<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\MasterController;

class RoleController extends MasterController
{
    public function listRoles(Request $request)
    {
    	$roles = Role::whereNull('deleted_at')->select('id', 'name', 'display_name')->orderBy('id', 'desc')->get();
    	return $this->sendResponse(true, $roles, [], 200);
    }
}
