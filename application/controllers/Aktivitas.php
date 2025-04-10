<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aktivitas extends CI_Controller {

	function __construct()
	{
		parent::__construct();

        if (str_contains($this->uri->uri_string(), 'aktivitas/cetak/berita_acara') !== FALSE)
        {
            // echo 'cetak';
        } else {
    		if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
    		if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
        }

        $this->load->model('Aktivitas_model');
	}

    function index()
    {
        $data['title'] = $_ENV['MENU_NAME'];
    	$data['content'] = 'aktivitas/index';

        $data['anggota']    = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $_SESSION['id_user'], 'as.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
        $data['aktivitas']  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $data['anggota']->id_aktivitas, 'a.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
        $data['pembimbing'] = $this->Aktivitas_model->pembimbing([ 'id_aktivitas' => $data['anggota']->id_aktivitas ])->result();

		$this->load->view('template', $data);
        // $this->output->enable_profiler(TRUE);
    }

    function hapus_berkas(int $id_berkas_anggota)
    {
        $hapus = $this->Aktivitas_model->hapus_berkas_anggota([ 'id_berkas_anggota' => $id_berkas_anggota, 'id_anggota' => $_SESSION['anggota']['id_anggota'] ]);
        if ($hapus) {
            unlink('./'.substr($this->input->get('file'), strlen(base_url())));

            $this->session->set_flashdata('msg', 'Berkas berhasil dihapus.');
            $this->session->set_flashdata('msg_clr', 'success');
        }
        
        redirect('aktivitas');
    }

    function simpan()
    {
        $table = ['lokasi', 'judul', 'judul_en'];
        $data = $this->input->post(null, true);
        if (in_array(array_keys($data)[1], $table)) {
            $update = $this->Aktivitas_model->update($data, ['id_aktivitas' => $data['id_aktivitas']]);
            if ($update) {
                $this->Aktivitas_model->add_log($_SESSION['id_user'], $data, null, 'simpan_'.array_keys($data)[1]);

                $this->session->set_flashdata('msg', 'Data studi akhir berhasil diperbaharui.');
                $this->session->set_flashdata('msg_clr', 'success');
            }
        }
        redirect('aktivitas');
    }

    function cetak($filename, $kegiatan, int $id_penjadwalan=null, int $id_mahasiswa_pt=null, int $id_jenis_aktivitas_mahasiswa=null) 
    {
        $filename = xss_clean($filename);
        $kegiatan = xss_clean($kegiatan);
        $id_mahasiswa_pt = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : $id_mahasiswa_pt;
        $id_jenis_aktivitas_mahasiswa = isset($_SESSION['id_jenis_aktivitas_mahasiswa']) ? $_SESSION['id_jenis_aktivitas_mahasiswa'] : $id_jenis_aktivitas_mahasiswa;

        $kegiatan = $this->Aktivitas_model->kegiatan(['slug' => $kegiatan])->row();
        $berkas_kegiatan = $this->Aktivitas_model->berkas_kegiatan(['kb.slug' => $filename, 'bk.id_kegiatan' => $kegiatan->id_kegiatan])->row();
        $kategori_berkas = $this->Aktivitas_model->kategori_berkas(['slug' => $filename])->row();

        // if ($kategori_berkas AND $kegiatan) {
        if ($berkas_kegiatan AND $kegiatan) {
            $data['anggota']    = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $id_mahasiswa_pt, 'as.id_jenis_aktivitas_mahasiswa' => $id_jenis_aktivitas_mahasiswa ])->row();
            $data['aktivitas']  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $data['anggota']->id_aktivitas, 'a.id_jenis_aktivitas_mahasiswa' => $id_jenis_aktivitas_mahasiswa ])->row();
            $data['penguji'] = $this->Aktivitas_model->penguji([ 'id_aktivitas' => $data['anggota']->id_aktivitas, 'p.id_kegiatan' => $kegiatan->id_kegiatan ])->result();
            $data['pembimbing'] = $this->Aktivitas_model->pembimbing([ 'id_aktivitas' => $data['anggota']->id_aktivitas ])->result();
            $data['mahasiswa']  = $this->Aktivitas_model->mahasiswa([ 'mp.id_mahasiswa_pt' => $data['anggota']->id_mahasiswa_pt ])->row();
            $data['kegiatan']   = $kegiatan;

            // print_r($data); exit;
            // $this->load->view('cetak/'.$filename, $data);
            // $this->output->enable_profiler(TRUE);
            // header('Content-Type: text/html; charset=UTF-8');

            $mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'FOLIO' ]);
            $stylesheet = file_get_contents(base_url('assets/css/cetak.css'));
            $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);

            if ($filename == 'berita_acara') {
                $data['penjadwalan'] = $this->Aktivitas_model->penjadwalan([ 'id_penjadwalan' => $id_penjadwalan ])->row();
                $data['rata_rata'] = $this->Aktivitas_model->rata_rata_nilai($id_penjadwalan, $data['penjadwalan']->id_kegiatan)->row();
                $data['title'] = 'Berita Acara '.$kegiatan->deskripsi.' - '.ucwords(strtolower($data['anggota']->nm_pd));

                $berita_acara = $this->load->view('cetak/berita_acara', $data, true);
                $mpdf->writeHTML(utf8_encode($berita_acara));

                $mpdf->addPage();
                $berita_acara_nilai = $this->load->view('cetak/berita_acara_nilai', $data, true);
                $mpdf->writeHTML(utf8_encode($berita_acara_nilai));

                foreach ($data['pembimbing'] as $data['pemberi_catatan']) {
                    $mpdf->addPage();
                    $data['jenis_bimbingan'] = ['1' => 'Dosen Pembimbing'];
                    $berita_acara_catatan = $this->load->view('cetak/berita_acara_catatan', $data, true);
                    $mpdf->writeHTML(utf8_encode($berita_acara_catatan));
                }

                foreach ($data['penguji'] as $data['pemberi_catatan']) {
                    $mpdf->addPage();
                    $data['jenis_bimbingan'] = ['2' => 'Dosen Penguji'];
                    $berita_acara_catatan = $this->load->view('cetak/berita_acara_catatan', $data, true);
                    $mpdf->writeHTML(utf8_encode($berita_acara_catatan));
                }

                $mpdf->addPage();
                $data['pemberi_catatan'] = $data['penjadwalan'];
                $data['jenis_bimbingan'] = ['3' => 'Ketua Sidang'];
                $berita_acara_catatan = $this->load->view('cetak/berita_acara_catatan', $data, true);
                $mpdf->writeHTML(utf8_encode($berita_acara_catatan));

                $mpdf->addPage();
                $berita_acara_peserta = $this->load->view('cetak/berita_acara_peserta', $data, true);
                $mpdf->writeHTML(utf8_encode($berita_acara_peserta));
            } else {
                $data['title'] = $kategori_berkas->nama_kategori.' '.$kegiatan->nama_kegiatan.' - '.ucwords(strtolower($data['anggota']->nm_pd));
                $html = $this->load->view('cetak/'.$filename, $data, true);
                $mpdf->writeHTML(utf8_encode($html));
            }
            

            $mpdf->output($data['title'].'.pdf', 'I');
        }
    }

    function unggah($berkas, $kegiatan)
    {
        $berkas = xss_clean($berkas);
        $kegiatan = xss_clean($kegiatan);

        $kegiatan = $this->Aktivitas_model->kegiatan(['slug' => $kegiatan])->row();
        $berkas_kegiatan = $this->Aktivitas_model->berkas_kegiatan(['kb.slug' => $berkas, 'bk.id_kegiatan' => $kegiatan->id_kegiatan])->row();
        
        if ($berkas_kegiatan AND $kegiatan) {
            $data['kegiatan']   = $kegiatan;
            $data['berkas_kegiatan']   = $berkas_kegiatan;
    
            $data['title'] = 'Unggah '.$berkas_kegiatan->nama_kategori;
            $data['content'] = 'aktivitas/unggah';

            $data['anggota']    = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $_SESSION['id_user'], 'as.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
            $data['aktivitas']  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $data['anggota']->id_aktivitas, 'a.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();

            $this->load->view('template', $data);
        }
    }

    function unggah_berkas($berkas, $kegiatan)
    {
        $berkas = xss_clean($berkas);
        $kegiatan = xss_clean($kegiatan);

        $kegiatan = $this->Aktivitas_model->kegiatan(['slug' => $kegiatan])->row();
        $berkas_kegiatan = $this->Aktivitas_model->berkas_kegiatan(['kb.slug' => $berkas, 'bk.id_kegiatan' => $kegiatan->id_kegiatan ])->row();

        if ($berkas_kegiatan AND $kegiatan) {
            $data = $this->input->post(null, true);

            $anggota    = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $_SESSION['id_user'], 'as.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
            $aktivitas  = $this->Aktivitas_model->aktivitas([ 'a.id_aktivitas' => $anggota->id_aktivitas, 'a.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
            $pembimbing = $this->Aktivitas_model->pembimbing([ 'id_aktivitas' => $anggota->id_aktivitas ])->result();

            $filename  = $anggota->id_mahasiswa_pt.'_'.$anggota->nm_pd.'_'.$berkas_kegiatan->nama_kategori.'_'.$kegiatan->nama_kegiatan.'.pdf';

            $config['upload_path']          = './dokumen/aktivitas';
            $config['allowed_types']        = 'pdf';
            $config['file_name']            = $filename;
            $config['overwrite']            = true;
            $config['max_size']             = 10240; // 1MB

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('berkas')) {
                $param = [
                    'id_berkas_kegiatan' => $berkas_kegiatan->id_berkas_kegiatan,
                    'id_anggota' => $anggota->id_anggota,
                    'berkas' => base_url('dokumen/aktivitas/'.$this->upload->data("file_name")),
                    'upload_by' => $_SESSION['id_user']
                ];

                $this->Aktivitas_model->unggah($param);

                $this->session->set_flashdata('msg', 'Berkas '.$berkas_kegiatan->nama_kategori.' berhasil diunggah.');
                $this->session->set_flashdata('msg_clr', 'success');
                redirect('aktivitas','refresh');
            } else {
                echo $this->upload->display_errors();
            }
        }
    }
}