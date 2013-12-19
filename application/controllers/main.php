<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    private $tbgames = "tbgames";
    private $tbvoucher = "tbvoucher";
    private $tbpic = "tbpic";

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    public function index()
    {
        $data['sTitle'] = "Chơi game đuổi hình bắt chữ";
        $data['sBody'] = $this->load->view("start_v", $data, true);
        $this->render($data);
    }

    private function render($data = array())
    {
        $data['sTitle'] = $data['sTitle'] . ' - ' . $this->config->item("sitename") . ' - ' . $this->config->item('suffix');
        $this->load->view("container_v", $data);
    }

    public function admin()
    {
        $data['sTitle'] = "Admin page";
        $data['sTQ'] = $this->load->view('admin_tq_v', $data, true);
        $data['sBody'] = $this->load->view("admin_v", $data, true);
        $this->render($data);
    }

    public function admingame()
    {
        $data = array();
        echo $this->load->view('admin_game_v', $data, true);
    }

    public function adminvoucher()
    {
        $data = array();
        echo $this->load->view('admin_voucher_v', $data, true);
    }

    public function savegame()
    {
        $param = array(
            'tbdatefrom' => strtotime($this->input->post("tbdatefrom")),
            'tbdateto' => strtotime($this->input->post("tbdateto")),
            'tbactive' => $this->input->post("tbactive"),
        );
        if ($this->input->post("edit") != "") //update
        {
            $str = $this->db->update_string($this->tbgames, $param, " id = " . $this->input->post("edit"));
            if ($this->db->query($str)) echo 1;
            else echo 0;
        }
        else { //insert
            $str = $this->db->insert_string($this->tbgames, $param);
            if ($this->db->query($str)) echo $this->db->insert_id();
            else echo 0;
        }

    }

    public function adminloadgame($page = 0)
    {
        $sql = "SELECT * FROM " . $this->tbgames . " ORDER BY id DESC LIMIT " . ($page - 1) . ", " . $this->config->item('pp');
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $rs = $qr->result();
            $data['games'] = $rs;
            $sql = "SELECT count(id) numrows FROM " . $this->tbgames;
            $qr = $this->db->query($sql);
            $data['sumpage'] = ceil($qr->row()->numrows / $this->config->item('pp'));
            $data['page'] = $page;
            echo $this->load->view("listgame_v", $data, true);
        }
        else echo "";
    }

    public function loadeditgame($id = 0)
    {
        $sql = "SELECT * FROM " . $this->tbgames . " WHERE id=$id ";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $rs = $qr->result_array();
            $rs = $rs[0];
            $rs['tbdatefrom'] = date("Y-m-d H:i:s", $rs['tbdatefrom']);
            $rs['tbdateto'] = date("Y-m-d H:i:s", $rs['tbdateto']);
            $this->mylibs->echojson($rs);
        }
        else echo "";
    }

    public function calljupload()
    {
        $this->load->helper("jupload");
        $configs['upload_dir'] = dirname($_SERVER['SCRIPT_FILENAME']) . '/././images/';
        $configs['upload_url'] = base_url() . 'images/';
        $configs['thumbnail'] = array(
            'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']) . '/././thumbnails/',
            'upload_url' => base_url() . 'thumbnails/',
            'max_width' => 200,
            'max_height' => 200
        );
        $upload_handler = jupload($configs);

        header('Pragma: no-cache');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Content-Disposition: inline; filename="files.json"');
        header('X-Content-Type-Options: nosniff');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'OPTIONS':
                break;
            case 'HEAD':
            case 'GET':
                $upload_handler->get();
                break;
            case 'POST':
                if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
                    $upload_handler->delete();
                }
                else {
                    $upload_handler->post();
                }
                break;
            case 'DELETE':
                $upload_handler->delete();
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
        }
    }

    function delfile($filename, $deldb = 0)
    {
        //important!!! need admin permission here
        try {
            if ($deldb == 1) {
                $sql = "DELETE FROM " . $this->tbpic . " WHERE tbpic='$filename'";
                $this->db->query($sql);
            }
            unlink(dirname($_SERVER['SCRIPT_FILENAME']) . "/././images/" . $filename);
            unlink(dirname($_SERVER['SCRIPT_FILENAME']) . "/././thumbnails/" . $filename);

            echo 1;
        }
        catch (Exception $ex) {
            echo 0;
        }
    }

    public function savegamepic($id)
    {
        $sql = "SELECT count(id) numr FROM " . $this->tbgames . " WHERE id=$id";
        $qr = $this->db->query($sql);
        if ($qr->row()->numr == 1) {
            $aNewPic = explode(",", $this->input->post("img"));
            $aResult = explode(",", $this->input->post("result"));
            $aResultvn = explode(",", $this->input->post("resultvn"));
            $aCountword = explode(",", $this->input->post("countword"));
            $sVal = "";

            for ($i = 0; $i < count($aNewPic); $i++) {
                $pic = $aNewPic[$i];
                if (trim($pic) == "") continue;
                $result = $aResult[$i];
                $resultvn = $aResultvn[$i];
                $countword = $aCountword[$i];
                if ($sVal != "") $sVal .= ",";
                $sVal .= "('$pic','$id','$result','$resultvn','$countword')";
            }
            if ($sVal != "") {
                $sql = "INSERT INTO " . $this->tbpic . " (tbpic,tbgames_id,tbresult,tbresultvn,tbcountword) VALUES " . $sVal;
                echo $this->db->query($sql);
            }
            else {
                return 0;
            }

        }
        else {
            echo -1;
        }
    }

    public function loadgamepic($id)
    {
        $sql = "SELECT * FROM " . $this->tbpic . " WHERE tbgames_id=$id";
        $qr = $this->db->query($sql);
        if ($qr->num_rows() > 0) {
            $arr = $qr->result_array();
            $this->mylibs->echojson($arr);
        }
        else {
            echo 0;
        }
    }

    public function updateoldpic($id)
    {
        $sql = "SELECT count(id) numr FROM " . $this->tbgames . " WHERE id=$id";
        $qr = $this->db->query($sql);
        if ($qr->row()->numr == 1) {
            $aNewPic = explode(",", $this->input->post("img"));
            $aResult = explode(",", $this->input->post("result"));
            $aResultvn = explode(",", $this->input->post("resultvn"));
            $aCountword = explode(",", $this->input->post("countword"));
            $sVal = "";
            $kq = 0;
            for ($i = 0; $i < count($aNewPic); $i++) {
                $pic = $aNewPic[$i];
                if (trim($pic) == "") continue;
                $result = $aResult[$i];
                $resultvn = $aResultvn[$i];
                $countword = $aCountword[$i];
                if ($sVal != "") $sVal .= ",";
//                $sVal .= "('$pic','$id','$result','$resultvn','$countword')";
                $sql = "UPDATE " . $this->tbpic . " SET tbresult='$result',tbresultvn='$resultvn',tbcountword='$countword' WHERE tbpic='$pic'";
                $kq += $this->db->query($sql);

            }
            echo $kq;

        }
        else {
            echo -1;
        }

    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */