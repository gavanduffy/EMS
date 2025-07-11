<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Common;

class BackgroundImage extends Model
{
	use Common;
    use SoftDeletes;

     public function getAttachmentPathAttribute()
    {
        return $this->getFilePath($this->background_image);
    }
}
