<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JlptLevel;
use App\Models\Kanji;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Vocabulary;
use App\Support\AdminLayoutData;

class AdminDashboardController extends Controller
{
    public function __invoke()
    {
        $pendingApprovals = User::query()
            ->where('is_admin', false)
            ->where('is_approved', false)
            ->count();

        return view('vue-page', [
            'title' => 'Admin Dashboard',
            'pageComponent' => 'admin-dashboard',
            'pageProps' => [
                'stats' => [
                    ['label' => 'Users', 'value' => User::count(), 'tone' => 'slate'],
                    ['label' => 'Pending Approvals', 'value' => $pendingApprovals, 'tone' => 'rose'],
                    ['label' => 'JLPT Levels', 'value' => JlptLevel::count(), 'tone' => 'emerald'],
                    ['label' => 'Lessons', 'value' => Lesson::count(), 'tone' => 'amber'],
                    ['label' => 'Vocabulary', 'value' => Vocabulary::count(), 'tone' => 'sky'],
                    ['label' => 'Kanji', 'value' => Kanji::count(), 'tone' => 'rose'],
                ],
                'recentLinks' => [
                    [
                        'label' => 'Approve Learners',
                        'description' => 'Accept newly registered learners and let them access study pages.',
                        'href' => route('admin.approvals.index'),
                    ],
                    [
                        'label' => 'Manage Users',
                        'description' => 'Create learner accounts, assign JLPT access, and manage admins.',
                        'href' => route('admin.users.index'),
                    ],
                    [
                        'label' => 'Manage JLPT Levels',
                        'description' => 'Create and organize the level structure.',
                        'href' => route('admin.levels.index'),
                    ],
                    [
                        'label' => 'Manage Lessons',
                        'description' => 'Update learning paths and lesson content.',
                        'href' => route('admin.lessons.index'),
                    ],
                ],
                'layout' => AdminLayoutData::make(
                    'Admin Dashboard',
                    'Overview of users, approvals, and Japanese learning content.',
                    'dashboard',
                ),
            ],
        ]);
    }
}
