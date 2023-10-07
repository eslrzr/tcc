@extends('adminlte::page')

@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
<div class="row">
    <div class="col-9">
        <h1>{{ __('general.in_outs') }}</h1>
        <p>{{ __('general.in_outs_list') }}</p>
    </div>
    <div class="col-3 text-right">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile text-center">
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item text-center">
                        <b>{{ __('general.money_in_cash') }}:</b> R$ {{ $cash->value }}
                    </li>
                </ul>
                {{-- @include('adminlte::components.form.button', [
                    'type' => 'button',
                    'label' => __('general.add'),
                    'icon' => 'fas fa-long-arrow-alt-up',
                    'theme' => 'primary',
                    'classes' => 'mb-4',
                    'attributes' => [
                        'data-toggle' => 'modal',
                        'data-target' => '#addCashModal'
                    ],
                ])
                @include('adminlte::components.form.button', [
                    'type' => 'button',
                    'label' => __('general.withdraw'),
                    'icon' => 'fas fa-long-arrow-alt-down',
                    'theme' => 'danger',
                    'classes' => 'mb-4',
                    'attributes' => [
                        'data-toggle' => 'modal',
                        'data-target' => '#withdrawCashModal'
                    ],
                ]) --}}
            </div>
        </div>
    </div>
</div>
@stop

@section('content')
    <div class="row">
        <div class="col-12 text-right">
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
    </div>
    <div class="row">
        <div class="col-12">
            @include('adminlte::components.tool.datatable')
        </div>
    </div>
@stop

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
@include('adminlte::components.tool.modal', [
    'id' => 'addCashModal',
    'title' => __('general.add_cash'),
    'icon' => 'fas fa-plus-circle',
    'size' => 'modal-sm',
    'slot' => 'admin.cashes.add',
    'route' => 'updateCash',
    'footer' => true,
    'deleteFooter' => false,
])
@include('adminlte::components.tool.modal', [
    'id' => 'withdrawCashModal',
    'title' => __('general.withdraw_cash'),
    'icon' => 'fas fa-minus-circle',
    'size' => 'modal-sm',
    'slot' => 'admin.cashes.withdraw',
    'route' => 'updateCash',
    'footer' => true,
    'deleteFooter' => false,
])

@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')
