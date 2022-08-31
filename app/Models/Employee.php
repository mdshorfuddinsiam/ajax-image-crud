<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
    	'name', 'phone', 'image'
    ];

    protected static $file;
    protected static $imageName;
    protected static $directory;
    protected static $data = [];
    protected static $employee;

    public static function saveImage($request){
    	if($request->hasFile('image')){
    		self::$file 	 = $request->file('image');
    		self::$imageName = 'employee'.time().'.'.self::$file->getClientOriginalExtension();
    		self::$directory = 'employee-images/';
    		self::$file->move(self::$directory, self::$imageName);
    		self::$data['image'] = self::$directory.self::$imageName;
    		return self::$data;
    	}
    	else{
    		self::$data['image'] = '';
    		return self::$data;
    	}
    }

    public static function updateImage($request){
    	if($request->hasFile('image')){
    		if(file_exists(self::$employee->image)){
    			unlink(self::$employee->image);
    		}
    		self::$file 	 = $request->file('image');
    		self::$imageName = 'employee'.time().'.'.self::$file->getClientOriginalExtension();
    		self::$directory = 'employee-images/';
    		self::$file->move(self::$directory, self::$imageName);
    		self::$data['image'] = self::$directory.self::$imageName;
    		return self::$data;
    	}
    	else{
    		self::$data['image'] = self::$employee->image;
    		return self::$data;
    	}
    }

    public static function addEmployee($request){
    	Employee::create(array_merge($request->all(), self::saveImage($request)));
    }

    public static function updateEmployeeData($request){
    	// dd($request->all());
    	// dd($request);

    	self::$employee = Employee::find($request->id);
    	self::$employee->update(array_merge($request->all(), self::updateImage($request)));
    }

}
