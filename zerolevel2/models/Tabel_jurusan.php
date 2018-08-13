<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Model class for querying to akademika_sia database
class Tabel_jurusan extends CI_Model {
	public function __construct() {
		parent::__construct();	
	}

	public function get($condition = FALSE, $sort = FALSE, $limit = FALSE) {
		if ($condition) $this->db->where($condition);
		if ($sort) $this->db->order_by($sort);
		if ($limit) $this->db->limit($limit);
		$query = $this->db->get('ref_jurusan');
		$result = $query->result_array();
		return $result;
	}

	public function detail($condition) {
		$this->db->where($condition);
		$query = $this->db->get('ref_jurusan');
		return $query->row_array();
		
	}	

	public function tambah($data) {
		$this->db->insert('ref_jurusan', $data);
		return $this->db->insert_id();
	}
	
	public function delete($id) {
		return $this->db->delete('ref_jurusan', array('kodeJurusan' => $id));
	}
	
	public function update($data) {
		$this->db->where('ref_jurusan', $data['kodeJurusan']);
		return $this->db->update('ref_jurusan', $data);
	}	

}
