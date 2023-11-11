<input type="hidden" name="id" value="{{ $employee->id }}">
<div @class(['row'])>
    <div @class(['col-6'])>
        <div @class(['form-group'])>
            <label for="form-name"><i @class(['fas', 'fa-user'])></i> {{ __('form.full_name') }}</label>
            <input id="form-name" type="text" name="name" class="form-control" placeholder="{{ __('form.full_name') }}" value="{{ old('name', $employee->name) }}">
        </div>
    </div>
    <div @class(['col-6'])>
        <div @class(['form-group'])>
            <label for="form-cpf"><i @class(['fas', 'fa-id-card'])></i> {{ __('form.cpf') }}</label>
            <input id="form-cpf" type="text" name="cpf" class="form-control" placeholder="{{ __('form.cpf') }}" maxlength="14" oninput="cpfFormat(this)" value="{{ old('cpf', $employee->cpf) }}">
        </div>
    </div>
</div>
<div @class(['row'])>
    <div @class(['col-6'])>
        <div @class(['form-group'])>
            <label for="form-number"><i @class(['fas', 'fa-phone'])></i> {{ __('form.phone_number') }}</label>
            <input id="form-number" type="text" name="number" class="form-control" placeholder="{{ __('form.phone_number') }}" maxlength="15" oninput="phoneNumberFormat(this)" value="{{ old('number', $employee->number) }}">
        </div>
    </div>
    <div @class(['col-6'])>
        <div @class(['form-group'])>
            <label for="form-not-future-date"><i @class(['fas', 'fa-star'])></i> {{ __('form.birth_date') }}</label>
            <input id="form-not-future-date" type="date" name="birth_date" class="form-control" placeholder="{{ __('form.birth_date') }}" min="{{ $minDate }}" value="{{ old('birth_date', $employee->birth_date) }}">
        </div>
    </div>
</div>
<div @class(['row'])>
    <div @class(['col-6'])>
        <div @class(['form-group'])>
            <label for="form-work-status"><i @class(['fas', 'fa-power-off'])></i> {{ __('form.work_status') }}</label>
            <select id="form-work-status" class="form-control" name="work_status">
                <option value="" disabled>{{ __('form.work_status') }}</option>
                <option value="A" {{ old('work_status', $employee->work_status['value']) === \app\Models\Employee::$WORK_STATUS_ACTIVE ? 'selected' : '' }}>{{ __('form.active') }}</option>
                <option value="D" {{ old('work_status', $employee->work_status['value']) === \app\Models\Employee::$WORK_STATUS_INACTIVE ? 'selected' : '' }}>{{ __('form.inactive') }}</option>
            </select>
        </div>
    </div>
    <div @class(['col-6'])>
        <div @class(['form-group'])>
            <label for="form-employee-role"><i @class(['fas', 'fa-user-tag'])></i> {{ __('form.role') }}</label>
            <select id="form-employee-role" class="form-control" name="role_id">
                <option value="" disabled>{{ __('form.role') }}</option>
                @foreach($slotData as $employeeRole)
                <option value="{{ $employeeRole->id }}" {{ old('role_id', $employee->role_id) == $employeeRole->id ? 'selected' : '' }}>{{ $employeeRole->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div @class(['row'])>
    <div @class(['col-6'])>
        <div @class(['form-group'])>
            <label for="form-salary"><i @class(['fas', 'fa-dollar-sign'])></i> {{ __('form.salary') }}</label>
            <input id="form-salary" type="text" name="salary" class="form-control" placeholder="{{ __('form.salary') }}" maxlength="6" oninput="salaryFormat(this)" value="{{ old('salary', $employee->salary) }}">
        </div>
    </div>
</div>