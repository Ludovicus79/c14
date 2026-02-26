@extends('layouts.master')

@section('mainContainer')
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">


                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.menu.agradecimientos') !!}</b></h4>
                    </div>
                </div>

                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-8 col-md-offset-2 col-md-8">
                            <p>Se agradece a la SENACYT (Secretaría Nacional de Ciencia, Tecnología e Innovación) de Panama la concesión de una ayuda financiera
                                bajo Convocatoria pública de nuevos investigadores ronda II 2020, Código: PAAC-NI-2020-II-25</p>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-offset-2 col-sm-4 col-md-3">
                                <img class="img-responsive center-block" src="{!! asset('images/Logo_SNI.png') !!}"
                                     alt="SNI" title="SNI"/>
                            </div>
                        </div>
                    </div>
                    
                     <div class="row">
                        <div class="col-sm-offset-2 col-sm-8 col-md-offset-2 col-md-8">
                            <p>José L. López, como miembro del SNI agradece a la SENACYT (Secretaría Nacional de Ciencia, Tecnología e Innovación) de Panamá el estímulo económico recibido</p>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-offset-2 col-sm-4 col-md-3">
                                <img class="img-responsive center-block" src="{!! asset('images/Logo_SNI.png') !!}"
                                     alt="SNI" title="SNI"/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <center><hr width="50%" /></center>
                        <div class="col-sm-offset-2 col-sm-8 col-md-offset-2 col-md-8">
                            <p>Se agradece a la Consejería de Educación de la Junta de Castilla y León por la concesión de una ayuda financiera
                                para el desarollo de este proyecto titulado "Aprendizaje y Entrenamiento Virtual para la Elucidación Estructural
                                de Compuestos Naturales en las Enseñanzas de Postgrado"</p>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-offset-2 col-sm-4 col-md-3">
                                <img class="img-responsive center-block" src="{!! asset('images/junta.png') !!}"
                                     alt="Junta" title="Junta"/>
                            </div>
                        </div>
                    </div>


            </div>
        </div>
    </section>
@endsection
