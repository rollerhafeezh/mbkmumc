<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbkm_data_model extends CI_Model {
    
    var $column_order = array(null, 'nama_jenis_aktivitas_mahasiswa', 'nama_prodi', 'nama_merek', 'tgl_mulai', 'kuota', 'tgl_mulai_daftar');
    var $column_search = array('nama_jenis_aktivitas_mahasiswa', 'nama_prodi', 'nama_resmi', 'nama_merek', 'm.alamat', 'keterangan', 'tgl_mulai', 'tgl_selesai');
    var $order = array('pm.created_at' => 'desc');
	
	function __construct()
	{
		parent::__construct();
	}
	
	 private function _get_datatables_query()
    {
		$this->db->select('pm.*, nama_jenis_aktivitas_mahasiswa, nama_prodi, nama_resmi, nama_merek, keterangan, nama_semester, m.alamat, nama_program, nama_jenis_program');

		$this->db->from($_ENV['DB_MBKM'].'program_mitra pm');
        $this->db->join($_ENV['DB_MBKM'].'program pg','pg.id_program = pm.id_program');
        $this->db->join($_ENV['DB_MBKM'].'mitra m','m.id_mitra = pm.id_mitra');
        $this->db->join($_ENV['DB_REF'].'prodi p','p.kode_prodi = pm.kode_prodi');
        $this->db->join($_ENV['DB_REF'].'semester s','s.id_semester = pm.id_smt');

        $this->db->join($_ENV['DB_REF'].'fakultas f','f.kode_fak = p.kode_fak');
		$this->db->join($_ENV['DB_REF'].'jenjang_pendidikan jp','jp.id_jenj_didik = p.id_jenjang_pendidikan');
        $this->db->join($_ENV['DB_REF'].'jenis_aktivitas_mahasiswa j','j.id_jenis_aktivitas_mahasiswa = pg.id_jenis_aktivitas_mahasiswa');
        $this->db->join($_ENV['DB_REF'].'jenis_program_mbkm jpm','jpm.id_jenis_program_mbkm = pm.jenis_program');

        $this->db->where('pm.status', '1');
        
        if($this->input->get('kode_prodi')!='0') $this->db->where('pm.kode_prodi',$this->input->get('kode_prodi'));
        if($this->input->get('id_smt')!='0') $this->db->where('pm.id_smt',$this->input->get('id_smt'));
        if($this->input->get('id_program')!='0') $this->db->where('pm.id_program',$this->input->get('id_program'));

        $i = 0;
     
        foreach ($this->column_search as $item) 
        {
            if($_GET['search']['value']) 
            {
                 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_GET['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_GET['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_GET['order'])) 
        {
            $this->db->order_by($this->column_order[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_GET['length'] != -1)
        $this->db->limit($_GET['length'], $_GET['start']);
        $query = $this->db->get();
        // print_r($this->db->last_query());    
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
		$this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
        //$this->db->from($this->table);
        //return $this->db->count_all_results();
    }
}