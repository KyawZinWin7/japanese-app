<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudyHomeController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('vue-page', [
            'title' => 'Study Home',
            'pageComponent' => 'study-home',
            'pageProps' => [
                'routes' => [
                    'lessons' => route('lessons.index'),
                    'vocabulary' => route('vocabulary.index'),
                    'kanji' => route('kanji.index'),
                    'flashcards' => route('flashcards.index'),
                    'quizzes' => route('kanji-quizzes.index'),
                ],
            ],
        ]);
    }
}
