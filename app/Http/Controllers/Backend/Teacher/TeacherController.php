<?php

namespace App\Http\Controllers\Backend\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Mark;
use App\Models\Session;
use App\Models\Class_model;
use App\Models\Section;
use App\Models\Auth\Registration;
use App\Models\Active_student;

class teacherController extends Controller
{

    public function teacher(){
        return view('Backend.Teacher.teacherDashboard');
    }
        public function tprofile(){
        return view('Backend.Teacher.profile');
    }

        public function profileUpdate(Request $request){
    $pros = Registration::where('email', session('email'))->first();;

        return view('Backend.Teacher.profileUpdate')->with('pros', $pros);;
    }

    public function profileUpdateSubmitted(Request $request){
        $teacher = Teacher::where('registration_id', $request->registration_id)->first(); 
        $teacher->name = $request->name;
        $teacher->phone = $request->phone;
        $teacher->save();
        $request->session()->put('name',$teacher->name);
        $request->session()->put('phone',$teacher->phone);
        return redirect()->route('tprofile');

    }

       public function changePicture(){
        return view('Backend.Teacher.changePicture');
    }
    public function changePictureSubmit(Request $request){
        $file_name = $request->file('picture')->getClientOriginalName();
        //$f_name = $file_name.'.'.$req->file('pro_pic')->getClientOriginalExtension();
        $folder = $request->file('picture')->move(public_path('timage').'/',$file_name);
        
        $value = session()->get('registration_id');
        $admin = Teacher::where('registration_id', $value)
        ->first();
        $admin->picture = $file_name;
        $admin->save();
        $request->session()->put('picture', $file_name);




        //$request->session()->flash('change_picture', 'Profile picture uploaded successfully');

        return redirect()->route('profileUpdate');

    }

        public function uploadmarks(){
        $var = Session::all();
       $v = Subject::all();
       $f=Class_model::all();
       $r=Subject::all();
        return view('Backend.Teacher.upload_marks')->with('ss', $var)->with('v', $v)->with('d',$f)->with('r',$r)->with('data','empty');
    }

          public function filterStudent(Request $request){
         $marks = Active_student::where('class_model_id',$request->class)->where('session_id',$request->session)->get();
        if($marks->count()>0)
        {
            return view('Backend.Teacher.studentMarks')->with('marks',$marks);
            
        }
        else
        {
           return'<h3 class="text-center">Wrong Information Found...</h3>';
        }
      
       
  } 
}
