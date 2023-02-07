@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Phone List</h2>
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
                    <button type="button" class="btn btn-phone btn-success" data-toggle="modal" data-target="#modal-new-phone"><i class="fa fa-plus"></i>Add New Phone</button>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12" style="overflow-x:auto;">
                <table class="table table-bordered table-hover table-striped table-success" id="phone-table">
                    <thead style="background-color: #b0b0b0">
                    <tr>
                        <th>Used By</th>
                        <th>Department</th>
                        <th>Location</th>
                        <th>Phone No.</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div> <!--/.Container-->

    @include('phone.modals.phone-add')
    @include('phone.modals.phone-update')

@endsection

@push('scripts')

    <script>
        $(function() {
            var table= $('#phone-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: 'phoneDataTable',
                columns: [
                    { data: 'used_by', name: 'used_by' },
                    { data: 'department.name', name: 'department.name' },
                    { data: 'location.location', name: 'location.location' },
                    { data: 'phone_no', name: 'phone_no' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, printable: false}
                ]
            });

            $('#phone-table').on("click", ".btn-phone-edit", function (e) {
                e.preventDefault();

                var data_id = $(this).data('rowid');
                var data_used_by = $(this).data('used_by');
                var data_phone_no = $(this).data('phone_no');
                var data_ip_address = $(this).data('ip_address');

                document.getElementById('id-for-update').value=data_id;
                document.getElementById('used_by-for-update').value=data_used_by;
                document.getElementById('phone_no-for-update').value=data_phone_no;
                document.getElementById('ip_address-for-update').value=data_ip_address;
            });    
        });

        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });


    </script>

@endpush