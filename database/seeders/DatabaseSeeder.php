<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $admin = User::query()->create([
            'name' => "Admin",
            'email' => "admin@admin.com",
            'email_verified_at' => now(),
            'password' => Hash::make('secret123'),
            'remember_token' => Str::random(60),
        ]);

        $categoriesList = ['Music', 'Food Festival', 'Organisation', 'School'];

        foreach ($categoriesList as $category) {
            $categories = Category::query()->create([
                'name' => $category,
                'is_active' => true
            ]);
        }
    }
}
