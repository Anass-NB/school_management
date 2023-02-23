<?php

namespace App\Repository;

use App\Models\Blood;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\Image;
use App\Models\MyParent;
use App\Models\Nationality;
use App\Models\Student;
use App\Repository\Interfaces\StudentRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class StudentRepository implements StudentRepositoryInterface
{

  function createStudent()
  {
    $data['my_classes'] = Grade::all();
    $data['parents'] = MyParent::all();
    $data['Genders'] = Gender::all();
    $data['nationals'] = Nationality::all();
    $data['bloods'] = Blood::all();
    return view("pages.Students.create", $data);
  }


  function storeStudent($request)
  {
    try {
      $students = new Student();
      $students->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
      $students->email = $request->email;
      $students->password = Hash::make($request->password);
      $students->gender_id = $request->gender_id;
      $students->nationalitie_id = $request->nationalitie_id;
      $students->blood_id = $request->blood_id;
      $students->Date_Birth = $request->Date_Birth;
      $students->Grade_id = $request->Grade_id;
      $students->Classroom_id = $request->Classroom_id;
      $students->section_id = $request->section_id;
      $students->parent_id = $request->parent_id;
      $students->academic_year = $request->academic_year;
      $students->save();

      if($request->hasfile('photos'))
      {
          foreach($request->file('photos') as $file)
          {
              $name = $file->getClientOriginalName();
              $file->storeAs('attachments/students/'.$students->name, $file->getClientOriginalName(),'upload_attachments');

              // insert in image_table
              $images= new Image();
              $images->filename=$name;
              $images->imageable_id= $students->id;
              $images->imageable_type = 'App\Models\Student';
              $images->save();
          }
      }
      toastr()->success(trans('messages.success'));
      return redirect()->route('students.index');
    } catch (\Exception $e) {
      return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
  }


  public function getAllStudents(){
    return view("pages.Students.index")->with([
      "students" => Student::all(),
    ]);
  }
  public function showStudent($id){
    return view("pages.Students.show")->with([
      "Student" => Student::findOrFail($id),
    ]);
  }
  public function editStudent($id){
    $data['Grades'] = Grade::all();
    $data['parents'] = MyParent::all();
    $data['Genders'] = Gender::all();
    $data['nationals'] = Nationality::all();
    $data['bloods'] = Blood::all();
    $Students =  Student::findOrFail($id);
    return view('pages.Students.edit',$data,compact('Students'));
  }


  public function updateStudent($request)
  {
    
    try {
      $Edit_Students = Student::findorfail($request->id);
      $Edit_Students->name = ['ar' => $request->name_ar, 'en' => $request->name_en];
      $Edit_Students->email = $request->email;
      $Edit_Students->password = Hash::make($request->password);
      $Edit_Students->gender_id = $request->gender_id;
      $Edit_Students->nationalitie_id = $request->nationalitie_id;
      $Edit_Students->blood_id = $request->blood_id;
      $Edit_Students->Date_Birth = $request->Date_Birth;
      $Edit_Students->Grade_id = $request->Grade_id;
      $Edit_Students->Classroom_id = $request->Classroom_id;
      $Edit_Students->section_id = $request->section_id;
      $Edit_Students->parent_id = $request->parent_id;
      $Edit_Students->academic_year = $request->academic_year;
      $Edit_Students->save();
      toastr()->success(trans('messages.Update'));
      return redirect()->route('students.index');
  } catch (\Exception $e) {
      return redirect()->back()->withErrors(['error' => $e->getMessage()]);
  }
  }



  public function deleteStudent($request)
  {
    $student = Student::findOrFail($request->id);
    $student->images()->delete();
    $student->delete();
    toastr()->error(trans('messages.Delete'));
    return route("students.index");
  }
  

  
  public function uploadNewAttachment($request)
  {


    if($request->hasFile("photos")){
      foreach($request->file("photos") as $file){
        $name_of_file = $file->getClientOriginalName();
        $file->storeAs('attachments/students/'. $request->student_name,$file->getClientOriginalName(),"upload_attachments");

        $image = new Image();
        $image->filename = $name_of_file;
        $image->imageable_id = $request->student_id;
        $image->imageable_type = "App\Models\Student";
        $image->save();


      }
      toastr()->success(trans('messages.success'));
      return redirect()->route('students.show',$request->student_id);
      




    }  
  }
  




}
