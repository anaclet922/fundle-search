<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
		$this->db->order_by('id', 'DESC');
		$this->db->limit(3);

		$data['history'] = $this->db->get('tbl_keywords')->result_array();

		$this->load->view('header');
		$this->load->view('home', $data);
		$this->load->view('footer');
	}

	public function save_search(){
		$post = file_get_contents('php://input');
		$post_array = json_decode($post, true);

		$data = array(
			'word' => $post_array['query']
		);
		$this->db->insert('tbl_keywords', $data);
		echo 'ok';
	}

	public function sign_out(){
		$this->session->sess_destroy();
		redirect('/');
	}
}
