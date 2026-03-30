<?php

namespace Tests\Feature\Lessons;

use App\Models\JlptLevel;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_users_can_view_filtered_lessons_from_assigned_levels(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $n5 = JlptLevel::create([
            'name' => 'N5',
            'slug' => 'n5',
            'sort_order' => 5,
            'description' => 'Beginner',
        ]);
        $n4 = JlptLevel::create([
            'name' => 'N4',
            'slug' => 'n4',
            'sort_order' => 4,
            'description' => 'Elementary',
        ]);
        $user->accessibleJlptLevels()->attach($n5->id);

        Lesson::create([
            'jlpt_level_id' => $n5->id,
            'title' => 'Hiragana Basics',
            'slug' => 'hiragana-basics',
            'excerpt' => 'Start with hiragana',
            'content' => 'Lesson content',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        Lesson::create([
            'jlpt_level_id' => $n4->id,
            'title' => 'Particles Review',
            'slug' => 'particles-review',
            'excerpt' => 'Understand common particles',
            'content' => 'Lesson content',
            'sort_order' => 2,
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->get('/lessons?level=n5');

        $response->assertOk();
        $response->assertSee('Hiragana Basics');
        $response->assertDontSee('Particles Review');
    }

    public function test_authenticated_users_can_view_a_published_lesson_detail_when_level_is_assigned(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create([
            'name' => 'N5',
            'slug' => 'n5',
            'sort_order' => 5,
            'description' => 'Beginner',
        ]);
        $user->accessibleJlptLevels()->attach($level->id);

        $lesson = Lesson::create([
            'jlpt_level_id' => $level->id,
            'title' => 'Greetings',
            'slug' => 'greetings',
            'excerpt' => 'Useful daily greetings',
            'content' => 'Konnichiwa and more',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->get('/lessons/'.$lesson->slug);

        $response->assertOk();
        $response->assertSee('Greetings');
        $response->assertSee('Konnichiwa and more');
    }

    public function test_authenticated_admin_users_can_create_lessons_from_admin(): void
    {
        $user = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $level = JlptLevel::create([
            'name' => 'N3',
            'slug' => 'n3',
            'sort_order' => 3,
            'description' => 'Intermediate',
        ]);

        $response = $this->actingAs($user)->post('/admin/lessons', [
            'jlpt_level_id' => $level->id,
            'title' => 'Reading Practice',
            'slug' => 'reading-practice',
            'excerpt' => 'Train your reading skills',
            'content' => 'Reading content',
            'sort_order' => 3,
            'is_published' => 1,
        ]);

        $response->assertRedirect('/admin/lessons');
        $this->assertDatabaseHas('lessons', [
            'title' => 'Reading Practice',
            'slug' => 'reading-practice',
        ]);
    }

    public function test_users_can_bookmark_lessons_when_level_is_assigned(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create([
            'name' => 'N5',
            'slug' => 'n5',
            'sort_order' => 5,
            'description' => 'Beginner',
        ]);
        $user->accessibleJlptLevels()->attach($level->id);

        $lesson = Lesson::create([
            'jlpt_level_id' => $level->id,
            'title' => 'Numbers',
            'slug' => 'numbers',
            'excerpt' => 'Learn basic numbers',
            'content' => 'ichi, ni, san',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->post('/lessons/'.$lesson->slug.'/bookmark');

        $response->assertRedirect();
        $this->assertDatabaseHas('lesson_bookmarks', [
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
        ]);
    }

    public function test_users_can_mark_lessons_as_completed_when_level_is_assigned(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create([
            'name' => 'N5',
            'slug' => 'n5',
            'sort_order' => 5,
            'description' => 'Beginner',
        ]);
        $user->accessibleJlptLevels()->attach($level->id);

        $lesson = Lesson::create([
            'jlpt_level_id' => $level->id,
            'title' => 'Time Expressions',
            'slug' => 'time-expressions',
            'excerpt' => 'Learn common time words',
            'content' => 'kyou, ashita, kinou',
            'sort_order' => 2,
            'is_published' => true,
        ]);

        $response = $this->actingAs($user)->post('/lessons/'.$lesson->slug.'/complete');

        $response->assertRedirect();
        $this->assertDatabaseHas('lesson_completions', [
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
        ]);
    }
}
