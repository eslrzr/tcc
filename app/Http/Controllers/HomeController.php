<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller {

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        // returns the total of documents, services, employees
        $totalDocuments = DB::table('documents')->count();
        $pendingDocuments = DB::table('documents')
                                ->whereNotIn('process_status', [Document::$PROCESS_STATUS_NOT_APPLICABLE, Document::$PROCESS_STATUS_FINISHED])
                                ->count();
        $totalServices = DB::table('services')->count();
        $doneServices = DB::table('services')
                        ->whereNotNull('end_date')
                        ->count();
        $totalEmployees = DB::table('employees')->count();
        $activeEmployees = DB::table('employees')
                        ->where('work_status', Employee::$WORK_STATUS_ACTIVE)
                        ->count();

        return view('admin.home', [
            'totalDocuments' => $totalDocuments,
            'pendingDocuments' => $pendingDocuments,
            'totalServices' => $totalServices,
            'doneServices' => $doneServices,
            'totalEmployees' => $totalEmployees,
            'activeEmployees' => $activeEmployees
        ]);
    }
}
