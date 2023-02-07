<?php

namespace App\Http\Controllers\Document;

use App\Models\Common\Department;
use App\Models\Document\DocumentTypeModel;
use App\Models\Document\DocumentModel;
use App\Models\Employee\EmpProfessional;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class DocumentationController extends Controller
{
    public $company_id;
    public $user_id;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->company_id = Auth::user()->company_id;
            $this->user_id = Auth::id();

            return $next($request);
        });
    }

    public function index()
    {
        if (check_privilege(29, 1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $document_type = DocumentTypeModel::query()
            ->where('company_id', $this->company_id)
            ->where('status', true)->pluck('name', 'id');

        $departments = Department::query()->where('company_id', $this->company_id)->where('status', true)
            ->orderBy('name', 'ASC')->pluck('name', 'id');

        return view('documentation.documentation-index', compact('document_type', 'departments'));
    }

    public function documentData()
    {
        $documents = DocumentModel::query()->where('company_id', $this->company_id)
            ->with('user')
            ->with('documentType')
            ->orderBy('id', 'DESC')
            ->get();

        return DataTables::of($documents)

            ->addColumn('view', function ($documents) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="View Button">                
                <button data-remote="view/' . $documents->id . '" data-rowid="' . $documents->id . '"  type="button" id="document-id"  class="btn btn-secondary btn-file-view btn-sm"><i class="fa fa-view">View</i></button>
                </div>';
            })
            ->addColumn('action', function ($documents) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    
                    <button data-rowid="' . $documents->id . '"  type="button" href="#document-upload" data-target="#document-upload" data-toggle="modal" class="btn btn-info btn-file-upload btn-sm"><i class="fa fa-upload">Upload</i></button>
                    <button data-remote="edit/' . $documents->id . '" 
                        type="button" class="btn btn-sm btn-document-edit btn-primary pull-center"><i class="fa fa-edit" >Edit</i></button>
                    
                    </div>                     
                    ';
            })
            ->addColumn('status', function ($documents) {

                return $documents->status == true ? 'Active' : 'Disabled';
            })
            ->rawColumns(['view', 'action', 'status'])
            ->make(true);
    }

    public function create(Request $request)
    {
        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['status'] = true;
        $request['document_date'] = Carbon::createFromFormat('d-m-Y', $request['document_date'])->format('Y-m-d');

        DB::beginTransaction();

        try {

            DocumentModel::query()->create($request->all());
        } catch (\Exception $e) {
            DB::rollBack();
            $error = $e->getMessage();
            return redirect()->back()->with('error', 'Not Saved ' . $error);
        }

        DB::commit();

        return response()->json(['success' => 'New Document Added'], 200);
    }

    public function saveFile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'doc-file'   => 'required|file|mimes:pdf'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        if ($request->hasfile('doc-file')) {
            $file = $request->file('doc-file');

            $name = $request['id-for-upload'] . '.' . $file->getClientOriginalExtension();
            $file->move(public_path() . '/documentation/', $name);

            DocumentModel::query()->find($request['id-for-upload'])->update(['file_path' => 'documentation/' . $name]);
        }

        return redirect()->action('Document\DocumentationController@index')->with(['success' => 'Document File Uploaded']);
    }

    public function viewFile($id)
    {

        $filename = 'documentation/' . $id . '.pdf';
        $path = public_path($filename);

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function documentEdit($id)
    {
        if (check_privilege(18, 3) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $data = DocumentModel::query()->where('company_id', 1)->where('id', $id)
            ->with('documentType')->with('user')->first();

        $departments = Department::query()->where('company_id', $this->company_id)->where('status', true)->pluck('name', 'id');
        $document_type = DocumentTypeModel::query()
            ->where('company_id', $this->company_id)
            ->where('status', true)->pluck('name', 'id');

        return view('documentation.edit-documentat-data', compact('data', 'departments', 'document_type'));
    }

    public function update(Request $request)
    {

        if (check_privilege(18, 3) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }


        DB::beginTransaction();

        try {
            DocumentModel::query()->where('id', $request['id'])->update($request->except(['_token', 'action']));
        } catch (\Exception $e) {
            DB::rollBack();
            $error = $e->getMessage();
            return response()->json(['error' => $error], 404);
        }

        DB::commit();


        return response()->json(['success' => 'Updated Document Data'], 200);
    }
}
