@extends('layouts.master')

@section('headers')
    <?php
    header("Cache-Control: no-store, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");?>
@endsection

@section('estilos')
    <style>
        #ketcher-container {
            width: 100%;
            height: 500px;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
        }
        #ketcher-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        .substructure-controls {
            padding-top: 60px;
        }
        .substructure-controls .form-group {
            margin-bottom: 20px;
        }
        @media (max-width: 767px) {
            #ketcher-container { height: 350px; }
            .substructure-controls { padding-top: 20px; }
        }

        #ketcher-container {
        width: 80%;
        height: 500px;
        border: 1px solid #ccc;
        border-radius: 4px;
        overflow: hidden;
        }

    </style>
@endsection

@section('scripts')
    <script src="{{ asset('js/spin.js') }}"></script>
    <script src="{{ asset('js/loadingScreen.js') }}"></script>
    <script src="{{ asset('js/loadFamilies.js') }}"></script>
    <script>
        function getSmile() {
            try {
                var iframe = document.getElementById('ketcherFrame');
                if (iframe && iframe.contentWindow && iframe.contentWindow.ketcher) {
                    var ketcher = iframe.contentWindow.ketcher;
                    ketcher.getSmiles().then(function(smiles) {
                        document.getElementById("smileCode").value = smiles;
                        document.getElementById("jmeCode").value = smiles;
                    });
                }
            } catch(e) {
                console.log('Ketcher not ready:', e);
            }
        }

        function submitWithSmiles() {
            var iframe = document.getElementById('ketcherFrame');
            if (iframe && iframe.contentWindow && iframe.contentWindow.ketcher) {
                var ketcher = iframe.contentWindow.ketcher;
                ketcher.getSmiles().then(function(smiles) {
                    document.getElementById("smileCode").value = smiles;
                    document.getElementById("jmeCode").value = smiles;
                    showLoading();
                    document.getElementById('substructureForm').submit();
                });
            } else {
                showLoading();
                document.getElementById('substructureForm').submit();
            }
        }

        $(document).ready(function() {
            $('#stereoButton').on('click', function() {
                var btn = $(this);
                setTimeout(function() {
                    btn.text(btn.hasClass('active') ? 'ON' : 'OFF');
                }, 10);
            });
        });
    </script>
@endsection

@section('mainContainer')
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-xs-10 col-sm-offset-1 col-sm-10 col-md-offset-1 col-md-10">

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.form.busquedas.subestructura') !!}</b></h4>
                    </div>
                </div>

                <hr class="invisible">

                <form id="substructureForm" class="form-horizontal" role="form" method="POST" action="">
                    @csrf

                    <div class="row">
                        {{-- EDITOR KETCHER --}}
                        <div class="col-xs-10 col-md-8">
                            <div id="ketcher-container">
                              <iframe id="ketcherFrame"
                                        src="/standalone/index.html"
                                         title="Ketcher Molecule Editor">
                                </iframe> 
                            </div>
                        </div>

                        {{-- CONTROLES --}}
                        <div class="col-xs-10 col-md-5 substructure-controls">

                            {{-- ESTEREOQUÍMICA --}}
                            <div class="form-group row text-center">
                                <label class="col-xs-6 control-label">
                                    {!! trans('applicationResource.form.stereo') !!}
                                </label>
                                <div class="col-xs-6">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-danger {{ old('stereo') ? 'active' : '' }}" id="stereoButton">
                                            <input type="checkbox" name="stereo" value="1"
                                                {{ old('stereo') ? 'checked' : '' }}>
                                            {{ old('stereo') ? 'ON' : 'OFF' }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <hr class="invisible">

                            {{-- FAMILIA / SUBFAMILIA / GRUPO --}}
                            <div class="form-group row">
                                @include('search.familiesPartial')
                            </div>

                            @if ($errors->has('emptyError'))
                                <div class="row text-center">
                                    <span style="color:red" class="col-xs-12 help-block">
                                        <strong>{{ trans('applicationResource.errors.substructure') }}</strong>
                                    </span>
                                </div>
                            @endif

                            <hr class="invisible">

                            {{-- BOTÓN BUSCAR --}}
                            <div class="form-group row text-center">
                                <button class="btn btn-danger" type="button"
                                        onclick="submitWithSmiles()">
                                    {!! trans('applicationResource.form.buscar') !!}
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- CAMPOS OCULTOS --}}
                    <input type="hidden" name="smileCode" id="smileCode" value="{{ old('smileCode') }}">
                    <input type="hidden" name="jmeCode" id="jmeCode" value="{{ old('jmeCode') }}">
                    <input type="hidden" name="emptyError" value="">
                    <input type="hidden" name="submitBtn" value="submitBtn">

                </form>
            </div>
        </div>
    </section>
@endsection
