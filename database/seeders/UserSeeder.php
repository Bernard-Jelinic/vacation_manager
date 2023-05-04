<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles_arr = ['manager', 'employee'];

        User::factory()->create([
            'role' => 'admin',
            'department_id' => null
        ]);

        $departments = Department::all();

        foreach ($roles_arr as $role) {
            foreach ($departments as $department) {
                $array = ['role' => $role, 'department_id' => $department->id];
                if ($role == 'manager') {
                    $response = User::where('role', 'admin')->first();
                    $array['parent_id'] = $response->id;
                } else {
                    $response = User::where('department_id', $department->id)->first();
                    $array['parent_id'] = $response->id;
                }
                User::factory()->create( $array );
            }
        };
    }
}
