<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bookings;
use App\SubAttendeeDetails;
use App\MainAttendee;
use App\User;
use App\Events;

class DashboardController extends Controller
{
     public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
    $bookings = Bookings::count();
        $categories = MainAttendee::where('status','1')->count();
        $events = Events::where('status','1')->count();
        $amount = Bookings::sum('amount_paid');
        return view('admin/dashboard',compact('bookings','categories','events','amount'));
    }

    


}
