<div class="content__header content__boxed overlapping">
    <div class="content__wrap">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('dasbor') ?>">Dasbor</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('biodata') ?>">Biodata</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Data Diri</li>
            </ol>
        </nav>
        <!-- END : Breadcrumb -->

        <h1 class="page-title mb-0 mt-2"><?= $title ?></h1>
        <p class="lead">Isi formulir sesuai data diri kamu</p>
    </div>
</div>
<div class="content__boxed">
    <div class="content__wrap">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <h5 class="card-header" style="min-height: 0px">Data Mahasiswa</h5>
                    <div class="card-body">
                        <!-- Block styled form -->
                        <form class="row g-3" method="POST" action="<?= base_url('biodata/update') ?>">
                            <div class="col-md-6">
                                <label for="id_mahasiswa_pt" class="form-label">Nomor Pokok Mahasiswa</label>
                                <input id="id_mahasiswa_pt" type="text" class="form-control" disabled value="<?= $anggota->id_mahasiswa_pt ?>">
                            </div>

                            <div class="col-md-6">
                                <label for="nm_pd" class="form-label">Nama Lengkap</label>
                                <input id="nm_pd" type="text" class="form-control" disabled value="<?= $anggota->nm_pd ?>">
                            </div>

                            <div class="col-md-6">
                                <label for="nm_ibu_kandung" class="form-label">Nama Ibu Kandung</label>
                                <input id="nm_ibu_kandung" type="text" class="form-control" disabled value="<?= $anggota->nm_ibu_kandung ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="jk" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select id="jk" name="jk" class="form-select" required="" >
                                    <option hidden="">Pilih Jenis Kelamin</option>
                                    <option value="L" <?= $anggota->jk == 'L' ? 'selected' : '' ?> >Laki-laki</option>
                                    <option value="P" <?= $anggota->jk == 'P' ? 'selected' : '' ?> >Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-6">
                                <label for="tmp_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <input id="tmp_lahir" name="tmp_lahir" type="text" class="form-control" required="" value="<?= $anggota->tmp_lahir ?>">
                            </div>
                            <div class="col-md-3 col-6">
                                <label for="tgl_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input id="tgl_lahir" name="tgl_lahir" type="date" class="form-control" required="" value="<?= $anggota->tgl_lahir ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="id_agama" class="form-label">Agama <span class="text-danger">*</span></label>
                                <select id="id_agama" name="id_agama" class="form-select" required="">
                                    <option value="" hidden="">Pilih Agama</option>
                                    <?php foreach($agama as $agama): ?>
                                    <option value="<?= $agama->id_agama ?>" <?= $agama->id_agama == $anggota->id_agama ? 'selected' : '' ?> ><?= $agama->agama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                <input id="nik" name="nik" type="text" pattern="[0-9]+" minlength="16" maxlength="16" class="form-control" required="" value="<?= $anggota->nik ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="nisn" class="form-label">NISN <span class="text-danger">*</span></label>
                                <input id="nisn" name="nisn" type="text" pattern="[0-9]+" minlength="8" maxlength="8" class="form-control" required="" value="<?= $anggota->nisn ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input id="email" name="email" type="email" class="form-control" required=""  value="<?= $anggota->email ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="no_hp" class="form-label">No. Handphone <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        +62
                                    </span>
                                    <input type="tel" class="form-control" name="no_hp" id="no_hp" required=""  value="<?= $anggota->no_hp ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="jalan" class="form-label">Blok / Jalan <span class="text-danger">*</span></label>
                                <input id="jalan" name="jalan" type="text" class="form-control" required=""  value="<?= $anggota->jalan ?>">
                            </div>
                            <div class="col-md-3 col-6">
                                <label for="rt" class="form-label">RT <span class="text-danger">*</span></label>
                                <input id="rt" name="rt" type="number" class="form-control" required="" value="<?= $anggota->rt ?>">
                            </div>
                            <div class="col-md-3 col-6">
                                <label for="rw" class="form-label">RW <span class="text-danger">*</span></label>
                                <input id="rw" name="rw" type="number" class="form-control" required="" value="<?= $anggota->rw ?>">
                            </div>

                            <div class="col-md-6">
                                <label for="kelurahan" class="form-label">Kelurahan <span class="text-danger">*</span></label>
                                <input id="kelurahan" name="kelurahan" type="text" class="form-control" required="" value="<?= $anggota->kelurahan ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="kecamatan" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                <input id="kecamatan" name="id_wil" list="data_kecamatan" type="text" class="form-control" required="" value="<?= $anggota->id_wil ?>">

                                <datalist id="data_kecamatan">
                                    <?php foreach ($kecamatan as $kecamatan): ?>
                                    <option value="<?= $kecamatan->id_wil ?>"><?= $kecamatan->nm_wil ?>, <?= $kecamatan->nama_kabupaten ?></option>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100 mt-3">Simpan</button>
                            </div>
                        </form>
                        <!-- END : Block styled form -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>