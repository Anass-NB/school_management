<?php

namespace App\Http\Controllers\Classrooms;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassRequest;
use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class ClassroomController extends Controller
{

  public function index()
  {
    $My_Classes = Classroom::all();
    $Grades = Grade::all();
    return view("pages.Classrooms.allclassrooms", compact("My_Classes", "Grades"));
  }

  public function create()
  {
    //
  }


  public function st(Request $request){
    return $request;
  }


  public function store(StoreClassRequest $request)
  {
    // $classes_list =  $request->List_Classes;
    // try {
    //   foreach ($classes_list as $class_list) {
    //     $class = new Classroom();
    //     $class->Name_class = [
    //       "ar" => $class_list["Name"],
    //       "en" => $class_list["Name_class_en"],
    //     ];
    //     $class->Grade_id = $class_list["Grade_id"];
    //     $class->save();
    //   }

    //   toastr()->success(trans("messages.success"));
    //   return redirect()->route('classrooms');
    // } catch (\Exception $e) {
    //   return redirect()->back()->withErrors(["error" => $e->getMessage()]);
    // }


    $List_Classes = $request->List_Classes;

    try {
      $validated = $request->validated();
      foreach ($List_Classes as $List_Class) {

        $My_Classes = new Classroom();

        $My_Classes->Name_Class = ['en' => $List_Class['Name_class_en'], 'ar' => $List_Class['Name']];

        $My_Classes->Grade_id = $List_Class['Grade_id'];

        $My_Classes->save();
      }

      toastr()->success(trans('messages.success'));
      return redirect()->route('classrooms');
    } catch (\Exception $e) {
      return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
  }


  public function show(Classroom $classroom)
  {
    //
  }

  public function edit(Request $request)
  {
    return $request;
  }


  public function update(Request $request, Classroom $classroom)
  {
    //
  }


  public function destroy(Request $request)
  {
    $class = Classroom::findorFail($request->id);
    $class->delete();
    toastr()->error(trans('messages.Delete'));
    return redirect()->route('classrooms');
  }

  

  public function test(Request $request)
  {
    foreach ($request->res as $k) {
      $class = Classroom::findorFail($k)->delete();
    }
    return response()->json([
      "status" => true,
      "message" => count($request->res) . " Classrooms has deleted !",
    ]);
  }


  public function filter(Request $request)
  {
    $Grades = Grade::all();
    $search = Classroom::select("*")->where("Grade_id","=",$request->Grade_id)->get();
    return view("pages.Classrooms.allclassrooms",compact("Grades"))->withDetails($search);
  }



}
