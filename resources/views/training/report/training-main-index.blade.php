@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Training Details : {!! $training->title !!}</h2>
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

        @if(!empty($final))

            <!--Table-->
                <table class="table table-striped table-hover table-bordered">

                    <!--Table head-->
                    <thead>
                    <tr>
                        <th style="font-weight: bold;">#</th>
                        <th style="font-weight: bold;">Department</th>
                        <th>Total Employee</th>
                        <th>Attended</th>
                        <th>Left</th>
                        <th>View</th>
                    </tr>
                    </thead>
                    <!--Table head-->



                    <!--Table body-->
                    <tbody>

                    @foreach($final as $i=>$row)
                        <tr class="{!! $i/1==0 ? 'table-info' : '' !!}">
                            <th scope="row">{!! $i+1 !!}</th>
                            <td>{!! $row->department->name !!}</td>
                            <td>{!! $row->t_emp !!}</td>
                            <td>{!! $row->attended !!}</td>
                            <td>{!! $row->t_emp - $row->attended !!}</td>
                            <td><a href="{!! url('training/printTraining/'.$training->id.'/'.$row->department_id) !!}">
                                    Print
                                </a></td>
                        </tr>

                    @endforeach

                    </tbody>
                    <!--Table body-->


                </table>
                <!--Table-->

            @endif



        {{--<div class="row justify-content-center">--}}
            {{--<div class="col-md-8">--}}
                {{--<div class="card">--}}
                    {{--<div class="card-header">User Privillege</div>--}}

                    {{--<div class="card-body">--}}
                        {{--<form method="get" action="{{ route('training/printTraining') }}" >--}}

                            {{--<div class="form-group row">--}}
                                {{--<label for="department_id" class="col-md-4 col-form-label text-md-right">Department</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--{!! Form::select('department_id',$departments,null,['id'=>'department_id', 'class'=>'form-control']) !!}--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group row">--}}
                                {{--<label for="department_id" class="col-md-4 col-form-label text-md-right">Department</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--{!! Form::select('status_id',['A'=>'Already Trained','N'=>'Not Trained'],null,['id'=>'status_id', 'class'=>'form-control']) !!}--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--{!! Form::hidden('training_id',$training->id) !!}--}}

                            {{--<div class="form-group row mb-0">--}}
                                {{--<div class="col-md-6 offset-md-1">--}}
                                    {{--<button type="submit" class="btn btn-primary" name="action" value="preview">Preview</button>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-5 text-md-right">--}}
                                    {{--<button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                        {{--</form>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}



    </div> <!--/.Container-->

@endsection
