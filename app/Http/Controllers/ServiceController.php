<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Project;
use App\Models\Service;
use App\Models\SystemLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Returns all services in JSON format
     * @return JsonResponse
     */
    public function all() : JsonResponse {
        $services = Service::all([
            'id', 
            'name'
        ]);

        return response()->json($services);
    }

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
                        'html' => '<a href="/admin/services/'. $service->id .'" class="btn btn-light btn-sm"><i class="fas fa-project-diagram"></i></a>',
                    ],
                    [
                        'html' => '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal' . $service->id . '" data-id="' . $service->id . '"><i class="fas fa-edit"></i></button>',
                    ],
                    [
                        'html' => '<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal' . $service->id . '" data-id="' . $service->id . '"><i class="fas fa-trash"></i></button>',
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
        foreach ($projects as $project) {
            $project->name = Str::limit($project->name, Project::$STRING_LIMIT, '...');
        }

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
            'zip_code' => ['required', 'string', 'max:9'],
            'street' => ['required', 'string', 'max:255'],
            'number' => ['required', 'numeric'],
            'district' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'uf' => ['required', 'string', 'max:2'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $service = Service::create([
                'name' => $request->name,
                'description' => $request->description,
                'start_date' => $request->start_date,
            ]);
            Address::create([
                'zip_code' => $request->zip_code,
                'street' => $request->street,
                'number' => $request->number,
                'district' => $request->district,
                'city' => $request->city,
                'state' => $request->uf,
                'formatted_address' => $request->street . ', ' . $request->number . ' - ' . $request->city . ' - ' . $request->uf,
                'service_id' => $service->id,
            ]);
            Storage::makeDirectory($service->id);
            Storage::makeDirectory($service->id . '/projects');
            Storage::makeDirectory($service->id . '/documents');
        } catch (\Throwable $th) {
            DB::rollBack();
            Storage::deleteDirectory($service->id);
            SystemLog::create([
                'type' => 'error',
                'action' => 'create_service',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return redirect()->back()->with('error', Lang::get('alerts.create_service_error'));
        }

        DB::commit();
        return redirect()->back()->with('success', Lang::get('alerts.create_service_success'));
    }

    /**
     * Update a service
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['date'],
            'zip_code' => ['required', 'string', 'max:9'],
            'street' => ['required', 'string', 'max:255'],
            'number' => ['required', 'numeric'],
            'district' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'uf' => ['required', 'string', 'max:2'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $service = Service::find($request->id);

        if (!$service) {
            return redirect()->back()->with('error', Lang::get('alerts.service_not_found'));
        }

        if ($service->end_date != null && $request->end_date != null && $request->start_date > $request->end_date && $request->end_date == $service->end_date) {
            return redirect()->back()->with('error', Lang::get('alerts.update_service_error'));
        }

        DB::beginTransaction();
        try {
            $service->update([
                'name' => $request->name,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
            $address = $service->address;
            $address->update([
                'zip_code' => $request->zip_code,
                'street' => $request->street,
                'number' => $request->number,
                'district' => $request->district,
                'city' => $request->city,
                'state' => $request->uf,
                'formatted_address' => $request->street . ', ' . $request->number . ' - ' . $request->city . ' - ' . $request->uf,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'update_service',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return redirect()->back()->with('error', Lang::get('alerts.update_service_error'));
        }

        DB::commit();
        return redirect()->back()->with('success', Lang::get('alerts.update_service_success'));
    }

    /**
     * Delete a service
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric', 'exists:services,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $service = Service::find($request->id);

        if (!$service) {
            return redirect()->back()->with('error', Lang::get('alerts.service_not_found'));
        }

        DB::beginTransaction();
        try {
            $service->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'delete_service',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return redirect()->back()->with('error', Lang::get('alerts.delete_service_error'));
        }

        DB::commit();
        return redirect()->back()->with('success', Lang::get('alerts.delete_service_success'));
    }

    /**
     * Finish a service
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finish(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric', 'exists:services,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $service = Service::find($request->id);

        if (!$service) {
            return redirect()->back()->with('error', Lang::get('alerts.service_not_found'));
        }

        DB::beginTransaction();
        try {
            if ($service->reopen) {
                $service->update([
                    'reopen' => false,
                    'reopen_finish_date' => date('Y-m-d'),
                ]);
            } else {
                $service->update([
                    'end_date' => date('Y-m-d'),
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'finish_service',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return redirect()->back()->with('error', Lang::get('alerts.finish_service_error'));
        }

        DB::commit();
        return redirect()->back()->with('success', Lang::get('alerts.finish_service_success'));
    }

    /**
     * Reopen a service
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reopen(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric', 'exists:services,id'],
            'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $service = Service::find($request->id);

        if (!$service) {
            return redirect()->back()->with('error', Lang::get('alerts.service_not_found'));
        }

        DB::beginTransaction();
        try {
            $service->update([
                'reopen' => true,
                'reopen_date' => date('Y-m-d'),
                'reopen_description' => $request->description,
                'reopen_count' => $service->reopen_count++,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'reopen_service',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return redirect()->back()->with('error', Lang::get('alerts.reopen_service_error'));
        }

        DB::commit();
        return redirect()->back()->with('success', Lang::get('alerts.reopen_service_success'));
    }
}
