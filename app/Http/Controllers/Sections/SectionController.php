<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSectionRequest;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SectionController extends Controller
{

  public function index()
  {
    $Grades = Grade::with(['Sections'])->get();
    $list_Grades = Grade::all();
    $teachers = Teacher::all();
    return view("pages.Sections.allsections", compact("list_Grades", "Grades","teachers"));
  }


  public function create()
  {
    //
  }


  public function store(StoreSectionRequest $request)
  {
    try {
      $validated = $request->validated();
      $section = new Section();
      $section->Name_section =[ "ar" => $request->Name_Section_Ar,"en" => $request->Name_Section_En];
      $section->Status = 1;
      $section->Grade_id = $request->Grade_id;
      $section->Class_id = $request->Class_id;
      $section->save();
      $section->teachers()->attach($request->teacher_id);
      toastr()->success(trans("messages.success"));   
      return redirect()->route('all-sections');
    } catch (\Exception $ex) {  
      return redirect()->back()->withErrors(["error" => $ex->getMessage()]);
      
    }
  }
  public function get_class($id)
  {
    $classes = Classroom::where("Grade_id",  $id)->pluck("Name_Class", "id");
    return $classes;
  }


  public function show()
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\cr  $cr
   * @return \Illuminate\Http\Response
   */
  public function edit()
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\cr  $cr
   * @return \Illuminate\Http\Response
   */
  public function update(StoreSectionRequest $request)
  {
    $request->validated();
    $section = Section::findOrFail($request->id);
    $section->Name_section  = ["ar"=> $request->Name_Section_Ar , "en"=>$request->Name_Section_En];
    $section->Grade_id = $request->Grade_id;
    $section->Class_id = $request->Class_id;

    if(isset($request->Status)) {
      $section->Status = 1;
    } else {
      $section->Status = 2;
    }


    
    $section->save();
    toastr()->success(trans('messages.Update'));

    return redirect()->route("all-sections");

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\cr  $cr
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $section = Section::findOrFail($request->id);
    $section->delete();
    
    toastr()->error(trans('messages.Delete'));

    return redirect()->route("all-sections");
  }
}
