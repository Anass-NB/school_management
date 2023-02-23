<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Models\Classroom;
use App\Models\Image;
use App\Models\Section;
use App\Models\Student;
use App\Repository\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;

class StudentController extends Controller
{
  protected StudentRepositoryInterface $student;

  public function __construct(StudentRepositoryInterface $student)
  {
    $this->student = $student;
  }

  public function index()
  {
    return $this->student->getAllStudents();
  }


  public function create()
  {
    return $this->student->createStudent();
  }


  public function store(Request $request)
  {
    return $this->student->storeStudent($request);
  }

  public function show($id)
  {
    return $this->student->showStudent($id);
  }


  public function edit($id)
  {
    return $this->student->editStudent($id);
  }

  public function update(StoreStudentRequest $request)
  {
    return $this->student->updateStudent($request);
  }

  public function destroy(Request $request)
  {
    return $this->student->deleteStudent($request);
  }

  public function getClasses($id)
  {
    return Classroom::where("Grade_id", $id)->pluck("Name_Class", "id");
  }

  public function getSection($id)
  {
    return Section::where("Class_id", $id)->pluck("Name_section", "id");
  }

  public function uploadAttachment(Request $request)
  {
    return $this->student->uploadNewAttachment($request);
  }


  public function downloadAttachment($student, $file)
  {
    try {
      return response()->download(public_path("attachments/students/" . $student . "/" . $file));
    } catch (\Throwable $th) {

      return redirect()->route("students.index")->withErrors(["errors" => $th->getMessage()]);
    }
  }


  public function deleteAttachment(Request $request)
  {
    unlink("attachments/students/" . $request->student_name . "/" . $request->attachment_name);
    Image::where("id",$request->attachment_id)->delete();
    toastr()->error(trans('messages.Delete'));
    return redirect()->back();
  }
}
