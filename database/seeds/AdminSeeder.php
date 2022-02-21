<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $domain = 'namsexpress.com';
        $pass = Hash::make('password');

        DB::table('admins')->insert([
            'name' => 'admin',
            'email' => 'admin@'.$domain,
            'password' => $pass,
        ]);

        DB::table('branches')->insert(['name' => 'Dhaka', 'address' => 'Mirpur, Dhaka, Bangladesh', 'status' => 'Active']);
        DB::table('branches')->insert(['name' => 'Khulna', 'address' => 'Sonatala, Khulna, Bangladesh', 'status' => 'Active']);
        DB::table('users')->insert(['name' => 'manager', 'email' => 'manager@'.$domain, 'password' => $pass, 'type' => 'Manager', 'status' => 'Active', 'branch_id' => 1]);
        DB::table('users')->insert(['name' => 'staff', 'email' => 'staff@'.$domain, 'password' => $pass, 'type' => 'Staff', 'status' => 'Active', 'branch_id' => 1]);
    }
}
