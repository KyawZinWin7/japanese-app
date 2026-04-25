<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudyHistoryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'entryKey' => ['required', 'string', 'max:255'],
            'href' => ['required', 'string', 'max:65535'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'progressLabel' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'array'],
            'resume' => ['nullable', 'boolean'],
        ]);

        $history = $request->user()->studyHistoryEntries()->updateOrCreate(
            ['entry_key' => $validated['entryKey']],
            [
                'href' => $validated['href'],
                'title' => $validated['title'],
                'subtitle' => $validated['subtitle'] ?? null,
                'progress_label' => $validated['progressLabel'] ?? null,
                'state' => $validated['state'] ?? null,
                'is_resume' => (bool) ($validated['resume'] ?? false),
                'last_accessed_at' => now(),
            ]
        );

        return response()->json([
            'ok' => true,
            'id' => $history->id,
        ]);
    }
}
