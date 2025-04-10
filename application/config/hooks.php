<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['pre_system'] = function() {
    $dotenv = Dotenv\Dotenv::createImmutable(APPPATH);
    $dotenv->load();
};