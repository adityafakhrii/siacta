<!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-between">
          <a class="navbar-brand brand-logo" href="index.html"><img src="../../images/logo-mini.svg" alt="logo"/></a>
          <a class="navbar-brand brand-logo-mini" href="index.html"><img src="../../images/logo-mini.svg" alt="logo"/></a>
          <div class="notification"> <i class="mdi mdi-bell-outline"></i> <span class="indicator"></span></div>
        </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
        <div class="d-none d-lg-flex">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link" href="#" data-toggle="dropdown" id="screenActionDropdown">
              <i class="mdi mdi-view-grid text-info mr-0"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="screenActionDropdown">
              <a class="dropdown-item">
                <i class="mdi mdi-fullscreen text-primary"></i>
                Fullscreen
              </a>
              <a class="dropdown-item">
                <i class="mdi mdi-fullscreen-exit text-primary"></i>
                Exit Fullscreen
              </a>
            </div>
          </li>
          <li class="nav-item nav-profile dropdown">
            <div class="nav-link"  data-toggle="dropdown" id="profileDropdown">
              <span>Hi, <span class="nav-profile-name">{{auth()->user()->nama}}</span></span>
              <span class="user-icon">A</span>
              </div>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown user-profile-action" aria-labelledby="profileDropdown">
              <div class="p-3 text-center bg-success">
                <img class="img-avatar img-avatar48 img-avatar-thumb" src="https://via.placeholder.com/36x36" alt="">
              </div>
              <div class="p-2">
                <a class="dropdown-item py-1 px-2 d-flex align-items-center justify-content-between" href="#">
                  <span>Profile</span>
                  <span class="p-0">
                    <span class="badge badge-success">1</span>
                    <i class="mdi mdi-account-outline ml-1"></i>
                  </span>
                </a>
                <a class="dropdown-item py-1  px-2 d-flex align-items-center justify-content-between" href="#">
                  <span>Log Out</span>
                  <i class="mdi mdi-logout ml-1"></i>
                </a>
              </div>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->