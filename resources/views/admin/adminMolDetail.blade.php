@extends('layouts.master')

@section('headers')
    <?php
    header("Cache-Control: no-store, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");?>
@endsection

@section('scripts')
    <script>
        var index;
        $(document).ready(
                function () {
                    $('#newCButton').click(newCarbon);
                    index = $('#tabladesplazamientos tbody tr.carbonRow').size();
                    $('.delCButton').click(deleteCarbon);
                    $('#jmeArea').change(reloadJme);
                }
        )

        var deleteCarbon = function () {
            if ($('#tabladesplazamientos tbody tr.carbonRow').size() > 1) {
                $(this).closest('tr').next('.errorRow').remove();
                $(this).closest('tr').remove();
            }
        }

        var newCarbon = function () {
            row = $('<tr>').addClass('carbonRow').appendTo('#tabladesplazamientos tbody');
            $('<input>', {'type': 'hidden'}).attr('name', 'carbon[' + index + '][id]').appendTo(row);
            $('<td>').append($('<input>').addClass('form-control input-sm inp-small').attr('name', 'carbon[' + index + '][num2]')).appendTo(row);
            $('<td>').append($('<input>').addClass('form-control input-sm inp-small').attr('name', 'carbon[' + index + '][numeration]')).appendTo(row);
            selectType = $('<select>').addClass('form-control input-sm inp-small').attr('name', 'carbon[' + index + '][carbonType]');
            selectType.append($('<option value="C">C</option>'));
            selectType.append($('<option value="CH">CH</option>'));
            selectType.append($('<option value="CH2">CH<sub>2</sub></option>'));
            selectType.append($('<option value="CH3">CH<sub>3</sub></option>'));

            $('<td>').append(selectType).appendTo(row);
            $('<td>').append($('<input>').addClass('form-control input-sm inp-small').attr('name', 'carbon[' + index + '][shift]')).appendTo(row);
            $('<td>').append($('<button>').attr('type', 'button').addClass('btn btn-danger delCButton').text('X').click(deleteCarbon)).appendTo(row);
            index++;
        }

    </script>

    <script src="{!! asset('jsme/jsme.nocache.js') !!}" type="text/javascript"></script>

    <script>
        var jsmeDis;
        var jsmeNum;

        $(document).ready(
                function () {
                    $('#jmeArea').change(reloadJme);
                }
        )

        function reloadJme() {
            jsmeNum.readMolecule($(this).val());
        }

        function jsmeOnLoad() {
            jsmeNum = new JSApplet.JSME("jsme_container_num", "500px", "350px", {
                "options": "depict, number"
            });
            jsmeNum.readMolecule("{!! $molecule->jmeNumeration !!}");
            jsmeDis = new JSApplet.JSME("jsme_container_dis", "500px", "350px", {
                "options": "depict, number"
            });
            jsmeDis.readMolecule("{!! $molecule->jmeDisplacement !!}");
        }
    </script>
@endsection

@section('mainContainer')
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-sm-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">

                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h4><b>{!! trans('applicationResource.admin.edit') !!}</b></h4>
                    </div>
                </div>

                @include('admin.adminMenuPartial')

                <br>

                <form class="form-horizontal" action="{{ url('admin/molEdit/') }}" method="POST">
                    @csrf

                    <input type="hidden" name="molecule[id]" value="{!!  $molecule->id !!}">

                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Ref: </label>
                        <div class="col-sm-2 {!! $errors->has('molecule.reference')?'has-error':''!!}">
                            <input
                                    class="form-control input-sm"
                                    name="molecule[reference]"
                                    value="{!! empty(old('molecule.reference'))?$molecule->reference:old('molecule.reference') !!}">
                            @if ($errors->has('molecule.reference'))
                                <span class="help-block">{{ $errors->first('molecule.reference') }}</span>
                            @endif
                        </div>
                        <label class="col-sm-2 control-label">{!! trans('applicationResource.molData.state') !!}</label>
                        <div class="col-sm-2 {!! $errors->has('molecule.state')?'has-error':''!!}">

                            <select class="form-control input-sm" name="molecule[state]" id="molecule[state]">
                                <option value="6">Sin confirmar</option>
                                <option value="1" {!! $molecule->state=="1"?"selected":"" !!}>Confirmada</option>
                            </select>
                            @if ($errors->has('molecule.state'))
                                <span class="help-block">{{ $errors->first('molecule.state') }}</span>
                            @endif
                        </div>
                        <label class="col-sm-2 control-label">{!! trans('applicationResource.molData.solvent') !!}</label>
                        <div class="col-sm-1 {!! $errors->has('molecule.solvent')?'has-error':''!!}">
                            <input
                                    class="form-control input-sm"
                                    name="molecule[solvent]"
                                    value="{!! empty(old('molecule.solvent'))?$molecule->solvent:old('molecule.solvent') !!}">
                            @if ($errors->has('molecule.solvent'))
                                <span class="help-block ">{{ $errors->first('molecule.solvent') }}</span>
                            @endif
                        </div>

                    </div>


                    <div class="form-group row">
                        <label class="col-sm-2 control-label">{!! trans('applicationResource.molData.family') !!}</label>
                        <div class="col-sm-2 {!! $errors->has('molecule.family')?'has-error':''!!}">
                            <input
                                    class="form-control input-sm"
                                    name="molecule[family]"
                                    value="{!! empty(old('molecule.family'))?$molecule->family:old('molecule.family') !!}">
                            @if ($errors->has('molecule.family'))
                                <span class="help-block ">{{ $errors->first('molecule.family') }}</span>
                            @endif
                        </div>
                         <label class="col-sm-2 control-label">{!! trans('applicationResource.molData.group') !!}</label>
                        <div class="col-sm-2 {!! $errors->has('molecule.subFamily')?'has-error':''!!}">
                            <input
                                    name="molecule[subFamily]"
                                    class="form-control input-sm"
                                    value="{!! empty(old('molecule.subFamily'))?$molecule->subFamily:old('molecule.subFamily') !!}">
                            @if ($errors->has('molecule.subFamily'))
                                <span class="help-block ">{{ $errors->first('molecule.subFamily') }}</span>
                            @endif
                        </div>
                        <label class="col-sm-2 control-label">{!! trans('applicationResource.molData.type') !!}</label>
                        <div class="col-sm-2 {!! $errors->has('molecule.subSubFamily')?'has-error':''!!}">
                            <input
                                    name="molecule[subSubFamily]"
                                    class="form-control input-sm"
                                    value="{!! empty(old('molecule.subSubFamily'))?$molecule->subSubFamily:old('molecule.subSubFamily') !!}">
                            @if ($errors->has('molecule.subSubFamily'))
                                <span class="help-block ">{{ $errors->first('molecule.subSubFamily') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">{!! trans('applicationResource.molData.weight') !!}</label>
                        <div class="col-sm-2">
                            {{ $molecule->molecularWeight }}
                        </div>
                        <label class="col-sm-2 control-label">{!! trans('applicationResource.molData.formula') !!}</label>
                        <div class="col-sm-2">
                            {!! $molecularFormula !!}
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-md-6 text-center"><u>{!! trans('applicationResource.submenu.desplazamiento')!!}</u></label>
                    <label class="col-md-6 text-center"><u>{!! trans('applicationResource.submenu.estructura')!!}</u></label>
                    </div>


                    <div class="row">
                        <div class="col-xs-12 col-sm-5" id="desplazamientos">
                            <table id="tabladesplazamientos">
                                <thead>
                                <tr>
                                    <td colspan="4">
                                        <button id="newCButton" class="btn btn-danger"
                                                type="button">{!! trans('applicationResource.button.add')!!}</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <span>{!! trans('applicationResource.carbonData.numeration2')!!}</span>
                                    </td>
                                    <td align="left">
                                        <span>{!! trans('applicationResource.carbonData.numeration')!!}</span>
                                    </td>
                                    <td align="left">
                                        <span>{!! trans('applicationResource.carbonData.type')!!}</span>
                                    </td>
                                    <td align="right"><span>&delta;(ppm)</span></td>
                                </tr>
                                </thead>
                                <tbody>
                                @if(old('carbon')!==null)
                                    @foreach((old('carbon')) as $i=>$carbon)
                                        <tr class="carbonRow">
                                            <input type="hidden" name="carbon[{!! $i !!}][id]"
                                                   value="{!! $carbon['id'] !!}">
                                            <td>
                                                <input class="form-control input-sm inp-small {!! $errors->has('carbon.'.$i.'.num2')?'inp-error':'' !!}"
                                                       name="carbon[{!! $i !!}][num2]"
                                                       value="{!! $carbon['num2'] !!}">
                                            </td>
                                            <td>
                                                <input class="form-control input-sm inp-small {!! $errors->has('carbon.'.$i.'.numeration')?'inp-error':'' !!}"
                                                       name="carbon[{!! $i !!}][numeration]"
                                                       value="{!! $carbon['numeration'] !!}"></td>
                                            <td><select class="form-control input-sm inp-small"
                                                        name="carbon[{!! $i !!}][carbonType]">
                                                    <option {{ $carbon['carbonType']=="C"?"selected":""}} value="C">
                                                        C
                                                    </option>
                                                    <option {{ $carbon['carbonType']=="CH"?"selected":""}} value="CH">
                                                        CH
                                                    </option>
                                                    <option {{ $carbon['carbonType']=="CH2"?"selected":""}} value="CH2">
                                                        CH<sub>2</sub></option>
                                                    <option {{ $carbon['carbonType']=="CH3"?"selected":""}} value="CH3">
                                                        CH<sub>3</sub></option>
                                                </select></td>
                                            <td>
                                                <input class="form-control input-sm inp-small {!! $errors->has('carbon.'.$i.'.shift')?'inp-error':'' !!}"
                                                       name="carbon[{!! $i !!}][shift]"
                                                       value="{!! $carbon['shift'] !!}"></td>
                                            <td>
                                                <button class="btn btn-danger delCButton" type="button">X</button>
                                            </td>
                                        </tr>
                                        <tr class="errorRow">
                                            <td colspan="5">
                                                @if ($errors->has('carbon.'.$i.'.num2'))
                                                    <span class="help-block ">{{ $errors->first('carbon.'.$i.'.num2') }}</span>
                                                @endif
                                                @if ($errors->has('carbon.'.$i.'.numeration'))
                                                    <span class="help-block ">{{ $errors->first('carbon.'.$i.'.numeration') }}</span>
                                                @endif
                                                @if ($errors->has('carbon.'.$i.'.num2'))
                                                    <span class="help-block ">{{ $errors->first('carbon.'.$i.'.shift') }}</span>
                                            @endif
                                        </tr>
                                    @endforeach

                                @else
                                    @for($i=0;$i<sizeof($carbons);$i++)
                                        <tr class="carbonRow">
                                            <input type="hidden" name="carbon[{!! $i !!}][id]"
                                                   value="{!! $carbons[$i]->id !!}">
                                            <td><input class="form-control input-sm inp-small"
                                                       name="carbon[{!! $i !!}][num2]"
                                                       value="{!! $carbons[$i]->num2 !!}">
                                            </td>
                                            <td><input class="form-control input-sm inp-small"
                                                       name="carbon[{!! $i !!}][numeration]"
                                                       value="{!! $carbons[$i]->numeration !!}"></td>
                                            <td><select class="form-control input-sm inp-small"
                                                        name="carbon[{!! $i !!}][carbonType]">
                                                    <option {{$carbons[$i]->carbonType=="C"?"selected":""}} value="C">
                                                        C
                                                    </option>
                                                    <option {{$carbons[$i]->carbonType=="CH"?"selected":""}} value="CH">
                                                        CH
                                                    </option>
                                                    <option {{$carbons[$i]->carbonType=="CH2"?"selected":""}} value="CH2">
                                                        CH<sub>2</sub></option>
                                                    <option {{$carbons[$i]->carbonType=="CH3"?"selected":""}} value="CH3">
                                                        CH<sub>3</sub></option>
                                                </select></td>
                                            <td><input class="form-control input-sm inp-small"
                                                       name="carbon[{!! $i !!}][shift]"
                                                       value="{!! $carbons[$i]->shift !!}"></td>
                                            <td>
                                                <button class="btn btn-danger delCButton" type="button">X</button>
                                            </td>
                                        </tr>
                                    @endfor
                                @endif
                                </tbody>

                            </table>
                        </div>



                        <div class="col-xs-12 col-sm-6">
                            <div class="jmeProp" id="jsme_container_num"></div>
                            <div class="jmeProp" id="jsme_container_dis"></div>
                        </div>

                    </div>

                    <hr class="invisible"></hr>

                    <div class="form-group row">
                        <label class="col-sm-3 control-label">{!! trans('applicationResource.molData.name') !!}</label>
                        <div class="col-sm-5 {!! $errors->has('molecule.name')?'has-error':''!!}">
                            <input
                                    class="form-control input-sm"
                                    name="molecule[name]"
                                    value="{!! empty(old('molecule.name'))?$molecule->name:old('molecule.name') !!}">
                            @if ($errors->has('molecule.name'))
                                <span class="help-block ">{{ $errors->first('molecule.name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 control-label">{!! trans('applicationResource.molData.ssname') !!}</label>
                        <div class="col-sm-5 {!! $errors->has('molecule.semiSystematicName')?'has-error':''!!}">
                            <input
                                    class="form-control input-sm "
                                    name="molecule[semiSystematicName]"
                                    value="{!! empty(old('molecule.semiSystematicName'))?$molecule->semiSystematicName:old('molecule.semiSystematicName') !!}">
                            @if ($errors->has('molecule.semiSystematicName'))
                                <span class="help-block ">{{ $errors->first('molecule.semiSystematicName') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row text-center">
                        <div class="col-sm-12 text-center">
                            <label class="control-label">{!! trans('applicationResource.molData.jmeNum')!!}</label>
                        </div>
                        <div class="col-sm-12 {!! $errors->has('molecule.jmeNumeration')?'has-error':''!!}">
                                <textarea
                                        class="form-control"
                                        id="jmeArea"
                                        name="molecule[jmeNumeration]">{!! empty(old('molecule.jmeNumeration'))?$molecule->jmeNumeration:old('molecule.jmeNumeration') !!}</textarea>
                            @if ($errors->has('molecule.jmeNumeration'))
                                <span class="help-block ">{{ $errors->first('molecule.jmeNumeration') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row text-center">
                        <div class="col-sm-12 text-center">
                            <label class="control-label">{!! trans('applicationResource.molData.smilesNum')!!}</label>
                        </div>
                        <div class="col-sm-12 {!! $errors->has('molecule.smilesNumeration')?'has-error':''!!}">
                            <textarea
                                    class="form-control"
                                    name="molecule[smilesNumeration]">{!! empty(old('molecule.smilesNumeration'))?$molecule->smilesNumeration:old('molecule.smilesNumeration') !!}</textarea>
                            @if ($errors->has('molecule.smilesNumeration'))
                                <span class="help-block">{{ $errors->first('molecule.smilesNumeration') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">

                            <h3>{!! trans('applicationResource.molData.bibliography') !!}</h3>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <label class="control-label">{!! trans('applicationResource.biblioData.authors')!!}</label>
                        </div>
                        <div class="col-sm-12 {!! $errors->has('bibliography.authors')?'has-error':''!!}">
                                <textarea
                                        class="form-control input-sm"
                                        name="bibliography[authors]">{!! empty(old('bibliography.authors'))?$bibliography->authors:old('bibliography.authors') !!}</textarea>
                            @if ($errors->has('bibliography.authors'))
                                <span class="help-block ">{{ $errors->first('bibliography.authors') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">


                        <label class="control-label col-sm-1">{!! trans('applicationResource.biblioData.magazine')!!}</label>
                        <div class="col-sm-4  {!! $errors->has('bibliography.magazine')?'has-error':''!!}">
                            <input
                                    class="form-control input-sm"
                                    name="bibliography[magazine]"
                                    value="{!! empty(old('bibliography.magazine'))?$bibliography->magazine:old('bibliography.magazine') !!}">
                            @if ($errors->has('bibliography.magazine'))
                                <span class="help-block ">{{ $errors->first('bibliography.magazine') }}</span>
                            @endif
                        </div>
                        <label class="control-label col-sm-1">{!! trans('applicationResource.biblioData.year')!!}</label>
                        <div class="col-sm-1 {!! $errors->has('bibliography.year')?'has-error':''!!}"><input
                                    class="form-control input-sm"
                                    name="bibliography[year]"
                                    value="{!! empty(old('bibliography.year'))?$bibliography->year:old('bibliography.year') !!}">
                            @if ($errors->has('bibliography.year'))
                                <span class="help-block">{{ $errors->first('bibliography.year') }}</span>
                            @endif
                        </div>
                        <label class="control-label col-sm-1">{!! trans('applicationResource.biblioData.volume')!!}</label>
                        <div class="col-sm-1 {!! $errors->has('bibliography.volume')?'has-error':''!!}"><input
                                    class="form-control input-sm"
                                    name="bibliography[volume]"
                                    value="{!! empty(old('bibliography.volume'))?$bibliography->volume:old('bibliography.volume') !!}">
                            @if ($errors->has('bibliography.volume'))
                                <span class="help-block ">{{ $errors->first('bibliography.volume') }}</span>
                            @endif
                        </div>
                        <label class="control-label col-sm-1">{!! trans('applicationResource.biblioData.page')!!}</label>
                        <div class="col-sm-2 {!! $errors->has('bibliography.page')?'has-error':''!!}"><input
                                    class="form-control input-sm"
                                    name="bibliography[page]"
                                    value="{!! empty(old('bibliography.page'))?$bibliography->page:old('bibliography.page') !!}">
                            @if ($errors->has('bibliography.page'))
                                <span class="help-block ">{{ $errors->first('bibliography.page') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-1">{!! trans('applicationResource.biblioData.doi')!!}</label>
                        <div class="col-sm-4  {!! $errors->has('bibliography.doi')?'has-error':''!!}">
                            <input
                                    class="form-control input-sm"
                                    name="bibliography[doi]"
                                    value="{!! empty(old('bibliography.doi'))?$bibliography->doi:old('bibliography.doi') !!}">
                            @if ($errors->has('bibliography.doi'))
                                <span class="help-block ">{{ $errors->first('bibliography.doi') }}</span>
                            @endif
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            <h3>{!! trans('applicationResource.molData.author')!!}</h3>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-2">{!! trans('applicationResource.authorData.author')!!}</label>
                        <div class="col-sm-4 {!! $errors->has('author.author')?'has-error':''!!}">
                            <input
                                    class="form-control input-sm"
                                    name="author[author]"
                                    value="{!! empty(old('author.author'))?$author->author:old('author.author') !!}">
                            @if ($errors->has('author.author'))
                                <span class="help-block  ">{{ $errors->first('author.author') }}</span>
                            @endif
                        </div>
                        <label class="control-label col-sm-2">{!! trans('applicationResource.authorData.email')!!}</label>
                        <div class="col-sm-4 {!! $errors->has('author.email')?'has-error':''!!}">
                            <input
                                    class="form-control input-sm"
                                    name="author[email]"
                                    value="{!! empty(old('author.email'))?$author->email:old('author.email') !!}">
                            @if ($errors->has('author.email'))
                                <span class="help-block ">{{ $errors->first('author.email') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-2">{!! trans('applicationResource.authorData.country')!!}</label>
                        <div class="col-sm-4 {!! $errors->has('author.country')?'has-error':''!!}">
                            <input
                                    class="form-control input-sm"
                                    name="author[country]"
                                    value="{!! empty(old('author.country'))?$author->country:old('author.country') !!}">
                            @if ($errors->has('author.country'))
                                <span class="help-block ">{{ $errors->first('author.country') }}</span>
                            @endif
                        </div>
                        <label class="control-label col-sm-2">{!! trans('applicationResource.authorData.organization')!!}</label>
                        <div class="col-sm-4 {!! $errors->has('author.organization')?'has-error':''!!}"><input
                                    class="form-control input-sm"
                                    name="author[organization]"
                                    value="{!! empty(old('author.organization'))?$author->organization:old('author.organization') !!}">
                            @if ($errors->has('author.organization'))
                                <span class="help-block ">{{ $errors->first('author.organization') }}</span>
                            @endif
                        </div>

                    </div>



                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <label class="control-label">{!! trans('applicationResource.molData.comments') !!}</label>
                        </div>
                        <div class="col-sm-12 {!! $errors->has('molecule.publicCom')?'has-error':''!!}">
                                <textarea
                                        class="form-control"
                                        name="molecule[publicCom]">{!! empty(old('molecule.publicCom'))?$molecule->publicCom:old('molecule.publicCom') !!}</textarea>
                            @if ($errors->has('molecule.publicCom'))
                                <span class="has-error ">{{ $errors->first('molecule.publicCom') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <label class="control-label">{!! trans('applicationResource.molData.priComments') !!}</label>
                        </div>
                        <div class="col-sm-12 {!! $errors->has('molecule.privateCom')?'has-error':''!!}">
                                <textarea
                                        class="form-control"
                                        name="molecule[privateCom]">{!! empty(old('molecule.privateCom'))?$molecule->privateCom:old('molecule.privateCom') !!}</textarea>
                            @if ($errors->has('molecule.privateCom'))
                                <span class="has-error ">{{ $errors->first('molecule.privateCom') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-12 text-center">
                        <button id="submitBtn" type="button" data-toggle="modal" data-target="#alertSave"
                                class="btn btn-md btn-danger">{!! trans('applicationResource.button.save') !!}</button>
                        <button type="button" id="deleteButton" data-toggle="modal" data-target="#alertDelete"
                                class="btn btn-md btn-danger {!! empty($molecule->id)?'disabled':'' !!}">{!! trans('applicationResource.button.delete') !!}</button>
                    </div>
                    <!-- Diálogo Guardar -->
                    <div id="alertSave" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-sm">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">{!! trans('applicationResource.dialog.sure') !!}</h4>
                                </div>
                                <div class="modal-body">
                                    <p>{!! trans('applicationResource.dialog.save') !!}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name
                                            class="btn btn-danger">{!! trans('applicationResource.button.confirm') !!}</
                                    >
                                    <button type="button" class="btn btn-default"
                                            data-dismiss="modal">{!! trans('applicationResource.button.cancel') !!}</button>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- Diálogo borrar -->
                    <div id="alertDelete" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-sm">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">{!! trans('applicationResource.dialog.sure') !!}</h4>
                                </div>
                                <div class="modal-body">
                                    <p>{!! trans('applicationResource.dialog.deleteMol') !!}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="delete"
                                            class="btn btn-danger">{!! trans('applicationResource.button.confirm') !!}</button>
                                    <button type="button" class="btn btn-default"
                                            data-dismiss="modal">{!! trans('applicationResource.button.cancel') !!}</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>


            </div>
        </div>
    </section>
@endsection
