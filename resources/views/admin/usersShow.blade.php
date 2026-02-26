@extends('layouts.master')

@section('estilos')
    <link rel="stylesheet" href="{{ asset('css/footable.core.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footable.metro.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/footable.js') }}"></script>
    <script src="{{ asset('js/footable.sort.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('.footable').footable();
        });
    </script>
@endsection

@section('mainContainer')
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">


                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h2>{!! trans('applicationResource.user.specific') !!}</h2>
                    </div>
                </div>

                @include('admin.adminMenuPartial')
                <div class="row">
                    <div class="col-xs-12 text-center ">
                        <h2>{{ $user->name }} </h2>
                    </div>
                </div>

                <hr class="invisible">

                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <table class="footable table" data-sort="false">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>{!! trans('applicationResource.userData.name') !!}</th>
                                        <th data-hide="phone">Email</th>
                                        <th data-hide="phone">Login</th>
                                        <th data-hide="phone">{!! trans('applicationResource.userData.org') !!}</th>
                                        <th data-hide="phone">{!! trans('applicationResource.userData.city') !!}</th>
                                        <th data-hide="phone">{!! trans('applicationResource.userData.country') !!}</th>
                                        <th>{!! trans('applicationResource.userData.allowed') !!}</th>
                                    </tr>

                                    </thead>

                                    <tbody>
                                    
                                        <tr>
                                            <td>{!! $user->id !!}</td>
                                            <td>{!! $user->name !!}</td>
                                            <td>{!! $user->email !!}</td>
                                            <td>{!! $user->login !!}</td>
                                            <td>{!! $user->university !!}</td>
                                            <td>{!! $user->city !!}</td>
                                            <td>{!! $user->country !!}</td>
                                            <td>
                                                <div class="square {!! $user->allowed?'greenSquare':'redSquare' !!}"></div>
                                            </td>
                                            
                                        </tr>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                        <div class="col-xs-12 text-center">
                            <button id="backBtn" class="btn btn-md btn-danger" onclick="window.history.back()">
                        {!! trans('applicationResource.button.back') !!}
                            </button>
                        </div>
                    </div>
                   

                


            </div>
        </div>
    </section>
@endsection