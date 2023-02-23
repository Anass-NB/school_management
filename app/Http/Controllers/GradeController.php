<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGradesRequest;
use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class GradeController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $grades = Grade::all();
    return view("pages.Grades.allgrades", compact("grades"));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(StoreGradesRequest  $request)
  {
    if(Grade::where("Name->en","=",$request->Name_en)->orWhere("Name->ar","=",$request->Name)->exists()){
      return redirect()->back()->withErrors(["This grade already exists!"]);
    }
    try {
      $validated = $request->validated();
      $grade = new Grade();
      $grade->Name = [
        "en" => $request->Name_en,
        "ar" => $request->Name,
      ];
      $grade->Notes = $request->Notes;
      $grade->save();
      toastr()->success(trans("messages.success"));
      return redirect()->route('grade');
    } catch (\Exception $e) {
      return redirect()->back()->withErrors(["error" => $e->getMessage()]);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(StoreGradesRequest  $request)
  {
    try {
      $validated = $request->validated();
      $grade = Grade::findorFail($request->id);
      $grade->update([
        $grade->Name = ["en" => $request->Name_en, "ar" => $request->Name],
        $grade->Notes = $request->Notes,
      ]);
      toastr()->info(trans("messages.Update"));
      return redirect()->route('grade');
    } catch (\Exception $e) {
      return redirect()->back()->withErrors(["error" => $e->getMessage()]);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy(Request  $request)
  {
    $count_classroom = Classroom::where("Grade_id","=",$request->id)->count();
    if($count_classroom == 0){
      Grade::findorFail($request->id)->delete();
      toastr()->error(trans("messages.Delete"));
      return redirect()->route('grade');
    }
    else{
      toastr()->error("This Grade contains Classrooms");
      return redirect()->route('grade');
    }

    
  }
}
