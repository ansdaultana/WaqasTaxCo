<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['ntn_id','sole_proprietorship_id','path','what_for','name'];

    public function ntn()
    {
        return $this->belongsTo(NTN::class);
    }
    public function soleproprietorship()
    {
        return $this->belongsTo(SoleProprietorship::class);
    }
    public function getUrl()
    {
        $path = $this->path;

        $url = url('storage/' . $path);
        return $url;
    }
}
