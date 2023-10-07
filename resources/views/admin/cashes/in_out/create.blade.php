<div class="row">
  <div class="col-6">
    <div class="form-group">
      <label for="form-name"><i class="fas fa-signature"></i> {{ __('form.name') }}</label>
      <input id="form-name" type="text" name="name" class="form-control" placeholder="{{ __('form.name') }}" required>
    </div>
  </div>
  <div class="col-6">
    <div class="form-group">
      <label for="form-description"><i class="fas fa-edit"></i> {{ __('form.description') }} {{ __('form.optional') }}</label>
      <input id="form-description" type="text" name="description" class="form-control" placeholder="{{ __('form.description') }}">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-6">
    <div class="form-group">
      <label for="form-value"><i class="fas fa-dollar-sign"></i> {{ __('form.value') }}</label>
      <input id="form-value" type="text" name="value" class="form-control" placeholder="{{ __('form.value') }}" maxlength="6" oninput="salaryFormat(this)" required>
    </div>
  </div>
  <div class="col-6">
    <div class="form-group">
      <label for="form-type"><i class="fas fa-tag"></i> {{ __('form.type') }}</label>
      <select id="form-type" class="form-control" name="type" required>
        <option value="" disabled>{{ __('form.type') }}</option>
          <option value="IN">{{ __('form.in') }}</option>
          <option value="OUT">{{ __('form.out') }}</option>
      </select>
    </div>
  </div>
</div>