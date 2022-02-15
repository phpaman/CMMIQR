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
use App\Sponsers;

class SponserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index(){
        $sponsers = Sponsers::get();
        $events = Events::where('status','1')->get();
        return view('admin.sponser.index',compact('sponsers','events'));
    }
    
    public function save(Request $request){
        $typeOfSponsers = $request->type_of_sponser;
        $souvier_ads_coloured = $request->souvier_ads_coloured;
        $digital_banner = $request->digital_banner;
        $coupons = $request->coupons;
        $amount = $request->amount;
        $remarks = $request->remarks;
        
        foreach($typeOfSponsers as $key => $sponser){
            $dataArray = array(
            'type_of_sponser' => $sponser,
            'souvier_ads_coloured' => $souvier_ads_coloured[$key],
            'digital_banner' => $digital_banner[$key],
            'coupons' => $coupons[$key],
            'amount' => $amount[$key],
            'remarks' => $remarks[$key]
            );
            Sponsers::create($dataArray);
        }
        
        return redirect()->back()->with('success','Sponser saved Successfully.');
    }
    
    public function booking(Request $request){
        
    $mainattendee =  MainAttendee::where('title','Sponsor')->first();
        
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $uid = 'QR'.substr(str_shuffle($str_result), 
                       0,6);

      $url = url('/user/uid/'.$uid);

      $image = QrCode::format('png')->size(200)->generate($url);
     
      $booking = new Bookings;
      $booking->member_name = $request->main_sponser;
      $booking->events_id = $request->event_id;
      $booking->email = $request->email;
      $booking->phone_no = $request->phone;
      $booking->amount_paid = $request->amount;
      $booking->uid = $uid;
      $booking->transaction_source = $request->transaction_source;
      $booking->transactio_number = $request->transactio_number;
      $booking->remark = $request->remark;
      $booking->main_attendee_id = $mainattendee->id;
      $booking->participate_in_lucky_dip = ($request->lucky_dip ? 'on' : 'off');
      $booking->payment_status = 'success';
      $booking->save();

      $subattendee_name = $request->sub_attendee_name;

      $event = Events::where('id',$booking->events_id)->first();
   
      if(!empty($subattendee_name)){
      foreach($subattendee_name as $key => $attendee){
        SubAttendeeDetails::create(['bookings_id' => $booking->id,
       'name' => $attendee,
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
     return redirect('admin/show/sponsers')->with('success','Booking Successfully. Attendee Booking Details are send on their Registered Email.');  
    }
    
}