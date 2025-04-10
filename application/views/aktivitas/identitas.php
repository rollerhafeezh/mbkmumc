<?php
    $anggota    = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $_SESSION['id_user'], 'as.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
    $aktivitas  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $anggota->id_aktivitas, 'a.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
    $penjadwalan = $this->Aktivitas_model->penjadwalan([ 'id_aktivitas' => $anggota->id_aktivitas], 'p.id_kegiatan ASC, p.tanggal ASC')->result();

?>
<div class="col-md-5">
    <?php if (count($penjadwalan) > 0): ?>
    <section id="boxed-layout-tips" class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Jadwal Seminar / Sidang</h5>
            <table class="w-100">
                <?php $i = 1; $nr_penjadwalan = count($penjadwalan); foreach($penjadwalan as $penjadwalan): ?>
                <tr>
                    <td colspan="3" class="fw-bold"><?= $penjadwalan->deskripsi ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap">Status Kegiatan</td>
                    <td width="1">: </td>
                    <td><?= $penjadwalan->status ? '<span class="text-secondary">Selesai Dilaksanakan</span>' : '<span class="text-primary">Belum Dilaksanakan</span>' ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap">Tempat</td>
                    <td width="1">: </td>
                    <td><?= $penjadwalan->tempat ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap" valign="top">Tgl. Pelaksanaan</td>
                    <td width="1" valign="top">: </td>
                    <td valign="top"><?= format_indo($penjadwalan->tanggal) ?> WIB</td>
                </tr>
                <tr>
                    <td class="text-nowrap" width="130px" valign="top">Ketua Sidang</td>
                    <td width="1" valign="top">: </td>
                    <td valign="top"><?= ucwords(strtolower($penjadwalan->nm_sdm)) ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap" width="130px" valign="top">Dosen Penguji</td>
                    <td width="1" valign="top">: </td>
                    <td valign="top">
                        <ol class="py-0 my-0 ps-3 pe-0">
                        <?php
                        $penguji_ = $this->Aktivitas_model->penguji([ 'p.id_aktivitas' => $penjadwalan->id_aktivitas, 'p.id_kegiatan' => $penjadwalan->id_kegiatan ], 'p.penguji_ke ASC')->result();
                        // print_r($penguji_);
                        foreach ($penguji_ as $penguji_) {
                            echo '<li>'.ucwords(strtolower($penguji_->nm_sdm)).'</li>';
                        }
                        ?>
                        </ol>
                    </td>
                </tr>
                <tr>
                    <td>Berita Acara</td>
                    <td>: </td>
                    <td>
                        <?php $berkas_anggota = $this->Aktivitas_model->berkas_anggota([ 'k.id_jenis_aktivitas_mahasiswa' => $aktivitas->id_jenis_aktivitas_mahasiswa, 'kb.id_kat_berkas' => '4', 'bk.id_kegiatan' => $penjadwalan->id_kegiatan ], 'bk.id_kegiatan ASC', $anggota->id_anggota)->row();  ?>
                        <a  style="<?= $berkas_anggota->berkas != '' ? '' : 'filters:grayscale(100%);' ?>" href="javascript:void(0)" onclick="lihat_berkas(`Berita Acara <?= $berkas_anggota->deskripsi ?>`, `<?= base_url('aktivitas/cetak/'.$berkas_anggota->slug_kategori_berkas.'/'.$berkas_anggota->slug_kegiatan.'/'.$penjadwalan->id_penjadwalan) ?>`)">
                            <!-- <img src="<?= base_url('assets/img/pdf.png') ?>" class="ms-1">  -->
                            Generate Berkas
                        </a>
                    </td>
                </tr>
                <tr style="<?= $i == $nr_penjadwalan ? 'display: none;' : 'height: 20px;' ?>" >
                    <td colspan="3"></td>
                </tr>
                <?php $i++; endforeach; ?>
            </table>
        </div>
    </section>
    <?php endif; ?>

    <section id="boxed-layout-tips" class="card mb-4">
        <div class="card-body">
            <?php if (isset($pembimbing)): ?>
            <?php if (count($pembimbing) > 0): ?>
            <h5 class="card-title">Identitas Pembimbing</h5>
            <table class="w-100 mb-2">
                <?php foreach($pembimbing as $pembimbing): ?>
                <!-- <tr>
                    <td colspan="3">Pembimbing Ke-<?= $pembimbing->pembimbing_ke ?></td>
                </tr> -->
                <tr>
                    <td>NIDN</td>
                    <td>: </td>
                    <td><?= $pembimbing->nidn ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap" width="130px" valign="top">Nama Dosen</td>
                    <td width="1" valign="top">: </td>
                    <td valign="top"><?= ucwords(strtolower($pembimbing->nm_sdm)) ?></td>
                </tr> 
                <tr>
                    <td>No. Handphone</td>
                    <td>: </td>
                    <td><?= $pembimbing->no_hp ? '<a href="tel:+'.$pembimbing->no_hp.'">+'.$pembimbing->no_hp.'</a>' : '-' ?></td>
                </tr>
                <tr style="height: 10px;" class="d-block">
                    <td colspan="3">&nbsp;</td>
                </tr>
                <?php endforeach; ?>
            </table>    
            <?php endif; ?>
            <?php endif; ?>

    		<h5 class="card-title">Identitas Kegiatan</h5>
    		<table class="w-100">
                <tr>
                    <td>Status Kegiatan</td>
                    <td>: </td>
                    <td><?= $aktivitas->status == 0 ? '<span class="text-primary">Belum Selesai</span>' : '<span class="text-secondary">Selesai</span>' ?></td>
                </tr>
    			<tr>
    				<td class="text-nowrap" width="130px">Jenis Kegiatan</td>
    				<td width="1">: </td>
    				<td><?= $aktivitas->nama_jenis_aktivitas_mahasiswa ?></td>
    			</tr> 
    			<tr>
    				<td>Tahun Akademik</td>
    				<td>: </td>
    				<td>
    					<?= $aktivitas->nama_semester ?>
    					<!-- <i class="pli-information ms-1 fs-4" data-bs-toggle="tooltip" title="Awal Kontrak: 2020/2021 Genap"></i> -->
    				</td>
    			</tr>
                <!-- <tr>
                    <td class="text-nowrap">No. Penugasan</td>
                    <td width="1">: </td>
                    <td><?= $aktivitas->sk_tugas ?: '<span class="text-primary">Silahkan hubungi prodi</span>' ?></td>
                </tr> -->
                <tr>
                    <td class="text-nowrap">Tgl. Penugasan</td>
                    <td width="1">: </td>
                    <td><?= $aktivitas->tanggal_sk_tugas ? tanggal_indo($aktivitas->tanggal_sk_tugas) : '<span class="text-primary">Silahkan hubungi prodi</span>' ?></td>
                </tr> 
    			<tr>
    				<td valign="top">Lokasi</td>
    				<td valign="top">: </td>
    				<td>
                        <?= strip_tags($aktivitas->lokasi) ?>
                        <a href="#" class="badge bg-info ms-1 text-decoration-none text-white" data-bs-toggle="modal" data-bs-target="#modal_lokasi_penelitian" data-action="2"><i class="psi-pen-4 me-1"></i> <?= $aktivitas->lokasi ? 'Edit' : 'Input Lokasi' ?></a>
                    </td>
    			</tr>
    			<tr>
    				<td class="text-nowrap" valign="top">Judul</td>
    				<td valign="top">: </td>
    				<td>
                        <?= strip_tags($aktivitas->judul) ?>
    					<a href="#" class="badge bg-info ms-1 text-decoration-none text-white" data-bs-toggle="modal" data-bs-target="#modal_judul" action="edit"><i class="psi-pen-4 me-1"></i> <?= $aktivitas->judul ? 'Edit' : 'Input Judul' ?></a>
    				</td>
    			</tr>
                <tr>
                    <td class="text-nowrap" valign="top">Judul (English)</td>
                    <td valign="top">: </td>
                    <td>
                        <i><?= strip_tags($aktivitas->judul_en) ?></i>
                        <a href="#" class="badge bg-info ms-1 text-decoration-none text-white" data-bs-toggle="modal" data-bs-target="#modal_judul_en" action="edit"><i class="psi-pen-4 me-1"></i> <?= $aktivitas->judul_en ? 'Edit' : 'Input Judul (English)' ?></a>
                    </td>
                </tr>
    			<!-- <tr>
    				<td>Jenis Anggota</td>
    				<td>: </td>
    				<td><?= $aktivitas->jenis_anggota == 0 ? 'Personal' : 'Kelompok' ?></td>
    			</tr> -->
    		</table>

            <h5 class="card-title mt-4">Identitas Mahasiswa</h5>
            <table class="w-100">
                <tr>
                    <td class="text-nowrap" width="130px">NIM</td>
                    <td width="1">: </td>
                    <td><?= $anggota->id_mahasiswa_pt ?></td>
                </tr>
                <tr>
                    <td valign="top">Nama Lengkap</td>
                    <td valign="top">: </td>
                    <td><?= ucwords(strtolower($anggota->nm_pd)) ?></td>
                </tr>
                <tr>
                    <td valign="top">Fakultas</td>
                    <td valign="top">: </td>
                    <td><?= ucwords(strtolower($anggota->nama_fak)) ?></td>
                </tr>
                <tr>
                    <td valign="top">Program Studi</td>
                    <td valign="top">: </td>
                    <td><?= $anggota->nm_jenj_didik ?> - <?= $anggota->nama_prodi ?></td>
                </tr>
                <tr>
                    <td valign="top">Perguruan Tinggi</td>
                    <td valign="top">: </td>
                    <td><?= $_ENV['INST_NAME'] ?></td>
                </tr>
            </table>

        </div>
    </section>
</div>