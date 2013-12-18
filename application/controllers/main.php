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
    private $tbgames = "tbgames";
    private $tbvoucher = "tbvoucher";

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
    public  function savegame(){
        $param = array(
            'tbdatefrom' => strtotime($this->input->post("tbdatefrom")),
            'tbdateto' => strtotime($this->input->post("tbdateto")),
            'tbactive' => $this->input->post("tbactive"),            
        );
        if ($this->input->post("edit") != "") //update
        {
            $str = $this->db->update_string($this->tbgames, $param, " id = " . $this->input->post("edit"));
            if ($this->db->query($str)) echo $this->db->insert_id();
        else echo 0;
        } else { //insert
            $str = $this->db->insert_string($this->tbgames, $param);
            if ($this->db->query($str)) echo $this->db->insert_id();
            else echo 0;
        }
        
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */