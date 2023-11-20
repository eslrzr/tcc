<div @class(['row'])>
    <div @class(['col-12'])>
        <p>{{ __('alerts.confirm_reopen_service') }}</p>
    </div>
</div>
<div @class(['row'])>
    <div @class(['col-12'])>
        <div @class(['form-group'])>
            <label for="form-description"><i @class(['fas', 'fa-edit'])></i> {{ __('form.reopen_reason') }}</label>
            <textarea id="form-description" name="description" @class(['form-control']) placeholder="{{ __('form.explain_reopen_reason') }}" @required(true)>{{ old('reopen_description', $service->reopen_description) }}</textarea>
        </div>
    </div>
</div>
<input type="hidden" name="id" value="{{ $service->id }}">