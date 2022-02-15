<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events;
use App\Bookings;
use App\MainAttendee;

class UserController extends Controller
{
     public function __construct()
    {
        $this->middleware('user');
    }

    public function index($id){
        
        $bookings = Bookings::where('payment_status','success')->count();
        $events = Events::where('status','1')->count();

        return view('user.dashboard',compact('id','bookings','events'));

    }
    
     public function bookings(Request $request){
    $type = $request->type;
    $events_id = $request->events;
    $entry_status = $request->entry_status;
    $dinner_status = $request->dinner_status;

    $bookings = Bookings::with('subattendeesdetails','mainattendee','event')->where('payment_status','success')->orderBy('id','DESC');
    
    if ($type) {
        $bookings = $bookings->where('main_attendee_id',$type);
    }

    if ($events_id) {
        $bookings = $bookings->where('events_id',$events_id);
    }

    if ($entry_status) {
        $bookings = $bookings->where('entry_status',$entry_status);
    }

    if ($dinner_status) {
        $bookings = $bookings->where('dinner_status',$dinner_status);
    }

    $bookings = $bookings->get();
  
    $main_attendees = MainAttendee::get();
    $events = Events::get();
     return view('user.booking.show',compact('bookings','main_attendees','events','type','events_id','entry_status','dinner_status'));
    }

    public function bookingDetails(Request $request){
        $bookingdetail = Bookings::with('subattendeesdetails.subattendee','event')->where('id',$request->id)->first();
    return response()->json(['success' => true, 'data' => $bookingdetail]);
    }


}
