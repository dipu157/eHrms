@extends('layouts.master')

@section('pagetitle')
<h2 class="no-margin-bottom">Update Document</h2>
@endsection
@section('content')
<script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>
<link href="{!! asset('assets/css/bootstrap-imageupload.css') !!}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{!! asset('assets/js/bootstrap-imageupload.js') !!}"></script>

<div class="container-fluid">

    <div class="row">
        <div class="col-md-6">
            <div class="pull-left">
                <a class="btn btn-primary" href="{!! URL::previous() !!}"> <i class="fa fa-list"></i> Back </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <form class="form-horizontal" id="document-form" role="form" method="POST" action="" accept-charset="UTF-8">

                {{ csrf_field() }}

                <input type="hidden" id="id" name="id" value="{!! $data->id !!}" class="form-control" />

                <div class="row">
                    <div class="container-fluid">

                        <div class="form-group row">
                            <label for="pr_district" class="col-sm-4 col-form-label text-md-right">Document Type</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    {!! Form::select('document_type_id',$document_type,$data->document_type_id,array('id'=>'document_type_id','class'=>'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row required">
                            <label for="document_date" class="col-sm-4 col-form-label text-md-right">Document Date</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <input type="text" name="document_date" id="document_date" value="{!! $data->document_date !!}" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="uhid" class="col-sm-4 col-form-label text-md-right">UHID</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <input type="text" name="uhid" class="form-control" id="uhid" placeholder="UHID" value="{!! $data->uhid !!}" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="employee_id" class="col-sm-4 col-form-label text-md-right">Employee ID</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <input type="text" name="employee_id" id="employee_id" class="form-control" value="{!! $data->employee_id !!}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="department" class="col-sm-4 col-form-label text-md-right">Department</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    {!! Form::select('department_id', $departments,$data->department_id,array('id'=>'department_id','class'=>'form-control' )) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="item/procedure_name" class="col-sm-4 col-form-label text-md-right">Item/Procedure Name</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <input type="text" name="item_procedure_name" id="item_procedure_name" class="form-control" value="{!! $data->item_procedure_name !!}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="doctor_name" class="col-sm-4 col-form-label text-md-right">Doctor Name</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <input type="text" name="doctor_name" id="doctor_name" class="form-control" value="{!! $data->doctor_name !!}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="doctor_department_name" class="col-sm-4 col-form-label text-md-right">Doctor's Department</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <input type="text" name="doctor_department_name" id="doctor_department_name" class="form-control" value="{!! $data->doctor_department_name !!}">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="action" id="action" class="form-control" value="document" />
                    </div>

                    <button type="submit" id="btn-document" class="btnRegister btn-document">Submit</button>

                </div>

            </form>
        </div>

    </div>

</div>
<!--/.Container-->


@endsection

@push('scripts')
<script>
    
    $('#document-form').on("submit", function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var url = 'document/update';
        // confirm then

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),

            error: function(request, status, error) {
                alert(request.responseText);
            },

            success: function(data) {
                alert('Data Successfully Updated');
            },

        })

    });

    $("#status_id").change(function() {
        if ($("#status_id").val() == 8) {
            $("#hidden-panel").show()
        } else {
            $("#hidden-panel").hide()
        }
    });
</script>

@endpush