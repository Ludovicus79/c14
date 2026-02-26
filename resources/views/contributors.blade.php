@extends('layouts.master')

@section('estilos')
    <link rel="stylesheet" href="{{ asset('css/footable.core.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footable.metro.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/footable.js') }}"></script>
    <script src="{{ asset('js/footable.sort.js') }}"></script>
    <script src="{{ asset('js/footable.paginate.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('.footable').footable();
        });
    </script>
@endsection
@section('mainContainer')
    <section class="container main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-12 col-md-offset-0">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.colab.colaboradores') !!}</b></h4>
                    </div>
                </div>
  
                <div class="row">
                    <div class="col-xs-12">
                        <table class="footable table" data-page-size="15">
                            <thead>
                            <tr>
                                <th>{!! trans('applicationResource.colab.autor') !!}</th>
                                <th data-hide="phone">{!! trans('applicationResource.colab.email') !!}</th>
                                <th data-hide="phone">{!! trans('applicationResource.colab.organismo') !!}</th>
                                <th data-hide="phone">{!! trans('applicationResource.colab.pais') !!}</th>
                                <th data-type="numeric">{!! trans('applicationResource.colab.numcompuestos') !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contributors as $contributor)
                                <tr>
                                    <td>{!! $contributor->author !!}</td>
                                    <td>{!! $contributor->email!!}</td>
                                    <td>{!! $contributor->organization !!}</td>
                                    <td>{!! $contributor->country !!}</td>
                                    <td>{!! $contributor->molecules()->count() !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5" class="text-center">
                                    <div class="pagination"></div>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection