<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoleProprietorship extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone_no',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function pdfs()
    {
        return $this->hasMany(Pdf::class);
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_sole_proprietorship');
    }
}
