<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        $data['sTitle'] = "Chơi game đuổi hình bắt chữ";
        $data['sBody'] = $this->load->view("start_v",$data,true);
        $this->render($data);
	}
    private function render($data = array()){
        $data['sTitle'] = $data['sTitle'].' - '.$this->config->item("sitename"). ' - '.$this->config->item('suffix');
        $this->load->view("container_v",$data);
    }
    public function admin(){
        $data['sTitle'] = "Admin page";
        $data['sTQ'] = $this->load->view('admin_tq_v',$data,true);
        $data['sBody'] = $this->load->view("admin_v",$data,true);
        $this->render($data);
    }
    public function admingame(){
        $data = array();
         echo $this->load->view('admin_game_v',$data,true);
    }
    public function adminvoucher(){
        $data = array();
        echo $this->load->view('admin_voucher_v',$data,true);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */