@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Doctor Department Information</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />

    <link href="{!! asset('assets/tabs/css/style.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! asset('assets/css/pretty-checkbox.css') !!}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>


    @include('partials.flash-message')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <button type="button" class="btn btn-doctorDepartment btn-success" data-toggle="modal" data-target="#modal-new-doctorDepartment"><i class="fa fa-plus"></i>New Doctor Department</button>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12" style="overflow-x:auto;">
                <table class="table table-bordered table-hover table-striped table-success" id="doctorDepartments-table">
                    <thead style="background-color: #b0b0b0">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Short Name</th>
                        <th>In Charge</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div> <!--/.Container-->

    @include('admin.modals.add.doctorDepartment-add')
    @include('admin.modals.edit.doctorDepartment-update')

@endsection

@push('scripts')

    <script>
        $( function() {
            $( "#started_from" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                inline:false
            });

        } );
        $(function() {
            var table= $('#doctorDepartments-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: 'doctorDepartmentDataTable',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'short_name', name: 'short_name' },
                    { data: 'headed_by', name: 'headed_by' },
                    { data: 'email', name: 'email' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, printable: false}
                ]
            });


            $(this).on("click", ".btn-doctorDepartment-edit", function (e) {
                e.preventDefault();

                var data_id = $(this).data('rowid');
                var data_name = $(this).data('name');
                var data_shortname = $(this).data('shortname');
                var data_email = $(this).data('email');
                var data_description = $(this).data('description');

                document.getElementById('id-for-update').value=data_id;
                document.getElementById('name-for-update').value=data_name;
                document.getElementById('short_name-for-update').value=data_shortname;
                document.getElementById('department_code-for-update').value=$(this).data('code');
                document.getElementById('top_rank-for-update').value=$(this).data('top');
                document.getElementById('email-for-update').value=data_email;
                document.getElementById('description-for-update').value=data_description;
});

            $("body").on("click", ".btn-create", function (e) {
                e.preventDefault();

                var url = $(this).data('remote');
                window.location.href = url;

            });
        });

    </script>

@endpush