<html>
<head>
	<title><?= $title ?></title>
</head>
<body>
	<table width="100%">
		<tr>
			<td><center><h3>CATATAN REVISI <?= strtoupper(array_values($jenis_bimbingan)[0]) ?> <br> <?= strtoupper($kegiatan->deskripsi) ?></h3></center></td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%" class="valign-top" style="margin-left: 50px;">
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
			<td valign="top">Lokasi</td>
			<td  valign="top">:</td>
			<td><?= $aktivitas->lokasi ?: '-' ?></td>
		</tr>
		<tr>
			<td valign="top">Judul</td>
			<td  valign="top">:</td>
			<td><?= $aktivitas->judul ?: '-' ?></td>
		</tr>
		<tr>
			<td><?= array_values($jenis_bimbingan)[0] ?></td>
			<td>:</td>
			<td><?= $pemberi_catatan->nm_sdm ?></td>
		</tr>
	</table>
	<br>
	<table width="100%" border="1" cellspacing="0" cellpadding="5">
		<tr>
			<td width="100%" height="650" valign="top">
				<h3>Catatan Revisi:</h3>
				<?php
				$bimbingan = $this->Aktivitas_model->bimbingan([ 'b.level_name' => 'Dosen', 'b.id_aktivitas' => $penjadwalan->id_aktivitas, 'b.jenis_bimbingan' => key($jenis_bimbingan), 'b.id_kegiatan' => $penjadwalan->id_kegiatan, 'b.id_user' => $pemberi_catatan->nidn, 'b.id_parent' => '0' ])->result();

				foreach ($bimbingan as $bimbingan) {
					echo $bimbingan->isi;
					echo '<br><br>';
				}
				?>
			</td>
		</tr>
	</table>
	<br>
	<table width="100%">
		<tr>
			<td align="center" width="50%"></td>
			<td align="center">
				Majalengka, <?php echo tanggal_indo($penjadwalan->tanggal); ?><br>
				<?= array_values($jenis_bimbingan)[0] ?>,
				<br>
				<br>
				<br>
				<br>
				<br>
				<strong><u><?= $pemberi_catatan->nm_sdm ?></u></strong> <br>
				NIDN. <?= $pemberi_catatan->nidn ?>
			</td>
		</tr>
	</table>	
</body>
</html>