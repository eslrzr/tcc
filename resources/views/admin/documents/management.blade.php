@extends('adminlte::page')
@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
    <h1>{{ __('general.document_management') }}</h1>
    <p>{{ __('general.document_management_explain') }}</p>
@stop
@section('content')
    @include('adminlte::components.tool.datatable')
    @foreach ($data as $document)
    @include('adminlte::components.tool.modal', [
        'id' => 'commentModal' . $document->id,
        'title' => __('general.document_comments'),
        'icon' => 'fas fa-comment',
        'size' => 'modal-md',
        'slot' => 'admin.documents.comments',
        'route' => 'viewEmployee',
        'footer' => false,
        'deleteFooter' => false,
    ])
    @endforeach
@stop
@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')
@push('js')
    <script>
        function changeProcessStatus(documentId) {
            var darkmode = {{ auth()->user()->dark_mode }};
            var id = '#document-status-' + documentId;
            var status = $(id).val();
            var classMap = {
                'N': 'badge-light',
                'A': 'badge-info',
                'F': 'badge-success',
                'R': 'badge-danger'
            };
            var defaultClass = 'badge-light';
            var selectedClass = classMap[status] || defaultClass;
            var classes = $(id).attr('class').split(' ');

            classes.forEach(function (item) {
                if (item !== selectedClass && item !== 'badge') {
                    $(id).removeClass(item);
                }
            });
            $(id).addClass(selectedClass);

            $.ajax({
                url: '{{ route('changeProcessStatus') }}',
                type: 'POST',
                data: {
                    id: documentId,
                    process_status: status,
                },
                success: function (response) {
                    if (response.success) {
                        showToastMessage(true, response.message);
                    } else {
                        showToastMessage(false, response.message);
                    }
                },
            });
        }
    </script>
@endpush