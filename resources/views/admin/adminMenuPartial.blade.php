<div class="row">
    <div class="col-xs-12">
        <div class="btn-group btn-group-justified hidden-xs">
            <a href="{!! url('/admin/logs') !!}"
               class="btn btn-danger">{!! trans('applicationResource.admin.logs') !!}</a>
            <div class="btn-group">
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                    {!! trans('applicationResource.admin.mol') !!}
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{!! url('/admin/molEdit') !!}">{!! trans('applicationResource.admin.new') !!}</a>
                    </li>
                    <li><a href="{!! url('/admin/search') !!}">{!! trans('applicationResource.admin.edit') !!}</a>
                    </li>
                    <li><a href="{!! url('/admin/upload') !!}">{!! trans('applicationResource.admin.excel') !!}</a>
                    </li>
                    <li><a href="{!! url('/admin/confirm') !!}">{!! trans('applicationResource.admin.confirm') !!}</a>
                    </li>
                    <li><a href="{!! url('/admin/lastMolecules') !!}">{!! trans('applicationResource.admin.lastMol') !!}</a>
                    </li>
                </ul>
            </div>
            <a href="{!! url('/admin/users') !!}"
               class="btn btn-danger">{!! trans('applicationResource.admin.users') !!}</a>
            <a href="{!! url('/admin/config') !!}"
               class="btn btn-danger">{!! trans('applicationResource.admin.config') !!}</a>
        </div>
    </div>
</div>
<div class="row text-center">
    <div class="col-xs-12">
        <div class="btn-group btn-group-vertical hidden-sm hidden-md hidden-lg">
            <a href="{!! url('/admin/logs') !!}"
               class="btn btn-danger">{!! trans('applicationResource.admin.logs') !!}</a>
            <div class="btn-group">
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                    {!! trans('applicationResource.admin.mol') !!}
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{!! url('/admin/molEdit') !!}">{!! trans('applicationResource.admin.new') !!}</a>
                    </li>
                    <li><a href="{!! url('/admin/search') !!}">{!! trans('applicationResource.admin.edit') !!}</a>
                    </li>
                    <li><a href="{!! url('/admin/upload') !!}">{!! trans('applicationResource.admin.excel') !!}</a>
                    </li>
                </ul>
            </div>
            <a href="{!! url('/admin/users') !!}"
               class="btn btn-danger">{!! trans('applicationResource.admin.users') !!}</a>
            <a href="{!! url('/admin/config') !!}"
               class="btn btn-danger">{!! trans('applicationResource.admin.config') !!}</a>
        </div>
    </div>
</div>