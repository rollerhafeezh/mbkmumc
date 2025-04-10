<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dasbor extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('Mbkm_model');
	}

    function index()
    {
        $this->load->model('Main_model');

        $url = $this->input->get('redirect', true);
        if ($url) redirect($url);
        
        $data['berita']     = $this->Mbkm_model->berita(['aktif' => '1']);
        $data['pertanyaan_umum'] = $this->Mbkm_model->pertanyaan_umum(['aktif' => '1']);
        $data['mitra']      = $this->Mbkm_model->mitra(['aktif' => '1']);
        
        $data['prodi']      = $this->Main_model->ref_prodi();
        $data['semester']   = $this->Main_model->ref_smt();
        $data['program']    = $this->Mbkm_model->program_mbkm(['aktif' => '1']);

    	$data['title']      = 'Beranda';
    	$data['content']    = 'dasbor/index';

		$this->load->view('template', $data);
    }

    function detail_kegiatan()
    {
        $id = $this->input->post('id_program_mitra', true);
        $data['detail'] = $this->Mbkm_model->get($_ENV['DB_MBKM'].'program_mitra', [ 'sha1(id_program_mitra)' => $id ])->row();
        $data['matkul_program'] = $this->Mbkm_model->matkul_program($id);
        // print_r($data['matkul_program']);
        $this->load->view('dasbor/detail_kegiatan', $data);
    }

    function json_matkul_program()
    {
        $this->load->model('Matkul_program_data_model');
        $list = $this->Matkul_program_data_model->get_datatables();

        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $no.'.';
            $row[] = $field->kode_mk;
            $row[] = $field->nm_mk;
            $row[] = $field->smt;
            $row[] = $field->sks_mk;

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Matkul_program_data_model->count_all(),
            "recordsFiltered" => $this->Matkul_program_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
    }

    function json()
    {
        $this->load->model('Mbkm_data_model');
        
        $list = $this->Mbkm_data_model->get_datatables();

        $data = array();
        $no = $_GET['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            
            $row[] = $no.'.';
            $row[] = $field->nama_jenis_aktivitas_mahasiswa.' '.$field->nama_program.' ('.$field->nama_jenis_program.')';
            $row[] = $field->nama_prodi;
            $row[] = '<h6 class="m-0 p-0">'.$field->nama_merek.'</h6>'.$field->alamat.'<br><a href="javascript:void(0)" onclick="detail_kegiatan(`'.sha1($field->id_program_mitra).'`)">Lihat Selengkapnya &raquo</a>';

            $tahun = date('Y', strtotime($field->tgl_mulai)) == date('Y', strtotime($field->tgl_selesai)) ? 1 : null;
            $row[] = '<h6 class="m-0 p-0">'.$field->nama_semester.'</h6>'.tanggal_indo($field->tgl_mulai, 1, $tahun).' - '.tanggal_indo($field->tgl_selesai, 1);

            $row[] = ($field->peserta == $field->kuota ? '<span class="badge bg-danger">Penuh</span>' : '<span data-toggle="tooltip" title="Kuota Tersedia" class="badge bg-secondary">'.$field->peserta.' / '.$field->kuota.'</span>');
            $row[] = (date('Y-m-d') >= date('Y-m-d', strtotime($field->tgl_mulai_daftar))) && (date('Y-m-d') <= date('Y-m-d', strtotime($field->tgl_selesai_daftar))) ? '<span class="badge bg-secondary">Dibuka</span>' : '<span class="badge bg-danger">Ditutup</span>';

            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->Mbkm_data_model->count_all(),
            "recordsFiltered" => $this->Mbkm_data_model->count_filtered(),
            "data" => $data,
        );
        
        echo json_encode($output);
    }

    function redirect()
    {
        $url = $this->input->get('redirect', true);
        redirect($url);
    }
}