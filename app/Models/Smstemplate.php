<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Smstemplate extends Model
{
    //
     protected $table    = 'sms_templates';
     protected $fillable = ['name','content','status'];
}