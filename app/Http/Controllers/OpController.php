<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DinkesModel;
use App\Models\NakesModel;
use App\Models\AdminModel;
use App\Models\OpModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use App\Helpers\Help;

class OpController extends Controller
{
    /** @var OpModel */
    protected $model;

    /** @var AdminModel */
    protected $model3;

    /** @var Help */
    protected $help;

    public function __construct(){
        $this->model = new OpModel;
        $this->model3 = new AdminModel;
        $this->help = new Help;
    }

    public function index(){
        //
        return view('welcome');
    
    }

  


    public function opdashboard(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $id_profesi = Auth::user()->class_op;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $tglcoba = '2022-01-10 02:01:00';
        $bedanya = $this->help->standardiff($tglcoba);
        $data['pengajuan'] = $this->model->getpengajuan($id_profesi);

        return view('op/opdashboard', $data);
        
    }

    public function optdashboard(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $id_profesi = Auth::user()->class_op;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $tglcoba = '2022-01-10 02:01:00';
        $bedanya = $this->help->standardiff($tglcoba);
        $data['pengajuan'] = $this->model->getpengajuan($id_profesi);

        return view('op/testing', $data);
        
    }

    public function setujuipengajuanop(Request $request) {

        $id_pengajuan = $request->id_pengajuan;
        $updatebyop = $this->model->updatestatusbyop($id_pengajuan);
        if ($updatebyop) {
            return response()->json(['success'=>true, 'message'=>'Berhasil Menyetujui Pengajuan Nakes']);
        } else {
            return response()->json(['success'=>false, 'message'=>'Gagal Menyetujui Pengajuan Nakes']);
        }
    }



    public function gethistoriasmanlistop(Request $request)
    {
        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id_aut = Auth::user()->id;
        $userrole = Auth::user()->role;
       
        $list = $this->model3->get_datatables_historitinjau($userrole, $request);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pengajuan) {

            if($pengajuan->perpanjangan == 0) {
                $jerapi = 'Pengajuan Awal';
            } else {
                $jerapi = 'Pengajuan Ke '.$pengajuan->perpanjangan;
            }

            if($pengajuan->isApproved == '3') {

                $keterangan = '<br /><span class="badge badge-info">Pengajuan TTE</span>';

            } elseif ($pengajuan->isApproved == '4') {

                $keterangan = '<br /><span class="badge badge-success">TTE Selesai</span>';

            } else {
                $keterangan = '';
            }
            

            $no++;
            $row = array();
            $row[] = $no;           
            $row[] = $pengajuan->name;
            $row[] = $pengajuan->no_doc;
            $row[] = $pengajuan->alamat_pengajuan;
            $row[] = $jerapi;
            //$row[] = $surat->pengirim_surat;
            $row[] = $pengajuan->created_at;
            $row[] = '<a class="btn btn-sm btn-primary viewdetailpengajuan" data-id = "'.$pengajuan->id.'" href="">Detail</a>'.$keterangan;
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->model3->count_all($userrole, $request),
                        "recordsFiltered" => $this->model3->count_filtered($userrole, $request),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
        
    }


    
    public function faskesdashboard(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $id_faskes = Auth::user()->class_op;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $tglcoba = '2022-01-10 02:01:00';
        $bedanya = $this->help->standardiff($tglcoba);
        $data['id_faskes'] = $id_faskes;
        $data['total_nakes'] = $this->model3->getrekapfaskes($id_faskes, 1);
        $data['total_nakes_pending'] = $this->model3->getrekapfaskes($id_faskes, 0);
        $data['allnakesonfaskes'] = $this->model3->allnakesonfaskes($id_faskes);
        return view('faskes/faskesdashboard', $data);
        
    }

}
