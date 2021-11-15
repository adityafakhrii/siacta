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
                    <b>Laporan Perubahan Ekuitas</b>
                  </p>
                  <p style="
                    font-size: 1rem;
                    font-weight: 300;
                    line-height: 1.1px;
                    text-align: center;
                    color: #3b3b3b;
                    margin-bottom: 30px;
                    ">
                    <b>Periode tanggal {{ date('d F Y', strtotime('last day of this month', time())) }}</b>
                  </p>
                </div>
                <!-- /pull-left -->
                
                <table border="1" width="100%">
                	<tbody>

                        <?php $total_ma = 0; ?>
                        @foreach($modal_awal as $ma)
                        <tr>
                          <td>{{$ma->nama_akun}}</td>
                          <td></td>
                          <td>Rp{{ number_format($ma->saldo,2,",",".") }}</td>
                          <?php 
                            $total_ma += $ma->saldo;
                          ?>
                        </tr>
                        @endforeach

                        <?php $total_tm = 0; ?>
                      	@foreach($tambahan_modal as $tm)
                        <tr>
                          <td>{{$tm->nama_akun}}</td>
                          <td></td>
                          <td>Rp{{ number_format($tm->saldo,2,",",".") }}</td>
                          <?php 
                            $total_tm += $tm->saldo;
                          ?>
                        </tr>
                        @endforeach

                        <tr>
                          <td colspan="2">Total Tambahan Modal</td>
                          <td>Rp{{ number_format($total_tm,2,",",".") }}</td>
                        </tr>
                        <tr>
                          <td colspan="2"><strong>Perubahan Modal</strong></td>
                          <td><strong>Rp{{ number_format($perubahan = $total_tm + $total_ma ,2,",",".") }}</strong></td>
                        </tr>

                        <tr>
                          <td>Laba (Rugi) Bersih</td>
                          <td>Rp{{ number_format($total_labarugi,2,",",".") }}</td>
                          <td></td>
                        </tr>

                        <?php $total_prive = 0; ?>
                        @foreach($prive as $p)
                        <tr>
                          <td>{{$p->nama_akun}}</td>
                          <td>Rp{{ number_format($p->saldo,2,",",".") }}</td>
                          <td></td>
                          <?php 
                            $total_prive += $p->saldo;
                          ?>
                        </tr>
                        @endforeach

                        <tr>
                          <td colspan="2"><h5><strong>Kenaikan (penurunan) modal</strong></h5></td>
                          <td><strong>Rp{{ number_format($kenaikan = $total_labarugi - $total_prive,2,",",".") }}</strong></td>
                        </tr>

                        <tr>
                          <td colspan="2"><h5><strong>Modal Akhir</strong></h5></td>
                          <td><strong>Rp{{ number_format($perubahan + $kenaikan,2,",",".") }}</strong></td>
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