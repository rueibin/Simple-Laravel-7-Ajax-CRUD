<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends BaseController
{
    public function data(){
        $dept=DB::table('department')->select('id','name')->get();
        return $this->sendResponse($dept);
    }
}
