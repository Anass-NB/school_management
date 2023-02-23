<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherRequest;
use App\Models\Gender;
use App\Models\Specialization;
use App\Models\Teacher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
  public function testApi(){
    $teachers = Teacher::findOrFail(1)->get();
    return response()->json($teachers);
  }


  public function index()
  {
    return view("pages.Teachers.Teachers")->with([
      "Teachers" =>  Teacher::all(),
    ]);
  }


  public function create()
  {
    $specializations = Specialization::all();
    $genders = Gender::all();
    return view('pages.Teachers.create',compact('specializations','genders'));
  }


  public function store(StoreTeacherRequest $request)
  {

    try {
      $Teachers = new Teacher();
      $Teachers->Email = $request->Email;
      $Teachers->Password =  Hash::make($request->Password);
      $Teachers->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
      $Teachers->Specialization_id = $request->Specialization_id;
      $Teachers->Gender_id = $request->Gender_id;
      $Teachers->Joining_Date = $request->Joining_Date;
      $Teachers->Address = $request->Address;
      $Teachers->save();
      toastr()->success(trans('messages.success'));
      return redirect()->route('teachers');
  }
  catch (Exception $e) {
      return redirect()->back()->with(['error' => $e->getMessage()]);
  }
  }


  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $teacher = Teacher::findOrFail($id);
    return $teacher->Sections()->get();
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    Teacher::findOrFail($request->id)->delete();
    toastr()->error(trans('messages.Delete'));

    return redirect()->route('teachers');
  }
}
