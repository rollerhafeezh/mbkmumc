<div class="content__header content__boxed overlapping">
    <div class="content__wrap">
        <!-- <h1 class="page-title mb-0 mt-2"><?= $title ?></h1> -->
        <!-- <p class="lead">&nbsp;</p> -->

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('kampus-merdeka') ?>">Kampus Merdeka</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="content__boxed">
    <div class="content__wrap">

        <div class="tab-base mt-3">

            <!-- Nav tabs -->
            <ul class="nav nav-callout" role="tablist">

                <?php $i = 1; foreach($program_mbkm->result() as $program): ?>
                <li class="nav-item w-25" role="presentation">
                    <button class="nav-link w-100 d-block <?= $i == 1 ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#<?= $program->slug ?>" type="button" role="tab" aria-controls="<?= $program->slug ?>" aria-selected="false"><?= $program->nama_jenis_aktivitas_mahasiswa ?></button>
                </li>
                <?php $i++; endforeach; ?>
            </ul>

            <!-- Tabs content -->
            <div class="tab-content" style="border-top-right-radius: 0 !important;">
                <?php $i = 1; foreach($program_mbkm->result() as $program): ?>
                <div id="<?= $program->slug ?>" class="tab-pane fade  <?= $i == 1 ? 'show active' : '' ?>" role="tabpanel" aria-labelledby="<?= $program->slug ?>-tab">
                    <h3 class="card-title text-center w-100 mb-3">Program <?= $program->nama_jenis_aktivitas_mahasiswa ?></h3>
                    <?= $program->deskripsi ?>
                </div>
                <?php  $i++; endforeach; ?>
            </div>

        </div>
    </div>
</div>