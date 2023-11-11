<div @class(['row'])>
    <div @class(['col-12'])>
        <p>{{ __('alerts.confirm_delete_project') }}</p>
    </div>
</div>
<input type="hidden" name="id" value="{{ $project->id }}">