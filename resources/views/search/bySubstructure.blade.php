@extends('layouts.master')

@section('headers')
    <?php
    header("Cache-Control: no-store, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");?>
@endsection

@section('estilos')
    <style>
        #jsme_container { width: 400px; height: 400px; margin: 0; }
        .substructure-controls { padding-top: 100px; }
        .substructure-controls .form-group { margin-bottom: 40px; }
        @media (max-width: 700px) {
            #jsme_container { width: 60%; height: 300px; }
            .substructure-controls { padding-top: 10px; }
        .substructure-controls #searchSubstructure1 label,
.substructure-controls #searchSubstructure2 label,
.substructure-controls #searchSubstructure3 label {
    width: auto;
    padding-right: 5px;
    float: left;
    padding-top: 7px;
}

.substructure-controls #searchSubstructure1,
.substructure-controls #searchSubstructure2,
.substructure-controls #searchSubstructure3 {
    display: flex;
    align-items: left;
    margin-bottom: 50px;
    width: 100%;
}

.substructure-controls #desplegableFam,
.substructure-controls #desplegableType,
.substructure-controls #desplegableGroup {
    flex: 1;
    padding-left: 10px;
}

        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('js/spin.js') }}"></script>
    <script src="{{ asset('js/loadingScreen.js') }}"></script>
    <script src="{{ asset('js/loadFamilies.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jsme/JSME_2024-04-29/jsme/jsme.nocache.js') }}"></script>
    <script>
        var jsmeApplet;
        function jsmeOnLoad() {
            jsmeApplet = new JSApplet.JSME("jsme_container", "500px", "400px", {"options": "query,hydrogens"});
        }
        window.addEventListener('load', function() {
            if (typeof JSApplet !== 'undefined' && !jsmeApplet) { jsmeOnLoad(); }
        });
        function getSmile() {
            if (jsmeApplet) {
                document.getElementById("smileCode").value = jsmeApplet.smiles();
                document.getElementById("jmeCode").value = jsmeApplet.jmeFile();
            }
        }
        $(document).ready(function() {
            $('#stereoButton').on('click', function() {
                var btn = $(this);
                setTimeout(function() {
                    btn.text(btn.hasClass('active') ? 'ON' : 'OFF');
                }, 5);
            });
        });
    </script>
@endsection

@section('mainContainer')
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.form.busquedas.subestructura') !!}</b></h4>
                    </div>
                </div>
                <hr class="invisible">
                <form class="form-horizontal" role="form" method="POST" action="" onsubmit="getSmile(); showLoading();">
                    @csrf
                    <div class="row">
                        {{-- EDITOR JSME --}}
                        <div class="col-xs-12 col-md-7">
                            <div id="jsme_container"></div>
                        </div>
                        {{-- CONTROLES --}}
                        <div class="col-xs-6 col-md-8 substructure-controls">
                            <div class="form-group row text-center">
                                <label class="col-xs-5 control-label">{!! trans('applicationResource.form.stereo') !!}</label>
                                <div class="col-xs-1">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-danger {{ old('stereo') ? 'active' : '' }}" id="stereoButton">
                                            <input type="checkbox" name="stereo" value="1" {{ old('stereo') ? 'checked' : '' }}>
                                            {{ old('stereo') ? 'ON' : 'OFF' }}
                                        </label>
                                    </div>
                                </div>
                            </div>
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
                            <div class="form-group row text-center">
                                <button class="btn btn-danger" type="submit" name="submitBtn" value="submitBtn">
                                    {!! trans('applicationResource.form.buscar') !!}
                                </button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="smileCode" id="smileCode" value="{{ old('smileCode') }}">
                    <input type="hidden" name="jmeCode" id="jmeCode" value="{{ old('jmeCode') }}">
                    <input type="hidden" name="emptyError" value="">
                </form>
            </div>
        </div>
    </section>
@endsection
