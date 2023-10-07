<div class="row">
    <div class="col-6">
        <div class="form-group">
        <label for="form-name"><i class="fas fa-signature"></i> {{ trans_choice('general.services', 1) }}</label>
        <input id="form-name" type="text" name="name" class="form-control" placeholder="{{ trans_choice('general.services', 1) }}">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
        <label for="form-not-future-date"><i class="fas fa-calendar"></i> {{ __('form.start_date') }}</label>
            <input id="form-not-future-date" type="date" name="start_date" class="form-control" placeholder="{{ __('form.start_date') }}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group">
        <label for="form-description"><i class="fas fa-edit"></i> {{ __('form.description') }}</label>
        <textarea id="form-description" name="description" class="form-control" placeholder="{{ __('form.description') }}"></textarea>
        </div>
    </div>
</div>
