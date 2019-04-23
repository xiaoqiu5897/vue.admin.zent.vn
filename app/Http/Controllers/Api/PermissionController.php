<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\MasterController;

class PermissionController extends MasterController
{
    public function listPermissions()
    {
    	$roles = Permission::select('id', 'name', 'display_name')->orderBy('id', 'desc')->get();
    	return $this->sendResponse(true, $roles, [], 200);
    }
}
