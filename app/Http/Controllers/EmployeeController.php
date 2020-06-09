<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Table;


class EmployeeController extends BaseController
{
    public function data(){
        $employee=DB::table('employee')
                    ->leftJoin('department','employee.dept_id','=','department.id')
                    ->select('employee.id','employee.name as emp_name','employee.gender','employee.email','employee.dept_id','department.name as dept_name')
                    ->orderBy('employee.id','desc')
                    ->paginate(5);
        return $this->sendResponse($employee);
    }

    public function save(Request $request){

        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'gender'=>'required',
            'email'=>'required|email',
            'dept_id'=>'required',
        ],[
            'name.required'=>'帳號必填',
            'gender.required'=>'性別必填',
            'email.required'=>'email必填',
            'email.email'=>'email格式錯誤',
            'dept_id.required'=>'部門必填',
        ]);

        if($validator->fails()){
            return $this->sendError( $validator->errors());
        }

        $employee=DB::Table('employee')
                    ->insert([
                        'name'=>$request['name'],
                        'gender'=>$request['gender'],
                        'email'=>$request['email'],
                        'dept_id'=>$request['dept_id']
                    ]);
        return $this->sendResponse($employee);
    }

    public function getEmp($id){
        $employee=DB::table('employee')->select('id','name','email','gender','dept_id')
                        ->where('id',$id)->get();
        return $this->sendResponse($employee);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'gender'=>'required',
            'email'=>'required|email',
            'dept_id'=>'required',
        ],[
            'name.required'=>'帳號必填',
            'gender.required'=>'性別必填',
            'email.required'=>'email必填',
            'email.email'=>'email格式錯誤',
            'dept_id.required'=>'部門必填',
        ]);

        if($validator->fails()){
            return $this->sendError( $validator->errors());
        }

        $employee=DB::Table('employee')
                    ->where('id',$request['id'])
                    ->update([
                        'name'=>$request['name'],
                        'gender'=>$request['gender'],
                        'email'=>$request['email'],
                        'dept_id'=>$request['dept_id']
                    ]);

        return $this->sendResponse($employee);
    }


    public function delete($id){
        $ids = explode(",", $id);
        $employee=DB::table('employee')->whereIn('id',$ids)->delete();
        return $this->sendResponse($employee);
    }


}
