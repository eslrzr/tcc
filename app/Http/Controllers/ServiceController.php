<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\SystemLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{

    /**
     * Build the view with the services list
     * @return \Illuminate\Contracts\View\View
     */
    public function view() : \Illuminate\Contracts\View\View {
        $services = Service::select('services.id', 'services.name', 'services.description', 'services.start_date', 'services.end_date')
                            ->get();                          

        foreach ($services as $service) {
            $service->actions = [
                'buttons' => [
                    [
                        'html' => '<a href="/admin/services/'. $service->id .'" target="_blank" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>',
                    ],
                    [
                        'html' => '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal' . $service->id . '" data-id="' . $service->id . '"><i class="fas fa-edit"></i></button>',
                    ],
                ],
            ];
        }

        return view('admin.services.index', [
            'id' => 'services-list',
            'language' => $this->localeKey(),
            'data' => $services,
            'heads' => [
                'id' => [
                    'classes' => 'text-center',
                    'width' => 5,
                    'label' => Lang::get('form.id'),
                ],
                'name' => [
                    'classes' => 'text-center',
                    'width' => 20,
                    'label' => trans_choice('general.services', 1),
                ],
                'description' => [
                    'classes' => 'text-center',
                    'width' => 20,
                    'label' => Lang::get('form.description'),
                ],
                'start_date' => [
                    'classes' => 'text-center',
                    'width' => 20,
                    'label' => Lang::get('form.start_date'),
                ],
                'end_date' => [
                    'classes' => 'text-center',
                    'width' => 20,
                    'label' => Lang::get('form.end_date'),
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
     * Build the view for a single service
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function viewOnce($id) : \Illuminate\Contracts\View\View {
        $service = Service::find($id);

        if (!$service) {
            return redirect()->route('admin.services.index')->with('error', Lang::get('alerts.service_not_found'));
        }

        $projects = $service->projects()->get();

        return view('admin.services.service', [
            'language' => $this->localeKey(),
            'service' => $service,
            'projects' => $projects,
        ]);
    }

    /**
     * Create a new service
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request) : RedirectResponse {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'start_date' => ['required', 'date'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $service = new Service();
            $service->name = $request->name;
            $service->description = $request->description;
            $service->start_date = $request->start_date;
            $service->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'create_service',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return redirect()->back()->with('error', Lang::get('alerts.service_not_created'));
        }

        DB::commit();
        return redirect()->back()->with('success', Lang::get('alerts.service_created'));
    }

    /**
     * Returns all employees in JSON format
     * @return JsonResponse
     */
    public function all() : JsonResponse {
        $services = Service::all([
            'id', 
            'name'
        ]);

        return response()->json($services);
    }
}
