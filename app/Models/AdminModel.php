<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Client;

use Carbon\Carbon;



class AdminModel extends Model
{
    public function setloglogin($id) {

        return DB::table('users')
            ->where('id', $id)
            ->update([
                'last_login' => date('Y-m-d H:i:s')
            ]);

    }

    function tgl_indo_sip($tanggal){
		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);
		
		// variabel pecahkan 0 = tanggal
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tahun
	 
		return (int)$pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}

    function tambahLimaTahunDanKurangkanSatuHari($tanggalInput) {
        // Parse the input date string using Carbon
        $tanggal = Carbon::createFromFormat('Y-m-d', $tanggalInput);
    
        // Add 5 years
        $tanggal->addYears(5);
    
        // Subtract one day
        $tanggal->subDay();
    
        return $tanggal;
    }

    public function getdataretrib(){
        return DB::table('tbl_master_retribusi')
            ->join('tbl_skpd', 'tbl_master_retribusi.id_opd', 'tbl_skpd.kode_retrib')
            ->orderBy('id', 'asc')
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

    
    public function getlistOPD(){
        return DB::table('tbl_skpd')
            ->get();
    }

    
    public function tambahretrib($posting) {

        $id_opd = $posting->id_opd;
        $nama_retribusi = $posting->nama_retribusi;
        $base_url = $posting->base_url;
        $remark = $posting->remark;
    
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $query = DB::table('tbl_master_retribusi')
            ->selectRaw(DB::raw('max(id_retribusi) as max_retrib'))
            ->where('id_opd', $id_opd)
            ->first();
        
        $id_retribusi = (int)$query->max_retrib;
        $next_retrib = $id_retribusi + 1;
        $retrib_id = str_pad($next_retrib,2,"0",STR_PAD_LEFT);

        DB::table('tbl_master_retribusi')
        ->insert([
            'id_opd' => $id_opd,
            'id_retribusi' => $retrib_id,
            'nama_retribusi' => $nama_retribusi,
            'base_url' => $base_url,
            'remark' => $remark,
            "created_at" => $created_at,
            "updated_at" => $updated_at
        ]);

        

    }

    
    public function detailPajak()
    {
        $quermax = DB::table('tbl_realisasi_pajak')
            ->select(DB::raw('max(periode) as periode'))
            ->first();
        
        $maxperiode = substr($quermax->periode,0,10);

        return DB::table('tbl_realisasi_pajak')
            ->select(DB::raw('jenis_pajak, `target`, realisasi, replace(persentase, ",",".") as persentase'))
            ->whereRaw('substr(periode,1,10) = "'.$maxperiode.'" and jenis_pajak <> "TOTAL"')
            ->orderByRaw('replace(replace(persentase,",","."),"%","") DESC')
            ->limit(5)
            ->get();
    }

    
    public function detailRetribusi()
    {
        $quermax = DB::table('tbl_realisasi_retribusi')
            ->select(DB::raw('max(periode) as periode'))
            ->first();
        
        $maxperiode = $quermax->periode;

        return DB::table('tbl_realisasi_retribusi')
            ->select(DB::raw('nama_retribusi, `target`, realisasi, persentase*100 as persentase'))
            ->whereRaw('periode = "'.$maxperiode.'"')
            ->orderBy('persentase', 'desc')
            ->limit(5)
            ->get();
    }


    ///charthistoripajak

    public function chartHistoryPajak($request)
	{
    
        $perioda = DB::table('tbl_realisasi_pajak')
            ->select(DB::raw('distinct(periode) as periode'))
            ->orderBy('periode')
            ->limit(12)
            ->get();

		foreach ($perioda as $per) {
				$period[] = $per->periode;
		}
        $str = implode("','", $period);
        
        
        $quaris = DB::table('tbl_realisasi_pajak')
            ->select(DB::raw('distinct(jenis_pajak) as jenis_pajak'))
            ->where('jenis_pajak', '<>', 'TOTAL')
            ->orderBy('jenis_pajak')
            ->get();

        $vel1 = [];
        
        foreach($quaris as $qua) {

            $jenise = $qua->jenis_pajak;

            $hasil = DB::table('tbl_realisasi_pajak')
            ->select(DB::raw('replace(substr(realisasi,1,(length(realisasi)-3)),".","") as realisasi'))
            ->where('jenis_pajak','<>', 'TOTAL')
            ->where('jenis_pajak', '=', $jenise)
            ->orderBy('periode')
            ->get();
            foreach ($hasil as $data) {

                $val1[] = (int)$data->realisasi;
            }
            array_push($vel1, $val1);
            $val1 = [];
            
        }
        
		return $vel1;
    }
    
    public function getChartDetail($posting)
	{
        $detailnya = $posting->detailnya;
        if ($detailnya == 'periode') {
            $vel1 = [];
            $hasil = DB::table('tbl_realisasi_pajak')
                ->select(DB::raw('distinct(substr(periode,1,10)) as periode'))
                ->where('jenis_pajak','<>', 'TOTAL')
                ->orderByRaw('substr(periode,1,10)')
                ->get();
            foreach ($hasil as $data) {

                $val1[] = $data->periode;
            }
            array_push($vel1, $val1);
            $val1 = [];

        } else {
            $vel1 = [];
            $hasil = DB::table('tbl_realisasi_pajak')
                ->select(DB::raw('distinct(jenis_pajak)'))
                ->where('jenis_pajak','<>', 'TOTAL')
                ->orderBy('jenis_pajak')
                ->get();
            foreach ($hasil as $data) {

                $val1[] = $data->jenis_pajak;
                array_push($vel1, $val1);
                $val1 = [];
                
            }
            
        }
		
		return $vel1;
    }

    public function getTotal($jenis) {
        if($jenis == 'pajak') {

            $quermax = DB::table('tbl_realisasi_pajak')
                ->select(DB::raw('max(periode) as periode'))
                ->first();
        
            $maxperiode = $quermax->periode;

            $query = DB::table('tbl_realisasi_pajak')
                ->select('realisasi')
                ->where('periode', $maxperiode)
                ->where('jenis_pajak', '=', 'TOTAL')
                ->first();
        
            $realisasi = $query->realisasi;

        } else {

            $quermax = DB::table('tbl_realisasi_retribusi')
                ->select(DB::raw('max(periode) as periode'))
                ->first();
        
            $maxperiode = $quermax->periode;

            $query = DB::table('tbl_realisasi_retribusi')
                ->select('realisasi')
                ->where('periode', $maxperiode)
                ->first();
        
            $realisasi = $query->realisasi;

        }
        
        return $realisasi;

    }


    ///// applikasi APP

    
    public function getlistApp($id)
    {
        if($id == 'all') {
            return DB::table('tbl_apps')
            ->where('isKominfo', '1')
            ->orderBy('updated_at', 'desc')
            ->get();

        } else {
            return DB::table('tbl_apps')
            ->where('isKominfo', '1')
            ->where('pic_', $id)
            ->orderBy('updated_at', 'desc')
            ->get();
        }

        
    }

    public function getlistService()
    {
        return DB::table('m_servis')
            ->where('id', '<>','1')
            ->orderBy('id', 'asc')
            ->get();

        
    }

    
    public function getlistPIC()
    {

        $s0 = DB::table('tbl_pic')
            ->select(DB::raw('distinct pic_, app_id, integration_id'))
            ->orderBy('app_id');

        return DB::table('users')
            ->select(DB::raw('users.name , users.id, users.photo_url, vk.app_id, case when users.isActive = "0" then "resigned" else "aktif" end as isActive'))
            ->leftjoinsub($s0, 'vk', function($join){
                $join->on('users.id', 'vk.pic_');
            })
            ->where('users.role', 'programmer')
            ->get();
    }

    public function getIntegration()
    {

        $s0 = DB::table('tbl_apps')
            ->select('id', 'app_name', 'description', 'img_url')
            ->orderBy('id');
        
        $s2 = DB::table('tbl_apps')
            ->select('id', 'app_name', 'description', 'img_url')
            ->orderBy('id');

        return DB::table('tbl_integration')
            ->select(DB::raw('tbl_integration.id, tbl_integration.description, tbl_integration.host_app, tbl_integration.client_app, tbl_integration.pic_, s0.app_name as host_name, s2.app_name as client_name, s0.img_url as host_img, s2.img_url as client_img'))
            ->leftjoinsub($s0, 's0', function($join){
                $join->on('tbl_integration.host_app', 's0.id');
            })
            ->leftjoinsub($s0, 's2', function($join){
                $join->on('tbl_integration.client_app', 's2.id');
            })
            ->get();
    }

    public function getlistProg(){

        return DB::table('users')
        ->where('role', 'programmer')
        ->get();
    }

    public function getTimeline()
    {

        $s0 = DB::table('users')
            ->select('id', 'name', 'photo_url', 'isActive')
            ->orderBy('id');
        

        return DB::table('tbl_activity')
            ->select(DB::raw('tbl_activity.activity_id, tbl_activity.activity, tbl_activity.jenis, tbl_activity.timestamp, s0.name, s0.photo_url, case when s0.isActive = "0" then "resigned" else "aktif" end as isActive'))
            ->leftjoinsub($s0, 's0', function($join){
                $join->on('tbl_activity.user_id', 's0.id');
            })
            ->limit(10)
            ->orderby('tbl_activity.timestamp', 'desc')
            ->get();
    }


    
    public function updateevent($posting)
	{
        $id = $posting->id;
        $start = $posting->startgame;
        $end = $posting->endgame;

        $updateDetails = [
            'tgl_permohonan_rev' => $start,
            'tgl_permohonan_end' => $end
        ];

        DB::table('tbl_permohonan')
            ->where('id', $id)
            ->update($updateDetails);

    }

    public function approveevent($posting)
	{
        $id = $posting->id;
        $status_id = $posting->status_id;

        DB::table('tbl_permohonan')
            ->where('id', $id)
            ->update(['status_permohonan' => $status_id]);

    }

    
    public function tambahTask($posting)
	{
        $app_id = $posting->taplikasi;
        $service_id = $posting->tJenis;
        $integration_id = $posting->tIntegrasi;
        $modul = $posting->tModul;
        $start_date = $posting->etgl;
        $status = $posting->tStatus;
        $end_date = $posting->etgl_end.'T00:00:00';
        $keterangan = $posting->tKeterangan;
        $status_id = $posting->status_id;
        $user_id = $posting->tUser_id;


        $qua = DB::table('tbl_apps')
                ->select('app_name')
                ->where('id', $app_id)
                ->first();
        $nama_aplikasi = $qua->app_name;

        $quat = DB::table('m_servis')
                ->select('service_name', 'service_alias')
                ->where('id', $service_id)
                ->first();
        $nama_servis = $quat->service_name;
        $jenis_serser = $quat->service_alias;

        $id = DB::table('tbl_task')
                -> insertGetId(array(
                        'app_id' => $app_id,
                        'integration_id' => $integration_id,
                        'service_id' => $service_id,
                        'user_id' => $user_id,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'modul' => $modul,
                        'allDay' => 1,
                        'status_task' => 1,
                        'keterangan' => $keterangan,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'remark' => $nama_servis.' '.$nama_aplikasi.' modul : '.$modul
                    ));

        DB::table('tbl_activity')
                    ->insert(array(
                        'user_id' => $user_id,
                        'app_id' => $app_id,
                        'integration_id' => $integration_id,
                        'jenis' => $jenis_serser,
                        'activity' => $jenis_serser.' '.$nama_servis.' '.$nama_aplikasi.' modul: '.$modul,
                        'timestamp' => date('Y-m-d H:i:s')

                    ));
        return $id;
    }

    public function updateTask($id, $filenamenya)
	{
    
        DB::table('tbl_task')
            ->where('id', $id)
            ->update(['file_lampiran' => $filenamenya]);

        return true;

    }

    public function updateAllDay($posting)
	{
        $id = $posting->id;
        $allDay = $posting->allDay;


        DB::table('tbl_permohonan')
            ->where('id', $id)
            ->update(['allDay' => $allDay]);

    }



    public function tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $updater, $tgl_doc_ori, $tgl_berlaku_ori) {

        $first_three = substr($jenis_doc, 0, 3);

        if($remark1 == 'PNG') {

            return DB::table('tbl_docs')
               ->insert(array(
                   'id_user' => $user_id,
                   'jenis_doc' => $jenis_doc,
                   'namafile' => $namafile,
                   'nama_doc' => $nama_doc,
                   'no_doc' => $no_doc,
                   'tgl_doc' => $tgl_doc,
                   'tgl_berlaku' => $tgl_berlaku,
                   'tgl_doc_origin' => $tgl_doc_ori,
                   'tgl_berlaku_origin' => $tgl_berlaku_ori,
                   'is_compromised' => '1',
                   'keterangan_tolak' => 'Silahkan Upload Foto JPG',
                   'remark1' => $remark1,
                   'updater' => $updater,
                   'created_at' => date('Y-m-d H:i:s'),
                   'updated_at' => date('Y-m-d H:i:s')

               ));

        } else {

            return DB::table('tbl_docs')
               ->insert(array(
                   'id_user' => $user_id,
                   'jenis_doc' => $jenis_doc,
                   'namafile' => $namafile,
                   'nama_doc' => $nama_doc,
                   'no_doc' => $no_doc,
                   'tgl_doc' => $tgl_doc,
                   'tgl_berlaku' => $tgl_berlaku,
                   'tgl_doc_origin' => $tgl_doc_ori,
                   'tgl_berlaku_origin' => $tgl_berlaku_ori,
                   'remark1' => $remark1,
                   'updater' => $updater,
                   'created_at' => date('Y-m-d H:i:s'),
                   'updated_at' => date('Y-m-d H:i:s')

               ));

        }


        
   }

   public function updatestatuspengajuan($id_pengajuan, $updater, $status, $tracker, $tgl_approval_dinkes) {

        
       $now = date('Y-m-d H:i:s');
       if ($status == '2') {
            return DB::table('tbl_pengajuan')
                ->where('id', $id_pengajuan)
                ->update(['isApproved' => $status , 'tgl_approval_dinkes' => $now, 'updater' => $updater, 'tracker' => $tracker, 'updated_at' => $now]);

       } else if ($status == '9') {
            return DB::table('tbl_pengajuan')
                ->where('id', $id_pengajuan)
                ->update(['isApproved' => $status , 'updater' => $updater, 'tracker' => $tracker, 'alasan_ditolak' => $tgl_approval_dinkes, 'updated_at' => $now]);

       } else if ($status == 'revert') {

            DB::table('tbl_pengajuan')
                ->where('id', $id_pengajuan)
                ->update([
                    'isApproved' => '2',
                    'isverif' => '0',
                    'alasan_revert' => $tracker,
                    'updated_at' => $now

                ]);
    
            // Update record in tbl_docs
            DB::table('tbl_sip')
                ->where('id_pengajuan', $id_pengajuan)
                ->delete();

            return true;
        

           
       } else {

            return DB::table('tbl_pengajuan')
                ->where('id', $id_pengajuan)
                ->update(['isApproved' => $status , 'updater' => $updater, 'tracker' => $tracker, 'updated_at' => $now]);

       }
       
   }


   public function tolakpengajuanU($id_pengajuan, $updater, $status, $tracker, $tgl_approval_dinkes) {

            $getuser = DB::table('tbl_pengajuan')
                ->select('id_user')
                ->where('id', $id_pengajuan)
                ->first();

            $id_user = $getuser->id_user;
        
            return DB::table('tbl_pengajuan')
                ->where('id','<>', $id_pengajuan)
                ->where('id_user', $id_user)
                ->whereNotIn('isApproved', ['4', 'CF'])
                ->update(['isApproved' => $status , 'updater' => $updater, 'tracker' => $tracker, 'alasan_ditolak' => 'Dokumen STR / KTP / IJAZAH / FOTO bermasalah']);
    }


   public function getpengajuan($jenis) {

        if($jenis != 'cabut' && $jenis != 'cabutfar' && $jenis != 'perubahan' && $jenis !='sipmanual' && $jenis != 'cabuthitung' && $jenis != 'verif' && $jenis !='kadin' && $jenis != 'kadincabut') {

            $s0 = DB::table('users')
            ->select('id', 'name', 'photo_url', 'isActive')
            ->orderBy('id');

            $s1 = DB::table('tbl_sip')
                ->select('id_pengajuan', 'filename_sip', 'perubahan', 'id as id_sip')
                ->where('status_sip','<>','P');
            

            return DB::table('tbl_pengajuan')
                ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.id_sip, case when s0.isActive = "0" then "resigned" else "aktif" end as isActive'))
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_pengajuan.id_user', 's0.id');
                })
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_pengajuan.id', 's1.id_pengajuan')->on('tbl_pengajuan.perubahan', 's1.perubahan');
                })
                ->whereRAW('isApproved in ("2","E2")')
                ->orderby('tbl_pengajuan.updated_at', 'desc')
                ->get();

        } else if ($jenis == 'perubahan') {

            $s0 = DB::table('users')
            ->select('id', 'name', 'photo_url', 'isActive')
            ->orderBy('id');

            $s1 = DB::table('tbl_sip')
                ->select('id_pengajuan', 'filename_sip', 'perubahan', 'id as id_sip');

            $s2 = DB::table('master_faskes')
                ->select('id_faskes', 'nama_faskes');

            $s3 = DB::table('master_alasan')
                ->select('kd_alasan', 'nama_alasan');
            

            return DB::table('tbl_pengajuan')
                ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.id_sip, case when s0.isActive = "0" then "resigned" else "aktif" end as isActive, s2.nama_faskes, ifnull(s3.nama_alasan,0) as nama_alasan'))
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_pengajuan.id_user', 's0.id');
                })
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_pengajuan.id', 's1.id_pengajuan')->on('tbl_pengajuan.perubahan', 's1.perubahan');
                })
                ->leftjoinsub($s2, 's2', function($join){
                    $join->on('tbl_pengajuan.id_faskes', 's2.id_faskes');
                })
                ->leftjoinsub($s3, 's3', function($join){
                    $join->on('tbl_pengajuan.alasan', 's3.kd_alasan');
                })
                ->whereRAW('isApproved in ("P2", "P3", "P4")')
                ->orderby('tbl_pengajuan.updated_at', 'desc')
                ->get();



        } else if ($jenis == 'sipmanual') {

            $s0 = DB::table('users')
            ->select('id', 'name', 'photo_url', 'isActive')
            ->orderBy('id');

            

            return DB::table('tbl_sip_lama')
                ->select(DB::raw('tbl_sip_lama.*, s0.name, s0.photo_url, tbl_sip_lama.id as id_sip'))
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_sip_lama.id_nakes', 's0.id');
                })
                ->whereRAW('isApproved in ("2")')
                ->orderby('tbl_sip_lama.updated_at', 'desc')
                ->get();

        } else if ($jenis == 'cabut') {


            // $isverdinkes = DB::raw('CASE WHEN (profesi like "%APOTEKER%" OR profesi like "%VOKASI FARMASI%" OR profesi like "%TVK%" OR profesi like "TTK") AND template_id in ("3","4") THEN "1" ELSE "0" END as isverdinkes');

            $isverdinkes = DB::raw("
                CASE 
                    WHEN template_id = '4' THEN 1
                    WHEN template_id = '3' THEN 
                        CASE 
                            WHEN profesi LIKE '%VOKASI FARMASI%' THEN 1
                            WHEN profesi LIKE '%TVK%' THEN 1
                            WHEN profesi LIKE '%TTK%' THEN 1
                            WHEN profesi LIKE '%PENANGGUNG JAWAB%' THEN 1
                            ELSE 0
                        END
                    ELSE 0 
                END AS isverdinkes
            ");


            $s0 = DB::table('users')
            ->select('id', 'name', 'photo_url', 'isActive')
            ->orderBy('id');

            $s1 = DB::table('tbl_sip')
                ->select('id_pengajuan', 'filename_sip', 'id as id_sip', 'suratpencabutan', $isverdinkes, 'verifdinkes');

            $s2 = DB::table('master_faskes')
                ->select('id_faskes', 'nama_faskes');

            $s3 = DB::table('master_alasan')
                ->select('kd_alasan', 'nama_alasan');

            $s4 = DB::table('tbl_docs')
                ->select('id_user', 'salinan','jenis_profesi', 'profesi')
                ->where('jenis_doc', 'like', 'STR%');


            $siplama = DB::table('tbl_sip_lama')
                ->select(DB::raw('CONCAT("M_",tbl_sip_lama.id) as id'), 'alamat_pengajuan', 'updated_at', 'isFaskes', 'isApproved', DB::raw('ifnull(s3.nama_alasan,0) as alasan'), 'id_nakes as id_user', DB::raw('"0" as perubahan'), 's0.name', 's0.photo_url', DB::raw('CONCAT("M_",tbl_sip_lama.id) as id_sip'), 'suratpencabutan', DB::raw('"Non Elektronik" as jenis'), 'nama_faskes', DB::raw('ifnull(s3.nama_alasan,0) as nama_alasan'), DB::raw('"1" as isverdinkes'), 'verifdinkes', DB::raw('"1" as siplama'), 's4.jenis_profesi')
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_sip_lama.id_nakes', 's0.id');
                })
                ->leftjoinsub($s3, 's3', function($join){
                    $join->on('tbl_sip_lama.alasan', 's3.kd_alasan');
                })
                ->leftjoinsub($s4, 's4', function($join){
                    $join->on('tbl_sip_lama.id_nakes', 's4.id_user')->on('tbl_sip_lama.salinan', 's4.salinan');
                })
                ->whereIn('isApproved', ['C', 'CF'])
                ->where('suratpencabutan', '<>', '1')
                ->where('verifdinkes', '1');
            

            return DB::table('tbl_pengajuan')
                ->select(DB::raw('tbl_pengajuan.id, tbl_pengajuan.alamat_pengajuan, tbl_pengajuan.updated_at, tbl_pengajuan.isFaskes, tbl_pengajuan.isApproved, tbl_pengajuan.alasan, tbl_pengajuan.id_user, tbl_pengajuan.perubahan, s0.name, s0.photo_url, s1.id_sip, s1.suratpencabutan, "Elektronik" as jenis, s2.nama_faskes, ifnull(s3.nama_alasan,0) as nama_alasan, s1.isverdinkes, s1.verifdinkes'), DB::raw('"0" as siplama'), 's4.jenis_profesi')
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_pengajuan.id_user', 's0.id');
                })
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_pengajuan.id', 's1.id_pengajuan');
                })
                ->leftjoinsub($s2, 's2', function($join){
                    $join->on('tbl_pengajuan.id_faskes', 's2.id_faskes');
                })
                ->leftjoinsub($s3, 's3', function($join){
                    $join->on('tbl_pengajuan.alasan', 's3.kd_alasan');
                })
                ->leftjoinsub($s4, 's4', function($join){
                    $join->on('tbl_pengajuan.id_user', 's4.id_user')->on('tbl_pengajuan.salinan', 's4.salinan');
                })
                ->whereRAW('isApproved in ("C", "CF")')
                ->union($siplama)
                ->where('suratpencabutan', '<>', '1')
                ->orderBy('verifdinkes', 'DESC')
                ->get();

        } else if ($jenis == 'cabutfar')
        {

            $isverdinkes = DB::raw('CASE WHEN (profesi like "%APOTEKER%" OR profesi like "%VOKASI FARMASI%" OR profesi like "%TVK%" OR profesi like "TTK") AND template_id in ("3","4") THEN "1" ELSE "0" END as isverdinkes');

            $jenis = DB::raw('CASE WHEN s1.verifdinkes = 1 THEN "Disetujui" ELSE "Diajukan" END as jenis');

            $s0 = DB::table('users')
            ->select('id', 'name', 'photo_url', 'isActive')
            ->orderBy('id');

            $s1 = DB::table('tbl_sip')
                ->select('id_pengajuan', 'filename_sip', 'id as id_sip', 'suratpencabutan', $isverdinkes, 'verifdinkes', 'profesi as profesi_sip', 'tgl_pencabutan');

            $s2 = DB::table('master_faskes')
                ->select('id_faskes', 'nama_faskes');

            $s3 = DB::table('master_alasan')
                ->select('kd_alasan', 'nama_alasan');

            $sd = DB::table('tbl_docs')
                ->select('id_user', 'id as id_doc', 'jenis_profesi');

            $sf = DB::table('tbl_docs')
                ->select('id_user', 'salinan', 'namafile', 'remark1')
                ->where('jenis_doc', 'like', 'REKOMDOKC%');

            $siplama = DB::table('tbl_sip_lama')
                ->select(DB::raw('CONCAT("M_",tbl_sip_lama.id) as id'), 'alamat_pengajuan', 'updated_at', 's0.name', 's0.photo_url', DB::raw('CONCAT("M_",tbl_sip_lama.id) as id_sip'), 'suratpencabutan', DB::raw('"Aktif" as isActive'), 'nama_faskes', DB::raw('ifnull(s3.nama_alasan,0) as nama_alasan'), DB::raw('"1" as isverdinkes'), 'verifdinkes', DB::raw('CASE WHEN verifdinkes = 1 THEN "Disetujui" ELSE "Diajukan" END as jenis'), 'tgl_pencabutan', DB::raw('"Non Elektronik" as jece'), 'sf.namafile as fileba', 'id_nakes')
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_sip_lama.id_nakes', 's0.id');
                })
                ->leftjoinsub($s3, 's3', function($join){
                    $join->on('tbl_sip_lama.alasan', 's3.kd_alasan');
                })
                ->leftjoinsub($sf, 'sf', function($join){
                    $join->on('tbl_sip_lama.id_nakes', 'sf.id_user')->on('tbl_sip_lama.salinan', 'sf.salinan');
                })
                ->whereIn('isApproved', ['C', 'CF']);
                
            
            return DB::table('tbl_pengajuan')
                ->select(DB::raw('tbl_pengajuan.id, tbl_pengajuan.alamat_pengajuan, tbl_pengajuan.updated_at, s0.name, s0.photo_url, s1.id_sip, s1.suratpencabutan, case when s0.isActive = "0" then "resigned" else "aktif" end as isActive, s2.nama_faskes, ifnull(s3.nama_alasan,0) as nama_alasan, s1.isverdinkes, s1.verifdinkes'), $jenis, 's1.tgl_pencabutan', DB::raw('"Elektronik" as jece'), 'sf.namafile as fileba', 'tbl_pengajuan.id_user as id_nakes')
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_pengajuan.id_user', 's0.id');
                })
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_pengajuan.id', 's1.id_pengajuan');
                })
                ->leftjoinsub($s2, 's2', function($join){
                    $join->on('tbl_pengajuan.id_faskes', 's2.id_faskes');
                })
                ->leftjoinsub($s3, 's3', function($join){
                    $join->on('tbl_pengajuan.alasan', 's3.kd_alasan');
                })
                ->leftjoinsub($sd, 'sd', function($join){
                    $join->on('tbl_pengajuan.id_user', 'sd.id_user')->on('tbl_pengajuan.id_doc', 'sd.id_doc');
                })
                ->leftjoinsub($sf, 'sf', function($join){
                    $join->on('tbl_pengajuan.id_user', 'sf.id_user')->on('tbl_pengajuan.salinan', 'sf.salinan')->on('s1.id_sip', 'sf.remark1');
                })
                ->whereIn('isApproved', ['C', 'CF'])
                ->whereIn('template_id', ['3', '4'])
                //->whereRAW('(s1.profesi_sip like "%APOTEKER%" OR s1.profesi_sip like "%VOKASI%")')
                ->whereIn('sd.jenis_profesi', ['APJ', 'TVK', 'TTK'])
                ->union($siplama)
                ->get();

        } else if ($jenis == 'verif') {

            $s0 = DB::table('users')
            ->select('id', 'name', 'photo_url', 'isActive')
            ->orderBy('id');

            $s1 = DB::table('tbl_sip')
                ->select('id_pengajuan', 'filename_sip', 'perubahan', 'id as id_sip');

            $s2 = DB::table('master_faskes')
                ->select('id_faskes', 'nama_faskes');

            $s3 = DB::table('master_alasan')
                ->select('kd_alasan', 'nama_alasan');
            

            return DB::table('tbl_pengajuan')
                ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.id_sip, case when s0.isActive = "0" then "resigned" else "aktif" end as isActive, s2.nama_faskes, ifnull(s3.nama_alasan,0) as nama_alasan'))
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_pengajuan.id_user', 's0.id');
                })
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_pengajuan.id', 's1.id_pengajuan')->on('tbl_pengajuan.perubahan', 's1.perubahan');
                })
                ->leftjoinsub($s2, 's2', function($join){
                    $join->on('tbl_pengajuan.id_faskes', 's2.id_faskes');
                })
                ->leftjoinsub($s3, 's3', function($join){
                    $join->on('tbl_pengajuan.alasan', 's3.kd_alasan');
                })
                ->where('isApproved', '3')
                ->where('isverif', '0')
                ->orderby('tbl_pengajuan.updated_at', 'desc')
                ->get();

        } else if ($jenis == 'kadin') {

            $s0 = DB::table('users')
            ->select('id', 'name', 'photo_url', 'isActive')
            ->orderBy('id');

            $s1 = DB::table('tbl_sip')
                ->select('id_pengajuan', 'filename_sip', 'perubahan', 'id as id_sip');

            $s2 = DB::table('master_faskes')
                ->select('id_faskes', 'nama_faskes');

            $s3 = DB::table('master_alasan')
                ->select('kd_alasan', 'nama_alasan');


            
            

            return DB::table('tbl_pengajuan')
                ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.id_sip, case when s0.isActive = "0" then "resigned" else "aktif" end as isActive, s2.nama_faskes, ifnull(s3.nama_alasan,0) as nama_alasan'))
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_pengajuan.id_user', 's0.id');
                })
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_pengajuan.id', 's1.id_pengajuan')->on('tbl_pengajuan.perubahan', 's1.perubahan');
                })
                ->leftjoinsub($s2, 's2', function($join){
                    $join->on('tbl_pengajuan.id_faskes', 's2.id_faskes');
                })
                ->leftjoinsub($s3, 's3', function($join){
                    $join->on('tbl_pengajuan.alasan', 's3.kd_alasan');
                })
                ->where('isApproved', '3')
                ->where('isverif', '1')
                ->orderby('tbl_pengajuan.updated_at', 'desc')
                ->get();

        } else if($jenis = 'kadincabut') {

            $s0 = DB::table('users')
            ->select('id', 'name', 'photo_url', 'isActive')
            ->orderBy('id');

            $s1 = DB::table('tbl_sip')
                ->select('id_pengajuan', 'filename_sip', 'id as id_sip', 'suratpencabutan');

            $s2 = DB::table('master_faskes')
                ->select('id_faskes', 'nama_faskes');

            $s3 = DB::table('master_alasan')
                ->select('kd_alasan', 'nama_alasan');

            $siplama = DB::table('tbl_sip_lama')
                ->select(DB::raw('CONCAT("M",tbl_sip_lama.id) as id'), 'alamat_pengajuan', 'isApproved', 'updated_at', 'isFaskes', 'alasan_lain as alasan', 's0.name', 's0.photo_url', DB::raw('CONCAT("M_",tbl_sip_lama.id) as id_sip'),'suratpencabutan', DB::raw('"Aktif" as isActive'),'nama_faskes',  DB::raw('ifnull(s3.nama_alasan,0) as nama_alasan'),DB::raw('"1" as siplama, "Non Elektronik" as jenis'))
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_sip_lama.id_nakes', 's0.id');
                })
                ->leftjoinsub($s3, 's3', function($join){
                    $join->on('tbl_sip_lama.alasan', 's3.kd_alasan');
                })
                ->whereIn('isApproved', ['C', 'CF'])
                ->where('suratpencabutan', 'A');
            

            return DB::table('tbl_pengajuan')
                ->select(DB::raw('tbl_pengajuan.id, tbl_pengajuan.alamat_pengajuan, tbl_pengajuan.isApproved, tbl_pengajuan.updated_at, tbl_pengajuan.isFaskes, tbl_pengajuan.alasan, s0.name, s0.photo_url, s1.id_sip, s1.suratpencabutan, case when s0.isActive = "0" then "resigned" else "aktif" end as isActive, s2.nama_faskes, ifnull(s3.nama_alasan,"0") as nama_alasan, "0" as siplama, "Eleketronik" as jenis'))
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_pengajuan.id_user', 's0.id');
                })
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_pengajuan.id', 's1.id_pengajuan');
                })
                ->leftjoinsub($s2, 's2', function($join){
                    $join->on('tbl_pengajuan.id_faskes', 's2.id_faskes');
                })
                ->leftjoinsub($s3, 's3', function($join){
                    $join->on('tbl_pengajuan.alasan', 's3.kd_alasan');
                })
                ->whereRAW('isApproved in ("C", "CF")')
                ->where('suratpencabutan', 'A')
                ->union($siplama)
                //->orderby('tbl_pengajuan.updated_at', 'desc')
                ->get();

        } else {

            return DB::table('tbl_pengajuan')
                ->where('isApproved', 'C')
                ->count();

        }

        


    }


    public function getpendaftar($status) {

        return DB::table('tbl_pendaftaran')
            ->where('current_status', $status)
            ->where('current_status', '<>', '9')
            ->get();


    }

    public function getpendaftarop() {

 
        return DB::table('tbl_pendaftaran')
            ->get();


    }


    public function createUserNakes($username, $password, $role, $name, $foto, $foto_not_avail){

        $id_user = DB::table('users')
            ->insertGetId([
                "name" => $name,
                "username" => $username,
                'role' => $role,
                'password' => Hash::make($password),
                'remember_token' => Str::random(7),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'isActive' => '1',
                'photo_url' => $foto,
                'foto_not_avail' => $foto_not_avail
            ]);


        return $id_user;


    }

    public function updatePendaftaran($id_user, $id_pendaftar, $password, $updater, $doc_status, $pendaftar_status) {


        $updateDetails = [
            'updater' => $updater,
            'doc_status' => $doc_status,
            'default_pass' => $password,
            'id_user' => $id_user,
            'current_status' => $pendaftar_status
        ];

        DB::table('tbl_pendaftaran')
            ->where('id', $id_pendaftar)
            ->update($updateDetails);

        

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

    public function setToDokumen($id_user, $jenis, $id_pendaftar) {

        $query = DB::table('tbl_pendaftaran')
            ->select('origin_file', 'salinan', 'str_hingga', 'no_reg', 'url_qr', 'kompetensi', 'profesi', 'tgl_keluar_str', 'template_id', 'jenis_profesi', 'str_hingga_origin', 'universitas', 'fixed_berlaku_hingga')
            ->where('id', $id_pendaftar)
            ->first();

        if($query) {
            $namafile = $query->origin_file;
            $salinan = $query->salinan;
            $tgl_berlaku = $query->str_hingga;
            $no_doc = $query->no_reg;
            $url_qr = $query->url_qr;
            $kompetensi = $query->kompetensi;
            $profesi = $query->profesi;
            $tgl_keluar_str = $query->tgl_keluar_str;
            $jenis_profesi = $query->jenis_profesi;
            $template_id = $query->template_id;
            $tgl_doc_origin = $query->str_hingga_origin;
            $universitas = $query->universitas;
            $fixed_berlaku_hingga = $query->fixed_berlaku_hingga;

        } 
        
        $selisih = '-';
        if($fixed_berlaku_hingga != '0') {
            $tgl_berlaku_ = $fixed_berlaku_hingga;
        } else {
            $tgl_berlaku_ = $tgl_berlaku;
        }
        
        $getselisih = DB::select(DB::raw('call selisihexpire("'.$tgl_berlaku.'")'));
        if($getselisih) {
            $selisih = $getselisih[0]->selisihhari;
        } 
        

        if ($template_id == '1') {
            if (Str::contains(strtoupper($kompetensi), 'FISIKAWAN')) {
                $banyaknya = ['1', '2', '3'];
            } else {
                $banyaknya = ['1', '2'];
            }
            
        } else {
            $banyaknya = ['1', '2', '3'];
        }

        $bypassing = '0';

        if (!empty($url_qr)) {
            $lastCharacter = substr($url_qr, -1);
            if($lastCharacter == 'p' || $lastCharacter == 'b' || $lastCharacter == '0' || $lastCharacter == 'K') {
                $bypassing = '1';
            }
        }

        foreach ($banyaknya as $salsal) {

            if($salsal != $salinan) {
                $kadaluarsa = 'i';
            } else {
                $kadaluarsa = 0;
            }

            DB::table('tbl_docs')
            ->insert([
                'id_user' => $id_user,
                'jenis_doc' => 'STR'.$salsal,
                'nama_doc' => 'STR'.$salsal,
                'namafile' => $namafile,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'tgl_doc' => $tgl_berlaku,
                'tgl_berlaku' => $tgl_keluar_str,
                'tgl_doc_origin' => $tgl_doc_origin,
                'no_doc' => $no_doc,
                'expiring_count' => $selisih,
                'kadaluarsa' => $kadaluarsa,
                'kompetensi' => $kompetensi,
                'profesi' => $profesi,
                'isDaftar' => '1',
                'salinan' => $salsal,
                'updater' => $id_user,
                'url_qr' => $url_qr,
                'jenis_profesi' => $jenis_profesi,
                'template_id' => $template_id,
                'remark1' => 'STR dari pendaftaran',
                'remark2' => $universitas,
                'remark3' => $bypassing,
                'fixed_berlaku_hingga' => $fixed_berlaku_hingga

            ]);

        }

        return true;
    }


    public function setToDokumenUploadUlang($id_user, $jenis, $id_pendaftar) {

        $query = DB::table('tbl_pendaftaran')
            ->select('origin_file', 'salinan', 'str_hingga', 'no_reg', 'url_qr', 'kompetensi', 'profesi', 'tgl_keluar_str', 'template_id', 'jenis_profesi', 'str_hingga_origin', 'universitas', 'fixed_berlaku_hingga')
            ->where('id', $id_pendaftar)
            ->first();

        if($query) {
            $namafile = $query->origin_file;
            $salinan = $query->salinan;
            $tgl_berlaku = $query->str_hingga;
            $no_doc = $query->no_reg;
            $url_qr = $query->url_qr;
            $kompetensi = $query->kompetensi;
            $profesi = $query->profesi;
            $tgl_keluar_str = $query->tgl_keluar_str;
            $jenis_profesi = $query->jenis_profesi;
            $template_id = $query->template_id;
            $tgl_doc_origin = $query->str_hingga_origin;
            $universitas = $query->universitas;
            $fixed_berlaku_hingga = $query->fixed_berlaku_hingga;

        } 
        
        $selisih = '-';
        if($fixed_berlaku_hingga != '0') {
            $tgl_berlaku_ = $fixed_berlaku_hingga;
        } else {
            $tgl_berlaku_ = $tgl_berlaku;
        }
        

        $getselisih = DB::select(DB::raw('call selisihexpire("'.$tgl_berlaku.'")'));
        if($getselisih) {
            $selisih = $getselisih[0]->selisihhari;
        } 
        

        if ($template_id == '1') {
            if (Str::contains(strtoupper($kompetensi), 'FISIKAWAN')) {
                $banyaknya = ['1', '2', '3'];
            } else {
                $banyaknya = ['1', '2'];
            }
            
        } else {
            $banyaknya = ['1', '2', '3'];
        }

        $bypassing = '0';

        if (!empty($url_qr)) {
            $lastCharacter = substr($url_qr, -1);
            if($lastCharacter == 'p' || $lastCharacter == 'b' || $lastCharacter == '0' || $lastCharacter == 'K') {
                $bypassing = '1';
            }
        }

        foreach ($banyaknya as $salsal) {

            if($salsal != $salinan) {
                $kadaluarsa = 'i';
                $is_compromised = '0';
                $keterangan_tolak = null;
            } else {
                $kadaluarsa = 0;
                $is_compromised = '1';
                $keterangan_tolak = 'Upload Ulang STR Dengan Kualitas PDF yang lebih baik';

            }

            DB::table('tbl_docs')
            ->insert([
                'id_user' => $id_user,
                'jenis_doc' => 'STR'.$salsal,
                'nama_doc' => 'STR'.$salsal,
                'namafile' => $namafile,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'tgl_doc' => $tgl_berlaku,
                'tgl_berlaku' => $tgl_keluar_str,
                'tgl_doc_origin' => $tgl_doc_origin,
                'no_doc' => $no_doc,
                'expiring_count' => $selisih,
                'kadaluarsa' => $kadaluarsa,
                'kompetensi' => $kompetensi,
                'profesi' => $profesi,
                'isDaftar' => '1',
                'salinan' => $salsal,
                'updater' => $id_user,
                'url_qr' => $url_qr,
                'jenis_profesi' => $jenis_profesi,
                'template_id' => $template_id,
                'remark1' => 'STR dari pendaftaran',
                'remark2' => $universitas,
                'remark3' => $bypassing,
                'fixed_berlaku_hingga' => $fixed_berlaku_hingga,
                'is_compromised' => $is_compromised,
                'keterangan_tolak' => $keterangan_tolak

            ]);

        }

        return true;
    }

    public function updatesavedphoto($id_user, $fotoname) {

        return DB::table('users')
            ->where('id', $id_user)
            ->update(['saved_photo' => $fotoname]);

    }

    public function isDraftExists($id_pengajuan, $perubahan) {

        $getSem = DB::table('tbl_pengajuan')
            ->select('perpanjangan', 'isperpanjangan')
            ->where('id', $id_pengajuan)
            ->first();

        $isSementara = $getSem->perpanjangan;
        $isperpanjangan = $getSem->isperpanjangan;

        if ($isSementara != 'S') {

            DB::table('tbl_sip')
                ->where('id_pengajuan', $id_pengajuan)
                ->where('perubahan', $perubahan)
                ->whereNotIn('status_sip', ['P', '1','CF'])
                ->delete();

            return DB::table('tbl_sip')
                ->where('id_pengajuan', $id_pengajuan)
                ->where('perubahan', $perubahan)
                ->where('status_sip', '<>', 'P')
                ->get();

        } else {

            if($isperpanjangan == '1' || $isperpanjangan == 'D') {

                DB::table('tbl_sip')
                    ->where('id_pengajuan', $id_pengajuan)
                    ->where('perubahan', $perubahan)
                    ->whereNotIn('status_sip', ['P', '1','CF'])
                    ->where('jadwal_praktek', $isSementara)
                    ->delete();

                return DB::table('tbl_sip')
                    ->where('id_pengajuan', $id_pengajuan)
                    ->where('perubahan', $perubahan)
                    ->where('status_sip', '<>', 'P')
                    ->where('jadwal_praktek', $isSementara)
                    ->get();

            } else {

                DB::table('tbl_sip')
                    ->where('id_pengajuan', $id_pengajuan)
                    ->where('perubahan', $perubahan)
                    ->whereNotIn('status_sip', ['P', '1','CF'])
                    ->where('jadwal_praktek', 'S')
                    ->delete();

                return DB::table('tbl_sip')
                    ->where('id_pengajuan', $id_pengajuan)
                    ->where('perubahan', $perubahan)
                    ->where('status_sip', '<>', 'P')
                    ->where('jadwal_praktek', 'S')
                    ->get();
            }
            
        }

        
    }

    public function getfilenamesurat($id_pengajuan) {
        $namasuratfile = '';
        $getnama = DB::table('tbl_sip')
            ->where('id_pengajuan', $id_pengajuan)
            ->whereNotIn('status_sip',['P','E','CF'])
            ->first();
        
        if ($getnama) {
            $namasuratfile = $getnama->filename_sip;
        }
        return $namasuratfile;
    }


    public function draftingSip($id_pengajuan, $nip_tte, $isplt, $nama_tte, $pangkat_tte, $id_template, $selectedfixed) {

        $qID = DB::table('tbl_pengajuan')
            ->select('id_user','id_doc', 'salinan', 'isFaskes', 'id_faskes', 'alamat_pengajuan', 'kecamatan', 'kabupaten', 'jadwal_praktek', 'tgl_approval_dinkes', 'perubahan', 'perpanjangan', 'remark', 'isperpanjangan')
            ->where('id', $id_pengajuan)
            ->first();
        
        $id_user = $qID->id_user;
        $id_nakes = $qID->id_user;
        $salinan = $qID->salinan;
        $isFaskes = $qID->isFaskes;
        $id_faskes = $qID->id_faskes;
        $strke = 'STR'.$salinan;
        //$jadwal_praktek = $qID->jadwal_praktek;
        $tgl_rekomdinkes = $qID->tgl_approval_dinkes;
        $perubahan = $qID->perubahan;
        $jadwal_praktek = $qID->perpanjangan;
        $id_doc = $qID->id_doc;
        $subspesialis = $qID->remark;
        $global_until = '0';
        $isperpanjangan = $qID->isperpanjangan;

        
        $salinan_terbilang = '';
        if ($salinan == 1) {
            $salinan_terbilang = 'Satu';
        } else if ($salinan == 2) {
            $salinan_terbilang = 'Dua';
        } else if ($salinan == 3) {
            $salinan_terbilang = 'Tiga';
        }

        
        $nama_lokasi = $qID->alamat_pengajuan;
        $kab_lokasi = $qID->kabupaten;
        $kec_lokasi = $qID->kecamatan;

        if($isFaskes){
            $getalamat = DB::table('master_faskes')
            ->select('alamat_faskes', 'kecamatan_faskes', 'kabupaten_faskes')
            ->where('id_faskes', $id_faskes)
            ->first();
            if($getalamat) {
                $nama_lokasi = $getalamat->alamat_faskes;
                $kab_lokasi = $getalamat->kabupaten_faskes;
                $kec_lokasi = $getalamat->kecamatan_faskes;
            }
        }

        $qfoto = DB::table('users')
            ->select('saved_photo')
            ->where('id', $id_nakes)
            ->first();
        $foto_nakes = $qfoto->saved_photo;
        

        $qnostr = DB::table('tbl_docs')
            ->select('no_doc', 'tgl_doc', 'tgl_berlaku', 'kompetensi', 'profesi', 'jenis_profesi', 'template_id', 'fixed_berlaku_hingga', DB::raw('ifnull(remark5,0) as global_until'))
            ->where('jenis_doc', $strke)
            ->where('id_user', $id_user)
            ->where('kadaluarsa', '=', '0')
            ->first();

        if($qnostr) {
            $global_until = $qnostr->global_until;
        }
            
        
        $no_str = $qnostr->no_doc;
        //$valid_until_ = $qnostr->tgl_doc;
        $valid_until_ = '29 Februari 2999';
        $currentDate = Carbon::now();
        if($qnostr->tgl_doc != 'Seumur Hidup') {
            
            $valid_until_fn = $qnostr->tgl_doc;
            $valid_until_ = $qnostr->tgl_doc;

            /// if they upload str lama

            // if($global_until == '0' || $global_until == '29 Februari 2999') {
            //     $valid_until_fn = $qnostr->tgl_doc;
            //     $valid_until_ = $qnostr->tgl_doc;
            // } else {
            //     $valid_until_ = $global_until;
            // }
            
        } else {
            
            $valid_until_fn = Carbon::now()->addYears(5)->format('Y-m-d');
            if($global_until == '0' || $global_until == '29 Februari 2999') {
                $valid_until_ = $this->tgl_indo_sip($valid_until_fn);
            } else {
                if($isperpanjangan == '1' || $isperpanjangan == 'D') {
                    $valid_until_fn = Carbon::now()->addYears(5)->format('Y-m-d');
                    $valid_until_ = $this->tgl_indo_sip($valid_until_fn);
                } else {
                    $valid_until_ = $global_until;
                }
            }
        }
        
        $tgl_str = $qnostr->tgl_berlaku;
        if($qnostr->template_id == '2') {
            if ($subspesialis == '0') {
                $kompetensi = $qnostr->kompetensi;
            } else if ($subspesialis == null) {
                $kompetensi = $qnostr->kompetensi;
            } else {
                $kompetensi = $subspesialis;
            }
        } else {
            $kompetensi = $qnostr->kompetensi;
        }
    

        $profesi = strtoupper($qnostr->profesi);
        if($profesi == 'APOTEKER') {
            $profesi = 'Apoteker Praktik';
            if($qnostr->template_id == '4') {
                $profesi = 'Apoteker';
            }
        } else {
            $profesi = ucwords($profesi);
            if($qnostr->template_id == '4') {
                $profesi = 'TVK';
            }
        }
        $jenisprofesi = $qnostr->jenis_profesi;
        $templatedaristr = $qnostr->template_id;

        if ($selectedfixed == '2') {

            if (Str::contains(strtoupper($kompetensi), 'BIDAN')) {
                $valid_until = '26 Maret 2026';
            } else {
                $valid_until = '12 Agustus 2026';
            }

        } else if ($selectedfixed == '31') {
            $valid_until = '31 Desember 2024';
        } else {
            $valid_until = $valid_until_;
        }
        

        //make call for this
        $is_plt = $isplt;
        //$nama_tte = 'NAMA TTE';
        //$pangkat_tte = 'PANGKAT TTE';
        $nip = $nip_tte;
        //make call for this
        $nostrfl = str_replace("/","_",preg_replace('/\s+/', '', $no_str));
        $tglstrfl = preg_replace('/\s+/', '', $valid_until_fn);
        
        if ($jadwal_praktek == 'S') {
            $filename_sip = $id_user.'_'.$id_pengajuan.'_'.$salinan.'_'.$nostrfl.'_'.$tglstrfl.'_'.$perubahan.'_S';
        } else {
            $filename_sip = $id_user.'_'.$id_pengajuan.'_'.$salinan.'_'.$nostrfl.'_'.$tglstrfl.'_'.$perubahan.'_'.$jadwal_praktek;
        }
        
        $status_sip = '0';
        $template_id = 'nakes'.$id_template;
        $jenisrekom = 'REKOMDK'.$salinan;
        $jenisprof = 'REKOMP'.$salinan;
        
        // $qrekomdk = DB::table('tbl_docs')
        //     ->select('no_doc', 'tgl_doc')
        //     ->where('jenis_doc', $jenisrekom)
        //     ->where('id_user', $id_user)
        //     ->where('kadaluarsa', '=', '0')
        //     ->first();
        
        $no_rekomdinkes = '-';
        


        // $qrkp = DB::table('tbl_docs')
        //     ->select('no_doc', 'tgl_doc')
        //     ->where('jenis_doc', $jenisprof)
        //     ->where('id_user', $id_user)
        //     ->where('kadaluarsa', '=', '0')
        //     ->first();
        
        // $no_rekomp = $qrkp->no_doc;
        // $tgl_rekomp = $qrkp->tgl_doc;
        $no_rekomp = '-';
        $tgl_rekomp = '-';

        $qktp = DB::table('tbl_docs')
            ->select('no_doc', 'nama_doc','tgl_doc', 'tgl_doc_origin', 'no_doc', 'remark1', 'remark2', 'remark3', 'remark4', 'jenis_profesi', 'template_id')
            ->where('jenis_doc', 'KTP')
            ->where('id_user', $id_user)
            ->where('kadaluarsa', '=', '0')
            ->first();
        $nama_nakes = $qktp->nama_doc;
        $ttl_nakes = $qktp->remark4.', '.$qktp->tgl_doc;
        $remark2 = $qktp->remark2;
        $remark3 = $qktp->remark3;
        $remark1 = $qktp->remark1;
        $alamat_nakes = $remark1.', Kecamatan '.$remark2.' '.$remark3;
        $formatedtgl = $qktp->jenis_profesi;

        $qenv = DB::table('tbl_env')
            ->select('env')
            ->first();
        $env = $qenv->env;    

        $qnf = DB::table('master_faskes')
            ->select('nama_faskes')
            ->where('id_faskes', $id_faskes)
            ->first();
        $nama_faskes = '';
        if($qnf) {
            $nama_faskes = $qnf->nama_faskes;
        }

        if($templatedaristr == '2') {
            $jenisprofdraft = $jenisprofesi;
            $no_surat = '3301/53212/'.$jenisprofdraft.'/'.$salinan.'/449.1/XXXXX/24/CLP';
        } else if($templatedaristr == '3' || $templatedaristr == '4') {
            
            if (!preg_match('/^\d{8}$/', $formatedtgl)) {
                $formatedtgl = str_replace('-', '', $qktp->tgl_doc_origin);
            }
            $jenisprofdraft = $formatedtgl;
            $no_surat = ''.$jenisprofdraft.'/449.1/'.$salinan.'/XXXXX/24/CLP';
        } else {
            $jenisprofdraft = $jenisprofesi;
            $no_surat = '449.1/'.$jenisprofdraft.'/XXXXX/24/CLP';
        }


        //DB::table('tbl_sip')->where('id_pengajuan', $id_pengajuan)->delete();

        return DB::table('tbl_sip')
            ->insert([
                'id_pengajuan' => $id_pengajuan,
                'id_doc' => $id_doc,
                'id_nakes' => $id_nakes,
                'salinan' => $salinan,
                'no_rekomdinkes' => $no_rekomdinkes,
                'tgl_rekomdinkes' => $tgl_rekomdinkes,
                'no_rekomp' => $no_rekomp,
                'tgl_rekomp' => $tgl_rekomp,
                'nama_nakes' => $nama_nakes,
                'ttl_nakes' => $ttl_nakes,
                'alamat_nakes' => $alamat_nakes,
                'kompetensi' => $kompetensi,
                'profesi' => $profesi,
                'foto_nakes' => $foto_nakes,
                'no_str' => $no_str,
                'tgl_berlaku' => $tgl_str,
                'tgl_doc' => $valid_until,
                'salinan_terbilang' => $salinan_terbilang,
                'nama_faskes' => $nama_faskes,
                'nama_lokasi' => $nama_lokasi,
                'kec_lokasi' => $kec_lokasi,
                'kab_lokasi' => $kab_lokasi,
                'jadwal_praktek' => $jadwal_praktek,
                'no_surat' => $no_surat,
                'tgl_surat' => date('Y-m-d'),
                'is_plt' => $is_plt,
                'nama_tte' => $nama_tte,
                'pangkat_tte' => $pangkat_tte,
                'nip_tte' => $nip_tte,
                'filename_sip' => $filename_sip,
                'status_sip' => $status_sip,
                'template_id' => $id_template,
                'jenis_profesi' => $jenisprofdraft,
                'perubahan' => $perubahan,
                'env' =>  $env
            ]);

    }

    public function getenv(){
        $getenv = DB::table('tbl_env')
            ->first();
        $env = $getenv->env;
        return $env;

    }

    public function getdraftsip($id_pengajuan){

        $s1 = DB::table('tbl_pengajuan')
                ->select('id as id_peng', 'ukuran');

        return DB::table('tbl_sip')
            ->select('tbl_sip.*', 's1.ukuran')
            ->leftjoinsub($s1, 's1', function($join){
                $join->on('tbl_sip.id_pengajuan', 's1.id_peng');
            })
            ->where ('id_pengajuan', $id_pengajuan)
            ->whereRAW('status_sip not in ("1", "P", "E", "CF")')
            ->first();

    }

    public function updatesipstatus($id_pengajuan, $updater, $isverif) {

        $updated_at = date('Y-m-d H:i:s');
        if($isverif == '1') {

            return DB::table('tbl_pengajuan')
            ->where('id', $id_pengajuan)
            ->update(['isApproved' => 3, 'isverif' => '1', 'updated_at' => $updated_at, 'updater' => $updater]);

        } else {

            return DB::table('tbl_pengajuan')
            ->where('id', $id_pengajuan)
            ->update(['isApproved' => 3, 'updated_at' => $updated_at, 'updater' => $updater]);
        }
        
    }

    public function getfotostr($id_pengajuan) {

        if (Str::contains($id_pengajuan, 'M_'))
        {
            $idsiplama = Str::replace('M_', '', $id_pengajuan);
            $getID = DB::table('tbl_sip_lama')
                ->select('id_nakes as id_user')
                ->where('id', $idsiplama)
                ->first();
        } else {

            $getID = DB::table('tbl_pengajuan')
                ->select('id_user')
                ->where('id', $id_pengajuan)
                ->first();

        }

        

        $iduser = $getID->id_user;

        $getfoto = DB::table('users')
            ->select('saved_photo')
            ->where('id', $iduser)
            ->first();

        $savedphoto = $getfoto->saved_photo;
        return $savedphoto;
    }

    public function getexistingtemplate($id_pengajuan, $perubahan) {
        $qtem = DB::table('tbl_sip')
            ->select('template_id')
            ->where('id_pengajuan', $id_pengajuan)
            ->where('perubahan', $perubahan)
            ->first();
        
        $templateid = $qtem->template_id;
        return $templateid;
            
    }

    public function gettemplateidsip($filename_sip){
        $template_id = '1';
        $qtem = DB::table('tbl_sip')
            ->select('template_id')
            ->where('filename_sip', $filename_sip)
            ->first();
        if($qtem) {
            $template_id = $qtem->template_id;
        }
        return $template_id;
    }

    public function updatetemplateid($id_pengajuan, $template_id, $perubahan){
        
        return DB::table('tbl_sip')
            ->where('id_pengajuan', $id_pengajuan)
            ->where('perubahan', $perubahan)
            ->update(['template_id' => $template_id]);
        
        
    }

    public function updatestatussip($id_pengajuan, $filename_sip, $detailjadwal, $no_surat, $signed_date) {

        $iscabut = substr($filename_sip, 0, 1);
        $perpanjangan = 0;
        if($iscabut == 'C') {

            if (Str::contains($id_pengajuan, 'M_'))
            {
                $idsiplama = Str::replace('M_', '', $id_pengajuan);

                return DB::table('tbl_sip_lama')
                    ->where('filename_pencabutan', $filename_sip)
                    ->where('status_sip', 'CF')
                    ->update([
                        'suratpencabutan' => '1',
                        'no_surat_pencabutan' => $no_surat,
                        'tgl_tte_pencabutan' => $signed_date,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

            } else {

                return DB::table('tbl_sip')
                    ->where('filename_pencabutan', $filename_sip)
                    ->where('status_sip', 'CF')
                    ->update([
                        'suratpencabutan' => '1',
                        'no_surat_pencabutan' => $no_surat,
                        'tgl_tte_pencabutan' => $signed_date,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
            }

        } else {

            $tgl_doc_sip = '29 Februari 2999';
            $gettgldoc = DB::table('tbl_sip')
                ->select('tgl_doc')
                ->where('filename_sip', $filename_sip)
                ->where('id_pengajuan', $id_pengajuan)
                ->first();

            $now = date('Y-m-d H:i:s');

            $getdetailing = DB::table('tbl_pengajuan')
                ->select('id_user', 'salinan', 'perubahan', 'id_doc', 'perpanjangan', 'isperpanjangan')
                ->where('id', $id_pengajuan)
                ->first();

            $id_user = $getdetailing->id_user;
            $salinan = $getdetailing->salinan;
            $perubahan = $getdetailing->perubahan;
            $id_doc = $getdetailing->id_doc;
            $perpanjangan = $getdetailing->perpanjangan;
            $isperpanjangan = $getdetailing->isperpanjangan;

            $getskip = DB::table('tbl_docs')
                ->select(DB::raw('ifnull(url_qr,"") as url_qr'),'remark3', DB::raw('ifnull(remark5,0) as remark5'))
                ->where('id_user', $id_user)
                ->where('id', $id_doc)
                ->first();
            
            $isskip = $getskip->remark3;
            if(substr($getskip->url_qr, -1) == '0' || substr($getskip->url_qr, -1) == 'p') {
                $isskip = '1';
            }
            $isfirst = $getskip->remark5;
            
            if($gettgldoc) {
                $tgl_doc_sip = $gettgldoc->tgl_doc;
            }

            if($tgl_doc_sip === '29 Februari 2999' && ($isfirst == '0' || $isfirst == '29 Februari 2999')) {
                $tgl_sampai = substr($signed_date, 0, 10);
                $converted_sampai = $this->tambahLimaTahunDanKurangkanSatuHari($tgl_sampai);
                $valid_until = $this->tgl_indo_sip($converted_sampai);
            } else {
                $tgl_sampai = $tgl_doc_sip;
                $converted_sampai = $tgl_doc_sip;
                $valid_until = $tgl_doc_sip;
            }

            // $tgl_sampai = $tgl_doc_sip;
            // $converted_sampai = $tgl_doc_sip;
            // $valid_until = $tgl_doc_sip;

            
            $selisih = '-';
            $getselisih = DB::select(DB::raw('call selisihexpire("'.$valid_until.'")'));
            if($getselisih) {
                $selisih = $getselisih[0]->selisihhari;
            }
            
            DB::table('tbl_sip')
                ->where('filename_sip', $filename_sip)
                ->where('perubahan', $perubahan)
                ->update(['status_sip' => 1, 'signed_date' => $signed_date, 'no_surat' => $no_surat, 'valid_until' => $valid_until, 'expiring_count' => $selisih]);

            DB::table('tbl_docs')
                ->where('id_user', $id_user)
                ->where('jenis_doc', 'like', 'STR%')
                ->update([
                    'remark5' => $valid_until,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            if($isperpanjangan == '1' || $isperpanjangan == 'D') {

                DB::table('tbl_sip')
                    ->where('id_nakes', $id_user)
                    ->where('salinan', $salinan)
                    ->where('status_sip', 'E')
                    ->delete();

                DB::table('tbl_pengajuan')
                    ->where('id', $id_pengajuan)
                    ->update(['due_date' => $valid_until, 'updated_at' => $now, 'isperpanjangan' => 'D']);

            } else {

                if($perubahan > 0) {

                    DB::table('tbl_sip')
                        ->where('filename_sip', $filename_sip)
                        ->where('perubahan','<>', $perubahan)
                        ->update(['status_sip' => 'R']);
                }

            }

            
            
            if($isskip == '1') {

                DB::table('tbl_pengajuan')
                ->where('id', $id_pengajuan)
                ->update(['isApproved' => 4, 'tracker' => 'Surat Disetujui DPMPTSP', 'updated_at' => $now, 'ditahan' => '1', 'lokasi_disimpan' => 'Rak Virtual']);


            } else {

                DB::table('tbl_pengajuan')
                ->where('id', $id_pengajuan)
                ->update(['isApproved' => 4, 'tracker' => 'Surat Disetujui DPMPTSP', 'updated_at' => $now]);

            }

            
            DB::table('approved_jadwal')
                ->insert([
                    'id_user' => $id_user,
                    'id_pengajuan' => $id_pengajuan,
                    'id_doc' => $id_doc,
                    'salinan' => $salinan,
                    'perubahan' => $perubahan,
                    'detail_jadwal' => $detailjadwal,
                    'updated_at' => $now
                ]);

            return true;

        }
        
        
    }

    
    public function updatestatussipdinkes($data) {

        $signed_date = $data['signed_date'];
        $no_surat = $data['no_surat'];
        $filename_sip = $data['filename_sip'];
        $id_pengajuan = $data['id_pengajuan'];

        $tgl_doc_sip = '29 Februari 2999';

        if($tgl_doc_sip === '29 Februari 2999') {
            $tgl_sampai = substr($signed_date, 0, 10);
            $converted_sampai = $this->tambahLimaTahunDanKurangkanSatuHari($tgl_sampai);
            $valid_until = $this->tgl_indo_sip($converted_sampai);
        } else {
            $tgl_sampai = $tgl_doc_sip;
            $converted_sampai = $tgl_doc_sip;
            $valid_until = $tgl_doc_sip;
        }

        
        $selisih = '-';
        $getselisih = DB::select(DB::raw('call selisihexpire("'.$valid_until.'")'));
        if($getselisih) {
            $selisih = $getselisih[0]->selisihhari;
        }
        

        $now = date('Y-m-d H:i:s');
        
        
        DB::table('tbl_sk_dinkes')
            ->where('filename_sk', $filename_sip)
            ->update(['status_sk' => 1, 'signed_date' => $signed_date, 'no_surat' => $no_surat, 'valid_until' => $valid_until]);
        

        DB::table('tbl_pengajuan')
            ->where('id', $id_pengajuan)
            ->update(['isApproved' => 2, 'tgl_approval_dinkes' => $now, 'tracker' => 'Surat Disetujui Kepala Dinas Kesehatan', 'updated_at' => $now]);

        return true;
        
    }

    public function getsalinansip($id_pengajuan) {

        if (Str::contains($id_pengajuan, 'M_'))
        {
            $idsiplama = Str::replace('M_', '', $id_pengajuan);

            $getsalin = DB::table('tbl_sip_lama')
                ->select('salinan')
                ->where('id', $idsiplama)
                ->first();

        } else {

            $getsalin = DB::table('tbl_pengajuan')
                ->select('salinan')
                ->where('id', $id_pengajuan)
                ->first();

        }
        

        $salinan = $getsalin->salinan;
        return $salinan;
    }

    public function getfotonakes($id_pengajuan) {

        if (Str::contains($id_pengajuan, 'M_'))
        {
            $idsiplama = Str::replace('M_', '', $id_pengajuan);

            $getID = DB::table('tbl_sip_lama')
                ->select('id_nakes as id_user')
                ->where('id', $idsiplama)
                ->first();

        } else {

            $getID = DB::table('tbl_pengajuan')
                ->select('id_user')
                ->where('id', $id_pengajuan)
                ->first();

        }

        
        
        $id_user = $getID->id_user;

        $getfoto = DB::table('users')
            ->select('saved_photo')
            ->where('id', $id_user)
            ->first();
        
        $fotonakes = $getfoto->saved_photo;
        return $fotonakes;
    }

    public function getnomorwa($id_nakes) {

        $nowa = false;

        $egtno = DB::table('tbl_pendaftaran')
            ->select('notelp')
            ->where('id_user', $id_nakes)
            ->where('current_status', '1')
            ->first();

        if($egtno) {
            $nowa = $egtno->notelp;
        }

        return $nowa;
    }

    public function getnomorwabypengajuan($id_pengajuan) {

        $nowa = false;

        $getid = DB::table('tbl_pengajuan')
            ->select('id_user')
            ->where('id', $id_pengajuan)
            ->first();
        
        if($getid) {
            
            $id_nakes = $getid->id_user;
            $egtno = DB::table('tbl_pendaftaran')
                ->select('notelp')
                ->where('id_user', $id_nakes)
                ->where('current_status', '1')
                ->first();

            if($egtno) {
                $nowa = $egtno->notelp;
            }

        }
        return $nowa;
    }

    public function getallfaskes() {

        return DB::table('master_faskes')
            ->where('status_faskes', '1')
            ->get();

    }

    public function getjadwalnakes($id_nakes, $salinan){
        $result = DB::table('tbl_jadwalpraktik')
            ->selectRAW(DB::raw("ROW_NUMBER() OVER (PARTITION BY isSet) as nomore, hari, concat(mulai, ' - ', selesai) as pukul, case when is_shift = '1' then 'Shift' else '-' end as isShift, uraian"))
            ->where('id_user', $id_nakes)
            ->where('kadaluarsa', 0)
            ->where('salinan', $salinan)
            ->where('isSet', '1')
            ->get();

        if ($result->count() > 0) {

            return $result;

        } else {
            return false;
        }
    }

    public function getjadwalpraktik($id_nakes, $salinan, $id_pengajuan){

        $jadwale = DB::table('tbl_jadwalpraktik')
            ->where('id_pengajuan', $id_pengajuan)
            ->where('kadaluarsa', 0)
            ->where('id_user', $id_nakes)
            ->where('salinan', $salinan)
            ->orderby('urutan')
            ->orderby('id', 'desc')
            ->get();

        if(count($jadwale) > 7)
        {
            $idsToKeep = $jadwale->unique('urutan')->pluck('id');
            DB::table('tbl_jadwalpraktik')
                ->where('id_pengajuan', $id_pengajuan)
                ->where('kadaluarsa', 0)
                ->where('id_user', $id_nakes)
                ->where('salinan', $salinan)
                ->whereNotIn('id', $idsToKeep)
                ->delete();

        }

        return DB::table('tbl_jadwalpraktik')
            ->where('id_pengajuan', $id_pengajuan)
            ->where('kadaluarsa', 0)
            ->where('id_user', $id_nakes)
            ->where('salinan', $salinan)
            ->where('isSet', '1')
            ->orderby('urutan')
            ->orderby('id')
            ->get();

    }


    public function updatetolakdoc($jenis_doc, $id_nakes, $keterangan) {
        return DB::table('tbl_docs')
            ->where('jenis_doc', $jenis_doc)
            ->where('id_user', $id_nakes)
            ->where('kadaluarsa', '0')
            ->update([ 'is_compromised' => '1', 'keterangan_tolak' => $keterangan]);
        
    }

    public function tolakjadwal($user_id, $salinan, $keterangan, $id_pengajuan) {

        $updating = DB::table('tbl_pengajuan')
            ->where('id', $id_pengajuan)
            ->update(['tolak_jadwal' => '1', 'ket_tolak_jadwal' => $keterangan]);

        if($updating) {

            return DB::table('tbl_jadwalpraktik')
            ->where('id_user', $user_id)
            ->where('salinan', $salinan)
            ->where('kadaluarsa', 0)
            ->update([ 'isDitolak' => 1, 'alasan' => $keterangan]);

        } else {
            return false;
        }
        
    }

    
    public function tolaktemplate($user_id, $salinan, $keterangantemplate, $id_pengajuan) {

        return DB::table('tbl_pengajuan')
            ->where('id', $id_pengajuan)
            ->update(['tolak_template' => 1, 'ket_tolak_template' => $keterangantemplate]);

        
    }

    public function tolaklokasi($user_id, $salinan, $keterangan, $id_pengajuan) {

        $updating = DB::table('tbl_pengajuan')
            ->where('id', $id_pengajuan)
            ->update(['tolak_lokasi' => 1, 'ket_tolak_lokasi' => $keterangan]);

        if($updating) {

            return DB::table('tbl_jadwalpraktik')
            ->where('id_user', $user_id)
            ->where('salinan', $salinan)
            ->where('kadaluarsa', 0)
            ->update([ 'isDitolak' => 1, 'alasan' => $keterangan]);

        } else {
            return false;
        }

        
    }


    public function approvepencabutan($request) {
        $id_pengajuan = $request->id_pengajuan;
        $salinan = $request->salinan;
        $id_nakes = $request->id_nakes;
        $alasan = $request->id_alasan;
        $updater = $request->updater;
        $kode = $request->kode;
        $alasan_tolak = $request->alasan_tolak;

        $now = date('Y-m-d H:i:s');

        if($kode == '9') {

            if($alasan == '4' || $alasan == '5' ) {

            DB::table('tbl_sip')
                ->where('id_nakes', $id_nakes)
                ->update(['status_sip'=>'1']);
    
            DB::table('tbl_pengajuan')
                ->where('id_user', $id_nakes)
                ->update(['isApproved' => '4', 'updated_at' => $now, 'updater' => $updater, 'tracker'=>'Pencabutan Ditolak DPMPTSP', 'alasan_ditolak' => $alasan_tolak]);

            DB::table('tbl_docs')
                ->where('id_user', $id_nakes)
                ->whereRAW('jenis_doc not in ("IJAZAH", "KTP")')
                ->update(['kadaluarsa' => '0']);
                
            return true;

            } else {

                DB::table('tbl_sip')
                    ->where('id_nakes', $id_nakes)
                    ->where('salinan', $salinan)
                    ->update(['status_sip'=>'1']);
        
                DB::table('tbl_pengajuan')
                    ->where('id_user', $id_nakes)
                    ->where('salinan', $salinan)
                    ->update(['isApproved' => '4', 'updated_at' => $now, 'updater' => $updater, 'tracker'=>'Pencabutan Ditolak DPMPTSP', 'alasan_ditolak' => $alasan_tolak]);

                DB::table('tbl_docs')
                    ->where('id_user', $id_nakes)
                    ->where('salinan', $salinan)
                    ->whereRAW('jenis_doc not in ("IJAZAH", "KTP")')
                    ->update(['kadaluarsa' => '0']);
                
                return true;

            }

            

        } else {

            if($alasan == '4' || $alasan == '5' ) {

                DB::table('tbl_sip')
                ->where('id_nakes', $id_nakes)
                ->update(['tgl_pencabutan' => $now, 'status_sip'=>'CF']);
    
                DB::table('tbl_pengajuan')
                    ->where('id_user', $id_nakes)
                    ->update(['isApproved' => 'CF', 'updated_at' => $now, 'updater' => $updater, 'tracker'=>'Pencabutan Disetujui DPMPTSP', 'alasan_ditolak' => null ]);
    
                DB::table('tbl_docs')
                    ->where('id_user', $id_nakes)
                    //->where('kadaluarsa', 'C'.$alasan)
                    ->whereRAW('jenis_doc not in ("IJAZAH", "KTP")')
                    ->update(['isDiajukan' => '0']);
    
                DB::table('tbl_jadwalpraktik')
                    ->where('id_user', $id_nakes)
                    ->where('kadaluarsa', 0)
                    ->delete();
                
                return true;
    
            } else {
    
                DB::table('tbl_sip')
                ->where('id_pengajuan', $id_pengajuan)
                ->where('id_nakes', $id_nakes)
                ->where('salinan', $salinan)
                ->update(['tgl_pencabutan' => $now, 'status_sip'=>'CF']);
    
                DB::table('tbl_pengajuan')
                    ->where('id', $id_pengajuan)
                    ->where('id_user', $id_nakes)
                    ->where('salinan', $salinan)
                    ->update(['isApproved' => 'CF', 'updated_at' => $now, 'updater' => $updater, 'tracker'=>'Pencabutan Disetujui DPMPTSP', 'alasan_ditolak' => null ]);
    
                DB::table('tbl_docs')
                    ->where('id_user', $id_nakes)
                    ->where('salinan', $salinan)
                    ->whereRAW('jenis_doc not in ("IJAZAH", "KTP")')
                    ->update(['isDiajukan' => '0']);
    
                DB::table('tbl_jadwalpraktik')
                    ->where('id_user', $id_nakes)
                    ->where('salinan', $salinan)
                    ->where('kadaluarsa', 0)
                    ->delete();

                return true;
            }
        }
    }

    public function getlatestjadwal($id) {

        $perubahanlatest = 0;
        // $getnumberperubahan = DB::table('tbl_pengajuan')
        //     ->select('perubahan')
        //     ->where('id', $id)
        //     ->first();

        // $perubahan = (int)$getnumberperubahan->perubahan;
        // if ($perubahan == 0) {
        //     $perubahanlatest = 0;
        // } else {
        //     $perubahanlatest = $perubahan - 1;
        // }

        $getnumberperubahan = DB::table('approved_jadwal')
            ->select(DB::raw('MAX(perubahan) as perubahan'))
            ->where('id_pengajuan', $id)
            ->where('kadaluarsa', '0')
            ->first();
        
        if($getnumberperubahan) {
            $perubahanlatest = $getnumberperubahan->perubahan;
        }
        

        $getdetailjadwal = DB::table('approved_jadwal')
            ->select('detail_jadwal')
            ->where('id_pengajuan', $id)
            ->where('perubahan', $perubahanlatest)
            ->where('kadaluarsa', '0')
            ->first();
        
        if($getdetailjadwal) {

            $detailjadwal = $getdetailjadwal->detail_jadwal;

            return json_decode($detailjadwal);

        } else {
            return true;
        }

        
    }

    public function getperpanjangan($id_pengajuan) {

        if (Str::contains($id_pengajuan, 'M_'))
        {
            return 0;

        } else {

            $getperj = DB::table('tbl_pengajuan')
                ->select('perpanjangan')
                ->where('id', $id_pengajuan)
                ->first();

            $perpanjangan = $getperj->perpanjangan;
            return $perpanjangan;

        }
        

        
    }


    public function getallprofesi(){

        return DB::table('master_profesi')
            ->orderby('nama_profesi')
            ->get();

    }

    public function updateIDFotoNakes($id_nakes) {
        DB::table('users')
            ->where('id', $id_nakes)
            ->update(['saved_photo' => $id_nakes.'.jpeg']);

        return true;
    }


    public function simpanstrmanual($request, $tgl_keluar_str, $str_hingga) {

        
        $url_qr = $request->sturlqr;
        if (is_null($url_qr) || !isset($url_qr)) {
            $url_qr = 'manual';
        } 
        //$sturlqr = 'manual';
        $no_reg = $request->stNoSTR;
        $nama = $request->stNama;
        $jk = $request->stJenisK;
        $kompetensi = $request->stKompetensi;
        $profesi = $request->stProfesi;
        $updater = $request->stUserIDNakes;
        
        $img_src = $request->stImg;
        $origin_file = $request->stWhichF;
        $email = $request->stEmail;
        $notelp = $request->stNotelp;
        $salinan = $request->stSalinan;
        $password = $request->stPassword;
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        $current_status = 0;
        $tgl_keluar_str_ori = $request->stSTRtetapSIPmanual;
        $str_hingga_ori = $request->stSTRHinggaSIPmanual;
        //$tgl_keluar_str = $request->stSTRtetapSIP;
        //$str_hingga = $request->stSTRHinggaSIP;
        $pilihanSIP = $request->stProfesiSIP;
        $profesiDD = $request->stProfesiDD;

       
        if($profesiDD == 'APT') {
            $profesi = 'APOTEKER';
        } else if ($profesiDD == 'TTK'){
            $profesi = 'Tenaga Teknis Kefarmasian';
        } else if($profesiDD == 'DU') {
            $profesi = 'DOKTER UMUM';
        } else if($profesiDD == 'DG') {
            $profesi = 'DOKTER GIGI';
        } else if($profesiDD == 'DS') {
            $profesi = 'DOKTER SPESIALIS';
        } else if($profesiDD == 'DGS') {
            $profesi = 'DOKTER GIGI SPESIALIS';
        } else {

            $querp = DB::table('master_profesi')
            ->where('alias_profesi', $profesiDD)
            ->first();
            if($querp) {
                $profesi = $querp->nama_profesi;
            } else {
                $profesi = 'TENAGA KESEHATAN LAINNYA';
            }
            
        }
            
        

        $tgl_keluar_str_conv = $request->stStrKeluarConv;
        $str_hingga_conv = $request->stDueConv;

        $jenis_profesi = 0;
        $template_id = '';

        if( $pilihanSIP == 'DU' || $pilihanSIP == 'DG' || $pilihanSIP == 'DGS' || $pilihanSIP == 'DS') {
            $jenis_profesi = $pilihanSIP;
            $template_id = '2';
        } else if($pilihanSIP == '3') {
            if ($profesiDD == 'TTK') {
                $jenis_profesi = 'TTK';
            } else {
                $jenis_profesi = 'Apt';
            }
            
            $template_id = $pilihanSIP;
        } else if ($pilihanSIP == '4') {
            $jenis_profesi = 'APJ';
            $template_id = $pilihanSIP;
        } else {
            $jenis_profesi = $profesiDD;
            $template_id = $pilihanSIP;
        }

        if ($request->has('seumurhidup')) {
            $str_hingga = 'Seumur Hidup';
        }

        $id_pendaftar = DB::table('tbl_pendaftaran')
            ->insertGetId([
                'url_qr' => $url_qr,
                'no_reg' => $no_reg,
                'nama' => $nama,
                'jenis_kelamin' => $jk,
                'kompetensi' => $kompetensi,
                'profesi' => $profesi,
                'tgl_keluar_str' => $tgl_keluar_str,
                'str_hingga' => $str_hingga,
                'origin_file' => $origin_file,
                'img_src' => $img_src,
                'email' => $email,
                'notelp' => $notelp,
                'salinan' => $salinan,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
                'current_status' => $current_status,
                'tgl_keluar_str_origin' => $tgl_keluar_str_ori,
                'str_hingga_origin' => $str_hingga_ori,
                'tgl_keluar_str_conv' => $tgl_keluar_str,
                'str_hingga_conv' => $str_hingga,
                'jenis_profesi' => $jenis_profesi,
                'template_id' => $template_id,
                'remark' => 'manual'
    
            ]);

       
        $id_nakes = $this->createUserNakes($email, $password, 'nakes', $nama, $origin_file, 0);
        $this->setToDokumen($id_nakes, $template_id, $id_pendaftar);
        $this->updateIDFotoNakes($id_nakes);
        $this->updatePendaftaran($id_nakes, $id_pendaftar, $password, $updater, '2', '1');
        
        return $id_nakes;

    }


    public function getdetailpengajuan($id) {

        $s3 = DB::table('master_alasan')
                ->select('kd_alasan', 'nama_alasan');

        $s2 = DB::table('tbl_docs')
                ->select('id', 'id_user','namafile', 'url_qr', 'no_doc', 'tgl_doc_origin', 'tgl_doc as berlaku_sampai');

        if (Str::contains($id, 'M_'))
        {
            $idsiplama = Str::replace('M_', '', $id);

            $s0 = DB::table('users')
                    ->select('id', 'name');

            return DB::table('tbl_sip_lama')
                ->select('tbl_sip_lama.id', 's2.no_doc', 'tbl_sip_lama.namafile as filename_sip', 'tracker', 'nama_faskes', 'alamat_pengajuan', 's3.nama_alasan', 's2.berlaku_sampai', 's0.name as nama_nakes', 's2.no_doc as no_str', 'no_sip as no_surat', DB::raw('"1" as siplama'))
                ->leftjoinsub($s3, 's3', function($join){
                    $join->on('tbl_sip_lama.alasan', 's3.kd_alasan');
                })
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_sip_lama.id_nakes', 's0.id');
                })
                ->leftjoinsub($s2, 's2', function($join){
                    $join->on('tbl_sip_lama.id_doc', 's2.id')->on('tbl_sip_lama.id_nakes', 's2.id_user');
                })
                ->where('tbl_sip_lama.id', $idsiplama)
                ->first();

        } else {

            

            $s1 = DB::table('tbl_sip')
                    ->select('id_pengajuan', 'filename_sip', 'nama_nakes', 'no_str', 'perubahan', 'no_surat');


            return DB::table('tbl_pengajuan')
                ->select('tbl_pengajuan.*', 's3.nama_alasan', 's2.namafile', 's2.url_qr', 's2.no_doc', 's2.tgl_doc_origin','s1.filename_sip', 's2.berlaku_sampai','s1.nama_nakes', 's1.no_str', DB::raw('"0" as siplama'), 's1.no_surat')
                ->leftjoinsub($s3, 's3', function($join){
                    $join->on('tbl_pengajuan.alasan', 's3.kd_alasan');
                })
                ->leftjoinsub($s2, 's2', function($join){
                    $join->on('tbl_pengajuan.id_doc', 's2.id')->on('tbl_pengajuan.id_user', 's2.id_user');
                })
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_pengajuan.id', 's1.id_pengajuan')->on('tbl_pengajuan.perubahan', 's1.perubahan');
                })
                ->where('tbl_pengajuan.id', $id)
                ->first();

        }

        
            
    }

    public function updateSTRTahan($request) {

        if($request->jenis == "SH")
        {
            $id_pengajuan = $request->id_pengajuan;

            return DB::table('tbl_pengajuan')
                ->where('id', $id_pengajuan)
                ->update([
                    'ditahan' => '1',
                    'tracker' => 'Nakes Menyerahkan STR ke DPMPTSP',
                    'lokasi_disimpan' => 'Rak Virtual',
                    'updater' => 'ADMIN',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);



        } else {

            $id_pengajuan = $request->stIDPengajuanKumpul;
            $updater = $request->UpdaterKumpul;
            $lokasi_disimpan = $request->stPenyimpanan;

            return DB::table('tbl_pengajuan')
                ->where('id', $id_pengajuan)
                ->update([
                    'ditahan' => '1',
                    'tracker' => 'Nakes Menyerahkan STR ke DPMPTSP',
                    'lokasi_disimpan' => $lokasi_disimpan,
                    'updater' => $updater,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

        }

        

    }


    public function getIDNakesbyPengajuan($id_pengajuan){

        $getid = DB::table('tbl_pengajuan')
            ->select('id_user')
            ->where('id', $id_pengajuan)
            ->first();

        if($getid) {
            $id_nakes = $getid->id_user;
            return $id_nakes;
        } else {
            return false;
        }
    }

    public function query_historitinjau($userrole,$start, $leng, $reqstat, $clausewhere, $ket) {

        if($ket == 'counting') {

            if($userrole == 'kadinkes') {

                $s0 = DB::table('users')
                    ->select('id', 'name', 'photo_url', 'isActive')
                    ->orderBy('id');

                $s1 = DB::table('tbl_docs')
                    ->select('id', 'id_user', 'salinan', 'no_doc')
                    ->where('kadaluarsa','<>','1');

                $s2 = DB::table('tbl_sip')
                    ->select('id_pengajuan', 'status_sip', 'signed_date', 'perubahan');
            
    
                return DB::table('tbl_pengajuan')
                    ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.no_doc, ifnull(s2.signed_date,"Belum TTE") as status_tte'))
                    ->leftjoinsub($s0, 's0', function($join){
                        $join->on('tbl_pengajuan.id_user', 's0.id');
                    })
                    ->leftjoinsub($s1, 's1', function($join){
                        $join->on('tbl_pengajuan.id_doc', 's1.id');
                    })
                    ->leftjoinsub($s2, 's2', function($join){
                        $join->on('tbl_pengajuan.id', 's2.id_pengajuan')->on('tbl_pengajuan.perubahan', 's2.perubahan');
                    })
                    ->whereRaw('isApproved not in ("0", "1")')
                    ->whereRaw('tbl_pengajuan.id in (SELECT distinct id FROM tbl_pengajuan_hist where isApproved = "1K")')
                    ->whereRaw($clausewhere)
                    ->orderby('tbl_pengajuan.updated_at', 'desc')
                    ->get();

            } else {

                $s0 = DB::table('users')
                    ->select('id', 'name', 'photo_url', 'isActive')
                    ->orderBy('id');

                $s1 = DB::table('tbl_docs')
                    ->select('id', 'id_user', 'salinan', 'no_doc')
                    ->where('kadaluarsa','<>','1');

                $s2 = DB::table('tbl_sip')
                    ->select('id_pengajuan', 'status_sip', 'signed_date', 'perubahan');
            
    
                return DB::table('tbl_pengajuan')
                    ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.no_doc, ifnull(s2.signed_date,"Belum TTE") as status_tte'))
                    ->leftjoinsub($s0, 's0', function($join){
                        $join->on('tbl_pengajuan.id_user', 's0.id');
                    })
                    ->leftjoinsub($s1, 's1', function($join){
                        $join->on('tbl_pengajuan.id_doc', 's1.id');
                    })
                    ->leftjoinsub($s2, 's2', function($join){
                        $join->on('tbl_pengajuan.id', 's2.id_pengajuan')->on('tbl_pengajuan.perubahan', 's2.perubahan');
                    })
                    ->whereRaw('isApproved not in ("0", "1")')
                    ->whereRaw($clausewhere)
                    ->orderby('tbl_pengajuan.updated_at', 'desc')
                    ->get();

            }

                

        } else {

            if ($userrole == 'admindinkes') {

                $s0 = DB::table('users')
                    ->select('id', 'name', 'photo_url', 'isActive')
                    ->orderBy('id');

                $s1 = DB::table('tbl_docs')
                    ->select('id', 'id_user', 'salinan', 'no_doc')
                    ->where('kadaluarsa','<>','1');

                $s2 = DB::table('tbl_sip')
                    ->select('id_pengajuan', 'status_sip', 'signed_date', 'perubahan');
            
    
                return DB::table('tbl_pengajuan')
                    ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.no_doc, ifnull(s2.signed_date,"Belum TTE") as status_tte'))
                    ->leftjoinsub($s0, 's0', function($join){
                        $join->on('tbl_pengajuan.id_user', 's0.id');
                    })
                    ->leftjoinsub($s1, 's1', function($join){
                        $join->on('tbl_pengajuan.id_doc', 's1.id');
                    })
                    ->leftjoinsub($s2, 's2', function($join){
                        $join->on('tbl_pengajuan.id', 's2.id_pengajuan')->on('tbl_pengajuan.perubahan', 's2.perubahan');
                    })
                    ->whereRaw('isApproved not in ("0", "1")')
                    ->whereRaw($clausewhere)
                    ->orderby('tbl_pengajuan.updated_at', 'desc')
                    ->offset($start)
                    ->limit($leng)
                    ->get();
    
            } else if ($userrole == 'op') {

                $id_profesi = Auth::user()->class_op;

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

                $s3 = DB::table('tbl_sip')
                    ->select('id_pengajuan', 'status_sip', 'signed_date', 'perubahan');
            
    
                return DB::table('tbl_pengajuan')
                    ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.no_doc, ifnull(s3.signed_date,"Belum TTE") as status_tte'))
                    ->leftjoinsub($s0, 's0', function($join){
                        $join->on('tbl_pengajuan.id_user', 's0.id');
                    })
                    ->leftjoinsub($s1, 's1', function($join){
                        $join->on('tbl_pengajuan.id_doc', 's1.id');
                    })
                    ->leftjoinsub($s2, 's2', function($join){
                        $join->on('tbl_pengajuan.id_user', 's2.id_user');
                    })
                    ->leftjoinsub($s3, 's3', function($join){
                        $join->on('tbl_pengajuan.id', 's3.id_pengajuan')->on('tbl_pengajuan.perubahan', 's3.perubahan');
                    })
                    ->where('updated_by_op', '1')
                    ->where('s2.jenis_profesi', $jenis_profesi)
                    ->whereRaw($clausewhere)
                    ->orderby('tbl_pengajuan.updated_at', 'desc')
                    ->offset($start)
                    ->limit($leng)
                    ->get();
            
            
            } else if ($userrole == 'kadinkes') {

                $s0 = DB::table('users')
                    ->select('id', 'name', 'photo_url', 'isActive')
                    ->orderBy('id');

                $s1 = DB::table('tbl_docs')
                    ->select('id', 'id_user', 'salinan', 'no_doc')
                    ->where('kadaluarsa','<>','1');

                $s2 = DB::table('tbl_sip')
                    ->select('id_pengajuan', 'status_sip', 'signed_date', 'perubahan');

                $s3 = DB::table('tbl_pengajuan_hist')
                    ->select(DB::raw('count(id) as total_id'), 'id')
                    ->where('isApproved', '1K')
                    ->groupby('id');
            
    
                return DB::table('tbl_pengajuan')
                    ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.no_doc, ifnull(s2.signed_date,"Belum TTE") as status_tte'))
                    ->leftjoinsub($s0, 's0', function($join){
                        $join->on('tbl_pengajuan.id_user', 's0.id');
                    })
                    ->leftjoinsub($s1, 's1', function($join){
                        $join->on('tbl_pengajuan.id_doc', 's1.id');
                    })
                    ->leftjoinsub($s2, 's2', function($join){
                        $join->on('tbl_pengajuan.id', 's2.id_pengajuan')->on('tbl_pengajuan.perubahan', 's2.perubahan');
                    })
                    // ->joinsub($s3, 's3', function($join){
                    //     $join->on('tbl_pengajuan.id', 's3.id');
                    // })
                    ->whereRaw('isApproved not in ("0", "1")')
                    ->whereRaw('tbl_pengajuan.id in (SELECT distinct id FROM tbl_pengajuan_hist where isApproved = "1K")')
                    ->whereRaw($clausewhere)
                    ->orderby('tbl_pengajuan.updated_at', 'desc')
                    ->offset($start)
                    ->limit($leng)
                    ->get();

            } else {

                $s0 = DB::table('users')
                    ->select('id', 'name', 'photo_url', 'isActive')
                    ->orderBy('id');

                $s1 = DB::table('tbl_docs')
                    ->select('id', 'id_user', 'salinan', 'no_doc')
                    ->where('kadaluarsa','<>','1');

                $s2 = DB::table('tbl_sip')
                    ->select('id_pengajuan', 'status_sip', 'signed_date', 'perubahan');
            
    
                return DB::table('tbl_pengajuan')
                    ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.no_doc, ifnull(s2.signed_date,"Belum TTE") as status_tte'))
                    ->leftjoinsub($s0, 's0', function($join){
                        $join->on('tbl_pengajuan.id_user', 's0.id');
                    })
                    ->leftjoinsub($s1, 's1', function($join){
                        $join->on('tbl_pengajuan.id_doc', 's1.id');
                    })
                    ->leftjoinsub($s2, 's2', function($join){
                        $join->on('tbl_pengajuan.id', 's2.id_pengajuan')->on('tbl_pengajuan.perubahan', 's2.perubahan');
                    })
                    ->whereRaw('isApproved not in ("0", "1", "2")')
                    ->whereRaw($clausewhere)
                    ->orderby('tbl_pengajuan.updated_at', 'desc')
                    ->offset($start)
                    ->limit($leng)
                    ->get();

            }

        }

    }


    public function query_historitinjaumanual($userrole,$start, $leng, $reqstat, $clausewhere, $ket) {

        if($ket == 'counting') {

                $s0 = DB::table('users')
                    ->select('id', 'name', 'photo_url', 'isActive')
                    ->orderBy('id');

                $s1 = DB::table('tbl_docs')
                    ->select('id', 'id_user', 'salinan', 'no_doc')
                    ->where('kadaluarsa','<>','1');

                return DB::table('tbl_sip_lama')
                    ->select(DB::raw('tbl_sip_lama.*, s0.name, s0.photo_url, s1.no_doc'))
                    ->leftjoinsub($s0, 's0', function($join){
                        $join->on('tbl_sip_lama.id_nakes', 's0.id');
                    })
                    ->leftjoinsub($s1, 's1', function($join){
                        $join->on('tbl_sip_lama.id_doc', 's1.id');
                    })
                    ->whereRaw('isApproved not in ("0", "1")')
                    ->whereRaw($clausewhere)
                    ->orderby('tbl_sip_lama.updated_at', 'desc')
                    ->get();

        } else {

            if ($userrole == 'admindinkes') {

                $s0 = DB::table('users')
                    ->select('id', 'name', 'photo_url', 'isActive')
                    ->orderBy('id');

                $s1 = DB::table('tbl_docs')
                    ->select('id', 'id_user', 'salinan', 'no_doc')
                    ->where('kadaluarsa','<>','1');

             
    
                return DB::table('tbl_sip_lama')
                    ->select(DB::raw('tbl_sip_lama.*, s0.name, s0.photo_url, s1.no_doc'))
                    ->leftjoinsub($s0, 's0', function($join){
                        $join->on('tbl_sip_lama.id_nakes', 's0.id');
                    })
                    ->leftjoinsub($s1, 's1', function($join){
                        $join->on('tbl_sip_lama.id_doc', 's1.id');
                    })
                    ->whereRaw('isApproved not in ("0", "1")')
                    ->whereRaw($clausewhere)
                    ->orderby('tbl_sip_lama.updated_at', 'desc')
                    ->offset($start)
                    ->limit($leng)
                    ->get();
    
            } else if ($userrole == 'op') {

                $id_profesi = Auth::user()->class_op;

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

                return DB::table('tbl_sip_lama')
                    ->select(DB::raw('tbl_sip_lama.*, s0.name, s0.photo_url, s1.no_doc'))
                    ->leftjoinsub($s0, 's0', function($join){
                        $join->on('tbl_sip_lama.id_nakes', 's0.id');
                    })
                    ->leftjoinsub($s1, 's1', function($join){
                        $join->on('tbl_sip_lama.id_doc', 's1.id');
                    })
                    ->leftjoinsub($s2, 's2', function($join){
                        $join->on('tbl_sip_lama.id_nakes', 's2.id_user');
                    })

                    ->where('updated_by_op', '1')
                    ->where('s2.jenis_profesi', $jenis_profesi)
                    ->whereRaw($clausewhere)
                    ->orderby('tbl_pengajuan.updated_at', 'desc')
                    ->offset($start)
                    ->limit($leng)
                    ->get();
            
            
            } else {

                $s0 = DB::table('users')
                    ->select('id', 'name', 'photo_url', 'isActive')
                    ->orderBy('id');

                $s1 = DB::table('tbl_docs')
                    ->select('id', 'id_user', 'salinan', 'no_doc')
                    ->where('kadaluarsa','<>','1');

              
                return DB::table('tbl_sip_lama')
                    ->select(DB::raw('tbl_sip_lama.*, s0.name, s0.photo_url, s1.no_doc'))
                    ->leftjoinsub($s0, 's0', function($join){
                        $join->on('tbl_sip_lama.id_nakes', 's0.id');
                    })
                    ->leftjoinsub($s1, 's1', function($join){
                        $join->on('tbl_sip_lama.id_doc', 's1.id');
                    })
                 
                    ->whereRaw('isApproved not in ("0", "1", "2")')
                    ->whereRaw($clausewhere)
                    ->orderby('tbl_sip_lama.updated_at', 'desc')
                    ->offset($start)
                    ->limit($leng)
                    ->get();

            }

        }

    }

    
    public function query_historiapproveuser($userrole,$start, $leng, $reqstat, $clausewhere, $ket) {
        $now = Carbon::now();
        $oneMonthAgo = $now->subMonth(2);

        $s1 = DB::table('users')
                    ->select('id', 'saved_photo')
                    ->where('role','nakes');

        if($ket == 'counting') {
            if($clausewhere == '') {

                return DB::table('tbl_pendaftaran')
                ->select('tbl_pendaftaran.*', 's1.saved_photo')
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_pendaftaran.id_user', 's1.id');
                })
                ->where('current_status', '1')
                ->orderby('tbl_pendaftaran.updated_at', 'desc')
                ->get();

            } else {

                return DB::table('tbl_pendaftaran')
                ->select('tbl_pendaftaran.*', 's1.saved_photo')
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_pendaftaran.id_user', 's1.id');
                })
                ->where('current_status', '1')
                ->orderby('tbl_pendaftaran.updated_at', 'desc')
                ->get();

            }

            

        } else {

            if($clausewhere == '') {

                return DB::table('tbl_pendaftaran')
                    ->select('tbl_pendaftaran.*', 's1.saved_photo')
                    ->leftjoinsub($s1, 's1', function($join){
                        $join->on('tbl_pendaftaran.id_user', 's1.id');
                    })
                    ->where('current_status', '1')
                    ->whereBetween('tbl_pendaftaran.updated_at', [$oneMonthAgo, Carbon::now()])
                    ->orderby('tbl_pendaftaran.updated_at', 'desc')
                    ->offset($start)
                    ->limit($leng)
                    ->get();

            } else {

                return DB::table('tbl_pendaftaran')
                    ->select('tbl_pendaftaran.*', 's1.saved_photo')
                    ->leftjoinsub($s1, 's1', function($join){
                        $join->on('tbl_pendaftaran.id_user', 's1.id');
                    })
                    ->where('current_status', '1')
                    ->whereRaw($clausewhere)
                    //->whereBetween('tbl_pendaftaran.updated_at', [$oneMonthAgo, Carbon::now()])
                    ->orderby('tbl_pendaftaran.updated_at', 'desc')
                    
                    ->offset($start)
                    ->limit($leng)
                    ->get();

            }

            

        }

        

    }

    public function get_datatables_historitinjau($therole, $request)
    {
        $nama_nakes = $request->nama_nakes;
        $lokasi = $request->lokasi;
        $no_str = $request->nostr;
        $start_date = $request->startdate;
        $end_date = $request->enddate;
        $reqstat = '';
        $clausewhere = '';

        if($nama_nakes == '' && $lokasi == '' && $start_date == '' && $end_date == '' && $no_str == '') {
            $reqstat = 'init';
            $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%"';
        } else {
            $reqstat = 'new';
            if($start_date != '' && $end_date != '') {
                $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%" AND tbl_pengajuan.alamat_pengajuan LIKE "%'.$lokasi.'%" AND s1.no_doc LIKE "%'.$no_str.'%" AND tbl_pengajuan.created_at BETWEEN "'.$start_date.'" AND "'.$end_date.'"';
            } else {
                $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%" AND tbl_pengajuan.alamat_pengajuan LIKE "%'.$lokasi.'%" AND s1.no_doc LIKE "%'.$no_str.'%"';
            }
            
        }

		if($_POST['length'] != -1) {

            $limitan = ' LIMIT '.$_POST['start'].','.$_POST['length'];
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historitinjau($therole, $start, $leng, $reqstat, $clausewhere, 'not');
            

        } else {

            $reqstat = 'all';
            $limitan = ' LIMIT '.$_POST['start'].','.$_POST['length'];
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historitinjau($therole, $start, $leng, $reqstat, $clausewhere, 'counting');

        }
        return $query;
    }



    
    public function get_datatables_historiapproveuser($therole, $request)
    {
        $nama_nakes = $request->nama_nakes;
        $kompetensi = $request->kompetensi;
        $no_str = $request->nostr;
        $email = $request->email;
        $notelp = $request->notelp;
        $reqstat = '';
        $clausewhere = '';

        if($nama_nakes == '' && $kompetensi == '' && $email == '' && $notelp == '' && $no_str == '') {
            $reqstat = 'init';
            $clausewhere = 'tbl_pendaftaran.nama LIKE "%'.$nama_nakes.'%"';
        } else {

            $clausewhere = 'tbl_pendaftaran.nama LIKE "%'.$nama_nakes.'%" AND tbl_pendaftaran.kompetensi LIKE "%'.$kompetensi.'%" AND tbl_pendaftaran.no_reg LIKE "%'.$no_str.'%" AND tbl_pendaftaran.email LIKE "%'.$email.'%" AND tbl_pendaftaran.notelp LIKE "%'.$notelp.'%"';
            
        }

		if($_POST['length'] != -1) {

            $limitan = ' LIMIT '.$_POST['start'].','.$_POST['length'];
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historiapproveuser($therole, $start, $leng, $reqstat, $clausewhere, 'not');
            

        } else {

            $reqstat = 'all';

            $limitan = ' LIMIT '.$_POST['start'].','.$_POST['length'];
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historiapproveuser($therole, $start, $leng, $reqstat, $clausewhere, 'counting');

        }
        return $query;
    }

    public function count_all($therole, $request)
    {
        $nama_nakes = $request->nama_nakes;
        $lokasi = $request->lokasi;
        $no_str = $request->nostr;
        $start_date = $request->startdate;
        $end_date = $request->enddate;
        $reqstat = '';
        $clausewhere = '';

        if($nama_nakes == '' && $lokasi == '' && $start_date == '' && $end_date == '' && $no_str == '') {
            $reqstat = 'init';
            $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%"';

        } else {
            $reqstat = 'new';
            if($start_date != '' && $end_date != '') {
                $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%" AND tbl_pengajuan.alamat_pengajuan LIKE "%'.$lokasi.'%" AND s1.no_doc LIKE "%'.$no_str.'%" AND tbl_pengajuan.created_at BETWEEN "'.$start_date.'" AND "'.$end_date.'"';
            } else {
                $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%" AND tbl_pengajuan.alamat_pengajuan LIKE "%'.$lokasi.'%" AND s1.no_doc LIKE "%'.$no_str.'%"';
            }
        }

        if($_POST['length'] != -1) {

            $limitan = ' LIMIT '.$_POST['start'].','.$_POST['length'];
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historitinjau($therole, $start, $leng, $reqstat, $clausewhere,'counting');

        } else {

            $reqstat = 'all';
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historitinjau($therole, $start, $leng, $reqstat, $clausewhere,'counting');

        }
        
        return count($query);
        //return $query->num_rows();
    }
    
    public function count_filtered($therole, $request)
    {
        $nama_nakes = $request->nama_nakes;
        $lokasi = $request->lokasi;
        $no_str = $request->nostr;
        $start_date = $request->startdate;
        $end_date = $request->enddate;
        $reqstat = '';
        $clausewhere = '';

        if($nama_nakes == '' && $lokasi == '' && $start_date == '' && $end_date == '' && $no_str == '') {
            $reqstat = 'init';
            $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%"';
        } else {
            $reqstat = 'new';
            if($start_date != '' && $end_date != '') {
                $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%" AND tbl_pengajuan.alamat_pengajuan LIKE "%'.$lokasi.'%" AND s1.no_doc LIKE "%'.$no_str.'%" AND tbl_pengajuan.created_at BETWEEN "'.$start_date.'" AND "'.$end_date.'"';
            } else {
                $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%" AND tbl_pengajuan.alamat_pengajuan LIKE "%'.$lokasi.'%" AND s1.no_doc LIKE "%'.$no_str.'%"';
            }
        }

        if($_POST['length'] != -1) {

            $limitan = ' LIMIT '.$_POST['start'].','.$_POST['length'];
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historitinjau($therole, $start, $leng, $reqstat, $clausewhere,'counting');

        } else {

            $reqstat = 'all';
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historitinjau($therole, $start, $leng, $reqstat, $clausewhere,'counting');

        }
        
        return count($query);
        //return $query->num_rows();
    }


    public function count_all_happuser($therole, $request)
    {
        $nama_nakes = $request->nama_nakes;
        $kompetensi = $request->kompetensi;
        $no_str = $request->nostr;
        $email = $request->email;
        $notelp = $request->notelp;
        $reqstat = '';
        $clausewhere = '';

        if($nama_nakes == '' && $kompetensi == '' && $email == '' && $notelp == '' && $no_str == '') {
            $reqstat = 'init';
            $clausewhere = '';
        } else {

            $clausewhere = 'tbl_pendaftaran.nama LIKE "%'.$nama_nakes.'%" AND tbl_pendaftaran.kompetensi LIKE "%'.$kompetensi.'%" AND tbl_pendaftaran.no_reg LIKE "%'.$no_str.'%" AND tbl_pendaftaran.email LIKE "%'.$email.'%" AND tbl_pendaftaran.notelp LIKE "%'.$notelp.'%"';
            
        }

		if($_POST['length'] != -1) {

            $limitan = ' LIMIT '.$_POST['start'].','.$_POST['length'];
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historiapproveuser($therole, $start, $leng, $reqstat, $clausewhere, 'counting');
            

        } else {

            $reqstat = 'all';

            $limitan = ' LIMIT '.$_POST['start'].','.$_POST['length'];
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historiapproveuser($therole, $start, $leng, $reqstat, $clausewhere, 'counting');

        }
        return $query;
        //return $query->num_rows();
    }

    public function count_filtered_happuser($therole, $request)
    {
        $nama_nakes = $request->nama_nakes;
        $kompetensi = $request->kompetensi;
        $no_str = $request->nostr;
        $email = $request->email;
        $notelp = $request->notelp;
        $reqstat = '';
        $clausewhere = '';

        if($nama_nakes == '' && $kompetensi == '' && $email == '' && $notelp == '' && $no_str == '') {
            $reqstat = 'init';
            $clausewhere = '';
        } else {

            $clausewhere = 'tbl_pendaftaran.nama LIKE "%'.$nama_nakes.'%" AND tbl_pendaftaran.kompetensi LIKE "%'.$kompetensi.'%" AND tbl_pendaftaran.no_reg LIKE "%'.$no_str.'%" AND tbl_pendaftaran.email LIKE "%'.$email.'%" AND tbl_pendaftaran.notelp LIKE "%'.$notelp.'%"';
            
        }

		if($_POST['length'] != -1) {

            $limitan = ' LIMIT '.$_POST['start'].','.$_POST['length'];
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historiapproveuser($therole, $start, $leng, $reqstat, $clausewhere, 'counting');
            

        } else {

            $reqstat = 'all';

            $limitan = ' LIMIT '.$_POST['start'].','.$_POST['length'];
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historiapproveuser($therole, $start, $leng, $reqstat, $clausewhere, 'counting');

        }
        return $query;
        //return $query->num_rows();
    }

    ///sipmanual
    public function get_datatables_historitinjaumanual($therole, $request)
    {
        $nama_nakes = $request->nama_nakes;
        $lokasi = $request->lokasi;
        $no_str = $request->nostr;
        $start_date = $request->startdate;
        $end_date = $request->enddate;
        $reqstat = '';
        $clausewhere = '';

        if($nama_nakes == '' && $lokasi == '' && $start_date == '' && $end_date == '' && $no_str == '') {
            $reqstat = 'init';
            $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%"';
        } else {
            $reqstat = 'new';
            if($start_date != '' && $end_date != '') {
                $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%" AND tbl_sip_lama.alamat_pengajuan LIKE "%'.$lokasi.'%" AND tbl_sip_lama.no_sip LIKE "%'.$no_str.'%" AND tbl_sip_lama.created_at BETWEEN "'.$start_date.'" AND "'.$end_date.'"';
            } else {
                $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%" AND tbl_sip_lama.alamat_pengajuan LIKE "%'.$lokasi.'%" AND tbl_sip_lama.no_sip LIKE "%'.$no_str.'%"';
            }
            
        }

		if($_POST['length'] != -1) {

            $limitan = ' LIMIT '.$_POST['start'].','.$_POST['length'];
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historitinjaumanual($therole, $start, $leng, $reqstat, $clausewhere, 'not');
            

        } else {

            $reqstat = 'all';

            $limitan = ' LIMIT '.$_POST['start'].','.$_POST['length'];
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historitinjaumanual($therole, $start, $leng, $reqstat, $clausewhere, 'counting');

        }
        return $query;
    }
    //
    public function count_allm($therole, $request)
    {
        $nama_nakes = $request->nama_nakes;
        $lokasi = $request->lokasi;
        $no_str = $request->nostr;
        $start_date = $request->startdate;
        $end_date = $request->enddate;
        $reqstat = '';
        $clausewhere = '';

        if($nama_nakes == '' && $lokasi == '' && $start_date == '' && $end_date == '' && $no_str == '') {
            $reqstat = 'init';
            $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%"';

        } else {
            $reqstat = 'new';
            if($start_date != '' && $end_date != '') {
                $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%" AND tbl_sip_lama.alamat_pengajuan LIKE "%'.$lokasi.'%" AND tbl_sip_lama.no_sip LIKE "%'.$no_str.'%" AND tbl_sip_lama.created_at BETWEEN "'.$start_date.'" AND "'.$end_date.'"';
            } else {
                $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%" AND tbl_sip_lama.alamat_pengajuan LIKE "%'.$lokasi.'%" AND tbl_sip_lama.no_sip LIKE "%'.$no_str.'%"';
            }
        }

        if($_POST['length'] != -1) {

            $limitan = ' LIMIT '.$_POST['start'].','.$_POST['length'];
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historitinjaumanual($therole, $start, $leng, $reqstat, $clausewhere,'counting');

        } else {

            $reqstat = 'all';
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historitinjaumanual($therole, $start, $leng, $reqstat, $clausewhere,'counting');

        }
        
        return count($query);
        //return $query->num_rows();
    }

    public function count_filteredm($therole, $request)
    {
        $nama_nakes = $request->nama_nakes;
        $lokasi = $request->lokasi;
        $no_str = $request->nostr;
        $start_date = $request->startdate;
        $end_date = $request->enddate;
        $reqstat = '';
        $clausewhere = '';

        if($nama_nakes == '' && $lokasi == '' && $start_date == '' && $end_date == '' && $no_str == '') {
            $reqstat = 'init';
            $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%"';
        } else {
            $reqstat = 'new';
            if($start_date != '' && $end_date != '') {
                $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%" AND tbl_sip_lama.alamat_pengajuan LIKE "%'.$lokasi.'%" AND tbl_sip_lama.no_sip LIKE "%'.$no_str.'%" AND tbl_sip_lama.created_at BETWEEN "'.$start_date.'" AND "'.$end_date.'"';
            } else {
                $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%" AND tbl_sip_lama.alamat_pengajuan LIKE "%'.$lokasi.'%" AND tbl_sip_lama.no_sip LIKE "%'.$no_str.'%"';
            }
        }

        if($_POST['length'] != -1) {

            $limitan = ' LIMIT '.$_POST['start'].','.$_POST['length'];
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historitinjaumanual($therole, $start, $leng, $reqstat, $clausewhere,'counting');

        } else {

            $reqstat = 'all';
            $start = $_POST['start'];
            $leng = $_POST['length'];
            $query = $this->query_historitinjaumanual($therole, $start, $leng, $reqstat, $clausewhere,'counting');

        }
        
        return count($query);
        //return $query->num_rows();
    }
    
    public function checkfotonotavail($id_pendaftar){
        $isnotavail = 0;
        $ceki = DB::table('tbl_pendaftaran')
                        ->where('id', $id_pendaftar)
                        ->first();
        if($ceki) {
            $isnotavail = $ceki->foto_not_avail;  
        } 
        return $isnotavail;
        
    }

    public function resetnakespassword($request){

        $newpass = $request->newpass;
        $id_user = $request->id_user;

        return DB::table('users')
            ->where('id', $id_user)
            ->update([
                'freshpass' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make($newpass)
            ]);
    }

    public function submitmanagefaskes($request){
        $jenissubmit = $request->jenissubmitfasyankes;
        $status_faskes = $request->statusfasyankes;
        $nama_faskes = $request->namafasyankes;
        $remark = $request->noijinfasyankes;
        $alamat_faskes = $request->alamatfasyankes;
        $kecamatan_faskes = $request->kecfasyankes;
        $kabupaten_faskes = $request->kabfasyankes;
        $latitude = $request->latfasyankes;
        $longitude = $request->longfasyankes;
        $id_faskes = $request->idfaskyankes;
        $notelp = $request->notelpfasyankes;
        $jamkerja = $request->jkfasyankes;
        

        if($jenissubmit == 'add') {
            $idfas = DB::table('master_faskes')
                ->insertGetId([
                    'status_faskes' => $status_faskes,
                    'nama_faskes' => $nama_faskes,
                    'remark' => $remark,
                    'alamat_faskes' => $alamat_faskes,
                    'kecamatan_faskes' => $kecamatan_faskes,
                    'kabupaten_faskes' => $kabupaten_faskes,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'no_telp' => $notelp,
                    'jam_kerja' => $jamkerja,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                if ($request->hasFile('fotofaskes')) {

                    $file = $request->file('fotofaskes');
                    $filename = $idfas . '.' . $file->getClientOriginalExtension();
                
                    $path = public_path('fotofaskes');
                
                    // check if directory exists
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                
                    return $file->move($path, $filename);
                
                }


        } else if ($jenissubmit == 'edit'){

            if ($request->hasFile('fotofaskes')) {

                $file = $request->file('fotofaskes');
                $filename = $id_faskes . '.' . $file->getClientOriginalExtension();
            
                $path = public_path('fotofaskes');
            
                // check if directory exists
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
            
                return $file->move($path, $filename);
            
            }

            return DB::table('master_faskes')
                ->where('id_faskes', $id_faskes)
                ->update([
                    'status_faskes' => $status_faskes,
                    'nama_faskes' => $nama_faskes,
                    'remark' => $remark,
                    'alamat_faskes' => $alamat_faskes,
                    'kecamatan_faskes' => $kecamatan_faskes,
                    'kabupaten_faskes' => $kabupaten_faskes,
                    'no_telp' => $notelp,
                    'jam_kerja' => $jamkerja,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
        } else {

            if ($request->hasFile('fotofaskes')) {

                $file = $request->file('fotofaskes');
                $filename = $id_faskes . '.' . $file->getClientOriginalExtension();
            
                $path = public_path('fotofaskes');
            
                // check if directory exists
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
            
                return $file->move($path, $filename);
            
            }

            return DB::table('master_faskes')
                ->where('id_faskes', $id_faskes)
                ->update([
                    'status_faskes' => 0,
                    'nama_faskes' => $nama_faskes,
                    'remark' => $remark,
                    'alamat_faskes' => $alamat_faskes,
                    'kecamatan_faskes' => $kecamatan_faskes,
                    'kabupaten_faskes' => $kabupaten_faskes,
                    'no_telp' => $notelp,
                    'jam_kerja' => $jamkerja,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

        }

    }

    public function verifstrserahan($request){

        $thename = $request->thename;
        $salinan = $request->salinan;

        $s1 = DB::table('users')
            ->select('id', 'name');

        return DB::table('tbl_docs')
            ->select('no_doc as no_reg', 'salinan', 's1.name as nama_nakes', 'tgl_doc_origin as str_hingga')
            ->leftjoinsub($s1, 's1', function($join){
                $join->on('tbl_docs.id_user', 's1.id');
            })
            ->where('url_qr', $thename)
            ->where('salinan', $salinan)
            ->first();

    }

    public function checkexistingmanual($request) {

        $totalcheck = 0;
        $email = $request->stEmail;
        $notelp = $request->stNotelp;
        $countemail = DB::table('users')
            ->where('username', $email)
            ->count();
        $checknotelp = DB::table('tbl_pendaftaran')
            ->where('notelp', $notelp)
            ->where('current_status','<>','9')
            ->count();

        $checknostr = DB::table('tbl_docs')
            ->where('no_doc', $notelp)
            ->where('kadaluarsa','<>','1')
            ->count();
        
        if($countemail > 0) {
            $totalcheck++;
        }
        if($checknotelp > 0) {
            $totalcheck++;
        }
        if($checknostr > 0) {
            $totalcheck++;
        }

        return $totalcheck;
    }


    public function cancelDraftSip($request){

        $id_pengajuan = $request->id_pengajuan;
        $getperubahan = DB::table('tbl_pengajuan')
            ->select('perubahan')
            ->where('id', $id_pengajuan)
            ->first();
        $perubahan = $getperubahan->perubahan;
        
        return DB::table('tbl_sip')
            ->where('id_pengajuan', $id_pengajuan)
            ->where('perubahan', $perubahan)
            ->where('status_sip','<>', '1')
            ->delete();

    }

    public function revertDraftSip($request) {

        $id_pengajuan = $request->id_pengajuan;
        $updater = $request->updater;
        $perubahan = $request->perubahan;

        DB::table('tbl_sip')
                ->where('id_pengajuan', $id_pengajuan)
                ->where('perubahan', $perubahan)
                ->where('status_sip','<>', '1')
                ->delete();

        return DB::table('tbl_pengajuan')
                ->where('id', $id_pengajuan)
                ->update([
                    'updater' => $updater,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'isApproved' => '2'
                ]);
    }

    public function ptspupdatepengaju($request) {

        $id = $request->id_nakes;
        $id_pengajuan = $request->id_pengajuan;

        $alamat_pengaju = $request->alamatpengaju;
        $kecamatan_pengaju = $request->kecamatanpengaju;
        $kabupaten_pengaju = $request->kabupatenpengaju;

        $alamat_pengajuanb = $request->alamatpengajuanbefore;
        $kecamatan_pengajuanb = $request->kecamatanpengajuanbefore;
        $kabupaten_pengajuanb = $request->kabupatenpengajuanbefore;
        $no_ttkbefore = $request->nottkbefore;
        $templatebefore = $request->templatebefore;
        $updater = $request->updater;
        $salinan = $request->salinan;

        $nama_esip = $request->namaesip;
        $profesi_esip = $request->profesiesip;
        $alamat_pengajuan = $request->alamatpengajuanafter;
        $kecamatan_pengajuan = $request->kecamatanpengajuanafter;
        $kabupaten_pengajuan = $request->kabupatenpengajuanafter;
        $nottk = $request->nottkafter;
        $template_id = $request->template_id;
        $isPengajuanFaskes = $request->ispengajuanfaskes;
        $tempat_lahir = $request->tempat_lahir;

        $isintern = $request->isintern;
        $tgldocintern = $request->tgldocintern;
        $kompetensi_esip = $request->kompetensi;
        

        if($isintern == '1') {

            $getselisih = DB::select(DB::raw('call selisihexpire("'.$tgldocintern.'")'));
            if($getselisih && isset($getselisih[0]->selisihhari)) {
                DB::table('tbl_docs')
                    ->where('id_user', $id)
                    ->where('jenis_doc', 'like', 'STR%')
                    ->update([
                        'expiring_count' => $getselisih[0]->selisihhari,
                        'tgl_doc' => $tgldocintern,
                        'remark5' => $tgldocintern,
                        'updater' => $updater,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
            } 
        }

        $s0 = DB::table('users')
            ->select('saved_photo', 'id')
            ->where('id', $id);

        $s1 = DB::table('tbl_docs')
            ->select('nama_doc as nama_pengaju', 'id_user', 'remark1 as alamat_pengaju', 'remark2 as kecamatan_pengaju', 'remark3 as kabupaten_pengaju', 'jenis_profesi as no_ttk','template_id','remark4 as tempat_lahir')
            ->where('id_user', $id)
            ->where('jenis_doc', 'KTP');

        $s2 = DB::table('tbl_docs')
            ->select('profesi as profesi_pengaju', 'kompetensi as kompetensi_pengaju', 'id_user')
            ->where('id_user', $id)
            ->where('jenis_doc', 'STR1');
      

        $pengaju = DB::table('tbl_pendaftaran')
            ->select('tbl_pendaftaran.*', 's0.saved_photo', 's1.nama_pengaju', 's2.profesi_pengaju', 's2.kompetensi_pengaju', 's1.alamat_pengaju', 's1.kecamatan_pengaju', 's1.kabupaten_pengaju', 's1.no_ttk', 's1.template_id', 's1.tempat_lahir')
            ->leftjoinsub($s0, 's0', function($join){
                $join->on('tbl_pendaftaran.id_user', 's0.id');
            })
            ->leftjoinsub($s1, 's1', function($join){
                $join->on('tbl_pendaftaran.id_user', 's1.id_user');
            })
            ->leftjoinsub($s2, 's2', function($join){
                $join->on('tbl_pendaftaran.id_user', 's2.id_user');
            })
            ->where('tbl_pendaftaran.id_user', $id)
            ->first();

        if($pengaju) {

            $datasend = [
                'id_pengajuan' => $id_pengajuan,
                'nama_pengaju' => $pengaju->nama_pengaju,
                'profesi_pengaju' => $pengaju->profesi_pengaju,
                'kompetensi_pengaju' => $pengaju->kompetensi_pengaju,
                'alamat_nakes' => $pengaju->alamat_pengaju,
                'kecamatan_nakes' => $pengaju->kecamatan_pengaju,
                'kabupaten_nakes' => $pengaju->kabupaten_pengaju,
                'alamat_pengajuan' => $alamat_pengajuanb,
                'kecamatan_pengajuan' => $kecamatan_pengajuanb,
                'kabupaten_pengajuan' => $kabupaten_pengajuanb,
                'no_ttk' => $pengaju->no_ttk,
                'template_id' => $pengaju->template_id,
                'tempat_lahir' => $pengaju->tempat_lahir,
                'tgldocintern' => $tgldocintern
            ];

            DB::table('ptsp_pengajuan_log')
                ->insert($datasend);

            DB::table('tbl_docs')
                ->where('id_user', $id)
                ->where('jenis_doc', 'like', 'STR%')
                ->update([
                    'profesi' => $profesi_esip,
                    'kompetensi' => $kompetensi_esip,
                    'template_id' => $template_id,
                    'updater' => $updater,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            DB::table('tbl_docs')
                ->where('id_user', $id)
                ->where('jenis_doc', 'KTP')
                ->update([
                    'nama_doc' => $nama_esip,
                    'remark1' => $alamat_pengaju,
                    'remark2' => $kecamatan_pengaju,
                    'remark3' => $kabupaten_pengaju,
                    'remark4' => $tempat_lahir,
                    'jenis_profesi' => $nottk,
                    'updater' => $updater,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            if($isPengajuanFaskes == 0) {
                
                DB::table('tbl_pengajuan')
                ->where('id', $id_pengajuan)
                ->update([
                    'alamat_pengajuan' => $alamat_pengajuan,
                    'kecamatan' => $kecamatan_pengajuan,
                    'kabupaten' => $kabupaten_pengajuan,
                    'template_id' => $template_id
                ]);
            }
            
            return true;

        } else {
            return false;
        }
    }

    public function updateproffirst($id, $eprof, $ketprof)
    {
        $getalias = DB::table('tbl_docs')
            ->select('jenis_profesi')
            ->where('jenis_doc', 'STR1')
            ->where('id_user', $id)
            ->first();
        if($getalias)
        {
            $curalias = $getalias->jenis_profesi;
            if($curalias == $eprof && $ketprof != 0)
            {
                return true;
            } else {
                $template_ = '1';

                if (in_array($eprof, ['DG', 'DGS', 'DU', 'DS'])) {
                    $template_ = '2';
                } elseif (in_array($eprof, ['APT', 'TTK'])) {
                    $template_ = '3';
                } elseif (in_array($eprof, ['APJ'])) {
                    $template_ = '4';
                } else {
                    $template_ = '1';
                }
            }

            
        }
    }

    public function tambahuserfaskes($request, $namafile) {
        $id_faskes = $request->fIDFaskes;
        $username = $request->fUsernameFaskes;
        $name = $request->fNamaUserFaskes;
        $password = $request->fPassFaskes;
        $nowa = $request->fWAFaskes;
        $isubah = $request->fIsUbah;

        if($isubah == 1) {
            
            return DB::table('users')
                ->where('class_op', $id_faskes)
                ->update([
                    "name" => $name,
                    "username" => $username,
                    'password' => Hash::make($password),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'isActive' => '1',
                    'photo_url' => $nowa
                ]);

        } else {

            return DB::table('users')
                ->insert([
                    "name" => $name,
                    "username" => $username,
                    'role' => 'faskes',
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(7),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'isActive' => '1',
                    'photo_url' => $nowa,
                    'saved_photo' => $namafile,
                    'class_op' => $id_faskes
                ]);

        }

    }

    public function getuserfaskes($request) {
        $id_faskes = $request->id_faskes;
        return DB::table('users')
            ->where('role', 'faskes')
            ->where('class_op', $id_faskes)
            ->get();
    }

    public function submittolaknakes($request) {

        $id_pendaftaran = $request->id_pendaftaran;
        $updater = $request->updater;
        return DB::table('tbl_pendaftaran')
            ->where('id', $id_pendaftaran)
            ->update([
                'current_status' => '9',
                'updated_at' => date('Y-m-d H:i:s'),
                'updater' => $updater
            ]);

    }

    public function submiteditnomor($request) {

        $id_pendaftaran = $request->id_pendaftaran;
        $updater = $request->updater;
        $email = $request->email;
        $notelp = $request->notelp;
        $setsiplama = $request->setsiplama;

        $getiduser = DB::table('tbl_pendaftaran')
            ->select('id_user', 'email')
            ->where('id', $id_pendaftaran)
            ->first();

        

        if($getiduser) {
            $id_user = $getiduser->id_user;
            $current_email = $getiduser->email;
            DB::table('users')
                ->where('id', $id_user)
                ->update([
                    'class_op' => $setsiplama,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            if($email != $current_email) {

                DB::table('users')
                ->where('id', $id_user)
                ->update([
                    'username' => $email,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            }
            return DB::table('tbl_pendaftaran')
                ->where('id', $id_pendaftaran)
                ->update([
                    'email' => $email,
                    'notelp' => $notelp,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updater' => $updater
                ]);
        } else {
            return false;
        }
        
    }

    public function getrekapfaskes($id_faskes, $status_sip) {

        // $s1 = DB::table('tbl_pengajuan')
        //     ->select('id as id_pengajuan')
        //     ->where('id_faskes', $id_faskes);

        // return DB::table('tbl_sip')
        //     ->selectRAW('count(tbl_sip.id) as total, profesi')
        //     ->where('status_sip','=',$status_sip)
        //     ->where('status_sip','<>','CF')
        //     ->whereRAW('id_pengajuan in (SELECT distinct(id) FROM tbl_pengajuan WHERE id_faskes = '.$id_faskes.')')
        //     ->groupby('profesi')
        //     ->orderby('profesi')
        //     ->get();

        $s1 = DB::table('tbl_docs')
            ->select('id as id_doc', 'profesi')
            ->where('kadaluarsa', '<>', '1');

        $s0 = DB::table(DB::raw("(SELECT concat('P',id) as id, id_doc, isApproved, id_faskes FROM tbl_pengajuan WHERE id_faskes = '".$id_faskes."' UNION ALL SELECT concat('L',id) as id, id_doc, isApproved, id_faskes FROM tbl_sip_lama WHERE id_faskes = '".$id_faskes."') as mtb"))
            ->selectRaw('count(mtb.id) as totalb, b1.profesi')
            ->joinSub($s1, 'b1', function ($join) {
                $join->on('mtb.id_doc', 'b1.id_doc');
            })
            ->where('isApproved', '<>', '4')
            ->where('isApproved', '<>', 'CF')
            ->where('id_faskes', $id_faskes)
            ->groupBy('b1.profesi');

        // $s2 = DB::table('tbl_pengajuan')
        //     ->selectRaw('count(id) as totala, a1.profesi')
        //     ->joinSub($s1, 'a1', function ($join) {
        //         $join->on('tbl_pengajuan.id_doc', 'a1.id_doc');
        //     })
        //     ->where('isApproved', '4')
        //     ->where('id_faskes', $id_faskes)
        //     ->groupBy('a1.profesi');

        $s2 = DB::table(DB::raw("(SELECT concat('P',id) as id, id_doc, isApproved, id_faskes FROM tbl_pengajuan WHERE id_faskes = '".$id_faskes."' UNION ALL SELECT concat('L',id) as id, id_doc, isApproved, id_faskes FROM tbl_sip_lama WHERE id_faskes = '".$id_faskes."') as mtb"))
            ->selectRaw('count(mtb.id) as totala, a1.profesi')
            ->joinSub($s1, 'a1', function ($join) {
                $join->on('mtb.id_doc', 'a1.id_doc');
            })
            ->where('isApproved', '4')
            ->where('id_faskes', $id_faskes)
            ->groupBy('a1.profesi');

        


        return DB::table(DB::raw("(SELECT distinct profesi as profesi FROM tbl_docs WHERE id in (SELECT id_doc FROM tbl_pengajuan WHERE id_faskes = '".$id_faskes."' UNION ALL SELECT id_doc FROM tbl_sip_lama WHERE id_faskes = '".$id_faskes."') group by profesi) as main_tb"))
            ->leftJoinSub($s0, 's0', function ($join) {
                $join->on('main_tb.profesi', 's0.profesi');
            })
            ->leftJoinSub($s2, 's2', function ($join) {
                $join->on('main_tb.profesi', 's2.profesi');
            })
            ->selectRAW('main_tb.profesi, ifnull(s0.totalb,0) as totalb, ifnull(s2.totala,0) as totala')
            ->limit(50)
            ->get();

        
    }

    public function allnakesonfaskes($id_faskes) {
        $s1 = DB::table('tbl_sip')
            ->select('id_pengajuan', 'nama_nakes', 'profesi', 'foto_nakes', 'tgl_doc', 'filename_sip', 'perubahan')
            ->where('status_sip', '<>','CF');
            //isdicabut excluded
        $s2 = DB::table('users')
            ->select('id as id_user', 'saved_photo', 'last_login', 'name')
            ->where('role','nakes');

        $s3 = DB::table('tbl_docs')
            ->select('id as id_doc', 'profesi', 'tgl_doc')
            ->where('jenis_doc','like','STR%');

        // return DB::table('tbl_pengajuan')
        //     ->selectRAW('ifnull(s1.nama_nakes, s2.name) as nama_nakes, ifnull(s1.profesi,s3.profesi) as profesi, ifnull(s1.foto_nakes,s2.saved_photo) as foto_nakes, ifnull(s1.tgl_doc,s3.tgl_doc) as tgl_doc, ifnull(s1.filename_sip,0) as filename_sip, isApproved, tracker as status_terakhir, concat("https://esip.cilacapkab.go.id/storagefoto/",ifnull(s1.foto_nakes, s2.saved_photo)) as foto_url')
        //     ->leftjoinsub($s1, 's1', function($join){
        //         $join->on('tbl_pengajuan.id', 's1.id_pengajuan')->on('tbl_pengajuan.perubahan', 's1.perubahan');
        //     })
        //     ->leftjoinsub($s2, 's2', function($join){
        //         $join->on('tbl_pengajuan.id_user', 's2.id_user');
        //     })
        //     ->joinsub($s3, 's3', function($join){
        //         $join->on('tbl_pengajuan.id_doc', 's3.id_doc');
        //     })
        //     ->where('id_faskes', $id_faskes)
        //     ->orderby('s2.last_login', 'desc')
        //     ->get();


        return DB::table(DB::raw("(SELECT id, id_doc, isApproved, id_faskes, tracker, perubahan, id_user FROM tbl_pengajuan WHERE id_faskes = '".$id_faskes."' UNION ALL SELECT concat('L',id) as id, id_doc, isApproved, id_faskes, tracker, remark as perubahan, id_nakes as id_user FROM tbl_sip_lama WHERE id_faskes = '".$id_faskes."') as mtb"))
            ->selectRAW('ifnull(s1.nama_nakes, s2.name) as nama_nakes, ifnull(s1.profesi,s3.profesi) as profesi, ifnull(s1.foto_nakes,s2.saved_photo) as foto_nakes, ifnull(s1.tgl_doc,s3.tgl_doc) as tgl_doc, ifnull(s1.filename_sip,0) as filename_sip, isApproved, tracker as status_terakhir, concat("https://esip.cilacapkab.go.id/storagefoto/",ifnull(s1.foto_nakes, s2.saved_photo)) as foto_url')
            ->leftjoinsub($s1, 's1', function($join){
                $join->on('mtb.id', 's1.id_pengajuan')->on('mtb.perubahan', 's1.perubahan');
            })
            ->leftjoinsub($s2, 's2', function($join){
                $join->on('mtb.id_user', 's2.id_user');
            })
            ->joinsub($s3, 's3', function($join){
                $join->on('mtb.id_doc', 's3.id_doc');
            })
            ->where('id_faskes', $id_faskes)
            
            ->orderby('s2.last_login', 'desc')
            ->limit(50)
            ->get();
    }

    public function getchartpelayanan($year) {

        $data = DB::select("CALL GetSipDataByYearSum(?)", [$year]);

        $transposedData = [];
        foreach ($data as $row) {
            $periode = $row->periode; // Use -> notation to access object properties
            if (!isset($transposedData[$periode])) {
                $transposedData[$periode] = [
                    'periode' => $periode,
                    'total' => 0,
                    'terlambat' => '0',
                ];
            }
            $transposedData[$periode]['total'] += (int)$row->total; // Use -> notation
            if ($row->terlambat === '1') { // Use -> notation
                $transposedData[$periode]['terlambat'] = '1';
            }
        }
        //return $transposedArray = array_values($transposedData);
        $labels = array_keys($transposedData);
        $totalData = array_column($transposedData, 'total');
        $terlambatData = array_column($transposedData, 'terlambat');

        return $areaChartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Terselesaikan',
                    'backgroundColor' => 'rgba(60,141,188,0.9)',
                    'borderColor' => 'rgba(60,141,188,0.8)',
                    'pointRadius' => false,
                    'pointColor' => '#3b8bba',
                    'pointStrokeColor' => 'rgba(60,141,188,1)',
                    'pointHighlightFill' => '#fff',
                    'pointHighlightStroke' => 'rgba(60,141,188,1)',
                    'data' => $totalData,
                ],
                [
                    'label' => 'Terlambat',
                    'backgroundColor' => 'rgba(210, 214, 222, 1)',
                    'borderColor' => 'rgba(210, 214, 222, 1)',
                    'pointRadius' => false,
                    'pointColor' => 'rgba(210, 214, 222, 1)',
                    'pointStrokeColor' => '#c1c7d1',
                    'pointHighlightFill' => '#fff',
                    'pointHighlightStroke' => 'rgba(220,220,220,1)',
                    'data' => $terlambatData,
                ],
            ],
        ];

    }

    public function detailrekappelayanan($year) {

        return $data = DB::select("CALL GetRekapPtsp(?)", [$year]);

    }
    
    public function getperiodesip() {
        return DB::table('tbl_pengajuan')
            ->selectRAW('distinct substr(updated_at,1,4) as yearly')
            ->orderby(DB::RAW('substr(updated_at,1,4)'), 'desc')
            ->get();
    }

    public function updatesipmanual($request) {
        $jenis = $request->jenis;
        $id = $request->id_pengajuan;
        $updater = $request->updater;

        return DB::table('tbl_sip_lama')
            ->where('id', $id)
            ->update([
                'isApproved' => $jenis,
                'updater' => $updater,
                'tracker' => 'Pengajuan SIP Lama Disetujui DPMPTSP',
                'updated_at' => date('Y-m-d H:i:s'),
                'status_sip' => '1'
            ]);
    }

    public function issipmanual($user_id, $salinan) {

        $ismanual = DB::table('tbl_docs')
            ->select('sip_manual')
            ->where('id_user', $user_id)
            ->where('salinan', $salinan)
            ->where('isDiajukan', '1')
            ->first();
        
        if($ismanual) {
            if($ismanual->sip_manual == '1') {
                $getid = DB::table('tbl_sip_lama')
                    ->select('id')
                    ->where('id_nakes', $user_id)
                    ->where('salinan', $salinan)
                    ->where('isApproved', '2')
                    ->first();
                if($getid) {
                    $id_pengajuan = $getid->id;
                } else {
                    $id_pengajuan = 1;
                }
                return $id_pengajuan;

            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function tolaksipmanual($id, $jenis, $keterangan, $updater) {

        if($jenis == 'lokasi') {

            return DB::table('tbl_sip_lama')
                ->where('id', $id)
                ->update([
                    'tolak_lokasi' => '1',
                    'alasan_lokasi' => $keterangan,
                    'updater' => $updater
                ]);
            
        } else if($jenis == 'jadwal') {

            return DB::table('tbl_sip_lama')
                ->where('id', $id)
                ->update([
                    'tolak_jadwal' => '1',
                    'alasan_jadwal' => $keterangan,
                    'updater' => $updater
                ]);

        } else {

            return DB::table('tbl_sip_lama')
                ->where('id', $id)
                ->update([
                    'tolak_file' => '1',
                    'alasan_tolak' => $keterangan,
                    'updater' => $updater,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'tracker' => 'Permohonan Ditolak DPMPTSP',
                    'isApproved' => '9'
                ]);

        }

    }

    /// getting nearby ////
    public function haversineDistance($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371000; // Radius of the Earth in meters
    
        // Check if any of the latitude or longitude values are not well-formed numeric values
        if (!is_numeric($lat1) || !is_numeric($lon1) || !is_numeric($lat2) || !is_numeric($lon2)) {
            return 0;
        }
    
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
             
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        $distance = $earthRadius * $c;
        
        return $distance;
    }
    
    public function getNearbyPoints($targetLat, $targetLon, $pointsArray, $maxDistance) {
        $nearbyPoints = [];
    
        foreach ($pointsArray as $point) {
            $lat = (float) $point->latitude; // Convert latitude to float
            $lon = (float) $point->longitude; 
            $distance = $this->haversineDistance($targetLat, $targetLon, $lat, $lon);

            if ($distance <= $maxDistance) {
                // Clone or extend point with distance
                $point->distance = $distance;
                $nearbyPoints[] = $point;
            }
        }
    
        return $nearbyPoints;
    }

    public function getnakessekitar($request) {

        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $maximumDistance = 1000;
        $arrayid = [];

        if ($request->filled('distance')) {
            $maximumDistance = $request->input('distance');
        }
        if ($request->filled('isFaskes') && $request->filled('jenis_profesi')) {
            $jenis_profesi = $request->jenis_profesi;
            $s1 = DB::table('tbl_docs')
                ->select('id as id_doc', 'id_user', 'jenis_profesi')
                ->where('jenis_doc', 'like', 'STR%');

            $points = DB::table('tbl_pengajuan')
                ->select('id', 'longitude', 'latitude')
                ->joinsub($s1, 's1', function($join){
                    $join->on('tbl_pengajuan.id_user', 's1.id_user')->on('tbl_pengajuan.id_doc', 's1.id_doc');
                })
                ->where('isApproved', '4')
                ->whereNotIn('latitude', [$latitude, ''])
                ->whereNotIn('longitude', [$longitude, ''])
                ->where('s1.jenis_profesi', $jenis_profesi)
                ->where('isFaskes', 0)
                ->get()
                ->toArray();

            
        } else {

            $points = DB::table('tbl_pengajuan')
            ->select('id', 'longitude', 'latitude')
            ->where('isApproved', '4')
            ->whereNotIn('latitude', [$latitude, ''])
            ->whereNotIn('longitude', [$longitude, ''])
            ->get()
            ->toArray(); // Convert the collection to a plain array


        }
        

        
        $nearbyPoints = $this->getNearbyPoints($latitude, $longitude, $points, $maximumDistance);
        
        $distanceMap = [];
        foreach ($nearbyPoints as $point) {
            $distanceMap[$point->id] = round($point->distance, 1);
            $arrayid[] = $point->id; // Keep array of IDs for query
        }


        $s1 = DB::table('users')
            ->select('id', 'saved_photo', 'name')
            ->orderBy('last_login');

        $s2 = DB::table('tbl_pendaftaran')
            ->select('id_user', 'profesi');

        $results = DB::table('tbl_pengajuan')
            ->select(
                'tbl_pengajuan.id',
                'tbl_pengajuan.id_user',
                'alamat_pengajuan',
                's2.profesi',
                's1.saved_photo',
                's1.name',
                'nama_faskes',
                'latitude',
                'longitude'
            )
            ->leftJoinSub($s1, 's1', function ($join) {
                $join->on('tbl_pengajuan.id_user', 's1.id');
            })
            ->leftJoinSub($s2, 's2', function ($join) {
                $join->on('tbl_pengajuan.id_user', 's2.id_user');
            })
            ->where('isApproved', '4')
            ->whereIn('tbl_pengajuan.id', $arrayid)
            ->where('latitude', '<>', $latitude)
            ->where('longitude', '<>', $longitude)
            ->limit(20)
            ->get();

        // Attach distance from $distanceMap
        $results->transform(function ($row) use ($distanceMap) {
            $row->distance = $distanceMap[$row->id] ?? null;
            return $row;
        });

        return $results;
        
    }

    public function getnakesinmap($request) {

        $profesi = $request->profesi;

        $s1 = DB::table('users')
            ->select('id', 'saved_photo', 'name')
            ->orderby('last_login');

        $s2 = DB::table('tbl_pendaftaran')
            ->select('id_user', 'profesi');

        if(is_array($profesi) && count($profesi) > 0) {

            return DB::table('tbl_pengajuan')
            ->select('tbl_pengajuan.id_user',DB::raw('case when tbl_pengajuan.isFaskes = "0" then "Mandiri" else tbl_pengajuan.nama_faskes end as location'), 'alamat_pengajuan', 's2.profesi', 's1.saved_photo', 's1.name', 'nama_faskes', 'latitude', 'longitude')
            ->joinsub($s1, 's1', function($join){
                $join->on('tbl_pengajuan.id_user', 's1.id');
            })
            ->leftjoinsub($s2, 's2', function($join){
                $join->on('tbl_pengajuan.id_user', 's2.id_user');
            })
            ->where('isApproved', '4')
            ->whereIn(DB::raw('UPPER(s2.profesi)'), $profesi)
            ->get();

        
        } else {

            return DB::table('tbl_pengajuan')
            ->select('tbl_pengajuan.id_user',DB::raw('case when tbl_pengajuan.isFaskes = "0" then "Mandiri" else tbl_pengajuan.nama_faskes end as location'), 'alamat_pengajuan', 's2.profesi', 's1.saved_photo', 's1.name', 'nama_faskes', 'latitude', 'longitude')
            ->joinsub($s1, 's1', function($join){
                $join->on('tbl_pengajuan.id_user', 's1.id');
            })
            ->leftjoinsub($s2, 's2', function($join){
                $join->on('tbl_pengajuan.id_user', 's2.id_user');
            })
            ->where('isApproved', '4')
            ->get();

        }

    }

    public function getpilihanprofesi() {
        return DB::table('tbl_docs')
            ->select(DB::raw('distinct profesi as profesi'))
            ->where('jenis_doc', 'like', 'STR%')
            ->orderby('profesi')
            ->get();
    }

    public function getfaskesinmap($request) {

        return DB::table('master_faskes')
            ->where('status_faskes', '1')
            ->get();
    }


    public function getuserinactive() {

        $s1 = DB::table('tbl_docs')
            ->select('id_user', 'kompetensi', 'no_doc', 'kadaluarsa', 'jenis_doc')
            ->where('jenis_doc', 'STR1');

        $s2 = DB::table('master_alasan')
            ->select('kd_alasan', 'nama_alasan');

        
        return DB::table('users')
            ->select('users.id', 'users.name','s1.no_doc', 's1.kompetensi', 's2.nama_alasan')
            ->leftjoinsub($s1, 's1', function($join) {
                $join->on('users.id', 's1.id_user');
            })
            ->leftjoinsub($s2, 's2', function($join) {
                $join->on(DB::raw('substr(s1.kadaluarsa,2)'), 's2.kd_alasan');
            })
            ->whereRAW('users.id in (SELECT distinct id_user FROM tbl_docs WHERE kadaluarsa in ("C3", "C4", "C5") and jenis_doc like "STR%") and users.id in (SELECT distinct id_user FROM tbl_pengajuan WHERE isApproved = "CF")')
            ->get();
    }

    public function reaktifasiuser($request) {
        $id_user = $request->id_user;

        return DB::table('tbl_docs')
            ->where('id_user', $id_user)
            ->where('jenis_doc', 'like', 'STR%')
            ->update([
                'kadaluarsa' => '0',
                'isDiajukan' => '0',
                'updated_at' => date('Y-m-d')
            ]);
    }

    public function isUserExist($username) {

        $getuser = DB::table('users')
            ->where('username', $username)
            ->where('isActive','1')
            ->first();

        if($getuser) {
            return true;
        } else {
            return false;
        }
    }

    public function getaboutkadal($jenis) {

        $s1 = DB::table('users')
            ->select('id', 'saved_photo', 'name');

        if($jenis == 'sip') {

            return DB::table('tbl_sip')
                ->select('tbl_sip.*', 's1.saved_photo')
                ->leftjoinsub($s1, 's1', function($join) {
                    $join->on('s1.id', 'tbl_sip.id_nakes');
                })
                ->where('expiring_count', '<', '100')
                ->where('status_sip', '1')
                ->get();

        } else {

            return DB::table('tbl_docs')
                ->select('tbl_docs.*', 's1.saved_photo', 's1.name as nama_nakes')
                ->leftjoinsub($s1, 's1', function($join) {
                    $join->on('s1.id', 'tbl_docs.id_user');
                })
                ->where('expiring_count', '<', '100')
                ->where('kadaluarsa', '0')
                ->where('jenis_doc', 'STR1')
                ->get();
        }

    }


    public function draftingPencabutanSip($id_sip, $nip_tte, $isplt, $nama_tte, $pangkat_tte, $id_template, $selectedfixed) {

        $alasan_tercetak = '';

        $s1 = DB::table('tbl_pengajuan')
            ->select('id as id_pengajuan', 'alasan');
        
        $s2 = DB::table('master_alasan')
            ->select('kd_alasan', 'nama_alasan');

        $no_surat = '400.7.22/XXXXX/24/CLP';

        if (Str::contains($id_sip, 'M_'))
        {
            $idsiplama = Str::replace('M_', '', $id_sip);


            $qID = DB::table('tbl_sip_lama')
            ->select('tbl_sip_lama.namafile as filename_sip',DB::raw('ifnull(s2.kd_alasan, "99") as kd_alasan'),DB::raw('ifnull(s2.nama_alasan,tbl_sip_lama.alasan_lain) as nama_alasan'))
            ->leftjoinsub($s2, 's2', function($join) {
                $join->on('s2.kd_alasan', 'tbl_sip_lama.alasan');
            })
            ->where('id', $idsiplama)
            ->where('status_sip', 'CF')
            ->first();

            if($qID) {
                $alasan_tercetak = $qID->nama_alasan;
                $filename_pencabutan = 'C_'.$qID->filename_sip;

                return DB::table('tbl_sip_lama')
                ->where('id', $idsiplama)
                ->where('status_sip', 'CF')
                ->update([

                    'nip_tte_c' => $nip_tte,
                    'is_plt_c' => $isplt,
                    'pangkat_tte_c' => $pangkat_tte,
                    'nama_tte_c' => $nama_tte,
                    'alasan_tercetak' => $alasan_tercetak,
                    'filename_pencabutan' => $filename_pencabutan,
                    'no_surat_pencabutan' => $no_surat,
                    'updated_at' => date('Y-m-d H:i:s')
                    
                ]);
                
            } else {
                return false;
            }

        } else {

            $qID = DB::table('tbl_sip')
            ->select('tbl_sip.filename_sip','tbl_sip.expiring_count',DB::raw('ifnull(s2.kd_alasan, "99") as kd_alasan'),DB::raw('ifnull(s2.nama_alasan,s1.alasan) as nama_alasan'))
            ->joinsub($s1, 's1', function($join) {
                $join->on('s1.id_pengajuan', 'tbl_sip.id_pengajuan');
            })
            ->leftjoinsub($s2, 's2', function($join) {
                $join->on('s2.kd_alasan', 's1.alasan');
            })
            ->where('id', $id_sip)
            ->where('status_sip', 'CF')
            ->first();

            
            

            if($qID) {
                if($qID->expiring_count < 30 && $qID->kd_alasan != '9') {
                    $alasan_tercetak = 'Masa berlaku SIP telah habis dan '.$qID->nama_alasan;
                } else {
                    $alasan_tercetak = $qID->nama_alasan;
                }
                $filename_pencabutan = 'C_'.$qID->filename_sip;

                return DB::table('tbl_sip')
                ->where('id', $id_sip)
                ->where('status_sip', 'CF')
                ->update([

                    'nip_tte_c' => $nip_tte,
                    'is_plt_c' => $isplt,
                    'pangkat_tte_c' => $pangkat_tte,
                    'nama_tte_c' => $nama_tte,
                    'alasan_tercetak' => $alasan_tercetak,
                    'filename_pencabutan' => $filename_pencabutan,
                    'no_surat_pencabutan' => $no_surat,
                    'updated_at' => date('Y-m-d H:i:s')
                    
                ]);
                
            } else {
                return false;
            }



        }


    }

    public function getdraftsipcabut($id_sip){

        $src = DB::table('tbl_docs')
                ->select('id_user', 'salinan', 'tgl_doc', 'no_doc')
                ->where('jenis_doc', 'like', 'REKOMDOKC%');

        $s1 = DB::table('tbl_docs')
                ->select('id as id_doc', 'id_user', 'tgl_doc', 'no_doc', 'tgl_berlaku', 'kompetensi', 'profesi', 'jenis_profesi', 'salinan')
                ->where('jenis_doc', 'like', 'STR%');

        if (Str::contains($id_sip, 'M_'))
        {
            $idsiplama = Str::replace('M_', '', $id_sip);

            

            $s2 = DB::table('tbl_docs')
                ->select('id_user', 'nama_doc as nama_nakes', 'tgl_doc as ttl_nakes', DB::raw('CONCAT(remark1, ", Kecamatan ",remark2," Kabupaten ",remark3) as alamat_nakes'))
                ->where('jenis_doc', 'KTP');

            

            $s3 = DB::table('master_alasan')
                ->select('kd_alasan', 'nama_alasan');

            return DB::table('tbl_sip_lama')
                ->select('filename_pencabutan', DB::raw('"" as no_rekomdinkes, "" as tgl_rekomp, s2.ttl_nakes as ttl_nakes, s2.alamat_nakes as alamat_nakes, "0" as jadwal_praktek, "" as no_rekomp, "0" as perubahan'),'tgl_pencabutan', 's1.no_doc as no_str', 's1.tgl_doc', 's1.tgl_berlaku', 's1.kompetensi', 's1.profesi', 'alamat_pengajuan as nama_lokasi', 'kecamatan as kec_lokasi', 'kabupaten as kab_lokasi', 'no_surat_pencabutan','is_plt_c', 'nama_tte_c', 'pangkat_tte_c', 'nip_tte_c', 'alasan_tercetak', 'tbl_sip_lama.salinan', 's1.jenis_profesi', 'nama_faskes', 's2.nama_nakes', 'no_sip as no_surat', 'id_nakes', 'suratpencabutan', 'tgl_verifdinkes','src.tgl_doc as tgl_rekomc', 'src.no_doc as no_rekomc','s1.jenis_profesi as isapj')
                ->leftjoinsub($s1, 's1', function($join) {
                    $join->on('tbl_sip_lama.id_nakes', 's1.id_user')->on('tbl_sip_lama.id_doc', 's1.id_doc');
                })
                ->leftjoinsub($s2, 's2', function($join) {
                    $join->on('tbl_sip_lama.id_nakes', 's2.id_user');
                })
                ->leftjoinsub($s3, 's3', function($join) {
                    $join->on('tbl_sip_lama.alasan', 's3.kd_alasan');
                })
                ->leftjoinsub($src, 'src', function($join) {
                    $join->on('tbl_sip_lama.id_nakes', 'src.id_user')->on('tbl_sip_lama.salinan', 'src.salinan');
                })
                ->where ('id', $idsiplama)
                ->where('status_sip', 'CF')
                ->first();

        } else {

            return DB::table('tbl_sip')
                ->select('tbl_sip.*', 'src.tgl_doc as tgl_rekomc', 'src.no_doc as no_rekomc', 's1.jenis_profesi as isapj')
                ->leftjoinsub($src, 'src', function($join) {
                    $join->on('tbl_sip.id_nakes', 'src.id_user')->on('tbl_sip.salinan', 'src.salinan');
                })
                ->leftjoinsub($s1, 's1', function($join) {
                    $join->on('tbl_sip.id_nakes', 's1.id_user')->on('tbl_sip.id_doc', 's1.id_doc');
                })
                ->where ('id', $id_sip)
                ->where('status_sip', 'CF')
                ->first();

        }
        

    }

    public function setstatuscabutsip($id_sip, $jenis) {

        if (Str::contains($id_sip, 'M_'))
        {
            $idsiplama = Str::replace('M_', '', $id_sip);
            return DB::table('tbl_sip_lama')
                ->where('id', $idsiplama)
                ->where('status_sip', 'CF')
                ->update([
                    'updated_at' => date('Y-m-d H:i:s'),
                    'suratpencabutan' => $jenis
                ]);

        } else {

            return DB::table('tbl_sip')
                ->where('id', $id_sip)
                ->where('status_sip', 'CF')
                ->update([
                    'updated_at' => date('Y-m-d H:i:s'),
                    'suratpencabutan' => $jenis
                ]);

        }
        
    }

    public function listsipperprofesi($request) {
        $jenis_profesi = $request->carijenisprofesi;
        $isFaskes = $request->cariisfaskes;
        if($jenis_profesi == 'DALL') {

            $s1 = DB::table('tbl_docs')
            ->select('id_user', 'salinan')
            ->whereIn(DB::raw('upper(jenis_profesi)'), ['DU', 'DS', 'DGS', 'DG'])
            ->where('isDiajukan', '1');

        } else if($jenis_profesi == 'DUALL'){

            $s1 = DB::table('tbl_docs')
            ->select('id_user', 'salinan')
            ->whereIn(DB::raw('upper(jenis_profesi)'), ['DU', 'DS'])
            ->where('isDiajukan', '1');

        } else if($jenis_profesi == 'DGALL'){

            $s1 = DB::table('tbl_docs')
            ->select('id_user', 'salinan')
            ->whereIn(DB::raw('upper(jenis_profesi)'), ['DGS', 'DG'])
            ->where('isDiajukan', '1');

        } else if($jenis_profesi == 'ALL'){

            $s1 = DB::table('tbl_docs')
            ->select('id_user', 'salinan')
            //->whereIn(DB::raw('upper(jenis_profesi)'), ['DGS', 'DG'])
            ->where('isDiajukan', '1');

        } else {
            $s1 = DB::table('tbl_docs')
            ->select('id_user', 'salinan')
            ->where(DB::raw('upper(jenis_profesi)'), $jenis_profesi)
            ->where('isDiajukan', '1');
        }
        
        

        $s2 = DB::table('tbl_pendaftaran')
            ->select('id_user', 'notelp');

        $s3 = DB::table('master_faskes')
            ->select('id_faskes', 'status_faskes', 'remark');
        
        $s4 = DB::table('tbl_pengajuan')
            ->select('id as id_pengajuan', 'id_faskes','isFaskes');
        
        $result1 = DB::table('tbl_sip')
            ->select('tbl_sip.nama_nakes', 'tbl_sip.no_str', 'tbl_sip.no_surat', 'tbl_sip.kompetensi', 'tbl_sip.salinan', 'tbl_sip.nama_faskes', DB::raw('CONCAT(tbl_sip.nama_lokasi,", Kecamatan ",tbl_sip.kec_lokasi) as nama_lokasi'), 'tbl_sip.kec_lokasi', 'tbl_sip.signed_date', 'tbl_sip.valid_until', 's2.notelp', DB::raw('ifnull(s3.remark, "-") as nomor_ijin'))
            ->joinsub($s1, 's1', function($join) {
                $join->on('tbl_sip.id_nakes', 's1.id_user')->on('tbl_sip.salinan', 's1.salinan');
            })
            ->leftjoinsub($s2, 's2', function($join) {
                $join->on('tbl_sip.id_nakes', 's2.id_user');
            })
            ->leftjoinsub($s4, 's4', function($join) {
                $join->on('tbl_sip.id_pengajuan', 's4.id_pengajuan');
            })
            ->leftjoinsub($s3, 's3', function($join) {
                $join->on('s4.id_faskes', 's3.id_faskes');
            })
            ->where('status_sip', '1')
            ->where('s4.isFaskes', '1')
            ->get();

        $result2 = DB::table('tbl_sip')
            ->select('tbl_sip.nama_nakes', 'tbl_sip.no_str', 'tbl_sip.no_surat', 'tbl_sip.kompetensi', 'tbl_sip.salinan', 'tbl_sip.nama_faskes', DB::raw('CONCAT(tbl_sip.nama_lokasi,", Kecamatan ",tbl_sip.kec_lokasi) as nama_lokasi'), 'tbl_sip.kec_lokasi', 'tbl_sip.signed_date', 'tbl_sip.valid_until', 's2.notelp', DB::raw('ifnull(s3.remark, "-") as nomor_ijin'))
            ->joinsub($s1, 's1', function($join) {
                $join->on('tbl_sip.id_nakes', 's1.id_user')->on('tbl_sip.salinan', 's1.salinan');
            })
            ->leftjoinsub($s2, 's2', function($join) {
                $join->on('tbl_sip.id_nakes', 's2.id_user');
            })
            ->leftjoinsub($s4, 's4', function($join) {
                $join->on('tbl_sip.id_pengajuan', 's4.id_pengajuan');
            })
            ->leftjoinsub($s3, 's3', function($join) {
                $join->on('s4.id_faskes', 's3.id_faskes');
            })
            ->where('status_sip', '1')
            ->where('s4.isFaskes', '0')
            ->get();

        if($isFaskes == '2') {

            $sourceRecords = $result1->union($result2);

        } else if ($isFaskes == '1') {
            
            $sourceRecords = $result1;

        } else {

            $sourceRecords = $result2;
        }

        return $sourceRecords;
        
    }


    public function hapussiplama($request) {
        try {
            $id_pengajuan_ = $request->id_pengajuan;
            $id_pengajuan = substr($id_pengajuan_, 1);
            $salinan = $request->salinan;
            $id_nakes = $request->id_nakes;
    
            // Start a database transaction
            DB::beginTransaction();
    
            // Delete record from tbl_sip_lama
            DB::table('tbl_sip_lama')
                ->where('id', $id_pengajuan)
                ->delete();
    
            // Update record in tbl_docs
            DB::table('tbl_docs')
                ->where('id_user', $id_nakes)
                ->where('salinan', $salinan)
                ->where('jenis_doc', 'like', 'STR%')
                ->update([
                    'isDiajukan' => '0',
                    'sip_manual' => '0'
                ]);
    
            // Commit the database transaction
            DB::commit();
    
            // Both transactions were successful, so return true
            return true;
        } catch (\Exception $e) {
            // An error occurred, rollback changes and return false
            DB::rollBack();
            return false;
        }
        
    }

    public function submitsupbeforeesip($request, $filenamenya) {
        $id_user = $request->tUserIdBeforeSip;
        $no_doc = $request->tNoDocBeforeSip;
        $tgl_doc_ = $request->tTglBeforeSip;
        $tgl_doc = $this->tgl_indo_sip($tgl_doc_);

        DB::table('tbl_docs')
            ->where('id_user', $id_user)
            ->where('jenis_doc', 'like', 'STR%')
            ->update([
                'remark5' => $tgl_doc,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        //to reset all pengajuan from perpanjangan//
        DB::table('tbl_pengajuan')
            ->where('id_user', $id_user)
            ->where('isperpanjangan', '1')
            ->update([
                'isperpanjangan' => '0'
            ]);

        DB::table('tbl_sip_external')
            ->where('id_user', $id_user)
            ->delete();


        return DB::table('tbl_sip_external')
            ->insert([
                'id_user' => $id_user,
                'no_sip' => $no_doc,
                'tgl_doc' => $tgl_doc,
                'filename_sip' => $filenamenya,
                'kadaluarsa' => '0',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function getexistingbefore($request){

        $id_user = $request->tUserIdBeforeSip;
        $no_doc = $request->tNoDocBeforeSip;
        $tgl_doc_ = $request->tTglBeforeSip;
        $tgl_doc = $this->tgl_indo_sip($tgl_doc_);
        $exisiting = false;

        $getid = DB::table('tbl_sip_external')
            ->select('id')
            ->where('id_user', $id_user)
            ->where('no_sip', $no_doc)
            ->where('tgl_doc', $tgl_doc)
            ->first();
        if($getid) {
            $exisiting = true;
        }

        return $exisiting;

    }

    public function getniktte($id_tte){
        return DB::table('users')
            ->select('photo_url')
            ->where('id', $id_tte)
            ->whereNotNull('photo_url')
            ->first();
    }

    public function gethistoripengajuanapproval($request) 
    {

        $start_date = $request->searchstartdate;
        $end_date = $request->searchenddate;
        $no_str = $request->searchSTR;
        $nama_nakes = $request->searchnamanakes;
        $lokasi = $request->searchlokasi;
        $userrole = $request->userrolesearch;

        $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%" AND tbl_pengajuan.alamat_pengajuan LIKE "%'.$lokasi.'%" AND s1.no_doc LIKE "%'.$no_str.'%" AND tbl_pengajuan.created_at BETWEEN "'.$start_date.'" AND "'.$end_date.'"';


        if ($userrole == 'admindinkes') {

            $s0 = DB::table('users')
                ->select('id', 'name', 'photo_url', 'isActive')
                ->orderBy('id');

            $s1 = DB::table('tbl_docs')
                ->select('id', 'id_user', 'salinan', 'no_doc')
                ->where('kadaluarsa','<>','1');

            $s2 = DB::table('tbl_sip')
                ->select('id_pengajuan', 'status_sip', 'signed_date', 'perubahan');
        

            return DB::table('tbl_pengajuan')
                ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.no_doc, ifnull(s2.signed_date,"Belum TTE") as status_tte'))
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_pengajuan.id_user', 's0.id');
                })
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_pengajuan.id_doc', 's1.id');
                })
                ->leftjoinsub($s2, 's2', function($join){
                    $join->on('tbl_pengajuan.id', 's2.id_pengajuan')->on('tbl_pengajuan.perubahan', 's2.perubahan');
                })
                ->whereRaw('isApproved not in ("0", "1")')
                ->whereRaw($clausewhere)
                ->orderby('tbl_pengajuan.updated_at', 'desc')
                ->get();

        } else if ($userrole == 'op') {

            $id_profesi = Auth::user()->class_op;

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

            $s3 = DB::table('tbl_sip')
                ->select('id_pengajuan', 'status_sip', 'signed_date', 'perubahan');
        

            return DB::table('tbl_pengajuan')
                ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.no_doc, ifnull(s3.signed_date,"Belum TTE") as status_tte'))
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_pengajuan.id_user', 's0.id');
                })
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_pengajuan.id_doc', 's1.id');
                })
                ->leftjoinsub($s2, 's2', function($join){
                    $join->on('tbl_pengajuan.id_user', 's2.id_user');
                })
                ->leftjoinsub($s3, 's3', function($join){
                    $join->on('tbl_pengajuan.id', 's3.id_pengajuan')->on('tbl_pengajuan.perubahan', 's3.perubahan');
                })
                ->where('updated_by_op', '1')
                ->where('s2.jenis_profesi', $jenis_profesi)
                ->whereRaw($clausewhere)
                ->orderby('tbl_pengajuan.updated_at', 'desc')
                ->get();
        
        
        } else if ($userrole == 'kadinkes') {

            $s0 = DB::table('users')
                ->select('id', 'name', 'photo_url', 'isActive')
                ->orderBy('id');

            $s1 = DB::table('tbl_docs')
                ->select('id', 'id_user', 'salinan', 'no_doc')
                ->where('kadaluarsa','<>','1');

            $s2 = DB::table('tbl_sip')
                ->select('id_pengajuan', 'status_sip', 'signed_date', 'perubahan');

            $s3 = DB::table('tbl_pengajuan_hist')
                ->select(DB::raw('count(id) as total_id'), 'id')
                ->where('isApproved', '1K')
                ->groupby('id');
        

            return DB::table('tbl_pengajuan')
                ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.no_doc, ifnull(s2.signed_date,"Belum TTE") as status_tte'))
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_pengajuan.id_user', 's0.id');
                })
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_pengajuan.id_doc', 's1.id');
                })
                ->leftjoinsub($s2, 's2', function($join){
                    $join->on('tbl_pengajuan.id', 's2.id_pengajuan')->on('tbl_pengajuan.perubahan', 's2.perubahan');
                })
                // ->joinsub($s3, 's3', function($join){
                //     $join->on('tbl_pengajuan.id', 's3.id');
                // })
                ->whereRaw('isApproved not in ("0", "1")')
                ->whereRaw('tbl_pengajuan.id in (SELECT distinct id FROM tbl_pengajuan_hist where isApproved = "1K")')
                ->whereRaw($clausewhere)
                ->orderby('tbl_pengajuan.updated_at', 'desc')
                ->get();

        } else if ($userrole == 'superadmin'){

            $s0 = DB::table('users')
                ->select('id', 'name', 'photo_url', 'isActive')
                ->orderBy('id');

            $s1 = DB::table('tbl_docs')
                ->select('id', 'id_user', 'salinan', 'no_doc')
                ->where('kadaluarsa','<>','1');

            $s2 = DB::table('tbl_sip')
                ->select('id_pengajuan', 'status_sip', 'signed_date', 'perubahan');
        

            return DB::table('tbl_pengajuan')
                ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.no_doc, ifnull(s2.signed_date,"Belum TTE") as status_tte'))
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_pengajuan.id_user', 's0.id');
                })
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_pengajuan.id_doc', 's1.id');
                })
                ->leftjoinsub($s2, 's2', function($join){
                    $join->on('tbl_pengajuan.id', 's2.id_pengajuan')->on('tbl_pengajuan.perubahan', 's2.perubahan');
                })
                ->whereRaw($clausewhere)
                ->orderby('tbl_pengajuan.updated_at', 'desc')
                ->get();


        }  else {

            if ($request->has('cabuttinjau') && $request->cabuttinjau == '1')
            {

                $clausewhere = 's0.name LIKE "%'.$nama_nakes.'%" AND tbl_pengajuan.alamat_pengajuan LIKE "%'.$lokasi.'%" AND no_str LIKE "%'.$no_str.'%" AND tgl_tte_pencabutan BETWEEN "'.$start_date.'" AND "'.$end_date.'"';
                
              
                $s0 = DB::table('users')
                ->select('id', 'name', 'photo_url', 'isActive')
                ->orderBy('id');
    
                $s1 = DB::table('tbl_sip')
                    ->select('id_pengajuan', 'filename_sip', 'id as id_sip', 'suratpencabutan', 'verifdinkes', 'tgl_tte_pencabutan', 'no_str');
    
                $s2 = DB::table('master_faskes')
                    ->select('id_faskes', 'nama_faskes');
    
                $s3 = DB::table('master_alasan')
                    ->select('kd_alasan', 'nama_alasan');
    
                $s4 = DB::table('tbl_docs')
                    ->select('id_user', 'salinan','jenis_profesi', 'profesi')
                    ->where('jenis_doc', 'like', 'STR%');


                $siplama = DB::table('tbl_sip_lama')
                    ->select(DB::raw('CONCAT("M_",tbl_sip_lama.id) as id'), 'alamat_pengajuan', 'updated_at', 'isFaskes', 'isApproved', DB::raw('ifnull(s3.nama_alasan,0) as alasan'), 'id_nakes as id_user', DB::raw('"0" as perubahan'), 's0.name', 's0.photo_url', DB::raw('CONCAT("M_",tbl_sip_lama.id) as id_sip'), 'suratpencabutan', DB::raw('"Non Elektronik" as jenis'), 'nama_faskes', DB::raw('ifnull(s3.nama_alasan,0) as nama_alasan'), DB::raw('"1" as isverdinkes'), DB::raw('"1" as siplama'), 's4.jenis_profesi', 'tgl_tte_pencabutan', 'no_sip')
                    ->leftjoinsub($s0, 's0', function($join){
                        $join->on('tbl_sip_lama.id_nakes', 's0.id');
                    })
                    ->leftjoinsub($s3, 's3', function($join){
                        $join->on('tbl_sip_lama.alasan', 's3.kd_alasan');
                    })
                    ->leftjoinsub($s4, 's4', function($join){
                        $join->on('tbl_sip_lama.id_nakes', 's4.id_user')->on('tbl_sip_lama.salinan', 's4.salinan');
                    })
                    ->whereIn('isApproved', ['C', 'CF'])
                    ->where('suratpencabutan', '1')
                    ->whereNotNull('tgl_tte_pencabutan')
                    ->where('verifdinkes', '1');


                return DB::table('tbl_pengajuan')
                    ->select(DB::raw('tbl_pengajuan.id, tbl_pengajuan.alamat_pengajuan, tbl_pengajuan.updated_at, tbl_pengajuan.isFaskes, tbl_pengajuan.isApproved, tbl_pengajuan.alasan, tbl_pengajuan.id_user, tbl_pengajuan.perubahan, s0.name, s0.photo_url, s1.id_sip, s1.suratpencabutan, "Elektronik" as jenis, s2.nama_faskes, ifnull(s3.nama_alasan,0) as nama_alasan, "1" as isverdinkes'), DB::raw('"0" as siplama'), 's4.jenis_profesi', 's1.tgl_tte_pencabutan', 's1.no_str as no_sip')
                    ->leftjoinsub($s0, 's0', function($join){
                        $join->on('tbl_pengajuan.id_user', 's0.id');
                    })
                    ->leftjoinsub($s1, 's1', function($join){
                        $join->on('tbl_pengajuan.id', 's1.id_pengajuan');
                    })
                    ->leftjoinsub($s2, 's2', function($join){
                        $join->on('tbl_pengajuan.id_faskes', 's2.id_faskes');
                    })
                    ->leftjoinsub($s3, 's3', function($join){
                        $join->on('tbl_pengajuan.alasan', 's3.kd_alasan');
                    })
                    ->leftjoinsub($s4, 's4', function($join){
                        $join->on('tbl_pengajuan.id_user', 's4.id_user')->on('tbl_pengajuan.salinan', 's4.salinan');
                    })
                    ->whereRAW('isApproved in ("CF")')
                    ->union($siplama)
                    ->where('suratpencabutan', '1')
                    ->whereRaw($clausewhere)
                    ->whereNotNull('s1.tgl_tte_pencabutan')
                    ->orderBy('tgl_tte_pencabutan', 'DESC')
                    ->get();

            }

            $s0 = DB::table('users')
                ->select('id', 'name', 'photo_url', 'isActive')
                ->orderBy('id');

            $s1 = DB::table('tbl_docs')
                ->select('id', 'id_user', 'salinan', 'no_doc')
                ->where('kadaluarsa','<>','1');

            $s2 = DB::table('tbl_sip')
                ->select('id_pengajuan', 'status_sip', 'signed_date', 'perubahan');
        

            return DB::table('tbl_pengajuan')
                ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.no_doc, ifnull(s2.signed_date,"Belum TTE") as status_tte'))
                ->leftjoinsub($s0, 's0', function($join){
                    $join->on('tbl_pengajuan.id_user', 's0.id');
                })
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_pengajuan.id_doc', 's1.id');
                })
                ->leftjoinsub($s2, 's2', function($join){
                    $join->on('tbl_pengajuan.id', 's2.id_pengajuan')->on('tbl_pengajuan.perubahan', 's2.perubahan');
                })
                ->whereRaw('isApproved not in ("0", "1", "2")')
                ->whereRaw($clausewhere)
                ->orderby('tbl_pengajuan.updated_at', 'desc')
                ->get();

        }
    }

    public function gethistoridaftarapprove($request)
    {
        $nama_nakes = $request->searchnamanakesapp;
        $kompetensi = $request->searchkompetensi;
        $no_str = $request->searchSTRapp;
        $email = $request->searchemail;
        $notelp = $request->searchnohp;
        $start_date = $request->searchstartdate;
        $end_date = $request->searchenddate;

        if (trim($nama_nakes) == '') {
            $clausewhere = 'tbl_pendaftaran.nama LIKE "%'.$nama_nakes.'%" AND tbl_pendaftaran.kompetensi LIKE "%'.$kompetensi.'%" AND tbl_pendaftaran.no_reg LIKE "%'.$no_str.'%" AND tbl_pendaftaran.email LIKE "%'.$email.'%" AND tbl_pendaftaran.notelp LIKE "%'.$notelp.'%" AND tbl_pendaftaran.updated_at BETWEEN "'.$start_date.' " AND "'.$end_date.'"';
        } else {
            $clausewhere = 'tbl_pendaftaran.nama LIKE "%'.$nama_nakes.'%" AND tbl_pendaftaran.kompetensi LIKE "%'.$kompetensi.'%" AND tbl_pendaftaran.no_reg LIKE "%'.$no_str.'%" AND tbl_pendaftaran.email LIKE "%'.$email.'%" AND tbl_pendaftaran.notelp LIKE "%'.$notelp.'%"';
        }

        $isverdinkes = DB::raw('CASE WHEN (profesi like "%APOTEKER%" OR profesi like "%VOKASI%") AND template_id in ("3","4") THEN "1" ELSE "0" END as isverdinkes');

        $s2 = DB::table('tbl_docs')
            ->select('id_user', 'no_doc as no_reg', 'kompetensi', 'tgl_doc as str_hingga', 'namafile as origin_file')
            ->where('jenis_doc','STR1');

        $jika = DB::raw('IFNULL(s2.no_reg, tbl_pendaftaran.no_reg) as no_reg, IFNULL(s2.kompetensi, tbl_pendaftaran.kompetensi) as kompetensi, IFNULL(s2.str_hingga, tbl_pendaftaran.str_hingga) as str_hingga, IFNULL(s2.origin_file, tbl_pendaftaran.origin_file) as origin_file');

        

        $s1 = DB::table('users')
            ->select('id', 'saved_photo', 'isActive', 'class_op')
            ->where('role','nakes');

        return DB::table('tbl_pendaftaran')
            ->select('tbl_pendaftaran.id', 'nama', 'url_qr', 'status_str', 'jenis_kelamin', 'profesi', 'tgl_keluar_str', 'img_src', 'email', 'notelp', 'salinan', 'created_at', 'updated_at', 'current_status', 'updater', 'tbl_pendaftaran.id_user', 'default_pass', 'doc_status', 'jenis_profesi', 'template_id','universitas', 'foto_not_avail', 'fixed_berlaku_hingga', 'remark', 's1.class_op', 's1.saved_photo', 's1.isActive', $isverdinkes, $jika)
            ->leftjoinsub($s1, 's1', function($join){
                $join->on('tbl_pendaftaran.id_user', 's1.id');
            })
            ->leftjoinsub($s2, 's2', function($join){
                $join->on('tbl_pendaftaran.id_user', 's2.id_user');
            })
            ->where('current_status', '1')
            ->whereRaw($clausewhere)
            //->whereBetween('tbl_pendaftaran.updated_at', [$oneMonthAgo, Carbon::now()])
            ->orderby('tbl_pendaftaran.updated_at', 'desc')
            ->get();

        return true;


    }

    public function updatefotonakes($id_user, $imageName)
    {
        return DB::table('users')
            ->where('id', $id_user)
            ->update([
                'saved_photo' => $imageName
            ]);
        
    }

    public function getiduser($id_pendaftaran)
    {
        $qid = DB::table('tbl_pendaftaran')
            ->select('id_user')
            ->where('id', $id_pendaftaran)
            ->first();
        
        return $qid->id_user;

    }

    public function getusernonseumurhidup()
    {
        $s1 = DB::table('tbl_docs')
            ->select('id_user', 'tgl_doc', 'no_doc', 'profesi', 'namafile')
            ->where('jenis_doc','STR1')
            ->where('tgl_doc', '<>', 'Seumur Hidup');

        $s2 = DB::table('tbl_pengajuan')
            ->select('id_user', DB::raw('count(id) as total_pengajuan'))
            ->where('isApproved','4')
            ->groupby('id_user');

        return DB::table('users')
            ->select('users.id as id_user', 'users.name as nama', 'users.saved_photo', 's1.tgl_doc', 's1.no_doc as no_reg', 's1.profesi', 'users.foto_not_avail', 's1.namafile as origin_file', 's2.total_pengajuan')
            ->joinsub($s1, 's1', function($join){
                $join->on('users.id', 's1.id_user');
            })
            ->leftjoinsub($s2, 's2', function($join){
                $join->on('users.id', 's2.id_user');
            })
            ->orderby('users.name')
            ->get();
            

    }


    public function ubahukuranfotosip($request)
    {
        $ukuran = $request->ukuran;
        $id_pengajuan = $request->id_pengajuan;

        return DB::table('tbl_pengajuan')
            ->where('id', $id_pengajuan)
            ->update([
                'ukuran' => $ukuran
            ]);
    }

    public function getdetailnakesbyidpendaftar($id_pendaftar)
    {
        $id_user = '';
        $getid = DB::table('tbl_pendaftaran')
            ->select('id_user')
            ->where('id', $id_pendaftar)
            ->first();

        if($getid){
            $id_user = $getid->id_user;
        } else {
            return false;
        }


        $s2 = DB::table('tbl_docs')
            ->select('id_user', 'namafile', 'tgl_doc', 'no_doc', 'kompetensi', 'profesi', 'url_qr', 'remark5 as berlaku_esip', 'isDiajukan')
            ->where('jenis_doc', 'STR1')
            ->where('id_user', $id_user);

        return DB::table('users')
            ->select('s2.*', 'users.name as nama_nakes')
            ->leftjoinsub($s2, 's2', function($join){
                $join->on('users.id', 's2.id_user');
            })
            ->where('isActive', '1')
            ->where('id', $id_user)
            ->first();

    }

    public function processperpanjanganbyadmin($request)
    {
        $filename = $request->stWhichnvDok;
        $id_user = $request->stUserIDNakesDoknv;
        $no_str = $request->stNoSTRnv;
        $jenis_profesi = $request->stProfesinv;

        if (strpos($jenis_profesi, 'DOKTER') !== false) {
            // Split the words in the profession name
            $words = explode(' ', $jenis_profesi);
            // Take the first letter of each word to form an abbreviation
            $abbreviation = implode('', array_map(fn($word) => $word[0], $words));

            $jenis_profesi = $abbreviation;
        } 


        $kompetensi = $request->stKompetensinv;
        $tgl_berlaku = $request->stSTRtetapSIPnv;
        $url_qr = $request->stURLnv;
        if (empty($url_qr)) {
            $geturl = DB::table('tbl_docs')
                ->select('url_qr')
                ->where('id_user', $id_user)
                ->where('jenis_doc', 'like', 'STR%')
                ->first();
            if($geturl) {
                $url_qr = $geturl->url_qr; 
            } else {
                $url_qr = 'manual';
            }
        }
        //$isseumurnv = $request->isseumurnv;
        $tgl_berlaku_ = $this->tgl_indo_sip($tgl_berlaku);
        if ($request->has('isseumurnv')) {
            $tgl_doc = 'Seumur Hidup';
            $expiring_count = '99999';
            $tgl_doc_ = $tgl_doc;
        } else {
            $tgl_doc = $request->stSTRHinggaSIPnv;
            $expiring_count = '99999';
            $tgl_doc_ = $this->tgl_indo_sip($tgl_doc);
            $getselisih = DB::select(DB::raw('call selisihexpire("'.$tgl_doc_.'")'));
            if($getselisih) {
                $expiring_count = $getselisih[0]->selisihhari;
            }
        }

        $getlatestperpanjangan = DB::table('tbl_pengajuan')
            ->select('perpanjangan', 'id')
            ->where('id_user', $id_user)
            ->where('isApproved', '4')
            ->first();

        if($getlatestperpanjangan)
        {
            $perpanjangan = $getlatestperpanjangan->perpanjangan;
            $nextperpanjangan = (int)$perpanjangan + 1;
            $id_pengajuan = $getlatestperpanjangan->id;

            $updateDetails = [
                'updater' => $id_user,
                'perpanjangan' => $nextperpanjangan,
                'isApproved' => '0',
                'isperpanjangan' => '1',
                'updated_at' => date('Y-m-d H:i:s')
            ];

            DB::table('tbl_pengajuan')
            ->where('id', $id_pengajuan)
            ->update($updateDetails);
        }

   
        DB::table('tbl_sip')
            ->where('id_nakes', $id_user)
            ->update([
                'status_sip' => 'E'
            ]);

        return DB::table('tbl_docs')
            ->where('id_user', $id_user)
            ->where('jenis_doc', 'like', 'STR%')
            ->update([
                'no_doc' => $no_str,
                'kompetensi' => $kompetensi,
                'jenis_profesi' => $jenis_profesi,
                'tgl_doc' => $tgl_doc_,
                'tgl_doc_origin' => $tgl_doc,
                'tgl_berlaku' => $tgl_berlaku_,
                'expiring_count' => $expiring_count,
                'url_qr' => $url_qr,
                'updated_at' => date('Y-m-d H:i:s'),
                'updater' => 'admin',
                'namafile' => $filename,
                'remark4' => 1,
                'remark5' => null,
                'is_compromised' => '0',
                'keterangan_tolak' => null
            ]);
    }

    public function reaktifasinakes($request)
    {
        $id_pendaftaran = $request->id_pendaftaran;
        $isActive = $request->isActive;

        $getid = DB::table('tbl_pendaftaran')
            ->select('id_user')
            ->where('id', $id_pendaftaran)
            ->first();

        if($getid) {
            $id_user = $getid->id_user;
        } else {
            return false;
        }

        return DB::table('users')
            ->where('id', $id_user)
            ->update([
                'isActive' => $isActive
            ]);

    }


    public function getsummarylayanan($request)
    {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Summary Laporan Layanan';
        $parsed = json_decode($request->getContent(), true);
        $result = $parsed['result'] ?? null;

        $prompting = 'Buatkan Ulasan dari data result berikut. Data ini menceritakan tentang data Chart pelayanan per periode, total artinya banyaknya pengajuan, terlambat artinya berapa pengajuan yang teralambat ditangani, total_perubahan artinya ada pengajuan perubahan dokumen, total_pencabutan artinya pencabutan dokumen, total_mandiri artinya pengajuan mandiri, total_faskes artinya pengajuan praktik ke faskes yang terdaftar. buatkan ulasan seperti, periode mana yang terbaik, tersibuk dan kurang baik';

        $username = config('app.summary_user');
        $password = config('app.summary_pass');
        $urlai = config('app.summary_host').'146ef2e5-6202-46aa-a3f0-483e27ba572d';

        $client = new Client();

        try {
            $response = $client->post($urlai, [
                'auth' => [$username, $password],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'prompting' => $prompting,
                    'result' => $result,
                ],
            ]);

            $body = json_decode((string) $response->getBody(), true);
            

            if (json_last_error() === JSON_ERROR_NONE) {
                $data['success'] = true;
                $data['summary'] = $body[0]['text'] ?? '[No summary returned]';
                $data['keterangan'] = 'Summary JSON Berhasil';
            } else {
                $data['keterangan'] = 'Gagal parsing JSON: ' . json_last_error_msg();
            }
        } catch (\Exception $e) {
            $data['keterangan'] = 'Exception: ' . $e->getMessage();
        }

        return $data;
    }

    public function gettextstr($text)
    {
        $data = [
            'success' => false,
            'keterangan' => 'Gagal Mendapatkan Informasi STR',
        ];

        $prompting = 'dari input berikut, Temukan Profesi, Tanggal (jika tanggal kurang dari tanggal sekarang artinya tanggal keluar (tgl_str), jika lebih besar artinya tanggal berlaku (str_hingga), kemudian tgl_str adalah tanggal keluar dalam format YYYY-MM-DD), jika ada lifetime / seumur hidup maka tanggal berlaku = seumur hidup, kemudian buat output dalam bentuk JSON. Contoh output: {"profesi":"dokter", "tgl_str":"24 Januari 2025","str_hingga":"seumur hidup"}';

        $username = config('app.summary_user');
        $password = config('app.summary_pass');
        $urlai = config('app.summary_host') . '86dc40a8-ce73-46e1-93be-b5c4c16eda28';

        $client = new Client();

        try {
            $response = $client->post($urlai, [
                'auth' => [$username, $password],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'prompting' => $prompting,
                    'input' => $text,
                ],
            ]);

            $status = $response->getStatusCode();

            if ($status === 200) {
                // Decode JSON body into associative array
                $body = (string) $response->getBody();
                $extractres = json_decode($body, true);

                // Handle successful JSON parse
                if (json_last_error() === JSON_ERROR_NONE) {
         
                    if (is_array($extractres) && isset($extractres[0])) {
                        $data = $extractres[0];
                    } else {
                        // If the response is already a single object
                        $data = $extractres;
                    }

                } else {
                    $data = false;
                }
            } else {
                $data = false;
            }

        } catch (\Exception $e) {
            $data = false;
        }

        return $data;
    }

    public function sendtoreminder($jenis, $id_pengajuan)
    {
        
        $username = config('app.summary_user');
        $password = config('app.summary_pass');
        $urlai = config('app.summary_host').'be60aafe-28a1-4ebd-9bed-37ea3875aff3';
        //$urlai = 'http://172.16.200.29:5678/webhook-test/be60aafe-28a1-4ebd-9bed-37ea3875aff3';

        $client = new Client();

        try {
            $response = $client->post($urlai, [
                'auth' => [$username, $password],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'kategori' => $jenis,
                    'id_pengajuan' => $id_pengajuan,
                    'role' => 'admin',
                ],
                'timeout' => 5,           // total request timeout
                'connect_timeout' => 5,
            ]);

            return true;
        } catch (\Exception $e) {
            return true;
        }

    }

    public function getcurrentprofesi($request)
    {
        $data['success'] = false;
        $id_nakes = $request->id_nakes;
        $countsip = DB::table('tbl_sip')
            ->where('id_nakes', $id_nakes)
            ->where('status_sip', 1)
            ->count();
        $alias = 'DG';
        
        $data['totalsip'] = $countsip;
        $currentprof = DB::table('tbl_docs')
            ->select('jenis_profesi')
            ->where('id_user', $id_nakes)
            ->where('jenis_doc', 'STR1')
            ->first();
        if($currentprof)
        {
            $alias = $currentprof->jenis_profesi;
        }

        $case = DB::raw('CASE WHEN alias_profesi = "'.$alias.'" THEN "selected" ELSE "" END as selection');
        $allprofesi = DB::table('master_profesi')
            ->select($case, 'alias_profesi', 'nama_profesi', 'id_profesi')
            ->where('isActive', '1')
            ->orderby('nama_profesi')
            ->get();
        
        if(count($allprofesi) > 0)
        {
            $data['success'] = true;
        }

        $data['allprofesi'] = $allprofesi;
        return $data;
    }

    public function setujupencabutanbidfar($request, $tgl_setuju)
    {
        $siplama = $request->siplama;
        $id_pengajuan = $request->id_pengajuan;
        $isadmin = $request->isadmin;

        if($siplama == '1')
        {
            if($isadmin == '1')
            {

                $getiddoc = DB::table('tbl_sip_lama')
                    ->select('id_doc')
                    ->where('id', $id_pengajuan)
                    ->first();

                if($getiddoc)
                {
                    $id_doc = $getiddoc->id_doc;

                    DB::table('tbl_sip_lama')
                        ->where('id', $id_pengajuan)
                        ->update([
                            'isApproved' => 'CF',
                            'status_sip' => 'CF',
                            'tgl_pencabutan' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

                    return DB::table('tbl_docs')
                        ->where('id', $id_doc)
                        ->update([
                            'sip_manual' => 0
                        ]);

                } else {
                    return false;
                } 

            } else {

                return DB::table('tbl_sip_lama')
                    ->where('id', $id_pengajuan)
                    ->update([
                        'verifdinkes' => 1,
                        'tgl_verifdinkes' => $tgl_setuju,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                

            }

            

        } else {

            return DB::table('tbl_sip')
            ->where('id_pengajuan', $id_pengajuan)
            ->update([
                'verifdinkes' => 1,
                'tgl_verifdinkes' => $tgl_setuju
            ]);

        }
        
        
        
    }

    public function getlogcabut($request)
    {

        $s0 = DB::table('users')
            ->select('id', 'name');

        $filename = $request->fileba;
        return DB::table('log_dok_cabut')
            ->select('log_dok_cabut.updated_at', 'log_dok_cabut.keterangan', 's0.name')
            ->leftjoinsub($s0, 's0', function($join){
                $join->on('log_dok_cabut.updater', 's0.id');
            })
            ->where('filename_rekom', $filename)
            ->orderby('updated_at', 'desc')
            ->get();

    }

    public function updatedokpencabutanlog($request)
    {
        $filename = $request->fileba;
        $id_user = $request->id_user;
        $pesan = $request->pesan;
        $id_doc = '0';
        $id_sip = '0';
 
        $getid = DB::table('log_dok_cabut')
            ->select('id_doc', 'id_sip')
            ->where('filename_rekom', $filename)
            ->first();
        if($getid){

            $id_doc = $getid->id_doc;
            $id_sip = $getid->id_sip;
            return DB::table('log_dok_cabut')
                ->insert([
                    'id_doc' => $id_doc,
                    'id_sip' => $id_sip,
                    'filename_rekom' => $filename,
                    'updater' => $id_user,
                    'keterangan' => $pesan,
                    'updated_at' => date('Y-m-d H:i:s')

                ]);

        } else {

            $getiduser = DB::table('tbl_docs')
                ->select('id_user')
                ->where('namafile', $filename)
                ->first();

            $id_user = $getiduser->id_user;

            if (Str::contains($request->id, 'M_'))
            {
                $getid = DB::table('tbl_sip_lama')
                    ->select('id_doc', 'id as id_sip')
                    ->where('id_nakes', $id_user)
                    ->where('status_sip','<>', '1')
                    ->first();

                $id_doc = $getid->id_doc;
                $id_sip = $request->id;

            } else {

                $getid = DB::table('tbl_sip')
                    ->select('id_doc', 'id as id_sip')
                    ->where('id_nakes', $id_user)
                    ->where('status_sip','<>', '1')
                    ->first();

                $id_doc = $getid->id_doc;
                $id_sip = $getid->id_sip;

            }
            
            return DB::table('log_dok_cabut')
                ->insert([
                    'id_doc' => $id_doc,
                    'id_sip' => $id_sip,
                    'filename_rekom' => $filename,
                    'updater' => $id_user,
                    'keterangan' => $pesan,
                    'updated_at' => date('Y-m-d H:i:s')

                ]);
            //return false;
        }

        
    }

    public function chatwithai($request)
    {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Summary Laporan Layanan';
        $sessionId = $request->chatInput;
        $chatInput = $request->chatInput;


        $username = config('app.summary_user');
        $password = config('app.summary_pass');
        $urlai = config('app.summary_host').'adc1cd15-455d-467c-bc09-e197b33b6fa2';

        $client = new Client();

        try {
            $response = $client->post($urlai, [
                'auth' => [$username, $password],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'sessionId' => $sessionId,
                    'chatInput' => $chatInput,
                ],
            ]);

            //$body = json_decode((string) $response->getBody(), true);
            $status = $response->getStatusCode();
            if($status == 200)
            {
                $reply = $response->getBody()->getContents();
                $htmlMessage = nl2br($reply);

                // Convert **bold** to <strong>
                $htmlMessage = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $htmlMessage);

                // Convert "* " lists to <ul><li>
                $htmlMessage = preg_replace('/\* +(.*?)(?=<br>|$)/', '<li>$1</li>', $htmlMessage);

                $data['success'] = true;
                $data['reply'] = $htmlMessage;
                $data['keterangan'] = 'Summary JSON Berhasil';

            }
            
        } catch (\Exception $e) {
            $data['keterangan'] = 'Exception: ' . $e->getMessage();
        }

        return $data;
    }

    public function setreminder($request)
    {
        $response = [
            'send' => false
        ];

        $kategori = $request->kategori;
        // 9 meaning penolakan
        // T meaning TTE
        $id_pengajuan = $request->id_pengajuan;

        if($kategori == '9')
        {
            $still = DB::table('tbl_pengajuan')
                ->select('id_user', 'id_faskes', 'nama_faskes', 'alamat_pengajuan')
                ->where('id', $id_pengajuan)
                ->where('isApproved', $kategori)
                ->first();

            if($still)
            {
                if($still->id_faskes == '0')
                {
                    $pesan = 'Ajuan Anda Yang Ditolak Pada: '.$still->alamat_pengajuan.' Belum Diperbaiki, Segera Periksa Pada Aplikasi e-SIP';

                } else {
                    $pesan = 'Ajuan Anda Yang Ditolak Pada Faskes: '.$still->nama_faskes.' Belum Diperbaiki, Segera Periksa Pada Aplikasi e-SIP';
                }
                
                $getnohp = DB::table('tbl_pendaftaran')
                    ->select('notelp')
                    ->where('id_user', $still->id_user)
                    ->first();

                if($getnohp)
                {
                    $response = [
                        'send' => true,
                        'pesan' => $pesan,
                        'nowa' => $getnohp->notelp
                    ];
                } 

            }

            return $response;

        }
    }


    public function getnomorfornotifcabut($fileba)
    {

        $getiduser = DB::table('tbl_docs')
                ->select('id_user')
                ->where('namafile', $filename)
                ->first();

        $id_user = $getiduser->id_user;


        $getid = DB::table('tbl_sip')
            ->select('id_doc', 'id as id_sip')
            ->where('id_nakes', $id_user)
            ->where('status_sip','<>', '1')
            ->first();


        $id_doc = $getid->id_doc;
        $id_sip = $getid->id_sip;
        

    }

    public function supernakesdetail($id_nakes)
    {
        return true;

    }

    public function generatepesanadmin($pesan, $nama, $password, $keterangan, $jenis)
    {
        //jenis 1 : pendaftaran akftifasi, jenis 11: pendaftaran harus upload ulang dok, jenis 1p: aktifasi bersama pass, jenis 2: reset password, jenis 3: pengajuan berhasil Dinkes ke PTSP, jenis 31: pengajuan berhasil dinkes ke Kadinkes, jenis 4 : pengajuan berhasil PTSP, jenis 5 : pengajuan akan di TTE, jenis 6: pengajuan telah di TTE, jenis 61: TTE dan mengunduh, jenis 6C: dokumen pencabutan, jenis 99C: pencabutan ditolak, jenis 99 : pengajuan ditolak, jenis 7: STR ditahan untuk e-SIP

        if($password !='')
        {
            if ($jenis == '1')
            {
                $jenis = '1P';
            } else if ($jenis == '11')
            {
                $jenis = '11P';
            }
            
        } 
    

        switch ($jenis) {

            case '1':
                $pesanVariants = [
                    'Selamat '.$nama.' Datang di e-SIP. akun anda sudah díaktifasi dan dapat digunakan untuk upload dokumen dan pendaftaran praktek.',
                
                    'Halo '.$nama.', Akun e-SIP Anda Sudah diaktifkan. Demi keamanan akun, mohon segera mengganti password secara berkala.',
                
                    'Pendaftaran atas nama '.$nama.' telah berhasil disetujui. Username dan password Anda telah aktif digunakan. Jangan lupa melakukan pergantian password secara rutin.',
                
                    'Selamat datang '.$nama.'. Akun Anda telah berhasil diverifikasi dan diaktifkan. Untuk menjaga keamanan akun, disarankan melakukan perubahan password secara berkala.',
                ];
                $pesanadmin = $pesanVariants[array_rand($pesanVariants)];
                return $pesanadmin;
    
            case '11':
                $pesanVariants = [
                    'Selamat '.$nama.' Datang di e-SIP. akun anda sudah díaktifasi dan dapat digunakan untuk upload dokumen dan pendaftaran praktek. Mohon Upload Ulang Dokumen STR yang diajukan',
                
                    'Halo '.$nama.', Akun e-SIP Anda Sudah diaktifkan. Demi keamanan akun, mohon segera mengganti password secara berkala. Mohon Upload Ulang Dokumen STR yang diajukan',
                
                    'Pendaftaran atas nama '.$nama.' telah berhasil disetujui. Username dan password Anda telah aktif digunakan. Jangan lupa melakukan pergantian password secara rutin. Mohon Upload Ulang Dokumen STR yang diajukan',
                
                    'Selamat datang '.$nama.'. Akun Anda telah berhasil diverifikasi dan diaktifkan. Untuk menjaga keamanan akun, disarankan melakukan perubahan password secara berkala. Mohon Upload Ulang Dokumen STR yang diajukan',
                ];
                $pesanadmin = $pesanVariants[array_rand($pesanVariants)];
                return $pesanadmin;

            case '1P':

                $pesanVariants = [
                    'Selamat '.$nama.' Datang di e-SIP. akun anda sudah díaktifasi dan dapat digunakan untuk upload dokumen dan pendaftaran praktek. Password Anda: '.$password.' , Segera Lakukan Perubahan',
                
                    'Halo '.$nama.', Akun e-SIP Anda Sudah diaktifkan. Demi keamanan akun, mohon segera mengganti password secara berkala. Password Anda: '.$password.' , Segera Lakukan Perubahan',
                
                    'Pendaftaran atas nama '.$nama.' telah berhasil disetujui. Username dan password Anda telah aktif digunakan. Password Anda: '.$password.' , Segera Lakukan Perubahan',
                
                    'Selamat datang '.$nama.'. Akun Anda telah berhasil diverifikasi dan diaktifkan. Password Anda: '.$password.' , Segera Lakukan Perubahan',
                ];
                $pesanadmin = $pesanVariants[array_rand($pesanVariants)];
                return $pesanadmin;

            
            case '11P':

                $pesanVariants = [
                    'Selamat '.$nama.' Datang di e-SIP. akun anda sudah díaktifasi dan dapat digunakan untuk upload dokumen dan pendaftaran praktek. Mohon Upload Ulang Dokumen STR yang diajukan, Password Anda: '.$password.' , Segera Lakukan Perubahan',
                
                    'Halo '.$nama.', Akun e-SIP Anda Sudah diaktifkan. Demi keamanan akun, mohon segera mengganti password secara berkala. Mohon Upload Ulang Dokumen STR yang diajukan, Password Anda: '.$password.' , Segera Lakukan Perubahan',
                
                    'Pendaftaran atas nama '.$nama.' telah berhasil disetujui. Username dan password Anda telah aktif digunakan. Jangan lupa melakukan pergantian password secara rutin. Mohon Upload Ulang Dokumen STR yang diajukan.Password Anda: '.$password.' , Segera Lakukan Perubahan',
                
                    'Selamat datang '.$nama.'. Akun Anda telah berhasil diverifikasi dan diaktifkan. Untuk menjaga keamanan akun, disarankan melakukan perubahan password secara berkala. Mohon Upload Ulang Dokumen STR yang diajukan, Password Anda: '.$password.' , Segera Lakukan Perubahan',
                ];
                $pesanadmin = $pesanVariants[array_rand($pesanVariants)];
                return $pesanadmin;

    
            case '2':
                return "Halo {$nama}, password Anda telah direset. Password baru: {$password}";
    
            case '3':
                $pesanVariants = [
                    'Pengajuan Atas Nama: '.$nama.' Telah ',
                
                    'Halo '.$nama.', Akun e-SIP Anda Sudah diaktifkan. Demi keamanan akun, mohon segera mengganti password secara berkala. Mohon Upload Ulang Dokumen STR yang diajukan',
                
                    'Pendaftaran atas nama '.$nama.' telah berhasil disetujui. Username dan password Anda telah aktif digunakan. Jangan lupa melakukan pergantian password secara rutin. Mohon Upload Ulang Dokumen STR yang diajukan',
                
                    'Selamat datang '.$nama.'. Akun Anda telah berhasil diverifikasi dan diaktifkan. Untuk menjaga keamanan akun, disarankan melakukan perubahan password secara berkala. Mohon Upload Ulang Dokumen STR yang diajukan',
                ];
                $pesanadmin = $pesanVariants[array_rand($pesanVariants)];
                return $pesanadmin;
    
            case '31':
                return "Pengajuan atas nama {$nama} telah disetujui Dinkes dan diteruskan ke Kepala Dinkes.";
    
            case '4':
                return "Pengajuan atas nama {$nama} telah disetujui DPMPTSP.";
    
            case '5':
                return "Pengajuan atas nama {$nama} sedang dalam proses TTE.";
    
            case '6':
                return "Pengajuan atas nama {$nama} telah selesai ditandatangani secara elektronik (TTE).";
    
            case '61':
                return "Dokumen atas nama {$nama} telah selesai TTE dan siap diunduh.";
    
            case '6C':
                return "Dokumen pencabutan SIP atas nama {$nama} telah diterbitkan.";
    
            case '99C':
                return "Pengajuan pencabutan SIP atas nama {$nama} ditolak. {$keterangan}";
    
            case '99':
                return "Pengajuan SIP atas nama {$nama} ditolak. {$keterangan}";
    
            case '7':
                return "STR atas nama {$nama} sedang ditahan untuk proses e-SIP.";
    
            default:
                return $pesan;
        }



    }

    public function logNotifWA($nomor, $pesan)
    {
            try {

                DB::beginTransaction();
                DB::table('log_notifwa')
                    ->insert([
                        'nomor' => $nomor,
                        'pesan' => $pesan,
                        'created_at' => date('Y-m-d')
                    ]);

                DB::commit();
                
                return true;
            } catch (\Exception $e) {
                // An error occurred, rollback changes and return false
                DB::rollBack();
                return true;
            }
    }

    public function getlogwabyname($request)
    {
        $validated = validator($request->all(), [
            'nama' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-Z ]+$/',
            ],
        ])->validate();
    
        $nama = trim($validated['nama']);
    
        $s1 = DB::table('log_notifwa')
            ->select('nomor', 'pesan', 'created_at');
    
        return DB::table('tbl_pendaftaran')
            ->select(
                'tbl_pendaftaran.nama',
                'tbl_pendaftaran.kompetensi',
                's1.nomor',
                's1.pesan',
                's1.created_at'
            )
            ->leftJoinSub($s1, 's1', function ($join) {
                $join->on('tbl_pendaftaran.notelp', '=', 's1.nomor');
            })
            ->where('tbl_pendaftaran.nama', 'like', '%' . $nama . '%')
            ->whereNotNull('tbl_pendaftaran.id_user')
            ->orderby('tbl_pendaftaran.id')
            ->orderby('tbl_pendaftaran.nama')
            ->orderby('s1.created_at', 'desc')
            ->get();

        
    }



}
