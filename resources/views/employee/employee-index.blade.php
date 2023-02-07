@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Employee Information</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>
    <link href="{!! asset('assets/css/bootstrap-imageupload.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap-imageupload.js') !!}"></script>


    <script type="text/javascript">

        $(document).ready(function() {

            $('select[name="pr_district"]').on('change', function() {
                var district = $(this).val();
                if(district) {
                    $.ajax({
                        url: 'postcode/ajax/' + district,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('select[name="pr_post_code"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="pr_post_code"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }else{
                    $('select[name="pr_post_code"]').empty();
                }
            });



            $('select[name="pm_district"]').on('change', function() {
                var district = $(this).val();
                if(district) {
                    $.ajax({
                        url: 'postcode/ajax/' + district,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('select[name="pm_post_code"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="pm_post_code"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }else{
                    $('select[name="pm_post_code"]').empty();
                }
            });


        });

    </script>


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <button type="button" class="btn btn-employee btn-success" data-toggle="modal" data-target="#modal-new-employee"><i class="fa fa-plus"></i>New Employee</button>
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
                <table class="table table-bordered table-hover table-striped" id="employees-table">
                    <thead style="background-color: #b0b0b0">
                    <tr>
                        <th></th>
                        <th>Photo</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Designation <br/><span style="color: #0c5460">Department</span></th>
                        <th>Mobile</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div> <!--/.Container-->

    @include('employee.modals.add.employee-add')
    @include('employee.modals.edit.photo-upload')
    @include('employee.modals.add.card-print-modal')

@endsection

@push('scripts')

    <script>

        $(function() {
            var table= $('#employees-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: 'employeeDataTable',
                columns: [
                    { data: 'id', name: 'id', visible: false },
                    { data: 'showimage', name: 'showimage'},
                    { data: 'emp_id', name: 'emp_id', defaultContent: ""},
                    { data: 'full_name', name: 'full_name'},
                    { data: 'designation', name: 'designation'},
                    { data: 'mobile', name: 'mobile' },
                    // { data: 'user.name', name: 'user.name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, printable: false}
                ],
                order: [ [0, 'desc'] ]
            });

            $(this).on("click", ".btn-view", function (e) {
                e.preventDefault();

                var url = $(this).data('remote');
                window.location.href = url;

            });

            $(this).on("click", ".btn-employee-edit", function (e) {
                e.preventDefault();

                var url = $(this).data('remote');
                window.location.href = url;

            });


            $(this).on("click", ".btn-history", function (e) {
                e.preventDefault();

                var url = $(this).data('remote');
                window.location.href = url;

            });
$(this).on("click", ".btn-recomended", function (e) {
                e.preventDefault();

                var url = $(this).data('remote');
                window.location.href = url;

            });

            $(this).on("click", ".btn-education", function (e) {
                e.preventDefault();

                var url = $(this).data('remote');
                window.location.href = $(this).data('remote');

            });

            $(this).on("click", ".btn-appLetter", function (e) {
                e.preventDefault();

                var url = $(this).data('remote');
                window.location.href = $(this).data('remote');

            });

            $(this).on("click", ".btn-punish", function (e) {
                e.preventDefault();

                var url = $(this).data('remote');
                window.location.href = $(this).data('remote');

            });


            $(this).on("click", ".btn-posting", function (e) {
                e.preventDefault();

                var url = $(this).data('remote');
                window.location.href = $(this).data('remote');

            });

            $(this).on("click", ".btn-promotion", function (e) {
                e.preventDefault();

                var url = $(this).data('remote');
                window.location.href = $(this).data('remote');

            });

            $(this).on("click", ".btn-idcard", function (e) {
                e.preventDefault();

                var emp_id = $(this).data('rowid');

                document.getElementById('emp_id_card').value = emp_id;
                $('#modal-card-print').modal('show');

                // var url = $(this).data('remote');
                // window.location.href = $(this).data('remote');

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
                    $('#employees-table').DataTable().draw(false);

                }

            });
        });




        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });


        function imageFileValidation(){
            var fileInput = document.getElementById('imagefilename');
            var filePath = fileInput.value;
            // var allowedExtensions = /(\.jpg)$/i;

            var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

            if(!allowedExtensions.exec(filePath)){
                alert('Please upload file having extensions .jpg, .jpeg or .png only.');
                fileInput.value = '';
                return false;
            }else{
                //Image preview
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'" width="100px"; height="100px"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }
        }


    </script>
@endpush