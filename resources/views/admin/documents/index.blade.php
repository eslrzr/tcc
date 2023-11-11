@extends('adminlte::page')
@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
    <h1>{{ trans_choice('general.documents', 2) }}</h1>
    <p>{{ __('general.documents_list') }}</p>
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
                'data-target' => '#createDocumentModal'
            ],
        ])
    </div>
    @include('adminlte::components.tool.datatable')
    @include('adminlte::components.tool.modal', [
        'id' => 'createDocumentModal',
        'formId' => 'my-dropzone',
        'formClass' => 'dropzone',
        'title' => __('general.create_document'),
        'icon' => 'fas fa-file-alt',
        'size' => 'modal-lg',
        'slot' => 'admin.documents.create',
        'route' => 'createDocument',
        'footer' => true,
        'deleteFooter' => false,
    ])
@stop
@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')