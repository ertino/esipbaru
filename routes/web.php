<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NakesController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ProgrammerController;
use App\Http\Controllers\DinkesController;
use App\Http\Controllers\DownloadfileController;
use App\Http\Controllers\OpController;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| 
*/

// \URL::forceScheme('https') is now opt-in: set FORCE_HTTPS=true in .env and it
// is applied from App\Providers\AppServiceProvider::boot() (config('app.force_https')).
// Forcing it unconditionally breaks http-only deployments such as the local
// Docker stack on port 7667.

Route::get('/', function(){
    return redirect()->route('login');
    //return redirect()->route('maintenance');
  })->name('index');

//Route::get('/info', [AdminController::class, 'info'])->name('info');
//Route::get('/ceki', [AdminController::class, 'ceki'])->name('ceki');
Route::get('/landing', [GuestController::class, 'index'])->name('landing');
Route::get('/daftarnakes', [GuestController::class, 'daftarnakes'])->name('daftar.nakes');
Route::post('/daftarsubmit', [GuestController::class, 'daftarsubmit'])->name('daftar.submit.str');
Route::get('/getdatastrdaftar', [GuestController::class, 'getdatastrdaftar'])->name('get.data.strdftr');
Route::get('/getdatastrdaftardev', [GuestController::class, 'getdatastrdaftardev'])->name('get.data.strdftrdev');
Route::post('lanjutpendaftaran', [GuestController::class, 'lanjutpendaftaran'])->name('simpan.pendaftaran');
Route::get('/daftarsukses', [GuestController::class, 'daftarsukses'])->name('daftar.sukses');
Route::get('/daftargagal', [GuestController::class, 'daftargagal'])->name('daftar.gagal');
Route::get('/maintenance', [GuestController::class, 'maintenance'])->name('maintenance');

/// TAMU
Route::get('/asistensi', [GuestController::class, 'asistensi'])->name('asistensi');
Route::get('/getevent', [GuestController::class, 'getevent'])->name('get.event');
Route::get('/geteventadmin', [GuestController::class, 'geteventadmin'])->name('get.event.admin');
Route::get('/detailevent', [GuestController::class, 'detailevent'])->name('detail.event');
Route::post('/submitasistensi', [GuestController::class, 'permohonansimpan'])->name('submit.asistensi');
Route::post('/submitreview', [GuestController::class, 'reviewsimpan'])->name('submit.review');
Route::get('/checksip/{filename}', [GuestController::class, 'checksip'])->name('check.qr.sip');
Route::get('/masterprofesi', [GuestController::class, 'masterprofesi'])->name('get.data.profesi');
Route::get('/testconvertjpg', [GuestController::class, 'testconvertjpg'])->name('test.convert.jpg');
Route::get('/readQrCodeFromPdf', [GuestController::class, 'readQrCodeFromPdf'])->name('readQrCodeFromPdf');
Route::get('/lupapassword', [GuestController::class, 'lupapassword'])->name('lupa.password');
Route::post('/guestsubmitcred', [GuestController::class, 'guestsubmitcred'])->name('guest.submit.cred');
Route::post('/guestresetpass', [GuestController::class, 'guestresetpass'])->name('guest.reset.pass');





Route::get('storagefotopublic/{filename}', function ($filename)
    {
        $path = storage_path('app/fotostr/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/approvepersetujuan', [AdminController::class, 'approvepersetujuan'])->name('approve.persetujuan');
    Route::post('/tolakpengajuan', [AdminController::class, 'tolakpengajuan'])->name('tolak.pengajuan');
    ///nakes
    Route::get('/nakesdashboard', [NakesController::class, 'nakesdashboard'])->name('nakes.dashboard');
    Route::get('/nakesprofile', [NakesController::class, 'nakesprofile'])->name('nakes.profile');
    Route::get('/nakesuploadktp/{id}', [NakesController::class, 'nakesuploadktp'])->name('nakes.upload.ktp');
    Route::get('/nakesuploadskskp/{id}', [NakesController::class, 'nakesuploadskskp'])->name('nakes.upload.skskp');
    Route::get('/nakesupdateskskp/{id}', [NakesController::class, 'nakesupdateskskp'])->name('nakes.update.skskp');
    
    Route::post('/submitskskp', [NakesController::class, 'submitskskp'])->name('submit.skskp');
    Route::post('/simpanmaindocnakes', [NakesController::class, 'simpanmaindocnakes'])->name('simpan.maindoc.nakes');
    Route::get('/getmaindoknakes', [NakesController::class, 'getmaindoknakes'])->name('get.maindok.nakes');
    
    
    
    
    Route::get('/nakesdocuments', [NakesController::class, 'nakesdocuments'])->name('nakes.documents');
    Route::get('/nakespetunjuk', [NakesController::class, 'nakespetunjuk'])->name('nakes.petunjuk');
    Route::get('/nakespengajuan', [NakesController::class, 'nakespengajuan'])->name('nakes.pengajuan');
    Route::post('/submitdokumen', [NakesController::class, 'submitdokumen'])->name('nakes.submit.dokumen');
    Route::post('/nakessubmitktp', [NakesController::class, 'nakessubmitktp'])->name('nakes.submit.ktp');
    Route::post('/submitpengajuanm', [NakesController::class, 'submitpengajuanm'])->name('nakes.submit.pengajuanM');
    Route::get('get/{file_name}', [DownloadfileController::class, 'downloadFile'])->name('download.the.file');
    Route::get('getKTP/{file_name}', [DownloadfileController::class, 'downloadKTP'])->name('download.the.ktp');
    Route::get('getoriginstr/{file_name}', [DownloadfileController::class, 'downloadOriginSTR'])->name('get.origin.str');
    Route::get('/getdatastr', [AdminController::class, 'getdatastr'])->name('get.data.str');
    Route::get('/gettesting', [AdminController::class, 'gettesting'])->name('get.data.testing');
    Route::post('/approvependaftar', [AdminController::class, 'approvependaftar'])->name('approve.pendaftar');
    Route::get('/getdatastrsalinan', [NakesController::class, 'getdatastrsalinan'])->name('get.data.strsalinan');
    Route::post('/submitktpnakes', [NakesController::class, 'submitktpnakes'])->name('submit.ktp.nakes');
    Route::post('/updatektpnakes', [NakesController::class, 'updatektpnakes'])->name('update.ktp.nakes');
    
    Route::get('/getallfaskes', [NakesController::class, 'getallfaskes'])->name('get.all.faskes'); 
    Route::get('/getalljadwal', [NakesController::class, 'getalljadwal'])->name('get.all.jadwal'); 
    Route::post('/submitjadwalprakteknakes', [NakesController::class, 'submitjadwalprakteknakes'])->name('submit.jadwaldetailpraktek');
    Route::get('/nakespencabutan/{id}', [NakesController::class, 'nakespencabutan'])->name('nakes.pencabutan'); 
    Route::get('/nakeshistorikal/{id}', [NakesController::class, 'nakeshistorikal'])->name('nakes.historikal'); 
    
    Route::post('/nakessubmitpencabutan', [NakesController::class, 'nakessubmitpencabutan'])->name('nakes.submit.pencabutan');
    Route::get('/getalasan', [NakesController::class, 'getalasan'])->name('nakes.getalasan'); 
    Route::get('/nakesperubahan/{id}', [NakesController::class, 'nakesperubahan'])->name('nakes.perubahan'); 
    Route::get('/nakespengajuannew/{salinan}', [NakesController::class, 'nakespengajuannew'])->name('nakes.pengajuan.new');
    Route::get('/nakespengajuanperubahan/{salinan}', [NakesController::class, 'nakespengajuanperubahan'])->name('nakes.pengajuan.perubahan');
    Route::post('/submitperubahanm', [NakesController::class, 'submitperubahanm'])->name('nakes.submit.perubahanM');
    Route::get('/nakesperpanjangan/{id}', [NakesController::class, 'nakesperpanjangan'])->name('nakes.perpanjangan');
    Route::get('/nakesdokteruploadstr/{salinan}', [NakesController::class, 'nakesdokteruploadstr'])->name('nakes.dokter.uploadstr');
    Route::get('/nakesnondokteruploadstr/{salinan}', [NakesController::class, 'nakesnondokteruploadstr'])->name('nakes.nondokter.uploadstr');
    Route::get('/nakespakaiidlestr/{salinan}', [NakesController::class, 'nakespakaiidlestr'])->name('nakes.pakai.idlestr');
    Route::post('/perpanjangansubmitstr', [NakesController::class, 'perpanjangansubmitstr'])->name('perpanjangan.submit.str');
    Route::post('/simpanperpanjanganstr', [NakesController::class, 'simpanperpanjanganstr'])->name('simpan.perpanjangan.str');
    Route::get('/nakeslanjutperpanjangan/{id}', [NakesController::class, 'nakeslanjutperpanjangan'])->name('nakes.lanjut.perpanjangan');
    Route::get('/nakesperpanjanganpengajuan/{id}', [NakesController::class, 'nakesperpanjanganpengajuan'])->name('nakes.perpanjangan.pengajuan');
    Route::post('/submitpengajuanperpanjangan', [NakesController::class, 'submitpengajuanperpanjangan'])->name('nakes.submit.perpanjangan');
    Route::get('/nakesperpanjangansementara/{id}', [NakesController::class, 'nakesperpanjangansementara'])->name('nakes.perpanjangan.sementara');

    Route::get('/nakesperpanjanganpengajuandokter/{id}', [NakesController::class, 'nakesperpanjanganpengajuandokter'])->name('nakes.perpanjangan.pengajuandokter');
    Route::post('/doktersubmitstr', [NakesController::class, 'doktersubmitstr'])->name('dokter.submit.str'); 
    Route::post('/nondoktersubmitstr', [NakesController::class, 'nondoktersubmitstr'])->name('nondokter.submit.str');
    Route::post('/nondokterupdatestr', [NakesController::class, 'nondokterupdatestr'])->name('nondokter.update.str');
    Route::post('/simpanstrdokter', [NakesController::class, 'simpanstrdokter'])->name('simpan.str.dokter');
    Route::post('/simpanstrnondokter', [NakesController::class, 'simpanstrnondokter'])->name('simpan.str.nondokter');
    Route::post('/simpanupdatestrnondokter', [NakesController::class, 'simpanupdatestrnondokter'])->name('simpanupdate.str.nondokter');
    Route::get('/nakesdetailpengajuan/{id}', [NakesController::class, 'nakesdetailpengajuan'])->name('nakes.kedetail.pengajuan');
    Route::post('/submitpersonalinfonakes', [NakesController::class, 'submitpersonalinfonakes'])->name('submit.personalinfo.nakes');
    Route::get('/nakespengajuanedit/{id}', [NakesController::class, 'nakespengajuanedit'])->name('nakes.pengajuan.edit');
    Route::get('/getselectedfaskesedit', [NakesController::class, 'getselectedfaskesedit'])->name('get.selected.faskesedit');
    Route::post('/simpanrekomprofesi', [NakesController::class, 'simpanrekomprofesi'])->name('simpan.rekomprofesi');
    Route::post('/updatelokasipengajuan', [NakesController::class, 'updatelokasipengajuan'])->name('update.lokasi.pengajuan');
    Route::get('/gettoupdatepengajuan', [NakesController::class, 'gettoupdatepengajuan'])->name('get.toupdate.pengajuan');
    Route::get('/gettoupdatepengajuanlokasi', [NakesController::class, 'gettoupdatepengajuanlokasi'])->name('get.toupdate.pengajuanlokasi');
    Route::post('/resubmitpengajuan', [NakesController::class, 'resubmitpengajuan'])->name('resubmit.pengajuan');
    Route::get('/editdokumenktp/{id}', [NakesController::class, 'editdokumenktp'])->name('edit.dokumen.ktp');
    Route::get('/editdokumennakes/{id}', [NakesController::class, 'editdokumennakes'])->name('edit.dokumen.nakes');
    Route::post('/nakesupdatedoc', [NakesController::class, 'nakesupdatedoc'])->name('nakes.update.doc');
    Route::post('/nakesupdatepass', [NakesController::class, 'nakesupdatepass'])->name('nakes.update.pass');
    Route::get('/getallvisitasi', [NakesController::class, 'getallvisitasi'])->name('get.all.visitasi');
    Route::post('/doktersubmitstrmanual', [NakesController::class, 'doktersubmitstrmanual'])->name('dokter.submit.strmanual');
    Route::post('/simpanstrmanualdokter', [NakesController::class, 'simpanstrmanualdokter'])->name('simpan.strmanual.dokter');
    Route::post('/batalkanpengajuan', [NakesController::class, 'batalkanpengajuan'])->name('batal.pengajuan.nakes');
    Route::get('/getesipbefore', [NakesController::class, 'getesipbefore'])->name('get.esip.before');
    Route::get('/updateqrcodenakes/{id}', [NakesController::class, 'updateqrcodenakes'])->name('update.qrcode.nakes');
    Route::post('/simpanupdateqrcode', [NakesController::class, 'simpanupdateqrcode'])->name('simpan.update.qrcode');
    Route::post('/simpansubstrdokter', [NakesController::class, 'simpansubstrdokter'])->name('simpan.strsubmanual.dokter');
    Route::post('/submitsipmanual', [NakesController::class, 'submitsipmanual'])->name('nakes.submit.sipmanual');
    Route::post('/simpansipmanual', [NakesController::class, 'simpansipmanual'])->name('nakes.simpan.sipmanual');
    Route::post('/skipvalidasistr', [NakesController::class, 'skipvalidasistr'])->name('nakes.skip.validasistr');
    Route::post('/simpanstrnvdokter', [NakesController::class, 'simpanstrnvdokter'])->name('simpan.strnv.dokter');
    Route::post('/simpanijazahlainnakes', [NakesController::class, 'simpanijazahlainnakes'])->name('simpan.ijazahlain.nakes');
    Route::get('/nakessiphistorikal', [NakesController::class, 'nakessiphistorikal'])->name('nakes.sip.historikal');
    Route::post('/summaryjadwal', [NakesController::class, 'summaryjadwal'])->name('get.summaryjadwal');
    
    
      
    
    /////adminnakes
    Route::get('/adminnakesboard', [AdminController::class, 'adminnakesdashboard'])->name('adminnakes.main.dashboard');
    Route::get('/adminnakespemohon', [AdminController::class, 'adminnakespemohon'])->name('adminnakes.pemohon');
    Route::get('/adminnakespendaftar', [AdminController::class, 'adminnakespendaftar'])->name('adminnakes.pemohon');
    Route::post('/resetnakespassword', [AdminController::class, 'resetnakespassword'])->name('nakes.reset.pass');
    Route::get('/getfileview', [DownloadfileController::class, 'getfileview'])->name('get.file.view');
    
    ///dinkes
    Route::get('/admindinkesboard', [DinkesController::class, 'dinkesdashboard'])->name('admindinkes.main.dashboard');
    Route::get('/getdetailpengajuan/{id}', [DinkesController::class, 'detailpengajuan'])->name('get.detail.pengajuan');
    Route::post('/submittglvisitasi', [DinkesController::class, 'submittglvisitasi'])->name('submit.tgl.visitasi');
    Route::post('/updatetglvisitasi', [DinkesController::class, 'updatetglvisitasi'])->name('update.tgl.visitasi');
    Route::post('/testdownloadfoto', [DinkesController::class, 'testdownloadfoto'])->name('test.download.foto');
    Route::post('/testdlft', [DinkesController::class, 'testdlft'])->name('test.dl.fotourl');
    Route::post('/getallin', [DinkesController::class, 'getallin'])->name('test.get.allin');
    Route::post('/getallindua', [DinkesController::class, 'getallindua'])->name('test.sending.notif');
    Route::post('/gethistoriasmanlist', [DinkesController::class, 'gethistoriasmanlist'])->name('get.histori.tinjauajuan');
    Route::post('/gethistoriasmanlistmanual', [DinkesController::class, 'gethistoriasmanlistmanual'])->name('get.histori.tinjauajuanmanual');
    //kadinkes
    Route::get('/kadinkesdashboard', [DinkesController::class, 'kadinkesdashboard'])->name('kadinkes.main.dashboard');
    Route::post('/submitdraftkadinkes', [DinkesController::class, 'submitdraftkadinkes'])->name('submit.draft.kadinkes');
    Route::post('/submitttekadinkes', [DinkesController::class, 'submitttekadinkes'])->name('submit.tte.kadinkes');
    

    Route::get('/adminprofile', [AdminController::class, 'adminprofile'])->name('admin.profile');
    

    ///ptsp
    Route::get('/adminptspboard', [AdminController::class, 'ptspdashboard'])->name('adminptsp.main.dashboard');
    Route::get('/draftsip', [AdminController::class, 'draftsip'])->name('draft.persetujuan.sip');
    Route::post('/draftingSip', [AdminController::class, 'draftingSip'])->name('drafting.data.sip');
    Route::post('/generateDraftSip', [AdminController::class, 'generateDraftSip'])->name('generate.draft.sip');
    Route::post('/submitsipasoka', [AdminController::class, 'submitsipasoka'])->name('draft.sip.asoka');
    Route::get('/ptspmanagefaskes', [AdminController::class, 'ptspmanagefaskes'])->name('ptsp.manage.faskes');
    Route::get('/ptspmanagepencabutan', [AdminController::class, 'ptspmanagepencabutan'])->name('ptsp.manage.pencabutan');
    Route::post('/approvepencabutan', [AdminController::class, 'approvepencabutan'])->name('approve.pencabutan');
    Route::get('/adminpendaftarannakes', [AdminController::class, 'adminpendaftarannakes'])->name('ptsp.daftar.nonqr');
    Route::post('/simpanstrmanual', [AdminController::class, 'simpanstrmanual'])->name('simpan.str.manual');
    Route::post('/submitstrmanual', [AdminController::class, 'submitstrmanual'])->name('admin.submit.strmanual');
    Route::get('/pengumpulanstrasli/{id}', [AdminController::class, 'pengumpulanstrasli'])->name('kumpul.str.asli');
    Route::post('/simpanpengumpulanstr', [AdminController::class, 'simpanpengumpulanstr'])->name('simpan.pengumpulan.str');
    Route::post('/submitmanagefaskes', [AdminController::class, 'submitmanagefaskes'])->name('submit.manage.faskes');
    Route::get('/verifstrserahan', [AdminController::class, 'verifstrserahan'])->name('verif.str.serahan');
    Route::post('/gethistoryapprovenakes', [DinkesController::class, 'gethistoryapprovenakes'])->name('get.histori.approvenakes');
    Route::post('/cancelDraftSip', [AdminController::class, 'cancelDraftSip'])->name('cancel.draft.sip');
    Route::post('/revertDraftSip', [AdminController::class, 'revertDraftSip'])->name('revert.draft.sip');
    Route::post('/reverseDraftSip', [AdminController::class, 'reverseDraftSip'])->name('refresh.draft.sip');
    Route::post('/ptspupdatepengaju', [AdminController::class, 'ptspupdatepengaju'])->name('ptsp.update.pengaju');
    Route::post('/simpanuserfaskes', [AdminController::class, 'simpanuserfaskes'])->name('simpan.user.faskes');
    Route::get('/getuserfaskes', [AdminController::class, 'getuserfaskes'])->name('get.user.faskes');
    Route::post('/submittolaknakes', [AdminController::class, 'submittolaknakes'])->name('submit.tolak.nakes');
    Route::post('/submiteditnomor', [AdminController::class, 'submiteditnomor'])->name('submit.edit.nomor');
    Route::post('/updatefotonakes', [AdminController::class, 'updatefotonakes'])->name('update.foto.nakes');
    Route::post('/reverttte', [AdminController::class, 'reverttte'])->name('ptsp.revert.tte');
    Route::get('/ambilistcabut', [AdminController::class, 'ambilistcabut'])->name('ambilistcabut');
    
    
    
    
    
    Route::get('/rekapnakesfaskes', [AdminController::class, 'rekapnakesfaskes'])->name('get.rekapnakesfaskes');
    Route::get('/profilingnakes', [DinkesController::class, 'profilingnakes'])->name('profiling.nakes');
    Route::get('/rekappelayanan', [AdminController::class, 'rekappelayanan'])->name('get.rekappelayanan');
    Route::get('/getchartpelayanan', [AdminController::class, 'getchartpelayanan'])->name('get.chartpelayanan');
    Route::get('/detailrekappelayanan', [AdminController::class, 'detailrekappelayanan'])->name('get.detailrekappelayanan');
    
    Route::get('/adminpengajuansipmanual', [AdminController::class, 'adminpengajuansipmanual'])->name('admin.pengajuansipmanual');
    Route::post('/updatesipmanual', [AdminController::class, 'updatesipmanual'])->name('update.sip.manual');
    Route::get('/getnakessekitar', [AdminController::class, 'getnakessekitar'])->name('get.nakes.sekitar');
    Route::get('/getrekapmapnakes', [AdminController::class, 'getrekapmapnakes'])->name('get.rekapmapnakes');
    Route::get('/getnakesinmap', [AdminController::class, 'getnakesinmap'])->name('get.nakes.inmap');
    Route::get('/ptspcountpencabutan', [AdminController::class, 'ptspcountpencabutan'])->name('ptsp.count.pencabutan');
    Route::post('/reaktifasiuser', [AdminController::class, 'reaktifasiuser'])->name('ptsp.reaktifasiuser');
    Route::get('/admincountmenu', [AdminController::class, 'admincountmenu'])->name('admin.count.menu');
    Route::post('/draftingPencabutanSip', [AdminController::class, 'draftingPencabutanSip'])->name('drafting.pencabutan.sip');
    Route::post('/submitcabutsipasoka', [AdminController::class, 'submitcabutsipasoka'])->name('submit.pencabutan.sip');
    Route::get('/lihatdokpencabutansip', [AdminController::class, 'lihatdokpencabutansip'])->name('lihatdoc.pencabutan.sip');
    Route::get('/listsipperprofesi', [AdminController::class, 'listsipperprofesi'])->name('list.sip.perprofesi');
    Route::post('/hapussiplama', [AdminController::class, 'hapussiplama'])->name('hapus.sip.lama');
    Route::post('/submitsupbeforeesip', [AdminController::class, 'submitsupbeforeesip'])->name('submit.sipbefore.esip');
    Route::post('/gethistoripendaftaran', [AdminController::class, 'gethistoripendaftaran'])->name('get.histori.pendaftaran');
    Route::get('/adminupdatestrnakes', [AdminController::class, 'adminupdatestrnakes'])->name('admin.updatestrnakes');
    Route::get('/updatestrbyadmin/{id}', [AdminController::class, 'updatestrbyadmin'])->name('admin.update.str');
    Route::post('/ubahukuranfotosip', [AdminController::class, 'ubahukuranfotosip'])->name('ubah.ukuran.fotosip');
    Route::get('/scantoupdatestr/{id}', [AdminController::class, 'scantoupdatestr'])->name('scantoupdatestr');
    Route::post('/nvupdatestrbyadmin', [AdminController::class, 'nvupdatestrbyadmin'])->name('nvupdate.str.byadmin');
    Route::post('/processperpanjanganbyadmin', [AdminController::class, 'processperpanjanganbyadmin'])->name('process.perpanjangan.byadmin');
    Route::post('/reaktifasinakes', [AdminController::class, 'reaktifasinakes'])->name('reaktifasi.nakes');
    Route::post('/getsummarylayanan', [AdminController::class, 'getsummarylayanan'])->name('get.summarylayanan');
    Route::get('/getcurrentprofesi', [AdminController::class, 'getcurrentprofesi'])->name('get.current.profesi');
    Route::get('/adminchat', [AdminController::class, 'adminchat'])->name('adminchat');
    Route::post('/chatwithai', [AdminController::class, 'chatwithai'])->name('chatwithai');
    Route::get('/getcekkecukupan', [AdminController::class, 'getcekkecukupan'])->name('getcekkecukupan');
    
    
    

    ///bidang farmasi
    Route::get('/bidfardashboard', [DinkesController::class, 'bidfardashboard'])->name('bidfar.main.dashboard');
    Route::get('/getlistforbidfar', [AdminController::class, 'getlistforbidfar'])->name('getlistforbidfar');
    Route::get('/detailsipuntukcabut', [AdminController::class, 'detailsipuntukcabut'])->name('detailsipuntukcabut');
    Route::post('/setujupencabutanbidfar', [AdminController::class, 'setujupencabutanbidfar'])->name('setujupencabutanbidfar');
    Route::get('/getdetailrekomc', [AdminController::class, 'getdetailrekomc'])->name('getdetailrekomc');
    Route::get('/dokpencabutan/{id}', [NakesController::class, 'dokpencabutan'])->name('dokpencabutan');
    Route::get('/getdetaildokpencabutan', [NakesController::class, 'getdetaildokpencabutan'])->name('getdetaildokpencabutan');
    Route::post('/updatedokpencabutan', [NakesController::class, 'updatedokpencabutan'])->name('updatedokpencabutan');

 

    
    
    
    
    
    ///

    //verifptsp
    Route::get('/verifdashboard', [AdminController::class, 'verifdashboard'])->name('verif.main.dashboard');
    //Route::post('/submitdraftkadinkes', [AdminController::class, 'submitdraftkadinkes'])->name('submit.draft.kadinkes');
    //Route::post('/submitttekadinkes', [AdminController::class, 'submitttekadinkes'])->name('submit.tte.kadinkes');

    //kaptsp
    Route::get('/kaptspdashboard', [AdminController::class, 'kaptspdashboard'])->name('kaptsp.main.dashboard');
    
    Route::post('/submitttekadin', [AdminController::class, 'submitttekadin'])->name('submit.tte.kadin');

    Route::post('/gethistoripengajuanapproval', [AdminController::class, 'gethistoripengajuanapproval'])->name('get.histori.pengajuan');
    Route::post('/gethistoridaftarapprove', [AdminController::class, 'gethistoridaftarapprove'])->name('get.histori.daftarapprove');
    
    
    

    
    //rekomop
    Route::get('/opdashboard', [OpController::class, 'opdashboard'])->name('op.main.dashboard');
    Route::get('/getdetailpengajuanop/{id}', [DinkesController::class, 'detailpengajuanop'])->name('get.detail.pengajuanop');
    Route::post('/setujuipengajuanop', [OpController::class, 'setujuipengajuanop'])->name('submit.setuju.op');
    Route::post('/gethistoriasmanlistop', [OpController::class, 'gethistoriasmanlistop'])->name('get.histori.tinjauajuanop');
    Route::get('/optdashboard', [OpController::class, 'optdashboard'])->name('op.testing.dashboard');

    //faskes
    Route::get('/faskesdashboard', [OpController::class, 'faskesdashboard'])->name('faskes.main.dashboard');


    //superadmin
    Route::get('/superadmindashboard', [AdminController::class, 'superadmindashboard'])->name('superadmin.dashboard');
    Route::get('/superdetailnakes/{id}', [AdminController::class, 'superdetailnakes'])->name('superdetailnakes');
    Route::get('/supernakesdetail', [AdminController::class, 'supernakesdetail'])->name('supernakesdetail');
    Route::get('/superadminpengajuan', [AdminController::class, 'superadminpengajuan'])->name('superadmin.pengajuan');
    Route::get('/superadminnotifikasi', [AdminController::class, 'superadminnotifikasi'])->name('superadmin.notifikasi');
    Route::post('/testkoneksiwa', [AdminController::class, 'testkoneksiwa'])->name('testkoneksiwa');
    Route::get('/getlogwabyname', [AdminController::class, 'getlogwabyname'])->name('getlogwabyname');
    
    
    
    
    
    
    
    
    

        //testing routing image
    Route::get('storage/{filename}', function ($filename)
    {
        $path = storage_path('app/daftar/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    Route::get('storageperpanjangan/{filename}', function ($filename)
    {
        $path = storage_path('app/perpanjangan/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    Route::get('storagesiplama/{filename}', function ($filename)
    {
        $path = storage_path('app/sipmanual/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    Route::get('storageup/{filename}', function ($filename)
    {
        $path = storage_path('app/uploaddoc/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    Route::get('storageform/{filename}', function ($filename)
    {
        $path = storage_path('app/uploadtask/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    Route::get('storagefoto/{filename}', function ($filename)
    {
        $path = storage_path('app/fotostr/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });


    Route::get('storagefotot/{filename}', function ($filename)
    {
        $pathParts = pathinfo($filename);
        $filenameWithoutExtension = $pathParts['filename'];
        $extension = $pathParts['extension'];

        // Add '_t' after the filename
        $modifiedFilename = $filenameWithoutExtension . '_t.' . $extension;

        $path = storage_path('app/fotostr/' . $modifiedFilename);

        if (!File::exists($path)) {
            $path = storage_path('app/fotostr/' . $filename);
            if (!File::exists($path)) {
                abort(404);
            }
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    Route::get('storagefotokosong/{filename}', function ($filename)
    {
        $path = storage_path('app/fotokosong/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    Route::post('/testsendingfilenya', [AdminController::class, 'testsendingfilenya'])->name('test.sending.file');
    
    
});

require __DIR__.'/auth.php';
