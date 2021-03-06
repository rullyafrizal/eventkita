<?php

namespace App\Actions\Role;

use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\Permission\Models\Permission;

class ListPermission
{
    use AsAction;

    public function handle(): array
    {
        return [
            'allPermissions' => Permission::query()
                ->whereNotIn('name', config('permission-list.full_access_permission'))
                ->get('name'),
            'fullAccessPermission' => Permission::query()
                ->whereIn('name', config('permission-list.full_access_permission'))
                ->get('name'),
            'dashboardPermissions' => Permission::query()
                ->whereIn('name', config('permission-list.dashboard_permissions'))
                ->get('name'),
            'rolePermissions' => Permission::query()
                ->whereIn('name', config('permission-list.role_permissions'))
                ->get('name'),
            'userPermissions' => Permission::query()
                ->whereIn('name', config('permission-list.user_permissions'))
                ->get('name'),
            'eventTypePermissions' => Permission::query()
                ->whereIn('name', config('permission-list.event_type_permissions'))
                ->get('name'),
            'articlePermissions' => Permission::query()
                ->whereIn('name', config('permission-list.article_permissions'))
                ->get('name'),
            'eventPermissions' => Permission::query()
                ->whereIn('name', config('permission-list.event_permissions'))
                ->get('name'),
            'eventPicturePermissions' => Permission::query()
                ->whereIn('name', config('permission-list.event_picture_permissions'))
                ->get('name'),
            'participationPermissions' => Permission::query()
                ->whereIn('name', config('permission-list.participation_permissions'))
                ->get('name'),
        ];
    }
}
