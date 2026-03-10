@extends('layouts.master')

@section('mainContainer')
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-0 col-md-12">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.menu.signUp') !!}</b></h4>
                    </div>
                </div>


                <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                    @csrf

                    <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }} row">
                        <label for="login" class="col-xs-12 col-sm-4 control-label">{!! trans('applicationResource.menu.login') !!}</label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="text" class="form-control" name="login" value="{{ old('login') }}"
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
                            <input type="password" class="form-control" name="password"
                                   placeholder="{!! trans('applicationResource.menu.password') !!}">
                            @if ($errors->has('password'))
                                <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} row">
                        <label class="col-xs-12 col-sm-4 control-label">{!! trans('applicationResource.menu.passwordConfirm') !!}</label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="password" class="form-control" name="password_confirmation"
                                   placeholder="{!! trans('applicationResource.menu.password') !!}">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} row">
                        <label class="col-xs-12 col-sm-4 control-label">{!! trans('applicationResource.menu.name') !!}</label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                   placeholder="{!! trans('applicationResource.menu.name') !!}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} row">
                        <label class="col-xs-12 col-sm-4 control-label">{!! trans('applicationResource.menu.email') !!}</label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                   placeholder="{!! trans('applicationResource.menu.email') !!}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('university') ? ' has-error' : '' }} row">
                        <label class="col-xs-12 col-sm-4 control-label">{!! trans('applicationResource.menu.organization') !!}</label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="text" class="form-control" name="university" value="{{ old('university') }}"
                                   placeholder="{!! trans('applicationResource.menu.organization') !!}">

                            @if ($errors->has('university'))
                                <span class="help-block">
                            <strong>{{ $errors->first('university') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }} row">
                        <label class="col-xs-12 col-sm-4 control-label">{!! trans('applicationResource.userData.city') !!}</label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="text" class="form-control" name="city" value="{{ old('city') }}"
                                   placeholder="{!! trans('applicationResource.userData.city') !!}">

                            @if ($errors->has('city'))
                                <span class="help-block">
                            <strong>{{ $errors->first('city') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }} row">
                        <label class="col-xs-12 col-sm-4 control-label">{!! trans('applicationResource.userData.country') !!}</label>
                        <div class="col-xs-12 col-sm-4">
                            <input type="text" class="form-control" name="country" value="{{ old('country') }}"
                                   placeholder="{!! trans('applicationResource.userData.country') !!}">

                            @if ($errors->has('country'))
                                <span class="help-block">
                            <strong>{{ $errors->first('country') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>

                    <!-- reCAPTCHA -->
                    <div class="form-group row">
                        <div class="col-xs-12 col-sm-offset-4 col-sm-4">
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-btn fa-user"></i>{!! trans('applicationResource.menu.signUp') !!}
                            </button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </section>
@endsection
