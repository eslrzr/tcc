<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentType;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller {

    /**
     * Build the view with the documents list
     * @return \Illuminate\Contracts\View\View
     */
    public function view() : \Illuminate\Contracts\View\View {
        $documents = Document::select('documents.id', 'documents.name', 'documents.path', 'documents.process_status', 'document_types.name as document_type')
            ->join('document_types', 'document_types.id', '=', 'documents.document_type_id')
            ->get();

        foreach ($documents as $document) {
            switch ($document->process_status) {
                case Document::$PROCESS_STATUS_NOT_APPLICABLE:
                    $document->process_status = [
                        'html' => '<small class="badge badge-secondary">' . Lang::get('form.document_not_applicable') . '</small>'
                    ];
                    break;
                case Document::$PROCESS_STATUS_PENDING:
                    $document->process_status = [
                        'html' => '<small class="badge badge-light">' . Lang::get('form.document_pending') . '</small>'
                    ];
                    break;
                case Document::$PROCESS_STATUS_IN_PROGRESS:
                    $document->process_status = [
                        'html' => '<small class="badge badge-info">' . Lang::get('form.document_in_progress') . '</small>'
                    ];
                    break;
                case Document::$PROCESS_STATUS_FINISHED:
                    $document->process_status = [
                        'html' => '<small class="badge badge-success">' . Lang::get('form.document_finished') . '</small>'
                    ];
                    break;
                case Document::$PROCESS_STATUS_REJECTED:
                    $document->process_status = [
                        'html' => '<small class="badge badge-danger">' . Lang::get('form.document_rejected') . '</small>'
                    ];
                    break;
                default:
                    $document->process_status = [
                        'html' => '<small class="badge badge-secondary">' . Lang::get('form.document_not_applicable') . '</small>'
                    ];
                    break;
            }
            $document->actions = [
                'buttons' => [
                    [
                        'html' => '<a href="' . Storage::url($document->path) . '" target="_blank" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>',
                    ],
                    [
                        'html' => '<a href="' . Storage::url($document->path) . '" download class="btn btn-info btn-sm"><i class="fas fa-download"></i></a>',
                    ],
                    [
                        'html' => '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal' . $document->id . '" data-id="' . $document->id . '"><i class="fas fa-edit"></i></button>',
                    ],
                    [
                        'html' => '<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal' . $document->id . '" data-id="' . $document->id . '"><i class="fas fa-trash"></i></button>',
                    ],
                ],
            ];
        }

        $documentTypes = DocumentType::all();
        
        return view('admin.documents.index', [
            'language' => $this->localeKey(),
            'data' => $documents,
            'slotData' => $documentTypes,
            'id' => 'documents-list',
            'heads' => [
                'id' => [
                    'classes' => 'text-center',
                    'width' => 5,
                    'label' => Lang::get('form.id'),
                ],
                'name' => [
                    'classes' => 'text-center',
                    'width' => 20,
                    'label' => Lang::get('form.document_title'),
                ],
                'document_type' => [
                    'classes' => 'text-center',
                    'width' => 15,
                    'label' => Lang::get('form.document_type'),
                ],
                'process_status' => [
                    'classes' => 'text-center',
                    'width' => 10,
                    'label' => Lang::get('form.document_status'),
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
     * Build the documents management view for accountant
     * @return \Illuminate\Contracts\View\View
     */
    public function managementView() : \Illuminate\Contracts\View\View {
        $documents = Document::select('documents.id', 'documents.name', 'documents.path', 'documents.process_status', 'document_types.name as document_type')
            ->join('document_types', 'document_types.id', '=', 'documents.document_type_id')
            ->whereNot('documents.process_status', Document::$PROCESS_STATUS_NOT_APPLICABLE)
            ->get();

        foreach ($documents as $document) {
            switch ($document->process_status) {
                case Document::$PROCESS_STATUS_PENDING:
                    $document->process_status = [
                        'html' => '
                            <select id="document-status-' . $document->id . '" class="badge badge-light" style="border: 0 !important;" onchange="changeProcessStatus(' . $document->id . ')">
                                <option value="' . Document::$PROCESS_STATUS_PENDING . '" selected>' . Lang::get('form.document_pending') . '</option>
                                <option value="' . Document::$PROCESS_STATUS_IN_PROGRESS . '">' . Lang::get('form.document_in_progress') . '</option>
                                <option value="' . Document::$PROCESS_STATUS_FINISHED . '">' . Lang::get('form.document_finished') . '</option>
                                <option value="' . Document::$PROCESS_STATUS_REJECTED . '">' . Lang::get('form.document_rejected') . '</option>
                            </select>'
                    ];
                    $document->actions = [
                        'buttons' => [
                            [
                                'html' => '<a href="' . Storage::url($document->path) . '" target="_blank" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>',
                            ],
                            [
                                'html' => '<a href="' . Storage::url($document->path) . '" download class="btn btn-info btn-sm"><i class="fas fa-download"></i></a>',
                            ],
                            [
                                'html' => '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#commentModal' . $document->id . '" data-id="' . $document->id . '"><i class="fas fa-comment"></i></button>',
                            ],
                        ],
                    ];
                    break;
                case Document::$PROCESS_STATUS_IN_PROGRESS:
                    $document->process_status = [
                        'html' => '
                            <select id="document-status-' . $document->id . '" class="badge badge-info" style="border: 0 !important;" onchange="changeProcessStatus(' . $document->id . ')">
                                <option value="' . Document::$PROCESS_STATUS_IN_PROGRESS . '" selected>' . Lang::get('form.document_in_progress') . '</option>
                                <option value="' . Document::$PROCESS_STATUS_FINISHED . '">' . Lang::get('form.document_finished') . '</option>
                                <option value="' . Document::$PROCESS_STATUS_REJECTED . '">' . Lang::get('form.document_rejected') . '</option>
                            </select>'
                    ];
                    $document->actions = [
                        'buttons' => [
                            [
                                'html' => '<a href="' . Storage::url($document->path) . '" target="_blank" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>',
                            ],
                            [
                                'html' => '<a href="' . Storage::url($document->path) . '" download class="btn btn-info btn-sm"><i class="fas fa-download"></i></a>',
                            ],
                            [
                                'html' => '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#commentModal' . $document->id . '" data-id="' . $document->id . '"><i class="fas fa-comment"></i></button>',
                            ],
                        ],
                    ];
                    break;
                case Document::$PROCESS_STATUS_FINISHED:
                    $document->process_status = [
                        'html' => '
                            <select id="document-status-' . $document->id . '" class="badge badge-success" style="border: 0 !important;" onchange="changeProcessStatus(' . $document->id . ')">
                                <option value="' . Document::$PROCESS_STATUS_FINISHED . '" selected >' . Lang::get('form.document_finished') . '</option>
                                <option value="' . Document::$PROCESS_STATUS_IN_PROGRESS . '">' . Lang::get('form.document_in_progress') . '</option>
                                <option value="' . Document::$PROCESS_STATUS_REJECTED . '">' . Lang::get('form.document_rejected') . '</option>
                            </select>'
                    ];
                    $document->actions = [
                        'buttons' => [
                            [
                                'html' => '<a href="' . Storage::url($document->path) . '" target="_blank" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>',
                            ],
                            [
                                'html' => '<a href="' . Storage::url($document->path) . '" download class="btn btn-info btn-sm"><i class="fas fa-download"></i></a>',
                            ],
                            [
                                'html' => '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#commentModal' . $document->id . '" data-id="' . $document->id . '"><i class="fas fa-comment"></i></button>',
                            ],
                        ],
                    ];
                    break;
                case Document::$PROCESS_STATUS_REJECTED:
                    $document->process_status = [
                        'html' => '
                            <select id="document-status-' . $document->id . '" class="badge badge-danger" style="border: 0 !important;" onchange="changeProcessStatus(' . $document->id . ')">
                                <option value="' . Document::$PROCESS_STATUS_REJECTED . '" selected>' . Lang::get('form.document_rejected') . '</option>
                                <option value="' . Document::$PROCESS_STATUS_IN_PROGRESS . '">' . Lang::get('form.document_in_progress') . '</option>
                                <option value="' . Document::$PROCESS_STATUS_FINISHED . '">' . Lang::get('form.document_finished') . '</option>
                            </select>'
                    ];
                    $document->actions = [
                        'buttons' => [
                            [
                                'html' => '<a href="' . Storage::url($document->path) . '" target="_blank" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>',
                            ],
                            [
                                'html' => '<a href="' . Storage::url($document->path) . '" download class="btn btn-info btn-sm"><i class="fas fa-download"></i></a>',
                            ],
                            [
                                'html' => '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#commentModal' . $document->id . '" data-id="' . $document->id . '"><i class="fas fa-comment"></i></button>',
                            ],
                        ],
                    ];
                    break;
                default:
                    $document->process_status = [
                        'html' => '<small class="badge badge-secondary">' . Lang::get('form.document_not_applicable') . '</small>'
                    ];
                    break;
            }
        }

        return view('admin.documents.management', [
            'language' => $this->localeKey(),
            'data' => $documents,
            'id' => 'documents-list',
            'heads' => [
                'id' => [
                    'classes' => 'text-center',
                    'width' => 5,
                    'label' => Lang::get('form.id'),
                ],
                'name' => [
                    'classes' => 'text-center',
                    'width' => 20,
                    'label' => Lang::get('form.document_title'),
                ],
                'document_type' => [
                    'classes' => 'text-center',
                    'width' => 15,
                    'label' => Lang::get('form.document_type'),
                ],
                'process_status' => [
                    'classes' => 'text-center',
                    'width' => 10,
                    'label' => Lang::get('form.document_status'),
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
     * Create a new document
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request) : \Illuminate\Http\RedirectResponse {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'document_type_id' => 'required|integer|exists:document_types,id',
            'file' => 'mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:2048',
            'linked_to' => 'required|string|in:E,S',
            'employee_id' => 'integer|exists:employees,id',
            'service_id' => 'integer|exists:services,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        switch ($request->linked_to) {
            case Document::$LINKED_TO_EMPLOYEE:
                $exists = Document::where('document_type_id', $request->document_type_id)
                    ->where('employee_id', $request->employee_id)
                    ->exists();

                if ($exists) {
                    return redirect()->back()->withErrors(Lang::get('alerts.document_already_linked'));
                }
                break;
            case Document::$LINKED_TO_SERVICE:
                $exists = Document::where('document_type_id', $request->document_type_id)
                    ->where('service_id', $request->service_id)
                    ->exists();

                if ($exists) {
                    return redirect()->back()->withErrors(Lang::get('alerts.document_already_linked'));
                }
                break;
            default:
                return redirect()->back()->withErrors(Lang::get('alerts.missing_parameters', ['parameter' => 'linked_to']));
                break;
        }

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/documents');
        }

        DB::beginTransaction();
        try {
            $document = new Document();
            $document->name = $request->name;
            $document->path = $path ?? null;
            $document->document_type_id = $request->document_type_id;
            $document->user_id = Auth::user()->id;
            $document->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'create_document',
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);
            return redirect()->back()->withErrors(Lang::get('alerts.create_document_error'));
        }

        DB::commit();
        return redirect()->back()->with('success', Lang::get('alerts.create_document_success'));
    }

    /**
     * Change process status of a document
     * @param Request $request
     * @return JsonResponse
     */
    public function changeProcessStatus(Request $request) : \Illuminate\Http\JsonResponse {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:documents,id',
            'process_status' => 'required|string|in:N,A,F,R',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        DB::beginTransaction();
        try {
            $document = Document::find($request->id);
            $document->process_status = $request->process_status;
            $document->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            SystemLog::create([
                'type' => 'error',
                'action' => 'change_process_status_document',
                'message' => $th->getMessage(),
                'user_id' => 999,
                'ip_address' => request()->ip(),
            ]);
            return response()->json([
                'success' => false,
                'message' => Lang::get('alerts.status_changed_error'),
            ]);
        }

        DB::commit();
        return response()->json([
            'success' => true,
            'message' => Lang::get('alerts.status_changed_success'),
        ]);
    }
}