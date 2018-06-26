<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {
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
        $sql = 'SELECT sa.*,s.title as title FROM sales as sa inner JOIN stock as s on s.id=sa.product_id';
        $query = $this->db->query( $sql);
        $result=  $query->result_array();
        $data = array( 'success'=>true, 'data'=>$result);

        $this->load->view('header');
        $this->load->view('sales/index', $data);
        $this->load->view('footer');
    }

    public function available_stock(){
        $product=array();
        $sql = "SELECT s.*, quantity - IFNULL(TotalSold, 0) as available_stock
                    FROM stock s
                    LEFT JOIN (SELECT id,product_id,IFNULL(sum(quantity), 0) AS TotalSold
                    FROM sales      
                    GROUP BY product_id) as sa ON sa.product_id = s.id";

        $query = $this->db->query($sql);
        $product=$query->result_array();
        $data=array('data'=>$product);
        $this->load->view('header');
        $this->load->view('sales/available_stock', $data);
        $this->load->view('footer');
    }

    public function all_orders(){
        $user_id=$this->logged_id;
        if($this->user_role=="Admin"){
            $sql = 'SELECT so.*,p.product_title as title,f.FranchiesName from sales_order as so inner join products as p on p.id=so.product_id left join users as u on u.id=so.user_id left join franchies as f on f.Id=u.controller_id';
        }elseif($this->user_role=="Area Sales Controller"){
            $user_ids=$this->getChildAreaSalesUser($user_id);
            $sql = "SELECT so.*,p.product_title as title,f.FranchiesName from sales_order as so inner join products as p on p.id=so.product_id left join users as u on u.id=so.user_id left join franchies as f on f.Id=u.controller_id where so.user_id IN ($user_ids)";
        }elseif($this->user_role=="Plant Sales Controller"){
            $user_ids=$this->getChildPlantSalesUser($user_id);
            $sql = "SELECT so.*,p.product_title as title,f.FranchiesName from sales_order as so inner join products as p on p.id=so.product_id left join users as u on u.id=so.user_id left join franchies as f on f.Id=u.controller_id where so.user_id IN ($user_ids)";
        }elseif($this->user_role=="Industrial Sales Controller"){
            $user_ids=$this->getChildIndustrialSalesUser($user_id);
            $sql = "SELECT so.*,p.product_title as title,f.FranchiesName from sales_order as so inner join products as p on p.id=so.product_id left join users as u on u.id=so.user_id left join franchies as f on f.Id=u.controller_id where so.user_id IN ($user_ids)";
        }elseif($this->user_role=="Sales Jobber"){
            $sql = "SELECT so.*,p.product_title as title,f.FranchiesName from sales_order as so inner join products as p on p.id=so.product_id left join users as u on u.id=so.user_id left join franchies as f on f.Id=u.controller_id where so.user_id ='$user_id'";
        }

        $query = $this->db->query( $sql);
        $result=  $query->result_array();
        $data = array( 'success'=>true, 'data'=>$result);
        $this->load->view('header');
        $this->load->view('sales/all_orders', $data);
        $this->load->view('footer');
    }

    public function generate_order(){

        $data =array();
        $success=false;
        $error_msg="";
        $msg="";
        if( $_POST && count($_POST)>0)
        {
            $this->form_validation->set_rules("product_id", "Product Title", "trim|required");
            $this->form_validation->set_rules("quantity", "Quantity", "trim|required");

            if ($this->form_validation->run() == FALSE) {
                $error_msg=validation_errors();
                $success=false;
                $msg="Validation Error";
            }
            else{
                $data = array(
                    'product_id'=> $this->input->post('product_id'),
                    'order_quantity' => $this->input->post('quantity'),
                    'quantity' => $this->input->post('quantity'),
                    'description' => $this->input->post('description'),
                    'order_date' => date('Y-m-d H:i:s'),
                    'approval_status' => 'Pending',
                    'user_id' => $this->session->userdata('logged_id')
                );

                $r_id=$this->input->post('RecordID');
                if(empty($r_id)){
                    if($this->db->insert('sales_order', $data)){
                        $msg = "Stock Order Request Generated Successfully";
                        $success=true;
                    }else{
                        $msg = "Please Try Again";
                        $success=false;
                    }
                }else{
                    $this->db->where('id',$this->input->post('RecordID'));
                    $this->db->update('sales_order', $data);
                    $msg = "Stock Order Request Updated Successfully";
                    $success=true;
                }
            }
            $data=array('success'=>$success,'msg'=>$msg,'error_msg'=>$error_msg);
            echo json_encode($data);die;
        }else{
            $product_list=array();
            $product_list=$this->db->query("select * from products where status='Active'")->result_array();
            $data=array('data'=>array(),'products'=>$product_list);
            $this->load->view('header');
            $this->load->view('sales/generate_order', $data);
            $this->load->view('footer');
        }
    }

    public function add_sales()
    {
        $data =array();
        $success=false;
        $error_msg="";
        $msg="";
        if( $_POST && count($_POST)>0)
        {
            $this->form_validation->set_rules("product_id", "Product Title", "trim|required");
            $this->form_validation->set_rules("price", "Price", "trim|required");
            $this->form_validation->set_rules("quantity", "Quantity", "trim|required");
            $this->form_validation->set_rules("sales_date", "Sales Date", "trim|required");

            if ($this->form_validation->run() == FALSE) {
                $error_msg=validation_errors();
                $success=false;
                $msg="Validation Error";
            }
            else{
                $data = array(
                    'product_id'=> $this->input->post('product_id'),
                    'price' => $this->input->post('price'),
                    'quantity' => $this->input->post('quantity'),
                    'description' => $this->input->post('description'),
                    'sales_date' => $this->input->post('sales_date'),
                    'entry_date' => date('Y-m-d'),
                    'status' => 'Active',
                    'user_id' => $this->session->userdata('logged_id'),
                    'controller_id' => $this->session->userdata('logged_controller')
                );

                $r_id=$this->input->post('RecordID');
                if(empty($r_id)){
                    if($this->db->insert('sales', $data)){
                        $msg = "Sales Added Successfully";
                        $success=true;
                    }else{
                        $msg = "Please Try Again";
                        $success=false;
                    }
                }else{
                    $this->db->where('id',$this->input->post('RecordID'));
                    $this->db->update('sales', $data);
                    $msg = "Sales Updated Successfully";
                    $success=true;
                }

            }
            $data=array('success'=>$success,'msg'=>$msg,'error_msg'=>$error_msg);
            echo json_encode($data);die;
        }else{
            $form_data=new stdClass();
            $edit_id=$this->input->get('id');
            if(isset($edit_id) && !empty($edit_id)){
                $sql = "SELECT * FROM sales where id=".$edit_id;
                $query = $this->db->query($sql);
                $form_data=$query->row();
            }
            $product=array();
            $sql = "SELECT s.*, quantity - IFNULL(TotalSold, 0) as available_stock
                    FROM stock s
                    LEFT JOIN (SELECT id,product_id,IFNULL(sum(quantity), 0) AS TotalSold
                    FROM sales      
                    GROUP BY product_id) as sa ON sa.product_id = s.id";

            $query = $this->db->query($sql);
            $product=$query->result_array();
            $data=array('data'=>$form_data,'products'=>$product);
            $this->load->view('header');
            $this->load->view('sales/add_sales', $data);
            $this->load->view('footer');
        }
    }

    public function arealist(){
        //$sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Area Sales Controller'";
        $user_id=$this->logged_id;
        if($this->user_role=="Admin"){
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Area Sales Controller'";
        }else{
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Area Sales Controller' and u.id='$user_id'";
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
            $total_sales =$this->db->query("SELECT sum(quantity) as total_sold FROM sales_order where approval_status='Approved' and user_id in ($in)")->row()->total_sold;
            $new_result[$key]['total_sales']=$total_sales;
            $incent=($total_sales*$incentive);
            $new_result[$key]['basic_pay']=$basic_pay;
            $new_result[$key]['incentive']=$incent;
            $total_pay=floatval($incent)+floatval($basic_pay);
            $new_result[$key]['total_pay']=$total_pay;
        }
        $data=array('success'=>true,'franchies'=>$new_result);
        $this->load->view('header');
        $this->load->view('sales/area/index',$data);
        $this->load->view('footer');
    }

    public function plantlist(){
        $user_id=$this->logged_id;
        if($this->user_role=="Admin"){
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Plant Sales Controller'";
        }elseif($this->user_role=="Plant Sales Controller"){
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Plant Sales Controller' and u.id='$user_id'";
        }else{
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Plant Sales Controller' and u.parent_id='$user_id'";
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
            $total_sales =$this->db->query("SELECT sum(quantity) as total_sold FROM sales_order where approval_status='Approved' and user_id in ($in)")->row()->total_sold;
            $new_result[$key]['total_sales']=$total_sales;
            $incent=($total_sales*$incentive);
            $new_result[$key]['basic_pay']=$basic_pay;
            $new_result[$key]['incentive']=$incent;
            $total_pay=floatval($incent)+floatval($basic_pay);
            $new_result[$key]['total_pay']=$total_pay;
        }

        $data=array('success'=>true,'franchies'=>$new_result);

        $this->load->view('header');
        $this->load->view('sales/plant/index',$data);
        $this->load->view('footer');
    }

    public function industriallist(){
        $user_id=$this->logged_id;
        $result=array();
        if($this->user_role=="Admin"){
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Industrial Sales Controller'";
        }elseif($this->user_role=="Industrial Sales Controller"){
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Industrial Sales Controller' and u.id='$user_id'";
        }elseif($this->user_role=="Area Sales Controller"){
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Industrial Sales Controller' and u.parent_id IN (SELECT id FROM users where parent_id='$user_id')";
        }elseif($this->user_role=="Plant Sales Controller"){
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Industrial Sales Controller' and u.parent_id='$user_id'";
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
            $total_sales =$this->db->query("SELECT sum(quantity) as total_sold FROM sales_order where approval_status='Approved' and user_id in ($in)")->row()->total_sold;
            $new_result[$key]['total_sales']=$total_sales;
            $incent=($total_sales*$incentive);
            $new_result[$key]['basic_pay']=$basic_pay;
            $new_result[$key]['incentive']=$incent;
            $total_pay=floatval($incent)+floatval($basic_pay);
            $new_result[$key]['total_pay']=$total_pay;
        }

        $data=array('success'=>true,'franchies'=>$new_result);


        $this->load->view('header');
        $this->load->view('sales/industrial/index',$data);
        $this->load->view('footer');
    }

    public function jobberlist(){
        $user_id=$this->logged_id;
        if($this->user_role=="Admin"){
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Sales Jobber'";
        }elseif($this->user_role=="Sales Jobber"){
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id where f.AssociatesType='Sales Jobber' and u.id='$user_id'";
        }elseif($this->user_role=="Area Sales Controller"){
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id 
                  where f.AssociatesType='Sales Jobber' and u.parent_id IN 
                  (SELECT id FROM users where parent_id IN (SELECT id from users where parent_id='$user_id'))";
        }elseif($this->user_role=="Plant Sales Controller"){
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id 
                  where f.AssociatesType='Sales Jobber' and u.parent_id IN 
                   (SELECT id FROM users where parent_id='$user_id')";
        }elseif($this->user_role=="Industrial Sales Controller"){
            $sql = "SELECT f.*,u.id as user_id FROM franchies as f inner join users as u on u.controller_id=f.Id 
                  where f.AssociatesType='Sales Jobber' and u.parent_id='$user_id'";
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

            $total_sales =$this->db->query("SELECT sum(quantity) as total_sold FROM sales_order where approval_status='Approved' and user_id='$user_id'")->row()->total_sold;
            $new_result[$key]['total_sales']=$total_sales;
            $incent=($total_sales*$incentive);
            $new_result[$key]['incentive']=$incent;
            $new_result[$key]['basic_pay']=$basic_pay;
            $total_pay=floatval($incent)+floatval($basic_pay);
            $new_result[$key]['total_pay']=$total_pay;
        }

        $data=array('success'=>true,'franchies'=>$new_result);

        $this->load->view('header');
        $this->load->view('sales/jobber/index',$data);
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

    public function DeleteSales(){
        $data=array();
        $success_msg="";
        $error_msg="";
        if($_POST){
            $this->db->where('Id', $_POST['id']);
            $this->db->delete('sales');
            if ($this->db->affected_rows() > 0) {
                $success_msg =  'Sales Deleted successfully';
            } else {
                $error_msg ='Something went wrong !';
            }
            unset ($_POST);
        }
        $data=array('success'=>true,'success_msg'=>$success_msg,'error_msg'=>$error_msg);
        echo json_encode($data);
    }

    public function DeleteSalesOrder(){
        $data=array();
        $success_msg="";
        $error_msg="";
        if($_POST){
            $this->db->where('Id', $_POST['id']);
            $this->db->where('approval_status', 'Pending');
            $this->db->delete('sales_order');
            if ($this->db->affected_rows() > 0) {
                $success_msg =  'Sales Order Deleted successfully';
                $success=true;
            } else {
                $success=false;
                $error_msg ='You Cannot delete this order';
            }
            unset ($_POST);
        }
        $data=array('success'=>$success,'success_msg'=>$success_msg,'error_msg'=>$error_msg);
        echo json_encode($data);
    }

    public function getChildAreaSalesUser($user_id){
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
        return $in;
    }

    public function getChildPlantSalesUser($user_id){
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
        return $in;
    }

    public function getChildIndustrialSalesUser($user_id){
        $jobber_user = $this->db->query("select id from users where parent_id='$user_id'")->result_array();
        $total_user=$jobber_user;
        $in=$user_id.',';
        if(count($total_user)>0){
            foreach ($total_user as $u){
                $in.=$u['id'].",";
            }
        }
        $in=substr($in, 0, -1);
        return $in;
    }
}
