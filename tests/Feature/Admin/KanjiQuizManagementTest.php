<?php

namespace Tests\Feature\Admin;

use App\Models\JlptLevel;
use App\Models\KanjiQuiz;
use App\Models\KanjiQuizQuestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KanjiQuizManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_quiz_for_a_selected_level(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N5', 'slug' => 'n5', 'sort_order' => 5, 'description' => 'Beginner']);

        $response = $this->actingAs($admin)->post('/admin/kanji-quizzes', [
            'jlpt_level_id' => $level->id,
            'title' => 'N5 Mixed Quiz',
            'slug' => 'n5-mixed-quiz',
            'description' => 'Basic kanji and vocabulary practice',
            'is_published' => 1,
            'questions' => [
                [
                    'quiz_type' => 'kanji',
                    'question' => 'What is the meaning of 水?',
                    'options' => ['water', 'fire', 'tree', 'gold'],
                    'correct_answer' => 'water',
                    'explanation' => '水 means water.',
                    'sort_order' => 1,
                ],
            ],
        ]);

        $response->assertRedirect('/admin/kanji-quizzes');
        $this->assertDatabaseHas('kanji_quizzes', [
            'title' => 'N5 Mixed Quiz',
            'slug' => 'n5-mixed-quiz',
            'jlpt_level_id' => $level->id,
            'question_count' => 1,
        ]);

        $quizId = KanjiQuiz::query()->where('slug', 'n5-mixed-quiz')->value('id');

        $this->assertDatabaseHas('kanji_quiz_questions', [
            'kanji_quiz_id' => $quizId,
            'quiz_type' => 'kanji',
            'question' => 'What is the meaning of 水?',
            'correct_answer' => 'water',
        ]);
    }

    public function test_admin_can_update_a_quiz_and_replace_questions(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N4', 'slug' => 'n4', 'sort_order' => 4, 'description' => 'Elementary']);
        $quiz = KanjiQuiz::create([
            'jlpt_level_id' => $level->id,
            'title' => 'Starter Quiz',
            'slug' => 'starter-quiz',
            'description' => 'Initial description',
            'question_count' => 1,
            'is_published' => true,
        ]);
        $question = KanjiQuizQuestion::create([
            'kanji_quiz_id' => $quiz->id,
            'prompt' => 'What is the meaning of 火?',
            'question_type' => 'kanji',
            'quiz_type' => 'kanji',
            'question' => 'What is the meaning of 火?',
            'options' => ['fire', 'water', 'tree', 'gold'],
            'correct_answer' => 'fire',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($admin)->put('/admin/kanji-quizzes/'.$quiz->slug, [
            'jlpt_level_id' => $level->id,
            'title' => 'Updated Quiz',
            'slug' => 'starter-quiz',
            'description' => 'Updated description',
            'is_published' => 0,
            'questions' => [
                [
                    'id' => $question->id,
                    'quiz_type' => 'vocab',
                    'question' => 'What does 木 mean in this quiz?',
                    'options' => ['tree', 'water', 'moon', 'rain'],
                    'correct_answer' => 'tree',
                    'explanation' => '木 is tree.',
                    'sort_order' => 1,
                ],
                [
                    'quiz_type' => 'grammar',
                    'question' => 'Which choice fits the pattern best?',
                    'options' => ['fire', 'stone', 'river', 'earth'],
                    'correct_answer' => 'fire',
                    'explanation' => 'This is the expected answer for the test case.',
                    'sort_order' => 2,
                ],
            ],
        ]);

        $response->assertRedirect('/admin/kanji-quizzes');
        $this->assertDatabaseHas('kanji_quizzes', [
            'id' => $quiz->id,
            'title' => 'Updated Quiz',
            'question_count' => 2,
            'is_published' => false,
        ]);
        $this->assertDatabaseHas('kanji_quiz_questions', [
            'id' => $question->id,
            'quiz_type' => 'vocab',
            'correct_answer' => 'tree',
        ]);
        $this->assertDatabaseHas('kanji_quiz_questions', [
            'kanji_quiz_id' => $quiz->id,
            'quiz_type' => 'grammar',
            'sort_order' => 2,
        ]);
    }

    public function test_admin_requires_quiz_type_question_and_matching_correct_answer(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $n5 = JlptLevel::create(['name' => 'N5', 'slug' => 'n5', 'sort_order' => 5, 'description' => 'Beginner']);

        $response = $this->from('/admin/kanji-quizzes/create')->actingAs($admin)->post('/admin/kanji-quizzes', [
            'jlpt_level_id' => $n5->id,
            'title' => 'Broken Quiz',
            'slug' => 'broken-quiz',
            'questions' => [
                [
                    'quiz_type' => '',
                    'question' => '',
                    'options' => ['mountain', 'river', 'fire', 'tree'],
                    'correct_answer' => 'gold',
                    'sort_order' => 1,
                ],
            ],
        ]);

        $response->assertRedirect('/admin/kanji-quizzes/create');
        $response->assertSessionHasErrors(['questions.0.quiz_type', 'questions.0.question', 'questions.0.correct_answer']);
    }
}
