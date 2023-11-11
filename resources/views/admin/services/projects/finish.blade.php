<div @class(['row'])>
    <div @class(['col-12'])>
        <p>{{ __('alerts.confirm_finish_service') }}</p>
    </div>
</div>
<input type="hidden" name="id" value="{{ $service->id }}">