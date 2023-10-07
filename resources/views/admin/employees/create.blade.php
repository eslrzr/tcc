<div class="row">
  <div class="col-6">
    <div class="form-group">
      <label for="form-name"><i class="fas fa-user"></i> {{ __('form.full_name') }}</label>
      <input id="form-name" type="text" name="name" class="form-control" placeholder="{{ __('form.full_name') }}">
    </div>
  </div>
  <div class="col-6">
    <div class="form-group">
      <label for="form-cpf"><i class="fas fa-id-card"></i> {{ __('form.cpf') }}</label>
      <input id="form-cpf" type="text" name="cpf" class="form-control" placeholder="{{ __('form.cpf') }}" maxlength="14" oninput="cpfFormat(this)">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-6">
    <div class="form-group">
      <label for="form-number"><i class="fas fa-phone"></i> {{ __('form.phone_number') }}</label>
      <input id="form-number" type="text" name="number" class="form-control" placeholder="{{ __('form.phone_number') }}" maxlength="15" oninput="phoneNumberFormat(this)">
    </div>
  </div>
  <div class="col-6">
    <div class="form-group">
      <label for="form-not-future-date"><i class="fas fa-star"></i> {{ __('form.birth_date') }}  {{ __('form.optional') }}</label>
      <input id="form-not-future-date" type="date" name="birth_date" class="form-control" placeholder="{{ __('form.birth_date') }}" min="{{ $minDate }}">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-6">
    <div class="form-group">
      <label for="form-work-status"><i class="fas fa-power-off"></i> {{ __('form.work_status') }}</label>
      <select id="form-work-status" class="form-control" name="work_status">
        <option value="" disabled>{{ __('form.work_status') }}</option>
        <option value="A">{{ __('form.active') }}</option>
        <option value="D">{{ __('form.inactive') }}</option>
      </select>
    </div>
  </div>
  <div class="col-6">
    <div class="form-group">
      <label for="form-employee-role"><i class="fas fa-user-tag"></i> {{ __('form.role') }}</label>
      <select id="form-employee-role" class="form-control" name="role_id">
        <option value="" disabled>{{ __('form.role') }}</option>
        @foreach($slotData as $employeeRole)
          <option value="{{ $employeeRole->id }}">{{ $employeeRole->name }}</option>
        @endforeach
      </select>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-6">
    <div class="form-group">
      <label for="form-salary"><i class="fas fa-dollar-sign"></i> {{ __('form.salary')  }} {{ __('form.optional') }}</label>
      <input id="form-salary" type="text" name="salary" class="form-control" placeholder="{{ __('form.salary') }}" maxlength="6" oninput="salaryFormat(this)">
    </div>
  </div>
</div>