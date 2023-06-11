<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LecturerController extends Controller
{
    public function lecturerIndex(){
        return view('lecturer.lecturer_login');
    } // end mehtod


    public function LecturerDashboard(){
        return view('lecturer.index');
    }// end mehtod


    public function LecturerLogin(Request $request){
        // dd($request->all());

        $check = $request->all();
        if(Auth::guard('lecturer')->attempt(['email' => $check['email'], 'password' => $check['password']  ])){
            return redirect()->route('lecturer.dashboard')->with('error','Lecturer Login Successfully');
        }else{
            return back()->with('error','Invalid Email Or Password');
        }

    } // end mehtod


    public function LecturerLogout(){

        Auth::guard('lecturer')->logout();
        return redirect()->route('lecturer_login_from')->with('error','Lecturer Logout Successfully');

    } // end mehtod


    public function LecturerRegister(){

        return view('lecturer.lecturer_register');

    } // end mehtod


    public function LecturerRegisterCreate(Request $request){

        // dd($request->all());

        Lecturer::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'position' => $request->position,
            'created_at' => Carbon::now(),

        ]);

         return redirect()->route('lecturer_login_from')->with('error','Lecturer Created Successfully');

    } // end mehtod

}
