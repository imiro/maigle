<?php
class keluarga_ctrl extends CI_Controller{

	public $data;
	public $filter;
	public $limit = 16;
	public static $CURRENT_CONTEXT = '/admin/keluarga_ctrl';
	public static $TITLE = "KELUARGA";

	public function __construct(){
		parent::__construct();
		$this->data = array();
		$this->load->helper('string');
		$this->load->helper('url');
		$this->load->helper('file');
		$this->load->helper('stringify');
		// $this->load->helper('acl');
		$this->load->helper('geodesics');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="note error">', '</span>');
		$this->load->library('pagination'); // GA KEPAKE
		$this->load->library('tank_auth');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->library('dao/keluarga_dao');
		$this->load->library('dao/individu_dao');
		$this->load->library('dao/daftar_agama_dao');
		$this->load->library('dao/daftar_pekerjaan_dao');
		$this->load->library('dao/daftar_pendidikan_dao');
		$this->load->library('dao/status_dm_dao');
		$this->load->library('dao/status_hamil_dao');
		$this->load->library('dao/status_hipertensi_dao');
		$this->load->library('dao/status_imunisasi_dao');
		$this->load->library('dao/status_tbc_dao');

		$this->logged_in();
		$this->role_user();

		$this->data['user_id'] = $this->session->userdata('user_id');
	}

	public function index($offset=0 ,$limit=16){
		$this->preload();
		$this->load_view('admin/list_keluarga', $this->data);
	}

	public function preload(){
		$this->data['current_context'] = self::$CURRENT_CONTEXT;
		$this->data['title'] = self::$TITLE;

		$this->data['objkel'] = null;
		$this->data['individus'] = null;
		$this->data['objanggota'] = null;
		$this->data['keluargas'] = $this->keluarga_dao->getDaftarKeluarga();
	}

	public function load_view($page, $data = null){
		$this->load->view('template/template_header',$data);
		$this->load->view('template/template_menu',$this->data);
		$this->load->view($page, $data);
		$this->load->view('template/template_footer');
	}

	public function edit($id_keluarga, $id_anggota = null){
		$this->preload();
		$user_url = self::$CURRENT_CONTEXT . '/edit/' . $id_keluarga;

		if ($id_keluarga == null) {
			$this->load_view('admin/list_keluarga');
		} 
		else {
			$this->data['objkel'] = $this->keluarga_dao->getInfoKeluarga($id_keluarga);
			$this->data['individus'] = $this->individu_dao->getDaftarAnggotaKeluarga($id_keluarga);

			// ambil daftar2 opsi
			$this->data['agama'] = $this->daftar_agama_dao->getDaftar();
			$this->data['pekerjaan'] = $this->daftar_pekerjaan_dao->getDaftar();
			$this->data['pendidikan'] = $this->daftar_pendidikan_dao->getDaftar();
			$this->data['dm'] = $this->status_dm_dao->getDaftar();
			$this->data['hamil'] = $this->status_hamil_dao->getDaftar();
			$this->data['hipertensi'] = $this->status_hipertensi_dao->getDaftar();
			$this->data['imunisasi'] = $this->status_imunisasi_dao->getDaftar();
			$this->data['tbc'] = $this->status_tbc_dao->getDaftar();
			$this->session->set_userdata('user_url', $user_url);

			if ($id_anggota) {
				$this->data['objanggota'] = $this->individu_dao->getInfoIndividu($id_anggota);
				$this->session->set_userdata('user_url', $user_url . '/' . $id_anggota);
			}

			$this->load_view('admin/list_keluarga', $this->data);
		}
	}

	private function fetch_input() {
		$data = array (
			'no_kk' => $this->input->post('no_kk'),
			'alamat' => $this->input->post('alamat'),
			'lat' => $this->input->post('lat'),
			'lon' => $this->input->post('lon')
		);

		return $data;
	}

	private function get_list_kamar() {
		$totalRow = $this->input->post('totalRowKmr');

		$listkamar = array();
		for ($i = 1; $i <= $totalRow; $i++) {
			$namakamar = $this->input->post('kmr_' . $i);
			$terisi = $this->input->post('filledKmr_' . $i);
			array_push($listkamar, array('nama' => $namakamar, 'terisi' => $terisi));
		}
		return $listkamar;
	}

	public function add_keluarga() {
		$infoSession = ''; // added by SKM17

		$obj = $this->fetch_input();
		
		if ($this->keluarga_dao->saveNewKeluarga($obj))
			$infoSession .= "Keluarga baru berhasil disimpan. ";
		else
			$infoSession .= "<font color='red'>Keluarga baru gagal disimpan. </font>";

		$this->session->set_flashdata("info", $infoSession);
		redirect(self::$CURRENT_CONTEXT);
	}

	public function edit_keluarga() {
		$infoSession = ''; // added by SKM17

		$obj = $this->fetch_input();
		$id_keluarga = $this->input->post('id_keluarga');

		if ($this->keluarga_dao->editKeluarga($id_keluarga, $obj))
			$infoSession .= "Data Keluarga berhasil diubah. ";
		else
			$infoSession .= "<font color='red'>Data Keluarga gagal diubah. </font>";

		$this->session->set_flashdata("info", $infoSession);
		redirect(self::$CURRENT_CONTEXT);
	}

	public function delete($id_keluarga = null){
		$obj_id = array('id_keluarga' => $id_keluarga);

		if ($this->keluarga_dao->delete($obj_id))
			$this->session->set_flashdata("success", "Hapus Keluarga berhasil!");
		else
			$this->session->set_flashdata("failed", "Hapus Keluarga gagal! Cek apakah data keluarga memiliki data anggota yang terhubung.");

		redirect(self::$CURRENT_CONTEXT);
	}

	private function fetch_input_anggota(){
		$data = array (
			'nama' => $this->input->post('nama'),
			'nik' => $this->input->post('nik'),
			'bpjs' => $this->input->post('bpjs'),
			'kelamin' => $this->input->post('jk'),
			'ttl' => $this->input->post('ttl'),
			'agama' => $this->input->post('agama'),
			'pendidikan' => $this->input->post('pendidikan'),
			'pekerjaan' => $this->input->post('pekerjaan'),
			'bb' => $this->input->post('bb'),
			'tb' => $this->input->post('tb'),
			'tensi_sistol' => $this->input->post('tensi_sistol'),
			'tensi_diastol' => $this->input->post('tensi_diastol'),
			'gula_darah' => $this->input->post('gula_darah'),
			'penyakit_saat_ini' => $this->input->post('penyakit_saat_ini'),
			'dm' => $this->input->post('dm'),
			'hipertensi' => $this->input->post('hipertensi'),
			'tbc' => $this->input->post('tbc'),
			'dbd' => $this->input->post('dbd'),
			'hiv' => $this->input->post('hiv'),
			'tb_hiv' => $this->input->post('tb_hiv'),
			'imunisasi' => $this->input->post('imunisasi'),
			'kehamilan' => $this->input->post('kehamilan'),
			'tgl_periksa' => $this->input->post('tgl_periksa'),
			'id_rumah' => $this->input->post('id_keluarga')
		);

		return $data;
	}

	public function add_anggota() {
		$infoSession = ''; // added by SKM17

		$objindiv = $this->fetch_input_anggota();

		if ($this->individu_dao->saveNewIndividu($objindiv))
			$infoSession .= "Individu baru berhasil disimpan. ";
		else
			$infoSession .= "<font color='red'>Individu baru gagal disimpan. </font>";

		$this->session->set_flashdata("info", $infoSession);
		// redirect($this->session->userdata('user_url'));
		redirect(self::$CURRENT_CONTEXT);
	}

	public function edit_anggota() {
		$infoSession = ''; // added by SKM17

		$objindiv = $this->fetch_input_anggota();
		$id_indiv = $this->input->post('id_individu');
		
		if ($this->individu_dao->editIndividu($id_indiv, $objindiv))
			$infoSession .= "Data Individu berhasil diubah. ";
		else
			$infoSession .= "<font color='red'>Data Individu gagal diubah. </font>";

		$this->session->set_flashdata("info", $infoSession);
		redirect($this->session->userdata('user_url'));
	}

	public function del_anggota($id_anggota, $id_keluarga = null){
		$obj_id = array('id_individu' => $id_anggota);

		if ($this->individu_dao->delete($obj_id))
			$this->session->set_flashdata("success", "Hapus Anggota berhasil!");
		else
			$this->session->set_flashdata("failed", "Hapus Anggota gagal! Cek apakah data keluarga memiliki data anggota yang terhubung.");

		redirect(self::$CURRENT_CONTEXT . '/edit/' . $id_keluarga);
	}
	
	function role_user() {
		$user_id = $this->tank_auth->get_user_id();
		// $user = $this->user_role_dao->fetch_record($user_id);
		$this->data['permission'] = 'admin';

		// if (trim($user->role_name) == 'viewer') {
		// 	redirect('html/map_clean');
		// }
	}
	
	function logged_in() {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('home/login');
		}
	}
}