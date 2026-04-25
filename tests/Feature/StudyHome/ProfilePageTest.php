<?php

namespace Tests\Feature\StudyHome;

use App\Models\JlptLevel;
use App\Models\KanjiQuiz;
use App\Models\KanjiQuizAttempt;
use App\Models\Lesson;
use App\Models\StudyHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_includes_profile_and_progress_data(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create([
            'name' => 'N5',
            'slug' => 'n5',
            'sort_order' => 5,
            'description' => 'Beginner',
        ]);

        $lesson = Lesson::create([
            'jlpt_level_id' => $level->id,
            'title' => 'Greetings',
            'slug' => 'greetings',
            'excerpt' => 'Start speaking',
            'content' => 'Lesson one',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $quiz = KanjiQuiz::create([
            'jlpt_level_id' => $level->id,
            'title' => 'Starter Quiz',
            'slug' => 'starter-quiz',
            'description' => 'Quick review',
            'question_count' => 3,
            'is_published' => true,
        ]);

        $user->accessibleJlptLevels()->attach($level->id);
        $user->completedLessons()->attach($lesson->id, ['created_at' => now()->subHour(), 'updated_at' => now()->subHour()]);
        $user->bookmarkedLessons()->attach($lesson->id, ['created_at' => now()->subMinutes(30), 'updated_at' => now()->subMinutes(30)]);

        KanjiQuizAttempt::create([
            'kanji_quiz_id' => $quiz->id,
            'user_id' => $user->id,
            'score' => 2,
            'total_questions' => 3,
            'answers' => [],
            'created_at' => now()->subMinutes(10),
            'updated_at' => now()->subMinutes(10),
        ]);

        StudyHistory::create([
            'user_id' => $user->id,
            'entry_key' => 'lesson:/lessons/greetings',
            'href' => 'http://localhost/lessons/greetings',
            'title' => 'Greetings',
            'subtitle' => 'N5 Read',
            'progress_label' => 'Ready',
            'state' => [],
            'is_resume' => true,
            'last_accessed_at' => now()->subMinutes(5),
        ]);

        $response = $this->actingAs($user)->get('/profile');

        $response->assertOk();
        $response->assertSee('profile', false);
        $response->assertSee('"completedLessons":1', false);
        $response->assertSee('"completionRate":100', false);
        $response->assertSee('"levels":[{"id":1,"name":"N5"', false);
        $response->assertSee('"resumeItems":[{"id":"lesson:\/lessons\/greetings","href":"http:\/\/localhost\/lessons\/greetings","title":"Greetings"', false);
        $response->assertSee('"historyItems":[{"id":"lesson:\/lessons\/greetings","href":"http:\/\/localhost\/lessons\/greetings","title":"Greetings"', false);
        $response->assertSee($user->email);
    }
}
