@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Prescription Preview</h2>
@endsection
@section('content')

    <style type="text/css" media="print">
        @page {
            size: auto;   /* auto is the initial value */
            margin: 0;  /* this affects the margin in the printer settings */
        }
    </style>


    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <div class="row">
        <!--  form area -->
        <div class="col-sm-12">
            <div  class="panel panel-default thumbnail">

                <div class="panel-heading no-print">
                    <div class="btn-group">
                        <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                        <button type="button" onclick="printDiv()" class="btn btn-danger" ><i class="fa fa-print"></i></button>
                    </div>
                </div>

                <div class="panel-body">

                    <div id="printpage">

                        <div style="position: relative; width: 100%; height: 10px"></div>

                        <div class="row">
                            <div class="container-fluid">

                                <table>
                                    
                                    <div>
                                        <tr style="line-height: 20px;">
                                            <td>বি আর বি হসঃ- </td>
                                            <td style="float: right;">তারিখঃ-  </td>
                                        </tr>
                                    </div>
                                    
                                    <div>
                                        <tr style="line-height: 30px;">
                                            <td>বরাবর, <br/>নামঃ {{ $data->name }}<br/> পিতাঃ {{ $data->fathers_name }}<br/> মাতাঃ {{ $data->mothers_name }}
                                            </td>
                                        </tr>
                                    </div>

                                    <div>
                                        <tr style="line-height: 30px;">

                                            <td width="25%"><strong> বর্তমান ঠিকানাঃ- </strong><br/> {{ $data->present_address }}</td>

                                            <td width="30%" style="float: left;"> <strong> স্থায়ী ঠিকানাঃ- </strong> <br/> {{ $data->permanent_address }}</td>
                                        </tr>
                                    </div>
                                    
                                </table>

                                <table>
                                    <tr style="line-height: 50px;">
                                        <td style="text-align: center; font-weight: bold;">বিষয়ঃ- নিয়োগ পত্র</td>

                                    </tr>

                                <tr style="line-height: 20px;">
                                    <td> আপনার এত ইং তারিখের আবেদন পত্র এবং তৎপরবর্তি সাক্ষাৎকার ও আলোচনা এবং আপনা কর্তৃক পুরনকৃত তথ্য এবং প্রতিষ্ঠানের নিয়ম নীতি সঠিকভাবে মানিয়া চলিবেন এই নিশ্চয়তার পরিপ্রেক্ষিতে ব্যবস্থাপনা কর্তৃপক্ষ সন্তুষ্টির সহিত নিম্ন বর্নিত সর্ত সাপেক্ষে {{ $data->department->name }} বিভাগের অধিনে দায়িত্ব পালনের জন্য আপনাকে {{ $data->designation->name }} পদে নিয়োগ প্রদান করিতেছে। আপনাকে প্রতি মাসে গ্রেড -{{ $data->salary_grade }} বেতনক্রম অনুযায়ী মোট {{ $data->regular_salary }} টাকা বেতন প্রদান করা হইবে। তবে প্রবেশন মেয়াদে আপনাকে প্রতিমাসে {{ $data->provision_salary }} টাকা মাত্র প্রদান করা হইবে। </td>
                                </tr>

                                <tr><td>-:শর্তাবলিঃ-</td></tr>
                                <tr>
                                    <td>
                                        ০১. আপনার চাকুরী বিদ্যমান স্রম আইন এবং প্রতিষ্ঠানের প্রচলিত নিয়ম অনুযায়ী পরিচালিত হইবে। 
                                    </td>
                                    
                                </tr>
                                </table>

                            </div>
                        </div>



                    </div>



                </div>
            </div>
        </div>
    </div>





@endsection

@push('scripts')

<script>
    function printDiv()
    {


        var newstr=document.getElementById("printpage").innerHTML;

        // var header='<header><div align="center"><h3 style="color:#EB5005"> Your HEader </h3></div><br></header><hr><br>'

//        var footer ="Your Footer";
        var htmlTableToPrint = '' +
            '<style media="print" type="text/css">' +
            'table th {' +
            'border:1px solid #000;' +
            'padding;0.5em;' +
            '}' +
            '</style>';

        var htmlToPrint = '' +
                '<style media="print">' +
            '   @page {' +
            '      size: auto;' +
            '      margin: 25mm 25mm 25mm 25mm;' +
            '  }' +
            '</style>'

        //You can set height width over here
        var popupWin = window.open('', '_blank', 'width=720,height=326');
        popupWin.document.open();
        popupWin.document.write('<link rel="stylesheet" href="{!! asset('assets/bootstrap-4.1.3/css/bootstrap.min.css') !!}" type="text/css" />');
        popupWin.document.write('<html> <body onload="window.print()">'+ htmlTableToPrint +  htmlToPrint + newstr + '</html>');
//        popupWin.document.write('<html> <body onload="window.print()">'+ newstr + '</html>' + footer);
        popupWin.document.close();
        return false;


    }
</script>
@endpush