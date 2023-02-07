@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Applicats Information View</h2>
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



        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: rgba(133,0,0,0.34)">Search By Submission Date</div>

                    <div class="card-body">

                        <form class="form-inline" id="search-form-date" method="get" action="{{ route('bioData/searchIndex') }}">

                            <div class="form-group row">
                                <label for="from_date" class="col-md-3 col-form-label text-md-right">Submission Date</label>
                                <div class="col-md-4">
                                    <input type="date" name="from_date" id="from_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="to_date" class="col-md-2 col-form-label text-md-right">To</label>
                                <div class="col-md-4">
                                    <input type="date" name="to_date" id="to_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required />
                                </div>
                            </div>

                            <input type="hidden" value="submission_date" name="submission_date"/>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="preview">Preview</button>
                                </div>
                                <div class="col-md-5 text-md-right">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                                </div>
                            </div>

                            {{--<button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search">Submit</i></button>--}}
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Search By Post</div>

                    <div class="card-body">

                        <form class="form-inline" id="search-form-post" method="get" action="{{ route('bioData/searchIndex') }}">

                            <div class="form-group row">
                                <label for="applied_post" class="col-md-2 col-form-label text-md-right">Post</label>
                                <div class="col-md-4">
                                    {!! Form::select('circular_id',$circulars,null,array('id'=>'circular_id','class'=>'form-control','autofocus')) !!}
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="preview">Preview</button>
                                </div>
                                <div class="col-md-5 text-md-right">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                                </div>
                            </div>
                        </form>




                    </div>
                </div>
            </div>
        </div>

       
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: rgba(65,148,168,0.46)">Search By Reference</div>

                    <div class="card-body">

                        <form class="form-inline" id="search-form-reference" method="get" action="{{ route('bioData/searchIndex') }}">

                            <div class="form-group row">
                                <label for="reference_name" class="col-md-3 col-form-label text-md-right">Reference</label>
                                <div class="col-md-3">
                                    <input type="text" name="reference_name" id="reference_name" class="form-control" required />
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="preview">Preview</button>
                                </div>
                                <div class="col-md-5 text-md-right">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                                </div>
                            </div>

                            {{--<button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search">Submit</i></button>--}}
                        </form>

                    </div>
                </div>
            </div>
        </div>


         <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Search By status</div>

                    <div class="card-body">

                        <form class="form-inline" id="search-form-post" method="get" action="{{ route('bioData/searchIndex') }}">

                            <div class="form-group row">
                                <label for="app_status_id" class="col-md-2 col-form-label text-md-right">Status</label>
                                <div class="col-md-4">
                                    {!! Form::select('app_status_id',$app_status_list,null,array('id'=>'app_status_id','class'=>'form-control','autofocus')) !!}
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary" name="action" value="preview">Preview</button>
                                </div>
                                <div class="col-md-5 text-md-right">
                                    <button type="submit" class="btn btn-secondary" name="action" value="print">Print</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @if(!empty($data))

            <div class="card" style="max-width: 100rem;">
                <div class="card-header">
                    <h3 style="font-weight: bold">{!! $title !!}</h3>
                </div>
                <div class="card-body">

                    <table class="table table-info table-striped table-bordered">

                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Submission<br/>Date</th>
                            <th>ID</th>
                            <th>Name</th>
                            <td>Mobile<br/>No</td>
                            <th>Applied<br/>Post</th>
                            <th>Speciality</th>
                            <th>Reference<br/>Name</th>
                            <th>Interview<br/>Status</th>
                            <th>Joining<br/>Date</th>
                            <th>remarks</th>

                        </tr>
                        </thead>
                        <tbody>


                        @foreach($data as $i=>$row)

                            <tr>
                                <td>{!! $i+1 !!}</td>
                                <td>{!! $row->submission_date !!}</td>
                                <td>{!! $row->issue_number !!}</td>
                                <td>{!! $row->name !!}</td>
                                <td>{!! $row->mobile_no !!}</td>
                                <td>{!! $row->circular->circular_name !!}</td>
                                <td>{!! $row->speciality !!}</td>
                                <td>{!! $row->reference_name !!}</td>
                                <td>{!! $row->applicantstatus->status_name !!}</td>
                                <td>{!! $row->joining_date !!}</td>
                                <td>{!! $row->remarks !!}</td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
            {{--@endforeach--}}
        @endif


    </div> <!--/.Container-->

@endsection
