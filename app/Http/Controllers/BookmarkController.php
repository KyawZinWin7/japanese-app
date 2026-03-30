<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $lessons = $user->bookmarkedLessons()
            ->with('jlptLevel:id,name,slug')
            ->orderByPivot('created_at', 'desc')
            ->get()
            ->map(fn ($lesson) => [
                'id' => $lesson->id,
                'title' => $lesson->title,
                'excerpt' => $lesson->excerpt,
                'level' => [
                    'name' => $lesson->jlptLevel?->name,
                    'slug' => $lesson->jlptLevel?->slug,
                ],
                'showUrl' => route('lessons.show', $lesson),
                'bookmarkUrl' => route('lessons.bookmarks.toggle', $lesson),
            ])
            ->values()
            ->all();

        $vocabulary = $user->bookmarkedVocabulary()
            ->with('jlptLevel:id,name,slug')
            ->orderByPivot('created_at', 'desc')
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'word' => $item->word,
                'reading' => $item->reading,
                'meaning' => $item->meaning,
                'meaning_mm' => $item->meaning_mm,
                'level' => [
                    'name' => $item->jlptLevel?->name,
                    'slug' => $item->jlptLevel?->slug,
                ],
                'showUrl' => route('vocabulary.show', $item),
                'bookmarkUrl' => route('vocabulary.bookmarks.toggle', $item),
            ])
            ->values()
            ->all();

        $kanji = $user->bookmarkedKanji()
            ->with('jlptLevel:id,name,slug')
            ->orderByPivot('created_at', 'desc')
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'character' => $item->character,
                'onyomi' => $item->onyomi,
                'kunyomi' => $item->kunyomi,
                'meaning' => $item->meaning,
                'meaning_mm' => $item->meaning_mm,
                'level' => [
                    'name' => $item->jlptLevel?->name,
                    'slug' => $item->jlptLevel?->slug,
                ],
                'showUrl' => route('kanji.show', $item),
                'bookmarkUrl' => route('kanji.bookmarks.toggle', $item),
            ])
            ->values()
            ->all();

        return view('vue-page', [
            'title' => 'Bookmarks',
            'pageComponent' => 'bookmarks',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'items' => [
                    'lessons' => $lessons,
                    'vocabulary' => $vocabulary,
                    'kanji' => $kanji,
                ],
                'routes' => [
                    'dashboard' => route('dashboard'),
                    'lessons' => route('lessons.index'),
                    'vocabulary' => route('vocabulary.index'),
                    'kanji' => route('kanji.index'),
                ],
                'status' => session('status'),
            ],
        ]);
    }
}
