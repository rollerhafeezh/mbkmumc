<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biodata extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		// if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		// if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		//$this->load->model('Main_model');

        $this->load->model('Aktivitas_model');
	}

    function index()
    {
        $data['title'] = 'Biodata';
    	$data['content'] = 'biodata/index';

        $data['anggota']    = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $_SESSION['id_user'], 'as.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ], null, 'biodata')->row();
    	
		$this->load->view('template', $data);
    }

    function edit()
    {
        $data['title'] = 'Edit Data Diri';
    	$data['content'] = 'biodata/edit';

        $data['anggota']    = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $_SESSION['id_user'], 'as.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ], null, 'biodata')->row();
        $data['agama'] = $this->Main_model->ref_agama();
        $data['kecamatan'] = $this->Main_model->ref_kecamatan();

		$this->load->view('template', $data);
    }

    function update()
    {
        $data = $this->input->post(null, true);

        $update = $this->Aktivitas_model->update_biodata($data, ['id_mhs' => $_SESSION['username'] ]);
        if ($update) {
            $data['id_mhs'] = $_SESSION['username'];
            $this->Aktivitas_model->add_log($_SESSION['id_user'], $data, null, 'update_biodata');

            $this->session->set_flashdata('msg', 'Biodata berhasil diperbaharui.');
            $this->session->set_flashdata('msg_clr', 'success');
        }
        redirect('biodata');
    }

    function unggah_dokumen()
    {
        $id_mhs = $_SESSION['username'];
        $jenis_dokumen = $this->input->post('jenis_dokumen', true);
        
        if(isset($_FILES['dokumen']['name']))
        {
            $nama_dokumen = md5($jenis_dokumen.'-'.$id_mhs.'-'.date("YmdHis"));
            $simpan_file = $this->Main_model->unggah_dokumen_re($nama_dokumen,'./dokumen/mahasiswa/','jpeg|jpg|png','dokumen');
            if($simpan_file)
            {
                $nama_dokumen=base_url('dokumen/mahasiswa/'.$simpan_file['upload_data']['file_name']);
                $this->Aktivitas_model->unggah_dokumen($id_mhs,$jenis_dokumen,$nama_dokumen);
                echo $nama_dokumen.'?'.date("YmdHis");
            }else{
                echo 0;
            }
        }else{
            echo 0;
        }
    }
}