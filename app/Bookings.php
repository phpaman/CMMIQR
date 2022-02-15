<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    
    public function subattendeesdetails()
    {
        return $this->hasMany(SubAttendeeDetails::class);
    }

    public function event(){
        return $this->hasOne(Events::class,'id','events_id');
    }
   
   public function mainattendee(){
        return $this->hasOne(MainAttendee::class,'id','main_attendee_id');
    }

}
