<?php

namespace Tests\Feature\Kanji;

use App\Models\JlptLevel;
use App\Models\Kanji;
use App\Models\ExampleWord;
use App\Models\Source;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KanjiFlashcardTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_view_kanji_flashcards_for_assigned_level(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create([
            'name' => 'N5',
            'slug' => 'n5',
            'sort_order' => 5,
            'description' => 'Beginner',
        ]);
        $user->accessibleJlptLevels()->attach($level->id);

        Kanji::create([
            'jlpt_level_id' => $level->id,
            'character' => '?',
            'slug' => 'flash-water',
            'onyomi' => '??',
            'kunyomi' => '??',
            'meaning' => 'water',
            'example_sentence' => '???????',
            'example_translation' => 'I drink water.',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->get('/kanji-flashcards?level=n5');

        $response->assertOk();
        $response->assertSee('kanji-flashcards');
        $response->assertSee('flash-water');
    }

    public function test_users_can_filter_kanji_flashcards_by_chapter(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create([
            'name' => 'N2',
            'slug' => 'n2',
            'sort_order' => 2,
            'description' => 'Upper intermediate',
        ]);
        $user->accessibleJlptLevels()->attach($level->id);

        $source = Source::create([
            'jlpt_level_id' => $level->id,
            'name' => 'Somatome',
            'slug' => 'somatome-n2',
            'content_type' => 'both',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Kanji::create([
            'jlpt_level_id' => $level->id,
            'source_id' => $source->id,
            'chapter' => '1',
            'character' => '?',
            'slug' => 'flash-first',
            'onyomi' => '??',
            'kunyomi' => '??',
            'meaning' => 'first',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        Kanji::create([
            'jlpt_level_id' => $level->id,
            'source_id' => $source->id,
            'chapter' => '2',
            'character' => '?',
            'slug' => 'flash-second',
            'onyomi' => '??',
            'kunyomi' => '??',
            'meaning' => 'second',
            'sort_order' => 2,
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->get('/kanji-flashcards?level=n2&source=somatome-n2&chapter=1');

        $response->assertOk();
        $response->assertSee('flash-first');
        $response->assertDontSee('flash-second');
    }

    public function test_kanji_flashcards_include_related_example_words(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create([
            'name' => 'N2',
            'slug' => 'n2',
            'sort_order' => 2,
            'description' => 'Upper intermediate',
        ]);
        $user->accessibleJlptLevels()->attach($level->id);

        $source = Source::create([
            'jlpt_level_id' => $level->id,
            'name' => 'Somatome',
            'slug' => 'somatome-kanji-related-n2',
            'content_type' => 'both',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Kanji::create([
            'jlpt_level_id' => $level->id,
            'source_id' => $source->id,
            'chapter' => '8',
            'character' => '煙',
            'slug' => 'kemuri-kanji',
            'onyomi' => 'エン',
            'kunyomi' => 'けむり',
            'meaning' => 'smoke',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $kanji = Kanji::where('slug', 'kemuri-kanji')->firstOrFail();
        $exampleWord = ExampleWord::create([
            'jlpt_level_id' => $level->id,
            'source_id' => $source->id,
            'chapter' => '8',
            'word' => '禁煙',
            'reading' => 'きんえん',
            'meaning' => 'no smoking',
            'sort_order' => 1,
        ]);
        $exampleWord->kanji()->attach($kanji->id);

        $response = $this->actingAs($user)->get('/kanji-flashcards?level=n2&source=somatome-kanji-related-n2&chapter=8');

        $response->assertOk();
        $response->assertSee('"related_words"', false);
        $response->assertSee('no smoking');
    }
}
