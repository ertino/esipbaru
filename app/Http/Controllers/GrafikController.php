<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GrafikController extends Controller
{
    /** @var AdminModel */
    protected $model;

    public function __construct(){
        $this->model = new AdminModel;
    }

    
    public function chartHistoryPajak(Request $request){
        
        $result = $this->model->chartHistoryPajak($request);
        echo json_encode($result);

    }

    public function getChartDetail(Request $request) {
       
        $result = $this->model->getChartDetail($request);
        echo json_encode($result);
    
    }


}
