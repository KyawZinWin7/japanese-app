<?php

namespace Database\Seeders;

use App\Models\JlptLevel;
use App\Models\Source;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    public function run(): void
    {
        $definitions = [
            'n3' => ['Somatome', 'Shinkanzen Master'],
            'n2' => ['Somatome', 'Shinkanzen Master'],
            'n1' => ['Somatome', 'Shinkanzen Master'],
        ];

        foreach ($definitions as $levelSlug => $sources) {
            $levelId = JlptLevel::query()->where('slug', $levelSlug)->value('id');

            if (! $levelId) {
                continue;
            }

            foreach ($sources as $index => $name) {
                Source::updateOrCreate(
                    ['slug' => str($name.'-'.$levelSlug)->slug()],
                    [
                        'jlpt_level_id' => $levelId,
                        'name' => $name,
                        'content_type' => Source::CONTENT_TYPE_BOTH,
                        'sort_order' => $index + 1,
                        'is_active' => true,
                    ],
                );
            }
        }
    }
}
