<style type="text/css">
    .header__info ul li {
        float: left;
        display: inline-block;
        white-space: nowrap;
    }

    .header__info ul li a {
        color: #a3adb9;
        padding: 0 14px 0 0;
        line-height: 30px;
        /*border-right: 1px solid white;*/
        font-size: 12px;
    }

    .header__info ul li a:hover {
        color: white!important;
    }
</style>
<div class="header__inner d-none d-lg-block" style="height: 35px!important;">
    <div class="header__info text-nowrap d-block w-100">
        <ul style="" class="pl-0 mb-0 list-unstyled">
            <!-- <li><a href="javascript:void(0)"><i class="psi-geo-2 me-1" style="margin-top: -4px;"></i> Jl. Tuparev No. 70, Cirebon</a></li>
            <li><a href="javascript:void(0)"><i class="psi-geo-2 me-1" style="margin-top: -4px;"></i> Jl. Watubelah No. 40, Sumber</a></li>
            <li><a href="javascript:void(0)"><i class="psi-geo-2 me-1" style="margin-top: -4px;"></i> Jl. Watubelah, Sumber</a></li> -->
            <li><a href="tel:0231209608"><i class="psi-telephone me-1" style="margin-top: -4px;"></i> (0231) 209608</a></li>
            <li><a href="mailto:mbkm@umc.ac.id"><i class="psi-mail me-1"></i> mbkm@umc.ac.id</a></li>
            <li><a href="mailto:rektorat@umc.ac.id"><i class="psi-mail me-1"></i> rektorat@umc.ac.id</a></li>
        </ul>
    </div>
</div>
<div class="header__inner">

    <!-- Brand -->
    <div class="header__brand">
        <div class="brand-wrap">

            <!-- Brand logo -->
            <a href="<?= base_url('dasbor') ?>" class="brand-img stretched-link">
                <img src="<?= base_url('assets/img/umc_mbkm.png') ?>" alt="<?= $_ENV['APP_NAME'] ?>" class="Nifty logo w-auto" style="height: 32px!important;">
            </a>

            <!-- Brand title -->
            <!-- <div class="brand-title"><?= strtoupper($_ENV['APP_NAME']) ?></div> -->

            <!-- You can also use IMG or SVG instead of a text element. -->

        </div>
    </div>
    <!-- End - Brand -->

    <div class="header__content">

        <!-- Content Header - Left Side: -->
        <div class="header__content-start">

            <!-- Navigation Toggler -->
            <!-- <button type="button" class="nav-toggler header__btn btn btn-icon btn-sm d-none d-lg-block" aria-label="Nav Toggler">
                <i class="psi-list-view"></i>
            </button> -->

            <!-- Tahun akademik -->
            <!-- <div class="dropdown ms-3">
                <span>Tahun Akademik : ~</span>
            </div> -->
            <!-- End - Tahun akademik -->
        </div>
        <!-- End - Content Header - Left Side -->

        <!-- Content Header - Right Side: -->
        <div class="header__content-end">
            <style type="text/css">
                .menu__header .nav-link {
                    color: white!important;
                }
                .menu__header .nav:not(.nav-pills) .nav-link.active {
                    color: #EAD202!important;
                }
            </style>
            <ul class="mainnav__menu nav menu__header d-none d-lg-flex">
                <?php 
                    $this->Menu_model->show('mahasiswa');
                ?>
            </ul>


            <a href="<?= base_url('registrasi') ?>" class="d-block d-lg-none me-4 text-white">
                Daftar
            </a>

            <a href="<?= base_url('dasbor?redirect=https://sso.ensitec.net') ?>" class="d-block d-lg-none me-4 text-white">
                Login
            </a>

            <!-- Navigation Toggler -->
            <button type="button" class="nav-toggler header__btn btn btn-icon btn-sm d-block d-lg-none" aria-label="Nav Toggler">
                <i class="psi-list-view"></i>
            </button>

        </div>
    </div>
</div>