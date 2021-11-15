<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
	.page-break {
	    page-break-after: always;
	}
	.abu{
		color: #595959;
	}
	td {
	    vertical-align: middle;
	}
  table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
  }

	.table{
		width: 100%;
	    max-width: 100%;
	    margin-bottom: 20px;
		background-color: transparent;
		border-spacing: 0;
		border-collapse: collapse;
	}
</style>
<body style="    
    font-family: 'Montserrat', sans-serif;">

	
	<section id="container">
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="col-lg-12 mt">
          <div class="row content-panel">
            <div class="col-lg-10 col-lg-offset-1">
              <div class="invoice-body">
                <div class="pull-left">
                  <p style="
                    font-size: 1.5rem;
                    font-weight: 700;
                    line-height: 1.1px;
                    text-align: center;
                    color: #3b3b3b;
                    margin-bottom: 35px;
                    ">
                    <b>BUMDes Sauyunan</b>
                  </p>
                	<p style="
                  	font-size: 1.3rem;
                  	font-weight: 700;
      					    line-height: 1.1px;
      					    text-align: center;
      					    color: #3b3b3b;
                    margin-bottom: 30px;
      					    ">
                    @if(Auth::user()->role == "unitusaha")
                    <b>Unit Usaha Air PAMDes</b>
                    @endif
      						</p>
                  <p style="
                    font-size: 1.25rem;
                    line-height: 1.1px;
                    font-weight: 500;
                    text-align: center;
                    color: #3b3b3b;
                    margin-bottom: 30px;
                    ">
                    <b>Laporan Arus Kas</b>
                  </p>
                  <p style="
                    font-size: 1rem;
                    font-weight: 300;
                    line-height: 1.1px;
                    text-align: center;
                    color: #3b3b3b;
                    margin-top: 10px;
                    ">
                    <b>Periode tanggal {{ date('d F Y', strtotime('last day of this month', time())) }}</b>
                  </p>
                </div>
                <!-- /pull-left -->
                
                <table border="1" width="100%">
                  <tbody>

                    <tr>
                      <td colspan="3"><strong>Aktivitas Operasional</strong></td>
                      
                    </tr>
                    <tr>
                      <td colspan="3"><h5><strong>Pendapatan Operasional</strong></h5></td>
                      
                    </tr>

                    <?php $total_po = 0; ?>
                    @foreach($operasional as $po)
                    <tr>
                      <td>{{$po->nama_akun}}</td>
                      <td colspan="2">Rp{{ number_format($po->saldo,2,",",".") }}</td>
                      
                      <?php 
                        $total_po += $po->saldo;
                      ?>
                    </tr>
                    @endforeach
                    <tr>
                      <td><strong>Total Pendapatan Operasional</strong></td>
                      
                      <td colspan="2"><strong>Rp{{ number_format($total_po,2,",",".") }}</strong></td>
                    </tr>

                    <tr>
                      <td colspan="3"><h5><strong>Beban Operasional</strong></h5></td>
                      
                    </tr>
                    <?php $total_bo = 0; ?>
                    @foreach($beban as $bo)
                    <tr>
                      <td>{{$bo->nama_akun}}</td>
                      <td colspan="2">Rp{{ number_format($bo->saldo,2,",",".") }}</td>
                      
                      <?php 
                        $total_bo += $bo->saldo;
                      ?>
                    </tr>
                    @endforeach
                    <tr>
                      <td><strong>Total Beban Operasional</strong></td>
                      
                      <td colspan="2"><strong>Rp{{ number_format($total_bo,2,",",".") }}</strong></td>
                    </tr>

                    <tr>
                      <td><strong>Arus Kas dari Aktivitas Operasional</strong></td>
                      
                      <td colspan="2"><strong>Rp{{ number_format($total_operasional = $total_po-$total_bo,2,",",".") }}</strong></td>
                    </tr>

                    <tr>
                      <td colspan="3"><strong>Aktivitas Investasi</strong></td>
                      
                    </tr>

                    <tr>
                      <td colspan="3"><h5><strong>Pendapatan Investasi</strong></h5></td>
                      
                    </tr>
                    <?php $total_intambah = 0; ?>
                    @foreach($investtambah as $in)
                    <tr>
                      <td>{{$in->nama_akun}}</td>
                      <td colspan="2">Rp{{ number_format($in->kredit,2,",",".") }}</td>
                      
                      <?php 
                        $total_intambah += $in->kredit;
                      ?>
                    </tr>
                    @endforeach
                    <?php $total_intambah2 = 0; ?>
                    @foreach($investtambah2 as $in)
                    <tr>
                      <td>{{$in->nama_akun}}</td>
                      <td colspan="2">Rp{{ number_format($in->saldo,2,",",".") }}</td>
                      
                      <?php 
                        $total_intambah2 += $in->saldo;
                      ?>
                    </tr>
                    @endforeach

                    <?php $total_tambah = $total_intambah+$total_intambah2 ?>

                    <tr>
                      <td><strong>Total Pendapatan Investasi</strong></td>
                      
                      <td colspan="2"><strong>Rp{{ number_format($total_intambah+$total_intambah2,2,",",".") }}</strong></td>
                    </tr>


                    <tr>
                      <td colspan="3"><h5><strong>Beban Investasi</strong></h5></td>
                      
                    </tr>

                    <?php $total_inkurang = 0; ?>
                    @foreach($investkurang as $in)
                    <tr>
                      <td>{{$in->nama_akun}}</td>
                      <td colspan="2">Rp{{ number_format($in->debit,2,",",".") }}</td>
                      
                      <?php 
                        $total_inkurang += $in->debit;
                      ?>
                    </tr>
                    @endforeach

                    <?php $total_inkurang2 = 0; ?>
                    @foreach($investkurang2 as $in)
                    <tr>
                      <td>{{$in->nama_akun}}</td>
                      <td colspan="2">Rp{{ number_format($in->saldo,2,",",".") }}</td>
                      
                      <?php 
                        $total_inkurang2 += $in->saldo;
                      ?>
                    </tr>
                    @endforeach
                    <tr>
                      <td><strong>Total Beban Investasi</strong></td>
                      
                      <td colspan="2"><strong>Rp{{ number_format($total_inkurang+$total_inkurang2,2,",",".") }}</strong></td>
                    </tr>

                    <?php $total_kurang = $total_inkurang+$total_inkurang2 ?>

                    <tr>
                      <td><h5><strong>Arus Kas dari Aktivitas Investasi</strong></h5></td>
                      
                      <td colspan="2"><strong>Rp{{ number_format($total_investasi = $total_tambah-$total_kurang,2,",",".") }}</strong></td>
                    </tr>

                    <tr>
                      <td colspan="3"><h5><strong>Aktivitas Pendanaan</strong></h5></td>
                      
                    </tr>

                    <tr>
                      <td colspan="3"><strong>Pendapatan Pendanaan</strong></td>
                      
                    </tr>

                    <?php $total_pendtambah = 0; ?>
                    @foreach($pendanaantambah as $pt)
                    <tr>
                      <td>{{$pt->nama_akun}}</td>
                      <td colspan="2">Rp{{ number_format($pt->saldo,2,",",".") }}</td>
                      
                      <?php 
                        $total_pendtambah += $pt->saldo;
                      ?>
                    </tr>
                    @endforeach
                    <tr>
                      <td><strong>Total Pendapatan Pendanaan</strong></td>
                      
                      <td colspan="2"><strong>Rp{{ number_format($total_pendtambah,2,",",".") }}</strong></td>
                    </tr>

                    <tr>
                      <td colspan="3"><h5><strong>Beban Pendanaan</strong></h5></td>
                      
                    </tr>

                    <?php $total_pendkurang = 0; ?>
                    @foreach($pendanaankurang as $pk)
                    <tr>
                      <td>{{$pk->nama_akun}}</td>
                      <td colspan="2">Rp{{ number_format($pk->saldo,2,",",".") }}</td>
                      
                      <?php 
                        $total_pendkurang += $pk->saldo;
                      ?>
                    </tr>
                    @endforeach
                    <tr>
                      <td><strong>Total Pendapatan Pendanaan</strong></td>
                      
                      <td colspan="2"><strong>Rp{{ number_format($total_pendkurang,2,",",".") }}</strong></td>
                    </tr>

                    <tr>
                      <td><strong>Arus Kas dari Aktivitas Pendanaan</strong></td>
                      
                      <td colspan="2"><strong>Rp{{ number_format($total_pendanaan = $total_pendtambah-$total_pendkurang,2,",",".") }}</strong></td>
                    </tr>

                    <tr>
                      <td class="saldoawal"><strong>Kenaikan (penurunan) Bersih Kas</strong></td>
                      
                      <td colspan="2"><strong>Rp{{ number_format($total_semua = $total_operasional+$total_investasi+$total_pendanaan,2,",",".") }}</strong></td>
                    </tr>
                    <tr>
                      <td class="saldoawal"><strong>Saldo Awal Kas</strong></td>
                      
                      <td colspan="2"><strong>Rp{{ number_format($total_saldoawal = $saldoawal->debit,2,",",".") }}</strong></td>
                    </tr>
                    <tr>
                      <td class="saldoawal"><strong>Saldo Akhir Kas</strong></td>
                      
                      <td colspan="2"><strong>Rp{{ number_format($total_semua + $total_saldoawal,2,",",".") }}</strong></td>
                    </tr>

                  </tbody>
                </table>
                
                <br>
                <br>
              </div>
              
      </section>
    </section>
</section>
	
</body>