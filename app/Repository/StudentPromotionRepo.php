<?php

namespace App\Repository;

use App\Models\Grade;
use App\Models\Promotion;
use App\Models\Student;
use App\Repository\Interfaces\StudentPromotionInterface;
use Illuminate\Support\Facades\DB;

class StudentPromotionRepo implements StudentPromotionInterface
{


  public function index()
  {
    $promotions = Promotion::all();
    return view("pages.Students.promotions.management", compact("promotions"));
  }
  public function createPromotion()
  {
    $Grades = Grade::all();
    return view('pages.Students.promotions.index', compact('Grades'));
  }

  public function storePromotion($request)
  {
    DB::beginTransaction();

    try {

      $students = Student::where('Grade_id', $request->Grade_id)->where('Classroom_id', $request->Classroom_id)->where('section_id', $request->section_id)->where('academic_year', $request->academic_year)->get();

      if ($students->count() < 1) {
        return redirect()->back()->with('error_promotions', __('لاتوجد بيانات في جدول الطلاب'));
      }

      // update in table student
      foreach ($students as $student) {

        $ids = explode(',', $student->id);
        Student::whereIn('id', $ids)
          ->update([
            'Grade_id' => $request->Grade_id_new,
            'Classroom_id' => $request->Classroom_id_new,
            'section_id' => $request->section_id_new,
            'academic_year' => $request->academic_year_new,
          ]);

        // insert in to promotions
        Promotion::updateOrCreate([
          'student_id' => $student->id,
          'from_grade' => $request->Grade_id,
          'from_Classroom' => $request->Classroom_id,
          'from_section' => $request->section_id,
          'to_grade' => $request->Grade_id_new,
          'to_Classroom' => $request->Classroom_id_new,
          'to_section' => $request->section_id_new,
          'academic_year' => $request->academic_year,
          'academic_year_new' => $request->academic_year_new,
        ]);
      }
      DB::commit();
      toastr()->success(trans('messages.success'));
      return redirect()->back();
    } catch (\Exception $e) {
      DB::rollback();
      return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
  }

  public function destroyPromotion($request)
  {
    DB::beginTransaction();
    try {
      if ($request->page_id == 1) {
        $promotions = Promotion::all();
        foreach ($promotions as $promotion) {
          $id = explode(",", $promotion->student_id); //[1,2,4,7,8,11]
          Student::whereIn("id", $id)->update([
            'Grade_id' => $promotion->from_grade,
            'Classroom_id' => $promotion->from_Classroom,
            'section_id' => $promotion->from_section,
            'academic_year' => $promotion->academic_year,
          ]);
        }
        Promotion::truncate();
      } else {
        $promotion = Promotion::findOrFail($request->id);
        Student::where('id', $promotion->student_id)
          ->update([
            'Grade_id' => $promotion->from_grade,
            'Classroom_id' => $promotion->from_Classroom,
            'section_id' => $promotion->from_section,
            'academic_year' => $promotion->academic_year,
          ]);
        $promotion->delete();
      }


      DB::commit();
      toastr()->error(trans('messages.Delete'));
      return redirect()->back();
    } catch (\Exception $tr) {
      DB::rollBack();
      return redirect()->back()->withErrors(["error" => $tr->getMessage()]);
    }
  }
}
