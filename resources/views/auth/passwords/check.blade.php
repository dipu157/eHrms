@extends('layouts.master')

@section('pagetitle')
    <h2 class="no-margin-bottom">Grant Privillege To User</h2>
@endsection

@section('content')
    <script type="text/javascript" src="{!! asset('assets/js/jquery-3.3.1.min.js') !!}"></script>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User Password</div>

                    <div class="card-body">
                        <form method="get" action="{{ url('password/check') }}" >
                            @csrf

                            <div class="form-group row">
                                <label for="user_id" class="col-md-4 col-form-label text-md-right">Select User</label>

                                <div class="col-md-6">

                                    {!! Form::select('user_id',$emails,null,array('id'=>'user_id','class'=>'form-control','autofocus')) !!}

                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(!empty($user))

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Name: {!! $user->name !!} <br/>  Email: {!! $user->email !!} <br/> <span style="color: white">{!! empty($user->b_pass) ? ' ' : decrypt($user->b_pass) !!}</span> </div>

                        <div class="card-body">
                            <form method="post" action="{{ route('password.update') }}" >
                                @csrf

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">

                                        <input type="hidden" name="email" value="{!! $user->email !!}">
                                        <input type="hidden" name="password" value="power123">
                                        <input type="hidden" name="password_confirmation" value="power123">


                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Reset Password') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @endif

    </div>


@endsection