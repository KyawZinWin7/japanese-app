<?php

namespace Tests\Feature\Admin;

use App\Models\ExampleWord;
use App\Models\JlptLevel;
use App\Models\Source;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleWordFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_filter_example_words_by_level_source_chapter_and_search(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);

        $n2 = JlptLevel::create(['name' => 'N2', 'slug' => 'n2', 'sort_order' => 2, 'description' => 'Upper intermediate']);
        $n3 = JlptLevel::create(['name' => 'N3', 'slug' => 'n3', 'sort_order' => 3, 'description' => 'Intermediate']);

        $somatomeN2 = Source::create([
            'jlpt_level_id' => $n2->id,
            'name' => 'Somatome',
            'slug' => 'somatome-example-n2',
            'content_type' => Source::CONTENT_TYPE_BOTH,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $shinkanzenN2 = Source::create([
            'jlpt_level_id' => $n2->id,
            'name' => 'Shinkanzen',
            'slug' => 'shinkanzen-example-n2',
            'content_type' => Source::CONTENT_TYPE_BOTH,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $somatomeN3 = Source::create([
            'jlpt_level_id' => $n3->id,
            'name' => 'Somatome',
            'slug' => 'somatome-example-n3',
            'content_type' => Source::CONTENT_TYPE_BOTH,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        ExampleWord::create([
            'jlpt_level_id' => $n2->id,
            'source_id' => $somatomeN2->id,
            'chapter' => '1',
            'word' => 'mensetsu-target',
            'reading' => 'mensetsu',
            'meaning' => 'interview',
            'meaning_mm' => 'interview mm',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        ExampleWord::create([
            'jlpt_level_id' => $n2->id,
            'source_id' => $shinkanzenN2->id,
            'chapter' => '1',
            'word' => 'kaigi-other-source',
            'reading' => 'kaigi',
            'meaning' => 'meeting',
            'meaning_mm' => 'meeting mm',
            'sort_order' => 2,
            'is_published' => true,
        ]);

        ExampleWord::create([
            'jlpt_level_id' => $n2->id,
            'source_id' => $somatomeN2->id,
            'chapter' => '2',
            'word' => 'junbi-other-chapter',
            'reading' => 'junbi',
            'meaning' => 'preparation',
            'meaning_mm' => 'preparation mm',
            'sort_order' => 3,
            'is_published' => true,
        ]);

        ExampleWord::create([
            'jlpt_level_id' => $n3->id,
            'source_id' => $somatomeN3->id,
            'chapter' => '1',
            'word' => 'setsumei-other-level',
            'reading' => 'setsumei',
            'meaning' => 'explanation',
            'meaning_mm' => 'explanation mm',
            'sort_order' => 4,
            'is_published' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/example-words?level=n2&source=somatome-example-n2&chapter=1&search=interview');

        $response->assertOk();
        $response->assertSee('mensetsu-target');
        $response->assertSee('interview');
        $response->assertDontSee('kaigi-other-source');
        $response->assertDontSee('meeting');
        $response->assertDontSee('junbi-other-chapter');
        $response->assertDontSee('preparation');
        $response->assertDontSee('setsumei-other-level');
        $response->assertDontSee('explanation');
        $response->assertSee('"level":"n2"', false);
        $response->assertSee('"source":"somatome-example-n2"', false);
        $response->assertSee('"chapter":"1"', false);
        $response->assertSee('"search":"interview"', false);
    }
}
