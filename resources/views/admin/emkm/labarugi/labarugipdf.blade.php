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
      						</p>
                  <p style="
                    font-size: 1.25rem;
                    line-height: 1.1px;
                    font-weight: 500;
                    text-align: center;
                    color: #3b3b3b;
                    margin-bottom: 30px;
                    ">
                    <b>Laporan Laba Rugi</b>
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

                        <tr>
                          <td colspan="3"><strong>Pendapatan</strong></td>
                        </tr>
                        <?php $total_pendapatan = 0; ?>
                      	@foreach($labarugi_pendapatan as $lr)
                        <tr>
                          <td>{{$lr->nama_akun}}</td>
                          <td>Rp{{ number_format($lr->saldo,2,",",".") }}</td>
                          <?php 
                            $total_pendapatan += $lr->saldo;
                          ?>
                        </tr>
                        @endforeach

                        <tr>
                          <td colspan="2"><strong>Total Pendapatan</strong></td>
                          <td><strong>Rp{{ number_format($total_pendapatan,2,",",".") }}</strong></td>
                        </tr>

                        <tr>
                          <td colspan="3"><strong>Beban</strong></td>
                        </tr>
                        <?php $total_beban = 0; ?>
                        @foreach($labarugi_beban as $lb)
                        <tr>
                          <td>{{$lb->nama_akun}}</td>
                          <td colspan="2">Rp{{ number_format($lb->saldo,2,",",".") }}</td>
                          <?php 
                            $total_beban += $lb->saldo;
                          ?>
                        </tr>
                        @endforeach

                        <tr style="background-color: #EAEAF1;">
                          <td colspan="2"><strong>Total Beban</strong></td>
                          <td><strong>Rp{{ number_format($total_beban,2,",",".") }}</strong></td>
                        </tr>

                        <tr style="background-color: #e8e6ff;">
                          <td colspan="2"><strong>Laba (Rugi) bersih sebelum pajak</strong></td>
                          <td><strong>Rp{{ number_format( $total_semua = $total_pendapatan - $total_beban,2,",",".") }}</strong></td>
                        </tr>

                        
                        <tr>
                          <td colspan="2">Pajak</td>
                          <?php 
                              $pajak = $total_pendapatan * (0.5/100);
                          ?>
                            <td>Rp{{ number_format(floor($pajak),2,",",".") }}</td>
                        </tr>

                        <tr>
                          <td colspan="2"><strong>Laba (Rugi) bersih setelah pajak</strong></td>
                          <td><strong>Rp{{ number_format( floor($total_semua - $pajak),2,",",".") }}</strong></td>
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