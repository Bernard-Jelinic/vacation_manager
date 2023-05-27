<?php

namespace Database\Seeders;

use App\Models\VacationStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VacationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VacationStatus::create([
            'id' => 1,
            'name' => 'Pending'
        ]);
        VacationStatus::create([
            'id' => 2,
            'name' => 'Approved'
        ]);
        VacationStatus::create([
            'id' => 3,
            'name' => 'Deny'
        ]);
    }
}
