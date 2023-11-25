<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('home.index') }}">
          <span class="menu-title">Home</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('employe.index') }}">
          <span class="menu-title">Daftar Pegawai</span>
          <i class="mdi mdi-contacts menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('presents.index') }}">
          <span class="menu-title">Absensi</span>
          <i class="mdi mdi-format-list-bulleted menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Data Utama</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ route('satker.index') }}">Satuan Kerja</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('position.index') }}">Posisi</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('rule.index') }}">
          <span class="menu-title">Pengaturan</span>
          <i class="mdi mdi-table-large menu-icon"></i>
        </a>
      </li>
    </ul>
  </nav>