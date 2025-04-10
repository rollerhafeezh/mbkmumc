<?php $this->load->view('aktivitas/modal') ?>

<?php if (count($pembimbing) < 1): ?>
<div class="content__header content__boxed overlapping">
    <div class="content__wrap"></div>
</div>
<div class="content__boxed">
    <div class="content__wrap">
        <div class="card text-center mb-4 col-md-6 offset-md-3">
            <div class="card-body">
            	<img src="<?= base_url('assets/img/no user.jpg') ?>" class="img-fluid w-50 mb-2" alt="">
                <h5 class="card-title"><?= $title ?> tidak tersedia!</h5>
                <p class="mb-5">
                	<?= $title ?> hanya muncul apabila sudah di-ploting oleh program studi
                </p>
            </div>
        </div>

    </div>
</div>

<?php else: ?>

<div class="content__header content__boxed overlapping">
    <div class="content__wrap">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('dasbor') ?>">Dasbor</a></li>
                <li class="breadcrumb-item"><a href="#"><?= ucwords($this->uri->segment(1)) ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
            </ol>
        </nav>
        <!-- END : Breadcrumb -->

        <h1 class="page-title mb-0 mt-2"><?= $title ?></h1>
        <p class="lead">Kelola data bimbingan bersama dosen pembimbing.</p>
    </div>
</div>

<?php if(isset($_GET['meet'])): ?> 
<?php $this->load->view('bimbingan/meet') ?>
<?php endif; ?>

<div class="content__boxed">
    <div class="content__wrap">

    	<div class="row">
    		<?php $this->load->view('aktivitas/identitas'); ?>
    		
    		<div class="col-md">
		        <section class="card mb-3">
		            <div class="card-body">
	            		<div class="float-end">
	            			<?php if (isset($_GET['meet'])): ?>
	            				<a href="<?= base_url('bimbingan/dosen_pembimbing') ?>" class="btn btn-primary btn-xs position-relative">Stop Meet</a>
	            			<?php else: ?>
	            				<a href="<?= base_url('bimbingan/dosen_pembimbing?meet') ?>" class="btn btn-info btn-xs position-relative mx-1">Meet Online</a>
	            				<a href="javascript:void(0)" onclick="lihat_berkas(`Laporan Kemajuan <?= $title ?>`, `<?= base_url('bimbingan/cetak/'.$jenis_bimbingan) ?>`)" class="btn btn-secondary btn-xs position-relative">Unduh Bimbingan</a>
	            			<?php endif; ?>
	            		</div>

		        		<h5 class="card-title">Bimbingan</h5>
                        <div class="alert alert-info py-2"><b>Info:</b> Hanya catatan atas nama kamu yang bisa dihapus atau pada label <span class="badge bg-info">Saya</span></div>
		        		<div class="bimbingan mt-2 d-block">
		        			<center class="py-2">
			        			<div class="spinner-border text-dark d-block mb-1" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
	                            Sedang memuat data bimbingan ....
		        			</center>
		        		</div>
		            </div>
		        </section>
    		</div>
    	</div>

    </div>
</div>
<?php $this->load->view('bimbingan/script.php') ?>
<?php endif; ?>