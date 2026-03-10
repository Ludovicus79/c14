<div class="form-group row">
           
  
<!-- FAMILIA -->
<div class="{{ $errors->has('family') ? ' has-error' : '' }} " id="searchSubstructure1">
    <label class="col-xs-12 col-sm-1 control-label">{!! trans('applicationResource.form.familia') !!}</label>
    <div class="col-xs-12 col-sm-3" id="desplegableFam">
        <select class="form-control " name="family" id="family">
            <option selected="true" value="">- - -</option>
        </select>
        @if ($errors->has('family'))
            <span class="col-xs-12 col-sm-5 col-md-5 help-block">
                            <strong>{{ $errors->first('family') }}</strong>
                        </span>
        @endif
    </div>
</div>
<!-- FIN DE FAMILIA -->

<!-- SUBFAMILIA -->
<div class="f{{ $errors->has('subFamily') ? ' has-error' : '' }} " id="searchSubstructure2">
    <label class="col-xs-12 col-sm-1 control-label">{!! trans('applicationResource.form.tipo') !!}</label>
    <div class="col-xs-12 col-sm-3" id="desplegableType">
        <select class="form-control" name="subFamily" id="subFamily">
            <option selected="true" value="">- - -</option>
        </select>
        @if ($errors->has('subFamily'))
            <span class="help-block">
                            <strong>{{ $errors->first('subFamily') }}</strong>
                        </span>
        @endif
    </div>
</div>
<!-- FIN DE SUBFAMILIA -->

<!-- GRUPO -->
<div class="{{ $errors->has('subSubFamily') ? ' has-error' : '' }} " id="searchSubstructure3">
    <label class="col-xs-12 col-sm-1 control-label">{!! trans('applicationResource.form.grupo') !!}</label>
    <div class="col-xs-12 col-sm-3" id="desplegableGroup">
        <select class="form-control" name="subSubFamily" id="subSubFamily">
            <option selected="true" value="">- - -</option>
        </select>
        @if ($errors->has('subSubFamily'))
            <span class="help-block">
                            <strong>{{ $errors->first('subSubFamily') }}</strong>
                        </span>
        @endif
    </div>
</div>

<!-- FIN DE GRUPO -->

</div>
