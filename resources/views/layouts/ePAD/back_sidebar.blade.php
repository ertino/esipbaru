
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>General</h3>
    @php
    $authorize['admin.super'] = "all";
    $authorize['executive'] = array(
        "Home", "Pajak", "Retribusi"
    );
    $authorize['dinas'] = array(
        "Master Data", "Retribusi", "Rekap"
    );
    @endphp

    <ul class="nav side-menu">
      <li><a href="{{ route('index') }}"><i class="fa fa-home"></i> Home </a>
        <ul class="nav child_menu" style="display: none">
        </ul>
      </li>
    @if(session('role') == "admin.super" || session('role') == "executive" 
	|| session('role') == "kepala.upt" || session('role') == "kepala.pasar" || session('role') == "operator.upt")

      <li><a href="{{ route('pasar.daftar') }}"><i class="fa fa-list"></i> Daftar Pasar </a>
        <ul class="nav child_menu" style="display: none">
        </ul>
      </li>
      <li><a href="{{ route('pedagang.daftar') }}"><i class="fa fa-list"></i> Daftar Pedagang </a>
        <ul class="nav child_menu" style="display: none">
        </ul>
      </li>
      <li><a href="{{ route('data.tutup')}}"><i class="fa fa-list"></i> Set Buka Toko (LOS)</a>
        <ul class="nav child_menu" style="display: none">
        </ul>
      </li>
    @endif
    @if(session('role') == "admin.super" || session('role') == "dinas" || session('role') == "operator.upt")
      <li><a><i class="fa fa-edit"></i> Master Data <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu" style="display: none">
          <li><a href="{{ route('data.pasar') }}">Data Pasar</a></li>
          <li><a href="{{ route('data.pedagang') }}">Data Pedagang</a></li>
          <li><a href="{{ route('data.kios') }}">Data Kios</a></li>
        </ul>
      </li>
	@if(session('role') == "admin.super" || session('role') == "dinas")
      <li><a><i class="fa fa-suitcase"></i> Retribusi <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu" style="display: none">
          <li><a href="{{ route('retribusi.status_pembayaran') }}">Status Pembayaran</a></li>
          <li><a href="{{ route('retribusi.tunai') }}">Retribusi Tunai</a></li>
        </ul>
      </li>
      <li><a><i class="fa fa-file"></i> Rekap <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu" style="display: none">
          <li><a href="{{ route('rekap.retribusi') }}">Retribusi Non-tunai</a></li>
          <li><a href="{{ route('rekap.laporan') }}">Cetak Laporan</a></li>
        </ul>
      </li>
      <li><a><i class="fa fa-gear"></i> Pengaturan <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu" style="display: none">
          <li><a href="{{ route('data.libur')}}">Hari Libur Penarikan</a></li>
          
          <li><a href="{{ route('data.tarif')}}">Tarif dan Tipe Kios</a></li>
        </ul>
      </li>
	@endif
    @endif

    </ul>

  </div>

</div>
<!-- /sidebar menu -->
