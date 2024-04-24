<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['ntn_id','path'];

    public function ntn()
    {
        return $this->belongsTo(NTN::class);
    }

}
