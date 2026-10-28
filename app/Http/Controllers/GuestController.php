<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuestModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Helpers\QrCodeReader;

class GuestController extends Controller
{
    /** @var GuestModel */
    protected $model;

    public function __construct(){
        $this->model = new GuestModel;
    }

    public function index(){
        //
        return view('landing');
    
    }

    public function maintenance(){
        //
        return view('guests/maintenance');
    
    }

    public function sendnotifwa($nomor,$pesan){

        
        $sender = config('app.no_ptsp');
        $urlget = config('app.wa_host');
        $response = Http::post($urlget, ['sender'=>$sender, 'number' => $nomor, 'message' => $pesan]);
        if ($response->failed()) {
            return true;
        } else {
            return true;
        }
        

    }

    public function lupapassword(){

        return view('guests/lupapassword');

    }

    public function guestsubmitcred(Request $request){

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mendapatkan Kode Reset Password';
        $nomorwa = $request->lpnohp;

        $hasilcek = $this->model->guestsubmitcred($request);
        if ($hasilcek) {

            $data['email'] = $request->lpemail;
            $data['nohp'] = $request->lpnohp;
            $data['resetcode'] = $hasilcek;
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Mendapatkan Kode Reset Password';
            $pesanadmin = 'Kode Perubahan Password Untuk Username / Email: '.$request->lpemail.' Adalah: '.$hasilcek;
            $this->sendnotifwa($nomorwa, $pesanadmin);

        }
        
        return response()->json($data);

    }

    public function guestresetpass(Request $request)
    {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Dalam Proses Reset Password';
        $resetcode = $request->lpkodereset;
        $email = $request->lpemailtoreset;
        $checkcode = $this->model->checkcode($resetcode, $email);
        if($checkcode) {

            $nomorwa = $request->lpnohporeset;
            $updatepass = $this->model->updatepass($request);
            if ($updatepass) {

                $data['success'] = true;
                $data['keterangan'] = 'Berhasil Dalam Proses Reset Password';
                $pesanadmin = 'Password Anda Dengan Email / Username:'.$request->lpemailtoreset.' Berhasil Diubah: '.$updatepass;
                $this->sendnotifwa($nomorwa, $pesanadmin);

            }

        } else {
            $data['keterangan'] = 'Kode Yang Anda Inputkan Salah';
        }

        
        
        return response()->json($data);

    }

    public function asistensi(){

        //
        $data['listOPD'] = $this->model->getlistOPD();
        $data['listApp'] = $this->model->getlistApp();
        $data['todays'] = date('Y-m-d');
        return view('asistensi', $data);
    
    }

    

    public function daftarnakes(){

        //
        $data['todays'] = date('Y-m-d');
        $data['semuaprofesi'] = $this->model->getallprofesi();
        return view('guests/pendaftarannakes', $data);
    
    }

    public function random_string($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
    
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
    
        return $key;
    }

    public function daftarsubmit(Request $request){


        if($request->hasFile('tFileSTR')){

            $request->validate([
                'tFileSTR' => 'file|mimes:pdf|max:5120',
            ]);

            $data['success'] = false;
            $data['success_extract'] = false;

            
            $thefile = $request->file('tFileSTR');
            $extension = $request->file('tFileSTR')->extension();
            $filenamenya = $request->file('tFileSTR')->getClientOriginalName();

            


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
                        $data['rstat'] = $response_status;

                        if (Str::contains($dcd->thelink, 'ktki')) {
                            $urlextractor = config('app.ocr_host').'extractstrmanualnew';
                        } else {
                            $urlextractor = config('app.ocr_host').'extractstr';
                        }

                        
                        $filestr = fopen('../storage/app/daftar/'.$encrypted.'.png','r');
                        $extractres_ = Http::attach('filestr', $filestr, $encrypted.'.png')->post($urlextractor, ['thename'=>$encrypted, 'extension' => $extensionpos]);
                        $extractres = $extractres_->json();
                        $status_extractor = $extractres_->status();

                        if ($status_extractor == 200) {
                            $data['resultword'] = $extractres;
                            $data['success_extract'] = true;
                        }

                    }

                    $this->model->postlogdaftar($dcd->thelink, $encrypted, 'insert', '0', $response);

                    
                    
                } elseif ($response_status == 201) {
                    $data['keterangan'] = 'Gagal Extract Data QRCODE dari Penyedia e-STR / Format Informasi Mengalami Perubahan';
                    $data['rstat'] = $response_status;
                } else {
                    $data['keterangan'] = 'Gagal Extract data QRCODE STR';
                    $data['rstat'] = $response_status;
                }
                
                return response()->json($data);

            }catch(Exception $e) {
                //$data['succees'] = false;
                $data['error'] = $e;
                return response()->json($data);

            }
        }
    }

    public function permohonansimpan(Request $request){

        try{
            $this->model->permohonansimpan($request);
            return redirect()->route('asistensi')->with('alert', 'Data berhasil disimpan');
        }catch(Exception $e) {
            return redirect()->route('asistensi')->with('alert', 'Gagal');
        }
    }

    public function getevent(Request $request){
        $data['events'] = $this->model->getevents();
        return response()->json($data);
    }

    public function geteventadmin(Request $request){
        $data['events'] = $this->model->geteventsadmin($request);
        return response()->json($data);
    }

    public function detailevent(Request $request){
        $result = $this->model->getdetailevent($request);
        echo json_encode($result);
    }


    public function reviewsimpan(Request $request){

        $resulta = $this->model->reviewsimpan($request);

        if($resulta){
            $msg['success'] = true;
        }
        echo json_encode($msg);
    }


    public function getdatastrdaftar(Request $request) {

        $geturl = $request->thename;
        $thelinker = $request->thelinker;
        $skipped = $request->skipped;
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Ekstrak Data Dari URL QRCODE STR';
        if ($thelinker == 1) {

            $urlget = config('app.warehouse_host').'getdatanakes_ceks';
            //$urlget = 'http://172.16.200.28:5989/getdatanakes_ceks';
            

        } else if ($thelinker == 2) {

            $urlget = config('app.warehouse_host').'getdatanakes_dok';
            //$urlget = 'http://172.16.200.28:5989/getdatanakes_dok';

        } else {

            $urlget = config('app.warehouse_host').'getdatanakes';
            //$urlget = 'http://172.16.200.28:5989/getdatanakes';

        }
        //$this->sendnotifwa('082211718526', 'Test Message');

        $response_ = Http::asForm()->post($urlget, ['thename'=>$geturl]);
        $response = $response_->body();
        $cleanResponse = preg_replace('/[\x00-\x1F\x7F]/u', '', $response);
        $status_response = $response_->status();
        
        if($status_response == '200') {
            $resdec = json_decode($cleanResponse);
            $this->model->postlogdaftar($geturl, 'scanned', 'insert', $skipped, $response);
            if(strtoupper($resdec->str_hingga_sip) === 'SEUMUR HIDUP') {
                $resdec->selisihtanggal = 99999;
            } else {
                $selisihtanggal = $this->model->cobaselisih($resdec->str_hingga_sip);
                $resdec->selisihtanggal = $selisihtanggal;
            }
            
            $resen = json_encode($resdec);
            return response()->json($resen);
        } else {
            return response()->json($data);
        }
        
    }

    public function getdatastrdaftardev(Request $request) {

        $geturl = $request->thename;
        $thelinker = $request->thelinker;
        $checkenv = $this->model->getenv();
        $data['success'] = false;
        $data['keterangan'] = 'QRCODE hanya berlaku untuk environment DEVELOPMENT!';

        if ($checkenv == 'dev') {

            $urlget = config('app.warehouse_host').'getdatanakes';
            $response = Http::asForm()->get($geturl, ['thename'=>$thelinker])->body();
            $resdec = json_decode($response);
            $selisihtanggal = $this->model->cobaselisih($resdec->str_hingga_sip);
            $resdec->selisihtanggal = $selisihtanggal;
            $resen = json_encode($resdec);
            
            return response()->json($resen);

        } else {
            return response()->json($data);
        }

        
        
        
    }

    public function lanjutpendaftaran(Request $request) {

        try{

            $url_qr = $request->stURL;
            $origin_file = $request->stWhichF;
            $bisalanjut = $this->model->postlogdaftar($url_qr, $origin_file, 'check', '0', null);
            $tidakvalid = $request->stStatDok;
            if($tidakvalid == 'Tidak Valid')
            {
                return redirect()->route('daftar.gagal')->with('alert', 'Gagal');
            }
            //dd($request);
            if($bisalanjut) {

                $ifexists = $this->model->checkexisting($request);
                if($ifexists > 0) {
                    return view('guests/exists')->with('alert', '9Gagal Pendaftaran Karena Data Sudah Terpakai');
                } else {

                    $id_pendaftaran = $this->model->lanjutpendaftaran($request);
                    if($request->hasFile('stFotoJika')){
                        $thefile = $request->file('stFotoJika');
                        $request->validate([
                            'stFotoJika' => 'file|mimes:jpg|max:5120',
                        ]);                    
                        $path = Storage::putFileAs('/fotokosong', $thefile, $id_pendaftaran.'.jpg');
                        $this->model->updatetidakfoto($id_pendaftaran);
                        return redirect()->route('daftar.sukses')->with('alert', '1Data berhasil disimpan');

                    } else {
                        return redirect()->route('daftar.sukses')->with('alert', '1Data berhasil disimpan');
                    }

                }

            } else {
                return redirect()->route('daftar.gagal')->with('alert', 'Gagal');
            }

            

        }catch(Exception $e) {

            return redirect()->route('daftar.gagal')->with('alert', 'Gagal');

        }

    }

    public function daftarsukses(){

        $data['todays'] = date('Y-m-d');
        return view('guests/sukses', $data);

    }

    public function daftargagal(){

        $data['todays'] = date('Y-m-d');
        return view('guests/gagal', $data);

    }

    public function checksip($filename){

        $alldetail = $this->model->getdetailsip($filename);
        if($alldetail) {
            $data['alldetail'] = $alldetail;
            $id_user = $data['alldetail']->id_nakes;
            $salinan = $data['alldetail']->salinan;
            $data['jadwalnakes'] = $this->model->getjadwalnakes($filename);
            $issk = substr($filename, 0, 2);
            if($issk == 'SK') {
                return view('guests/detailsk', $data);
            } else {
                return view('guests/detailsip', $data);
            }
        } else {
            return view('guests/gagal');
        }
        


    }

    public function masterprofesi(Request $request){

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mendapatkan Master Data Profesi';

        $hasilcariprof = $this->model->cariprofesi($request);
        if ($hasilcariprof) {
            $data['resultprofesi'] = $hasilcariprof;
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Mendapatkan Master Data Profesi';
        }
        
        return response()->json($data);

    }

    public function testconvertjpg(Request $request){

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mendapatkan Master Data Profesi';

        $convert = $this->model->convert($request);
        if ($convert) {
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Mendapatkan Master Data Profesi';
        }
        
        return response()->json($data);

    }


    public function readQrCodeFromPdf()
    {
        try {
            // Validate the file input

            $pdfFile = fopen('../storage/app/converted/SKSKP.pdf','r');

            // Specify the temporary directory to extract images
            $tempDir = sys_get_temp_dir();

            // Convert PDF to images
            $images = $this->convertPdfToImages($pdfFile, $tempDir);

            // Loop through the images and attempt to decode QR codes
            $qrCodeData = [];
            foreach ($images as $image) {
                $decoded = QrCodeReader::decodeFile($image);
                if ($decoded !== null) {
                    $qrCodeData[] = $decoded;
                }
            }

            // Return the QR code data
            return response()->json(['qr_code_data' => $qrCodeData]);

        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Helper function to convert PDF to images
    private function convertPdfToImages($pdfFile, $tempDir)
    {
        $pdfPath = $pdfFile;

        // Use a PDF to Image conversion library (e.g. imagick)
        if (! class_exists(\Imagick::class)) {
            throw new \RuntimeException('The Imagick extension is required to convert PDF pages to images.');
        }

        $imagick = new \Imagick();
        $imagick->readImage($pdfPath);

        $images = [];
        foreach ($imagick as $pageNumber => $image) {
            // Save each page as an image
            $imagePath = $tempDir . '/page_' . $pageNumber . '.png';
            $image->writeImage($imagePath);
            $images[] = $imagePath;
        }

        return $images;
    }

  


    


}
