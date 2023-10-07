<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\SystemLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Js;

class ProjectController extends Controller
{
    /**
     * Create a new project
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) : JsonResponse {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'process_status' => 'required|string',
            'service_id' => 'required|integer|exists:services,id',
        ]);

        if ($validator->fails()) {
            SystemLog::create([
                'type' => 'error',
                'action' => 'create_project',
                'message' => $validator->errors()->first(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return response()->json([
                'success' => false,
                'message' => Lang::get('alerts.create_project_error'),
            ]);
        }

        switch ($request->process_status) {
            case Project::$STATUS_TO_DO_ID:
                $processStatus = Project::$STATUS_TO_DO;
                break;
            case Project::$STATUS_IN_PROGRESS_ID:
                $processStatus = Project::$STATUS_IN_PROGRESS;
                break;
            case Project::$STATUS_DONE_ID:
                $processStatus = Project::$STATUS_DONE;
                break;
            default:
                $processStatus = Project::$STATUS_TO_DO;
                break;
        }

        DB::beginTransaction();
        try {
            $project = new Project();
            $project->name = $request->name;
            $project->process_status = $processStatus;
            $project->service_id = $request->service_id;
            $project->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'create_project',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return response()->json([
                'success' => false,
                'message' => Lang::get('alerts.create_project_error'),
            ]);
        }

        DB::commit();
        return response()->json([
            'success' => true,
            'message' => Lang::get('alerts.create_project_success'),
        ]);
    }

    /**
     * Update a project
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request) : JsonResponse {
        $validator = Validator::make(request()->all(), [
            'id' => 'required|integer|exists:projects,id',
            'process_status' => 'required|string',
        ]);

        if ($validator->fails()) {
            SystemLog::create([
                'type' => 'error',
                'action' => 'update_project',
                'message' => $validator->errors()->first(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return response()->json([
                'success' => false,
                'message' => Lang::get('alerts.update_project_error'),
            ]);
        }

        switch ($request->process_status) {
            case Project::$STATUS_TO_DO_ID:
                $processStatus = Project::$STATUS_TO_DO;
                break;
            case Project::$STATUS_IN_PROGRESS_ID:
                $processStatus = Project::$STATUS_IN_PROGRESS;
                break;
            case Project::$STATUS_DONE_ID:
                $processStatus = Project::$STATUS_DONE;
                break;
            default:
                $processStatus = Project::$STATUS_TO_DO;
                break;
        }

        DB::beginTransaction();
        try {
            $project = Project::find($request->id);
            $project->process_status = $processStatus;
            $project->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'update_project',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return response()->json([
                'success' => false,
                'message' => Lang::get('alerts.update_project_error'),
            ]);
        }

        DB::commit();
        return response()->json([
            'success' => true,
            'message' => Lang::get('alerts.update_project_success'),
        ]);
    }

    /**
     * Delete a project
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request) : RedirectResponse {
        $validator = Validator::make(request()->all(), [
            'id' => 'required|integer|exists:projects,id',
        ]);

        if ($validator->fails()) {
            SystemLog::create([
                'type' => 'error',
                'action' => 'delete_project',
                'message' => $validator->errors()->first(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return redirect()->back()->with('error', Lang::get('alerts.delete_project_error'));
        }

        DB::beginTransaction();
        try {
            $project = Project::find($request->id);
            $project->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'delete_project',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return redirect()->back()->with('error', Lang::get('alerts.delete_project_error'));
        }

        DB::commit();
        return redirect()->back()->with('success', Lang::get('alerts.delete_project_success'));
    }
}
