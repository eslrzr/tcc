@extends('adminlte::page')
@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
<div @class(['d-flex', 'justify-content-between'])>
    <div>
        <h1>{{ __('general.in_outs') }}</h1>
        <p>{{ __('general.in_outs_list') }}</p>
    </div>
    <div @class(['card', 'card-primary', 'card-outline', 'col-3'])>
        <div @class(['card-body', 'box-profile', 'text-center'])>
            <ul @class(['list-group', 'list-group-unbordered', 'mb-3'])>
                <li @class(['list-group-item', 'text-center'])>
                    <b>{{ __('general.money_in_cash') }}:</b> R$ {{ $cash->value }}
                </li>
            </ul>
        </div>
    </div>
</div>
@stop
@section('content')
    <div @class(['text-right'])>
        @include('adminlte::components.form.button', [
            'type' => 'button',
            'label' => __('general.add_in_out_event'),
            'icon' => 'fas fa-plus',
            'theme' => 'primary',
            'classes' => 'mb-4',
            'attributes' => [
                'data-toggle' => 'modal',
                'data-target' => '#createInOutModal'
            ],
        ])
    </div>
    @include('adminlte::components.tool.datatable')
    @include('adminlte::components.tool.modal', [
        'id' => 'createInOutModal',
        'title' => __('general.add_in_out_event'),
        'icon' => 'fas fa-money-bill-wave',
        'size' => 'modal-lg',
        'slot' => 'admin.cashes.in_out.create',
        'route' => 'createInOut',
        'footer' => true,
        'deleteFooter' => false,
    ])
@stop
@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')
