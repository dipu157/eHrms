<div class="modal fade right" id="modal-new-user" tabindex="-1" role="dialog" aria-labelledby="modal-new-user-label"
     aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-info modal-lg" role="document">
        <!--Content-->
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header" style="background-color: #17A2B8;">
                    <p class="heading">New Designation
                    </p>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>

                <!--Body-->
                <div class="modal-body">


                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">{{ __('Register') }}</div>

                                    <div class="card-body">
                                        <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                                            @csrf



                                            <div class="form-group row">
                                                <label for="role_id" class="col-md-4 col-form-label text-md-right">Select Role</label>

                                                <div class="col-md-6">

                                                    {!! Form::select('role_id',$roles,null,array('id'=>'role_id','class'=>'form-control','autofocus')) !!}

                                                </div>
                                            </div>

                                            <div class="form-group row" id="person_name">
                                                <label for="name" id="label_name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                                <div class="col-md-6">
                                                    <input id="name" type="text" class="form-control typeahead" name="name" value="" required autocomplete="off">
                                                </div>
                                            </div>


                                            <div class="form-group row" id="person_id">
                                                <label for="emp_id" class="col-md-4 col-form-label text-md-right">Employee ID</label>

                                                <div class="col-md-6">
                                                    <input id="emp_id" type="text" id="emp_id" class="form-control" name="emp_id" required>
                                                </div>
                                            </div>




                                            <div class="form-group row">
                                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                                <div class="col-md-6">
                                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="your-id@brbhospital.com" required>

                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                                <div class="col-md-6">
                                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                                <div class="col-md-6">
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Register') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



            </div>
            <!--/.Content-->
    </div>
</div>
<!-- Modal: modalAbandonedCart-->

