<table border="0" width="100%" cellpadding="3" class="valign-top" style="margin: 0 25px;">
	<tr>
		<td width="200">Nama Mahasiswa</td>
		<td width="15">:</td>
		<td><?= $mahasiswa->nm_pd ?></td>
	</tr>
	<tr>
		<td>Nomor Induk Mahasiswa</td>
		<td>:</td>
		<td><?= $mahasiswa->id_mahasiswa_pt ?></td>
	</tr>
	<tr>
		<td>Tempat, Tanggal Lahir</td>
		<td>:</td>
		<td><?= ucwords(strtolower($mahasiswa->tmp_lahir)) ?>, <?= tanggal_indo($mahasiswa->tgl_lahir) ?></td>
	</tr>
	<tr>
		<td>Jenis Kelamin</td>
		<td>:</td>
		<td><?= $mahasiswa->jk == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
	</tr>
	<!-- <tr>
		<td>Agama</td>
		<td>:</td>
		<td><?= $mahasiswa->agama ?></td>
	</tr>
	<tr>
		<td>Kewarganegaraan</td>
		<td>:</td>
		<td>WNI</td>
	</tr> -->
	<tr>
		<td valign="top">Alamat</td>
		<td valign="top">:</td>
		<td><?= $mahasiswa->jalan ?: '' ?> <?= $mahasiswa->blok ?: '' ?> <?= ($mahasiswa->rt ? 'RT '.$mahasiswa->rt: '') ?> <?= $mahasiswa->rw ? 'RW '.$mahasiswa->rw : '' ?> <?= $mahasiswa->kelurahan ?: '' ?> <?= $mahasiswa->nm_wil ?: '' ?></td>
	</tr>
	<tr>
		<td>Nomor Handphone</td>
		<td>:</td>
		<td><?= $mahasiswa->no_hp ?></td>
	</tr>
	<tr>
		<td>Fakultas / Program Studi</td>
		<td>:</td>
		<td><?= ucwords(strtolower($mahasiswa->nama_fak)).' / '.$mahasiswa->nama_prodi ?></td>
	</tr>
	<tr>
		<td>Tahun Akademik</td>
		<td>:</td>
		<td><?= $aktivitas->nama_semester ?></td>
	</tr>
	<tr>
		<td>Lokasi</td>
		<td>:</td>
		<td><?= $aktivitas->lokasi ?></td>
	</tr>
	<tr>
		<td>Judul</td>
		<td>:</td>
		<td><?= $aktivitas->judul ?></td>
	</tr>
	<tr>
		<td>Judul (English)</td>
		<td>:</td>
		<td><?= $aktivitas->judul_en ?></td>
	</tr>
</table>