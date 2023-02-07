@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Approve Training</h2>
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
                        <tr>
                                   
                                    <th width="180px">Employee ID</th>
                                    <th width="180px">Name</th>
                                    <th width="125px">Designation</th>
                                    <th width="60px">Training</th>
                                    <th width="60px">Training Date</th>
                                   
                                    <th width="60px">Recommended</th>
                                    <th width="155px">Reason</th>
                                    <th width="60px">Action</th>

                                </tr>
                        </tr>
                        <tr>
                            <th colspan="8" style="text-align: right">Select All {!! Form::checkbox('check[]',null, false,array('id'=>'check-all')) !!}</th>
                        </tr>
                    </thead>

                    {!! Form::open(['url' => 'training/approve', 'method' => 'post']) !!}

                    <tbody>
                    @foreach($data as $i=>$emp)


    <tr id="tr-id-{!! $i !!}" style="background-color:">
        {!! Form::hidden('id', $emp->id, array('id' => 'row_id-'.$i)) !!}
        {!! Form::hidden('training_date', $emp->training_date, array('id' => 'training_date-'.$i)) !!}
      
        <td>{!! $emp->employee_id !!} </td>

        <td>  {!! $emp->employee->personal->full_name !!}</td>
        <td><span style="color: rebeccapurple">{!! $emp->employee->designation->name !!}</span></td>
        <td>{!! $emp->title !!} </td>
        
        <td width="180px"> <br/>
         <span style="color: #0062cc">{!! $emp->training_date !!}--Time {!! \Carbon\Carbon::parse($emp->start_from)->format('g:i A') !!} -- {!! \Carbon\Carbon::parse($emp->end_on)->format('g:i A') !!}</span>
            
            </td>
     
        <td> <span style="color: #7d0000"> {!! $emp->approver->name ?? '' !!}</span> <br/><span style="color: #7d0000"> {!! $emp->recommended_date ?? '' !!}</span> </td>
        <td> {!! $emp->reason !!} </span></td>
        <td>{!! Form::checkbox('check[]',$emp->id, false) !!}</td>
        <td>  </td>
    </tr>


@endforeach
                    </tbody>

                    <tfoot>
                    <tr>
                            <td colspan="5"><button class="btn btn-secondary btn-approve" type="submit" name="action" value="approve"> <i class="fa fa-apple"></i> Approve </button></td>
                            <td colspan="5"><button class="btn btn-danger btn-reject pull-right" type="submit" name="action" value="reject"> <i class="fa fa-trash"></i> Reject </button></td>
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