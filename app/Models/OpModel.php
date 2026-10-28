<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OpModel extends Model
{
    public function getdatatask($posting){

        $user_id = $posting->user_id;
    }

    public function getdoc($id, $jenis) {

        return DB::table('tbl_docs')
            ->where('id_user',$id)
            ->where('jenis_doc', $jenis)
            ->get();
    }

    public function getpengajuan($id_profesi) {

        $getnamaprof = DB::table('master_profesi')
            ->select('alias_profesi')
            ->where('id_profesi', $id_profesi)
            ->first();
        
        $jenis_profesi = $getnamaprof->alias_profesi;


        $s0 = DB::table('users')
            ->select('id', 'name', 'photo_url', 'isActive')
            ->orderBy('id');
        $s1 = DB::table('tbl_docs')
            ->select('id', 'id_user', 'salinan', 'no_doc')
            ->where('kadaluarsa','<>','1');
        $s2 = DB::table('tbl_pendaftaran')
            ->select('id_user', 'jenis_profesi');

        return DB::table('tbl_pengajuan')
            ->select(DB::raw('tbl_pengajuan.*, "'.$jenis_profesi.'" as jenis_profesi, s0.name, s0.photo_url, s1.no_doc, case when s0.isActive = "0" then "resigned" else "aktif" end as isActive'))
            ->leftjoinsub($s0, 's0', function($join){
                $join->on('tbl_pengajuan.id_user', 's0.id');
            })
            ->leftjoinsub($s1, 's1', function($join){
                $join->on('tbl_pengajuan.id_doc', 's1.id');
            })
            ->leftjoinsub($s2, 's2', function($join){
                $join->on('tbl_pengajuan.id_user', 's2.id_user');
            })
            ->where('updated_by_op', '0')
            ->where('s2.jenis_profesi', $jenis_profesi)
            ->orderby('tbl_pengajuan.updated_at', 'desc')
            ->get();


    }


    public function updatestatusbyop($id_pengajuan){
        return DB::table('tbl_pengajuan')
                ->where('id', $id_pengajuan)
                ->update(['updated_by_op' => '1']);
    }

    public function tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1) {

         return DB::table('tbl_docs')
                ->insert(array(
                    'id_user' => $user_id,
                    'jenis_doc' => $jenis_doc,
                    'namafile' => $namafile,
                    'nama_doc' => $nama_doc,
                    'no_doc' => $no_doc,
                    'tgl_doc' => $tgl_doc,
                    'tgl_berlaku' => $tgl_berlaku,
                    'remark1' => $remark1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')

                ));
    }

    public function getidnakes($id) {

        $query = DB::table('tbl_pengajuan')
            ->select('id_user')
            ->where('id', $id)
            ->first();
        
        $id_nakes = $query->id_user;
        return $id_nakes;

    }

    public function getdetailpengajuan($id) {

        $s3 = DB::table('master_alasan')
                ->select('kd_alasan', 'nama_alasan');


        return DB::table('tbl_pengajuan')
            ->leftjoinsub($s3, 's3', function($join){
                $join->on('tbl_pengajuan.alasan', 's3.kd_alasan');
            })
            ->where('id', $id)
            ->first();
            
    }

    public function getsalinanpengajuan($id) {

        $query = DB::table('tbl_pengajuan')
            ->select('salinan')
            ->where('id', $id)
            ->first();
        
        $salinan = $query->salinan;
        return $salinan;
        
    }

    public function updatevisitasil($id_pengajuan, $id_nakes, $tgl_visitasi) {

        $affected = DB::table('tbl_pengajuan')
            ->where('id', $id_pengajuan )
            ->update(['tgl_visitasi' => $tgl_visitasi , 'isApproved' => '1']);


        if ($affected > 0) {
            return true;
        } else {
            return false;
        }
        
    }


    public function updatePesan($updater, $jenis, $pesanadmin, $id_user) {


        DB::table('tbl_information')
            ->insert([
                'jenis_informasi' => $jenis,
                'updater' => $updater,
                'informasi' => $pesanadmin,
                'terupdate' => $id_user,
                'remark' => 'Approval Pendaftaran',
                'created_at' => date('Y-m-d')
            ]);

    }

    public function getjadwalnak($id_nakes, $salinan){
        $result = DB::table('tbl_jadwalpraktik')
            ->selectRAW(DB::raw("urutan as nomore, hari, concat(mulai, ' - ', selesai) as pukul, case when is_shift = '1' then 'Shift' else '-' end as isShift"))
            ->where('id_user', $id_nakes)
            ->where('salinan', $salinan)
            ->where('isSet', '1')
            ->get();

        if ($result->count() > 0) {

            return $result;

        } else {
            return false;
        }
    }

    


}
