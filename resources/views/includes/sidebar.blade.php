<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>Menu</h3>
    <ul class="nav side-menu">
      <li><a><i class="fa fa-tags"></i> Pendaftaran <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a>Pendaftaran<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="{{ URL::to('daftar-pribadi/create') }}">Rekam Master WP/WR Pribadi</a>

              </li>
              <li><a href="{{ URL::to('daftar-badan') }}">Rekam Master WP/WR Badan Usaha</a>
              </li>
              <hr>
              <li><a href="{{ URL::to('daftar-pribadi/table') }}">Daftar WP/WR Pribadi</a>
              </li>
              <li><a href="{{ URL::to('daftar-bu/table') }}">Daftar WP/WR Badan Usaha</a>
              </li>

              <li><a href="{{ URL::to('cetak_kartu') }}">Cetak Kartu NPWPD</a>
              </li>
            </ul>
          </li>
          <li><a>Pendataan<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="level2.html">Rekam Data Objek Pajak dan Retribusi</a>
              </li>
              <li><a href="#level2_1">Rekam Laporan Hasil Pemeriksaan (LHP) -- Self Assessment</a>
              </li>
              <li><a href="#level2_1">Rekam Laporan Hasil Pemeriksaan (LHP) -- Retribusi</a>
              </li>
              <li><a href="#level2_1">Rekam Laporan Hasil Pemeriksaan (LHP) -- Reklame</a>
              </li>
              <hr>
              <li><a href="#level2_1">Cetak Kartu Data</a>
              </li>
              <li><a href="#level2_1">Cetak Daftar Kartu Data</a>
              </li>
            </ul>
          </li>
          <li><a>Dokumentasi dan Pengolahan Data<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="level2.html">Cetak Daftar Induk WP/WR</a>
              </li>
              <li><a href="#level2_1">Cetak Daftar Perkembangan WP/WR</a>
              </li>
              <li><a href="#level2_1">Cetak Daftar List Perkembangan WP/WR</a>
              </li>
            </ul>
          </li>
          <li><a href="index2.html">Penutupan WP/WR</a></li>
          <li><a href="index3.html">Pembukaan kembali WP/WR</a></li>
        </ul>
      </li>
      <li><a><i class="fa fa-check-square-o"></i> Penetapan <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="index.html">Cetak Surat Ketetapan</a></li>
          <li><a href="{{ URL::to('penetapan/table') }}">Daftar Penetapan Pajak</a></li>
          <li><a href="index3.html">Cetak Daftar Surat Ketetapan</a></li>
        </ul>
      </li>
      <li><a><i class="fa fa-suitcase"></i> BKP <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a>Petugas Loket / Kasir Penerima<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="{{ url('penyetoran')}}">Rekam Penerimaan Pajak/Retribusi</a>
              </li>
              <hr>
              <li><a href="#">Daftar Setoran Official Assesment</a>
              </li>
              <li><a href="{{ URL::to('bkp/daftar-self') }}">Daftar Setoran Self Assesment</a>
              </li>
              <hr>
              <li><a href="#">Cetak Buku Pembantu Penerimaan Sejenis (BPPS) via</a>
              </li>
              <li><a href="#">Cetak Rekapitulasi Daftar Ketetapan dan Setoran</a>
              </li>
            </ul>
          </li>
          <li><a>Bendahara Penerima<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="#">Rekam Penyetoran ke Bank</a>
              </li>
              <li><a href="#">Cetak STS (Surat Setoran ke Bank)</a>
              </li>
              <li><a href="#">Cetak Laporan Pertanggungjawaban Penerimaan & Penyetoran Uang</a>
              </li>
              <li><a href="#">Cetak Buku Kas Umum</a>
              </li>
              <li><a href="#">Cetak Buku Jurnal Keluar Kas</a>
              </li>
              <li><a href="#">Cetak Laporan Realisasi Penerimaan Pajak Daerah</a>
              </li>
              <li><a href="#">++ Realisasi Penerimaan Setoran Harian Pajak Daerah</a>
              </li>
              <hr>
              <li><a href="#">Cetak Laporan Realisasi Penerimaan Pajak Daerah Bedasar tgl setor</a>
              </li>
              <li><a href="#">Cetak Laporan Pendapatan Diterima Dimuka</a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a><i class="fa fa-book"></i> Pembukuan Pelaporan <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a>Pembukuan Penerimaan<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="#">Cetak Buku Wajib Pajak / Retribusi ???</a>
              </li>
            </ul>
          </li>
          <li><a>Pembukuan Pelaporan<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="#">* Cetak Laporan Realisasi Penerimaan Pendapatan Daerah</a>
              </li>
              <li><a href="#">** Cetak REKAP Realisasi Penerimaan Pendapatan Daerah</a>
              </li>
              <li><a href="#">Cetak Laporan Realisasi Penerimaan Pajak Daerah</a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a><i class="fa fa-bullhorn"></i> Penagihan <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="#">Cetak Daftar Piutan Self</a></li>
          <li><a href="#">Cetak Daftar Piutang Official</a></li>
          <li><a href="#">Cetak Daftar Tunggakan</a></li>
          <li><a href="#">Cetak Daftar SKPD Reklame Habis Pajak</a></li>
          <li><a href="#">Cetak Surat Pemberitahuan Reklame</a></li>
          <li><a href="#">Cetak Rekap Laporan Piutan Tahunan</a></li>
        </ul>
      </li>
      <li><a><i class="fa fa-gears"></i> Pemeliharaan <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a>Menu Master<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="#">Tabel Pemda</a>
              </li>
              <li><a href="#">Tabel Bidang Satuan Kerja Kab / Kota</a>
              </li>
              <li><a href="#">Tabel Satuan Kerja Kab / Kota</a>
              </li>
              <li><a href="#">Tabel Kecamatan</a>
              </li>
              <li><a href="#">Tabel Kelurahan</a>
              </li>
              <li><a href="#">Tabel Anggaran</a>
              </li>
              <li><a href="#">Tabel Rekening</a>
              </li>
              <li><a href="#">Tabel Pos Anggaran</a>
              </li>
              <li><a href="#">Tabel Pejabat</a>
              </li>
              <li><a href="#">Tabel Operator</a>
              </li>
              <li><a href="#">Tabel Keterangan SPT</a>
              </li>
              <li><a href="#">Tabel Printer</a>
              </li>
              <li><a href="#">Tabel Kode Usaha</a>
              </li>
              <li><a href="#">Jatuh Tempo </a>
              </li>
              <li><a href="#">Tabel Password</a>
              </li>
              <li><a href="#">History Log </a>
              </li>
              <li><a href="#">Tabel Bank</a>
              </li>
            </ul>
          </li>
          <li><a>Menu Reklame<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="#">Tabel NJOP Reklame</a>
              </li>
              <li><a href="#">Tabel Ayat Jenis NJOPR</a>
              </li>
              <li><a href="#">Sudut Pandang</a>
              </li>
              <li><a href="#">Kelas Jalan</a>
              </li>
              <li><a href="#">Sudut Pandang dan Kelas Jalan</a>
              </li>
              <li><a href="#">Reklame - Lokasi Reklame</a>
              </li>
            </ul>
          </li>
          <li><a>Rekam Objek Pajak Multi</a></li>
          <li><a href="#">Import WP/WR Data</a></li>
          <li><a href="#">Import Kecamatan & Kelurahan Data</a></li>
        </ul>
      </li>
    </ul>
  </div>
  <!-- <div class="menu_section">
    <h3>Live On</h3>
    <ul class="nav side-menu">
      <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="e_commerce.html">E-commerce</a></li>
          <li><a href="projects.html">Projects</a></li>
          <li><a href="project_detail.html">Project Detail</a></li>
          <li><a href="contacts.html">Contacts</a></li>
          <li><a href="profile.html">Profile</a></li>
        </ul>
      </li>
      <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
          <li><a href="page_403.html">403 Error</a></li>
          <li><a href="page_404.html">404 Error</a></li>
          <li><a href="page_500.html">500 Error</a></li>
          <li><a href="plain_page.html">Plain Page</a></li>
          <li><a href="login.html">Login Page</a></li>
          <li><a href="pricing_tables.html">Pricing Tables</a></li>
        </ul>
      </li>
      <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="#level1_1">Level One</a>
            <li><a>Level One<span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li class="sub_menu"><a href="level2.html">Level Two</a>
                </li>
                <li><a href="#level2_1">Level Two</a>
                </li>
                <li><a href="#level2_2">Level Two</a>
                </li>
              </ul>
            </li>
            <li><a href="#level1_2">Level One</a>
            </li>
        </ul>
      </li>                  
      <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
    </ul>
  </div>-->

</div>

<!-- /menu footer buttons -->
<!-- <div class="sidebar-footer hidden-small">
  <a data-toggle="tooltip" data-placement="top" title="Settings">
    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
  </a>
  <a data-toggle="tooltip" data-placement="top" title="FullScreen">
    <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
  </a>
  <a data-toggle="tooltip" data-placement="top" title="Lock">
    <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
  </a>
  <a data-toggle="tooltip" data-placement="top" title="Logout">
    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
  </a>
</div> -->
<!-- /menu footer buttons -->