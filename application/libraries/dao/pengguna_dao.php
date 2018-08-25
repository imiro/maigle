<?php

require_once('generic_dao.php');

class pengguna_dao extends Generic_dao  {

	public function table_name(){
		return 'pengguna';
	}

	public function field_map() {
		return array (
			'id_pengguna'=>'id_pengguna',
			'username'=>'username',
			'nama_lengkap'=>'nama_lengkap',
			'hp'=>'hp',
			'alamat'=>'alamat',
			'password'=>'password'
		);
	}

	public function __construct() {
		parent::__construct();
	}

	function get_user_by_login($login) {
		$obj_id_o = $this->to_sql_array($login);
		$this->ci->db->select($this->field_query());
		$this->ci->db->where($obj_id_o);
		$q = $this->ci->db->get($this->table_name());
		// var_dump($q);
		return $q->row();
	}

	function getUserById($id) {
		$user = $this->by_id(array('id_pengguna' => $id));
		if ($user) return $user;

		return false;
	}

	function editPengguna($id, $obj) {
		return $this->update($obj, array('id_pengguna' => $id));
	}

	function change_password($id, $new_pass) {
		return $this->update(array('password' => $new_pass), array('id_pengguna' => $id));
	}

}

?>
