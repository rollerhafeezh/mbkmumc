<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

    function mahasiswa()
    {
        $data=[ 
                [
                    'has-sub'   => FALSE,
                    'menu_color'=> '',
                    'menu_text' => 'Beranda',
                    'menu_icon' => '',
                    'menu_link' => 'dasbor',
                ],
                [
                    'has-sub'   => FALSE,
                    'menu_color'=> '',
                    'menu_text' => 'Tentang',
                    'menu_icon' => '',
                    'menu_link' => 'dasbor?redirect=https://umc.ac.id',
                ],
                // [
                //     'has-sub'   => FALSE,
                //     'menu_color'=> '',
                //     'menu_text' => 'Repositori',
                //     'menu_icon' => '',
                //     'menu_link' => 'repositori',
                // ],
                [
                    'has-sub'   => FALSE,
                    'menu_color'=> '',
                    'menu_text' => 'Program',
                    'menu_icon' => '',
                    'menu_link' => 'program',
                ],
                [
                    'has-sub'   => FALSE,
                    'menu_color'=> '',
                    'menu_text' => 'Registrasi',
                    'menu_icon' => '',
                    'menu_link' => 'registrasi',
                ],
                [
                    'has-sub'   => FALSE,
                    'menu_color'=> '',
                    'menu_text' => 'Login',
                    'menu_icon' => '',
                    'menu_link' => 'dasbor?redirect=https://sso.umc.ac.id',
                ],
            ];
        return $data;
    }
    
    function show($menu)
    {
        $uri_1 = $this->uri->segment(1);
        $uri_2 = $this->uri->segment(2);

        foreach ($this->$menu() as $data) {
            if($data['has-sub']){
                echo'
                    <li class="nav-item has-sub">
                        <a href="" class="mininav-toggle nav-link collapsed '.(strpos($this->uri->uri_string(), $data['menu_link']) !== false ? 'active' : '').'">';

                            if ($data['menu_icon'] != '') echo '<i class="'.$data['menu_icon'].' fs-5 me-2"></i>';

                echo '<span class="nav-label ms-1">'.$data['menu_text'].'</span>
                        </a>
                    
                        <ul class="mininav-content nav collapse">';
                    	    foreach($data['menu_child'] as $value){
                        	    echo'
                                <li class="nav-item">
                        		    <a href="'.base_url($value['menu_link']).'" class="nav-link '.(strpos($this->uri->uri_string(), $value['menu_link']) !== false ? 'active' : '').'">'.$value['menu_text'].'</a>
                        	    </li>';
                    	    }
                echo '</ul>
                    </li>';
            }else{
                echo'
                <li class="nav-item">
                    <a href="'.base_url($data['menu_link']).'" class="nav-link collapsed '.(strpos($this->uri->uri_string(), $data['menu_link']) !== false ? 'active' : '').' '.((!$this->uri->uri_string() AND ($data['menu_link'] == 'dasbor'))  ? 'active' : '').'">';
                        
                        if ($data['menu_icon'] != '') echo '<i class="'.$data['menu_icon'].' fs-5 me-2"></i>';

                echo '<span class="nav-label ms-1">'.$data['menu_text'].'</span>
                    </a>
                </li>
                ';
            }
        }
    }

}