<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bookings;
use App\SubAttendeeDetails;
use App\Events;
use App\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index(){
        $bookings = Bookings::where('payment_status','success')->count();
        $events = Events::where('status','1')->count();
        // return $amount;
        return view('user.dashboard',compact('bookings','events'));
    }

    public function userDetails(Request $request){
        $uid = $request->uid;

        $userDetails = Bookings::with('subattendeesdetails.subattendee','event','mainattendee')->where('uid',$uid)->where('payment_status','success')->first();
        
        if(!empty($userDetails)){
        return response()->json(['success' => true, 'data' => $userDetails]);
        }else{
        return response()->json(['success' => false, 'data' => 'Please enter a valid uid no.']);
        }
    }

    public function updateAttendeeDetails(Request $request){

    $uid = $request->uid;
    $booking = Bookings::where('uid',$uid)->first();

     

    if($request->type == 'entry'){
       Bookings::where('uid',$uid)->update(['entry_status' => '0']);
         SubAttendeeDetails::where('bookings_id',$booking->id)->update(['entry_status' => '0']);
        if(isset($request->main_attendee)){
       if($request->main_attendee[0] == 'on'){ 
        Bookings::where('uid',$uid)->update(['entry_status' => '1']);
       }
        }

        if(isset($request->sub_attendee_id)){
            foreach($request->sub_attendee_id as $key => $sub_attendee){
                if($sub_attendee != NULL){
              SubAttendeeDetails::where('id',$sub_attendee)->update(['entry_status' => '1']);      
                }
            }
        }

        return redirect('/user/dashboard')->with('success','Entry Details for Attendee of UID : '.$uid.' is Updated Successfully! Attendee Entry Details are send to their Registered Email.');
    }else{
        Bookings::where('uid',$uid)->update(['dinner_status' => '0']);
        SubAttendeeDetails::where('bookings_id',$booking->id)->update(['dinner_status' => '0']);  
         if(isset($request->main_attendee)){
       if($request->main_attendee[0] == 'on'){     
       Bookings::where('uid',$uid)->update(['dinner_status' => '1']);
       }
        }

        if(isset($request->sub_attendee_id)){
            foreach($request->sub_attendee_id as $key => $sub_attendee){
                if($sub_attendee != NULL){
              SubAttendeeDetails::where('id',$sub_attendee)->update(['dinner_status' => '1']);      
                }
            }
        }

        return redirect('/user/dashboard')->with('success','Dinner Details for Attendee of UID : '.$uid.' is Updated Successfully! Attendee Dinner Details are send to their Registered Email.');
    }



    }


}
