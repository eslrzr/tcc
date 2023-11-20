@extends('adminlte::page')

@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
    <h1>@lang('general.indicators')</h1>
    <p>@lang('general.operation_indicators')</p>
@stop
@section('content')
<div @class(['row'])>
    <div @class(['col-12', 'col-sm-6', 'col-md-4'])>
        <div @class(['info-box'])>
            <span @class(['info-box-icon', 'bg-info', 'elevation-1'])><i @class(['fas', 'fa-file'])></i></span>
            <div @class(['info-box-content'])>
                <span @class(['info-box-text'])>{{ trans_choice('general.documents', 2) }}</span>
                <span @class(['info-box-number'])>{{ __('general.total') }}: {{ $totalDocuments }}</span>
                <span @class(['info-box-number'])>{{ __('charts.pending_documents') }}: {{ $pendingDocuments }}</span>
            </div>
        </div>
    </div>
    <div @class(['col-12', 'col-sm-6', 'col-md-4'])>
        <div @class(['info-box'])>
            <span @class(['info-box-icon', 'bg-primary', 'elevation-1'])><i @class(['fas', 'fa-wrench'])></i></span>
            <div @class(['info-box-content'])>
                <span @class(['info-box-text'])>{{ trans_choice('general.services', 2) }}</span>
                <span @class(['info-box-number'])>{{ __('general.total') }}: {{ $totalServices }}</span>
                <span @class(['info-box-number'])>{{ __('charts.done_services') }}: {{ $doneServices }}</span>
            </div>
        </div>
    </div>
    <div @class(['col-12', 'col-sm-6', 'col-md-4'])>
        <div @class(['info-box'])>
            <span @class(['info-box-icon', 'bg-navy', 'elevation-1'])><i @class(['fas', 'fa-user-tie'])></i></span>
            <div @class(['info-box-content'])>
                <span @class(['info-box-text'])>{{ trans_choice('general.employees', 2) }}</span>
                <span @class(['info-box-number'])>{{ __('general.total') }}: {{ $totalEmployees }}</span>
                <span @class(['info-box-number'])>{{ __('charts.active_employees') }}: {{ $activeEmployees }}</span>
            </div>
        </div>
    </div>
</div>
{{-- <h3>@lang('general.charts')</h3>
<p>@lang('general.financial_charts')</p>
<div class="row">
    <div class="col-6">
        <div class="card card-lime">
            <div class="card-header">
                <h3 class="card-title">@lang('general.in_outs')</h3>
            </div>
            <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">@lang('charts.services_in')</h3>
            </div>
            <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div> --}}
@stop