@extends('layouts.master')

@section('headers')
    <?php
    header("Cache-Control: no-store, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");?>
@endsection

@section('scripts')
    <script src="{{ asset('js/spin.js') }}"></script>
    <script src="{{ asset('js/loadingScreen.js') }}"></script>
    <script src="{{ asset('js/loadFamilies.js') }}"></script>
@endsection

@section('mainContainer')
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10">


                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.form.busquedas.nombre') !!}</b></h4>
                    </div>
                </div>


                @if ($errors->has('emptyError'))
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h4 class="help-block">
                                <strong style="color: red;">{!! trans('applicationResource.errors.requeridos') !!}</strong>
                            </h4>
                        </div>
                    </div>
                @endif

                <form class="form-horizontal" role="form" method="POST" action="{{ url('search/byName') }}"
                      onsubmit="showLoading()">
                    @csrf

                    <!--FAMILIA, TIPO, GRUPO-->
                   
                        @include('search.familiesPartial')
                    

                    <!-- FORMULA MOLECULAR -->
                    
                    <div class="form-group row">
                            <label class="col-xs-12 col-sm-1 control-label">{!! trans('applicationResource.form.formulamol') !!}</label>

                            <!-- CARBONO -->
                            <label class="col-xs-2 col-sm-1 control-label label2cifras" style="margin-left: 40px">C</label>
                            <div class="col-xs-4 col-sm-1{{ $errors->has('ca') ? ' has-error' : '' }} columna">
                                <input type="text" class=" form-control" id="ca" name="ca"
                                       value="{{ old('ca') }}" placeholder="0">
                                @if ($errors->has('ca'))
                                    <span class="col-sm-12 help-block">
                            <strong>{{ $errors->first('ca') }}</strong>
                        </span>
                                @endif
                            </div>
                            <!-- HIDROGENO -->
                            <label class="col-xs-2 col-sm-1 control-label label2cifras">H</label>
                            <div class="col-xs-4 col-sm-1 {{ $errors->has('hi') ? ' has-error' : '' }} columna">
                                <input type="text" class=" form-control" id="hi" name="hi"
                                       value="{{ old('hi') }}" placeholder="0">
                                @if ($errors->has('hi'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('hi') }}</strong>
                        </span>
                                @endif
                            </div>
                            <!-- NITROGENO -->
                            <label class="col-xs-2 col-sm-1 control-label label2cifras">N</label>
                            <div class="col-xs-4 col-sm-1 {{ $errors->has('ni') ? ' has-error' : '' }} columna">
                                <input type="text" class=" form-control" id="ni" name="ni"
                                       value="{{ old('ni') }}" placeholder="0">
                                @if ($errors->has('ni'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('ni') }}</strong>
                        </span>
                                @endif
                            </div>

                            <!-- OXIGENO -->
                            <label class="col-xs-2 col-sm-1  control-label label2cifras">O</label>
                            <div class="col-xs-4 col-sm-1{{ $errors->has('ox') ? ' has-error' : '' }} columna">
                                <input type="text" class=" form-control" id="ox" name="ox"
                                       value="{{ old('ox') }}" placeholder="0">
                                @if ($errors->has('ox'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('ox') }}</strong>
                        </span>
                                @endif
                            </div>
                        <!--Prueba Azufre-->
                            <label class="col-xs-2 col-sm-1  control-label label2cifras">S</label>
                            <div class="col-xs-4 col-sm-1{{ $errors->has('s') ? ' has-error' : '' }} columna">
                                <input type="text" class=" form-control" id="s" name="s"
                                       value="{{ old('s') }}" placeholder="0">
                                @if ($errors->has('s'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('s') }}</strong>
                        </span>
                                @endif
                            </div>
                    <!--Prueba Fluor-->
                            <label class="col-xs-2 col-sm-1  control-label label2cifras">F</label>
                            <div class="col-xs-4 col-sm-1{{ $errors->has('fl') ? ' has-error' : '' }} columna">
                                <input type="text" class=" form-control" id="fl" name="fl"
                                       value="{{ old('fl') }}" placeholder="0">
                                @if ($errors->has('fl'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('fl') }}</strong>
                        </span>
                                @endif
                            </div>

                        <!--Prueba Cloros-->
                            <label class="col-xs-2 col-sm-1  control-label label2cifras">Cl</label>
                            <div class="col-xs-4 col-sm-1{{ $errors->has('cl') ? ' has-error' : '' }} columna">
                                <input type="text" class=" form-control" id="cl" name="cl"
                                       value="{{ old('cl') }}" placeholder="0">
                                @if ($errors->has('cl'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('cl') }}</strong>
                        </span>
                                @endif
                            </div>

                        <!--Prueba Bromo-->
                            <label class="col-xs-2 col-sm-1  control-label label2cifras">Br</label>
                            <div class="col-xs-4 col-sm-1{{ $errors->has('br') ? ' has-error' : '' }} columna">
                                <input type="text" class=" form-control" id="br" name="br"
                                       value="{{ old('br') }}" placeholder="0">
                                @if ($errors->has('br'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('br') }}</strong>
                        </span>
                                @endif
                            </div>

                        <!--Prueba Iodo-->
                            <label class="col-xs-2 col-sm-1  control-label label2cifras">I</label>
                            <div class="col-xs-4 col-sm-1{{ $errors->has('io') ? ' has-error' : '' }} columna">
                                <input type="text" class=" form-control" id="io" name="io"
                                       value="{{ old('io') }}" placeholder="0">
                                @if ($errors->has('io'))
                                    <span class="help-block">
                            <strong>{{ $errors->first('io') }}</strong>
                        </span>
                                @endif
                            </div>

                    </div>
                    <br>
                    <!-- FIN DE FORMULA MOLECULAR -->



                    <!-- PESO MOLECULAR -->
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-3 control-label">{!! trans('applicationResource.form.pesomol') !!}</label>
                        <div class="col-xs-5 col-sm-2 {{ $errors->has('minWeight') ? ' has-error' : '' }}">
                            <input type="text" class=" form-control" id="minWeight" name="minWeight"
                                   value="{{ old('minWeight') }}" placeholder="0.000">
                            @if ($errors->has('minWeight'))
                                <span class="help-block">
                            <strong>{{ $errors->first('minWeight') }}</strong>
                        </span>
                            @endif
                        </div>
                        <div class="col-xs-1 col-sm-2 text-center"><></div>
                        <div class="col-xs-5 col-sm-2 {{ $errors->has('maxWeight') ? ' has-error' : '' }}">
                            <input type="text" class=" form-control" id="maxWeight" name="maxWeight"
                                   value="{{ old('maxWeight') }}" placeholder="0.000">
                            @if ($errors->has('maxWeight'))
                                <span class="help-block">
                            <strong>{{ $errors->first('maxWeight') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <!-- FIN DE PESO MOLECULAR -->

                    <!-- NOMBRES -->
                    <!-- TRIVIAL -->
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-3 control-label">{!! trans('applicationResource.form.nombretri') !!}</label>
                        <div class="col-xs-12 col-sm-6 {{ $errors->has('triName') ? ' has-error' : '' }}">
                            <input type="text" class=" form-control" id="triName" name="triName"
                                   value="{{ old('triName') }}">
                            @if ($errors->has('triName'))
                                <span class="help-block">
                            <strong>{{ $errors->first('triName') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <!-- SEMISISTEMATICO -->
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-3 control-label">{!! trans('applicationResource.form.nombresemi') !!}</label>
                        <div class="col-xs-12 col-sm-6 {{ $errors->has('semiName') ? ' has-error' : '' }}">
                            <input type="text" class=" form-control" id="semiName" name="semiName"
                                   value="{{ old('semiName') }}">
                            @if ($errors->has('semiName'))
                                <span class="help-block">
                            <strong>{{ $errors->first('semiName') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <!-- FIN DE NOMBRES -->

                    <!-- BIBLIOGRAFIA -->
                    <h4 class="col-xs-12 text-center">{!! trans('applicationResource.form.biblio') !!}</h4>
           
                    <!-- AUTORES -->
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-3 control-label">{!! trans('applicationResource.form.autores') !!}</label>
                        <div class="col-xs-12 col-sm-6{{ $errors->has('authors') ? ' has-error' : '' }}">
                            <input type="text" class="form-control " id="authors" name="authors"
                                   value="{{ old('authors') }}">
                            @if ($errors->has('authors'))
                                <span class="help-block">
                            <strong>{{ $errors->first('authors') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                    <!-- REVISTA -->
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-3 control-label">{!! trans('applicationResource.form.revista') !!}</label>
                        <div class="col-xs-12 col-sm-6 {{ $errors->has('magazine') ? ' has-error' : '' }}">
                            <input type="text" class="form-control " id="magazine" name="magazine"
                                   value="{{ old('magazine') }}">
                            @if ($errors->has('magazine'))
                                <span class="help-block">
                            <strong>{{ $errors->first('magazine') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        
                        
                        <!-- PAGINA -->
                        <label class="col-xs-12 col-sm-3 control-label">{!! trans('applicationResource.form.pag') !!}</label>
                        <div class="col-xs-12 col-sm-2 {{ $errors->has('page') ? ' has-error' : '' }}">
                            <input type="text" class="form-control " id="page" name="page"
                                   value="{{ old('page') }}">
                            @if ($errors->has('page'))
                                <span class="help-block">
                            <strong>{{ $errors->first('page') }}</strong>
                        </span>
                            @endif
                        </div>

                        <!-- VOLUMEN -->
                        <label class="col-xs-12 col-sm-1 control-label">{!! trans('applicationResource.form.vol') !!}</label>
                        <div class="col-xs-12 col-sm-1 {{ $errors->has('volume') ? ' has-error' : '' }}">
                            <input type="text" class="form-control " id="volume" name="volume"
                                   value="{{ old('volume') }}">
                            @if ($errors->has('volume'))
                                <span class="help-block">
                            <strong>{{ $errors->first('volume') }}</strong>
                        </span>
                            @endif
                        </div>

                        <!-- AÑO -->
                        <label class="col-xs-12 col-sm-1 control-label label2cifras">{!! trans('applicationResource.form.anio') !!}</label>
                        <div class="col-xs-12 col-sm-2 columna2 {{ $errors->has('year') ? ' has-error' : '' }}">
                            <input type="text" class="form-control " id="year" name="year"
                                   value="{{ old('year') }}">
                            @if ($errors->has('year'))
                                <span class="help-block">
                            <strong>{{ $errors->first('year') }}</strong>
                        </span>
                            @endif
                        </div>
                        
                    </div>
                    <!-- FIN DE BIBLIOGRAFIA -->


                    <!-- ENVIAR -->
                        <div class="form-group row">
                            <div class="col-xs-12 text-center">
                            <button type="submit" name="submitBtn" value="submitBtn" class="btn btn-md btn-danger">
                                {!! trans('applicationResource.form.buscar') !!}
                            </button>
                            </div>
                        </div>
                </form>


            </div>
        </div>
    </section>
@endsection
