<html>
	<head>
		<title><?= $title ?></title>
	</head>
	<body>
		<?php $this->load->view('cetak/kop-surat') ?>
		<table width="100%">
			<tr>
				<td>
					<center>
						<h3>
							FORM SYARAT PENGAJUAN <br>
							<?= strtoupper($kegiatan->deskripsi) ?> <br>
						</h3>
					</center>
				</td>
			</tr>
		</table>
		<br>
		<table border="0" width="100%" cellpadding="3">
			<tr>
				<td width="20%" valign="top">Nama mahasiswa</td>
				<td width="30%">: <?= $mahasiswa->nm_pd ?></td>

				<td  valign="top">Program Studi</td>
				<td>: <?= $mahasiswa->nama_prodi ?></td>
			</tr>
			<tr>
				<td width="20%"  valign="top">NIM</td>
				<td  width="30%">: <?= $mahasiswa->id_mahasiswa_pt ?></td>

				<td width="20%"  valign="top">Tahun Akademik</td>
				<td  width="30%">: <?= $aktivitas->nama_semester ?></td>

				<!-- <td valign="top">Dosen Wali</td>
				<td>: <?= $mahasiswa->nm_sdm ?></td> -->
			</tr>
		</table>
		<br>
		<table width="100%" border="1" cellspacing="0" cellpadding="5">
			<tr bgcolor="#e7ecf3">
				<th width="15">NO</th>
				<th>SYARAT KELENGKAPAN</th>
				<th width="250">TANDA TANGAN <br>& TANGGAL</th>
			</tr>
			<tr>
				<td valign="top"><b>1.</b></td>
				<td valign="top"><b>AKADEMIK</b>
					<ol>
						<li>Formulir Pendaftaran <?= $kegiatan->deskripsi ?></li>
						<!-- <li>Transkrip Nilai Akademik telah menempuh 120 SKS (Tanpa Nilai E)</li> -->
						<li>IPK Minimal 2,75</li>
					</ol>
				</td>
				<td align="center">
					Bagian Akademik
					<br>
					<br>
					<br>
					<br>
					.............................
				</td>
			</tr>
			<tr>
				<td valign="top"><b>2.</b></td>
				<td valign="top"><b>KEUANGAN</b>
					<ol>
						<li>Lunas Semua Biaya Perkuliahan</li>
					</ol>
				</td>
				<td align="center">
					Bagian Keuangan
					<br>
					<br>
					<br>
					<br>
					.............................
				</td>
			</tr>
			<tr>
				<td valign="top"><b>3.</b></td>
				<td><b>KETUA PROGRAM STUDI</b>
					<ol>
						<li>Fotocopy Laporan Kemajuan</li>
						<li>Fotocopy Kartu Seminar *)</li>
						<li>Fotocopy Surat Keterangan Supervisi *)</li>
						<li>Fotocopy Surat Ijin Kegiatan / Penelitian dari Bakesbangpol *)</li>
						<li>Fotocopy Surat Ijin Balasan dari Tempat Kegiatan / Penelitian *)</li>
						<li>Menyerahkan Ringkasan Seminar 5 Rangkap *)</li>
						<li>Menyerahkan Draf Laporan <?= $aktivitas->nama_jenis_aktivitas_mahasiswa ?></li>
						<li>Softcopy Power Point <?= $kegiatan->deskripsi ?></li>
					</ol>
				</td>
				<td align="center">
					Ketua Program Studi
					<br>
					<br>
					<br>
					<br>
					.............................
				</td>
			</tr>
		</table>
		<br>
		<i>*) Disesuaikan dengan ketentuan fakultas masing-masing.</i> <br>
		<!-- <i>**) Untuk ditandatangani dan diberikan tanggal validasi.</i> -->
	</body>
</html>