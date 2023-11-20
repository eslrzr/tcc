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
    <div id="reopen-service" @class(['text-center'])>
        <div @class(['row', 'd-flex', 'justify-content-center'])>
            <div @class(['col-3'])>
                <div @class(['info-box'])>
                    <span @class(['info-box-icon', 'bg-primary', 'elevation-1'])><i @class(['fas', 'fa-undo'])></i></span>
                    <div @class(['info-box-content'])>
                        <span @class(['info-box-text'])>{{ __('charts.reopen_count') }}</span>
                        <span @class(['info-box-number'])>{{ $service->reopen_count }}</span>
                    </div>
                </div>
            </div>
        </div>
        <p>@lang('alerts.service_reopen')</p>
        @include('adminlte::components.form.button', [
            'type' => 'button',
            'label' => __('general.reopen_service'),
            'icon' => 'fas fa-unlock',
            'theme' => 'primary',
            'classes' => 'mb-4',
            'service' => $service,
            'attributes' => [
                'data-toggle' => 'modal',
                'data-target' => '#reopenServiceModal'
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
            'hasForm' => true,
            'deleteFooter' => true,
            'footer' => false,
            'cancelFooter' => false,
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
            'hasForm' => false,
            'deleteFooter' => false,
            'footer' => false,
            'cancelFooter' => false,
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
    'hasForm' => true,
    'deleteFooter' => false,
    'footer' => true,
    'cancelFooter' => false,
])
@include('adminlte::components.tool.modal', [
    'id' => 'reopenServiceModal',
    'title' => __('general.reopen_service'),
    'icon' => 'fas fa-unlock',
    'size' => 'modal-md',
    'slot' => 'admin.services.projects.reopen',
    'route' => 'reopenService',
    'hasForm' => true,
    'deleteFooter' => false,
    'footer' => true,
    'cancelFooter' => false,
])
@stop
@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')
@push('js')
    <script>
        $('#content-wrapper').addClass('kanban');

        var service = {!! json_encode($service) !!};
        if (service.end_date != null && service.reopen == 0) {
            $('#finish-service').hide();
            $('#reopen-service').show();
            // blur the kanban
            $('#kanban').css('filter', 'blur(2px)');
            // disable the kanban
            $('#kanban').css('pointer-events', 'none');
        } else if (service.end_date == null) {
            $('#reopen-service').hide();
            // unblur the kanban
            $('#kanban').css('filter', 'blur(0px)');
            // enable the kanban
            $('#kanban').css('pointer-events', 'auto');
        } else if (service.reopen == 1) {
            $('#finish-service').hide();
            if (finished) {
                $('#finish-service').show();
            }
            $('#reopen-service').hide();
            // unblur the kanban
            $('#kanban').css('filter', 'blur(0px)');
            // enable the kanban
            $('#kanban').css('pointer-events', 'auto');
        }
    </script>
@endpush