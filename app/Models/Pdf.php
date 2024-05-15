<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
    use HasFactory;
    protected $fillable = ['sole_proprietorship_id','path','what_for'];
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
