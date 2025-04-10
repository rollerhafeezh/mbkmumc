<?php $this->load->view('aktivitas/modal') ?>

<?php if (!$aktivitas): ?>
<div class="content__header content__boxed overlapping">
    <div class="content__wrap"></div>
</div>
<div class="content__boxed">
    <div class="content__wrap">
        <div class="card text-center mb-4 col-md-6 offset-md-3">
            <div class="card-body">
            	<img src="<?= base_url('assets/img/no data.jpg') ?>" class="img-fluid w-50 mb-2" alt="">
                <h5 class="card-title">Oops, <?= $_ENV['MENU_NAME'] ?> tidak tersedia.</h5>
                <p class="mb-5">
                	<?= $_ENV['MENU_NAME'] ?> hanya tersedia apabila kamu sudah mengontrak mata kuliah <?= $_ENV['MENU_NAME'] ?> dan Kartu Rencana Studi kamu sudah divalidasi oleh keuangan.
                </p>
            </div>
        </div>

    </div>
</div>
<?php else: ?>
<div class="content__header content__boxed overlapping">
    <div class="content__wrap">
        <h1 class="page-title mb-0 mt-2"><?= $title ?></h1>
        <p class="lead">Pastikan identitas dan berkas kamu lengkap dan sesuai dengan ketentuan.</p>
    </div>
</div>

<div class="content__boxed">
    <div class="content__wrap">
    	<!-- <div class="alert alert-info">
            <span><b>Informasi:</b> Untuk bisa mengambil ijazah & legalisir-nya pastikan bahwa semua pemberkasan dalam status lengkap.</b></span>
        </div> -->
        <?php if(isset($_SESSION['msg'])) { ?>
			<div class="alert alert-<?=$_SESSION['msg_clr']?> alert-dismissible fade show" role="alert">
			  <?=$_SESSION['msg']?>
			  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php  } ?>

    	<div class="row">
    		<?php $this->load->view('aktivitas/identitas'); ?>
    		
    		<div class="col-md">
			<?php
      			$kegiatan_anggota = $this->Aktivitas_model->kegiatan_anggota(['id_jenis_aktivitas_mahasiswa' => $aktivitas->id_jenis_aktivitas_mahasiswa], $anggota->id_anggota)->result();
      			foreach ($kegiatan_anggota as $kegiatan_anggota) {
      		?>
				<section id="<?= $kegiatan_anggota->slug ?>" class="card mb-3">
		            <div class="card-body">
		            	<div>
		            		<?php if ($kegiatan_anggota->status == 1): ?>
		            		<span class="badge bg-secondary ms-auto float-end">Berkas Lengkap</span>
		            		<?php else: ?>
		            		<span class="badge bg-danger ms-auto float-end">Berkas Belum Lengkap</span>
		            		<?php endif; ?>
			        		<h5 class="card-title"><?= $kegiatan_anggota->deskripsi ?></h5>
			        		<div class="alert alert-info fs-6 p-2 px-3">
			        			*) Berkas yang di-unggah disesuaikan dengan ketentuan fakultas-nya masing-masing.
			        		</div>
			        		<div class="row">
			        			<div class="col-md-5 mb-3">
			        				<!-- <h6>Unduh Berkas</h6>
			        				<hr> -->
			        				<ul class="p-0 m-0 list-unstyled">
				      				<?php
					      				$berkas_kegiatan = $this->Aktivitas_model->berkas_kegiatan([ 'id_kegiatan' => $kegiatan_anggota->id_kegiatan, 'tipe_berkas' => 'download' ], 'urutan ASC')->result();
					      				foreach ($berkas_kegiatan as $berkas_kegiatan) {
				  					?>
										<li>
					                        <a href="javascript:void(0)" onclick="lihat_berkas(`<?= $berkas_kegiatan->nama_kategori ?>`, `<?= base_url('aktivitas/cetak/'.$berkas_kegiatan->slug.'/'.$kegiatan_anggota->slug) ?>`)">
					                            <img src="<?= base_url('assets/img/pdf.png') ?>"> Unduh <?= $berkas_kegiatan->nama_kategori ?>
					                        </a>
					                  	</li>
				  					<?php } ?>
				  					</ul>
			        			</div>

			        			<div class="col-md-7">
			        				<!-- <h6>Unggah Berkas</h6>
			        				<hr> -->
	              					<ul class="p-0 m-0 list-unstyled">
				      				<?php
					      				$berkas_kegiatan = $this->Aktivitas_model->berkas_kegiatan([ 'id_kegiatan' => $kegiatan_anggota->id_kegiatan, 'tipe_berkas' => 'upload' ], 'urutan ASC', $anggota->id_anggota)->result();
					      				foreach ($berkas_kegiatan as $berkas_kegiatan) {
				  					?>
										<li>
					      					<span data-bs-toggle="tooltip" title="<?= $berkas_kegiatan->created_at != '' ? tanggal_indo(explode(' ', $berkas_kegiatan->created_at)[0]).' '.explode(' ', $berkas_kegiatan->created_at)[1] : 'Klik untuk mengunggah berkas.' ?>" >
						                        
						                        <?php if ($berkas_kegiatan->berkas == ''): ?>
							                        <a style="filter: grayscale(100%);" href="<?= base_url('aktivitas/unggah/'.$berkas_kegiatan->slug.'/'.$kegiatan_anggota->slug) ?>">
							                            <img src="<?= base_url('assets/img/pdf.png') ?>"> Unggah <?= $berkas_kegiatan->nama_kategori ?>
							                        </a> 
							                    <?php else: ?>
							                    	<a href="javascript:void(0)" onclick="lihat_berkas(`<?= $berkas_kegiatan->nama_kategori ?>`, `<?= $berkas_kegiatan->berkas ?>?time=<?= time() ?>`)">
							                            <img src="<?= base_url('assets/img/pdf.png') ?>"> <?= $berkas_kegiatan->nama_kategori ?>
							                        </a> 
							                    <?php endif; ?>

					      					</span>

					                        <?php if ($berkas_kegiatan->id_berkas_anggota != ''): ?>
					                        - <a onclick="return confirm('Hapus Berkas <?= $berkas_kegiatan->nama_kategori ?> ?')" href="<?= base_url('aktivitas/hapus_berkas/'.$berkas_kegiatan->id_berkas_anggota.'?file='.$berkas_kegiatan->berkas) ?>" class="badge bg-danger text-white">hapus</a>
					                        <?php endif; ?>
					                  	</li>
				  					<?php } ?>
				  					</ul>
			        			</div>
			        		</div>
		            	</div>
		            </div>
		        </section>
      		<?php
      			}
  			?>
    		</div>
    	</div>

    </div>
</div>
<?php endif; ?>