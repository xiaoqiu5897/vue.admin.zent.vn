<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MasterController extends Controller
{
    /**
     * response method.
     * 
     * success  true|false
     * data 
     * errors
     * 
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($success, $data, $errors = [], $code = 404)
    {
    	return response()->json([
    				'success' => $success, 
    				'data'=> $data, 
    				'errors' => $errors
    			], $code);
    }
}
