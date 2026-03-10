@extends('layouts.master')

@section('estilos')
    <link rel="stylesheet" href="{{ asset('css/footable.core.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footable.metro.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/footable.js') }}"></script>
    <script src="{{ asset('js/footable.sort.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('.footable').footable();
        });
    </script>
    <script>
        $(document).ready(function(){
            $('#checkAll').click(function(){
                $('.checkConfirm').prop('checked',this.checked);
            })
        })


    </script>
@endsection

@section('mainContainer')
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.admin.confirm') !!}</b></h4>
                    </div>
                </div>

                @include('admin.adminMenuPartial')



                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="footable table" data-sort="false">
                                        <thead>
                                        <tr>
                                            <th>{!! trans('applicationResource.confirm.id') !!}</th>
                                            <th>{!! trans('applicationResource.confirm.ref') !!}</th>
                                            <th data-hide="phone">{!! trans('applicationResource.confirm.created') !!}</th>
                                            <th data-hide="phone">{!! trans('applicationResource.confirm.mod') !!}</th>
                                            <th data-hide="phone">{!! trans('applicationResource.confirm.edit') !!}</th>
                                            <th data-hide="phone"><input type="checkbox" id="checkAll"></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($molecules as $molecule)
                                            <tr>
                                                <td>{!! $molecule->id !!}</td>
                                                <td>{!! $molecule->reference !!}</td>
                                                <td>{!! $molecule->created_at !!}</td>
                                                <td>{!! $molecule->updated_at !!}</td>
                                                <td><a class="btn btn-danger btn-md"
                                                       href="{!! url('admin/molEdit/'.$molecule->id)!!}">{!! trans('applicationResource.confirm.edit') !!}</a>
                                                </td>
                                                <td><input class="checkConfirm" type="checkbox"
                                                           name="check[{!! $molecule->id !!}]"
                                                           value="{!! $molecule->id !!}"></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center">
                            {!! $molecules->render() !!}
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
                                    <p>{!! trans('applicationResource.dialog.confirm') !!}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">{!! trans('applicationResource.confirm.confirm') !!}</button>
                                    <button type="button" class="btn btn-default"
                                            data-dismiss="modal">{!! trans('applicationResource.button.cancel') !!}</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 text-center">
                <button class="btn btn-danger btn-md confirm-btn" data-toggle="modal"
                        data-target="#alert">{!! trans('applicationResource.button.confirm') !!} </button>
            </div>
        </div>


    </section>
@endsection