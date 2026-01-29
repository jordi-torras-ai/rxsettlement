<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\GlossarySeeder;
use Database\Seeders\DocumentTypeSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User']
        );

        $this->call(GlossarySeeder::class);
        $this->call(DocumentTypeSeeder::class);
    }
}
