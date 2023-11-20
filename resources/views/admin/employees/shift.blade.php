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
                        <label for="{{ $day }}-{{ $employee->id }}">{{ __('date.' . $day) }}</label>
                        <input id="{{ $day }}-{{ $employee->id }}" type="hidden" name="shift[{{ $shift }}][date]" value="">
                    </td>
                    <td>
                        <div @class(['loading' . $employee->id ])>
                            <div @class(['row', 'd-flex', 'justify-content-center'])>
                                <div @class(['col-4', 'd-flex', 'justify-content-center'])>
                                    <div @class(['skeleton', 'skeleton-text', 'skeleton-text-body'])></div>
                                </div>
                            </div>
                        </div>
                        <div @class(['form-group', 'clearfix', 'loaded' . $employee->id ]) style="display: none;">
                            <div @class(['icheck-primary', 'd-inline'])>
                                <input type="checkbox" id="{{ $day }}-morning-{{ $employee->id }}" name="shift[{{ $shift }}][morning]" value="1">
                                <label for="{{ $day }}-morning-{{ $employee->id }}"></label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div @class(['loading' . $employee->id ])>
                            <div @class(['row', 'd-flex', 'justify-content-center'])>
                                <div @class(['col-4', 'd-flex', 'justify-content-center'])>
                                    <div @class(['skeleton', 'skeleton-text', 'skeleton-text-body'])></div>
                                </div>
                            </div>
                        </div>
                        <div @class(['form-group', 'clearfix', 'loaded' . $employee->id ]) style="display: none;">
                            <div @class(['icheck-primary', 'd-inline'])>
                                <input type="checkbox" id="{{ $day }}-afternoon-{{ $employee->id }}" name="shift[{{ $shift }}][afternoon]" value="1">
                                <label for="{{ $day }}-afternoon-{{ $employee->id }}"></label>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div @class(['loading' . $employee->id ])>
                            <div @class(['row', 'd-flex', 'justify-content-center'])>
                                <div @class(['col-4', 'd-flex', 'justify-content-center'])>
                                    <div @class(['skeleton', 'skeleton-text', 'skeleton-text-body'])></div>
                                </div>
                            </div>
                        </div>
                        <div @class(['form-group', 'clearfix', 'loaded' . $employee->id ]) style="display: none;">
                            <div @class(['icheck-primary', 'd-inline'])>
                                <input type="checkbox" id="{{ $day }}-night-{{ $employee->id }}" name="shift[{{ $shift }}][night]" value="1">
                                <label for="{{ $day }}-night-{{ $employee->id }}"></label>
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
                <p @class(['reference-week'])></p>
            </div>
        </div>
    </div>
<div @class(['loaded' . $employee->id ]) style="display: none;">
    <div @class(['row'])>
        <div @class(['col-12'])>
            <div @class(['text-center'])>
                <span id="payment-badge-{{ $employee->id }}" @class(['badge', 'badge-info'])>{{ __('general.waiting_payment') }}</span>
                <p id="period-value-{{ $employee->id }}"></p>
            </div>
        </div>
    </div>
</div>
<div @class(['loading' . $employee->id ])>
    <div @class(['row', 'd-flex', 'justify-content-center'])>
        <div @class(['col-6', 'd-flex', 'justify-content-center'])>
            <div @class(['skeleton', 'skeleton-text', 'skeleton-text-body'])></div>
        </div>
    </div>
</div>
<div id="confirm-payment-{{ $employee->id }}" @class(['row', 'loaded'])" style="display: none;">
    <div @class(['col-12'])>
        <div @class(['text-center'])>
            @include('adminlte::components.form.button', [
                'type' => 'button',
                'label' => __('general.confirm_payment'),
                'icon' => 'fas fa-check',
                'theme' => 'success',
                'classes' => 'mb-4',
                'attributes' => [
                    'id' => 'confirm-payment-button-' . $employee->id,
                ],
            ])
            @include('adminlte::components.form.button', [
                'type' => 'button',
                'label' => __('general.generate_pdf'),
                'icon' => 'fas fa-file-download',
                'theme' => 'info',
                'classes' => 'mb-4',
                'attributes' => [
                    'id' => 'generate-pdf-button-' . $employee->id,
                ],
            ])
        </div>
        <input id="payment-id-{{ $employee->id }}" type="hidden">
    </div>
</div>
<input @class(['start-date']) type="hidden" name="start_date">
<input @class(['end-date']) type="hidden" name="end_date">
<input type="hidden" name="employee_id" value="{{ $employee->id }}">
<input id="loaded-shifts-{{ $employee->id }}" type="hidden">
@push('js')
    <script>
        function confirmPayment(paymentId, employeeId) {
            $.ajax({
                url: '{{ route('confirmPayment') }}',
                type: 'POST',
                data: {
                    id: paymentId
                },
                success: function(response) {
                    if (response.success) {
                        showToastMessage(true, response.message);
                        $('#confirm-payment-button-' + employeeId).hide();
                        $('#confirm-payment-button-' + employeeId).prop('disabled', true);
                        $('#payment-badge-' + employeeId).removeClass('badge-info');
                        $('#payment-badge-' + employeeId).addClass('badge-success');
                        $('#payment-badge-' + employeeId).text('{{ __('general.paid') }}');
                        $('#period-value-' + employeeId).css('text-decoration', 'line-through');
                    } else {
                        showToastMessage(false, response.message);
                    }
                }
            });
        }

        $('[id^=confirm-payment-button-]').on('click', function() {
            var employeeId = $(this).attr('id').replace('confirm-payment-button-', '');
            var paymentId = $('#payment-id-' + employeeId).val();
            confirmPayment(paymentId, employeeId);
        });

        $('[id^=generate-pdf-button-]').on('click', function() {
            var employeeId = $(this).attr('id').replace('generate-pdf-button-', '');
            var startDate = $('.start-date').val();
            var endDate = $('.end-date').val();
            window.open('{{ route('employeeShiftPDF') }}?employee_id=' + employeeId + '&start_date=' + startDate + '&end_date=' + endDate, '_blank');
        });
    </script>
@endpush
