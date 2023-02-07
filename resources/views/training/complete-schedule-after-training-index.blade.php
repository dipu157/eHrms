@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Select Attended participant for the training</h2>
    <h2>{!! $training->training->title !!} : <span style="color: #7b0000">Schedule : {!! $training->start_from !!} To {!! $training->end_on !!}</span> </h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>

    <style>
        a, a:hover {
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


        <table class="table table-striped table-hover" id="refresh">
            <thead>
            <tr style="background-color: rgba(24,149,255,0.56)">
                <th style="min-width: 30px;">SL</th>
                <th style="min-width: 300px;">Name</th>
                <th style="min-width: 100px; text-align: right">No of Employee</th>
                <th style="min-width: 100px; text-align: right">Participant</th>
            </tr>
            </thead>

            @csrf
            <tbody>


            @foreach($emp_count as $i=>$row)

                <tr>
                    <td style="min-width: 30px;">{!! $i+1 !!}</td>
                    <td style="min-width: 300px;"><a href="{!! url('training/completeList/'.$row->department_id.'/'.$training->id) !!}">
                            {!! $row->department->name !!}
                        </a></td>
                    <td style="min-width: 100px; text-align: right">{!! $row->total !!}</td>
                    <td style="min-width: 100px; text-align: right">{!! $row->participant !!}</td>

                </tr>

            @endforeach

            </tbody>

            {{--<tfoot>--}}

            {{--<tr>--}}
            {{--<td><button class="btn btn-secondary btn-approve pull-left" type="submit" name="action" value="approve"> <i class="fa fa-apple"></i> Approve </button></td>--}}
            {{--<td><button class="btn btn-danger btn-reject pull-right" type="submit" name="action" value="reject"> <i class="fa fa-trash"></i>Reject</button></td>--}}
            {{--</tr>--}}

            {{--</tfoot>--}}
        </table>






    </div>


@endsection

@push('scripts')

    <script>

        $("#check-one").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

    </script>

@endpush