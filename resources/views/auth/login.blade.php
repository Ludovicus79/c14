@extends('layouts.master')

@section('mainContainer')
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-0 col-md-12">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.menu.sesion') !!}</b></h4>
                    </div>
                </div>

                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    @csrf
                    <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }} row">
                        <label class="col-xs-12 col-sm-4 control-label">{!! trans('applicationResource.menu.login') !!}</label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="text" class="form-control" id="login" name="login"
                                   value="{{ old('login') }}"
                                   placeholder="{!! trans('applicationResource.menu.login') !!}">
                            @if ($errors->has('login'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('login') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} row">
                        <label class="col-xs-12 col-sm-4 control-label">{!! trans('applicationResource.menu.password') !!}</label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="{!! trans('applicationResource.menu.password') !!}">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-12 text-center">
                            <label>
                                <input type="checkbox"
                                       name="remember"> {!! trans('applicationResource.menu.rememberMe') !!}
                            </label>
                        </div>
                        <div class="col-xs-12 text-center">
                            <a class="btn btn-link"
                               href="{{ url('/password/reset') }}">{!! trans('applicationResource.menu.forgotPassword') !!}</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="submit" class="btn btn-danger">
                                {!! trans('applicationResource.menu.signIn') !!}
                            </button>
                            <a  href="{{ url('/register') }}" class="btn btn-danger">
                                {!! trans('applicationResource.menu.signUp') !!}
                            </a>
                        </div>
                    </div>

                </form>


            </div>
        </div>
    </section>
@endsection
