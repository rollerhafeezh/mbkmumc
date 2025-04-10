<html>
<head>
	<title><?= $title ?></title>
</head>
<body>
	<table width="100%">
		<tr>
			<td><center><h3>
				DAFTAR HADIR <?= strtoupper($kegiatan->deskripsi) ?> <br>
				<?= $mahasiswa->nama_fak ?> - UMC<br>
				TA. <?= strtoupper($aktivitas->nama_semester) ?>
			</h3></center></td>
		</tr>
	</table>
	<br>
	<table border="0" width="100%" class="valign-top" style="margin-left: 50px;">
		<tr>
			<td>Hari, Tanggal, Pukul</td>
			<td>:</td>
			<td><?= format_indo($penjadwalan->tanggal) ?> WIB</td>
		</tr>
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
			<td width="200">Program Studi</td>
			<td width="15">:</td>
			<td><?= $mahasiswa->nama_prodi ?></td>
		</tr>
		<tr>
			<td valign="top">Judul</td>
			<td  valign="top">:</td>
			<td><?= $aktivitas->judul ?: '-' ?></td>
		</tr>
	</table>
	<br>
	<table border="1" cellspacing="0" cellpadding="5" width="100%">
		<tr bgcolor="silver">
			<th width="15">NO</th>
			<th width="130">NO IDENTITAS</th>
			<th>NAMA</th>
			<th width="170">PERAN</th>
			<th width="100">TANDA TANGAN</th>
		</tr>
		<tr>
	        <td align="center"><?= $i = 1 ?>.</td>
	        <td align="center"><?= $penjadwalan->nidn ?></td>
	        <td><?= $penjadwalan->nm_sdm ?></td>
	        <td>KETUA SIDANG</td>
			<td align="center">TTD</td>
	    </tr>
	    <?php
		$audien = 1;
		foreach ($pembimbing as $r_pembimbing) {
		?>
		<tr>
	        <td align="center"><?= $i += 1 ?>.</td>
	        <td align="center"><?= $r_pembimbing->nidn ?></td>
	        <td><?= $r_pembimbing->nm_sdm ?></td>
	        <td>DOSEN PEMBIMBING <?= $r_pembimbing->pembimbing_ke ?></td>
			<td align="center">TTD</td>
	    </tr>
		<?php
		$audien++;
		}

		foreach ($penguji as $r_penguji) {
		?>
		<tr>
	        <td align="center"><?= $i += 1 ?>.</td>
	        <td align="center"><?= $r_penguji->nidn ?></td>
	        <td><?= $r_penguji->nm_sdm ?></td>
	        <td>DOSEN PENGUJI <?= $r_penguji->penguji_ke ?></td>
			<td align="center">TTD</td>
	    </tr>
		<?php $audien++; } ?>
		<tr>
	        <td align="center"><?= $i += 1 ?>.</td>
	        <td align="center"><?= $mahasiswa->id_mahasiswa_pt ?></td>
	        <td><?= $mahasiswa->nm_pd ?></td>
	        <td>PENYAJI</td>
			<td align="center">TTD</td>
	    </tr>
	    <?php
	    $peserta = $this->Aktivitas_model->presensi_penjadwalan([ 'pp.id_penjadwalan' => $penjadwalan->id_penjadwalan, 'pp.hadir' => '1' ])->result();

	    for ($j=0; $j < (19 - $audien); $j++) { 
	    ?>
	    <tr>
	        <td align="center"><?= ++$i ?>.</td>
	        <td align="center"><?= isset($peserta[$j]) ? $peserta[$j]->id_user : '' ?></td>
	        <td><?= isset($peserta[$j]) ? $peserta[$j]->nm_pd : '' ?></td>
	        <td><?= isset($peserta[$j]) ? 'PESERTA' : '' ?></td>
			<td align="center"><?= isset($peserta[$j]) ? 'TTD' : '' ?></td>
	    </tr>
	    <?php
	    }
	    ?>
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