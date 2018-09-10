<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct() {
		parent::__construct();

		if (!isset($this->session->userdata['logged_in_dosen'])) {
			redirect(site_url('login/dosen'));
		}
		$this->view = 'layout/dosen';
		
	}

	public function index() {
		
		$this->data['pageTitle'] = "Home";
		$this->data['body_page'] = 'body_dosen/home';

		$this->load->view($this->view,$this->data);

	}

}