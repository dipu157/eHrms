@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Shift Information</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <button type="button" class="btn btn-shift btn-success" data-toggle="modal" data-target="#modal-new-shift"><i class="fa fa-plus"></i>New Shift</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="pull-right">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12" style="overflow-x:auto;">
                <table class="table table-bordered table-hover table-striped" id="shifts-table">
                    <thead style="background-color: #b0b0b0">
                    <tr>
                        <th>Name</th>
                        <th>Short <br/> Name</th>
                        <th>Time</th>
                        <th>Duty <br/>Hour</th>
                        <th>Next<br/> Day</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div> <!--/.Container-->

    @include('roster.modals.add-shift-modal')
    @include('roster.modals.edit-shift-modal')

@endsection

@push('scripts')

    <script>
        $(function() {
            var table= $('#shifts-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: 'shiftsDataTable',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'short_name', name: 'short_name' },
                    { data: 'shifttime', name: 'shifttime' },
                    { data: 'duty_hour', name: 'duty_hour' },
                    { data: 'nextday', name: 'nextday' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, printable: false}
                ]
            });


            $(this).on("click", ".btn-shift-edit", function (e) {
                e.preventDefault();

                var data_id = $(this).data('rowid');
                var data_name = $(this).data('name');
                var data_shortname = $(this).data('shortname');
                var data_fromtime = $(this).data('fromtime');
                var data_totime = $(this).data('totime');
                var data_nextdate = $(this).data('nextdate');
                var data_dutyhour = $(this).data('hour');


                document.getElementById('id-for-update').value=data_id;
                document.getElementById('name-for-update').value=data_name;
                document.getElementById('short_name-for-update').value=data_shortname;
                document.getElementById('from-time-for-update').value=data_fromtime;
                document.getElementById('to-time-for-update').value=data_totime;
                document.getElementById('duty-hour-for-update').value=data_dutyhour;

                data_nextdate == true ? $("#end_next_day-y-for-update").prop("checked", true) : $("#end_next_day-n-for-update").prop("checked", true);
                // data_nextdate == false ? $("#end_next_day-n-for-update").prop("checked", true) : $("#end_next_day-n-for-update").prop("checked", false);



                // document.getElementById('next-date-update-y').value=data_totime;

            });


            // $("body").on("click", ".btn-create", function (e) {
            //     e.preventDefault();
            //
            //     var url = $(this).data('remote');
            //     window.location.href = url;
            //
            // });



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

    </script>






@endpush