<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xave extends CI_Controller {

	public function index()
	{
		$this->data['jlh_mahasiswa'] = 7000;
		$this->data['jlh_dosen'] = 800;
	
		$this->view = "welcome";
		$this->load->view($this->view,$this->data);
	}

	public function cek_login($username,$password)
	{
		$this->load->model('akademika_portal');
		$this->data['title'] = 'Debug Page';

		$cek_portal = $this->akademika_portal->get_Login($username,md5($password));

		if($cek_portal)
		{
			foreach($query->result() as $data){
				$sess_data['tusrId'] = $data->tusrNama;
				$sess_data['tusrThakrId'] = $data->tusrThakrId;
				$sess_data['tusrNama'] = $data->tusrProfil;
				$sess_data['kodeProdi'] = $data->tusrProdiKode;
				$sess_data['kodeJur'] = $data->prodiJurKode;
				$sess_data['kodeFak'] = $data->prodiFakKode;

				$this->session->set_userdata('logged_in_dosen',$sess_data);
			}
		} else {}

		$this->load->view('layout/debug');

	}



	public function cek_krs($nim)
	{
		$this->load->model('akademika_sia');
		$this->data['result'] = $this->akademika_sia->total_sks($nim);
		$this->load->view('layout/debug',$this->data);
	}

	public function cek_mk_ta($nim)
	{
		$this->load->model('akademika_sia');
		$this->data['result'] = $this->akademika_sia->cek_krs($nim);
		$this->load->view('layout/debug',$this->data);
	}

	public function mahasiswa()
	{
		$this->data['body_page'] = '';
		$this->load->view('layout/mahasiswa',$this->data);
	}

		public function dosen()
	{
		$this->data['body_page'] = '';
		$this->load->view('layout/dosen',$this->data);
	}

	public function testa(){
		//$result 	= http_response_code(URL_API.'dosen/login?user=197711202010121002&pass=fJu4g6sdMQW');
		//echo $result;

		$result = json_decode(file_get_contents(URL_API.'dosen/login?user=197711202010121002&pass=fJu4g6sdMQW'),1);
		echo $result['status'];
		//echo $result->status;
		//$result2 = get_headers(URL_API.'dosen/login?user=197711202010121002&pass=fJu4g6sdMQW');

		//$result =  (substr(get_headers(URL_API.'dosen/login?user=197711202010121002&pass=fJu4g6sdMQW')[0], 9, 3) == 200 ? TRUE:FALSE);
		//echo $result;
		//echo is_array($result) ? 'Array' : 'not an Array';

		//echo $result['status'];
		//echo $result2;
		//var_dump($result);
		//echo $result[];

					//$result[$key]['judulDsnPengusul'] = json_decode(file_get_contents(URL_API.'dosen?nip='.$result[$key]['judulDsnPengusul']))->nama;
	}

	public function test() {
		$session_data = array(
							'curr_id' => '1',
							'curr_username' => 'admin',
							'curr_group' => 'admin',
							'curr_jurusan' => '',
							'curr_prodi' => '',
						);							
						
		$this->session->set_userdata('logged_in_admin', $session_data);
		$this->load->view('siteview/debug');
	}

	public function logout() {
		$this->session->sess_destroy();
		$this->load->view('debug');
	}

	public function get_detail($secret, $nip) {
		$this->load->model(array('Portal_model'));
		if ($secret == "xave") {
			$result = $this->Portal_model->get_detail($nip);
			echo json_encode($result);
		}
	}
	
	public function encodes($plaintext) {
	
		$this->load->library('encrypt');
		$cyphertext	= $this->encrypt->encode($plaintext);
		$cyphertext	= str_replace(array('+', '/', '='), array('-', '_', '~'), $cyphertext);
		echo $cyphertext;
	}
	
	public function decodes($cyphertext) {
	
		$this->load->library('encrypt');
		$cyphertext	= str_replace(array('-', '_', '~'), array('+', '/', '='), $cyphertext);
		$plaintext	= $this->encrypt->decode($cyphertext);
		echo $plaintext;
	}
	
	public function latihan($plaintext) {

		
		echo $this->encrypt->encode($plaintext);
	}
	
	public function latihan2($plaintext) {

		
		echo $this->encrypt->decode($plaintext);
	}


	public function pindahfile() {

		
		$this->load->model(array('Tabel_dokumen'));
		$dokumen = $this->Tabel_dokumen->get();
		//echo var_dump($dokumen);

		foreach ($dokumen as $key => $value) {
			//echo $value['dokumenFile']."</br>";
			rename(DIR_DOKUMEN.$value['dokumenFile'], DIR_DOKUMEN.$value['dokumenDocgroupId'].'/'.$value['dokumenFile']);
		}
	}

	public function updatetabeldok() {

		
		$this->load->model(array('Tabel_dokumen'));
		$dokumen = $this->Tabel_dokumen->user_get();
		echo var_dump($dokumen);die;

		foreach ($dokumen as $key => $value) {
			//$result = count($this->Tabel_dokumen->user_get(array('ft_dokumen_user.dokumenId' => $value['dokumenId'])));
			//echo $result."<br/>";
			//if ($result > 1) echo $value['dokumenId'];
			//if ($result == 1) $this->Tabel_dokumen->update(array('dokumenId' => ));
			$owner = $this->Tabel_dokumen->get(array('ft_dokumen_user.dokumenId' => $value['dokumenId']));
			echo var_dump($owner)."<br/>";
			//$this->Tabel_dokumen->update(array('dokumenId' => $value['dokumenId'], 'ownerId' => $this->Tabel_dokumen->user_get(array('ft_dokumen_user.dokumenId' => $value['dokumenId']))['ft_dokumen_user.userId']));
		}
	}		

	
}
