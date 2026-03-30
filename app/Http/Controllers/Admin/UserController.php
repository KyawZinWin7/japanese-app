<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\JlptLevel;
use App\Models\User;
use App\Support\AdminLayoutData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->with('accessibleJlptLevels:id,name,slug')
            ->orderByDesc('is_admin')
            ->orderBy('name')
            ->get()
            ->map(fn (User $user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
                'is_approved' => $user->is_approved,
                'levels' => $user->accessibleJlptLevels->map(fn ($level) => [
                    'name' => $level->name,
                    'slug' => $level->slug,
                ])->values()->all(),
            ])
            ->values()
            ->all();

        return view('vue-page', [
            'title' => 'Manage Users',
            'pageComponent' => 'admin-users',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'users' => $users,
                'routes' => [
                    'create' => route('admin.users.create'),
                    'editBase' => route('admin.users.index'),
                    'approvals' => route('admin.approvals.index'),
                ],
                'status' => session('status'),
                'layout' => AdminLayoutData::make(
                    'Manage Users',
                    'Create learners, assign JLPT access, approve registrations, and control admin accounts.',
                    'users',
                ),
            ],
        ]);
    }

    public function create()
    {
        return view('vue-page', [
            'title' => 'Create User',
            'pageComponent' => 'admin-user-form',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'errors' => session('errors')?->getBag('default')->toArray() ?? [],
                'levels' => $this->levelOptions(),
                'method' => 'POST',
                'mode' => 'create',
                'routes' => [
                    'action' => route('admin.users.store'),
                    'index' => route('admin.users.index'),
                ],
                'userItem' => [
                    'name' => '',
                    'email' => '',
                    'is_admin' => false,
                    'is_approved' => true,
                    'jlpt_levels' => [],
                ],
                'layout' => AdminLayoutData::make(
                    'Create User',
                    'Add a learner or administrator and configure approval and JLPT access.',
                    'users',
                ),
            ],
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $isAdmin = (bool) ($data['is_admin'] ?? false);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'is_admin' => $isAdmin,
            'is_approved' => $isAdmin || (bool) ($data['is_approved'] ?? false),
        ]);

        $user->accessibleJlptLevels()->sync($user->is_admin ? [] : ($data['jlpt_levels'] ?? []));

        return redirect()->route('admin.users.index')->with('status', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $user->load('accessibleJlptLevels:id');

        return view('vue-page', [
            'title' => 'Edit User',
            'pageComponent' => 'admin-user-form',
            'pageProps' => [
                'csrfToken' => csrf_token(),
                'errors' => session('errors')?->getBag('default')->toArray() ?? [],
                'levels' => $this->levelOptions(),
                'method' => 'PUT',
                'mode' => 'edit',
                'routes' => [
                    'action' => route('admin.users.update', $user),
                    'index' => route('admin.users.index'),
                ],
                'userItem' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_admin' => $user->is_admin,
                    'is_approved' => $user->is_approved,
                    'jlpt_levels' => $user->accessibleJlptLevels->pluck('id')->all(),
                ],
                'layout' => AdminLayoutData::make(
                    'Edit User',
                    'Update learner details, approval status, and JLPT access permissions.',
                    'users',
                ),
            ],
        ]);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        $isAdmin = (bool) ($data['is_admin'] ?? false);

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'is_admin' => $isAdmin,
            'is_approved' => $isAdmin || (bool) ($data['is_approved'] ?? false),
        ]);

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();
        $user->accessibleJlptLevels()->sync($user->is_admin ? [] : ($data['jlpt_levels'] ?? []));

        return redirect()->route('admin.users.index')->with('status', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('status', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User deleted successfully.');
    }

    private function levelOptions(): array
    {
        return JlptLevel::query()
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug'])
            ->map(fn ($level) => [
                'id' => $level->id,
                'name' => $level->name,
                'slug' => $level->slug,
            ])
            ->values()
            ->all();
    }
}
