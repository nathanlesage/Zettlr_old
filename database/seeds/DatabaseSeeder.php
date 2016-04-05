<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserTableSeeder::class);
        
        // Create an admin account to login
        // easily without having to harass with always
        // having to manually register
        DB::table('users')->insert([
        'name' => "admin",
        'email' => 'test@example.com',
        'password' => bcrypt('admin')]);
    }
}
