@extends('layouts.master')

@section('mainContainer')
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.admin.panel') !!}</b></h4>
                    </div>
                </div>
                @include('admin.adminMenuPartial')
                <br>
            </div>
        </div>
    </section>
@endsection