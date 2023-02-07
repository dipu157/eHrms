@extends('layouts.master')

@section('pagetitle')
<h2 class="no-margin-bottom">Employee Wise Overtime Report</h2>
@endsection
@section('content')
<script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>

<script type="text/javascript" src="{!! asset('assets/js/bootstrap3-typeahead.js') !!}"></script>


<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
            </div>
        </div>
    </div>
</div>
<!--/.Container-->



<div class="row ">
<div class="col-md-8">
        <div class="card">
        <div class="card-header"> Ovetime Report</div>
            <div class="card-body">
                <form method="get" action="{!! url('overtime/employeeMonthlyOvertimeIndex') !!}">
                    @csrf

                    <div class="form-group row">
                        <label for="from_date" class="col-md-4 col-form-label text-md-right">From Date</label>
                        <div class="col-md-6">
                            <input type="text" name="from_date" id="from_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="to_date" class="col-md-4 col-form-label text-md-right">To Date</label>
                        <div class="col-md-6">
                            <input type="text" name="to_date" id="to_date" class="form-control" value="{!! \Carbon\Carbon::now()->format('d-m-Y') !!}" required readonly />
                        </div>
                    </div>

                    <div class="form-group row" id="person_name">
                        <label for="name" id="label_name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control typeahead" name="name"  autocomplete="off">
                            <input id="emp_id" type="hidden" id="emp_id" class="form-control" name="emp_id" >
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                    <div class="col-md-3 text-md-Left">
                               </div>
                              
                                <div class="col-md-3 text-md-center">
                                <button type="submit" class="btn btn-primary" name="action" value="print">Print</button></div>
                              

                                <div class="col-md-3 text-md-right">
                                <button type="submit" class="btn btn-secondary" name="action" value="OvertimePrint">Attend</button>
                                </div>
                            </div>
                    
                </form>
            </div>
        </div>
    </div>


  
</div>


@endsection

@push('scripts')

<script>
    // var autocomplete_path = "{{ url('autocomplete/departmentEmployee') }}"; 
    var autocomplete_path = "{{ url('autocomplete/employeeNameId') }}";

    $(document).on('click', '.form-control.typeahead', function() {

        $(this).typeahead({
            minLength: 2,
            displayText: function(data) {
                return data.professional.employee_id + ' : ' + data.full_name;
            },

            source: function(query, process) {
                $.ajax({
                    url: autocomplete_path,
                    type: 'GET',
                    dataType: 'JSON',
                    data: 'query=' + query,
                    success: function(data) {
                        return process(data);
                    }
                });
            },
            afterSelect: function(data) {

                document.getElementById('emp_id').value = data.id;
            }
        });
    });


    $(document).on('click', '.form-control.typeahead-alter', function() {

        $(this).typeahead({
            minLength: 2,
            displayText: function(data) {
                return data.professional.employee_id + ' : ' + data.full_name;
            },

            source: function(query, process) {
                $.ajax({
                    url: "{{ url('autocomplete/employeeNameId') }}",
                    type: 'GET',
                    dataType: 'JSON',
                    data: 'query=' + query,
                    success: function(data) {
                        return process(data);
                    }
                });
            },
            afterSelect: function(data) {

                document.getElementById('alternate_id').value = data.professional.employee_id;
            }
        });
    });




    $(function() {

        $("#from_date").datetimepicker({
            format: 'd-m-Y',
            timepicker: false,
            closeOnDateSelect: true,
            scrollInput: false,
            inline: false
        });

        $("#to_date").datetimepicker({
            format: 'd-m-Y',
            timepicker: false,
            closeOnDateSelect: true,
            scrollInput: false,
            inline: false
        });
        $("#from1_date").datetimepicker({
            format: 'd-m-Y',
            timepicker: false,
            closeOnDateSelect: true,
            scrollInput: false,
            inline: false
        });

        $("#to1_date").datetimepicker({
            format: 'd-m-Y',
            timepicker: false,
            closeOnDateSelect: true,
            scrollInput: false,
            inline: false
        });
    });


    $(function() {
        $(document).on("focus", "input:text", function() {
            $(this).select();
        });
    });


 
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
      alert(msg);
    }
  
</script>

@endpush