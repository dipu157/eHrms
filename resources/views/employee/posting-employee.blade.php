@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Posting Information for <strong style="color: #980000">{!! $emp_data->full_name !!}</strong></h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap3-typeahead.js') !!}"></script>
    {{--<link href="{!! asset('assets/css/bootstrap-imageupload.css') !!}" rel="stylesheet" type="text/css" />--}}
{{--    <script type="text/javascript" src="{!! asset('assets/js/bootstrap-imageupload.js') !!}"></script>--}}

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <button type="button" class="btn btn-new-posting btn-success" data-toggle="modal" data-target="#modal-new-posting"><i class="fa fa-plus"></i>New Posting</button>
                </div>
            </div>

            <div class="col-md-6">
                <div class="pull-right">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>

        </div>

        {!! Form::hidden('emp_id', $emp_data->id, array('id' => 'emp_id')) !!}

        <div class="row">
            <div class="col-md-12" style="overflow-x:auto;">
                <table class="table table-bordered table-hover table-striped" id="posting-table">
                    <thead style="background-color: #b0b0b0">
                    <tr>
                        <th>Division</th>
                        <th>Department</th>
                        <th>Section</th>
                        <th>Effective From</th>
                        <th>Charge</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div> <!--/.Container-->
@include('employee.modals.add.posting-add')
@include('employee.modals.edit.posting-edit-modal')

@endsection

@push('scripts')

    <script>
        $(function() {
            var table= $('#posting-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: 'postingDataTable/'+ $('#emp_id').val(),
                columns: [
                    { data: 'division.name', name: 'division.name' },
                    { data: 'department.name', name: 'department.name', defaultContent: "" },
                    { data: 'section.name', name: 'section.name', defaultContent: "" },
                    { data: 'posting_start_date', name: 'posting_start_date' },
                    { data: 'charge', name: 'charge' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, printable: false}
                ]
            });


            $("body").on("click", ".btn-new-posting", function (e) {
                e.preventDefault();

                document.getElementById('n_posting_emp_id').value= $('#emp_id').val();

            });


            $(this).on("click", ".btn-posting-edit", function (e) {
                e.preventDefault();

                document.getElementById('u_division_id').value = $(this).data('division');
                document.getElementById('u_department_id').value = $(this).data('department');
                document.getElementById('u_section_id').value = $(this).data('section');
                document.getElementById('u_report_id').value = $(this).data('boss');
                document.getElementById('u_effective_date').value = $(this).data('start-date');
                document.getElementById('u_special').value = $(this).data('special');
                document.getElementById('u_posting_notes').value = $(this).data('note');

                document.getElementById('u_posting_id').value = $(this).data('rowid');
                document.getElementById('u_emp_personals_id').value = $(this).data('emp-id');

                switch($(this).data('charge')) {
                    case 'G':
                        $("#u_inlineRadio3").prop("checked", true);
                        break;
                    case 'S':
                        $("#u_inlineRadio2").prop("checked", true);
                        break;
                    case 'I':
                        $("#u_inlineRadio1").prop("checked", true);
                        break;
                }

            });

            $(this).on("click", ".btn-posting-delete", function (e) {
                e.preventDefault();

                window.location.href = $(this).data('remote');

            });


        });

        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });

        $( function() {
            $( "#dob" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                inline:false
            });

            $( "#joining_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                inline:false
            });

            $( "#achievement_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                inline:false
            });

        } );

    </script>
@endpush

