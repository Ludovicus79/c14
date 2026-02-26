@extends('layouts.master')

@section('mainContainer')
    <section class="container">
        <div class="row">

            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10">
                <h3 class="text-center"><b>{!! trans('applicationResource.developers.title') !!}</b></h3>
                <hr class="invisible">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <h4 class="text-center">Adrián García San José</h4>
                    <h5 class="text-center">{!! trans('applicationResource.menu.email') !!}: <a href="mailto:adriangarciasanjose@gmail.com">adriangarciasanjose@gmail.com</a></h5>
                    <h5 class="text-center">{!! trans('applicationResource.developers.web') !!}: </h5>
                    <a href="https://www.linkedin.com/in/adrian-garcia-san-jose-34444a160/"><img class="img-responsive center-block" src="{!! asset('images/linkedinLogo.png') !!}" alt="linkedin"></a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <h4 class="text-center">Alejandro Sánchez Gómez</h4>
                    <h5 class="text-center">{!! trans('applicationResource.menu.email') !!}: <a href="mailto:alsago333@gmail.com">alsago333@gmail.com</a></h5>
                    <h5 class="text-center">{!! trans('applicationResource.developers.web') !!}: </h5>
                    <a href="https://es.linkedin.com/in/alsago"><img class="img-responsive center-block" src="{!! asset('images/linkedinLogo.png') !!}" alt="linkedin"></a>
                </div>
                
                
                <hr class="invisible">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10">
                <div class="col-xs-12 col-sm-6 col-md-6">
                        <h4 class="text-center">Álvaro Estévez Gómez</h4>
                        <h5 class="text-center">{!! trans('applicationResource.menu.email') !!}: <a href="mailto:alvaro_esgo@hotmail.com">alvaro_esgo@hotmail.com</a></h5>
                        <h5 class="text-center">{!! trans('applicationResource.developers.web') !!}: </h5>
                        <a href="https://es.linkedin.com/in/alvaroestegom"><img class="img-responsive center-block" src="{!! asset('images/linkedinLogo.png') !!}" alt="linkedin"></a>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6">
                            <h4 class="text-center">Javier García Mateos</h4>
                            <h5 class="text-center">{!! trans('applicationResource.menu.email') !!}: <a href="mailto:javiergarciamateos1989@gmail.com">javiergarciamateos1989@gmail.com</a></h5>
                            <h5 class="text-center">{!! trans('applicationResource.developers.web') !!}: </h5>
                            <a href="https://es.linkedin.com/in/javier-garcía-mateos-406a15140"><img class="img-responsive center-block" src="{!! asset('images/linkedinLogo.png') !!}" alt="linkedin"></a>
                    </div>
            </div>
        </div>
        <hr>
        <div class="row">
             <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10">
                <div class="col-xs-12 col-sm-6 col-md-6">
                        <h4 class="text-center">Sergio Domínguez Montero</h4>
                        <h5 class="text-center">{!! trans('applicationResource.menu.email') !!}: <a href="mailto:sergio07.d@gmail.com">sergio07.d@gmail.com</a></h5>
                        <h5 class="text-center">{!! trans('applicationResource.developers.web') !!}: </h5>
                        <a href="https://www.linkedin.com/in/sergio-d-981077ab/"><img class="img-responsive center-block" src="{!! asset('images/linkedinLogo.png') !!}" alt="linkedin"></a>
                </div>

            
            </div>

    </section>
    <hr class="invisible">
    <br>
@endsection