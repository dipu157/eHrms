@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">All Type of Report</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-header">
                <h3 style="font-weight: bold">All Kind of Report</h3>
            </div>

            <div class="card-body">
                
                <table class="table table-info table-striped table-bordered">

                    <tr>
                        <td><a href="{!! url('admin/report/'.'divList') !!}">Division List</a></td>
                    </tr>

                    <tr>
                        <td><a href="{!! url('admin/report/'.'divdeptList') !!}">Division Wise Department List</a></td>
                    </tr>

                    <tr>
                        <td><a href="{!! url('admin/report/'.'deptList') !!}">Only Department List</a></td>
                    </tr>

                    <tr>
                        <td><a href="{!! url('admin/report/'.'deptsecList') !!}">Department wise Section List</a></td>
                    </tr>

                    <tr>
                        <td><a href="{!! url('admin/report/'.'secList') !!}">Only Section List</a></td>
                    </tr>

                    <tr>
                        <td><a href="{!! url('admin/report/'.'divDeptSecList') !!}">Division, Department & Section List</a></td>
                    </tr>

                    <tr>
                        <td><a href="{!! url('admin/report/'.'desigList') !!}">Designation List</a></td>
                    </tr>

                    <tr>
                        <td><a href="{!! url('admin/report/'.'locationList') !!}">Duty Location List</a></td>
                    </tr>

                    <tr>
                        <td><a href="{!! url('admin/report/'.'shiftList') !!}">All Shift List</a></td>
                    </tr>

                    <tr>
                        <td><a href="{!! url('admin/report/'.'leaveList') !!}">All Leave List</a></td>
                    </tr>

                    <tr>
                        <td><a href="{!! url('admin/report/'.'workingStatusList') !!}">All Working Status List</a></td>
                    </tr>
                </table>

            </div>
        </div>


    </div> <!--/.Container-->

@endsection
