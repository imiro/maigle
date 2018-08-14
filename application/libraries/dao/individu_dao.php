<?php

require_once('generic_dao.php');

class individu_dao extends Generic_dao  {
	
	public function table_name(){
		return 'individu';
	}

	public function field_map() {
		return array (
			'id_individu'=>'id_individu',
			'nama'=>'nama',
			'nik'=>'nik',
			'kelamin'=>'kelamin',
			'ttl'=>'ttl',
			'agama'=>'agama',
			'bpjs'=>'bpjs',
			'pendidikan'=>'pendidikan',
			'pekerjaan'=>'pekerjaan',
			'tgl_periksa'=>'tgl_periksa',
			'bb'=>'bb',
			'tb'=>'tb',
			'tensi_sistol'=>'tensi_sistol',
			'tensi_diastol'=>'tensi_diastol',
			'gula_darah'=>'gula_darah',
			'penyakit_saat_ini'=>'penyakit_saat_ini',
			'dm'=>'dm',
			'hipertensi'=>'hipertensi',
			'tbc'=>'tbc',
			'dbd'=>'dbd',
			'hiv'=>'hiv',
			'tb_hiv'=>'tb_hiv',
			'imunisasi'=>'imunisasi',
			'kehamilan'=>'kehamilan',
			'id_rumah'=>'id_rumah'
		);
	}

	public function __construct() {
		parent::__construct();
	}

	function getDaftarAnggotaKeluarga($id_keluarga) {
		$limit = 100;
		$offset = 0;
		return $this->fetch($limit, $offset, 'nama', array('id_rumah' => $id_keluarga));
	}

	function saveNewIndividu($obj) {
		return $this->insert($obj);
	}

	function getInfoIndividu($id_individu) {
		return $this->by_id(array('id_individu' => $id_individu));
	}

	function editIndividu($id, $obj) {
		return $this->update($obj, array('id_individu' => $id));
	}
}

?>
