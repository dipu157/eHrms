@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee Attendance Process</h2>
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
            <div class="col-md-6">
                <div class="card">
                    {{--<div class="card-header">User Privillege</div>--}}

                    <div class="card-body">
                        <form method="post" action="{{ route('attendance/create') }}" >
                            @csrf

                            <div class="form-group row">
                                <label for="run_date" class="col-md-4 col-form-label text-md-right">Select Date</label>

                                <div class="col-md-6">

                                    <input type="text" name="run_date" id="run_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />

                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer">
                        <div class="progress">
                            <div class="bar"></div >
                            <div class="percent">0%</div >
                        </div>

                        <div id="status"></div>
                    </div>
                </div>
            </div>


            @if(!empty($data))
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">

                                <table class="table table-bordered table-success table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Submitted By</th>
                                            <th>Submitted Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $row)
                                            <tr>
                                                <td>{!! $row->process_date_param !!}</td>
                                                <td>{!! $row->user->name !!}</td>
                                                <td>{!! $row->created_at !!}</td>
                                            </tr>

                                        @endforeach
                                    </tbody>

                                </table>


                        </div>
                    </div>
                </div>
            @endif



        </div>

    </div> <!--/.Container-->

@endsection

@push('scripts')

    <script>

        $(document).ready(function(){

            $( "#run_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                scrollInput : false,
                inline:false
            });
        });




        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });


        $(function() {
            var bar = $('.bar');
            var percent = $('.percent');
            var status = $('#status');

            $('form').ajaxForm({
                beforeSend: function() {
                    status.empty();
                    var percentVal = '0%';
                    bar.width(percentVal);
                    percent.html(percentVal);
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    bar.width(percentVal);
                    percent.html(percentVal);
                },
                complete: function(xhr) {
                    status.html(xhr.responseText);
                }
            });
        });




    </script>






@endpush