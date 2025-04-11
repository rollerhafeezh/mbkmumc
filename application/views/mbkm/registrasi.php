<!--Select2 [ OPTIONAL ]-->
<link href="<?= base_url() ?>assets/select2.min.css" rel="stylesheet">

<div class="content__header content__boxed overlapping">
    <div class="content__wrap">
        
    </div>
</div>

<div class="content__boxed">
    <div class="content__wrap">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">

                        <div class="text-center">
                            <img src="<?= base_url('assets/img/mbkm_umc_color.png') ?>" class="img-fluid mb-4 mt-2" width="150px">
                            <h4 class="mb-1">Registrasi Mahasiswa <span class="text-nowrap"> Inbound</span></h4>
                            <p>Merdeka Belajar Kampus Merdeka</p>
                            <!-- <hr> -->
                        </div>

                        <form class="mt-4" action="<?= base_url('mbkm/daftar_v2') ?>" method="POST" enctype="multipart/form-data">
                            <?php if(isset($_SESSION['msg'])) { ?>
                                <div class="alert alert-<?=$_SESSION['msg'][0]?>"><?=$_SESSION['msg'][1]?></div>
                            <?php } ?>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label text-dark fw-bold" for="nm_pd">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nm_pd" id="nm_pd" class="form-control" placeholder="Nama Lengkap" required="">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark fw-bold" for="nik">Nomor Induk Kependudukan (NIK) <span class="text-danger">*</span></label>
                                    <input type="number" name="nik" id="nik" class="form-control" placeholder="Nomor Induk Kependudukan (NIK)" required="">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label text-dark fw-bold" for="jk">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="form-control" required="" name="jk" id="jk">
                                        <option value="">Jenis Kelamin</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label text-dark fw-bold" for="tmp_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="tmp_lahir" id="tmp_lahir" class="form-control" placeholder="Tempat Lahir" required="">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-dark fw-bold" for="tgl_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" placeholder="Tanggal Lahir" required="">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-dark fw-bold" for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Email Aktif" required="">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark fw-bold" for="no_hp">No. Handphone (WA) <span class="text-danger">*</span></label>
                                    <input type="tel" id="no_hp" name="no_hp" class="form-control" placeholder="Nomor Handphone (Whatsapp)" required="">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-dark fw-bold" for="id_sp">Pergurutan Tinggi Asal <span class="text-danger">*</span></label>
                                    <select class="form-control" name="id_sp" required="" id="id_sp"></select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark fw-bold" for="nama_prodi">Nama Prodi Asal <span class="text-danger">*</span></label>
                                    <input type="text" id="nama_prodi" name="nama_prodi" class="form-control" placeholder="Cth: Ilmu Komputer" required="">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-dark fw-bold" for="nim">Nomor Induk Mahasiswa (NIM) <span class="text-danger">*</span></label>
                                    <input type="text" id="nim" name="nim" class="form-control" placeholder="NIM (Nomor Induk Mahasiswa)" required="">
                                </div>
                            </div>

                            <div class="form-group row mb-2 py-3" style="border-bottom: 1px dashed rgba(0,0,0,.07);">
                                <label class="col-md-6 form-control-label" for="foto_diri">
                                    <label class="form-label text-dark fw-bold" for="foto">Foto Mahasiswa <span class="text-danger">*</span></label> <br>
                                    Keterangan :
                                    <ul>
                                        <li>Tipe file ber-ekstensi .jpg, .jpeg atau .png;</li>
                                        <li>Ukuran maksimal 2 MB;</li>
                                        <li>Tampilan foto harus potrait;</li>
                                        <li>Gunakan jas almamater kampus asal;</li>
                                    </ul>
                                </label>
                                <div class="col-md-6 text-center">
                                    <img src="<?= base_url('assets/img/no foto 2.jpg') ?>" class="mb-2 rounded" id="foto_preview" height="168px" alt="">
                                    <input class="form-control w-75 mx-auto" type="file" accept=".jpg,.jpeg,.png" id="foto" name="foto" onchange="unggah_dokumen('foto')" required="">
                                </div>
                            </div>

                            <div class="d-grid mt-2">
                                <button class="btn btn-primary" type="submit"><i class="psi-paper-plane me-1"></i> Daftar Sekarang</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--JAVASCRIPT-->
<!--=================================================-->

<!--jQuery [ REQUIRED ]-->
<script src="<?=base_url()?>assets/js/jquery.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/select2.min.js"></script>

<script>
    $( document ).ready(function() {
        $("#id_sp").select2({
            placeholder: 'Pilih Perguruan Tinggi Asal',
            allowClear: true,
            ajax: {
                url: '<?= base_url('mbkm/satuan_pendidikan') ?>', // Ganti dengan URL API yang sesuai
                dataType: 'json',
                delay: 10,
                data: function(params) {
                    return {
                        q: params.term // Parameter pencarian (nama PT yang diketik)
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.text // Sesuaikan dengan atribut dari respons API
                            };
                        })
                    };
                }
            }
        });
    });

</script>

<script>
    function unggah_dokumen(jenis_dokumen) {
        const fileInput = document.getElementById(jenis_dokumen); // Elemen input file
        const previewImage = document.getElementById(jenis_dokumen + '_preview'); // Elemen gambar untuk pratinjau
        const maxFileSize = 2 * 1024 * 1024; // Ukuran maksimal dalam byte (2 MB)
        
        if (fileInput.files && fileInput.files[0]) {
            const file = fileInput.files[0]; // File yang diunggah
            
            // Validasi ukuran file
            if (file.size > maxFileSize) {
                alert("Ukuran file terlalu besar. Maksimal ukuran file adalah 2 MB.");
                fileInput.value = ""; // Mengosongkan input file
                return;
            }

            const reader = new FileReader(); // Membuat objek FileReader
            
            reader.onload = function (e) {
                // Ubah src elemen img menjadi URL dari file yang diunggah
                previewImage.setAttribute('src', e.target.result);
            };
            
            reader.readAsDataURL(file); // Membaca file sebagai DataURL
        }
    }
</script>

<script>
    function recaptcha_validation(e, evt) {
        var response = grecaptcha.getResponse()
        
        if (response.length == 0) {
            alert('Silahkan verifikasi captcha apabila anda bukan robot.')
            evt.preventDefault()
            return
        }
    }

    function hit_mhs(e) {
        if ( castvote(e, 'oninput') )
            return

        if (e.value == '') 
            document.querySelector('#hit_mhs').innerHTML = '';

        fetch('<?= base_url('mbkm/hit_mhs/') ?>' + e.value)
        .then(response => response.json())
        .then(json => {
            var options = ''
            json.data.forEach( function(e, i) {
                options += '<option value="' + e.mahasiswa + '" data-asal_mahasiswa="'+ e.detail +'">'+ e.detail +'</option>';
            });

            document.querySelector('#hit_mhs').innerHTML = options;
        })
    }

    function castvote(e, action = null) {
        var datalist = document.querySelector(`#${e.getAttribute('list')}`).children

        var flag = false
        for(let i = 0; i < datalist.length; i++){
            flag = datalist[i].value === e.value || flag
        }

        if (!flag) {
            if (action == null)
                e.value = ""
            
            return false
        } else {
            return true
        }
    }
</script>
