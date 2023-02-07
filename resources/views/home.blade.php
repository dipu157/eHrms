@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Dashboard</h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

    <div class="container-fluid">

        <div class="alert alert-danger justify-content-center" role="alert">
            <strong>Important! <br/>  </strong> <strong class="blinking font-weight-bold">১। মাস শুরু হওয়ার আগেই সকল কর্মকর্তা/কর্মচারি গণকে তাদের রোস্টার সঠিক ভাবে ইনপুট করার জন্য বিশেষ ভাবে অনুরোধ করা হলো। এবং মাস শেষ হওয়ার আগেই রোস্টার এপ্রুভ করতে অনুরোধ করা হচ্ছে। সঠিক ভাবে রোস্টার ইনপুট না দিলে সংশ্লিস্ট অফিসিয়াল অনুপস্থিত হিসাবে গন্য হবে।
            </strong>
        </div>

        <div class="alert alert-danger justify-content-center" role="alert">
            <strong></strong> <strong class="blinking font-weight-bold">২। Duty Date  এর ৩ দিনের ভিতর Overtime Data এখানে এন্ট্রি করতে হবে।
            </strong>
        </div>

        <div class="alert alert-danger justify-content-center" role="alert">
            <strong></strong> <strong class="blinking font-weight-bold">৩। সময়মত Leave Application, Acknowledge & Recommend করতে হবে। নাহলে
                সংশ্লিস্ট অফিসিয়াল সেই দিন অনুপস্থিত হিসাবে গন্য হবে।
            </strong>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        REQUESTS
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped table-success">
                            <tbody>


                                @if($ack_leave > 0)

                                    <button type="button" class="btn btn-info btn-acknowledge">
                                        <strong style="color: #980000">Your Colleague Need Your Kind Attention</strong><span class="badge badge-light">{!! $ack_leave !!}</span>
                                    </button>

                                    <img src="{!! asset('assets/images/ackLeave.jpg') !!}" width="400px" height="400px" class="rounded-circle" alt="Cinque Terre">

                                @endif


                                @if($rec_count > 0)

                                    <button type="button" class="btn btn-default btn-recommend">
                                        <strong style="color: #980000">Some One Need Your Kind Recommendation</strong><span class="badge badge-light">{!! $rec_count !!}</span>
                                    </button>

                                    <img src="{!! asset('assets/images/recommendLeave.jpg') !!}" width="400px" height="200px" class="rounded-circle" alt="Cinque Terre">

                                @endif


                            </tbody>


                        </table>

                    </div>
                    <div class="card-footer text-muted">
                        {!! \Carbon\Carbon::now()->format('d-m-Y H:i') !!}
                    </div>
                </div>
            </div>


            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header text-center">
                        NOTICE BOARD
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped table-primary">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Details</th>
                                    <th>VIEW</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($notices as $i=>$row)
                                <tr>
                                    <td>{!! \Carbon\Carbon::parse($row->notice_date)->format('d-M-Y') !!}</td>
                                    <td>{!! $row->title !!}</td>
                                    <td>{!! $row->description !!}</td>
                                    <td><button type="button" id="notice-id-{!! $i !!}" value="{!! $row->id !!}" class="btn btn-sm btn-primary btn-notice-view">VIEW</button></td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- Dashboard Counts Section-->
@endsection

@push('scripts')

    <script>
        $(function() {

            $(document).on("click", ".btn-acknowledge", function (e) {
                e.preventDefault();

                window.location.href = 'leave/acknowledgeIndex';

            });

            $(document).on("click", ".btn-recommend", function (e) {
                e.preventDefault();

                window.location.href = 'leave/recommendIndex';

            });


            $(document).on("click", ".btn-notice-view", function (e) {
                e.preventDefault();

                input_id = $(this).attr('id').split('-');
                item_id = parseInt(input_id[input_id.length - 1]);

                window.location.href = 'notice/view/'+ $('#notice-id-' + item_id).val();

            });

        });

        idleTimer();


        function blinker() {
            $('.blinking').fadeOut(500);
            $('.blinking').fadeIn(500);
        }
        setInterval(blinker, 3000);




    </script>






@endpush