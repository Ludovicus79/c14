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

                <hr class="invisible">

                <form class="form-horizontal" role="form" method="POST" action="" onsubmit="showLoading()">
                    @csrf

                    {{-- FAMILIA / SUBFAMILIA / GRUPO --}}
                    <div class="row">
                        <div class="col-xs-12">
                            @include('search.familiesPartial')
                        </div>
                    </div>

                    <hr class="invisible">

                    {{-- FÓRMULA MOLECULAR con átomos individuales --}}
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-2 col-md-2 control-label">
                            {!! trans('applicationResource.form.formulamol') !!}
                        </label>
                        <div class="col-xs-12 col-sm-10 col-md-10">
                            <div class="row">
                                @foreach(['C','H','N','O','S','F','Cl','Br','I'] as $atom)
                                <div class="col-xs-2 col-sm-1" style="padding-right:2px; padding-left:2px;">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon" style="padding:2px 4px;">{{ $atom }}</span>
                                        <input type="text"
                                               class="form-control input-sm"
                                               name="molFormula[{{ $atom }}]"
                                               value="{{ old('molFormula.'.$atom, 0) }}"
                                               style="width:40px; padding:2px;">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- PESO MOLECULAR con rango --}}
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-2 col-md-2 control-label">
                            {!! trans('applicationResource.form.pesomol') !!}
                        </label>
                        <div class="col-xs-5 col-sm-3 col-md-2">
                            <input type="text"
                                   class="form-control"
                                   name="molWeightMin"
                                   placeholder="0.000"
                                   value="{{ old('molWeightMin') }}">
                        </div>
                        <div class="col-xs-2 col-sm-1 text-center" style="padding-top:7px;">
                            &#8920;
                        </div>
                        <div class="col-xs-5 col-sm-3 col-md-2">
                            <input type="text"
                                   class="form-control"
                                   name="molWeightMax"
                                   placeholder="0.000"
                                   value="{{ old('molWeightMax') }}">
                        </div>
                    </div>

                    {{-- NOMBRE TRIVIAL --}}
                    <div class="form-group row{{ $errors->has('trivialName') ? ' has-error' : '' }}">
                        <label class="col-xs-12 col-sm-2 col-md-2 control-label">
                            {!! trans('applicationResource.form.nombretri') !!}
                        </label>
                        <div class="col-xs-12 col-sm-8 col-md-6">
                            <input type="text" class="form-control" name="trivialName" value="{{ old('trivialName') }}">
                        </div>
                    </div>

                    {{-- NOMBRE SEMISISTÉMÁTICO --}}
                    <div class="form-group row{{ $errors->has('semiName') ? ' has-error' : '' }}">
                        <label class="col-xs-12 col-sm-2 col-md-2 control-label">
                            {!! trans('applicationResource.form.nombresemi') !!}
                        </label>
                        <div class="col-xs-12 col-sm-8 col-md-6">
                            <input type="text" class="form-control" name="semiName" value="{{ old('semiName') }}">
                        </div>
                    </div>

                    {{-- BIBLIOGRAFÍA --}}
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h4><b>{!! trans('applicationResource.form.biblio') !!}</b></h4>
                        </div>
                    </div>
                    <hr>

                    {{-- AUTORES --}}
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-2 col-md-2 control-label">
                            {!! trans('applicationResource.form.autores') !!}
                        </label>
                        <div class="col-xs-12 col-sm-8 col-md-6">
                            <input type="text" class="form-control" name="biblio[autores]" value="{{ old('biblio.autores') }}">
                        </div>
                    </div>

                    {{-- REVISTA --}}
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-2 col-md-2 control-label">
                            {!! trans('applicationResource.form.revista') !!}
                        </label>
                        <div class="col-xs-12 col-sm-8 col-md-6">
                            <input type="text" class="form-control" name="biblio[revista]" value="{{ old('biblio.revista') }}">
                        </div>
                    </div>

                    {{-- PÁGINAS / VOLUMEN / AÑO en una fila --}}
                    <div class="form-group row">
                        <label class="col-xs-12 col-sm-2 col-md-2 control-label">
                            {!! trans('applicationResource.form.pag') !!}
                        </label>
                        <div class="col-xs-4 col-sm-3 col-md-2">
                            <input type="text" class="form-control" name="biblio[pag]" value="{{ old('biblio.pag') }}">
                        </div>

                        <label class="col-xs-4 col-sm-2 col-md-1 control-label">
                            {!! trans('applicationResource.form.vol') !!}
                        </label>
                        <div class="col-xs-4 col-sm-1 col-md-1">
                            <input type="text" class="form-control" name="biblio[vol]" value="{{ old('biblio.vol') }}">
                        </div>

                        <label class="col-xs-4 col-sm-1 col-md-1 control-label">
                            {!! trans('applicationResource.form.anio') !!}
                        </label>
                        <div class="col-xs-4 col-sm-2 col-md-2">
                            <input type="text" class="form-control" name="biblio[anio]" value="{{ old('biblio.anio') }}">
                        </div>
                    </div>

                    {{-- BOTÓN BUSCAR --}}
                    <div class="form-group row text-center">
                        <button class="btn btn-danger" type="submit" onsubmit="showLoading()">
                            {!! trans('applicationResource.form.buscar') !!}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection
