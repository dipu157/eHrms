@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Investigation Advice Report</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap3-typeahead.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>
        </div>


        {{--<div class="form-group row">--}}
        {{--<label for="descp" class="col-sm-2 form-control-label mt-2">Product Description</label>--}}
        {{--<div class="col-sm-10">--}}
        {{--<textarea name="descp" id="descp" class="summernote form-control form-control-success"></textarea>--}}
        {{--</div>--}}
        {{--</div>--}}



        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    {{--<div class="card-header" style="background-color: rgba(17,173,190,0.34)">Investigation Advised By {!! \Illuminate\Support\Facades\Auth::user()->name !!}</div>--}}
                    {{----}}
                    <div class="card-body">

                        <form id="search-form-date" method="get" action="{{ route('doctorReport/doctorServiceIndex') }}">


                            <div class="form-group row">
                                <label for="emp_id" id="doctor_label" class="col-md-4 col-form-label text-md-right">Doctor Name</label>

                                <div class="col-md-6">

                                    <input id="d_name" type="text" class="form-control typeahead" name="d_name" autocomplete="off">
                                    <input id="doctor_id" type="hidden"  name="doctor_id" required>

                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="from_date" class="col-md-4 col-form-label text-md-right">From Date</label>
                                <div class="col-md-6">
                                    <input type="text" name="from_date" id="from_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="to_date" class="col-md-4 col-form-label text-md-right">To</label>
                                <div class="col-md-6">
                                    <input type="text" name="to_date" id="to_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required />
                                </div>
                            </div>

                            {{--                            <input type="hidden" value="{!! \Illuminate\Support\Facades\Auth::user()->attached !!}" name="doctor_id"/>--}}


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="preview">Preview</button>
                                </div>
                                <div class="col-md-5 text-md-right">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                                </div>
                            </div>

                            {{--<button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search">Submit</i></button>--}}
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{--<div class="row justify-content-center">--}}
            {{--@if(!empty($ipd))--}}
                {{--<div class="col-md-6">--}}
                    {{--<div class="card">--}}

                        {{--<div class="card-header" style="font-weight: bold; color: rebeccapurple"> IPD Investigation--}}
                        {{--</div>--}}

                        {{--<div class="card-body">--}}

                            {{--<table class="table table-striped table-bordered table-success">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th style="font-weight: bold">SL</th>--}}
                                    {{--<th style="font-weight: bold">INVESTIGATION</th>--}}
                                    {{--<th style="text-align: right; font-weight: bold">COUNT</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}

                                {{--<tbody>--}}
                                {{--@foreach($ipd as $i=>$row)--}}
                                    {{--<tr>--}}
                                        {{--<td>{!! $i+1 !!}</td>--}}
                                        {{--<td>{!! $row->Service_Name !!}</td>--}}
                                        {{--<td style="text-align: right">{!! $row->count_no !!}</td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}
                                {{--</tbody>--}}

                            {{--</table>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--@endif--}}

            {{--@if(!empty($opd))--}}

                {{--<div class="col-md-6">--}}
                    {{--<div class="card">--}}

                        {{--<div class="card-header" style="font-weight: bold; color: darkseagreen">OPD Investigation--}}
                        {{--</div>--}}

                        {{--<div class="card-body">--}}

                            {{--<table class="table table-striped table-bordered table-success">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th style="font-weight: bold">SL</th>--}}
                                    {{--<th style="font-weight: bold">INVESTIGATION</th>--}}
                                    {{--<th style="text-align: right; font-weight: bold">COUNT</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}

                                {{--<tbody>--}}
                                {{--@foreach($opd as $i=>$row)--}}
                                    {{--<tr>--}}
                                        {{--<td>{!! $i+1 !!}</td>--}}
                                        {{--<td>{!! $row->Service_Name !!}</td>--}}
                                        {{--<td style="text-align: right">{!! $row->count_no !!}</td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}
                                {{--</tbody>--}}

                            {{--</table>--}}
                        {{--</div>--}}
                    {{--</div>--}}


                {{--</div>--}}

            {{--@endif--}}
        {{--</div>--}}
    </div> <!--/.Container-->

@endsection

@push('scripts')

    <script>



        $(document).ready(function(){

            $( "#from_date").datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false,
            });

            $( "#to_date").datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false,
            });

            $('.summernote').summernote({
                placeholder: 'Descriptions',
                tabsize: 2,
                height: 100
            });



            var autocomplete_path = "{{ url('autocomplete/doctors') }}";

            $(document).on('click', '.form-control.typeahead', function() {

                $(this).typeahead({
                    minLength: 2,
                    displayText:function (data) {
                        return data.doctor_name;
                    },
                    source: function (query, process) {
                        $.ajax({
                            url: autocomplete_path,
                            type: 'GET',
                            dataType: 'JSON',
                            data: 'query=' + query ,
                            success: function(data) {
                                return process(data);
                            }
                        });
                    },
                    afterSelect: function (data) {

                        document.getElementById('doctor_id').value = data.Doctor_code;

                    }
                });
            });


        });



    </script>

@endpush