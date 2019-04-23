<?php

namespace App\Http\Controllers\Api;

use DB;
use Log;
use Hash;
use Exception;
use Carbon\Carbon;
use Validator;
use App\Models\User;
use App\Models\RoleUser;
use App\Models\OptionValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\MasterController;

class UserController extends MasterController
{
	public function listUsers(Request $request)
	{
		$users = User::join('option_values', 'option_values.id', '=', 'users.position_id')
		->whereNull('users.deleted_at')
		->select('users.*', 'option_values.id as option_values_id', 'option_values.value as position')
		->orderBy('users.id', 'desc')
		->get();
		$role_id = [];
		foreach ($users as $value) {
			$value->roles = RoleUser::where('user_id', $value->id)
			->join('roles', 'roles.id', '=', 'role_users.role_id')
			->whereNull('roles.deleted_at')
			->select('role_users.role_id', 'roles.display_name as display_name')
			->orderBy('roles.id', 'desc')
			->get();

			if ($value->type_job == 1) {
				$value->type_job_name = "Full-time";
			} else 
			$value->type_job_name = "Part-time";
		}
		return $this->sendResponse(true, $users, [], 200);
	}

	public function listDepartments()
	{
		$departments = OptionValue::select('id', 'value')->where('option_id', 2)->orderBy('id', 'desc')->get();
		return $this->sendResponse(true, $departments, [], 200);
	}

	public function listPostions()
	{
		$postions = OptionValue::where('option_id', 1)->orderBy('id', 'desc')->get();
		return $this->sendResponse(true, $postions, [], 200);
	}

	public function addUser(Request $request)
	{
		$input = $request->all();

		$validator = Validator::make($input, [
			'email' 		=> 'required|email|unique:users,email',
			'name' 			=> 'required',
			'birthday' 		=> 'required|date',
			'gender' 		=> 'required|numeric',
			'mobile' 		=> 'required|numeric|digits:10',
			'positionid'    => 'numeric',
			'departmentid'  => 'numeric',
			'typejob' 		=> 'numeric',
		]);

		if ($validator->fails()) {
			return $this->sendResponse(false, [], ['message' => $validator->errors()], 422);            
		}

		//$roles = explode(",", $request->roles);

		DB::beginTransaction();
		try {
			$user = User::create([
				'email'  		 => $input['email'],
				'password' 		 => bcrypt('123456'),
				'name'			 => $input['name'],
				'birthday' 		 => $input['birthday'],
				'mobile' 		 => $input['mobile'],
				'position_id'    => $input['positionid'],
				'department_id'  => $input['departmentid'],
				'gender'    	 => $input['gender'],
				'address' 		 => $input['address'],
				'type_job' 		 => $input['typejob'],
			]);

			foreach ($request->roles as $value) {
				if ($value != null) {
					$user_role = RoleUser::create([
						'user_id' => $user->id,
						'role_id' => $value
					]);
				}
			}

			DB::commit();
			return $this->sendResponse(true, ['message' => 'Successfully'], [], 200);
		} catch (Exception $e) {
			Log::info($e->getMessage());

			DB::rollBack();

			return $this->sendResponse(false, [], $e->getMessage() , 500);
		}
	}
	
	public function editUser(Request $request, $id)
	{
		$input = $request->all();

		$validator = Validator::make($input, [
			'email' 		 => 'required|email|unique:users,email,'. $id,
			'name' 			 => 'required',
			'birthday' 		 => 'required|date',
			'gender' 		 => 'required|numeric',
			'mobile' 		 => 'required|numeric|digits:10',
			'role_id' 		 => 'numeric',
			'position_id'    => 'numeric',
			'department_id'  => 'numeric',
			'type_job' 		 => 'numeric',
		]);

		if ($validator->fails()) {
			return $this->sendResponse(false, [], ['message' => $validator->errors()], 422);            
		}

		DB::beginTransaction();
		try {

			$user = User::where('id', $id)
			->whereNull('deleted_at')
			->update([
				'email'          => $input['email'],
				'name'           => $input['name'],
				'birthday'       => $input['birthday'],
				'mobile'         => $input['mobile'],
				'position_id'    => $input['position_id'],
				'department_id'  => $input['department_id'],
				'gender'         => $input['gender'],
				'address'        => $input['address'],
				'type_job'       => $input['type_job'],
			]);

			foreach ($request->roles as $value) {
				RoleUser::firstOrCreate(
					[
						'user_id' => $id,
						'role_id' => $value
					]
				);
			}

			DB::commit();
			return $this->sendResponse(true, ['message' => 'Successfully'], [], 200);
		} catch (Exception $e) {
			Log::info($e->getMessage());

			DB::rollBack();

			return $this->sendResponse(false, [], $e->getMessage() , 500);
		}
	}

















}
