<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BillingModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BillingController extends Controller
{
    /** @var BillingModel */
    protected $model;

    public function __construct(){
        $this->model = new BillingModel;
    }

    public function index(){
        //
    
    }
    
    public function getOPD(){
        $data['dataOPD']= $this->model->getOPD();
        return response()->json($data);
    }

    public function checkpembayar($id_billing){
        $idkota = substr($id_billing,0,2);
        $idopd = substr($id_billing, 2,3);
        $jenisretrib = substr($id_billing,5,2);
        $tahun = substr($id_billing, 7,4);
        $idwr = substr($id_billing,11);
        $base_url = $this->model->geturl($idopd, $jenisretrib);
        $get_url = $base_url.'checkwr/'.$tahun.$idwr;
        $response = Http::withBasicAuth('billingcenter', '12345')->get($get_url)->throw()->json();
        return $response;
        #return response()->json($data);
    }

    public function settlement($id_billing,$tgl_posting){
        $idkota = substr($id_billing,0,2);
        $idopd = substr($id_billing, 2,3);
        $jenisretrib = substr($id_billing,5,2);
        $tahun = substr($id_billing, 7,4);
        $idwr = substr($id_billing,11);
        $base_url = $this->model->geturl($idopd, $jenisretrib);
        $get_url = $base_url.'settlement/'.$tahun.$idwr.'/'.$tgl_posting;
        $response = Http::withBasicAuth('billingcenter', '12345')->post($get_url)->throw()->json();
        return $response;
        #return response()->json($data);
    }




}
