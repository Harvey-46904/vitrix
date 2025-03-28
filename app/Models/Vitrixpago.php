<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Vitrixpago extends Model
{
    protected $fillable = ["hash","successpay","errorpay","feed_moment","pay_moment"];
}
