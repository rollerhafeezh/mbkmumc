<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function unggah_dokumen_re($nama_dokumen,$nama_folder,$tipe=null,$dokumen)
	{
		/*upload lib and process */
		$config['file_name'] 	= $nama_dokumen;
		$config['upload_path'] 	= $nama_folder;
		if($tipe) $config['allowed_types'] = $tipe;
		$config['file_ext_tolower'] = TRUE;
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = TRUE;
		
		$this->load->library('upload',$config);
		
		if ( !$this->upload->do_upload($dokumen))
		{
			$hasil = array('error' => $this->upload->display_errors());
		}else{
			$hasil = array('upload_data' => $this->upload->data());
		}
		return $hasil;
	}
	
	function get_dosen()
    {
        $nm_sdm= $this->input->get('nm_sdm');
        $id_dosen= $this->input->get('nm_sdm');
		
		if($id_dosen)
		{
			$this->db->where_not_in('a.id_dosen',$id_dosen);
		}

        if($nm_sdm)
        {
            $this->db->like('a.nm_sdm',$nm_sdm);
        }

        $this->db->select('a.nm_sdm,a.nidn,a.id_dosen');
        return $this->db->get($_ENV['DB_GREAT'].'dosen a')->result();
    }
	
	function count_sks_dosen($id_dosen,$id_smt)
	{
		return $this->db->select('sum(sks_subst_tot) as total_sks')->where('id_dosen',$id_dosen)->where('id_smt',$id_smt)->get('ajar_dosen')->row()->total_sks;
	}
	
	function conf_maks_sks_dosen()
	{
		return $this->db->select('value_konfigurasi')->where('nama_konfigurasi','maks_sks_dosen')->get('konfigurasi')->row()->value_konfigurasi;
	}
	
	function check_maks_sks_dosen($id_dosen,$id_smt,$sks_baru)
	{
		$maks_sks = $this->conf_maks_sks_dosen();
		$sks = $this->db->select('sum(sks_subst_tot) as total_sks')->where('id_dosen',$id_dosen)->where('id_smt',$id_smt)->get('ajar_dosen')->row()->total_sks;
		$total_sks = $sks_baru + $sks;
		if($total_sks > $maks_sks) return false; else return true;
	}
	
	function get_log_akademik()
	{
		$this->db->order_by('whenat','desc');
		$this->db->limit(1000);
		return $this->db->get('akademik_log');
	}
	
	function simpan_konfigurasi($nama_konfigurasi,$value_konfigurasi)
	{
		$this->db->where('nama_konfigurasi',$nama_konfigurasi);
		$this->db->set('value_konfigurasi',$value_konfigurasi);
		return $this->db->update('konfigurasi');
	}
	
	function get_konfigurasi($nama_konfigurasi=null)
	{
		if($nama_konfigurasi)
		{
			$this->db->where('nama_konfigurasi',$nama_konfigurasi);
		}
		return $this->db->get('konfigurasi');
	}
	
	function check_kuliah_mahasiswa($id_mahasiswa_pt,$id_smt)
	{
		$smt = $this->get_mulai_smt($id_mahasiswa_pt);
		
		if($smt->mulai_smt <= $id_smt)
		{
			$check = $this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt)->where('id_smt',$id_smt)->get('kuliah_mahasiswa')->row();
			if(!$check)
			{
				$data=['id_mahasiswa_pt'=>$id_mahasiswa_pt,'id_smt'=>$id_smt,'smt_mhs'=>$this->smt_mhs($smt->mulai_smt,$smt->diterima_smt,$id_smt)];
				$this->db->insert('kuliah_mahasiswa',$data);
			}
		}
	}
	
	function get_mhs_kelas($id_kelas_kuliah=null)
	{
		if($id_kelas_kuliah)
		{
			$this->db->where('a.id_kelas_kuliah',$id_kelas_kuliah);
		}
		$this->db->select('a.id_nilai,a.id_kelas_kuliah,a.id_krs,c.nm_pd,b.id_mahasiswa_pt,a.nilai_huruf');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa_pt b','a.id_mahasiswa_pt=b.id_mahasiswa_pt');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa c','c.id_mhs=b.id_mhs');
		//$this->db->join($_ENV['DB_REF'].'prodi p','b.kode_prodi=p.kode_prodi');
		//$this->db->join($_ENV['DB_REF'].'fakultas f','f.kode_fak=p.kode_fak');
		$this->db->order_by('c.nm_pd','asc');
		return $this->db->get($_ENV['DB_GREAT'].'nilai a');
	}
	
	function get_mhs_krs($id_kelas_kuliah=null)
	{
		if($id_kelas_kuliah)
		{
			$this->db->where('a.id_kelas_kuliah',$id_kelas_kuliah);
		}
		$this->db->select('a.id_krs,a.id_kelas_kuliah,a.id_krs,c.nm_pd,b.id_mahasiswa_pt,a.status_krs');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa_pt b','a.id_mahasiswa_pt=b.id_mahasiswa_pt');
		$this->db->join($_ENV['DB_GREAT'].'mahasiswa c','c.id_mhs=b.id_mhs');
		//$this->db->join($_ENV['DB_REF'].'prodi p','b.kode_prodi=p.kode_prodi');
		//$this->db->join($_ENV['DB_REF'].'fakultas f','f.kode_fak=p.kode_fak');
		$this->db->order_by('c.nm_pd','asc');
		return $this->db->get($_ENV['DB_GREAT'].'krs a');
	}
	
	function get_mulai_smt($id_mahasiswa_pt)
	{
		return $this->db->select('mulai_smt,diterima_smt')->where('id_mahasiswa_pt',$id_mahasiswa_pt)->get('mahasiswa_pt')->row();
	}
	
	function pengampu_kelas_kosong($id_kelas_kuliah=null,$id_ajar_dosen=null,$id_dosen=null)
	{
		if($id_kelas_kuliah)
		{
			$this->db->where('a.id_kelas_kuliah',$id_kelas_kuliah);
		}
		if($id_dosen)
		{
			$this->db->where('a.id_dosen',$id_dosen);
		}
		if($id_ajar_dosen)
		{
			$this->db->where('a.id_ajar_dosen',$id_ajar_dosen);
		}
		return $this->db->get($_ENV['DB_GREAT'].'ajar_dosen a');
	}
	
	function pengampu_kelas($id_kelas_kuliah=null,$id_ajar_dosen=null)
	{
		if($id_ajar_dosen)
		{
			$this->db->where('a.id_ajar_dosen',$id_ajar_dosen);
		}
		if($id_kelas_kuliah)
		{
			$this->db->where('a.id_kelas_kuliah',$id_kelas_kuliah);
		}
		$this->db->select('b.nm_sdm,b.nidn,a.id_dosen,a.sks_subst_tot,a.id_ajar_dosen,a.id_kelas_kuliah');
		$this->db->join($_ENV['DB_GREAT'].'dosen b','a.id_dosen=b.id_dosen');
		return $this->db->get($_ENV['DB_GREAT'].'ajar_dosen a');
	}
	
	function cek_ips($id_smt,$id_mahasiswa_pt)
	{
		$this->db->select('ips');
		$this->db->where('id_smt',$id_smt);
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		return $this->db->get($_ENV['DB_GREAT'].'kuliah_mahasiswa');
	}
	
	function krs_note($id_smt,$id_mahasiswa_pt)
	{
		$this->db->where('id_smt',$id_smt);
		$this->db->where('id_mahasiswa_pt',$id_mahasiswa_pt);
		return $this->db->get($_ENV['DB_GREAT'].'krs_note');
	}
	
	function get_mata_kuliah($id_matkul=null)
	{
		if($id_matkul)
		{
			$this->db->where('a.id_matkul',$id_matkul);
		}
		$this->db->join($_ENV['DB_REF'].'prodi b','a.kode_prodi=b.kode_prodi');
		$this->db->join($_ENV['DB_REF'].'fakultas c','c.kode_fak=b.kode_fak');
		return $this->db->get($_ENV['DB_GREAT'].'mata_kuliah a');
	}
	
	function unggah_dokumen($nama_dokumen,$nama_folder,$tipe=null,$dokumen)
	{
		/*upload lib and process */
		$config['file_name'] 	= $nama_dokumen.'-'.date('YmdHis');
		$config['upload_path'] 	= $nama_folder;
		if($tipe) $config['allowed_types'] = $tipe;
		$config['file_ext_tolower'] = TRUE;
		$config['remove_spaces'] = TRUE;
		$config['overwrite'] = TRUE;
		
		$this->load->library('upload',$config);
		
		if ( !$this->upload->do_upload($dokumen))
		{
			$hasil = array('error' => $this->upload->display_errors());
		}else{
			$hasil = array('upload_data' => $this->upload->data());
		}
		return $hasil;
	}

	function ref_kecamatan()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/kecamatan'));
	}

	function ref_agama()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/agama'));
	}
	
	function ref_jenis_mk()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/jenis_mk'));
	}

	function ref_kategori_mk()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/kategori_mk'));
	}

	function ref_kategori_kegiatan()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/kategori_kegiatan'));
	}

	function ref_kegiatan()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/kegiatan'));
	}
	
	function ref_tahun_ajaran()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/tahun_ajaran'));
	}
	
	function ref_status_mahasiswa()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/status_mahasiswa'));
	}
	
	function ref_jenis_keluar()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/jenis_keluar'));
	}
	
	function ref_smt($where = null, $order_by = 'id_semester DESC')
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($where) $this->db->where($where);
		
		$this->db->limit(10);
		$this->db->where_in('semester', ['1', '2']);
        return $this->db->get($_ENV['DB_REF'].'semester')->result();
		// return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/smt'));
	}

	function ref_jenis_aktivitas_mahasiswa()
	{
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/jenis_aktivitas_mahasiswa'));
	}
	
	function ref_fakultas($kode_fak=null)
	{
		$query='';
		if($kode_fak || $kode_fak !=0)
		{
			$query.='?kode_fak='.$kode_fak;
		}
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/fakultas'.$query));
	}
	
	function ref_prodi($kode_fak=null,$kode_prodi=null)
	{
		$query='';
		if($kode_fak && $kode_prodi)
		{
			$query.='?kode_fak='.$kode_fak.'&$kode_prodi='.$kode_prodi;
		}else if($kode_fak)
		{
			$query.='?kode_fak='.$kode_fak;
		}else if($kode_prodi)
		{
			$query.='?kode_prodi='.$kode_prodi;
		}
		return json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/prodi'.$query));
	}
	
	public function akademik_log($whythis,$whatdo)
	{
		$data=array(
			'whois'		=> $_SESSION['username'],
			'whythis'	=> $whythis,
			'whatdo'	=> $whatdo,
			'wherefrom'	=> $this->getUserIpAddr()
		);				
		return $this->db->insert('akademik_log',$data);
	}
	
	
	function post_api($url,$data)
	{
		$this->curl->http_header('token',$_SESSION['api_token']);
		$this->curl->http_header('bearer','SIMAK');
		return json_decode($this->curl->simple_post($_ENV['API_LINK'].$url,$data));
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
	
	private function smt_mhs($mulai_smt,$diterima_smt,$smt_count)
	{
		
			/*semester berjalan genap / gajil/ pendek*/
			$smt=str_split($smt_count);
			if($smt[4]==3){
				$smt_mhs=0;
			}else{
				$diff_smt=$smt_count-$mulai_smt;
				switch($diff_smt){
					case 0 		: $smt_mhs=$diterima_smt+0; 	break;
					case 1 		: $smt_mhs=$diterima_smt+1; 	break;
					case 9 		: $smt_mhs=$diterima_smt+1; 	break;
					case 10 	: $smt_mhs=$diterima_smt+2; 	break;
					case 11 	: $smt_mhs=$diterima_smt+3; 	break;
					case 19 	: $smt_mhs=$diterima_smt+3; 	break;
					case 20 	: $smt_mhs=$diterima_smt+4; 	break;
					case 21 	: $smt_mhs=$diterima_smt+5; 	break;
					case 29 	: $smt_mhs=$diterima_smt+5; 	break;
					case 30 	: $smt_mhs=$diterima_smt+6; 	break;
					case 31 	: $smt_mhs=$diterima_smt+7; 	break;
					case 39 	: $smt_mhs=$diterima_smt+7; 	break;
					case 40 	: $smt_mhs=$diterima_smt+8; 	break;
					case 41 	: $smt_mhs=$diterima_smt+9; 	break;
					case 49 	: $smt_mhs=$diterima_smt+9; 	break;
					case 50 	: $smt_mhs=$diterima_smt+10; 	break;
					case 51 	: $smt_mhs=$diterima_smt+11; 	break;
					case 59 	: $smt_mhs=$diterima_smt+11; 	break;
					case 60 	: $smt_mhs=$diterima_smt+12; 	break;
					case 61 	: $smt_mhs=$diterima_smt+13; 	break;
					case 69 	: $smt_mhs=$diterima_smt+13; 	break;
					case 70 	: $smt_mhs=$diterima_smt+14; 	break;
					case 71 	: $smt_mhs=$diterima_smt+15; 	break;
					case 79 	: $smt_mhs=$diterima_smt+15; 	break;
					case 80 	: $smt_mhs=$diterima_smt+16; 	break;
					case 81 	: $smt_mhs=$diterima_smt+17; 	break;
					case 89 	: $smt_mhs=$diterima_smt+17; 	break;
					case 90 	: $smt_mhs=$diterima_smt+18; 	break;
					default		: $smt_mhs=0; break;
				}
			}
		return $smt_mhs;
	}
}