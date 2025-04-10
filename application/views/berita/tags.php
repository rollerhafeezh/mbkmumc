<div class="content__header content__boxed overlapping">
    <div class="content__wrap">
        <!-- <h1 class="page-title mb-0 mt-2"><?= $title ?></h1> -->
        <!-- <p class="lead">&nbsp;</p> -->

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('berita') ?>">Berita</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tags: <?= $title ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="content__boxed">
    <div class="content__wrap">
        <?php if ($berita->num_rows() < 1): ?>
        <div class="mt-4 text-center">
            <img src="<?= base_url('assets/img/news.png') ?>" class="w-50 mt-4">
            <h5 class="mb-0 mt-2">Oops,</h5>
            <p>
                Sepertinya berita tidak tersedia.
            </p>
        </div>
        <?php else: ?>

        <div class="row <?= $berita->num_rows() < 3 ? 'justify-content-center' : '' ?>">
            <?php foreach($berita->result() as $berita): ?>
            <div class="col-md-4 mb-3">
                <div class="card" style="height: 239px;">
                    <div class="card-body">
                        <a href="<?= base_url('berita/detail/'.$berita->slug) ?>" class="d-block h5 mb-0 text-decoration-none text-truncate"><?= $berita->judul ?></a>
                        <small class="text-muted">
                            <span class="w-50 d-inline-block text-nowrap overflow-hidden" style="text-overflow: ellipsis;"><?= ucwords(strtolower($berita->penulis)) ?></span> 
                            <span class="d-inline-block" style="vertical-align: top">, <?= tanggal_indo($berita->created_at) ?></span>
                        </small>

                        <div class="mt-2" style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 6; overflow: hidden">
                            <?= substr(strip_tags($berita->isi), 0, 350) ?>
                        </div>
                        <br>
                        
                        <?php $tags = explode(',', $berita->tags); ?>
                        <?php if($berita->tags) { for ($i = 0; $i < count($tags); $i++) {
                            echo '<a href="'.base_url('berita/tags/'.$tags[$i]).'" class="text-white badge bg-info me-1">#'.$tags[$i].'</a>';
                        } } ?>
                        
                        <div class="d-none mt-2 pt-3 border-top d-flex align-items-center">
                            <div class="d-flex g-2">
                                <small class="text-muted"><?= $berita->penulis ?></small>
                            </div>
                            <small class="text-muted ms-auto"><?= tanggal_indo($berita->created_at) ?></small>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>