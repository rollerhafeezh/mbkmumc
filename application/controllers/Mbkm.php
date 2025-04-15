<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbkm extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('Mbkm_model');
	}

    function index()
    {
    	$data['title'] = 'Kampus Merdeka';
    	$data['content'] = 'mbkm/index';

		$this->load->view('template', $data);
    }

    function kirim_email($email, $subject, $data = [])
    {
        $mail_server    = $this->Mbkm_model->get($_ENV['DB_PMB'].'mail_server', array('is_active' => 'Y'))->row();

        $config = Array(
        'protocol' => $mail_server->driver,
        'smtp_host' => $mail_server->host,
        'smtp_port' => $mail_server->port,
        'smtp_user' => $mail_server->username,
        'smtp_pass' => $mail_server->password,
        'mailtype'  => $mail_server->mailtype, 
        'charset'   => $mail_server->charset,
        'smtp_crypto'   => $mail_server->encryption
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

        $this->email->from($mail_server->username, "Universitas Muhammdiyah Cirebon");
        $this->email->to($email);
        $this->email->subject($subject);
        
        $mesg       = $this->load->view('mbkm/email', $data, true);
        $this->email->message($mesg);

        // $mail = $this->email->send();
        if (!$this->email->send()) {
            // Menampilkan error jika pengiriman email gagal
            echo "Error saat mengirim email: ";
            echo $this->email->print_debugger();
            return false;
        } else {
            return true;
        }

    }

    function registrasi()
    {
        $data['title'] = 'Registrasi Mahasiswa Kampus Merdeka';
        $data['content'] = 'mbkm/registrasi';

        $this->load->view('template', $data);
    }

    function satuan_pendidikan() {
        // Mendapatkan parameter pencarian dari request
        $searchTerm = $this->input->get('q');

        // Ambil data berdasarkan pencarian dari model
        $data = $this->Mbkm_model->satuan_pendidikan($searchTerm);

        // Format data untuk Select2
        $result = array();
        foreach ($data as $item) {
            $result[] = array(
                'id' => $item->id_sp,
                'text' => $item->nm_lemb
            );
        }

        // Kembalikan data dalam format JSON
        echo json_encode(array('data' => $result));
    }


    function verifikasi($nim)
    {
        $nim = substr_replace($nim, '', 5, 1);

        $user_main = $this->Mbkm_model->get($_ENV['DB_SSO'].'user_main', [ 'sha1(username)' => $nim ]);
        $mahasiswa_pt = $this->Mbkm_model->get($_ENV['DB_MBKM'].'mahasiswa_pt', [ 'sha1(id_mahasiswa_pt)' => $nim ]);

        // print_r($user_main->row()); exit;

        # jika belum ada user dan mahasiswa pt ada
        if($user_main->num_rows() > 0 AND $mahasiswa_pt->num_rows() > 0) {
            $data_user_level = [
                'id_level' => '96',
                'username' => $user_main->row()->username,
                'status_user_level' => '1',
            ]; $user_level = $this->Mbkm_model->insert_ignore($_ENV['DB_SSO'].'user_level', $data_user_level);

            if ($user_level) {
                $verify = $this->Mbkm_model->update($_ENV['DB_SSO'].'user_main', [ 'username' => $user_main->row()->username ], ['verify' => '1']);

                $this->session->set_flashdata('msg', ['success', '<i class="pli-yes me-1"></i> Verifikasi akun kampus merdeka berhasil, silahkan login.']);
                redirect('registrasi');

            } else {
                $this->session->set_flashdata('msg', ['danger', '<i class="pli-exclamation me-1"></i> Verifikasi akun gagal, silahkan hubungi kampus!']);
                redirect('registrasi');
            }
        }
    }

    public function daftar_v2()
    {
        $active_smt = json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/smt?id_smt=aktif'))[0];
        $data = $this->input->post(null, true);

        # data mahasiswa_pt
        $mhs_pt['id_mahasiswa_pt'] = rand(10, 99).'.'.$data['nim'];
        $mhs_pt['nipd'] = $data['nim'];
        $mhs_pt['id_sp'] = $data['id_sp'];
        $mhs_pt['nama_prodi'] = $data['nama_prodi'];
        $mhs_pt['mulai_smt'] = $active_smt->id_semester;
        $mhs_pt['id_mhs'] = '';

        unset($data['nim']);
        unset($data['id_sp']);
        unset($data['nama_prodi']);
        
        # data mahasiswa
        $mhs = $data;
        # input mahasiswa
        $mhs_insert = $this->Mbkm_model->insert_ignore_v2($_ENV['DB_MBKM'].'mahasiswa', $mhs, true);

        if ($mhs_insert) {
            # upload foto
            if ($_FILES) {
                $path = 'dokumen/foto/';
                $config['upload_path']          = './'.$path;
                $config['allowed_types']        = 'jpg|png|gif|jpeg';
                $config['overwrite']            = false;
                $config['max_size']             = 5000;

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('foto')) {
                    # update foto
                    $foto = [
                        'foto' => base_url($path.$this->upload->data('file_name'))
                    ];

                    $update_foto = $this->Mbkm_model->updateOrInsert($_ENV['DB_MBKM'].'mahasiswa', $foto, [ 'id_mhs' => $mhs_insert ]);
                } else {
                    echo strip_tags($this->upload->display_errors()).' (max. uploaded size: 2 MB, allowed filetypes: .jpeg, .jpg, .png, .gif)';
                }
            }

            # input mahasiswa pt
            $mhs_pt['id_mhs'] = $mhs_insert;
            $mhs_pt_insert = $this->Mbkm_model->insert_ignore_v2($_ENV['DB_MBKM'].'mahasiswa_pt', $mhs_pt);

            if ($mhs_pt_insert) {
                # kirim email verifikasi
                $data_email = [
                    'nipd' => trim($mhs_pt['nipd']),
                    'id_mahasiswa_pt' => trim($mhs_pt['id_mahasiswa_pt']),
                    'nama_mahasiswa' => $mhs['nm_pd'],
                    'email' => $mhs['email'],
                ]; $this->kirim_email($mhs['email'], "Verifikasi Akun Kampus Merdeka", $data_email);

                $data_user_main = [
                    'username' => trim($mhs_pt['id_mahasiswa_pt']),
                    'email' => $mhs['email'],
                    'nama_pengguna' => strtoupper($mhs['nm_pd']),
                    'verify' => '0',
                ]; $user_main_insert = $this->Mbkm_model->insert_ignore_v2($_ENV['DB_SSO'].'user_main', $data_user_main);

                if ($user_main_insert) {
                    $this->session->set_flashdata('msg', ['success', '<i class="pli-yes me-1"></i> Registrasi berhasil, silahkan periksa email untuk verifikasi akun.']);
                    redirect('registrasi');

                } else {
                    $this->session->set_flashdata('msg', ['danger', '<i class="pli-exclamation me-1"></i> Registrasi gagal, akun mahasiswa tidak tersimpan!']);
                    redirect('registrasi');
                }

            } else {
                $this->session->set_flashdata('msg', ['danger', '<i class="pli-exclamation me-1"></i> Registrasi gagal, mahasiswa pt tidak tersimpan!']);
                redirect('registrasi');
            }

        } else {
            $this->session->set_flashdata('msg', ['danger', '<i class="pli-exclamation me-1"></i> Registrasi gagal, mahasiswa sudah terdaftar!']);
            redirect('registrasi');
        }

        // print_r($mhs_insert); exit;
    }

    function daftar()
    {
        $this->load->model('Auth_model');

        $captcha_response = trim($this->input->post('g-recaptcha-response'));
		if($captcha_response != '')
		{
			$keySecret = '6Le585ckAAAAAFBAqVu9S4rFfySQWNTamWyrpwKC';

			$check = array(
				'secret'		=>	$keySecret,
				'response'		=>	$this->input->post('g-recaptcha-response')
			);

			$startProcess = curl_init();
			curl_setopt($startProcess, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
			curl_setopt($startProcess, CURLOPT_POST, true);
			curl_setopt($startProcess, CURLOPT_POSTFIELDS, http_build_query($check));
			curl_setopt($startProcess, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($startProcess, CURLOPT_RETURNTRANSFER, true);

			$receiveData = curl_exec($startProcess);
			$finalResponse = json_decode($receiveData, true);

			if($finalResponse['success'])
			{
				$data = $this->input->post(null, true);
		        $nim = trim(explode(' - ', $data['mahasiswa'])[0]);
		        $nm_pd = explode(' - ', $data['mahasiswa'])[1];
		        $asal_mahasiswa = explode(', ', $data['asal_mahasiswa']);

		        $pt = $this->Mbkm_model->get($_ENV['DB_REF'].'satuan_pendidikan', [ 'nm_lemb like' => '%'.$asal_mahasiswa[1].'%' ])->row();
		        // print_r($pt); exit;

		        $check_email = $this->Auth_model->get_email(xss_clean($data['email']));
		        if($check_email){
		            $this->session->set_flashdata('msg', ['danger', '<i class="pli-close me-1"></i> Registrasi gagal, email sudah terdaftar. Silahkan hubungi pengelola website.']);
		            redirect('registrasi');
		        }
		        
		        $check_username = $this->Auth_model->get_username($nim);
		        if($check_username){
		            $this->session->set_flashdata('msg', ['danger', '<i class="pli-close me-1"></i> Registrasi gagal, mahasiswa sudah terdaftar. Silahkan hubungi pengelola website.']);
		            redirect('registrasi');
		        }

		        $data_sso = [
		            'username' => $nim,
		            'nama_pengguna' => $nm_pd,
		            'email' => $data['email']
		        ]; $user_main = $this->Mbkm_model->insert($_ENV['DB_SSO'].'user_main', $data_sso);

		        $data_mahasiswa = [
		            'nik' => $data['nik'],
		            'nm_pd' => $nm_pd,
		            'email' => $data['email'],
		            'no_hp' => $data['no_hp'],
		        ]; $id_mhs = $this->Mbkm_model->insert($_ENV['DB_MBKM'].'mahasiswa', $data_mahasiswa, true);

		         $data_mahasiswa_pt = [
		            'id_mhs' => $id_mhs,
		            'id_mahasiswa_pt' => $nim,
		            'nipd' => $nim,
		            'id_sp' => $pt ? $pt->id_sp : null,
		            'kode_pt' => $pt ? $pt->npsn : null,
		            'nama_pt' => $pt ? $pt->nm_lemb : ucwords(strtolower($asal_mahasiswa[1])),
		            'nama_prodi' => ucwords(strtolower($asal_mahasiswa[0])),
		            'npm_aktif' => '1',
		        ]; $mahasiswa_pt = $this->Mbkm_model->insert($_ENV['DB_MBKM'].'mahasiswa_pt', $data_mahasiswa_pt, true);
		        
		        $data_email = [
		            'nim' => trim($nim),
		            'nama_mahasiswa' => $nm_pd,
		            'email' => $data['email'],
		        ]; $this->kirim_email($data['email'], "Verifikasi Registrasi Akun", $data_email);

		        $this->session->set_flashdata('msg', ['success', '<i class="pli-yes me-1"></i> Registrasi berhasil, silahkan periksa email untuk verifikasi.']);
			} else {
		        $this->session->set_flashdata('msg', ['danger', '<i class="pli-close me-1"></i> Validasi captcha gagal, silahkan ulangi lagi.']);
			}
		} else {
	        $this->session->set_flashdata('msg', ['danger', '<i class="pli-close me-1"></i> Validasi captcha gagal, silahkan ulangi lagi.']);
		}
        
        redirect('registrasi');
    }

    function hit_mhs($keyword=null)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api-frontend.kemdikbud.go.id/hit_mhs/'.$keyword,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        // $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE) != 0 ? 'wadidaw' : 'Error: Server PDDIKTI Sedang Maintenance. Silahkan Ulangi Lagi Nanti.' ;
        $response = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($response, TRUE);

        $mahasiswa = $res['mahasiswa'];
        for ($i=0; $i < sizeof($res['mahasiswa']); $i++) { 
            // $mahasiswa[$i]['nim'] = $keyword;
            $detail = explode(', ', $mahasiswa[$i]['text']);
            $nim = preg_replace("/[^a-zA-Z0-9]+/", "", explode('(', $detail[0])[1]);
            // explode('(', $detail[0])[1]

            $mahasiswa[$i]['mahasiswa'] = $nim.' - '.explode('(', $mahasiswa[$i]['text'])[0];
            $mahasiswa[$i]['detail'] = explode(': ', $detail[2])[1].', '.explode(' : ', $detail[1])[1];
            $mahasiswa[$i]['link'] = 'https://pddikti.kemdikbud.go.id/'.$mahasiswa[$i]['website-link'];
            $mahasiswa[$i]['id'] = substr($mahasiswa[$i]['website-link'], -48);

            unset($mahasiswa[$i]['text'], $mahasiswa[$i]['website-link']);
        }

        $obj['data'] = $mahasiswa;
        $obj['meta'] = null;
        echo json_encode($obj);
    }

    function program()
    {
        $data['program_mbkm'] = $this->Mbkm_model->program(['mbkm' => '1']);
        $data['title'] = 'Program Kampus Merdeka';
        $data['content'] = 'mbkm/program';

        $this->load->view('template', $data);
    }

    function notification()
    {
    	$notification = $this->Aktivitas_model->aktivitas_log(['whatdo REGEXP' => 'tambah_dosen|tambah_penjadwalan|file_sk_tugas', 'id_aktivitas' => '3'], null, 'whatdo')->result();
    	print_r($notification);
    }
}