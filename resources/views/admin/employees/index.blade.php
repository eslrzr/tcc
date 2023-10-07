@extends('adminlte::page')

@section('title', ' Empreiteira Andrades - Administração')
@section('content_header')
    <h1>{{ trans_choice('general.employees', 2) }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <p>{{ __('general.employees_list') }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
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
    </div>
    <div class="row">
        <div class="col-12">
            @include('adminlte::components.tool.datatable')
        </div>
    </div>
@stop
@include('adminlte::components.tool.modal', [
    'id' => 'createEmployeeModal',
    'title' => __('general.create_employee'),
    'icon' => 'fas fa-user-tie-plus',
    'size' => 'modal-lg',
    'slot' => 'admin.employees.create',
    'route' => 'createEmployee',
    'footer' => true,
    'deleteFooter' => false,
])

@foreach ($data as $employee)
    @include('adminlte::components.tool.modal', [
        'id' => 'viewModal' . $employee->id,
        'title' => __('general.view_employee'),
        'icon' => 'fas fa-user-tie',
        'size' => 'modal-lg',
        'slot' => 'admin.employees.view',
        'route' => 'viewEmployee',
        'footer' => false,
        'deleteFooter' => false,
        'data' => $employee,
    ])

    @include('adminlte::components.tool.modal', [
        'id' => 'updateModal' . $employee->id,
        'title' => __('general.update_employee'),
        'icon' => 'fas fa-user-tie-edit',
        'size' => 'modal-lg',
        'slot' => 'admin.employees.update',
        'route' => 'updateEmployee',
        'footer' => true,
        'deleteFooter' => false,
        'data' => $employee,
    ])

    @include('adminlte::components.tool.modal', [
        'id' => 'shiftModal' . $employee->id,
        'title' => __('general.shift_employee'),
        'icon' => 'fas fa-calendar-week',
        'size' => 'modal-lg',
        'slot' => 'admin.employees.shift',
        'route' => 'createShiftEmployee',
        'footer' => true,
        'deleteFooter' => false,
        'data' => $employee,
    ])
@endforeach

@section('plugins.BootstrapSwitch', true)
@include('adminlte::components.tool.onpageload')
@push('js')
    <script>
        $('[id^="shiftModal"]').on('shown.bs.modal', function() {
            calculateEmployeeShift();
        });

        function calculateEmployeeShift() {
            $.ajax({
                url: "{{ route('calculateEmployeeShift') }}",
                type: "GET",
                dataType: "json",
                data: {
                    employee_id: {{ $employee->id ?? null }},
                    start_date: startDate,
                    end_date: endDate,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        const shifts = response.data.shifts;
                        shifts.forEach(shift => {
                            const date = shift.date;
                            if (shift.morning == 1) {
                                document.getElementById(`${date}-morning`).checked = true;
                            }
                            if (shift.afternoon == 1) {
                                document.getElementById(`${date}-afternoon`).checked = true;
                            }
                            if (shift.night == 1) {
                                document.getElementById(`${date}-night`).checked = true;
                            }
                        });
                        const period = `Valor do período: R$ ${response.data.value}`;
                        document.getElementById('period-value').textContent = period;
                    }
                }
            });
        }

        function getPreviousDayOfWeek(dayOfWeek) {
            const today = new Date();
            const currentDayOfWeek = today.getDay();
            const daysUntilPreviousDayOfWeek = (currentDayOfWeek - dayOfWeek - 6 + 7) % 7;
            const previousDay = new Date(today);
            previousDay.setDate(today.getDate() - daysUntilPreviousDayOfWeek - 7);
            return previousDay.toISOString().slice(0, 10); // Formato YYYY-MM-DD
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('monday').value = getPreviousDayOfWeek(2); // Segunda-feira
            document.getElementById('monday-morning').id = `${getPreviousDayOfWeek(2)}-morning`;
            document.querySelector('label[for="monday-morning"]').setAttribute('for', `${getPreviousDayOfWeek(2)}-morning`);
            document.getElementById('monday-afternoon').id = `${getPreviousDayOfWeek(2)}-afternoon`;
            document.querySelector('label[for="monday-afternoon"]').setAttribute('for', `${getPreviousDayOfWeek(2)}-afternoon`);
            document.getElementById('monday-night').id = `${getPreviousDayOfWeek(2)}-night`;
            document.querySelector('label[for="monday-night"]').setAttribute('for', `${getPreviousDayOfWeek(2)}-night`);
            document.getElementById('tuesday').value = getPreviousDayOfWeek(3); // Terça-feira
            document.getElementById('tuesday-morning').id = `${getPreviousDayOfWeek(3)}-morning`;
            document.querySelector('label[for="tuesday-morning"]').setAttribute('for', `${getPreviousDayOfWeek(3)}-morning`);
            document.getElementById('tuesday-afternoon').id = `${getPreviousDayOfWeek(3)}-afternoon`;
            document.querySelector('label[for="tuesday-afternoon"]').setAttribute('for', `${getPreviousDayOfWeek(3)}-afternoon`);
            document.getElementById('tuesday-night').id = `${getPreviousDayOfWeek(3)}-night`;
            document.querySelector('label[for="tuesday-night"]').setAttribute('for', `${getPreviousDayOfWeek(3)}-night`);
            document.getElementById('wednesday').value = getPreviousDayOfWeek(4); // Quarta-feira
            document.getElementById('wednesday-morning').id = `${getPreviousDayOfWeek(4)}-morning`;
            document.querySelector('label[for="wednesday-morning"]').setAttribute('for', `${getPreviousDayOfWeek(4)}-morning`);
            document.getElementById('wednesday-afternoon').id = `${getPreviousDayOfWeek(4)}-afternoon`;
            document.querySelector('label[for="wednesday-afternoon"]').setAttribute('for', `${getPreviousDayOfWeek(4)}-afternoon`);
            document.getElementById('wednesday-night').id = `${getPreviousDayOfWeek(4)}-night`;
            document.querySelector('label[for="wednesday-night"]').setAttribute('for', `${getPreviousDayOfWeek(4)}-night`);
            document.getElementById('thursday').value = getPreviousDayOfWeek(5); // Quinta-feira
            document.getElementById('thursday-morning').id = `${getPreviousDayOfWeek(5)}-morning`;
            document.querySelector('label[for="thursday-morning"]').setAttribute('for', `${getPreviousDayOfWeek(5)}-morning`);
            document.getElementById('thursday-afternoon').id = `${getPreviousDayOfWeek(5)}-afternoon`;
            document.querySelector('label[for="thursday-afternoon"]').setAttribute('for', `${getPreviousDayOfWeek(5)}-afternoon`);
            document.getElementById('thursday-night').id = `${getPreviousDayOfWeek(5)}-night`;
            document.querySelector('label[for="thursday-night"]').setAttribute('for', `${getPreviousDayOfWeek(5)}-night`);
            document.getElementById('friday').value = getPreviousDayOfWeek(6); // Sexta-feira
            document.getElementById('friday-morning').id = `${getPreviousDayOfWeek(6)}-morning`;
            document.querySelector('label[for="friday-morning"]').setAttribute('for', `${getPreviousDayOfWeek(6)}-morning`);
            document.getElementById('friday-afternoon').id = `${getPreviousDayOfWeek(6)}-afternoon`;
            document.querySelector('label[for="friday-afternoon"]').setAttribute('for', `${getPreviousDayOfWeek(6)}-afternoon`);
            document.getElementById('friday-night').id = `${getPreviousDayOfWeek(6)}-night`;
            document.querySelector('label[for="friday-night"]').setAttribute('for', `${getPreviousDayOfWeek(6)}-night`);
            document.getElementById('saturday').value = getPreviousDayOfWeek(7); // Sábado
            document.getElementById('saturday-morning').id = `${getPreviousDayOfWeek(7)}-morning`;
            document.querySelector('label[for="saturday-morning"]').setAttribute('for', `${getPreviousDayOfWeek(7)}-morning`);
            document.getElementById('saturday-afternoon').id = `${getPreviousDayOfWeek(7)}-afternoon`;
            document.querySelector('label[for="saturday-afternoon"]').setAttribute('for', `${getPreviousDayOfWeek(7)}-afternoon`);
            document.getElementById('saturday-night').id = `${getPreviousDayOfWeek(7)}-night`;
            document.querySelector('label[for="saturday-night"]').setAttribute('for', `${getPreviousDayOfWeek(7)}-night`);
        });

        function formatDate(date) {
            const formattedDate = new Date(date);
            const day = formattedDate.getDate();
            const month = formattedDate.getMonth() + 1;
            const year = formattedDate.getFullYear();
            return `${day}/${month}/${year}`;
        }

        const startDate = getPreviousDayOfWeek(2);
        const startDateFormated = formatDate(getPreviousDayOfWeek(3));
        const endDate = getPreviousDayOfWeek(7);
        const endDateFormated = formatDate(getPreviousDayOfWeek(7));

        const weekInfo = `Semana de ${startDateFormated} a ${endDateFormated}`;
        document.getElementById('reference-week').textContent = weekInfo;
    </script>
@endpush