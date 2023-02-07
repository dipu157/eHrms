<?php

namespace App\Http\Controllers\Notice;

use App\Http\Traits\CommonTrait;
use App\Models\Notice\Notice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CreateNoticeController extends Controller
{

    use CommonTrait;

    public function index(Request $request)
    {

        return view('notice.create-notice-index');
    }

    public function noticeData()
    {
        $notices = Notice::query()->where('company_id',$this->getCompanyId())
            ->orderBy('id','DESC')
            ->get();


        return DataTables::of($notices)

            ->addColumn('action', function ($notices) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    
                    <button data-rowid="'. $notices->id . '"  type="button" href="#notice-document-upload" data-target="#notice-document-upload" data-toggle="modal" class="btn btn-info btn-file-upload btn-sm"><i class="fa fa-upload">Upload</i></button>
                    
                    <button data-remote="edit/' . $notices->id . '" data-rowid="'. $notices->id . '" 
                        data-title="'. $notices->title . '" 
                        data-description="'. $notices->description . '" 
                        type="button" href="#modal-edit-training" data-target="#modal-edit-training" data-toggle="modal" class="btn btn-sm btn-training-edit btn-primary pull-center"><i class="fa fa-edit" >Edit</i></button>
                        
                        <button data-remote="view/' . $notices->id . '" data-rowid="'. $notices->id . '"  type="button"  class="btn btn-secondary btn-file-view btn-sm"><i class="fa fa-download">View</i></button>
                    </div>
                    
                    ';
            })

            ->addColumn('status', function ($notices) {

                return $notices->status == true ? 'Open' : 'Closed';
            })


            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function create(Request $request)
    {

//        dd($request);

        $request['company_id'] = $this->getCompanyId();
        $request['user_id'] = $this->getUserId();
        $request['status'] = true;
        $request['type'] = $request['action'];
        $request['confidentiality'] = $request['confidential'];
        $request['notice_date'] = Carbon::createFromFormat('d-m-Y',$request['notice_date'])->format('Y-m-d');
        $request['expiry_date'] = is_null($request['expiry_date']) ? null : Carbon::createFromFormat('d-m-Y',$request['expiry_date'])->format('Y-m-d');

        DB::beginTransaction();

        try {

            Notice::query()->create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return response()->json(['success' => 'New Notice Added'], 200);
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


        if($request->hasfile('doc-file'))
        {
            $file = $request->file('doc-file');

            $name = $request['id-for-update'].'.'.$file->getClientOriginalExtension();
            $file->move(public_path().'/document/', $name);

            Notice::query()->find($request['id-for-update'])->update(['file_path'=>'document/'.$name]);
        }

        return redirect()->action('Notice\CreateNoticeController@index')->with(['success' => 'Document File Uploaded']);


    }

    public function viewFile($id)
    {

        $filename = 'document/'.$id.'.pdf';
        $path = public_path($filename);

//        dd($path);

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);

    }

    public function update(Request $request)
    {
        DB::beginTransaction();

        try {

            Training::query()->where('id',$request['id-for-update'])->update($request->except('_token','id-for-update'));


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return response()->json(['success' => 'Training Data Updated'], 200);
    }

    public function view($id)
    {
        $training = Training::query()->where('company_id',1)->where('id',$id)->first();

        return view('training.view-training',compact('training'));
    }
}
