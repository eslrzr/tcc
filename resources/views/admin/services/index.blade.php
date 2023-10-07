@extends('adminlte::page')

@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
    <h1>{{ trans_choice('general.services', 2) }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <p>{{ __('general.services_list') }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
            @include('adminlte::components.form.button', [
                'type' => 'button',
                'label' => __('general.create'),
                'icon' => 'fas fa-plus',
                'theme' => 'primary',
                'classes' => 'mb-4',
                'attributes' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#createServiceModal'
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
    'id' => 'createServiceModal',
    'title' => __('general.create_service'),
    'icon' => 'fas fa-wrench',
    'size' => 'modal-lg',
    'slot' => 'admin.services.create',
    'route' => 'createService',
    'footer' => true,
    'deleteFooter' => false,
])

@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')