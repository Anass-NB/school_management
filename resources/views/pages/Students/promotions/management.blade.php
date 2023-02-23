@extends('layouts.master')
@section('css')
  @toastr_css
@section('title')
  {{ trans('main_trans.list_students') }}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
  {{ trans('main_trans.list_students') }}
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

              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Delete_all">
                تراجع الكل
              </button>
              <br><br>

              <div class="table-responsive">
                <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                  style="text-align: center">
                  <thead>
                    <tr>
                      <th class="alert-info">#</th>
                      <th class="alert-info">{{ trans('Students_trans.name') }}</th>
                      <th class="alert-danger">المرحلة الدراسية السابقة</th>
                      <th class="alert-danger">السنة الدراسية</th>
                      <th class="alert-danger">الصف الدراسي السابق</th>
                      <th class="alert-danger">القسم الدراسي السابق</th>
                      <th class="alert-success">المرحلة الدراسية الحالي</th>
                      <th class="alert-success">السنة الدراسية الحالية</th>
                      <th class="alert-success">الصف الدراسي الحالي</th>
                      <th class="alert-success">القسم الدراسي الحالي</th>
                      <th>{{ trans('Students_trans.Processes') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($promotions as $promotion)
                      <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $promotion->student->name }}</td>
                        <td>{{ $promotion->f_grade->Name }}</td>
                        <td>{{ $promotion->academic_year }}</td>
                        <td>{{ $promotion->f_classroom->Name_Class }}</td>
                        <td>{{ $promotion->f_section->Name_section }}</td>
                        <td>{{ $promotion->t_grade->Name }}</td>
                        <td>{{ $promotion->academic_year_new }}</td>
                        <td>{{ $promotion->t_classroom->Name_Class }}</td>
                        <td>{{ $promotion->t_section->Name_section }}</td>
                        <td>

                          <button type="button" class="btn btn-outline-danger" data-toggle="modal"
                            data-target="#Delete_one{{ $promotion->id }}">ارجاع الطالب</button>
                          <button type="button" class="btn btn-outline-success" data-toggle="modal"
                            data-target="#graduate_{{ $promotion->id }}">تخرج الطالب</button>
                        </td>
                      </tr>
                      <!-- Deleted inFormation Student -->
                      <div class="modal fade" id="Delete_all" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                تراجع الكل</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form action="{{ route('promotions.destroy', 'test') }}" method="post">
                                @csrf
                                @method('DELETE')

                                <input type="hidden" name="page_id" value="1">
                                <h5 style="font-family: 'Cairo', sans-serif;">هل انت متاك من عملية تراجع كافة الطلاب ؟
                                </h5>
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
                      <!-- Deleted inFormation Student -->
                      <div class="modal fade" id="Delete_one{{ $promotion->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                تراجع طالب</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form action="{{ route('promotions.destroy', 'test') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $promotion->id }}">
                                <h5 style="font-family: 'Cairo', sans-serif;">هل انت متاكد من عملية تراجع الطالب ؟
                                  {{ $promotion->student->name }}</h5>
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
                      <!-- Graduate  inFormation Student -->
                      <div class="modal fade" id="graduate_{{ $promotion->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                تراجع طالب</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form action="{{ route('graduating.store', 'test') }}" method="post">
                                @csrf
                                
                                <input type="hidden" name="id" value="{{ $promotion->id }}">
                                <h5 style="font-family: 'Cairo', sans-serif;">هل انت متاكد من عملية تخرج الطالب ؟
                                  {{ $promotion->student->name }}</h5>
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
