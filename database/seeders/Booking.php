<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking as BookingModel;

class Booking extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        BookingModel::factory(10)->create();
        BookingModel::factory()->create([
            'user_id' => 11,
            'caravan_id' => 1,
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'status' => 'approved',
            'price' => 100,
            'payment_method' => 'credit_card',
            'payment_status' => 'paid',
        ]);

    }
}
