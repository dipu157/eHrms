@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Circular Information</h2>
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
                    <button type="button" class="btn btn-circular btn-success" data-toggle="modal" data-target="#modal-new-circular"><i class="fa fa-plus"></i>New Circular</button>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12" style="overflow-x:auto;">
                <table class="table table-bordered table-hover table-striped table-success" id="circular-table">
                    <thead style="background-color: #b0b0b0">
                    <tr>
                        <th>ID</th>
                        <th>Circular Name</th>
                        <th>Department Name</th>
                        <th>Expire Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div> <!--/.Container-->

    @include('circular.modals.add.circular-add')
    @include('circular.modals.edit.circular-update')

@endsection

@push('scripts')

    <script>
        $(function() {
            var table= $('#circular-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: 'circularDataTable',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'circular_name', name: 'circular_name' },
                    { data: 'department.name', name: 'department.name' },
                    { data: 'expire_date', name: 'expire_date' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, printable: false}
                ]
            });

            $("body").on("click", ".btn-create", function (e) {
                e.preventDefault();

                var url = $(this).data('remote');
                window.location.href = url;

            });

            $(this).on("click", ".btn-circular-edit", function (e) {
                e.preventDefault();

                var data_id = $(this).data('rowid');
                var data_circular_name = $(this).data('circular_name');
                var data_expire_date = $(this).data('expire_date');

                document.getElementById('id-for-update').value=data_id;
                document.getElementById('circular_name-for-update').value=data_circular_name;
                document.getElementById('expire_date-for-update').value=data_expire_date;


            });          


        });

        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });

        $( function() {
            $( "#expire_date" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                inline:false
            });

        } );


    </script>

@endpush