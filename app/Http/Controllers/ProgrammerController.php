<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgrammerModel;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProgrammerController extends Controller
{
    /** @var ProgrammerModel */
    protected $model;

    /** @var AdminModel */
    protected $model2;

    public function __construct(){
        $this->model = new ProgrammerModel;
        $this->model2 = new AdminModel;
    }

    public function index(){
        //
        return view('welcome');
    
    }


    public function progdashboard(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $data['user_id'] = $id;
        $data['role'] = Auth::user()->role;

        $data['listApp'] = $this->model2->getlistApp($id);
        $data['listPIC'] = $this->model2->getlistPIC();
        $data['listIntegrasi'] = $this->model2->getIntegration();
        $data['listProg'] = $this->model2->getlistProg();
        $data['listActivity'] = $this->model->getTimeline($id);
        $data['listServis'] = $this->model2->getlistService();
        return view('progdashboard', $data);
        
    }



    
    public function tambahretrib(Request $request){
        //$data['listlokasi']= $this->model->getAllLokasi();

        try{
            $this->model->tambahretrib($request);
            return redirect()->route('admin.main.dashboard')->with('alert', 'Data berhasil disimpan');
        }catch(Exception $e) {
            return redirect()->route('admin.main.dashboard')->with('alert', 'Gagal');
        }
        
    }


    public function executivedashboard(){


        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $data['role'] = Auth::user()->role;
        $id = Auth::user()->id;
        $data['user_id'] = $id;

        $data['listRetrib'] = $this->model->getdataretrib();
        $data['listOPD'] = $this->model->getlistOPD();
        $data['detailPajak'] = $this->model->detailPajak();
        $data['detailRetribusi'] = $this->model->detailRetribusi();
        $data['totalPajak'] = $this->model->getTotal('pajak');
        $data['totalRetribusi'] = $this->model->getTotal('retribusi');
        return view('executive_dashboard', $data);
        
    }

    public function ceki(){
        //
        return view('template_dashboard');
    
    }

    public function uploaddashboard(){

        $data['role'] = Auth::user()->role;
        $id = Auth::user()->id;
        $data['user_id'] = $id;

        $data['listApp'] = $this->model->getlistApp();
        $data['listPIC'] = $this->model->getlistPIC();
        $data['listIntegrasi'] = $this->model->getIntegration();
        $data['listProg'] = $this->model->getlistProg();
        $data['listActivity'] = $this->model->getTimeline();
        return view('uploaddashboard', $data);
        
    }

    public function uploadtest(Request $request){

        $data['role'] = Auth::user()->role;
        $id = Auth::user()->id;
        $data['user_id'] = $id;

        $data['listApp'] = $this->model->getlistApp();
        $data['listPIC'] = $this->model->getlistPIC();
        $data['listIntegrasi'] = $this->model->getIntegration();
        $data['listProg'] = $this->model->getlistProg();
        $data['listActivity'] = $this->model->getTimeline();
        $thefile = $request->file('filekpcpn');
        $path = Storage::putFileAs('/filekpcpn', $thefile, 'filekpcpn.csv');

        return response()->json(['success'=>'Successfully uploaded.']);

    }

    
    public function tambahtask(Request $request){

        $data['role'] = Auth::user()->role;
        $id = Auth::user()->id;
        $data['user_id'] = $id;
        $tgl_task = substr($request->etgl,0,10);
        
        $result = $this->model2->tambahTask($request);
        $msg['success'] = false;
        $msg['type'] = 'update';
        $thefile = $request->file('tFileTask');
        $filenamenya = $id.'_'.$result.'_'.$tgl_task;
        $path = Storage::putFileAs('/uploadtask', $thefile, $filenamenya.'.pdf');
        $resultupdate = $this->model2->updateTask($result, $filenamenya);
        if($resultupdate){
            $msg['success'] = true;
        }
        echo json_encode($msg);

    }

    
    public function getdatatask(Request $request){
        $data['events'] = $this->model->getdatatask($request);
        return response()->json($data);
    }
    


}
