<input type="hidden" name="id" value="{{ $service->id }}">
<div @class(['row'])>
    <div @class(['col-6'])>
        <div @class(['form-group'])>
            <label for="form-name"><i @class(['fas', 'fa-signature'])></i> {{ trans_choice('general.services', 1) }}</label>
            <input id="form-name" type="text" name="name" @class(['form-control']) placeholder="{{ trans_choice('general.services', 1) }}" @required(true) value="{{ old('name', $service->name) }}">
        </div>
    </div>
    <div @class(['col-6'])>
        <div @class(['form-group'])>
            <label for="form-not-future-date"><i @class(['fas', 'fa-calendar'])></i> {{ __('form.start_date') }}</label>
            <input id="form-not-future-date" type="date" name="start_date" @class(['form-control']) placeholder="{{ __('form.start_date') }}" @required(true) value="{{ old('start_date', $service->start_date) }}">
        </div>
    </div>
</div>
<div @class(['row'])>
    <div @class(['col-12'])>
        <div @class(['form-group'])>
            <label for="form-description"><i @class(['fas', 'fa-edit'])></i> {{ __('form.description') }}</label>
            <textarea id="form-description" name="description" @class(['form-control']) placeholder="{{ __('form.description') }}" @required(true)>{{ old('description', $service->description) }}</textarea>
        </div>
    </div>
</div>
<div @class(['row'])>
    <div @class(['col-4'])>
        <div @class(['form-group'])>
            <label for="form-cep"><i @class(['fas', 'fa-map-marker-alt'])></i> {{ __('form.zipcode') }}</label>
            <input id="form-cep" type="text" name="zip_code" @class(['form-control']) placeholder="{{ __('form.zipcode') }}" maxlength="8" @required(true) value="{{ old('zip_code', $service->address->zip_code ?? null) }}">
        </div>
    </div>
    <div @class(['col-6'])>
        <div @class(['form-group'])>
            <label for="form-street"><i @class(['fas', 'fa-road'])></i> {{ __('form.address') }}</label>
            <input id="form-street" type="text" name="street" @class(['form-control']) placeholder="{{ __('form.address') }}" @required(true) value="{{ old('street', $service->address->street ?? null) }}">
        </div>
    </div>
    <div @class(['col-2'])>
        <div @class(['form-group'])>
            <label for="form-number"><i @class(['fas', 'fa-sort-numeric-up'])></i> {{ __('form.number') }}</label>
            <input id="form-number" type="text" name="number" @class(['form-control']) placeholder="{{ __('form.number') }}" maxlength="10" @required(true) value="{{ old('number', $service->address->number ?? null) }}">
        </div>
    </div>
</div>
<span id="message"></span>
<div @class(['row'])>
    <div @class(['col-6'])>
        <div @class(['form-group'])>
            <label for="form-district"><i @class(['fas', 'fa-map'])></i> {{ __('form.district') }}</label>
            <input id="form-district" type="text" name="district" @class(['form-control']) placeholder="{{ __('form.district') }}" @required(true) value="{{ old('district', $service->address->district ?? null) }}">
        </div>
    </div>
    <div @class(['col-4'])>
        <div @class(['form-group'])>
            <label for="form-city"><i @class(['fas', 'fa-city'])></i> {{ __('form.city') }}</label>
            <input id="form-city" type="text" name="city" @class(['form-control']) placeholder="{{ __('form.city') }}" @required(true) value="{{ old('city', $service->address->city ?? null) }}">
        </div>
    </div>
    <div @class(['col-2'])>
        <div @class(['form-group'])>
            <label for="form-uf"><i @class(['fas', 'fa-flag'])></i> {{ __('form.uf') }}</label>
            <input id="form-uf" type="text" name="uf" @class(['form-control']) placeholder="{{ __('form.uf') }}" @required(true) value="{{ old('state', $service->address->state ?? null) }}">
        </div>
    </div>
</div>
@push('js')
<script>
    $(document).ready(function() {
        function cleanCEP() {
            $('#form-street').val('');
            $('#form-district').val('');
            $('#form-city').val('');
            $('#form-uf').val('');
        }

        $('#form-cep').blur(function() {
            var cep = $(this).val().replace(/\D/g, '');
            if (cep != '') {
                var validateCEP = /^[0-9]{8}$/;
                if(validateCEP.test(cep)) {
                    $('#form-street').val('...');
                    $('#form-district').val('...');
                    $('#form-city').val('...');
                    $('#form-uf').val('...');

                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(data) {
                        if (!("erro" in data)) {
                            $('#form-street').val(data.logradouro);
                            $('#form-district').val(data.bairro);
                            $('#form-city').val(data.localidade);
                            $('#form-uf').val(data.uf);
                        } else {
                            cleanCEP();
                            $('#message').html('{{ __('alerts.not_found_cep') }}').css('color', 'red');
                            setTimeout(function() {
                                $('#message').html('');
                            }, 2000);
                        }
                    });
                } else {
                    cleanCEP();
                    $('#message').html('{{ __('alerts.invalid_cep') }}').css('color', 'red');
                    setTimeout(function() {
                        $('#message').html('');
                    }, 2000);
                }
            } else {
                cleanCEP();
            }
        });
    });
</script>
@endpush