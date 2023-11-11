@extends('adminlte::page')
@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
    <h1>{{ trans_choice('general.services', 2) }}</h1>
    <p>{{ __('general.services_list') }}</p>
@stop
@section('content')
    <div @class(['text-right'])>
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
    @include('adminlte::components.tool.datatable')
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
    @foreach ($data as $service)
        @include('adminlte::components.tool.modal', [
            'id' => 'editModal' . $service->id,
            'title' => __('general.update_service'),
            'icon' => 'fas fa-edit',
            'size' => 'modal-lg',
            'slot' => 'admin.services.update',
            'route' => 'updateService',
            'footer' => true,
            'deleteFooter' => false,
            'data' => $service
        ])
        @include('adminlte::components.tool.modal', [
            'id' => 'deleteModal' . $service->id,
            'title' => __('general.delete_service'),
            'icon' => 'fas fa-trash',
            'size' => 'modal-md',
            'slot' => 'admin.services.delete',
            'route' => 'deleteService',
            'footer' => false,
            'deleteFooter' => true,
            'data' => $service
        ])
    @endforeach
@stop
@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')