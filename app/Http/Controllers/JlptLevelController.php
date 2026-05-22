<?php

namespace App\Http\Controllers;

use App\Models\JlptLevel;
use App\Support\StudyAccess;
use Illuminate\Http\Request;

class JlptLevelController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $levelIds = StudyAccess::allowedLevelIds($user);
        $canSaveProgress = (bool) ($user?->is_approved);

        return view('vue-page', [
            'title' => 'JLPT Levels',
            'pageComponent' => 'jlpt-levels',
            'pageProps' => [
                'levels' => JlptLevel::query()
                    ->whereIn('id', $levelIds)
                    ->orderBy('sort_order')
                    ->get(['id', 'name', 'slug', 'sort_order', 'description'])
                    ->toArray(),
                'viewer' => [
                    'isAuthenticated' => $user !== null,
                    'isApproved' => $canSaveProgress,
                    'dashboardUrl' => route('study.home'),
                    'loginUrl' => route('login'),
                ],
                'routes' => [
                    'dashboard' => route('study.home'),
                ],
            ],
        ]);
    }
}
