<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\Employee;
use App\Models\EmployeeRole;
use App\Models\InOut;
use App\Models\Payment;
use App\Models\SystemLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller {   

    /**
     * Build the view with the employees list
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function view() : \Illuminate\Contracts\View\View {
        $employees = Employee::select('employees.id', 'employees.name', 'employees.cpf', 'employees.number', 'employees.birth_date', 'employees.work_status', 'employees.salary', 'employee_roles.name as role')
                               ->join('employee_roles', 'employee_roles.id', '=', 'employees.role_id')
                               ->get();

        foreach ($employees as $employee) {
            switch ($employee->work_status) {
                case Employee::$WORK_STATUS_ACTIVE:
                    $employee->work_status = [
                        'value' => 'A',
                        'html' => '<small class="badge badge-success">' . Lang::get('form.active') . '</small>'
                    ];
                    break;
                case Employee::$WORK_STATUS_INACTIVE:
                    $employee->work_status = [
                        'value' => 'D',
                        'html' => '<small class="badge badge-light">' . Lang::get('form.inactive') . '</small>'
                    ];
                    break;
            }

            $employee->actions = [
                'buttons' => [
                    [
                        'html' => '<button title="Informações" type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#viewModal' . $employee->id . '" data-id="' . $employee->id . '"><i class="fas fa-eye"></i></button>',
                    ],
                    [
                        'html' => '<button title="Editar" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateModal' . $employee->id . '" data-id="' . $employee->id . '"><i class="fas fa-edit"></i></button>',
                    ],
                    [
                        'html' => '<button title="Marcar dias trabalhados" type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#shiftModal' . $employee->id . '" data-id="' . $employee->id . '"><i class="fas fa-calendar-week"></i></button>',
                    ],
                    [
                        'html' => '<button title="Remover" type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal' . $employee->id . '" data-id="' . $employee->id . '"><i class="fas fa-trash"></i></button>',
                    ],
                ],
            ];
        }

        $employeeRoles = EmployeeRole::all();

        return view('admin.employees.index', [
            'language' => $this->localeKey(),
            'data' => $employees,
            'slotData' => $employeeRoles,
            'id' => 'employees-list',
            'minDate' => date('Y-m-d', strtotime('-80 years')),
            'heads' => [
                'id' => [
                    'classes' => 'text-center',
                    'width' => 5,
                    'label' => Lang::get('form.id'),
                ],
                'name' => [
                    'classes' => 'text-center',
                    'width' => 20,
                    'label' => Lang::get('form.name'),
                ],
                'number' => [
                    'classes' => 'text-center',
                    'width' => 10,
                    'label' => Lang::get('form.phone'),
                ],
                'work_status' => [
                    'classes' => 'text-center',
                    'width' => 5,
                    'label' => Lang::get('form.status'),
                ],
                'role' => [
                    'classes' => 'text-center',
                    'width' => 10,
                    'label' => Lang::get('form.role'),
                ],
                'actions' => [
                    'classes' => 'text-center',
                    'width' => 15,
                    'label' => Lang::get('form.actions'),
                ],
            ],
        ]);
    }


    /**
     * Returns all employees in JSON format
     * @return JsonResponse
     */
    public function all() : JsonResponse {
        $employees = Employee::all([
            'id',
            'name',
        ]);

        return response()->json($employees);
    }

    /**
     * Build the view for an employee
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function info() : \Illuminate\Contracts\View\View {
        return view('admin.employees.info');
    }

    /**
     * Build the view for employee shifts
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function shift() : \Illuminate\Contracts\View\View {
        return view('admin.employees.shift');
    }

    /**
     * Create a new employee
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request) : RedirectResponse {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14',
            'number' => 'required|string|max:15',
            'work_status' => 'required|string|max:1',
            'birth_date' => 'date',
            'salary' => 'string|max:10',
            'role_id' => 'required|integer|exists:employee_roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        DB::beginTransaction();
        try {
            $employee = new Employee();
            $employee->name = $request->name;
            $employee->cpf = $request->cpf;
            $employee->number = $request->number;
            $employee->work_status = $request->work_status;
            $employee->birth_date = $request->birth_date;
            $employee->salary = $request->salary;
            $employee->role_id = $request->role_id;
            $employee->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'create_employee',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return redirect()->back()->withErrors(Lang::get('alerts.create_employee_error'));
        }
        
        DB::commit();
        return redirect()->back()->with('success', Lang::get('alerts.create_employee_success'));
    }

    /**
     * Update an employee
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request) : RedirectResponse {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:employees,id',
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14',
            'number' => 'required|string|max:15',
            'work_status' => 'required|string|max:1',
            'birth_date' => 'required|date',
            'salary' => 'required|string|max:10',
            'role_id' => 'required|integer|exists:employee_roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        DB::beginTransaction();
        try {
            $employee = Employee::find($request->id);
            $employee->name = $request->name;
            $employee->cpf = $request->cpf;
            $employee->number = $request->number;
            $employee->work_status = $request->work_status;
            $employee->birth_date = $request->birth_date;
            $employee->salary = $request->salary;
            $employee->role_id = $request->role_id;
            $employee->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'update_employee',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return redirect()->back()->withErrors(Lang::get('alerts.update_employee_error'));
        }

        DB::commit();
        return redirect()->back()->with('success', Lang::get('alerts.update_employee_success'));
    }

    /**
     * Delete an employee
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Request $request) : RedirectResponse {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:employees,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        DB::beginTransaction();
        try {
            $employee = Employee::find($request->id);
            $employee->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'delete_employee',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return redirect()->back()->withErrors(Lang::get('alerts.delete_employee_error'));
        }

        DB::commit();
        return redirect()->back()->with('success', Lang::get('alerts.delete_employee_success'));

    }

    /**
     * Confirm employee payment
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function confirmPayment(Request $request) : JsonResponse {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:payments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        DB::beginTransaction();
        try {
            $payment = Payment::find($request->id);
            $name = 'Pagamento para ' . $payment->employee->name;
            $inOut = CashController::registerInOut($name, InOut::$TYPE_OUT, $payment->value);
            if ($inOut == 'alerts.value_greater_than_cash' || $inOut == 'alerts.in_out_register_error') {
                return response()->json([
                    'success' => false,
                    'message' => Lang::get($inOut)
                ]);
            }
            $payment->status = Payment::$STATUS_PAID;
            $payment->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'confirm_payment',
                'message' => $th->getMessage(),
                'user_id' => 999,
                'ip_address' => request()->ip(),
            ]);
            return response()->json([
                'success' => false,
                'message' => Lang::get('alerts.confirm_payment_error')
            ]);
        }

        DB::commit();
        return response()->json([
            'success' => true,
            'message' => Lang::get('alerts.confirm_payment_success')
        ]);
    }
}
