<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable=['user_id','ntn_id','sole_proprietorship_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ntn()
    {
        return $this->hasOne(NTN::class);
    }
    public function sole_proprietorships()
    {
        return $this->belongsToMany(SoleProprietorship::class,'cart_sole_proprietorship');
    }

    public function aops()
    {
        return $this->belongsToMany(Aop::class, 'cart_aop');
    }
}
