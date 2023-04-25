<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vacation;
use App\Models\VacationStatus;
use Illuminate\Database\Seeder;

class VacationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all()->where('role', '!=', 'admin');
        $statuses = VacationStatus::all();

        foreach ($users as $user) {
            foreach($statuses as $status){
                Vacation::factory()->count(1)->create([
                    'status_id' => $status->id,
                    'user_id' => $user->id
                ]);
            }
        }
    }
}
