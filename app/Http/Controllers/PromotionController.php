<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Promotion;
use App\Repository\Interfaces\StudentPromotionInterface;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
  protected StudentPromotionInterface $student;

  public function __construct(StudentPromotionInterface $student)
  {
    $this->student = $student;
  }

  public function index()
  {
    return $this->student->index();
  }
  

  public function create()
  {
    return $this->student->createPromotion();

  }

  public function store(Request $request)
  {
    
    return $this->student->storePromotion($request);
  }

  public function show(Promotion $promotion)
  {
    //
  }


  public function edit(Promotion $promotion)
  {
    //
  }


  public function update(Request $request, Promotion $promotion)
  {
    //
  }


  public function destroy(Request $request)
  {
    return $this->student->destroyPromotion($request);
  }
}
