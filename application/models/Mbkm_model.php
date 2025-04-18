<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbkm_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function updateOrInsert($table, $data, $where)
    {
        // Cek apakah data sudah ada berdasarkan kondisi $where
        $query = $this->db->get_where($table, $where);
        
        if ($query->num_rows() > 0) {
            // Jika data ada, lakukan update
            $this->db->where($where);
            $update = $this->db->update($table, $data);
            return 'update';
        } else {
            // Jika data tidak ada, lakukan insert
            $this->db->insert($table, $data);
            return $this->db->insert_id();
        }
    }


	public function satuan_pendidikan($searchTerm) {
        $this->db->select('*');
        $this->db->like('nm_lemb', $searchTerm);
        $this->db->limit(5);
        $query = $this->db->get($_ENV['DB_REF'].'satuan_pendidikan'); // Ganti dengan nama tabel sesuai database
        
        return $query->result();
    }

	function delete($table, $where)
	{
		$this->db->where($where);
		return $this->db->delete($table);
	}

	function insert_ignore($table, $data)
	{
		$insert_query = $this->db->insert_string($table, $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO', $insert_query);
		return $this->db->query($insert_query);
	}

	function insert_ignore_v2($table, $data, $insert_id = false)
	{
	    $insert_query = $this->db->insert_string($table, $data);
	    $insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);

	    if ($this->db->query($insert_query)) {
	        if ($insert_id) {
	            return $this->db->insert_id(); // Mengembalikan ID dari data yang baru di-insert
	        } else {
	            return true; // Mengembalikan true jika query berhasil
	        }
	    } else {
	        return false; // Mengembalikan false jika query gagal
	    }
	}

	function insert($table, $data, $insert_id = false)
	{
		if ($insert_id) {
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		} else {
			return $this->db->insert($table, $data);
		}
	}

	function update($table, $where, $data)
	{
		$this->db->where($where);
		return $this->db->update($table, $data);
	}

	function get($table, $where = null, $order_by = null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($where) $this->db->where($where);

		return $this->db->get($table);
	}

	function matkul_program($id_program_mitra)
	{
		$this->db->select('*');

        $this->db->from($_ENV['DB_MBKM'].'matkul_program_mitra mpm');
        $this->db->join($_ENV['DB_MBKM'].'program_mitra pm','pm.id_program_mitra = mpm.id_program_mitra');
        $this->db->join($_ENV['DB_GREAT'].'mata_kuliah mk','mk.id_matkul = mpm.id_matkul');
        $this->db->join($_ENV['DB_GREAT'].'mata_kuliah_kurikulum mkk','mkk.id_matkul = mpm.id_matkul');

        $this->db->where('sha1(mpm.id_program_mitra)', $id_program_mitra);

        return $this->db->get();
	}

	function program_mbkm($where=null, $order_by=null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($where) $this->db->where($where);

		$this->db->select('*');
		$this->db->join($_ENV['DB_MBKM'].'program p', 'p.id_jenis_aktivitas_mahasiswa = j.id_jenis_aktivitas_mahasiswa', 'left');
		return $this->db->get($_ENV['DB_REF'].'jenis_aktivitas_mahasiswa j');
	}

	function program($where=null, $order_by=null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($where) $this->db->where($where);

		$this->db->select('*');
		return $this->db->get($_ENV['DB_REF'].'jenis_aktivitas_mahasiswa j');
	}

	function mitra($where=null, $order_by=null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($where) $this->db->where($where);

		$this->db->select('*');
		return $this->db->get($_ENV['DB_MBKM'].'mitra m');
	}

	function pertanyaan_umum($where=null, $order_by=null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($where) $this->db->where($where);

		$this->db->select('*');
		return $this->db->get($_ENV['DB_MBKM'].'pertanyaan_umum p');
	}

	function berita($where=null, $order_by=null)
	{
		if ($order_by) $this->db->order_by($order_by);
		if ($where) $this->db->where($where);

		$this->db->select('*');
		return $this->db->get($_ENV['DB_MBKM'].'berita b');
	}

}

/* End of file Mbkm_model.php */
/* Location: ./application/models/Mbkm_model.php */