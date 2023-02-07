 <!-- Bootstrap CSS-->
    <link href="{!! asset('assets/bootstrap-4.1.3/css/bootstrap.min.css') !!}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome CSS-->
    <link href="{!! asset('assets/font-awesome-4.7.0/css/font-awesome.min.css') !!}" rel="stylesheet" type="text/css" />
    <!-- theme stylesheet-->
    <link href="{!! asset('assets/css/style.default.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! asset('assets/jquery-ui-1.12.1/jquery-ui.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! asset('assets/css/mdb.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! asset('assets/tabs/css/style.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <script type="text/javascript" src="{!! asset('assets/js/bootstrap3-typeahead.js') !!}"></script>

    <meta http-equiv="refresh" content="30">
    <div class="container-fluid">


        <div class="row">
            <div class="col-xl-12">              
                <div class="card">
                    <table>
                        <tr>
                            <td width="100%"><img style="text-align: center;width: 400px; height: 70px;" src="{!! asset('/assets/images/Logobrb.png') !!}" ></td>
                        </tr>
                    </table>
                    <div style="text-align: center; font-weight: bold; font-size:46px;" class="card-header">TODAY'S OT LIST</div>

                    <div class="card-body">
                        <table class="table table-bordered table-info table-responsive table-striped"  style="width:100%">
                            <thead>
                            <tr>                               
                                <th style="font-weight: bold; width: 10%; font-size: 28px;">UHID</th>
                                <th style="font-weight: bold; width: 27%; text-align: center; font-size: 32px;">Patient Name</th>
                                <th style="font-weight: bold; width: 29%; text-align: center; font-size: 32px;">Doctor Name</th>
                                <th style="font-weight: bold; width: 18%; font-size: 32px;">Description</th>
                                <th style="font-weight: bold; width: 16%; text-align: right; font-size: 32px;">OT Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($sl = 1)
                            @foreach($data as $i=>$row)
                                <tr>                                   
                                    <td style="font-weight: bold; font-size: 22px;">{!! $row->ot_number !!} </td>
                                    <td style="font-weight: bold; font-size: 22px;">{!! $row->patient_name !!} </td>
                                    <td style="font-weight: bold; font-size: 22px;">{!! $row->doctor_name !!}</td>
                                    <td style="font-weight: bold; font-size: 22px;">{!! $row->description !!}</td>
                                    <td style="font-weight: bold; font-size: 22px;">{!! $row->ot_status == 'P' ? '...' : ($row->ot_status == "C" ? "OT Done, You Will be call soon" : 'ON Going') !!}</td>
                                </tr>
                                @php($sl++)
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div> <!--/.Container-->


    <script type="text/javascript" src="{!! asset('assets/bootstrap-4.1.3/js/bootstrap.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('assets/js/front.js') !!}"></script>
