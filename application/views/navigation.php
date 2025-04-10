<div class="mainnav__inner">

    <!-- Navigation menu -->
    <div class="mainnav__top-content scrollable-content pb-5">

        <!-- Profile Widget -->
        <div class="mainnav__profile mt-3 d-flex3">

            <div class="mt-2 d-mn-max"></div>

            <!-- Profile picture  -->
            <div class="mininav-toggle text-center py-2">
                <img class="mainnav__avatar img-md rounded-circle border" src="<?= base_url('assets/img/umc.png') ?>" alt="Profile Picture">
            </div>

            <div class="mininav-content collapse d-mn-max">
                <div class="d-grid">

                    <!-- User name and position -->
                    <button class="d-block btn shadow-none p-2">
                        <span class="d-flex justify-content-center align-items-center">
                            <h5 class="mb-0" style="font-family: inherit">UMC</h5>
                        </span>
                        <small class="text-muted fs-6">Islami, Profesional & Mandiri</small>
                    </button>
                </div>
            </div>

        </div>
        <!-- End - Profile widget -->

        <div class="mainnav__categoriy py-3">
            <h6 class="mainnav__caption mt-0 px-3 fw-bold">Kampus Merdeka</h6>
            <ul class="mainnav__menu nav flex-column">
                <?php 
                    $this->Menu_model->show('mahasiswa');
                ?>
            </ul>

        </div>

    </div>
    <!-- End - Navigation menu -->
</div>