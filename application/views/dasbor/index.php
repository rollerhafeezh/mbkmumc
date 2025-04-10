<div class="content__header content__boxed overlapping">
    <div class="content__wrap">
        <!-- <h1 class="page-title mb-0 mt-2"><?= $title ?></h1> -->
        <!-- <p class="lead">&nbsp;</p> -->


        <div class="alert alert-info">
            <i class="pli-yes me-1 fs-4" style="margin-top: -3px;"></i>
            <span>Selamat Datang di Website <?= $_ENV['APP_NAME'].' '.$_ENV['INST_NAME'] ?>.</span>
        </div>
    </div>
</div>

<div class="content__boxed">
    <div class="content__wrap mb-0 pb-0" >

        <!-- CARD -->
        <div class="card mb-4">
            <!-- KAMPUS MERDEKA -->
            <div class="card-body">
                <div class="row" id="kampus_merdeka">
                    <div class="col-md">
                    	<img src="https://mbkm.itp.ac.id/assets/images/img_home/kampus_merdeka.jpg" class="w-100">
                    </div>
                    <div class="col-md-9">
                		<h2>Kampus Merdeka</h2>
                		<h5>Program persiapan karier yang komprehensif untuk mempersiapkan generasi terbaik Indonesia</h5>
                        <p>
                        	Kampus Merdeka merupakan bagian dari kebijakan Merdeka Belajar oleh Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Republik Indonesia yang memberikan kesempaatan bagi mahasiswa/i untuk mengasah kemampuan sesuai bakat dan minat dengan terjun langsung ke dunia kerja sebagai persiapan karier masa depan.
                        </p>
                        <a href="<?= base_url('kampus-merdeka') ?>" class="btn btn-sm btn-info">Lihat Selengkapnya &raquo;</a>
                    </div>
                </div>
            </div>
            <!-- KAMPUS MERDEKA -->
            <hr>

            <!-- JADWAL KEGIATAN -->
            <div class="card-body pt-0">
                <h4 class="mb-3 d-block">Jadwal Kegiatan Kampus Merdeka</h4>
                <div style="background: #F2F2F2;" class=" rounded-top px-3 py-3 border-bottom">
                    <div class="row">
                        <div class="col-md-4 mb-1">
                            <select class="form-select" id="id_smt">
                                <option value="0">Tahun Akademik (All)</option>
                                <?php foreach($semester as $semester): ?>
                                <option value="<?= $semester->id_semester ?>"><?= $semester->nama_semester ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-1">
                            <select class="form-select" id="kode_prodi">
                                <?php foreach($prodi as $prodi): ?>
                                <option value="<?= $prodi->kode_prodi ?>"><?= $prodi->kode_prodi == '0' ? 'Program Studi (All)' : $prodi->nama_prodi.' ('.$prodi->nm_jenj_didik.')' ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-1">
                            <select class="form-select" id="id_program">
                                <option value="0">Program Kampus Merdeka (All)</option>
                                <?php foreach($program->result() as $program): ?>
                                <option value="<?= $program->id_program ?>">Program <?= $program->nama_jenis_aktivitas_mahasiswa ?> <?= $program->nama_program ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-block w-100 mt-3">
                    <style type="text/css">
                        table.dataTable>tbody>tr.child span.dtr-title {
                            display: block !important;
                        }
                        table.dataTable>tbody>tr.child ul.dtr-details {
                            width: 100%;
                        }
                    </style>
                    <table id="datatabel" class="table table-striped dataTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-nowrap">Skema Program</th>
                                <th class="text-nowrap">Prodi</th>
                                <th>Lokasi Kegiatan</th>
                                <th class="text-nowrap">Jadwal Kegiatan</th>
                                <th>Kuota</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <!-- JADWAL KEGIATAN -->

            <!-- BERITA -->
            <div class="card-body bg-light">
                <h3 class="d-block mb-4 mt-2 w-100 text-center">Berita Terkini</h3>
                
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
            <!-- BERITA -->

            <!-- FAQ -->
            <div class="card-body">
                <h4><i class="pli-question me-1 fs-2" style="margin-top: -3px;"></i> Pertanyaan Umum</h4>
                <div class="row" id="faq">
                    <div class="col-md-8">
                        <div class="accordion accordion-flush mb-3" id="generalFAQ">
                            <style>
                                .accordion-body ol {
                                    padding-left: 1rem!important;
                                }
                            </style>
                            <?php foreach($pertanyaan_umum->result() as $pertanyaan_umum): ?>
                            <div class="accordion-item bg-transparent border-0">
                                <h2 class="accordion-header" id="header_pertanyaan_<?= $pertanyaan_umum->id ?>">
                                    <button class="accordion-button bg-transparent shadow-none fs-5 fw-semibold text-head px-0 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#pertanyaan_<?= $pertanyaan_umum->id ?>" aria-expanded="true" aria-controls="pertanyaan_<?= $pertanyaan_umum->id ?>">
                                        <?= $pertanyaan_umum->pertanyaan ?>
                                    </button>
                                </h2>
                                <div id="pertanyaan_<?= $pertanyaan_umum->id ?>" class="accordion-collapse bg-transparent collapse show" aria-labelledby="header_pertanyaan_<?= $pertanyaan_umum->id ?>" data-bs-parent="#generalFAQ">
                                    <div class="accordion-body px-0 pt-2">
                                        <?= $pertanyaan_umum->jawaban ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="ms-2 text-center">
                        	<img src="<?= base_url('assets/img/pertanyaan.jpg') ?>" class="img-fluid w-50 mb-1">
                            <h5 class="mb-2">Tidak menemukan <br> jawaban yang kamu cari ?</h5>
                            <p class="d-block mb-3">Apabila ada jawaban yang belum kamu temukan terkait dengan kampus merdeka silahkan untuk menghubungi akademik.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FAQ -->
            <!-- MITRA -->
            <div class="card-body border-top">
                <h4 class="w-100 text-center mb-4 d-block">Mitra Kami</h4>
                <div class="mitra mb-3">
                    <?php foreach($mitra->result() as $mitra): ?>
                    <div  style="height: 75px; max-width: 100%; display: flex; justify-content: center; align-items: center;">
                        <img data-bs-toggle="tooltip" data-bs-container="body" data-container="body" title="<?= $mitra->nama_resmi ?>" data-lazy="<?= $mitra->logo ?>" class="d-block mx-auto rounded" alt="<?= $mitra->nama_merek ?>" style="max-height: 75px; max-width: 100%">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- MITRA -->
        </div>
        <!-- CARD -->
    </div>
</div>

<!-- Modal Informasi Kegiatan -->
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="detail_kegiatan" >
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="detail_kegiatanLabel">Informasi Kegiatan</h5>
            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        	<div class="detail_kegiatan"></div>
            <div class="loading">
                <div class="py-2 text-center">

                    <!-- Loader - Ball grid pulse -->
                    <div class="loader">
                        <div class="loader-inner line-scale">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                    <!-- END : Loader - Ball grid pulse -->

                </div>
                <p class="text-center">
                    Sedang memuat data, silahkan tunggu ...
                </p>
            </div>
        </div>
    </div>
  </div>
</div>
<!-- Modal Informasi Kegiatan -->

<script>

    function detail_kegiatan(id) {
    	var detail_kegiatan = document.querySelector('.detail_kegiatan')
    	var loading = document.querySelector('.loading')

        var modal_detail_kegiatan = new bootstrap.Modal(document.getElementById('detail_kegiatan'))
        modal_detail_kegiatan.show()
        
    	loading.style.display = 'block'
    	detail_kegiatan.style.display = 'none'

        var formData = new FormData()
        formData.append('id_program_mitra', id)

        fetch('<?= base_url('dasbor/detail_kegiatan') ?>', { method: 'POST', body: formData })
        .then(response => response.text())
        .then(text => {
        	loading.style.display = 'none'
            detail_kegiatan.innerHTML = text
    		detail_kegiatan.style.display = 'block'
        })
    }

    $(document).ready(function() {
		var table = $('#datatabel').DataTable( {
			ajax: {
				url 	: "<?= base_url('dasbor/json') ?>",
				type 	: 'GET',
				data : function(d){
					d.kode_prodi 	= $("#kode_prodi").val();
					d.id_smt 		= $("#id_smt").val();
					d.id_program 	= $("#id_program").val();
				}
			},
			// order: [[2, 'asc']],
			responsive: true,
			lengthMenu: [
				[ 10, 25, 50, -1 ],
				[ '10 rows', '25 rows', '50 rows', 'Show all' ]
			],
            columnDefs: [
                { className: "text-nowrap", targets: [ 4 ] },
                { className: "text-center", orderable: false, targets: [ 0,5,6 ] }
            ],
			serverSide: true,
			processing: true,
			search: {
	            return: true,
	        },
		} );
		
		$('#kode_prodi, #id_smt, #id_program').change(function(){ //button filter event click
	        table.ajax.reload(null,false);  //just reload table
		});
		
	} );
</script>