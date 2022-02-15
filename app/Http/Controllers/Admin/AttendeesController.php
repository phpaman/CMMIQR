<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MainAttendee;
use App\SubAttendees;
use App\Bookings;
use App\SubAttendeeDetails;
use App\Events;
use App\Mail\BookingMail;
use QrCode;

class AttendeesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

   public function mainAttendees(){
      $attendees = MainAttendee::where('status','1')->get();
      return view('admin.attendees.main_attendees',compact('attendees'));
   }

   public function addMainAttendee(){
    return view('admin.attendees.add_main_attendees');
   }

   public function saveMainAttendee(Request $request){

    $this->validate($request, [
        'title'           => 'required|max:255',
    ]);

    MainAttendee::create([
      'title' => $request->title
  
    ]);

    return redirect('admin/main-attendees')->with('success','Attendee Saved Successfully!');

   }

   public function saveCategory(Request $request){
    $id = $request->id;
    $visibility = ($request->visibility ? $request->visibility : 'off');
    $attendee = MainAttendee::where('id',$id)->update(['amount' => $request->attendee_amount,'visibility' => $visibility]);
    
    $subattendees = $request->sub_attendee;
    $subattendeeamount = $request->amount;

    $if_exist = SubAttendees::where('main_attendee_id',$id)->delete();

    foreach($subattendees as $key => $subattendee){
    SubAttendees::create([
      'main_attendee_id' => $id,
      'title' => $subattendee,
      'amount' => $subattendeeamount[$key]
     ]);
     }

     return redirect('admin/main-attendees')->with('success',' Information Saved Successfully!');

   }

   public function categoryEditDetails (Request $request){
    $id = $request->id;
    
    $subattendees = SubAttendees::where(['main_attendee_id' => $id, 'status' => '1'])->get();

    return response()->json(['success' => true,'data' => $subattendees]);
   }

   public function newbookingData(Request $request){
   $id = $request->id;

   $categoryData = MainAttendee::with('subattendees')->where('id',$id)->first();
   $events = Events::where('status','1')->get();

   $html = '<div class="row"><div class="col-md-1"><div class="form-group"><input type="checkbox" disabled checked class="form-control" name="member_check" > </div> </div><div class="col-md-2"><div class="form-group"> <label for="exampleInputEmail1">'.$categoryData->title.'</label>  </div></div> <div class="col-md-2"><div class="form-group"><input type="text" class="form-control" required="required" name="membership_no" id="exampleInputEmail1" placeholder="Enter Membership No."></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control" required="required" name="member_name" id="exampleInputEmail1" placeholder="Enter Name"></div></div><div class="col-md-2"> <div class="form-group"><input type="text" class="form-control" required="required" name="email" id="exampleInputEmail1" placeholder="Enter Email"></div> </div><div class="col-md-2"><div class="form-group"> <input type="text" class="form-control" required="required" name="phone_no" id="exampleInputEmail1" placeholder="Enter Phone no."></div></div><div class="col-md-1"><div class="form-group"><label for="exampleInputEmail1">INR '.$categoryData->amount.'/head</label></div></div></div>';

   $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
      $uid = substr(str_shuffle($str_result), 
                       0,10);
       
       foreach($categoryData->subattendees as $subattendee){
              $html .= '<div class="row"  >
                    <div class="col-md-1">
                    <div class="form-group">
                     <input type="checkbox"  data-id="'.$subattendee->id.'" class="form-control checksubattendee" name="member_check" > 
                    </div>
                   </div>
                   <div class="col-md-2">
                    <div class="form-group">
                     <label for="exampleInputEmail1">'.$subattendee->title.'</label> 
                    </div>
                    </div>
                    <div class="col-md-2">
                     <div class="form-group">
                      <input type="text" class="form-control" required="required" disabled name="subattendee_name[]" id="input_id_'.$subattendee->id.'" placeholder="Enter Name">
                       <input type="hidden" name="subattendee_id[]" value="'.$subattendee->id.'">
                     </div>
                    </div>
                    <div class="col-md-2">
                     <div class="form-group">
                       <label for="exampleInputEmail1">INR <span id="sub_attenee_amount_txt_'.$subattendee->id.'">'.$subattendee->amount.'</span>/head</label>
                     </div>
                    </div>
                    <div class="col-md-2">
                     <div class="form-group">
                      <button type="button" data-id="'.$subattendee->id.'" data-title="'.$subattendee->title.'" data-amount="'.$subattendee->amount.'" class="btn btn-success subattandeeAddMore" id="'.$subattendee->id.'"  style="display: none;"  ><i class="fas fa-plus" ></i>Add more</button>
                     </div>
                    </div>
                    <div class="col-md-2">
                     <div class="form-group">
                     </div>
                    </div>
                    <div class="col-md-1">
                     <div class="form-group">
                     </div>
                    </div>
                  </div>
                 <div id="subattendeeRow_'.$subattendee->id.'" ></div>
                  ';

              }

   return response()->json(['success' => true,'data' => $categoryData,'html' => $html,'events' => $events,'uid' => $uid ]);
   }

   public function saveBooking(Request $request){
      $id = $request->main_attendee_id;

      $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $uid = 'QR'.substr(str_shuffle($str_result), 
                       0,6);

      $url = url('/user/uid/'.$uid);

      $image = QrCode::format('png')->size(200)->generate($url);
     
      $booking = new Bookings;
      $booking->membership_no = $request->membership_no;
      $booking->member_name = $request->member_name;
      $booking->events_id = $request->events_id;
      $booking->email = $request->email;
      $booking->phone_no = $request->phone_no;
      $booking->payment_method = $request->payment_method;
      $booking->amount_paid = $request->amount_paid;
      $booking->uid = $uid;
      $booking->transaction_source = $request->transaction_source;
      $booking->transactio_number = $request->transactio_number;
      $booking->remark = $request->remark;
      $booking->main_attendee_id = $request->main_attendee_id;
      $booking->participate_in_lucky_dip = ($request->lucky_dip ? 'on' : 'off');
      $booking->payment_status = 'success';
      $booking->save();

      $subattendees = $request->subattendee_id;
      $subattendee_name = $request->subattendee_name;

      $event = Events::where('id',$booking->events_id)->first();
   
      if(!empty($subattendee_name)){
      foreach($subattendee_name as $key => $attendee){
        SubAttendeeDetails::create(['bookings_id' => $booking->id,
       'name' => $attendee,
       'subattendee_id' => $subattendees[$key],
       'venue' => $event->venue,
       'date' => $event->date,
       'time' => $event->start_time
       ]);
      }
     }

     if($booking){
      
      //EMAIL//
    $details = [
    'title' => 'Booking Details',
    'name' => $booking->member_name,
    'uid' => $uid,
    'image' => $image
    ];

    \Mail::to($booking->email)->send(new BookingMail($details));

     }

     return redirect('admin/main-attendees')->with('success','Booking Successfully. Attendee Bppking Details are send on their Registered Email.'); 
   }

   public function Bookings(){
    $bookings = Bookings::with('subattendeesdetails','mainattendee','event')->orderBy('id','DESC')->get();
    return view('admin.bookings.view',compact('bookings'));
   }

   public function showBookingDetails(Request $request){
    $bookingdetail = Bookings::with('subattendeesdetails','event')->where('id',$request->id)->first();
    return response()->json(['success' => true, 'data' => $bookingdetail]);
   }

   public function bookingDetails(Request $request){
    $bookingdetail = Bookings::with('subattendeesdetails.subattendee','event')->where('id',$request->id)->first();
    return response()->json(['success' => true, 'data' => $bookingdetail]);
   }

   public function showEvents(){
    $events = Events::orderBy('date', 'Desc')->get();
    return view('admin.events.show',compact('events'));
   }

   public function saveEvents(Request $request){
     $title = $request->title;
     $venue = $request->venue;
     $date = $request->date;
     $start_time = $request->start_time;
     $instructions = $request->instructions;

     $event = new Events;
     $event->title = $title;
     $event->venue = $venue;
     $event->date = $date;
     $event->start_time = $start_time;
     $event->instructions = $instructions;
     $event->save();

     return redirect('/admin/events')->with('success','Event Saved Successfully!');

   }

   public function editEvents(Request $request){
    $id = $request->id;
    $event = Events::where('id',$id)->first();
    return response()->json(['success' => true,'data' => $event]);
   }

   public function updateEvents(Request $request){
    $id = $request->id;
    $title = $request->title;
     $venue = $request->venue;
     $date = $request->date;
     $start_time = $request->start_time;
     $instructions = $request->instructions;

     $event =  Events::find($id);
     $event->title = $title;
     $event->venue = $venue;
     $event->date = $date;
     $event->start_time = $start_time;
     $event->instructions = $instructions;
     $event->status = $request->status;
     $event->update();

     return redirect('/admin/events')->with('success','Event Updated Successfully!');
   }
   
   public function resendEmail($slug){
             $booking = Bookings::with('subattendeesdetails.subattendee','event')->where('id',$slug)->first();
       
             $date = date('d-M-y');

                 $user = ['txno' => $booking->transactio_number,'date' => $date,'payment_method' => $booking->payment_method,'email' => $booking->email,'uid' => $booking->uid,'booking_id' => $booking->id,'booking_date' => date('d-M-y', strtotime($booking->created_at)),'amount_paid' => $booking->amount_paid,'name' => $booking->member_name,'phone_no' => $booking->phone_no];
             
                $url = url('/user/uid/'.$booking->uid);
                $bookingdetails = ['name' => $booking->member_name,'uid' => $booking->uid,'event_title' => $booking->event->title,'event_vanue' => $booking->event->venue,'event_date' => $booking->event->date,'event_start_time' => $booking->event->start_time,'url' => $url,'email' => $booking->email,'membership_no' => $booking->membership_no];
                

                $receiptpdf = \PDF::loadView('frontend.pdf.receipt', compact('user'));
                $bookingpdf = \PDF::loadView('frontend.pdf.bookingdetails', compact('bookingdetails'));

                //  $image = QrCode::format('png')->size(200)->generate($url);
                
                //EMAIL//
                $details = [
                'title' => 'Booking Details',
                'name' => $booking->member_name,
                'uid' => $booking->uid,
                'to' => $booking->email,
                //  'image' => $image
                ];

             \Mail::send('mail.booking', $details, function($message)use($details, $receiptpdf, $bookingpdf) {

                        $message->to($details["to"], $details["to"])

                                ->subject($details["title"])

                                ->attachData($receiptpdf->output(), "receipt.pdf")

                                ->attachData($bookingpdf->output(), "booking.pdf");

                    });
                    
            return redirect()->back()->with('success','Email with booking details is Resend successfully!');   
       
   }
   
   public function downloadpdf($slug){
       $booking = Bookings::with('subattendeesdetails.subattendee','event')->where('id',$slug)->first();
       
             $date = date('d-M-y');
             if($booking){
                $url = url('/user/uid/'.$booking->uid);
                $bookingdetails = ['name' => $booking->member_name,'uid' => $booking->uid,'event_title' => $booking->event->title,'event_vanue' => $booking->event->venue,'event_date' => $booking->event->date,'event_start_time' => $booking->event->start_time,'url' => $url,'email' => $booking->email,'membership_no' => $booking->membership_no];
                
                $bookingpdf = \PDF::loadView('frontend.pdf.bookingdetails', compact('bookingdetails'));
                return $bookingpdf->download('booking_details.pdf');
             }
             return redirect()->back()->with('error','Something went wrong!');
   }

}
