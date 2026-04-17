<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            JlptLevelSeeder::class,
            SourceSeeder::class,
            N5Chapter1Seeder::class,
        ]);

        User::updateOrCreate(
            ['email' => 'kyawzinwin.devops@gmail.com'],
            [
                'name' => 'Kyaw Zin Win',
                'password' => 'password',
                'is_admin' => true,
                'is_approved' => true,
            ],
        );
    }
}
