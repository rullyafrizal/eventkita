<?php

namespace App\Http\Controllers;

use App\Actions\Role\ListPermission;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\Role\RoleCollection;
use App\Http\Resources\Role\RoleResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view-roles');
    }

    public function index(Request $request)
    {
        $this->authorize('view-roles', Role::class);

        return Inertia::render('Roles/Index', [
            'filters' => $request->only('search'),
            'roles' => new RoleCollection(
                Role::with('permissions')
                    ->when($request->search, function (Builder $query) use ($request) {
                        return $query->where('name', 'like', "%{$request->search}%");
                    })
                    ->orderByDesc('id')
                    ->paginate()
            )
        ]);
    }

    public function create()
    {
        $this->authorize('create-role', Role::class);

        return Inertia::render('Roles/Create', ListPermission::run());
    }

    public function store(StoreRoleRequest $request)
    {
        DB::transaction(function () use ($request) {
            $role = Role::create($request->only('name'));

            $role->syncPermissions($request->permissions);
        });

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role has been created.');
    }

    public function edit(Role $role)
    {
        $this->authorize('edit-role', Role::class);

        $role = ['role' => new RoleResource($role)];
        $listPermissions = array_merge($role, ListPermission::run());

        return Inertia::render('Roles/Edit', $listPermissions);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        DB::transaction(function () use ($request, $role) {
            $role->update($request->only('name', 'guard_name'));

            $role->syncPermissions($request->permissions);
        });

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role has been updated.');
    }

    public function destroy(Role $role)
    {
        $this->authorize('delete-role', Role::class);

        DB::transaction(function () use ($role) {
            $role->permissions()->detach();

            $role->delete();
        });

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role has been updated.');
    }
}
