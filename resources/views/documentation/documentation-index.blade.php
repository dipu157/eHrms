@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">All Document</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <button type="button" class="btn btn-documentation btn-success" data-toggle="modal" data-target="#modal-new-documentation"><i class="fa fa-plus"></i>New</button>
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
                <table class="table table-bordered table-hover table-striped" id="documents-table">
                    <thead style="background-color: #b0b0b0">
                    <tr>
                        <th>ID</th>
                        <th>Document Type</th>
                        <th>Document Date</th>
                        <th>Doctor Name</th>
                        <th>Doctor Dept.</th>
                        <th>View</th>                        
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div> <!--/.Container-->

    @include('documentation.modals.new-document-form')
    @include('documentation.modals.edit-document-form')
    @include('documentation.modals.documentFile-upload-form')

    @endsection

    
@push('scripts')

<script>
    $(function() {
        var table= $('#documents-table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: 'documentDataTable',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'document_type.name', name: 'document_type.name' },
                { data: 'document_date', name: 'document_date' },
                { data: 'doctor_name', name: 'doctor_name' },
                { data: 'doctor_department_name', name: 'doctor_department_name' },
                { data: 'view', name: 'view' , orderable: false, searchable: false, printable: false},
                { data: 'action', name: 'action', orderable: false, searchable: false, printable: false}
            ]
        });


        $(this).on("click", ".btn-file-upload", function (e) {
            e.preventDefault();

            document.getElementById('id-for-upload').value=$(this).data('rowid');
        });

        $(this).on("click", ".btn-document-edit", function (e) {
                e.preventDefault();

                var url = $(this).data('remote');
                window.location.href = url;

            });

        $(this).on("click", ".btn-file-view", function (e) {
            e.preventDefault();

            window.location.href = 'view/'+$(this).data('rowid');
            //window.location.href = 'view/'+ $('#document-id').val();

        });
    });

    $(function (){
        $(document).on("focus", "input:text", function() {
            $(this).select();
        });
    });

</script>

@endpush