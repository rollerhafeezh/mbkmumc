<?php
	$anggota    = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $_SESSION['id_user'], 'as.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
    $aktivitas  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $anggota->id_aktivitas, 'a.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
?>
<style type="text/css">
	.timeline .tl-time:not(:empty) {
	    min-width: 5.5rem!important;
	}
</style>
<!-- Modal Lihat Berkas -->
<div class="modal" id="lihatBerkas" tabindex="-1" aria-labelledby="lihatBerkasLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header bg-primary p-0 py-1">
        <span class="modal-title ms-2 my-1  text-white" style="width: 85%; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
          <img src="<?= base_url('assets/img/pdf.png') ?>" style="margin-top: -4px;" class="me-1"> 
          <span id="lihatBerkasLabel">Lihat Berkas</span>
        </span>
        <button type="button" class="border border-dark bg-white p-1 btn-close me-2 text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0 overflow-hidden" >
      	<iframe  id="lihatBerkasFile" src="#" type="application/pdf" class="w-100 h-100"></iframe>
      </div>
    </div>
  </div>
</div>
<!-- Modal Lihat Berkas -->

<!-- Modal Lokasi -->
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modal_lokasi_penelitian" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_lokasi_penelitianLabel">Lokasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<form method="POST" action="<?= base_url('aktivitas/simpan') ?>">
      		<input type="hidden" name="id_aktivitas" value="<?= $aktivitas->id_aktivitas ?>">
	        <div class="form-floating mb-3">
	            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Lokasi" required="">
	            <label for="lokasi">Tulis Lokasi Disini</label>
	        </div>
	        <div class="row">
	        	<div class="col">
	        		<button type="submit" class="btn btn-primary d-block w-100">Simpan</button>
	        	</div>
	        </div>
      	</form>
      	<!-- LOG -->
      	<hr>
      	<div class="accordion" id="colorsAccordion">
            <div class="accordion-item border-0">
                <div class="accordion-header" id="colorsAccHeadingOne">
                    <button class="accordion-button bg-light shadow-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#log_lokasi" aria-expanded="false" aria-controls="log_lokasi">
                        Riwayat Perubahan
                    </button>
                </div>
                <div id="log_lokasi" class="accordion-collapse bg-light collapse" aria-labelledby="colorsAccHeadingOne" data-bs-parent="#colorsAccordion" style="">
                    <div class="accordion-body ps-0">
				      	<div class="pb-5">
					      	<div class="timeline">
						      	<?php
						      		$lokasi = $this->Aktivitas_model->aktivitas_log([ 'whois' => $_SESSION['id_user'], 'whatdo' => 'simpan_lokasi' ], 'created_at DESC')->result();
						      		echo count($lokasi) < 1 ? '<center class="pt-4 d-block w-100">Belum ada riwayat perubahan.</center>' : '';
						      		$i = 0;
						      		foreach ($lokasi as $lokasi) { $data = json_decode($lokasi->data); ++$i;
						      	?>
					      		<div class="tl-entry <?= ($i == 1 ? 'active' : '') ?>">
					                <div class="tl-time">
					                    <div class="tl-date"><?= date("d/m/Y", strtotime(explode(' ', $lokasi->created_at)[0])) ?></div>
					                    <div class="tl-time"><?= substr(explode(' ', $lokasi->created_at)[1], 0, 5) ?> WIB</div>
					                </div>
					                <div class="tl-point"></div>
					                <div class="tl-content card <?= ($i == 1 ? 'bg-secondary text-white' : '') ?>">
					                    <div class="card-body">
					                        <?= $data->lokasi ?>
					                    </div>
					                </div>
					            </div>
						      	<?php
						      		}
						      	?>
					        </div>
					    </div>
                    </div>
                </div>
            </div>
        </div>
      	<!-- LOG -->
      </div>
    </div>
  </div>
</div>
<!-- Modal Lokasi -->

<!-- Modal Judul -->
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modal_judul" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_judulLabel">Judul</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<form method="POST" action="<?= base_url('aktivitas/simpan') ?>">
      		<input type="hidden" name="id_aktivitas" value="<?= $aktivitas->id_aktivitas ?>">
	        <div class="form-floating mb-3">
	        	<textarea class="form-control" id="judul" name="judul" style="height: 130px" required=""></textarea>
	            <label for="judul">Tulis Judul Disini</label>
	        </div>
	        <div class="row">
	        	<div class="col">
	        		<button type="submit" class="btn btn-primary d-block w-100">Simpan</button>
	        	</div>
	        </div>
      	</form>
      	<!-- LOG -->
      	<hr>
      	<div class="accordion" id="colorsAccordion">
            <div class="accordion-item border-0">
                <div class="accordion-header" id="colorsAccHeadingOne">
                    <button class="accordion-button bg-light shadow-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#log_judul" aria-expanded="false" aria-controls="log_judul">
                        Riwayat Perubahan
                    </button>
                </div>
                <div id="log_judul" class="accordion-collapse bg-light collapse" aria-labelledby="colorsAccHeadingOne" data-bs-parent="#colorsAccordion" style="">
                    <div class="accordion-body ps-0">
				      	<div class="pb-5">
					      	<div class="timeline">
						      	<?php
						      		$judul = $this->Aktivitas_model->aktivitas_log([ 'whois' => $_SESSION['id_user'], 'whatdo' => 'simpan_judul' ], 'created_at DESC')->result();
						      		echo count($judul) < 1 ? '<center class="pt-4 d-block w-100">Belum ada riwayat perubahan.</center>' : '';
						      		$i = 0;
						      		foreach ($judul as $judul) { $data = json_decode($judul->data); ++$i;
						      	?>
					      		<div class="tl-entry <?= ($i == 1 ? 'active' : '') ?>">
					                <div class="tl-time">
					                    <div class="tl-date"><?= date("d/m/Y", strtotime(explode(' ', $judul->created_at)[0])) ?></div>
					                    <div class="tl-time"><?= substr(explode(' ', $judul->created_at)[1], 0, 5) ?> WIB</div>
					                </div>
					                <div class="tl-point"></div>
					                <div class="tl-content card <?= ($i == 1 ? 'bg-secondary text-white' : '') ?>">
					                    <div class="card-body">
					                        <?= $data->judul ?>
					                    </div>
					                </div>
					            </div>
						      	<?php
						      		}
						      	?>
					        </div>
					    </div>
                    </div>
                </div>
            </div>
        </div>
      	<!-- <div class="bg-light rounded pe-3 pt-4 pb-5">
	    </div> -->
      	<!-- LOG -->
      </div>
    </div>
  </div>
</div>
<!-- Modal Judul -->

<!-- Modal Judul (English) -->
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modal_judul_en" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_judul_enLabel">Judul (English)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<form method="POST" action="<?= base_url('aktivitas/simpan') ?>">
      		<input type="hidden" name="id_aktivitas" value="<?= $aktivitas->id_aktivitas ?>">
	        <div class="form-floating mb-3">
	        	<textarea class="form-control" id="judul_en" name="judul_en" style="height: 130px" required=""></textarea>
	            <label for="judul_en">Tulis Judul Disini</label>
	        </div>
	        <div class="row">
	        	<div class="col">
	        		<button type="submit" class="btn btn-primary d-block w-100">Simpan</button>
	        	</div>
	        </div>
      	</form>
      	<!-- LOG -->
      	<hr>
      	<div class="accordion" id="colorsAccordion">
            <div class="accordion-item border-0">
                <div class="accordion-header" id="colorsAccHeadingOne">
                    <button class="accordion-button bg-light shadow-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#log_judul_en" aria-expanded="false" aria-controls="log_judul_en">
                        Riwayat Perubahan
                    </button>
                </div>
                <div id="log_judul_en" class="accordion-collapse bg-light collapse" aria-labelledby="colorsAccHeadingOne" data-bs-parent="#colorsAccordion" style="">
                    <div class="accordion-body ps-0">
				      	<div class="pb-5">
				      		<div class="timeline">
					      	<?php
					      		$judul_en = $this->Aktivitas_model->aktivitas_log([ 'whois' => $_SESSION['id_user'], 'whatdo' => 'simpan_judul_en' ], 'created_at DESC')->result();
					      		echo count($judul_en) < 1 ? '<center class="pt-4 d-block w-100">Belum ada riwayat perubahan.</center>' : '';
					      		$i = 0;
					      		foreach ($judul_en as $judul_en) { $data = json_decode($judul_en->data); ++$i;
					      	?>
				      		<div class="tl-entry <?= ($i == 1 ? 'active' : '') ?>">
				                <div class="tl-time">
				                    <div class="tl-date"><?= date("d/m/Y", strtotime(explode(' ', $judul_en->created_at)[0])) ?></div>
				                    <div class="tl-time"><?= substr(explode(' ', $judul_en->created_at)[1], 0, 5) ?> WIB</div>
				                </div>
				                <div class="tl-point"></div>
				                <div class="tl-content card <?= ($i == 1 ? 'bg-secondary text-white' : '') ?>">
				                    <div class="card-body">
				                        <?= $data->judul_en ?>
				                    </div>
				                </div>
				            </div>
					      	<?php
					      		}
					      	?>
				        </div>
					    </div>
                    </div>
                </div>
            </div>
        </div>
      	<!-- <div class="bg-light rounded pe-3 pt-4 pb-5">
	    </div> -->
      	<!-- LOG -->
      </div>
    </div>
  </div>
</div>
<!-- Modal Judul (English) -->

<script>
	function getEle(e) { return document.querySelector(e) }
	
	function disabled_enter(el) {
		el.addEventListener('keydown', function (e) {
		    const keyCode = e.which || e.keyCode;
		    if (keyCode === 13 && !e.shiftKey) {
		        e.preventDefault();
		    }
		})
	}

	disabled_enter(getEle('#judul'));
	disabled_enter(getEle('#judul_en'));

	function simpan(data, action) {
		var formData = new FormData(data)
		fetch('<?= base_url() ?>' + action, { method: 'POST', body: formData })
		.then(response => response.text())
		.then(text => {
			cosole.log(text)
		})

		return
	}

	getEle('#modal_lokasi_penelitian').addEventListener('shown.bs.modal', function () {
	  getEle('#lokasi_penelitian').focus()
	})

	function lihat_berkas(filename, pdf) {
	    if (pdf != '') {
			document.getElementById('lihatBerkasLabel').innerHTML = filename + ' (Kertas F4)'
			document.getElementById('lihatBerkasFile').src = '<?= base_url('/assets/plugins/pdfjs/web/viewer.html?file=') ?>' + pdf
			var myModal = new bootstrap.Modal(document.getElementById('lihatBerkas'))
			myModal.show()
	    }
  	}
</script>