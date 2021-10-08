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
                  @if(auth()->user()->role == 'unitusaha')
                    <p class="profile-description">Air PAMDes</p>
                  @endif
                  @if(auth()->user()->role == 'bumdes')
                    <p class="profile-description">BUMDes</p>
                  @endif
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

          @if(auth()->user()->role == 'superadmin')
          <li class="nav-item">
            <a class="nav-link" href="/data-bumdes">
              <i class="mdi mdi-cards-variant menu-icon"></i>
              <span class="menu-title">Data BUMDes</span>
            </a>
          </li>
          @endif

          <li class="nav-item">
            <a class="nav-link" href="/data-akun">
              <i class="mdi mdi-account-multiple menu-icon"></i>
              <span class="menu-title">Data Akun</span>
            </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-jasa" aria-expanded="false" aria-controls="ui-jasa">
                <i class="mdi mdi-water menu-icon"></i>
                <span class="menu-title">Transaksi</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-jasa">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="/neraca-saldo-awal"><p>Neraca Saldo</p> <p>Awal</p></a></li>
                  <li class="nav-item"><a class="nav-link" href="/transaksi"><p>Transaksi</p></a></li>
                  <li class="nav-item"><a class="nav-link" href="/jurnal-umum"><p>Jurnal Umum</p></a></li>
                  <li class="nav-item"><a class="nav-link" href="/buku-besar"><p>Buku Besar</p></a></li>
                  <li class="nav-item"><a class="nav-link" href="/neraca-saldo"><p>Neraca Saldo</p> <p>Sebelum</p> <p>Penyesuaian</p></a></li>
                  <li class="nav-item"><a class="nav-link" href="/jurnal-penyesuaian"><p>Jurnal</p> <p>Penyesuaian</p></a></li>
                  <li class="nav-item"><a class="nav-link" href="/neraca-saldo/setelah-disesuaikan"><p>Neraca Saldo</p> <p>Setelah</p> <p>Disesuaikan</p></a></li>
                  <li class="nav-item"><a class="nav-link" href="/jurnal-penutup"><p>Jurnal Penutup</p></a></li>
                  <li class="nav-item"><a class="nav-link" href="/neraca-penutup"><p>Neraca Penutup</p></a></li>

                </ul>
              </div>
            </li>
          @if(auth()->user()->role == 'bumdes')
            {{-- <li class="nav-item">
              <a class="nav-link" href="/data-unit">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">Data Unit Usaha</span>
              </a>
            </li> --}}

            {{-- ETAP --}}
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-etap" aria-expanded="false" aria-controls="ui-etap">
                <i class="mdi mdi-layers menu-icon"></i>
                <span class="menu-title">Laporan Keuangan <br> ETAP (BUMDes)</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-etap">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="/laba-rugi">Laporan Laba Rugi</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/laporan-neraca"><p>Laporan Neraca</p></a></li>
                  <li class="nav-item"> <a class="nav-link" href="/perubahan-ekuitas"><p>Laporan Perubahan</p><p>Ekuitas</p></a></li>
                  <li class="nav-item"> <a class="nav-link" href="/arus-kas"><p>Laporan Arus Kas</p></a></li>
                  <li class="nav-item"> <a class="nav-link" href="/calk"><p>Catatan Atas</p><p>Laporan Keuangan</p></a></li>
                </ul>
              </div>
            </li>

          @endif

          @if(auth()->user()->role == 'unitusaha')

            {{-- EMKM --}}
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-emkm" aria-expanded="false" aria-controls="ui-emkm">
                <i class="mdi mdi-layers menu-icon"></i>
                <span class="menu-title">Laporan Keuangan <br> EMKM (Unit Usaha)</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-emkm">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="/laba-rugi">Laporan Laba Rugi</a></li>
                  <li class="nav-item"> <a class="nav-link" href="/posisi-keuangan"><p>Laporan Posisi</p><p>Keuangan</p></a></li>
                  <li class="nav-item"> <a class="nav-link" href="/calk"><p>Catatan Atas</p><p>Laporan Keuangan</p></a></li>
                </ul>
              </div>
            </li>

            
          @endif

          {{-- PPH21 --}}
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-pajak" aria-expanded="false" aria-controls="ui-pajak">
                <i class="fa fa-money menu-icon"></i>
                <span class="menu-title">Pajak</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-pajak">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="/pph21/bukti-potong-tetap"><p>PPh 21 - </p> <p>Bukti Potong</p> <p> Tetap</p></a></li>
                  <li class="nav-item"><a class="nav-link" href="/pph21/bukti-potong-tidaktetap"><p>PPh 21 - </p> <p>Bukti Potong</p> <p>Tidak Tetap</p></a></li>
                  <li class="nav-item"> <a class="nav-link" href="/pph21">PPh 21 - SPT</a></li>
                  <li class="nav-item"><a class="nav-link" href="/pph22/bukti-potong"><p>PPh 22 - </p> <p>Bukti Potong</p> </a></li>
                  <li class="nav-item"> <a class="nav-link" href="/pph22">PPh 22 - SPT</a></li>
                  <li class="nav-item"><a class="nav-link" href="/pph23/bukti-potong"><p>PPh 23 - </p> <p>Bukti Potong</p> </a></li>
                  <li class="nav-item"> <a class="nav-link" href="/pph23">PPh 23 - SPT</a></li>
                  <li class="nav-item"><a class="nav-link" href="/pph4ayat2"><p>PPh Pasal 4 - </p> <p>Ayat 2 - SPT</p> </a></li>
                </ul>
              </div>
            </li>
        </ul>
      </nav>
      <!-- partial -->

