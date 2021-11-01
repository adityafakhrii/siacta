<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Profil BUMDes</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: FlexStart - v1.7.0
  * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="/" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span>SIACTA</span>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="/">Home</a></li>
          <li class="dropdown active"><a href="#"><span>Tentang</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="/tentang-siacta">Tentang SIACTA</a></li>
              <li><a href="/profil-bumdes">Profil BUMDes</a></li>
            </ul>
          </li>
          <li><a class="nav-link scrollto" href="/#kelebihan">Kelebihan</a></li>
          <li><a class="nav-link scrollto" href="/#laporan">Report</a></li>
          <li><a class="nav-link scrollto" href="/#team">Team</a></li>
          <li><a class="nav-link scrollto" href="/#kontak">Kontak</a></li>
          @if(Auth::check())
          <li><a class="getstarted scrollto" href="/login">Login</a></li>
          @else
          <li><a class="getstarted scrollto" href="/login">Login</a></li>
          @endif
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="/">Home</a></li>
          <li><a href="#tentang">Tentang</a></li>
          <li>Profil BUMDes</li>
        </ol>
        <h2>Profil BUMDes</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Blog Single Section ======= -->
    <section id="blog" class="blog">
      <div class="container" data-aos="fade-up">

        <div class="row">

          <div class="col-lg-12 entries">

            <article class="entry entry-single">

              <h2 class="entry-title" align="center">
                <a href="blog-single.html">BUMDes Sauyunan</a>
              </h2>

              <div class="entry-content" style="text-align: justify; text-justify: inter-word;">
                <p>
                  System Information Accounting and Tax merupakan sebuah aplikasi  yang terintegrasi berbasis web yang dibuat dan dikembangkan menggunakan bahasa pemrograman PHP yang dikombinasikan dengan framework Laravel.
                 Kami memulai pembuatan aplikasi ini dengan menentukan rancangan-rancangan dasar atau konsep sebelum ke tahap pengkodean program. 
                </p>

                <p>
                  Gambaran konsep kami buat dalam bentuk flowchart yang dimulai dari proses input hingga proses output aplikasi tersebut berakhir. Kemudian untuk rancangan database sistem, kami menggunakan konsep ERD atau Entity Relationship Diagram agar mudah dipahami saat pembuatan sistem berlangsung.
                </p>

                <p>
                  Dengan perencanaan flowchart yang tersusun dengan baik dan rancangan database yang matang, kami dapat membangun aplikasi ini dengan baik dan efisien. Lalu untuk membuat tampilan, kami membuatnya dengan html, css, bootstrap, javascript, dan berbagai macam library javascript sebagai pendukung agar aplikasi lebih interaktif dan memudahkan pengguna.
                </p>

              </div>

            </article><!-- End blog entry -->

          </div><!-- End blog entries list -->

        </div>

      </div>
    </section><!-- End Blog Single Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">

          <div class="col-lg-5 col-md-12 footer-info">
            <a href="index.html" class="logo d-flex align-items-center">
              <img src="assets/img/logo.png" alt="">
              <span>SIACTA</span>
            </a>
            <p>Sistem yang dapat mempermudah pengelola BUMDes untuk mencatat transaksi hingga menyusun laporan keuangan serta meningkatkan kepatuhan terhadap pajak.</p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
          <div class="col-lg-1 col-6 footer-links">
          </div>
          <div class="col-lg-3 col-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="/#tentang">Home</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="/#tentang">Tentang</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="/#kelebihan">Kelebihan</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="/#laporan">Laporan</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="/#team">Team</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="/#kontak">Kontak</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
            <h4>Kontak Kami</h4>
            <p>
              <strong>Email:</strong> info@siacta.com<br>
              <strong>Instagram:</strong> @siacta.id<br>
            </p>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
         Copyright &copy; 2021 <strong><span>SIACTA</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/flexstart-bootstrap-startup-template/ -->
        Team PHP2D 2021 <a href="https://widyatama.ac.id/">Universitas Widyatama</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>