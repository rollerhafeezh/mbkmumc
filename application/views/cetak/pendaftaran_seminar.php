<html>
	<head>
		<title><?= $title ?></title>
	</head>
	<body>
		<?php $this->load->view('cetak/kop-surat') ?>
		<table width="100%">
			<tr>
				<td><center><h3>FORMULIR PENDAFTARAN <br> <?= strtoupper($kegiatan->deskripsi) ?></h3></center></td>
			</tr>
		</table>
		<br>
		<?php $this->load->view('cetak/identitas') ?>
		<br>
			<div style="border: 2px solid #000;width: 2.8cm;height: 3.8cm;margin: 0 auto; text-align: center; vertical-align: middle;">
				<br><br>
				<small>Foto Almamater <br>Berwarna <br>3x4</small>
			</div>
		<br>
		<table width="100%">
			<tr>
				<td align="center">
					<br>
					Dosen Wali,
					<br>
					<br>
					<br>
					<br>
					<br>
					<strong><u><?= $mahasiswa->nm_sdm ?></u></strong> <br>
					NIDN. <?= $mahasiswa->nidn ?>
				</td>
				<td align="center">
					Majalengka, <?php echo tanggal_indo(date('Y-m-d')); ?><br>
					Yang Mengajukan,
					<br>
					<br>
					<br>
					<br>
					<br>
					<strong><u><?= $mahasiswa->nm_pd ?></u></strong> <br>
					NIM. <?= $mahasiswa->id_mahasiswa_pt ?>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<br>
					<br>	
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