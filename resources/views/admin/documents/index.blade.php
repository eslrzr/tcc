@extends('adminlte::page')
@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
    <h1>{{ trans_choice('general.documents', 2) }}</h1>
    <p>{{ __('general.documents_list') }}</p>
@stop
@section('content')
    <div @class(['row', 'd-flex', 'justify-content-between'])>
        <div @class(['col-3'])></div>
        <div @class(['col-6', 'text-center'])>
            <p>{{ __('alerts.explain_filter') }}</p>
            <div @class(['btn-group', 'btn-group-toggle']) data-toggle="buttons">
                <label id="btn-non-applicable" @class(['btn', 'btn-sm', 'btn-outline-secondary'])>
                    <input type="checkbox" autocomplete="off" onclick="documentFilter()"> {{ __('form.document_not_applicable') }}
                </label>
                <label id="btn-pending" @class(['btn', 'btn-sm', 'btn-outline-light'])>
                    <input type="checkbox" autocomplete="off" onclick="documentFilter()"> {{ __('form.document_pending') }}
                </label>
                <label id="btn-in-progress" @class(['btn', 'btn-sm', 'btn-outline-info'])>
                    <input type="checkbox" autocomplete="off" onclick="documentFilter()"> {{ __('form.document_in_progress') }}
                </label>
                <label id="btn-finished" @class(['btn', 'btn-sm', 'btn-outline-success'])>
                    <input type="checkbox" autocomplete="off" onclick="documentFilter()"> {{ __('form.document_finished') }}
                </label>
                <label id="btn-rejected" @class(['btn', 'btn-sm', 'btn-outline-danger'])>
                    <input type="checkbox"  autocomplete="off" onclick="documentFilter()"> {{ __('form.document_rejected') }}
                </label>
                <label id="btn-canceled" @class(['btn', 'btn-sm', 'btn-outline-dark'])>
                    <input type="checkbox"  autocomplete="off" onclick="documentFilter()"> {{ __('form.document_canceled') }}
                </label>
            </div>
        </div>
        <div @class(['col-3', 'text-right'])>
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
    @include('adminlte::components.tool.datatable')
    <div @class(['row', 'd-flex', 'justify-content-center', 'mt-4'])">
        <div id="loading" @class(['col-9']) hidden>
            <p @class(['text-center'])>{{ __('alerts.explain_loading_table') }}</p>
            <div @class(['skeleton', 'skeleton-text'])></div>
        </div>
    </div>
    @include('adminlte::components.tool.modal', [
        'id' => 'createDocumentModal',
        'formId' => 'my-dropzone',
        'formClass' => 'dropzone',
        'title' => __('general.create_document'),
        'icon' => 'fas fa-file-alt',
        'size' => 'modal-lg',
        'slot' => 'admin.documents.create',
        'route' => 'createDocument',
        'hasForm' => true,
        'footer' => true,
        'deleteFooter' => false,
        'cancelFooter' => false,
    ])
    @foreach ($data as $document)
        @include('adminlte::components.tool.modal', [
            'id' => 'commentModal' . $document->id,
            'title' => __('general.document_comments'),
            'icon' => 'fas fa-comment',
            'size' => 'modal-md',
            'slot' => 'admin.documents.comments',
            'hasForm' => false,
            'footer' => false,
            'deleteFooter' => false,
            'cancelFooter' => false,
        ])
        @if ($document->status == 'C' || $document->open_time < 5)
            @include('adminlte::components.tool.modal', [
                'id' => 'cancelDocumentModal' . $document->id,
                'title' => __('general.cancel_document'),
                'icon' => 'fas fa-file-alt',
                'size' => 'modal-md',
                'slot' => 'admin.documents.cancel',
                'route' => 'cancelDocument',
                'hasForm' => true,
                'footer' => false,
                'deleteFooter' => false,
                'cancelFooter' => true,
            ])
        @endif
    @endforeach
@stop
@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')
@push('js')
    <script>
        // verificar tempo em aberto dos documentos para disponibilizar botão de cancelar
        const documents = @json($data);
        
        verifyDocumentDate();
        setInterval(function() {
            verifyDocumentDate();
        }, 60000);
        
        function verifyDocumentDate() {
            var today = new Date();
            var todayTimestamp = today.getTime();

            documents.forEach(document => {
                var documentDate = new Date(document.created_at);
                var documentDateTimestamp = documentDate.getTime();
                var difference = todayTimestamp - documentDateTimestamp;
                // diferença em minutos
                var differenceInMinutes = Math.round(difference / 60000);

                if (differenceInMinutes < 5) {
                    $('#cancel-document-' + document.id).attr('hidden', false);
                } else {
                    $('#cancel-document-' + document.id).attr('hidden', true);
                }
            });
        }

        function documentFilter() {
            $('#loading').attr('hidden', false);
            $('.table-responsive').hide();

            setTimeout(function () {
                var progressBar = $('#progress-bar');
                progressBar.css('width', '0%').attr('aria-valuenow', 0);

                var nonApplicable = $('#btn-non-applicable').hasClass('active');
                var pending = $('#btn-pending').hasClass('active');
                var inProgress = $('#btn-in-progress').hasClass('active');
                var finished = $('#btn-finished').hasClass('active');
                var rejected = $('#btn-rejected').hasClass('active');
                var canceled = $('#btn-canceled').hasClass('active');

                var table = $('#documents-list').DataTable();

                var searchTerm = '';
                if (nonApplicable) {
                    searchTerm += '{{ __('form.document_not_applicable') }}|';
                }
                if (pending) {
                    searchTerm += '{{ __('form.document_pending') }}|';
                }
                if (inProgress) {
                    searchTerm += '{{ __('form.document_in_progress') }}|';
                }
                if (finished) {
                    searchTerm += '{{ __('form.document_finished') }}|';
                }
                if (rejected) {
                    searchTerm += '{{ __('form.document_rejected') }}|';
                }
                if (canceled) {
                    searchTerm += '{{ __('form.document_canceled') }}|';
                }

                searchTerm = searchTerm.replace(/\|$/, '');
                table.column(3).search(searchTerm, true, false).draw();

                $('#loading').attr('hidden', true);
                $('.table-responsive').show();
            }, 1000);
        }

        $('[id^=comment-modal-button-]').on('click', function() {
            var documentId = $(this).attr('id').replace('comment-modal-button-', '');
            loadDocumentComments(documentId);
        });

        function loadDocumentComments(documentId) {
            var loaded = $('#loaded-comments-' + documentId).val();
            if (loaded == 1) {
                return;
            }
            setTimeout(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    url: '{{ route('loadDocumentComments') }}',
                    type: 'GET',
                    data: {
                        id: documentId,
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#loaded-comments-' + documentId).val(1);
                            $('.loading' + documentId).hide();
                            $('#document-comments-' + documentId).append(response.data.comments);
                        } else {
                            $('.loading' + documentId).hide();
                            showToastMessage(false, response.message);
                        }
                    },
                });
            }, 1000);
        }

        $('[id^=comment-document-button-]').on('click', function () {
            var documentId = $(this).attr('id').replace('comment-document-button-', '');
            var comment = $('#comment-text-' + documentId).val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                url: '{{ route('storeDocumentComment') }}',
                type: 'POST',
                data: {
                    id: documentId,
                    comment: comment,
                },
                success: function (response) {
                    if (response.success) {
                        $('#no-comment-message-' + documentId).hide();
                        $('#comment-text-' + documentId).val('');
                        $('#document-comments-' + documentId).append(response.data.comments);
                    } else {
                        showToastMessage(false, response.message);
                    }
                },
            });
        });
    </script>
@endpush