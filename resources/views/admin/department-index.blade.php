@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Division Information</h2>
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
                    <button type="button" class="btn btn-department btn-success" data-toggle="modal" data-target="#modal-new-department"><i class="fa fa-plus"></i>New Department</button>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12" style="overflow-x:auto;">
                <table class="table table-bordered table-hover table-striped table-success" id="departments-table">
                    <thead style="background-color: #b0b0b0">
                    <tr>
                        <th>ID</th>
                        <th>Division</th>
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

    @include('admin.modals.add.department-add')
    @include('admin.modals.edit.department-update')

@endsection

@push('scripts')

    <script>
        $(function() {
            var table= $('#departments-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: 'departmentDataTable',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'division.name', name: 'division.name' },
                    { data: 'name', name: 'name' },
                    { data: 'short_name', name: 'short_name' },
                    { data: 'headed_by', name: 'headed_by' },
                    { data: 'email', name: 'email' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, printable: false}
                ]
            });


            $(this).on("click", ".btn-department-edit", function (e) {
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



                var str = $(this).data('leave');


                str.toString().substr(0,1) == 1 ? $("#apply").prop("checked", true) : $("#apply").prop("checked", false);
                str.toString().substr(1,1) == 1 ? $("#acknowledge").prop("checked", true) : $("#acknowledge").prop("checked", false);
                str.toString().substr(2,1) == 1 ? $("#recommend").prop("checked", true) : $("#recommend").prop("checked", false);
                str.toString().substr(3,1) == 1 ? $("#approve").prop("checked", true) : $("#approve").prop("checked", false);



            });


            $("body").on("click", ".btn-create", function (e) {
                e.preventDefault();

                var url = $(this).data('remote');
                window.location.href = url;

            });



        });

        // Patient Name Update

        $(document).on('click', '.btn-patient-data-update', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = 'division/update';

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
                    $('#terms-table').DataTable().draw(false);

                }

            });
        });




        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });

        $( function() {
            $( "#started_from" ).datetimepicker({
                format:'d-m-Y',
                timepicker: false,
                closeOnDateSelect: true,
                inline:false
            });

        } );



        // $('.tabgroup > div').hide();
        // $('.tabgroup > div:first-of-type').show();
        // $('.tabs a').click(function(e){
        //     e.preventDefault();
        //     var $this = $(this),
        //         tabgroup = '#'+$this.parents('.tabs').data('tabgroup'),
        //         others = $this.closest('li').siblings().children('a'),
        //         target = $this.attr('href');
        //     others.removeClass('active');
        //     $this.addClass('active');
        //     $(tabgroup).children('div').hide();
        //     $(target).show();
        //
        // })


    </script>

@endpush