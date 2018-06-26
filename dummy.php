<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Franchies extends CI_Controller {
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
    public function index()
    {
        $sql = "SELECT f.*,c.name as city_name,a.name as area_name FROM franchies as f left join cities as c on c.id=f.city left join area as a on a.id=f.area";
        $query = $this->db->query($sql);
        $result=$query->result_array();
        $data=array('success'=>true,'franchies'=>$result);

        $this->load->view('header');
        $this->load->view('franchies/index',$data);
        $this->load->view('footer');

    }
    public function addfranchies()
    {
        $data=array();
        $sql = "SELECT * FROM countries";
        $query = $this->db->query($sql);
        $result=$query->result_array();
        $form_data=new stdClass();
        if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
            $sql = "SELECT * FROM franchies where Id=".$_REQUEST['id'];
            $query = $this->db->query($sql);
            $form_data=$query->row();
        }
        $success_msg="";
        $error_msg="";
        if($_POST && count($_POST)>0){
            $this->form_validation->set_rules('FranchiesName', 'Franchies Name', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $error_msg=validation_errors();
                $data=array('success'=>false,'country_data'=>$result,'success_msg'=>$success_msg,'error_msg'=>$error_msg);
                $this->load->view('franchies/add',$data);
                return;
            } else {
                $data=array(
                    'FranchiesName' => $this->input->post('FranchiesName'),
                    'OwnerName'=>$this->input->post('OwnerName'),
                    'Address'=>$this->input->post('Address'),
                    'Country'=>$this->input->post('Country'),
                    'State'=>$this->input->post('State'),
                    'City'=>$this->input->post('City'),
                    'Area'=>$this->input->post('Area'),
                    'Phone'=>$this->input->post('Phone'),
                    'Email'=>$this->input->post('Email'),
                    'Description'=>$this->input->post('Description'),
                );
                if(!empty($this->input->post('RecordID'))){

                    $this->db->where('Id',$this->input->post('RecordID'));
                    $this->db->update('franchies', $data);
                }else{
                    $success_msg =  'Franchies added successfully';
                    $this->db->insert('franchies', $data);
                }


                if ($this->db->affected_rows() > 0) {
                } else {
                    if(!empty($this->input->post('RecordID'))){
                        $success_msg =  'Franchies updated successfully';
                    }else{
                        $success_msg =  '';
                        $error_msg ='Something went wrong !';
                    }
                }
            }
            unset ($_POST);
        }
        $data=array('success'=>true,'country_data'=>$result,'success_msg'=>$success_msg,'error_msg'=>$error_msg,'form_data'=>$form_data);
        $this->load->view('header');
        $this->load->view('franchies/add',$data);
        $this->load->view('footer');

    }

    public function DeleteFranchies(){
        $data=array();
        $success_msg="";
        $error_msg="";
        if($_POST){
            $this->db->where('Id', $_POST['id']);
            $this->db->delete('franchies');
            if ($this->db->affected_rows() > 0) {
                $success_msg =  'Franchies Deleted successfully';
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
    public function GetArea()
    {
        if ($_POST) {
            $id=$this->input->post('Id');
            $sql = "SELECT * FROM area WHERE city_id = ?";
            $query = $this->db->query($sql, $id);
            $result=$query->result_array();
            $data=array('success'=>true,'data'=>$result);
            echo json_encode($data);die;
        }
    }
}


"INSERT INTO all_population(state_name,city_name,area_name,total_type,total_population)
SELECT State_UTs_Name,District_Name,Name,Total_Rural_Urban,Total_Population_Person
    FROM ahmadnagar";
