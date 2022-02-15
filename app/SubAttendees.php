<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubAttendees extends Model
{
 protected $fillable = ['main_attendee_id','title','amount','status'];
}

