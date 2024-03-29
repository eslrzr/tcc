<?php

namespace App\Http\Controllers;

use App\Models\AdministrationType;
use App\Models\SystemLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {

    /**
     * Build the view with the users list
     * @return \Illuminate\Contracts\View\View
     */
    public function view() : \Illuminate\Contracts\View\View {
        $users = User::select('users.id', 'users.name', 'users.email', 'administration_types.name as administration_type', 'users.created_at', 'users.status')
            ->where('users.id', '!=', Auth::user()->id)
            ->join('administration_types', 'administration_types.id', '=', 'users.administration_type_id')
            ->get();
        
        foreach ($users as $user) {
            $checked = $user->status ? 'checked' : '';
            $user->actions = [
                'buttons' => [
                    [
                        'html' => '<input type="checkbox" name="status" '. $checked .' data-bootstrap-switch data-off-color="danger" data-on-color="success" value="' . $user->id . '">',
                        'route' => 'changeStatus',
                    ],
                ],
            ];
        }

        $administrationTypes = AdministrationType::select('id', 'name')->get();
        
        return view('admin.users.index',
        [
            'language' => $this->localeKey(),
            'data' => $users,
            'slotData' => $administrationTypes,
            'id' => 'users-list',
            'heads' => [
                'id' => [
                    'classes' => 'text-center',
                    'width' => 5,
                    'label' => Lang::get('form.id'),
                ],
                'name' => [
                    'classes' => 'text-center',
                    'width' => 30,
                    'label' => Lang::get('form.name'),
                ],
                'email' => [
                    'classes' => 'text-center',
                    'width' => 30,
                    'label' => Lang::get('form.email'),
                ],
                'administration_type' => [
                    'classes' => 'text-center',
                    'width' => 15,
                    'label' => Lang::get('form.administration_type'),
                ],
                'created_at' => [
                    'classes' => 'text-center',
                    'width' => 15,
                    'label' => Lang::get('form.created_at'),
                ],
                'actions' => [
                    'classes' => 'text-center',
                    'width' => 10,
                    'label' => Lang::get('form.status'),
                ],
            ],
        ]);
    }

    /**
     * Build the user settings view
     * @return \Illuminate\Contracts\View\View
     */
     public function settingsView() : \Illuminate\Contracts\View\View {
        $user = User::find(Auth::id());
        $administrationTypes = AdministrationType::select('id', 'name')->get();

        return view('admin.settings.index', [
            'data' => $user,
            'slotData' => $administrationTypes,
        ]);
     }

    /**
     * Change the user status
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => Lang::get('alerts.status_changed_success')
        ]);
    }

    /**
     * Create user account
     * @return \Illuminate\Http\RedirectResponse - Redirect to the previous page with a success message
    */
    public function create() {
        $fields = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed'],
            'administration_type_id' => ['required', 'exists:administration_types,id'],
        ]);

        $fields['password'] = Hash::make($fields['password']);

        try {
            $user = User::create($fields);
            
            if ($user) {
                return redirect()->back()->with('success', Lang::get('alerts.create_user_success'));
            }
        } catch (\Throwable $th) {
            SystemLog::create([
                'type' => 'error',
                'action' => 'register',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return redirect()->back()->with('error', Lang::get('alerts.create_user_error'));
        }
    }
}