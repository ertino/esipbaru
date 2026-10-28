<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <img src="{{ asset('images/nakesico.png')}}" alt="REKOM NAKES" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">URAT NADI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        @if(Auth::user()->role =='kadinkes')
          <li class="nav-item has-treeview">
            <a href="{{ route('kadinkes.main.dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
        @elseif(Auth::user()->role =='kaptsp')
          <li class="nav-item has-treeview">
            <a href="{{ route('kaptsp.main.dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
        @elseif(Auth::user()->role =='superadmin')
          <li class="nav-item has-treeview">
            <a href="{{ route('superadmin.dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Cari User
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="{{ route('superadmin.pengajuan') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Cari Pengajuan
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="{{ route('superadmin.notifikasi') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Notifikasi
              </p>
            </a>
          </li>
        @elseif(Auth::user()->role =='verifptsp')
          <li class="nav-item has-treeview">
            <a href="{{ route('verif.main.dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
        @elseif(Auth::user()->role =='bidfarmasidinkes')

          <li class="nav-item" id="menupencabutan">
            <a href=" {{ route('bidfar.main.dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-times-circle"></i>
              <p>
                List Pencabutan
                <span class="right badge badge-danger" id="hhitungpendingcabut"></span>
              </p>
            </a>
          </li>
        
        @endif
        @if(Auth::user()->role == "nakes")
          <li class="nav-item has-treeview">
            <a href="{{ route('nakes.dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Beranda
                <!--<i class="right fas fa-home"></i>-->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href=" {{ route('nakes.documents') }}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Dokumen
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
        @else
          <li class="nav-item has-treeview" style="display:none">
            <a href="{{ route('adminnakes.main.dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          @if(Auth::user()->role == "admindinkes")
          <li class="nav-item">
            <a href=" {{ route('get.rekapmapnakes') }}" class="nav-link">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Map Nakes
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item" @if(Auth::user()->role == "faskes" || Auth::user()->role == "kadinkes" || Auth::user()->role == "kaptsp" || Auth::user()->role == "verifptsp" || Auth::user()->role == "bidfarmasidinkes" || Auth::user()->role == "superadmin") style="display:none" @endif>
            <a href=" {{ route('adminnakes.pemohon') }}" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p id="menudaftaran">
                List Pendaftar
                <span class="right badge badge-danger" id="hitungpendingdaftar"></span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            @if(Auth::user()->role == "admindinkes")
            <a href=" {{ route('admindinkes.main.dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
              <p>
                List Pengajuan
                <span class="right badge badge-danger" id="hitungpendingaju"></span>
              </p>
            </a>
          </li>
            @elseif (Auth::user()->role == "adminptsp")
            <a href=" {{ route('adminptsp.main.dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
              <p>
                List Pengajuan
                <span class="right badge badge-danger" id="hitungpendingaju"></span>
              </p>
            </a>
          </li>
            @elseif(Auth::user()->role == "op")
            <a href=" {{ route('op.testing.dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
              <p>
                List Pengajuan
                <span class="right badge badge-danger" id="hitungpendingaju"></span>
              </p>
            </a>
          </li>
            @elseif(Auth::user()->role == "faskes")
            <a href=" {{ route('faskes.main.dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
              <p>
                Rekapitulasi
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>
            @endif
              
          @if(Auth::user()->role == "adminptsp")

          <li class="nav-item">
            <a href=" {{ route('admin.pengajuansipmanual') }}" class="nav-link">
              <i class="nav-icon fas fa-archive"></i>
              <p>
                Pengajuan SIP Manual
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href=" {{ route('admin.updatestrnakes') }}" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Update STR Nakes
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>

          <li class="nav-item" id="menupencabutan">
            <a href=" {{ route('ptsp.manage.pencabutan') }}" class="nav-link">
              <i class="nav-icon fas fa-times-circle"></i>
              <p>
                List Pencabutan
                <span class="right badge badge-danger" id="hhitungpendingcabut"></span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href=" {{ route('ptsp.manage.faskes') }}" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                List Fasyankes
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href=" {{ route('ptsp.daftar.nonqr') }}" class="nav-link">
              <i class="nav-icon fas fa-user-md"></i>
              <p>
                Pendaftaran Non QR
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href=" {{ route('get.rekappelayanan') }}" class="nav-link">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>
                Rekap
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href=" {{ route('get.rekapmapnakes') }}" class="nav-link">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Map Nakes
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>


          

          @endif
        @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>