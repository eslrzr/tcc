@extends('adminlte::page')

@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
    <h1>{{ trans_choice('general.employees', 2) }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <p>{{ __('general.employees_list') }}</p>
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
                    'data-target' => '#createEmployeeModal'
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
    'id' => 'createEmployeeModal',
    'title' => __('general.create_employee'),
    'icon' => 'fas fa-user-tie-plus',
    'size' => 'modal-lg',
    'slot' => 'admin.employees.create',
    'route' => 'createEmployee',
    'footer' => true,
])

@foreach ($data as $employee)
    @include('adminlte::components.tool.modal', [
        'id' => 'viewModal' . $employee->id,
        'title' => __('general.view_employee'),
        'icon' => 'fas fa-user-tie',
        'size' => 'modal-lg',
        'slot' => 'admin.employees.view',
        'route' => 'viewEmployee',
        'footer' => false,
        'data' => $employee,
    ])

    @include('adminlte::components.tool.modal', [
        'id' => 'updateModal' . $employee->id,
        'title' => __('general.update_employee'),
        'icon' => 'fas fa-user-tie-edit',
        'size' => 'modal-lg',
        'slot' => 'admin.employees.update',
        'route' => 'updateEmployee',
        'footer' => true,
        'data' => $employee,
    ])

    @include('adminlte::components.tool.modal', [
        'id' => 'shiftModal' . $employee->id,
        'title' => __('general.shift_employee'),
        'icon' => 'fas fa-calendar-week',
        'size' => 'modal-lg',
        'slot' => 'admin.employees.shift',
        'route' => 'shiftEmployee',
        'footer' => true,
        'data' => $employee,
    ])
@endforeach

@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')