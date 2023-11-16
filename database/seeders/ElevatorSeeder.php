<?php

namespace Database\Seeders;

use App\Models\Elevator;
use Illuminate\Database\Seeder;

class ElevatorSeeder extends Seeder
{
    public function run()
    {
        Elevator::factory()->createMany(3);
    }
}
