<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DinkesModel;
use App\Models\NakesModel;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use App\Helpers\Help;

class DinkesController extends Controller
{
    /** @var DinkesModel */
    protected $model;

    /** @var NakesModel */
    protected $model2;

    /** @var AdminModel */
    protected $model3;

    /** @var Help */
    protected $help;

    public function __construct(){
        $this->model = new DinkesModel;
        $this->model2 = new NakesModel;
        $this->model3 = new AdminModel;
        $this->help = new Help;
    }

    public function index(){
        //
        return view('welcome');
    
    }

    public function sendnotifwa($nomor,$pesan){

        $sender = config('app.no_ptsp');
        $urlget = config('app.wa_host');
        $response = Http::timeout(3)->post($urlget, ['sender'=>$sender, 'number' => $nomor, 'message' => $pesan]);

        if ($response->failed()) {
            return true;
        } else {
            return true;
        }
        

    }


    public function dinkesdashboard(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $tglcoba = '2022-01-10 02:01:00';
        $bedanya = $this->help->standardiff($tglcoba);
        $tglsip = $this->help->tgl_indo_sip($tglcoba);
        $data['tglsip'] = $tglsip;
        $data['bedaken'] = $bedanya;
        $data['pengajuan'] = $this->model->getpengajuan('normal');

        return view('dinkes/admindinkesdashboard', $data);


        // $todays = date('Y-m-d');
        // $data['todays'] = $todays;
        // $data['role'] = Auth::user()->role;
        // $nama = Auth::user()->name;
        // $id = Auth::user()->id;
        // $data['user_id'] = $id;
        // $data['nama_user'] = $nama;
        // $data['pendaftar'] = $this->model3->getpendaftar();


        // return view('adminnakespendaftaran', $data);
        
    }

    public function kadinkesdashboard()
    {
        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $tglcoba = '2022-01-10 02:01:00';
        $bedanya = $this->help->standardiff($tglcoba);
        $tglsip = $this->help->tgl_indo_sip($tglcoba);
        $data['tglsip'] = $tglsip;
        $data['bedaken'] = $bedanya;
        $data['pengajuan'] = $this->model->getpengajuan('kadinkes');

        return view('dinkes/kadinkesdashboard', $data);

    }

    public function resubmitDraftAsoka($id_pengajuan){

        $isverif = $this->model->getisverif($id_pengajuan);
        if($isverif) {
            $getdraftsip = $this->model3->getdraftsip($id_pengajuan);
            $getperpanjangan = $this->model3->getperpanjangan($id_pengajuan);
            $salinanori = $this->model3->getsalinansip($id_pengajuan);
            $foto_nakes = $this->model3->getfotonakes($id_pengajuan);

            if($getdraftsip) {
                $filename_sip = $getdraftsip->filename_sip;
                $nama_nakes = $getdraftsip->nama_nakes;
                $no_str = $getdraftsip->no_str;
                $no_sip = "DRAFT SIP STR".$no_str;
                $template_id = $getdraftsip->template_id;
                $no_rekomp = $getdraftsip->no_rekomp;
                $tgl_rekomp = $getdraftsip->tgl_rekomp;
                $no_rekomdinkes = $getdraftsip->no_rekomdinkes;
                $tgl_rekomdinkes = $this->help->tgl_indo_sip($getdraftsip->tgl_rekomdinkes);
                $nama_nakes = $getdraftsip->nama_nakes;
                $ttl_nakes = $getdraftsip->ttl_nakes;
                $alamat_nakes = $getdraftsip->alamat_nakes;
                $salinan_terbilang = $getdraftsip->salinan_terbilang;
                $tgl_berlaku = $getdraftsip->tgl_berlaku;
                $tgl_doc = $getdraftsip->tgl_doc;
                $kompetensi = $getdraftsip->kompetensi;
                $profesi = $getdraftsip->profesi;
                if($profesi == 'APOTEKER') {
                    $profesi = 'Apoteker Praktik';
                } else {
                    $profesi = ucwords($profesi);
                }
                $nama_faskes = $getdraftsip->nama_faskes;
                $nama_lokasi = $getdraftsip->nama_lokasi;
                $kec_lokasi = $getdraftsip->kec_lokasi;
                $kab_lokasi = $getdraftsip->kab_lokasi;
                $salinan = $getdraftsip->salinan;
                $id_nakes = $getdraftsip->id_nakes;
                $is_plt = $getdraftsip->is_plt;
                $nama_tte = $getdraftsip->nama_tte;
                $pangkat_tte = $getdraftsip->pangkat_tte;
                $nip_tte = $getdraftsip->nip_tte;
                $jenis_profesi = $getdraftsip->jenis_profesi;
                $perubahan = $getdraftsip->perubahan;
                $isSementara = $getdraftsip->jadwal_praktek;

                $getjadwal = $this->model3->getjadwalnakes($id_nakes, $salinan);
                $jadwaljson = json_encode($getjadwal);


                $urlget = config('app.surat_host').'CsubmitRekomNakes/submitRekomNakes';
                $liatdraft = config('app.surat_host').'assets/uploads/maker/draft/';

                $datapost = [
                    'filename_sip' => $filename_sip, 
                    'nama_nakes' => $nama_nakes, 
                    'no_sip' => $no_sip, 
                    'id_pengajuan' => $id_pengajuan, 
                    'no_str' => $no_str, 
                    'template_id' => $template_id,
                    'no_rekomp' => $no_rekomp,
                    'tgl_rekomp' => $tgl_rekomp,
                    'no_rekomdinkes' => $no_rekomdinkes,
                    'tgl_rekomdinkes' => $tgl_rekomdinkes,
                    'nama_nakes' => $nama_nakes,
                    'ttl_nakes' => $ttl_nakes,
                    'alamat_nakes' => $alamat_nakes,
                    'salinan_terbilang' => $salinan_terbilang,
                    'tgl_berlaku' => $tgl_berlaku,
                    'tgl_doc' => $tgl_doc,
                    'kompetensi' => $kompetensi,
                    'profesi' => $profesi,
                    'nama_faskes' => $nama_faskes,
                    'nama_lokasi' => $nama_lokasi,
                    'kec_lokasi' => $kec_lokasi,
                    'kab_lokasi' => $kab_lokasi,
                    'is_plt' => $is_plt,
                    'nama_tte' => $nama_tte,
                    'pangkat_tte' => $pangkat_tte,
                    'nip_tte' => $nip_tte,
                    'salinan' => $salinan,
                    'id_nakes' => $id_nakes,
                    'foto_nakes' => $foto_nakes,
                    'jenis_profesi' => $jenis_profesi,
                    'jadwal_praktek' => $jadwaljson,
                    'perubahan' => $perubahan,
                    'salinan' => $salinanori,
                    'perpanjangan' => $getperpanjangan,
                    'isSementara' => $isSementara
                ];

                $response_ = Http::asForm()->post($urlget, $datapost);
                
            }
        }

    }

    public function detailpengajuan($id) {
        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id_aut = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id_aut;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['id_pengajuan'] = $id;
        $firstChar = substr($id, 0, 1);
        if ($firstChar != 'M') {

            $id_nakes = $this->model->getidnakes($id);
            $salinan = $this->model->getsalinanpengajuan($id);

            $statussip = $this->model2->checkstatussip($id, $id_nakes, $salinan);
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
                    $idsurat = $esiptte[0]['id_surat'];
                    if($idsurat == '0') {

                        $this->resubmitDraftAsoka($id);

                    }
                    $statusdokumen = $esiptte[0]['statusdokumen'];
                    $statusesip = $esiptte[0]['statusesip'];
                    $signed_date = $esiptte[0]['signed_date'];
                    $no_surat = $esiptte[0]['no_surat'];
                    $detailjadwal = $esiptte[0]['detailjadwal'];
                    if($statusdokumen == '1') {
                        $result = $this->model3->updatestatussip($id, $filename_sip, $detailjadwal, $no_surat, $signed_date);
                    }
                }

            }
            
            $data['salinan'] = $salinan;
            $data['id_nakes'] = $id_nakes;
            $data['doc_stp'] = $this->model2->getdoc($id_nakes, 'STP'.$salinan);
            $data['doc_strused'] = $this->model2->getdoc($id_nakes, 'STR'.$salinan);
            $data['strbrapa'] = 'STR'.$salinan;
            $data['doc_sks'] = $this->model2->getdoc($id_nakes, 'SKS'.$salinan);
            $data['doc_sptp'] = $this->model2->getdoc($id_nakes, 'SPTP'.$salinan);
            $data['doc_ijazah'] = $this->model2->getdoc($id_nakes, 'IJAZAH');
            $data['doc_skp'] = $this->model2->getdoc($id_nakes, 'SKP'.$salinan);
            $data['doc_foto'] = $this->model2->getdoc($id_nakes, 'FOTO');
            $data['doc_rekomdk'] = $this->model2->getdoc($id_nakes, 'REKOMDK'.$salinan);
            $data['doc_rekomp'] = $this->model2->getdoc($id_nakes, 'REKOMP'.$salinan);
            $data['doc_bav'] = $this->model2->getdoc($id_nakes, 'BAV'.$salinan);
            $data['doc_ktp'] = $this->model2->getdoc($id_nakes, 'KTP');
            $data['doc_c'] = $this->model2->getdoc($id_nakes, 'REKOMDOKC'.$salinan);
            $data['doc_skskp'] = $this->model2->getdoc($id_nakes, 'SKSKP'.$salinan);
            $data['doc_sktp'] = $this->model2->getdoc($id_nakes, 'SKTP'.$salinan);
            $data['detail_pengajuan'] = $this->model->getdetailpengajuan($id);
            $data['jadwalbefore'] = $this->model3->getlatestjadwal($id);
            $data['detail_pengaju'] = $this->model2->detailpengaju($id_nakes);
            $data['jadwalpraktik'] = $this->model3->getjadwalpraktik($id_nakes, $salinan, $id);
            $data['checkfix'] = $this->model->checkfixed($id);
            $data['pilihfixed'] = $this->model->pilihfixed($id);
            $data['infonakes'] = $this->model2->getinfonakes($id_nakes);
            $data['surat_host'] = config('app.surat_host');
            $data['subspesialis'] = $this->model2->getsubspesialis($id_nakes);
            $data['doc_sub'] = $this->model2->getdoc($id_nakes, 'stsub');
            $data['histori_pengajuan'] = $this->model2->gethistoripengajuan($id);
            $data['sejawat'] = $this->model2->getsejawat($id_nakes);
            $data['doc_rekdin'] = $this->model2->getdoc($id_nakes, 'rekdin'.$salinan);
            $data['doc_sipb'] = $this->model2->getdoc($id_nakes, 'SIPB'.$salinan);

            return view('pengajuan/detailpengajuan', $data);

        } else {
            $id_pengajuan = substr($id, 1);
            $getdetailsipmanual = $this->model->detailsipmanual($id_pengajuan);
            $id_nakes = $getdetailsipmanual->id_nakes;
            $data['id_user'] = $id_aut;
            $salinan = $getdetailsipmanual->salinan;

            $data['doc_stp'] = $this->model2->getdoc($id_nakes, 'STP'.$salinan);
            $data['doc_strused'] = $this->model2->getdoc($id_nakes, 'STR'.$salinan);
            $data['strbrapa'] = 'STR'.$salinan;
            $data['doc_sks'] = $this->model2->getdoc($id_nakes, 'SKS'.$salinan);
            $data['doc_sptp'] = $this->model2->getdoc($id_nakes, 'SPTP'.$salinan);
            $data['doc_ijazah'] = $this->model2->getdoc($id_nakes, 'IJAZAH');
            $data['doc_skp'] = $this->model2->getdoc($id_nakes, 'SKP'.$salinan);
            $data['doc_foto'] = $this->model2->getdoc($id_nakes, 'FOTO');
            $data['doc_rekomdk'] = $this->model2->getdoc($id_nakes, 'REKOMDK'.$salinan);
            $data['doc_rekomp'] = $this->model2->getdoc($id_nakes, 'REKOMP'.$salinan);
            $data['doc_bav'] = $this->model2->getdoc($id_nakes, 'BAV'.$salinan);
            $data['doc_ktp'] = $this->model2->getdoc($id_nakes, 'KTP');
            $data['doc_c'] = $this->model2->getdoc($id_nakes, 'REKOMDOKC'.$salinan);
            $data['detail_pengajuan'] = $this->model2->getdetailsiplama($id_nakes, $salinan);
            //$data['jadwalbefore'] = $this->model3->getlatestjadwal($id);
            $data['detail_pengaju'] = $this->model2->detailpengaju($id_nakes);
            //$data['jadwalpraktik'] = $this->model3->getjadwalpraktik($id_nakes, $salinan, $id);
            
            $data['infonakes'] = $this->model2->getinfonakes($id_nakes);
            $data['surat_host'] = config('app.surat_host');
            $data['subspesialis'] = $this->model2->getsubspesialis($id_nakes);
            $data['doc_sub'] = $this->model2->getdoc($id_nakes, 'stsub');
            //$data['histori_pengajuan'] = $this->model2->gethistoripengajuan($id);
            $data['sejawat'] = $this->model2->getsejawat($id_nakes);

            return view('pengajuan/detailpengajuansiplama', $data);

        }
        
    }


    public function detailpengajuanop($id) {
        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id_aut = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id_aut;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['id_pengajuan'] = $id;
        $id_nakes = $this->model->getidnakes($id);
        $salinan = $this->model->getsalinanpengajuan($id);
        
        $data['salinan'] = $salinan;
        $data['id_nakes'] = $id_nakes;
        $data['doc_stp'] = $this->model2->getdoc($id_nakes, 'STP'.$salinan);
        $data['doc_strused'] = $this->model2->getdoc($id_nakes, 'STR'.$salinan);
        $data['strbrapa'] = 'STR'.$salinan;
        $data['doc_sks'] = $this->model2->getdoc($id_nakes, 'SKS'.$salinan);
        $data['doc_sptp'] = $this->model2->getdoc($id_nakes, 'SPTP'.$salinan);
        $data['doc_ijazah'] = $this->model2->getdoc($id_nakes, 'IJAZAH');
        $data['doc_skp'] = $this->model2->getdoc($id_nakes, 'SKP'.$salinan);
        $data['doc_foto'] = $this->model2->getdoc($id_nakes, 'FOTO');
        $data['doc_rekomdk'] = $this->model2->getdoc($id_nakes, 'REKOMDK'.$salinan);
        $data['doc_rekomp'] = $this->model2->getdoc($id_nakes, 'REKOMP'.$salinan);
        $data['doc_bav'] = $this->model2->getdoc($id_nakes, 'BAV'.$salinan);
        $data['doc_ktp'] = $this->model2->getdoc($id_nakes, 'KTP');
        $data['detail_pengajuan'] = $this->model->getdetailpengajuan($id);
        $data['jadwalbefore'] = $this->model3->getlatestjadwal($id);
        $data['detail_pengaju'] = $this->model2->detailpengaju($id_nakes);
        $data['jadwalpraktik'] = $this->model3->getjadwalpraktik($id_nakes, $salinan, $id);

        $data['infonakes'] = $this->model2->getinfonakes($id_nakes);

        return view('pengajuan/detailpengajuanop', $data);
    }


    public function submittglvisitasi(Request $request){

        $id_pengajuan = $request->id_pengajuan;
        $id_nakes = $request->id_nakes;
        $tgl_visitasi = $request->tgl_visitasi;
        $updater = $request->updater;
        $pesanadmin = 'Penjadwalan Visitasi Anda Telah Ditetapkan pada '.$tgl_visitasi.'. Pastikan Kesiapan Lokasi Pengajuan Anda.';
        $nomorwa = $this->model3->getnomorwa($id_nakes);
        $updatevisitasi = $this->model->updatevisitasil($id_pengajuan, $id_nakes, $tgl_visitasi, $updater);
        //$this->sendnotifwa($nomorwa, $pesanadmin);
        if ($updatevisitasi) {
            $this->model->updatePesan('admin', '1', $pesanadmin, $id_nakes);
            
            return response()->json(['success'=>true, 'message'=>'Berhasil Update Tanggal Visitasi']);
        } else {
            return response()->json(['success'=>false, 'message'=>'Gagal Update Tanggal Visitasi']);
        }

        

    }

    
    public function updatetglvisitasi(Request $request){

        $id_pengajuan = $request->id_pengajuan;
        $id_nakes = $request->id_nakes;
        $tgl_visitasi = $request->tgl_visitasi;
        $updater = $request->updater;
        $pesanadmin = 'Penjadwalan Visitasi Anda Telah Diupdate pada '.$tgl_visitasi.'. Pastikan Kesiapan Lokasi Pengajuan Anda.';
        $nomorwa = $this->model3->getnomorwa($id_nakes);
        $updatevisitasi = $this->model->updatevisitasil($id_pengajuan, $id_nakes, $tgl_visitasi, $updater);
        //$this->sendnotifwa($nomorwa, $pesanadmin);
        if ($updatevisitasi) {
            $this->model->updatePesan('admin', '1', $pesanadmin, $id_nakes);
            
            return response()->json(['success'=>true, 'message'=>'Berhasil Update Tanggal Visitasi']);
        } else {
            return response()->json(['success'=>false, 'message'=>'Gagal Update Tanggal Visitasi']);
        }

        

    }


    
    public function testdownloadfoto(Request $request){

        $filenamenya = $request->filenamenya;
       

        try{
 
            $image = str_replace('data:image/jpeg;base64,', '', $filenamenya);
            $image = str_replace(' ', '+', $image);
            $imageName = 'testinggambars.jpeg';
            \File::put(storage_path('app/fotostr'). '/' . $imageName, base64_decode($image));
            //$path = Storage::putFileAs('/fotostr', base64_decode($image), $imageName);
            return response()->json(['success'=>true, 'message'=>'Berhasil Simpan Gambar']);

        }catch(Exception $e) {

            
            return response()->json(['success'=>false, 'message'=>'Gagal Simpan Gambar']);

        }

        

    }

    public function testdlft(Request $request) {
        $filenya = $request->filenya;

        try{
 
            $url = "http://registrasi.kki.go.id/idxcrd/039075.jpg";
            $contents = file_get_contents($url);
            $name = 'fotostr/testingurlbwjin.jpg';
            Storage::put($name, $contents);
            $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
            //$path = Storage::putFileAs('/fotostr', $contents, $name);
            
            //$path = Storage::putFileAs('/fotostr', base64_decode($image), $imageName);
            return response()->json(['success'=>true, 'message'=>'Berhasil Simpan Gambar', 'ext'=>$ext]);

        }catch(Exception $e) {

            
            return response()->json(['success'=>false, 'message'=>'Gagal Simpan Gambar']);

        }


    }

    public function getallin(){

        try{

            $thename = 'strs.png';
            $resulting = $this->model->getjadwalnak('31','1');
            $jadwaljson = json_encode($resulting);
            //$urlget = 'http://172.16.200.47:5003/convertandextract';
            $urlget = config('app.warehouse_host').'suratconvertengineuat/getdatane';
            $response = Http::asForm()->post($urlget, ['jadwal'=>$jadwaljson])->json();
            $data['dataextraction'] = $response;
            $data['success'] = true;
            return response()->json($data);
            //return redirect()->route('daftar.nakes')->with('alert', 'Data berhasil disimpan');

        }catch(Exception $e) {
            //$data['succees'] = false;
            $data['error'] = $e;
            return response()->json($data);

        }

    }

    public function getallindua(Request $request){
        
        $filenamec = $request->filenamenya;
        $urlget = 'http://172.16.200.28:3070/checkconnectbaru';
        $response = Http::post($urlget, ['filenamec'=>$filenamec])->body();
        $data['result'] = $response;
        $data['success'] = true;
        return response()->json($data);

    }

    public function profilingnakes(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mengambil Detail Faskes';
        $id_nakes = $request->id_nakes;

        $detail_pengaju = $this->model2->detailpengaju($id_nakes);
        $sejawat = $this->model2->getsejawat($id_nakes);
        $salinan1 = $this->model->pengajuanke($id_nakes, '1', 'current');
        $salinan2 = $this->model->pengajuanke($id_nakes, '2', 'current');
        $salinan3 = $this->model->pengajuanke($id_nakes, '3', 'current');
        $jadwal1 = $this->model->jadwalke($id_nakes, '1');
        $jadwal2 = $this->model->jadwalke($id_nakes, '2');
        $jadwal3 = $this->model->jadwalke($id_nakes, '3');
        $infonakes = $this->model2->getinfonakes($id_nakes);
        $data['sejarah1'] = $this->model->pengajuanke($id_nakes, '1', 'sejarah');
        $data['sejarah2'] = $this->model->pengajuanke($id_nakes, '2', 'sejarah');
        $data['sejarah3'] = $this->model->pengajuanke($id_nakes, '3', 'sejarah');

        
        if($detail_pengaju) {

            $data['success'] = true;
            $data['keterangan'] = 'Sukses Mengambil Detail Faskes';
            $data['detail_pengaju'] = $detail_pengaju;
            $data['sejawat'] = $this->model2->getsejawat($id_nakes);
            $data['salinan1'] = $salinan1;
            $data['salinan2'] = $salinan2;
            $data['salinan3'] = $salinan3;
            $data['jadwal1'] = $jadwal1;
            $data['jadwal2'] = $jadwal2;
            $data['jadwal3'] = $jadwal3;
            $data['infonakes'] = $infonakes;

        }

        return response()->json($data);
    }


    public function gethistoriasmanlist(Request $request)
    {
        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id_aut = Auth::user()->id;
        $userrole = Auth::user()->role;
        
       
        $list = $this->model3->get_datatables_historitinjau($userrole, $request);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pengajuan) {
            $ditahan = '-';

            if($pengajuan->perubahan == 0) {
                $jerapi = 'Pengajuan Awal';
            } else {
                $jerapi = 'Perubahan Ke '.$pengajuan->perubahan;
            }

            if($pengajuan->isFaskes == 1) {
                $nama_faskes = $pengajuan->nama_faskes;
                
            } else {
                $nama_faskes = 'Mandiri';
            }

            if($pengajuan->isApproved == '3') {

                $keterangan = '<br /><span class="badge badge-info">Pengajuan TTE</span>';

            } elseif ($pengajuan->isApproved == '4') {

                $keterangan = '<br /><span class="badge badge-success">TTE Selesai</span>';

            } elseif ($pengajuan->isApproved == '9') {

                $keterangan = '<br /><span class="badge badge-danger">Ditolak</span>';

            } elseif ($pengajuan->isApproved == 'CF') {

                $keterangan = '<br /><span class="badge badge-danger">Dicabut</span>';

            } else {
                $keterangan = '';
            }

            if($pengajuan->status_tte != 'Belum TTE'){
                $tte_stat = $this->help->tgl_indo_sip($pengajuan->status_tte);
            } else {
                $tte_stat = $pengajuan->status_tte;
            }

            if ($pengajuan->template_id == '2') {
                $ditahan = 'Belum Menyerahkan STR';

                if($pengajuan->isApproved == '4') {
                    if($pengajuan->ditahan == '1') {
                        $ditahan = 'Sudah Diserahkan';
                    } 
                }

            }
            

            $no++;
            $row = array();
            $row[] = $no;           
            $row[] = '<a class="toprofilingnakes" href="#historyapprovedptsp" data-id="'.$pengajuan->id_user.'">'.$pengajuan->name.'</a>';
            $row[] = $pengajuan->salinan;
            $row[] = $pengajuan->no_doc;
            $row[] = $nama_faskes;
            $row[] = $pengajuan->alamat_pengajuan;
            $row[] = $jerapi;
            //$row[] = $surat->pengirim_surat;
            $row[] = $pengajuan->created_at;
            $row[] = $tte_stat;
            $row[] = $ditahan;
            $row[] = '<a class="btn btn-sm btn-primary viewdetailpengajuan" data-id = "'.$pengajuan->id.'" href="">Detail</a>'.$keterangan;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model3->count_all($userrole, $request),
            "recordsFiltered" => $this->model3->count_filtered($userrole, $request),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
        
    }


    public function gethistoryapprovenakes(Request $request)
    {
        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id_aut = Auth::user()->id;
        $userrole = Auth::user()->role;
       
        $list = $this->model3->get_datatables_historiapproveuser($userrole, $request);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pendaftaran) {

            $addfile = '';
            if ($pendaftaran->current_status == 0) {
                $button_aksi = '<div class="btn-group"><button class="btn btn-xs btn-success activatenakes" data-toggle="tooltip" data-placement="top" title="Lihat Pendaftar" id="'.$pendaftaran->id.'" data-file="'.$pendaftaran->origin_file.'" data-url="'.$pendaftaran->url_qr.'" data-nama="'.$pendaftaran->nama.'" data-str="'.$pendaftaran->no_reg.'" data-email="'.$pendaftaran->email.'" data-foto = "'.$pendaftaran->img_src.'" data-salinan="'.$pendaftaran->salinan.'" data-kompetensi="'.$pendaftaran->kompetensi.'" data-profesi="'.$pendaftaran->profesi.'" data-tglstr = "'.$pendaftaran->tgl_keluar_str.'" data-univ=".'.$pendaftaran->universitas.'"><i class="fas fa-check"></i></button><button class="btn btn-xs btn-warning editdetailnakes" data-toggle="tooltip" data-placement="top" title="Edit Data" id="'.$pendaftaran->id.'" data-email="'.$pendaftaran->email.'" data-notelp="'.$pendaftaran->notelp.'" data-nama="'.$pendaftaran->nama.'"><i class="fas fa-edit"></i></button>
                <button class="btn btn-xs btn-info resetnakespass" data-toggle="tooltip" data-placement="top" title="Reset Password" data-id="'.$pendaftaran->id_user.'" data-nama="'.$pendaftaran->nama.'" data-notelp="'.$pendaftaran->notelp.'"><i class="fas fa-sync-alt"></i></button></div>';
            } else {
                $button_aksi = '<div class="btn-group"><button class="btn btn-xs btn-success intipnakes" data-toggle="tooltip" data-placement="top" title="Lihat Pendaftar" id="'.$pendaftaran->id.'" data-file="'.$pendaftaran->origin_file.'" data-url="'.$pendaftaran->url_qr.'" data-nama="'.$pendaftaran->nama.'" data-str="'.$pendaftaran->no_reg.'" data-email="'.$pendaftaran->email.'" data-statdoc="'.$pendaftaran->doc_status.'" data-foto = "'.$pendaftaran->img_src.'" data-salinan="'.$pendaftaran->salinan.'" data-kompetensi="'.$pendaftaran->kompetensi.'" data-profesi="'.$pendaftaran->profesi.'" data-tglstr = "'.$pendaftaran->tgl_keluar_str.'" data-univ=".'.$pendaftaran->universitas.'"><i class="fas fa-eye"></i></button><button class="btn btn-xs btn-warning editdetailnakes" data-toggle="tooltip" data-placement="top" title="Edit Data" id="'.$pendaftaran->id.'" data-email="'.$pendaftaran->email.'" data-notelp="'.$pendaftaran->notelp.'" data-nama="'.$pendaftaran->nama.'"><i class="fas fa-edit"></i></button>
                <button class="btn btn-xs btn-info resetnakespass" data-toggle="tooltip" data-placement="top" title="Reset Password" data-id="'.$pendaftaran->id_user.'" data-nama="'.$pendaftaran->nama.'" data-notelp="'.$pendaftaran->notelp.'"><i class="fas fa-sync-alt"></i></button></div>';
            }
            
            if ($pendaftaran->origin_file != 'scanned') {
                $addfile = '&nbsp; &nbsp;<a href="https://esip.cilacapkab.go.id/getoriginstr/'.$pendaftaran->origin_file.'.pdf" target="_blank"><i class="fas fa-file"></i></a>';
            }

            if($pendaftaran->img_src != null && $pendaftaran->foto_not_avail !== '1') {
                $foto = '<a href="#tblpendaftarhist" id="'.$pendaftaran->id.'" class="changepp" data-nama="'.$pendaftaran->nama.'"><img src="'.$pendaftaran->img_src.'" width="50px" alt="user image"></a>';
            } elseif ($pendaftaran->foto_not_avail == '1'){
                $foto = '<a href="#tblpendaftarhist" id="'.$pendaftaran->id.'" class="changepp" data-nama="'.$pendaftaran->nama.'"><img src="https://esip.cilacapkab.go.id/storagefoto/'.$pendaftaran->saved_photo.'" width="50px" alt="user image"></a>';
            } else {
                $foto = '<a href="#tblpendaftarhist" id="'.$pendaftaran->id.'" class="changepp" data-nama="'.$pendaftaran->nama.'"><img src="https://esip.cilacapkab.go.id/storagefoto/'.$pendaftaran->saved_photo.'" width="50px" alt="user image"></a>';
            }
                            
            $no++;
            $row = array();
            $row[] = $no;           
            $row[] = $foto;
            $row[] = $pendaftaran->nama;
            $row[] = $pendaftaran->no_reg.$addfile;
            $row[] = $pendaftaran->salinan;
            $row[] = $pendaftaran->kompetensi;
            $row[] = $pendaftaran->str_hingga;
            $row[] = $pendaftaran->email;
            $row[] = $pendaftaran->notelp;
            $row[] = $button_aksi;
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->model3->count_all_happuser($userrole, $request),
                        "recordsFiltered" => $this->model3->count_filtered_happuser($userrole, $request),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
        
    }


    public function gethistoriasmanlistmanual(Request $request)
    {
        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id_aut = Auth::user()->id;
        $userrole = Auth::user()->role;
       
        $list = $this->model3->get_datatables_historitinjaumanual($userrole, $request);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pengajuan) {

          
            if($pengajuan->isFaskes == 1) {
                $nama_faskes = $pengajuan->nama_faskes;
                
            } else {
                $nama_faskes = 'Mandiri';
            }

            if($pengajuan->isApproved == '3') {

                $keterangan = '<br /><span class="badge badge-info">Menunggu</span>';

            } elseif ($pengajuan->isApproved == '4') {

                $keterangan = '<br /><span class="badge badge-success">Disetujui</span>';

            } elseif ($pengajuan->isApproved == '9') {

                $keterangan = '<br /><span class="badge badge-danger">Ditolak</span>';

            } elseif ($pengajuan->isApproved == 'CF') {

                $keterangan = '<br /><span class="badge badge-danger">Dicabut</span>';

            } else {
                $keterangan = '';
            }

        

            $no++;
            $row = array();
            $row[] = $no;           
            $row[] = '<a class="toprofilingnakes" href="#historyapprovedptspsipmanual" data-id="'.$pengajuan->id_nakes.'">'.$pengajuan->name.'</a>';
            $row[] = $pengajuan->salinan;
            $row[] = $pengajuan->no_sip;
            $row[] = $nama_faskes;
            $row[] = $pengajuan->alamat_pengajuan;
            $row[] = $pengajuan->created_at;
            $row[] = '<a class="btn btn-sm btn-primary viewdetailpengajuan" data-id = "M'.$pengajuan->id.'" href="">Detail</a>'.$keterangan;
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->model3->count_allm($userrole, $request),
                        "recordsFiltered" => $this->model3->count_filteredm($userrole, $request),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
        
    }

    public function submitdraftkadinkes(Request $request)
    {
        $id_pengajuan = $request->id_pengajuan;
        $id_nakes = $request->id_nakes;
        $salinan = $request->salinan;
        $nikkadinkes = $this->model->getnikkadinkes();
        $template_id = 'sk';

        $nik = $nikkadinkes->nik;

        //$result1 = $this->makedraftsk($data);
        $surathost = config('app.surat_host').'assets/uploads/maker/draft/';
        $ttehost = config('app.surat_host').'CsubmitRekomNakes/getttedinkes';

        $data['isExist'] = 0;
        $data['surathost'] = $surathost;
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Memproses Draft Surat Keterangan Dinkes';

        try{
            $datatte_ = Http::get($ttehost);
            $datatte_status = $datatte_->status();
            if ($datatte_status == 200) {
                $tte = $datatte_->json();
                $nama_tte = $tte[0]['nama_tte'];
                $pangkat_tte = $tte[0]['pangkat_tte'];
                $isplt = $tte[0]['isplt'];
                $nip_tte = $tte[0]['nip_tte'];
                $nik_tte = $tte[0]['nik'];
                if($nik !== $nik_tte) {
                    $data['hasilnya'] = 'Nik Tidak Sesuai Dengan ASOKA, Silahkan Cek dan Update';
                } else {

                    $datadrafter = $this->model->draftingSk($id_pengajuan, $nip_tte, $isplt, $nama_tte, $pangkat_tte, $template_id, '', $nik);

                    $draftsk = $this->model->submitdraftsk($datadrafter);
                    $newData = $this->renamedataset($datadrafter);
                    $generatedraftsk = $this->generateDraftSK($newData);
                    $thefilename = $newData['filename_sip'];

                    $hasildraft = $generatedraftsk->json();
                    $status_draft = $generatedraftsk->status();

                    if ($status_draft == 200) {

                        $sendtoasoka = $this->draftdinkestoasoka($datadrafter);
                        $hasilasoka = $sendtoasoka->json();
                        $status_asoka = $sendtoasoka->status();

                        if($status_asoka == 200) {

                            $data['resultdraft'] = $hasildraft;
                            $data['success'] = true;
                            $data['keterangan'] = 'Berhasil Memproses Draft Surat Keterangan Dinkes';
                            $data['filename'] = $thefilename;
                            $data['filenamec'] = $thefilename.'.pdf';
                            $data['nik'] = $nik_tte;

                        } else {

                            $data['response_asoka'] = $status_asoka;
                            $data['keterangan'] = $sendtoasoka->body();

                        }
                        

                    } else {
                        $data['response_draft'] = $status_draft;
                        $data['keterangan'] = $generatedraftsk->body();
            
                    }
                    
                }
                
            } else {
                $data['hasilnya'] = 'Gagal Mengambil Data TTE dari ASOKA';
            }
            
            
            return response()->json($data);
            
            //return redirect()->route('daftar.nakes')->with('alert', 'Data berhasil disimpan');

        }catch(Exception $e) {
            //$data['succees'] = false;
            $data['error'] = $e;
            return response()->json($data);

        }

    }

    private function generateDraftSK($datadrafter){

        $thefile = fopen('../storage/app/fotostr/dummy.jpg','r');
        $urlget = config('app.conv_host').'draftrekomnakes';
        $response_ = Http::attach('filefoto', $thefile, 'dummy.jpg')->post($urlget, $datadrafter);
        return $response_;

    }

    public function renamedataset($data)
    {
        // Check if 'filename_sk' key exists in the array
        if (array_key_exists('filename_sk', $data)) {
            // Replace 'filename_sk' with 'filename_sip'
            $data = array_replace($data, ['filename_sip' => $data['filename_sk']]);
            unset($data['filename_sk']); // Remove the old key
        }

        return $data;
    }

    public function submitttekadinkes(Request $request) 
    {
        $data['success'] = false;
        $data['keterangan'] = "Proses TTE Surat Keterangan Dinas Kesehatan Berhasil";
        $nik = $request->nik_tte;
        $passphrase = $request->passphrase;
        $filename_sip = $request->filename_tte;
        $datatte = [
            'nik' => $nik,
            'passphrase' => $passphrase,
            'filename_sip' => $filename_sip
        ];
        $urlget = config('app.surat_host').'CsubmitRekomNakes/submitTteDinkes';
        $response_ = Http::asForm()->post($urlget, $datatte);
        $hasiltte = $response_->json();
        $status_tte = $response_->status();
        

        if ($status_tte == 200) {

            $tte_status = $hasiltte['status'];
            if($tte_status == 'done') {

                $datasktte = $hasiltte['detailtte'];
                $updatesk = $this->model3->updatestatussipdinkes($datasktte);
                if($updatesk) {
                    $data['result'] = $hasiltte;
                    $data['success'] = true;
                    $data['keterangan'] = 'Berhasil Memproses TTE Surat Keterangan Tempat Praktik Dinkes';
                } else {
                    $data['keterangan'] = 'Proses TTE Berhasil, Namum Data Pengajuan Gagal Diupdate, Silahkan Lakukan Sinkronisasi';
                }

            } else {
                $data['keterangan'] = $hasiltte['keterangan'];
            }

        } else {

            $data['response_tte'] = $status_tte;
            $data['keterangan'] = $response_->body();

        }
        return $data;

    }

    public function draftdinkestoasoka($datadrafter){

        $urlget = config('app.surat_host').'CsubmitRekomNakes/submitRekomDinkes';

        $response_ = Http::asForm()->post($urlget, $datadrafter);
        return $response_;

    }

    public function bidfardashboard()
    {

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['pengajuan'] = $this->model->getpengajuan('normal');

        return view('dinkes/bidfardashboard', $data);

    }

}
