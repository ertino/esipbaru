<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\BillingModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadfileController extends Controller
{
    /** @var BillingModel */
    protected $model;

    public function __construct(){
        $this->model = new BillingModel;
    }

    public function index(){
        //
    
    }
    
    function downloadFile($file_name){
        //$thefile = Storage::get('jaringan/processed/networkdiskominfo.json');
        //$file = Storage::disk('uploaddoc')->get($file_name);
        $thefile = Storage::get('uploaddoc/'.$file_name);
  
        return (new Response($thefile, 200))->header('Content-Type', 'application/pdf');
    }

    function downloadKTP($file_name) {

        $thefile = Storage::get('uploaddoc/'.$file_name);
        return (new Response($thefile, 200))->header('Content-Type', 'image/jpg');

    }


    


    function downloadFilePeru($file_name){
        //$thefile = Storage::get('jaringan/processed/networkdiskominfo.json');
        //$file = Storage::disk('uploaddoc')->get($file_name);
        $thefile = Storage::get('uploadperubahandoc/'.$file_name);
  
        return (new Response($thefile, 200))->header('Content-Type', 'application/pdf');
    }

    function downloadFileTask($file_name){
        //$thefile = Storage::get('jaringan/processed/networkdiskominfo.json');
        //$file = Storage::disk('uploaddoc')->get($file_name);
        $thefile = Storage::get('uploadtask/'.$file_name);
  
        return (new Response($thefile, 200))->header('Content-Type', 'application/pdf');
    }


    function downloadOriginSTR($file_name){
        //$thefile = Storage::get('jaringan/processed/networkdiskominfo.json');
        //$file = Storage::disk('uploaddoc')->get($file_name);
        $thefile = Storage::get('daftar/'.$file_name);
  
        return (new Response($thefile, 200))->header('Content-Type', 'application/pdf');
    }

    function getfileview(Request $request) {

        $thefilenya = $request->thename;
        $thefile = Storage::get('daftar/'.$thefilenya);

        return (new Response($thefile, 200))->header('Content-Type', 'application/pdf');


    }




}
