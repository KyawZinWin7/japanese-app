<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use App\Models\JlptLevel;
use Illuminate\Http\Request;

class StudyHomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return view('vue-page', [
            'title' => 'Study Home',
            'pageComponent' => 'study-home',
            'pageProps' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'levels' => JlptLevel::query()
                    ->orderBy('sort_order')
                    ->get(['id', 'name', 'slug'])
                    ->map(fn ($level) => [
                        'id' => $level->id,
                        'name' => $level->name,
                        'slug' => $level->slug,
                    ])
                    ->values()
                    ->all(),
                'routes' => [
                    'levels' => route('levels.index'),
                    'lessons' => route('lessons.index'),
                    'vocabulary' => route('vocabulary.index'),
                    'kanji' => route('kanji.index'),
                    'flashcards' => route('flashcards.index'),
                    'quizzes' => route('kanji-quizzes.index'),
                    'bookmarks' => route('bookmarks.index'),
                    'logout' => route('logout'),
                ],
                'csrfToken' => csrf_token(),
            ],
        ]);
    }
}
