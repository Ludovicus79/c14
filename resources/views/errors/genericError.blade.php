@extends('layouts.master')

@section('scripts')
    <script type="text/javascript">
        $(document).ready(init);

        function init() {
            $('#showDetails').click(function () {
                $('#details').toggle();
            });
        }
    </script>
@endsection

@section('mainContainer')
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">


                <div class="row">
                    <div class="col-xs-12 text-center">
                        @if($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException)
                            <h2>{!! trans('applicationResource.errors.404') !!}</h2>
                        @else
                            @if(config('app.env') == 'local')
                                <h2>{!! $exception->getMessage() !!}</h2>
                            @else
                                <h2>{!! trans('applicationResource.errors.generic') !!}</h2>
                            @endif
                        @endif
                    </div>
                </div>

                <hr class="invisible">

                <div class="row">
                    <div class="col-xs-12">
                        <img class="img-responsive center-block" src="{!! asset('images/errors/errorWarning.png') !!}"/>
                    </div>
                </div>

                <hr class="invisible">

                @if(config('app.env') == 'local')
                    <div class="row">
                        <div class="col-xs-6 col-xs-offset-3 col-sm-offset-4 col-sm-4 text-center">
                            <div id="showDetails"
                                 class="flip">{!! trans('applicationResource.button.showHideDetails') !!}</div>
                        </div>
                    </div>
                    <div id="details" class="row" style="text-align: left; display: none">
                        <div class="col-xs-12 text-center">
                            <pre style="max-height: 300px;">{!! str_replace("\n", "<br>", $exception->getTraceAsString()) !!}</pre>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <button id="botonvolver" type="button" class="btn btn-danger"
                                onclick="window.history.back()">{!! trans('applicationResource.button.back') !!}</button>
                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection