@extends('adminlte::page')
@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
    <h1>{{ __('general.change_password') }}</h1>
@stop
@section('content')
<form action="{{ route('changePassword') }}" method="POST">
    @csrf
    <div @class(['d-flex', 'justify-content-center'])>
        <div @class(['row'])>
            <div @class(['col-12'])>
                <div @class(['form-group'])>
                    <label for="form-old-password"><i @class(['fas', 'fa-lock'])></i> {{ __('form.old_password') }}</label>
                    <input id="form-old-password" type="password" name="old_password" @class(['form-control']) placeholder="{{ __('form.old_password') }}" @required(true)>
                </div>
            </div>
            <div @class(['col-12'])>
                <div @class(['form-group'])>
                    <label for="form-old-password-confirmation"><i @class(['fas', 'fa-key'])></i> {{ __('form.old_password_confirmation') }}</label>
                    <input id="form-old-password-confirmation" type="password" name="old_password_confirmation" @class(['form-control']) placeholder="{{ __('form.old_password_confirmation') }}" @required(true)>
                    <span id="message"></span>
                </div>
            </div>
            <div @class(['col-12'])>
                <div @class(['form-group'])>
                    <label for="form-password"><i @class(['fas', 'fa-lock'])></i> {{ __('form.new_password') }}</label>
                    <input id="form-password" type="password" name="password" @class(['form-control']) placeholder="{{ __('form.new_password') }}" @required(true)>
                    <span>
                        <ul>
                            <li>{{ __('form.password_lowercase') }} <i id="password-lowercase"></i></li>
                            <li>{{ __('form.password_uppercase') }} <i id="password-uppercase"></i></li>
                            <li>{{ __('form.password_number') }} <i id="password-number"></i></li>
                            <li>{{ __('form.password_min') }} <i id="password-min"></i></li>
                        </ul>
                    </span>
                </div>
            </div>
            <div @class(['col-12', 'text-center'])>
                @include('adminlte::components.form.button', [
                    'type' => 'submit',
                    'label' => __('general.save'),
                    'icon' => 'fas fa-save',
                    'theme' => 'success',
                    'attributes' => [
                        'id' => 'btn-save'
                    ],
                ])
            </div>
        </div>
    </div>
</form>
@stop
@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')
@push('js')
    <script>
        $('#form-old-password-confirmation').on('keyup', function () {
            if ($('#form-old-password').val() != $('#form-old-password-confirmation').val()) {
                $('#message').html('{{ __('form.not_matching') }}').css('color', 'red');
                $('#btn-save').prop('disabled', true);
            } else {
                $('#message').html('{{ __('form.matching') }}').css('color', 'green');
                setTimeout(function() {
                    $('#message').html('');
                }, 2000);
                $('#btn-save').prop('disabled', false);
            }
        });
        $('#form-password').on('keyup', function () {
            // Validate lowercase letters
            var lowerCaseLetters = /[a-z]/g;
            if ($('#form-password').val().match(lowerCaseLetters)) {
                $('#password-lowercase').html('<i class="fas fa-check" style="color:green"></i>');
            } else {
                $('#password-lowercase').html('<i class="fas fa-times" style="color:red"></i>');
                $('#btn-save').prop('disabled', true);
            }
            // Validate capital letters
            var upperCaseLetters = /[A-Z]/g;
            if ($('#form-password').val().match(upperCaseLetters)) {
                $('#password-uppercase').html('<i class="fas fa-check" style="color:green"></i>');
            } else {
                $('#password-uppercase').html('<i class="fas fa-times" style="color:red"></i>');
                $('#btn-save').prop('disabled', true);
            }
            // Validate numbers
            var numbers = /[0-9]/g;
            if ($('#form-password').val().match(numbers)) {
                $('#password-number').html('<i class="fas fa-check" style="color:green"></i>');
            } else {
                $('#password-number').html('<i class="fas fa-times" style="color:red"></i>');
                $('#btn-save').prop('disabled', true);
            }
            // Validate length
            if ($('#form-password').val().length >= 8) {
                $('#password-min').html('<i class="fas fa-check" style="color:green"></i>');
            } else {
                $('#password-min').html('<i class="fas fa-times" style="color:red"></i>');
                $('#btn-save').prop('disabled', true);
            }

            if ($('#form-password').val().match(lowerCaseLetters) && $('#form-password').val().match(upperCaseLetters) && $('#form-password').val().match(numbers) && $('#form-password').val().length >= 8) {
                $('#btn-save').prop('disabled', false);
            }
        });
    </script>
@endpush