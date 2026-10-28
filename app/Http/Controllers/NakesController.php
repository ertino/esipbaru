<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NakesModel;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Helpers\Help;

class NakesController extends Controller
{
    /** @var NakesModel */
    protected $model;

    /** @var AdminModel */
    protected $model2;

    /** @var Help */
    protected $help;

    public function __construct(){
        $this->model = new NakesModel;
        $this->model2 = new AdminModel;
        $this->help = new Help;
    }

    public function index(){
        //
        return view('welcome');
    
    }

    public function cropthephoto($filename_fotone) {

        $urlget = config('app.cv2_host').'cropthephoto';
        $response = Http::asForm()->post($urlget, ['thename'=>$filename_fotone]);
        if ($response->failed()) {
            return true;
        } else {
            return true;
        }

    }

    public function nakesdashboard(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $isfresh = Auth::user()->freshpass;
        $nama = Auth::user()->name;
        $issiplama = Auth::user()->class_op;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $tglcoba = '2022-01-10 02:01:00';
        $bedanya = $this->help->standardiff($tglcoba);
        $data['id_pengajuan'] = '';
        $data['bedaken'] = $bedanya;
        $data['fotouser'] = $this->model->getdocfoto($id);
        $data['informasis'] = $this->model->getinformation($id);
        $data['profesi'] = $this->model->getprofesi($id, 'prof');
        $data['qr_url'] = $this->model->getprofesi($id, 'url');
        $data['isdokter'] = $this->model->getprofesi($id, 'isdokter');
        $data['isKadaluarsa'] = $this->model->isKadaluarsa($id);
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['pengajuanditolak'] = $this->model->getditolak('pengajuan', $id);
        $data['perpanjanganditolak'] = $this->model->getditolak('perpanjangan', $id);
        $data['perubahanditolak'] = $this->model->getditolak('perubahan', $id);
        $data['sipmanualditolak'] = $this->model->getditolak('sipmanual', $id);
        $data['dokumenissue'] = $this->model->getditolak('dokumen', $id);
        $data['cobaselisih'] = $this->model->cobaselisih('10 Agustus 2026');
        $data['allsalinan'] = $this->model->getdatastrsalinan($id);
        $data['detail_pengaju'] = $this->model->detailpengaju($id);
        $data['freshpass'] = $isfresh;
        $data['issiplama'] = $issiplama;
        $isActive = Auth::user()->isActive;
        if($isActive == '0') {
            return view('nakes/inactive', $data);
        }
        if ($isfresh == 1) {
            return redirect()->route('nakes.profile')->with('alert', '1Silahkan Klik Ubah Password Untuk Mengganti Password Anda!');
        } else {
            return view('nakes/nakesdashboard', $data);
        }
        
        
    }

    public function nakesprofile(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['email'] = Auth::user()->username;
        $data['fotouser'] = $this->model->getdocfoto($id);
        $data['profesi'] = $this->model->getprofesi($id, 'prof');
        $data['detail_pengaju'] = $this->model->detailpengaju($id);
        $data['approvedsip'] = $this->model->approvedsip($id);
        $data['semuajadwal'] = $this->model->semuajadwal($id);

        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['infonakes'] = $this->model->getinfonakes($id);
        

        return view('nakes/nakesprofil', $data);
        
    }

    public function nakesuploadktp($id_nakes) {

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['fotouser'] = $this->model->getdocfoto($id);
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['template_id'] = $this->model->gettemplateid($id);
        $data['detail_pengaju'] = $this->model->detailpengaju($id_nakes);
        $data['isedit'] = 0;
        //$data['wilayah'] = $this->model->getallwilayah();

        return view('nakes/nakesuploadktp', $data);

    }

    public function nakesuploadskskp($id_nakes) {

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['fotouser'] = $this->model->getdocfoto($id);
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['template_id'] = $this->model->gettemplateid($id);
        $data['detail_pengaju'] = $this->model->detailpengaju($id_nakes);
        $data['isedit'] = 0;
        //$data['wilayah'] = $this->model->getallwilayah();

        return view('nakes/nakesuploadskskp', $data);

    }

    public function nakesupdateskskp($id_nakes) {

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['fotouser'] = $this->model->getdocfoto($id);
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['template_id'] = $this->model->gettemplateid($id);
        $data['detail_pengaju'] = $this->model->detailpengaju($id_nakes);
        $data['detailskskp'] = $this->model->detailskskp($id_nakes);
        $data['isedit'] = 1;
        //$data['wilayah'] = $this->model->getallwilayah();

        return view('nakes/nakesuploadskskp', $data);

    }


    public function editdokumenktp($id_nakes) {

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['fotouser'] = $this->model->getdocfoto($id);
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['template_id'] = $this->model->gettemplateid($id);
        $data['isedit'] = 1;
        $data['detail_ktp'] = $this->model->getdetailktp($id_nakes);

        return view('nakes/nakesuploadktp', $data);

    }

    
    public function editdokumennakes($id_request) {

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $splitt = explode('_',$id_request);
        $jenis_doc = $splitt[1];
        $salinan = $splitt[2];
        $template_id = $this->model->gettemplateid($id);
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['fotouser'] = $this->model->getdocfoto($id);
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['salinan'] = $salinan;
        $data['template_id'] = $template_id;
        $data['pencabutan'] = 0;
        
        if($jenis_doc != 'STR') {
            $id_pengajuan = $this->model->getidpengajuan($id, $salinan);
            if($id_pengajuan)
            {
                $data['idpengajuan'] = $id_pengajuan;

                $data['isedit'] = 1;
                $data['detail_dok'] = $this->model->getdetaildok($id, $jenis_doc, $salinan);
    
                return view('nakes/nakeseditdokumen', $data);

            } else {
                return view('nakes/nakesdashboard', $data);
            }
           

        } else {

            $ispindah = $this->model->isPindah($id, $salinan);
            $data['isedit'] = 1;
            if($template_id == '2') {
                $data['current_str'] = $this->model->getcurrentstrdetaildok($id,$salinan);
            } else {
                $data['current_str'] = $this->model->getcurrentstrdetail($id);
            }
            
        
            if($ispindah == '0') {
                return view('nakes/uploadstrnondokter', $data);
            } else {
                return view('nakes/pindah', $data);
            }

        }
        
    }



    public function nakeslanjutperpanjangan($id_nakes) {

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['fotouser'] = $this->model->getdocfoto($id);
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['template_id'] = $this->model->gettemplateid($id);
        $template_id = $this->model->gettemplateid($id);
        $data['listperpanjangan'] = $this->model->listperpanjangan($id, 0, $template_id);
        $data['sementara'] = '0';
        $data['klasifikasi'] = $this->model->klasifikasistr($id);

        return view('nakes/nakeslistperpanjangan', $data);
    }

    public function nakespencabutan($id){

        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;

        $data['fotouser'] = $this->model->getdocfoto($id);
        $data['informasis'] = $this->model->getinformation($id);
        $data['profesi'] = $this->model->getprofesi($id, 'prof');
        $data['qr_url'] = $this->model->getprofesi($id, 'url');
        $data['jenis_profesi'] = $this->model->getprofesi($id, 'jenis_profesi');
        $data['pengajuan'] = $this->model->getallpengajuan($id, 'cabut');
        $data['pengajuanhist'] = $this->model->getallpengajuan($id, 'cabuthist');
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $surathostdraft = config('app.surat_host').'assets/uploads/maker/draft/';
        $surathost = config('app.surat_host').'assets/uploads/maker/approved/';
        $data['surathost'] = $surathost;
        $data['surathostdraft'] = $surathostdraft;
        
        return view('nakes/nakespencabutan', $data);

    }

    
    public function nakesperubahan($id){

        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;

        $data['fotouser'] = $this->model->getdocfoto($id);
        $data['informasis'] = $this->model->getinformation($id);
        $data['profesi'] = $this->model->getprofesi($id, 'prof');
        $data['qr_url'] = $this->model->getprofesi($id, 'url');
        $data['jenis_profesi'] = $this->model->getprofesi($id, 'jenis_profesi');
        $data['pengajuan'] = $this->model->getallpengajuan($id, 'ubah');
        $data['dirubah'] = $this->model->getallpengajuan($id, 'dirubah');

        $data['personal_info'] = $this->model->getpersonalinfo($id);
        return view('nakes/nakesperubahan', $data);

    }

    public function nakesperpanjangan($id) {

        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;

        $data['fotouser'] = $this->model->getdocfoto($id);
        $data['informasis'] = $this->model->getinformation($id);
        $data['profesi'] = $this->model->getprofesi($id, 'prof');
        $data['qr_url'] = $this->model->getprofesi($id, 'url');
        $data['jenis_profesi'] = $this->model->getprofesi($id, 'jenis_profesi');
        $data['current_str'] = $this->model->getcurrentstrdetail($id);
        $template_id = $this->model->getcurrenttemplateid($id);
        $isstrmanual = $this->model->getjenisstr($id);
        
        

        $iskepengajuan = $this->model->pengajuandiperpanjang($id);
        $data['pengajuan'] = $this->model->getallpengajuan($id, 'perpanjangan');
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['semuaprofesi'] = $this->model->getallprofesi();
        $data['klasifikasi'] = $this->model->klasifikasistr($id);
        $klasifikasi = $this->model->klasifikasistr($id);

        if ($template_id == '2') {
            $totalpengajuan = $this->model->gettotalpengajuan($id);
            if($iskepengajuan && ($klasifikasi == '4' || $klasifikasi == '6')) {
                $data['template_id'] = $template_id;
                return redirect()->route('nakes.lanjut.perpanjangan', $id)->with('alert', '1Data Perpanjangan Berhasil Disimpan, Silahkan Lanjutkan Ke Proses Berikutnya');
            } else {
                return view('nakes/updatestr', $data);
            }

            
            
        } else if ($template_id == '3' || $isstrmanual == '1') {

            return view('nakes/updatestr', $data);

        } else {

            if ($iskepengajuan) {
                return redirect()->route('nakes.lanjut.perpanjangan', $id)->with('alert', '1Data Perpanjangan Berhasil Disimpan, Silahkan Lanjutkan Ke Proses Berikutnya');
            } else {
                return view('nakes/updatestr', $data);
    
            }

        }

        
    }

    public function nakesperpanjangansementara($id) {

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['fotouser'] = $this->model->getdocfoto($id);
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['template_id'] = $this->model->gettemplateid($id);
        $template_id = $this->model->gettemplateid($id);
        $data['listperpanjangan'] = $this->model->listperpanjangan($id, 1, $template_id);
        $data['sementara'] = '1';

        return view('nakes/nakeslistperpanjangan', $data);

    }


    public function nakesdocuments(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['fotouser'] = $this->model->getdocfoto($id);

        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['datapendaftaran'] = $this->model->getdatapendaftaran($id);
        
        $data['doc_str'] = $this->model->getdoc($id, 'STR');
        $data['doc_str1'] = $this->model->getdoc($id, 'STR1');
        $data['doc_str2'] = $this->model->getdoc($id, 'STR2');
        $data['doc_str3'] = $this->model->getdoc($id, 'STR3');
        $data['doc_sks'] = $this->model->getdoc($id, 'SKS');
        $data['doc_sptp'] = $this->model->getdoc($id, 'SPTP');
        $data['doc_ijazah'] = $this->model->getdoc($id, 'IJAZAH');
        $data['doc_skp'] = $this->model->getdoc($id, 'SKP');
        $data['doc_foto'] = $this->model->getdoc($id, 'FOTO');
        $data['doc_rekomdk'] = $this->model->getdoc($id, 'REKOMDK');
        $data['doc_rekomp'] = $this->model->getdoc($id, 'REKOMP');
        $data['doc_bav'] = $this->model->getdoc($id, 'BAV');
        $data['doc_ktp'] = $this->model->getdoc($id, 'KTP');
        $data['doc_sub'] = $this->model->getdoc($id, 'stsub');

        $data['doc_skskp'] = $this->model->getdoc($id, 'SKSKP1');

        $data['iscompro1'] = $this->model->getdoccompro($id,'1');
        $data['iscompro2'] = $this->model->getdoccompro($id,'2');
        $data['iscompro3'] = $this->model->getdoccompro($id,'3');

        $data['isKadaluarsa'] = $this->model->isKadaluarsa($id);
        $data['template_id'] = $this->model->istiga($id);
        $data['detail_pengaju'] = $this->model->detailpengaju($id);
        $data['allismanual'] = $this->model->allismanual($id);

        return view('nakes/nakesdocuments', $data);
        
    }

    public function nakespengajuan($gabungan) {

        $pecahan = explode("_",$gabungan);
        $salinanke = $pecahan[1];

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;

        $data['personal_info'] = $this->model->getpersonalinfo($id);
        
        $data['doc_str'] = $this->model->getdoc($id, 'STR');
        $data['doc_str1'] = $this->model->getdoc($id, 'STR1');
        $data['doc_str2'] = $this->model->getdoc($id, 'STR2');
        $data['doc_str3'] = $this->model->getdoc($id, 'STR3');
        $data['doc_sks'] = $this->model->getdoc($id, 'SKS');
        $data['doc_sptp'] = $this->model->getdoc($id, 'SPTP');
        $data['doc_ijazah'] = $this->model->getdoc($id, 'IJAZAH');
        $data['doc_skp'] = $this->model->getdoc($id, 'SKP');
        $data['doc_foto'] = $this->model->getdoc($id, 'FOTO');
        $data['doc_rekomdk'] = $this->model->getdoc($id, 'REKOMDK');
        $data['doc_rekomp'] = $this->model->getdoc($id, 'REKOMP');
        $data['doc_bav'] = $this->model->getdoc($id, 'BAV');
        $data['doc_ktp'] = $this->model->getdoc($id, 'KTP');
        $data['doc_salinan'] = $salinanke;
        $data['pengajuan'] = $this->model->getpengajuan($id);

        return view('nakes/nakespengajuan', $data);

    }

    public function submitdokumen(Request $request){

        if($request->hasFile('tFileDoc')){

            $request->validate([
                'tFileRekomdok' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
            ]); 

            $jenis_doc = $request->tJenisDoc;
            $user_id = $request->tUser_id;

            $tUniv = $request->tUniversitas;
            $tStrata = $request->tStrata;
            $tProdi = $request->tProdi;
            
            $thefile = $request->file('tFileDoc');
            $extension = $request->file('tFileDoc')->extension();
            $filenamenya = $jenis_doc.'_'.$user_id;
            if ($jenis_doc !== 'FOTO') {

                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.pdf');
                $namafile = $filenamenya.'.pdf';

            } else {
                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                $namafile = $filenamenya.'.'.$extension;
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
            }

            

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

                if($jenis_doc == 'IJAZAH') {
                    $this->model->tambahDocIjazah($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, 0, $tUniv, $tStrata, $tProdi);
                } else {
                    $this->model->tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, 0, $jenis_doc);
                }

                
                return redirect()->route('nakes.documents')->with('alert', '1Dokumen Beserta Data Pendukung Berhasil Disimpan');

            }catch(Exception $e) {

                return redirect()->route('nakes.documents')->with('alert', '9Gagal Menyimpan Dokumen Beserta Data Pendukung');

            }
            
            

        } else {

            $jenis_doc = $request->tJenisDoc;
            $user_id = $request->tUser_id;

            $tUniv = $request->tUniversitas;
            $tStrata = $request->tStrata;
            $tProdi = $request->tProdi;
            $isEdit = $request->tEditIjazah;

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

                if($jenis_doc == 'IJAZAH') {
                    if($isEdit == '1') {

                        $this->model->updateDocIjazah($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, 0, $tUniv, $tStrata, $tProdi);

                    } else {

                        $this->model->tambahDocIjazah($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, 0, $tUniv, $tStrata, $tProdi);

                    }
                    
                } else {

                    $this->model->tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, 0, $jenis_doc);
                }

                
                return redirect()->route('nakes.documents')->with('alert', '1Dokumen Beserta Data Pendukung Berhasil Disimpan');

            }catch(Exception $e) {

                return redirect()->route('nakes.documents')->with('alert', '9Gagal Menyimpan Dokumen Beserta Data Pendukung');

            }

        }

    }

    public function nakessubmitktp(Request $request){

        $id_user = $request->tUserKTP;

        if($request->hasFile('tFileNakesKTP')){

            $data['success'] = false;

            
            $thefile = $request->file('tFileNakesKTP');
            $extension = $request->file('tFileNakesKTP')->extension();
            $filenamenya = $request->file('tFileNakesKTP')->getClientOriginalName();

            


            try{

                $namafile = 'KTP_'.$id_user.'.'.$extension;
                $path = Storage::putFileAs('/uploaddoc', $thefile, $namafile);
                $data['ktpfilename'] = $namafile;
                //Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));

                $urlget = config('app.ocr_host').'convertandextract';
                $thefile = fopen('../storage/app/uploaddoc/'.$namafile,'r');
                $response_ = Http::attach('filektp', $thefile, $namafile)->post($urlget, ['thename'=>$namafile, 'extension' => $extension]);
                $response = $response_->json();
                $response_status = $response_->status();
                $data['response_status'] = $response_status;

                if ($response_status == 200) {
                    $data['dataextraction'] = $response;
                    $data['success'] = true;
                }
                
                return response()->json($data);
                //return redirect()->route('daftar.nakes')->with('alert', 'Data berhasil disimpan');

            }catch(Exception $e) {
                //$data['succees'] = false;
                $data['error'] = $e;
                return response()->json($data);

            }
        }

    }

    public function submitpengajuanm(Request $request){

        $data['success'] = false;
        $data['keterangan'] = 'Pengajuan e-SIP Gagal Dilakukan, Silahkan Coba Kembali';

        try{

            if($request->hasFile('tFileRekomP')){

                $request->validate([
                    'tFileRekomP' => 'file|mimes:pdf|max:5120',
                ]); 

                $salinan = $request->tAjuanSalinan;
                $jenis_doc = 'REKOMP'.$salinan;
                $user_id = $request->tUserPengajuan;
                $tgldokrekom = $request->tTglRekomP;
                
                $thefile = $request->file('tFileRekomP');
                $extension = $request->file('tFileRekomP')->extension();
                $filenamenya = $jenis_doc.'_'.$user_id.'_'.$tgldokrekom;
                
                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                $namafile = $filenamenya.'.'.$extension;
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
                
    
                $nama_doc = 'Rekom Profesi '.$salinan;
                $no_doc = $request->tNoRekomP;
                $tgl_doc_ori = $request->tTglRekomP;
                $tgl_berlaku_ori = $request->tTglRekomP;

                if ($tgl_doc_ori != '') {
                    $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
                } else {
                    $tgl_doc = $tgl_doc_ori;
                }

                if ($tgl_berlaku_ori != '') {
                    $tgl_berlaku = $this->help->tgl_indo_sip($tgl_berlaku_ori);
                } else {
                    $tgl_berlaku_ori = $tgl_berlaku;
                }

                $remark1 = 'Rekom Profesi Salinan '.$salinan;
                $this->model->tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, 0, 'rekomprofesi');
    
            }

            if($request->hasFile('tFileSKSKP')){

                $request->validate([
                    'tFileSKSKP' => 'file|mimes:pdf|max:5120',
                ]); 


                $salinan = $request->tAjuanSalinan;
                $jenis_doc = 'SKSKP'.$salinan;
                $user_id = $request->tUserPengajuan;
                $tgldokrekom = $request->tTglSKSKP;
                
                $thefile = $request->file('tFileSKSKP');
                $extension = $request->file('tFileSKSKP')->extension();
                $filenamenya = $jenis_doc.'_'.$user_id.'_'.$tgldokrekom;
                
                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                $namafile = $filenamenya.'.'.$extension;
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
                
    
                $nama_doc = 'File Serkom / SKP '.$salinan;
                $no_doc = $request->tNoSKSKP;
                $tgl_doc_ori = $request->tTglSKSKP;
                $tgl_berlaku_ori = $request->tTglSKSKP;

                if ($tgl_doc_ori != '') {
                    $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
                } else {
                    $tgl_doc = $tgl_doc_ori;
                }

                if ($tgl_berlaku_ori != '') {
                    $tgl_berlaku = $this->help->tgl_indo_sip($tgl_berlaku_ori);
                } else {
                    $tgl_berlaku_ori = $tgl_berlaku;
                }

                $remark1 = 'File Serkom / SKP Salinan '.$salinan;
                $this->model->tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, 0, 'skskp');
    
            }


            if($request->hasFile('tFileSKTP')){

                $request->validate([
                    'tFileSKTP' => 'file|mimes:pdf|max:5120',
                ]); 

                $salinan = $request->tAjuanSalinan;
                $jenis_doc = 'SKTP'.$salinan;
                $user_id = $request->tUserPengajuan;
                $tgldokrekom = $request->tTglSKTP;
                
                $thefile = $request->file('tFileSKTP');
                $extension = $request->file('tFileSKTP')->extension();
                $filenamenya = $jenis_doc.'_'.$user_id.'_'.$tgldokrekom;
                
                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                $namafile = $filenamenya.'.'.$extension;
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
                
    
                $nama_doc = 'File SKTP '.$salinan;
                $no_doc = $request->tNoSKTP;
                $tgl_doc_ori = $request->tTglSKTP;
                $tgl_berlaku_ori = $request->tTglSKTP;

                if ($tgl_doc_ori != '') {
                    $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
                } else {
                    $tgl_doc = $tgl_doc_ori;
                }

                if ($tgl_berlaku_ori != '') {
                    $tgl_berlaku = $this->help->tgl_indo_sip($tgl_berlaku_ori);
                } else {
                    $tgl_berlaku_ori = $tgl_berlaku;
                }

                $remark1 = 'File SKTP Salinan '.$salinan;
                $this->model->tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, 0, 'sktp');
    
            }
            

            if($request->hasFile('tFileSTP')){

                $request->validate([
                    'tFileSTP' => 'file|mimes:pdf|max:5120',
                ]); 

                $salinan = $request->tAjuanSalinan;
                $jenis_doc = 'SPTP'.$salinan;
                $user_id = $request->tUserPengajuan;
                $tglstpnya = $request->tTglSTP;
                
                $thefile = $request->file('tFileSTP');
                $extension = $request->file('tFileSTP')->extension();
                $filenamenya = $jenis_doc.'_'.$user_id.'_'.$tglstpnya;
                
                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                $namafile = $filenamenya.'.'.$extension;
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
                
    
                $nama_doc = 'Surat Pernyataan Tempat Praktik '.$salinan;
                $no_doc = $request->tNoSTP;
                $tgl_doc_ori = $request->tTglSTP;
                $tgl_berlaku_ori = $request->tTglSTP;

                if ($tgl_doc_ori != '') {
                    $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
                } else {
                    $tgl_doc = $tgl_doc_ori;
                }

                if ($tgl_berlaku_ori != '') {
                    $tgl_berlaku = $this->help->tgl_indo_sip($tgl_berlaku_ori);
                } else {
                    $tgl_berlaku_ori = $tgl_berlaku;
                }

                $remark1 = 'Surat Pernyataan Tempat Praktik '.$salinan;
                $this->model->tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, 0, 'STP');
    
            }

            if($request->hasFile('tFileSKP')){

                $request->validate([
                    'tFileSKP' => 'file|mimes:pdf|max:5120',
                ]); 

                $salinan = $request->tAjuanSalinan;
                $jenis_doc = 'SKP'.$salinan;
                $user_id = $request->tUserPengajuan;
                $tglSKP = $request->tTglSKP;
                
                $thefile = $request->file('tFileSKP');
                $extension = $request->file('tFileSKP')->extension();
                $filenamenya = $jenis_doc.'_'.$user_id.'_'.$tglSKP;
                
                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                $namafile = $filenamenya.'.'.$extension;
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
                
    
                $nama_doc = 'Surat Keterangan Pimpinan '.$salinan;
                $no_doc = $request->tNoSKP;
                $tgl_doc_ori = $request->tTglSKP;
                $tgl_berlaku_ori = $request->tTglSKP;

                if ($tgl_doc_ori != '') {
                    $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
                } else {
                    $tgl_doc = $tgl_doc_ori;
                }

                if ($tgl_berlaku_ori != '') {
                    $tgl_berlaku = $this->help->tgl_indo_sip($tgl_berlaku_ori);
                } else {
                    $tgl_berlaku_ori = $tgl_berlaku;
                }

                $remark1 = 'Surat Keterangan Pimpinan '.$salinan;
                $this->model->tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, 0, 'skp');
    
            }

            if($request->hasFile('tFileSKS')){

                $request->validate([
                    'tFileSKS' => 'file|mimes:pdf|max:5120',
                ]); 

                $salinan = $request->tAjuanSalinan;
                $jenis_doc = 'SKS'.$salinan;
                $user_id = $request->tUserPengajuan;
                $tglSKS = $request->tTglSKS;
                
                $thefile = $request->file('tFileSKS');
                $extension = $request->file('tFileSKS')->extension();
                $filenamenya = $jenis_doc.'_'.$user_id.'_'.$tglSKS;
                
                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                $namafile = $filenamenya.'.'.$extension;
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
                
    
                $nama_doc = 'Surat Keterangan Sehat '.$salinan;
                $no_doc = $request->tNoSKS;
                $tgl_doc_ori = $request->tTglSKS;
                $tgl_berlaku_ori = $request->tTglSKS;

                if ($tgl_doc_ori != '') {
                    $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
                } else {
                    $tgl_doc = $tgl_doc_ori;
                }

                if ($tgl_berlaku_ori != '') {
                    $tgl_berlaku = $this->help->tgl_indo_sip($tgl_berlaku_ori);
                } else {
                    $tgl_berlaku_ori = $tgl_berlaku;
                }

                $remark1 = 'Surat Keterangan Sehat '.$salinan;
                $this->model->tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, 0, 'sks');
    
            }

            $this->model->submitpengajuanm($request);
            $this->model->updateDocStat($request);
            $pesanadmin = 'Pengajuan Anda Berhasil Disimpan dan Akan Direview Oleh Dinas Kesehatan Kabupaten Cilacap';
            $this->model->updatePesan('admin', '1', $pesanadmin, $user_id);

            $data['success'] = true;
            $data['keterangan'] = 'Pengajuan Berhasil Diproses Oleh Sistem, Lakukan Pengecheckan Informasi Secara Rutin';
            //return redirect()->route('nakes.dashboard')->with('alert', '1Pengajuan Berhasil Diproses Oleh Sistem, Lakukan Pengecheckan Informasi Secara Rutin');
            return response()->json($data);

        }catch(Exception $e) {

            //return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Memproses Pengajuan, Silahkan Coba Kembali Beberapa Saat');
            $data['keterangan'] = $e;
            $this->model->erropengajuanlog($e, $request);
            return response()->json($data);

        }

    }

    public function submitperubahanm(Request $request){

        try{

            $perubahanakhir = $this->model->submitperubahanm($request);

            if($request->hasFile('tFileRekomP')){

                $salinan = $request->tAjuanSalinan;
                $jenis_doc = 'REKOMP'.$salinan.'_'.$perubahanakhir;
                $user_id = $request->tUserPengajuan;
                $tglrekomperubahan = $request->tTglRekomP;
                
                $thefile = $request->file('tFileRekomP');
                $extension = $request->file('tFileRekomP')->extension();
                $filenamenya = $jenis_doc.'_'.$user_id.'_'.$tglrekomperubahan;
                
                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                $namafile = $filenamenya.'.'.$extension;
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
                
    
                $nama_doc = 'Rekom Profesi '.$salinan.' Perubahan Ke '.$perubahanakhir;
                $no_doc = $request->tNoRekomP;
                $tgl_doc_ori = $request->tTglRekomP;
                $tgl_berlaku_ori = $request->tTglRekomP;

                if ($tgl_doc_ori != '') {
                    $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
                } else {
                    $tgl_doc = $tgl_doc_ori;
                }

                if ($tgl_berlaku_ori != '') {
                    $tgl_berlaku = $this->help->tgl_indo_sip($tgl_berlaku_ori);
                } else {
                    $tgl_berlaku_ori = $tgl_berlaku;
                }

                $remark1 = 'Rekom Profesi Salinan '.$salinan. ' Perubahan Ke '.$perubahanakhir;
                $this->model->tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, $perubahanakhir, 'rekomprofesi');
    
            }

            $this->model->updateDocStat($request);
            return redirect()->route('nakes.dashboard')->with('alert', '1Perubahan Berhasil Disimpan, Silahkan Lakukan Pengecheckan Informasi Secara Rutin');

        }catch(Exception $e) {

            return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Melakukan Perubahan, Silahkan Coba Lagi Beberapa Saat');

        }



    }


    public function getdatastrsalinan(Request $request) {

        $id_user = $request->id_user;

        $data['allsalinan'] = $this->model->getdatastrsalinan($id_user);
        return response()->json($data);
    }


    public function getalasan(Request $request) {
        $data['getalasan'] = $this->model->getalasan();
        return response()->json($data);
    }
    


    public function nakespengajuannew($id_request){

        $newid = explode('_', $id_request);
        $id = $newid[0];
        $salinan = $newid[1];
        $sip_manual = 0;
        if(count($newid) == 3) {
            $sip_manual = $newid[2];
        }
        
        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        //$id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['salinan'] = $salinan;
        $id_doc_str = $this->model->getIdDocStr($id, $salinan);
        $ispindah = $this->model->isPindah($id, $salinan);
        $data['id_doc_str'] = $id_doc_str;
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['doc_str'] = $this->model->getdoc($id, 'STR');
        $data['doc_str1'] = $this->model->getdoc($id, 'STR1');
        $data['doc_str2'] = $this->model->getdoc($id, 'STR2');
        $data['doc_str3'] = $this->model->getdoc($id, 'STR3');
        $data['doc_sks'] = $this->model->getdoc($id, 'SKS');
        $data['doc_sptp'] = $this->model->getdoc($id, 'SKSKP1');
        $data['doc_ijazah'] = $this->model->getdoc($id, 'IJAZAH');
        $data['doc_skp'] = $this->model->getdoc($id, 'SKP');
        $data['doc_foto'] = $this->model->getdoc($id, 'FOTO');
        $data['doc_rekomdk'] = $this->model->getdoc($id, 'REKOMDK');
        $data['doc_rekomp'] = $this->model->getdoc($id, 'REKOMP');
        $data['doc_bav'] = $this->model->getdoc($id, 'BAV');
        $data['doc_ktp'] = $this->model->getdoc($id, 'KTP');
        $data['pengajuan'] = $this->model->getpengajuan($id);
        $data['currentstrdetail'] = $this->model->getdoc($id, 'STR'.$salinan);
        $data['subspesialis'] = $this->model->getsubspesialis($id);
        $data['jenis_form'] = $this->model->getjenisform($id);
        
        $countditolak = $this->model->getditolaksalinan('dokumen', $id, $salinan);
        if ($countditolak == 0) {
            $this->model->createdraftjadwal($id, $salinan, $id_doc_str);
        }
        $data['dokumenissue'] = $countditolak;
        if($ispindah == '0') {
            
            if($sip_manual == 1) {
                $data['isedit'] = 0;
                return view('nakes/nakesuploadsipmanual', $data);
            } else {
                return view('nakes/nakespengajuan2', $data);
            }
            
        } else {
            return view('nakes/pindah', $data);
        }
        
    }

    
    public function nakespengajuanedit($id_request){

        $newid = explode('_', $id_request);
        $id = $newid[0];
        $salinan = $newid[1];
        $id_pengajuan = $newid[2];
        $firstchar = substr($id_pengajuan, 0, 1); // Get the first character
        $id_pengajuanm = substr($id_pengajuan, 1);
        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $id_nakes = $id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $id_doc_str = $this->model->getIdDocStr($id, $salinan);
        $data['id_doc_str'] = $id_doc_str;
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        
        
        $data['salinan'] = $salinan;
        $data['id_nakes'] = $id_nakes;
        $data['doc_str'] = $this->model->getdoc($id_nakes, 'STR');
        $data['doc_stp'] = $this->model->getdoc($id_nakes, 'STP'.$salinan);
        $data['doc_strused'] = $this->model->getdoc($id_nakes, 'STR'.$salinan);
        $data['strbrapa'] = 'STR'.$salinan;
        $data['doc_sks'] = $this->model->getdoc($id_nakes, 'SKS'.$salinan);
        $data['doc_sptp'] = $this->model->getdoc($id_nakes, 'SPTP'.$salinan);
        $data['doc_ijazah'] = $this->model->getdoc($id_nakes, 'IJAZAH');
        $data['doc_skp'] = $this->model->getdoc($id_nakes, 'SKP'.$salinan);
        $data['doc_foto'] = $this->model->getdoc($id_nakes, 'FOTO');
        $data['doc_rekomdk'] = $this->model->getdoc($id_nakes, 'REKOMDK'.$salinan);
        $data['doc_rekomp'] = $this->model->getdoc($id_nakes, 'REKOMP'.$salinan);
        $data['doc_bav'] = $this->model->getdoc($id_nakes, 'BAV'.$salinan);
        $data['doc_ktp'] = $this->model->getdoc($id_nakes, 'KTP');
        $data['detail_pengaju'] = $this->model->detailpengaju($id_nakes);
        $data['infonakes'] = $this->model->getinfonakes($id_nakes);

        if($firstchar == 'M') {

            $data['isedit'] = '1';
            $data['id_pengajuan'] = $id_pengajuanm;
            $data['detail_pengajuan'] = $this->model->getdetailsiplama($id_nakes, $salinan);
            return view('nakes/nakesuploadsipmanual', $data);

        } else {

            $id_pengajuan = $this->model->getidpengajuan($id, $salinan);
            $data['id_pengajuan'] = $id_pengajuan;
            $data['detail_pengajuan'] = $this->model->getdetailpengajuan($id_pengajuan);
            $data['jadwalbefore'] = $this->model2->getlatestjadwal($id_pengajuan);
            $data['jadwalpraktik'] = $this->model2->getjadwalpraktik($id_nakes, $salinan, $id_pengajuan);
            $data['dokumenissue'] = $this->model->getditolaksalinan('dokumen', $id, $salinan);
            return view('pengajuan/detailpengajuanedit2', $data);

        }
    
    }

    public function nakespakaiidlestr($id_request) {

        $newid = explode('_', $id_request);
        $id = $newid[0];
        $salinan = $newid[1];


        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        //$id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['salinan'] = $salinan;

        $updatestatestr = $this->model->updatestatestr($id, $salinan);
        $data['currentstrdetail'] = $this->model->getdoc($id, 'STR'.$salinan);
        if($updatestatestr) {

            $id_doc_str = $this->model->getIdDocStr($id, $salinan);
            $ispindah = $this->model->isPindah($id, $salinan);
            $data['id_doc_str'] = $id_doc_str;
            $data['personal_info'] = $this->model->getpersonalinfo($id);
            $data['doc_str'] = $this->model->getdoc($id, 'STR');
            $data['doc_str1'] = $this->model->getdoc($id, 'STR1');
            $data['doc_str2'] = $this->model->getdoc($id, 'STR2');
            $data['doc_str3'] = $this->model->getdoc($id, 'STR3');
            $data['doc_sks'] = $this->model->getdoc($id, 'SKS');
            $data['doc_sptp'] = $this->model->getdoc($id, 'SPTP');
            $data['doc_ijazah'] = $this->model->getdoc($id, 'IJAZAH');
            $data['doc_skp'] = $this->model->getdoc($id, 'SKP');
            $data['doc_foto'] = $this->model->getdoc($id, 'FOTO');
            $data['doc_rekomdk'] = $this->model->getdoc($id, 'REKOMDK');
            $data['doc_rekomp'] = $this->model->getdoc($id, 'REKOMP');
            $data['doc_bav'] = $this->model->getdoc($id, 'BAV');
            $data['doc_ktp'] = $this->model->getdoc($id, 'KTP');
            $data['pengajuan'] = $this->model->getpengajuan($id);
            $data['jenis_form'] = $this->model->getjenisform($id);
            $this->model->createdraftjadwal($id, $salinan, $id_doc_str);

            if($ispindah == '0') {
                return view('nakes/nakespengajuan2', $data);
            } else {
                return view('nakes/pindah', $data);
            }

        } else {
            return view('nakes/pindah', $data);
        }
        

    }

    public function nakesdokteruploadstr($id_request) {

        $newid = explode('_', $id_request);
        $id = $newid[0];
        $salinan = $newid[1];

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        //$id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['salinan'] = $salinan;
        //$id_doc_str = $this->model->getIdDocStr($id, $salinan);
        if($salinan == 'K') {
            $ispindah = $this->model->isPindah($id, '1');
        } else {
            $ispindah = $this->model->isPindah($id, $salinan);
        }
        
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        //$data['current_str'] = $this->model->currentSTR($id, $salinan);
        $data['current_str'] = $this->model->getcurrentstrdetail($id);
        $ismanual = $this->model->ismanual($id);
        $data['ismanual'] = $ismanual;
        $nosalinan = $this->model->isnosalinan($id, $salinan);
        $data['semuaprofesi'] = $this->model->getallprofesi();
    
        if($ispindah == '0') {

            if($nosalinan != '0') {

                if($salinan == 'K') {
                    $data['allismanual'] = $this->model->allismanual($id);
                    return view('nakes/uploadstrsubdokter', $data);
                } else {
                    $this->model->updatestatestr($id, $salinan);
                    return redirect()->route('nakes.pengajuan.new', $id_request)->with('alert', '1Silahkan Lanjutkan Proses Berikutnya');
                }
                

            } else {

                if($salinan == 'K') {
                    $data['allismanual'] = $this->model->allismanual($id);
                    return view('nakes/uploadstrsubdokter', $data);
                } else {
                    return view('nakes/uploadstrdokter', $data);
                }
            }
            
            
        } else {
            return view('nakes/pindah', $data);
        }

        

    }

    public function nakesnondokteruploadstr($id_request) {

        $newid = explode('_', $id_request);
        $id = $newid[0];
        $salinan = $newid[1];

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        //$id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['salinan'] = $salinan;
        //$id_doc_str = $this->model->getIdDocStr($id, $salinan);
        $ispindah = $this->model->isPindah($id, $salinan);
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        //$data['current_str'] = $this->model->currentSTR($id, $salinan);
        $data['current_str'] = $this->model->getcurrentstrdetail($id);
        $data['isedit'] = 0;
     
        if($ispindah == '0') {
            return view('nakes/uploadstrnondokter', $data);
        } else {
            return view('nakes/pindah', $data);
        }

    }



    public function nakespengajuanperubahan($id_request) {

        $newid = explode('_', $id_request);
        $id = $newid[0];
        $salinan = $newid[1];
        $id_pengajuan = $newid[2];


        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        //$id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['salinan'] = $salinan;
        $id_doc_str = $this->model->getIdDocStr($id, $salinan);
        $ispindah = $this->model->isPindah($id, $salinan);
        $data['id_doc_str'] = $id_doc_str;
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['doc_str'] = $this->model->getdoc($id, 'STR');
        $data['doc_str1'] = $this->model->getdoc($id, 'STR1');
        $data['doc_str2'] = $this->model->getdoc($id, 'STR2');
        $data['doc_str3'] = $this->model->getdoc($id, 'STR3');
        $data['doc_sks'] = $this->model->getdoc($id, 'SKS');
        $data['doc_sptp'] = $this->model->getdoc($id, 'SPTP');
        $data['doc_ijazah'] = $this->model->getdoc($id, 'IJAZAH');
        $data['doc_skp'] = $this->model->getdoc($id, 'SKP');
        $data['doc_foto'] = $this->model->getdoc($id, 'FOTO');
        $data['doc_rekomdk'] = $this->model->getdoc($id, 'REKOMDK');
        $data['doc_rekomp'] = $this->model->getdoc($id, 'REKOMP');
        $data['doc_bav'] = $this->model->getdoc($id, 'BAV');
        $data['doc_ktp'] = $this->model->getdoc($id, 'KTP');
        $data['pengajuan'] = $this->model->getpengajuan($id);
        $data['detail_pengajuan'] = $this->model->getdetailpengajuan($id_pengajuan);
        $data['jadwalpraktik'] = $this->model2->getjadwalpraktik($id, $salinan, $id_pengajuan);
        //$this->model->createdraftjadwal($id, $salinan, $id_doc_str);
        

        if($ispindah == '0') {
            return view('nakes/nakespengajuanperubahan', $data);
        } else {
            return view('nakes/pindah', $data);
        }

    }

    public function submitktpnakes(Request $request) {

            $jenis_doc = 'KTP';
            $user_id = $request->ktpUploader;
            $namafile = $request->ktpFilename;
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

            $tgl_doc = $this->help->tgl_indo_sip($tgl_origin);
            $template_id = $request->ktpTemplateId;
            $jenis_sip = '';

            if ($template_id == '3' || $template_id == '4') {
                $jenis_sip = $this->help->tgl_indo_apoteker($tgl_origin);
            }
           

            try{

                $this->model->tambahDocKTP($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1,$remark2, $remark3, $remark4, $namaktp, $tgl_origin, $template_id, $jenis_sip, $remark5, $remark6, $remark7, $ifdom);
                return redirect()->route('nakes.documents')->with('alert', '1Data KTP Berhasil Disimpan');

            }catch(Exception $e) {

                return redirect()->route('nakes.documents')->with('alert', '9Gagal Memproses Data KTP');

            }

    }


    public function updatektpnakes(Request $request) {

        $jenis_doc = 'KTP';
        $user_id = $request->ktpUploader;
        $namafile = $request->ktpFilename;
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

        $tgl_doc = $this->help->tgl_indo_sip($tgl_origin);
        $template_id = $request->ktpTemplateId;
        $jenis_sip = '';

        if ($template_id == '3' || $template_id == '4') {
            $jenis_sip = $this->help->tgl_indo_apoteker($tgl_origin);
        }
       

        try{

            $this->model->updatedokktp($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1,$remark2, $remark3, $remark4, $namaktp, $tgl_origin, $template_id, $jenis_sip, $remark5, $remark6, $remark7, $ifdom);
            return redirect()->route('nakes.dashboard')->with('alert', '1Data KTP Berhasil Disimpan');

        }catch(Exception $e) {

            return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Memproses Data KTP');

        }

    }


    public function getallfaskes(Request $request){

        $data['allfaskes'] = $this->model->getallfaskes($request);
        return response()->json($data);

    }

    public function getalljadwal(Request $request){
        $data['alljadwal'] = $this->model->getalljadwal($request);
        return response()->json($data);
    }

    public function submitjadwalprakteknakes(Request $request){

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Update Jadwal Nakes';
        $result = $this->model->submitjadwalprakteknakes($request);
        if ($result) {
            $data['success'] = true;
            $data['keterangan'] = 'Sukses Update Jadwal Nakes';
        }

        return response()->json($data);
    }


    public function nakessubmitpencabutan(Request $request) {

        $salinan = $request->cabutSalinan;
        $user_id = $request->cabutnakes_id;
        $id_sip = $request->cabutIdSip;

        //remark1
        

        try{

            if($request->hasFile('tFileRekomdok')){

                $jenis_doc = 'REKOMDOKC'.$salinan;
                $now = date('Y-m-d');
                
                
                $thefile = $request->file('tFileRekomdok');
                $extension = $request->file('tFileRekomdok')->extension();
                $filenamenya = $jenis_doc.'_'.$user_id.'_'.$now;
                
                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                $namafile = $filenamenya.'.'.$extension;
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
                
    
                $nama_doc = $request->tPerihalRekomdok;
                $no_doc = $request->tNoDocumentrekomdok;
                $tgl_doc_ori = $request->tTglRekomdok;
                $tgl_berlaku_ori = date('Y-m-d');

                if ($tgl_doc_ori != '') {
                    $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
                    $hari = $this->help->hariIndo($tgl_doc_ori);
                    $tgl_doc = 'hari '.$hari.' tanggal '.$tgl_doc;
                } else {
                    $tgl_doc = $tgl_doc_ori;
                }

                if ($tgl_berlaku_ori != '') {
                    $tgl_berlaku = $this->help->tgl_indo_sip($tgl_berlaku_ori);
                } else {
                    $tgl_berlaku_ori = $tgl_berlaku;
                }

                $remark1 = $id_sip;
                $this->model->removerekom($user_id, $salinan, $id_sip);
                $this->model->tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, 0, 'rekomdokc');
    
            }

            $this->model->submitpencabutan($request);
            //$this->model->updateDocStat($request);
            return redirect()->route('nakes.dashboard')->with('alert', 'Data berhasil disimpan');

        }catch(Exception $e) {

            return redirect()->route('nakes.dashboard')->with('alert', 'Gagal');

        }

    }

    public function random_string($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
    
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
    
        return $key;
    }



    public function perpanjangansubmitstr(Request $request){


        if($request->hasFile('tFileSTR')){

            $data['success'] = false;
            $data['success_extract'] = false;

            
            $thefile = $request->file('tFileSTR');
            $extension = $request->file('tFileSTR')->extension();
            $filenamenya = $request->file('tFileSTR')->getClientOriginalName();

            
            $encrypted = $this->random_string(25);
            $namafile = $encrypted.'.'.$extension;

            try{

                
                $path = Storage::putFileAs('/perpanjangan', $thefile, $encrypted.'.'.$extension);
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));

                $urlget = config('app.cv2_host').'/convertandextract';
                $extensionpos = '.pdf';

                
                $response_ = Http::asForm()->post($urlget, ['thename'=>$encrypted, 'extension' => $extensionpos, 'jenis'=>'perpanjangan']);
                $response_status = $response_->status();
                $response = $response_->json();

                if ($response_status == 200) {

                    $dcd = json_decode($response_);
                    if (Str::contains($dcd->thelink, 'devcheck')) {

                        $data['success'] = true;
                        $data['keterangan'] = 'Berhasil Extract QRCODE STR';
                        $data['success_extract'] = true;
                        $data['dataextraction'] = $response;

                    } else {

                        $data['dataextraction'] = $response;
                        $data['success'] = true;
                        $data['keterangan'] = 'Berhasil Extract QRCODE STR';
                        $data['filenamestr'] = $encrypted;

                        $urlextractor = config('app.ocr_host').'extractstr';
                        $filestr = fopen('../storage/app/perpanjangan/'.$encrypted.'.png','r');
                        $extractres_ = Http::attach('filestr', $filestr, $encrypted.'.png')->post($urlextractor, ['thename'=>$encrypted, 'extension' => $extensionpos]);
                        $extractres = $extractres_->json();
                        $status_extractor = $extractres_->status();

                        if ($status_extractor == 200) {
                            //$path = Storage::putFileAs('/daftar', $thefile, $encrypted.'.'.$extension);
                            Storage::copy('perpanjangan/'.$encrypted.'.pdf', 'daftar/'.$encrypted.'.pdf');
                            $data['resultword'] = $extractres;
                            $data['success_extract'] = true;
                            $data['filenamestr'] = $encrypted;
                        }
                    }
                    
                } elseif ($response_status == 201) {
                    $data['filenamestr'] = $encrypted;
                    $data['keterangan'] = 'Gagal Extract Data QRCODE dari Penyedia e-STR / Format Informasi Mengalami Perubahan';
                } else {
                    $data['filenamestr'] = $encrypted;
                    $data['keterangan'] = 'Gagal Extract data QRCODE STR';
                }
                //this is try to test the forthe windowos tyr tofiehisihividjifefsjkjfjekjskjdkfjiewoeifwo
                
                return response()->json($data);
                //return redirect()->route('daftar.nakes')->with('alert', 'Data berhasil disimpan');

            }catch(Exception $e) {
                //$data['succees'] = false;
                $data['filenamestr'] = $encrypted;
                $data['error'] = $e;
                return response()->json($data);

            }
            

        }
    }

    public function simpanperpanjanganstr(Request $request){

        $foto = $request->stImg;
        $id_user = $request->stUserIDNakes;
        $origin_file = $request->stWhichF;
        $template_id = $request->stTemplateIDPerpanjangan;
        $id_pengajuan = $request->tIDPengajuanDokter;
        $currentsalinan = $request->stSalinanPerpanjangan;

        try{

            if (strpos($foto, 'data:image/jpeg;base64,') !== false) {
                $image = str_replace('data:image/jpeg;base64,', '', $foto);
                $image = str_replace(' ', '+', $image);
                $imageName = $id_user.'.jpeg';
                \File::put(storage_path('app/fotostr'). '/' . $imageName, base64_decode($image));
                
            } else if (strpos($foto, 'data:image/jpg;base64,') !== false) {
                $image = str_replace('data:image/jpg;base64,', '', $foto);
                $image = str_replace(' ', '+', $image);
                $imageName = $id_user.'.jpeg';
                \File::put(storage_path('app/fotostr'). '/' . $imageName, base64_decode($image));
                
            } else if ($foto == 'devcheck') {

                $imageName = $id_user.'.jpeg';
                $filename_fotone = $imageName;

            } else {
                $contents = file_get_contents($foto);
                $ext = pathinfo(parse_url($foto, PHP_URL_PATH), PATHINFO_EXTENSION);
                $name = 'fotostr/'.$id_user.'.'.$ext;
                $filename_fotone = $id_user.'.'.$ext;
                $imageName = $filename_fotone;
                Storage::put($name, $contents);
                
            }
            $sourcePath = 'perpanjangan/' . $origin_file . '.pdf';
            $destinationPath = 'daftar/' . $origin_file . '.pdf';
            if (Storage::exists($sourcePath)) {
                Storage::put($destinationPath, Storage::get($sourcePath));
            }

            //Storage::copy('perpanjangan/'.$origin_file.'.pdf', 'daftar/'.$origin_file.'.pdf');
            $this->model->simpanperpanjanganstr($request);
            $this->cropthephoto($imageName);
            if ($template_id == '2') {
                $totalpengajuan = $this->model->gettotalpengajuan($id_user);
                if($totalpengajuan > 0) {
                    $id_requestperpanjangan = $id_user.'_'.$currentsalinan.'_'.$id_pengajuan.'_0';
                    return redirect()->route('nakes.perpanjangan.pengajuan', $id_requestperpanjangan)->with('alert', '1Perubahan Berhasil Disimpan, Silahkan Lakukan Pengecheckan Informasi Secara Rutin');
                } else {
                    return redirect()->route('nakes.dashboard')->with('alert', '1Pembaharuan STR Berhasil');
                }
                

            } else {
                return redirect()->route('nakes.lanjut.perpanjangan', $id_user)->with('alert', '1Data berhasil disimpan');
            }
            
            

        }catch(Exception $e) {

            return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Melakukan Perubahan, Silahkan Coba Beberapa Saat Lagi');

        }

    }

    public function nakesperpanjanganpengajuan($id_request) {

        $newid = explode('_', $id_request);
        $id = $newid[0];
        $salinan = $newid[1];
        $id_pengajuan = $newid[2];
        $isSementara = $newid[3];
        if (is_numeric($salinan) == false) {
            $geting = $this->model->getlastpengajuan($id);
            $salinan = $geting->salinan;
            $id_pengajuan = $geting->id;
        }
        
        


        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        //$id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['salinan'] = $salinan;
        $id_doc_str = $this->model->getIdDocStr($id, $salinan);
        $ispindah = $this->model->isPindah($id, $salinan);
        $data['id_doc_str'] = $id_doc_str;
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['doc_str'] = $this->model->getdoc($id, 'STR');
        $data['doc_str1'] = $this->model->getdoc($id, 'STR1');
        $data['doc_str2'] = $this->model->getdoc($id, 'STR2');
        $data['doc_str3'] = $this->model->getdoc($id, 'STR3');
        $data['doc_sks'] = $this->model->getdoc($id, 'SKS');
        $data['doc_sptp'] = $this->model->getdoc($id, 'SPTP');
        $data['doc_ijazah'] = $this->model->getdoc($id, 'IJAZAH');
        $data['doc_skp'] = $this->model->getdoc($id, 'SKP');
        $data['doc_foto'] = $this->model->getdoc($id, 'FOTO');
        $data['doc_rekomdk'] = $this->model->getdoc($id, 'REKOMDK');
        $data['doc_rekomp'] = $this->model->getdoc($id, 'REKOMP');
        $data['doc_bav'] = $this->model->getdoc($id, 'BAV');
        $data['doc_ktp'] = $this->model->getdoc($id, 'KTP');
        $data['pengajuan'] = $this->model->getpengajuan($id);
        $data['detail_pengajuan'] = $this->model->getdetailpengajuan($id_pengajuan);
        
        $data['jadwalpraktik'] = $this->model2->getjadwalpraktik($id, $salinan, $id_pengajuan);
        $data['ismanual'] = $this->model->getstatusqr($id, $salinan);
        
        $data['jadwalpraktikexisting'] = $this->model2->getjadwalpraktik($id, $salinan, $id_pengajuan);
        if($isSementara == '1') {
            $data['isSementara'] = $isSementara;
        } else {
            $data['isSementara'] = 0;
        }
        //$this->model->createdraftjadwal($id, $salinan, $id_doc_str);
        if($ispindah == '0') {
            return view('nakes/nakespengajuanperpanjangan', $data);
        } else {
            return view('nakes/pindah', $data);
        }

    }


    public function nakesperpanjanganpengajuandokter($id_request) {

        $newid = explode('_', $id_request);
        $id = $newid[0];
        $salinan = $newid[1];
        $id_pengajuan = $newid[2];
        //$isSementara = $newid[3];


        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        //$id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['salinan'] = $salinan;
        $data['isBaru'] = 0; 

        $data['fotouser'] = $this->model->getdocfoto($id);
        $data['informasis'] = $this->model->getinformation($id);
        $data['profesi'] = $this->model->getprofesi($id, 'prof');
        $data['qr_url'] = $this->model->getprofesi($id, 'url');
        $data['jenis_profesi'] = $this->model->getprofesi($id, 'jenis_profesi');
        $data['current_str'] = $this->model->getcurrentstrdetail($id);
        $template_id = $this->model->getcurrenttemplateid($id);
        $data['currentidpengajuan'] = $id_pengajuan;
        $data['semuaprofesi'] = $this->model->getallprofesi();
        
        $iskepengajuan = $this->model->pengajuandiperpanjang($id);
        $data['pengajuan'] = $this->model->getallpengajuan($id, 'perpanjangan');
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['idrequest'] = $id_request;

        return view('nakes/updatestrdokter', $data);

    }


    public function submitpengajuanperpanjangan(Request $request) {

        $tgl_doc_rekom = $request->tTglRekomP;
        $tgl_doc_sks = $request->tTglSKS;
        $isSementara = $request->tIsSementara;

        if ($isSementara == '1') {

            try{

                $perubahanakhir = $this->model->submitperubahanm($request);
    
                if($request->hasFile('tFileRekomP')){
    
                    $salinan = $request->tAjuanSalinan;
                    $jenis_doc = 'REKOMP'.$salinan;
                    $user_id = $request->tUserPengajuan;
                    
                    $thefile = $request->file('tFileRekomP');
                    $extension = $request->file('tFileRekomP')->extension();
                    $filenamenya = $jenis_doc.'_'.$user_id.'_'.$tgl_doc_rekom;
                    
                    $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                    $namafile = $filenamenya.'.'.$extension;
                    Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
                    
        
                    $nama_doc = 'Rekom Profesi '.$salinan.' Periode '.$tgl_doc_rekom. ' Perpanjangan Sementara';
                    $no_doc = $request->tNoRekomP;
                    $tgl_doc_ori = $request->tTglRekomP;
                    $tgl_berlaku_ori = $request->tTglRekomP;
    
                    if ($tgl_doc_ori != '') {
                        $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
                    } else {
                        $tgl_doc = $tgl_doc_ori;
                    }
    
                    if ($tgl_berlaku_ori != '') {
                        $tgl_berlaku = $this->help->tgl_indo_sip($tgl_berlaku_ori);
                    } else {
                        $tgl_berlaku_ori = $tgl_berlaku;
                    }
    
                    $remark1 = $nama_doc;
                    $this->model->updateDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, $perubahanakhir);
        
                }
    
    
                if($request->hasFile('tFileSKSKP')){
    
                    $salinan = $request->tAjuanSalinan;
                    $jenis_doc = 'SKSKP'.$salinan;
                    $user_id = $request->tUserPengajuan;
                    
                    $thefile = $request->file('tFileSKSKP');
                    $extension = $request->file('tFileSKSKP')->extension();
                    $filenamenya = $jenis_doc.'_'.$user_id.'_'.$tgl_doc_sks;
                    
                    $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                    $namafile = $filenamenya.'.'.$extension;
                    Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
                    
        
                    $nama_doc = 'Surat Serkom / SKP '.$salinan.' Periode '.$tgl_doc_rekom;
                    $no_doc = $request->tNoSKS;
                    $tgl_doc_ori = $request->tTglSKSKP;
                    $tgl_berlaku_ori = $request->tTglSKSKP;
    
                    if ($tgl_doc_ori != '') {
                        $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
                    } else {
                        $tgl_doc = $tgl_doc_ori;
                    }
    
                    if ($tgl_berlaku_ori != '') {
                        $tgl_berlaku = $this->help->tgl_indo_sip($tgl_berlaku_ori);
                    } else {
                        $tgl_berlaku_ori = $tgl_berlaku;
                    }
    
                    $remark1 = 'Surat Serkom / SKP '.$salinan. ' Perubahan Ke '.$perubahanakhir;
                    $this->model->updateDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, $perubahanakhir);
        
                }
                $this->model->submitperpanjangannakes($request);
                $this->model->updateDocStat($request);
                return redirect()->route('nakes.dashboard')->with('alert', '1Perpanjangan Berhasil Diajukan,, Silahkan Lakukan Pengecheckan Informasi Secara Rutin');
    
            }catch(Exception $e) {
    
                return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Mengajukan Perpanjangan, Silahkan Coba Beberapa Saat Lagi');
    
            }

        } else {

            try{

                $perubahanakhir = $this->model->submitperubahanm($request);
    
                if($request->hasFile('tFileRekomP')){
    
                    $salinan = $request->tAjuanSalinan;
                    $jenis_doc = 'REKOMP'.$salinan;
                    $user_id = $request->tUserPengajuan;
                    
                    $thefile = $request->file('tFileRekomP');
                    $extension = $request->file('tFileRekomP')->extension();
                    $filenamenya = $jenis_doc.'_'.$user_id.'_'.$tgl_doc_rekom;
                    
                    $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                    $namafile = $filenamenya.'.'.$extension;
                    Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
                    
        
                    $nama_doc = 'Rekom Profesi '.$salinan.' Periode '.$tgl_doc_rekom;
                    $no_doc = $request->tNoRekomP;
                    $tgl_doc_ori = $request->tTglRekomP;
                    $tgl_berlaku_ori = $request->tTglRekomP;
    
                    if ($tgl_doc_ori != '') {
                        $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
                    } else {
                        $tgl_doc = $tgl_doc_ori;
                    }
    
                    if ($tgl_berlaku_ori != '') {
                        $tgl_berlaku = $this->help->tgl_indo_sip($tgl_berlaku_ori);
                    } else {
                        $tgl_berlaku_ori = $tgl_berlaku;
                    }
    
                    $remark1 = 'Rekom Profesi Salinan '.$salinan. ' Perubahan Ke '.$perubahanakhir;
                    $this->model->updateDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, '0');
        
                }
    
    
                if($request->hasFile('tFileSKS')){
    
                    $salinan = $request->tAjuanSalinan;
                    $jenis_doc = 'SKS'.$salinan;
                    $user_id = $request->tUserPengajuan;
                    
                    $thefile = $request->file('tFileSKS');
                    $extension = $request->file('tFileSKS')->extension();
                    $filenamenya = $jenis_doc.'_'.$user_id.'_'.$tgl_doc_sks;
                    
                    $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                    $namafile = $filenamenya.'.'.$extension;
                    Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
                    
        
                    $nama_doc = 'Surat Keterangan Sehat Salinan '.$salinan.' Periode '.$tgl_doc_rekom;
                    $no_doc = $request->tNoSKS;
                    $tgl_doc_ori = $request->tTglSKS;
                    $tgl_berlaku_ori = $request->tTglSKS;
    
                    if ($tgl_doc_ori != '') {
                        $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
                    } else {
                        $tgl_doc = $tgl_doc_ori;
                    }
    
                    if ($tgl_berlaku_ori != '') {
                        $tgl_berlaku = $this->help->tgl_indo_sip($tgl_berlaku_ori);
                    } else {
                        $tgl_berlaku_ori = $tgl_berlaku;
                    }
    
                    $remark1 = 'Rekom Profesi Salinan '.$salinan. ' Perubahan Ke '.$perubahanakhir;
                    $this->model->updateDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, '0');
        
                }
                $this->model->submitperpanjangannakes($request);
                $this->model->updateDocStat($request);
                return redirect()->route('nakes.dashboard')->with('alert', '1Perpanjangan Berhasil Diajukan,, Silahkan Lakukan Pengecheckan Informasi Secara Rutin');
    
            }catch(Exception $e) {
    
                return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Mengajukan Perpanjangan, Silahkan Coba Beberapa Saat Lagi');
    
            }

        }
    }


    
    public function doktersubmitstr(Request $request){


        if($request->hasFile('tFileSTRDok')){

            $data['success'] = false;
            $data['success_extract'] = false;

            
            $thefile = $request->file('tFileSTRDok');
            $extension = $request->file('tFileSTRDok')->extension();
            $filenamenya = $request->file('tFileSTRDok')->getClientOriginalName();

            $encrypted = $this->random_string(25);
            $namafile = $encrypted.'.'.$extension;
            try{

                
                $path = Storage::putFileAs('/daftar', $thefile, $encrypted.'.'.$extension);
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));

                $urlget = config('app.cv2_host').'convertandextract';
                $extensionpos = '.pdf';

                
                $response_ = Http::asForm()->post($urlget, ['thename'=>$encrypted, 'extension' => $extensionpos]);
                $response_status = $response_->status();
                $response = $response_->json();

                if ($response_status == 200) {

                    $data['dataextraction'] = $response;
                    $data['success'] = true;
                    $data['keterangan'] = 'Berhasil Extract QRCODE STR';

                    $urlextractor = config('app.ocr_host').'extractstr';
                    $filestr = fopen('../storage/app/daftar/'.$encrypted.'.png','r');
                    $extractres_ = Http::attach('filestr', $filestr, $encrypted.'.png')->post($urlextractor, ['thename'=>$encrypted, 'extension' => $extensionpos]);
                    $extractres = $extractres_->json();
                    $status_extractor = $extractres_->status();

                    if ($status_extractor == 200) {
                        $data['resultword'] = $extractres;
                        $data['success_extract'] = true;
                    }
                    
                } elseif ($response_status == 201) {
                    $data['filenamestr'] = $encrypted;
                    $data['keterangan'] = 'Gagal Extract Data QRCODE dari Penyedia e-STR / Format Informasi Mengalami Perubahan';
                } else {
                    $data['filenamestr'] = $encrypted;
                    $data['keterangan'] = 'Gagal Extract data QRCODE STR';
                }
                //this is try to test the forthe windowos tyr tofiehisihividjifefsjkjfjekjskjdkfjiewoeifwo
                
                return response()->json($data);
                //return redirect()->route('daftar.nakes')->with('alert', 'Data berhasil disimpan');

            }catch(Exception $e) {
                //$data['succees'] = false;
                $data['filenamestr'] = $encrypted;
                $data['error'] = $e;
                return response()->json($data);

            }
            

        }
    }


    public function doktersubmitstrmanual(Request $request){


        if($request->hasFile('tFileSTRDok')){

            $data['success'] = false;
            $data['success_extract'] = false;

            
            $thefile = $request->file('tFileSTRDok');
            $extension = $request->file('tFileSTRDok')->extension();
            $filenamenya = $request->file('tFileSTRDok')->getClientOriginalName();

            $issub = $request->tIsSub;

    
            try{

                $encrypted = $this->random_string(25);
                $namafile = $encrypted.'.'.$extension;
                
                $path = Storage::putFileAs('/daftar', $thefile, $encrypted.'.'.$extension);
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));

                $urlget = config('app.cv2_host').'convertandextract';
                $extensionpos = '.pdf';

                $data['namafile'] = $encrypted;
                
                $response_ = Http::asForm()->post($urlget, ['thename'=>$encrypted, 'extension' => $extensionpos]);
                $response_status = $response_->status();
                $response = $response_->json();

                if ($response_status == 200 || $response_status == 500) {

                    $data['dataextraction'] = $response;
                    $data['success'] = true;
                    $data['keterangan'] = 'Berhasil Extract QRCODE STR';

                    $urlextractor = config('app.ocr_host').'extractstrmanual';
                    $filestr = fopen('../storage/app/daftar/'.$encrypted.'.png','r');
                    $extractres_ = Http::attach('filestr', $filestr, $encrypted.'.png')->post($urlextractor, ['thename'=>$encrypted, 'extension' => $extensionpos]);
                    $extractres = $extractres_->json();
                    $status_extractor = $extractres_->status();

                    if ($status_extractor == 200) {
                        $data['resultword'] = $extractres;
                        $data['success_extract'] = true;
                    }
                    
                } elseif ($response_status == 201) {
                    $data['keterangan'] = 'Gagal Extract Data QRCODE dari Penyedia e-STR / Format Informasi Mengalami Perubahan';
                } else {
                    $data['keterangan'] = 'Gagal Extract data QRCODE STR';
                }
                //this is try to test the forthe windowos tyr tofiehisihividjifefsjkjfjekjskjdkfjiewoeifwo
                
                return response()->json($data);
                //return redirect()->route('daftar.nakes')->with('alert', 'Data berhasil disimpan');

            }catch(Exception $e) {
                //$data['succees'] = false;
                $data['error'] = $e;
                return response()->json($data);

            }
            

        }
    }


    public function nondoktersubmitstr(Request $request){


        if($request->hasFile('tFileSTRnonDok')){

            $data['success'] = false;
            $data['success_extract'] = false;

            
            $thefile = $request->file('tFileSTRnonDok');
            $extension = $request->file('tFileSTRnonDok')->extension();
            $filenamenya = $request->file('tFileSTRnonDok')->getClientOriginalName();

    
            try{

                $encrypted = $this->random_string(25);
                $namafile = $encrypted.'.'.$extension;
                $path = Storage::putFileAs('/daftar', $thefile, $encrypted.'.'.$extension);
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));

                $urlget = config('app.cv2_host').'convertandextract';
                $extensionpos = '.pdf';

                
                $response_ = Http::asForm()->post($urlget, ['thename'=>$encrypted, 'extension' => $extensionpos]);
                $response_status = $response_->status();
                $response = $response_->json();

                if ($response_status == 200) {

                    $data['dataextraction'] = $response;
                    $data['success'] = true;
                    $data['keterangan'] = 'Berhasil Extract QRCODE STR';

                    $urlextractor = config('app.ocr_host').'extractstr';
                    $filestr = fopen('../storage/app/daftar/'.$encrypted.'.png','r');
                    $extractres_ = Http::attach('filestr', $filestr, $encrypted.'.png')->post($urlextractor, ['thename'=>$encrypted, 'extension' => $extensionpos]);
                    $extractres = $extractres_->json();
                    $status_extractor = $extractres_->status();

                    if ($status_extractor == 200) {
                        $data['resultword'] = $extractres;
                        $data['success_extract'] = true;
                    }
                    
                } elseif ($response_status == 201) {
                    $data['keterangan'] = 'Gagal Extract Data QRCODE dari Penyedia e-STR / Format Informasi Mengalami Perubahan';
                } else {
                    $data['keterangan'] = 'Gagal Extract data QRCODE STR';
                }
                //this is try to test the forthe windowos tyr tofiehisihividjifefsjkjfjekjskjdkfjiewoeifwo
                
                return response()->json($data);
                //return redirect()->route('daftar.nakes')->with('alert', 'Data berhasil disimpan');

            }catch(Exception $e) {
                //$data['succees'] = false;
                $data['error'] = $e;
                return response()->json($data);

            }
            

        }
    }


    public function nondokterupdatestr(Request $request){


        if($request->hasFile('tFileSTRnonDok')){

            $data['success'] = false;
            $data['success_extract'] = false;

            $request->validate([
                'tFileSTRnonDok' => 'file|mimes:pdf|max:5120',
            ]);  

            
            $thefile = $request->file('tFileSTRnonDok');
            $extension = $request->file('tFileSTRnonDok')->extension();
            $filenamenya = $request->file('tFileSTRnonDok')->getClientOriginalName();
            $encrypted = $this->random_string(25);
            $namafile = $encrypted.'.'.$extension;
    
            try{

                
                $path = Storage::putFileAs('/daftar', $thefile, $encrypted.'.'.$extension);
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));

                $urlget = config('app.cv2_host').'convertandextract';
                $extensionpos = '.pdf';

                
                $response_ = Http::asForm()->post($urlget, ['thename'=>$encrypted, 'extension' => $extensionpos]);
                $response_status = $response_->status();
                $response = $response_->json();

                if ($response_status == 200) {

                    $data['dataextraction'] = $response;
                    $data['success'] = true;
                    $data['keterangan'] = 'Berhasil Extract QRCODE STR';

                    $urlextractor = config('app.ocr_host').'extractstr';
                    $filestr = fopen('../storage/app/daftar/'.$encrypted.'.png','r');
                    $extractres_ = Http::attach('filestr', $filestr, $encrypted.'.png')->post($urlextractor, ['thename'=>$encrypted, 'extension' => $extensionpos]);
                    $extractres = $extractres_->json();
                    $status_extractor = $extractres_->status();

                    if ($status_extractor == 200) {
                        $data['resultword'] = $extractres;
                        $data['success_extract'] = true;
                        $data['newfilename'] = $encrypted;
                    }
                    
                } elseif ($response_status == 201) {
                    $data['filenamestr'] = $encrypted;
                    $data['keterangan'] = 'Gagal Extract Data QRCODE dari Penyedia e-STR / Format Informasi Mengalami Perubahan';
                } else {
                    $data['filenamestr'] = $encrypted;
                    $data['keterangan'] = 'Gagal Extract data QRCODE STR';
                }
                //this is try to test the forthe windowos tyr tofiehisihividjifefsjkjfjekjskjdkfjiewoeifwo
                
                return response()->json($data);
                //return redirect()->route('daftar.nakes')->with('alert', 'Data berhasil disimpan');

            }catch(Exception $e) {
                //$data['succees'] = false;
                $data['error'] = $e;
                $data['filenamestr'] = $encrypted;
                return response()->json($data);

            }
            

        }
    }


    public function simpanstrdokter(Request $request) {

        $id_nakes = $request->stUserIDNakesDok;
        $salinan = $request->stSalinanDok;
        $id_request = $id_nakes.'_'.$salinan;


        try{

            
            $result = $this->model->simpanstrdokter($request);
            if ($result) {
                return redirect()->route('nakes.pengajuan.new', $id_request)->with('alert', '1Berhasil Menyimpan STR, Silahkan Lanjutkan Proses Berikutnya');
            } else {
                return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Memproses STR, Silahkan Coba Beberapa Saat Lagi');
            }
            

        }catch(Exception $e) {

            return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Memproses STR, Silahkan Coba Beberapa Saat Lagi');

        }

    }

    public function simpansubstrdokter(Request $request) {

        try{
  
            $result = $this->model->simpanstrsubdokter($request);
            if ($result) {
                return redirect()->route('nakes.documents')->with('alert', '1Berhasil Menyimpan STR, Silahkan Lanjutkan Proses Berikutnya');
            } else {
                return redirect()->route('nakes.documents')->with('alert', '9Gagal Memproses STR Subspesialis, Silahkan Coba Beberapa Saat Lagi');
            }
            

        }catch(Exception $e) {

            return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Memproses STR Subspesialis, Silahkan Coba Beberapa Saat Lagi');

        }

    }


    public function simpanstrnondokter(Request $request) {

        $id_nakes = $request->stUserIDNakesnonDok;
        $salinan = $request->stSalinannonDok;
        $id_request = $id_nakes.'_'.$salinan;


        try{

            
            $result = $this->model->simpanstrnondokter($request);
            if ($result) {
                return redirect()->route('nakes.pengajuan.new', $id_request)->with('alert', '1Berhasil Menyimpan STR, Silahkan Lanjutkan Proses Berikutnya');
            } else {
                return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Memproses STR, Silahkan Coba Beberapa Saat Lagi');
            }
            

        }catch(Exception $e) {

            return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Memproses STR, Silahkan Coba Beberapa Saat Lagi');

        }

    }

    public function simpanupdatestrnondokter(Request $request) {

        $id_nakes = $request->stUserIDNakesnonDok;
        $salinan = $request->stSalinannonDok;
        $id_request = $id_nakes.'_'.$salinan;
        $newfilename = $request->stNewFilename;


        try{

            
            $result = $this->model->simpanupdatestrnondokter($request);
            if ($result) {
                return redirect()->route('nakes.dashboard', $id_request)->with('alert', '1Berhasil Menyimpan STR, Silahkan Lanjutkan Proses Berikutnya');
            } else {
                return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Memproses STR, Silahkan Coba Beberapa Saat Lagi');
            }
            

        }catch(Exception $e) {

            return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Memproses STR, Silahkan Coba Beberapa Saat Lagi');

        }

    }


    public function nakesdetailpengajuan($gabungan) {
        $pecahan = explode("_",$gabungan);
        $salinan = $pecahan[1];
        

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $id_nakes = $id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;

        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['salinan'] = $salinan;
        $data['id_nakes'] = $id_nakes;
        
        $data['doc_stp'] = $this->model->getdoc($id_nakes, 'STP'.$salinan);
        $data['doc_strused'] = $this->model->getdoc($id_nakes, 'STR'.$salinan);
        $data['strbrapa'] = 'STR'.$salinan;
        $data['doc_sks'] = $this->model->getdoc($id_nakes, 'SKS'.$salinan);
        $data['doc_sptp'] = $this->model->getdoc($id_nakes, 'SPTP'.$salinan);
        $data['doc_ijazah'] = $this->model->getdoc($id_nakes, 'IJAZAH');
        $data['doc_skp'] = $this->model->getdoc($id_nakes, 'SKP'.$salinan);
        $data['doc_foto'] = $this->model->getdoc($id_nakes, 'FOTO');
        $data['doc_rekomdk'] = $this->model->getdoc($id_nakes, 'REKOMDK'.$salinan);
        $data['doc_rekomp'] = $this->model->getdoc($id_nakes, 'REKOMP'.$salinan);
        $data['doc_bav'] = $this->model->getdoc($id_nakes, 'BAV'.$salinan);
        $data['doc_ktp'] = $this->model->getdoc($id_nakes, 'KTP');
        $data['doc_c'] = $this->model->getdoc($id_nakes, 'REKOMDOKC'.$salinan);
        $data['doc_skskp'] = $this->model->getdoc($id_nakes, 'SKSKP'.$salinan);
        $data['doc_sktp'] = $this->model->getdoc($id_nakes, 'SKTP'.$salinan);
        $data['detail_pengaju'] = $this->model->detailpengaju($id_nakes);
        $data['infonakes'] = $this->model->getinfonakes($id_nakes);
        $data['surat_host'] = config('app.surat_host');
        $data['subspesialis'] = $this->model->getsubspesialis($id_nakes);
        $data['doc_sub'] = $this->model->getdoc($id_nakes, 'stsub');

        $sip_manual = $this->model->checksipmanual($id_nakes, $salinan);

        if($sip_manual) {

            $data['detail_pengajuan'] = $this->model->getdetailsiplama($id_nakes, $salinan);
            $data['id_user'] = $id_nakes;
            return view('pengajuan/detailpengajuansiplama', $data);
            

        } else {
            $id_pengajuan = $this->model->getidpengajuan($id, $salinan);
            $statussip = $this->model->checkstatussip($id_pengajuan, $id, $salinan);
            if($statussip != 0) {

                $filename_sip = $statussip;
                $lateststatus = config('app.surat_host').'CsubmitRekomNakes/lateststatussip';
                $datapost = [
                    'filename_sip' => $filename_sip
                ];
                $response_esiptte = Http::asForm()->post($lateststatus, $datapost);
                $esiptte_status = $response_esiptte->status();
                if ($esiptte_status == 200) {
                    $esiptte = $response_esiptte->json();
                    $statusdokumen = $esiptte[0]['statusdokumen'];
                    $statusesip = $esiptte[0]['statusesip'];
                    $signed_date = $esiptte[0]['signed_date'];
                    $no_surat = $esiptte[0]['no_surat'];
                    $detailjadwal = $esiptte[0]['detailjadwal'];
                    if($statusdokumen == '1') {
                        $result = $this->model2->updatestatussip($id_pengajuan, $filename_sip, $detailjadwal, $no_surat, $signed_date);
                    }
                }

            }

            $data['id_pengajuan'] = $id_pengajuan;
            $data['jadwalpraktik'] = $this->model2->getjadwalpraktik($id_nakes, $salinan, $id_pengajuan);
            $data['detail_pengajuan'] = $this->model->getdetailpengajuan($id_pengajuan);
            $data['jadwalbefore'] = $this->model2->getlatestjadwal($id_pengajuan);
            $data['checkfix'] = $this->model->checkfixed($id_pengajuan);
            $data['pilihfixed'] = $this->model->pilihfixed($id_pengajuan);
            $data['doc_rekdin'] = $this->model->getdoc($id_nakes, 'rekdin'.$salinan);
            $data['doc_sipb'] = $this->model->getdoc($id_nakes, 'SIPB'.$salinan);

            return view('pengajuan/detailpengajuan', $data);

        }
        

        
        //check latest status asoka
        
        
    }


    public function submitpersonalinfonakes(Request $request) {

        try{            
            $result = $this->model->submitpersonalinfonakes($request);
            if ($result) {
                return redirect()->route('nakes.profile')->with('alert', '1Sukses Update Profile Nakes');
            } else {
                return redirect()->route('nakes.profile')->with('alert', '9Gagal Menyimpan Data Profile Nakes');
            }
            
        }catch(Exception $e) {

            return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Menyimpan Data Profile Nakes');

        }

    }

    
    public function simpanrekomprofesi(Request $request) {

        try{            
            if($request->hasFile('recFileRekom')){

                $request->validate([
                    'recFileRekom' => 'file|mimes:pdf|max:5120',
                ]);  
    
                
                $id_pengajuan = $request->recIdPengajuan;
                $getdetail = $this->model->getdetailpeng($id_pengajuan);

                $salinan = $getdetail->salinan;
                $jenis_doc = 'REKOMP'.$salinan;
                $user_id = $getdetail->id_user;
                $tgldokrekom = $request->recTglDok;
                
                $thefile = $request->file('recFileRekom');
                $extension = $request->file('recFileRekom')->extension();
                $filenamenya = $jenis_doc.'_'.$user_id.'_'.$tgldokrekom;
                
                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                $namafile = $filenamenya.'.'.$extension;
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
                
    
                $nama_doc = 'Rekom Profesi '.$salinan;
                $no_doc = $request->recNoDok;
                $tgl_doc_ori = $request->recTglDok;
                $tgl_berlaku_ori = $request->recTglDok;

                if ($tgl_doc_ori != '') {
                    $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
                } else {
                    $tgl_doc = $tgl_doc_ori;
                }

                if ($tgl_berlaku_ori != '') {
                    $tgl_berlaku = $this->help->tgl_indo_sip($tgl_berlaku_ori);
                } else {
                    $tgl_berlaku_ori = $tgl_berlaku;
                }

                $remark1 = 'Rekom Profesi Salinan '.$salinan;
                $this->model->tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, 0, 'rekomprofesi');

                $result = $this->model->updateafterop($id_pengajuan);
    
            }

            if ($result) {
                return redirect()->route('nakes.dashboard')->with('alert', '1Sukses Upload Rekomendasi Organisasi Profesi');
            } else {
                return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Upload Rekomendasi Organisasi Profesi');
            }
            
        }catch(Exception $e) {

            return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Upload Rekomendasi Organisasi Profesi');

        }

    }

    public function nakespetunjuk(){



        return redirect()->route('nakes.dashboard')->with('alert', '9Kuciki Ini Bisa dilanjutkan');

    }

    public function getselectedfaskesedit(Request $request){

        $id_pengajuan = $request->id_pengajuan;

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mengambil Data Jadwal Praktik';
        $result = $this->model->getselectedfaskesedit($id_pengajuan);
        if($result) {
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Mengambil Data Faskes';
            $data['result'] = $result;
        }
        return response()->json($data);

    }

    public function updatelokasipengajuan(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Update Lokasi Pengajuan';
        $selectedfaskes = $request->selectedfaskes;
        if (isset($selectedfaskes) && $selectedfaskes !== '') {
            $result = $this->model->updatelokasipengajuan($request);
            if($result) {
                $data['success'] = true;
                $data['keterangan'] = 'Berhasil Update Lokasi Pengajuan';
                $data['result'] = $result;
            }
        } else {
            $data['keterangan'] = 'Faskes Yang Dipilih Tidak Diperbolehkan';
        }
        return response()->json($data);

    }

    public function gettoupdatepengajuan(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Melakukan Pengecheckan Pengajuan';
        $result = $this->model->gettoupdatepengajuan($request);
        if($result !== false) {
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Melakukan Pengecheckan Pengajuan';
            $data['result'] = $result;
        }
        return response()->json($data);

    }


    public function gettoupdatepengajuanlokasi(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Melakukan Pengecheckan Pengajuan';
        $result = $this->model->gettoupdatepengajuanlokasi($request);
        if($result !== false) {
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Melakukan Pengecheckan Pengajuan';
            $data['result'] = $result;
        }
        return response()->json($data);

    }

    public function resubmitpengajuan(Request $request) {

        $id_user = $request->updater;
        $salinan = $request->salinan;
        $id_pengajuan = $request->id_pengajuan;
        $idredirect = $id_user.'_'.$salinan.'_'.$id_pengajuan;

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Melakukan Pengecheckan Pengajuan';

        $result = $this->model->resubmitpengajuan($request);
        if($result) {

            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Melakukan Pengecheckan Pengajuan';
            $data['result'] = $result;
            $data['idredirect'] = $idredirect;

            //return redirect()->route('nakes.dashboard')->with('alert', '1Pengajuan SIP Berhasil Di Submit Ulang');
        } 

        return response()->json($data);

    }

    public function nakesupdatedoc(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Update Dokumen';
        $isrubahfile = '0';

        $salinan = $request->tupdateSalinan;
        $jenis_doc = $request->tjenisdoc;
        $user_id = $request->tUserDok;
        $tgl_doc_ori = $request->dokTGL;
        $tgl_berlaku_ori = $request->dokTGL;
        

        if ($jenis_doc == 'IJAZAH') {
            $filenamenya = $request->texistingfilename;
            $id_request = $user_id.'_IJAZAH_0';
        } else {
            $filenamenya = $jenis_doc.'_'.$user_id.'_'.$tgl_doc_ori;
            $id_request = $user_id.'_'.$jenis_doc.'_'.$salinan;
        }
        
        $updater = $request->dokUploader;
        $no_doc = $request->dokNOMOR;
        $remark1 = $request->dokREMARK1;
        $remark2 = $request->dokREMARK2;
        $remark3 = $request->dokREMARK3;

        if ($tgl_doc_ori != '') {
            $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
        } else {
            $tgl_doc = $tgl_doc_ori;
        }

        if($jenis_doc != 'FOTO') {

            if ($tgl_berlaku_ori != '' ) {
                $tgl_berlaku = $this->help->tgl_indo_sip($tgl_berlaku_ori);
            } else {
                $tgl_berlaku_ori = $tgl_berlaku;
            }

        }

    

        if($request->hasFile('tFileNakesDok')){

            $request->validate([
                'tFileNakesDok' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
            ]); 

            $thefile = $request->file('tFileNakesDok');
            $extension = $request->file('tFileNakesDok')->extension();
            if ($jenis_doc == 'IJAZAH') {
                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya);
                $namafile = $filenamenya;
                $hasil = Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
            } else if($jenis_doc == 'FOTO') {

                $namafile = $request->texistingfilename;
                $hasil = Storage::putFileAs('/fotostr', $thefile, $namafile);
                $this->cropthephoto($namafile);

            } else if(Str::contains($jenis_doc, 'SKSKP')) {

                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                $namafile = $filenamenya.'.'.$extension;
                $hasil = Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));

                $urlget = config('app.cv2_host').'convertandextract';
                $extensionpos = '.pdf';
                $remark1 = '31 Desember 2024';

                try {

                    $response_ = Http::timeout(10)->connectTimeout(5)->asForm()->post($urlget, ['thename'=> $filenamenya, 'extension' => $extensionpos, 'jenis' => 'skskp']);
                    $response_status = $response_->status();
                    $response = $response_->json();

                    if ($response_status == 200) {

                        $dcd = json_decode($response_);
                        $data['hasil'] = $dcd;
                        if (!empty($dcd->thelink)) {
                            $remark1 = $dcd->thelink;
                        }
                        
                    } 

                    $this->model->updatedetailskskp($user_id, $remark1);

                } catch (\Exception $e) {
                    // ❌ Any other unexpected error
                    $data['error'] = $e;
                }
                
                

            } else {
                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                $namafile = $filenamenya.'.'.$extension;
                $hasil = Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
            }
            
        } else {
            $hasil = true;
            $namafile = $filenamenya;
        }

        if($hasil) {

            $updatedoknakes = $this->model->updatedoknakes($request, $namafile, $tgl_doc);
            if($updatedoknakes) {
                return redirect()->route('nakes.documents')->with('alert', '1Sukses Upload Rekomendasi Organisasi Profesi');
            } else {

                return redirect()->route('edit.dokumen.nakes', $id_request)->with('alert', '9Gagal update dokumen, Silahkan Coba Kembali');
            }   
        }
    }

    public function nakesupdatepass(Request $request) {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Update Password, Silahkan Coba Kembali';
        $result = $this->model->nakesupdatepass($request);
        if($result) {
            $data['success'] = true;
            $data['keterangan'] = 'Update Password Berhasil';
        }
        return response()->json($data);

    }

    public function getallvisitasi(Request $request) {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mengambil Data Visitasi';
        $result = $this->model->getallvisitasi($request);
        if($result) {
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Mengambil Data Visitasi';
            $data['visitasi'] = $result;
        }
        return response()->json($data);
    }


    public function simpanstrmanualdokter(Request $request) {

        try{
            $result = $this->model->simpanstrmanualdokter($request);
            if ($result) {
                return redirect()->route('nakes.documents')->with('alert', '1Berhasil Menyimpan STR, Silahkan Lanjutkan Proses Berikutnya');
            } else {
                return redirect()->route('nakes.documents')->with('alert', '9Gagal Memproses STR, Silahkan Coba Beberapa Saat Lagi');
            }
            
        }catch(Exception $e) {

            return redirect()->route('nakes.documents')->with('alert', '9Gagal Memproses STR, Silahkan Coba Beberapa Saat Lagi. Keterangan :'+$e);

        }

    }

    public function batalkanpengajuan(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Membatalkan Pengajuan';

        try {
            $result = $this->model->batalkanpengajuan($request);
            if ($result) {
                $data['success'] = true;
                $data['keterangan'] = 'Berhasil Membatalkan Pengajuan';
                $data['visitasi'] = $result;
            } 
            return response()->json($data);
            
        } catch(Exception $e) {

            $data['error'] = 'Terjadi Kesalahan : '+e;
            return response()->json($data);

        }

    }


    public function getesipbefore(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mendapatkan Data SIP Sebelumnya';
        $data['surat_url'] = config('app.surat_host');

        try {
            $result = $this->model->getesipbefore($request);
            if ($result) {
                $data['success'] = true;
                $data['keterangan'] = 'Berhasil Ambil Data SIP Sebelumnya';
                $data['sip_sebelumnya'] = $result;
            } 
            return response()->json($data);
            
        } catch(Exception $e) {

            $data['error'] = 'Terjadi Kesalahan : '+e;
            return response()->json($data);

        }

    }


    public function updateqrcodenakes($salinan){

        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $template_id = $this->model->gettemplateid($id);
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['fotouser'] = $this->model->getdocfoto($id);
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $data['salinan'] = $salinan;
        $data['template_id'] = $template_id;
        $data['current_str'] = $this->model->getcurrentstrdetaildok($id,$salinan);

        return view('nakes/nakesupdateqrcode', $data);

    }

    public function simpanupdateqrcode(Request $request) {

        try{
            $result = $this->model->simpanupdateqrcode($request);
            if ($result) {
                return redirect()->route('nakes.documents')->with('alert', '1Berhasil Menyimpan STR, Silahkan Lanjutkan Proses Berikutnya');
            } else {
                return redirect()->route('nakes.documents')->with('alert', '9Gagal Memproses STR, Silahkan Coba Beberapa Saat Lagi');
            }
            
        }catch(Exception $e) {

            return redirect()->route('nakes.documents')->with('alert', '9Gagal Memproses STR, Silahkan Coba Beberapa Saat Lagi. Keterangan :'+$e);

        }

    }

    public function submitsipmanual(Request $request){

        $data['success'] = false;
        $data['success_extract'] = false;

        if($request->hasFile('tFileNakesSIPLama')){

            
            $thefile = $request->file('tFileNakesSIPLama');
            $extension = $request->file('tFileNakesSIPLama')->extension();
            $filenamenya = $request->file('tFileNakesSIPLama')->getClientOriginalName();
            
        }

        try{

            $encrypted = $this->random_string(25);
            $namafile = $encrypted.'.'.$extension;
            $path = Storage::putFileAs('/sipmanual', $thefile, $encrypted.'.'.$extension);
            Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));

            $data['namafile'] = $encrypted;
            return response()->json($data);

        }catch(Exception $e) {

            $data['error'] = $e;
            return response()->json($data);

        }
    }

    public function simpansipmanual(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Menyimpan SIP';

        try{
            $result = $this->model->simpansipmanual($request);
            if ($result) {
                $data['success'] = true;
                $data['keterangan'] = 'Berhasil Menyimpan SIP';
            } else {
                $this->model->batalajukansipmanual($request);
            }
            return response()->json($data);
            
        }catch(Exception $e) {

            $data['error'] = $e;
            return response()->json($data);
        }

    }

    public function skipvalidasistr(Request $request) 
    {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Melanjutkan Proses Dokumen STR';
       
        $result = $this->model->skipvalidasistr($request);
        if ($result) {
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Menyimpan STR';
        }
        return response()->json($data);
    }

    public function simpanstrnvdokter(Request $request)
    {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Melanjutkan Proses Perpanjangan STR';
        $id_request = $request->strequestnv.'_0';
        $id = $request->stUserIDNakesDoknv;
        $filename = $request->stWhichnvDok;

        try {
            Storage::copy('perpanjangan/'.$filename.'.pdf', 'daftar/'.$filename.'.pdf');
        } catch(Exception $e) {
            //$data['succees'] = false;
            return redirect()->route('nakes.dashboard')->with('alert', '9'.$e);
        }
       
        $result = $this->model->skipvalidasistrperpanjangan($request);
        if ($result) {
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Menyimpan Perpanjangan STR';
            $totalpengajuan = $this->model->gettotalpengajuanperpanjangan($id);
            if($totalpengajuan > 0) {
                return redirect()->route('nakes.perpanjangan.pengajuan', $id_request)->with('alert', '1Berhasil Menyimpan STR, Silahkan Lanjutkan Proses Berikutnya');
            } else {
                return redirect()->route('nakes.dashboard')->with('alert', '1Berhasil Menyimpan STR, Silahkan Lanjutkan Proses Berikutnya');
            }
            
        } else {
            return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Update STR, Silahkan Coba Lagi');
        }
        //

    }

    public function simpanijazahlainnakes(Request $request){

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Menambah Data Pendidikan';

        $id_user = $request->tUser_id;
        $tahun = $request->tthlulus;
        $jenis_doc = 'IJAZAH_'.$tahun;
        
        try{
            if($request->hasFile('tFileDoc')){

                $request->validate([
                    'tFileDoc' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
                ]); 

                $thefile = $request->file('tFileDoc');
                $extension = $request->file('tFileDoc')->extension();
                $filenamenya = 'IJAZAH_'.$id_user.'_'.$tahun.'.'.$extension;
                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya);
                $namafile = $filenamenya;
                $hasil = Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
                
            }

            $nama_doc = 'Ijazah '.$tahun;
            $no_doc = $request->tNoDocument;
            $tgl_doc_ori = $request->tTglDocument;
            $tgl_berlaku_ori = $request->tTglBerlaku;
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

            $tUniv = $request->tUniversitas;
            $tStrata = $request->tStrata;
            $tProdi = $request->tProdi;
            $remark1 = '';
        
            $this->model->tambahDocIjazah($jenis_doc, $id_user, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $id_user, $tgl_doc_ori, $tgl_berlaku_ori, 0, $tUniv, $tStrata, $tProdi);
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Menambah Data Pendidikan';
            return response()->json($data);

        }catch(Exception $e) {
            //$data['succees'] = false;
            $data['error'] = $e;
            $data['filenamestr'] = $encrypted;
            return response()->json($data);

        }
    }

    public function submitskskp(Request $request)
    {

        if($request->hasFile('tFileNakesSKSKP')){

            $data['success'] = false;
            $data['success_extract'] = false;

            $request->validate([
                'tFileNakesSKSKP' => 'file|mimes:pdf|max:5120',
            ]); 


            
            $thefile = $request->file('tFileNakesSKSKP');
            $extension = $request->file('tFileNakesSKSKP')->extension();
            $filenamenya = $request->file('tFileNakesSKSKP')->getClientOriginalName();
            $user_id = $request->tUserPengajuan;
            $isedit = $request->tiseditskskp;

            $no_doc = $request->tNoSKSKP;
            $tgl_doc_ori = $request->tTglSKSKP;
            $tgl_berlaku_ori = $request->tTglSKSKP;

            if ($tgl_doc_ori != '') {
                $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
            } else {
                $tgl_doc = $tgl_doc_ori;
            }

            if ($tgl_berlaku_ori != '') {
                $tgl_berlaku = $this->help->tgl_indo_sip($tgl_berlaku_ori);
            } else {
                $tgl_berlaku_ori = $tgl_berlaku;
            }

            
            try{

                if($isedit == '0') {

                    $encrypted = $this->random_string(10);
                    $namafile = 'SKSKP_'.$encrypted.'.'.$extension;
                    $path = Storage::putFileAs('/uploaddoc', $thefile, 'SKSKP_'.$encrypted.'.'.$extension);
                    $hasil = Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));

                    $urlget = config('app.cv2_host').'convertandextract';
                    $extensionpos = '.pdf';
                    $remark1 = '31 Desember 2024';

                    try{

                        $response_ = Http::timeout(10)->asForm()->post($urlget, ['thename'=>'SKSKP_'.$encrypted, 'extension' => $extensionpos, 'jenis' => 'skskp']);
                        $response_status = $response_->status();
                        $response = $response_->json();
                        
                        
                        if ($response_status == 200) {

                            if($response == null)
                            {
                                $remark1 = '';
                            } else {

                                $dcd = json_decode($response_);
                                $data['hasil'] = $dcd;
                                if (!empty($dcd->thelink)) {
                                    $remark1 = $dcd->thelink;
                                }

                            }
                            
                            
                        } 

                    } catch (\Exception $e) {
                        // ❌ Any other unexpected error
                        $data['error'] = $e;
                    }

                    
                    

                    $banyaknya = ['1', '2', '3'];

                    foreach ($banyaknya as $salsal) {
                        $jenis_doc = 'SKSKP'.$salsal;
                        $nama_doc = 'File Serkom / SKP '.$salsal;
                        
                        $this->model->tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $user_id, $tgl_doc_ori, $tgl_berlaku_ori, 0, 'skskp');
                    }

                    $data['success'] = true;
                    $data['keterangan'] = 'Data Berhasil Disimpan';
                    
                    return response()->json($data);

                } else {

                    $namafile = $request->filenameskskp;
                    $thename = str_replace('.pdf', '',$namafile);
                    $path = Storage::putFileAs('/uploaddoc', $thefile, $namafile);
                    $hasil = Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));

                    $urlget = config('app.cv2_host').'convertandextract';
                    $extensionpos = '.pdf';
                    $remark1 = '31 Desember 2024';

             
                    try {

                        $response_ = Http::timeout(10)->asForm()->post($urlget, ['thename'=> $thename, 'extension' => '.pdf', 'jenis' => 'skskp']);
                        $response_status = $response_->status();
                        $response = $response_->json();
                        
                        if ($response_status == 200) {

                            $dcd = json_decode($response_);
                            $data['hasil'] = $dcd;
                            if (!empty($dcd->thelink)) {
                                $remark1 = $dcd->thelink;
                            }
                            
                        } 

                        $result = $this->model->updateSKSKP($remark1, $no_doc, $tgl_doc);

                    } catch(Exception $e) {
                        //$data['succees'] = false;
                        $data['error'] = $e;
        
                    }
                    
                    $data['success'] = true;
                    $data['keterangan'] = 'Data Berhasil Disimpan';
                    
                    return response()->json($data);
                }

                

            }catch(Exception $e) {
                //$data['succees'] = false;
                $data['error'] = $e;
                return response()->json($data);

            }
        }

    }

    public function simpanmaindocnakes(Request $request)
    {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Submit Dokumen Nakes';

        $tgl_origin = $request->ktpTanggalLahir;
        
        $tgl_doc = $this->help->tgl_indo_sip($tgl_origin);
        $template_id = $request->ktpTemplateId;
        $jenis_sip = '';

        if ($template_id == '3' || $template_id == '4') {
            $jenis_sip = $this->help->tgl_indo_apoteker($tgl_origin);
        }
       
        $result = $this->model->simpanmaindocnakes($request, $tgl_doc, $jenis_sip);
        if ($result) {
            $data['success'] = true;
            $data['keterangan'] = 'Submit Dokumen Nakes Berhasil';
        }
        return response()->json($data);

    }

    public function getmaindoknakes(Request $request)
    {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Submit Dokumen Nakes';

        
        $result = $this->model->getmaindoknakes($request);
        if ($result) {
            $data['success'] = true;
            $data['keterangan'] = 'Submit Dokumen Nakes Berhasil';
            $data['result'] = $result;
        }
        return response()->json($data);



    }

    public function nakeshistorikal($id)
    {
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;

        $data['fotouser'] = $this->model->getdocfoto($id);
        $data['informasis'] = $this->model->getinformation($id);
        $data['profesi'] = $this->model->getprofesi($id, 'prof');
        $data['qr_url'] = $this->model->getprofesi($id, 'url');
        $data['jenis_profesi'] = $this->model->getprofesi($id, 'jenis_profesi');
        $data['pengajuan'] = $this->model->getallpengajuan($id, 'cabut');
        $data['pengajuanhist'] = $this->model->getallpengajuan($id, 'cabuthist');
        $data['personal_info'] = $this->model->getpersonalinfo($id);
        $surathost = config('app.surat_host').'assets/uploads/maker/approved/';
        $surathostprd = 'https://surat.cilacapkab.go.id/assets/uploads/maker/approved/';
        $data['surathost'] = $surathost;
        $data['surathostprd'] = $surathostprd;
        
        return view('nakes/nakeshistorikal', $data);

    }

    public function nakessiphistorikal(Request $request)
    {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mengambil Data Historikal SIP';
        $id_user = $request->id_user;

        
        $result = $this->model->nakessiphistorikal($request);
        if ($result) {
            $data['success'] = true;
            $data['keterangan'] = 'Submit Dokumen Nakes Berhasil';
            $data['result'] = $result;
        }
        return response()->json($data);

    }

    public function summaryjadwal(Request $request)
    {
        $data = $this->model->summaryjadwal($request);
        return $data;
    }

    public function getdetaildokpencabutan(Request $request)
    {
        $data['success'] = false;
        $result = $this->model->getdetaildokpencabutan($request->idpengajuan);
        $histori = $this->model->gethistoridokpencabutan($request);
        if($histori)
        {
            $data['success'] = true;
            $data['result'] = $result;
            $data['histori'] = $histori;
        }
        return $data;
    }

    public function dokpencabutan($idpengajuan)
    {
        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['pencabutan'] = 1;
        $data['idpengajuan'] = $idpengajuan;
        $getdetaildoc = $this->model->getdetaildokpencabutan($idpengajuan);
        return view('nakes/nakeseditdokumen', $data);

    }

    public function updatedokpencabutan(Request $request)
    {
        $data['success'] = false;
        $data['keterangan'] = "Gagal Update Dokumen Pencabutan";

        if($request->has('isAdmin'))
        {
            

        } else {

            $salinan = $request->cabutSalinan;
            $user_id = $request->cabutnakes_id;
            
            try{

                if($request->hasFile('tFileRekomdok')){

                    $request->validate([
                        'tFileRekomdok' => 'file|mimes:pdf|max:5120',
                    ]); 

                    $jenis_doc = 'REKOMDOKC'.$salinan;
                    $now = date('Y-m-d');
                    
                    
                    $thefile = $request->file('tFileRekomdok');
                    $filenamenya = $request->cabutfilename;
                    
                    $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya);
                    $namafile = $filenamenya;
                    Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));

                }

                $tgl_doc_ori = $request->tTglRekomdok;

                if ($tgl_doc_ori != '') {
                    $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
                    $hari = $this->help->hariIndo($tgl_doc_ori);
                    $tgl_doc = 'hari '.$hari.' tanggal '.$tgl_doc;
                } else {
                    $tgl_doc = $tgl_doc_ori;
                }

                $result = $this->model->updatedokpencabutan($request, $tgl_doc);
                if($result)
                {
                    $data['success'] = true;
                    $data['keterangan'] = "Berhasil Update Dokumen Pencabutan";

                }

            }catch(Exception $e) {

                $data['keterangan'] = $e;

            }

        }

        

        return $data;

    }


}
