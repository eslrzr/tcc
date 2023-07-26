@extends('adminlte::page')

@section('title', ' Empreiteira Andrades - Administração')

@section('content_header')
    <h1>@lang('general.indicadores')</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <p>@lang('general.indicadores_operacao')</p>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <!-- DONUT CHART -->
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">@lang('general.entradas_saidas')</h3>
                </div>
                <div class="card-body">
                    <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop