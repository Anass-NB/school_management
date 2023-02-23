<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{

  public function index()
  {
    $subjects = Subject::get();
    return view('pages.subjects.index', compact('subjects'));
  }


  public function create()
  {
    $grades = Grade::get();
    $teachers = Teacher::get();
    return view('pages.subjects.create', compact('grades', 'teachers'));
  }


  public function store(Request $request)
  {
    // $subject = new Subject();
    // $subject->name = [
    //   "en" => $request->Name_en,
    //   "ar" => $request->Name_ar
    // ];
    // $subject->grade_id = $request->Grade_id;
    // $subject->classroom_id = $request->Class_id;
    // $subject->teacher_id = $request->teacher_id;
    // $subject->save();

    try {
      DB::table("subjects")->insert([
        "name" => ["en" => $request->Name_en, "ar" => $request->Name_ar],
        "grade_id" => $request->Grade_id,
        "classroom_id" => $request->Class_id,
        "teacher_id" => $request->teacher_id
      ]);
      toastr()->success(trans('messages.success'));
      return redirect()->route('subjects.index');
    } catch (\Exception $e) {
      return redirect()->back()->with(['error' => $e->getMessage()]);
    }
  }


  public function show(Subject $subject)
  {
    //
  }


  public function edit($id)
  {
    $subject = Subject::findorfail($id);
    $grades = Grade::get();
    $teachers = Teacher::get();
    return view('pages.subjects.edit', compact('subject', 'grades', 'teachers'));
  }

  public function update(Request $request, Subject $subject)
  {
    try {
      $subjects =  Subject::findorfail($request->id);
      $subjects->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
      $subjects->grade_id = $request->Grade_id;
      $subjects->classroom_id = $request->Class_id;
      $subjects->teacher_id = $request->teacher_id;
      $subjects->save();
      toastr()->success(trans('messages.Update'));
      return redirect()->route('subjects.index');
    } catch (\Exception $e) {
      return redirect()->back()->with(['error' => $e->getMessage()]);
    }
  }


  public function destroy(Request $request)
  {
    try {
      Subject::destroy($request->id);
      toastr()->error(trans('messages.Delete'));
      return redirect()->back();
    } catch (\Exception $e) {
      return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
  }
}
