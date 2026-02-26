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

    <script>
        $(document).ready(function(){
            $('.delete-btn').click(function(){
                newHref="{!! url('admin/logs/delete') !!}"+"/"+$(this).data('id');
                $('#confirmDelete').attr('href',newHref);
            })
        })

    </script>
@endsection

@section('mainContainer')
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">

                <div class="row text-center">
                    <div class="col-xs-12">
                        <h4><b>{!! trans('applicationResource.admin.logs') !!}</b></h4>
                    </div>
                </div>

                @include('admin.adminMenuPartial')

                <br>

                <div class="row">
                    <div class="col-xs-12">
                        <table class="footable table" data-sort="false" data-page-size="10">
                            <thead>
                            <tr>
                                <th></th>
                                <th data-hide="phone"></th>
                                <th data-hide="phone"></th>
                                <th data-hide="phone"></th>
                                <th data-hide="phone"></th>
                            </tr>

                            </thead>

                            <tbody>
                            @for($i = 0; $i < sizeof($logs); $i++)
                                <tr>
                                    <td>{!! $logs[$i]->getFileName() !!}</td>
                                    <td>{!!$date=date('d-m-Y H-i-s', File::lastModified($logs[$i]->getPathname()))!!}</td>
                                    <td><a href="{!! url('admin/logs',$logs[$i]->getFilename())!!}"
                                           class="btn btn-danger"
                                           role="button">{!! trans('applicationResource.button.view') !!}</a></td>
                                    <td><a href="{!! url('admin/logs/download',$logs[$i]->getFilename())!!}"
                                           class="btn btn-danger"
                                           role="button">{!! trans('applicationResource.button.download') !!}</a></td>
                                    <td><button data-toggle="modal" data-target="#alert" data-id="{!! $logs[$i]->getFilename() !!}"
                                           class="btn btn-danger delete-btn"
                                           role="button">{!! trans('applicationResource.button.delete') !!}</button>
                                    </td>
                                </tr>
                            @endfor
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5">
                                    <div class="pagination center-block"></div>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <button data-toggle="modal" data-target="#alert" data-id="all"
                                class="btn btn-md btn-danger delete-btn"
                                role="button">{!! trans('applicationResource.button.deleteAll') !!}</button>
                        <a class="btn btn-md btn-danger" href="{!! url('admin/logs/download/all') !!}">{!! trans('applicationResource.button.downloadAll') !!}</a>
                    </div>
                </div>

                <div id="alert" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-sm">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">{!! trans('applicationResource.dialog.sure') !!}</h4>
                            </div>
                            <div class="modal-body">
                                <p>{!! trans('applicationResource.dialog.deleteLog') !!}</p>
                            </div>
                            <div class="modal-footer">
                                <a type="button" href="#" id="confirmDelete" class="btn btn-danger">{!! trans('applicationResource.button.confirm') !!}</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">{!! trans('applicationResource.button.cancel') !!}</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection