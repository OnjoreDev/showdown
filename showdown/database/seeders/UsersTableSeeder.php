<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $timezones = ['CET','CST','GMT+1'];

        for($i = 0; $i<20; $i++){
            DB::table('users')->insert([
               //generate random name and email
                'name'=> Str::random(10),
                'email'=> Str::random(10).'gmail.com',
                'password'=> bcrypt('password'),//Use a hashed password
                'timezone' => $timezones[array_rand($timezones)], //Randomly select a timezone
                'created_at'=> now(),
                'updated_at'=>now(),
            ]);
        }
    }
}
