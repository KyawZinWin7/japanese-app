<?php

namespace Tests\Feature\StudyHome;

use App\Models\StudyHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudyHistorySyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_approved_user_can_sync_study_history_entry(): void
    {
        $user = User::factory()->create(['is_approved' => true]);

        $response = $this->actingAs($user)->postJson('/study-history/sync', [
            'entryKey' => 'quiz:http://localhost/kanji-quizzes/starter-quiz',
            'href' => 'http://localhost/kanji-quizzes/starter-quiz/take',
            'title' => 'Starter Quiz',
            'subtitle' => 'N5',
            'progressLabel' => '2 / 5',
            'state' => [
                'answers' => [
                    '1' => 'A',
                ],
            ],
            'resume' => true,
        ]);

        $response->assertOk()->assertJson(['ok' => true]);

        $this->assertDatabaseHas('study_histories', [
            'user_id' => $user->id,
            'entry_key' => 'quiz:http://localhost/kanji-quizzes/starter-quiz',
            'title' => 'Starter Quiz',
            'subtitle' => 'N5',
            'progress_label' => '2 / 5',
            'is_resume' => true,
        ]);

        $entry = StudyHistory::query()->where('user_id', $user->id)->firstOrFail();

        $this->assertSame(['answers' => ['1' => 'A']], $entry->state);
    }
}
