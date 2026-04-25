<?php

namespace Tests\Feature\Kanji;

use App\Models\JlptLevel;
use App\Models\ExampleWord;
use App\Models\Kanji;
use App\Models\Source;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KanjiModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_filter_kanji_by_assigned_level(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $n5 = JlptLevel::create(['name' => 'N5', 'slug' => 'n5', 'sort_order' => 5, 'description' => 'Beginner']);
        $n4 = JlptLevel::create(['name' => 'N4', 'slug' => 'n4', 'sort_order' => 4, 'description' => 'Elementary']);
        $user->accessibleJlptLevels()->attach($n5->id);

        Kanji::create([
            'jlpt_level_id' => $n5->id,
            'character' => '?',
            'slug' => 'mizu-kanji',
            'onyomi' => '??',
            'kunyomi' => '??',
            'meaning' => 'water',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        Kanji::create([
            'jlpt_level_id' => $n4->id,
            'character' => '?',
            'slug' => 'yomu-kanji',
            'onyomi' => '??',
            'kunyomi' => '??',
            'meaning' => 'read',
            'sort_order' => 2,
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->get('/kanji?level=n5');

        $response->assertOk();
        $response->assertSee('water');
        $response->assertSee('"level":"n5"', false);
    }

    public function test_users_can_view_kanji_detail_for_assigned_level(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N5', 'slug' => 'n5', 'sort_order' => 5, 'description' => 'Beginner']);
        $user->accessibleJlptLevels()->attach($level->id);
        $kanji = Kanji::create([
            'jlpt_level_id' => $level->id,
            'character' => '?',
            'slug' => 'hi-kanji',
            'onyomi' => '?',
            'kunyomi' => '?',
            'meaning' => 'fire',
            'example_sentence' => '?????????',
            'example_translation' => 'Please look at the fire.',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->get('/kanji/'.$kanji->slug);

        $response->assertOk();
        $response->assertSee('fire');
        $response->assertSee('?????????');
    }

    public function test_admin_can_create_kanji(): void
    {
        $user = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N3', 'slug' => 'n3', 'sort_order' => 3, 'description' => 'Intermediate']);
        $source = Source::create([
            'jlpt_level_id' => $level->id,
            'name' => 'Somatome',
            'slug' => 'somatome-kanji-n3',
            'content_type' => 'both',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->post('/admin/kanji', [
            'jlpt_level_id' => $level->id,
            'source_id' => $source->id,
            'chapter' => '1',
            'character' => '?',
            'slug' => 'gaku-kanji',
            'onyomi' => '??',
            'kunyomi' => '???',
            'meaning' => 'study',
            'meaning_mm' => 'ေလ့လာမှု',
            'example_sentence' => '????????????',
            'example_translation' => 'I study Japanese.',
            'sort_order' => 1,
            'is_published' => 1,
        ]);

        $response->assertRedirect('/admin/kanji');
        $this->assertDatabaseHas('kanji', ['slug' => 'gaku-kanji', 'source_id' => $source->id, 'chapter' => '1', 'meaning_mm' => 'ေလ့လာမှု']);
    }

    public function test_admin_can_create_example_word_and_attach_it_to_multiple_kanji(): void
    {
        $user = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N2', 'slug' => 'n2', 'sort_order' => 2, 'description' => 'Upper intermediate']);
        $source = Source::create([
            'jlpt_level_id' => $level->id,
            'name' => 'Somatome',
            'slug' => 'somatome-example-n2',
            'content_type' => 'both',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $friend = Kanji::create([
            'jlpt_level_id' => $level->id,
            'source_id' => $source->id,
            'chapter' => '3',
            'character' => '友',
            'slug' => 'tomo-kanji',
            'meaning' => 'friend',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $reach = Kanji::create([
            'jlpt_level_id' => $level->id,
            'source_id' => $source->id,
            'chapter' => '3',
            'character' => '達',
            'slug' => 'tatsu-kanji',
            'meaning' => 'reach',
            'sort_order' => 2,
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->post('/admin/example-words', [
            'jlpt_level_id' => $level->id,
            'source_id' => $source->id,
            'chapter' => '3',
            'word' => '友達',
            'reading' => 'ともだち',
            'meaning' => 'friend',
            'meaning_mm' => 'သူငယ်ချင်း',
            'sort_order' => 1,
            'is_published' => 1,
            'kanji_ids' => [$friend->id, $reach->id],
        ]);

        $response->assertRedirect('/admin/example-words');
        $exampleWord = ExampleWord::where('word', '友達')->first();
        $this->assertNotNull($exampleWord);
        $this->assertDatabaseHas('example_word_kanji', ['example_word_id' => $exampleWord->id, 'kanji_id' => $friend->id]);
        $this->assertDatabaseHas('example_word_kanji', ['example_word_id' => $exampleWord->id, 'kanji_id' => $reach->id]);
    }

    public function test_users_can_filter_kanji_by_source(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N2', 'slug' => 'n2', 'sort_order' => 2, 'description' => 'Upper intermediate']);
        $user->accessibleJlptLevels()->attach($level->id);

        $somatome = Source::create([
            'jlpt_level_id' => $level->id,
            'name' => 'Somatome',
            'slug' => 'somatome-kanji-n2',
            'content_type' => 'both',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $other = Source::create([
            'jlpt_level_id' => $level->id,
            'name' => 'Shinkanzen Master',
            'slug' => 'shinkanzen-kanji-n2',
            'content_type' => 'both',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Kanji::create([
            'jlpt_level_id' => $level->id,
            'source_id' => $somatome->id,
            'character' => '?',
            'slug' => 'kei-kanji',
            'onyomi' => '??',
            'kunyomi' => '???',
            'meaning' => 'respect',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        Kanji::create([
            'jlpt_level_id' => $level->id,
            'source_id' => $other->id,
            'character' => '?',
            'slug' => 'setsu-kanji',
            'onyomi' => '??',
            'kunyomi' => '??',
            'meaning' => 'theory',
            'sort_order' => 2,
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->get('/kanji?level=n2&source=somatome-kanji-n2');

        $response->assertOk();
        $response->assertSee('respect');
        $response->assertSee('"source":"somatome-kanji-n2"', false);
        $response->assertSee('"level":"n2"', false);
    }

    public function test_admin_must_choose_a_kanji_source_when_multiple_sources_exist(): void
    {
        $user = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N1', 'slug' => 'n1', 'sort_order' => 1, 'description' => 'Advanced']);

        Source::create([
            'jlpt_level_id' => $level->id,
            'name' => 'Somatome',
            'slug' => 'somatome-kanji-n1',
            'content_type' => 'both',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Source::create([
            'jlpt_level_id' => $level->id,
            'name' => 'Shinkanzen Master',
            'slug' => 'shinkanzen-kanji-n1',
            'content_type' => 'both',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $response = $this->from('/admin/kanji/create')->actingAs($user)->post('/admin/kanji', [
            'jlpt_level_id' => $level->id,
            'character' => '?',
            'slug' => 'shin-kanji',
            'meaning' => 'truth',
            'sort_order' => 1,
            'is_published' => 1,
        ]);

        $response->assertRedirect('/admin/kanji/create');
        $response->assertSessionHasErrors('source_id');
    }

    public function test_users_can_bookmark_kanji_when_level_is_assigned(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N5', 'slug' => 'n5', 'sort_order' => 5, 'description' => 'Beginner']);
        $user->accessibleJlptLevels()->attach($level->id);
        $kanji = Kanji::create([
            'jlpt_level_id' => $level->id,
            'character' => '?',
            'slug' => 'mori-kanji',
            'onyomi' => '??',
            'kunyomi' => '??',
            'meaning' => 'forest',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->post('/kanji/'.$kanji->slug.'/bookmark');

        $response->assertRedirect();
        $this->assertDatabaseHas('kanji_bookmarks', [
            'user_id' => $user->id,
            'kanji_id' => $kanji->id,
        ]);
    }
}
