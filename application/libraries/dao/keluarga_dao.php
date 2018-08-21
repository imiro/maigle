<?php

require_once('generic_dao.php');

class keluarga_dao extends Generic_dao  {
	
	public function table_name(){
		return 'keluarga';
	}

	public function field_map() {
		return array (
			'id_keluarga'=>'id_keluarga',
			'no_kk'=>'no_kk',
			'alamat'=>'alamat',
			'lat'=>'lat',
			'lon'=>'lon'
		);
	}

	public function __construct() {
		parent::__construct();
	}

	function getDaftarKeluarga($limit = 100, $offset = 0) {
		return $this->fetch($limit, $offset, 'alamat');
	}

	function saveNewKeluarga($obj) {
		return $this->insert($obj);
	}

	function getInfoKeluarga($id_keluarga) {
		return $this->by_id(array('id_keluarga' => $id_keluarga));
	}

	function editKeluarga($id, $obj) {
		return $this->update($obj, array('id_keluarga' => $id));
	}

	function getAllKelIndividu() {
		$this->ci->db->select('keluarga.*, individu.*, daftar_agama.desc AS desc_agama, daftar_pendidikan.desc AS desc_pend, daftar_pekerjaan.desc AS desc_kerja');
		$this->ci->db->from('keluarga LEFT JOIN individu ON (keluarga.id_keluarga = individu.id_rumah) 
			LEFT JOIN daftar_agama ON (individu.agama = daftar_agama.id)
			LEFT JOIN daftar_pendidikan ON (individu.pendidikan = daftar_pendidikan.id)
			LEFT JOIN daftar_pekerjaan ON (individu.pekerjaan = daftar_pekerjaan.id)
		');
		
        // $this->ci->db->where('id_keluarga = 4');
		$q = $this->ci->db->get();
		return $q->result();
	}

}

?>
