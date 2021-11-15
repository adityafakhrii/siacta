<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<style>

  *{
    box-sizing: border-box;
  }

	@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
	.page-break {
	    page-break-after: always;
	}
	.abu{
		color: #595959;
	}
	
  .row {
  margin-left:-5px;
  margin-right:-5px;
}
  
.column {
  float: left;
  width: 50%;
  padding: 5px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
}

th, td {
  text-align: left;
  padding: 16px;
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
                  
                  @if(Auth::user()->role == "unitusaha")
                	<p style="
                  	font-size: 1.3rem;
                  	font-weight: 700;
      					    line-height: 1.1px;
      					    text-align: center;
      					    color: #3b3b3b;
                    margin-bottom: 30px;
      					    ">
                    <b>Unit Usaha Air PAMDes</b>
      						</p>
                  <p style="
                    font-size: 1.25rem;
                    line-height: 1.1px;
                    font-weight: 500;
                    text-align: center;
                    color: #3b3b3b;
                    margin-bottom: 30px;
                    ">
                    <b>Laporan Posisi Keuangan</b>
                  </p>
                  @else
                  <p style="
                    font-size: 1.25rem;
                    line-height: 1.1px;
                    font-weight: 500;
                    text-align: center;
                    color: #3b3b3b;
                    margin-bottom: 30px;
                    ">
                    <b>Laporan Neraca</b>
                  </p>
                  @endif

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
                
                

                <div class="row">
                  <div class="column">
                    <table>
                      <tbody>
                        <tr>
                          <td align="center" colspan="3"> <strong>ASET</strong> </td>
                        </tr>

                        <tr>
                          <td colspan="3"> <strong>Aset Lancar</strong> </td>
                        </tr>
                        <?php $total_aslan = 0; ?>
                        @foreach($asetlancar as $aslan)
                        <tr>
                          <td>{{$aslan->no_akun}}</td>
                          <td>{{$aslan->nama_akun}}</td>
                          <td>Rp{{ number_format($aslan->saldo,2,",",".") }}</td>
                          <?php 
                            $total_aslan += $aslan->saldo;
                          ?>
                        </tr>
                        @endforeach
                        <tr>
                          <td colspan="2"> <strong>Total Aset Lancar</strong> </td>
                          <td><strong>Rp{{ number_format($total_aslan,2,",",".") }}</strong></td>
                        </tr>

                        <tr>
                          <td colspan="3"> <strong>Aset Tetap</strong> </td>
                        </tr>
                        <?php $total_astetdeb = 0; ?>
                        @foreach($asettetapdebit as $astetdeb)
                        <tr>
                          <td>{{$astetdeb->no_akun}}</td>
                          <td>{{$astetdeb->nama_akun}}</td>
                          <td>Rp{{ number_format($astetdeb->saldo,2,",",".") }}</td>
                          <?php 
                            $total_astetdeb += $astetdeb->saldo;
                          ?>
                        </tr>
                        @endforeach
                        <?php $total_astetkre = 0; ?>
                        @foreach($asettetapkredit as $astetkre)
                        <tr>
                          <td>{{$astetkre->no_akun}}</td>
                          <td>{{$astetkre->nama_akun}}</td>
                          <td>Rp{{ number_format($astetkre->saldo,2,",",".") }}</td>
                          <?php 
                            $total_astetkre += $astetkre->saldo;
                          ?>
                        </tr>
                        @endforeach


                        <tr>
                          <td colspan="2"> <strong>Total Aset Tetap</strong> </td>
                          <td><strong>Rp{{ number_format($total_astet = $total_astetdeb-$total_astetkre,2,",",".") }}</strong></td>
                        </tr>

                        <tr>
                          <td colspan="3"> <strong>Aset Tidak Berwujud</strong> </td>
                        </tr>
                        <?php $total_astiber = 0; ?>
                        @foreach($asettidakberwujud as $astiber)
                        <tr>
                          <td>{{$astiber->no_akun}}</td>
                          <td>{{$astiber->nama_akun}}</td>
                          <td>Rp{{ number_format($astiber->saldo,2,",",".") }}</td>
                          <?php
                            $total_astiber += $astiber->saldo;
                          ?>
                        </tr>
                        @endforeach
                        <tr>
                          <td colspan="2"> <strong>Total Aset Tidak Berwujud</strong> </td>
                          <td><strong>Rp{{ number_format($total_astiber,2,",",".") }}</strong></td>
                        </tr>

                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="2" align="center"><strong>TOTAL ASET</strong></td>
                          <td><strong>Rp{{ number_format($total1 = $total_aslan+$total_astet+$total_astiber,2,",",".") }}</strong></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>

                  <div class="column">
                    <table>
                      <tbody>
                        <tr>
                          <td align="center" colspan="3"> <strong>KEWAJIBAN & EKUITAS</strong> </td>
                        </tr>

                        <tr>
                          <td colspan="3"> <strong>KEWAJIBAN</strong> </td>
                        </tr>
                        <?php $total_kew = 0; ?>
                        @foreach($kewajiban as $kew)
                        <tr>
                          <td>{{$kew->no_akun}}</td>
                          <td>{{$kew->nama_akun}}</td>
                          <td>Rp{{ number_format($kew->saldo,2,",",".") }}</td>
                          <?php 
                            $total_kew += $kew->saldo;
                          ?>
                        </tr>
                        @endforeach
                        <tr>
                          <td colspan="2"> <strong>Total Kewajiban</strong> </td>
                          <td><strong>Rp{{ number_format($total_kew,2,",",".") }}</strong></td>
                        </tr>

                        <tr>
                          <td colspan="3"> <strong>EKUITAS</strong> </td>
                        </tr>
                        <?php $total_ekui = 0; ?>
                        @foreach($ekuitas as $ekui)
                        <tr>
                          <td>{{$ekui->no_akun}}</td>
                          <td>{{$ekui->nama_akun}}</td>
                          <td>Rp{{ number_format($ekui->saldo,2,",",".") }}</td>
                          <?php 
                            $total_ekui += $ekui->saldo;
                          ?>
                        </tr>
                        @endforeach

                        @if($total_labarugi < 0)
                          @foreach ($saldorugi as $sr)
                          <tr>
                            <td>{{$sr->no_akun}}</td>
                            <td>{{$sr->nama_akun}}</td>
                            <td><strong>Rp{{ number_format($total_labarugi,2,",",".") }}</strong></td>
                          </tr>
                            
                          @endforeach
                          <tr>
                            <td colspan="2"> <strong>Total Ekuitas</strong> </td>
                            <td><strong>Rp{{ number_format($total_ekuitas = $total_ekui+$total_labarugi,2,",",".") }}</strong></td>
                          </tr>
                        @elseif($total_labarugi > 0)
                          @foreach ($saldolaba as $sl)
                          <tr>
                            <td>{{$sl->no_akun}}</td>
                            <td>{{$sl->nama_akun}}</td>
                            <td><strong>Rp{{ number_format($total_labarugi,2,",",".") }}</strong></td>
                          </tr>
                            
                          @endforeach
                          <tr>
                            <td colspan="2"> <strong>Total Ekuitas</strong> </td>
                            <td><strong>Rp{{ number_format($total_ekuitas = $total_ekui+$total_labarugi,2,",",".") }}</strong></td>
                          </tr>
                        @else
                          <tr>
                            <td colspan="2"> <strong>Total Ekuitas</strong> </td>
                            <td><strong>Rp{{ number_format($total_ekuitas = $total_ekui+0,2,",",".") }}</strong></td>
                          </tr>
                        @endif

                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="2" align="center"><strong>TOTAL KEWAJIBAN & EKUITAS</strong></td>
                          <td><strong>Rp{{ number_format($total2 = $total_kew+$total_ekuitas,2,",",".") }}</strong></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  
                </div>
                
                <br>
                <br>
              </div>
              
      </section>
    </section>
</section>
	
</body>