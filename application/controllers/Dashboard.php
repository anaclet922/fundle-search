<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('header');
		$this->load->view('login');
		$this->load->view('footer');
	}


	public function post_login(){

		$password = $_POST['password'];
		$username = $_POST['username'];

		$this->db->where('username', $username);
		$this->db->where('password', strtolower(hash("sha512", $password)));
		$user = $this->db->get("tbl_users")->result_array();

		if(!isset($user[0]['id'])){
			$this->session->set_flashdata('error', 'User not found!');
			redirect($this->agent->referrer());
		}else{
			$this->session->set_userdata('user', $user);
			redirect('dashboard/home');
		}

	}

	public function home(){

		$counts = $this->GetContents('counts');
		$queries = $this->GetContents('queries');
		$clicks = $this->GetContents('clicks');

		// echo '<pre>';print_r(json_decode($counts, true));

		$this->load->view('header');
		$this->load->view('dashboard');
		$this->load->view('footer');
	}

	function GetContents($t){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fundle-90b183.ent.us-central1.gcp.cloud.es.io/api/as/v1/engines/fundle-search-engine/analytics/" . $t);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
			'Authorization: Bearer private-7bw32q2ncuz4trj15f8ysoky'
		));
        $output = curl_exec($ch);
        curl_close($ch); 

        return $output;
	}


}
