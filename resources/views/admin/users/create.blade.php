<div class="row">
  <div class="col-6">
    <div class="input-group mb-3">
      <input type="text" name="name" class="form-control" placeholder="{{ __('form.full_name') }}">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-user"></span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6">
    <div class="input-group mb-3">
      <input type="email" name="email" class="form-control" placeholder="{{ __('form.email') }}">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-at"></span>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-6">
    <div class="input-group mb-3">
      <input type="password" name="password" class="form-control" placeholder="{{ __('form.password') }}">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-lock"></span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6">
    <div class="input-group mb-3">
      <div class="form-group">
        <select class="form-control">
          @foreach($slotData as $administrationType)
            <option value="{{ $administrationType->id }}">{{ $administrationType->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
</div>