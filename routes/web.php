<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\PendingApprovalController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExampleWordFlashcardController;
use App\Http\Controllers\JlptLevelController;
use App\Http\Controllers\KanjiController;
use App\Http\Controllers\KanjiQuizController;
use App\Http\Controllers\Learner\StudyHomeController;
use App\Http\Controllers\Learner\FlashcardLauncherController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\VocabularyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $accountHome = auth()->check()
        ? (auth()->user()->is_admin
            ? route('admin.dashboard')
            : (auth()->user()->is_approved ? route('study.home') : route('approval.pending')))
        : route('login');

    return view('vue-page', [
        'title' => 'KMM JAPANESE',
        'pageComponent' => 'home',
        'pageProps' => [
            'viewer' => [
                'isAuthenticated' => auth()->check(),
                'isAdmin' => auth()->user()?->is_admin ?? false,
                'isApproved' => auth()->user()?->is_approved ?? false,
            ],
            'routes' => [
                'accountHome' => $accountHome,
                'study' => auth()->check() ? route('study.home') : route('login'),
                'levels' => auth()->check() ? route('levels.index') : route('login'),
                'lessons' => auth()->check() ? route('lessons.index') : route('login'),
                'vocabulary' => auth()->check() ? route('vocabulary.index') : route('login'),
                'kanji' => auth()->check() ? route('kanji.index') : route('login'),
                'flashcards' => auth()->check() ? route('flashcards.index') : route('login'),
                'quizzes' => auth()->check() ? route('kanji-quizzes.index') : route('login'),
                'login' => route('login'),
                'register' => route('register'),
                'pending' => auth()->check() ? route('approval.pending') : route('login'),
            ],
        ],
    ]);
})->name('home');

Route::post('/locale', [LocaleController::class, 'update'])->name('locale.update');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/pending-approval', PendingApprovalController::class)->name('approval.pending');

    Route::middleware('approved')->group(function () {
        Route::get('/study', StudyHomeController::class)->name('study.home');
        Route::get('/flashcards', FlashcardLauncherController::class)->name('flashcards.index');
        Route::get('/levels', [JlptLevelController::class, 'index'])->name('levels.index');
        Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index');
        Route::get('/lessons/{lesson:slug}', [LessonController::class, 'show'])->name('lessons.show');
        Route::get('/vocabulary', [VocabularyController::class, 'index'])->name('vocabulary.index');
        Route::get('/vocabulary/{vocabulary:slug}', [VocabularyController::class, 'show'])->name('vocabulary.show');
        Route::get('/kanji', [KanjiController::class, 'index'])->name('kanji.index');
        Route::get('/kanji/study-page', [KanjiController::class, 'launch'])->name('kanji.launch');
        Route::get('/kanji/{kanji:slug}', [KanjiController::class, 'show'])->name('kanji.show');
        Route::get('/kanji-flashcards', [KanjiController::class, 'flashcards'])->name('kanji-flashcards.index');
        Route::get('/kanji-word-flashcards', [ExampleWordFlashcardController::class, 'index'])->name('example-word-flashcards.index');
        Route::get('/vocabulary-flashcards', [VocabularyController::class, 'flashcards'])->name('vocabulary-flashcards.index');
        Route::get('/kanji-quizzes', [KanjiQuizController::class, 'index'])->name('kanji-quizzes.index');
        Route::get('/kanji-quizzes/{quiz:slug}', [KanjiQuizController::class, 'show'])->name('kanji-quizzes.show');
        Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');

        Route::post('/lessons/{lesson:slug}/complete', [LessonController::class, 'toggleCompletion'])->name('lessons.complete.toggle');
        Route::post('/lessons/{lesson:slug}/bookmark', [LessonController::class, 'toggleBookmark'])->name('lessons.bookmarks.toggle');
        Route::post('/kanji/{kanji:slug}/bookmark', [KanjiController::class, 'toggleBookmark'])->name('kanji.bookmarks.toggle');
        Route::post('/vocabulary/{vocabulary}/bookmark', [VocabularyController::class, 'toggleBookmark'])->name('vocabulary.bookmarks.toggle');
        Route::get('/kanji-quizzes/{quiz:slug}/take', [KanjiQuizController::class, 'take'])->name('kanji-quizzes.take');
        Route::post('/kanji-quizzes/{quiz:slug}/submit', [KanjiQuizController::class, 'submit'])->name('kanji-quizzes.submit');
        Route::get('/kanji-quizzes/{quiz:slug}/results/{attempt}', [KanjiQuizController::class, 'result'])->name('kanji-quizzes.results.show');
    });

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/', \App\Http\Controllers\Admin\AdminDashboardController::class)->name('dashboard');
        Route::get('/approvals', [\App\Http\Controllers\Admin\UserApprovalController::class, 'index'])->name('approvals.index');
        Route::post('/approvals/{user}/approve', [\App\Http\Controllers\Admin\UserApprovalController::class, 'approve'])->name('approvals.approve');
        Route::post('/approvals/{user}/reject', [\App\Http\Controllers\Admin\UserApprovalController::class, 'reject'])->name('approvals.reject');
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/levels', [\App\Http\Controllers\Admin\JlptLevelController::class, 'index'])->name('levels.index');
        Route::get('/levels/create', [\App\Http\Controllers\Admin\JlptLevelController::class, 'create'])->name('levels.create');
        Route::post('/levels', [\App\Http\Controllers\Admin\JlptLevelController::class, 'store'])->name('levels.store');
        Route::get('/levels/{level}/edit', [\App\Http\Controllers\Admin\JlptLevelController::class, 'edit'])->name('levels.edit');
        Route::put('/levels/{level}', [\App\Http\Controllers\Admin\JlptLevelController::class, 'update'])->name('levels.update');
        Route::delete('/levels/{level}', [\App\Http\Controllers\Admin\JlptLevelController::class, 'destroy'])->name('levels.destroy');
        Route::get('/sources', [\App\Http\Controllers\AdminSourceController::class, 'index'])->name('sources.index');
        Route::get('/sources/create', [\App\Http\Controllers\AdminSourceController::class, 'create'])->name('sources.create');
        Route::post('/sources', [\App\Http\Controllers\AdminSourceController::class, 'store'])->name('sources.store');
        Route::get('/sources/{source}/edit', [\App\Http\Controllers\AdminSourceController::class, 'edit'])->name('sources.edit');
        Route::put('/sources/{source}', [\App\Http\Controllers\AdminSourceController::class, 'update'])->name('sources.update');
        Route::delete('/sources/{source}', [\App\Http\Controllers\AdminSourceController::class, 'destroy'])->name('sources.destroy');
        Route::get('/lessons', [\App\Http\Controllers\Admin\LessonController::class, 'index'])->name('lessons.index');
        Route::get('/lessons/create', [\App\Http\Controllers\Admin\LessonController::class, 'create'])->name('lessons.create');
        Route::post('/lessons', [\App\Http\Controllers\Admin\LessonController::class, 'store'])->name('lessons.store');
        Route::get('/lessons/{lesson}/edit', [\App\Http\Controllers\Admin\LessonController::class, 'edit'])->name('lessons.edit');
        Route::put('/lessons/{lesson}', [\App\Http\Controllers\Admin\LessonController::class, 'update'])->name('lessons.update');
        Route::delete('/lessons/{lesson}', [\App\Http\Controllers\Admin\LessonController::class, 'destroy'])->name('lessons.destroy');
        Route::get('/vocabulary', [\App\Http\Controllers\Admin\VocabularyController::class, 'index'])->name('vocabulary.index');
        Route::get('/vocabulary/create', [\App\Http\Controllers\Admin\VocabularyController::class, 'create'])->name('vocabulary.create');
        Route::post('/vocabulary', [\App\Http\Controllers\Admin\VocabularyController::class, 'store'])->name('vocabulary.store');
        Route::get('/vocabulary/{vocabulary}/edit', [\App\Http\Controllers\Admin\VocabularyController::class, 'edit'])->name('vocabulary.edit');
        Route::put('/vocabulary/{vocabulary}', [\App\Http\Controllers\Admin\VocabularyController::class, 'update'])->name('vocabulary.update');
        Route::delete('/vocabulary/{vocabulary}', [\App\Http\Controllers\Admin\VocabularyController::class, 'destroy'])->name('vocabulary.destroy');
        Route::get('/kanji', [\App\Http\Controllers\Admin\KanjiController::class, 'index'])->name('kanji.index');
        Route::get('/kanji/create', [\App\Http\Controllers\Admin\KanjiController::class, 'create'])->name('kanji.create');
        Route::post('/kanji', [\App\Http\Controllers\Admin\KanjiController::class, 'store'])->name('kanji.store');
        Route::get('/kanji/{kanji}/edit', [\App\Http\Controllers\Admin\KanjiController::class, 'edit'])->name('kanji.edit');
        Route::put('/kanji/{kanji}', [\App\Http\Controllers\Admin\KanjiController::class, 'update'])->name('kanji.update');
        Route::delete('/kanji/{kanji}', [\App\Http\Controllers\Admin\KanjiController::class, 'destroy'])->name('kanji.destroy');
        Route::get('/example-words', [\App\Http\Controllers\Admin\ExampleWordController::class, 'index'])->name('example-words.index');
        Route::get('/example-words/create', [\App\Http\Controllers\Admin\ExampleWordController::class, 'create'])->name('example-words.create');
        Route::post('/example-words', [\App\Http\Controllers\Admin\ExampleWordController::class, 'store'])->name('example-words.store');
        Route::get('/example-words/{exampleWord}/edit', [\App\Http\Controllers\Admin\ExampleWordController::class, 'edit'])->name('example-words.edit');
        Route::put('/example-words/{exampleWord}', [\App\Http\Controllers\Admin\ExampleWordController::class, 'update'])->name('example-words.update');
        Route::delete('/example-words/{exampleWord}', [\App\Http\Controllers\Admin\ExampleWordController::class, 'destroy'])->name('example-words.destroy');
    });
});



