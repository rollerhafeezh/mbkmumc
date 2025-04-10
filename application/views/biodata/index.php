<div class="content__header content__boxed overlapping">
    <div class="content__wrap">
        <h1 class="page-title mb-0 mt-2"><?= $title ?></h1>
        <p class="lead">Pastikan semua data lengkap dan valid</p>
    </div>
</div>
<div class="content__boxed">
    <div class="content__wrap">

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="tab-base">
                    <!-- Nav tabs -->
                    <ul class="nav nav-callout position-relative" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#data_diri" type="button" role="tab" aria-controls="home" aria-selected="true">Data Diri</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#coTabsBaseProfile" type="button" role="tab" aria-controls="profile" aria-selected="false">Dokumen</button>
                        </li>

                        <a href="<?= base_url('biodata/edit') ?>" class="btn btn-info btn-sm position-absolute" style="right: 6px; top: 6px;"><i class="psi-pen-5 me-1 ms-0 ps-0"></i> Edit Data Diri</a>
                    </ul>

                    <!-- Tabs content -->
                    <div class="tab-content" style="border-top-right-radius: 0 !important;">

                        <div id="data_diri" class="tab-pane fade active show" role="tabpanel" aria-labelledby="home-tab">
                            <div class="alert alert-danger"><b>Penting!</b> Cek apakah data diri kamu sudah lengkap dan tercatat di <a href="https://pddikti.kemdikbud.go.id/search/<?= $_SESSION['id_user'] ?>" class="text-decoration-underline btn-link alert-link" target="_blank">PDDIKTI</a>.</div>

                            <?php foreach ($anggota as $key => $value) { ?>
                            <div class="form-group row m-0">
                                <label class="pb-2 col-md-3 col-5" for="<?= $key ?>"><?= strtoupper(str_replace('_', ' ', $key)) ?></label>
                                <div class="col pb-2"><?= strtoupper($value ?: '-') ?></div>
                            </div>
                            <?php } ?>

                        </div>
                        <div id="coTabsBaseProfile" class="tab-pane fade" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="form-group row mb-2 py-3" style="border-bottom: 1px dashed rgba(0,0,0,.07);">
                                <label class="col-md-6 form-control-label" for="foto_diri">
                                    <h5>Foto Almamater Mahasiswa</h5>
                                    Keterangan :
                                    <ul>
                                        <li>Tipe file ber-ekstensi .jpg, .jpeg atau .png;</li>
                                        <li>Ukuran maksimal 5 MB;</li>
                                        <li>Tampilan foto harus potrait;</li>
                                        <li>Gunakan jas almamater pada saat masih berstatus mahasiswa; dan</li>
                                        <li>Gunakan kemeja putih dan jas hitam pada saat akan mengajukan sidang skripsi / tugas akhir.</li>
                                    </ul>
                                </label>
                                <div class="col-md-6 text-center">
                                    <?php
                                        $dokumen = $this->Aktivitas_model->get_dokumen($_SESSION['username'], 'pasfoto');
                                        
                                        if($dokumen)
                                        {
                                            $pasfoto = $dokumen->file_mahasiswa;
                                        }else{
                                            $pasfoto = base_url('assets/img/jas-umc.png');
                                        }
                                    ?>
                                    <img src="<?= $pasfoto ?>" class="mb-2 rounded" id="pasfoto_preview" height="168px" alt="">
                                    <input class="form-control w-75 mx-auto" type="file" accept=".jpg,.jpeg,.png" id="pasfoto" name="pasfoto" onchange="unggah_dokumen('pasfoto')">
                                    <small class="text-info" id="pasfoto_loading" style="display: none">Sedang mengunggah ....</small>
                                </div>
                            </div>
                            <div class="form-group row mb-2 py-3" style="border-bottom: 1px dashed rgba(0,0,0,.07);">
                                <label class="col-md-6 form-control-label" for="foto_diri">
                                    <h5>Kartu Tanda Penduduk</h5>
                                    Keterangan :
                                    <ul>
                                        <li>Tipe file ber-ekstensi .jpg, .jpeg atau .png;</li>
                                        <li>Ukuran maksimal 5 MB;</li>
                                        <li>Tampilan foto harus landscape;</li>
                                        <li>Foto harus jelas.</li>
                                    </ul>
                                </label>
                                <div class="col-md-6 text-center">
                                    <?php
                                        $dokumen = $this->Aktivitas_model->get_dokumen($_SESSION['username'], 'ktp');
                                        
                                        if($dokumen)
                                        {
                                            $ktp = $dokumen->file_mahasiswa;
                                        }else{
                                            $ktp = base_url('assets/img/kartu-tanda-penduduk.png');
                                        }
                                    ?>
                                    <img src="<?= $ktp ?>" class="mb-2 rounded" id="ktp_preview" height="168px" alt="">
                                    <input class="form-control w-75 mx-auto" type="file" accept=".jpg,.jpeg,.png" id="ktp" name="ktp" onchange="unggah_dokumen('ktp')">
                                    <small class="text-info" id="ktp_loading" style="display: none">Sedang mengunggah ....</small>
                                </div>
                            </div>
                            <div class="form-group row mb-2 py-3" style="border-bottom: 1px dashed rgba(0,0,0,.07);">
                                <label class="col-md-6 form-control-label" for="foto_diri">
                                    <h5>Kartu Keluarga</h5>
                                    Keterangan :
                                    <ul>
                                        <li>Tipe file ber-ekstensi .jpg, .jpeg atau .png;</li>
                                        <li>Ukuran maksimal 5 MB;</li>
                                        <li>Tampilan foto harus presisi dan landscape;</li>
                                        <li>Dokumen harus jelas.</li>
                                    </ul>
                                </label>
                                <div class="col-md-6 text-center">
                                    <?php
                                        $dokumen = $this->Aktivitas_model->get_dokumen($_SESSION['username'], 'kk');
                                        
                                        if($dokumen)
                                        {
                                            $kk = $dokumen->file_mahasiswa;
                                        }else{
                                            $kk = base_url('assets/img/kartu-keluarga.png');
                                        }
                                    ?>
                                    <img src="<?= $kk ?>" class="mb-2 rounded" id="kk_preview" height="168px" alt="">
                                    <input class="form-control w-75 mx-auto" type="file" accept=".jpg,.jpeg,.png" id="kk" name="kk" onchange="unggah_dokumen('kk')">
                                    <small class="text-info" id="kk_loading" style="display: none">Sedang mengunggah ....</small>
                                </div>
                            </div>
                            <div class="form-group row mb-2 py-3" style="border-bottom: 1px dashed rgba(0,0,0,.07);">
                                <label class="col-md-6 form-control-label" for="foto_diri">
                                    <h5>Ijazah Terakhir</h5>
                                    Keterangan :
                                    <ul>
                                        <li>Tipe file ber-ekstensi .jpg, .jpeg atau .png;</li>
                                        <li>Ukuran maksimal 5 MB;</li>
                                        <li>Tampilan foto harus potrait untuk ijazah SLTA atau sederajat; dan</li>
                                        <li>Tampilan foto harus landscape untuk ijazah D3 atau sederajat;</li>
                                        <li>Dokumen harus jelas.</li>
                                    </ul>
                                </label>
                                <div class="col-md-6 text-center">
                                    <?php
                                        $dokumen = $this->Aktivitas_model->get_dokumen($_SESSION['username'], 'ijazah');
                                        
                                        if($dokumen)
                                        {
                                            $ijazah = $dokumen->file_mahasiswa;
                                        }else{
                                            $ijazah = base_url('assets/img/ijazah.png');
                                        }
                                    ?>
                                    <img src="<?= $ijazah ?>" class="mb-2 rounded" id="ijazah_preview" height="168px" alt="">
                                    <input class="form-control w-75 mx-auto" type="file" accept=".jpg,.jpeg,.png" id="ijazah" name="ijazah" onchange="unggah_dokumen('ijazah')">
                                    <small class="text-info" id="ijazah_loading" style="display: none">Sedang mengunggah ....</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function unggah_dokumen(jenis_dokumen)
    {
        document.getElementById(jenis_dokumen+'_loading').style.display = 'block';
        
        var data = new FormData()
        const dokumen = document.getElementById(jenis_dokumen).files[0] ;
        if(dokumen.size > 15728640) return false;
        
        data.append('dokumen', dokumen);
        data.append('jenis_dokumen', jenis_dokumen);
        
        fetch('<?= base_url('biodata/unggah_dokumen') ?>', {
            method: 'POST',
            body: data
        })
        .then((response) => response.text())
        .then((text) => {
            document.getElementById(jenis_dokumen+'_preview').setAttribute('src', text);
            document.getElementById(jenis_dokumen+'_loading').style.display = 'none';
        })
        .catch(error => {
            console.log(error)
        })  
    }
</script>