<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchedulerModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProcessNotif;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use PhpOffice\PhpWord\Element\InlineImage;
use PhpOffice\PhpWord\Shared\Converter;


use App\Helpers\Help;

class SchedulerController extends Controller
{
    /** @var SchedulerModel */
    protected $model;

    /** @var Help */
    protected $help;

    public function __construct(){
        $this->model = new SchedulerModel;
        $this->help = new Help;
    }

    public function sendnotifwa($nomor,$pesan){

        
        $sender = config('app.no_ptsp');
        $urlget = config('app.wa_host');
        $response = Http::post($urlget, ['sender'=>$sender, 'number' => $nomor, 'message' => $pesan]);
        $rescode = $response->status();
        if ($response->failed()) {
            return '400';
        } else {
            return strval($rescode);
        }
        

    }

    public function setkadaluarsa(){

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Update Status';
        $result = $this->model->setkadaluarsa();
        if($result) {
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Update Status';
            $data['result'] = $result;
        }
        return response()->json($data);

    
    }

    public function getqueuenotif(){

        //$nomorwa = 'xx';
        $pesanadmin = 'Testing Untuk Scheduller Pooling Notif WA';
        $now = date('Y-m-d H:i:s');
        $queuelist = $this->model->queuelist();
        $data['success'] = false;

        if(!empty($queuelist)) {
            $id_info = $queuelist->id;
            $pesanadmin = $queuelist->informasi;
            $nomorwa = $queuelist->notelp;
            $sendnotif = $this->sendnotifwa($nomorwa, $pesanadmin);
            //$data['sendnotif'] = $sendnotif;
            if($sendnotif == '200') {
                $statussend = '1';
                $this->model->updateinfo($id_info, $now, $statussend);
                $data['success'] = true;
                $data['keterangan'] = 'Notif Terkirim';

            } else {

                $this->model->updateinfo($id_info, $now, $sendnotif);
                $data['keterangan'] = 'Gagal Mengirim Notif';

            }

            
        } else {

            
             $data['keterangan'] = 'Tidak Ada List Untuk Dikirim Notifikasi';

        }
        
        return response()->json($data);
        
    }

    public function testdocx(){
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Simpan Docx';
        // $templateProcessor = new TemplateProcessor(storage_path('app/templates/nakes1.docx'));
        // $replacements = array(
        //     array('nomore' => '1', 'hari' => 'Senin', 'pukul' => '08:00', 'isShift' => 'Shift', 'uraian' => 'Sesuai Keterangan'),
        //     array('nomore' => '2', 'hari' => 'Selasa', 'pukul' => '10:00', 'isShift' => 'Shift', 'uraian' => 'Sesuai Keterangan'),
        //     array('nomore' => '3', 'hari' => 'Rabu', 'pukul' => '09:00', 'isShift' => 'Shift', 'uraian' => 'Sesuai Keterangan'),
        // );

        // $templateProcessor->setImageValue('userLogo', array('path' => storage_path('app/fotostr/230.jpg'), 'width' => 100, 'ratio' => true));
        // $templateProcessor->setImageValue('qr_code', array('path' => storage_path('app/fotostr/230.jpg'), 'width' => 100, 'ratio' => true));
        // $templateProcessor->cloneRowAndSetValues('nomore', $replacements);
        // $templateProcessor->setValue('no_surat', '323/42323/jinewa/212k31');
        // $templateProcessor->setValue('nama_nakes', 'Aduduh');
        // $templateProcessor->setValue('ttl_nakes', '25 Dec 2023');
        // $templateProcessor->setValue('keterangan', 'Foto Terbaik');

        // $modifiedDocxPath = storage_path('app/templates/modified_document.docx');
        // $templateProcessor->saveAs($modifiedDocxPath);
        // $libreoffice_exec = '/usr/bin/libreoffice';
        // $docxFilePath = $modifiedDocxPath;
        // $pdfOutputPath = storage_path('app/templates/nakes1.pdf');
        // $folder = dirname($pdfOutputPath);

    
        // $command = [
        //     $libreoffice_exec,
        //     '--headless',
        //     '--convert-to',
        //     'pdf:writer_pdf_Export',
        //     '--outdir',
        //     $folder,
        //     $docxFilePath,
        // ];

        // $process = new Process($command);
        // $process->run();

        // if (!$process->isSuccessful()) {
        //     throw new ProcessFailedException($process);
        // }

        // $data['success'] = true;
        // $data['keterangan'] = 'Tidak Ada List Untuk Dikirim Notifikasi';

        return response()->json($data);
        

    }

    public function getreportesip(){

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mendapatkan Data Dashboard e-SIP';
        $year = date("Y");
        $total_pengajuan = $this->model->detailrekappelayanan($year);
        if($total_pengajuan) {
            $data['total_pengajuan'] = $total_pengajuan;
            $data['success'] = false;
            $data['keterangan'] = 'Berhasil Mendapatkan Data Dashboard e-SIP';
        }
        
        return response()->json($data);

    
    }

    public function getallnakes()
    {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mendapatkan Data All Nakes';
        $allnakes = $this->model->getallnakes();
        if($allnakes) {
            $data['allnakes'] = $allnakes;
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Mendapatkan Data All Nakes';
        }
        
        //return response()->json($data);

    }

    public function nakescontext()
    {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mendapatkan Data All Nakes';
        $nakescontext = $this->model->nakescontext();
        if($allnakes) {
            $data['nakescontext'] = $nakescontext;
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Mendapatkan Data All Nakes';
        }
        
        return response()->json($data);

    }

    public function getallmaster()
    {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mendapatkan Data All Faskes';
        $faskes = $this->model->getallmaster('faskes');
        $profesi = $this->model->getallmaster('profesi');
        if($faskes) {
            $data['faskes'] = $faskes;
            $data['profesi'] = $profesi;
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Mendapatkan Data All Faskes';
        }
        
        return response()->json($data);

    }

    public function getfakta($jenis)
    {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Mendapatkan Data Fakta';
        $fakta = $this->model->getfakta($jenis);
        if($fakta) {
            $data['fakta'] = $fakta;
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Mendapatkan Data All Faskes';
        }
        
        return response()->json($data);

    }

    public function delaymessage(Request $request)
    {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Submit Delay Message';
        $result = $this->model->processmessage($request);
        if($result) {
            $data['success'] = true;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['keterangan'] = 'Berhasil Submit Delay Message';
        }
        
        return response()->json($data);


    }

    public function getdatasekitar(Request $request)
    {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Ambil Data Sekitar';
        $result = $this->model->getdatasekitar($request);
        if($result) {
            if ($keyword = trim($request->keyword ?? '')) {

                $keyword = strtolower($keyword);

                $result['faskes'] = $result['faskes']
                    ->filter(fn($row) => strpos(strtolower($row->nama_faskes), $keyword) !== false)
                    ->values();

            }

            $data['success'] = true;
            $data['result'] = $result;
            $data['keterangan'] = 'Berhasil Ambil Data Sekitar';
        }

        return response()->json($data);

        

    }

    public function detailfaskessekitar(Request $request)
    {
        $data['success'] = false;
        $data['keterangan'] = 'Gagal Ambil Data Sekitar';
        $result = $this->model->detailfaskessekitar($request);
        if($result) {
            $data['success'] = true;
            $data['result'] = $result;
            $data['keterangan'] = 'Berhasil Ambil Data Sekitar';
        }

        return response()->json($data);

    }

    public function getpuskesmas(Request $request)
    {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Ambil Data Sekitar';
        $result = $this->model->getpuskesmas($request);
        if($result) {
            $data['success'] = true;
            $data['result'] = $result;
            $data['keterangan'] = 'Berhasil Ambil Data Puskesmas';
        }

        return response()->json($data);

    }

    public function updatepuskesmas(Request $request)
    {

        $data['success'] = false;
        $data['keterangan'] = 'Gagal Update Data Puskesmas';
        $result = $this->model->updatepuskesmas($request);
        if($result) {
            $data['success'] = true;
            $data['keterangan'] = 'Berhasil Update Data Puskesmas';
        }
        
        return response()->json($data);

    }

}
