<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Common;
class PostalRecord extends Model
{
	use Common;
	
    protected $table = 'postal_record';

     protected $fillable = [
       'school_id','academic_year_id','type','reference_number','confidential','sender_title','sender_address','receiver_title','receiver_address','postal_date','description','entry_by'
    ];

     public function getAttachmentPathAttribute()
    {
        return $this->getFilePath($this->attachment);
    }

   
  
}
