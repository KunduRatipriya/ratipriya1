<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showRegister()
    {
        return view('admin.auth.register');
    }
    public function showLogin()
    {
        return view('admin.auth.login');
    }
    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|min:3|max:20|regex:/^[a-zA-ZÑñ\s]+$/',
            'username' => 'required|min:3|max:20|unique:admins',
            'email' => 'required |email|unique:admins|regex:/([\w\-]+\@[\w\-]+\.[\w\-]+)/',
            'password' => 'required|min:8',
        ],
        [
            'fullname.required' => 'Full Name must be required',
            'fullname.min' => 'Full Name must be at least 3 charecters',
            'fullname.max' => 'Full Name must be maximum 20 charecters',
            'fullname.regex' => 'Only Alphabates are allowed',
            'username.required' => 'Admin Name must be required',
            'username.min' => 'Admin Name must be at least 3 charecters',
            'username.max' => 'Admin Name must be maximum 20 charecters',
            'username.unique' => 'Admin Name already exists',
            'email.required' => 'Email must be required',
            'email.unique' => 'Email already exists',
            'email.regex' => 'Email format is not valid',
            'password.required' => 'Password must be required',
            'password.min' => 'Minimum 6 Charecters',
        ]);
            $admin = new Admin;
            $admin ->fullname = $request ->fullname;
            $admin ->username = $request ->username;
            $admin ->email = $request ->email;
            $admin ->password = Hash::make($request->password);
            $res = $admin->save();
            if($res){
                return response()->json([
                    'status' => 201,
                    'message' => "Candidate registered successfully"
                ], 201);
            }
            else{
                return response()->json([
                    'status' => 401,
                    'message' => "Candidate not registered"
                ], 401);
            }
    }
    public function storeLogin(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ],
        [
            'email.required' => 'Email must be required',
            'password.required' => 'Password must be required',
        ]);
        $admin = Admin::where('email','=',$request->email)->first();
        if($admin){
            if(Hash::check($request->password, $admin->password)){
                $request->session()->put('loginEmail', $admin->id);
                //$request->session(['loginEmail'=>$admin->id]);
                return response()->json([
                    'status' => 201,
                    'message' => "Login successful"
                ], 201);
            }
            else{
                return response()->json([
                    'status' => 401,
                    'message' => "Login not successful"
                ], 401);
            }
        }
        else{
            return response()->json([
                'status' => 501,
                'message' => "Not Registered"
            ], 501);
        }

    }
    //Show User
    public function showUser() {
        return view('admin.users',
    [
        'users'=>User::paginate(10)
    ]);
        if($users) {
            return response()->json([
                'status' => 201,
                'message' => "User Fetched"
            ], 201);
        }else {
            return response()->json([
                'status' => 401,
                'message' => "User not Fetched"
            ], 401);
        }
    }
    //Add User
    public function addUser(Request $request) {
        $request->validate([
            'fullname' => 'required|min:3|max:20|regex:/^[a-zA-ZÑñ\s]+$/',
            'username' => 'required|min:3|max:20|unique:users',
            'email' => 'required |email|unique:users|regex:/([\w\-]+\@[\w\-]+\.[\w\-]+)/',
            'password' => 'required|min:8',
        ],
        [
            'fullname.required' => 'Full Name must be required',
            'fullname.min' => 'Full Name must be at least 3 charecters',
            'fullname.max' => 'Full Name must be maximum 20 charecters',
            'fullname.regex' => 'Only Alphabates are allowed',
            'username.required' => 'User Name must be required',
            'username.min' => 'User Name must be at least 3 charecters',
            'username.max' => 'User Name must be maximum 20 charecters',
            'username.unique' => 'User Name already exists',
            'email.required' => 'Email must be required',
            'email.unique' => 'Email already exists',
            'email.regex' => 'Email format is not valid',
            'password.required' => 'Password must be required',
            'password.min' => 'Minimum 6 Charecters',
        ]);
        $user = new User;
            $user ->fullname = $request ->fullname;
            $user ->username = $request ->username;
            $user ->email = $request ->email;
            $user ->password = Hash::make($request->password);
            $res = $user->save();
            if($res) {
                return response()->json([
                    'status' => 201,
                    'message' => "User added successfully"
                ], 201);
            }else {
                return response()->json([
                    'status' => 401,
                    'message' => "Used not added"
                ], 401);
            }
    }
    //Delete User
    public function deleteUser(Request $request) {
        $id=$request->id;
        $deleteUser=User::where('id',$id)->delete();
        if($deleteUser) {
            return back();
            // return response()->json([
            //     'status' => 201,
            //     'message' => "User deleted successfully"
            // ], 201);
        }else {
            return response()->json([
                'status' => 401,
                'message' => "User delete unsuccessfully"
            ], 401);
        }
    }
    //Update User
    public function updateUser(Request $request) {
        $request->validate([
            'fullname' => 'required|min:3|max:20|regex:/^[a-zA-ZÑñ\s]+$/',
            'username' => 'required|min:3|max:20|unique:users',
            'email' => 'required |email|unique:users|regex:/([\w\-]+\@[\w\-]+\.[\w\-]+)/',
            'password' => 'required|min:8',
        ],
        [
            'fullname.required' => 'Full Name must be required',
            'fullname.min' => 'Full Name must be at least 3 charecters',
            'fullname.max' => 'Full Name must be maximum 20 charecters',
            'fullname.regex' => 'Only Alphabates are allowed',
            'username.required' => 'User Name must be required',
            'username.min' => 'User Name must be at least 3 charecters',
            'username.max' => 'User Name must be maximum 20 charecters',
            'username.unique' => 'User Name already exists',
            'email.required' => 'Email must be required',
            'email.unique' => 'Email already exists',
            'email.regex' => 'Email format is not valid',
            'password.required' => 'Password must be required',
            'password.min' => 'Minimum 6 Charecters',
        ]);
        $userUpdate=User::where('id',$request->id)
                          ->update(
                              [
                                  'fullname'=>$request->fullname,
                                  'username'=>$request->username,
                                  'email'=>$request->email,
                                  'password'=>$request->password

                              ]
                          );
        if($userUpdate) {
            return response()->json([
                'status' => 201,
                'message' => "User Updated Successfully"
            ], 201);
        }else {
            return response()->json([
                'status' => 201,
                'message' => "User Not Updated"
            ], 201);
        }
    }
    
}
