<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aktivitas_model extends CI_Model {

	function __construct()
	{
		parent::__construct();

		$CI = &get_instance();
		$this->load->database();
		$this->db_aktivitas = $CI->load->database('aktivitas', TRUE);
		$this->db_sso 		= $CI->load->database('sso', TRUE);
	}

	function get_dokumen($id_mhs, $jenis)
	{
	    return $this->db->get_where($_ENV['DB_GREAT'].'mahasiswa_file', array('id_mhs'=>$id_mhs,'jenis'=>$jenis))->row();
	}
	
	function unggah_dokumen($id_mhs, $jenis, $file_mahasiswa)
	{
	    $sql = $this->db->get_where($_ENV['DB_GREAT'].'mahasiswa_file',array('id_mhs'=>$id_mhs,'jenis'=>$jenis))->row();

	    if($sql)
	    {
	        $this->db->where('id_mhs',$id_mhs);
	        $this->db->where('jenis',$jenis);
		    $this->db->set('file_mahasiswa',$file_mahasiswa);
		    return $this->db->update($_ENV['DB_GREAT'].'mahasiswa_file');

	    }else{
	        $this->db->set('id_mhs',$id_mhs);
	        $this->db->set('jenis',$jenis);
		    $this->db->set('file_mahasiswa',$file_mahasiswa);
		    return $this->db->insert($_ENV['DB_GREAT'].'mahasiswa_file');
	    }
	}

	function aktivitas($where, $order_by=null)
	{
		if ($order_by) $this->db->order_by($order_by);

		$this->db->select('a.*, jam.nama_jenis_aktivitas_mahasiswa, s.nama_semester');
		$this->db->where($where);
		$this->db->join($_ENV['DB_REF'].'jenis_aktivitas_mahasiswa jam', 'jam.id_jenis_aktivitas_mahasiswa = a.id_jenis_aktivitas_mahasiswa');
		$this->db->join($_ENV['DB_REF'].'semester s', 's.id_semester=a.id_smt');
		
		return $this->db->get($_ENV['DB_AKT'].'aktivitas a');
	}

	function mahasiswa($where)
	{
		$this->db->select('m.*, mp.*, nidn, nm_sdm, a.*, w.nm_wil, p.*, f.*');
		$this->db->where($where);
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa_pt mp', 'mp.id_mhs = m.id_mhs');
		$this->db->join($_ENV['DB_GREAT'].'dosen d', 'd.id_dosen = mp.id_dosen', 'left');
		$this->db->join($_ENV['DB_REF'].'wilayah w', 'w.id_wil LIKE concat("%",m.id_wil)', 'left');
		$this->db->join($_ENV['DB_REF'].'agama a', 'a.id_agama = m.id_agama', 'left');
		$this->db->join($_ENV['DB_REF'].'prodi p', 'p.kode_prodi = mp.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas f', 'f.kode_fak = p.kode_fak');
		return $this->db->get($_ENV['DB_GREAT'].'mahasiswa m');
	}

	function anggota($where, $order_by=null, $biodata=null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($biodata) {
			$this->db->select('m.id_mhs, mp.id_mahasiswa_pt, nm_pd, jk, nik, nisn, m.email, tmp_lahir, tgl_lahir, nm_ibu_kandung, id_agama, m.no_hp, jalan, rt, rw, kelurahan, id_wil');
		} else {
			$this->db->select('a.*, mp.kode_prodi, m.nm_pd, m.id_mhs, p.nama_prodi, p.kode_fak, f.nama_fak, jp.nm_jenj_didik');
		}

		$this->db->where($where);
		$this->db->join($_ENV['DB_AKT'].'aktivitas as', 'as.id_aktivitas=a.id_aktivitas');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa_pt mp', 'mp.id_mahasiswa_pt=a.id_mahasiswa_pt');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa m', 'm.id_mhs=mp.id_mhs');
		$this->db->join($_ENV['DB_REF'].'prodi p', 'p.kode_prodi=mp.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas f', 'f.kode_fak=p.kode_fak');
		$this->db->join($_ENV['DB_REF'].'jenjang_pendidikan jp', 'jp.id_jenj_didik=p.id_jenjang_pendidikan');

		return $this->db->get($_ENV['DB_AKT'].'anggota a');
	}

	function kegiatan($where)
	{
		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->get('kegiatan');
	}

	function kategori_berkas($where)
	{
		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->get('kategori_berkas');
	}

	function berkas_kegiatan($where, $order_by=null, $id_anggota=null)
	{
		if ($order_by) $this->db_aktivitas->order_by($order_by);
		$id_anggota = !$id_anggota ? null : ' AND ba.id_anggota = '.$this->db->escape(xss_clean($id_anggota));
	
		$this->db_aktivitas->select('bk.*, kb.slug, kb.nama_kategori, kb.deskripsi, ba.id_berkas_anggota, ba.id_anggota, ba.berkas, ba.upload_by, ba.created_at');
		$this->db_aktivitas->where($where);
		$this->db_aktivitas->join('kategori_berkas kb', 'kb.id_kat_berkas=bk.id_kat_berkas');
		$this->db_aktivitas->join('berkas_anggota ba', 'ba.id_berkas_kegiatan=bk.id_berkas_kegiatan'.$id_anggota, 'left');
		return $this->db_aktivitas->get('berkas_kegiatan bk');
	}

	function hapus_berkas_anggota($where)
	{
		$this->db_aktivitas->where($where);
		$this->db_aktivitas->delete('berkas_anggota');
		return $this->db_aktivitas->affected_rows();
	}

	function kegiatan_anggota($where, $id_anggota)
	{
		$this->db_aktivitas->select('k.*, ka.id_anggota, ka.created_at, ka.status');
		$this->db_aktivitas->where($where);
		$this->db_aktivitas->join('kegiatan_anggota ka', 'ka.id_kegiatan = k.id_kegiatan AND ka.id_anggota = '.$this->db->escape(xss_clean($id_anggota)), 'left');

		return $this->db_aktivitas->get('kegiatan k');
	}

	function pengaturan_nilai($nilai_angka)
	{
		return $this->db_aktivitas->query('SELECT * FROM `pengaturan_nilai` WHERE (? BETWEEN nilai_angka_min AND nilai_angka_maks) AND aktif = 1', [ $nilai_angka ])->row();
	}

	function proses_nilai($data)
	{
		$penilaian = $this->pengaturan_nilai($data['nilai_angka']);

		$this->db_aktivitas->where([ 'id_aktivitas' => $data['id_aktivitas'], 'id_anggota' => $data['id_anggota'] ]);
		return $this->db_aktivitas->update('anggota', [ 'nilai_angka' => $data['nilai_angka'], 'nilai_huruf' => $penilaian->nilai_huruf, 'bobot' => $penilaian->bobot ]);

		// $this->db_aktivitas->where($where);
		// $this->db_aktivitas->where($where);
		// return $this->db_aktivitas->get('nilai');
	}

	function rata_rata_nilai($id_penjadwalan, $id_kegiatan)
	{
		$query = 'SELECT SUM(rata_rata) / COUNT(*) as nilai FROM (SELECT AVG(nilai) as rata_rata FROM nilai JOIN komponen_nilai ON komponen_nilai.id_komponen_nilai = nilai.id_komponen_nilai WHERE id_penjadwalan = ? AND id_kegiatan = ? GROUP BY jenis_nilai) N';
		return $this->db_aktivitas->query($query, [ $id_penjadwalan, $id_kegiatan ]);
	}

	function nilai($where, $select=null)
	{
		if ($select) $this->db_aktivitas->select($select);

		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->get('nilai');
	}

	function komponen_nilai($where)
	{
		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->get('komponen_nilai');
	}

	function bimbingan($where, $order_by=null)
	{
		if ($order_by) $this->db_aktivitas->order_by($order_by);

		$this->db_aktivitas->select('*');
		$this->db_aktivitas->where($where);
		$this->db_aktivitas->join('kegiatan k', 'k.id_kegiatan = b.id_kegiatan', 'left');

		return $this->db_aktivitas->get('bimbingan b');
	}

	function simpan_bimbingan($data)
	{
		return $this->db_aktivitas->insert('bimbingan', $data);
	}

	function hapus_bimbingan($where)
	{
		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->delete('bimbingan');
	}

	function pembimbing($where)
	{
		$this->db->select('p.*, kk.*, nm_sdm, no_hp');
		$this->db->where($where);
		$this->db->order_by('p.pembimbing_ke ASC');
		$this->db->join($_ENV['DB_REF'].'kategori_kegiatan kk', 'kk.id_kategori_kegiatan = p.id_kategori_kegiatan');
		$this->db->join($_ENV['DB_GREAT'].'dosen d', 'd.nidn = p.nidn');
		return $this->db->get($_ENV['DB_AKT'].'pembimbing p');
	}

	function penguji($where)
	{
		$this->db->select('p.*, kk.*, nm_sdm, no_hp, k.nama_kegiatan, k.deskripsi');
		$this->db->where($where);
		$this->db->join($_ENV['DB_REF'].'kategori_kegiatan kk', 'kk.id_kategori_kegiatan = p.id_kategori_kegiatan');
		$this->db->join($_ENV['DB_GREAT'].'dosen d', 'd.nidn = p.nidn');
		$this->db->join($_ENV['DB_AKT'].'kegiatan k', 'k.id_kegiatan = p.id_kegiatan');
		$this->db->order_by('k.id_kegiatan ASC, p.penguji_ke ASC');
		return $this->db->get($_ENV['DB_AKT'].'penguji p');
	}

	function berkas_anggota($where, $order_by=null, $id_anggota)
	{
		if ($order_by) $this->db_aktivitas->order_by($order_by);
	
		$this->db_aktivitas->select('bk.*, kb.nama_kategori, kb.deskripsi, ba.*, k.deskripsi, kb.slug as slug_kategori_berkas, k.slug as slug_kegiatan');
		$this->db_aktivitas->where($where);
		$this->db_aktivitas->join('kegiatan k', 'k.id_kegiatan = bk.id_kegiatan');
		$this->db_aktivitas->join('kategori_berkas kb', 'kb.id_kat_berkas=bk.id_kat_berkas');
		$this->db_aktivitas->join('berkas_anggota ba', 'ba.id_berkas_kegiatan=bk.id_berkas_kegiatan AND ba.id_anggota = '.$this->security->xss_clean($id_anggota), 'left');
		return $this->db_aktivitas->get('berkas_kegiatan bk');
	}

	function penjadwalan($where)
	{
		$this->db->select('p.*, nm_sdm, no_hp, k.nama_kegiatan, k.deskripsi');
		$this->db->where($where);
		$this->db->join($_ENV['DB_GREAT'].'dosen d', 'd.nidn = p.nidn');
		$this->db->join($_ENV['DB_AKT'].'kegiatan k', 'k.id_kegiatan = p.id_kegiatan');
		return $this->db->get($_ENV['DB_AKT'].'penjadwalan p');
	}

	function presensi_penjadwalan($where)
	{
		$this->db->select('pp.*, nm_pd');
		$this->db->where($where);
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa_pt mp', 'mp.id_mahasiswa_pt = pp.id_user');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa m', 'm.id_mhs = mp.id_mhs');
		// $this->db->join($_ENV['DB_AKT'].'kegiatan k', 'k.id_kegiatan = p.id_kegiatan');
		return $this->db->get($_ENV['DB_AKT'].'presensi_penjadwalan pp');
	}

	function tambah_dosen($table, $data)
	{
		$insert_query = $this->db_aktivitas->insert_string($table, $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		return $this->db_aktivitas->query($insert_query);

		// return $this->db_aktivitas->replace($table, $data);
	}

	function tambah_penjadwalan($data)
	{
		$insert_query = $this->db_aktivitas->insert_string('penjadwalan', $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		return $this->db_aktivitas->query($insert_query);

		// return $this->db_aktivitas->insert('penjadwalan', $data);
	}

	function hapus_dosen($table, $where)
	{
		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->delete($table);
	}

	function hapus_penjadwalan($where)
	{
		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->delete('penjadwalan');
	}

	function status_kegiatan_anggota($data)
	{
		return $this->db_aktivitas->replace('kegiatan_anggota', $data);
	}

	function tambah_aktivitas($data)
	{
		$insert_query = $this->db_aktivitas->insert_string('aktivitas', $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		$this->db_aktivitas->query($insert_query);
		return $this->db_aktivitas->insert_id();
	}

	function tambah_anggota($data)
	{
		$insert_query = $this->db_aktivitas->insert_string('anggota', $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		return $this->db_aktivitas->query($insert_query);
	}

	function tambah_user_level($data)
	{
		$insert_query = $this->db_sso->insert_string('user_level', $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		return $this->db_sso->query($insert_query);
	}

	function update($data, $where, $table='aktivitas')
	{
		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->update($table, $data);
	}

	function update_biodata($data, $where)
	{
		$this->db->where($where);
		return $this->db->update($_ENV['DB_GREAT'].'mahasiswa', $data);
	}

	function unggah($data)
	{
		// $insert_query = $this->db_aktivitas->insert_string('berkas_anggota', $data);
		// $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		// return $this->db_aktivitas->query($insert_query);
		return $this->db_aktivitas->replace('berkas_anggota', $data);
	}

	function aktivitas_log($where, $order_by=null, $group_by=null)
	{
		if ($order_by) $this->db_aktivitas->order_by($order_by);
		if ($group_by) $this->db_aktivitas->group_by($group_by);

		$this->db_aktivitas->where($where);
		return $this->db_aktivitas->get('aktivitas_log');
	}

	function getUserIpAddr()
	{			
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){	        
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){	        
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{	     
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		return $ip;	
	}

	function add_log($whois, $data=null, $ref=null, $whatdo=null)
	{
		$this->load->library('BrowserDetection');
		$browser = new BrowserDetection();
		$data=array(
			'whois'		=> $whois,
			'id_aktivitas' => (isset($data['id_aktivitas']) ? $data['id_aktivitas'] : '0' ),
			'ref'		=> $ref ?: base_url(uri_string()),
			'data'		=> json_encode($data),
			'whatdo'	=> $whatdo ?: $this->router->method,
			'browser'	=> $browser->getName(),
			'platform'	=> $browser->getPlatformVersion(),
			'ip_address'	=> $this->getUserIpAddr(),
		);

		return $this->db_aktivitas->insert('aktivitas_log', $data);
	}
}

/* End of file Aktivitas_model.php */
/* Location: ./application/models/Aktivitas_model.php */