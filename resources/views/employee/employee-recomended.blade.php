@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee Recomended For <strong style="color: #980000">{!! $emp_data->full_name !!}</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>
    <link href="{!! asset('assets/css/bootstrap-imageupload.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap-imageupload.js') !!}"></script>

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <button type="button" class="btn btn-new-recomended btn-success" data-toggle="modal" data-target="#modal-new-recomended"><i class="fa fa-plus"></i>Add Employee recomended</button>
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
                <table class="table table-bordered table-hover table-striped" id="recomended-table">
                    <thead style="background-color: #b0b0b0">
                    <tr>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Promotion</th>
                        <th>Change Designation</th>
                        <th>Aditional Amount</th>
                    
                        <th>Fixation Amount</th>
                        <th>Proposed Salary</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div> <!--/.Container-->

    @include('employee.modals.add.recomended-add')

@endsection

@push('scripts')

    <script>

        $(function() {
            var table= $('#recomended-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: 'recomendedDataTable/'+ $('#emp_id').val(),
                columns: [
                    { data: 'department.name', name: 'department.name' },
                    { data: 'designation.name', name: 'designation.name' },
                    { data: 'promotion_name', name: 'promotion_name' },
                    { data: 'change_designame', name: 'change_designame' },
                    { data: 'aditional_amt', name: 'aditional_amt' },
                    { data: 'fixation_amt', name: 'fixation_amt' },
                    { data: 'proposed_salary', name: 'proposed_salary' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, printable: false}
                ]
            });


            $("body").on("click", ".btn-new-recomended", function (e) {
                e.preventDefault();

                document.getElementById('n_recomended_emp_id').value= $('#emp_id').val();

            });

        });

        // Patient Name Update

        $(document).on('click', '.btn-title-data-update', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = 'title/update';

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

                    $('#modal-new-recomended').modal('hide');
                    $('#employees-table').DataTable().draw(false);

                }

            });
        });




        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });

        

    </script>
@endpush

