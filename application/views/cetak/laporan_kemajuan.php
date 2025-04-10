<html>
<head>
	<title><?= $title ?></title>
</head>
<body>
	<?php $this->load->view('cetak/kop-surat') ?>

	<table width="100%">
		<tr>
			<td><center><h3>LAPORAN KEMAJUAN <?= strtoupper($aktivitas->nama_jenis_aktivitas_mahasiswa) ?></h3></center></td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%" class="valign-top">
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
			<td>Program Studi</td>
			<td>:</td>
			<td><?= $mahasiswa->nama_prodi ?></td>
		</tr>
		<tr>
			<td>Tahun Akademik</td>
			<td>:</td>
			<td><?= $aktivitas->nama_semester ?></td>
		</tr>
		<tr>
			<td>Pembimbing</td>
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
		<tr>
			<td valign="top">Lokasi</td>
			<td  valign="top">:</td>
			<td><?= $aktivitas->lokasi ?: '' ?></td>
		</tr>
		<tr>
			<td valign="top">Judul Usulan</td>
			<td  valign="top">:</td>
			<td><?= $aktivitas->judul ?: '' ?></td>
		</tr>
		<tr>
			<td valign="top">Judul Usulan (English)</td>
			<td  valign="top">:</td>
			<td><?= $aktivitas->judul_en ?: '' ?></td>
		</tr>
	</table>
	<br>
	<table border="1" cellspacing="0" cellpadding="5" width="100%">
		<tr bgcolor="#e7ecf3">
			<th width="15">NO</th>
			<th width="150">TANGGAL</th>
			<th>MATERI YANG DISAMPAIKAN</th>
			<th width="100">PARAF</th>
		</tr>

		<?php $no = 1; if (isset($bimbingan)): ?>
		<?php if (count($bimbingan) < 1) {
			echo '<tr><td colspan="4" align="center">Data bimbingan masih kosong.</td></tr>';
		} ?>
		<?php foreach ($bimbingan as $bimbingan): ?>
		<tr>
			<td valign="top" align="center"><?= $no++ ?>.</td>
			<td valign="top" align="center"><?= date('d/m/Y', strtotime($bimbingan->created_at)) ?></td>
			<td valign="top"><?= $bimbingan->isi ?></td>
			<td valign="top" align="center"><?= $bimbingan->nama_user ?></td>
		</tr>
		<?php endforeach; ?>

		<?php else: ?> 
		<tr>
			<td height="450px"></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<?php endif; ?>
	</table>
	<br>
	<?= $aktivitas->nama_jenis_aktivitas_mahasiswa ?> telah disetujui untuk diajukan dalam seminar / ujian pada Program Studi <?= $mahasiswa->nama_prodi ?>:
	<br>
	<br>
	<table width="100%">
		<tr>
			<td align="center" width="50%">
				Ketua Program Studi <br> <?= $mahasiswa->nama_prodi ?>,
				<br>
				<br>
				<br>
				<br>
				<br>
				.................................
			</td>
			<td align="center">
				Majalengka, <?php echo tanggal_indo(date('Y-m-d')); ?><br>
				Pembimbing,
				<br>
				<br>
				<br>
				<br>
				<br>
				<strong><?= (count($pembimbing) > 0) ? '<u>'.$pembimbing[0]->nm_sdm.'</u></strong><br>NIDN. '.$pembimbing[0]->nidn : '<strong>Belum diatur' ?></strong>
			</td>
		</tr>
	</table>
	<!-- <p></p>
	<small>
		Catatan: Apabila tabel bimbingan tidak cukup, silahkan cetak berkas ini lebih dari 1 rangkap.
	</small> -->
</body>
</html>