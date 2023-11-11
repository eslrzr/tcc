<div @class(['row'])>
  <div @class(['col-6'])>
      <div @class(['form-group'])>
          <label for="name"><i @class(['fas', 'fa-user'])></i> {{ __('form.full_name') }}</label>
          <input type="text" name="name" @class(['form-control']) placeholder="{{ __('form.full_name') }}">
      </div>
  </div>
  <div @class(['col-6'])>
      <div @class(['form-group'])>
          <label for="email"><i @class(['fas', 'fa-at'])></i> {{ __('form.email') }}</label>
          <input type="email" name="email" @class(['form-control']) placeholder="{{ __('form.email') }}">
      </div>
  </div>
</div>
<div @class(['row'])>
  <div @class(['col-6'])>
      <div @class(['form-group'])>
          <label for="password"><i @class(['fas', 'fa-lock'])></i> {{ __('form.password') }}</label>
          <input type="password" name="password" @class(['form-control']) placeholder="{{ __('form.password') }}">
      </div>
  </div>
  <div @class(['col-6'])>
      <div @class(['form-group'])>
          <label for="password-confirmation"><i @class(['fas', 'fa-lock'])></i> {{ __('form.password_confirmation') }}</label>
          <input type="password" name="password_confirmation" @class(['form-control']) placeholder="{{ __('form.password_confirmation') }}">
      </div>
  </div>
</div>
<div @class(['row'])>
  <div @class(['col-6'])>
      <div @class(['form-group'])>
          <label for="administration-type"><i @class(['fas', 'fa-id-card'])></i> {{ __('form.administration_type') }}</label>
          <select id="administration-type" @class(['form-control']) name="administration_type_id">
              <option value="" disabled>{{ __('form.administration_type') }}</option>
              @foreach($slotData as $administrationType)
                  <option value="{{ $administrationType->id }}">{{ $administrationType->name }}</option>
              @endforeach
          </select>
      </div>
  </div>
</div>