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
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.admin.lastMol') !!}</b></h4>
                    </div>
                </div>
                @include('admin.adminMenuPartial')
            </div>
        </div>

        <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                    <hr>
                        <table class="footable table" data-sort="false" data-page-size="5">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th data-hide="phone">{!! trans('applicationResource.confirm.ref') !!}</th>
                                <th data-hide="phone">{!! trans('applicationResource.criteria.createdAt') !!}</th>
                                <th data-hide="phone">{!! trans('applicationResource.criteria.family') !!}</th>
                                <th data-hide="phone">{!! trans('applicationResource.criteria.subFamily') !!}</th>
                                <th data-hide="phone">{!! trans('applicationResource.criteria.subSubFamily') !!}</th>
                                <th data-hide="phone"></th>
                            </tr>

                            </thead>

                            <tbody>
                            @for($i = 0; $i < sizeof($molecules); $i++)
                                <tr>
                                    <td>{{$molecules[$i]->id}}</td>
                                    <td>{{$molecules[$i]->reference}}</td>
                                    <td>{{$molecules[$i]->created_at}}</td>
                                    <td>{{$molecules[$i]->family}}</td>
                                    <td>{{$molecules[$i]->subFamily}}</td>
                                    <td>{{$molecules[$i]->subSubFamily}}</td>
                                    <td><a href="{!! url('admin/molEdit',$molecules[$i]->id)!!}"
                                           class="btn btn-danger"
                                           role="button">{!! trans('applicationResource.button.view') !!}</a></td>
                                </tr>
                            @endfor
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="pagination center-block"></div>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
    </section>
@endsection