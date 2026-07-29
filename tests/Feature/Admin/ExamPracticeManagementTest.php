<?php

namespace Tests\Feature\Admin;

use App\Models\ExamPracticeQuestion;
use App\Models\ExamPracticeSet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExamPracticeManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_an_exam_practice_set(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);

        $response = $this->actingAs($admin)->post('/admin/exam-practice', [
            'title' => 'AWS Cloud Practitioner Set 1',
            'slug' => 'aws-cloud-practitioner-set-1',
            'description' => 'Core AWS CCP practice questions',
            'exam_code' => 'CLF-C02',
            'is_published' => 1,
            'questions' => [
                [
                    'question' => 'Which AWS service classifies images uploaded to a website?',
                    'options' => ['Amazon Rekognition', 'Amazon SageMaker', 'Amazon Mechanical Turk', 'Amazon Transcribe'],
                    'correct_answer' => 'Amazon Rekognition',
                    'explanation' => 'Amazon Rekognition provides image and video analysis.',
                    'sort_order' => 1,
                ],
            ],
        ]);

        $response->assertRedirect('/admin/exam-practice');
        $this->assertDatabaseHas('exam_practice_sets', [
            'title' => 'AWS Cloud Practitioner Set 1',
            'slug' => 'aws-cloud-practitioner-set-1',
            'exam_code' => 'CLF-C02',
            'question_count' => 1,
        ]);

        $setId = ExamPracticeSet::query()->where('slug', 'aws-cloud-practitioner-set-1')->value('id');

        $this->assertDatabaseHas('exam_practice_questions', [
            'exam_practice_set_id' => $setId,
            'question' => 'Which AWS service classifies images uploaded to a website?',
            'correct_answer' => 'Amazon Rekognition',
        ]);
    }

    public function test_admin_can_update_an_exam_practice_set_and_replace_questions(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $set = ExamPracticeSet::create([
            'title' => 'Starter Set',
            'slug' => 'starter-set',
            'description' => 'Initial description',
            'exam_code' => 'CLF-C02',
            'question_count' => 1,
            'is_published' => true,
        ]);
        $question = ExamPracticeQuestion::create([
            'exam_practice_set_id' => $set->id,
            'question' => 'What does Amazon S3 store?',
            'options' => ['Objects', 'Containers', 'Virtual machines', 'DNS records'],
            'correct_answer' => 'Objects',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($admin)->put('/admin/exam-practice/'.$set->slug, [
            'title' => 'Updated Set',
            'slug' => 'starter-set',
            'description' => 'Updated description',
            'exam_code' => 'CLF-C02',
            'is_published' => 0,
            'questions' => [
                [
                    'id' => $question->id,
                    'question' => 'Which AWS service provides virtual servers?',
                    'options' => ['Amazon EC2', 'Amazon S3', 'AWS Lambda', 'Amazon Route 53'],
                    'correct_answer' => 'Amazon EC2',
                    'explanation' => 'Amazon EC2 provides resizable compute capacity.',
                    'sort_order' => 1,
                ],
                [
                    'question' => 'Which pricing model has no long-term commitment?',
                    'options' => ['On-Demand', 'Reserved', 'Dedicated Hosts', 'Savings Plans only'],
                    'correct_answer' => 'On-Demand',
                    'explanation' => 'On-Demand pricing lets you pay as you go.',
                    'sort_order' => 2,
                ],
            ],
        ]);

        $response->assertRedirect('/admin/exam-practice');
        $this->assertDatabaseHas('exam_practice_sets', [
            'id' => $set->id,
            'title' => 'Updated Set',
            'question_count' => 2,
            'is_published' => false,
        ]);
        $this->assertDatabaseHas('exam_practice_questions', [
            'id' => $question->id,
            'correct_answer' => 'Amazon EC2',
        ]);
        $this->assertDatabaseHas('exam_practice_questions', [
            'exam_practice_set_id' => $set->id,
            'correct_answer' => 'On-Demand',
            'sort_order' => 2,
        ]);
    }

    public function test_admin_requires_question_text_and_matching_correct_answer(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);

        $response = $this->from('/admin/exam-practice/create')->actingAs($admin)->post('/admin/exam-practice', [
            'title' => 'Broken Set',
            'slug' => 'broken-set',
            'questions' => [
                [
                    'question' => '',
                    'options' => ['Amazon S3', 'Amazon EC2', 'AWS Lambda', 'Amazon RDS'],
                    'correct_answer' => 'Amazon CloudFront',
                    'sort_order' => 1,
                ],
            ],
        ]);

        $response->assertRedirect('/admin/exam-practice/create');
        $response->assertSessionHasErrors(['questions.0.question', 'questions.0.correct_answer']);
    }
}
