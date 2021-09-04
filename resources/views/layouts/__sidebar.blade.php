<!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item sidebar-profile mt-4">
            <a href="#">
              <div>
                <div class="profile-thumb">
                    <img src="{{asset('img/user.jpg')}}" alt="profile">
                </div>
                <div class="mt-2">
                  <h3 class="mb-1 profile-name">{{auth()->user()->nama}}</h3>
                  <p class="profile-description">{{auth()->user()->unitusaha->jenis}}</p>
                </div>
              </div>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/dashboard">
              <i class="mdi mdi-cards-variant menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/data-akun">
              <i class="mdi mdi-database menu-icon"></i>
              <span class="menu-title">Data Akun</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-jasa" aria-expanded="false" aria-controls="ui-jasa">
              <i class="mdi mdi-water menu-icon"></i>
              <span class="menu-title">Jasa</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-jasa">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="/jasa/neraca-saldo-awal"><p>Neraca Saldo</p> <p>Awal</p></a></li>
                <li class="nav-item"><a class="nav-link" href="/jasa/transaksi"><p>Transaksi</p></a></li>
                <li class="nav-item"><a class="nav-link" href="/jasa/jurnal-umum"><p>Jurnal Umum</p></a></li>
                <li class="nav-item"><a class="nav-link" href="/jasa/buku-besar"><p>Buku Besar</p></a></li>
                <li class="nav-item"><a class="nav-link" href="/jasa/neraca-saldo"><p>Neraca Saldo</p> <p>Sebelum</p> <p>Penyesuaian</p></a></li>
                <li class="nav-item"><a class="nav-link" href="/jasa/jurnal-penyesuaian"><p>Jurnal</p> <p>Penyesuaian</p></a></li>
                <li class="nav-item"><a class="nav-link" href="/jasa/neraca-saldo/setelah-disesuaikan"><p>Neraca Saldo</p> <p>Setelah</p> <p>Disesuaikan</p></a></li>
                <li class="nav-item"><a class="nav-link" href="/jasa/jurnal-penutup"><p>Jurnal Penutup</p></a></li>
                <li class="nav-item"><a class="nav-link" href="/jasa/neraca-penutup"><p>Neraca Penutup</p></a></li>

              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-dagang" aria-expanded="false" aria-controls="ui-dagang">
              <i class="mdi mdi-package-variant-closed menu-icon"></i>
              <span class="menu-title">Dagang</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-dagang">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="/dagang/neraca-saldo-awal"><p>Neraca Saldo</p> <p>Awal</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/dagang/transaksi"><p>Transaksi</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/dagang/jurnal-umum"><p>Jurnal Umum</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/dagang/buku-besar"><p>Buku Besar</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/dagang/neraca-saldo"><p>Neraca Saldo</p> <p>Sebelum</p> <p>Penyesuaian</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/dagang/jurnal-penyesuaian"><p>Jurnal</p> <p>Penyesuaian</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/dagang/neraca-saldo/setelah-disesuaikan"><p>Neraca Saldo</p> <p>Setelah</p> <p>Disesuaikan</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/dagang/jurnal-penutup"><p>Jurnal Penutup</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/dagang/neraca-saldo/setelah-penutup"><p>Neraca Saldo</p> <p>Setelah Penutup</p></a></li>

              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-manufaktur" aria-expanded="false" aria-controls="ui-manufaktur">
              <i class="mdi mdi-factory menu-icon"></i>
              <span class="menu-title">Manufaktur</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-manufaktur">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="/manufaktur/neraca-saldo-awal"><p>Neraca Saldo</p> <p>Awal</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/manufaktur/transaksi"><p>Transaksi</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/manufaktur/jurnal-umum"><p>Jurnal Umum</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/manufaktur/buku-besar"><p>Buku Besar</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/manufaktur/neraca-saldo"><p>Neraca Saldo</p> <p>Sebelum</p> <p>Penyesuaian</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/manufaktur/jurnal-penyesuaian"><p>Jurnal</p> <p>Penyesuaian</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/manufaktur/neraca-saldo/setelah-disesuaikan"><p>Neraca Saldo</p> <p>Setelah</p> <p>Disesuaikan</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/manufaktur/jurnal-penutup"><p>Jurnal Penutup</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/manufaktur/neraca-saldo/setelah-penutup"><p>Neraca Saldo</p> <p>Setelah Penutup</p></a></li>

              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-emkm" aria-expanded="false" aria-controls="ui-emkm">
              <i class="mdi mdi-layers menu-icon"></i>
              <span class="menu-title">Laporan Keuangan <br> EMKM (Unit Usaha)</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-emkm">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="/emkm/laba-rugi">Laporan Laba Rugi</a></li>
                <li class="nav-item"> <a class="nav-link" href="/emkm/posisi-keuangan"><p>Laporan Posisi</p><p>Keuangan</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="/emkm/calk"><p>Catatan Atas</p><p>Laporan Keuangan</p></a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-etap" aria-expanded="false" aria-controls="ui-etap">
              <i class="mdi mdi-layers menu-icon"></i>
              <span class="menu-title">Laporan Keuangan <br> ETAP (BUMDes)</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-etap">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dragula.html">Laporan Laba Rugi</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/clipboard.html"><p>Laporan Posisi</p><p>Keuangan</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/clipboard.html"><p>Laporan Perubahan</p><p>Ekuitas</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/clipboard.html"><p>Laporan Arus Kas</p></a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/clipboard.html"><p>Catatan Atas</p><p>Laporan Keuangan</p></a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-pajak" aria-expanded="false" aria-controls="ui-pajak">
              <i class="fa fa-money menu-icon"></i>
              <span class="menu-title">Pajak</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-pajak">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/accordions.html">PPH 21</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">PPH 22</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/badges.html">PPH 23</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/badges.html">PPH 25</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/badges.html">Pasal 4 Ayat 2</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/badges.html">PPN</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
      <!-- partial -->