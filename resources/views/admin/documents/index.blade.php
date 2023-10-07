@extends('adminlte::page')

@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
    <h1>{{ trans_choice('general.documents', 2) }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <p>{{ __('general.documents_list') }}</p>
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
                    'data-target' => '#createDocumentModal'
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
    'id' => 'createDocumentModal',
    'title' => __('general.create_document'),
    'icon' => 'fas fa-file-alt',
    'size' => 'modal-lg',
    'slot' => 'admin.documents.create',
    'route' => 'createDocument',
    'footer' => true,
    'deleteFooter' => false,
])

@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')