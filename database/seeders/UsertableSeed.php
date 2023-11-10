<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UsertableSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // for admin //
            [
                'name' => 'admin',
                'username' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('1234'),
                'role' => 'admin',
                'status' => 'active',
        
            ],

            // for agent //
            [
                'name' => 'agent',
                'username' => 'Agent',
                'email' => 'agent@gmail.com',
                'password' => Hash::make('1234'),
                'role' => 'agent',
                'status' => 'active',
        
            ],
            // for user //
            [
                'name' => 'user',
                'username' => 'User',
                'email' => 'user@gmail.com',
                'password' => Hash::make('1234'),
                'role' => 'user',
                'status' => 'active',
        
            ]
        ]);
        


        
    }
}
