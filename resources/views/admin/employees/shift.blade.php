<div @class(['row'])>
    <table @class(['table', 'table-bordered'])>
        <thead>
            <tr>
                <th><i @class(['fas', 'fa-calendar-day'])></i> {{ __('date.day') }}</th>
                <th><i @class(['fas', 'fa-cloud-sun'])></i> {{ __('date.morning') }}</th>
                <th><i @class(['fas', 'fa-sun'])></i> {{ __('date.afternoon') }}</th>
                <th><i @class(['fas', 'fa-moon'])></i> {{ __('date.night') }}</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i <= 6; $i++)
                @php
                    switch ($i) {
                        case 1:
                            $day = 'monday';
                            $shift = 'mon';
                            break;
                        case 2:
                            $day = 'tuesday';
                            $shift = 'tue';
                            break;
                        case 3:
                            $day = 'wednesday';
                            $shift = 'wed';
                            break;
                        case 4:
                            $day = 'thursday';
                            $shift = 'thu';
                            break;
                        case 5:
                            $day = 'friday';
                            $shift = 'fri';
                            break;
                        case 6:
                            $day = 'saturday';
                            $shift = 'sat';
                            break;
                    }
                @endphp
                <tr>
                    <td>
                        <label for="{{ $day }}">{{ __('date.' . $day) }}</label>
                        <input id="{{ $day }}" type="hidden" name="shift[{{ $shift }}][date]" value="">
                    </td>
                    <td>
                        <div @class(['loading'])>
                            <div @class(['row', 'd-flex', 'justify-content-center'])>
                                <div @class(['col-4', 'd-flex', 'justify-content-center'])>
                                    <div @class(['skeleton', 'skeleton-text', 'skeleton-text-body'])></div>
                                </div>
                            </div>
                        </div>
                        <div @class(['form-group', 'clearfix', 'loaded']) style="display: none;">
                            <div @class(['icheck-primary', 'd-inline'])>
                                <input type="checkbox" id="{{ $day }}-morning" name="shift[{{ $shift }}][morning]" value="1">
                                <label for="{{ $day }}-morning"></label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div @class(['loading'])>
                            <div @class(['row', 'd-flex', 'justify-content-center'])>
                                <div @class(['col-4', 'd-flex', 'justify-content-center'])>
                                    <div @class(['skeleton', 'skeleton-text', 'skeleton-text-body'])></div>
                                </div>
                            </div>
                        </div>
                        <div @class(['form-group', 'clearfix', 'loaded']) style="display: none;">
                            <div @class(['icheck-primary', 'd-inline'])>
                                <input type="checkbox" id="{{ $day }}-afternoon" name="shift[{{ $shift }}][afternoon]" value="1">
                                <label for="{{ $day }}-afternoon"></label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div @class(['loading'])>
                            <div @class(['row', 'd-flex', 'justify-content-center'])>
                                <div @class(['col-4', 'd-flex', 'justify-content-center'])>
                                    <div @class(['skeleton', 'skeleton-text', 'skeleton-text-body'])></div>
                                </div>
                            </div>
                        </div>
                        <div @class(['form-group', 'clearfix', 'loaded']) style="display: none;">
                            <div @class(['icheck-primary', 'd-inline'])>
                                <input type="checkbox" id="{{ $day }}-night" name="shift[{{ $shift }}][night]" value="1">
                                <label for="{{ $day }}-night"></label>
                            </div>
                        </div>
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>
    <div @class(['row'])>
        <div @class(['col-12'])>
            <div @class(['text-center'])>
                <p id="reference-week"></p>
            </div>
        </div>
    </div>
<div @class(['loaded']) style="display: none;">
    <div @class(['row'])>
        <div @class(['col-12'])>
            <div @class(['text-center'])>
                <p id="period-value"></p>
            </div>
        </div>
    </div>
</div>
<div @class(['loading'])>
    <div @class(['row', 'd-flex', 'justify-content-center'])>
        <div @class(['col-6', 'd-flex', 'justify-content-center'])>
            <div @class(['skeleton', 'skeleton-text', 'skeleton-text-body'])></div>
        </div>
    </div>
</div>

<div id="confirm-payment" @class(['row']) style="display: none;">
    <div @class(['col-12'])>
        <div @class(['text-center'])>
            @include('adminlte::components.form.button', [
                'type' => 'button',
                'label' => __('general.confirm_payment'),
                'icon' => 'fas fa-check',
                'theme' => 'success',
                'classes' => 'mb-4',
                'attributes' => [
                    'id' => 'confirm-payment-button',
                ],
            ])
        </div>
        <input id="payment-id" type="hidden">
    </div>
</div>
<input type="hidden" name="employee_id" value="{{ $employee->id }}">
@push('js')
    <script>
        $('#confirm-payment-button').on('click', function() {
            var paymentId = $('#payment-id').val();
            confirmPayment(paymentId);
        });

        function confirmPayment(paymentId) {
            $.ajax({
                url: '{{ route('confirmPayment') }}',
                type: 'POST',
                data: {
                    id: paymentId
                },
                success: function(response) {
                    if (response.success) {
                        showToastMessage(true, response.message);
                    } else {
                        showToastMessage(false, response.message);
                    }
                }
            });
        }
    </script>
@endpush
