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
        $sql = "SELECT * FROM franchies";
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
        $success=false;
        $msg="";
        $redirect_url="";
        $error_msg="";
        if($_POST && count($_POST)>0){
            $this->form_validation->set_rules('FranchiesName', 'Franchies Name', 'trim|required');
            $this->form_validation->set_rules('AssociatesType', 'Associates Type', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $error_msg=validation_errors();
                $msg="Data Validation Error Occured!";
                $success=false;
            } else {
                $data=array(
                    'AssociatesType'=> $this->input->post('AssociatesType'),
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
                    'Incentive'=>$this->input->post('Incentive'),
                    'BasicPay'=>$this->input->post('BasicPay'),
                    'Status'=>'Active'
                );

                $r_id=$this->input->post('RecordID');
                if(empty($r_id)){
                    $array = array('email' => $this->input->post('Email'));
                    $this->db->select('*');
                    $this->db->from('users');
                    $this->db->where($array);
                    $query=$this->db->get();
                    //  echo $this->db->last_query();
                    if ($query->num_rows() == 0) {
                        $success_msg =  'Associates added successfully';
                        $this->db->insert('franchies', $data);
                        $insert_id=$this->db->insert_id();
                        $parent_idd=$this->input->post('ParentAssociates');
                        if(!empty($parent_idd)){
                            $parent_id=$this->input->post('ParentAssociates');
                        }else{
                            $parent_id=$this->session->userdata('logged_id');
                        }
                        $addUser=array(
                            'email'=>$this->input->post('Email'),
                            'password'=>password_hash('welcome@@', PASSWORD_DEFAULT, array('cost' => 10)),
                            'role'=>$this->input->post('AssociatesType'),
                            'status'=>"1",
                            'controller_id'=>$insert_id,
                            'parent_id'=>$parent_id
                        );
                        $this->db->insert('users', $addUser);
                        $success=true;
                        $msg="Associates Added Successfully";
                    }else{
                        $msg="This Email is already Registered!";
                        $success=false;
                    }
                }else{
                    $this->db->where('Id',$this->input->post('RecordID'));
                    $this->db->update('franchies', $data);
                }
                $associates_type=$this->input->post('AssociatesType');
                if ($this->db->affected_rows() > 0) {
                    $redirect_url=$this->config->item('AdminUrls');
                    $redirect_url=$redirect_url[$associates_type];
                } else {
                    if(empty($r_id)){
                        $msg ='Something went wrong !';
                        $success=false;
                    }else{
                        //redirect('franchies');
                        $redirect_url='';
                        $success=true;
                        $msg =  'Associates updated successfully';
                    }
                }
            }
            unset ($_POST);
            $data=array('success'=>$success,'msg'=>$msg,'redirect_url'=>$redirect_url);
            echo json_encode($data);die;
        }else{
            $sql = "SELECT * FROM countries";
            $query = $this->db->query($sql);
            $result=$query->result_array();
            $form_data=new stdClass();
            if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
                $sql = "SELECT * FROM franchies where Id=".$_REQUEST['id'];
                $query = $this->db->query($sql);
                $form_data=$query->row();
            }
            $data=array('success'=>true,'country_data'=>$result,'form_data'=>$form_data);
            $this->load->view('header');
            $this->load->view('franchies/add',$data);
            $this->load->view('footer');
        }

    }

    public function get_parent_associates(){
        if (isset($_POST) && count($_POST)>0) {
            $country=$this->input->post('country');
            $state=$this->input->post('state');
            $city=$this->input->post('city');
            $area=$this->input->post('area');
            $type=$this->input->post('type');
            $parents=$this->config->item('ControllerParents');
            $parent_type=$parents[$type];
            $result=array();
            if($parent_type){
                $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id WHERE f.AssociatesType='$parent_type' and f.State='$state' and f.City='$city'";
                $query = $this->db->query($sql);
                $result=$query->result_array();
            }
            $data=array('success'=>true,'data'=>$result);
            echo json_encode($data);die;
        }
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
            $sql = "SELECT distinct city_name as name FROM all_population WHERE state_name = ?";
           // $sql = "SELECT * FROM cities WHERE state_id = ?";
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
            $sql = "SELECT * FROM all_population WHERE city_name = ?";
            $query = $this->db->query($sql, $id);
            $result=$query->result_array();
            $data=array('success'=>true,'data'=>$result);
            echo json_encode($data);die;
        }
    }
}
