<?php

namespace App\Support;

use App\Models\JlptLevel;
use App\Models\User;

class StudyAccess
{
    public static function allowedLevelIds(User $user): array
    {
        return JlptLevel::query()->pluck('id')->all();
    }

    public static function canAccessLevel(User $user, ?int $levelId): bool
    {
        if ($user->is_admin) {
            return true;
        }

        if ($levelId === null) {
            return false;
        }

        return in_array($levelId, self::allowedLevelIds($user), true);
    }
}
