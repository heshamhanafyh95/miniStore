<?php

namespace App\Services\role;

use App\Http\Requests\role\StoreRolePostRequest;
use App\Models\Role;


class RoleService
{
    public function Create(StoreRolePostRequest $request)
    {
        $data = $request->all();
        $data['permissionsJson'] = json_encode($data['permissionsJson']);
        $role = Role::create($data);
        return $role;
    }
}
