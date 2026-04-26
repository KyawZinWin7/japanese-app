<?php

namespace App\Support;

class AdminLayoutData
{
    public static function make(string $title, string $subtitle, string $active): array
    {
        $user = auth()->user();

        return [
            'title' => $title,
            'subtitle' => $subtitle,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'navigation' => [
                [
                    'label' => 'Dashboard',
                    'href' => route('admin.dashboard'),
                    'active' => $active === 'dashboard',
                ],
                [
                    'label' => 'Approvals',
                    'href' => route('admin.approvals.index'),
                    'active' => $active === 'approvals',
                ],
                [
                    'label' => 'Users',
                    'href' => route('admin.users.index'),
                    'active' => $active === 'users',
                ],
                [
                    'label' => 'JLPT Levels',
                    'href' => route('admin.levels.index'),
                    'active' => $active === 'levels',
                ],
                [
                    'label' => 'Lessons',
                    'href' => route('admin.lessons.index'),
                    'active' => $active === 'lessons',
                ],
                [
                    'label' => 'Vocabulary',
                    'href' => route('admin.vocabulary.index'),
                    'active' => $active === 'vocabulary',
                ],
                [
                    'label' => 'Kanji',
                    'href' => route('admin.kanji.index'),
                    'active' => $active === 'kanji',
                ],
                [
                    'label' => 'Quizzes',
                    'href' => route('admin.kanji-quizzes.index'),
                    'active' => $active === 'kanji-quizzes',
                ],
                [
                    'label' => 'Example Words',
                    'href' => route('admin.example-words.index'),
                    'active' => $active === 'example-words',
                ],
            ],
            'actions' => [
                'siteUrl' => route('study.home'),
                'logoutUrl' => route('logout'),
            ],
        ];
    }
}


