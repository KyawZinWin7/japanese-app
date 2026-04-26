<?php

namespace Tests\Feature\KanjiQuiz;

use App\Models\JlptLevel;
use App\Models\Kanji;
use App\Models\KanjiQuiz;
use App\Models\KanjiQuizQuestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KanjiQuizModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login_for_quiz_pages(): void
    {
        $level = JlptLevel::create(['name' => 'N5', 'slug' => 'n5', 'sort_order' => 5, 'description' => 'Beginner']);
        $quiz = KanjiQuiz::create([
            'jlpt_level_id' => $level->id,
            'title' => 'Public N5 Meaning Quiz',
            'slug' => 'public-n5-meaning-quiz',
            'description' => 'Basic kanji meanings',
            'question_count' => 1,
            'is_published' => true,
        ]);

        $listResponse = $this->get('/kanji-quizzes');
        $detailResponse = $this->get('/kanji-quizzes/'.$quiz->slug);

        $listResponse->assertRedirect('/login');
        $detailResponse->assertRedirect('/login');
    }

    public function test_users_can_choose_level_then_view_quiz_list_and_detail_for_assigned_levels(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N5', 'slug' => 'n5', 'sort_order' => 5, 'description' => 'Beginner']);
        $user->accessibleJlptLevels()->attach($level->id);
        $quiz = KanjiQuiz::create([
            'jlpt_level_id' => $level->id,
            'title' => 'N5 Meaning Quiz',
            'slug' => 'n5-meaning-quiz',
            'description' => 'Basic kanji meanings',
            'question_count' => 1,
            'is_published' => true,
        ]);

        $launcherResponse = $this->actingAs($user)->get('/kanji-quizzes');
        $listResponse = $this->actingAs($user)->get('/kanji-quizzes?level=n5');
        $detailResponse = $this->actingAs($user)->get('/kanji-quizzes/'.$quiz->slug);

        $launcherResponse->assertOk()->assertSee('"selectedLevel":null', false)->assertSee('"levels":[{"id":1,"name":"N5","slug":"n5"}]', false);
        $listResponse->assertOk()->assertSee('N5 Meaning Quiz');
        $detailResponse->assertOk()->assertSee('Basic kanji meanings');
    }

    public function test_users_can_submit_answers_and_get_score_for_assigned_levels(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N5', 'slug' => 'n5', 'sort_order' => 5, 'description' => 'Beginner']);
        $user->accessibleJlptLevels()->attach($level->id);
        $kanji = Kanji::create([
            'jlpt_level_id' => $level->id,
            'character' => '?',
            'slug' => 'quiz-water',
            'onyomi' => '??',
            'kunyomi' => '??',
            'meaning' => 'water',
            'sort_order' => 1,
            'is_published' => true,
        ]);
        $quiz = KanjiQuiz::create([
            'jlpt_level_id' => $level->id,
            'title' => 'Water Quiz',
            'slug' => 'water-quiz',
            'description' => 'Simple quiz',
            'question_count' => 1,
            'is_published' => true,
        ]);
        $question = KanjiQuizQuestion::create([
            'kanji_quiz_id' => $quiz->id,
            'kanji_id' => $kanji->id,
            'prompt' => 'What is the meaning of this kanji?',
            'question_type' => 'kanji',
            'quiz_type' => 'kanji',
            'question' => 'What is the meaning of this kanji?',
            'options' => ['water', 'fire', 'tree', 'gold'],
            'correct_answer' => 'water',
            'explanation' => '水 means water.',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($user)->post('/kanji-quizzes/'.$quiz->slug.'/submit', [
            'answers' => [
                $question->id => 'water',
            ],
        ]);

        $response->assertRedirect();
        $follow = $this->actingAs($user)->get($response->headers->get('Location'));
        $follow->assertOk()->assertSee('"score":1', false)->assertSee('"percentage":100', false);
        $this->assertDatabaseHas('kanji_quiz_attempts', [
            'kanji_quiz_id' => $quiz->id,
            'user_id' => $user->id,
            'score' => 1,
            'total_questions' => 1,
        ]);
    }

    public function test_quiz_submission_requires_answers_for_all_questions(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N4', 'slug' => 'n4', 'sort_order' => 4, 'description' => 'Elementary']);
        $user->accessibleJlptLevels()->attach($level->id);
        $quiz = KanjiQuiz::create([
            'jlpt_level_id' => $level->id,
            'title' => 'N4 Quiz',
            'slug' => 'n4-quiz',
            'description' => 'Two question quiz',
            'question_count' => 1,
            'is_published' => true,
        ]);
        $kanji = Kanji::create([
            'jlpt_level_id' => $level->id,
            'character' => '?',
            'slug' => 'quiz-fire',
            'onyomi' => '?',
            'kunyomi' => '?',
            'meaning' => 'fire',
            'sort_order' => 1,
            'is_published' => true,
        ]);
        KanjiQuizQuestion::create([
            'kanji_quiz_id' => $quiz->id,
            'kanji_id' => $kanji->id,
            'prompt' => 'Meaning?',
            'question_type' => 'kanji',
            'quiz_type' => 'kanji',
            'question' => 'Meaning?',
            'options' => ['fire', 'water', 'earth', 'wind'],
            'correct_answer' => 'fire',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($user)->from('/kanji-quizzes/'.$quiz->slug.'/take')->post('/kanji-quizzes/'.$quiz->slug.'/submit', [
            'answers' => [],
        ]);

        $response->assertRedirect('/kanji-quizzes/'.$quiz->slug.'/take');
        $response->assertSessionHasErrors('answers');
    }
}
