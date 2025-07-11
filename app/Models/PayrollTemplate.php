<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollTemplate extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['school_id' , 'name','status','created_by'];

  public function user()
  {
        return $this->belongsTo(User::class,'created_by');
   }

   public function payrollitems()
    {
        return $this->hasMany(TemplateItem::class, 'template_id', 'id');
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class, 'template_id', 'id');
    }

}
