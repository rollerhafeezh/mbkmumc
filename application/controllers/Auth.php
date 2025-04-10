<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
    }
    
    function index($encoded=null)
    {
        redirect(base_url('logout'));
    }
    
    function logon($encoded=null)
    {
        if($encoded)
        {
            $decoded=base64_decode($encoded);
            $dekripsi = $this->Auth_model->dekripsi($decoded);
            $data = explode('#', $dekripsi);
            if(count($data)==3)
            {
                $cek_login = $this->Auth_model->cek_login($data[0],$data[1]);
                if($cek_login)
                {
                    $this->proses($data[0],$data[1]);
                }else{
                    redirect(base_url('logout'));
                }
            }else{
                redirect(base_url('logout'));
            }
        }else{
            redirect(base_url('logout'));
        }
    }
    
    private function proses($username,$id_level)
    {
        $this->load->model('Aktivitas_model');
        $pengguna = $this->Auth_model->get_username($username);
        
        $level = $this->Auth_model->get_level($id_level);
        
        if($pengguna && $level)
        {

            /*-------USER DETAIL---------*/
            $_SESSION['id_jenis_aktivitas_mahasiswa'] = $_ENV['ID_JENIS_AKTIVITAS_MAHASISWA'];

            $_SESSION['picture']        =($pengguna->picture)?:$_ENV['LOGO_100'];
            $_SESSION['username']       =$pengguna->username;
            $_SESSION['email']          =$pengguna->email;
            $_SESSION['nama_pengguna']  =$pengguna->nama_pengguna;
            $_SESSION['api_token']      =$pengguna->api_token;
            $_SESSION['id_user']        =$this->Auth_model->get_id_user($pengguna->username,$level->app_level);
            /*-------USER DETAIL---------*/

            /*---CAN BE IGNORED ----*/
            $_SESSION['id_level']   =$level->id_level;
            $_SESSION['id_app']     =$level->id_app;
            $_SESSION['nama_app']   =$level->nama_app;
            /*---CAN BE IGNORED ----*/
            
            /*--------FOR APPLEVEL PURPOSE-----*/
            $_SESSION['app_level']  =$level->app_level;
            $_SESSION['level_name'] =$level->level_name;
            $_SESSION['kode_fak']   =$level->kode_fak;
            $_SESSION['nama_fak']   =json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/fakultas?kode_fak='.$level->kode_fak))[0]->nama_fak;
            $_SESSION['kode_prodi'] =$level->kode_prodi;
            $_SESSION['nama_prodi'] =json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/prodi?kode_prodi='.$level->kode_prodi))[0]->nama_prodi;
            /*--------FOR APPLEVEL PURPOSE-----*/
            
            /*-----KETERANGAN TAMBAHAN HERE----*/
            $active_smt = json_decode($this->curl->simple_get($_ENV['API_LINK'].'ref/smt?id_smt=aktif'))[0];
            $_SESSION['active_smt']=$active_smt->id_semester;
            $_SESSION['nama_smt']=$active_smt->nama_semester;
            
            $thn_aka=substr($_SESSION['active_smt'],0,4);
            $_SESSION['thn_aka']=$thn_aka;
            $_SESSION['thn_akademik']=$thn_aka.'/'.($thn_aka+1);

            $_SESSION['logged_in'] = TRUE;


            $aktivitas  = $this->Aktivitas_model->anggota([ 'a.id_mahasiswa_pt' => $_SESSION['id_user'], 'as.id_jenis_aktivitas_mahasiswa' => $_SESSION['id_jenis_aktivitas_mahasiswa'] ])->row();
            foreach ($aktivitas as $key => $value) {
                $_SESSION['anggota'][$key] = $value;
            }
            
    		redirect('dasbor');
        }else{
            redirect(base_url('logout'));   
        }
    }
}