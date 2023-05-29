<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
                foreach ( $user->ancestors as $ancestor ) {
                    if ($ancestor->role == 'admin') {
                        $text = 'Employee ' . $user->name . ' from department ' . $user->department->name .  ' send request for vacation';
                    } else{
                        $text = 'Employee ' . $user->name . ' send request for vacation';
                    }

                    $vacation = Vacation::latest('id')->first();

                    $randomNumber = rand(1, 100);
                    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $randomString = substr(str_shuffle($characters), 0, 3); // Generates a random string of length 10

                    $randomWordWithNumber = $randomString . $randomNumber;

                    \DB::table('notifications')->insert(
                        [
                            'id' => $randomWordWithNumber,
                            'type' => 'App\Notifications\VacationNotification',
                            'notifiable_type' => 'App\Models\User',
                            'notifiable_id' => $ancestor->id,
                            'data' => '{"data":"' . $text . '","vacation_id":' . $vacation->id . '}',
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]
                    );
                }
            }
        }
    }
}
