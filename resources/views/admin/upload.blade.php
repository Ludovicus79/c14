@extends('layouts.master')

@section('estilos')
    <link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fileinput.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/fileinput.min.js') }}"></script>
@endsection

@section('mainContainer')

    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">


                <div class="row text-center">
                    <div class="col-xs-12">
                        <h4><b>{!! trans('applicationResource.admin.excel') !!}</b></h4>
                    </div>
                </div>

                @include('admin.adminMenuPartial')

                <br>

                <form class="form-horizontal" action="{!!  url('/admin/upload') !!}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3 text-center">
                            <label class="control-label">{!! trans('applicationResource.admin.selectFile') !!}</label>
                            <input id="input-1" type="file" name="file" class="file">
                            @if ($errors->has('file'))
                            <span class="help-block">
                                <strong>{{ $errors->first('file') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <hr class="invisible">
                    <!--<div class="row">
                        <div class="col-xs-12 text-center">
                            <button class="btn btn-danger" type="submit">{!! trans('applicationResource.button.upload') !!}</button>
                        </div>
                    </div>-->

                </form>

                @if(isset($logResults))
                    <div class="row previousResult">
                        <p>Carga de datos realizada con exito</p>
                        <p>Resultados:</p>
                        <div class="col-xs-offset-2 col-xs-8 logResult" style="overflow-y: scroll ">
                            <p>{!! nl2br($logResults) !!}</p>
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </section>
@endsection