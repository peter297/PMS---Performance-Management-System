<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function Symfony\Component\Clock\now;

class DevelopmentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $admin = User::create([
            "name"=> "Admin User",
            "email"=> "admin@pms.test",
            "password"=> Hash::make('password'),
            "role" => "admin",
            "is_active" => true,
        ]);


        $coordinator1 = User::create([
            "name"=> "John Coordinator",
            "email"=> "coordinator1@oms.test",
            "password"=> Hash::make("password"),
            "role" => "coordinator",
            "is_active"=> true,
        ]);

        $coordinator2 = User::create([
             "name"=> "Mohamed Coordinator",
            "email"=> "coordinator2@oms.test",
            "password"=> Hash::make("password"),
            "role" => "coordinator",
            "is_active"=> true,
        ]);


        $teacher1 = User::create([
            "name" => 'Alice Teacher',
            "email" => "teacher1@pms.test",
            'password' => Hash::make('password'),
            "role" => "teacher",
            "is_active" => true,
        ]);

         $teacher2 = User::create([
            "name" => 'Abdi Teacher',
            "email" => "teacher2@pms.test",
            'password' => Hash::make('password'),
            "role" => "teacher",
            "is_active" => true,
         ]);

          $teacher3 = User::create([
            "name" => 'Bob Teacher',
            "email" => "teacher3@pms.test",
            'password' => Hash::make('password'),
            "role" => "teacher",
            "is_active" => true,
         ]);



         $teacher1->coordinators()->attach($coordinator1->id, [
            'assigned_date' => now(),
            'is_active' => true,
         ]);

         $teacher2->coordinators()->attach($coordinator1->id, [
            'assigned_date' => now(),
            'is_active' => true,
         ]);

         $teacher3->coordinators()->attach($coordinator2->id, [
            'assigned_date' => now(),
            'is_active' => true,
         ]);
    }
}
