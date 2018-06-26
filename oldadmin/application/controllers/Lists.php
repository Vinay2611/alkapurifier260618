<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lists extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // Load form helper library
        $this->load->helper('form');
        // Load form validation library
        $this->load->library('form_validation');
        // Load session library
        $this->load->library('session');
        // Load database
        $this->load->database();
        /* $this->load->model('login_database');*/
        if(!$this->session->userdata('is_logged_in'))
        {
            redirect('login');
        }
    }
    public function country()
    {
        $sql = "SELECT * from countries";
        $query = $this->db->query($sql);
        $result=$query->result_array();
        $data=array('success'=>true,'countries'=>$result);
        $this->load->view('header');
        $this->load->view('lists/country',$data);
        $this->load->view('footer');

    }
    public function State()
    {
        $sql = "SELECT s.*,c.name as country_name from states as s inner JOIN countries as c on c.id=s.country_id";
        $query = $this->db->query($sql);
        $result=$query->result_array();
        $data=array('success'=>true,'states'=>$result);
        $this->load->view('header');
        $this->load->view('lists/state',$data);
        $this->load->view('footer');

    }
    public function City()
    {
        $sql = "SELECT c.*,s.name as state_name from cities as c inner join states as s on s.id=c.state_id where s.country_id='101'";
        $query = $this->db->query($sql);
        $result=$query->result_array();
        $data=array('success'=>true,'city'=>$result);
        $this->load->view('header');
        $this->load->view('lists/city',$data);
        $this->load->view('footer');

    }
    public function Area()
    {
        $sql = "SELECT * FROM countries";
        $get_result=$this->db->query($sql);
        $result=$get_result->result_array();
        $form_data=new stdClass();
        if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
            $sql = "SELECT a.*,s.id as state_id,co.id as country_id FROM area as a inner join cities as c on c.id=a.city_id inner join states as s on s.id=c.state_id inner join countries as co on co.id=s.country_id where a.id=".$_REQUEST['id'];
            $query = $this->db->query($sql);
            $form_data=$query->row();
        }

        $sql2 = "SELECT a.*,c.name as city_name from area as a inner JOIN cities as c on c.id=a.city_id";
        $query = $this->db->query($sql2);
        $result2=$query->result_array();
        $data=array('success'=>true,'area'=>$result2,'countries'=>$result,'form_data'=>$form_data);
        $this->load->view('header');
        $this->load->view('lists/area',$data);
        $this->load->view('footer');

    }
    public function AddArea(){
        $data=array();
        $success_msg="";
        $error_msg="";
        if($_POST){
            $data=array(
                'city_id'=>$this->input->post('City'),
                'name'=>$this->input->post('Area'),
                'population'=>$this->input->post('Population'),
            );
            $this->db->insert('area', $data);

            if ($this->db->affected_rows() > 0) {
                $success_msg =  'Area added successfully';
            } else {
                $error_msg ='Something went wrong !';
            }
            unset ($_POST);
        }
        $data=array('success'=>true,'success_msg'=>$success_msg,'error_msg'=>$error_msg);
        echo json_encode($data);
    }

    public function DeleteArea(){
        $data=array();
        $success_msg="";
        $error_msg="";
        if($_POST){
            $this->db->where('id', $_POST['id']);
            $this->db->delete('area');
            if ($this->db->affected_rows() > 0) {
                $success_msg =  'Area Deleted successfully';
            } else {
                $error_msg ='Something went wrong !';
            }
            unset ($_POST);
        }
        $data=array('success'=>true,'success_msg'=>$success_msg,'error_msg'=>$error_msg);
        echo json_encode($data);
    }

    public function GetStates()
    {
        if ($_POST) {
            $id=$this->input->post('Id');
            $sql = "SELECT * FROM states WHERE country_id = ?";
            $query = $this->db->query($sql, $id);
            $result=$query->result_array();
            $data=array('success'=>true,'data'=>$result);
            echo json_encode($data);die;
        }
    }
    public function GetCities()
    {
        if ($_POST) {
            $id=$this->input->post('Id');
            $sql = "SELECT * FROM cities WHERE state_id = ?";
            $query = $this->db->query($sql, $id);
            $result=$query->result_array();
            $data=array('success'=>true,'data'=>$result);
            echo json_encode($data);die;
        }
    }
}
