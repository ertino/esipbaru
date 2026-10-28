<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminModel;
use App\Models\DinkesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;
use App\Helpers\GeoHelper;
use Carbon\Carbon;
use Smalot\PdfParser\Parser;

use App\Helpers\Help;

class AdminController extends Controller
{
    /** @var AdminModel */
    protected $model;

    /** @var DinkesModel */
    protected $model2;

    /** @var Help */
    protected $help;

    public function __construct(){
        $this->model = new AdminModel;
        $this->model2 = new DinkesModel;
        $this->help = new Help;
    }

    public function index(){
        //
        return view('welcome');
    
    }

    // public function sendnotifwa($nomor,$pesan){

        
    //     $sender = config('app.no_ptsp');
    //     $urlget = config('app.wa_host');
    //     $response = Http::post($urlget, ['sender'=>$sender, 'number' => $nomor, 'message' => $pesan]);
    //     if ($response->failed()) {
    //         return true;
    //     } else {
    //         return true;
    //     }
    // }

    public function sendnotifwa($nomor,$pesan){

        $this->model->logNotifWA($nomor, $pesan);

        if (substr($nomor, 0, 1) === '0') {
            $nomor = '62' . substr($nomor, 1);
        }

        $curl = curl_init();
        $token = "YxcxIb2zC8iRHGft5XoKgLHzRcNj3edQW92Fqt1yXoOsI987ctmrEb7pApWIIevR.9tMYXSm7";
        $data = [
            'phone' => $nomor,
            'message' => $pesan,
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL,  "https://jogja.wablas.com/api/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;


    }

    public function sendnotifwasp($nomor, $pesan)
    {
        if (substr($nomor, 0, 1) === '0') {
            $nomor = '62' . substr($nomor, 1);
        }

        $curl = curl_init();
        $token = "YxcxIb2zC8iRHGft5XoKgLHzRcNj3edQW92Fqt1yXoOsI987ctmrEb7pApWIIevR.9tMYXSm7";
        $data = [
            'phone' => $nomor,
            'message' => $pesan,
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL,  "https://jogja.wablas.com/api/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $body = curl_exec($curl);
        // Capture HTTP status code before closing cURL
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Capture cURL-level errors, if any
        $curlError = curl_error($curl);
        $curlErrno = curl_errno($curl);

        curl_close($curl);

        return [
            'http_status' => $statusCode,
            'success'     => $curlErrno === 0
                            && $statusCode >= 200
                            && $statusCode < 300,
            'body'        => $body,
            'curl_error'  => $curlErrno ? $curlError : null,
        ];

    }


    

    // public function sendnotifwareturn($nomor,$pesan){

        
    //     $sender = config('app.no_ptsp');
    //     $urlget = config('app.wa_host');
    //     $response = Http::post($urlget, ['sender'=>$sender, 'number' => $nomor, 'message' => $pesan]);
    //     $request_status = $response->status();
    //     if ($response->failed()) {
    //         return false;
    //     } else {
    //         if ($request_status == '200' || $request_status == '201') {
    //             $responses = $response->throw()->json();
    //             $billing_status = $responses['status'];
    //             if($billing_status == 'true') {
    //                 return true;
    //             } else {
    //                 return false;
    //             }
    //         } else {
    //             return false;
    //         }
            
    //     }
    // }

    public function sendnotifwareturn($nomor,$pesan){

        
        if (substr($nomor, 0, 1) === '0') {
            $nomor = '62' . substr($nomor, 1);
        }

        $curl = curl_init();
        $token = "YxcxIb2zC8iRHGft5XoKgLHzRcNj3edQW92Fqt1yXoOsI987ctmrEb7pApWIIevR.9tMYXSm7";
        $data = [
            'phone' => $nomor,
            'message' => $pesan,
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL,  "https://jogja.wablas.com/api/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
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

    public function random_string($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
    
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
    
        return $key;
    }

    public function info(){
        //
        echo phpinfo();
    }

    
    

    public function dashboard(){

        $this->model->setloglogin(Auth::user()->id);
        
        if(Auth::user()->role == 'nakes'){
            return redirect()->route('nakes.dashboard');
            // Auth::logout();
            // request()->session()->invalidate();
            // request()->session()->regenerateToken();
            // return redirect('/'); 
            
        } else if (Auth::user()->role == 'executive') {
            return redirect()->route('executive.dashboard');
        }else if(Auth::user()->role == 'admin'){
            return redirect()->route('admin.main.dashboard');
        }else if(Auth::user()->role == 'adminnakes') {
            return redirect()->route('adminnakes.main.dashboard');
        }else if(Auth::user()->role == 'admindinkes'){
            return redirect()->route('admindinkes.main.dashboard');
        }else if(Auth::user()->role == 'adminptsp') {
            return redirect()->route('adminptsp.main.dashboard');
        }else if(Auth::user()->role == 'op') {
            return redirect()->route('op.main.dashboard');
        }else if (Auth::user()->role == 'faskes') {
            return redirect()->route('faskes.main.dashboard');
        }else if (Auth::user()->role == 'kadinkes') {
            return redirect()->route('kadinkes.main.dashboard');
        }else if (Auth::user()->role == 'verifptsp') {
            return redirect()->route('verif.main.dashboard');
        }else if (Auth::user()->role == 'kaptsp') {
            return redirect()->route('kaptsp.main.dashboard');
        }else if (Auth::user()->role == 'bidfarmasidinkes') {
            return redirect()->route('bidfar.main.dashboard');
        }else if (Auth::user()->role == 'superadmin') {
            return redirect()->route('superadmin.dashboard');
        }

    }


    
    public function uploadtest(Request $request){

        $data['role'] = Auth::user()->role;
        $id = Auth::user()->id;
        $data['user_id'] = $id;

        $data['listApp'] = $this->model->getlistApp('all');
        $data['listPIC'] = $this->model->getlistPIC();
        $data['listIntegrasi'] = $this->model->getIntegration();
        $data['listProg'] = $this->model->getlistProg();
        $data['listActivity'] = $this->model->getTimeline();
        $data['listServis'] = $this->model->getlistService();
        $thefile = $request->file('filekpcpn');
        $path = Storage::putFileAs('/filekpcpn', $thefile, 'filekpcpn.csv');

        return response()->json(['success'=>'Successfully uploaded.']);

    }

    public function superadmindashboard(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $data['role'] = Auth::user()->role;
        $nama = Auth::user()->name;
        $id = Auth::user()->id;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;


        return view('superadmin/superadmindashboard', $data);
        
    }

    public function superdetailnakes($id_nakes){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $data['role'] = Auth::user()->role;
        $role = Auth::user()->role;
        $nama = Auth::user()->name;
        $id = Auth::user()->id;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['id_nakes'] = $id_nakes;
        if($role != 'superadmin')
        {
            return redirect()->route('dashboard');
        }


        return view('superadmin/superdetailnakes', $data);
        
    }

    


    public function adminnakesdashboard(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $data['role'] = Auth::user()->role;
        $nama = Auth::user()->name;
        $id = Auth::user()->id;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;


        return view('adminnakesdashboard', $data);
        
    }

    
    public function ptspdashboard(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $tglcoba = '2022-01-10 02:01:00';
        $bedanya = $this->help->standardiff($tglcoba);
        $data['bedaken'] = $bedanya;
        $data['pengajuan'] = $this->model->getpengajuan('normal');
        $data['perubahan'] = $this->model->getpengajuan('perubahan');

        return view('ptsp/adminptspdashboard', $data);
        
    }

    public function verifdashboard(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $tglcoba = '2022-01-10 02:01:00';
        $bedanya = $this->help->standardiff($tglcoba);
        $data['bedaken'] = $bedanya;
        $data['pengajuan'] = $this->model->getpengajuan('verif');
        $data['perubahan'] = $this->model->getpengajuan('perubahan');

        return view('ptsp/verifptspdashboard', $data);

    }

    public function kaptspdashboard(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $tglcoba = '2022-01-10 02:01:00';
        $bedanya = $this->help->standardiff($tglcoba);
        $data['bedaken'] = $bedanya;
        $data['pengajuan'] = $this->model->getpengajuan('kadin');
        $data['pencabutan'] = $this->model->getpengajuan('kadincabut'); 
        $data['perubahan'] = $this->model->getpengajuan('perubahan');

        return view('ptsp/verifptspdashboard', $data);

    }

    
    public function adminnakespemohon(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $data['role'] = Auth::user()->role;
        $nama = Auth::user()->name;
        $id = Auth::user()->id;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;


        return view('adminnakespemohon', $data);
        
    }

    public function ptspmanagefaskes(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $tglcoba = '2022-01-10 02:01:00';
        $bedanya = $this->help->standardiff($tglcoba);
        $data['bedaken'] = $bedanya;
        $data['pengajuan'] = $this->model->getpengajuan('normal');
        $data['allfaskes'] = $this->model->getallfaskes();

        return view('ptsp/adminptspfaskes', $data);
        
    }

    public function adminpengajuansipmanual(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $tglcoba = '2022-01-10 02:01:00';
        $bedanya = $this->help->standardiff($tglcoba);
        $data['bedaken'] = $bedanya;
        $data['pengajuan'] = $this->model->getpengajuan('sipmanual');

        return view('dashboardpengajuansipmanual', $data);
        
    }

    public function approvepersetujuan(Request $request){

        $setstatus = $request->tSetStatus;
        $therole = Auth::user()->role;
        $id_pengajuan = $request->tid_pengajuan;
        $no_doc_dinkes = $request->stNoDocDinkes;
        $tgl_doc_dinkes = $request->stTglDocDinkes;
        $salinan = $request->tSalinanKe;
        $user_id = $request->tid_nakes;
        $updater = $request->tUser_id;
        $tglapp = date('Y-m-d');
        $tgl_app_dinkes = $this->help->tgl_indo_sip($tglapp);

        $getnowa = DB::table('tbl_pendaftaran')
            ->select('notelp','nama')
            ->where('id_user', $user_id)
            ->first();
        
        $getisfaskes = DB::table('tbl_pengajuan')
            ->select('isFaskes')
            ->where('id', $id_pengajuan)
            ->first();

        $nama_nakes = $getnowa->nama;
        $isFaskes = $getisfaskes->isFaskes;

        if ($setstatus == '2') {

            if($request->hasFile('tFileDocDinkes')){

                $request->validate([
                    'tFileDocDinkes' => 'file|mimes:pdf|max:5120',
                ]);

                $jenis_doc = 'REKOMDK'.$salinan;
                
                
                $thefile = $request->file('tFileDocDinkes');
                $extension = $request->file('tFileDocDinkes')->extension();
                $filenamenya = $jenis_doc.'_'.$user_id;
            
    
                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.pdf');
                $namafile = $filenamenya.'.pdf';
    
    
                $nama_doc = 'Rekomendasi Dinas Kesehatan';
                $no_doc = $no_doc_dinkes;
                $tgl_doc_ori = $tgl_doc_dinkes;
                if($tgl_doc_ori != '') {
                    $tgl_doc = $this->help->tgl_indo_sip($tgl_doc_ori);
                } else {
                    $tgl_doc = $tgl_doc_ori;
                }
                $tgl_berlaku = date('Y-m-d');
                $tgl_berlaku_ori = $tgl_berlaku;
                $remark1 = '';
    
                try{
    
                    $this->model->tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $updater, $tgl_doc_ori, $tgl_berlaku_ori);
                    
    
                }catch(Exception $e) {
    
                    
                    if ($therole == 'admindinkes') {
                        return redirect()->route('admindinkes.main.dashboard')->with('alert', '9Gagal Menambah Dokumen, Silahkan Coba Lagi');
                    } else if ($therole == 'adminptsp') {
                        return redirect()->route('nakes.documents')->with('alert', '9Gagal Menambah Dokumen, Silahkan Coba Beberapa Saat Lagi');
                    }
    
                }
                
                
    
            }

            if($request->hasFile('tFileVisitasi')){

                $request->validate([
                    'tFileVisitasi' => 'file|mimes:pdf|max:5120',
                ]);

                $jenis_doc = 'BAV'.$salinan;
                $user_id = $request->tid_nakes;
                $updater = $request->tUser_id;
                
                $thefile = $request->file('tFileVisitasi');
                $extension = $request->file('tFileVisitasi')->extension();
                $filenamenya = $jenis_doc.'_'.$user_id;
            
    
                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.pdf');
                $namafile = $filenamenya.'.pdf';
    
                
                
    
                $nama_doc = 'Berita Acara Visitasi Salinan'.$salinan;
                $no_doc = '';
                $tgl_doc = date('Y-m-d');
                $tgl_doc_ori = $tgl_doc;
                $tgl_berlaku = date('Y-m-d');
                $tgl_berlaku_ori = $tgl_berlaku;
                $remark1 = '';
    
                try{

                    if($isFaskes == '0'){
                        $setstatus = '1K';
                    }
    
                    $this->model->tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $updater, $tgl_doc_ori, $tgl_berlaku_ori);
                    $this->model->updatestatuspengajuan($id_pengajuan, $updater, $setstatus, 'Disetujui Dinkes',$tgl_app_dinkes);
                    $pesanadmin = 'Pengajuan Atas Nama: '.$nama_nakes.' Sudah Diterima Dan Disetujui Oleh Dinkes dan akan Direview Oleh DPMPTSP \n Silahkan Check Pada Aplikasi e-SIP.';
                    $nomorwa = $this->model->getnomorwa($user_id);
                    if($nomorwa) {
                        $this->sendnotifwa($nomorwa, $pesanadmin);
                    }
                    
                    $this->model->updatePesan('admin', '1', $pesanadmin, $user_id);
                    
                    if ($therole == 'admindinkes') {
                        return redirect()->route('admindinkes.main.dashboard')->with('alert', '1Berhasil Approve Pengajuan');
                    } else if ($therole == 'adminptsp') {
                        return redirect()->route('nakes.documents')->with('alert', '1Berhasil Approve Pengajuan');
                    }
                    
    
                }catch(Exception $e) {
    
                    
                    if ($therole == 'admindinkes') {
                        return redirect()->route('admindinkes.main.dashboard')->with('alert', '9Gagal Approve Pengajuan, Silahkan Coba Kembali');
                    } else if ($therole == 'adminptsp') {
                        return redirect()->route('nakes.documents')->with('alert', '9Gagal Approve Pengajuan, SIlahkan Coba Kembali');
                    }
    
                }

            
            } else {
                $this->model->updatestatuspengajuan($id_pengajuan, $updater, $setstatus, 'Disetujui Dinkes', $tgl_app_dinkes);
                $pesanadmin = 'Pengajuan Atas Nama: '.$nama_nakes.' Sudah Diterima Dan Disetujui Oleh Dinkes dan akan Direview Oleh DPMPTSP \n Silahkan Check Pada Aplikasi e-SIP.';
                $this->model->updatePesan('admin', '1', $pesanadmin, $user_id);
                $nomorwa = $this->model->getnomorwa($user_id);
                if($nomorwa) {
                    $this->sendnotifwa($nomorwa, $pesanadmin);
                }
                if ($therole == 'admindinkes') {
                    return redirect()->route('admindinkes.main.dashboard')->with('alert', '1Berhasil Approve Pengajuan');
                } else if ($therole == 'adminptsp') {
                    return redirect()->route('nakes.documents')->with('alert', '1Berhasil Approve Pengajuan');
                }
            }

        } else if ($setstatus == '1K') {

            try{

                $this->model->updatestatuspengajuan($id_pengajuan, $updater, $setstatus, 'Disetujui Dinkes',$tgl_app_dinkes);
                $pesanadmin = 'Pengajuan Atas Nama: '.$nama_nakes.' Sudah Diterima Dan Disetujui Oleh Dinkes dan akan Direview Untuk Rekomendasi Kepala Dinas Kesehatan. Silahkan Check Pada Aplikasi e-SIP.';
                $nomorwa = $this->model->getnomorwa($user_id);
                if($nomorwa) {
                    $this->sendnotifwa($nomorwa, $pesanadmin);
                }
                
                $this->model->updatePesan('admin', '1', $pesanadmin, $user_id);
                
                if ($therole == 'admindinkes') {
                    return redirect()->route('admindinkes.main.dashboard')->with('alert', '1Berhasil Approve Pengajuan');
                } else if ($therole == 'adminptsp') {
                    return redirect()->route('nakes.documents')->with('alert', '1Berhasil Approve Pengajuan');
                }
                

            }catch(Exception $e) {

                
                if ($therole == 'admindinkes') {
                    return redirect()->route('admindinkes.main.dashboard')->with('alert', '9Gagal Approve Pengajuan, Silahkan Coba Kembali');
                } else if ($therole == 'adminptsp') {
                    return redirect()->route('nakes.documents')->with('alert', '9Gagal Approve Pengajuan, SIlahkan Coba Kembali');
                }

            }

        } else {


            if($request->hasFile('tFileDocDPMPTSP')){

                $request->validate([
                    'tFileDocDPMPTSP' => 'file|mimes:pdf|max:5120',
                ]);

                $jenis_doc = 'REKPTSP';
                $user_id = $request->tid_nakes;
                $updater = $request->tUser_id;
                
                $thefile = $request->file('tFileDocDPMPTSP');
                $extension = $request->file('tFileDocDPMPTSP')->extension();
                $filenamenya = $jenis_doc.'_'.$user_id;
            
    
                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.pdf');
                $namafile = $filenamenya.'.pdf';
    
                
                
    
                $nama_doc = 'Rekomendasi DPMPTSP';
                $no_doc = '';
                $tgl_doc = date('Y-m-d');
                $tgl_berlaku = date('Y-m-d');
                $remark1 = '';
    
                try{
    
                    $this->model->tambahDoc($jenis_doc, $user_id, $namafile, $nama_doc, $no_doc, $tgl_doc, $tgl_berlaku, $remark1, $updater, $tgl_doc, $tgl_berlaku);
                    $this->model->updatestatuspengajuan($id_pengajuan, $updater, $setstatus, 'Disetujui DPMPTSP','');
                    $pesanadmin = 'Pengajuan Atas Nama: '.$nama_nakes.' Sudah Diterima Dan Disetujui Oleh DPMPTSP. Silahkan Check Pada Aplikasi e-SIP.';
                    //$this->model->updatePesan('admin', '1', $pesanadmin, $user_id);
                    $nomorwa = $this->model->getnomorwa($user_id);
                    if($nomorwa) {
                        $this->sendnotifwa($nomorwa, $pesanadmin);
                    }

                    if ($therole == 'admindinkes') {
                        return redirect()->route('admindinkes.main.dashboard')->with('alert', '1Berhasil Approve Pengajuan');
                    } else if ($therole == 'adminptsp') {
                        return redirect()->route('adminptsp.main.dashboard')->with('alert', '1Berhasil Approve Pengajuan');
                    }
                    
    
                }catch(Exception $e) {
    
                    
                    if ($therole == 'admindinkes') {
                        return redirect()->route('admindinkes.main.dashboard')->with('alert', '9Gagal Approve Pengajuan, Silahkan Coba Lagi');
                    } else if ($therole == 'adminptsp') {
                        return redirect()->route('adminptsp.main.dashboard')->with('alert', '9Gagal Approve Pengajuan, Silahkan Coba Lagi');
                    }
    
                }
            }
        }
    }


    public function tolakpengajuan(Request $request) {

        $user_id = $request->tid_nakes;
        $updater = $request->tUser_id;
        $therole = Auth::user()->role;
        $updater = $request->tUser_id;
        $id_pengajuan = $request->tid_pengajuan;
        $salinan = $request->tolak_salinan;
        $issipmanual = $this->model->issipmanual($user_id, $salinan);
        if($issipmanual == 0) {

            $setstatus = 9;
            $keteranganpenolakan = '';
            $isuniversal = 0;

            $getnowa = DB::table('tbl_pendaftaran')
                ->select('notelp','nama')
                ->where('id_user', $user_id)
                ->first();
            $nama_nakes = $getnowa->nama;

            $nama_pengupdate = '';    
            $getuser = DB::table('users')
                ->select('name')
                ->where('id', $updater)
                ->first();
            if($getuser) {
                $nama_pengupdate = $getuser->name;
            }

            $issueKTP = $request->isRejKTP;
            $keteranganKTP = $request->rejKeteranganKTP;
            if($issueKTP == '1') {
                $this->model->updatetolakdoc('KTP', $user_id, $keteranganKTP);
                if($keteranganpenolakan == '') {
                    $keteranganpenolakan = 'Dokumen KTP';
                }
                $isuniversal = $isuniversal + 1;
            }

            $issueSTR = $request->isRejSTR;
            $keteranganSTR = $request->rejKeteranganSTR;
            if($issueSTR == '1') {
                $this->model->updatetolakdoc('STR'.$salinan, $user_id, $keteranganSTR);
                if($keteranganpenolakan == '') {
                    $keteranganpenolakan = 'Dokumen STR';
                } else {
                    $keteranganpenolakan = $keteranganpenolakan.', Dokumen STR';
                }
                $isuniversal = $isuniversal + 1;
            }

            $issueIjazah = $request->isRejIJAZAH;
            $keteranganIjazah = $request->rejKeteranganIjazah;
            if($issueIjazah == '1') {
                $this->model->updatetolakdoc('IJAZAH', $user_id, $keteranganIjazah);
                if($keteranganpenolakan == '') {
                    $keteranganpenolakan = 'Dokumen IJAZAH';
                } else {
                    $keteranganpenolakan = $keteranganpenolakan.', Dokumen IJAZAH';
                }
                $isuniversal = $isuniversal + 1;
            }

            
            $issueFoto = $request->isRejFOTO;
            $keteranganFoto = $request->rejKeteranganFoto;
            if($issueFoto == '1') {
                $this->model->updatetolakdoc('FOTO', $user_id, $keteranganFoto);
                if($keteranganpenolakan == '') {
                    $keteranganpenolakan = 'Dokumen FOTO';
                } else {
                    $keteranganpenolakan = $keteranganpenolakan.', Dokumen FOTO';
                }
                $isuniversal = $isuniversal + 1;
            }

            $issueSKP = $request->isRejSKP;
            $keteranganSKP = $request->rejKeteranganSKP;
            if($issueSKP == '1') {
                $this->model->updatetolakdoc('SKP'.$salinan, $user_id, $keteranganSKP);
                if($keteranganpenolakan == '') {
                    $keteranganpenolakan = 'Dokumen Surat Keterangan Pimpinan';
                } else {
                    $keteranganpenolakan = $keteranganpenolakan.', Dokumen Surat Keterangan Pimpinan';
                }
            }

            $issueSKS = $request->isRejSKS;
            $keteranganSKS = $request->rejKeteranganSKS;
            if($issueSKS == '1') {
                $this->model->updatetolakdoc('SKS'.$salinan, $user_id, $keteranganSKS);
                if($keteranganpenolakan == '') {
                    $keteranganpenolakan = 'Dokumen Surat Keterangan Sehat';
                } else {
                    $keteranganpenolakan = $keteranganpenolakan.', Dokumen Surat Keterangan Sehat';
                }
            }

            $issuerekomp = $request->isRejRPROF;
            $keteranganrekomp = $request->rejKeteranganRekomProv;
            if($issuerekomp == '1') {
                $this->model->updatetolakdoc('REKOMP'.$salinan, $user_id, $keteranganrekomp);
                if($keteranganpenolakan == '') {
                    $keteranganpenolakan = 'Dokumen Rekomendasi Profesi';
                } else {
                    $keteranganpenolakan = $keteranganpenolakan.', Dokumen Rekomendasi Profesi';
                }
            }

            $issueSTP = $request->isRejSTP;
            $keteranganSTP = $request->rejKeteranganSTP;
            if($issueSTP == '1') {
                $this->model->updatetolakdoc('SPTP'.$salinan, $user_id, $keteranganSTP);
                if($keteranganpenolakan == '') {
                    $keteranganpenolakan = 'Dokumen Surat Pernyataan Tempat Praktik';
                } else {
                    $keteranganpenolakan = $keteranganpenolakan.', Dokumen Surat Pernyataan Tempat Praktik';
                }
            }

            $issueSKSKP = $request->isRejSKSKP;
            $keteranganSKSKP = $request->rejKeteranganSKSKP;
            if($issueSKSKP == '1') {
                $this->model->updatetolakdoc('SKSKP'.$salinan, $user_id, $keteranganSKSKP);
                if($keteranganpenolakan == '') {
                    $keteranganpenolakan = 'Dokumen Serkom / SKP';
                } else {
                    $keteranganpenolakan = $keteranganpenolakan.', Dokumen Serkom / SKP';
                }
            }

            $issueSKTP = $request->isRejSKTP;
            $keteranganSKTP = $request->rejKeteranganSKTP;
            if($issueSKTP == '1') {
                $this->model->updatetolakdoc('SKTP'.$salinan, $user_id, $keteranganSKTP);
                if($keteranganpenolakan == '') {
                    $keteranganpenolakan = 'Dokumen Surat Keterangan Permohonan Tempat Praktik';
                } else {
                    $keteranganpenolakan = $keteranganpenolakan.', Dokumen Surat Keterangan Permohonan Tempat Praktik';
                }
            }

            $issuejadwal = $request->isRejjadwalF;
            $keteranganjadwal = $request->rejKeteranganJadwal;
            if($issuejadwal == '1') {
                $this->model->tolakjadwal($user_id, $salinan, $keteranganjadwal, $id_pengajuan);
                if($keteranganpenolakan == '') {
                    $keteranganpenolakan = 'Jadwal Praktik';
                } else {
                    $keteranganpenolakan = $keteranganpenolakan.', Jadwal Praktik';
                }
            }

            $issuetemplate = $request->isRejTemplate;
            $keterangantemplate = $request->rejKeteranganTemplate;
            if($issuetemplate == '1') {
                $this->model->tolaktemplate($user_id, $salinan, $keterangantemplate, $id_pengajuan);
                if($keteranganpenolakan == '') {
                    $keteranganpenolakan = 'Pengajuan Apoteker Sebagai';
                } else {
                    $keteranganpenolakan = $keteranganpenolakan.', Pengajuan Apoteker Sebagai';
                }
            }

            $issuelainnya = $request->isRejLainnyaF;
            $keteranganlainnya = $request->rejKeteranganLainnya;
            if($issuelainnya == '1') {

                if($keteranganpenolakan == '') {
                    $keteranganpenolakan = $keteranganlainnya;
                } else {
                    $keteranganpenolakan = $keteranganpenolakan.', '.$keteranganlainnya;
                }
                
            }

            $issuelokasi = $request->isRejLokasiF;
            $keteranganlokasi = $request->rejKeteranganLokasi;
            if($issuelokasi == '1') {

                $this->model->tolaklokasi($user_id, $salinan, $keteranganlokasi, $id_pengajuan);
                if($keteranganpenolakan == '') {
                    $keteranganpenolakan = $keteranganlokasi;
                } else {
                    $keteranganpenolakan = $keteranganpenolakan.', '.$keteranganlokasi;
                }

            }


            try{

                if($isuniversal > 0) {
                    $this->model->tolakpengajuanU($id_pengajuan, $updater, $setstatus, 'Pengajuan Ditolak '.$nama_pengupdate,$keteranganpenolakan);
                }
                $this->model->updatestatuspengajuan($id_pengajuan, $updater, $setstatus, 'Pengajuan Ditolak '.$nama_pengupdate,$keteranganpenolakan);
                $pesanadmin = 'Pengajuan Atas Nama: '.$nama_nakes.' Ditolak, Silahkan Periksa Kelengakapan Pengajuan Anda Pada Akun e-SIP. Keterangan Penolakan : '.$keteranganpenolakan;
                $pesanadmin_ = 'Pengajuan Atas Nama: '.$nama_nakes.' Ditolak, Silahkan Periksa Pengajuan Anda Pada Aplikasi e-SIP.';
                if($getnowa) {
                    $nomorwa = $getnowa->notelp;
                    $this->sendnotifwa($nomorwa, $pesanadmin_);
                }
                $this->model->updatePesan('admin', '2', $pesanadmin, $user_id);
                // send to webhook
                $this->model->sendtoreminder('9', $id_pengajuan);
                
                if ($therole == 'admindinkes') {
                    return redirect()->route('admindinkes.main.dashboard')->with('alert', '1Berhasil Reject Pengajuan');
                } else if ($therole == 'adminptsp') {
                    return redirect()->route('adminptsp.main.dashboard')->with('alert', '1Berhasil Reject Pengajuan');
                } else if ($therole == 'verifptsp') {
                    return redirect()->route('verif.main.dashboard')->with('alert', '1Berhasil Reject Pengajuan');
                } else if ($therole == 'kaptsp') {
                    return redirect()->route('kaptsp.main.dashboard')->with('alert', '1Berhasil Reject Pengajuan');
                } else if ($therole == 'kadinkes') {
                    return redirect()->route('kadinkes.main.dashboard')->with('alert', '1Berhasil Reject Pengajuan');
                }

                
                

            }catch(Exception $e) {

                
                if ($therole == 'admindinkes') {
                    return redirect()->route('admindinkes.main.dashboard')->with('alert', '9Gagal Memproses Penolakan Pengajuan');
                } else if ($therole == 'adminptsp') {
                    return redirect()->route('adminptsp.main.dashboard')->with('alert', '9Gagal Memproses Penolakan Pengajuan');
                } else if ($therole == 'verifptsp') {
                    return redirect()->route('verif.main.dashboard')->with('alert', '9Gagal Memproses Penolakan Pengajuan');
                } else if ($therole == 'kaptsp') {
                    return redirect()->route('kaptsp.main.dashboard')->with('alert', '9Gagal Memproses Penolakan Pengajuan');
                } else if ($therole == 'kadinkes') {
                    return redirect()->route('kadinkes.main.dashboard')->with('alert', '9Gagal Memproses Penolakan Pengajuan');
                }

            }

        } else {

            $data['success'] = false;
            $data['keterangan'] = 'Penolakan SIP Manual Gagal';

            $keteranganpenolakan = 'Pengajuan SIP Manual Ditolak';
            $issuejadwal = $request->isRejjadwalF;
            $keteranganjadwal = $request->rejKeteranganJadwal;
            $issuelokasi = $request->isRejLokasiF;
            $keteranganlokasi = $request->rejKeteranganLokasi;
            

            try {

                if($issuelokasi == '1') {

                    $this->model->tolaksipmanual($issipmanual,'lokasi', $keteranganlokasi, $updater);
                    if($keteranganpenolakan == '') {
                        $keteranganpenolakan = $keteranganlokasi;
                    } else {
                        $keteranganpenolakan = $keteranganpenolakan.', '.$keteranganlokasi;
                    }
                }

                if($issuejadwal == '1') {

                    $this->model->tolaksipmanual($issipmanual,'jadwal', $keteranganjadwal, $updater);
                    if($keteranganpenolakan == '') {
                        $keteranganpenolakan = 'Jadwal Praktik';
                    } else {
                        $keteranganpenolakan = $keteranganpenolakan.', Jadwal Praktik';
                    }
                }

                $tolak = $this->model->tolaksipmanual($issipmanual,'sip', $keteranganlokasi, $updater);
                if($tolak) {

                    $data['success'] = true;
                    $data['keterangan'] = 'Penolakan SIP Manual Berhasil';

                }

                return redirect()->route('admin.pengajuansipmanual')->with('alert', '1Berhasil Reject Pengajuan');
                

            } catch (Exception $e) {

                return redirect()->route('admin.pengajuansipmanual')->with('alert', '9Gagal Memproses Penolakan Pengajuan');

            }
        }
    }


    public function getdatastr(Request $request) {

        $geturl = $request->thename;
        $thelinker = $request->thelinker;
        if ($thelinker == 1) {

            $urlget = config('app.warehouse_host').'nakes/getdatanakes_ceks';

        } else if ($thelinker == 2) {

            $urlget = config('app.warehouse_host').'nakes/getdatanakes_dok';

        } else {

            $urlget = config('app.warehouse_host').'nakes/getdatanakes';

        }
        
        $response = Http::asForm()->post($urlget, ['thename'=>$geturl])->body();
        
        return response()->json($response);
        
        
    }

    public function gettesting(Request $request) {
        $geting = $request->thename;
        $urlget = config('app.warehouse_host').'nakes/gettesting';
        $response = Http::asForm()->post($urlget, ['thename'=>$geting]);
        return $response;
    }


    public function adminnakespendaftar(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $data['role'] = Auth::user()->role;
        $nama = Auth::user()->name;
        $id = Auth::user()->id;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        if(Auth::user()->role == 'op') {
            $data['pendaftar'] = $this->model->getpendaftarop();
            $data['disetujui'] = $this->model->getpendaftarop();
        } else {
            $data['pendaftar'] = $this->model->getpendaftar(0);
            $data['disetujui'] = $this->model->getpendaftar(1);
        }
        


        return view('adminnakespendaftaran', $data);

    }
 

    public function approvependaftar(Request $request) {

        $username = $request->aprEmail;
        $password = $request->aprPassw;
        $role = 'nakes';
        $name = $request->aprNama;
        $foto = $request->aprFoto;
        $salinan = $request->aprSalinan;

        $tgl_keluar_str = $request->aprTglStr;
        $kompetensi = $request->aprKompetensi;
        $profesi = $request->aprProfesi;

        //
        $updater = $request->aprIDUpdater;
        $doc_status = $request->aprStatusFile;
        $pendaftar_status = '1';
        $id_pendaftar = $request->aprID;
        $isKeepFile = $request->aprStatusFile;
        $jenisfile = 'FOTO';

        $isUserExist = $this->model->isUserExist($username);

        if($isUserExist) {

            return redirect()->route('adminnakes.pemohon')->with('alert', '1Berhasil Approve Pendaftar');

        } else {

            try{

                $isfotonotavail = $this->model->checkfotonotavail($id_pendaftar);
                $id_user = $this->model->createUserNakes($username, $password, $role, $name, $foto, $isfotonotavail);
                if ($isKeepFile == '2') {
                    $pesanadmin = 'Selamat Datang di e-SIP. akun anda sudah díaktifasi dan dapat digunakan untuk upload dokumen dan pendaftaran praktek.';
                    $this->model->setToDokumen($id_user, 'STR'.$salinan , $id_pendaftar);
                    
                } else {
                    $pesanadmin = 'Selamat Datang di e-SIP. akun anda sudah díaktifasi dan dapat digunakan untuk upload dokumen dan pendaftaran praktek. Silahkan Upload Ulang Dokumen STR yang akan diajukan.';
                    $this->model->setToDokumenUploadUlang($id_user, 'STR'.$salinan , $id_pendaftar);
                }
                $this->model->updatePesan('admin', '1', $pesanadmin, $id_user);
                $this->model->updatePendaftaran($id_user, $id_pendaftar, $password, $updater, $doc_status, $pendaftar_status);
    
                if ($isfotonotavail == 0) {
    
                    if (strpos($foto, 'data:image/jpeg;base64,') !== false) {
                        $image = str_replace('data:image/jpeg;base64,', '', $foto);
                        $image = str_replace(' ', '+', $image);
                        $imageName = $id_user.'.jpeg';
                        $filename_fotone = $id_user.'.jpeg';
                        \File::put(storage_path('app/fotostr'). '/' . $imageName, base64_decode($image));
                        $this->model->updatesavedphoto($id_user, $imageName);
                    } else if (strpos($foto, 'data:image/jpg;base64,') !== false) {
                        $image = str_replace('data:image/jpg;base64,', '', $foto);
                        $image = str_replace(' ', '+', $image);
                        $imageName = $id_user.'.jpg';
                        $filename_fotone = $id_user.'.jpg';
                        \File::put(storage_path('app/fotostr'). '/' . $imageName, base64_decode($image));
                        $this->model->updatesavedphoto($id_user, $imageName);
                    }else if (strpos($foto, 'data:image/png;base64,') !== false) {
    
                        $jenisfile = 'PNG';
    
                        $base64String = str_replace('data:image/png;base64,', '', $foto);
                        $imageData = base64_decode($base64String);
             
                            // $pngImage = imagecreatefromstring($imageData);
                            // $jpgImage = imagecreatetruecolor(imagesx($pngImage), imagesy($pngImage));
                            // imagecopy($jpgImage, $pngImage, 0, 0, 0, 0, imagesx($pngImage), imagesy($pngImage));
                            // ob_start();
                            // imagejpeg($jpgImage, null, 100);
                            // $jpgImageData = ob_get_clean();
                            // $imageName = $id_user.'.jpg';
                            // $filename_fotone = $id_user.'.jpg';
                            // \File::put(storage_path('app/fotostr'). '/' . $imageName, $jpgImageData);
                       
               
                            $image = str_replace('data:image/png;base64,', '', $foto);
                            $image = str_replace(' ', '+', $image);
                            $imageName = $id_user.'.png';
                            $filename_fotone = $id_user.'.png';
                            \File::put(storage_path('app/fotostr'). '/' . $imageName, base64_decode($image));
                            //call the service
                            $urlget = config('app.cv2_host').'converttojpg';
                            $response = Http::asForm()->post($urlget, ['thename'=>$filename_fotone]);
    
                            if($response->status() == '200') {
                                $filename_fotone = $id_user.'.jpg';
                                $this->model->updatesavedphoto($id_user, $filename_fotone);
                            } else {
    
                                $imageName = $id_user.'.jpg';
                                $filename_fotone = $id_user.'.jpg';
                                \File::put(storage_path('app/fotostr'). '/' . $imageName, base64_decode($image));
                                $this->model->updatesavedphoto($id_user, $imageName);
                            }
    
                    } else if (strpos($foto, 'defaultpp') !== false) {
    
                        $success = \File::copy(storage_path('app/fotokosong'). '/defaultpp.jpg',storage_path('app/fotostr'). '/' . $id_user.'.jpg');
                        $imageName = $id_user.'.jpg';
                        $filename_fotone = $id_user.'.jpg';
                        $this->model->updatesavedphoto($id_user, $imageName);
    
    
                    } else {
    
                        $headers = get_headers($foto, 1);
                        if (isset($headers['Content-Disposition']) && strpos($headers['Content-Disposition'], 'filename') !== false) {
                            $contents = file_get_contents($foto);
                            $ext = pathinfo(parse_url($foto, PHP_URL_PATH), PATHINFO_EXTENSION);
                        } else {
                            $newfoto = str_replace("http://", "https://", $foto);
                            $contents = file_get_contents($newfoto);
                            $ext = pathinfo(parse_url($newfoto, PHP_URL_PATH), PATHINFO_EXTENSION);
                        }
                        
                        $imageName = 'fotostr/'.$id_user.'.'.$ext;
                        $filename_fotone = $id_user.'.'.$ext;
                        Storage::put($imageName, $contents);
                        $this->model->updatesavedphoto($id_user, $filename_fotone);
                    }
    
                    $this->model->tambahDoc('FOTO', $id_user, $filename_fotone, 'FOTO', $id_user, $tgl_keluar_str, $tgl_keluar_str, $jenisfile, $id_user, $tgl_keluar_str, $tgl_keluar_str);
    
                } else {
                    $success = \File::copy(storage_path('app/fotokosong'). '/' . $id_pendaftar.'.jpg',storage_path('app/fotostr'). '/' . $id_user.'.jpg');
                    $imageName = $id_user.'.jpg';
                    $filename_fotone = $id_user.'.jpg';
                    $this->model->updatesavedphoto($id_user, $imageName);
                    $this->model->tambahDoc('FOTO', $id_user, $filename_fotone, 'FOTO', $id_user, $tgl_keluar_str, $tgl_keluar_str, $jenisfile, $id_user, $tgl_keluar_str, $tgl_keluar_str);
                }
    
                
    
                $nomorwa = $this->model->getnomorwa($id_user);
                $pesanadmin = 'Selamat, Pendaftaran User Atas Nama: '.$name.' Telah Disetujui. Silahkan Lakukan Pergantian Password Secara Berkala.';
                if ($isKeepFile == '2') {
                    $this->sendnotifwa($nomorwa, $pesanadmin.' Username anda adalah email saat anda mendaftarkan dokumen STR, Password anda adalah: '.$password.' Segera Lakukan Pergantian Password');
                } else {
                    $this->sendnotifwa($nomorwa, $pesanadmin.' Username anda adalah email saat anda mendaftarkan dokumen STR, Password anda adalah: '.$password.' Segera Lakukan Pergantian Password. Dokumen STR anda harus diupload ulang dengan kualitas file yang lebih baik.');
                }
                $this->model->updatePesan('admin', '1', $pesanadmin, $id_user);
                $this->cropthephoto($filename_fotone);
                return redirect()->route('adminnakes.pemohon')->with('alert', '1Berhasil Approve Pendaftar');
                
    
            }catch(Exception $e) {
    
                
          
                return redirect()->route('adminnakes.pemohon')->with('alert', '9Gagal Approve Pendaftar');
                
    
            }

        }

    }

    public function draftsip(Request $request) {

        
        $data['id_pengajuan'] = $id_pengajuan;
        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $data['role'] = Auth::user()->role;
        $nama = Auth::user()->name;
        $id = Auth::user()->id;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;

        $id_pengajuan = $request->draftid_persetujuan;
        $id_nakes = $request->draftid_nakes;
        $detailpengajuan = $this->model->draftingSip($id_pengajuan);

        return view('pengajuan/draftsip', $data);

    }


    public function draftingSip(Request $request) {

        $id_pengajuan = $request->id_pengajuan;
        $env = $this->model->getenv();
        $template_id = $request->template_id;
        $perubahan = $request->perubahan;
        $fixedtgl = $request->selectedfixed;

        // if ($env == 'prd') {
        //     $surathost = 'https://surat.cilacapkab.go.id/assets/uploads/maker/draft/';
        //     $ttehost = 'https://surat.cilacapkab.go.id/CsubmitRekomNakes/gettteptsp';
        // } else if ($env == 'uat') {
        //     $surathost = 'https://surat2.cilacapkab.go.id/assets/uploads/maker/draft/';
        //     $ttehost = 'https://surat2.cilacapkab.go.id/CsubmitRekomNakes/gettteptsp';
        // } else {
        //     $surathost = 'http://dev1.cilacapkab.go.id/assets/uploads/maker/draft/';
        //     $ttehost = 'http://dev1.cilacapkab.go.id/CsubmitRekomNakes/gettteptsp';
        // }

        $surathost = config('app.surat_host').'assets/uploads/maker/draft/';
        $ttehost = config('app.surat_host').'CsubmitRekomNakes/gettteptsp';

        $data['isExist'] = 0;
        $data['surathost'] = $surathost;
        $data['success'] = false;
        

    
        try{
            //$datatte_ = Http::get($ttehost);
            $datatte_ = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
                'Accept' => 'application/json',
                'Referer' => config('app.surat_host'),
                'Origin' => config('app.surat_host'),
                'Accept-Language' => 'en-US,en;q=0.9'
            ])->get($ttehost);

            $datatte_status = $datatte_->status();
            //dd($datatte_);
            if ($datatte_status == 200) {
                $tte = $datatte_->json();
                $nama_tte = $tte[0]['nama_tte'];
                $pangkat_tte = $tte[0]['pangkat_tte'];
                $isplt = $tte[0]['isplt'];
                $nip_tte = $tte[0]['nip_tte'];

                $isexist = $this->model->isDraftExists($id_pengajuan, $perubahan)->count();
                if ($isexist == 0) {
                    $drafter = $this->model->draftingSip($id_pengajuan, $nip_tte, $isplt, $nama_tte, $pangkat_tte, $template_id, $fixedtgl);
                    if ($drafter) {
                        $data['hasilnya'] = $drafter;
                        $data['success'] = true;
                    }
                    
                    
                } else {
                    $getexistingtemplate = $this->model->getexistingtemplate($id_pengajuan, $perubahan);
                    if($template_id == $getexistingtemplate) {

                        $getfilenamesurat = $this->model->getfilenamesurat($id_pengajuan);
                        $data['success'] = true;
                        $data['isExist'] = 1;
                        $data['namafilesurat'] = $getfilenamesurat;

                    } else {
                        $updatetemplateid = $this->model->updatetemplateid($id_pengajuan, $template_id, $perubahan);
                        if($updatetemplateid) {

                            $data['success'] = true;
                            $data['isExist'] = 0;
                            

                        } else {
                            $data['success'] = false;
                            $data['isExist'] = 0;
                            
                        }
                        
                    }
                    // $resetdraft = $this->model->resetdraftsip($id_pengajuan);
                    // $drafter = $this->model->draftingSip($id_pengajuan, $nip_tte, $isplt, $nama_tte, $pangkat_tte, $template_id, $fixedtgl);
                    // if ($drafter) {
                    //     $data['hasilnya'] = $drafter;
                    //     $data['success'] = true;
                    // }
                    
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

    public function generateDraftSip(Request $request) {

        $data['success_draft'] = false;
        $env = $this->model->getenv();

        $urlget = config('app.conv_host').'draftrekomnakes';

        $id_pengajuan = $request->id_pengajuan;
        $draftsip = $this->model->getdraftsip($id_pengajuan);
        $getfotostr = $this->model->getfotostr($id_pengajuan);
        $id_nakes = $request->id_nakes;
        


        if($draftsip) {

            $template_id = 'nakes'.$draftsip->template_id;
            $filename_sip = $draftsip->filename_sip;
            $no_rekomdinkes = $draftsip->no_rekomdinkes;
            $tgl_rekomdinkes = $this->help->tgl_indo_sip($draftsip->tgl_rekomdinkes);
            $no_rekomp = $draftsip->no_rekomp;
            $tgl_rekomp = $draftsip->tgl_rekomp;
            $nama_nakes = $draftsip->nama_nakes;
            $ttl_nakes = $draftsip->ttl_nakes;
            $alamat_nakes = $draftsip->alamat_nakes;
            $no_str = $draftsip->no_str;
            $tgl_berlaku = $draftsip->tgl_berlaku;
            $tgl_doc = $draftsip->tgl_doc;
            $kompetensi = $draftsip->kompetensi;
            $profesi = strtoupper($draftsip->profesi);
            if($profesi == 'APOTEKER' && $draftsip->template_id == '3') {
                $profesi = 'Apoteker Praktik';
            } else {
                $profesi = ucwords($profesi);
            }
            if ($draftsip->nama_faskes != '') {
                $nama_faskes = $draftsip->nama_faskes.', ';
            } else {
                $nama_faskes = '';
            }
            $nama_lokasi = $draftsip->nama_lokasi;
            $kec_lokasi = $draftsip->kec_lokasi;
            $kab_lokasi = $draftsip->kab_lokasi;
            $no_surat = $draftsip->no_surat;
            $is_plt = $draftsip->is_plt;
            $nama_tte = $draftsip->nama_tte;
            $pangkat_tte = $draftsip->pangkat_tte;
            $nip_tte = $draftsip->nip_tte;
            $salinan_terbilang = $draftsip->salinan_terbilang;
            $salinan = $draftsip->salinan;
            $jenis_profesi = $draftsip->jenis_profesi;
            $isSementara = $draftsip->jadwal_praktek;
            $ukuran = $draftsip->ukuran;
          

            $getjadwal = $this->model->getjadwalnakes($id_nakes, $salinan);
            $jadwaljson = json_encode($getjadwal);

            $thefile = fopen('../storage/app/fotostr/'.$getfotostr,'r');
            $perdata = [
                'env' => $env,
                'template_id' => $template_id,
                'filename_sip' => $filename_sip,
                'no_rekomdinkes' => $no_rekomdinkes,
                'tgl_rekomdinkes' => $tgl_rekomdinkes,
                'no_rekomp' => $no_rekomp,
                'tgl_rekomp' => $tgl_rekomp,
                'nama_nakes' => $nama_nakes,
                'ttl_nakes' => $ttl_nakes,
                'alamat_nakes' => $alamat_nakes,
                'no_str' => $no_str,
                'tgl_berlaku' => $tgl_berlaku,
                'tgl_doc' => $tgl_doc,
                'kompetensi' => $kompetensi,
                'profesi' => $profesi,
                'nama_faskes' => $nama_faskes,
                'nama_lokasi' => $nama_lokasi,
                'kec_lokasi' => $kec_lokasi,
                'kab_lokasi' => $kab_lokasi,
                'no_surat' => $no_surat,
                'is_plt' => $is_plt,
                'nama_tte' => $nama_tte,
                'pangkat_tte' => $pangkat_tte,
                'nip_tte' => $nip_tte,
                'salinan_terbilang' => $salinan_terbilang,
                'id_nakes' => $id_nakes,
                'salinan' => $salinan,
                'foto_nakes' => $getfotostr,
                'jadwal_praktek' => $jadwaljson,
                'jenis_profesi' => $jenis_profesi,
                'isSementara' => $isSementara,
                'ukuran' => $ukuran
            ];
            $response_ = Http::attach('filefoto', $thefile, $getfotostr)->post($urlget, $perdata);

            $hasildraft = $response_->json();
            $status_draft = $response_->status();

            if ($status_draft == 200) {
                $data['resultdraft'] = $hasildraft;
                $data['success_draft'] = true;
                

            } else {
                $data['response_draft'] = $status_draft;
                $data['keterangan'] = $response_->body();
    
            }

        }

        return response()->json($data);
        
        
    }

    public function testsendingfilenya() {
        // $filename_sip = '4343524242';
        // $nama_nakes = 'Jermeah Klakson';
        // $no_sip = '9348032409204-342042';
        // $id_pengajuan = '3';
        // $no_str = '93ur9u2r9u22';

        // $urlget = 'http://dev1.cilacapkab.go.id/CsubmitRekomNakes/submitRekomNakes';
        // $response = Http::asForm()->post($urlget, ['filename_sip' => $filename_sip, 'nama_nakes' => $nama_nakes, 'no_sip' => $no_sip, 'id_pengajuan' => $id_pengajuan, 'no_str' => $no_str])->body();

        //return response()->json($response);

        $result = Storage::copy('perpanjangan/8tvsxac2mra6eo9feb5tfk46l.pdf', 'daftar/8tvsxac2mra6eo9feb5tfk46l.pdf');
        return $result;

    }

    public function submitsipasoka(Request $request) {

        $data['success'] = false;
        $id_pengajuan = $request->id_pengajuan;
        $updater = $request->updater;
        $getdraftsip = $this->model->getdraftsip($id_pengajuan);
        $salinanori = $this->model->getsalinansip($id_pengajuan);
        $foto_nakes = $this->model->getfotonakes($id_pengajuan);
        $getperpanjangan = $this->model->getperpanjangan($id_pengajuan);
        $isverif = $request->isverif;
        if($isverif == '1') {

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
                $ukuran = $getdraftsip->ukuran;

                $getjadwal = $this->model->getjadwalnakes($id_nakes, $salinan);
                $jadwaljson = json_encode($getjadwal);
            }

            $env = $this->model->getenv();

            // if ($env == 'prd') {
            //     $urlget = 'https://surat.cilacapkab.go.id/CsubmitRekomNakes/submitRekomNakes';
            //     $liatdraft = 'https://surat.cilacapkab.go.id/assets/uploads/maker/draft/';
            // } else if ($env == 'uat') {
            //     $urlget = 'https://surat2.cilacapkab.go.id/CsubmitRekomNakes/submitRekomNakes';
            //     $liatdraft = 'https://surat2.cilacapkab.go.id/assets/uploads/maker/draft/';
            // } else {
            //     $urlget = 'http://dev1.cilacapkab.go.id/CsubmitRekomNakes/submitRekomNakes';
            //     $liatdraft = 'http://dev1.cilacapkab.go.id/assets/uploads/maker/draft/';
            // }

            $urlget = config('app.surat_host').'CsubmitRekomNakes/submitRekomNakes';
            $liatdraft = config('app.surat_host').'assets/uploads/maker/draft/';

            try {

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
                    'isSementara' => $isSementara,
                    'ukuran' => $ukuran
                ];

                $response_ = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
                    'Accept' => 'application/json',
                    'Referer' => config('app.surat_host'),
                    'Origin' => config('app.surat_host'),
                    'Accept-Language' => 'en-US,en;q=0.9'
                ])->asForm()->post($urlget, $datapost);
                $response_status = $response_->status();
                $response = $response_->json();

                if ($response_status == 200) {
                    $this->model->updatesipstatus($id_pengajuan, $updater, $isverif);
                    $data['success'] = true;
                    $data['keterangan'] = $response;
                    return response()->json($data);
                    //notif here//
                    $pesanadmin = 'Pengajuan Atas Nama: '.$nama_nakes.', salinan: '.$salinan_terbilang.', Akan Ditandatangani secara elektronik oleh KA DPMPTSP dengan masa berlaku hingga: '.$tgl_doc.', silahkan ajukan revisi jika ada kesalahan.';
                    $nomorwa = $this->model->getnomorwa($id_nakes);
                    $this->sendnotifwa($nomorwa, $pesanadmin);
                    $this->model->updatePesan('admin', '1', $pesanadmin, $id_nakes);

                } else if ($response_status == 201) {

                    $data['keterangan'] = 'Data Sudah Pernah Disubmit';
                    return response()->json($data);

                } else {
                    $ket = $response_->body();
                    //$data['datapost'] = $datapost;
                    $data['keterangan'] = $ket;
                    return response()->json($data);
                }


            }catch(Exception $e) {

                $data['error'] = $e;
                return response()->json($data);
                
            }

        } else {

            $this->model->updatesipstatus($id_pengajuan, $updater, $isverif);
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Update Status SIP dan Diteruskan Ke Verifikator';
            return response()->json($data);

        }
            

    }


    public function updatestatussip(Request $request){
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Update Status SIP';
        $nama_nakes = '';
        $filename_sip = $request->filename_sip;
        $id_pengajuan = $request->id_pengajuan;
        $detailjadwal = $request->detailjadwal;
        $no_surat = $request->no_surat;
        $signed_date = $request->signed_date;
        $template_id = $this->model->gettemplateidsip($filename_sip);
        $detailpengajuan = $this->model->getdetailpengajuan($id_pengajuan);
        if($detailpengajuan)
        {
            $nama_nakes = $detailpengajuan->nama_nakes;
        }
        $result = $this->model->updatestatussip($id_pengajuan, $filename_sip, $detailjadwal, $no_surat, $signed_date);
        if($result) {
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Update Status SIP';
            $nomorwa = $this->model->getnomorwabypengajuan($id_pengajuan);
            if($nomorwa) {

                $iscabut = substr($filename_sip, 0, 1);
                $pesanadmin = 'Ajuan Anda Atas Nama: '.$nama_nakes.' Sudah Diterima dan e-SIP anda sudah ditanda-tangani secara elektronik. Silahkan Kunjungi Akun eSIP Anda Untuk Mengunduh';

                if($template_id == '2') {
                    $pesanadmin = 'Ajuan Anda Atas Nama: '.$nama_nakes.' Sudah Diterima dan e-SIP anda sudah ditanda-tangani secara elektronik. Silahkan Kunjungi Akun eSIP Anda Untuk Mengunduh';
                }
                if($iscabut == 'C') {
                    $pesanadmin = 'Dokumen Pencabutan eSIP anda Atas Nama: '.$nama_nakes.' telah selesai Ditanda Tangani Secara Elektronik';
                }
                $this->sendnotifwa($nomorwa, $pesanadmin);
            }
            //$data['filename_sip'] = $filename_sip;
            //$data['id_pengajuan'] = $id_pengajuan; 
        }
        return response()->json($data);
    }


    public function updatestatussipdinkes(Request $request){
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Update Status SIP';
        $filename_sip = $request->filename_sip;
        $id_pengajuan = $request->id_pengajuan;
        $detailjadwal = $request->detailjadwal;
        $no_surat = $request->no_surat;
        $signed_date = $request->signed_date;
        $template_id = $this->model->gettemplateidsip($filename_sip);
        //$result = $this->model->updatestatussipdinkes($id_pengajuan, $filename_sip, $detailjadwal, $no_surat, $signed_date);
        
        return response()->json($data);
    }

    public function getjadwalnakes($id_nakes, $salinan) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mengambil Data Jadwal Praktik';
        $result = $this->model->getjadwalnakes($id_nakes, $salinan);
        if($result) {
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Mengambil Data Jadwal Praktik';
            $data['result'] = $result;
        }
        return response()->json($data);

    }

    public function ptspmanagepencabutan() {

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $tglcoba = '2022-01-10 02:01:00';
        $bedanya = $this->help->standardiff($tglcoba);
        $data['bedaken'] = $bedanya;
        $data['pencabutan'] = $this->model->getpengajuan('cabut');
        $data['userinactive'] = $this->model->getuserinactive();

        return view('ptsp/adminptsppencabutan', $data);

    }

    public function ambilistcabut(Request $request)
    {
        $jenis = $request->jenis;
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Ambil Data Pencabutan';

        $pencabutan = $this->model->getpengajuan($jenis);
        if($pencabutan) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Ambil Data Pencabutan';
            $data['pencabutan'] = $pencabutan;
            
        }
        return response()->json($data);
    }

    

    public function approvepencabutan(Request $request) {

        $kode = $request->kode;
        $alasan_tolak = $request->alasan_tolak;

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Update Data Pencabutan';
        $id_nakes = $request->id_nakes;
        $result = $this->model->approvepencabutan($request);
        if($result) {
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Update Data Pencabutan';
            $data['result'] = $result;
            if($kode == '9') {
                $pesanadmin = 'Pencabutan SIP Anda Ditolak Oleh DPMPTSP dengan Alasan : '.$alasan_tolak.', Silahkan Periksa Pada Akun e-SIP ';
            } else {
                $pesanadmin = 'Pencabutan SIP Anda Sudah Disetujui Oleh DPMPTSP, Silahkan Periksa Pada Akun e-SIP ';
            }
            
            $this->model->updatePesan('admin', '1', $pesanadmin, $id_nakes);
        }
        return response()->json($data);



    }

    public function adminpendaftarannakes() {

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $data['role'] = Auth::user()->role;
        $nama = Auth::user()->name;
        $id = Auth::user()->id;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;

        $data['semuaprofesi'] = $this->model->getallprofesi();

        $data['todays'] = date('Y-m-d');
        return view('ptsp/adminpendaftarannakes', $data);

    }

    public function simpanstrmanual(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mengupload STR Manual';
        $strtetap = $request->stSTRtetapSIPmanual;
        $strhingga = $request->stSTRHinggaSIPmanual;
        $tgl_tetap_conv = $this->help->tgl_indo_sip($strtetap);

        if ($request->has('seumurhidup')) {
            $tgl_hingga_conv = 'Seumur Hidup';
        } else {
            $tgl_hingga_conv = $this->help->tgl_indo_sip($strhingga);
        }
        
        $originname = $request->stWhichF;
        $ifexists = $this->model->checkexistingmanual($request);
        if($ifexists > 0) {
            return redirect()->route('ptsp.daftar.nonqr')->with('alert', '9Email / No HP / STR sudah Pernah Dipakai Untuk Pendaftaran');
        } else {

            $result = $this->model->simpanstrmanual($request, $tgl_tetap_conv, $tgl_hingga_conv);
            $no_reg = $request->stNoSTR;
            $nama = $request->stNama;
            $nomorwa = $request->stNotelp;
            $password = $request->stPassword;
            $pesanadmin = 'Selamat, Pendaftaran User Atas Nama: '.$nama.' Sudah Berhasil. ';

            if($result) {

                Storage::copy('fotostr/'.$originname.'.jpeg', 'fotostr/'.$result.'.jpeg');
                $this->cropthephoto($result.'.jpeg');
                $data['id_nakes'] = $result;
                $data['success'] = true;
                $data['keterangan'] = 'Berhasil Mengupload STR atas nama: '.$nama;
                //return view('ptsp/adminptspdashboard', $data);
                $this->sendnotifwa($nomorwa, $pesanadmin.' Username anda adalah email saat anda mendaftarkan dokumen STR, Password anda adalah: '.$password.' Segera Lakukan Pergantian Password');
                return redirect()->route('adminptsp.main.dashboard')->with('alert', '1Berhasil Menyimpan STR Manual');
                
            } else {
                return redirect()->route('adminptsp.main.dashboard')->with('alert', '9Gagal Menyimpan STR Manual');
            }
        
        }
        
        

    }


    public function submitstrmanual(Request $request){

        $data['success'] = false;
        $data['success_extract'] = false;

        if($request->hasFile('tFileSTRManual')){

            $request->validate([
                'tFileSTRManual' => 'file|mimes:pdf|max:5120',
            ]);


            
            $thefile = $request->file('tFileSTRManual');
            $extension = $request->file('tFileSTRManual')->extension();
            $filenamenya = $request->file('tFileSTRManual')->getClientOriginalName();
            

        }

        if($request->hasFile('tFileFotoNakes')){

            $request->validate([
                'tFileFotoNakes' => 'file|mimes:jpg,jpeg,png|max:5120',
            ]);

            $thefilefoto = $request->file('tFileFotoNakes');
            $extensionfoto = 'jpeg';
            $filenamenyafoto = $request->file('tFileFotoNakes')->getClientOriginalName();
            

        }

        try{

            $encrypted = $this->random_string(25);
            $namafile = $encrypted.'.'.$extension;
            $path = Storage::putFileAs('/daftar', $thefile, $encrypted.'.'.$extension);
            Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));

            
            $namafilefoto = $encrypted.'.'.$extensionfoto;
            $path = Storage::putFileAs('/fotostr', $thefilefoto, $encrypted.'.'.$extensionfoto);
            Storage::disk('public_upload')->put($namafilefoto, file_get_contents($thefilefoto));
            

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
                $data['success_extract'] = false;

                $parser = new Parser();
                $pdf = $parser->parseFile(storage_path('app/daftar/'.$encrypted.'.pdf'));
                $text = $pdf->getText();
                if($text != "")
                {
                    $extract = $this->model->gettextstr($text);
                    if($extract)
                    {
                        $data['resultword'] = $extract;
                        $data['success_extract'] = true;
                    }
                    

                } 

                // $urlextractor = config('app.ocr_host').'extractstrmanual';
                // $filestr = fopen('../storage/app/daftar/'.$encrypted.'.png','r');
                // $extractres_ = Http::timeout(10) // timeout 10 detik
                // ->attach('filestr', $filestr, $encrypted.'.png')
                // ->post($urlextractor, [
                //     'thename'   => $encrypted,
                //     'extension' => $extensionpos
                // ]);
        
                // $status_extractor = $extractres_->status();
            
                // if ($status_extractor == 200) {
                //     $extractres = $extractres_->json();
                //     $data['resultword'] = $extractres;
                //     $data['success_extract'] = true;
                // } else {
                //     $data['success_extract'] = false;
                //     $data['error'] = "Extractor error: HTTP $status_extractor";
                // }
                
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


    

    public function pengumpulanstrasli($id_request) {

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $tglcoba = '2022-01-10 02:01:00';
        $bedanya = $this->help->standardiff($tglcoba);
        $data['bedaken'] = $bedanya;
        $detailnya = $this->model->getdetailpengajuan($id_request);
        if($detailnya->berlaku_sampai == "Seumur Hidup")
        {
            $request = new \stdClass();
            $request->id_pengajuan = $id_request;
            $request->jenis = 'SH';

            $result = $this->model->updateSTRTahan($request);

            return redirect()->route('adminptsp.main.dashboard');

        } else {

            $data['detail_pengajuan'] = $detailnya;
            $data['id_pengajuan'] = $id_request;
            

            return view('ptsp/adminptsptahanstr', $data);

        }
        

    }


    public function simpanpengumpulanstr(Request $request) {

        $id_pengajuan = $request->stIDPengajuanKumpul;
        $id_nakes = $this->model->getIDNakesbyPengajuan($id_pengajuan);

        
        try{
    
            $result = $this->model->updateSTRTahan($request);
            if($result) {

                if($id_nakes) {

                    $pesanadmin = 'STR Anda Berhasil Disimpan Oleh DPMPTSP, Silahkan Periksa Pada Akun e-SIP Anda Untuk Download File e-SIP';
                    $this->model->updatePesan('admin', '1', $pesanadmin, $id_nakes);

                }

                return redirect()->route('get.detail.pengajuan', $id_pengajuan)->with('alert', '1Data Pengumpulan STR Berhasil Disimpan');
            } else {
                return redirect()->route('kumpul.str.asli', $id_pengajuan)->with('alert', '9Gagal Proses Pengumpulan STR');
            }
            
            
        }catch(Exception $e) {

            return redirect()->route('kumpul.str.asli', $id_pengajuan)->with('alert', 'Gagal');
        
        }
    }


    public function resetnakespassword(Request $request){

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Update Password, Silahkan Coba Kembali';
        $result = $this->model->resetnakespassword($request);
        if($result) {
            $nomor = $request->nomor;
            $newpass = $request->newpass;
            $nama = $request->nama;
            $pesan = 'Selamat, Password Atas Nama: '.$nama.' Berhasil Diperbaharui Oleh System. Password Baru Anda: '.$newpass.' Silahkan Lakukan Login Ke Aplikasi e-SIP Untuk Melanjutkan Proses Berikutnya.';
            //$sendnotif = $this->sendnotifwareturn($nomor,$pesan);
            $sendnotif = $this->sendnotifwa($nomor,$pesan);
            if($sendnotif) {
                $data['success'] = true;
                $data['keterangan'] = 'Update Password Berhasil';
            } else {
                $data['keterangan'] = 'Gagal Mengirim Notif Ke Nakes';
            }
        }
        return response()->json($data);

    }

    public function submitmanagefaskes(Request $request){

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mengupdate Data Fasyankes, Silahkan Coba Kembali';
        $result = $this->model->submitmanagefaskes($request);
        if($result) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Update Data Fasyankes Berhasil';
            return redirect()->route('ptsp.manage.faskes')->with('alert', '1Update Data Fasyankes Berhasil');
        } else {
            return redirect()->route('ptsp.manage.faskes')->with('alert', '9Gagal Mengupdate Data Fasyankes, Silahkan Coba Kembali');
        }
        

    }

    public function verifstrserahan(Request $request){

        $result = $this->model->verifstrserahan($request);
        $data = json_encode($result);
        return response()->json($data);

    }

    public function cancelDraftSip(Request $request){

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Cancel Draft e-SIP';
        $result = $this->model->cancelDraftSip($request);
        if($result) {
            $data['success'] = true;
            $data['keterangan'] = 'Sukses Mengcancel Draft e-SIP';
        }
        $data = json_encode($result);
        return response()->json($data);

    }

    public function revertDraftSip(Request $request) {

        $data['success'] = true;
        $data['keterangan'] = "Berhasil Mengembalikan Data Pengajuan";

        $id_pengajuan = $request->id_pengajuan;
        $filename_sip = $request->filename_sip;
        $lateststatus = config('app.surat_host').'CsubmitRekomNakes/revertdraftsip';
        $datapost = [
            'filename_sip' => $filename_sip
        ];
        $response_esiptte = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
            'Accept' => 'application/json',
            'Referer' => config('app.surat_host'),
            'Origin' => config('app.surat_host'),
            'Accept-Language' => 'en-US,en;q=0.9'
        ])->asForm()->post($lateststatus, $datapost);
        $esiptte_status = $response_esiptte->status();
        if ($esiptte_status == 200) {
            $esiptte = $response_esiptte->json();
            $statusdokumen = $esiptte['statusdokumen'];
            $data['statusdokumen'] = $esiptte;
            if($statusdokumen == 'cancelled') {
                $result = $this->model->revertDraftSip($request);
                //dd($statusdokumen);
                if($result) {
                    return response()->json($data);
                } else {
                    $data['success'] = false;
                    $data['keterangan'] = 'Gagal Membatalkan Draft Surat, Silahkan Coba Lagi';
                    return response()->json($data);
                }
            } else {
                $data['success'] = false;
                $data['keterangan'] = 'Gagal Membatalkan Data Draft eSIP dari ASOKA, Silahkan Coba kembali';
                return response()->json($data);
            }
        } else {
            $data['success'] = false;
            $data['keterangan'] = 'Gagal Membatalkan Data Draft eSIP dari ASOKA, Silahkan Coba kembali';
            return response()->json($data);
        }
    }

    public function reverseDraftSip(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Membatalkan Data Draft eSIP dari ASOKA, Silahkan Coba kembali';

    }

    public function ptspupdatepengaju(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Update Data Pengaju';
        $result = $this->model->ptspupdatepengaju($request);
        if($result) {
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Update Data Pengaju';
        }
        return response()->json($data);

    }

    public function simpanuserfaskes(Request $request) {

        $id_faskes = $request->fIDFaskes;
        $is_update = $request->fIsUpdate;

        if($is_update) {

            if($request->hasFile('fLogoFaskes')){

                $request->validate([
                    'fLogoFaskes' => 'file|mimes:jpg,jpeg,png|max:5120',
                ]);


                $extension = $request->file('fLogoFaskes')->extension();
                $namafile = 'f_'.$id_faskes.'.'.$extension;
                $thefile = $request->file('fLogoFaskes');
                $hasil = Storage::putFileAs('/public/imguser', $thefile, $namafile);
    
            } 

        } else {

            $extension = $request->file('fLogoFaskes')->extension();
            $namafile = 'f_'.$id_faskes.'.'.$extension;
            $thefile = $request->file('fLogoFaskes');
            $hasil = Storage::putFileAs('/public/imguser', $thefile, $namafile);

        }

        $tambahuserfaskes = $this->model->tambahuserfaskes($request, $namafile);
        if($tambahuserfaskes) {
            return redirect()->route('ptsp.manage.faskes')->with('alert', '1Sukses Mengupdate Data User Faskes');
        } else {
            return redirect()->route('ptsp.manage.faskes')->with('alert', '9Gagal Update Data User Faskes, Silahkan Coba Kembali');
        }

    }

    public function getuserfaskes(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Ambil Data User Faskes';

        $result = $this->model->getuserfaskes($request);
        if($result) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Mendapatkan Data User Faskes';
            $data['result'] = $result;
            
        }
        return response()->json($data);
    }

    public function submittolaknakes(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Menolak Pendaftaran Nakes';

        $result = $this->model->submittolaknakes($request);
        if($result) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Menolak Pendaftaran nakes';
            $data['result'] = $result;
            
        }
        return response()->json($data);


    }

    
    public function submiteditnomor(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Update Data Nakes';

        $result = $this->model->submiteditnomor($request);
        if($result) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Update Data Nakes';
            $data['result'] = $result;
            
        }
        return response()->json($data);


    }

    public function rekapnakesfaskes(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mengambil Detail Faskes';
        $id_faskes = $request->id_faskes;

        $result1 = $this->model->getrekapfaskes($id_faskes, '0');
        $result2 = $this->model->allnakesonfaskes($id_faskes);
        if($result1 && $result2) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Mengambil Detail Faskes';
            $data['result1'] = $result1;
            $data['result2'] = $result2;
            
        }
        return response()->json($data);

    }

    

    
    public function getnearestloc(Request $request) {

        $longitude = 1.2345; // Replace with your specific longitude
        $latitude = 2.3456; // Replace with your specific latitude

        $locations = [
            ['latitude' => 2.1111, 'longitude' => 1.2222],
            ['latitude' => 2.3333, 'longitude' => 1.4444],
            // Add more locations to the array as needed
        ];

        $nearestLocation = GeoHelper::findNearestLocation($longitude, $latitude, $locations);

        if ($nearestLocation) {
            // Found a location within 500 meters
            // $nearestLocation contains the nearest location's latitude and longitude
        } else {
            // No location found within 500 meters
        }

    }

    public function rekappelayanan() {

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $tglcoba = '2022-01-10 02:01:00';
        $data['semuaprofesi'] = $this->model->getallprofesi();
        $data['periode_sip'] = $this->model->getperiodesip();
        $data['sipakankadal'] = $this->model->getaboutkadal('sip');
        $data['strakankadal'] = $this->model->getaboutkadal('str');
        
        return view('ptsp/adminptsprekap', $data);

    }

    public function getchartpelayanan(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Ambil Data Chart Rekapitulasi Pelayanan';
        $year = $request->year;

        $result = $this->model->getchartpelayanan($year);
        
        if($result) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Ambil Data Chart Rekapitulasi Pelayanan';
            $data['result'] = $result;
            
        }
        return response()->json($data);

    }

    public function detailrekappelayanan(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Ambil Data Rekapitulasi Pelayanan';
        $year = $request->year;

        $result = $this->model->detailrekappelayanan($year);
        
        if($result) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Ambil Data Rekapitulasi Pelayanan';
            $data['result'] = $result;
            
        }
        return response()->json($data);

    }

    public function updatesipmanual(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Menyimpan Update SIP Manual';

        $result = $this->model->updatesipmanual($request);
        
        if($result) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Menyimpan Update SIP Manual';
            $data['result'] = $result;
            
        }
        return response()->json($data);

    }

    public function getnakessekitar(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Ambil Data Nakes Sekitar';

        $result = $this->model->getnakessekitar($request);
        
        if($result) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Ambil Data Nakes Sekitar';
            $data['result'] = $result;
            
        }
        return response()->json($data);

    }

    
    public function ptspcountpencabutan(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Ambil Data Hitung Pencabutan Pending';
        $result = $this->model->getpengajuan('cabuthitung');
        
        if($result) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Ambil Data Hitung Pencabutan Pending';
            $data['result'] = $result;
            
        }
        return response()->json($data);

    }

    
    public function admincountmenu(Request $request) {

        $jenis = $request->jenis;
        $role = $request->role;
        $result2 = [];
        

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Ambil Data Hitung Daftar Pending';
        if($jenis == 'pendaftaran') {
            $result = $this->model->getpendaftar(0);
            
        } else if($jenis == 'admincabut')
        {
            $result = $this->model->getpengajuan('cabut');

            $countApprovedC = $result->where('isApproved', 'C')->count();


            $data['totalcabut'] = $countApprovedC;

        } else {
            if($role == 'adminptsp') {
                $result = $this->model->getpengajuan('normal');
                $result2 = $this->model->getpengajuan('perubahan');
            } else {
                $result = $this->model2->getpengajuan('normal');
            }
            
        }
        
        $data['result2'] = $result2;
        if($result) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Ambil Data Hitung Daftar Pending';
            $data['result'] = $result;
            
        }
        
        return response()->json($data);

    }

    public function reaktifasiuser(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Reaktifasi User';

        $result = $this->model->reaktifasiuser($request);
        if($result) {

            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Aktifasi User';

        }
        return response()->json($data);

    }

    
    public function getnakesinmap(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Ambil Data Nakes Sekitar';
        $nama_kec = 'Semua Kecamatan';

        $path = storage_path() . "/kecamatan.json"; // ie: /var/www/laravel/app/storage/json/filename.json
        $geojsonData = json_decode(file_get_contents($path), true);

        $area = $request->area;
        if($area == 'all') {
            $geojsonPolygon = '0';
        } else {

            $filteredFeatures = collect($geojsonData['features'])->filter(function ($feature) use ($area) {
                return $feature['properties']['kode'] === $area;
            })->values()->toArray();

            if (!empty($filteredFeatures)) {
                $nama_kec = $filteredFeatures[0]['properties']['nama'];  
            } 
            
            // Create the desired $geojsonPolygon format
            $coordinates = $filteredFeatures[0]['geometry']['coordinates'][0];
            $geojsonPolygon = [
                'type' => 'Polygon',
                'coordinates' => [$coordinates],
            ];

        }

        //$geojsonPolygon = json_encode($geojsonPolygon);
        $result = $this->model->getnakesinmap($request);
        $result2 = $this->model->getfaskesinmap($request);
        if($result && $result2) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Ambil Data Nakes Sekitar';
            $data['result'] = $result;
            $data['faskes'] = $result2;
            $data['polygon'] = $geojsonPolygon;
            $data['nama_kec'] = $nama_kec;
            $data['kecamatan_polygon'] = $geojsonData['features'];
            
        }
        return response()->json($data);

    }

    public function getrekapmapnakes() {

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $tglcoba = '2022-01-10 02:01:00';
        $path = storage_path() . "/kecamatan.json"; // ie: /var/www/laravel/app/storage/json/filename.json
        $dataloc = json_decode(file_get_contents($path), true);
        $output = [];
        foreach ($dataloc['features'] as $feature) {
            $properties = $feature['properties'];
            $output[] = [
                'kode' => $properties['kode'],
                'nama' => $properties['nama'],
            ];
        }
        usort($output, function($a, $b) {
            return strcmp($a['nama'], $b['nama']);
        });
        $data['kecamatan'] = $output;
        $getpilihanprofesi = $this->model->getpilihanprofesi();
        $data['profesi'] = $getpilihanprofesi;
        
        return view('adminrekapmap', $data);

    }




    //// draft surat pencabutan
    public function draftingPencabutanSip(Request $request) {

        $id_pengajuan = $request->id_pengajuan;
        $id_nakes = $request->id_nakes;
        $id_sip = $request->id_sip;
        $env = $this->model->getenv();
        $template_id = 'c';
        $perubahan = $request->perubahan;
        $fixedtgl = '';
        $status_csip = $request->status_csip;

        $surathost = config('app.surat_host').'assets/uploads/maker/draft/';
        $ttehost = config('app.surat_host').'CsubmitRekomNakes/gettteptsp';

        $data['isExist'] = 0;
        $data['surathost'] = $surathost;
        $data['success'] = false;

        if($status_csip == 'RCCS') {

            $draftcabut = $this->generateDraftSipPencabutan($id_sip, $id_pengajuan, $id_nakes, $status_csip);
            $data['draftcabut'] = $draftcabut;
            $data['success'] = true;
            $data['hasilnya'] = 'Berhasil Update Data Draft Pencabutan SIP';

            return response()->json($data);

        } else {

            try{
                $datatte_ = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
                    'Accept' => 'application/json',
                    'Referer' => config('app.surat_host'),
                    'Origin' => config('app.surat_host'),
                    'Accept-Language' => 'en-US,en;q=0.9'
                ])->get($ttehost);
                $datatte_status = $datatte_->status();
                if ($datatte_status == 200) {
                    $tte = $datatte_->json();
                    $nama_tte = $tte[0]['nama_tte'];
                    $pangkat_tte = $tte[0]['pangkat_tte'];
                    $isplt = $tte[0]['isplt'];
                    $nip_tte = $tte[0]['nip_tte'];
                    $drafter = $this->model->draftingPencabutanSip($id_sip, $nip_tte, $isplt, $nama_tte, $pangkat_tte, $template_id, $fixedtgl);
                    
                    if($drafter) {
                
                        $draftcabut = $this->generateDraftSipPencabutan($id_sip, $id_pengajuan, $id_nakes, $status_csip);
                        $data['draftcabut'] = $draftcabut;
                        $data['success'] = true;
                        $data['hasilnya'] = 'Berhasil Update Data Draft Pencabutan SIP';
                    } else {
                        $data['hasilnya'] = 'Gagal Update Data Draft Pencabutan SIP';
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

    
        
    }


    public function generateDraftSipPencabutan($id_sip, $id_pengajuan, $id_nakes, $status_csip) {

        $surathost = config('app.surat_host').'assets/uploads/maker/draft/';
        $draftsip = $this->model->getdraftsipcabut($id_sip);

        if($status_csip == 'D') {

            $hasildraft['surathost'] = $surathost;
            $hasildraft['thefile'] = $draftsip->filename_pencabutan;
            $data['resultdraft'] = $hasildraft;
            $data['success_draft'] = true;

        } else {

            $data['success_draft'] = false;
            $env = $this->model->getenv();
            $urlget = config('app.conv_host').'draftrekomnakes';
            $getfotostr = $this->model->getfotostr($id_pengajuan);
        
            if($draftsip) {

                $template_id = 'nakesc';
                $filename_sip = $draftsip->filename_pencabutan;
                //$no_rekomdinkes = $draftsip->no_rekomdinkes;
                $no_rekomdinkes = $draftsip->isapj;
                //$tgl_rekomdinkes = $this->help->tgl_indo_sip($draftsip->tgl_pencabutan);
                $tgl_rekomdinkes = $draftsip->tgl_verifdinkes;
                //$no_rekomp = $draftsip->no_rekomp;
                $no_rekomp = $draftsip->no_rekomc;
                //$tgl_rekomp = $draftsip->tgl_rekomp;
                $tgl_rekomp = $draftsip->tgl_rekomc;
                $nama_nakes = $draftsip->nama_nakes;
                $ttl_nakes = $draftsip->ttl_nakes;
                $alamat_nakes = $draftsip->alamat_nakes;
                $no_str = $draftsip->no_str;
                $tgl_berlaku = $draftsip->tgl_berlaku;
                $tgl_doc = $draftsip->tgl_doc;
                $kompetensi = $draftsip->no_surat;
                $profesi = strtoupper($draftsip->profesi);
                $nama_lokasi = $draftsip->nama_lokasi;
                $kec_lokasi = $draftsip->kec_lokasi;
                $kab_lokasi = $draftsip->kab_lokasi;
                $no_surat = $draftsip->no_surat_pencabutan;
                $is_plt = $draftsip->is_plt_c;
                $nama_tte = $draftsip->nama_tte_c;
                $pangkat_tte = $draftsip->pangkat_tte_c;
                $nip_tte = $draftsip->nip_tte_c;
                $salinan_terbilang = $draftsip->alasan_tercetak;
                $salinan = $draftsip->salinan;
                $jenis_profesi = $draftsip->jenis_profesi;
                $isSementara = $draftsip->jadwal_praktek;
                $nama_faskes = $draftsip->nama_faskes;
                if ($draftsip->nama_faskes == '') {

                    $nama_faskes = $draftsip->nama_lokasi.', Kecamatan '.$kec_lokasi.' Kabupaten'.$kab_lokasi;
                }

                $getjadwal = $this->model->getjadwalnakes($id_nakes, $salinan);
                $jadwaljson = json_encode($getjadwal);

                $thefile = fopen('../storage/app/fotostr/bening.jpeg','r');
                $perdata = [
                    'env' => $env,
                    'template_id' => $template_id,
                    'filename_sip' => $filename_sip,
                    'no_rekomdinkes' => $no_rekomdinkes,
                    'tgl_rekomdinkes' => $tgl_rekomdinkes,
                    'no_rekomp' => $no_rekomp,
                    'tgl_rekomp' => $tgl_rekomp,
                    'nama_nakes' => $nama_nakes,
                    'ttl_nakes' => $ttl_nakes,
                    'alamat_nakes' => $alamat_nakes,
                    'no_str' => $no_str,
                    'tgl_berlaku' => $tgl_berlaku,
                    'tgl_doc' => $tgl_doc,
                    'kompetensi' => $kompetensi,
                    'profesi' => ucwords($profesi),
                    'nama_faskes' => $nama_faskes,
                    'nama_lokasi' => $nama_lokasi,
                    'kec_lokasi' => $kec_lokasi,
                    'kab_lokasi' => $kab_lokasi,
                    'no_surat' => $no_surat,
                    'is_plt' => $is_plt,
                    'nama_tte' => $nama_tte,
                    'pangkat_tte' => $pangkat_tte,
                    'nip_tte' => $nip_tte,
                    'salinan_terbilang' => $salinan_terbilang,
                    'id_nakes' => $id_nakes,
                    'salinan' => $salinan,
                    'foto_nakes' => $getfotostr,
                    'jadwal_praktek' => $jadwaljson,
                    'jenis_profesi' => $jenis_profesi,
                    'isSementara' => $isSementara
                ];
                $response_ = Http::attach('filefoto', $thefile, $getfotostr)->post($urlget, $perdata);
                $hasildraft = $response_->json();
                $status_draft = $response_->status();

                if ($status_draft == 200) {
                    $data['resultdraft'] = $hasildraft;
                    $data['success_draft'] = true;
                    $this->model->setstatuscabutsip($id_sip, 'D');
                    

                } else {
                    $data['response_draft'] = $status_draft;
                    $data['keterangan'] = $response_->body();
        
                }

            }

        }

        

        //return response()->json($data);
        return $data;
        
        
    }



    public function submitcabutsipasoka(Request $request) {

        $data['success'] = false;
        $id_pengajuan = $request->id_pengajuan;
        $id_sip = $request->id_sip;
        $updater = $request->updater;
        $getdraftsip = $this->model->getdraftsipcabut($id_sip);
        $salinanori = $this->model->getsalinansip($id_pengajuan);
        $foto_nakes = $this->model->getfotonakes($id_pengajuan);
        $getperpanjangan = $this->model->getperpanjangan($id_pengajuan);
        if($getdraftsip) {
            $filename_sip = $getdraftsip->filename_pencabutan;
            $nama_nakes = $getdraftsip->nama_nakes;
            $no_str = $getdraftsip->no_str;
            $no_sip = "DRAFT PENCABUTAN SIP".$getdraftsip->no_surat;
            $template_id = 'c';
            //$no_rekomp = $getdraftsip->no_rekomp;
            $no_rekomp = $getdraftsip->no_rekomc;
            //$tgl_rekomp = $getdraftsip->tgl_rekomp;
            $tgl_rekomp = $getdraftsip->tgl_rekomc;
            //$no_rekomdinkes = $getdraftsip->no_rekomdinkes;
            $no_rekomdinkes = $getdraftsip->isapj;
            //$tgl_rekomdinkes = $this->help->tgl_indo_sip($getdraftsip->tgl_pencabutan);
            $tgl_rekomdinkes = $getdraftsip->tgl_verifdinkes;
            $nama_nakes = $getdraftsip->nama_nakes;
            $ttl_nakes = $getdraftsip->ttl_nakes;
            $alamat_nakes = $getdraftsip->alamat_nakes;
            $salinan_terbilang = $getdraftsip->alasan_tercetak;
            $tgl_berlaku = $getdraftsip->tgl_berlaku;
            $tgl_doc = $getdraftsip->tgl_doc;
            $kompetensi = $getdraftsip->no_surat;
            $profesi = ucwords($getdraftsip->profesi);
            $nama_faskes = $getdraftsip->nama_faskes;
            $nama_lokasi = $getdraftsip->nama_lokasi;
            $kec_lokasi = $getdraftsip->kec_lokasi;
            $kab_lokasi = $getdraftsip->kab_lokasi;
            $salinan = $getdraftsip->salinan;
            $id_nakes = $getdraftsip->id_nakes;
            $is_plt = $getdraftsip->is_plt_c;
            $nama_tte = $getdraftsip->nama_tte_c;
            $pangkat_tte = $getdraftsip->pangkat_tte_c;
            $nip_tte = $getdraftsip->nip_tte_c;
            $jenis_profesi = $getdraftsip->jenis_profesi;
            $perubahan = $getdraftsip->perubahan;
            $isSementara = $getdraftsip->jadwal_praktek;

            if ($getdraftsip->nama_faskes == '') {
                $nama_faskes = $getdraftsip->nama_lokasi.', Kecamatan '.$kec_lokasi.' Kabupaten'.$kab_lokasi;
            }

            $getjadwal = $this->model->getjadwalnakes($id_nakes, $salinan);
            $jadwaljson = json_encode($getjadwal);

        }

        $env = $this->model->getenv();

        // if ($env == 'prd') {
        //     $urlget = 'https://surat.cilacapkab.go.id/CsubmitRekomNakes/submitRekomNakes';
        //     $liatdraft = 'https://surat.cilacapkab.go.id/assets/uploads/maker/draft/';
        // } else if ($env == 'uat') {
        //     $urlget = 'https://surat2.cilacapkab.go.id/CsubmitRekomNakes/submitRekomNakes';
        //     $liatdraft = 'https://surat2.cilacapkab.go.id/assets/uploads/maker/draft/';
        // } else {
        //     $urlget = 'http://dev1.cilacapkab.go.id/CsubmitRekomNakes/submitRekomNakes';
        //     $liatdraft = 'http://dev1.cilacapkab.go.id/assets/uploads/maker/draft/';
        // }

        $urlget = config('app.surat_host').'CsubmitRekomNakes/submitRekomNakes';
        $liatdraft = config('app.surat_host').'assets/uploads/maker/draft/';

        try {

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

            $response_ = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
                'Accept' => 'application/json',
                'Referer' => config('app.surat_host'),
                'Origin' => config('app.surat_host'),
                'Accept-Language' => 'en-US,en;q=0.9'
            ])->asForm()->post($urlget, $datapost);
            $response_status = $response_->status();
            $response = $response_->json();

            if ($response_status == 200) {
                //$this->model->updatesipcancelstatus($id_pengajuan, $updater);
                $data['success'] = true;
                $data['keterangan'] = $response;
                $this->model->setstatuscabutsip($id_sip, 'A');
                return response()->json($data);

            } else if ($response_status == 201) {

                $data['keterangan'] = 'Data Sudah Pernah Disubmit';
                $this->model->setstatuscabutsip($id_sip, 'A');
                return response()->json($data);

            } else {
                $ket = $response_->body();
                //$data['datapost'] = $datapost;
                $data['keterangan'] = $ket;
                return response()->json($data);
            }


        }catch(Exception $e) {

            $data['error'] = $e;
            return response()->json($data);
            
        }

    }

    public function lihatdokpencabutansip(Request $request) {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Memuat Dokumen Pencabutan SIP';
        $id_sip = $request->id_sip;
        $getdraftsip = $this->model->getdraftsipcabut($id_sip);
        if($getdraftsip) {

            if($getdraftsip->suratpencabutan == 'A') {

                $suraturl = config('app.surat_host').'assets/uploads/maker/draft/';

            } else {

                $suraturl = config('app.surat_host').'assets/uploads/maker/approved/';
            }

            $thefile = $getdraftsip->filename_pencabutan;
            $no_surat = $getdraftsip->no_surat_pencabutan;
            $data['success'] = true;
            $data['surathost'] = $suraturl;
            $data['thefile'] = $thefile;
            $data['keterangan'] = 'Berhasil Memuat Dokumen Pencabutan SIP';

        }

        return response()->json($data);

    }

    public function listsipperprofesi(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mengambil Data SIP Per Profesi';

        $result = $this->model->listsipperprofesi($request);
        
        if($result) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Ambil Data SIP Per Profesi';
            $data['result'] = $result;
            
        }
        return response()->json($data);

    }

    public function hapussiplama(Request $request) {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Menghapus Pengajuan SIP Lama';

        $result = $this->model->hapussiplama($request);
        
        if($result) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Menghapus Pengajuan SIP Lama';
            //$data['result'] = $result;
            
        }
        return response()->json($data);

    }

    public function adminprofile(){

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['email'] = Auth::user()->username;
        

        return view('adminprofile', $data);

    }

    public function submitsupbeforeesip(Request $request){

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Submit SIP Sebelum e-SIP';
        $id_user = $request->tUserIdBeforeSip;

        if($request->hasFile('tFileSipBeforeSip')){

            $request->validate([
                'fLogoFaskes' => 'file|mimes:pdf|max:5120',
            ]);


            $thefile = $request->file('tFileSipBeforeSip');
            $extension = $request->file('tFileSipBeforeSip')->extension();
            $filenamenya = 'SIPB_'.$id_user;
    
            try{

                $path = Storage::putFileAs('/uploaddoc', $thefile, $filenamenya.'.'.$extension);
                $namafile = $filenamenya.'.'.$extension;
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
                $getexistingbefore = $this->model->getexistingbefore($request);
                if($getexistingbefore) {
                    $data['keterangan'] = 'SIP Telah Diupload Sebelumnya';
                } else {

                    $result = $this->model->submitsupbeforeesip($request, $filenamenya);
                    if($result) {
                        $data['success'] = true;
                        $data['keterangan'] = 'Berhasil Submit SIP Sebelum e-SIP';
                    }
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

    public function submitttekadin(Request $request)
    {

        $data['success'] = false;
        $data['keterangan'] = "Proses TTE Surat Keterangan Dinas Kesehatan Berhasil";
        $id_tte = $request->id_tte;
        $passphrase = $request->passphrase;
        $filename_sip = $request->filename_tte;
        $iscabut = $request->iscabut_tte_kadin;
        $id_pengajuan = $request->idpengajuan_tte_kadin;

        $getnik = $this->model->getniktte($id_tte);
        if($getnik) {

            $nik = $getnik->photo_url;
            $datatte = [
                'nik' => $nik,
                'passphrase' => $passphrase,
                'filename_sip' => $filename_sip
            ];
            $urlget = config('app.surat_host').'CsubmitRekomNakes/submitTteRekomNakes';
            $response_ = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
                'Accept' => 'application/json',
                'Referer' => config('app.surat_host'),
                'Origin' => config('app.surat_host'),
                'Accept-Language' => 'en-US,en;q=0.9'
            ])->asForm()->post($urlget, $datatte);
            $hasiltte = $response_->json();
            $status_tte = $response_->status();

            
    
            if ($status_tte == 200) {
    
                $tte_status = $hasiltte['status'];
                if($tte_status == 'done') {
    
                    $datasktte = $hasiltte['detailsurat'];
                    $detailjadwal = $datasktte['detailjadwal'];
                    $no_surat = $datasktte['no_surat'];
                    $signed_date = $datasktte['signed_date'];

                    $updatesk = $this->model->updatestatussip($id_pengajuan, $filename_sip, $detailjadwal, $no_surat, $signed_date);
                    if($updatesk) {
                        $data['keterangan'] = 'Proses TTE dan Update Data SIP Berhasil';
                    } else {
                        $data['keterangan'] = 'Proses TTE Berhasil, Namum Data Pengajuan Gagal Diupdate, Silahkan Lakukan Sinkronisasi';
                    }
                    //$data['result'] = $hasiltte;
                    $data['success'] = true;
                    $data['keterangan'] = 'Berhasil Memproses TTE e-SIP';
    
                } else {
                    $data['keterangan'] = $hasiltte['keterangan'];
                }
    
            } else {
    
                $data['response_tte'] = $status_tte;
                $data['keterangan'] = $response_->body();
    
            }

        } else {
            $data['keterangan'] = 'NIK Tidak Ditemukan Untuk User Ini, Silahkan Hubungi Administrator';
        }
        
        return $data;

    }

    public function gethistoripengajuanapproval(Request $request)
    {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mendapatkan Data Pengajuan';

        $result = $this->model->gethistoripengajuanapproval($request);
        
        if($result) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Data Pengajuan Berhasil Dimuat';
            $data['pengajuan'] = $result;
            //$data['result'] = $result;
            
        }
        return response()->json($data);


    }

    public function gethistoripendaftaran(Request $request)
    {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mendapatkan Data Pengajuan';

        $result = $this->model->gethistoripendaftaran($request);
        
        if($result) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Data Pengajuan Berhasil Dimuat';
            $data['pengajuan'] = $result;
            //$data['result'] = $result;
            
        }
        return response()->json($data);

    }

    public function gethistoridaftarapprove(Request $request)
    {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mendapatkan Data Approval Pendaftaran';

        $result = $this->model->gethistoridaftarapprove($request);
        
        if($result) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Data Approval Pendaftaran Berhasil Dimuat';
            $data['pendaftaran'] = $result;
            //$data['result'] = $result;
            
        }
        return response()->json($data);

    }

    public function updatefotonakes(Request $request)
    {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Update Foto Nakes';
        $file = $request->file('tFotoEdit');
        $id_user = $request->idusereditfoto;
        $getid = $this->model->getiduser($id_user);
        $imageName = $getid.'.jpeg';
        try {
            $file->storeAs('fotostr', $imageName);
            $result = $this->model->updatefotonakes($getid, $imageName);
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Update Foto Nakes';
            return response()->json($data);

        }catch(Exception $e) {

            $data['error'] = $e;
            return response()->json($data);
        }

        
        
    }

    public function reverttte(Request $request)
    {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mengembalikan Status TTE Permohonan';

        $id_pengajuan = $request->id_pengajuan;
        $getfilenamesurat = $this->model->getfilenamesurat($id_pengajuan);
        $alasan_revert = $request->alasan_revert;
        $datatte = [
            'filename' => $getfilenamesurat
        ];
        $urlget = config('app.surat_host').'SubmitDataMpp/revertsuratmpp';
        $response_ = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
            'Accept' => 'application/json',
            'Referer' => config('app.surat_host'),
            'Origin' => config('app.surat_host'),
            'Accept-Language' => 'en-US,en;q=0.9'
        ])->asForm()->post($urlget, $datatte);
        $hasilrevert = $response_->json();
        $status_tte = $response_->status();

        if ($status_tte === 200 && !empty($hasilrevert['keterangan'])) {

            $updatestatus = $this->model->updatestatuspengajuan($id_pengajuan, '', 'revert', $alasan_revert ,'');
            if($updatestatus) {
                $data['keterangan'] = 'Berhasil Mengembalikan Status Permohonan';
                $data['success'] = true;
            } else {
                $data['keterangan'] = 'Data TTE Berhasil Dihapus Dari ASOKA tetapi Gagal Update Data Pada e-SIP';
            }

        }

        return response()->json($data);

    }

    public function ubahukuranfotosip(Request $request)
    {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Update Ukuran Foto Pada e-SIP';

        $result = $this->model->ubahukuranfotosip($request);
        
        if($result) {
            
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Update Ukuran Foto Pada e-SIP';
            //$data['result'] = $result;
            
        }
        return response()->json($data);

    }

    public function adminupdatestrnakes()
    {

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;

        return view('ptsp/adminstrupdater', $data);

    }

    public function scantoupdatestr($id_pendaftar)
    {

        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;
        $data['role'] = Auth::user()->role;
        $data['semuaprofesi'] = $this->model->getallprofesi();
        $getdetailnakes =  $this->model->getdetailnakesbyidpendaftar($id_pendaftar);
        if($getdetailnakes) {

            $data['detailnakes'] = $getdetailnakes;
            return view('ptsp/scantoupdatestr', $data);

        } else {

            return view('ptsp/adminstrupdater', $data);
        }
        
    }

    public function nvupdatestrbyadmin(Request $request){


        if($request->hasFile('tFileSTR')){

            $request->validate([
                'tFileSTR' => 'file|mimes:pdf|max:5120',
            ]);


            $data['success'] = false;
 
            $thefile = $request->file('tFileSTR');
            $extension = $request->file('tFileSTR')->extension();
            $filenamenya = $request->file('tFileSTR')->getClientOriginalName();

            
            $encrypted = $this->random_string(25);
            $namafile = $encrypted.'.'.$extension;

            try{

                
                $path = Storage::putFileAs('/perpanjangan', $thefile, $encrypted.'.'.$extension);
                Storage::disk('public_upload')->put($namafile, file_get_contents($thefile));
                Storage::copy('perpanjangan/'.$encrypted.'.pdf', 'daftar/'.$encrypted.'.pdf');
                $data['filenamestr'] = $encrypted;
                $data['keterangan'] = 'Upload STR Sukses';
                $data['success'] = true;
                
                return response()->json($data);
                //return redirect()->route('daftar.nakes')->with('alert', 'Data berhasil disimpan');

            }catch(Exception $e) {
                //$data['succees'] = false;
                $data['filenamestr'] = $encrypted;
                $data['keterangan'] = 'Upload STR Gagal';
                $data['error'] = $e;
                return response()->json($data);

            }
            

        }
    }

    public function processperpanjanganbyadmin(Request $request)
    {
        $data['success'] = false;
        $data['keterangan'] = 'Perpanjangan STR Gagal, Silahkan Coba Lagi';

        try{

            $perpanjangan = $this->model->processperpanjanganbyadmin($request);
            if($perpanjangan) {
                $data['success'] = true;
                $data['keterangan'] = 'Pengajuan Berhasil Diproses Oleh Sistem, Lakukan Pengecheckan Informasi Secara Rutin';
            } else {
                $data['keterangan'] = 'Perpanjangan STR Gagal, Silahkan Coba Lagi';
            }
            
            return response()->json($data);

        }catch(Exception $e) {

            //return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Memproses Pengajuan, Silahkan Coba Kembali Beberapa Saat');
            $data['keterangan'] = $e;
            $this->model->erropengajuanlog($e, $request);
            return response()->json($data);

        }
    }

    public function reaktifasinakes(Request $request)
    {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Update Status Aktif User';

        try{

            $updatestatus = $this->model->reaktifasinakes($request);
            if($updatestatus) {
                $data['success'] = true;
                $data['keterangan'] = 'Berhasil Update Status Aktif User';
            } else {
                $data['keterangan'] = 'Gagal Update Status Aktif User';
            }
            
            return response()->json($data);

        }catch(Exception $e) {

            //return redirect()->route('nakes.dashboard')->with('alert', '9Gagal Memproses Pengajuan, Silahkan Coba Kembali Beberapa Saat');
            $data['keterangan'] = $e;
            return response()->json($data);

        }

    }

    public function getsummarylayanan(Request $request)
    {
        $data = $this->model->getsummarylayanan($request);
        return $data;
    }

    public function getcurrentprofesi(Request $request)
    {
        $data = $this->model->getcurrentprofesi($request);
        return $data;

    }

    public function getlistforbidfar(Request $request)
    {

        $data = $this->model->getpengajuan('cabutfar');
        return $data;

    }

    public function detailsipuntukcabut(Request $request)
    {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mendapatkan Detail Pencabutan';
        $surathost = config('app.surat_host').'assets/uploads/maker/approved/';
        $id = $request->id;
        $result = $this->model->getdetailpengajuan($id);
        if($result)
        {
            $data['success'] = true;
            $data['result'] = $result;
            $data['keterangan'] = 'Sukses Mendapatkan Detail Pencabutan';
            $data['surat_host'] = $surathost;
            $data['log_cabut'] = $this->model->getlogcabut($request);
            
        }
        return $data;

    }

    public function setujupencabutanbidfar(Request $request)
    {

        $data['success'] = false;
        
        $now = date('Y-m-d');
        $tgl_setuju = $this->help->tgl_indo_sip($now);
        if($request->has('pesan'))
        {
            $data['keterangan'] = 'Gagal Kirim Pesan Pencabutan';

            $result = $this->model->updatedokpencabutanlog($request);
            if($result)
            {
                $data['success'] = true;
                $data['keterangan'] = 'Berhasil Update Pesan';
                $data['pesan'] = $request->pesan;
                $data['updated_at'] = date('Y-m-d H:i:s');

                $getnowa = DB::table('tbl_pendaftaran')
                    ->select('notelp','nama')
                    ->where('id_user', $request->id_nakes)
                    ->first();
                if($getnowa) {
                    $pesanwa = "Proses Pencabuta Anda Mendapat Pesan Dari Admin E-SIP : ". $request->pesan;
                    $nomorwa = $getnowa->notelp;
                    $this->sendnotifwa($nomorwa, $pesanwa);
                }

            }
            

        } else {

            $data['keterangan'] = 'Gagal Persetujuan Pencabutan';

            $result = $this->model->setujupencabutanbidfar($request, $tgl_setuju);
            if($result)
            {
                $data['success'] = true;
                $data['result'] = $result;
                $data['keterangan'] = 'Sukses Persetujuan Pencabutan';
                
            }

        }
        
        return $data;

    }

    

    public function getdetailrekomc(Request $request)
    {
        $data['id_pengajuan'] = $request->id_pengajuan;
        $data['salinan'] = $request->salinan;
        return $data;
    }

    
    public function adminchat()
    {
        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $data['role'] = Auth::user()->role;
        $nama = Auth::user()->name;
        $id = Auth::user()->id;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;


        return view('ptsp/adminchat', $data);
    }

    public function chatwithai(Request $request)
    {

        $data = $this->model->chatwithai($request);
        return $data;


    }

    public function setreminder(Request $request)
    {
        $data['success'] = true;
        $result = $this->model->setreminder($request);
        if($result['send'] == true) {
            //$this->sendnotifwa($result['nowa'], $result['pesan']);
            $this->sendnotifwa('082211718526', $result['pesan']);
            $this->model->sendtoreminder($request->kategori, $request->id_pengajuan);
        }
        return response()->json($data);

    }

    public function getcekkecukupan(Request $request)
    {
        $data['success'] = false;
        $filename = str_ireplace('.pdf', '', $request->filename);
        $urlget = config('app.cv2_host').'convertandextract';
        $extensionpos = '.pdf';

        try{

            $response_ = Http::timeout(10)->asForm()->post($urlget, ['thename'=>$filename, 'extension' => $extensionpos, 'jenis' => 'skskp']);
            $response_status = $response_->status();
            $response = $response_->json();
            
            if ($response_status == 200) {

                if($response != null)
                {
                    $dcd = json_decode($response_);
                    if (!empty($dcd->thelink)) {
                        $data['success'] = true;
                        $data['thelink'] = $dcd->thelink;
                    }

                }
                
            } 

        } catch (\Exception $e) {
            // ❌ Any other unexpected error
            $data['error'] = $e;
        }

        return $data;

    }


    public function supernakesdetail(Request $request)
    {
        $id_nakes = $request->id_nakes;
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mendapatkan Detail Nakes Untuk Superadmin';
        $result = $this->model->supernakesdetail($id_nakes);
        if($result)
        {
            $data['success'] = true;
            $data['result'] = $result;
            $data['keterangan'] = 'Sukses Mendapatkan Detail Nakes Superadmin';
            
        }
        return $data;

    }

    public function superadminpengajuan()
    {
        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $data['role'] = Auth::user()->role;
        $nama = Auth::user()->name;
        $id = Auth::user()->id;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;


        return view('superadmin/superadminpengajuan', $data);

    }

    public function superadminnotifikasi()
    {
        $todays = date('Y-m-d');
        $data['todays'] = $todays;
        $data['role'] = Auth::user()->role;
        $nama = Auth::user()->name;
        $id = Auth::user()->id;
        $data['user_id'] = $id;
        $data['nama_user'] = $nama;


        return view('superadmin/superadminnotifikasi', $data);

    }


    public function testkoneksiwa(Request $request)
    {
        $request->validate([
            'nomorWA' => 'required',
            'pesannya' => 'required',
        ]);
        $nomor = $request->nomorWA;
        $pesan = $request->pesannya;

        $result = $this->sendnotifwasp($nomor, $pesan);

        return response()->json([
            'http_status' => $result['http_status'],
            'success'     => $result['success'],
            'message'     => $result['body'],
            'curl_error'  => $result['curl_error'],
        ]);
    }

    public function getlogwabyname(Request $request)
    {
        
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mendapatkan Informasi Nakes';
        $result = $this->model->getlogwabyname($request);
        if($result)
        {
            $data['success'] = true;
            $data['result'] = $result;
            $data['keterangan'] = 'Sukses Mendapatkan Informasi Nakes';
            
        }
        return $data;

    }

}
