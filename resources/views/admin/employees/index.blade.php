@extends('adminlte::page')
@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
    <h1>{{ trans_choice('general.employees', 2) }}</h1>
    <p>{{ __('general.employees_list') }}</p>
@stop
@section('content')
    <div @class(['text-right'])>
        @include('adminlte::components.form.button', [
            'type' => 'button',
            'label' => __('general.create'),
            'icon' => 'fas fa-plus',
            'theme' => 'primary',
            'classes' => 'mb-4',
            'attributes' => [
                'data-toggle' => 'modal',
                'data-target' => '#createEmployeeModal'
            ],
        ])
    </div>
    @include('adminlte::components.tool.datatable')
    @include('adminlte::components.tool.modal', [
        'id' => 'createEmployeeModal',
        'title' => __('general.create_employee'),
        'icon' => 'fas fa-user-tie-plus',
        'size' => 'modal-lg',
        'slot' => 'admin.employees.create',
        'route' => 'createEmployee',
        'hasForm' => true,
        'footer' => true,
        'deleteFooter' => false,
        'cancelFooter' => false,
    ])
    @foreach ($data as $employee)
        @include('adminlte::components.tool.modal', [
            'id' => 'viewModal' . $employee->id,
            'title' => __('general.view_employee'),
            'icon' => 'fas fa-user-tie',
            'size' => 'modal-md',
            'slot' => 'admin.employees.view',
            'route' => 'viewEmployee',
            'hasForm' => false,
            'footer' => false,
            'deleteFooter' => false,
            'cancelFooter' => false,
            'data' => $employee,
        ])

        @include('adminlte::components.tool.modal', [
            'id' => 'updateModal' . $employee->id,
            'title' => __('general.update_employee'),
            'icon' => 'fas fa-user-tie-edit',
            'size' => 'modal-md',
            'slot' => 'admin.employees.update',
            'route' => 'updateEmployee',
            'hasForm' => true,
            'footer' => true,
            'deleteFooter' => false,
            'cancelFooter' => false,
            'data' => $employee,
        ])

        @include('adminlte::components.tool.modal', [
            'id' => 'shiftModal' . $employee->id,
            'title' => __('general.shift_employee') . ' - ' . $employee->name,
            'icon' => 'fas fa-calendar-week',
            'size' => 'modal-md',
            'slot' => 'admin.employees.shift',
            'route' => 'createShiftEmployee',
            'hasForm' => true,
            'footer' => true,
            'deleteFooter' => false,
            'cancelFooter' => false,
            'data' => $employee,
        ])
    @endforeach
@stop
@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')
@push('js')
    <script>
        var employees = {!! json_encode($data) !!};
        var weekDates = [];
        var currentDate = new Date();
        var currentDayOfWeek = currentDate.getDay();
        
        for (var i = 1; i <= 6; i++) {
            var date = new Date();
            var day = date.getDate() + (i - currentDayOfWeek);
            date.setDate(day);
            weekDates[i] = date;
        }

        $('[id^=shift-modal-button-]').on('click', function() {
            var employeeId = $(this).attr('id').replace('shift-modal-button-', '');
            calculateEmployeeShift(employeeId);
        });


        function getDayOfWeek(dayOfWeek) {
            var date = weekDates[dayOfWeek];
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();

            return `${year}-${month}-${day}`;
        }


        function setValuesAndAttributes(dayOfWeek, elementIdPrefix, employeeId) {
            var day = getDayOfWeek(dayOfWeek);
            $(`#${elementIdPrefix}-${employeeId}`).val(day);
            $(`#${elementIdPrefix}-morning-${employeeId}`).prop('id', `${day}-morning-${employeeId}`);
            $(`label[for="${elementIdPrefix}-morning-${employeeId}"]`).attr('for', `${day}-morning-${employeeId}`);
            $(`#${elementIdPrefix}-afternoon-${employeeId}`).prop('id', `${day}-afternoon-${employeeId}`);
            $(`label[for="${elementIdPrefix}-afternoon-${employeeId}"]`).attr('for', `${day}-afternoon-${employeeId}`);
            $(`#${elementIdPrefix}-night-${employeeId}`).prop('id', `${day}-night-${employeeId}`);
            $(`label[for="${elementIdPrefix}-night-${employeeId}"]`).attr('for', `${day}-night-${employeeId}`);
        }

        const options = {
            year: "numeric", month: "numeric", day: "numeric",
        };
        function formatDate(date) {
            date = new Date(date);
            date.setDate(date.getDate() + 1);

            return date.toLocaleDateString("pt-BR", options);
        }

        const startDate = getDayOfWeek(1);
        const startDateFormatted = formatDate(startDate);
        const endDate = getDayOfWeek(6);
        const endDateFormatted = formatDate(endDate);

        const weekInfo = `Semana de ${startDateFormatted} a ${endDateFormatted}`;
        $('.reference-week').text(weekInfo);

        $('.start-date').val(startDate);
        $('.end-date').val(endDate);

        function calculateEmployeeShift(employeeId) {
            var loadedShifts = $('#loaded-shifts-' + employeeId).val();
            if (loadedShifts == 1) {
                return;
            }
            setTimeout(function () {
                $.ajax({
                url: "{{ route('calculateEmployeeShift') }}",
                type: "GET",
                dataType: "json",
                data: {
                    employee_id: employeeId,
                    start_date: startDate,
                    end_date: endDate,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('#loaded-shifts-' + employeeId).val(1);
                        var shifts = response.data.shifts;
                        shifts.forEach(shift => {
                            const date = shift.date;
                            if (shift.morning == 1) {
                                $('#' + date + '-morning-' + employeeId).prop('checked', true);
                            }
                            if (shift.afternoon == 1) {
                                $('#' + date + '-afternoon-' + employeeId).prop('checked', true);
                            }
                            if (shift.night == 1) {
                                $('#' + date + '-night-' + employeeId).prop('checked', true);
                            }
                        });
                        var period = `Valor do período: R$ ${response.data.value}`;
                        $('#period-value-' + employeeId).text(period);
                        $('.loading' + employeeId).hide();
                        $('.loaded' + employeeId).show();
                        if (response.data.payment) {
                            if (response.data.payment.status == 0) {
                                $('#confirm-payment-' + employeeId).show();
                                $('#confirm-payment-button-' + employeeId).show();
                                $('#payment-id-' + employeeId).val(response.data.payment.id);
                            } else {
                                $('#confirm-payment-' + employeeId).show();
                                $('#confirm-payment-button-' + employeeId).hide();
                                $('#payment-badge-' + employeeId).removeClass('badge-info');
                                $('#payment-badge-' + employeeId).addClass('badge-success');
                                $('#payment-badge-' + employeeId).text('{{ __('general.paid') }}');
                                $('#period-value-' + employeeId).css('text-decoration', 'line-through');
                            }
                        } else {
                            $('#confirm-payment-' + employeeId).hide();
                            $('#payment-badge-' + employeeId).hide();
                            $('#period-value-' + employeeId).hide();
                        }
                    }
                }
            });
            }, 1000);
        }

        employees.forEach(employee => {
            setValuesAndAttributes(1, 'monday', employee.id);
            setValuesAndAttributes(2, 'tuesday', employee.id);
            setValuesAndAttributes(3, 'wednesday', employee.id);
            setValuesAndAttributes(4, 'thursday', employee.id);
            setValuesAndAttributes(5, 'friday', employee.id);
            setValuesAndAttributes(6, 'saturday', employee.id);
        });
    </script>
@endpush