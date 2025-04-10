<html>
<head>
	<title><?= $title ?></title>
</head>
<body>
	<?php $this->load->view('cetak/kop-surat') ?>

	<table width="100%">
		<tr>
			<td><center><h3>KARTU MENGIKUTI <?= strtoupper($kegiatan->deskripsi) ?></h3></center></td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%">
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
	</table>
	<br>
	<table border="1" cellspacing="0" cellpadding="5" width="100%">
		<tr bgcolor="#e7ecf3">
			<th width="15">NO</th>
			<th width="100">TANGGAL</th>
			<th>IDENTITAS PENYAJI DAN JUDUL</th>
			<th width="100">DOSEN PENGUJI</th>
			<th width="100">TANDA TANGAN</th>
		</tr>
		<tr>
			<td height="650px"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>
	<br>
	<table width="100%">
		<tr>
			<td align="center" width="50%">
				<br>
				<br>
				Mahasiswa,
				<br>
				<br>
				<br>
				<br>
				<br>
				<b><u><?= $mahasiswa->nm_pd ?></u></b> <br>
				NIM. <?= $mahasiswa->id_mahasiswa_pt ?>
			</td>
			<td align="center">
				Majalengka, <?php echo tanggal_indo(date('Y-m-d')); ?><br>
				Ketua Program Studi <br> <?= $mahasiswa->nama_prodi ?>,
				<br>
				<br>
				<br>
				<br>
				<br>
				.................................
			</td>
		</tr>
	</table>
</body>
</html>