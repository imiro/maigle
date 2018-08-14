<?php

require_once('generic_dao.php');

class status_tbc_dao extends Generic_dao  {
	
	public function table_name(){
		return 'status_tbc';
	}

	public function field_map() {
		return array (
			'id'=>'id',
			'desc'=>'desc'
		);
	}

	public function __construct() {
		parent::__construct();
	}

	function getDaftar() {
		$limit = 100;
		$offset = 0;
		return $this->fetch($limit, $offset, 'id');
	}
	
}

?>
