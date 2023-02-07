@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Update Salary For <span style="font-weight: bold"> {!! $salary->employee_id !!} : {!! $salary->professional->personal->full_name !!} </span></h2>
@endsection
@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>
    <link href="{!! asset('assets/css/bootstrap-imageupload.css') !!}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{!! asset('assets/js/bootstrap-imageupload.js') !!}"></script>

    <link href="{!! asset('assets/css/jquery.datetimepicker.min.css') !!}" rel="stylesheet" type="text/css" />

    <link href="{!! asset('assets/tabs/css/style.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! asset('assets/css/pretty-checkbox.css') !!}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>


    @include('partials.flash-message')

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="pull-left">
                    <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
                </div>
            </div>
        </div>

        <form class="form-horizontal" id="salary-update-form" role="form" method="POST" action="">

        <div class="row justify-content-center">


            <div class="row">
                <div class="col-sm-6">
                    <div class="card text-primary bg-gray border-primary">

                        <div class="card-header">Salary Scale : {!! $salary->employee_id !!} : {!! $salary->professional->personal->full_name !!}</div>
                        <div class="card-body">

                            <div class="form-group row" id="md-name">
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="hidden" name="employee_id" id="employee_id" value="{!! $salary->employee_id !!}" class="form-control" required>
                                        <input type="hidden" name="row_id" id="row_id" value="{!! $salary->id !!}" class="form-control" required>
                                        <input type="hidden" name="period_id" id="period_id" value="{!! $salary->period_id !!}" class="form-control" required>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row" id="md-name">
                                <label for="basic" class="col-sm-4 col-form-label text-md-right">Basic</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="basic" id="basic" class="form-control" value="{!! $salary->basic !!}" readonly required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row" id="md-name">
                                <label for="house_rent" class="col-sm-4 col-form-label text-md-right">House Rent</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="house_rent" id="house_rent" value="{!! $salary->house_rent !!}" readonly class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row" id="md-name">
                                <label for="Medical" class="col-sm-4 col-form-label text-md-right">Medical</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="medical" id="medical" value="{!! $salary->medical !!}" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="Entertainment" class="col-sm-4 col-form-label text-md-right">Entertainment</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="entertainment" value="{!! $salary->entertainment !!}" id="entertainment" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="Conveyance" class="col-sm-4 col-form-label text-md-right">Conveyance</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="conveyance" value="{!! $salary->conveyance !!}" id="conveyance" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="other_allowance" class="col-sm-4 col-form-label text-md-right">Other Allowance</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="other_allowance" value="{!! $salary->other_allowance !!}" id="other_allowance" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="gross_salary" class="col-sm-4 col-form-label text-md-right">Gross Salary</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="gross_salary" value="{!! $salary->gross_salary !!}" id="gross_salary" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card text-primary bg-gray border-primary">

                        <div class="card-header">Overtime : {!! $salary->employee_id !!} : {!! $salary->professional->personal->full_name !!}</div>

                        <div class="card-body">


                            <div class="form-group row" id="md-name">
                                <label for="overtime_hour" class="col-sm-4 col-form-label text-md-right">Overtime Hour</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="overtime_hour" id="overtime_hour" value="{!! $salary->overtime_hour !!}" class="form-control" required readonly>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group row" id="md-name">
                                <label for="overtime_amount" class="col-sm-4 col-form-label text-md-right">Overtime Amount</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="overtime_amount" value="{!! $salary->overtime_amount !!}" id="overtime_amount" class="form-control" required readonly>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>



                    <div class="card text-primary bg-gray border-primary">

                        <div class="card-header">AREAR : {!! $salary->employee_id !!} : {!! $salary->professional->personal->full_name !!}</div>

                        <div class="card-body">




                            <div class="form-group row" id="md-name">
                                <label for="arear_amount" class="col-sm-4 col-form-label text-md-right">Arear Amount</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="arear_amount" value="{!! $salary->arear_amount !!}" id="arear_amount" class="form-control" required readonly>
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>


                </div>



                <div class="col-sm-6">
                    <div class="card text-primary bg-gray border-primary">

                        <div class="card-header">Deductions : {!! $salary->employee_id !!} : {!! $salary->professional->personal->full_name !!}</div>

                        <div class="card-body">

                            <div class="form-group row" id="md-name">
                                <label for="income_tax" class="col-sm-4 col-form-label text-md-right">Tax Amount</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="income_tax" value="{!! $salary->income_tax !!}" id="income_tax" class="form-control" required readonly>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row" id="md-name">
                                <label for="advance" class="col-sm-4 col-form-label text-md-right">Advance</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" value="{!! $salary->advance !!}" name="advance" id="advance" class="form-control" required readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row" id="md-name">
                                <label for="mobile_others" class="col-sm-4 col-form-label text-md-right">Mobile & Others</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" value="{!! $salary->mobile_others !!}" name="mobile_others" id="mobile_others" class="form-control"readonly >
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="food_charge" class="col-sm-4 col-form-label text-md-right">Food</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" value="{!! $salary->food_charge !!}" name="food_charge" id="food_charge" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="stamp_fee" class="col-sm-4 col-form-label text-md-right">Stamp</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" value="{!! $salary->stamp_fee !!}" name="stamp_fee" id="stamp_fee" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="card text-primary bg-gray border-primary">

                        <div class="card-header">Others : {!! $salary->employee_id !!} : {!! $salary->professional->personal->full_name !!}</div>

                        <div class="card-body">

                            <div class="form-group row" id="md-name">
                                <label for="bank_id" class="col-sm-4 col-form-label text-md-right">Bank Name</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        {!! Form::select('bank_id',$banks,$salary->bank_id,['id'=>'bank_id','class'=>'form-control']) !!}

                                    </div>
                                </div>
                            </div>


                            <div class="form-group row" id="md-name">
                                <label for="account_no" class="col-sm-4 col-form-label text-md-right">Account No</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="account_no" value="{!! $salary->account_no !!}" id="account_no" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row" id="md-name">
                                <label for="tds_id" class="col-sm-4 col-form-label text-md-right">TDS Type</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        {!! Form::select('tds_id',['T'=>'TDS','C'=>'Cons TDS','N'=>'No TDS'],$salary->tds,['id'=>'tds_id','class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>


                    <div class="card text-primary bg-gray border-primary">

                        <div class="card-header">Increment : {!! $salary->employee_id !!} : {!! $salary->professional->personal->full_name !!}</div>

                        <div class="card-body">

                            {{--<div class="form-group row" id="md-name">--}}
                                {{--<label for="" class="col-sm-4 col-form-label text-md-right">Months</label>--}}
                                {{--<div class="col-sm-8">--}}
                                    {{--<div class="input-group mb-3">--}}
                                        {{--<input type="text" value="{!! $salary->basic !!}" name="account_no" id="account_no" class="form-control" required>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}



                            {{--<div class="form-group row" id="md-name">--}}
                                {{--<label for="cash_salary" class="col-sm-4 col-form-label text-md-right">Increment</label>--}}
                                {{--<div class="col-sm-8">--}}
                                    {{--<div class="input-group mb-3">--}}
                                        {{--<input type="text" name="cash_salary" value="{!! $salary->basic !!}" id="cash_salary" class="form-control" required>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="form-group row" id="md-name">
                                <label for="increment_amt" class="col-sm-4 col-form-label text-md-right">Increment Amount</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input type="text" name="increment_amt" value="{!! $salary->increment_amt !!}" id="increment_amt" class="form-control" required>
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>




                </div>
            </div>


            <div class="col-sm-12">
            <div class="card text-primary bg-gray border-primary">

                <div class="card-header">Calculation : {!! $salary->employee_id !!} : {!! $salary->professional->personal->full_name !!}</div>

                <div class="card-body">

                    <div class="form-group row" id="md-name">
                        <label for="paid_days" class="col-sm-4 col-form-label text-md-right">Days To Be Paid</label>
                        <div class="col-sm-8">
                            <div class="input-group mb-3">
                                <input type="text" name="paid_days" id="paid_days" value="{!! $salary->paid_days !!}" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row" id="md-name">
                        <label for="net_salary" class="col-sm-4 col-form-label text-md-right">Net Salary</label>
                        <div class="col-sm-8">
                            <div class="input-group mb-3">
                                <input type="text" name="net_salary" id="net_salary" value="{!! $salary->net_salary !!}" class="form-control" required>
                            </div>
                        </div>
                    </div>



                    <div class="form-group row" id="md-name">
                        <label for="cash_salary" class="col-sm-4 col-form-label text-md-right">Cash Salary</label>
                        <div class="col-sm-8">
                            <div class="input-group mb-3">
                                <input type="text" name="cash_salary" value="{!! $salary->cash_salary !!}" id="cash_salary" class="form-control" required>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row" id="md-name">
                        <label for="cash_salary" class="col-sm-4 col-form-label text-md-right">Held Up</label>
                        <div class="col-sm-8">
                            <div class="input-group mb-3">

                                {!! Form::checkbox('withheld',$salary->id, $salary->withheld == true ? true : false) !!}

                            </div>
                        </div>
                    </div>

                    <div class="form-group row" id="md-name">
                        <label for="reason" class="col-sm-4 col-form-label text-md-right">Held Up Reason</label>
                        <div class="col-sm-8">
                            <div class="input-group mb-3">
                                <input type="text" name="reason" value="{!! $salary->reason ?? ' ' !!}" id="reason" class="form-control">
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            </div>



        </div>

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success"><i class="fa fa-user-plus"></i> Submit</button>
                </div>
            </div>



        </form>

    </div> <!--/.Container-->

@endsection

@push('scripts')

    <script>

        $('#salary-update-form').on("submit", function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // alert('here');

            var url = 'updateSalary';
            // window.location.href = url;
            // confirm then

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: $(this).serialize(),

                error: function (request, status, error) {
                    alert(request.responseText);
                },

                success: function (data) {

                    document.getElementById('net_salary').value = data.net_salary;
                    alert('Data Successfully Updated');
                },

            })

        });


        // $("#salary-update-form").submit(function(e) {
        //
        //     e.preventDefault(); // avoid to execute the actual submit of the form.
        //
        //     var form = $(this);
        //     // var url = form.attr('action');
        //
        //     $.ajax({
        //         type: "POST",
        //         url: 'payroll/updateSalary',
        //         data: form.serialize(), // serializes the form's elements.
        //         success: function(data)
        //         {
        //             alert(data); // show response from the php script.
        //         }
        //     });
        //
        //
        // });



        $(function (){
            $(document).on("focus", "input:text", function() {
                $(this).select();
            });
        });

    </script>
@endpush