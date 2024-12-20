<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\orders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */
        // $this->call(UsersTableSeeder::class);
        \App\Models\User::all()->each(function ($user) {
            \App\Models\orders::factory(random_int(1, 10))->create([
                'user_id' => $user->id,
            ]);
        });        
        
    }
}
