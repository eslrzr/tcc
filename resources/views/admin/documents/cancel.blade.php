<div @class(['row'])>
    <div @class(['col-12'])>
        <h4>{{ __('alerts.confirm_document_cancel') }}</h4>
        <p>{{ __('alerts.explain_document_cancel') }}</p>
    </div>
</div>
<input type="hidden" name="id" value="{{ $document->id }}">