<?php
    function format_tgl ($tgl, $with_time=false, $char_bulan=false, $period=false) {

    // $arr_bulan = array("JANUARI","FEBRUARI","MARET","APRIL","MEI","JUNI","JULI","AGUSTUS","SEPTEMBER","OKTOBER","NOVEMBER","DESEMBER");

    $arr_bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

    $arr_bulan_num = array("01","02","03","04","05","06","07","08","09","10","11","12");

        if ($with_time) {
            list($tgl,$time) = explode(" ",$tgl);
        }

        if (!empty($tgl)) {
            $arr_tgl = explode("-",$tgl);
                if (!$char_bulan)
                $tgl = $arr_tgl[2]."-".$arr_tgl[1]."-".$arr_tgl[0];
                else {
                    foreach ($arr_bulan as $k => $v) {
                        if ($arr_bulan_num[$k] == $arr_tgl[1])
                        $arr_tgl[1] = $v;
                    }
                    if(!$period)
                    $tgl = $arr_tgl[0]." ".$arr_tgl[1]." ".$arr_tgl[2];
                    else
                    $tgl = $arr_tgl[1]." ".$arr_tgl[2];
                }
        }

        if ($with_time) {
            $tgl = $tgl." ".$time;
        }

        return $tgl;
    } 
    $tanggal = ($tgl_awal_conv <> $tgl_akhir_conv) ? format_tgl($tgl_awal_conv,false,true)." s/d ".format_tgl($tgl_akhir_conv,false,true):format_tgl($tgl_awal_conv,false,true);
?>
        <style type="text/css">
            body { font-family: Arial; font-size: 9pt; }
            #isi table,#isi th,#isi td {
                border: 1px solid #000000;
                padding:5px;
            }
            #judul{
                font-weight: bold;
            }
        </style>
            @if($button_val == 'pdf')
            <table>
                <tr>
                    <td style="width:50px">
                        <img width="50px" src="{{ public_path('logo_baru_pekalongan.jpg') }}">
                    </td>
                    <td style="width:25%">
            @endif
                        <table id="info">
                            <tr>
                                <td colspan="9" align="left" style="font-weight: bold;">PEMERINTAH {{strtoupper($pemda[0]->dapemda_nama." ".$pemda[0]->dapemda_nm_dati2)}}</td>
                            </tr>
                            <tr>
                                <td colspan="9" align="left" style="font-weight: bold;">{{strtoupper($pemda[0]->nama_dinas)}}</td>
                            </tr>
                            <tr>
                                <td colspan="9" align="left">{{ucwords(strtolower($pemda[0]->dapemda_lokasi))." - ".ucwords(strtolower($pemda[0]->dapemda_ibu_kota))}}</td>
                            </tr>
                            <tr>
                                <td colspan="9" align="left">Telp : {{$pemda[0]->dapemda_no_telp}}</td>
                            </tr>                
                        </table> 
            @if($button_val == 'pdf')            
                    </td>
                    <td style="width:50%">
            @endif
                        <table id="judul" >
                            <tr>
                                <td colspan="9" align="center">DAFTAR {{ strtoupper($arr_jenis_ketetapan[0]->ketspt_ket)." ( ".strtoupper($arr_jenis_ketetapan[0]->ketspt_singkat)." )"}}</td>
                            </tr>
                            <tr>
                                <td colspan="9" align="center">Jenis Pajak : {{$ar_objek_pajak[0]->ref_jenparet_ket}}</td>
                            </tr>
                            <tr>
                                <td colspan="9" align="center">Tanggal Penetapan: {{$tanggal}}</td>
                            </tr>            
                        </table>
            @if($button_val == 'pdf')
                    </td>
                </tr>
            </table>
            @endif
        <div id="isi">
            
        
        <table style="border-collapse: collapse;">
            <tr>
                <th rowspan="2" width="10"><b>No</b></th>
                <th colspan="2"><b>SKPD</b></th>
                <th><b>Nama</b></th>
                <th rowspan="2"><b>Rekening</b></th>
                <th rowspan="2"><b>NPWPD/NPWRD</b></th>
                <th rowspan="2"><b>Masa Pajak/Retribusi</b></th>
                <th rowspan="2"><b>Ketetapan</b></th>     
                <th rowspan="2"><b>Keterangan</b></th>
            </tr>
            <tr>
                @if($button_val == 'excel')
                <th></th>
                @endif
                <th>Tanggal</th>
                <th>Kohir</th>
                <th>Alamat</th>
            </tr>                
<?php         $nomor = 1;
            $total_spt_pajak = 0;
            foreach($rs as $aa => $bb) 
            {
?>              <tr>
                    <td align="center" rowspan="2">{{$nomor}}</td>
                    <td align="center" rowspan="2">{{format_tgl($bb->netapajrek_tgl)}}</td>
                    <td rowspan="2" align="center">{{$bb->netapajrek_kohir}}</td>
                    <td>{{$bb->wp_wr_nama}}</td>
                    <td rowspan="2">{{$bb->korek_nama}}</td>
                    <td rowspan="2">{{$bb->npwprd}}</td>
                    <td align="center">{{format_tgl($bb->spt_periode_jual1,false,true)}}</td>
                    <td align="right" rowspan="2">{{number_format($bb->spt_pajak, 2, ',', '.')}}</td>
                    <td rowspan='2'>{{$bb->reklame_wilayah.", ".$bb->reklame_jenis.", '".$bb->cnaskah."' ".$bb->npanjang."m x ".$bb->nlebar."m x ".$bb->nmuka." muka x ".$bb->njumlah." unit\n ".$bb->clokasi}}</td>;
                    
                    
                </tr>
                <tr>
                @if($button_val == 'excel')
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
                    <td>{{$bb->wp_wr_almt}}</td>
                    <td align="center">{{format_tgl($bb->spt_periode_jual2,false,true)}}</td>
                </tr>
<?php              $total_spt_pajak += $bb->spt_pajak;
                $nomor++;
            }
?>         <tr>
                <td colspan="7" align="center"><b>TOTAL KETETAPAN</b></td>
                <td align="right"><b>{{number_format($total_spt_pajak, 2, ',', '.')}}</td>
            </tr>          
        </table>
        </div>
        <br>
        <br>
        <br>
        <div style="page-break-inside: avoid">
            <table style="width:100%">
                <tr>
                    <td colspan="3" align="center" style="width: 30%">Mengetahui,</td>
                    <td colspan="3" align="center" style="width: 30%">Diperiksa Oleh,</td>                
                    <td style="width: 10%">Tanggal Cetak</td>
                    <td style="width: 20%">: <?php echo format_tgl($tgl_cetak_conv,false,true)?></td>
                </tr>
                <tr>
                    <td colspan="3" align="center">{{strtoupper($mengetahui[0]->ref_japeda_nama)}}</td>
                    <td colspan="3" align="center">{{strtoupper($pemeriksa[0]->ref_japeda_nama)}}</td>                
                    <td>Nama</td>
                    <td>: {{$operator}}</td>                
                </tr>
                <tr>
                    <td colspan="3" align="center"></td>
                    <td colspan="3" align="center"></td>                                
                    <td>Jabatan</td>
                    <td>: {{$jabatan}}</td>                
                </tr>
                <tr>
                    <td colspan="3" align="center"></td>
                    <td colspan="3" align="center"></td>                                
                    <td style="width: 10%">Tanda Tangan:</td>
                    <td style="width: 20%">:</td>              
                </tr>
                <tr>
                    <td colspan="3" align="center"></td>
                    <td colspan="3" align="center"></td>                                
                    <td style="width: 10%"></td>
                    <td style="width: 20%"></td>              
                </tr>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <tr>
                    <td colspan="3" align="center" style="width: 30%">{{strtoupper($mengetahui[0]->pejda_nama)}}</td>
                    <td colspan="3" align="center" style="width: 30%">{{strtoupper($pemeriksa[0]->pejda_nama)}}</td>                
                    <td style="width: 10%"></td>
                    <td style="width: 20%"></td>                                
                </tr>                        
                <tr>
                    <td colspan="3" align="center">{{$mengetahui[0]->ref_pangpej_ket}}</td>
                    <td colspan="3" align="center">{{$pemeriksa[0]->ref_pangpej_ket}}</td>                
                </tr>            
                <tr>
                    <td colspan="3" align="center">NIP. {{$mengetahui[0]->pejda_nip}}</td>
                    <td colspan="3" align="center">NIP. {{$pemeriksa[0]->pejda_nip}}</td>                
                </tr>                        
            </table>
        </div>
        