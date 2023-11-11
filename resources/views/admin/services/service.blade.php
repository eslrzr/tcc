@extends('adminlte::page')
@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
    <h1>{{ trans_choice('general.services', 1) . ' - ' . $service->name}}</h1>
    <p>{{ $service->description }}</p>
    <div id="finish-service" @class(['text-center'])>
        <p>@lang('alerts.service_finished')</p>
        @include('adminlte::components.form.button', [
            'type' => 'button',
            'label' => __('general.finish_service'),
            'icon' => 'fas fa-check',
            'theme' => 'success',
            'classes' => 'mb-4',
            'service' => $service,
            'attributes' => [
                'data-toggle' => 'modal',
                'data-target' => '#finishServiceModal'
            ],
        ])
    </div>
@stop
@section('content')
    @include('adminlte::components.tool.jkanban', [
        'projects' => $projects,
    ])
    @foreach ($projects as $project)
        @include('adminlte::components.tool.modal', [
            'id' => 'deleteModal' . $project->id,
            'title' => __('general.delete_project'),
            'icon' => 'fas fa-trash',
            'size' => 'modal-md',
            'slot' => 'admin.services.projects.delete',
            'route' => 'deleteProject',
            'deleteFooter' => true,
            'footer' => false,
            'data' => $project,
        ])
        @include('adminlte::components.tool.modal', [
            'id' => 'imageModal' . $project->id,
            'formId' => 'my-dropzone',
            'formClass' => 'dropzone',
            'title' => __('general.images_project'),
            'icon' => 'fas fa-images',
            'size' => 'modal-md',
            'slot' => 'admin.services.projects.image',
            'route' => 'imageProject',
            'deleteFooter' => false,
            'footer' => false,
            'project' => $project,
        ])
    @endforeach
@include('adminlte::components.tool.modal', [
    'id' => 'finishServiceModal',
    'title' => __('general.finish_service'),
    'icon' => 'fas fa-check',
    'size' => 'modal-md',
    'slot' => 'admin.services.projects.finish',
    'route' => 'finishService',
    'deleteFooter' => false,
    'footer' => true,
])
@stop
@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')
@push('js')
    <script>
        $('#content-wrapper').addClass('kanban');
    </script>
@endpush