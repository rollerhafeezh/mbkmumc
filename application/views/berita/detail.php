<div class="content__header content__boxed overlapping">
    <div class="content__wrap">
        <!-- <h1 class="page-title mb-0 mt-2"><?= $title ?></h1> -->
        <!-- <p class="lead">&nbsp;</p> -->

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('berita') ?>">Berita</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="content__boxed">
    <div class="content__wrap">

        <div class="card mt-3">
            <div class="mb-3 <?= $berita->cover ? '' : 'd-none' ?>">
                <div>
                    <img class="card-img-top object-cover h-100" src="<?= $berita->cover ?>" alt="<?= $title ?>" loading="lazy">
                    <!-- <small class="card-body py-0 text-muted">Foto: Dokumentasi Universitas Muhammadiyah Cirebon.</small> -->
                </div>
            </div>

            <div class="card-body flex-grow-0">

                <!-- Article header -->
                <div class="d-flex align-items-start justify-content-between mb-1">
                    <h2 class="m-0 pe-4"><?= $title ?></h2>
                    <!-- Social media buttons -->
                    <div class="ms-auto text-center text-nowrap text-muted d-none">
                        <a href="#" class="btn btn-sm btn-icon btn-hover btn-info text-inherit">
                            <i class="psi-facebook fs-5"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-icon btn-hover btn-info text-inherit">
                            <i class="psi-twitter fs-5"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-icon btn-hover btn-danger text-inherit">
                            <i class="psi-instagram fs-5"></i>
                        </a>
                    </div>
                    <!-- END : Social media buttons -->

                </div>
                <small class="d-block">
                    <i class="psi-male-2 me-1"></i> <?= ucwords(strtolower($berita->penulis)) ?>
                    <i class="psi-calendar-4 ms-2 me-1"></i> <?= tanggal_indo($berita->created_at) ?>
                    <i class="psi-tag ms-2 me-1"></i> Kampus Merdeka
                </small>
                <!-- END : Article header -->

                <!-- Article content -->
                <article class="lh-lg mt-3">
                    <?= $berita->isi ?>
                </article>
                <!-- END : Article content -->

                <!-- Article footer -->
                <div class="mt-0 pt-0 d-flex align-items-center">
                    <div class="position-relative">
                        <?php $tags = explode(',', $berita->tags); ?>
                        <?php if($berita->tags) { for ($i = 0; $i < count($tags); $i++) {
                            echo '<a href="'.base_url('berita/tags/'.$tags[$i]).'" class="text-white badge bg-info me-1">#'.$tags[$i].'</a>';
                        } } ?>
                    </div>
                </div>
                <!-- END : Article footer -->

            </div>
        </div>

    </div>
</div>