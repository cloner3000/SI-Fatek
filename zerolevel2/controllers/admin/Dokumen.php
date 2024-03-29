<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokumen extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->model(array('Tabel_dokumen','Tabel_docgroup','Tabel_dosen'));

		if (!isset($this->session->userdata['logged_in_portal']['admin'])) {
			redirect(site_url('login'));
		}

		$this->unit		= $this->session->userdata['logged_in_portal']['admin']['grup'];
		$this->namaUnit	= $this->session->userdata['logged_in_portal']['admin']['namaUnit'];
		$this->kodeUnit	= $this->session->userdata['logged_in_portal']['admin']['kodeUnit'];

		if ($this->unit == 'fakultas') {
			$this->namaUnit	= "Fakultas Teknik";
		}
		
	}
	
	public function index() {

		$data['pageTitle'] 	= "Dokumen " . $this->namaUnit;
		$data['menu_page']	= "menu/".$this->unit;
		$data['body_page'] 	= "body/dokumen/list_add";

		$unit = $this->unit . $this->kodeUnit;

		if ($this->unit == 'admin') {
			$data['dokumen'] 	= $this->Tabel_dokumen->get(FALSE,'dokumenTahun DESC, dokumenDocgroupId ASC');
		} else {
			$data['dokumen'] 	= $this->Tabel_dokumen->get(array('ownerId'=> $unit),'dokumenTahun DESC, dokumenDocgroupId ASC');
		}
		
		$data['docgroup'] 	= $this->Tabel_docgroup->get();
		
		foreach ($data['dokumen'] as &$val) {
			$val['dokumenFile'] = URL_DOKUMEN.$val['dokumenDocgroupId'].'/'.$val['dokumenFile'];
		}
		
		$this->load->view(THEME_DOSEN,$data);

	}

	public function dosen($nip=FALSE) {

		$data['menu_page']	= "menu/".$this->unit;
		$unit = $this->unit . $this->kodeUnit;

		if ($nip === FALSE) {

			$data['pageTitle'] 	= "Dokumen Dosen";
			$data['body_page'] 	= "body/dokumen/dosen";
			
			$data['dosen'] 		= $this->Tabel_dosen->get();
			foreach ($data['dosen'] as $key => $value) {
				$data['dosen'][$key]['jurusan'] = ucwords(strtolower($value['jurusan']));
				$data['dosen'][$key]['prodi'] = ucwords(strtolower($value['prodi']));
			}

		} else {

			$namaDosen = $this->Tabel_dosen->detail(array('nip' => $nip))['nama'];

			$data['pageTitle'] 	= "Dokumen ". $namaDosen;
			$data['body_page'] 	= "body/dokumen/list";

			$data['dokumen'] 	= $this->Tabel_dokumen->user_get(array('ft_dokumen_user.userId'=> $nip),'dokumenTahun DESC, dokumenDocgroupId ASC');
			foreach ($data['dokumen'] as &$val) {
				$val['dokumenFile'] = URL_DOKUMEN.$val['dokumenDocgroupId'].'/'.$val['dokumenFile'];
			}

		}
		
		$this->load->view(THEME_DOSEN,$data);

	}	

	public function tambah() {

		$this->form_validation->set_rules('nama', 'Nama Dokumen', 'trim|required');
		$this->form_validation->set_rules('user[]', 'NIP/NIM', 'numeric');

		if (empty($_FILES['dokumen']['name'])) {
			$this->form_validation->set_rules('dokumen', 'Upload Dokumen', 'required');
		}		

		if ($this->form_validation->run() == TRUE) {

			$database['dokumenNama']		= $this->input->post('nama');
			$database['dokumenDeskripsi']	= $this->input->post('deskripsi');
			$database['dokumenNomor'] 		= $this->input->post('nomor');
			$database['dokumenTahun']		= $this->input->post('tahun');
			$database['dokumenDocgroupId'] 	= $this->input->post('jenis');
			$database['ownerId'] 			= $this->unit . $this->kodeUnit;
			$database['userUpdate']			= $this->session->userdata['logged_in_portal']['nama'];

			$this->config->config['dokumen']['file_name'] = $database['ownerId']."-".date('Ymd-His');
			$this->config->config['dokumen']['upload_path'] =DIR_DOKUMEN . $database['dokumenDocgroupId'] ."/";
			$this->load->library('upload', $this->config->item('dokumen'));

			if(!empty($_FILES['dokumen']['name'])) {

				if(!$this->upload->do_upload('dokumen')) {
				
					$this->session->set_flashdata('type', 'danger');
					$this->session->set_flashdata('message', $this->upload->display_errors());				
					
				} else {

					$upload_data 				= $this->upload->data();
					$database['dokumenFile'] 	= $upload_data['file_name'];
					
					$id_dokumen 	= $this->Tabel_dokumen->tambah($database);
					$user = $this->input->post('user');
					
					foreach ($user as $val) {
						$multi_user[] = array('dokumenId' => $id_dokumen, 'userId' => $val);
					}
					
					if ($this->Tabel_dokumen->link_user($multi_user)) {
					
						$this->session->set_flashdata('type', 'success');
						$this->session->set_flashdata('message', 'Berhasil disimpan!');;
						
					} else {
					
						$this->session->set_flashdata('type', 'danger');
						$this->session->set_flashdata('message', 'Gagal disimpan!');
					}
				}
			}

		} else {

			$this->session->set_flashdata('type', 'warning');
			$this->session->set_flashdata('message', validation_errors('Gagal disimpan. Form tidak lengkap! '));
		}

		redirect(site_url('admin/dokumen'));		

	}

	public function delete() {

		$id_dokumen = $this->input->post('id');
		
		$file = $this->Tabel_dokumen->detail(array('ft_dokumen.dokumenId' => $id_dokumen));

		if (!empty($file)) unlink(FCPATH.DIR_DOKUMEN.'/'.$file['dokumenDocgroupId'].'/'.$file['dokumenFile']);

		if ($this->Tabel_dokumen->delete($id_dokumen)) {
				
			$this->session->set_flashdata('type', 'success');
			$this->session->set_flashdata('message', 'Berhasil dihapus!');

		} else {
		
			$this->session->set_flashdata('type', 'danger');
			$this->session->set_flashdata('message', 'Gagal dihapus!');
			$this->output->set_status_header('500');
		}

	}

	public function detail($id) {

		$output = $this->Tabel_docgroup->detail(array('docgroupId'=> $id));
		echo json_encode($output);

	}			
	
}