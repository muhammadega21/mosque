<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ url('/') }}" class="logo d-flex justify-content-center align-items-center">
            <img src="{{ asset('img/logo2.png') }}" alt="">
            <span class="d-none d-lg-block">DokuMosque</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">

                <div class="nav-link nav-profile d-flex align-items-center pe-0">
                    <div class="profile-name me-3 text-end">
                        <span>Welcome, {{ Auth()->user()->user_data->nama }}</span>
                        <span class="role">{{ Str::upper(Auth()->user()->role) }}</span>
                    </div>
                    <div class="rounded-circle overflow-hidden " style="width: 35px; height: 35px;">
                        <img src="{{ asset('img/user.png') }}" alt="Profile" class="w-100 h-100 object-fit-cover ">
                    </div>
                    <i class="bx bx-arrow-down"></i>
                </div><!-- End Profile Iamge Icon -->



            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
