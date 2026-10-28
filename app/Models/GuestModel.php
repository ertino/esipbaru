<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuestModel extends Model
{

    public function getlistOPD(){

        return DB::table('tbl_skpd')
        ->get();
    }

    public function getlistApp()
    {

        return DB::table('tbl_apps')
            ->where('isKominfo', '1')
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    
    public function permohonansimpan($posting) {

        $aplikasi = $posting->aplikasi;
        $jenis_servis = $posting->jenis_servis;
        $opd_requester = $posting->opd_requester;
        $tgl_permohonan = $posting->tgl_permohonan;
        $keterangan = $posting->keterangan;
        $lokasi = $posting->lokasi;
        $email = $posting->email;
        $contact_person = $posting->contact_person;
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        if(strlen($tgl_permohonan) > 10) {
            $allday = 0;
        } else {
            $allday = 1;
        }

        $quar = DB::table('tbl_apps')
                ->select('app_name')
                ->where('id', $aplikasi)
                ->first();
            $nama_aplikasi = $quar->app_name;

        if ($opd_requester == '9') {

            $judul = 'Asistensi '.$nama_aplikasi.' '.$keterangan;

        } else {

            $query = DB::table('tbl_skpd')
            ->select('nama')
            ->where('kodes', $opd_requester)
            ->first();
            $nama_opd = $query->nama;

            
            if ($jenis_servis == '1') {
                $judul = 'Asistensi '.$nama_opd. ' Aplikasi '.$nama_aplikasi;
            } else {
                $judul = 'Laporan Dari '.$nama_opd. ' Aplikasi '.$nama_aplikasi;
            }

        }

        
        
        DB::table('tbl_permohonan')
        ->insert([
            'aplikasi' => $aplikasi,
            'jenis_servis' => $jenis_servis,
            'opd_requester' => $opd_requester,
            'tgl_permohonan' => $tgl_permohonan,
            'allDay' => $allday,
            'keterangan' => $keterangan,
            'lokasi' => $lokasi,
            'email' => $email,
            'contact_person' => $contact_person,
            'judul' => $judul,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            'status_permohonan' => 0
        ]);

    }

    public function getevents(){
        return DB::table('tbl_permohonan')
            ->select(DB::raw('id, ifnull(tgl_permohonan_rev,tgl_permohonan) as start, tgl_permohonan_end as end, allDay, judul as title, case when status_permohonan = "0" then "#6f9ecb" when status_permohonan = "1" then "#abc06e" when status_permohonan = "2" then "#e8bb79" else "#9c1b0c" end as color'))
            ->where('status_permohonan','<>','3')
            ->orderBy('id', 'asc')
            ->get();
    }

    
    public function geteventsadmin($posting){

        $user_id = $posting->user_id;

        if ($user_id == '') {
            return DB::table('tbl_permohonan')
            ->select(DB::raw('id, ifnull(tgl_permohonan_rev,tgl_permohonan) as start, tgl_permohonan_end as end, allDay, judul as title, case when status_permohonan = "0" then "#6f9ecb" when status_permohonan = "1" then "#abc06e" when status_permohonan = "2" then "#e8bb79" else "#9c1b0c" end as color'))
            ->where('status_permohonan','<>','3')
            ->orderBy('id', 'asc')
            ->get();

        } else {
            return DB::table('tbl_permohonan')
            ->select(DB::raw('id, ifnull(tgl_permohonan_rev,tgl_permohonan) as start, tgl_permohonan_end as end, allDay, judul as title, case when status_permohonan = "0" then "#6f9ecb" when status_permohonan = "1" then "#abc06e" when status_permohonan = "2" then "#e8bb79" else "#9c1b0c" end as color'))
            ->where('status_permohonan','<>','3')
            ->whereRaw('aplikasi in (select distinct id from tbl_apps where pic_ = "'.$user_id.'")')
            ->orderBy('id', 'asc')
            ->get();

        }
        
    }

    
    public function getdetailevent($posting){

        $id = $posting->id;
        $quar = DB::table('tbl_permohonan')
                ->select('aplikasi', 'jenis_servis', 'opd_requester')
                ->where('id', $id)
                ->first();
        $app_id = $quar->aplikasi;
        $servis_id = $quar->jenis_servis;
        $kodes = $quar->opd_requester;

        $qua = DB::table('tbl_apps')
                ->select('app_name')
                ->where('id', $app_id)
                ->first();
        $nama_aplikasi = $qua->app_name;

        $quat = DB::table('m_servis')
                ->select('service_name')
                ->where('id', $servis_id)
                ->first();
        $nama_servis = $quat->service_name;

        if($kodes == '9') {
            $nama_opd = 'Sesuai Keterangan';
        } else {
            $quak = DB::table('tbl_skpd')
                ->select('nama')
                ->where('kodes', $kodes)
                ->first();
            $nama_opd = $quak->nama;

        }

        return DB::table('tbl_permohonan')
            ->select(DB::raw('id, ifnull(tgl_permohonan_rev,tgl_permohonan) as start, judul as title,case when lokasi = "1" then "Diskominfo" else "OPD pemohon" end as lokasi, case when status_permohonan = "0" then "Direview" when status_permohonan = "1" then "Disetujui" when status_permohonan = "2" then "Dijadwalkan Ulang" else "Dibatalkan" end as status_permohonan, "'.$nama_aplikasi.'" as nama_aplikasi, "'.$nama_servis.'" as nama_servis, "'.$nama_opd.'" as nama_opd, keterangan, email, contact_person, tgl_permohonan_rev, tgl_permohonan, allDay, status_permohonan as status_id'))
            ->where('status_permohonan','<>','3')
            ->where('id','=',$id)
            ->orderBy('id', 'asc')
            ->get();
    }


    public function reviewsimpan($posting) {

        $idUserNilai = $posting->idUserNilai;
        $idAppNilai = $posting->idAppNilai;
        $nilaiUser = $posting->nilaiUser;
        $nilaiApp = $posting->nilaiApp;
        $ttguser = $posting->ttguser;
        $ttgapp = $posting->ttguser;

        $tgl_event = date('Y-m-d');
       
        $created_at = date('Y-m-d H:i:s');
        
        if ($nilaiUser != 0) {

            DB::table('tbl_ratings')
                ->insert([
                    'id_dinilai' => $idUserNilai,
                    'jenis' => 'U',
                    'nilai' => $nilaiUser,
                    'isi_review' => $ttguser,
                    'tgl_event' => $tgl_event,
                    'created_at' => $created_at
                ]);

        }

        if ($nilaiApp != 0) {

            DB::table('tbl_ratings')
                ->insert([
                    'id_dinilai' => $idAppNilai,
                    'jenis' => 'A',
                    'nilai' => $nilaiApp,
                    'isi_review' => $ttgapp,
                    'tgl_event' => $tgl_event,
                    'created_at' => $created_at
                ]);

        }

        return true;
        
        
        

    }

    public function checkexisting($request) {

        $totalcheck = 0;
        $url_qr = $request->stURL;
        $email = $request->stEmail;
        $notelp = $request->stNotelp;
        $no_reg = $request->stNoSTR;

        $countstr = DB::table('tbl_docs')
            ->where('no_doc', $no_reg)
            ->where('jenis_doc', 'STR1')
            ->count();

        $countqr = DB::table('tbl_docs')
            ->where('url_qr', $url_qr)
            ->count();

        $countqrdftr = DB::table('tbl_pendaftaran')
            ->where('url_qr', $url_qr)
            ->count();

        $countemail = DB::table('users')
            ->where('username', $email)
            ->count();
        // $countnotelp = DB::table('tbl_pendaftaran')
        //     ->where('notelp', $notelp)
        //     ->count();
        if($countstr > 0) {
            $totalcheck++;
        }

        if($countqr > 0) {
            $totalcheck++;
        }
        if($countemail > 0) {
            $totalcheck++;
        }
        if ($countqrdftr > 0) {
            $totalcheck++;
        }
        // if($countnotelp > 0) {
        //     $totalcheck++;
        // }

        return $totalcheck;
    }


    public function lanjutpendaftaran($request) {

        $url_qr = $request->stURL;
        $no_reg = $request->stNoSTR;
        $nama = $request->stNama;
        $jk = $request->stJenisK;
        $kompetensi = $request->stKompetensi;
        $profesi = $request->stProfesi;
        $universitas = $request->stUniversitas;
        $chekfixed = strtoupper(trim($kompetensi));
        $fixed_berlaku_hingga = '0';

        $img_src = $request->stImg;
        $origin_file = $request->stWhichF;
        $email = $request->stEmail;
        $notelp = $request->stNotelp;
        $salinan = $request->stSalinan;
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        $current_status = 0;
        $tgl_keluar_str_ori = $request->stStrKeluarOri;
        $str_hingga_ori = $request->stDueOri;
        $tgl_keluar_str = $request->stSTRtetapSIP;
        $str_hingga = $request->stSTRHinggaSIP;
        $pilihanSIP = $request->stProfesiSIP;
        $profesiDD = $request->stProfesiDD;
        $statusStr = $request->stStatDok;

        //check fixed berlaku hingga untuk bidan dan perawat//
        if (Str::contains($chekfixed, 'KEPERAWATAN')) {
            if ( $chekfixed == 'AHLI MADYA KEPERAWATAN' || $chekfixed == 'SARJANA TERAPAN KEPERAWATAN') {
                $getselisih = DB::select(DB::raw('call selisihfixedperawat("'.$str_hingga.'")'));
                if($getselisih >= 0) {
                    $fixed_berlaku_hingga = '12 Agustus 2026';
                }  
            } 
        } else if (Str::contains($chekfixed, 'BIDAN')) {
            if ( $chekfixed == 'AHLI MADYA BIDAN' || $chekfixed == 'SARJANA TERAPAN BIDAN' || $chekfixed == 'BIDAN') {
                $getselisih = DB::select(DB::raw('call selisihfixedbidan("'.$str_hingga.'")'));
                if($getselisih >= 0) {
                    $fixed_berlaku_hingga = '26 Maret 2026';
                }
            } else {
                $fixed_berlaku_hingga = '1';
            }
        } else {
            $fixed_berlaku_hingga = '0';
        }
        

        if($profesi == '') {
            if($profesiDD == 'APT') {
                $profesi = 'APOTEKER';
            } else {

                $querp = DB::table('master_profesi')
                ->where('alias_profesi', $profesiDD)
                ->first();
                $profesi = $querp->nama_profesi;

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
            $jenis_profesi = 'Apt';
            $template_id = $pilihanSIP;
        } else if ($pilihanSIP == '4') {
            $jenis_profesi = 'APJ';
            $template_id = $pilihanSIP;
        } else {
            $jenis_profesi = $profesiDD;
            $template_id = $pilihanSIP;
        }


        $resulting = DB::table('tbl_pendaftaran')
                ->insertGetId([
                    'url_qr' => $url_qr,
                    'status_str' => $statusStr,
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
                    'tgl_keluar_str_conv' => $tgl_keluar_str_conv,
                    'str_hingga_conv' => $str_hingga_conv,
                    'jenis_profesi' => $jenis_profesi,
                    'template_id' => $template_id,
                    'universitas' => $universitas,
                    'fixed_berlaku_hingga' => $fixed_berlaku_hingga
        
                ]);

        return $resulting;

    }

    public function getjadwalnakes($filename){

        // $result = DB::table('tbl_jadwalpraktik')
        //     ->selectRAW(DB::raw("ROW_NUMBER() OVER (PARTITION BY isSet) as nomore, hari, concat(mulai, ' - ', selesai) as pukul, case when is_shift = '1' then 'Shift' else '-' end as isShift"))
        //     ->where('id_user', $id_nakes)
        //     ->where('kadaluarsa', 0)
        //     ->where('salinan', $salinan)
        //     ->where('isSet', '1')
        //     ->get();

        // if ($result->count() > 0) {

        //     return $result;

        // } else {
        //     return false;
        // }
        $iscabut = substr($filename, 0, 1);
        if($iscabut == 'C') {

            $query = DB::table('tbl_sip')
            ->where('filename_pencabutan', $filename)
            ->first();

        } else {

            $issk = substr($filename, 0, 2);
            if($issk == 'SK') {

                $query = DB::table('tbl_sk_dinkes')
                    ->select('id_pengajuan', 'id_user as id_nakes', 'salinan')
                    ->where('filename_sk', $filename)
                    ->first();

            } else {

                $query = DB::table('tbl_sip')
                    ->where('filename_sip', $filename)
                    ->first();
            }

        }

        

        $id_pengajuan = $query->id_pengajuan;
        $id_nakes = $query->id_nakes;
        $salinan = $query->salinan;

        return DB::table('tbl_jadwalpraktik')
                    ->where('id_pengajuan', $id_pengajuan)
                    ->where('kadaluarsa', 0)
                    ->where('id_user', $id_nakes)
                    ->where('salinan', $salinan)
                    ->where('isSet', 1)
                    ->get();
    }

    public function getdetailsip($filename) {

        $s1 = DB::table('users')
            ->select('saved_photo as saved_photo', 'id as id_user')
            ->where('role', 'nakes');

        $s2 = DB::table('tbl_docs')
            ->select('id','url_qr')
            ->where('jenis_doc','LIKE','STR%');

        $iscabut = substr($filename, 0, 1);
        if($iscabut == 'C') {

            $query = DB::table('tbl_sip')
                ->select('tbl_sip.*','s1.saved_photo', 's2.url_qr')
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_sip.id_nakes', 's1.id_user');
                })
                ->leftjoinsub($s2, 's2', function($join){
                    $join->on('tbl_sip.id_doc', 's2.id');
                })
                ->where('filename_pencabutan', $filename)
                ->first();

            if($query) {
                return $query;
            } else {
                return false;
            }

        } else {

            $issk = substr($filename, 0, 2);
            if($issk == 'SK') {

                $query = DB::table('tbl_sk_dinkes')
                ->select('tbl_sk_dinkes.*','s1.saved_photo', 's2.url_qr', 'tbl_sk_dinkes.id_user as id_nakes')
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_sk_dinkes.id_user', 's1.id_user');
                })
                ->leftjoinsub($s2, 's2', function($join){
                    $join->on('tbl_sk_dinkes.id_doc', 's2.id');
                })
                ->where('filename_sk', $filename)
                ->first();

                if($query) {
                    return $query;
                } else {
                    return false;
                }

            } else {

                $query = DB::table('tbl_sip')
                ->select('tbl_sip.*','s1.saved_photo', 's2.url_qr')
                ->leftjoinsub($s1, 's1', function($join){
                    $join->on('tbl_sip.id_nakes', 's1.id_user');
                })
                ->leftjoinsub($s2, 's2', function($join){
                    $join->on('tbl_sip.id_doc', 's2.id');
                })
                ->where('filename_sip', $filename)
                ->first();

                if($query) {
                    return $query;
                } else {
                    return false;
                }

            }

        }

        
    }



    public function cariprofesi($request) {
        $nama_profesi = $request->nama_profesi;
        $carinama = DB::table('master_profesi')
            ->where('nama_profesi', 'like', '%'.$nama_profesi.'%')
            ->get();
        
        if(count($carinama) == 1) {
            return $carinama;
        } else {
            return false;
        }
    }

    public function getallprofesi(){

        return DB::table('master_profesi')
            ->get();

    }

    public function updatetidakfoto($id_pendaftaran) {
        return DB::table('tbl_pendaftaran')
                    ->where('id', $id_pendaftaran)
                    ->update(['foto_not_avail' => '1']);
    }

    public function getenv(){
        $getenv = DB::table('tbl_env')
            ->select('env')
            ->first();

        return $getenv->env;

    }

    public function cobaselisih($tglnya) {

        $getselisih = DB::select(DB::raw('call selisihexpire("'.$tglnya.'")'));
        $selisih = $getselisih[0]->selisihhari;
        
        return $selisih;

    }

    public function convert($request) {
        $id_user = $request->id_user;
        $getbase = DB::table('users')
            ->select('photo_url')
            ->where('id', $id_user)
            ->first();

        $url = $getbase->photo_url;

        $base64String = $url; // Replace with your base64-encoded PNG image
        $base64String = str_replace('data:image/png;base64,', '', $base64String);
        $imageData = base64_decode($base64String);
        $pngImage = imagecreatefromstring($imageData);
        $jpgImage = imagecreatetruecolor(imagesx($pngImage), imagesy($pngImage));
        imagecopy($jpgImage, $pngImage, 0, 0, 0, 0, imagesx($pngImage), imagesy($pngImage));
        ob_start();
        imagejpeg($jpgImage, null, 100);
        $jpgImageData = ob_get_clean();
        $imageName = $id_user.'.jpg';
        $filename_fotone = $id_user.'.jpg';
        \File::put(storage_path('app/fotostr'). '/' . $imageName, $jpgImageData);

        // Free up memory
        imagedestroy($pngImage);
        imagedestroy($jpgImage);

    }

    public function postlogdaftar($thelink, $namafile, $jenis, $skipped, $response)
    {
        $response = $response ?? json_encode(['status' => 'default', 'message' => 'No response provided']);

        // Ensure $response is in JSON format
        if (!is_string($response) || json_decode($response) === null) {
            // Convert to JSON if not already in proper format
            $response = json_encode($response);
        }
        
        $secureUrl = str_replace("http://", "https://", $thelink);
        if ($jenis == 'insert') {

            return DB::table('daftar_logs')
                ->insert([
                    'origin_file' => $namafile,
                    'url_qr' => $secureUrl,
                    'skipped' => $skipped,
                    'result' => $response,
                    'created_at' => date('Y-m-d H:i:s') 
                ]);

        } else {
            
            $getid = DB::table('daftar_logs')
                ->where('url_qr', $secureUrl)
                ->where('origin_file', $namafile)
                ->orderby('id', 'desc')
                ->first();

            if($getid) {
                return $getid->id;
            } else {
                return false;
            }
        }
        
        
    }

    public function guestsubmitcred($request){
        $email = $request->lpemail;
        $nohp = $request->lpnohp;

        $s1 = DB::table('tbl_pendaftaran')
            ->select('id_user', 'notelp');
        
        $check = DB::table('users')
            ->select('id')
            ->joinsub($s1, 's1', function($join){
                $join->on('users.id', 's1.id_user');
            })
            ->where('username', $email)
            ->where('s1.notelp', $nohp)
            ->first();

        if($check) {
            $randomNumber = mt_rand(10000, 99999); // Generates a random 5-digit number
            DB::table('users')
                ->where('username', $email)
                ->update([
                    'resetcode' => $randomNumber,
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
            return $randomNumber;
            
        } else {
            return false;
        }

    }

    public function updatepass($request){

        $newpass = Str::random(2) . rand(10, 99) . Str::random(2);
        $email = $request->lpemailtoreset;

        DB::table('tbl_pendaftaran')
            ->where('email', $email)
            ->update([
                'default_pass' => $newpass
            ]);

        $result = DB::table('users')
            ->where('username', $email)
            ->update([
                'freshpass' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make($newpass)
            ]);
        
        if($result) {
            return $newpass;
        } else {
            return false;
        }

        
    }

    public function checkcode($resetcode, $email)
    {
        $result = DB::table('users')
            ->where('resetcode', $resetcode)
            ->where('username', $email)
            ->first();

        if($result) {
            return true;
        } else {
            return false;
        }
    }


}
