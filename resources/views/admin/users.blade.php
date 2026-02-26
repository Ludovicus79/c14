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
@endsection

@section('mainContainer')
    <section class="container-fluid main-container">
        <div class="row">
            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">


                <div class="row">
                    <div class="col-xs-12 text-center">
                        <h2>{!! trans('applicationResource.admin.users') !!}</h2>
                    </div>
                </div>

                @include('admin.adminMenuPartial')

                @if (session('eliminado'))
                    <div class="row">
                        <div class="col-xs-12 text-center" style="color: #CB0223">
                            <h2>{!! trans('applicationResource.admin.deleteUser') !!}</h2>
                        </div>
                    </div>
                @endif
                    
                    
                <hr class="invisible">

                

                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <table class="footable table" data-sort="false">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>{!! trans('applicationResource.userData.name') !!}</th>
                                        <th class="col-md-1">{!! trans('applicationResource.userData.allowed') !!}</th>
                                        <th style="width: 50px; border-bottom: solid 1px #000;"> </th>
                                        <th style="width: 50px; border-bottom: solid 1px #000;"> </th>
                                    </tr>

                                    </thead>

                                    <tbody>
                                    @for($i = 0; $i < sizeof($users); $i++)
                                        <tr>
                                            <td>{!! $users[$i]->id !!}</td>
                                            <td>{!! $users[$i]->name !!}</td>
                                            <td>
                                                <div class="square {!! $users[$i]->allowed?'greenSquare':'redSquare' !!} "></div>
                                            </td>
  <td style="text-align: center;">
    <a href="{{ url('admin/users/show/'.$users[$i]->id) }}">Ver</a>
</td>
<td style="text-align: center;">
    <form action="{{ url('admin/users/'.$users[$i]->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
    </form>
</td>                           </tr>
                                    @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 text-center">
                        {{ $users->render() }}
                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection