@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee History Information</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>
    <link href="{!! asset('assets/css/bootstrap-imageupload.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap-imageupload.js') !!}"></script>

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <button type="button" class="btn btn-new-history btn-success" data-toggle="modal" data-target="#modal-new-history"><i class="fa fa-plus"></i>Add Employee History</button>
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
                <table class="table table-bordered table-hover table-striped" id="historys-table">
                    <thead style="background-color: #b0b0b0">
                    <tr>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div> <!--/.Container-->

    @include('employee.modals.add.history-add')

@endsection

@push('scripts')

    <script>

        $(function() {
            var table= $('#historys-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: 'historyDataTable/'+ $('#emp_id').val(),
                columns: [
                    { data: 'department.name', name: 'department.name' },
                    { data: 'designation.name', name: 'designation.name' },
                    { data: 'descriptions', name: 'descriptions' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, printable: false}
                ]
            });


            $("body").on("click", ".btn-new-history", function (e) {
                e.preventDefault();

                document.getElementById('n_history_emp_id').value= $('#emp_id').val();

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

                    $('#modal-new-history').modal('hide');
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

