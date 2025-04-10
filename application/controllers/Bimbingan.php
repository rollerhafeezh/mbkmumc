<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bimbingan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		//$this->load->model('Main_model');
        $this->load->model('Aktivitas_model');
	}

    function cetak(int $jenis_bimbingan) 
    {
        $data['anggota']    = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $_SESSION['id_user'], 'as.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
        $data['aktivitas']  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $data['anggota']->id_aktivitas, 'a.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
        $data['pembimbing'] = $this->Aktivitas_model->pembimbing([ 'id_aktivitas' => $data['anggota']->id_aktivitas ])->result();

        $data['mahasiswa']  = $this->Aktivitas_model->mahasiswa([ 'm.id_mhs' => $data['anggota']->id_mhs ])->row();
        $data['bimbingan']  = $this->Aktivitas_model->bimbingan([ 'b.id_aktivitas' => $data['anggota']->id_aktivitas, 'b.jenis_bimbingan' => $jenis_bimbingan, 'b.level_name' => 'Dosen', 'b.id_parent' => '0' ], 'b.created_at desc')->result();

        $arr_jenis_bimbingan = ['-', 'Dosen Pembimbing', 'Dosen Penguji', 'Ketua Sidang'];
        $data['title'] = 'Laporan Kemajuan '.$arr_jenis_bimbingan[$jenis_bimbingan].' - '.ucwords(strtolower($data['anggota']->nm_pd));

        $mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'FOLIO' ]);
        $html = $this->load->view('cetak/laporan_kemajuan', $data, true);
        $stylesheet = file_get_contents(base_url('assets/css/cetak.css'));
        $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->writeHTML(utf8_encode($html));

        $mpdf->output($data['title'].'.pdf', 'I');
    }

    function bimbingan(int $jenis_bimbingan)
    {
        $data['anggota']    = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $_SESSION['id_user'], 'as.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
        $data['aktivitas']  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $data['anggota']->id_aktivitas, 'a.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
        $data['bimbingan']  = $this->Aktivitas_model->bimbingan([ 'b.id_aktivitas' => $data['anggota']->id_aktivitas, 'b.jenis_bimbingan' => $jenis_bimbingan, 'b.level_name' => 'Dosen', 'b.id_parent' => '0' ], 'b.created_at desc')->result();

        $this->load->view('bimbingan/bimbingan', $data);
    }

    function sse()
    {
        header("Content-Type: text/event-stream");
        header("Cache-Control: no-cache");
        header("Connection: keep-alive");

        $time = date('r');
        echo "data: The server time is: {$time}\n\n";
        ob_end_flush();
        flush();
    }

    public function kirim()
    {
        $data = $this->input->post(null, true);
        $data['id_user'] = $_SESSION['id_user'];
        $data['nama_user'] = ucwords(strtolower($_SESSION['nama_pengguna']));
        $data['level_name'] = ucwords(strtolower($_SESSION['level_name']));

        if($_FILES)  {
            $config['upload_path']          = './dokumen/bimbingan/';
            $config['allowed_types']        = 'pdf|doc|docx|ppt|pptx|jpg|png|gif';
            $config['overwrite']            = true;
            $config['max_size']             = 5000; // 1MB

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('file')) {
                $data['file'] = base_url('dokumen/bimbingan/'.$this->upload->data('file_name'));
            } else {
                echo strip_tags($this->upload->display_errors()).' (max. uploaded size: 5 MB, allowed filetypes: .pdf, .doc, .docx, .ppt, .pptx, .jpg, .png, .gif)';
                exit;
            }
        }

        $bimbingan = $this->Aktivitas_model->simpan_bimbingan($data);
        // print_r($data);
    }

    function hapus()
    {
        if ($this->input->post('file') != '') {
            $file = explode('/', $this->input->post('file'));
            unlink('./dokumen/bimbingan/'.$file[5]);
        }

        $bimbingan = $this->Aktivitas_model->hapus_bimbingan([ 'id_bimbingan' => $this->input->post('id_bimbingan'), 'id_user' => $_SESSION['id_user'] ]);
        print_r($bimbingan);
    }

    function dosen_pembimbing()
    {
        $data['title'] = 'Dosen Pembimbing';
    	$data['content'] = 'bimbingan/dosen_pembimbing';

        $data['anggota']    = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $_SESSION['id_user'], 'as.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
        $data['aktivitas']  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $data['anggota']->id_aktivitas, 'a.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
        $data['pembimbing'] = $this->Aktivitas_model->pembimbing([ 'id_aktivitas' => $data['anggota']->id_aktivitas ])->result();
        $data['jenis_bimbingan'] = 1;

		$this->load->view('template', $data);
    }

    function dosen_penguji()
    {
        $data['title'] = 'Dosen Penguji';
        $data['content'] = 'bimbingan/dosen_penguji';

        $data['anggota']    = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $_SESSION['id_user'], 'as.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
        $data['aktivitas']  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $data['anggota']->id_aktivitas, 'a.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
        $data['penguji'] = $this->Aktivitas_model->penguji([ 'id_aktivitas' => $data['anggota']->id_aktivitas ])->result();
        $data['jenis_bimbingan'] = 2;

        $this->load->view('template', $data);
        // $this->output->enable_profiler(TRUE);
    }

    function ketua_sidang()
    {
        $data['title'] = 'Ketua Sidang';
        $data['content'] = 'bimbingan/ketua_sidang';

        $data['anggota']    = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $_SESSION['id_user'], 'as.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
        $data['aktivitas']  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $data['anggota']->id_aktivitas, 'a.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
        
        $data['penjadwalan'] = $this->Aktivitas_model->penjadwalan([ 'id_aktivitas' => $data['anggota']->id_aktivitas ])->result();
        $data['penguji'] = $this->Aktivitas_model->penguji([ 'id_aktivitas' => $data['anggota']->id_aktivitas ])->result();
        $data['pembimbing'] = $this->Aktivitas_model->pembimbing([ 'id_aktivitas' => $data['anggota']->id_aktivitas ])->result();
        
        $data['jenis_bimbingan'] = 3;

        $this->load->view('template', $data);
    }
}