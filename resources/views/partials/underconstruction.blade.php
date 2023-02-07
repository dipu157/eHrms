@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Underconstruction</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap3-typeahead.js') !!}"></script>
    {{--<link href="{!! asset('assets/css/bootstrap-imageupload.css') !!}" rel="stylesheet" type="text/css" />--}}
    {{--    <script type="text/javascript" src="{!! asset('assets/js/bootstrap-imageupload.js') !!}"></script>--}}

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-right">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>

        </div>

        <img class="img-fluid" src="{!! asset('assets/images/page-under-construction.jpg') !!}" alt="Under Construction">


        {{--<picture>--}}
            {{--<source srcset="..." type="image/svg+xml">--}}
            {{--<img src="{!! asset('assets/images/page-under-construction.jpg') !!}" class="img-fluid img-thumbnail" alt="...">--}}
        {{--</picture>--}}

    </div> <!--/.Container-->

@endsection



