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
      			  @endif
                  <p style="
                    font-size: 1.25rem;
                    line-height: 1.1px;
                    font-weight: 500;
                    text-align: center;
                    color: #3b3b3b;
                    margin-bottom: 30px;
                    ">
                    <b>Neraca Saldo Sebelum Penyesuaian</b>
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
                      <thead>
                        <tr>
                          <th>Nomor Akun</th>
                          <th>Nama Akun</th>
                          <th>Debit</th>
                          <th>Kredit</th>
                      </thead>
                        <tbody>
                          <?php
                           $total_debit = 0;
                           $total_kredit = 0;
                          ?>
                          @foreach($neracasaldo as $ns)
                          <tr>
                            <td align="left">{{$ns->akun->no_akun}}</td>
                            <td align="left">{{$ns->akun->nama_akun}}</td>
                            @if($ns->debit != NULL)
                            <td align="right">
                            Rp{{ number_format($ns->debit,2,",",".") }}
                            </td>
                            @else
                            <td align="center">-</td>
                            @endif
                            @if($ns->kredit != NULL)
                            <td align="right">
                            Rp{{ number_format($ns->kredit,2,",",".") }}
                            </td>
                            @else
                            <td align="center">-</td>
                            @endif
                          </tr>
                          <?php
                            $total_debit += $ns->debit;
                            $total_kredit += $ns->kredit;
                          ?>
                          @endforeach
                          <tr>
                          	<td align="center" colspan="2"> <h5><strong>Total</strong></h5> </td>
	                          <td align="right"> <strong>Rp{{ number_format($total_debit,2,",",".") }}</strong></td>
	                          <td align="right"><strong>Rp{{ number_format($total_kredit,2,",",".") }}</strong></td>
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