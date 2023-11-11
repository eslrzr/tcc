<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\InOut;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class CashController extends Controller
{
    /**
     * Build the view with cash options
     * @return \Illuminate\Contracts\View\View
     */
    public function view() : \Illuminate\Contracts\View\View {
        $cash = DB::table('cashes')->first();
        $inOuts = DB::table('in_outs')->get();
        $inOuts = $inOuts->map(function ($inOut) {
            $inOut->value = number_format($inOut->value, 2, ',', '.');
            $inOut->created_at = date('d/m/Y H:i:s', strtotime($inOut->created_at));
            switch ($inOut->type) {
                case InOut::$TYPE_IN:
                    $inOut->type = [
                        'html' => '<small class="badge badge-success">' . Lang::get('form.in') . '</small>'
                    ];
                    break;
                case InOut::$TYPE_OUT:
                    $inOut->type = [
                        'html' => '<small class="badge badge-danger">' . Lang::get('form.out') . '</small>'
                    ];
                    break;
                default:
                    $inOut->type = [
                        'html' => '<small class="badge badge-success">' . Lang::get('form.in') . '</small>'
                    ];
                    break;
            }
            return $inOut;
        });
        $inOuts = $inOuts->toArray();
        $cash->value = number_format($cash->value, 2, ',', '.');

        return view('admin.cashes.index', [
            'language' => $this->localeKey(),
            'cash' => $cash,
            'data' => $inOuts,
            'id' => 'in-outs-list',
            'heads' => [
                'id' => [
                    'classes' => 'text-center',
                    'width' => 5,
                    'label' => Lang::get('form.id'),
                ],
                'name' => [
                    'classes' => 'text-center',
                    'width' => 25,
                    'label' => Lang::get('form.name'),
                ],
                'value' => [
                    'classes' => 'text-center',
                    'width' => 15,
                    'label' => Lang::get('form.value'),
                ],
                'type' => [
                    'classes' => 'text-center',
                    'width' => 10,
                    'label' => Lang::get('form.type'),
                ],
                'created_at' => [
                    'classes' => 'text-center',
                    'width' => 20,
                    'label' => Lang::get('form.date'),
                ],
            ],
        ]);
    }

    /**
     * Update cash value
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) : \Illuminate\Http\RedirectResponse {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:cashes,id',
            'value' => 'required|numeric',
            'type' => 'required|string|in:IN,OUT',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        DB::beginTransaction();
        try {
            $cash = Cash::find($request->id);
            if ($request->type == InOut::$TYPE_IN) {
                $cash->value += $request->value;
            } else {
                $cash->value -= $request->value;
            }
            $cash->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'update_cash',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return redirect()->back()->withErrors(Lang::get('alerts.update_cash_error'));
        }
        DB::commit();

        return redirect()->back()->with('success', Lang::get('alerts.update_cash_success'));
    }

    /**
     * Register a new in/out web
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createInOut(Request $request) : \Illuminate\Http\RedirectResponse {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            // 'description' => 'string|max:255',
            'value' => 'required|numeric',
            'type' => 'required|string|in:IN,OUT',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $cash = Cash::first();
        if ($cash->value < $request->value && $request->type == InOut::$TYPE_OUT) {
            return redirect()->back()->withErrors(Lang::get('alerts.value_greater_than_cash'));
        }

        DB::beginTransaction();
        try {
            $inOut = new InOut();
            $inOut->description = $request->description;
            $inOut->name = $request->name;
            $inOut->value = $request->value;
            if ($request->type == InOut::$TYPE_IN) {
                $cash->value += $request->value;
            } else {
                $cash->value -= $request->value;
            }
            $inOut->type = $request->type;
            $inOut->cash_id = $cash->id;
            $inOut->save();
            $cash->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'shift_register',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return redirect()->back()->withErrors(Lang::get('alerts.in_out_register_error'));
        }
        DB::commit();

        return redirect()->back()->with('success', Lang::get('alerts.in_out_register_success'));
    }

    /**
     * Register a new in/out internal
     * @param string $name
     * @param string $type
     * @param double $value
     * @return string
     */
    public static function registerInOut(string $name, string $type, $value) : string {
        $cash = Cash::first();
        if ($cash->value < $value && $type == InOut::$TYPE_OUT) {
            return 'alerts.value_greater_than_cash';
        }

        DB::beginTransaction();
        try {
            $inOut = new InOut();
            $inOut->description = $name;
            $inOut->name = $name;
            $inOut->value = $value;
            if ($type == InOut::$TYPE_IN) {
                $cash->value += $value;
            } else {
                $cash->value -= $value;
            }
            $inOut->type = $type;
            $inOut->cash_id = $cash->id;
            $inOut->save();
            $cash->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'in_out_register',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return 'alerts.in_out_register_error';
        }
        DB::commit();

        return 'alerts.in_out_register_success';
    }
}