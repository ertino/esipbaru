<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BillingModel extends Model
{
    public function getOPD(){
        return DB::table('tbl_master_opd')
            ->orderBy('id_opd', 'asc')
            ->get();
    }

    public function geturl($idopd, $jenisretrib){
        $query = DB::table('tbl_master_retribusi')
            ->select('base_url')
            ->where('id_opd', $idopd)
            ->where('id_retribusi', $jenisretrib)
            ->first();
        
        $baseurl = $query->base_url;
        return $baseurl;
    }

    
    

}
