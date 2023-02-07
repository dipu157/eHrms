@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee Education Information <strong style="color: #980000">{!! $emp_data->full_name !!}</strong></h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>
    <link href="{!! asset('assets/css/bootstrap-imageupload.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap-imageupload.js') !!}"></script>

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <button type="button" class="btn btn-new-education btn-success" data-toggle="modal" data-target="#modal-new-education"><i class="fa fa-plus"></i>New Education</button>
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
                <table class="table table-bordered table-hover table-striped" id="educations-table">
                    <thead style="background-color: #b0b0b0">
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Institute</th>
                        <th>Passing Year</th>
                        <th>Result</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div> <!--/.Container-->

    @include('employee.modals.add.education-add')
    @include('employee.modals.edit.education-edit-modal')

@endsection

@push('scripts')

    <script>
        $(function() {
            var table= $('#educations-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: 'educationsDataTable/'+ $('#emp_id').val(),
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'degree_type', name: 'degree_type', defaultContent: "" },
                    { data: 'institution', name: 'institution' },
                    { data: 'passing_year', name: 'passing_year' },
                    { data: 'result', name: 'result' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, printable: false}
                ]
            });


            $("body").on("click", ".btn-new-education", function (e) {
                e.preventDefault();

                document.getElementById('n_education_emp_id').value= $('#emp_id').val();

            });

            $(this).on("click", ".btn-education-edit", function (e) {
                e.preventDefault();

                $('#name-for-update').val($(this).data('name'));
                $('#u_degree_type').val($(this).data('type'));
                $('#id-for-update').val($(this).data('rowid'));
                $('#u_institution').val($(this).data('institution'));
                $('#u_passing_year').val($(this).data('year'));
                $('#u_result').val($(this).data('result'));
                $('#u_achievement_date').val($(this).data('achievement'));
            });


            $(this).on("click", ".btn-education-delete", function (e) {
                e.preventDefault();
                if(confirm("Are you sure you want to Delete this?")){

                    var url = $(this).data('remote');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {method: '_POST', submit: true},

                        error: function (request) {

                        },
                        success: function (data) {
                            alert(data.success);
                            $('#educations-table').DataTable().draw(false);
                        }

                    }).always(function (data) {
                        $('#educations-table').DataTable().draw(false);
                    });

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
