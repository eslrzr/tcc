<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label><i class="fas fa-user"></i> {{ __('form.full_name') }}</label>
            <p>{{ $employee->name }}</p>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label><i class="fas fa-id-card"></i> {{ __('form.cpf') }}</label>
            <p>{{ $employee->cpf }}</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label><i class="fas fa-phone"></i> {{ __('form.phone_number') }}</label>
            <p>{{ $employee->number }}</p>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label><i class="fas fa-star"></i> {{ __('form.birth_date') }}</label>
            <p>{{ $employee->birth_date }}</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label><i class="fas fa-power-off"></i> {{ __('form.work_status') }}</label>
            <p>{{ $employee->work_status['value'] === \app\Models\Employee::$WORK_STATUS_ACTIVE ? __('form.active') : __('form.inactive') }}</p>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label><i class="fas fa-user-tag"></i> {{ __('form.role') }}</label>
            <p>{{ $employee->role }}</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label><i class="fas fa-dollar-sign"></i> {{ __('form.salary') }}</label>
            <p>{{ $employee->salary }}</p>
        </div>
    </div>
</div>
