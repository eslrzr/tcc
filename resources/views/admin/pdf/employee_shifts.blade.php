<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <style>
            .table {
                width: 100%;
                margin-bottom: 1rem;
                color: #212529;
                border-collapse: collapse;
            }
            .table th,
            .table td {
                padding: 0.75rem;
                vertical-align: top;
                border-top: 1px solid #dee2e6;
            }
            .table th,
            .table td,
            h1 {
                font-family: Arial, Helvetica, sans-serif;
            }
            .table thead th {
                vertical-align: bottom;
                border-bottom: 2px solid #dee2e6;
            }
            .table tbody + tbody {
                border-top: 2px solid #dee2e6;
            }
            .table .table {
                background-color: #fff;
            }
            .table-sm th,
            .table-sm td {
                padding: 0.3rem;
            }
            .table-bordered {
                border: 1px solid #dee2e6;
            }
            .table-bordered th,
            .table-bordered td {
                border: 1px solid #dee2e6;
            }
            .table-bordered thead th,
            .table-bordered thead td {
                border-bottom-width: 2px;
            }
            .table-striped tbody tr:nth-of-type(odd) {
                background-color: rgba(0, 0, 0, 0.05);
            }
            .table-hover tbody tr:hover {
                background-color: rgba(0, 0, 0, 0.075);
            }
            .table-primary,
            .table-primary > th,
            .table-primary > td {
                background-color: #b8daff;
            }
            .table-primary th,
            .table-primary td,
            .table-primary thead th,
            .table-primary tbody + tbody {
                border-color: #7abaff;
            }
            .table-hover .table-primary:hover {
                background-color: #9fcdff;
            }
            .table-hover .table-primary:hover > td,
            .table-hover .table-primary:hover > th {
                background-color: #9fcdff;
            }
            .table-secondary,
            .table-secondary > th,
            .table-secondary > td {
                background-color: #d6d8db;
            }
            .table-secondary th,
            .table-secondary td,
            .table-secondary thead th,
            .table-secondary tbody + tbody {
                border-color: #b3b7bb;
            }
        </style>
    </head>
    <body>
        <h1>{{ __('general.shift_employee') }} - {{ $data['employee_name'] }}</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><b>{{ __('date.date') }}</b></th>
                    <th><b>{{ __('date.morning') }}</b></th>
                    <th><b>{{ __('date.afternoon') }}</b></th>
                    <th><b>{{ __('date.night') }}</b></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($data['shifts'] as $shift)
                    @php
                        switch ($i) {
                            case 1:
                                $day = 'monday';
                                break;
                            case 2:
                                $day = 'tuesday';
                                break;
                            case 3:
                                $day = 'wednesday';
                                break;
                            case 4:
                                $day = 'thursday';
                                break;
                            case 5:
                                $day = 'friday';
                                break;
                            case 6:
                                $day = 'saturday';
                                break;
                        }
                        $i++;
                    @endphp
                    <tr>                
                        <td>{{ date('d/m/Y', strtotime($shift->date)) }}  {{ __('date.' . $day) }}</td>
                        <td>{{ $shift->morning == 1 ? __('general.yes') : __('general.no') }}</td>
                        <td>{{ $shift->afternoon == 1 ? __('general.yes') : __('general.no') }}</td>
                        <td>{{ $shift->night == 1 ? __('general.yes') : __('general.no') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3"><b>{{ __('form.period_value') }}:</b> {{ $data['value'] }}</td>
                    <td colspan="1"><b>{{ __('form.status') }}:</b> {{ __('general.' . $data['status']) }}</td>
                </tr>
            </tbody>
    </body>
</html>