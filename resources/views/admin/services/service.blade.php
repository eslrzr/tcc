@extends('adminlte::page')
@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
    <h1>@lang('general.services_projects')</h1>
@stop
@section('content')
    @include('adminlte::components.tool.jkanban', [
        'projects' => $projects,
    ])
    @foreach ($projects as $project)
        @include('adminlte::components.tool.modal', [
            'id' => 'deleteModal' . $project->id,
            'title' => __('general.delete_project'),
            'icon' => 'fas fa-project-diagram-trash',
            'size' => 'modal-md',
            'slot' => 'admin.services.projects.delete',
            'route' => 'deleteProject',
            'deleteFooter' => true,
            'footer' => false,
            'data' => $project,
        ])
    @endforeach
@stop
@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')
@push('js')
    <script>
        $('#content-wrapper').addClass('kanban');
    </script>
@endpush