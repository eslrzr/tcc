<?php

namespace App\Http\Controllers;

use App\Models\AdministrationType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {

    /**
     * Build the view with the users list
     * @return \Illuminate\Contracts\View\View
     */
    public function view() {
        $users = User::select('users.id', 'users.name', 'users.email', 'administration_types.name as administration_type', 'users.created_at', 'users.status')
            ->where('users.id', '!=', Auth::user()->id)
            ->join('administration_types', 'administration_types.id', '=', 'users.administration_type_id')
            ->get();
        
        foreach ($users as $user) {
            $checked = $user->status ? 'checked' : '';
            $user->actions = [
                'buttons' => [
                    'html' => '<input type="checkbox" name="status" '. $checked .' data-bootstrap-switch data-off-color="danger" data-on-color="success" value="' . $user->id . '">',
                    'route' => 'changeStatus',
                ],
            ];
        }

        $administrationTypes = AdministrationType::select('id', 'name')->get();
        
        return view('admin.users',
        [
            'language' => $this->localeKey(),
            'data' => $users,
            'slotData' => $administrationTypes,
            'id' => 'users-list',
            'heads' => [
                'id' => [
                    'classes' => 'text-center',
                    'width' => 10,
                    'label' => 'ID'
                ],
                'name' => [
                    'classes' => 'text-center',
                    'width' => 30,
                    'label' => 'Nome'
                ],
                'email' => [
                    'classes' => 'text-center',
                    'width' => 30,
                    'label' => 'E-mail'
                ],
                'administration_type' => [
                    'classes' => 'text-center',
                    'width' => 15,
                    'label' => 'Tipo de usuário'
                ],
                'created_at' => [
                    'classes' => 'text-center',
                    'width' => 15,
                    'label' => 'Criado em'
                ],
                'actions' => [
                    'classes' => 'text-center',
                    'width' => 10,
                    'label' => 'Status'
                ],
            ],
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
            'message' => Lang::get('alerts.status_changed_successfully')
        ]);
    }
}