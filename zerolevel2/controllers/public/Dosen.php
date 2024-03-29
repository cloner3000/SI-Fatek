<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends CI_Controller {

	private $layout = 'themes/public';

	public function __construct() {
		parent::__construct();
		$this->load->model(array('Tabel_dosen','Tabel_publikasi'));

	}
	
	public function index() {
	
		$data['dosen'] 		= $this->Tabel_dosen->get(array('showInPublic' => 1));
		$data['pageTitle'] 	= "Data Dosen Fakultas Teknik";
		$data['body_page'] 	= 'body/dosen/list_public';

		foreach ($data['dosen'] as $key => $value) {
			$data['dosen'][$key]['jurusan'] = ucwords(strtolower($value['jurusan']));
			$data['dosen'][$key]['prodi'] = ucwords(strtolower($value['prodi']));
		}

		$this->load->view($this->layout,$data);
	
	}

	public function jurusan($jur, $format = FALSE) {

		switch ($jur) {
			case "sipil":
		        $data['dosen'] 		= $this->Tabel_dosen->get(array('kodeJurusan'=> 45, 'showInPublic' => 1), 'nip ASC');
		        $data['pageTitle'] 	= "Data Dosen Jurusan Teknik Sipil";
		        break;
		    case "arsitektur":
		        $data['dosen'] 		= $this->Tabel_dosen->get(array('kodeJurusan'=> 42, 'showInPublic' => 1), 'nip ASC');
		        $data['pageTitle'] 	= "Data Dosen Jurusan Arsitektur";
		        break;
		    case "elektro":
		        $data['dosen'] 		= $this->Tabel_dosen->get(array('kodeJurusan'=> 43, 'showInPublic' => 1),'nip ASC');
		        $data['pageTitle'] 	= "Data Dosen Jurusan Teknik Elektro";
		        break;
		    case "mesin":
		        $data['dosen'] 		= $this->Tabel_dosen->get(array('kodeJurusan'=> 44, 'showInPublic' => 1),'nip ASC');
		        $data['pageTitle'] 	= "Data Dosen Jurusan Teknik Mesin";
		        break;
		    default:
		        echo "Data not found";die;
		}

		foreach ($data['dosen'] as $key => $value) {
			$data['dosen'][$key]['jurusan'] = ucwords(strtolower($value['jurusan']));
			$data['dosen'][$key]['prodi'] = ucwords(strtolower($value['prodi']));
		}

		$data['body_page'] = 'body/dosen/list_public';

		if ($format == "json") {
			header('Access-Control-Allow-Origin: *');
			header('Content-type: application/json');
			echo json_encode($data['dosen']);

		} else {	
			$this->load->view($this->layout,$data);		
		}	
	}

	public function prodi($prodi, $format = FALSE) {

		switch ($prodi) {
			case "sipil":
		        $data['dosen'] 		= $this->Tabel_dosen->get(array('kodeProdi'=> 14, 'showInPublic' => 1), 'nip ASC');
		        $data['pageTitle'] 	= "Data Dosen Prodi Teknik Sipil";
		        break;
		 	case "lingkungan":
		        $data['dosen'] 		= $this->Tabel_dosen->get(array('kodeProdi'=> 94, 'showInPublic' => 1), 'nip ASC');
		        $data['pageTitle'] 	= "Data Dosen Prodi Teknik Lingkungan";
		        break;
		    case "arsitektur":
		        $data['dosen'] 		= $this->Tabel_dosen->get(array('kodeProdi'=> 15, 'showInPublic' => 1), 'nip ASC');
		        $data['pageTitle'] 	= "Data Dosen Prodi Arsitektur";
		        break;
		    case "pwk":
		        $data['dosen'] 		= $this->Tabel_dosen->get(array('kodeProdi'=> 16, 'showInPublic' => 1), 'nip ASC');
		        $data['pageTitle'] 	= "Data Dosen Prodi Perencanaan Wilayah dan Kota";
		        break;    
		    case "elektro":
		        $data['dosen'] 		= $this->Tabel_dosen->get(array('kodeProdi'=> 12, 'showInPublic' => 1), 'nip ASC');
		        $data['pageTitle'] 	= "Data Dosen Prodi Teknik Elektro";
		        break;
		    case "informatika":
		        $data['dosen'] 		= $this->Tabel_dosen->get(array('kodeProdi'=> 77, 'showInPublic' => 1), 'nip ASC');
		        $data['pageTitle'] 	= "Data Dosen Prodi Informatika";
		        break;
		    case "mesin":
		        $data['dosen'] 		= $this->Tabel_dosen->get(array('kodeProdi'=> 13, 'showInPublic' => 1), 'nip ASC');
		        $data['pageTitle'] 	= "Data Dosen Prodi Teknik Mesin";
		        break;
		    default:
		        echo "Data not found";die;
		}

		foreach ($data['dosen'] as $key => $value) {
			$data['dosen'][$key]['jurusan'] = ucwords(strtolower($value['jurusan']));
			$data['dosen'][$key]['prodi'] = ucwords(strtolower($value['prodi']));
		}

		$data['body_page'] = 'body/dosen/list_public';

		if ($format == "json") {
			header('Access-Control-Allow-Origin: *');
			header('Content-type: application/json');
			echo json_encode($data['dosen']);

		} else {	
			$this->load->view($this->layout,$data);		
		}	
	}

	public function id($nip, $format = FALSE) {
		
		$data['dosen'] = $this->Tabel_dosen->detail(array('nip'=>$nip));

		if ($data['dosen']) {
			$data['edu'] = $this->apicall->get(URL_API."dosen?nip=".$nip)->edu;
			$data['publikasi'] = $this->Tabel_publikasi->get(array('dosenNip' => $data['dosen']['nip']), 'tahun DESC');

			$data['dosen']['foto'] = (!empty($data['dosen']['foto'])) ? URL_FOTO_DOSEN.$data['dosen']['foto'] : URL_FOTO_DOSEN."default.jpg";
			$data['dosen']['jurusan'] = ucwords(strtolower($data['dosen']['jurusan']));
			$data['dosen']['prodi'] = ucwords(strtolower($data['dosen']['prodi']));
			if (!empty($data['dosen']['email'])) $data['dosen']['email'] = str_replace("@", "[a]", $data['dosen']['email']);
			if (!empty($data['dosen']['sintaId'])) $data['dosen']['sintaId'] = URL_SINTA.$data['dosen']['sintaId']."&view=overview";
			if (!empty($data['dosen']['googleId'])) $data['dosen']['googleId'] = URL_GOOGLE.$data['dosen']['googleId'];
			if (!empty($data['dosen']['scopusId'])) $data['dosen']['scopusId'] = URL_SCOPUS.$data['dosen']['scopusId'];

			$data['pageTitle'] = $data['dosen']['nama'];
			$data['body_page'] = 'body/dosen/detail_public';

			if ($format == "json") {
				header('Access-Control-Allow-Origin: *');
				header('Content-type: application/json');
				echo json_encode($data['dosen']);

			} else {
				$this->load->view($this->layout,$data);		
			}

		} else {
			echo "Data not found.";die;
		}
	}
	
}