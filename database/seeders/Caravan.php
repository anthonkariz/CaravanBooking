<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Caravan as CaravanModel;

class Caravan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        CaravanModel::factory(10)->create();
        CaravanModel::factory()->create([
            'user_id' => 11,
            'location' => 'London',
            'size' => 'large',
            'price' => 100,
        ]);
    }
}
