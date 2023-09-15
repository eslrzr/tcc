@extends('adminlte::page')

@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
    <h1>{{ trans_choice('general.users', 2) }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <p>{{ __('general.users_list') }}</p>
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
                    'data-target' => '#createUserModal'
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
    'id' => 'createUserModal',
    'title' => __('general.create_user'),
    'icon' => 'fas fa-user-plus',
    'size' => 'modal-lg',
    'slot' => 'admin.users.create',
    'route' => 'createUser',
    'footer' => true,
])

@section('plugins.BootstrapSwitch', true)
@section('js')
    <script>
        $('input[data-bootstrap-switch]').each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

        $('input[data-bootstrap-switch]').on('switchChange.bootstrapSwitch', function(event, state) {
            var userId = $(this).val();
            var status = state ? 1 : 0;
            changeStatus(userId, status);
        });

        function changeStatus(userId, status) {
            $.ajax({
                url: '/api/admin/users/' + userId + '/status',
                type: 'PUT',
                data: {
                    id: userId,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1200
                        })
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1200
                        })
                    }
                }
            });
        }
    </script>
@stop
@include('adminlte::components.tool.onpageload')