@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee Section List</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> Department Wise Section List</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('employee/report/empsectionEmpList') }}">
                            <div class="form-group row">
                                <label for="status_id" class="col-md-4 col-form-label text-md-right">Department</label>
                                <div class="col-md-6">

                                    {!! Form::select('department_id', $departments, null, [
                                        'id' => 'department_id',
                                        'class' => 'form-control',
                                        'placeholder' => 'Select One',
                                    ]) !!}
                                </div>
                            </div>


                            {{-- {!! Form::hidden('search_id',1) !!} --}}

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="export">Export</button>
                                </div>
                                <div class="col-md-5 text-md-right">
                                    <button type="submit" class="btn btn-secondary" name="action"
                                        value="print">Print</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Section Wise List</div>

                    <div class="card-body">
                        <form method="get" action="{{ route('employee/report/empsectionEmpList') }}">

                            <div class="form-group row">
                                <label for="from_date" class="col-md-4 col-form-label text-md-right">Section</label>
                                <div class="col-md-6">
                                    {!! Form::select('sec', $sections, null, [
                                        'id' => 'sec',
                                        'class' => 'form-control',
                                        'placeholder' => 'Select One',
                                    ]) !!}
                                </div>
                            </div>

                            {{-- {!! Form::hidden('search_id',1) !!} --}}

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="export">Export</button>
                                </div>
                                <div class="col-md-5 text-md-right">
                                    <button type="submit" class="btn btn-secondary" name="action"
                                        value="print">Print</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--/.Container-->
    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('select[name="department_id"]').on('change', function() {
                    var sections = $(this).val();
                    if (section) {
                        $.ajax({
                            url: 'sectioncode/ajax/' + sections,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('select[name="sec"]').empty();
                                $.each(data, function(key, value) {
                                    $('select[name="sec"]').append('<option value="' + key +
                                        '">' + value + '</option>');
                                });
                            }
                        });
                    } else {
                        $('select[name="sec"]').empty();
                    }
                });
            });
        </script>
    @endpush
