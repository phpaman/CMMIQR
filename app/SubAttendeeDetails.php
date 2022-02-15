<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubAttendeeDetails extends Model
{
    protected $table = 'sub_attendee_detials';
    protected $fillable= ['bookings_id','name','subattendee_id','status'];

    public function subattendee(){
        return $this->hasOne(SubAttendees::class,'id','subattendee_id');
    }
}
