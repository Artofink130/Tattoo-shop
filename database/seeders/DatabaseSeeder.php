<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /** User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);**/

         User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'artofink130@gmail.com')],
            ['name' => 'Admin', 'password' => env('ADMIN_PASSWORD', '1@Mur!!th!'), 'is_admin' => true],
        );

        
    }
}
