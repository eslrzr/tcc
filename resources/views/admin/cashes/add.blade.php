<div class="row">
    <div class="col-12">
        <div class="form-group">
        <label for="form-value"><i class="fas fa-dollar-sign"></i> {{ __('form.value') }}</label>
            <input id="form-value" type="text" name="value" class="form-control" placeholder="{{ __('form.value') }}" maxlength="8" oninput="salaryFormat(this)" required>
        </div>
    </div>
</div>
<input type="hidden" name="id" value="{{ $cash->id }}">
<input type="hidden" name="type" value="IN">