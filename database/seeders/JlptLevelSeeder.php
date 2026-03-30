<?php

namespace Database\Seeders;

use App\Models\JlptLevel;
use Illuminate\Database\Seeder;

class JlptLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['name' => 'N5', 'slug' => 'n5', 'sort_order' => 5, 'description' => 'Beginner level for foundational vocabulary, kana, and grammar.'],
            ['name' => 'N4', 'slug' => 'n4', 'sort_order' => 4, 'description' => 'Elementary level with broader grammar and reading practice.'],
            ['name' => 'N3', 'slug' => 'n3', 'sort_order' => 3, 'description' => 'Intermediate bridge level with longer texts and richer expressions.'],
            ['name' => 'N2', 'slug' => 'n2', 'sort_order' => 2, 'description' => 'Upper-intermediate level focused on nuance, comprehension, and fluency.'],
            ['name' => 'N1', 'slug' => 'n1', 'sort_order' => 1, 'description' => 'Advanced level with complex reading, listening, and abstract usage.'],
        ];

        foreach ($levels as $level) {
            JlptLevel::updateOrCreate(
                ['name' => $level['name']],
                $level,
            );
        }
    }
}
