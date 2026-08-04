<?php

namespace Tests\Feature\ExamPractice;

use App\Models\ExamPracticeAttempt;
use App\Models\ExamPracticeQuestion;
use App\Models\ExamPracticeSet;
use App\Models\StudyHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExamPracticeModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_view_exam_practice_list_and_detail_pages(): void
    {
        $set = ExamPracticeSet::create([
            'title' => 'AWS Cloud Practitioner Set 1',
            'slug' => 'aws-cloud-practitioner-set-1',
            'description' => 'Core cloud concepts and pricing basics.',
            'exam_code' => 'CLF-C02',
            'question_count' => 1,
            'is_published' => true,
        ]);

        $listResponse = $this->get('/exam-practice');
        $detailResponse = $this->get('/exam-practice/'.$set->slug);

        $listResponse->assertOk();
        $listResponse->assertSee('AWS Cloud Practitioner Set 1');
        $detailResponse->assertOk();
        $detailResponse->assertSee('Core cloud concepts and pricing basics.');
    }

    public function test_approved_users_can_submit_exam_practice_answers_and_get_a_score(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $set = ExamPracticeSet::create([
            'title' => 'AWS Cloud Practitioner Set 1',
            'slug' => 'aws-cloud-practitioner-set-1',
            'description' => 'Starter practice set',
            'exam_code' => 'CLF-C02',
            'question_count' => 1,
            'is_published' => true,
        ]);
        $question = ExamPracticeQuestion::create([
            'exam_practice_set_id' => $set->id,
            'question' => 'Which AWS service classifies images uploaded to a website?',
            'options' => ['Amazon Rekognition', 'Amazon Transcribe', 'AWS Glue', 'Amazon Inspector'],
            'correct_answer' => 'Amazon Rekognition',
            'explanation' => 'Amazon Rekognition analyzes images and videos.',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($user)->post('/exam-practice/'.$set->slug.'/submit', [
            'answers' => [
                $question->id => 'Amazon Rekognition',
            ],
        ]);

        $response->assertRedirect();
        $follow = $this->actingAs($user)->get($response->headers->get('Location'));
        $follow->assertOk()->assertSee('"score":1', false)->assertSee('"percentage":100', false);
        $this->assertDatabaseHas('exam_practice_attempts', [
            'exam_practice_set_id' => $set->id,
            'user_id' => $user->id,
            'score' => 1,
            'total_questions' => 1,
        ]);
    }

    public function test_revealed_answers_are_saved_in_attempt_results(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $set = ExamPracticeSet::create([
            'title' => 'AWS Review Mode',
            'slug' => 'aws-review-mode',
            'description' => 'Reveal answer tracking set',
            'exam_code' => 'CLF-C02',
            'question_count' => 1,
            'is_published' => true,
        ]);
        $question = ExamPracticeQuestion::create([
            'exam_practice_set_id' => $set->id,
            'question' => 'Which AWS service stores objects?',
            'options' => ['Amazon EC2', 'Amazon S3', 'AWS Lambda', 'Amazon RDS'],
            'correct_answer' => 'Amazon S3',
            'explanation' => 'Amazon S3 is object storage.',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($user)->post('/exam-practice/'.$set->slug.'/submit', [
            'answers' => [
                $question->id => 'Amazon S3',
            ],
            'revealed_questions' => [$question->id],
        ]);

        $response->assertRedirect();

        $attempt = ExamPracticeAttempt::query()->firstOrFail();

        $this->assertTrue($attempt->answers[0]['answer_revealed']);

        $follow = $this->actingAs($user)->get($response->headers->get('Location'));
        $follow->assertOk()->assertSee('"answer_revealed":true', false);
    }

    public function test_approved_users_can_submit_choose_two_exam_practice_answers(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $set = ExamPracticeSet::create([
            'title' => 'AWS Shared Responsibility',
            'slug' => 'aws-shared-responsibility',
            'description' => 'Choose two validation set',
            'exam_code' => 'CLF-C02',
            'question_count' => 1,
            'is_published' => true,
        ]);
        $question = ExamPracticeQuestion::create([
            'exam_practice_set_id' => $set->id,
            'question' => 'Which tasks are the responsibility of AWS according to the AWS shared responsibility model? (Choose two.)',
            'options' => [
                'Configure AWS Identity and Access Management (IAM).',
                'Configure security groups on Amazon EC2 instances.',
                'Secure the access of physical AWS facilities.',
                'Patch applications that run on Amazon EC2 instances.',
                'Perform infrastructure patching and maintenance.',
            ],
            'correct_answer' => '[2,4]',
            'explanation' => 'AWS secures facilities and infrastructure.',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($user)->post('/exam-practice/'.$set->slug.'/submit', [
            'answers' => [
                $question->id => [
                    'Secure the access of physical AWS facilities.',
                    'Perform infrastructure patching and maintenance.',
                ],
            ],
        ]);

        $response->assertRedirect();
        $follow = $this->actingAs($user)->get($response->headers->get('Location'));
        $follow->assertOk()->assertSee('"score":1', false)->assertSee('"percentage":100', false);
    }

    public function test_take_page_restores_saved_exam_practice_progress(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $set = ExamPracticeSet::create([
            'title' => 'AWS Cloud Practitioner Set 1',
            'slug' => 'aws-cloud-practitioner-set-1',
            'description' => 'Starter practice set',
            'exam_code' => 'CLF-C02',
            'question_count' => 1,
            'is_published' => true,
        ]);
        $question = ExamPracticeQuestion::create([
            'exam_practice_set_id' => $set->id,
            'question' => 'Which AWS service classifies images uploaded to a website?',
            'options' => ['Amazon Rekognition', 'Amazon Transcribe', 'AWS Glue', 'Amazon Inspector'],
            'correct_answer' => 'Amazon Rekognition',
            'explanation' => 'Amazon Rekognition analyzes images and videos.',
            'sort_order' => 1,
        ]);

        StudyHistory::create([
            'user_id' => $user->id,
            'entry_key' => 'quiz:http://localhost/exam-practice/'.$set->slug,
            'href' => 'http://localhost/exam-practice/'.$set->slug.'/take',
            'title' => $set->title,
            'subtitle' => $set->exam_code,
            'progress_label' => '1 / 1',
            'state' => [
                'answers' => [$question->id => 'Amazon Rekognition'],
                'checkedQuestionStates' => [$question->id => true],
                'revealedQuestions' => [$question->id => false],
                'currentQuestionIndex' => 0,
            ],
            'is_resume' => true,
            'last_accessed_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/exam-practice/'.$set->slug.'/take');

        $response->assertOk();
        $response->assertSee('"studyState":{"answers":{"'.$question->id.'":"Amazon Rekognition"}', false);
    }

    public function test_exam_practice_submission_requires_answers_for_all_questions(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $set = ExamPracticeSet::create([
            'title' => 'AWS Cloud Practitioner Set 2',
            'slug' => 'aws-cloud-practitioner-set-2',
            'description' => 'Missing answer validation set',
            'exam_code' => 'CLF-C02',
            'question_count' => 1,
            'is_published' => true,
        ]);

        ExamPracticeQuestion::create([
            'exam_practice_set_id' => $set->id,
            'question' => 'Which service stores objects?',
            'options' => ['Amazon S3', 'Amazon EC2', 'AWS Lambda', 'Amazon RDS'],
            'correct_answer' => 'Amazon S3',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($user)
            ->from('/exam-practice/'.$set->slug.'/take')
            ->post('/exam-practice/'.$set->slug.'/submit', [
                'answers' => [],
            ]);

        $response->assertRedirect('/exam-practice/'.$set->slug.'/take');
        $response->assertSessionHasErrors('answers');
    }

    public function test_exam_practice_submission_requires_all_answers_for_choose_two_questions(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $set = ExamPracticeSet::create([
            'title' => 'AWS Shared Responsibility 2',
            'slug' => 'aws-shared-responsibility-2',
            'description' => 'Choose two incomplete answer set',
            'exam_code' => 'CLF-C02',
            'question_count' => 1,
            'is_published' => true,
        ]);

        $question = ExamPracticeQuestion::create([
            'exam_practice_set_id' => $set->id,
            'question' => 'Which tasks are the responsibility of AWS according to the AWS shared responsibility model? (Choose two.)',
            'options' => [
                'Configure AWS Identity and Access Management (IAM).',
                'Configure security groups on Amazon EC2 instances.',
                'Secure the access of physical AWS facilities.',
                'Patch applications that run on Amazon EC2 instances.',
                'Perform infrastructure patching and maintenance.',
            ],
            'correct_answer' => '[2,4]',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($user)
            ->from('/exam-practice/'.$set->slug.'/take')
            ->post('/exam-practice/'.$set->slug.'/submit', [
                'answers' => [
                    $question->id => [
                        'Secure the access of physical AWS facilities.',
                    ],
                ],
            ]);

        $response->assertRedirect('/exam-practice/'.$set->slug.'/take');
        $response->assertSessionHasErrors('answers');
    }
}
