@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Division Information</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <button type="button" class="btn btn-leave-master btn-success" data-toggle="modal" data-target="#modal-new-leave-master"><i class="fa fa-plus"></i>New</button>
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
                <table class="table table-bordered table-hover table-striped" id="leaves-table">
                    <thead style="background-color: #b0b0b0">
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Particulars</th>
                        <th>Limit</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div> <!--/.Container-->

    @include('leave.modals.new-leave-master')
{{--    @include('training.modals.edit-training-form')--}}

@endsection

@push('scripts')

    <script>
        $(function() {
            var table= $('#leaves-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: 'leaveMasterDataTable',
                columns: [
                    { data: 'short_code', name: 'short_code' },
                    { data: 'name', name: 'name' },
                    { data: 'particulars', name: 'particulars' },
                    { data: 'yearly_limit', name: 'yearly_limit' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, printable: false}
                ]
            });


            $(this).on("click", ".btn-training-edit", function (e) {
                e.preventDefault();

                document.getElementById('id-for-update').value=$(this).data('rowid');
                document.getElementById('u_title').value=$(this).data('title');
                document.getElementById('u_description').value=$(this).data('description');
                document.getElementById('u_trainer').value=$(this).data('trainer');
                document.getElementById('u_start_from').value=$(this).data('start');
                document.getElementById('u_end_on').value=$(this).data('end');
                document.getElementById('u_participants').value=$(this).data('participants');
                document.getElementById('u_attended').value=$(this).data('attended');
                document.getElementById('u_closing_notes').value=$(this).data('closing');
                $(this).data('status') === 1 ? $("#status-open").attr('checked', 'checked') : $("#status-close").attr('checked', 'checked')
            });


            $("body").on("click", ".btn-create", function (e) {
                e.preventDefault();

                var url = $(this).data('remote');
                window.location.href = url;

            });

            $(this).on("click", ".btn-view", function (e) {
                e.preventDefault();

                window.location.href = $(this).data('remote');;

            });



        });

        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });

    </script>

@endpush