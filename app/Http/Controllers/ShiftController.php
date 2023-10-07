<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeShift;
use App\Models\SystemLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller {

    /**
     * Register the employee shifts
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request) : RedirectResponse {
        $validator = Validator::make($request->all(), [
            'shift' => 'required|array',
            'employee_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try{
            foreach ($request->shift as $day => $shift) {
                $date = $request->input('shift.' . $day . '.date');
                $date = date('Y-m-d', strtotime($date));
                $morning = false;
                $afternoon = false;
                $night = false;

                if (empty($shift['id'])) {
                    $employeeShift = new EmployeeShift();
                } else {
                    $employeeShift = EmployeeShift::find($shift['id']);
                }

                $employeeShift->employee_id = $request->employee_id;
                $employeeShift->date = $date;
                
                if (!empty($shift['morning'])) {
                    $employeeShift->morning = 1;
                    $morning = true;
                }
                if (!empty($shift['afternoon'])) {
                    $employeeShift->afternoon = 1;
                    $afternoon = true;
                }
                if (!empty($shift['night'])) {
                    $employeeShift->night = 1;
                    $night = true;
                }

                if ($morning && $afternoon && !$night) {
                    $employeeShift->period_value = 1;
                } else if ($morning && $night && !$afternoon) {
                    $employeeShift->period_value = 1;
                } else if ($afternoon && $night && !$morning) {
                    $employeeShift->period_value = 1;
                } else if ($morning && (!$afternoon || !$night)) {
                    $employeeShift->period_value = 0.5;
                } else if ($afternoon && (!$morning || !$night)) {
                    $employeeShift->period_value = 0.5;
                } else if ($night && (!$morning || !$afternoon)) {
                    $employeeShift->period_value = 0.5;
                } else if ($morning && $afternoon && $night) {
                    $employeeShift->period_value = 1.5;
                } else {
                    $employeeShift->period_value = 0;
                }
                
                $employeeShift->save();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'register_shift',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return redirect()->back()->with('error', Lang::get('alerts.shift_register_error'));
        }

        DB::commit();
        return redirect()->back()->with('success', Lang::get('alerts.shift_register_success'));
    }

    /**
     * Get the employee shifts
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function weekShifts(Request $request) : JsonResponse {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $start = date('Y-m-d', strtotime(urldecode($request->start_date)));
        $end = date('Y-m-d', strtotime(urldecode($request->end_date)));

        $employeeShifts = EmployeeShift::where('employee_id', $request->employee_id)
            ->whereBetween('date', [$start, $end])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $periodValue = 0;
        foreach ($employeeShifts as $employeeShift) {
            $employee = Employee::find($employeeShift->employee_id);
            $periodValue += $employeeShift->period_value * $employee->salary;
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'shifts' => $employeeShifts,
                'value' => $periodValue
            ],
        ]);
    }
}
