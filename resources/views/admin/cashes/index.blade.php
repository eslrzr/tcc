@extends('adminlte::page')
@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
<div @class(['d-flex', 'justify-content-between'])>
    <div>
        <h1>{{ __('general.in_outs') }}</h1>
        <p>{{ __('general.in_outs_list') }}</p>
    </div>
    <div @class(['card', 'card-primary', 'card-outline', 'col-3'])>
        <div @class(['card-body', 'box-profile', 'text-center'])>
            <ul @class(['list-group', 'list-group-unbordered', 'mb-3'])>
                <li @class(['list-group-item', 'text-center'])>
                    <b>{{ __('general.money_in_cash') }}:</b> R$ {{ $cash->value }}
                </li>
            </ul>
        </div>
    </div>
</div>
@stop
@section('content')
    <div @class(['row', 'd-flex', 'justify-content-between'])>
        <div @class(['col-3'])></div>
        <div @class(['col-6', 'text-center'])>
            <p>{{ __('alerts.explain_filter') }}</p>
            <div @class(['btn-group', 'btn-group-toggle']) data-toggle="buttons">
                <label id="btn-in" @class(['btn', 'btn-sm', 'btn-outline-success'])>
                    <input type="checkbox" autocomplete="off" onclick="inOutFilter()"> {{ __('form.in') }}
                </label>
                <label id="btn-out" @class(['btn', 'btn-sm', 'btn-outline-danger'])>
                    <input type="checkbox"  autocomplete="off" onclick="inOutFilter()"> {{ __('form.out') }}
                </label>
            </div>
        </div>
        <div @class(['col-3', 'text-right'])>
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
    @include('adminlte::components.tool.datatable')
    <div @class(['row', 'd-flex', 'justify-content-center', 'mt-4'])">
        <div id="loading" @class(['col-9']) hidden>
            <p @class(['text-center'])>{{ __('alerts.explain_loading_table') }}</p>
            <div @class(['skeleton', 'skeleton-text'])></div>
        </div>
    </div>
    @include('adminlte::components.tool.modal', [
        'id' => 'createInOutModal',
        'title' => __('general.add_in_out_event'),
        'icon' => 'fas fa-money-bill-wave',
        'size' => 'modal-lg',
        'slot' => 'admin.cashes.in_out.create',
        'route' => 'createInOut',
        'hasForm' => true,
        'footer' => true,
        'deleteFooter' => false,
        'cancelFooter' => false,
    ])
@stop
@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')
@push('js')
    <script>
        function inOutFilter() {
            $('#loading').attr('hidden', false);
            $('.table-responsive').hide();

            setTimeout(function () {
                var paymentIn = $('#btn-in').hasClass('active');
                var paymentOut = $('#btn-out').hasClass('active');

                var table = $('#in-outs-list').DataTable();

                var searchTerm = '';
                if (paymentIn) {
                    searchTerm += '{{ __('form.in') }}|';
                }
                if (paymentOut) {
                    searchTerm += '{{ __('form.out') }}|';
                }

                searchTerm = searchTerm.replace(/\|$/, '');
                table.column(3).search(searchTerm, true, false).draw();

                $('#loading').attr('hidden', true);
                $('.table-responsive').show();
            }, 1000);
        }
    </script>
@endpush
