<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <link rel="shortcut icon" href="<?= base_url('assets/img/favicon.png') ?>">
    <link rel="manifest" href="<?= base_url('manifest.json') ?>">

    <title><?= $title ?> | <?= $_ENV['APP_NAME'] ?> - <?= $_ENV['INST_NAME'] ?></title>

    <!-- Fonts [ OPTIONAL ] -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS [ REQUIRED ] -->
    <!-- <link rel="stylesheet" href="<?= $_ENV['THM_LINK'] ?>css/bootstrap.min.css"> -->

    <!-- Nifty CSS [ REQUIRED ] -->
    <!-- <link rel="stylesheet" href="<?= $_ENV['THM_LINK'] ?>css/nifty.min.css"> -->

    <!-- Premium icons [ OPTIONAL ] -->
    <link rel="stylesheet" href="<?= $_ENV['THM_LINK'] ?>premium/icon-sets/icons/line-icons/premium-line-icons.min.css">
    <link rel="stylesheet" href="<?= $_ENV['THM_LINK'] ?>premium/icon-sets/icons/solid-icons/premium-solid-icons.min.css">

     <!-- Color Scheme -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/color-schemes/all-headers/umc/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/color-schemes/all-headers/umc/nifty.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/r-2.3.0/datatables.min.css"/>
 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/r-2.3.0/datatables.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/') ?>slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/') ?>slick/slick-theme.css"/>

    <link rel="stylesheet" href="<?= $_ENV['THM_LINK'] ?>vendors/loader.css/loader.min.css">

    <style type="text/css">
        .brand-wrap:hover {
            transition: none !important;
            transform: none !important;
        }

        .upload {
            filter: grayscale(100%);
        }

        .media {
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-align: start;
          -ms-flex-align: start;
          align-items: flex-start;
        }

        .media-body {
          -webkit-box-flex: 1;
          -ms-flex: 1;
          flex: 1;
        }

        a, a:hover { text-decoration: none }

        #identitas table tr td { vertical-align: top; }
        #content,
        .root .mainnav__inner .nav-link,
        .text-disabled { 
            /*color: #626262; */
        }

        #jitsiConferenceFrame0 { border-radius: .4375rem; overflow: hidden; }
        #jitsiConferenceFrame0::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="jumping centered-layout">

    <!-- PAGE CONTAINER -->
    <div id="root" class="root mn--push hd--expanded">

        <!-- CONTENTS -->
        <section id="content" class="content">
            <?php $this->load->view($content) ?>

            <section class="content__boxed">
                <section class="content__wrap">
                    <!-- <div class="card">
                        <div class="card-body"> -->
                            <div class="row">
                                <div class="col-md-5">
                                    <h5 class="mb-3">Tentang Kami</h5>
                                    <!-- <hr> -->
                                    <table>
                                        <tr>
                                            <td><img src="https://mbkm.umc.ac.id/assets/img/favicon.png" class="float-left me-2"></td>
                                            <td>
                                                <h6 class="mb-0"><b>Universitas Muhammadiyah Cirebon</b></h6>
                                                Islami, Profesional & Mandiri
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                    <p>
                                        Kampus 1: Jl. Tuparev No. 70, Cirebon, <br>
                                        Kampus 2: Jl. Watubelah No. 40, Sumber, <br>
                                        Kampus 3: Jl. Watubelah, Sumber
                                        <br>
                                        Telepon: (0231) 209608, Email: mbkm@umc.ac.id
                                    </p>
                                </div>

                                <div class="col-md-2 col">
                                    <style type="text/css">
                                        ul.navigasi li {
                                            padding-bottom: 5px;
                                        }
                                    </style>
                                    <h5 class="mb-3">Navigasi</h5>
                                    <!-- <hr> -->
                                    <ul class="pl-0 mb-0 list-unstyled navigasi">
                                        <li><a href="#">Beranda</a></li>
                                        <li><a href="#">Tentang</a></li>
                                        <li><a href="#">Program</a></li>
                                        <li><a href="#">Berita</a></li>
                                        <li><a href="#">FAQ</a></li>
                                        <!-- <li><a href="#">Login</a></li>
                                        <li><a href="#">Daftar</a></li> -->
                                    </ul>
                                </div>
                                <div class="col">
                                    <style type="text/css">
                                        ul.navigasi li {
                                            padding-bottom: 5px;
                                        }
                                    </style>
                                    <h5 class="mb-3">Link Terkait</h5>
                                    <!-- <hr> -->
                                    <a href="#" target="_blank" class="d-inline-block mb-1"><img src="<?= base_url('assets/img/btn_mbkm.jpg') ?>" height="35"></a>
                                    <a href="#" target="_blank" class="d-inline-block mb-1"><img src="<?= base_url('assets/img/btn_pddikti.jpg') ?>" height="35"></a>
                                    <a href="#" target="_blank" class="d-inline-block mb-1"><img src="<?= base_url('assets/img/btn_simlitabmas.jpg') ?>" height="35"></a>
                                    <a href="#" target="_blank" class="d-inline-block mb-1"><img src="<?= base_url('assets/img/btn_sinta.jpg') ?>" height="35"></a>
                                    <a href="#" target="_blank" class="d-inline-block mb-1"><img src="<?= base_url('assets/img/btn_simbelmawa.jpg') ?>" height="35"></a>
                                </div>

                            </div>
                            <hr>
                           &copy; <?= $_ENV['COPYRIGHT'] ?> 2022.
                        <!-- </div>
                    </div> -->
                </section>
            </section>
        </section>
        <!-- END - CONTENTS -->

        <!-- HEADER -->
        <header class="header">
            <?php $this->load->view('header') ?>
        </header>
        <!-- END - HEADER -->

        <!-- NAVIGATION -->
        <nav id="mainnav-container" class="mainnav">
            <?php 
                $this->load->view('navigation') 
                // $this->Menu_model->show('mahasiswa');
            ?>
        </nav>
        <!-- END - NAVIGATION -->


    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- END - PAGE CONTAINER -->

    <!-- SCROLL TO TOP BUTTON -->
    <div class="scroll-container">
        <a href="#root" class="scroll-page rounded-circle ratio ratio-1x1" aria-label="Scroll button"></a>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- END - SCROLL TO TOP BUTTON -->

    <!-- JAVASCRIPTS -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

    <!-- Popper JS [ OPTIONAL ] -->
    <script src="<?= $_ENV['THM_LINK'] ?>vendors/popperjs/popper.min.js" defer></script>

    <!-- Bootstrap JS [ OPTIONAL ] -->
    <script src="<?= $_ENV['THM_LINK'] ?>vendors/bootstrap/bootstrap.min.js" defer></script>

    <!-- Nifty JS [ OPTIONAL ] -->
    <script src="<?= $_ENV['THM_LINK'] ?>js/nifty.js" defer></script>

    <!-- Nifty Settings [ DEMO ] -->
    <script src="<?= $_ENV['THM_LINK'] ?>js/demo-purpose-only.js" defer></script>

    <!-- Initialize the tooltips and popovers [ SAMPLE ] -->
    <script src="<?= $_ENV['THM_LINK'] ?>/pages/tooltips-popovers.js" defer></script>
    <script src="<?= base_url('assets/plugins/timeago.js/dist/timeago.min.js') ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?= base_url('assets/plugins/') ?>slick/slick.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.mitra').slick({
                lazyLoad: 'ondemand',
                arrows: false,
                slidesToShow: 6,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                responsive: [
                    {
                      breakpoint: 1024,
                      settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                      }
                    },
                    {
                      breakpoint: 600,
                      settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                      }
                    },
                    {
                      breakpoint: 480,
                      settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                      }
                    }
                ]
            });
        });

        timeago.render(document.querySelectorAll(".timeago"), "id_ID")
    </script>
    </body>
</html>