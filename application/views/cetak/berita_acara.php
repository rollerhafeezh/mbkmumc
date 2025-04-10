<html>
<head>
	<title><?= $title ?></title>
</head>
<body>
	<?php $this->load->view('cetak/kop-surat') ?>

	<table width="100%">
		<tr>
			<td><center><h3>BERITA ACARA <?= strtoupper($kegiatan->deskripsi) ?></h3></center></td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%">
		<tr>
			<td style="text-align: justify; line-height: 1.5">
				<?php $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu']; ?>
				Pada hari ini, <?= $hari[date('w', strtotime($penjadwalan->tanggal))] ?> tanggal <?= tanggal_indo($penjadwalan->tanggal) ?> pukul <?= substr(explode(' ', $penjadwalan->tanggal)[1], 0, 5)  ?> WIB sampai dengan <?= substr($penjadwalan->selesai, 0, 5) ?: '<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>' ?> WIB telah dilaksanakan <?= $kegiatan->deskripsi ?> Mahasiswa Tahun Akademik <?= $aktivitas->nama_semester ?>. Program Studi <?= $mahasiswa->nama_prodi ?>, menyatakan bahwa :
			</td>
		</tr>
	</table>
	<table border="0" width="100%" class="valign-top" style="margin-left: 100px">
		<tr>
			<td>Nama Mahasiswa</td>
			<td>:</td>
			<td><?= $mahasiswa->nm_pd ?></td>
		</tr>
		<tr>
			<td width="200">Nomor Induk Mahasiswa</td>
			<td width="15">:</td>
			<td><?= $mahasiswa->id_mahasiswa_pt ?></td>
		</tr>
		<tr>
			<td valign="top">Judul</td>
			<td  valign="top">:</td>
			<td><?= $aktivitas->judul ?: '-' ?></td>
		</tr>
		<tr>
			<td>Dosen Pembimbing</td>
			<td>:</td>
			<td>
				<?php
				if (count($pembimbing) < 1) {
					echo 'Belum diatur';
				}

				$pmb_text = '';
				foreach ($pembimbing as $pmb) {
					$pmb_text .= '<span data-toggle="tooltip" title="Pembimbing ke '.$pmb->pembimbing_ke.'"><sup>['.$pmb->pembimbing_ke.']</sup>'.ucwords(strtolower($pmb->nm_sdm)).'</span>, ';
				}
				echo rtrim($pmb_text, ', ');
				?>
			</td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%" class="valign-top">
		<tr>
			<td colspan="3">Dengan hasil pengujian sebagai berikut :</td>
		</tr>
		<tr>
			<td width="300">DINYATAKAN</td>
			<td width="15">:</td>
			<?php if ($rata_rata->nilai != 0): ?>
			<td><?= !in_array($this->Aktivitas_model->pengaturan_nilai($rata_rata->nilai)->nilai_huruf, ['D', 'E']) ? 'LULUS / <del>TIDAK LULUS</del>' : '<del>LULUS</del> / TIDAK LULUS' ?> *)</td>
			<?php else: ?>
			<td>LULUS / TIDAK LULUS *)</td>
			<?php endif; ?>
		</tr>
		<tr>
			<td valign="top">DENGAN NILAI ANGKA</td>
			<td  valign="top">:</td>
			<td><?= $rata_rata->nilai ? round($rata_rata->nilai, 2) : '<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>' ?></td>
		</tr>
		<tr>
			<td valign="top">NILAI HURUF</td>
			<td  valign="top">:</td>
			<td><?= $rata_rata->nilai ? $this->Aktivitas_model->pengaturan_nilai($rata_rata->nilai)->nilai_huruf : '<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>' ?></td>
		</tr>
	</table>
	<br>
	Demikian berita acara ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.
	<br><br>
	*) Coret yang tidak sesuai.
	<br>
	<br>
	<table width="100%">
		<tr>
			<td align="center" width="50%">
				<br>
				Dosen Penguji,
				<br>
				<br>
				<br>
				<br>
				<br>
				<strong><?= (count($penguji) > 0) ? '<u>'.$penguji[0]->nm_sdm.'</u></strong><br>NIDN. '.$penguji[0]->nidn : '<strong>Belum diatur' ?></strong>
			</td>
			<td align="center" width="50%">
				Majalengka, <?php echo tanggal_indo($penjadwalan->tanggal); ?><br>
				Dosen Pembimbing,
				<br>
				<br>
				<br>
				<br>
				<br>
				<strong><?= (count($pembimbing) > 0) ? '<u>'.$pembimbing[0]->nm_sdm.'</u></strong><br>NIDN. '.$pembimbing[0]->nidn : '<strong>Belum diatur' ?></strong>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<br>
				Ketua Sidang,
				<br>
				<br>
				<br>
				<br>
				<br>
				<strong><u><?= $penjadwalan->nm_sdm ?></u></strong> <br>
				NIDN. <?= $penjadwalan->nidn ?>
			</td>
		</tr>
	</table>
	<!-- <p></p>
	<small>
		Catatan: Apabila tabel bimbingan tidak cukup, silahkan cetak berkas ini lebih dari 1 rangkap.
	</small> -->
</body>
</html>