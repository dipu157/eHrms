@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Food Charge For The Month Of {!! $period->month_name !!}, {!! $period->calender_year !!}</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>
    <link href="{!! asset('assets/css/bootstrap-imageupload.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap-imageupload.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />

    <link href="{!! asset('assets/tabs/css/style.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! asset('assets/css/pretty-checkbox.css') !!}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>


    @include('partials.flash-message')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>
        </div>




            <div class="row">
                <div class="col-md-12" style="overflow-x:auto;">
                    <table class="table table-bordered table-hover table-striped" id="employees-table">
                        <thead style="background-color: #b0b0b0">
                        <tr>
                            <th></th>
                            <th>Photo</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Designation <br/><span style="color: #0c5460">Department</span></th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>


    </div> <!--/.Container-->

    @include('hospitality.modal.add-charge-modal')

@endsection

@push('scripts')

    <script>

        $(function() {
            var table= $('#employees-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: 'employeeFoodChargeData',
                columns: [
                    { data: 'id', name: 'id', visible: false },
                    { data: 'image', name: 'image'},
                    { data: 'employee_id', name: 'employee_id'},
                    { data: 'personal.full_name', name: 'personal.full_name'},
                    { data: 'designation.name', name: 'designation.name'},
                    { data: 'amount', name:'amount' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, printable: false}

                ],
                order: [ [0, 'desc'] ]
            });

            $(this).on("click", ".btn-view", function (e) {
                e.preventDefault();

                var url = $(this).data('remote');
                window.location.href = url;

            });

            $(this).on("click", ".btn-charge-edit", function (e) {
                e.preventDefault();

                // alert($(this).data('employee'));
                // return false;

                document.getElementById('employee_id').value=$(this).data('employee');
                document.getElementById('amount').value=$(this).data('amount');
                document.getElementById('description').value=$(this).data('description');

            });

        });

        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });

    </script>
@endpush