<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		// if(!isset($_SESSION['logged_in'])){redirect(base_url('logout'));}
		// if($_SESSION['logged_in']==FALSE){ redirect (base_url('logout'));}
		
		$this->load->model('Mbkm_model');
	}

    function detail($slug = '')
    {
        $berita = $this->Mbkm_model->berita(['slug' => $slug])->row();
        $data['berita'] = $berita;

    	$data['title'] = $berita->judul;
    	$data['content'] = 'berita/detail';

		$this->load->view('template', $data);
    }

    function tags($tags = '')
    {
        if ($tags != '') {
            $berita = $this->Mbkm_model->berita(['aktif' => '1', 'tags REGEXP' => $tags]);
            $data['berita'] = $berita;

            $data['title'] = $tags;
            $data['content'] = 'berita/tags';

            $this->load->view('template', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    function redirect()
    {
        $url = $this->input->get('redirect', true);
        redirect($url);
    }
}