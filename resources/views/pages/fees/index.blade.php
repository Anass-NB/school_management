@extends('layouts.master')
@section('css')
  @toastr_css
@section('title')
  الرسوم الدراسية
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
  الرسوم الدراسية
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
  <div class="col-md-12 mb-30">
    <div class="card card-statistics h-100">
      <div class="card-body">
        <div class="col-xl-12 mb-30">
          <div class="card card-statistics h-100">
            <div class="card-body">
              <a href="{{ route('fees.create') }}" class="btn btn-success btn-sm" role="button" aria-pressed="true">اضافة
                رسوم جديدة</a><br><br>
              <div class="table-responsive">
                <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                  style="text-align: center">
                  <thead>
                    <tr class="alert-success">
                      <th>#</th>
                      <th>الاسم</th>
                      <th>المبلغ</th>
                      <th>المرحلة الدراسية</th>
                      <th>الصف الدراسي</th>
                      <th>السنة الدراسية</th>
                      <th>ملاحظات</th>
                      <th>العمليات</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($fees as $fee)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $fee->title }}</td>
                        <td>{{ number_format($fee->amount, 2) }}</td>
                        <td>{{ $fee->grade->Name }}</td>
                        <td>{{ $fee->classroom->Name_Class }}</td>
                        <td>{{ $fee->year }}</td>
                        <td>{{ $fee->description }}</td>
                        <td>
                          <a href="{{ route('fees.edit', $fee->id) }}" class="btn btn-info btn-sm" role="button"
                            aria-pressed="true"><i class="fa fa-edit"></i></a>
                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#Delete_Fee{{ $fee->id }}" title="{{ trans('Grades_trans.Delete') }}"><i
                              class="fa fa-trash"></i></button>
                          <button type="button"  class="btn btn-warning btn-sm" data-toggle="modal" data-target="#show_students{{ $fee->id }}"  aria-pressed="true"><i
                              class="far fa-eye"></i></button>

                        </td>
                      </tr>
                      <!-- Deleted inFormation Student -->
                      <div class="modal fade" id="Delete_Fee{{ $fee->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                {{ trans('Students_trans.Deleted_Student') }}</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form action="{{ route('fees.destroy', 'test') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $fee->id }}">
                                <h5 style="font-family: 'Cairo', sans-serif;">هل انت متاكد مع عملية الحذف ؟</h5>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ trans('Students_trans.Close') }}</button>
                                  <button class="btn btn-danger">{{ trans('Students_trans.submit') }}</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                  
                    @endforeach
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- row closed -->
@endsection
@section('js')
@toastr_js
@toastr_render
@endsection
