<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainAttendee extends Model
{
    protected $fillable = ['title','amount','visibility','status'];

    public function subattendees()
    {
        return $this->hasMany(SubAttendees::class);
    }
}
