<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Helpers\Help;

class NakesModel extends Model
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

        $latestchar = substr($jenis, -1);
        $restchar = substr($jenis, 0, -1);
        if($restchar == 'rekdin') {

            $urlget = config('app.surat_host').'/assets/uploads/maker/approved/';
            return DB::table('tbl_sk_dinkes')
                ->select('tbl_sk_dinkes.*', DB::raw('"$urlget" as urlsurat'), DB::raw("SUBSTRING(filename_sk, -1) AS perpanjangan"))
                ->where('id_user', $id)
                ->where('salinan', $latestchar)
                ->where('status_sk', '1')
                ->get();
        } else if($restchar == 'SIPB') {

            return DB::table('tbl_sip_external')
                ->where('id_user',$id)
                ->get();
        
        } else if($restchar == 'SKSKP') {

            return DB::table('tbl_docs')
                ->where('id_user',$id)
                ->where('jenis_doc', 'like', 'SKSKP%')
                ->whereNotIn('kadaluarsa',['1','i'])
                ->orderby('updated_at','desc')
                ->get();

        } else {

            return DB::table('tbl_docs')
                ->where('id_user',$id)
                ->where('jenis_doc', $jenis)
                ->whereNotIn('kadaluarsa',['1','i'])
                ->orderby('updated_at','desc')
                ->get();

        }
        
    }

    

    public function getallprofesi()
    {
        return DB::table('master_profesi')
            ->get();
    }

    public function getpengajuan($id) {

        return DB::table('tbl_pengajuan')
            ->where('id_user',$id)
            ->get();

    }

    public function gettemplateid($id){
        $template_id = '';
        $gettemp = DB::table('tbl_pendaftaran')
            ->select('template_id')
            ->where('id_user', $id)
            ->first();
        $template_id = $gettemp->template_id;

        return $template_id;

    }

    public function getdocfoto($id) {

        $query = DB::table('tbl_docs')
            ->where('jenis_doc', 'FOTO')
            ->where('id_user',$id)
            ->first();

        if($query) {
            $foto = $query->namafile;
        } else {
            $foto = 'user.png';
        }

        return $foto;

    }

    public function getpersonalinfo($id) {


        return DB::table('tbl_personal_info')
            ->where('id_user',$id)
            ->first();

    }

    public function getinfonakes($id) {

        $s0 = DB::table('tbl_docs')
            ->select('id_user as id_u_ktp','nama_doc as nama_nakes', 'remark1 as alamat_ktp', 'remark2 as kec_ktp', 'remark3 as kab_ktp', 'remark5 as alamat_domisili', 'remark6 as kec_domisili', 'remark7 as kab_domisili', 'url_qr as isdomi')
            ->where('id_user', $id)
            ->where('jenis_doc', 'KTP');
        
        $periodepend = DB::table('tbl_docs')
            ->select('id')
            ->where('id_user', $id)
            ->where('jenis_doc', 'IJAZAH')
            ->orderby('updated_at', 'desc')
            ->first();
            
        if($periodepend)
        {
            $s1 = DB::table('tbl_docs')
                ->select('id_user as id_u_ijazah','remark1 as universitas', 'remark2 as strata', 'remark3 as jurusan')
                ->where('id_user', $id)
                ->where('id', $periodepend->id)
                ->where('jenis_doc', 'IJAZAH');

        } else {
            $s1 = DB::table('tbl_docs')
                ->select('id_user as id_u_ijazah','remark1 as universitas', 'remark2 as strata', 'remark3 as jurusan')
                ->where('id_user', $id)
                ->where('jenis_doc', 'IJAZAH');
        }

        


        return DB::table('tbl_docs')
            ->select('tbl_docs.no_doc','tbl_docs.expiring_count','tbl_docs.profesi', 'tbl_docs.kompetensi', 's0.nama_nakes', 's0.alamat_ktp', 's0.kec_ktp', 's0.kab_ktp', 's0.alamat_domisili', 's0.kec_domisili', 's0.kab_domisili', 's1.universitas', 's1.strata','s1.jurusan', 's0.isdomi')
            ->leftjoinsub($s0, 's0', function($join){
                $join->on('tbl_docs.id_user', 's0.id_u_ktp');
            })
            ->leftjoinsub($s1, 's1', function($join){
                $join->on('tbl_docs.id_user', 's1.id_u_ijazah');
            })
            ->where('id_user',$id)
            ->where('jenis_doc', 'LIKE', 'STR%')
            ->first();

    }

    public function getdatapendaftaran($id) {
        return DB::table('tbl_pendaftaran')
            ->where('id_user', $id)
            ->first();
    }

    public function tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $updater, $tgl_doc_ori, $tgl_berlaku_ori, $perubahan, $remark7) {

        $last_char = substr($jenis_doc, -1);
        if (is_numeric($last_char)) {
            $salinan = $last_char;
        } else {
            $salinan = 1;
        }

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
                    'perubahan' => $perubahan,
                    'salinan' => $salinan,
                    'remark1' => $remark1,
                    'remark7' => $remark7,
                    'updater' => $updater,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')

                ));
    }

    public function tambahDocIjazah($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $updater, $tgl_doc_ori, $tgl_berlaku_ori, $perubahan, $tUniv, $tStrata, $tProdi) {

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
                   'perubahan' => $perubahan,
                   'remark1' => $tUniv,
                   'remark2' => $tStrata,
                   'remark3' => $tProdi,
                   'remark7' => 'ijazah',
                   'updater' => $updater,
                   'created_at' => date('Y-m-d H:i:s'),
                   'updated_at' => date('Y-m-d H:i:s')

               ));
   }

    public function tambahDocKTP($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $remark2, $remark3, $remark4, $namaktp, $tgl_origin, $template_id, $jenis_profesi, $remark5, $remark6, $remark7, $ifdom) {

        if($remark5 != '') {

            return DB::table('tbl_docs')
                ->insert(array(
                    'id_user' => $user_id,
                    'jenis_doc' => $jenis_doc,
                    'namafile' => $namafile,
                    'nama_doc' => $namaktp,
                    'no_doc' => $no_doc,
                    'tgl_doc' => $tgl_doc,
                    'tgl_berlaku' => $tgl_berlaku,
                    'tgl_doc_origin' => $tgl_origin,
                    'template_id' => $template_id,
                    'jenis_profesi' => $jenis_profesi,
                    'remark1' => $remark1,
                    'remark2' => $remark2,
                    'remark3' => $remark3,
                    'remark4' => $remark4,
                    'remark5' => $remark5,
                    'remark6' => $remark6,
                    'remark7' => $remark7,
                    'url_qr' => $ifdom,
                    'updater' => $user_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')

                ));

        } else {

            return DB::table('tbl_docs')
                ->insert(array(
                    'id_user' => $user_id,
                    'jenis_doc' => $jenis_doc,
                    'namafile' => $namafile,
                    'nama_doc' => $namaktp,
                    'no_doc' => $no_doc,
                    'tgl_doc' => $tgl_doc,
                    'tgl_berlaku' => $tgl_berlaku,
                    'tgl_doc_origin' => $tgl_origin,
                    'template_id' => $template_id,
                    'jenis_profesi' => $jenis_profesi,
                    'remark1' => $remark1,
                    'remark2' => $remark2,
                    'remark3' => $remark3,
                    'remark4' => $remark4,
                    'url_qr' => $ifdom,
                    'updater' => $user_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')

                ));

        }
        

    }


    public function updatedokktp($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1,$remark2, $remark3, $remark4, $namaktp, $tgl_origin, $template_id, $jenis_sip, $remark5, $remark6, $remark7, $ifdom) {

        if($remark5 != '') {

            return DB::table('tbl_docs')
                ->where('id_user', $user_id)
                ->where('jenis_doc', 'KTP')
                ->update([
                    
                    'nama_doc' => $namaktp,
                    'no_doc' => $no_doc,
                    'tgl_doc' => $tgl_doc,
                    'tgl_berlaku' => $tgl_berlaku,
                    'tgl_doc_origin' => $tgl_origin,
                
                    'remark1' => $remark1,
                    'remark2' => $remark2,
                    'remark3' => $remark3,
                    'remark4' => $remark4,
                    'remark5' => $remark5,
                    'remark6' => $remark6,
                    'remark7' => $remark7,
                    'url_qr' => $ifdom,
                    'updater' => $user_id,
                    'is_compromised' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')

                ]);

        } else {

            return DB::table('tbl_docs')
                ->where('id_user', $user_id)
                ->where('jenis_doc', 'KTP')
                ->update([
                    
                    'nama_doc' => $namaktp,
                    'no_doc' => $no_doc,
                    'tgl_doc' => $tgl_doc,
                    'tgl_berlaku' => $tgl_berlaku,
                    'tgl_doc_origin' => $tgl_origin,
                 
                    'remark1' => $remark1,
                    'remark2' => $remark2,
                    'remark3' => $remark3,
                    'remark4' => $remark4,
                    'url_qr' => $ifdom,
                    'updater' => $user_id,
                    'is_compromised' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')

                ]);

        }

    }

    public function submitpengajuanm($request) {

        $alamat = $request->tAlamatPengajuanM;
        $kabupaten = $request->tKabupatenM;
        $kecamatan = $request->tKecamatanM;
        $lat = $request->tLat;
        $long = $request->tLong;
        $user_id = $request->tUserPengajuan;
        $jenis = $request->tTypeAjuan;
        $id = $request->tIdAjuan;
        $salinan = $request->tAjuanSalinan;
        $jadwal_praktek = $request->tJadwalPraktek;
        $isFaskes = $request->tIsFaskes;
        $idFaskes = $request->tidFaskes;
        $nama_faskes = $request->tNamaFaskes;
        $nama_faskesmandiri = $request->tNamaFaskesMan;
        //$isApproved = 0;
        $isApproved = '0';
        $tgl_visitasi = '';
        $nama_faskes = 0;
        $template_profesi = $request->templateprofesi;
        $subkompetensi = $request->kompetensipilihan;


        $gettemplate = DB::table('tbl_docs')
            ->select('template_id', 'id', 'no_doc')
            ->where('id_user', $user_id)
            ->where('salinan', $salinan)
            ->where('jenis_doc', 'STR'.$salinan)
            ->where('kadaluarsa', 0)
            ->first();
        
        //$template_id = $gettemplate->template_id;
        $id_doc = $gettemplate->id;
        $no_dokumen = $gettemplate->no_doc;

        $template_id = $template_profesi;
        
        // karena tidak ada lagi tanggal visitasi
        $isApproved = '0';
        $tgl_visitasi = date('Y-m-d');

        if($isFaskes == 1) {
            
            //$isApproved = '0';
            //$tgl_visitasi = date('Y-m-d');

            $getnamafask = DB::table('master_faskes')
                ->select('nama_faskes')
                ->where('id_faskes', $idFaskes)
                ->first();
            
            $nama_faskes = $getnamafask->nama_faskes;
        }

        if ($jenis == 'add') {

            $id_pengajuan = DB::table('tbl_pengajuan')
                ->insertGetId(array(
                    'id_user' => $user_id,
                    'id_doc' => $id_doc,
                    'salinan' =>$salinan,
                    'no_doc' => $no_dokumen,
                    'isFaskes' => $isFaskes,
                    'isApproved' => $isApproved,
                    'tracker' => 'Sedang Diajukan',
                    'latitude' => $lat,
                    'longitude' => $long,
                    'remark' => $subkompetensi,
                    'alamat_pengajuan' => $alamat,
                    'kabupaten' => $kabupaten,
                    'kecamatan' => $kecamatan,
                    'id_faskes' => $idFaskes,
                    'tgl_visitasi' => $tgl_visitasi,
                    'nama_faskes' => $nama_faskes,
                    'template_id' => $template_id,
                    'isperpanjangan' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')

                ));

            return DB::table('tbl_jadwalpraktik')
                ->where('id_user', $user_id)
                ->where('salinan', $salinan)
                ->where('kadaluarsa', '0')
                ->update(['id_pengajuan' => $id_pengajuan]);

        } else {

            $updateDetails = [
                'latitude' => $lat,
                'longitude' => $long,
                'alamat_pengajuan' => $alamat,
                'kabupaten' => $kabupaten,
                'kecamatan' => $kecamatan,
                'updated_at' => date('Y-m-d H:i:s')
            ];
    
            return DB::table('tbl_pengajuan')
                ->where('id', $id)
                ->update($updateDetails);

        }

        

    }

    public function submitperubahanm($request){


        $alamat = $request->tAlamatPengajuanM;
        $kabupaten = $request->tKabupatenM;
        $kecamatan = $request->tKecamatanM;
        $lat = $request->tLat;
        $long = $request->tLong;
        $user_id = $request->tUserPengajuan;
        $jenis = $request->tTypeAjuan;
        $id = $request->tIdAjuan;
        $salinan = $request->tAjuanSalinan;
        $jadwal_praktek = $request->tJadwalPraktek;
        $isFaskes = $request->tIsFaskes;
        $idFaskes = $request->tidFaskes;
        $nama_faskes = $request->tNamaFaskes;
        $id_pengajuan = $request->tIDPengajuan;
        $isApproved = '0';
        $tgl_visitasi = '';
        $nama_faskes = 0;
        $isSementara = $request->tIsSementara;

        $getperubahan = DB::table('tbl_pengajuan')
                ->select('perubahan')
                ->where('id', $id_pengajuan)
                ->first();
        $perubahanawal = (int)$getperubahan->perubahan;

        if($isSementara == '1') {

            return $perubahanawal;

        } else {

            if($jenis == 'init') {

                $perubahanakhir = $perubahanawal + 1;
    
            } else {
    
                $perubahanakhir = $perubahanawal;
    
            }
    
            $updateDetails = [
                'updater' => $user_id,
                'isApproved' => 'P2',
                'perubahan' => $perubahanakhir,
                'isperpanjangan' => '0',
                'updated_at' => date('Y-m-d H:i:s')
            ];
    
            DB::table('tbl_pengajuan')
                ->where('id', $id_pengajuan)
                ->update($updateDetails);
    
    
            DB::table('tbl_jadwalpraktik')
                ->where('id_user', $user_id)
                ->where('salinan', $salinan)
                ->where('kadaluarsa', '0')
                ->update(['id_pengajuan' => $id_pengajuan, 'perubahan' => $perubahanakhir]);
    
            return $perubahanakhir;

        }

        

    }

    public function getinformation($id) {

        return DB::table('tbl_information')
            ->where('terupdate', $id)
            ->orderby('id', 'desc')
            ->get();
    }

    public function getprofesi($id, $jenis) {
        $query = DB::table('tbl_docs')
            ->select('kompetensi', 'url_qr', 'jenis_profesi')
            ->where('id_user', $id)
            ->where('jenis_doc', 'like', 'STR%')
            ->first();

            if($query) {
                $qr_url = $query->url_qr;
                $profesi = $query->kompetensi;
                $jenis_profesi = $query->jenis_profesi;
            } else {
                $qr_url = '';
                $profesi = 'Nakes';
                $jenis_profesi = '';
            }
        
        if($jenis == 'url') {

            return $qr_url;

        } else if ($jenis == 'jenis_profesi') {

            return $jenis_profesi;

        }else {

            return $profesi;

        }

        
    }


    public function getdatastrsalinan($id) {

        $s0 = DB::table('tbl_pengajuan')
            ->select('id as id_pengajuan','id_doc','isApproved', 'perpanjangan', 'perubahan', 'isFaskes', 'nama_faskes', 'alamat_pengajuan', 'alasan_ditolak')
            ->where('id_user',$id)
            ->where('isApproved','<>','CF');
        $s1 = DB::table('tbl_sip_lama')
            ->select('id as id_pengajuan', 'id_doc', 'isApproved', 'isFaskes', 'nama_faskes', 'alamat_pengajuan')
            ->where('id_nakes', $id)
            ->where('isApproved', '<>','CF');

        return DB::table('tbl_docs')
            ->select('id as id_doc','salinan', 'isDiajukan', 'template_id', DB::raw('ifnull(s0.isApproved, s1.isApproved) as isApproved'), 's0.perpanjangan', 's0.perubahan', DB::raw('ifnull(s0.id_pengajuan,CONCAT("M",s1.id_pengajuan)) as id_pengajuan'), DB::raw('ifnull(s0.isFaskes, s1.isFaskes) as isFaskes'), DB::raw('ifnull(s0.nama_faskes,s1.nama_faskes) as nama_faskes'), DB::raw('ifnull(s0.alamat_pengajuan,s1.alamat_pengajuan) as alamat_pengajuan'), 'sip_manual', 'alasan_ditolak', 'tbl_docs.kompetensi')
            ->leftjoinsub($s0, 's0', function($join){
                $join->on('tbl_docs.id', 's0.id_doc');
            })
            ->leftjoinsub($s1, 's1', function($join){
                $join->on('tbl_docs.id', 's1.id_doc');
            })
            ->where('id_user', $id)
            ->where('kadaluarsa', '<>','i')
            ->whereRAW('jenis_doc in ("STR1", "STR2", "STR3")')
            ->get();
    }

    public function updatestatestr($id_nakes, $salinan){

        return DB::table('tbl_docs')
            ->where('id_user', $id_nakes)
            ->where('jenis_doc', 'STR'.$salinan)
            ->update([
                'kadaluarsa' => '0',
                'updated_at' => date('Y-m-d H:i:s'),
                'updater' => $id_nakes
            ]);

    }

    public function updateDocStat($request) {

        $user_id = $request->tUserPengajuan;
        $salinan = $request->tAjuanSalinan;
        $jenis_doc = 'STR'.$salinan;

        

        if ($request->has('templateprofesi')) {

            $template_id = $request->templateprofesi;
            $updateDetails = [
                'isDiajukan' => '1',
                'template_id' => $template_id,
                'updated_at' => date('Y-m-d H:i:s')
            ];

        } else {

            $updateDetails = [
                'isDiajukan' => '1',
                'updated_at' => date('Y-m-d H:i:s')
            ];

        }

        return DB::table('tbl_docs')
            ->where('id_user', $user_id)
            ->where('salinan', $salinan)
            ->where('jenis_doc', $jenis_doc)
            ->update($updateDetails);


    }

    public function updateDoc($jenis_doc, $id_nakes, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, $perubahan){

        return DB::table('tbl_docs')
            ->where('jenis_doc', $jenis_doc)
            ->where('id_user', $user_id)
            ->update([
                'no_doc' => $no_doc,
                'tgl_doc' => $tgl_doc,
                'tgl_berlaku' => $tgl_berlaku,
                'tgl_doc_origin' => $tgl_doc_ori,
                'tgl_berlaku_origin' => $tgl_berlaku_ori,
                'updated_at' => date('Y-m-d H:i:s'),
                'namafile' => $namafile,
                'perubahan' => $perubahan,
                'remark1' => $remark1
            ]);

    }


    public function detailpengaju($id) {

        $s0 = DB::table('users')
            ->select('saved_photo', 'id')
            ->where('id', $id);

        $s1 = DB::table('tbl_docs')
            ->select('nama_doc as nama_pengaju', 'id_user', 'remark1 as alamat_pengaju', 'remark2 as kecamatan_pengaju', 'remark3 as kabupaten_pengaju', 'jenis_profesi as no_ttk', 'remark4 as tmpt_lahir', 'tgl_doc as tgl_lahir')
            ->where('id_user', $id)
            ->where('jenis_doc', 'KTP');

        $s2 = DB::table('tbl_docs')
            ->select('profesi as profesi_pengaju', 'kompetensi as kompetensi_pengaju', 'id_user')
            ->where('id_user', $id)
            ->where('jenis_doc', 'STR1');
      

        return DB::table('tbl_pendaftaran')
            ->select('tbl_pendaftaran.*', 's0.saved_photo', 's1.nama_pengaju', 's2.profesi_pengaju','s2.kompetensi_pengaju', 's1.alamat_pengaju', 's1.kecamatan_pengaju', 's1.kabupaten_pengaju', 's1.no_ttk', 's1.tmpt_lahir', 's1.tgl_lahir')
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
    }

    public function getallfaskes($request) {

        if ($request->has('id_user')) {

            $id_user = $request->id_user;

            return DB::table('master_faskes')
            ->where('status_faskes', '1')
            ->whereRAW('id_faskes not in (SELECT distinct(ifnull(id_faskes,0)) FROM tbl_pengajuan WHERE id_user = "'.$id_user.'" AND isApproved not in ("CF") UNION SELECT distinct(ifnull(id_faskes,0)) FROM tbl_sip_lama WHERE id_nakes = "'.$id_user.'" AND isApproved not in ("CF") )')
            ->get();



        } else {

            return DB::table('master_faskes')
            ->where('status_faskes', '1')
            ->get();

        }

    }

    public function getIdDocStr($id, $salinan) {
        $getId = DB::table('tbl_docs')
            ->select('id')
            ->where('id_user', $id)
            ->where('salinan', $salinan)
            ->where('kadaluarsa','=','0')
            ->first();

        $id_doc = $getId->id;
        return $id_doc;
    }

    public function createdraftjadwal($id_user, $salinan, $id_doc_str){
        $isexist = DB::table('tbl_jadwalpraktik')
            ->select('id')
            ->where('id_user', $id_user)
            ->where('salinan', $salinan)
            ->where('id_doc', $id_doc_str)
            ->get();
        if(count($isexist) > 0) {
            return true;
        } else {

             DB::table('tbl_jadwalpraktik')
                ->insert(array(
                    'id_user' => $id_user,
                    'salinan' =>$salinan,
                    'id_doc' => $id_doc_str,
                    'urutan' => 1,
                    'hari' => 'Senin',
                    'mulai' => '08:00',
                    'selesai' => '12:00',
                    'rmulai' => '480',
                    'rselesai' => '720',
                    'is_shift'=> 0,
                    'iscompromised' => 0,
                    'levelwarning' => 0,
                    'updated_at' => date('Y-m-d H:i:s')

                ));

                DB::table('tbl_jadwalpraktik')
                ->insert(array(
                    'id_user' => $id_user,
                    'salinan' =>$salinan,
                    'id_doc' => $id_doc_str,
                    'urutan' => 2,
                    'hari' => 'Selasa',
                    'mulai' => '08:00',
                    'selesai' => '12:00',
                    'rmulai' => '480',
                    'rselesai' => '720',
                    'is_shift'=> 0,
                    'iscompromised' => 0,
                    'levelwarning' => 0,
                    'updated_at' => date('Y-m-d H:i:s')

                ));

                DB::table('tbl_jadwalpraktik')
                ->insert(array(
                    'id_user' => $id_user,
                    'salinan' =>$salinan,
                    'id_doc' => $id_doc_str,
                    'urutan' => 3,
                    'hari' => 'Rabu',
                    'mulai' => '08:00',
                    'selesai' => '12:00',
                    'rmulai' => '480',
                    'rselesai' => '720',
                    'is_shift'=> 0,
                    'iscompromised' => 0,
                    'levelwarning' => 0,
                    'updated_at' => date('Y-m-d H:i:s')

                ));

                DB::table('tbl_jadwalpraktik')
                ->insert(array(
                    'id_user' => $id_user,
                    'salinan' =>$salinan,
                    'id_doc' => $id_doc_str,
                    'urutan' => 4,
                    'hari' => 'Kamis',
                    'mulai' => '08:00',
                    'selesai' => '12:00',
                    'rmulai' => '480',
                    'rselesai' => '720',
                    'is_shift'=> 0,
                    'iscompromised' => 0,
                    'levelwarning' => 0,
                    'updated_at' => date('Y-m-d H:i:s')

                ));


                DB::table('tbl_jadwalpraktik')
                ->insert(array(
                    'id_user' => $id_user,
                    'salinan' =>$salinan,
                    'id_doc' => $id_doc_str,
                    'urutan' => 5,
                    'hari' => 'Jumat',
                    'mulai' => '08:00',
                    'selesai' => '12:00',
                    'rmulai' => '480',
                    'rselesai' => '720',
                    'is_shift'=> 0,
                    'iscompromised' => 0,
                    'levelwarning' => 0,
                    'updated_at' => date('Y-m-d H:i:s')

                ));

                DB::table('tbl_jadwalpraktik')
                ->insert(array(
                    'id_user' => $id_user,
                    'salinan' =>$salinan,
                    'id_doc' => $id_doc_str,
                    'urutan' => 6,
                    'hari' => 'Sabtu',
                    'mulai' => '08:00',
                    'selesai' => '12:00',
                    'rmulai' => '480',
                    'rselesai' => '720',
                    'is_shift'=> 0,
                    'iscompromised' => 0,
                    'levelwarning' => 0,
                    'updated_at' => date('Y-m-d H:i:s')

                ));

                DB::table('tbl_jadwalpraktik')
                ->insert(array(
                    'id_user' => $id_user,
                    'salinan' =>$salinan,
                    'id_doc' => $id_doc_str,
                    'urutan' => 7,
                    'hari' => 'Minggu',
                    'mulai' => '08:00',
                    'selesai' => '12:00',
                    'rmulai' => '480',
                    'rselesai' => '720',
                    'is_shift'=> 0,
                    'iscompromised' => 0,
                    'levelwarning' => 0,
                    'updated_at' => date('Y-m-d H:i:s')

                ));

            return true;


        }
    }

    public function getalljadwal($request) {

        

        $id_user = $request->id_user;
        $salinan = $request->salinan;
        $id_doc = $request->id_doc;
        $alsal = ['1', '2', '3'];
        $selsal = [];
        foreach($alsal as $cursal){
            if ($cursal != $salinan) {
                array_push($selsal,$cursal);
            }
        }
        $salsec = $selsal[0];
        $salthird = $selsal[1];

        $s0 = DB::table('tbl_jadwalpraktik')
            ->select('salinan', 'urutan', 'mulai', 'selesai', 'rmulai', 'rselesai')
            ->where('id_user', $id_user)
            ->where('salinan', $salsec)
            ->where('kadaluarsa', 0);

        $s1 = DB::table('tbl_jadwalpraktik')
            ->select('salinan', 'urutan', 'mulai', 'selesai', 'rmulai', 'rselesai')
            ->where('id_user', $id_user)
            ->where('salinan', $salthird)
            ->where('kadaluarsa', 0);


        $result = DB::table('tbl_jadwalpraktik AS jp')
            ->select('jp.*', 's0.salinan AS salinan1','s0.mulai AS mulai1', 's0.selesai AS selesai1', 's0.rmulai AS rmulai1', 's0.rselesai AS rselesai1', 's1.salinan AS salinan2','s1.mulai AS mulai2', 's1.selesai AS selesai2', 's1.rmulai AS rmulai2', 's1.rselesai AS rselesai2')
    
            ->leftjoinsub($s0, 's0', function($join){
                $join->on('jp.urutan', 's0.urutan');
            })
            ->leftjoinsub($s0, 's1', function($join){
                 $join->on('jp.urutan', 's1.urutan');
             })
            ->where('jp.id_user', $id_user)
            ->where('jp.salinan', $salinan)
            ->where('jp.id_doc', $id_doc)
            ->get();

        return $result;
    }

    public function namahari($urutan) {
        switch ($urutan) {
            case "1":
                return "Senin";
            break;
            case "2":
                return "Selasa";
            break;
            case "3":
                return "Rabu";
            break;
            case "4":
                return "Kamis";
            break;
            case "5":
                return "Jumat";
            break;
            case "6":
                return "Sabtu";
            break;
            case "7":
                return "Minggu";
            break;
           
          }
    }

    public function submitjadwalprakteknakes($request){

        $submitdata = $request->submitdata;
        $id_user = $submitdata['id_user'];
        $id_doc = $submitdata['id_doc'];
        $salinan = $submitdata['salinan'];
        $jadwal = $submitdata['jadwal'];
        $istolak = $submitdata['istolak'];
        $isadmin = isset($submitdata['isadmin']) ? $submitdata['isadmin'] : 0;
        $updateresult = 0;
        $otherone = 0;
        $othertwo = 0;

        $alsal = ['1', '2', '3'];
        $selsal = [];
        foreach($alsal as $cursal){
            if ($cursal != $salinan) {
                array_push($selsal,$cursal);
            }
        }
        $salsec = $selsal[0];
        $salthird = $selsal[1];

        $quersalsec = DB::table('tbl_jadwalpraktik')
            ->where('id_user', $id_user)
            ->where('salinan', $salsec)
            ->where('kadaluarsa', '0')
            ->orderby('urutan')
            ->get();

        $quersalthird = DB::table('tbl_jadwalpraktik')
            ->where('id_user', $id_user)
            ->where('salinan', $salthird)
            ->where('kadaluarsa', '0')
            ->orderby('urutan')
            ->get();

        if(count($quersalsec) > 0) {
            $otherone = 1;
        }
        if(count($quersalthird) > 0 ) {
            $othertwo = 1;
        }

        if($isadmin == 1)
        {
            DB::table('tbl_jadwalpraktik')
                ->where('id_user', $id_user)
                ->where('salinan', $salinan)
                ->where('kadaluarsa', '0')
                ->where('id_pengajuan', '0')
                ->delete();
        }
        


        for ($i = 0; $i < count($jadwal); $i++) {
            $iscompromised = 0;
            $keterangan = '';
            $levelwarning = 0;
            $uraian = '';

            $jadwaljson = json_decode($jadwal[$i]);
            if($i == 0) {
                $jadwalbefore = json_decode($jadwal[6]);
                if($otherone == 1) {
                    $jadwalbeforesec = $quersalsec[6];
                }
                if($othertwo == 1) {
                    $jadwalbeforethird = $quersalthird[6];
                }
                
            } else {
                $jadwalbefore = json_decode($jadwal[$i-1]);
                if($otherone == 1) {
                    $jadwalbeforesec = $quersalsec[$i-1];
                }
                if($othertwo == 1) {
                    $jadwalbeforethird = $quersalthird[$i-1];
                }
            }

            $urutanbefore = $jadwalbefore->urutan;
            $mulaibefore = $jadwalbefore->mulai;
            $selesaibefore = $jadwalbefore->selesai;
            $rmulaibefore = $jadwalbefore->rmulai;
            $rselesaibefore = $jadwalbefore->rselesai;
            $isnextdaybefore = $jadwalbefore->isnextday;
            $haribefore = $this->namahari($urutanbefore);
            $issetbefore = $jadwalbefore->isSet;

            if($i == 6) {
                $jadwalafter = json_decode($jadwal[0]);

                if($otherone == 1) {
                    $jadwalaftersec = $quersalsec[0];
                }
                if($othertwo == 1) {
                    $jadwalafterthird = $quersalthird[0];
                }
                
            } else {
                $jadwalafter = json_decode($jadwal[$i+1]);
                if($otherone == 1) {
                    $jadwalaftersec = $quersalsec[$i+1];
                }
                if($othertwo == 1) {
                    $jadwalafterthird = $quersalthird[$i+1];
                }
            }
            $urutanafter = $jadwalafter->urutan;
            $mulaiafter = $jadwalafter->mulai;
            $selesaiafter = $jadwalafter->selesai;
            $rmulaiafter = $jadwalafter->rmulai;
            $rselesaiafter = $jadwalafter->rselesai;
            $hariafter = $this->namahari($urutanafter);
            $issetafter = $jadwalafter->isSet;

            $urutan = $jadwaljson->urutan;
            $mulai = $jadwaljson->mulai;
            $selesai = $jadwaljson->selesai;
            $rmulai = $jadwaljson->rmulai;
            $rselesai = $jadwaljson->rselesai;
            $isSet = $jadwaljson->isSet;
            $isshift = $jadwaljson->is_shift;
            $isNextDay = $jadwaljson->isnextday;
            $isuraian = $jadwaljson->uraian;

            if($isSet == 1) {

                //logical here///
                if($isnextdaybefore == 1 && $issetbefore == 1) {
                    if($rselesaibefore > $rmulai) {
                        $iscompromised = 1;
                        $levelwarning = 2;
                        if($keterangan == '') {
                            $keterangan = 'Jadwal Berbenturan Dengan Hari (Sebelumnya) '.$haribefore. ' Pukul '.$mulaibefore.' Hingga '.$selesaibefore.' Salinan '.$salinan;
                        } else {
                            $keterangan = $keterangan.', Jadwal Berbenturan Dengan Hari (Sebelumnya) '.$haribefore. ' Pukul '.$mulaibefore.' Hingga '.$selesaibefore.' Salinan '.$salinan;
                        }
                        
                    } elseif (($rmulai - $rselesaibefore) < 30) {
                        $iscompromised = 1;
                        if($levelwarning != 2) {
                            $levelwarning = 1;
                        }
                        if ($keterangan == '') {
                            $keterangan = 'Jadwal Praktik Terlalu Dekat Dengan Hari (Sebelumnya) '.$haribefore. ' Pukul '.$mulaibefore.' Hingga '.$selesaibefore. ' Salinan '.$salinan;
                        } else {
                            $keterangan = $keterangan. ', Jadwal Praktik Terlalu Dekat Dengan Hari (Sebelumnya) '.$haribefore. ' Pukul '.$mulaibefore.' Hingga '.$selesaibefore. ' Salinan '.$salinan;
                        }
                        
                    }
                }

                if($isNextDay == 1) {
                    if(($rselesai > $rmulaiafter) && $issetafter == 1) {
                        $iscompromised = 1;
                        $levelwarning = 2;
                        $keterangan = 'Jadwal Berbenturan Dengan Hari (Setelahnya) '.$hariafter. ' Pukul '.$mulaiafter.' Hingga '.$selesaiafter. ' Salinan '.$salinan;
                    } elseif(($rmulaiafter - $rselesai) < 30 && $issetafter == 1) {
                        $iscompromised = 1;
                        $levelwarning = 1;
                        $keterangan = 'Jadwal Praktik Terlalu Dekat Dengan Hari (Setelahnya) '.$hariafter. ' Pukul '.$mulaiafter. ' Hingga '.$selesaiafter. ' Salinan '.$salinan;
                    }
                }

                if($otherone == 1) {

                    $urutansec = $quersalsec[$i]->urutan;
                    $mulaisec = $quersalsec[$i]->mulai;
                    $selesaisec = $quersalsec[$i]->selesai;
                    $rmulaisec = $quersalsec[$i]->rmulai;
                    $rselesaisec = $quersalsec[$i]->rselesai;
                    $isSetsec = $quersalsec[$i]->isSet;
                    $isshiftsec = $quersalsec[$i]->is_shift;
                    $isNextDaysec = $quersalsec[$i]->isNextDay;
                    $salisansec = $quersalsec[$i]->salinan;
                    $hariasec = $this->namahari($urutansec);


                    $urutanbeforesec = $jadwalbeforesec->urutan;
                    $mulaibeforesec = $jadwalbeforesec->mulai;
                    $selesaibeforesec = $jadwalbeforesec->selesai;
                    $rmulaibeforesec = $jadwalbeforesec->rmulai;
                    $rselesaibeforesec = $jadwalbeforesec->rselesai;
                    $isnextdaybeforesec = $jadwalbeforesec->isNextDay;
                    $haribeforesec = $this->namahari($urutanbeforesec);
                    $issetbeforesec = $jadwalbeforesec->isSet;

                    $urutanaftersec = $jadwalaftersec->urutan;
                    $mulaiaftersec = $jadwalaftersec->mulai;
                    $selesaiaftersec = $jadwalaftersec->selesai;
                    $rmulaiaftersec = $jadwalaftersec->rmulai;
                    $rselesaiaftersec = $jadwalaftersec->rselesai;
                    $hariaftersec = $this->namahari($urutanaftersec);
                    $issetaftersec = $jadwalaftersec->isSet;

                    if($isSetsec == 1) {
                        if($isNextDay != 1 && $isNextDaysec != 1) {
                            if(($rmulaisec <= $rmulai) && ($rmulai <= $rselesaisec) || ($rmulaisec <= $rselesai) && ($rselesai <= $rselesaisec)){

                                $iscompromised = 1;
                                $levelwarning = 2;
                                if($keterangan == '') {
                                    $keterangan = 'Jadwal Berbenturan Dengan Hari '.$hariasec. ' Pukul '.$mulaisec.' Hingga '.$selesaisec.' Salinan '.$salisansec;
                                } else {
                                    $keterangan = $keterangan.', Jadwal Berbenturan Dengan Hari '.$hariasec. ' Pukul '.$mulaisec.' Hingga '.$selesaisec.' Salinan '.$salisansec;
                                }
                                

                            } elseif (($rmulai - $rselesaisec) < 30 && ($rmulai > $rselesaisec)) {

                                $iscompromised = 1;
                                if($levelwarning != 2) {
                                    $levelwarning = 1;
                                }
                                if ($keterangan == '') {
                                    $keterangan = 'Jadwal Praktik Terlalu Dekat Dengan Hari '.$hariasec. ' Pukul '.$mulaisec.' Hingga '.$selesaisec. ' Salinan '.$salisansec;
                                } else {
                                    $keterangan = $keterangan. ', Jadwal Praktik Terlalu Dekat Dengan Hari '.$hariasec. ' Pukul '.$mulaisec.' Hingga '.$selesaisec. ' Salinan '.$salisansec;
                                }
                                
                            } elseif (($rmulaisec - $rselesai) < 30 && ($rmulaisec > $rselesai)) {
                                
                                $iscompromised = 1;
                                if($levelwarning != 2) {
                                    $levelwarning = 1;
                                }
                                if ($keterangan == '') {
                                    $keterangan = 'Jadwal Praktik Terlalu Dekat Dengan Hari '.$hariasec. ' Pukul '.$mulaisec.' Hingga '.$selesaisec. ' Salinan '.$salisansec;
                                } else {
                                    $keterangan = $keterangan. ', Jadwal Praktik Terlalu Dekat Dengan Hari '.$hariasec. ' Pukul '.$mulaisec.' Hingga '.$selesaisec. ' Salinan '.$salisansec;
                                }
                            }
                        } elseif ($isNextDay == 1 && $isNextDaysec != 1) {

                            if(($rmulaisec <= $rmulai) && ($rmulai <= $rselesaisec)){

                                $iscompromised = 1;
                                $levelwarning = 2;
                                if($keterangan == '') {
                                    $keterangan = 'Jadwal Berbenturan Dengan Hari '.$hariasec. ' Pukul '.$mulaisec.' Hingga '.$selesaisec.' Salinan '.$salisansec;
                                } else {
                                    $keterangan = $keterangan.', Jadwal Berbenturan Dengan Hari '.$hariasec. ' Pukul '.$mulaisec.' Hingga '.$selesaisec.' Salinan '.$salisansec;
                                }
                                

                            }

                        } elseif ($isNextDay != 1 && $isNextDaysec == 1) {

                            if(($rmulai <= $rmulaisec) && ($rmulaisec <= $rselesai)){

                                $iscompromised = 1;
                                $levelwarning = 2;
                                if($keterangan == '') {
                                    $keterangan = 'Jadwal Berbenturan Dengan Hari '.$hariasec. ' Pukul '.$mulaisec.' Hingga '.$selesaisec.' Salinan '.$salisansec;
                                } else {
                                    $keterangan = $keterangan.', Jadwal Berbenturan Dengan Hari '.$hariasec. ' Pukul '.$mulaisec.' Hingga '.$selesaisec.' Salinan '.$salisansec;
                                }
                                

                            }

                        } else {

                            $iscompromised = 1;
                            $levelwarning = 2;
                            if($keterangan == '') {
                                $keterangan = 'Jadwal Berbenturan Dengan Hari '.$hariasec. ' Pukul '.$mulaisec.' Hingga '.$selesaisec.' Salinan '.$salisansec;
                            } else {
                                $keterangan = $keterangan.', Jadwal Berbenturan Dengan Hari '.$hariasec. ' Pukul '.$mulaisec.' Hingga '.$selesaisec.' Salinan '.$salisansec;
                            }

                        }

                    }


                    if($isnextdaybeforesec == 1 && $issetbeforesec == 1) {
                        if($rselesaibeforesec > $rmulai) {
                            $iscompromised = 1;
                            $levelwarning = 2;
                            if($keterangan == '') {
                                $keterangan = 'Jadwal Berbenturan Dengan Hari (Sebelumnya) '.$haribeforesec. ' Pukul '.$mulaibeforesec.' Hingga '.$selesaibeforesec.' Salinan '.$salisansec;
                            } else {
                                $keterangan = $keterangan.', Jadwal Berbenturan Dengan Hari (Sebelumnya) '.$haribeforesec. ' Pukul '.$mulaibeforesec.' Hingga '.$selesaibeforesec.' Salinan '.$salisansec;
                            }
                            
                        } elseif (($rmulai - $rselesaibeforesec) < 30) {
                            $iscompromised = 1;
                            if($levelwarning != 2) {
                                $levelwarning = 1;
                            }
                            if ($keterangan == '') {
                                $keterangan = 'Jadwal Praktik Terlalu Dekat Dengan Hari (Sebelumnya) '.$haribeforesec. ' Pukul '.$mulaibeforesec.' Hingga '.$selesaibeforesec. ' Salinan '.$salisansec;
                            } else {
                                $keterangan = $keterangan. ', Jadwal Praktik Terlalu Dekat Dengan Hari (Sebelumnya) '.$haribeforesec. ' Pukul '.$mulaibeforesec.' Hingga '.$selesaibeforesec. ' Salinan '.$salisansec;
                            }
                            
                        }
                    }
    
                    if($isNextDay == 1) {
                        if(($rselesai > $rmulaiaftersec) && $issetaftersec == 1) {
                            $iscompromised = 1;
                            $levelwarning = 2;
                            $keterangan = 'Jadwal Berbenturan Dengan Hari (Setelahnya) '.$hariaftersec. ' Pukul '.$mulaiaftersec.' Hingga '.$selesaiaftersec. ' Salinan '.$salisansec;
                        } elseif(($rmulaiaftersec - $rselesai) < 30 && $issetaftersec == 1) {
                            $iscompromised = 1;
                            if($levelwarning != 2) {
                                $levelwarning = 1;
                            }
                            if ($keterangan == '') {
                                $keterangan = 'Jadwal Praktik Terlalu Dekat Dengan Hari (Setelahnya) '.$hariaftersec. ' Pukul '.$mulaiaftersec.' Hingga '.$selesaiaftersec. ' Salinan '.$salisansec;
                            } else {
                                $keterangan = $keterangan. ', Jadwal Praktik Terlalu Dekat Dengan Hari (Setelahnya) '.$hariaftersec. ' Pukul '.$mulaiaftersec.' Hingga '.$selesaiaftersec. ' Salinan '.$salisansec;
                            }

                            
                        }
                    }
                    
                }


                if($othertwo == 1) {

                    $urutanthird = $quersalthird[$i]->urutan;
                    $mulaithird = $quersalthird[$i]->mulai;
                    $selesaithird = $quersalthird[$i]->selesai;
                    $rmulaithird = $quersalthird[$i]->rmulai;
                    $rselesaithird = $quersalthird[$i]->rselesai;
                    $isSetthird = $quersalthird[$i]->isSet;
                    $isshiftthird = $quersalthird[$i]->is_shift;
                    $isNextDaythird = $quersalthird[$i]->isNextDay;
                    $salisanthird = $quersalthird[$i]->salinan;
                    $hariathird = $this->namahari($urutanthird);


                    $urutanbeforethird = $jadwalbeforethird->urutan;
                    $mulaibeforethird = $jadwalbeforethird->mulai;
                    $selesaibeforethird = $jadwalbeforethird->selesai;
                    $rmulaibeforethird = $jadwalbeforethird->rmulai;
                    $rselesaibeforethird = $jadwalbeforethird->rselesai;
                    $isnextdaybeforethird = $jadwalbeforethird->isNextDay;
                    $haribeforethird = $this->namahari($urutanbeforethird);
                    $issetbeforethird = $jadwalbeforethird->isSet;

                    $urutanafterthird = $jadwalafterthird->urutan;
                    $mulaiafterthird = $jadwalafterthird->mulai;
                    $selesaiafterthird = $jadwalafterthird->selesai;
                    $rmulaiafterthird = $jadwalafterthird->rmulai;
                    $rselesaiafterthird = $jadwalafterthird->rselesai;
                    $hariafterthird = $this->namahari($urutanafterthird);
                    $issetafterthird = $jadwalafterthird->isSet;

                    if($isSetthird == 1) {
                        if($isNextDay != 1 && $isNextDaythird != 1) {
                            if(($rmulaithird <= $rmulai) && ($rmulai <= $rselesaithird) || ($rmulaithird <= $rselesai) && ($rselesai <= $rselesaithird)){

                                $iscompromised = 1;
                                $levelwarning = 2;
                                if($keterangan == '') {
                                    $keterangan = 'Jadwal Berbenturan Dengan Hari '.$hariathird. ' Pukul '.$mulaithird.' Hingga '.$selesaithird.' Salinan '.$salisanthird;
                                } else {
                                    $keterangan = $keterangan.', Jadwal Berbenturan Dengan Hari '.$hariathird. ' Pukul '.$mulaithird.' Hingga '.$selesaithird.' Salinan '.$salisanthird;
                                }
                                

                            }
                            elseif (($rmulai - $rselesaithird) < 30 && ($rmulai > $rselesaithird)) {

                                $iscompromised = 1;
                                if($levelwarning != 2) {
                                    $levelwarning = 1;
                                }
                                if ($keterangan == '') {
                                    $keterangan = 'Jadwal Praktik Terlalu Dekat Dengan Hari '.$hariathird. ' Pukul '.$mulaithird.' Hingga '.$selesaithird. ' Salinan '.$salisanthird;
                                } else {
                                    $keterangan = $keterangan. ', Jadwal Praktik Terlalu Dekat Dengan Hari '.$hariathird. ' Pukul '.$mulaithird.' Hingga '.$selesaithird. ' Salinan '.$salisanthird;
                                }
                                
                            } elseif (($rmulaithird - $rselesai) < 30 && ($rmulaithird > $rselesai )) {

                                $iscompromised = 1;
                                if($levelwarning != 2) {
                                    $levelwarning = 1;
                                }
                                if ($keterangan == '') {
                                    $keterangan = 'Jadwal Praktik Terlalu Dekat Dengan Hari '.$hariathird. ' Pukul '.$mulaithird.' Hingga '.$selesaithird. ' Salinan '.$salisanthird;
                                } else {
                                    $keterangan = $keterangan. ', Jadwal Praktik Terlalu Dekat Dengan Hari '.$hariathird. ' Pukul '.$mulaithird.' Hingga '.$selesaithird. ' Salinan '.$salisanthird;
                                }

                            }
                        } elseif ($isNextDay == 1 && $isNextDaythird != 1) {

                            if(($rmulaithird <= $rmulai) && ($rmulai <= $rselesaithird)){

                                $iscompromised = 1;
                                $levelwarning = 2;
                                if($keterangan == '') {
                                    $keterangan = 'Jadwal Berbenturan Dengan Hari '.$hariathird. ' Pukul '.$mulaithird.' Hingga '.$selesaithird.' Salinan '.$salisanthird;
                                } else {
                                    $keterangan = $keterangan.', Jadwal Berbenturan Dengan Hari '.$hariathird. ' Pukul '.$mulaithird.' Hingga '.$selesaithird.' Salinan '.$salisanthird;
                                }
                                

                            }

                        } elseif ($isNextDay != 1 && $isNextDaythird == 1) {

                            if(($rmulai <= $rmulaithird) && ($rmulaithird <= $rselesai)){

                                $iscompromised = 1;
                                $levelwarning = 2;
                                if($keterangan == '') {
                                    $keterangan = 'Jadwal Berbenturan Dengan Hari '.$hariathird. ' Pukul '.$mulaithird.' Hingga '.$selesaithird.' Salinan '.$salisanthird;
                                } else {
                                    $keterangan = $keterangan.', Jadwal Berbenturan Dengan Hari '.$hariathird. ' Pukul '.$mulaithird.' Hingga '.$selesaithird.' Salinan '.$salisanthird;
                                }
                                

                            }

                        } else {

                            $iscompromised = 1;
                            $levelwarning = 2;
                            if($keterangan == '') {
                                $keterangan = 'Jadwal Berbenturan Dengan Hari '.$hariathird. ' Pukul '.$mulaithird.' Hingga '.$selesaithird.' Salinan '.$salisanthird;
                            } else {
                                $keterangan = $keterangan.', Jadwal Berbenturan Dengan Hari '.$hariathird. ' Pukul '.$mulaithird.' Hingga '.$selesaithird.' Salinan '.$salisanthird;
                            }

                        }

                    }


                    if($isnextdaybeforethird == 1 && $issetbeforethird == 1) {
                        if($rselesaibeforethird > $rmulai) {
                            $iscompromised = 1;
                            $levelwarning = 2;
                            if($keterangan == '') {
                                $keterangan = 'Jadwal Berbenturan Dengan Hari (Sebelumnya) '.$haribeforethird. ' Pukul '.$mulaibeforethird.' Hingga '.$selesaibeforethird.' Salinan '.$salisanthird;
                            } else {
                                $keterangan = $keterangan.', Jadwal Berbenturan Dengan Hari (Sebelumnya) '.$haribeforethird. ' Pukul '.$mulaibeforethird.' Hingga '.$selesaibeforethird.' Salinan '.$salisanthird;
                            }
                            
                        } elseif (($rmulai - $rselesaibeforethird) < 30) {
                            $iscompromised = 1;
                            if($levelwarning != 2) {
                                $levelwarning = 1;
                            }
                            if ($keterangan == '') {
                                $keterangan = 'Jadwal Praktik Terlalu Dekat Dengan Hari (Sebelumnya) '.$haribeforethird. ' Pukul '.$mulaibeforethird.' Hingga '.$selesaibeforethird. ' Salinan '.$salisanthird;
                            } else {
                                $keterangan = $keterangan. ', Jadwal Praktik Terlalu Dekat Dengan Hari (Sebelumnya) '.$haribeforethird. ' Pukul '.$mulaibeforethird.' Hingga '.$selesaibeforethird. ' Salinan '.$salisanthird;
                            }
                            
                        }
                    }
    
                    if($isNextDay == 1) {
                        if(($rselesai > $rmulaiafterthird) && $issetafterthird == 1) {
                            $iscompromised = 1;
                            $levelwarning = 2;
                            if ($keterangan == '') {
                                $keterangan = 'Jadwal Berbenturan Dengan Hari (Setelahnya) '.$hariafterthird. ' Pukul '.$mulaiafterthird.' Hingga '.$selesaiafterthird. ' Salinan '.$salisanthird;
                            } else {
                                $keterangan = $keterangan. ', Jadwal Berbenturan Dengan Hari (Setelahnya) '.$hariafterthird. ' Pukul '.$mulaiafterthird.' Hingga '.$selesaiafterthird. ' Salinan '.$salisanthird;
                            }
                            
                        } elseif(($rmulaiafterthird - $rselesai) < 30 && $issetafterthird == 1) {
                            $iscompromised = 1;
                            if($levelwarning != 2) {
                                $levelwarning = 1;
                            }

                            if ($keterangan == '') {
                                $keterangan = 'Jadwal Praktik Terlalu Dekat Dengan Hari (Setelahnya) '.$hariafterthird. ' Pukul '.$mulaiafterthird.' Hingga '.$selesaiafterthird. ' Salinan '.$salisanthird;
                            } else {
                                $keterangan = $keterangan. ', Jadwal Praktik Terlalu Dekat Dengan Hari (Setelahnya) '.$hariafterthird. ' Pukul '.$mulaiafterthird.' Hingga '.$selesaiafterthird. ' Salinan '.$salisanthird;
                            }
                            
                        }
                    }


                    
                    
                }

                $uraian = str_replace(["\r\n", "\r", "\n"], ",", $isuraian);
            }
        
            

            if($isadmin ==  1)
            {
                $haribaru = $this->namahari($urutan);
                $id_pengajuan = isset($submitdata['id_pengajuan']) ? $submitdata['id_pengajuan'] : 0;
                $updateDetails = [
                    'id_user' => $id_user,
                    'id_doc' => $id_doc,
                    'id_pengajuan' => $id_pengajuan,
                    'salinan' => $salinan,
                    'isSet' => $isSet,
                    'urutan' => $urutan,
                    'hari' => $haribaru,
                    'mulai' => $mulai,
                    'selesai' => $selesai,
                    'rmulai' => $rmulai,
                    'rselesai' => $rselesai,
                    'is_shift' => $isshift,
                    'isNextDay' => $isNextDay,
                    'iscompromised' => $iscompromised,
                    'levelwarning' => $levelwarning,
                    'keterangan' => $keterangan,
                    'uraian' => $uraian,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $affected = DB::table('tbl_jadwalpraktik')
                    ->insert($updateDetails);

            } else {

                $updateDetails = [
                    'isSet' => $isSet,
                    'mulai' => $mulai,
                    'selesai' => $selesai,
                    'rmulai' => $rmulai,
                    'rselesai' => $rselesai,
                    'is_shift' => $isshift,
                    'isNextDay' => $isNextDay,
                    'iscompromised' => $iscompromised,
                    'levelwarning' => $levelwarning,
                    'keterangan' => $keterangan,
                    'uraian' => $uraian,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $affected = DB::table('tbl_jadwalpraktik')
                    ->where('id_user', $id_user)
                    ->where('id_doc', $id_doc)
                    ->where('salinan', $salinan)
                    ->where('urutan', $urutan)
                    ->update($updateDetails);
            }
            
            
            if ($affected > 0) {
                $updateresult++;
            }
            

        } 

            DB::table('tbx_log')
                ->insert([
                    'result' => $updateresult,
                    'update_date' => date('Y-m-d H:i:s')
                ]);

            if($istolak == '1') {
                DB::table('tbl_pengajuan')
                    ->where('id_user', $id_user)
                    ->where('salinan', $salinan)
                    ->where('isApproved', '9')
                    ->update(['tolak_jadwal' => '0']);
            }

        if ($updateresult == 7) {
            
            return true;
        } else {
            return false;
        }
        

    }

    public function getallpengajuan($id, $jenis) {

        $s3 = DB::table('tbl_sip')
                ->select('id as id_sip','signed_date', 'id_pengajuan', 'no_surat', 'suratpencabutan', 'alasan_tercetak', 'filename_pencabutan', 'tgl_pencabutan', 'nama_nakes', 'status_sip', 'verifdinkes', 'template_id');
            
        $s4 = DB::table('tbl_docs')
                ->select('id as id_doc','id_user', 'jenis_profesi');
        $idsiplama = DB::raw('CONCAT("M_", id) as id');
        $idsiplama_ = DB::raw('CONCAT("M_", id) as id_sip');

        if ($jenis == 'cabut') {

            

            $siplama = DB::table('tbl_sip_lama')
                ->select($idsiplama, 'id_faskes', 'nama_faskes', 'alamat_pengajuan', 'salinan', 'isApproved', 'alasan_tolak as alasan_ditolak', 'updated_at', 'created_at as signed_date', 'no_sip as no_surat', DB::raw('"1" as siplama'), 's4.jenis_profesi', 'verifdinkes', $idsiplama_, 'tbl_sip_lama.template_id')
                ->leftjoinsub($s4, 's4', function($join){
                    $join->on('tbl_sip_lama.id_doc', 's4.id_doc');
                })
                ->where('id_nakes', $id)
                ->whereIn('isApproved', ['4', 'C'])
                ->whereIn('status_sip', ['1', 'C']);

            return DB::table('tbl_pengajuan')
            ->select('tbl_pengajuan.id','id_faskes', 'nama_faskes','alamat_pengajuan', 'salinan', 'isApproved', 'alasan_ditolak','updated_at', 's3.signed_date', 's3.no_surat', DB::raw('"0" as siplama'), 's4.jenis_profesi', 's3.verifdinkes', 's3.id_sip', 's3.template_id')
            ->leftjoinsub($s3, 's3', function($join){
                $join->on('tbl_pengajuan.id', 's3.id_pengajuan');
            })
            ->leftjoinsub($s4, 's4', function($join){
                $join->on('tbl_pengajuan.id_doc', 's4.id_doc');
            })
            ->where('tbl_pengajuan.id_user', $id)
            ->whereIn('isApproved', ['4','C'])
            ->whereIn('s3.status_sip', ['1', 'C'])
            ->union($siplama) 
            ->get();

        } else if ($jenis == 'perpanjangan') {

            return DB::table('tbl_pengajuan')
            ->select('tbl_pengajuan.*', 's3.signed_date', 's3.no_surat')
            ->leftjoinsub($s3, 's3', function($join){
                $join->on('tbl_pengajuan.id', 's3.id_pengajuan');
            })
            ->where('id_user', $id)
            ->where('isApproved', 'E')
            ->get();

        } else if ($jenis == 'dirubah') {

            return DB::table('tbl_pengajuan')
            ->select('tbl_pengajuan.*', 's3.signed_date', 's3.no_surat')
            ->leftjoinsub($s3, 's3', function($join){
                $join->on('tbl_pengajuan.id', 's3.id_pengajuan');
            })
            ->where('id_user', $id)
            ->whereIn('isApproved', ['2', '3'])
            ->get();

        } else if ($jenis == 'cabuthist') {

            $siplama = DB::table('tbl_sip_lama')
            ->select($idsiplama, 'id_faskes', 'nama_faskes', 'alamat_pengajuan', 'salinan', 'isApproved', 'alasan_tolak as alasan_ditolak', 'updated_at', 'created_at as signed_date', 'no_sip as no_surat', DB::raw('"1" as siplama'), 's4.jenis_profesi', 'verifdinkes', $idsiplama_, 'tbl_sip_lama.filename_pencabutan')
            ->leftjoinsub($s4, 's4', function($join){
                $join->on('tbl_sip_lama.id_doc', 's4.id_doc');
            })
            ->where('id_nakes', $id)
            ->whereIn('isApproved', ['CF'])
            ->whereIn('status_sip', ['CF']);

            return DB::table('tbl_pengajuan')
            ->select('tbl_pengajuan.id','id_faskes', 'nama_faskes','alamat_pengajuan', 'salinan', 'isApproved', 'alasan_ditolak','updated_at', 's3.signed_date', 's3.no_surat', DB::raw('"0" as siplama'), 's4.jenis_profesi', 's3.verifdinkes', 's3.id_sip', 's3.filename_pencabutan')
            ->leftjoinsub($s3, 's3', function($join){
                $join->on('tbl_pengajuan.id', 's3.id_pengajuan');
            })
            ->leftjoinsub($s4, 's4', function($join){
                $join->on('tbl_pengajuan.id_doc', 's4.id_doc');
            })
            ->where('tbl_pengajuan.id_user', $id)
            ->whereIn('tbl_pengajuan.isApproved', ['CF'])
            ->union($siplama)
            ->get();
        
        } else {

            return DB::table('tbl_pengajuan')
            ->select('tbl_pengajuan.*', 's3.signed_date', 's3.no_surat')
            ->leftjoinsub($s3, 's3', function($join){
                $join->on('tbl_pengajuan.id', 's3.id_pengajuan');
            })
            ->where('id_user', $id)
            ->where('isApproved', '4')
            ->where('s3.status_sip', '1')
            ->get();

        }
        
    }

    public function submitpencabutan($request) {

        $salinan = $request->cabutSalinan;
        $id_nakes = $request->cabutnakes_id;
        $id_pengajuan = $request->cabutIdPengajuan;
        
        $alasan = $request->tAlasanCabut;
        $alasanlain = $request->tAlasanCabutRemark;
        $now = date('Y-m-d H:i:s');

        if($alasan == 'Lainnya') {
            $alasan_ = $alasanlain;
        } else {
            $alasan_ = $alasan;
        }

        if(Str::contains($id_pengajuan, 'M')) {

            DB::table('tbl_sip_lama')
                ->where('id_nakes', $id_nakes)
                ->update([
                    'status_sip'=>'C',
                    'isApproved' => 'C',
                    'alasan' => $alasan_,
                    'alasan_lain' => $alasanlain,
                    'tracker' => 'Nakes Mengajukan Pencabutan SIP Lama',
                    'updated_at' => date('Y-m-d H:i:s'),

                    'updater' => $id_nakes
                ]);


        } else {

            if($alasan == 4 || $alasan == 5 ) {

                DB::table('tbl_sip')
                ->where('id_nakes', $id_nakes)
                ->update(['status_sip'=>'C']);
    
                DB::table('tbl_pengajuan')
                    ->where('id_user', $id_nakes)
                    ->update(['isApproved' => 'C', 'updated_at' => $now, 'updater' => $id_nakes, 'tracker' => 'Pengajuan Pencabutan Oleh Nakes', 'alasan' => $alasan_, 'isperpanjangan' => '0']);
    
                DB::table('tbl_docs')
                    ->where('id_user', $id_nakes)
                    ->whereRAW('jenis_doc not in ("IJAZAH", "KTP")')
                    ->update(['kadaluarsa' => 'C'.$alasan]);
    
            } else {
                DB::table('tbl_sip')
                ->where('id_pengajuan', $id_pengajuan)
                ->where('id_nakes', $id_nakes)
                ->where('salinan', $salinan)
                ->update(['status_sip'=>'C']);
    
                DB::table('tbl_pengajuan')
                    ->where('id', $id_pengajuan)
                    ->where('id_user', $id_nakes)
                    ->where('salinan', $salinan)
                    ->update(['isApproved' => 'C', 'updated_at' => $now, 'updater' => $id_nakes, 'tracker' => 'Pengajuan Pencabutan Oleh Nakes', 'alasan' => $alasan_, 'isperpanjangan' => '0']);
    
                DB::table('tbl_docs')
                    ->where('id_user', $id_nakes)
                    ->where('salinan', $salinan)
                    ->whereRAW('jenis_doc not in ("IJAZAH", "KTP", "STR1", "STR2", "STR3")')
                    ->update(['kadaluarsa' => 'C'.$alasan]);
            }

        }

       
        
        return true;
    }


    public function getalasan(){
        return DB::table('master_alasan')
            ->where('kd_alasan', '<>', '99')
            ->get();
    }


    public function isPindah($id, $salinan) {
        $getId = DB::table('tbl_docs')
            ->select('kadaluarsa')
            ->where('id_user', $id)
            ->where('salinan', $salinan)
            ->where('jenis_doc', 'like', 'STR%')
            ->whereRAW('kadaluarsa in ("C4", "C5")')
            ->first();

        if($getId) {
            $isPindah = $getId->kadaluarsa;
        } else {
            $isPindah = '0';
        }

        
        return $isPindah;
    }

    public function getdetailpengajuan($id) {

        $s3 = DB::table('master_alasan')
                ->select('kd_alasan', 'nama_alasan');

        $s2 = DB::table('tbl_docs')
                ->select('id', 'id_user','namafile', 'url_qr', 'no_doc', 'tgl_doc_origin', 'tgl_doc as berlaku_sampai', 'jenis_profesi');

        $s1 = DB::table('tbl_sip')
                ->select('id_pengajuan', 'filename_sip', 'perubahan')
                ->where('status_sip', '<>','CF');


        return DB::table('tbl_pengajuan')
            ->select('tbl_pengajuan.*', 's3.nama_alasan', 's2.namafile', 's2.url_qr', 's2.no_doc', 's2.tgl_doc_origin','s1.filename_sip', 's2.berlaku_sampai', 's2.jenis_profesi')
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

    public function isKadaluarsa($id) {

        $maxid = DB::table('tbl_docs')
            ->where('id_user', $id)
            ->where('jenis_doc', 'LIKE', 'STR%')
            ->where('kadaluarsa', '<>', 'i')
            ->max('id');

        $getkadal = DB::table('tbl_docs')
            ->where('id', $maxid)
            ->first();

        return $getkadal;

        

    }

    public function getcurrentstrdetail($id) {

        $isscanned = DB::table('tbl_pendaftaran')
            ->select('origin_file')
            ->where('id_user', $id)
            ->first();
        
        $origin_file = $isscanned->origin_file;

        if($origin_file == 'scanned') {

            return DB::table('tbl_pendaftaran')
                ->select('str_hingga as tgl_doc_origin', 'kompetensi', 'no_reg as no_doc', 'template_id', 'url_qr', 'str_hingga as tgl_doc', 'salinan', DB::raw('"0" as remark3'))
                ->where('id_user', $id)
                ->first();

        } else {

            return DB::table('tbl_docs')
                ->where('id_user', $id)
                ->where('jenis_doc', 'LIKE', 'STR%')
                ->where('kadaluarsa', '0')
                ->first();

        }
        
        
    }

    public function getcurrentstrdetaildok($id, $salinan) {

        $isscanned = DB::table('tbl_pendaftaran')
            ->select('origin_file')
            ->where('id_user', $id)
            ->first();
        
        $origin_file = $isscanned->origin_file;

        if($origin_file == 'scanned') {

            return DB::table('tbl_pendaftaran')
                ->select('str_hingga as tgl_doc_origin', 'kompetensi', 'no_reg as no_doc', 'template_id', 'url_qr')
                ->where('id_user', $id)
                ->first();

        } else {

            return DB::table('tbl_docs')
                ->where('id_user', $id)
                ->where('jenis_doc', 'LIKE', 'STR%')
                ->where('salinan', $salinan)
                ->where('kadaluarsa', '0')
                ->first();

        }
        
        
    }

    public function pengajuandiperpanjang($id) {

        $maxid = DB::table('tbl_pengajuan')
            ->where('id_user', $id)
            ->where('isApproved', 'E')
            ->get();

        if(count($maxid) > 0) {
            return true;
        } else {
            return false;
        }

    }


    public function listperpanjangan($id, $sementara, $template_id) {

        if($template_id == '2') {

            if($sementara == 0) {

                return DB::table('tbl_pengajuan')
                ->where('id_user', $id)
                ->wherein('isApproved', ['4', 'E'])
                ->get();
    
            } else {
    
                return DB::table('tbl_pengajuan')
                ->where('id_user', $id)
                ->wherein('isApproved', ['4', 'E'])
                ->get();
    
            }

        } else {

            if($sementara == 0) {

                return DB::table('tbl_pengajuan')
                ->where('id_user', $id)
                ->wherein('isApproved', ['4', 'E', 'P'])
                ->get();
    
            } else {
    
                return DB::table('tbl_pengajuan')
                ->where('id_user', $id)
                ->where('isApproved', '4')
                ->get();
    
            }

        }

    }


    public function simpanperpanjanganstr($request) {
        $url_qr = $request->stURL;
        $no_reg = $request->stNoSTR;
        $nama = $request->stNama;
        $jk = $request->stJenisK;
        $kompetensi = $request->stKompetensi;
        $profesi = $request->stProfesi;
        $isBeda = $request->stKompetensiBeda;
        $id_user = $request->stUserIDNakes;
       

        //if ($isBeda == '0') {

            $img_src = $request->stImg;
            $origin_file = $request->stWhichF;
            $updated_at = date('Y-m-d H:i:s');
            $current_status = 0;
            $tgl_keluar_str_ori = $request->stStrKeluarOri;
            $str_hingga_ori = $request->stDueOri;
            $tgl_keluar_str = $request->stSTRtetapSIP;
            $str_hingga = $request->stSTRHinggaSIP;
            $pilihanSIP = $request->stProfesiSIP;
            $profesiDD = $request->stProfesiDD;

            $tgl_keluar_str_conv = $request->stStrKeluarConv;
            $str_hingga_conv = $request->stDueConv;

            $template_id = $request->stTemplateIDPerpanjangan;
            $salinan = $request->stSalinanPerpanjangan;
            $selisih = '-';
            $curkom = '';

            $getcurkom = DB::table('tbl_docs')
                ->select('kompetensi')
                ->where('id_user', $id_user)
                ->where('jenis_doc', 'like' ,'STR%')
                ->first();

            if($getcurkom) {
                $curkom = $getcurkom->kompetensi;
            }

            $getselisih = DB::select(DB::raw('call selisihexpire("'.$str_hingga.'")'));
            if($getselisih) {
                $selisih = $getselisih[0]->selisihhari;
            }

            if ($template_id == '2') {

                $tanpasalian = '0';
                $gettanpa = DB::table('tbl_docs')
                    ->select('remark3')
                    ->where('id_user', $id_user)
                    ->where('salinan', $salinan)
                    ->where('jenis_doc', 'STR'.$salinan)
                    ->first();
                if($gettanpa){
                    $tanpasalian = $gettanpa->remark3;
                }
                if (is_numeric($salinan) == false) {
                    $tanpasalian = '1';
                }

                if($tanpasalian == '0') {

                    DB::table('tbl_docs')
                        ->where('id_user', $id_user)
                        ->where('jenis_doc', 'STR'.$salinan)
                        ->update([
                                'url_qr' => $url_qr,
                                'no_doc' => $no_reg,
                                'kompetensi' => $kompetensi,
                                'tgl_berlaku' => $tgl_keluar_str,
                                'tgl_doc' => $str_hingga,
                                'namafile' => $origin_file,
                                'updated_at' => $updated_at,
                                'expiring_count' => $selisih,
                                'perubahan' => '0',
                                'tgl_berlaku_origin' => $tgl_keluar_str_ori,
                                'tgl_doc_origin' => $str_hingga_ori
                    
                        ]);

                        DB::table('tbl_pengajuan')
                        ->where('id_user', $id_user)
                        ->where('isApproved', '4')
                        ->where('salinan', $salinan)
                        ->update([
                                'isperpanjangan' => '1',
                                'isApproved' => 'E',
                                'updated_at' => $updated_at,
                                'updater' => $id_user
                    
                        ]);


                        DB::table('tbl_sip')
                            ->where('id_nakes', $id_user)
                            ->where('status_sip', '1')
                            ->where('salinan', $salinan)
                            ->update([
                                    'status_sip' => 'E'
                        
                        ]);

                } else {
                    DB::table('tbl_docs')
                        ->where('id_user', $id_user)
                        ->where('jenis_doc', 'like', 'STR%')
                        ->update([
                                'url_qr' => $url_qr,
                                'no_doc' => $no_reg,
                                'kompetensi' => $kompetensi,
                                'tgl_berlaku' => $tgl_keluar_str,
                                'tgl_doc' => $str_hingga,
                                'namafile' => $origin_file,
                                'updated_at' => $updated_at,
                                'expiring_count' => $selisih,
                                'perubahan' => '0',
                                'tgl_berlaku_origin' => $tgl_keluar_str_ori,
                                'tgl_doc_origin' => $str_hingga_ori
                    
                        ]);

                        DB::table('tbl_pengajuan')
                        ->where('id_user', $id_user)
                        ->where('isApproved', '4')
                        ->update([
                                'isApproved' => 'E',
                                'updated_at' => $updated_at,
                                'updater' => $id_user
                    
                        ]);


                        DB::table('tbl_sip')
                            ->where('id_nakes', $id_user)
                            ->where('status_sip', '1')
                            ->update([
                                    'status_sip' => 'E'
                        
                        ]);
                }
                

            } else {
                DB::table('tbl_docs')
                ->where('id_user', $id_user)
                ->where('jenis_doc', 'LIKE', 'STR%')
                ->update([
                        'url_qr' => $url_qr,
                        'no_doc' => $no_reg,
                        'kompetensi' => $kompetensi,
                        'tgl_berlaku' => $tgl_keluar_str,
                        'tgl_doc' => $str_hingga,
                        'namafile' => $origin_file,
                        'updated_at' => $updated_at,
                        'expiring_count' => $selisih,
                        'perubahan' => '0',
                        'tgl_berlaku_origin' => $tgl_keluar_str_ori,
                        'tgl_doc_origin' => $str_hingga_ori
            
                ]);

                DB::table('tbl_pengajuan')
                ->where('id_user', $id_user)
                ->where('isApproved', '4')
                ->update([
                        'isApproved' => 'E',
                        'updated_at' => $updated_at,
                        'updater' => $id_user
            
                ]);


                DB::table('tbl_sip')
                    ->where('id_nakes', $id_user)
                    ->where('status_sip', '1')
                    ->update([
                            'status_sip' => 'P'
                
                ]);
            }
            
            DB::table('users')
                ->where('id', $id_user)
                ->update([
                        'name' => $nama,
                        'photo_url' => $img_src
                ]);

        
        if ($isBeda == '1') {

            $now = date('Y-m-d H:i:s');

            $alasan_ = 'Perubahan Kompetensi Pada STR Terbaru Dari '.$curkom.' Menjadi '.$kompetensi;

            DB::table('tbl_sip')
            ->where('id_nakes', $id_user)
            ->update(['status_sip'=>'C']);

            DB::table('tbl_pengajuan')
                ->where('id_user', $id_user)
                ->update(['isApproved' => 'C', 'updated_at' => $now, 'updater' => $id_user, 'tracker' => 'Pengajuan Pencabutan Oleh Nakes (Setelah Update STR)', 'alasan' => $alasan_]);


        }
        //}
    }

    public function submitperpanjangannakes($request) {


        $alamat = $request->tAlamatPengajuanM;
        $kabupaten = $request->tKabupatenM;
        $kecamatan = $request->tKecamatanM;
        $lat = $request->tLat;
        $long = $request->tLong;
        $user_id = $request->tUserPengajuan;
        $jenis = $request->tTypeAjuan;
        $id = $request->tIdAjuan;
        $salinan = $request->tAjuanSalinan;
        $jadwal_praktek = $request->tJadwalPraktek;
        $isFaskes = $request->tIsFaskes;
        $idFaskes = $request->tidFaskes;
        $nama_faskes = $request->tNamaFaskes;
        $id_pengajuan = $request->tIDPengajuan;
        $isApproved = 0;
        $tgl_visitasi = '';
        $nama_faskes = 0;
        $isSementara = $request->tIsSementara;
        $urlqr = $request->ismanualqr;
        $perpanjangan = 0;
        $getlatestperpanjangan = DB::table('tbl_pengajuan')
            ->select('perpanjangan')
            ->where('id_user', $user_id)
            ->where('salinan', $salinan)
            ->first();
        if($getlatestperpanjangan)
        {
            $perpanjangan = $getlatestperpanjangan->perpanjangan;
            $nextperpanjangan = (int)$perpanjangan + 1;
        }

        if($isSementara == '1') {
            $updateDetails = [
                'updater' => $user_id,
                'perpanjangan' => 'S',
                'isApproved' => '0',
                'isperpanjangan' => '1',
                'updated_at' => date('Y-m-d H:i:s')
            ];
        } else {
            $updateDetails = [
                'updater' => $user_id,
                'perpanjangan' => $nextperpanjangan,
                'isApproved' => '0',
                'isperpanjangan' => '1',
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        DB::table('tbl_docs')
            ->where('id_user', $user_id)
            ->where('salinan', $salinan)
            ->where('jenis_doc', 'STR'.$salinan)
            ->update([
                'url_qr' => $urlqr
            ]);

        DB::table('tbl_sip')
            ->where('id_pengajuan', $id_pengajuan)
            ->where('id_nakes', $user_id)
            ->update([
                'status_sip' => 'E'
            ]);

        return DB::table('tbl_pengajuan')
            ->where('id', $id_pengajuan)
            ->update($updateDetails);

    }


    public function getcurrenttemplateid($id) {

        $gettemplate = DB::table('tbl_docs')
            ->where('id_user', $id)
            ->where('jenis_doc', 'LIKE', 'STR%')
            ->where('kadaluarsa', '<>', '1')
            ->first();

        if($gettemplate) {
            $template_id = $gettemplate->template_id;
            return $template_id;
        } else {
            return false;
        }

        

    }

    public function simpanstrdokter($request) {

        $id_nakes = $request->stUserIDNakesDok;
        $salinan = $request->stSalinanDok;
        $thefile = $request->stWhichFDok;
        $url_qr = $request->stUrlCodeDok;

        $query = DB::table('tbl_pendaftaran')
            ->select('origin_file', 'salinan', 'str_hingga', 'no_reg', 'url_qr', 'kompetensi', 'profesi', 'tgl_keluar_str', 'template_id', 'jenis_profesi', 'str_hingga_origin', 'universitas', 'fixed_berlaku_hingga')
            ->where('id_user', $id_nakes)
            ->first();

        $isscanned = $query->origin_file;
        if($isscanned == 'scanned') {
            DB::table('tbl_pendaftaran')
                ->where('id_user', $id_nakes)
                ->update([
                    'origin_file' => $thefile
                ]);

                //$namafile = $query->origin_file;
                $tgl_berlaku = $query->str_hingga;
                $no_doc = $query->no_reg;
                //$url_qr = $query->url_qr;
                $kompetensi = $query->kompetensi;
                $profesi = $query->profesi;
                $tgl_keluar_str = $query->tgl_keluar_str;
                $jenis_profesi = $query->jenis_profesi;
                $template_id = $query->template_id;
                $tgl_doc_origin = $query->str_hingga_origin;
                $universitas = $query->universitas;
                $fixed_berlaku_hingga = $query->fixed_berlaku_hingga;

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
                    $banyaknya = ['1', '2'];
                } else {
                    $banyaknya = ['1', '2', '3'];
                }
        
                foreach ($banyaknya as $salsal) {
        
                    if($salsal != $salinan) {
                        $kadaluarsa = 'i';
                    } else {
                        $kadaluarsa = 0;
                    }
        
                    DB::table('tbl_docs')
                    ->insert([
                        'id_user' => $id_nakes,
                        'jenis_doc' => 'STR'.$salsal,
                        'nama_doc' => 'STR'.$salsal,
                        'namafile' => $thefile,
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
                        'updater' => $id_nakes,
                        'url_qr' => $url_qr,
                        'jenis_profesi' => $jenis_profesi,
                        'template_id' => $template_id,
                        'remark1' => 'STR dari pendaftaran',
                        'remark2' => $universitas,
                        'fixed_berlaku_hingga' => $fixed_berlaku_hingga
        
                    ]);
        
                }
        
                
        } 

         DB::table('tbl_docs')
            ->where('id_user', $id_nakes)
            ->where('salinan', $salinan)
            ->where('kadaluarsa', 'i')
            ->update([
                'namafile' => $thefile,
                'kadaluarsa' => '0',
                'updated_at' => date('Y-m-d H:i:s'),
                'url_qr' => $url_qr
            ]);

        return true;



    }


    public function simpanstrnondokter($request) {

        $id_nakes = $request->stUserIDNakesnonDok;
        $salinan = $request->stSalinannonDok;
        $thefile = $request->stWhichFnonDok;
        $url_qr = $request->stUrlCodenonDok;

        $query = DB::table('tbl_pendaftaran')
            ->select('origin_file', 'salinan', 'str_hingga', 'no_reg', 'url_qr', 'kompetensi', 'profesi', 'tgl_keluar_str', 'template_id', 'jenis_profesi', 'str_hingga_origin', 'universitas', 'fixed_berlaku_hingga')
            ->where('id_user', $id_nakes)
            ->first();

        $isscanned = $query->origin_file;
        if($isscanned == 'scanned') {
            DB::table('tbl_pendaftaran')
                ->where('id_user', $id_nakes)
                ->update([
                    'origin_file' => $thefile
                ]);

                //$namafile = $query->origin_file;
                $tgl_berlaku = $query->str_hingga;
                $no_doc = $query->no_reg;
                //$url_qr = $query->url_qr;
                $kompetensi = $query->kompetensi;
                $profesi = $query->profesi;
                $tgl_keluar_str = $query->tgl_keluar_str;
                $jenis_profesi = $query->jenis_profesi;
                $template_id = $query->template_id;
                $tgl_doc_origin = $query->str_hingga_origin;
                $universitas = $query->universitas;
                $fixed_berlaku_hingga = $query->fixed_berlaku_hingga;

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
                    $banyaknya = ['1', '2'];
                } else {
                    $banyaknya = ['1', '2', '3'];
                }
        
                foreach ($banyaknya as $salsal) {
        
                    if($salsal != $salinan) {
                        $kadaluarsa = 'i';
                    } else {
                        $kadaluarsa = 0;
                    }
        
                    DB::table('tbl_docs')
                    ->insert([
                        'id_user' => $id_nakes,
                        'jenis_doc' => 'STR'.$salsal,
                        'nama_doc' => 'STR'.$salsal,
                        'namafile' => $thefile,
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
                        'updater' => $id_nakes,
                        'url_qr' => $url_qr,
                        'jenis_profesi' => $jenis_profesi,
                        'template_id' => $template_id,
                        'remark1' => 'STR dari pendaftaran',
                        'remark2' => $universitas,
                        'fixed_berlaku_hingga' => $fixed_berlaku_hingga
        
                    ]);
        
                }
        
                
        } 

         DB::table('tbl_docs')
            ->where('id_user', $id_nakes)
            ->where('salinan', $salinan)
            ->where('kadaluarsa', 'i')
            ->update([
                'namafile' => $thefile,
                'kadaluarsa' => '0',
                'updated_at' => date('Y-m-d H:i:s'),
                'url_qr' => $url_qr
            ]);

        return true;



    }


    public function simpanupdatestrnondokter($request) {

        $id_nakes = $request->stUserIDNakesnonDokU;
        $salinan = $request->stSalinannonDokU;
        
        $url_qr = $request->stUrlCodenonDokU;
        $newfilename = $request->stNewFilename;

        $query = DB::table('tbl_docs')
            ->select('template_id', 'namafile')
            ->where('id_user', $id_nakes)
            ->where('jenis_doc', 'like', 'STR%')
            ->first();
        $template_id = $query->template_id;
        $thefile = $query->namafile;

        if($template_id == '2') {

            DB::table('tbl_docs')
            ->where('id_user', $id_nakes)
            ->where('salinan', $salinan)
            ->where('jenis_doc', 'like', 'STR%')
            ->update([
                'namafile' => $newfilename,
                'remark7' => $thefile,
                'updater' => $id_nakes,
                'updated_at' => date('Y-m-d H:i:s'),
                'is_compromised' => '0',
                'keterangan_tolak' => NULL
            ]);

            return true;

        } else {

            DB::table('tbl_docs')
            ->where('id_user', $id_nakes)
            ->where('jenis_doc', 'like', 'STR%')
            ->update([
                'namafile' => $newfilename,
                'remark7' => $thefile,
                'updater' => $id_nakes,
                'updated_at' => date('Y-m-d H:i:s'),
                'is_compromised' => '0',
                'keterangan_tolak' => NULL
            ]);

            return true;
        }
    }

    public function cobaselisih($tglnya) {

        $getselisih = DB::select(DB::raw('call selisihexpire("'.$tglnya.'")'));
        $selisih = $getselisih[0]->selisihhari;
        
        return $selisih;

    }



    public function getidpengajuan($id_user, $salinan) {
        $getid = DB::table('tbl_pengajuan')
            ->where('id_user', $id_user)
            ->where('salinan', $salinan)
            ->where('isApproved','<>','CF')
            ->first();

        if($getid)
        {
            $id_pengajuan = $getid->id;
            return $id_pengajuan;

        } else {
            DB::table('tbl_docs')
                ->where('id_user', $id_user)
                ->update(
                    [
                        'is_compromised' => '0',
                        'keterangan_tolak' => NULL
                    ]);

            return false;
        }

        
    }

    public function istiga($id) {
        $gettemplate = DB::table('tbl_docs')
            ->where('id_user', $id)
            ->where('jenis_doc', 'LIKE', 'STR%')
            ->where('kadaluarsa', '<>', '1')
            ->first();
        if($gettemplate) {
            $template_id = $gettemplate->template_id;
            return $template_id;
        } else {
            return false;
        }
    }


    public function submitpersonalinfonakes($request) {

        $id_user = $request->useridprof;

        $gol_darah = $request->nakes_goldar;
        $riwayat_penyakit = $request->nakes_riwayatsk;
        $no_bpjs = $request->nakes_nobpjs;
        $pendidikan_sd = $request->nakes_sd;
        $pendidikan_smp = $request->nakes_smp;
        $pendidikan_sma = $request->nakes_sma;
        $remark = $request->nakes_sertifikasi1;
        $remark2 = $request->nakes_sertifikasi2;
        $remark3 = $request->nakes_sertifikasi3;
        
        $remark5 = $request->nakes_aldom;
        $remark6 = $request->nakes_kecdom;
        $remark7 = $request->nakes_kabdom;
        $ifdom_ = $request->ifdomprof;
        if ($ifdom_ != null) {
            $ifdom = 'D';
        } else {
            $ifdom = 'K';
            $remark5 = '';
            $remark6 = '';
            $remark7 = '';
        }

        $person = DB::table('tbl_personal_info')
            ->where('id_user',$id_user)
            ->get();


        DB::table('tbl_docs')
            ->where('id_user',$id_user)
            ->where('jenis_doc', 'KTP')
            ->update([
                'remark5' => $remark5,
                'remark6' => $remark6,
                'remark7' => $remark7,
                'url_qr' => $ifdom
            ]);

        if(count($person) > 0) {

            return DB::table('tbl_personal_info')
                ->where('id_user', $id_user)
                ->update([
                    'gol_darah' => $gol_darah,
                    'riwayat_penyakit' => $riwayat_penyakit,
                    'no_bpjs' => $no_bpjs,
                    'pendidikan_sd' => $pendidikan_sd,
                    'pendidikan_smp' => $pendidikan_smp,
                    'pendidikan_sma' => $pendidikan_sma,
                    'remark' => $remark,
                    'remark2' => $remark2,
                    'remark3' => $remark3
                ]);

        } else {

            return DB::table('tbl_personal_info')
                ->insert([
                    'id_user' => $id_user,
                    'gol_darah' => $gol_darah,
                    'riwayat_penyakit' => $riwayat_penyakit,
                    'no_bpjs' => $no_bpjs,
                    'pendidikan_sd' => $pendidikan_sd,
                    'pendidikan_smp' => $pendidikan_smp,
                    'pendidikan_sma' => $pendidikan_sma,
                    'remark' => $remark,
                    'remark2' => $remark2,
                    'remark3' => $remark3
                ]);

        }

    }

    public function getditolak($jenis, $id) {
        if ($jenis == 'dokumen') {
            $dok = DB::table('tbl_docs')
                ->where('id_user', $id)
                ->where('is_compromised', '1')
                ->get();

            return count($dok);
        } else if ($jenis == 'pengajuan') {
            $pengajuan = DB::table('tbl_pengajuan')
                ->where('id_user', $id)
                ->where('isApproved', '9')
                ->where('perubahan', '0')
                ->get();

            return count($pengajuan);
        } else if ($jenis == 'perubahan') {
            $perubahan = DB::table('tbl_pengajuan')
                ->where('id_user', $id)
                ->where('isApproved', '9')
                ->where('perubahan','<>','0')
                ->get();
            return count($perubahan);
        } else if ($jenis == 'perpanjangan') {
            $perpanjangan = DB::table('tbl_pengajuan')
                ->where('id_user', $id)
                ->where('isApproved', 'E9')
                ->get();
            return count($perpanjangan);
        } else if ($jenis == 'sipmanual') {

            $siplama = DB::table('tbl_sip_lama')
                ->where('id_nakes', $id)
                ->where('isApproved', '9')
                ->get();
            return count($siplama);

        }
    }

    public function getditolaksalinan($jenis, $id, $salinan) {
        
            $dok = DB::table('tbl_docs')
                ->where('id_user', $id)
                ->where('salinan', $salinan)
                ->where('is_compromised', '1')
                ->whereRAW('jenis_doc not in ("KTP","FOTO", "IJAZAH")')
                ->get();

            return count($dok);
        
    }

    public function getselectedfaskesedit($id_pengajuan) {

        $getid_user = DB::table('tbl_pengajuan')
            ->select('id_user')
            ->where('id', $id_pengajuan)
            ->first();

        $id_user = $getid_user->id_user;

        $s3 = DB::table('tbl_pengajuan')
                ->select('id_faskes as selectedfaskes')
                ->where('id', $id_pengajuan);

        return DB::table('master_faskes')
        ->selectRAW('master_faskes.*, ifnull(s3.selectedfaskes,0) as selectedfaskes')
        ->leftjoinsub($s3, 's3', function($join){
            $join->on('master_faskes.id_faskes', 's3.selectedfaskes');
        })
        ->whereRAW('master_faskes.id_faskes not in (SELECT id_faskes FROM tbl_pengajuan WHERE id_user = "'.$id_user.'" AND id_faskes <> "0" AND id <> "'.$id_pengajuan.'" AND isApproved <> "CF")')
        ->get();

     
    }

    public function getdetailpeng($id_pengajuan){
        return DB::table('tbl_pengajuan')
                    ->where('id', $id_pengajuan)
                    ->first();
    }

    public function updateafterop($id_pengajuan) {
        return DB::table('tbl_pengajuan')
                    ->where('id', $id_pengajuan)
                    ->update(['isApproved' => '0']);
    }

    public function updatelokasipengajuan($request) {

        $nama_faskes = '';
        $id_pengajuan = $request->id_pengajuan;
        $getcurrentisfa = DB::table('tbl_pengajuan')
            ->select('isFaskes')
            ->where('id', $id_pengajuan)
            ->first();
        $currentstatusfaskes = $getcurrentisfa->isFaskes;

        $isFaskes = $request->isFaskes;
        $idFaskesEdit = $request->idFaskesEdit;
        $selectedfaskes = $request->selectedfaskes;
        if($isFaskes == $currentstatusfaskes) {
            $id_faskes = $selectedfaskes;
        } else {
            $id_faskes = $idFaskesEdit;
        }

        if ($isFaskes == '1') {

            $getnama = DB::table('master_faskes')
                ->select('nama_faskes')
                ->where('id_faskes', $id_faskes)
                ->first();
            if($getnama) {
                $nama_faskes = $getnama->nama_faskes;

            } else {

                $getnama = DB::table('master_faskes')
                ->select('nama_faskes')
                ->where('id_faskes', $id_faskes)
                ->first();
                $nama_faskes = $getnama->nama_faskes;
            }
            
        }
        $alamatpengajuan = $request->alamatpengajuan;
        $kabpengajuan = $request->kabpengajuan;
        $kecpengajuan = $request->kecpengajuan;
        $latpengajuan = $request->latpengajuan;
        $longpengajuan = $request->longpengajuan;

        return DB::table('tbl_pengajuan')
            ->where('id', $id_pengajuan)
            ->update([
                'isFaskes' => $isFaskes,
                'id_faskes' => $id_faskes,
                'nama_faskes' => $nama_faskes,
                'alamat_pengajuan' => $alamatpengajuan,
                'kabupaten' => $kabpengajuan,
                'kecamatan' => $kecpengajuan,
                'latitude' => $latpengajuan,
                'longitude' => $longpengajuan,
                'tolak_lokasi' => 'U'
            ]);

    }

    public function gettoupdatepengajuan($request){

        $id_pengajuan = $request->id_pengajuan;
        $lokasi = 0;
        $jadwal = 0;

        $getinti = DB::table('tbl_pengajuan')
                    ->select('id_user','salinan', 'tolak_lokasi', 'tolak_jadwal')
                    ->where('id', $id_pengajuan)
                    ->first();
        $id_user = $getinti->id_user;
        $salinan = $getinti->salinan;
        $ctl = $getinti->tolak_lokasi;
        $ctj = $getinti->tolak_jadwal;

        if ($ctl == '1') {
            $lokasi = 1;
        } 

        if ($ctj == '1') {
            $jadwal = 1;
        } 

        $countdoc = DB::table('tbl_docs')
                        ->where('id_user', $id_user)
                        ->where('salinan', $salinan)
                        ->where('is_compromised', '1')
                        ->whereRAW('jenis_doc not in ("KTP","FOTO", "IJAZAH")')
                        ->count();

        $countdocinti = DB::table('tbl_docs')
                        ->where('id_user', $id_user)
                        ->where('salinan', $salinan)
                        ->where('is_compromised', '1')
                        ->whereRAW('jenis_doc in ("KTP","FOTO", "IJAZAH")')
                        ->count();

        $totalcek = (int)$countdoc + (int)$countdocinti + (int)$lokasi + (int)$jadwal;

        return $totalcek;

    }


    
    public function gettoupdatepengajuanlokasi($request){

        $id_pengajuan = $request->id_pengajuan;
        $lokasi = 0;
        $jadwal = 0;

        $getinti = DB::table('tbl_pengajuan')
                    ->select('id_user','salinan', 'tolak_lokasi', 'tolak_jadwal')
                    ->where('id', $id_pengajuan)
                    ->first();
        $id_user = $getinti->id_user;
        $salinan = $getinti->salinan;
        $ctl = $getinti->tolak_lokasi;
        $ctj = $getinti->tolak_jadwal;

        if ($ctl == '1') {
            $lokasi = 1;
        } 

       

        $countdoc = DB::table('tbl_docs')
                        ->where('id_user', $id_user)
                        ->where('salinan', $salinan)
                        ->where('is_compromised', '1')
                        ->whereRAW('jenis_doc not in ("KTP","FOTO", "IJAZAH")')
                        ->count();

        $countdocinti = DB::table('tbl_docs')
                        ->where('id_user', $id_user)
                        ->where('salinan', $salinan)
                        ->where('is_compromised', '1')
                        ->whereRAW('jenis_doc in ("KTP","FOTO", "IJAZAH")')
                        ->count();

        $totalcek = (int)$countdoc + (int)$countdocinti + (int)$lokasi;

        return $totalcek;

    }

    public function resubmitpengajuan($request) {
        
        $id_pengajuan = $request->id_pengajuan;
        $updater = $request->updater;
        $newtemplate = $request->templateupdate;
        $isApproved = '0';

        $getpenolak = DB::table('tbl_pengajuan_hist')
            ->select('isApproved')
            ->where('id', $id_pengajuan)
            ->whereNotIn('isApproved', ['9', '4', 'OP'])
            ->orderby('updated_at', 'desc')
            ->first();

        if($getpenolak) {
            $isApproved = $getpenolak->isApproved;
            if(is_numeric($isApproved)) {
                if($isApproved < 2) {
                    $isApproved = 0;
                } else {
                    $isApproved = 2;
                }
            } else if ($isApproved == '1K') {
                $isApproved = 0;
            }
        }
    
        if ($newtemplate == 0) {

            return DB::table('tbl_pengajuan')
            ->where('id', $id_pengajuan)
            ->update([
                'isApproved' => $isApproved,
                'tracker' => 'Sedang Diajukan Kembali',
                'updater' => $updater,
                'updated_at' => date('Y-m-d H:i:s'),
                'alasan_ditolak' => null
            ]);

        } else {
            return DB::table('tbl_pengajuan')
            ->where('id', $id_pengajuan)
            ->update([
                'isApproved' => $isApproved,
                'tracker' => 'Sedang Diajukan Kembali',
                'template_id' => $newtemplate,
                'updater' => $updater,
                'updated_at' => date('Y-m-d H:i:s'),
                'alasan_ditolak' => null
            ]);
        }

    }

    public function getdetailktp($id_nakes) {
        return DB::table('tbl_docs')
            ->where('id_user', $id_nakes)
            ->where('jenis_doc', 'KTP')
            ->first();
    }

    public function getdetaildok($id_nakes, $jenis_doc, $salinan) {

        if($jenis_doc == 'IJAZAH') {

            return DB::table('tbl_docs')
                ->where('id_user', $id_nakes)
                ->where('jenis_doc', $jenis_doc)
                ->first();

        } else {

            return DB::table('tbl_docs')
                ->where('id_user', $id_nakes)
                ->where('jenis_doc', $jenis_doc)
                ->where('salinan', $salinan)
                ->first();

        }

        
        
    }

    public function updatedoknakes($request, $namafile, $tgl_doc) {

        $jenis_doc = $request->tjenisdoc;
        $user_id = $request->tUserDok;
        $updater = $request->dokUploader;
        $salinan = $request->tupdateSalinan;
        $no_doc = $request->dokNOMOR;
        $tgl_berlaku = $request->dokTGL;
        $tgl_origin = $request->dokTGL;
        $id_doc = $request->tIDdokumen;
        $remark1 = $request->dokREMARK1;
        $remark2 = $request->dokREMARK2;
        $remark3 = $request->dokREMARK3;


        if($jenis_doc == 'IJAZAH') {

            return DB::table('tbl_docs')
                ->where('id', $id_doc)
                ->where('jenis_doc', $jenis_doc)
                ->update([

                    'namafile' => $namafile,                
                    'no_doc' => $no_doc,
                    'tgl_doc' => $tgl_doc,
                    'tgl_berlaku' => $tgl_berlaku,
                    'tgl_doc_origin' => $tgl_origin,
                
                    'remark1' => $remark1,
                    'remark2' => $remark2,
                    'remark3' => $remark3,
    
                    'updater' => $user_id,
                    'is_compromised' => '0',
                    'updated_at' => date('Y-m-d H:i:s')

                ]);

        } else if($jenis_doc == 'FOTO') {

            return DB::table('tbl_docs')
                ->where('id', $id_doc)
                ->where('jenis_doc', $jenis_doc)
                ->update([
                 
                    'updater' => $user_id,
                    'is_compromised' => '0',
                    'updated_at' => date('Y-m-d H:i:s')

                ]);

        } else {

            if (Str::contains($jenis_doc, ['SKSKP', 'SKP', 'SKTP'])) {
                
                $count = DB::table('tbl_docs')
                    ->where('id_user', $user_id)
                    ->where('jenis_doc', $jenis_doc)
                    ->where('is_compromised', '1')
                    ->where('id', '<>', $id_doc)
                    ->delete();
            }

            if (Str::contains($jenis_doc, ['SKSKP']))
            {
                return DB::table('tbl_docs')
                ->where('id', $id_doc)
                ->where('jenis_doc', 'like', 'SKSKP%')
                ->update([
                    
                    'namafile' => $namafile,   
                    'no_doc' => $no_doc,
                    'tgl_doc' => $tgl_doc,
                    'tgl_berlaku' => $tgl_berlaku,
                    'tgl_doc_origin' => $tgl_origin,
                 
                    'updater' => $user_id,
                    'is_compromised' => '0',
                    'updated_at' => date('Y-m-d H:i:s')

                ]);

            } else {
                return DB::table('tbl_docs')
                ->where('id', $id_doc)
                ->where('jenis_doc', $jenis_doc)
                ->update([
                    
                    'namafile' => $namafile,   
                    'no_doc' => $no_doc,
                    'tgl_doc' => $tgl_doc,
                    'tgl_berlaku' => $tgl_berlaku,
                    'tgl_doc_origin' => $tgl_origin,
                 
                    'updater' => $user_id,
                    'is_compromised' => '0',
                    'updated_at' => date('Y-m-d H:i:s')

                ]);
            }

        }

    }

    public function getdoccompro($id, $salinan) {
        return DB::table('tbl_docs')
            ->where('id_user', $id)
            ->whereRaw('jenis_doc not in ("KTP", "IJAZAH", "STR1", "STR2", "STR3")')
            ->where('is_compromised', '1')
            ->where('salinan',$salinan)
            ->get();
    }

    public function approvedsip($id) {
        return DB::table('tbl_sip')
            ->where('id_nakes', $id)
            ->where('status_sip', '1')
            ->get();
    }

    public function semuajadwal($id) {
        return DB::table('tbl_jadwalpraktik')
            ->where('id_user', $id)
            ->where('kadaluarsa', '0')
            ->where('isSet', '1')
            ->get();
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

    public function nakesupdatepass($request) {
        $newpass = $request->newpass;
        $id_user = $request->id_user;

        return DB::table('users')
            ->where('id', $id_user)
            ->update([
                'freshpass' => 0,
                'updated_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make($newpass)
            ]);
        
    }

    public function getallwilayah(){

        $jsonFilePath = public_path('wilayah.json');
        $jsonString = file_get_contents($jsonFilePath);
        $data = json_decode($jsonString, true);
        return $data;
    }

    public function getallvisitasi($request) {

        $id_nakes = $request->id_nakes;
        return DB::table('tbl_pengajuan')
            ->where('id_user', $id_nakes)
            ->get();

    }

    public function ismanual($id) {
        $manual = 1;
        $geturl = DB::table('tbl_pendaftaran')
            ->where('id_user', $id)
            ->first();

        if($geturl) {
            $url_qr = $geturl->url_qr;
            $remark = $geturl->remark;

            if($remark == 'manual') {
                if($url_qr == 'manual') {
                    return $manual;
                } else {
                    if (Str::contains($url_qr, 'kki.go.id/cekdokter')) {
                        $urlget = config('app.warehouse_host').'nakes/getdatanakes_dok';
                        $response = Http::asForm()->post($urlget, ['thename'=>$geturl]);
                        $response_status = $response->status();
                        if($response_status == 200) {
                            return 0;
                        } else {
                            return $manual;
                        }
                    } else {
                        return $manual;
                    }
                }
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }


    public function simpanstrmanualdokter($request) {

        $id_nakes = $request->stUserIDNakesDokmanual;
        $salinan = $request->stSalinanManual;
        $thefile = $request->stWhichFManualDok;
        $url_qr = $request->sturlqrmanualdok;
        if ($url_qr != null) {

            return DB::table('tbl_docs')
            ->where('id_user', $id_nakes)
            ->where('salinan', $salinan)
            ->where('kadaluarsa', 'i')
            ->update([
                'namafile' => $thefile,
                'updater' => $id_nakes,
                'kadaluarsa' => '0',
                'updated_at' => date('Y-m-d H:i:s'),
                'url_qr' => $url_qr
            ]);

        } else {

            return DB::table('tbl_docs')
            ->where('id_user', $id_nakes)
            ->where('salinan', $salinan)
            ->where('kadaluarsa', 'i')
            ->update([
                'namafile' => $thefile,
                'updater' => $id_nakes,
                'kadaluarsa' => '0',
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        }
        
    }


    public function checkstatussip($id_pengajuan, $id_nakes, $salinan) {
        $filename_sip = 0;
        $getperub = DB::table('tbl_pengajuan')
            ->select('perubahan')
            ->where('id', $id_pengajuan)
            ->first();
        

        if($getperub) {
            $perubahan = $getperub->perubahan;
            $query = DB::table('tbl_sip')
            
                ->select('filename_sip')
                ->where('id_pengajuan', $id_pengajuan)
                ->where('salinan', $salinan)
                ->where('id_nakes', $id_nakes)
                ->where('perubahan', $perubahan)
                ->where('status_sip', '0')
                ->first();
        

            if($query) {
                $filename_sip = $query->filename_sip;
            }
        }
        

        return $filename_sip;

    }

    public function batalkanpengajuan($request) {
        $id_pengajuan = $request->id_pengajuan;
        $id_doc = $request->id_doc;
        $updater = $request->updater;


        DB::table('tbl_jadwalpraktik')
            ->where('id_pengajuan', $id_pengajuan)
            ->delete();

        DB::table('tbl_docs')
            ->where('id', $id_doc)
            ->update([
                'isDiajukan' => '0',
                'updater' => $updater,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        DB::table('tbl_sip')
            ->where('status_sip', '<>','1')
            ->where('id_pengajuan', $id_pengajuan)
            ->delete();

        DB::table('tbl_pengajuan')
            ->where('id', $id_pengajuan)
            ->delete();

        return true;
    }

    public function getesipbefore($request) {

        $id_pengajuan = $request->id_pengajuan;
        $perubahan = $request->perubahanbefore;

        return DB::table('tbl_sip')
            ->where('perubahan', $perubahan)
            ->where('id_pengajuan', $id_pengajuan)
            ->first();

    }

    public function simpanupdateqrcode($request) {

        $id_doc = $request->qriddocument;
        $url_qr = $request->qrupdatedurl;
        $updater = $request->qrupdaterid;
        return DB::table('tbl_docs')
            ->where('id', $id_doc)
            ->update([
                'url_qr' => $url_qr,
                'updater' => $updater,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

    }

    public function allismanual($id) {
        $allmanual = 1;
        $getdata = DB::table('tbl_docs')
            ->select('url_qr')
            ->where('jenis_doc', 'like', 'STR%')
            ->where('url_qr','<>','manual')
            ->where('id_user', $id)
            ->first();
        if($getdata) {
            $allmanual = $getdata->url_qr;
        }

        return $allmanual;
    }

    public function simpanstrsubdokter($request) {

        $id = $request->stUserIDNakesDokmanual;
        $namafile = $request->stWhichFManualDok;
        $url_qr = $request->sturlqrmanualdok;
        $kompetensi_sub = $request->stKomSub;


        $getdatastr = DB::table('tbl_docs')
            ->where('jenis_doc', 'like', 'STR%')
            ->where('id_user', $id)
            ->where('kadaluarsa', '0')
            ->first();

        $no_doc = $getdatastr->no_doc;
        $tgl_doc = $getdatastr->tgl_doc;
        $tgl_berlaku = $getdatastr->tgl_berlaku;
        $tgl_doc_ori = $getdatastr->tgl_doc_origin;
        $tgl_berlaku_ori = $getdatastr->tgl_berlaku_origin;
        $perubahan = $getdatastr->perubahan;
        $salinan = '4';
        $remark1 = 'STR Subspesialis';
        
        
        

        return DB::table('tbl_docs')
            ->insert(array(
                'id_user' => $id,
                'jenis_doc' => 'stsub',
                'namafile' => $namafile,
                'nama_doc' => 'STR Subspesialis',
                'no_doc' => $no_doc,
                'tgl_doc' => $tgl_doc,
                'tgl_berlaku' => $tgl_berlaku,
                'tgl_doc_origin' => $tgl_doc_ori,
                'tgl_berlaku_origin' => $tgl_berlaku_ori,
                'perubahan' => $perubahan,
                'salinan' => $salinan,
                'kompetensi' => $kompetensi_sub,
                'profesi' => $kompetensi_sub,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')

            ));

    }

    public function getsubspesialis($id) {

        $kompetensisub = '0';

        $getdatastr = DB::table('tbl_docs')
            ->where('jenis_doc', 'stsub')
            ->where('id_user', $id)
            ->first();

        if($getdatastr) {
            $kompetensisub = $getdatastr->kompetensi;
        }

        return $kompetensisub;

    }

    public function gethistoripengajuan($id_pengajuan) {

        $s1 = DB::table('users')
            ->select('id','name');

        $q1 = DB::table('tbl_pengajuan')
            ->select('s1.name as pelaku', 'nama_faskes', DB::raw('CONVERT_TZ(STR_TO_DATE(updated_at, "%Y-%m-%d %H:%i:%s"), "+00:00", "+07:00") as updated_at'), 'tracker', 'alasan_ditolak', 'isApproved')
            ->leftjoinsub($s1, 's1', function($join){
                $join->on('tbl_pengajuan.updater', 's1.id');
            })
            ->where('tbl_pengajuan.id', $id_pengajuan);
        
        $q2 = DB::table('tbl_pengajuan_hist')
            ->select(DB::raw('ifnull(s1.name,"Nakes") as pelaku'), 'nama_faskes', DB::raw('CONVERT_TZ(STR_TO_DATE(updated_at, "%Y-%m-%d %H:%i:%s"), "+00:00", "+07:00") as updated_at'), 'tracker', 'alasan_ditolak', 'isApproved')
            ->leftjoinsub($s1, 's1', function($join){
                $join->on('tbl_pengajuan_hist.updater', 's1.id');
            })
            ->where('tbl_pengajuan_hist.id', $id_pengajuan)
            ->where('isApproved','<>','OP');

        $results = $q1->unionall($q2)->orderByDesc('updated_at')->get();
        return $results;
    }

    public function getsejawat($id_nakes) {

        $pendaf = DB::table('tbl_pendaftaran')
            ->select('id_user', 'no_reg', 'nama', 'str_hingga');

        $getjepro = DB::table('tbl_docs')
            ->select('jenis_profesi')
            ->where('id_user', $id_nakes)
            ->where('jenis_doc','like','STR%')
            ->first();

        if($getjepro) {
            $prof = $getjepro->jenis_profesi;

            $quer = DB::table('tbl_docs')
                ->select('id_user')
                ->where('jenis_doc', 'STR1')
                ->where('jenis_profesi',$prof)
                ->where('id_user','<>',$id_nakes)
                ->pluck('id_user')
                ->toArray();

            return DB::table('users')
                ->select('users.id','pendaf.nama','pendaf.no_reg', 'pendaf.str_hingga', 'saved_photo')
                ->leftjoinsub($pendaf, 'pendaf', function($join){
                    $join->on('users.id', 'pendaf.id_user');
                })
                ->whereIn('id', $quer)
                ->limit(20)
                ->get();

        } else {
            return 0;
        }

        
    }

    public function simpansipmanual($request) {

        $id_nakes = $request->id_nakes;
        $id_doc = $request->id_doc;
        $namafile = $request->namafile;
        $no_sip = $request->no_sip;
        $nama_faskes = $request->nama_faskes;
        $alamat_pengajuan = $request->alamat_pengajuan;
        $kecamatan = $request->kecamatan;
        $kabupaten = $request->kabupaten;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $isFaskes = $request->isFaskes;
        $id_faskes = $request->id_faskes;
        $jadwal_praktik = $request->jadwal_praktik;
        $salinan = $request->salinan;
        $isedit = $request->isedit;
        $id_pengajuan = $request->id_pengajuan;
        if($isedit != '1') {

            $updatedoc = DB::table('tbl_docs')
                ->where('id', $id_doc)
                ->update([
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updater' => $id_nakes,
                    'isDiajukan' => '1',
                    'sip_manual' => 1
                ]);

            if($updatedoc) {

                return DB::table('tbl_sip_lama')
                    ->insert([
                        'id_nakes' => $id_nakes,
                        'id_doc' => $id_doc,
                        'namafile' => $namafile,
                        'no_sip' => $no_sip,
                        'nama_faskes' => $nama_faskes,
                        'alamat_pengajuan' => $alamat_pengajuan,
                        'kecamatan' => $kecamatan,
                        'kabupaten' => $kabupaten,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'isFaskes' => $isFaskes,
                        'id_faskes' => $id_faskes,
                        'jadwal_praktik' => $jadwal_praktik,
                        'template_id' => 'M',
                        'tracker' => 'Nakes Upload Dokumen SIP',
                        'salinan' => $salinan,
                        'isApproved' => '2',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updater' => $id_nakes,
                        'status_sip' => 0
                    ]);

            } else {
                return false;
            }

        } else {

            return DB::table('tbl_sip_lama')
                ->where('id', $id_pengajuan)
                ->update([
                    'no_sip' => $no_sip,
                    'nama_faskes' => $nama_faskes,
                    'alamat_pengajuan' => $alamat_pengajuan,
                    'kecamatan' => $kecamatan,
                    'kabupaten' => $kabupaten,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'isFaskes' => $isFaskes,
                    'id_faskes' => $id_faskes,
                    'jadwal_praktik' => $jadwal_praktik,
                    'tracker' => 'Nakes Submit Ulang SIP Manual',
                    'isApproved' => '2',
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updater' => $id_nakes
                ]);

        }

        

    }

    public function batalajukansipmanual($request) {
        $id_doc = $request->id_doc;
        return DB::table('tbl_docs')
            ->where('id', $id_doc)
            ->update([
                'updated_at' => date('Y-m-d H:i:s'),
                'isDiajukan' => '0',
                'sip_manual' => 0
            ]);
    }

    public function checksipmanual($id_nakes, $salinan) {
        $getmanual = DB::table('tbl_docs')
            ->select('sip_manual')
            ->where('id_user', $id_nakes)
            ->where('jenis_doc', 'STR'.$salinan)
            ->where('isDiajukan', '1')
            ->first();
        if($getmanual) {
            if($getmanual->sip_manual == '1') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getdetailsiplama($id_nakes, $salinan) {

        $s1 = DB::table('tbl_docs')
            ->select('id as id_doc', 'tgl_doc')
            ->where('id_user', $id_nakes)
            ->where('jenis_doc', 'STR'.$salinan)
            ->where('isDiajukan', '1')
            ->where('sip_manual', '1');

        return DB::table('tbl_sip_lama')
            ->select('tbl_sip_lama.*', 'id_nakes as id_user','s1.tgl_doc as berlaku_sampai')
            ->leftjoinsub($s1, 's1', function($join){
                $join->on('tbl_sip_lama.id_doc', 's1.id_doc');
            })
            ->where('id_nakes', $id_nakes)
            ->where('salinan', $salinan)
            ->first();
       
    }

    public function getjenisstr($id) {
        $ismanual = '0';

        $geturl = DB::table('tbl_docs')
            ->select('url_qr')
            ->where('id_user', $id)
            ->where('jenis_doc', 'like', 'STR%')
            ->first();

        if($geturl->url_qr == 'manual') {
            $ismanual = '1';
        } 

        return $ismanual;
    }
    
    public function erropengajuanlog($e, $request) 
    {
        $user_id = $request->tUserPengajuan;
        $salinan = $request->tAjuanSalinan;
        $errorString = (string) $e;

        return DB::table('error_pengajuan_logs')
            ->insert([
                'id_user' => $user_id,
                'salinan' => $salinan,
                'error_log' => $errorString,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

    }

    public function isnosalinan($id, $salinan)
    {
        $isnosalinan = '0';
        $result = DB::table('tbl_docs')
            ->select('remark3 as nosalinan')
            ->where('id_user', $id)
            ->where('jenis_doc', 'like', 'STR%')
            ->whereNotNull('remark3')
            ->first();
        if($result) {
            $isnosalinan = $result->nosalinan;
        }
    }

    public function skipvalidasistr($request)
    {
        $filename = $request->filenamestr;
        $id_user = $request->id_nakes;
        $salinan = $request->salinan;
        $isall = '0';
        //$isseumurnv = $request->isseumurnv;
        $cekremark = DB::table('tbl_docs')
            ->select('remark3')
            ->where('id_user', $id_user)
            ->where('salinan', $salinan)
            ->where('jenis_doc', 'STR'.$salinan)
            ->first();

        DB::table('tbl_pendaftaran')
            ->where('id_user', $id_user)
            ->where('salinan', $salinan)
            ->where('origin_file', 'scanned')
            ->update([
                'origin_file' => $filename
            ]);

        if($cekremark->remark3 == '1') {

            return DB::table('tbl_docs')
            ->where('id_user', $id_user)
            ->where('jenis_doc', 'like', 'STR%')
            ->update([
                'namafile' => $filename,
                'updated_at' => date('Y-m-d H:i:s'),
                'updater' => $id_user,
                'remark4' => '1',
                'is_compromised' => '0',
                'keterangan_tolak' => null
            ]);

        } else {

            return DB::table('tbl_docs')
            ->where('id_user', $id_user)
            ->where('jenis_doc', 'STR'.$salinan)
            ->update([
                'namafile' => $filename,
                'updated_at' => date('Y-m-d H:i:s'),
                'updater' => $id_user,
                'remark4' => '1',
                'is_compromised' => '0',
                'keterangan_tolak' => null
            ]);

        }
        
        
        
    }

    public function skipvalidasistrperpanjangan($request)
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
                'updater' => $id_user,
                'namafile' => $filename,
                'remark4' => 1,
                'remark5' => null,
                'is_compromised' => '0',
                'keterangan_tolak' => null
            ]);
    }

    public function getstatusqr($id, $salinan)
    {
        $url_qr = 'manual';
        $geturl = DB::table('tbl_docs')
            ->select('url_qr')
            ->where('id_user', $id)
            ->where('salinan', $salinan)
            ->where('jenis_doc', 'STR'.$salinan)
            ->first();

        if($geturl) {
            $url_qr = $geturl->url_qr;
        }

        return $url_qr;
    }

    public function getjenisform($id_user){
        $jenisform = 'LAIN_FORM';
        $getprof = DB::table('tbl_docs')
            ->select('jenis_profesi')
            ->where('id_user', $id_user)
            ->where('jenis_doc', 'STR1')
            ->first();
        
        if($getprof){
            $jenis_prof = $getprof->jenis_profesi;
            if($jenis_prof == 'DU') {
                $jenisform = 'DOK_FORM';
            } else if ($jenis_prof == 'DS'){
                $jenisform = 'DOK_FORM';
            } else if ($jenis_prof == 'DG') {
                $jenisform = 'DG_FORM';
            } else if ($jenis_prof == 'DGS') {
                $jenisform = 'DG_FORM';
            } else if (strtoupper($jenis_prof) == 'PER') {
                $jenisform = 'PER_FORM';
            } else if (strtoupper($jenis_prof) == 'NERS') {
                $jenisform = 'PER_FORM';
            } else if (strtoupper($jenis_prof) == 'BID') {
                $jenisform = 'BID_FORM';
            } else {
                $jenisform = 'LAIN_FORM';
            }
        }
        return $jenisform;
    }

    public function gettotalpengajuan($id)
    {
        return DB::table('tbl_pengajuan')
            ->where('id_user', $id)
            ->count();
    }

    public function gettotalpengajuanperpanjangan($id)
    {
        return DB::table('tbl_pengajuan')
            ->where('id_user', $id)
            ->where('isApproved', '4')
            ->count();
    }

    public function klasifikasistr($id)
    {

        //code klasifikasi
        // 1 = STR belum seumur hidup, expiring count > 60, non dokter
        // 2 = STR belum seumur hidup, expiring count < 60, non dokter
        // 3 = STR seumur hidup, non dokter
        // 4 = STR belum seumur hidup, expiring count > 60, dokter
        // 5 = STR belum seumur hidup, expiring count < 60, dokter
        // 6 = STR seumur hidup, remark 3 0
        // 7 = STR seumur hidup, remark 3 1
        $kode = 0;
        $tgl_doc = '0';
        $expiring_count = 0;
        $remark3 = '0';
        $template_id = '1';
        
        $getid = DB::table('tbl_docs')
            ->select('expiring_count', 'tgl_doc', 'remark3', 'template_id')
            ->where('id_user', $id)
            ->where('kadaluarsa', '0')
            ->where('jenis_doc', 'like', 'STR%')
            ->first();
        

        if($getid) {
            $tgl_doc = $getid->tgl_doc;
            //$expiring_count = is_numeric($getid->expiring_count) ? $getid->expiring_count : 0;
            $getselisih = DB::select(DB::raw('call selisihexpire("'.$tgl_doc.'")'));
            $expiring_count = $getselisih[0]->selisihhari;
            $remark3 = $getid->remark3;
            $template_id = $getid->template_id;
        }

        if($template_id == '2') {
            if($tgl_doc != 'Seumur Hidup') {
                if($expiring_count < 60) {
                    $kode = 5;
                } else {
                    $kode = 6;
                }
            } else {
                if($remark3 == '0') {
                    $kode = 6;
                } else {
                    $kode = 7;
                }
            }
        } else {

            if($tgl_doc != 'Seumur Hidup') {
                if($expiring_count < 60) {
                    $kode = 2;
                } else {
                    $kode = 1;
                }
            } else {
                $kode = 3;
            }

        }

        return $kode;
    }

    public function getlastpengajuan($id)
    {
      

        return DB::table('tbl_pengajuan')
            ->select('salinan', 'id')
            ->where('id_user', $id)
            ->first();

    }

    public function simpanmaindocnakes($request, $tgl_doc, $jenis_sip)
    {

        $jenis_doc = $request->tJenisDoc;

        if($jenis_doc == 'KTP') {

            $isEdit = $request->isEditKTP;

            $user_id = $request->ktpUploader;
            $namafile = 'defaultktp.jpg';
            $nama_doc = 'KTP';
            $no_doc = $request->ktpNOMOR;
            
            $namaktp = $request->ktpNAMA;

            $tgl_berlaku = date('Y-m-d H:i:s');
            $remark1 = $request->ktpALAMAT;
            $remark2 = $request->ktpKecamatan;
            $remark3 = $request->ktpKabupaten;
            $remark4 = $request->ktpTTL;
            $tgl_origin = $request->ktpTanggalLahir;
            $remark5 = $request->ktpALAMATDom;
            $remark6 = $request->ktpKecamatanDom;
            $remark7 = $request->ktpKabupatenDom;
            $ifdom_ = $request->ifdom;
            if ($ifdom_ == null) {
                $ifdom = 'D';
            } else {
                $ifdom = 'K';
            }
            $template_id = $request->ktpTemplateId;
            

            try{

                if($isEdit == '1') {
                    $hasil = $this->updatedokktp($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1,$remark2, $remark3, $remark4, $namaktp, $tgl_origin, $template_id, $jenis_sip, $remark5, $remark6, $remark7, $ifdom);
                } else {

                    $hasil = $this->tambahDocKTP($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1,$remark2, $remark3, $remark4, $namaktp, $tgl_origin, $template_id, $jenis_sip, $remark5, $remark6, $remark7, $ifdom);

                }
                if($hasil) {
                    return true;
                } else {
                    return false;
                }


            }catch(Exception $e) {

                return false;

            }

        } else {

            $user_id = $request->tUser_id;
            $isEdit = $request->tEditIjazah;

            $tUniv = $request->tUniversitas;
            $tStrata = $request->tStrata;
            $tProdi = $request->tProdi;
            $namafile = 'defaultijazah.pdf';

            $nama_doc = $request->tJudulDoc;
            $no_doc = $request->tNoDocument;
            $tgl_doc_ori = $request->tTglDocument;
            $tgl_berlaku_ori = $request->tTglBerlaku;
            $remark1 = $request->tKeterangan;
        
            if ($tgl_doc_ori != '') {
                $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
            } else {
                $tgl_doc = $tgl_doc_ori;
            }

            if ($tgl_berlaku_ori != '') {
                $tgl_berlaku = $this->help->tgl_indo_sip($tgl_berlaku_ori);
            } else {
                $tgl_berlaku = $tgl_berlaku_ori;
            }

            try{

                if($isEdit == '1') 
                {
                    $this->updateDocIjazah($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, 0, $tUniv, $tStrata, $tProdi);

                } else {

                    $this->tambahDocIjazah($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, 0, $tUniv, $tStrata, $tProdi);

                }

             
                
                
                return true;

            }catch(Exception $e) {

                return false;

            }

        }

    }

    public function getmaindoknakes($request)
    {
        $id_nakes = $request->id_nakes;
        $jenis_doc = $request->jenis_doc;
        $id_doc = $request->id_doc;
        return DB::table('tbl_docs')
            ->where('id_user', $id_nakes)
            ->where('jenis_doc', $jenis_doc)
            ->where('id', $id_doc)
            //->where('is_compromised', '1')
            ->first();
    }

    public function updateDocIjazah($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $updater, $tgl_doc_ori, $tgl_berlaku_ori, $perubahan, $tUniv, $tStrata, $tProdi)
    {

        return DB::table('tbl_docs')
                ->where('jenis_doc', $jenis_doc)
                ->where('id_user', $user_id)
                ->update(array(
                    'no_doc' => $no_doc,
                    'tgl_doc' => $tgl_doc,
                    'tgl_berlaku' => $tgl_berlaku,
                    'tgl_doc_origin' => $tgl_doc_ori,
                    'tgl_berlaku_origin' => $tgl_berlaku_ori,
                    'remark1' => $tUniv,
                    'remark2' => $tStrata,
                    'remark3' => $tProdi,
                    'remark7' => 'ijazah',
                    'updater' => $updater,
                    'is_compromised' => '0',
                    'updated_at' => date('Y-m-d H:i:s')

                ));

    }

    public function updatedetailskskp($user_id, $remark1)
    {
        return DB::table('tbl_docs')
            ->where('id_user', $user_id)
            ->where('jenis_doc', 'like', 'SKSKP%')
            ->update([
                'remark1' => $remark1
            ]);
    }

    public function detailskskp($id_nakes)
    {
        return DB::table('tbl_docs')
            ->where('id_user', $id_nakes)
            ->where('jenis_doc', 'like', 'SKSKP%')
            ->first();
    }

    public function updateSKSKP($remark1, $no_doc, $tgl_doc)
    {
        return DB::table('tbl_docs')
            ->where('jenis_doc', 'like', 'SKSKP%')
            ->update([
                'remark1' => $remark1,
                'no_doc' => $no_doc,
                'tgl_doc' => $tgl_doc
            ]);

    }

    public function nakessiphistorikalbysalinan($id_user, $salinan)
    {
        $s1 = DB::table('tbl_sip')
            ->select('perubahan as perubahan_c', 'valid_until as valid_until_c', 'id_nakes as id_nakes_c')
            ->where('id_nakes', $id_user)
            ->where('salinan', $salinan)
            ->where('status_sip', '1');

        $slatest = DB::table('tbl_sip')
            ->select('id as id_l','perubahan as perubahan_l', 'valid_until as valid_until_l', 'id_nakes as id_nakes_l', 
            'status_sip as status_sip_l', 'tgl_pencabutan as tgl_pencabutan_l')
            ->where('id_nakes', $id_user)
            ->where('salinan', $salinan);

        return DB::table('tbl_sip_hist')
            ->select('tbl_sip_hist.*', 's1.perubahan_c as perubahan_c','s1.valid_until_c as valid_until_c', 'slatest.perubahan_l', 'slatest.valid_until_l', 'slatest.status_sip_l', 'slatest.tgl_pencabutan_l')
            ->leftjoinsub($s1, 's1', function($join){
                $join->on('tbl_sip_hist.id_nakes', 's1.id_nakes_c');
            })
            ->leftjoinsub($slatest, 'slatest', function($join){
                $join->on('tbl_sip_hist.id', 'slatest.id_l');
            })
            ->where('id_nakes', $id_user)
            ->where('salinan', $salinan)
            ->where('status_sip', '1')
            ->orderby('id', 'desc')
            ->limit(5)
            ->get();

    }

    public function nakessiphistorikal($request)
    {
        $id_user = $request->id_user;
        $salinan1 = $this->nakessiphistorikalbysalinan($id_user, '1');
        $salinan2 = $this->nakessiphistorikalbysalinan($id_user, '2');
        $salinan3 = $this->nakessiphistorikalbysalinan($id_user, '3');

        return [
            'salinan1' => $salinan1,
            'salinan2' => $salinan2,
            'salinan3' => $salinan3,
        ];
    }

    public function summaryjadwal($request)
    {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Summary Laporan Layanan';
        $parsed = json_decode($request->getContent(), true);
        $result = $parsed['prompt'] ?? null;

        $prompting = 'Ubah input ini menjadi JSON berisi daftar hari, waktu mulai, waktu akhir, dan uraian.\n\nContoh output {day : senin, start: 08:00, end: 14:00, uraian: shift, isshift: true }}';

        $username = config('app.summary_user');
        $password = config('app.summary_pass');
        $urlai = config('app.summary_host').'cf5aed25-a578-4492-ba73-50b1712e93bb';

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
                    'input' => $result,
                ],
            ]);

            $body = json_decode((string) $response->getBody(), true);
            

            if (json_last_error() === JSON_ERROR_NONE) {
                $data['success'] = true;
                $data['summary'] = $body;
                $data['keterangan'] = 'Summary JSON Berhasil';
            } else {
                $data['keterangan'] = 'Gagal parsing JSON: ' . json_last_error_msg();
            }
        } catch (\Exception $e) {
            $data['keterangan'] = 'Exception: ' . $e->getMessage();
        }

        return $data;
    }

    public function cekrekomc($id, $islama)
    {
        $remark1 = 0;

        if($islama == 0)
        {

            $getid = DB::table('tbl_sip')
                ->select('id','id_nakes', 'salinan')
                ->where('id_pengajuan', $id)
                ->first();
                
            if($getid)
            {
                $remark1 = $getid->id;
            }
            
            

        } else {

            $getid = DB::table('tbl_sip_lama')
                ->select('id_nakes', 'salinan')
                ->where('id', $id)
                ->first();

            $remark1 = 'M_'.$id;

            

        }

        if($getid)
        {
            $cekdokrekom = DB::table('tbl_docs')
                ->select('id', 'salinan')
                ->where('id_user', $getid->id_nakes)
                ->where('jenis_doc', 'REKOMDOKC'.$getid->salinan)
                ->first();
            
        }

        if(!$cekdokrekom)
        {
            $rand = Str::random(10);
            return DB::table('tbl_docs')
                ->insert([
                    'id_user' => $getid->id_nakes,
                    'jenis_doc' => 'REKOMDOKC'.$getid->salinan,
                    'namafile' => 'REKOMDOKC'.$getid->salinan.'_'.$getid->id_nakes.'_'.$rand.'.pdf',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'tgl_doc' => '1 Januari 2026',
                    'tgl_berlaku' => '1 Januari 2026',
                    'tgl_doc_origin' => '2026-01-01',
                    'kadaluarsa' => 'C',
                    'expiring_count' => '-',
                    'no_doc' => '001/001/001',
                    'salinan' => $getid->salinan,
                    'remark7' => 'rekomdokc'
                ]);
        } else {
            return true;
        }
    }

    public function getdetaildokpencabutan($idpengajuan)
    {
        
        if (Str::contains($idpengajuan, 'M_'))
        {
            $idsiplama = Str::replace('M_', '', $idpengajuan);
            $ceking = $this->cekrekomc($idsiplama,1);

            $s1 = DB::table('tbl_sip_lama')
                ->select('id_nakes', 'salinan', 'c_visitasi', 'verifdinkes', 'tgl_verifdinkes')
                ->where('id', $idsiplama);

           

            return DB::table('tbl_docs')
                ->select('tbl_docs.*', 's1.c_visitasi', 's1.verifdinkes', 's1.tgl_verifdinkes')
                ->joinsub($s1, 's1', function($join){
                    $join->on('tbl_docs.id_user', 's1.id_nakes')->on('tbl_docs.salinan', 's1.salinan');
                })
                ->where('jenis_doc', 'like', 'REKOMDOKC%')
                ->first();



        } else {

            $this->cekrekomc($idpengajuan,0);

            $s1 = DB::table('tbl_sip')
                ->select('id_nakes', 'salinan','c_visitasi', 'verifdinkes', 'tgl_verifdinkes')
                ->where('id_pengajuan', $idpengajuan);

            return DB::table('tbl_docs')
                ->select('tbl_docs.*', 's1.c_visitasi', 's1.verifdinkes', 's1.tgl_verifdinkes')
                ->joinsub($s1, 's1', function($join){
                    $join->on('tbl_docs.id_user', 's1.id_nakes')->on('tbl_docs.salinan', 's1.salinan');
                })
                ->where('jenis_doc', 'like', 'REKOMDOKC%')
                ->first();

        }
    }

    public function gethistoridokpencabutan($request)
    {
        $idpengajuan = $request->idpengajuan;
        if (Str::contains($idpengajuan, 'M_'))
        {
            //$idsiplama = Str::replace('M_', '', $idpengajuan);
            return DB::table('log_dok_cabut')
                    ->where('id_sip', $idpengajuan)
                    ->orderby('updated_at', 'desc')
                    ->get();

        } else {

            $get = DB::table('tbl_sip')
                ->select('id as id_sip')
                ->where('id_pengajuan', $idpengajuan)
                ->first();

            if($get)
            {
                $id_sip = $get->id_sip;
                $s1 = DB::table('users')
                    ->select('name', 'role', 'id as id_user');
                
                return DB::table('log_dok_cabut')
                    ->select('log_dok_cabut.*', 's1.name', 's1.role')
                    ->leftjoinsub($s1, 's1', function($join){
                        $join->on('log_dok_cabut.updater', 's1.id_user');
                    })
                    ->where('id_sip', $id_sip)
                    ->orderby('updated_at', 'desc')
                    ->get();
            } else {
                return [];
            }

        }

    }

    public function updatedokpencabutan($request, $tgl_doc)
    {
        $nama_doc = $request->tPerihalRekomdok;
        $no_doc = $request->tNoDocumentrekomdok;
        $tgl_doc_ori = $request->tTglRekomdok;
        $id_user = $request->cabutnakes_id;
        $id_pengajuan = $request->cabutIdPengajuan;
        $salinan = $request->cabutSalinan;
        $namafile = $request->cabutfilename;
        $catatan = $request->tCatatanRekom;
        $id_sip = $request->cabutidsip;
        $id_doc = $request->cabutiddok;

        DB::table('tbl_docs')
            ->where('namafile', $namafile)
            ->where('id_user', $id_user)
            ->update([
                'nama_doc' => $nama_doc,
                'no_doc' => $no_doc,
                'tgl_doc' => $tgl_doc,
                'tgl_doc_origin' => $tgl_doc_ori,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return DB::table('log_dok_cabut')
            ->insert([
                'id_doc' => $id_doc,
                'id_sip' => $id_sip,
                'updater' => $id_user,
                'keterangan' => $catatan,
                'updated_at' => date('Y-m-d H:i:s'),
                'filename_rekom' => $namafile
            ]);
        
    }

    public function removerekom($user_id, $salinan, $id_sip)
    {
        return DB::table('tbl_doc')
            ->where('id_user', $user_id)
            ->where('jenis_doc', 'REKOMDOKC'.$salinan)
            ->where('remark1', $id_sip)
            ->delete();
    }

}
