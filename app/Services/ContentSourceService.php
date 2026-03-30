<?php

namespace App\Services;

use App\Models\JlptLevel;
use App\Models\Source;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ContentSourceService
{
    public static function ensureDefaults(): void
    {
        $definitions = [
            'n3' => ['Somatome', 'Shinkanzen'],
            'n2' => ['Somatome', 'Shinkanzen'],
            'n1' => ['Somatome', 'Shinkanzen'],
        ];

        foreach ($definitions as $levelSlug => $names) {
            $levelId = JlptLevel::query()->where('slug', $levelSlug)->value('id');

            if (! $levelId) {
                continue;
            }

            foreach ($names as $index => $name) {
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

    public static function queryForType(string $contentType): Builder
    {
        self::ensureDefaults();

        return Source::query()
            ->where('is_active', true)
            ->whereIn('content_type', [$contentType, Source::CONTENT_TYPE_BOTH]);
    }

    public static function optionsForType(string $contentType, ?array $levelIds = null): array
    {
        $query = self::queryForType($contentType)
            ->with('jlptLevel:id,name,slug')
            ->orderBy('sort_order')
            ->orderBy('name');

        if ($levelIds !== null) {
            $query->whereIn('jlpt_level_id', $levelIds);
        }

        return $query->get()->map(fn (Source $source) => [
            'id' => $source->id,
            'name' => $source->name,
            'slug' => $source->slug,
            'content_type' => $source->content_type,
            'jlpt_level_id' => $source->jlpt_level_id,
            'level' => [
                'name' => $source->jlptLevel?->name,
                'slug' => $source->jlptLevel?->slug,
            ],
        ])->values()->all();
    }

    public static function shouldRequireForLevel(?int $levelId, string $contentType): bool
    {
        if ($levelId === null) {
            return false;
        }

        return self::queryForType($contentType)
            ->where('jlpt_level_id', $levelId)
            ->count() > 1;
    }

    public static function sourceMatchesLevelAndType(?int $sourceId, ?int $levelId, string $contentType): bool
    {
        if ($sourceId === null || $levelId === null) {
            return false;
        }

        return self::queryForType($contentType)
            ->whereKey($sourceId)
            ->where('jlpt_level_id', $levelId)
            ->exists();
    }

    public static function sourceSlugOptionsForType(string $contentType, array $levelIds): Collection
    {
        return self::queryForType($contentType)
            ->whereIn('jlpt_level_id', $levelIds)
            ->get(['id', 'slug']);
    }
}
