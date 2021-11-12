<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use Throwable;

class UserController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('permission:view-users');
    }

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('view-users', User::class);

        $filters = $request->only(['search', 'trashed', 'role']);

        return Inertia::render('Users/Index', [
            'filters' => $filters,
            'users' => new UserCollection(
                User::query()
                    ->with(['roles'])
                    ->orderBy('name')
                    ->filter($filters)
                    ->paginate()
            ),
            'roles' => Role::all('name')->pluck('name')
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('create-user', User::class);

        return Inertia::render('Users/Create', [
            'roles' => Role::all('name')->pluck('name', 'name'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $user = User::query()
                ->create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                    'phone' => $request->input('phone')
                ]);

            $user->syncRoles($request->role);
        });

        return Redirect::route('users.index')
            ->with('success', 'User created.');
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(User $user): Response
    {
        $this->authorize('edit-user', User::class);

        return Inertia::render('Users/Edit', [
            'user' => new UserResource($user->load(['roles'])),
            'roles' => Role::all('name')->pluck('name'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        DB::transaction(function() use ($request, $user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ?? $user->password,
                'phone' => $request->phone,
            ]);

            $user->syncRoles($request->role);
        });

        return Redirect::route('users.edit', $user->id)
            ->with('success', 'User updated');
    }

    /**
     * @throws Throwable
     * @throws AuthorizationException
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete-user', $user);

        DB::transaction(function () use ($user) {
            $user->delete();
        });

        return redirect()
            ->route('users.index')
            ->with('success', 'User has been deleted.');
    }

    /**
     * @throws AuthorizationException
     */
    public function restore(User $user): RedirectResponse
    {
        $this->authorize('restore-user', $user);

        $user->restore();

        return redirect()
            ->route('users.index')
            ->with('success', 'User has been restored.');
    }
}
