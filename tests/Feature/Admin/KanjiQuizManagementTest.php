<?php

namespace Tests\Feature\Admin;

use App\Models\JlptLevel;
use App\Models\Kanji;
use App\Models\KanjiQuiz;
use App\Models\KanjiQuizQuestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KanjiQuizManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_kanji_quiz_for_a_selected_level(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N5', 'slug' => 'n5', 'sort_order' => 5, 'description' => 'Beginner']);
        $kanji = Kanji::create([
            'jlpt_level_id' => $level->id,
            'character' => '水',
            'slug' => 'water-kanji',
            'meaning' => 'water',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $response = $this->actingAs($admin)->post('/admin/kanji-quizzes', [
            'jlpt_level_id' => $level->id,
            'title' => 'N5 Water Quiz',
            'slug' => 'n5-water-quiz',
            'description' => 'Basic kanji meanings',
            'is_published' => 1,
            'questions' => [
                [
                    'kanji_id' => $kanji->id,
                    'prompt' => 'What is the meaning of this kanji?',
                    'question_type' => 'meaning',
                    'options' => ['water', 'fire', 'tree', 'gold'],
                    'correct_answer' => 'water',
                    'sort_order' => 1,
                ],
            ],
        ]);

        $response->assertRedirect('/admin/kanji-quizzes');
        $this->assertDatabaseHas('kanji_quizzes', [
            'title' => 'N5 Water Quiz',
            'slug' => 'n5-water-quiz',
            'jlpt_level_id' => $level->id,
            'question_count' => 1,
        ]);
        $quizId = KanjiQuiz::query()->where('slug', 'n5-water-quiz')->value('id');

        $this->assertDatabaseHas('kanji_quiz_questions', [
            'kanji_quiz_id' => $quizId,
            'kanji_id' => $kanji->id,
            'correct_answer' => 'water',
        ]);
    }

    public function test_admin_can_update_a_quiz_and_replace_questions(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N4', 'slug' => 'n4', 'sort_order' => 4, 'description' => 'Elementary']);
        $firstKanji = Kanji::create([
            'jlpt_level_id' => $level->id,
            'character' => '火',
            'slug' => 'fire-kanji',
            'meaning' => 'fire',
            'sort_order' => 1,
            'is_published' => true,
        ]);
        $secondKanji = Kanji::create([
            'jlpt_level_id' => $level->id,
            'character' => '木',
            'slug' => 'tree-kanji',
            'meaning' => 'tree',
            'sort_order' => 2,
            'is_published' => true,
        ]);
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
            'kanji_id' => $firstKanji->id,
            'prompt' => 'What is the meaning of this kanji?',
            'question_type' => 'meaning',
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
                    'kanji_id' => $secondKanji->id,
                    'prompt' => 'What is the meaning of this kanji?',
                    'question_type' => 'meaning',
                    'options' => ['tree', 'water', 'moon', 'rain'],
                    'correct_answer' => 'tree',
                    'sort_order' => 1,
                ],
                [
                    'kanji_id' => $firstKanji->id,
                    'prompt' => 'What is the meaning of this kanji?',
                    'question_type' => 'meaning',
                    'options' => ['fire', 'stone', 'river', 'earth'],
                    'correct_answer' => 'fire',
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
            'kanji_id' => $secondKanji->id,
            'correct_answer' => 'tree',
        ]);
        $this->assertDatabaseHas('kanji_quiz_questions', [
            'kanji_quiz_id' => $quiz->id,
            'kanji_id' => $firstKanji->id,
            'sort_order' => 2,
        ]);
    }

    public function test_admin_cannot_use_kanji_from_a_different_level_in_a_quiz(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $n5 = JlptLevel::create(['name' => 'N5', 'slug' => 'n5', 'sort_order' => 5, 'description' => 'Beginner']);
        $n4 = JlptLevel::create(['name' => 'N4', 'slug' => 'n4', 'sort_order' => 4, 'description' => 'Elementary']);
        $wrongKanji = Kanji::create([
            'jlpt_level_id' => $n4->id,
            'character' => '山',
            'slug' => 'mountain-kanji',
            'meaning' => 'mountain',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $response = $this->from('/admin/kanji-quizzes/create')->actingAs($admin)->post('/admin/kanji-quizzes', [
            'jlpt_level_id' => $n5->id,
            'title' => 'Broken Quiz',
            'slug' => 'broken-quiz',
            'questions' => [
                [
                    'kanji_id' => $wrongKanji->id,
                    'prompt' => 'What is the meaning of this kanji?',
                    'question_type' => 'meaning',
                    'options' => ['mountain', 'river', 'fire', 'tree'],
                    'correct_answer' => 'mountain',
                    'sort_order' => 1,
                ],
            ],
        ]);

        $response->assertRedirect('/admin/kanji-quizzes/create');
        $response->assertSessionHasErrors('questions.0.kanji_id');
    }
}
