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
    <script type="text/javascript">
        function selectAll() {
            var checkboxs=document.getElementsByClassName('checkEliminar');
            if (document.getElementById('checkAll').checked==true) {
                for (var i = 0; i < checkboxs.length; i++) {
                    checkboxs[i].checked=true;
                }
            }
            else{
                for (var i = 0; i < checkboxs.length; i++) {
                    checkboxs[i].checked=false;
                }
            }
            
            
        }

        function areCheckAll() {
            var comprobar=true;
            var checkboxs=document.getElementsByClassName('checkEliminar');
            for (var i = 0; i < checkboxs.length; i++) {
                if(checkboxs[i].checked==false){
                    comprobar=false;
                }
            }
            if(comprobar){ 
                document.getElementById('checkAll').checked=true;
            }else{
                document.getElementById('checkAll').checked=false;
            }
        }
    </script>
@endsection

@section('mainContainer')
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">


                <div class="row ">
                    <div class="col-xs-12 text-center">
                        <h4><b>{!! trans('applicationResource.admin.edit') !!}</b></h4>
                    </div>
                </div>

                

                @include('admin.adminMenuPartial')
                <br>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/search') }}"
                      onsubmit="showLoading()">
                    @csrf
                    <hr class="col-xs-12 invisible">

                    <div class="form-group row">
                        <label class="col-xs-offset-4 col-xs-1 col-sm-offset-3 col-sm-2 control-label ">Id</label>
                        <div class="col-xs-4 col-sm-2">
                            <input type="text" class="form-control  input-sm" id="id" name="id">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xs-offset-4 col-xs-1 col-sm-offset-3 col-sm-2 control-label">Ref</label>
                        <div class="col-xs-4 col-sm-2">
                            <input type="text" class="form-control input-sm" id="reference" name="reference">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-12 text-center">
                            <button type="submit" name="submitBtn" value="submitBtn" class="btn btn-danger">
                                {!! trans('applicationResource.form.buscar') !!}
                            </button>
                        </div>
                    </div>
                </form>
                
                @if (session('message'))
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h4 class="help-block">
                                <strong style="color: red;">{!! trans('applicationResource.errors.busquedaNull') !!}</strong>
                            </h4>
                        </div>
                    </div>
                @endif
                



                @if(isset($molecules))

                    @if(count($molecules)>0)
                    <div class="row">
                        <div class="col-xs-8 col-xs-offset-2">
                            {{ Form::open(array('method' => 'DELETE', 'action' => 'AdminSearchController@destroy')) }}
                                <table class="footable table tablet footable-loaded" data-page-size="5">
                                    <thead>
                                        <tr>
                                            <th class="footable-visible footable-first-column">ID</th>
                                            <th class="footable-visible">Reference</th>
                                            <th class="footable-visible">Edit</th>
                                            <th class="footable-visible footable-last-column">
                                                <input type="checkbox" id="checkAll" onclick="selectAll()">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($molecules as $reference)
                                        <tr>
                                            <td>{!! $reference->id !!}</td>
                                            <td>{!! $reference->reference !!}</td>
                                            <td><a href="{!! url('admin/molEdit/'.$reference->id)!!}"
                                                   class="btn btn-danger "
                                                   role="button">{!! trans('applicationResource.button.view') !!}</a>
                                            </td>
                                            <td><input type="checkbox" name="check[]" property="check" class="checkEliminar" value="{!!$reference->id!!}" onclick="areCheckAll()"></td>
                                        </tr>
                                    @endforeach
                                    <input type="text" hidden="true" name="reference" value="{!!$reference->reference!!}">
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <div class="pagination pagination-centered"></div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <hr class="invisible">
                                <div class="row text-center">
                                    <div class="col-xs-12">
                                        <button type="submit" name="" value="removeBtn" class="btn btn-md btn-danger">
                                            {!! trans('applicationResource.button.delete') !!}
                                        </button>
                                    </div>
                                </div>
                            {{Form::close()}}
                        </div>
                    </div>
                    @else
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <h4 class="help-block">
                                    <strong style="color: red;">{!! trans('applicationResource.errors.deleteOk') !!}</strong>
                                </h4>
                            </div>
                        </div>
                    @endif
                    
                @endif


                @if(isset($references))
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h4 class="help-block">
                                <strong style="color: red;">{!! trans('applicationResource.errors.reference') !!}</strong>
                            </h4>
                        </div>
                    </div>
                @endif

                @if ($errors->has('emptyError'))
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h4 class="help-block">
                                <strong style="color: red;">{!! trans('applicationResource.errors.requeridos') !!}</strong>
                            </h4>
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </section>

@endsection