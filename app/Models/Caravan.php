<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caravan extends Model
{
    use HasFactory;
    public $fillable = [
        'size',
            'location',
            'price',
            'user_id',
     ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function images()
    {
        return $this->morphMany(Images::class, 'imageable');
    }

    protected static function booted()
    {
        static::creating(function ($caravan) {
            $caravan->user_id = 10; // auth()->id();
        });
        static::updating(function ($caravan) {
            $caravan->user_id = 10; // auth()->id();
        });
        static::deleting(function ($caravan) {
            $caravan->images()->delete();
            $caravan->bookings()->delete();
        });
    }





}
