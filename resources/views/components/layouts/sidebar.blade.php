<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed{{ Request::is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-heading">Pages</li>
        @can('pengurus')
            <li class="nav-item">
                <a class="nav-link  {{ Request::is(['jamaah', 'kategori', 'keuangan', 'laporan_keuangan', 'kegiatan_masjid', 'informasi_masjid']) ? 'active' : 'collapsed' }}"
                    data-bs-target="#master-data" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="master-data"
                    class="nav-content collapse {{ Request::is(['jamaah*', 'kategori*', 'keuangan*', 'laporan_keuangan*', 'kegiatan_masjid*', 'informasi_masjid*']) ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">

                    <li>
                        <a href="{{ url('jamaah') }}" class="{{ Request::is('jamaah') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Data Donatur</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('kategori') }}" class="{{ Request::is('kategori') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Data Kategori</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('keuangan') }}" class="{{ Request::is('keuangan*') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Data Keuangan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('laporan_keuangan') }}"
                            class="{{ Request::is('laporan_keuangan*') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Data Laporan Keuangan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('kegiatan_masjid') }}"
                            class="{{ Request::is('kegiatan_masjid*') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Data Kegiatan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('informasi_masjid') }}"
                            class="{{ Request::is('informasi_masjid*') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>Data Informasi</span>
                        </a>
                    </li>
                </ul>

            </li><!-- End Master Data -->
        @endcan

        <li class="nav-item">
            <a class="nav-link collapsed{{ Request::is('donasi*') ? 'active' : '' }}" href="{{ url('/donasi') }}">
                <i class="bi bi-wallet"></i>
                <span>Donasi</span>
            </a>
        </li>


        <li class="nav-heading">Setting</li>
        {{-- 
        <li class="nav-item">
            <a class="nav-link collapsed {{ Request::is('profile') ? 'active' : '' }}" href="{{ url('profile') }}">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('/logout') }}" onclick="confirmLogout(event)">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Sign Out</span>
            </a>
        </li>

    </ul>

</aside><!-- End Sidebar-->
