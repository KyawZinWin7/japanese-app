<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\AdminLayoutData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->string('status')->lower()->value() ?: 'pending';
        $search = trim((string) $request->string('search')->value());

        $users = User::query()
            ->where('is_admin', false)
            ->when($status === 'pending', fn ($query) => $query->where('is_approved', false))
            ->when($status === 'approved', fn ($query) => $query->where('is_approved', true))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->with('accessibleJlptLevels:id,name,slug')
            ->orderBy('is_approved')
            ->orderBy('name')
            ->get()
            ->map(fn (User $user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_approved' => $user->is_approved,
                'levels' => $user->accessibleJlptLevels->map(fn ($level) => [
                    'name' => $level->name,
                    'slug' => $level->slug,
                ])->values()->all(),
            ])
            ->values()
            ->all();

        return view('vue-page', [
            'title' => 'Learner Approvals',
            'pageComponent' => 'admin-user-approvals',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'filters' => [
                    'search' => $search,
                    'status' => in_array($status, ['pending', 'approved', 'all'], true) ? $status : 'pending',
                ],
                'users' => $users,
                'status' => session('status'),
                'routes' => [
                    'index' => route('admin.approvals.index'),
                    'approveBase' => route('admin.approvals.index'),
                    'rejectBase' => route('admin.approvals.index'),
                    'editBase' => route('admin.users.index'),
                ],
                'layout' => AdminLayoutData::make(
                    'Learner Approvals',
                    'Search learners, filter by approval status, and accept or reject registrations.',
                    'approvals',
                ),
            ],
        ]);
    }

    public function approve(User $user): RedirectResponse
    {
        abort_if($user->is_admin, 404);

        $user->update(['is_approved' => true]);

        return redirect()->route('admin.approvals.index')->with('status', 'Learner approved successfully.');
    }

    public function reject(User $user): RedirectResponse
    {
        abort_if($user->is_admin || $user->is_approved, 404);

        $user->accessibleJlptLevels()->detach();
        $user->delete();

        return redirect()->route('admin.approvals.index')->with('status', 'Learner registration rejected and removed.');
    }
}
