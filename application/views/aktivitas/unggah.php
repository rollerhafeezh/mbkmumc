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
                	<?= $_ENV['MENU_NAME'] ?> hanya tersedia apabila kamu sudah mengontrak mata kuliah <?= $_ENV['MENU_NAME'] ?> / Tugas Akhir dan Kartu Rencana Studi kamu sudah divalidasi oleh keuangan.
                </p>
            </div>
        </div>

    </div>
</div>
<?php else: ?>
<div class="content__header content__boxed overlapping">
    <div class="content__wrap">
    	<nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Dasbor</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('aktivitas') ?>"><?= $_ENV['MENU_NAME'] ?></a></li>
                <li class="breadcrumb-item active" aria-current="page">Unggah Berkas</li>
            </ol>
        </nav>

        <h1 class="page-title mb-0 mt-2"><?= $title ?></h1>
        <p class="lead">Periksa kembali berkas yang kamu unggah melalui pratinjau.</p>
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
    		<div class="col-md-4">
    			<section class="card mb-3">
    				<div class="card-body">
		        		<h5 class="card-title">Pilih Berkas</h5>
		        		<form action="<?= base_url('aktivitas/unggah_berkas/'.$berkas_kegiatan->slug.'/'.$kegiatan->slug) ?>" method="POST" enctype="multipart/form-data">
			        		<input id="berkas" name="berkas" accept="application/pdf,.pdf" class="form-control mb-2" type="file" required="" onchange="lihat_berkas(this)">
			        		<button type="submit" class="btn btn-danger w-100">Simpan Berkas</button>
		        		</form>
		        		<br>
    					<span class="d-block">
              	Keterangan : <br>
              	<ol type="1">
              		<li>Berkas yang di-unggah harus file pdf (.pdf), apabila berkas yang di-unggah dalam bentuk Power Point silahkan konversi terlebih dahulu menggunakan tautan dibawah:
              			<ul class="pl-0 m-0 list-unstyled">
              				<li><a href="https://smallpdf.com/id/ppt-ke-pdf" target="_blank"><i class="ft-link"></i> Link Konverter PPT ke PDF - Small PDF</a></li>
              			</ul>
              		</li>
              		<li>Berkas yang di-unggah adalah berkas dengan tanda tangan dan cap asli, bukan fotokopian-an</li>
              		<li>Ukuran maksimal 10 MB untuk berkas yang di-unggah, apabila berkas yang di-unggah melebihi batas maksimal silahkan untuk melakukan Kompresi File Online terlebih dahulu dengan menggunakan link dibawah:
              			<ul class="pl-0 m-0 list-unstyled">
              				<li><a href="https://smallpdf.com/id/mengompres-pdf" target="_blank"><i class="ft-link"></i> Link Kompres PDF - Small PDF</a></li>
              			</ul>
              		</li>
              	</ol>
          	</span>
    				</div>	
    			</section>	
    		</div>

    		<div class="col-md">
    			<section class="card mb-3">
    				<div class="card-body">
		        		<h5 class="card-title">Pratinjau Berkas</h5>
                <!-- <div class="alert alert-info text-center mb-0 alert_pilih_berkas">
                  <img src="<?= base_url('assets/img/pdf.png') ?>" class="me-1" style="margin-top: -4px;">
                  Silahkan pilih berkas untuk diunggah.
                </div> -->
		        		<div class="rounded pratinjau_berkas">
                  <iframe src="<?= base_url('assets/plugins/pdfjs/web/viewer.html?file=#') ?>" id="pratinjau_berkas" class="rounded w-100" style="height: calc(100vh - 120px)"></iframe>    
                </div>
    				</div>	
    			</section>	
    		</div>
    	</div>

    </div>
</div>
<?php endif; ?>

<script>
	function lihat_berkas(e) {
	    if (e.value != '') {
        // const file = e.files[0]
        // const reader = new FileReader();
        // var filename = file.name;

        // reader.addEventListener("load", function () {
          // document.querySelector('.alert_pilih_berkas').style.display = 'none'
          // document.querySelector('#pratinjau_berkas').style.display = 'block'

          var src = URL.createObjectURL(e.files[0])
          document.getElementById('pratinjau_berkas').src = '<?= base_url('/assets/plugins/pdfjs/web/viewer.html?file=') ?>' + src
        // }, false);

        // if (file) {
        //   reader.readAsDataURL(file);
        // }
	    }
  	}
</script>