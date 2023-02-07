@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Notice Information</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <button type="button" class="btn btn-notice btn-success" data-toggle="modal" data-target="#modal-new-notice"><i class="fa fa-plus"></i>New</button>
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
                <table class="table table-bordered table-hover table-striped" id="notices-table">
                    <thead style="background-color: #b0b0b0">
                    <tr>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Sender</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div> <!--/.Container-->

    @include('notice.modals.new-notice-form')
    @include('notice.modals.notice-file-upload-form')

@endsection

@push('scripts')

    <script>
        $(function() {
            var table= $('#notices-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: 'noticeDataTable',
                columns: [
                    { data: 'notice_date', name: 'notice_date' },
                    { data: 'title', name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'sender', name: 'sender' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, printable: false}
                ]
            });


            $(this).on("click", ".btn-file-upload", function (e) {
                e.preventDefault();

                document.getElementById('id-for-update').value=$(this).data('rowid');
            });


            // $("body").on("click", ".btn-create", function (e) {
            //     e.preventDefault();
            //
            //     var url = $(this).data('remote');
            //     window.location.href = url;
            //
            // });

            $(this).on("click", ".btn-file-view", function (e) {
                e.preventDefault();

                window.location.href = $(this).data('remote');

            });



        });

        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });

    </script>

@endpush