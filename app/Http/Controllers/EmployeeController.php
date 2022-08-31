<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;

class EmployeeController extends Controller
{
    
	public function index(){
		return view('employee.index');
	}

	public function store(Request $request){
		// dd($request->all());

		$validator = Validator::make($request->all(), [
			'name' => 'required|max:191',
			'phone' => 'required|max:191',
			'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
		]);

		if($validator->fails()){
			return response()->json([
				'status' => 400,
				'errors' => $validator->messages(),
			]);
		}
		else{
			Employee::addEmployee($request);
			return response()->json([
				'status'  => 200,
				'message' => 'Employee added successfully!!',
			]);
		}
	}

	public function showEmployee(){
		$employee = Employee::latest()->get();
		return response()->json([
			'employee' => $employee,
		]);
	}

	public function editEmployee($id){
		$employee = Employee::find($id);
		if($employee){
			return response()->json([
				'status'	=> 200,
				'employee' 	=> $employee,
			]);
		}
		else{
			return response()->json([
				'status'	=> 400,
				'message' 	=> 'Employee Not Found!!',
			]);
		}
	}

	public function updateEmployee(Request $request){
		// dd($request->all());

		$validator = Validator::make($request->all(), [
			'name' => 'required|max:191',
			'phone' => 'required|max:191',
			// 'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
		]);

		if($validator->fails()){
			return response()->json([
				'status' => 400,
				'errors' => $validator->messages(),
			]);
		}
		else{
			Employee::updateEmployeeData($request);
			return response()->json([
				'status'  => 200,
				'message' => 'Employee updated successfully!!',
			]);
		}
	}

	public function deleteEmployee($id){
		$employee = Employee::find($id);
		if($employee){
			if(file_exists($employee->image)){
				unlink($employee->image);
			}
			$employee->delete();

			return response()->json([
				'status' => 200,  
				'message' => 'Employee deleted successfully!!',  
			]);
		}
		else{
			return response()->json([
				'status' => 400,  
				'message' => 'Employee not found!!',  
			]);
		}
	}

}
