<html>
<head>
	<title><?= $title ?></title>
</head>
<body>
	<table width="100%">
		<tr>
			<td><center><h3>FORM PENILAIAN <?= strtoupper($kegiatan->deskripsi) ?></h3></center></td>
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
	<?php $komponen_nilai = $this->Aktivitas_model->komponen_nilai([ 'aktif' => 1, 'id_kegiatan' => $penjadwalan->id_kegiatan ])->result() ?>
	<table border="1" width="100%" cellpadding="5" cellspacing="0">
		<tr bgcolor="silver">
			<th rowspan="2" align="center" style="vertical-align: middle;"><b>Penilaian</b></th>
			<th colspan="<?= count($komponen_nilai) ?>" align="center" >Komponen Nilai</th>
			<th rowspan="2" align="center" width="100" style="vertical-align: middle;">Rata-rata</th>
		</tr>
		<tr bgcolor="silver">
			<?php foreach($komponen_nilai as $komponen_nilai_): ?>
			<th width="100" align="center"><?= $komponen_nilai_->nama_komponen ?></th>
			<?php endforeach; ?>
		</tr>
		<?php 
			$penilai = 0;
			$jenis_nilai = ['Pembimbing', 'Penguji', 'Ketua Sidang'];
		?>

		<?php $nilai_pembimbing = 0; foreach($pembimbing as $pembimbing_): ?>
		<tr>
			<td>
				Nilai Pembimbing <br>
				(<?= $pembimbing_->nm_sdm ?>)
			</td>

			<?php $i = 0; $nilai = 0;
			echo count($komponen_nilai) < 1 ? '<td></td>' : '';
			foreach($komponen_nilai as $komponen_nilai_): 
			?>
			<?php $get_nilai = $this->Aktivitas_model->nilai([ 'id_penjadwalan' => $penjadwalan->id_penjadwalan, 'id_komponen_nilai' => $komponen_nilai_->id_komponen_nilai, 'jenis_nilai' => 1, 'nidn' => $pembimbing_->nidn ])->row() ?>
			<td align="center" style="<?= $get_nilai ? '' : 'background: white; color: white;' ?>">
				<?= $x = ($get_nilai ? $get_nilai->nilai : 0); $i += ($get_nilai ? 1 : 0); ?>
			</td>
			<?php $nilai += $x;  endforeach; ?>
			
			<td align="center" style="<?= $nilai == 0 ? 'background: white; color: white;' : '' ?>"><?= ($i > 0 ? round($nilai / $i, 2) : 0); $nilai_pembimbing += ($i > 0 ? ($nilai / $i) : 0); ($nilai != 0 ? $penilai++ : $penilai) ?></td>
		</tr>
		<?php endforeach; ?>

		<?php $nilai_penguji = 0; foreach($penguji as $penguji_): ?>
		<tr>
			<td>
				Nilai Penguji <br>
				(<?= $penguji_->nm_sdm ?>)
			</td>

			<?php $i = 0; $nilai = 0;
			echo count($komponen_nilai) < 1 ? '<td></td>' : '';
			foreach($komponen_nilai as $komponen_nilai_): 
			?>
			<?php $get_nilai = $this->Aktivitas_model->nilai([ 'id_penjadwalan' => $penjadwalan->id_penjadwalan, 'id_komponen_nilai' => $komponen_nilai_->id_komponen_nilai, 'jenis_nilai' => 2, 'nidn' => $penguji_->nidn ])->row() ?>
			<td align="center" style="<?= $get_nilai ? '' : 'background: white; color: white;' ?>">
				<?= $x = ($get_nilai ? $get_nilai->nilai : 0); $i += ($get_nilai ? 1 : 0); ?>
			</td>
			<?php $nilai += $x;  endforeach; ?>
			
			<td align="center" style="<?= $nilai == 0 ? 'background: white; color: white;' : '' ?>"><?= ($i > 0 ? round($nilai / $i, 2) : 0); $nilai_penguji += ($i > 0 ? ($nilai / $i) : 0); ($nilai != 0 ? $penilai++ : $penilai) ?></td>
		</tr>
		<?php endforeach; ?>

		<tr>
			<td>
				Nilai Ketua Sidang <br>
				(<?= $penjadwalan->nm_sdm ?>)
			</td>

			<?php $i = 0; $nilai = 0; $nilai_ketua_sidang = 0;
			echo count($komponen_nilai) < 1 ? '<td></td>' : '';
			foreach($komponen_nilai as $komponen_nilai_): 
			?>
			<?php $get_nilai = $this->Aktivitas_model->nilai([ 'id_penjadwalan' => $penjadwalan->id_penjadwalan, 'id_komponen_nilai' => $komponen_nilai_->id_komponen_nilai, 'jenis_nilai' => 3, 'nidn' => $penjadwalan->nidn ])->row() ?>
			<td align="center" style="<?= $get_nilai ? '' : 'background: white; color: white;' ?>">
				<?= $x = ($get_nilai ? $get_nilai->nilai : 0); $i += ($get_nilai ? 1 : 0); ?>
			</td>
			<?php $nilai += $x;  endforeach; ?>
			
			<td align="center" style="<?= $nilai == 0 ? 'background: white; color: white;' : '' ?>"><?= ($i > 0 ? round($nilai / $i, 2) : 0); $nilai_ketua_sidang += ($i > 0 ? ($nilai / $i) : 0); ($nilai != 0 ? $penilai++ : $penilai) ?></td>
		</tr>

		<tr>
			<th align="center" colspan="<?= (count($komponen_nilai) ? count($komponen_nilai)+1 : 2 ) ?>">
				<?php $nilai_akhir = round(($nilai_pembimbing + $nilai_penguji + $nilai_ketua_sidang) / ($penilai ?: 1), 2) ?: '.....'; ?>
				Nilai Akhir = (Total Rata-rata) / <?= $nilai_akhir > 0 ? $penilai : '.....'; ?>
			</th>
			<th align="center">
				<span class="nilai_angka"><?= $nilai_akhir ?></span> 
				(<span class="nilai_huruf"><?= $nilai_mutu = $nilai_akhir > 0 ? $this->Aktivitas_model->pengaturan_nilai($nilai_akhir)->nilai_huruf : '...' ?></span>)
			</th>
		</tr>
	</table>
	<br>
	<?php
		$proses_nilai = $this->Aktivitas_model->proses_nilai([ 'nilai_angka' => $nilai_akhir, 'id_aktivitas' => $anggota->id_aktivitas, 'id_anggota' => $anggota->id_anggota ]);
		// print_r($proses_nilai->row());
	?>
	<table border="0" width="100%" class="valign-top">
		<tr>
			<td valign="top">Sehingga nilai akhir yang dicapai adalah: <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $nilai_akhir ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
		</tr>
		<tr>
			<td valign="top">Dengan huruf mutu: <u>&nbsp;&nbsp;&nbsp;<?= $nilai_mutu ?>&nbsp;&nbsp;&nbsp;</u></td>
		</tr>
	</table>
	<br>
	Mahasiswa diwajibkan mengumpulkan laporan akhir (sudah dijilid <i>hardcover</i>) selambat-lambatnya tanggal <u>&nbsp;&nbsp;&nbsp;<?= tanggal_indo(date("Y-m-d", strtotime("+7 day", strtotime($penjadwalan->tanggal)))) ?>&nbsp;&nbsp;&nbsp;</u>
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
			<td align="center">
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
	<!-- <br>
	<table>
		<tr>
			<td>Ketentuan huruf mutu:</td>
		</tr>
		<tr>
			<td>A (Baik Sekali)</td>
			<td>(80 &#8804; NA &#8804; 100)</td>
		</tr>
		<tr>
			<td>B (Baik)</td>
			<td>(70 &#8804; NA &#8804; 79)</td>
		</tr>
		<tr>
			<td>C (Cukup)</td>
			<td>(50 &#8804; NA &#8804; 69)</td>
		</tr>
		<tr>
			<td>D (Kurang)</td>
			<td>(NA &#8804; 49) harus mengulang seminar/sidang</td>
		</tr>
	</table> -->
	<!-- <p></p>
	<small>
		Catatan: Apabila tabel bimbingan tidak cukup, silahkan cetak berkas ini lebih dari 1 rangkap.
	</small> -->
</body>
</html>