<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Carbon\Carbon;

class DinkesModel extends Model
{
    public function getdatatask($posting){

        $user_id = $posting->user_id;
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

    public function getdoc($id, $jenis) {

        return DB::table('tbl_docs')
            ->where('id_user',$id)
            ->where('jenis_doc', $jenis)
            ->get();
    }

    public function getpengajuan($jenis) {

        $s0 = DB::table('users')
            ->select('id', 'name', 'photo_url', 'isActive')
            ->orderBy('id');
        $s1 = DB::table('tbl_docs')
            ->select('id', 'id_user', 'salinan', 'no_doc')
            ->where('kadaluarsa','<>','1');

        if($jenis == 'kadinkes') {

            return DB::table('tbl_pengajuan')
            ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.no_doc, case when s0.isActive = "0" then "resigned" else "aktif" end as isActive'))
            ->leftjoinsub($s0, 's0', function($join){
                $join->on('tbl_pengajuan.id_user', 's0.id');
            })
            ->leftjoinsub($s1, 's1', function($join){
                $join->on('tbl_pengajuan.id_doc', 's1.id');
            })
            ->whereRaw('isApproved in ("1K")')
            ->orderby('tbl_pengajuan.updated_at', 'desc')
            ->get();

        } else {

            return DB::table('tbl_pengajuan')
            ->select(DB::raw('tbl_pengajuan.*, s0.name, s0.photo_url, s1.no_doc, case when s0.isActive = "0" then "resigned" else "aktif" end as isActive'))
            ->leftjoinsub($s0, 's0', function($join){
                $join->on('tbl_pengajuan.id_user', 's0.id');
            })
            ->leftjoinsub($s1, 's1', function($join){
                $join->on('tbl_pengajuan.id_doc', 's1.id');
            })
            ->whereRaw('isApproved in ("0", "1")')
            ->orderby('tbl_pengajuan.updated_at', 'desc')
            ->get();

        }
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

        $s2 = DB::table('tbl_docs')
                ->select('id', 'id_user','namafile', 'url_qr', 'no_doc', 'tgl_doc_origin', 'tgl_doc as berlaku_sampai', 'jenis_profesi');

        $s1 = DB::table('tbl_sip')
                ->select('id_pengajuan', 'perubahan', 'filename_sip', 'filename_pencabutan', 'suratpencabutan');


        return DB::table('tbl_pengajuan')
            ->select('tbl_pengajuan.*', 's3.nama_alasan', 's2.namafile', 's2.url_qr', 's2.no_doc', 's2.tgl_doc_origin','s1.filename_sip', 's2.berlaku_sampai', 's1.filename_pencabutan', 's1.suratpencabutan', 's2.jenis_profesi')
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

    public function getsalinanpengajuan($id) {

        $query = DB::table('tbl_pengajuan')
            ->select('salinan')
            ->where('id', $id)
            ->first();
        
        $salinan = $query->salinan;
        return $salinan;
        
    }

    public function updatevisitasil($id_pengajuan, $id_nakes, $tgl_visitasi, $updater) {

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

    public function checkfixed($id) {

        $inform = '0';
        $getiddoc = DB::table('tbl_pengajuan')
            ->select('id_doc')
            ->where('id', $id)
            ->first();
        
        $id_doc = $getiddoc->id_doc;

        $getfixed = DB::table('tbl_docs')
            ->select('fixed_berlaku_hingga', 'kompetensi')
            ->where('id', $id_doc)
            ->first();

        $isfixed = $getfixed->fixed_berlaku_hingga;

        if ($isfixed != '0') {
            $kompetensi = Str::upper($getfixed->kompetensi) ;
            if (Str::contains($kompetensi, 'BIDAN')) {
                $inform = 'Sesuai dengan UU No. 4 Tahun 2019 tentang Kebidanan, Masa Berlaku SIP Mandiri Ditetapkan Hingga 26 Maret 2026';
            } else if (Str::contains($kompetensi, 'PERAWAT')) {
                $inform = 'Sesuai dengan Nomor 38 Tahun 2014 tentang Perawat, Masa Berlaku SIP Mandiri Ditetapkan Hingga 12 Agustus 2026';
            }
        }

        return $inform;

    }

    public function pilihfixed($id) {

        $inform = '';
        $getiddoc = DB::table('tbl_pengajuan')
            ->select('id_doc')
            ->where('id', $id)
            ->first();
        
        $id_doc = $getiddoc->id_doc;

        $getfixed = DB::table('tbl_docs')
            ->select('fixed_berlaku_hingga', 'kompetensi')
            ->where('id', $id_doc)
            ->first();

        $isfixed = $getfixed->fixed_berlaku_hingga;
        return $isfixed;

    }

    public function pengajuanke($id_nakes, $salinan, $kat) {

        if($kat == 'current') {

            $getmanual = DB::table('tbl_docs')
            ->select('sip_manual')
            ->where("id_user", $id_nakes)
            ->where("salinan", $salinan)
            ->where('jenis_doc', 'like', 'STR%')
            ->first();

            if($getmanual) {
                $sipman = $getmanual->sip_manual;
            } else {
                $sipman = 0;
            }
            

            if($sipman == '1') {

                $s3 = DB::table('master_alasan')
                    ->select('kd_alasan', 'nama_alasan');

                $s2 = DB::table('tbl_docs')
                        ->select('id', 'id_user','namafile', 'url_qr', 'no_doc', 'tgl_doc_origin', 'tgl_doc as berlaku_sampai', 'sip_manual');

                return DB::table('tbl_sip_lama')
                    ->select('tbl_sip_lama.*', 's2.namafile', 's2.url_qr', 's2.no_doc', 's2.tgl_doc_origin', 's2.berlaku_sampai', 's2.sip_manual')
                    ->leftjoinsub($s2, 's2', function($join){
                        $join->on('tbl_sip_lama.id_doc', 's2.id')->on('tbl_sip_lama.id_nakes', 's2.id_user');
                    })
                    ->where('tbl_sip_lama.id_nakes', $id_nakes)
                    ->where('salinan', $salinan)
                    ->first();

            } else {

                $s3 = DB::table('master_alasan')
                    ->select('kd_alasan', 'nama_alasan');

                $s2 = DB::table('tbl_docs')
                        ->select('id', 'id_user','namafile', 'url_qr', 'no_doc', 'tgl_doc_origin', 'tgl_doc as berlaku_sampai', 'sip_manual');

                $s1 = DB::table('tbl_sip')
                        ->select('id_pengajuan', 'filename_sip', 'perubahan')
                        ->where('status_sip', '<>','CF');


                return DB::table('tbl_pengajuan')
                    ->select('tbl_pengajuan.*', 's3.nama_alasan', 's2.namafile', 's2.url_qr', 's2.no_doc', 's2.tgl_doc_origin','s1.filename_sip', 's2.berlaku_sampai', 's2.sip_manual')
                    ->leftjoinsub($s3, 's3', function($join){
                        $join->on('tbl_pengajuan.alasan', 's3.kd_alasan');
                    })
                    ->leftjoinsub($s2, 's2', function($join){
                        $join->on('tbl_pengajuan.id_doc', 's2.id')->on('tbl_pengajuan.id_user', 's2.id_user');
                    })
                    ->leftjoinsub($s1, 's1', function($join){
                        $join->on('tbl_pengajuan.id', 's1.id_pengajuan')->on('tbl_pengajuan.perubahan', 's1.perubahan');
                    })
                    ->where('tbl_pengajuan.id_user', $id_nakes)
                    ->where('salinan', $salinan)
                    ->first();

            }

        } else {

            $getmanual = DB::table('tbl_pengajuan')
                ->select('id')
                ->where("id_user", $id_nakes)
                ->where("salinan", $salinan)
                ->where('isApproved', 'CF')
                ->pluck('id', 'id')
                ->toArray();

            $s3 = DB::table('master_alasan')
                ->select('kd_alasan', 'nama_alasan');

            $s1 = DB::table('tbl_sip')
                    ->select('id_pengajuan', 'filename_sip', 'perubahan', 'signed_date')
                    ->where('status_sip','CF');

            return DB::table('tbl_pengajuan')
                ->select('tbl_pengajuan.*', 's3.nama_alasan','s1.filename_sip', 's1.signed_date')
                ->leftjoinsub($s3, 's3', function($join){
                    $join->on('tbl_pengajuan.alasan', 's3.kd_alasan');
                })
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_pengajuan.id', 's1.id_pengajuan')->on('tbl_pengajuan.perubahan', 's1.perubahan');
                })
                ->where('tbl_pengajuan.id_user', $id_nakes)
                ->where('salinan', $salinan)
                ->whereIn('id', $getmanual)
                ->get();

        }

        

        

    }

    public function jadwalke($id_nakes, $salinan){

        $getmanual = DB::table('tbl_docs')
            ->select('sip_manual')
            ->where("id_user", $id_nakes)
            ->where('salinan', $salinan)
            ->where('jenis_doc', 'like', 'STR%')
            ->first();

        if($getmanual) {
            $sipman = $getmanual->sip_manual;
        } else {
            $sipman = 0;
        }
       
        if($sipman == '1') {

            $getjadw = DB::table('tbl_sip_lama')
                ->select('jadwal_praktik')
                ->where('id_nakes', $id_nakes)
                ->where('salinan', $salinan)
                ->whereIn('isApproved', ['2','4','CF'])
                ->first();

            if($getjadw) {

                $jadwal = $getjadw->jadwal_praktik;
                $jsonjadwal = json_decode($jadwal);
                $arrj = [];
                foreach($jsonjadwal as $jad) {
                    $jadwalarr = json_decode($jad);
                    array_push($arrj, $jadwalarr);
                }

            } else {
                $arrj = 0;
            }

            return $arrj;

        } else {

            $getidpeng = DB::table('tbl_pengajuan')
            ->select('id')
            ->where('id_user', $id_nakes)
            ->where('salinan', $salinan)
            ->where('isApproved','<>', 'CF')
            ->first();

            if($getidpeng) {

                $id_pengajuan = $getidpeng->id;

                return DB::table('tbl_jadwalpraktik')
                    ->where('kadaluarsa', 0)
                    ->where('id_user', $id_nakes)
                    ->where('salinan', $salinan)
                    ->where('id_pengajuan', $id_pengajuan)
                    ->where('isSet', 1)
                    ->get();

            } else {
                return 0;
            }

        }

    }

    public function detailsipmanual($id){

        return DB::table('tbl_sip_lama')
            ->where('id', $id)
            ->first();

    }

    public function getnikkadinkes()
    {
        return DB::table('users')
            ->select('photo_url as nik')
            ->where('role', 'kadinkes')
            ->first();

    }



    public function draftingSk($id_pengajuan, $nip_tte, $isplt, $nama_tte, $pangkat_tte, $id_template, $selectedfixed, $nik) {

        $qID = DB::table('tbl_pengajuan')
            ->select('id_user','id_doc', 'salinan', 'isFaskes', 'id_faskes', 'alamat_pengajuan', 'kecamatan', 'kabupaten', 'jadwal_praktek', 'tgl_approval_dinkes', 'perubahan', 'perpanjangan', 'remark', 'created_at as tgl_aju')
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
        $tgl_aju = $qID->tgl_aju;

        $tanggal_ajuan = substr($tgl_aju, 0, 10);
        $tgl_aju_indo = $this->tgl_indo_sip($tanggal_ajuan);

        
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


        $qfoto = DB::table('users')
            ->select('saved_photo')
            ->where('id', $id_nakes)
            ->first();
        $foto_nakes = $qfoto->saved_photo;
        

        $qnostr = DB::table('tbl_docs')
            ->select('no_doc', 'tgl_doc', 'tgl_berlaku', 'kompetensi', 'profesi', 'jenis_profesi', 'template_id', 'fixed_berlaku_hingga')
            ->where('jenis_doc', $strke)
            ->where('id_user', $id_user)
            ->where('kadaluarsa', '=', '0')
            ->first();

            
        
        $no_str = $qnostr->no_doc;
        //$valid_until_ = $qnostr->tgl_doc;
        $valid_until_ = '29 Februari 2999';
        $currentDate = Carbon::now();
        $valid_until_fn = $currentDate->addYears(5)->format('Y-m-d');
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
        } else {
            $profesi = ucwords($profesi);
        }
        $jenisprofesi = $qnostr->jenis_profesi;
        $templatedaristr = $qnostr->template_id;

        if ($selectedfixed == '2') {

            if (Str::contains(strtoupper($kompetensi), 'BIDAN')) {
                $valid_until = '26 Maret 2026';
            } else {
                $valid_until = '12 Agustus 2026';
            }

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
        
        $filename_sip = 'SK_'.$id_user.'_'.$id_pengajuan.'_'.$salinan.'_'.$nostrfl.'_'.$tglstrfl.'_'.$perubahan;
        
        $status_sip = '0';
        $template_id = 'nakes'.$id_template;
        $jenisrekom = 'REKOMDK'.$salinan;
        $jenisprof = 'REKOMP'.$salinan;
        
        $no_rekomdinkes = '-';
        
        $no_rekomp = '-';
        $tgl_rekomp = '-';

        $qktp = DB::table('tbl_docs')
            ->select('no_doc', 'nama_doc','tgl_doc', 'no_doc', 'remark1', 'remark2', 'remark3', 'remark4', 'jenis_profesi', 'template_id')
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

        $jenisprofdraft = $jenisprofesi;
        $no_surat = '400.7.22/XXXXX/16/'.date('Y').'/CLP';

        // return DB::table('tbl_sk_dinkes')
        //     ->insert([
        //         'id_pengajuan' => $id_pengajuan,
        //         'id_doc' => $id_doc,
        //         'id_user' => $id_nakes,
        //         'salinan' => $salinan,
        //         'nama_nakes' => $nama_nakes,
        //         'kompetensi' => $kompetensi,
        //         'no_str' => $no_str,
        //         'alamat_pengajuan' => $nama_lokasi,
        //         'kecamatan' => $kec_lokasi,
        //         'kabupaten' => $kab_lokasi,
        //         'no_surat' => $no_surat,
        //         'is_plt' => $is_plt,
        //         'nama_tte' => $nama_tte,
        //         'pangkat_tte' => $pangkat_tte,
        //         'nip_tte' => $nip_tte,
        //         'filename_sk' => $filename_sip,
        //         'status_sk' => '0'
        //     ]);
        $getjadwal = DB::table('tbl_jadwalpraktik')
            ->selectRAW(DB::raw("ROW_NUMBER() OVER (PARTITION BY isSet) as nomore, hari, concat(mulai, ' - ', selesai) as pukul, case when is_shift = '1' then 'Shift' else '-' end as isShift, uraian"))
            ->where('id_user', $id_nakes)
            ->where('kadaluarsa', 0)
            ->where('salinan', $salinan)
            ->where('isSet', '1')
            ->get();

        $jadwaljson = json_encode($getjadwal);

        DB::table('tbl_sk_dinkes')
            ->where('status_sk', '0')
            ->where('filename_sk', $filename_sip)
            ->delete();

        $data = [
            'id_pengajuan' => $id_pengajuan,
            'id_doc' => $id_doc,
            'id_user' => $id_nakes,
            'salinan' => $salinan,
            'nama_nakes' => $nama_nakes,
            'kompetensi' => $kompetensi,
            'no_str' => $no_str,
            'nama_lokasi' => $nama_lokasi,
            'kec_lokasi' => $kec_lokasi,
            'kab_lokasi' => $kab_lokasi,
            'no_surat' => $no_surat,
            'jadwal_praktek' => $jadwaljson,
            'is_plt' => $is_plt,
            'nama_tte' => $nama_tte,
            'pangkat_tte' => $pangkat_tte,
            'nip_tte' => $nip_tte,
            'filename_sk' => $filename_sip,
            'tgl_surat' => date('Y-m-d'),
            'tgl_doc' => $tgl_aju_indo,
            'status_sk' => '0',
            'template_id' => 'nakessk',
            'env' => 'prd'
        ];

        return $data;

    }

    public function submitdraftsk($data)
    {
        return DB::table('tbl_sk_dinkes')
             ->insert($data);

    }

    public function getisverif($id_pengajuan){
        $getisverif = DB::table('tbl_pengajuan')
            ->where('id', $id_pengajuan)
            ->where('isApproved', '3')
            ->where('isverif', '1')
            ->first();
        if($getisverif) {
            return true;
        } else {
            return false;
        }
    }

    


}
