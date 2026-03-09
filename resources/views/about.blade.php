@extends('layouts.master')

@section('mainContainer')
<section class="container main-container">

    {{-- TÍTULO --}}
    <div class="row">
        <div class="col-xs-12 text-center">
            <h4><b>{!! trans('applicationResource.about.title') !!}</b></h4>
        </div>
    </div>
    <hr class="invisible">

    {{-- ¿QUÉ ES NAPROC-13? --}}
    <div class="row">
        <div class="col-xs-12 col-md-10 col-md-offset-1">
            <h4><b>{!! trans('applicationResource.about.whatisTitle') !!}</b></h4>
            <p>{!! trans('applicationResource.about.whatisText1') !!}</p>
            <p>{!! trans('applicationResource.about.whatisText2') !!}</p>
        </div>
    </div>
    <hr class="invisible">

    {{-- ESTADÍSTICAS --}}
    <div class="row text-center">
        <div class="col-xs-12 col-sm-4">
            <div style="border: 2px solid #CB0223; border-radius: 6px; padding: 20px 10px; margin-bottom: 15px;">
                <h2 style="color: #CB0223; font-weight: bold; margin: 0;">+30.000</h2>
                <p style="margin: 6px 0 0; color: #555;">{!! trans('applicationResource.about.stat1') !!}</p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div style="border: 2px solid #CB0223; border-radius: 6px; padding: 20px 10px; margin-bottom: 15px;">
                <h2 style="color: #CB0223; font-weight: bold; margin: 0;"> C<sup>13</sup> NMR</h2>
                <p style="margin: 6px 0 0; color: #555;">{!! trans('applicationResource.about.stat2') !!}</p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div style="border: 2px solid #CB0223; border-radius: 6px; padding: 20px 10px; margin-bottom: 15px;">
                <h2 style="color: #CB0223; font-weight: bold; margin: 0;">USAL</h2>
                <p style="margin: 6px 0 0; color: #555;">{!! trans('applicationResource.about.stat3') !!}</p>
            </div>
        </div>
    </div>
    <hr class="invisible">

    {{-- ¿QUÉ ES RMN C13? --}}
    <div class="row">
        <div class="col-xs-12 col-md-10 col-md-offset-1">
            <h4><b>{!! trans('applicationResource.about.nmrTitle') !!}</b></h4>
            <p>{!! trans('applicationResource.about.nmrText1') !!}</p>
            <p>{!! trans('applicationResource.about.nmrText2') !!}</p>
        </div>
    </div>
    <hr class="invisible">

    {{-- HERRAMIENTAS DE BÚSQUEDA --}}
    <div class="row">
        <div class="col-xs-12 col-md-10 col-md-offset-1">
            <h4><b>{!! trans('applicationResource.about.toolsTitle') !!}</b></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div style="border-left: 4px solid #CB0223; padding: 12px 16px; margin-bottom: 15px; background: #fafafa;">
                <strong>01 — {!! trans('applicationResource.submenu.nombre') !!}</strong>
                <p style="margin-top: 6px; font-size: 13px; color: #555;">{!! trans('applicationResource.about.tool1') !!}</p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div style="border-left: 4px solid #CB0223; padding: 12px 16px; margin-bottom: 15px; background: #fafafa;">
                <strong>02 — {!! trans('applicationResource.submenu.subestructura') !!}</strong>
                <p style="margin-top: 6px; font-size: 13px; color: #555;">{!! trans('applicationResource.about.tool2') !!}</p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div style="border-left: 4px solid #CB0223; padding: 12px 16px; margin-bottom: 15px; background: #fafafa;">
                <strong>03 — {!! trans('applicationResource.submenu.desplazamiento') !!}</strong>
                <p style="margin-top: 6px; font-size: 13px; color: #555;">{!! trans('applicationResource.about.tool3') !!}</p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div style="border-left: 4px solid #CB0223; padding: 12px 16px; margin-bottom: 15px; background: #fafafa;">
                <strong>04 — {!! trans('applicationResource.submenu.tipocarbono') !!}</strong>
                <p style="margin-top: 6px; font-size: 13px; color: #555;">{!! trans('applicationResource.about.tool4') !!}</p>
            </div>
        </div>
    </div>
    <hr class="invisible">

    {{-- HISTORIA --}}
    <div class="row">
        <div class="col-xs-12 col-md-10 col-md-offset-1">
            <h4><b>{!! trans('applicationResource.about.historyTitle') !!}</b></h4>
            <table class="table" style="margin-top: 10px;">
                <tbody>
                    <tr>
                        <td style="width: 100px; color: #CB0223; font-weight: bold; vertical-align: top;">~2000</td>
                        <td>{!! trans('applicationResource.about.history1') !!}</td>
                    </tr>
                    <tr>
                        <td style="color: #CB0223; font-weight: bold; vertical-align: top;">2010</td>
                        <td>{!! trans('applicationResource.about.history2') !!}</td>
                    </tr>
                    <tr>
                        <td style="color: #CB0223; font-weight: bold; vertical-align: top;">2020</td>
                        <td>{!! trans('applicationResource.about.history3') !!}</td>
                    </tr>
                    <tr>
                        <td style="color: #CB0223; font-weight: bold; vertical-align: top;">{!! trans('applicationResource.about.today') !!}</td>
                        <td>{!! trans('applicationResource.about.history4') !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr class="invisible">

    {{-- CÓMO CITAR --}}
    <div class="row">
        <div class="col-xs-12 col-md-10 col-md-offset-1">
            <h4><b>{!! trans('applicationResource.about.citeTitle') !!}</b></h4>
            <p>{!! trans('applicationResource.about.citeText') !!}</p>
            <div style="background: #f5f5f5; border-left: 4px solid #CB0223; padding: 14px 18px; border-radius: 0 4px 4px 0; font-family: monospace; font-size: 13px;" id="citeBox">
                Departamento de Ciencias Farmacéuticas, Universidad de Salamanca.
                NAPROC-13: Natural Products C<sup>13</sup> NMR Database.
                Disponible en: {{ url('/') }}
            </div>
            <br>
            <button class="btn btn-danger btn-sm" onclick="copyCite()">
                {!! trans('applicationResource.about.citeCopy') !!}
            </button>
        </div>
    </div>
    <hr class="invisible">

    {{-- CTA --}}
    <div class="row text-center">
        <div class="col-xs-12">
            <a href="{{ url('search/byName') }}" class="btn btn-danger btn-lg">
                {!! trans('applicationResource.about.cta') !!}
            </a>
        </div>
    </div>
    <hr class="invisible">

</section>
@endsection

@section('scripts')
<script>
function copyCite() {
    var text = "Departamento de Ciencias Farmacéuticas, Universidad de Salamanca. NAPROC-13: Natural Products C13 NMR Database. Disponible en: {{ url('/') }}";
    navigator.clipboard.writeText(text).then(function() {
        var btn = document.querySelector('[onclick="copyCite()"]');
        var orig = btn.innerHTML;
        btn.innerHTML = '✓ {!! trans('applicationResource.about.citeCopied') !!}';
        setTimeout(function() { btn.innerHTML = orig; }, 2000);
    });
}
</script>
@endsection
