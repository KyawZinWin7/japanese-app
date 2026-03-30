<?php

namespace Tests\Feature\Admin;

use App\Models\JlptLevel;
use App\Models\Source;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SourceManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_sources(): void
    {
        $user = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $level = JlptLevel::create(['name' => 'N3', 'slug' => 'n3', 'sort_order' => 3, 'description' => 'Intermediate']);

        $createResponse = $this->actingAs($user)->post('/admin/sources', [
            'jlpt_level_id' => $level->id,
            'name' => 'Somatome',
            'slug' => 'somatome-shortcut-n3',
            'content_type' => 'both',
            'sort_order' => 1,
            'is_active' => 1,
        ]);

        $createResponse->assertRedirect('/admin/sources');
        $this->assertDatabaseHas('sources', ['slug' => 'somatome-shortcut-n3']);

        $source = Source::query()->where('slug', 'somatome-shortcut-n3')->firstOrFail();

        $indexResponse = $this->actingAs($user)->get('/admin/sources?level=n3&content_type=both');
        $indexResponse->assertOk();
        $indexResponse->assertSee('Somatome');

        $updateResponse = $this->actingAs($user)->put('/admin/sources/'.$source->id, [
            'jlpt_level_id' => $level->id,
            'name' => 'Somatome Updated',
            'slug' => 'somatome-shortcut-n3',
            'content_type' => 'both',
            'sort_order' => 1,
            'is_active' => 1,
        ]);

        $updateResponse->assertRedirect('/admin/sources');
        $this->assertDatabaseHas('sources', ['id' => $source->id, 'name' => 'Somatome Updated']);
    }
}
