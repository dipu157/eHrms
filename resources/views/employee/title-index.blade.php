@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Title Information</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>


    @include('partials.flash-message')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <button type="button" class="btn btn-title btn-success" data-toggle="modal" data-target="#modal-new-title"><i class="fa fa-plus"></i>New Title</button>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12" style="overflow-x:auto;">
                <table class="table table-bordered table-hover table-striped" id="titles-table">
                    <thead style="background-color: #b0b0b0">
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div> <!--/.Container-->

    @include('employee.modals.add.title-add')
    @include('employee.modals.edit.title-update')

@endsection

@push('scripts')

    <script>
        $(function() {
            var table= $('#titles-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: 'titleDataTable',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, printable: false}
                ]
            });


            $('#titles-table').on("click", ".btn-title-edit", function (e) {
                e.preventDefault();

                var data_id = $(this).data('rowid');
                var data_name = $(this).data('name');
                var data_description = $(this).data('description');

                document.getElementById('id-for-update').value=data_id;
                document.getElementById('name-for-update').value=data_name;
                document.getElementById('description-for-update').value=data_description;

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

                    $('#patient-update-modal').modal('hide');
                    $('#titles-table').DataTable().draw(false);

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