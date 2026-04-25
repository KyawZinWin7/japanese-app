<?php

namespace App\Support;

use Illuminate\Http\Request;

class StudyHistoryKey
{
    public static function fromPath(Request $request, string $prefix, bool $withQuery = true): string
    {
        $suffix = $withQuery
            ? $request->getRequestUri()
            : '/'.$request->path();

        return $prefix.':'.$suffix;
    }

    public static function quiz(string $detailUrl): string
    {
        return 'quiz:'.$detailUrl;
    }
}
