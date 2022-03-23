<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@teste.com',
            'password' => Hash::make('password')
        ]);
        
        // User::create([
        //     'name' => 'guest',
        //     'email' => 'guest@teste.com',
        //     'password' => Hash::make('password')
        // ]);
        
        // User::create([
        //     'name' => 'teste',
        //     'email' => 'teste@teste.com',
        //     'password' => Hash::make('password')
        // ]);

        // User::factory(300)->create();
    }
}
