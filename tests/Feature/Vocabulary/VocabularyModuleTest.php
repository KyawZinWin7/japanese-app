<?php

namespace Tests\Feature\Vocabulary;

use App\Models\JlptLevel;
use App\Models\Source;
use App\Models\User;
use App\Models\Vocabulary;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VocabularyModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login_from_vocabulary_page(): void
    {
        $level = JlptLevel::create(['name' => 'N5', 'slug' => 'n5', 'sort_order' => 5, 'description' => 'Beginner']);

        Vocabulary::create([
            'jlpt_level_id' => $level->id,
            'word' => '?',
            'slug' => 'mizu',
            'reading' => '??',
            'meaning' => 'water',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $response = $this->get('/vocabulary');

        $response->assertRedirect('/login');
    }

    public function test_users_can_search_and_filter_vocabulary_from_assigned_levels(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $n5 = JlptLevel::create(['name' => 'N5', 'slug' => 'n5', 'sort_order' => 5, 'description' => 'Beginner']);
        $n4 = JlptLevel::create(['name' => 'N4', 'slug' => 'n4', 'sort_order' => 4, 'description' => 'Elementary']);
        $user->accessibleJlptLevels()->attach($n5->id);

        Vocabulary::create([
            'jlpt_level_id' => $n5->id,
            'word' => '?',
            'slug' => 'mizu',
            'reading' => '??',
            'meaning' => 'water',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        Vocabulary::create([
            'jlpt_level_id' => $n4->id,
            'word' => '??',
            'slug' => 'densha',
            'reading' => '????',
            'meaning' => 'train',
            'sort_order' => 2,
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->get('/vocabulary?level=n5&search=water');

        $response->assertOk();
        $response->assertSee('water');
        $response->assertDontSee('train');
    }

    public function test_vocabulary_source_tables_and_columns_are_available(): void
    {
        $this->assertTrue(Schema::hasTable('sources'));
        $this->assertTrue(Schema::hasColumn('vocabularies', 'source_id'));
        $this->assertTrue(Schema::hasColumn('kanji', 'source_id'));
        $this->assertTrue(Schema::hasColumn('vocabularies', 'meaning_mm'));
        $this->assertTrue(Schema::hasColumn('kanji', 'meaning_mm'));
        $this->assertTrue(Schema::hasColumn('vocabularies', 'chapter'));
        $this->assertTrue(Schema::hasColumn('kanji', 'chapter'));
    }

    public function test_users_can_filter_vocabulary_by_source(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N3', 'slug' => 'n3', 'sort_order' => 3, 'description' => 'Intermediate']);
        $user->accessibleJlptLevels()->attach($level->id);

        $somatome = Source::create([
            'jlpt_level_id' => $level->id,
            'name' => 'Somatome',
            'slug' => 'somatome-n3',
            'content_type' => 'both',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $shinkanzen = Source::create([
            'jlpt_level_id' => $level->id,
            'name' => 'Shinkanzen Master',
            'slug' => 'shinkanzen-master-n3',
            'content_type' => 'both',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Vocabulary::create([
            'jlpt_level_id' => $level->id,
            'source_id' => $somatome->id,
            'word' => '??',
            'slug' => 'bunpou',
            'reading' => '?????',
            'meaning' => 'grammar',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        Vocabulary::create([
            'jlpt_level_id' => $level->id,
            'source_id' => $shinkanzen->id,
            'word' => '??',
            'slug' => 'goi',
            'reading' => '??',
            'meaning' => 'word list',
            'sort_order' => 2,
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->get('/vocabulary?level=n3&source=somatome-n3');

        $response->assertOk();
        $response->assertSee('grammar');
        $response->assertDontSee('word list');
    }

    public function test_users_can_bookmark_vocabulary_when_level_is_assigned(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N5', 'slug' => 'n5', 'sort_order' => 5, 'description' => 'Beginner']);
        $user->accessibleJlptLevels()->attach($level->id);
        $item = Vocabulary::create([
            'jlpt_level_id' => $level->id,
            'word' => '?',
            'slug' => 'hi',
            'reading' => '?',
            'meaning' => 'fire',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->post('/vocabulary/'.$item->slug.'/bookmark');

        $response->assertRedirect();
        $this->assertDatabaseHas('vocabulary_bookmarks', [
            'user_id' => $user->id,
            'vocabulary_id' => $item->id,
        ]);
    }

    public function test_admin_can_create_vocabulary(): void
    {
        $user = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N3', 'slug' => 'n3', 'sort_order' => 3, 'description' => 'Intermediate']);
        $source = Source::create([
            'jlpt_level_id' => $level->id,
            'name' => 'Somatome',
            'slug' => 'somatome-admin-n3',
            'content_type' => 'both',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->post('/admin/vocabulary', [
            'jlpt_level_id' => $level->id,
            'source_id' => $source->id,
            'chapter' => '1',
            'word' => '??',
            'slug' => 'benkyou',
            'reading' => '?????',
            'meaning' => 'study',
            'meaning_mm' => 'ေလ့လာမှု',
            'example_sentence' => '????????????',
            'example_translation' => 'I study Japanese.',
            'sort_order' => 1,
            'is_published' => 1,
        ]);

        $response->assertRedirect('/admin/vocabulary');
        $this->assertDatabaseHas('vocabularies', ['slug' => 'benkyou', 'source_id' => $source->id, 'chapter' => '1', 'meaning_mm' => 'ေလ့လာမှု']);
    }

    public function test_admin_must_choose_a_source_when_multiple_sources_exist_for_a_level(): void
    {
        $user = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N2', 'slug' => 'n2', 'sort_order' => 2, 'description' => 'Upper intermediate']);

        Source::create([
            'jlpt_level_id' => $level->id,
            'name' => 'Somatome',
            'slug' => 'somatome-n2',
            'content_type' => 'both',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Source::create([
            'jlpt_level_id' => $level->id,
            'name' => 'Shinkanzen Master',
            'slug' => 'shinkanzen-master-n2',
            'content_type' => 'both',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $response = $this->from('/admin/vocabulary/create')->actingAs($user)->post('/admin/vocabulary', [
            'jlpt_level_id' => $level->id,
            'word' => '??',
            'slug' => 'kotoba',
            'reading' => '????',
            'meaning' => 'language',
            'sort_order' => 1,
            'is_published' => 1,
        ]);

        $response->assertRedirect('/admin/vocabulary/create');
        $response->assertSessionHasErrors('source_id');
    }

    public function test_admin_can_create_n5_vocabulary_without_a_source(): void
    {
        $user = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N5', 'slug' => 'n5', 'sort_order' => 5, 'description' => 'Beginner']);

        $response = $this->actingAs($user)->post('/admin/vocabulary', [
            'jlpt_level_id' => $level->id,
            'word' => '??',
            'slug' => 'asa',
            'reading' => '??',
            'meaning' => 'morning',
            'sort_order' => 1,
            'is_published' => 1,
        ]);

        $response->assertRedirect('/admin/vocabulary');
        $this->assertDatabaseHas('vocabularies', ['slug' => 'asa', 'source_id' => null]);
    }

    public function test_users_can_view_their_bookmarked_items_page(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N5', 'slug' => 'n5', 'sort_order' => 5, 'description' => 'Beginner']);
        $user->accessibleJlptLevels()->attach($level->id);

        $lesson = \App\Models\Lesson::create([
            'jlpt_level_id' => $level->id,
            'title' => 'Self Introduction',
            'slug' => 'self-introduction',
            'excerpt' => 'Talk about yourself',
            'content' => 'Watashi wa...',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $item = Vocabulary::create([
            'jlpt_level_id' => $level->id,
            'word' => '??',
            'slug' => 'tomodachi',
            'reading' => '????',
            'meaning' => 'friend',
            'sort_order' => 2,
            'is_published' => true,
        ]);

        $kanji = \App\Models\Kanji::create([
            'jlpt_level_id' => $level->id,
            'character' => '?',
            'slug' => 'tomo-kanji',
            'onyomi' => '??',
            'kunyomi' => '??',
            'meaning' => 'friend',
            'sort_order' => 3,
            'is_published' => true,
        ]);

        $user->bookmarkedLessons()->attach($lesson->id);
        $user->bookmarkedVocabulary()->attach($item->id);
        $user->bookmarkedKanji()->attach($kanji->id);

        $response = $this->actingAs($user)->get('/bookmarks');

        $response->assertOk();
        $response->assertSee('Self Introduction');
        $response->assertSee('friend');
        $response->assertSee('tomo-kanji');
    }
}
