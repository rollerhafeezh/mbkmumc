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
							<?= strtoupper($kegiatan->nama_kegiatan) ?> / TUGAS AKHIR<br>
							<?= $mahasiswa->nama_fak ?>
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
						<li>Formulir Pendaftaran <?= $kegiatan->nama_kegiatan ?></li>
						<li>Transkrip Nilai Akademik Tanpa Nilai E</li>
						<li>IPK Minimal 3,00</li>
						<li>Fotocopy Ijazah Pendidikan Sebelumnya (Legalisir)</li>
						<li>Sertifikat Prosspek Perguruan Tinggi (Asli)</li>
						<li>Sertifikat Prosspek Fakultas (Asli) *)</li>
						<li>Sertifikat KKN / KNM (Asli)</li>
						<li>Pas Foto (Jas Hitam Berdasi) 2x3, 3x4, 4x6 (Hitam Putih & Berwarna) Rangkap 6</li>
						<li>Print Out Data Mahasiswa di PDDIKTI</li>
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
				<td valign="top"><b>PEMBIMBING DAN PENGUJI</b>
					<ol>
						<li>Menyerahkan Draf Laporan</li>
					</ol>
				</td>
				<td align="center">
						Pembimbing I	<br><br>.............................<br>
						Pembimbing II	<br><br>.............................<br>
						Penguji I		<br><br>.............................<br>
						Penguji II		<br><br>.............................
				</td>
			</tr>
			<tr>
				<td valign="top"><b>4.</b></td>
				<td><b>KETUA PROGRAM STUDI</b>
					<ol>
						<li>Menyerahkan Draf Laporan</li>
						<li>Menyerahkan Draf Jurnal</li>
						<li>Menyerahkan Poster Penelitian</li>
						<li>Fotocopy Hasil <i>Plagiarism Checker</i></li>
						<li>Fotocopy Laporan Kemajuan</li>
						<li>Fotocopy Kartu Seminar *)</li>
						<li>Fotocopy Riwayat Hidup (CV)</li>
						<li>Softcopy Power Point & Draf Laporan</li>
						<li>Sertifikat TOEFL/TOEIC/IELTS/TOEP (Asli) *)</li>
						<li>Sertifikat Keprofesian Sesuai Bidang Program Studi (Asli) *)</li>
						<li>Sertifikat Sebagai Pemakalah Tk. Nasional (1 Buah Asli) *)</li>
						<li>Sertifikat Sebagai Peserta Tk. Nasional (2 Buah Asli) *)</li>
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
			<tr>
				<td valign="top"><b>5.</b></td>
				<td><b>PERPUSTAKAAN FAKULTAS</b>
					<ol>
						<li>Tidak Ada Pinjaman Buku</li>
						<li>Lunas Tunggakan Denda Buku</li>
						<li>Menyumbang Min. 1 Buku Handbook Tahun Terbit 2000 - Sekarang</li>
					</ol>
				</td>
				<td align="center">
					Kepala Perpustakaan
					<br>
					<br>
					<br>
					<br>
					.............................
				</td>
			</tr>
			<tr>
				<td valign="top"><b>6.</b></td>
				<td><b>PERPUSTAKAAN UNIVERSITAS MAJALENGKA</b>
					<ol>
						<li>Tidak Ada Pinjaman Buku</li>
						<li>Lunas Tunggakan Denda Buku</li>
						<li>Menyumbang Min. 1 Buku Handbook Tahun Terbit 2000 - Sekarang</li>
					</ol>
				</td>
				<td align="center">
					Kepala Perpustakaan
					<br>
					<br>
					<br>
					<br>
					.............................
				</td>
			</tr>
		</table>
		<br>
		<i>*) Disesuaikan dengan ketentuan fakultas masing-masing.</i>
	</body>
</html>