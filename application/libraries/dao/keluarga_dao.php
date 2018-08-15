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

	function getDaftarKeluarga() {
		$limit = 100;
		$offset = 0;
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

}

?>
