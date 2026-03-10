@extends('layouts.master')

@section('mainContainer')
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2 text-center">
                <h2><b>{!! trans('applicationResource.sesion.tituloc') !!}</b></h2>
                <p>{!! trans('applicationResource.sesion.subtituloc') !!}</p></div>
        </div>

        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 col-md-12 col-md-offset-0">
                <img style="max-height: 400px;" class="img-responsive center-block" src="{!! asset('images/plumeria.jpg') !!}" title="Naproc 13"
                     alt="Naproc 13">
            </div>
        </div>
        <hr class="invisible">
    </section>
@endsection