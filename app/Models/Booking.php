<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public $fillable = [
        'start_date',
        'end_date',
        'caravan_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function caravan()
    {
        return $this->belongsTo(Caravan::class);
    }

    protected static function booted()
    {
        static::creating(function ($booking) {
            $booking->user_id = 10; // auth()->id();
        });
        static::updating(function ($booking) {
            $booking->user_id = 10; // auth()->id();
        });
        static::deleting(function ($booking) {
            $booking->images()->delete();
            $booking->bookings()->delete();
        });
    }

    public function scopeFilter($query, $request)
    {
        $from = $request->from;
        $to = $request->to;

        $query->leftJoin('caravans', 'bookings.caravan_id', '=', 'caravans.id')
            ->select(
                'caravans.location',
                'caravans.size',
                'caravans.price as price',
                'bookings.start_date as From',
                'bookings.end_date as To',
                'Bookings.caravan_id as caravan_id'
            )
            ->whereBetween('bookings.start_date', [$from, $to])
         ->where('caravans.location', 'like', '%' . $request->location . '%');
    }

    public function scopeAlternative($query, $request)
    {
        $from = $request->from;
        $to = $request->to;

        $query->leftJoin('caravans', 'bookings.caravan_id', '=', 'caravans.id')
            ->select(
                'caravans.location',
                'caravans.size',
                'caravans.price as price',
                'bookings.start_date as From',
                'bookings.end_date as To',
                'Bookings.caravan_id as caravan_id'
            )
            ->whereNotBetween('bookings.start_date', [$from, $to])
            ->where('caravans.location', 'like', '%' . $request->location . '%');
    }

}
