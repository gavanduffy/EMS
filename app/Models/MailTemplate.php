<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    //
     protected $table='mailtemplates';
     protected $fillable=['name','subject','mail_content','status'];
}
