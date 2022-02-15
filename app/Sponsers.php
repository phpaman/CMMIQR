<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsers extends Model
{
    protected $fillable = ['type_of_sponser','souvier_ads_coloured','digital_banner','coupons','amount','remarks','status'];
}
