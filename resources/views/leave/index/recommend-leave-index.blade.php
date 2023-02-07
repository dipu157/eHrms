@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Leave Recommendation</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    {{--<link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />--}}
    {{--<script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>--}}
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap3-typeahead.js') !!}"></script>


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-md-12" style="overflow-x:auto;">
                <table class="table table-bordered table-hover table-striped" id="recommend-leaves-table">
                    <thead style="background-color: #b0b0b0">
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Nods</th>
                        <th>Type</th>
                        <th>Alternate</th>
                        {{--<th>Reason</th>--}}
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div> <!--/.Container-->

@endsection

@push('scripts')

    <script>
        $(function() {
            var table= $('#recommend-leaves-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: 'recommendDataTable',
                columns: [
                    { data: 'image', name: 'image' },
                    { data: 'name', name: 'name' },
                    { data: 'leave_date', name: 'leave_date' },
                    { data: 'nods', name: 'nods' },
                    { data: 'leave_type', name: 'leave_type' },
                    { data: 'alternate', name: 'alternate' },
                    // { data: 'reason', name: 'reason' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, printable: false}
                ],
                columnDefs: [
                    { width: 50, targets: 0 },
                    { width: 150, targets: 1 },
                    { width: 150, targets: 2 }
                ],
            });

            $(this).on("click", ".btn-view", function (e) {
                e.preventDefault();

                window.location.href = $(this).data('remote');

            });


            $(this).on("click", ".btn-recommend", function (e) {
                e.preventDefault();

                if(confirm("Are you sure you want to recommend this?")){

                    // window.location.href = $(this).data('remote');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var url = $(this).data('remote');
                    // confirm then
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {method: '_POST', submit: true},

                        error: function (request, status, error) {
                            alert(request.responseText);
                        },
                        success: function (request, status, error) {
                            $('#recommend-leaves-table').DataTable().draw(false);
                        }

                    }).always(function (data) {
                        $('#recommend-leaves-table').DataTable().draw(false);
                    })
                }
                else{
                    return false;
                }
            });

            $(this).on("click", ".btn-reject", function (e) {
                e.preventDefault();

                if(confirm("Are you sure you want to reject this?")){

                    // window.location.href = $(this).data('remote');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var url = $(this).data('remote');
                    // confirm then
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {method: '_POST', submit: true},

                        error: function (request, status, error) {
                            alert(request.responseText);
                        },
                        success: function (request, status, error) {
                            alert('Leave has been rejected');
                        }

                    }).always(function (data) {
                        $('#recommend-leaves-table').DataTable().draw(false);
                    })
                }
                else{
                    return false;
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