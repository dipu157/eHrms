@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Approve Overtime</h2>
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

        @if(!empty($data))


        <div class="row">
            <div class="col-md-12" style="overflow-x:auto;">
                <table class="table table-bordered table-hover table-striped" id="overtime-table">
                    <thead>
                        <tr>
                            <th width="10%">Date</th>
                            <th width="10%">ID<br/> </th>
                            <th width="25%">Name</th>
                            <th width="15%">Time</th>
                            <th width="10%">Overtime <br/>Hour</th>
                            <th width="20%">Reason<br/> Day</th>
                            <th width="10%">Action</th>
                        </tr>
                        <tr>
                            <th colspan="6" style="text-align: right">Select All {!! Form::checkbox('check[]',null, false,array('id'=>'check-all')) !!}</th>
                        </tr>
                    </thead>

                    {!! Form::open(['url' => 'overtime/approve', 'method' => 'post']) !!}

                    <tbody>
                    @foreach($data as $row)
                        <tr>
                            <td>{!! \Carbon\Carbon::parse($row->ot_date)->format('d-m-Y') !!}</td>
                            <td>{!! $row->employee_id !!}</td>
                            <td>{!! $row->professional->personal->full_name !!}<br/> <span style="color: darkred">{!! $row->professional->designation->name !!}</span></td>
                            <td>{!! \Carbon\Carbon::parse($row->entry_time)->format('g:i A') !!} -- {!! \Carbon\Carbon::parse($row->exit_time)->format('g:i A') !!}</td>
                            <td>{!! $row->ot_hour !!}</td>
                            <td>{!! $row->reason !!}</td>
                            <td>{!! Form::checkbox('check[]',$row->id, false) !!}</td>
                        </tr>
                    @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="3"><button class="btn btn-secondary btn-approve" type="submit" name="action" value="approve"> <i class="fa fa-apple"></i> Approve </button></td>
                            <td colspan="3"><button class="btn btn-danger btn-reject pull-right" type="submit" name="action" value="reject"> <i class="fa fa-trash"></i> Reject </button></td>
                        </tr>
                    </tfoot>
                    {!! Form::close() !!}

                </table>
            </div>
        </div>

        @endif

    </div> <!--/.Container-->

@endsection

@push('scripts')

    <script>

        $("#check-all").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        // Patient Name Update

        $(document).on('click', '.btn-shift-data-update', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = 'designation/update';

            // confirm then
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',

                data: {method: '_POST', submit: true, app_id:$('#appointment-id').val(),
                    first_name:$('#first_name').val(), middle_name:$('#middle_name').val(),
                    last_name:$('#last_name').val(),
                },

                error: function (request, status, error) {
                    alert(request.responseText);
                },

                success: function (data) {

                    $('#patient-update-modal').modal('hide');
                    $('#designation-table').DataTable().draw(false);

                }

            });
        });




        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });

        $( function() {
            $( "#started_from" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                inline:false
            });

        } );

        idleTimer();

    </script>






@endpush