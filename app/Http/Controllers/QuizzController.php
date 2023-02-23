<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Quizz;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class QuizzController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $quizzes = Quizz::get();
      return view('pages.quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data['grades'] = Grade::all();
      $data['subjects'] = Subject::all();
      $data['teachers'] = Teacher::all();
      return view('pages.quizzes.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      try {
        $quizzes = new Quizz();
        $quizzes->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
        $quizzes->subject_id = $request->subject_id;
        $quizzes->grade_id = $request->Grade_id;
        $quizzes->classroom_id = $request->Classroom_id;
        $quizzes->section_id = $request->section_id;
        $quizzes->teacher_id = $request->teacher_id;
        $quizzes->save();
        toastr()->success(trans('messages.success'));
        return redirect()->route('Quizzes.create');
    }
    catch (\Exception $e) {
        return redirect()->back()->with(['error' => $e->getMessage()]);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quizz  $quizz
     * @return \Illuminate\Http\Response
     */
    public function show(Quizz $quizz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quizz  $quizz
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $quizz = Quizz::findorFail($id);
      $data['grades'] = Grade::all();
      $data['subjects'] = Subject::all();
      $data['teachers'] = Teacher::all();
      return view('pages.quizzes.edit', $data, compact('quizz'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quizz  $quizz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quizz $quizz)
    {
      try {
        $quizz = Quizz::findorFail($request->id);
        $quizz->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
        $quizz->subject_id = $request->subject_id;
        $quizz->grade_id = $request->Grade_id;
        $quizz->classroom_id = $request->Classroom_id;
        $quizz->section_id = $request->section_id;
        $quizz->teacher_id = $request->teacher_id;
        $quizz->save();
        toastr()->success(trans('messages.Update'));
        return redirect()->route('quizzes.index');
    } catch (\Exception $e) {
        return redirect()->back()->with(['error' => $e->getMessage()]);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quizz  $quizz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      try {
        Quizz::destroy($request->id);
        toastr()->error(trans('messages.Delete'));
        return redirect()->back();
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
    }
}
