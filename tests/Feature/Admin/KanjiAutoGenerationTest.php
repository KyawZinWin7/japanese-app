<?php

namespace Tests\Feature\Admin;

use App\Models\JlptLevel;
use App\Models\Kanji;
use App\Models\Source;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KanjiAutoGenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_kanji_with_auto_generated_slug_and_sort_order(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N2', 'slug' => 'n2', 'sort_order' => 2, 'description' => 'Upper intermediate']);
        $source = Source::create([
            'jlpt_level_id' => $level->id,
            'name' => 'Somatome',
            'slug' => 'somatome-kanji-n2',
            'content_type' => Source::CONTENT_TYPE_BOTH,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Kanji::create([
            'jlpt_level_id' => $level->id,
            'source_id' => $source->id,
            'chapter' => '1',
            'character' => '先',
            'slug' => 'previous-kanji',
            'meaning' => 'previous',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        Kanji::create([
            'jlpt_level_id' => $level->id,
            'source_id' => $source->id,
            'chapter' => '1',
            'character' => '後',
            'slug' => 'after-kanji',
            'meaning' => 'after',
            'sort_order' => 2,
            'is_published' => true,
        ]);

        $response = $this->actingAs($admin)->post('/admin/kanji', [
            'jlpt_level_id' => $level->id,
            'source_id' => $source->id,
            'chapter' => '1',
            'character' => '学',
            'slug' => '',
            'meaning' => 'study',
            'sort_order' => '',
            'is_published' => 1,
        ]);

        $response->assertRedirect('/admin/kanji');
        $this->assertDatabaseHas('kanji', [
            'character' => '学',
            'slug' => 'study-kanji',
            'sort_order' => 3,
        ]);
    }

    public function test_admin_cannot_reuse_sort_order_in_the_same_scope(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N3', 'slug' => 'n3', 'sort_order' => 3, 'description' => 'Intermediate']);
        $source = Source::create([
            'jlpt_level_id' => $level->id,
            'name' => 'Shinkanzen',
            'slug' => 'shinkanzen-kanji-n3',
            'content_type' => Source::CONTENT_TYPE_BOTH,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Kanji::create([
            'jlpt_level_id' => $level->id,
            'source_id' => $source->id,
            'chapter' => '4',
            'character' => '考',
            'slug' => 'think-kanji',
            'meaning' => 'think',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $response = $this->from('/admin/kanji/create')->actingAs($admin)->post('/admin/kanji', [
            'jlpt_level_id' => $level->id,
            'source_id' => $source->id,
            'chapter' => '4',
            'character' => '答',
            'slug' => 'answer-kanji',
            'meaning' => 'answer',
            'sort_order' => 1,
            'is_published' => 1,
        ]);

        $response->assertRedirect('/admin/kanji/create');
        $response->assertSessionHasErrors('sort_order');
    }
}
