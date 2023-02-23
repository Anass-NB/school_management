<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\FeeInvoice;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeInvoiceController extends Controller
{

  public function index()
  {
    $Fee_invoices = FeeInvoice::all();
    $Grades = Grade::all();
    return view('pages.fees_invoices.index',compact('Fee_invoices','Grades'));
  }

  public function create()
  {
    //
  }

  public function store(Request $request)
  {
    $List_Fees = $request->List_Fees;

    DB::beginTransaction();

    try {

      foreach ($List_Fees as $List_Fee) {
        //save data in fee_invoices_table
        $Fees = new FeeInvoice();
        $Fees->invoice_date = date('Y-m-d');
        $Fees->student_id = $List_Fee['student_id'];
        $Fees->Grade_id = $request->Grade_id;
        $Fees->Classroom_id = $request->Classroom_id;;
        $Fees->fee_id = $List_Fee['fee_id'];
        $Fees->amount = $List_Fee['amount'];
        $Fees->description = $List_Fee['description'];
        $Fees->save();

      
        // $StudentAccount = new StudentAccount();
        // $StudentAccount->date = date('Y-m-d');
        // $StudentAccount->type = 'invoice';
        // $StudentAccount->fee_invoice_id = $Fees->id;
        // $StudentAccount->student_id = $List_Fee['student_id'];
        // $StudentAccount->Debit = $List_Fee['amount'];
        // $StudentAccount->credit = 0.00;
        // $StudentAccount->description = $List_Fee['description'];
        // $StudentAccount->save();
      }

      DB::commit();

      toastr()->success(trans('messages.success'));
      return redirect()->route('Fees_Invoices.index');
    } catch (\Exception $e) {
      DB::rollback();
      return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
  }

  public function show($id)
  {
    $student = Student::findorfail($id);
    $fees = Fee::where('Classroom_id', $student->Classroom_id)->get();
    return view('pages.fees_invoices.add', compact('student', 'fees'));
  }

  public function edit(FeeInvoice $feeInvoice)
  {
    //
  }


  public function update(Request $request, FeeInvoice $feeInvoice)
  {
    //
  }


  public function destroy(FeeInvoice $feeInvoice)
  {
    //
  }
}
