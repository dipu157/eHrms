@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Select list of participant for the training</h2>
    <h2>{!! $training->training->title !!} : <span style="color: #7b0000">Schedule : {!! $training->start_from !!} To {!! $training->end_on !!}</span> </h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>

    <style>
        a,a:hover {
          color: white;
        }
        .table-wrapper-scroll-y {
            display: block;
            max-height: 400px;
            overflow-y: auto;
            -ms-overflow-style: -ms-autohiding-scrollbar;
        }


        table {
            width: auto;
        }

        thead, tbody, tr, td, th { display: block; }

        tr:after {
            content: ' ';
            display: block;
            visibility: hidden;
            clear: both;
        }

        thead th {
            height: 60px;

            /*text-align: left;*/
        }

        tbody {
            height: 500px;
            overflow-y: auto;
        }

        thead {
            /* fallback */
        }


        tbody td, thead th {
            width: 90px;
            float: left;
        }


    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>

        </div>


        <form class="form-inline" method="post" action="{{ route('training/traineeList') }}">

            {!! Form::hidden('training_id', $training->id, array('id' => 'training_id')) !!}
            {!! Form::hidden('department_id', $emp_info[0]->department_id, array('id' => 'department_id')) !!}


            <table class="table table-striped table-hover" id="refresh">
                <thead>
                <tr style="background-color: rgba(24,149,255,0.56)">
                    <th style="min-width: 30px;">{!! Form::checkbox('check-one',null, false,array('id'=>'check-one')) !!}</th>
                    <th style="min-width: 70px;">ID</th>
                    <th style="min-width: 250px;">Name</th>
                    <th style="min-width: 200px; text-align: right">Designation</th>
                    <th style="min-width: 100px; text-align: right">Participated</th>
                </tr>
                </thead>

                @csrf
                <tbody>

                @foreach($emp_info as $i=>$row)
                    <tr>
                        <td style="min-width: 30px;">{!! Form::checkbox('check[]',$row->employee_id, $empSelected->contains('employee_id',$row->employee_id) ? true : false) !!}</td>
                        <td style="min-width: 70px;">{!! $row->employee_id !!}</td>
                        <td style="min-width: 250px;">{!! $row->personal->full_name !!}</td>
                        <td style="min-width: 200px; text-align: right">{!! $row->designation->name !!}</td>
                        <td style="min-width: 100px;"></td>
                    </tr>
                @endforeach

                </tbody>

                <tfoot>

                <tr>
                    <td><button class="btn btn-secondary btn-approve pull-left" type="submit" name="action" value="approve"> <i class="fa fa-apple"></i> Submit </button></td>
                </tr>

                </tfoot>

            </table>
        </form>




    </div>








@endsection

@push('scripts')

    <script>

        $("#check-one").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

    </script>

@endpush