<div @class(['row'])>
    <div @class(['col-12'])>
        <h4>{{ __('alerts.confirm_delete_service') }}</h4>
        <p>{{ __('alerts.explain_delete_service') }}</p>
    </div>
</div>
<input type="hidden" name="id" value="{{ $service->id }}">