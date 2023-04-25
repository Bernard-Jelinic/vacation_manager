<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DepartmentSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(VacationStatusSeeder::class);
        $this->call(VacationSeeder::class);
    }
}
