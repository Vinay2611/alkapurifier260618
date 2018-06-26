<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production extends CI_Controller {
    public $user_role;
    public $logged_id;
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

        $this->logged_id = $this->session->userdata('logged_id');
        $this->user_role = $this->session->userdata('logged_role');
    }
    public function index()
    {
        echo "Hello";
    }
    public function arealist(){
       // $sql = "SELECT * FROM franchies where AssociatesType='Area Production Controller'";
        $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Area Production Controller'";
        $query = $this->db->query($sql);
        $result=$query->result_array();
        $new_result=array();
        foreach ($result as $key=>$val){
            $new_result[$key]=$val;
            $user_id=$val['user_id'];
            $basic_pay=$val['BasicPay'];
            $incentive=$val['Incentive'];
            $incentive = str_replace('%', '', $incentive);
            $plant_user = $this->db->query("select id from users where parent_id='$user_id'")->result_array();
            $industrial_user = $this->db->query("SELECT id
            FROM users
            WHERE parent_id IN 
                   (SELECT id 
            FROM users where parent_id='$user_id')")->result_array();

            $jobber_user = $this->db->query("SELECT id
                  FROM users
                 WHERE parent_id IN 
                       (SELECT id 
          FROM users where parent_id IN (SELECT id from users where parent_id='$user_id'))")->result_array();

            $total_user=array_merge($plant_user,$industrial_user,$jobber_user);
            $in=$user_id.',';
            if(count($total_user)>0){
                foreach ($total_user as $u){
                    $in.=$u['id'].",";
                }
            }
            $in=substr($in, 0, -1);
            $total_stock =$this->db->query("SELECT sum(quantity) as total_stock FROM stock_detail where added_by in ($in)")->row()->total_stock;
            $new_result[$key]['total_stock']=$total_stock;
            $incent=($total_stock*$incentive);
            $new_result[$key]['basic_pay']=$basic_pay;
            $new_result[$key]['incentive']=$incent;
            $total_pay=floatval($incent)+floatval($basic_pay);
            $new_result[$key]['total_pay']=$total_pay;
        }
        $data=array('success'=>true,'franchies'=>$new_result);
        $this->load->view('header');
        $this->load->view('production/area/index',$data);
        $this->load->view('footer');
    }

    public function plantlist(){
        $user_id=$this->logged_id;
       if($this->user_role=="Admin"){
           $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Plant Production Controller'";
       }else{
           $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Plant Production Controller' and u.parent_id='$user_id'";
       }
        $query = $this->db->query($sql);
        $result=$query->result_array();

        $new_result=array();
        foreach ($result as $key=>$val){
            $new_result[$key]=$val;
            $user_id=$val['user_id'];
            $basic_pay=$val['BasicPay'];
            $incentive=$val['Incentive'];
            $incentive = str_replace('%', '', $incentive);
            $industrial_user = $this->db->query("select id from users where parent_id='$user_id'")->result_array();

            $jobber_user = $this->db->query("SELECT id
            FROM users
            WHERE parent_id IN 
                   (SELECT id 
            FROM users where parent_id='$user_id')")->result_array();

            $total_user=array_merge($industrial_user,$jobber_user);
            $in=$user_id.',';
            if(count($total_user)>0){
                foreach ($total_user as $u){
                    $in.=$u['id'].",";
                }
            }
            $in=substr($in, 0, -1);
            $total_stock =$this->db->query("SELECT sum(quantity) as total_stock FROM stock_detail where added_by in ($in)")->row()->total_stock;
            $new_result[$key]['total_stock']=$total_stock;
            $incent=($total_stock*$incentive);
            $new_result[$key]['basic_pay']=$basic_pay;
            $new_result[$key]['incentive']=$incent;
            $total_pay=floatval($incent)+floatval($basic_pay);
            $new_result[$key]['total_pay']=$total_pay;
        }

        $data=array('success'=>true,'franchies'=>$new_result);

        $this->load->view('header');
        $this->load->view('production/plant/index',$data);
        $this->load->view('footer');
    }

    public function industriallist(){
        $user_id=$this->logged_id;
        if($this->user_role=="Admin"){
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Industrial Production Controller'";
        }else{
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Industrial Production Controller' and u.parent_id='$user_id'";
        }
        $query = $this->db->query($sql);
        $result=$query->result_array();

        $new_result=array();
        foreach ($result as $key=>$val){
            $new_result[$key]=$val;
            $user_id=$val['user_id'];
            $basic_pay=$val['BasicPay'];
            $incentive=$val['Incentive'];
            $incentive = str_replace('%', '', $incentive);
            $jobber_user = $this->db->query("select id from users where parent_id='$user_id'")->result_array();
            $total_user=$jobber_user;
            $in=$user_id.',';
            if(count($total_user)>0){
                foreach ($total_user as $u){
                    $in.=$u['id'].",";
                }
            }
            $in=substr($in, 0, -1);
            $total_stock =$this->db->query("SELECT sum(quantity) as total_stock FROM stock_detail where added_by in ($in)")->row()->total_stock;
            $new_result[$key]['total_stock']=$total_stock;
            $incent=($total_stock*$incentive);
            $new_result[$key]['incentive']=$incent;
            $new_result[$key]['basic_pay']=$basic_pay;
            $total_pay=floatval($incent)+floatval($basic_pay);
            $new_result[$key]['total_pay']=$total_pay;
        }

        $data=array('success'=>true,'franchies'=>$new_result);


        $this->load->view('header');
        $this->load->view('production/industrial/index',$data);
        $this->load->view('footer');
    }

    public function jobberlist(){
        $user_id=$this->logged_id;
        if($this->user_role=="Admin"){
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where AssociatesType='Production Jobber'";
        }else{
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where AssociatesType='Production Jobber' and u.parent_id='$user_id'";
        }

        $query = $this->db->query($sql);
        $result=$query->result_array();
        //$data=array('success'=>true,'franchies'=>$result);
        $new_result=array();
        foreach ($result as $key=>$val){
            $new_result[$key]=$val;
            $user_id=$val['user_id'];
            $basic_pay=$val['BasicPay'];
            $incentive=$val['Incentive'];
            $incentive = str_replace('%', '', $incentive);

            $total_stock =$this->db->query("SELECT sum(quantity) as total_stock FROM stock_detail where added_by='$user_id'")->row()->total_stock;
            $new_result[$key]['total_stock']=$total_stock;
            $incent=($total_stock*$incentive);
            $new_result[$key]['incentive']=$incent;
            $new_result[$key]['basic_pay']=$basic_pay;
            $total_pay=floatval($incent)+floatval($basic_pay);
            $new_result[$key]['total_pay']=$total_pay;
        }

        $data=array('success'=>true,'franchies'=>$new_result);


        $this->load->view('header');
        $this->load->view('production/jobber/index',$data);
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
}
