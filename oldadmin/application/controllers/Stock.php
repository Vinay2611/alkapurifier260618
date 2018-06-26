<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {
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
        $sql = 'SELECT s.*,p.product_title as title,p.stock_price,p.sales_price,f.FranchiesName FROM stock as s left join products as p on p.id=s.product_id left join Franchies as f on f.Id=s.controller_id';
        $query = $this->db->query( $sql);
        $result=  $query->result_array();
        $data = array( 'success'=>true, 'stock'=>$result);

        $this->load->view('header');
        $this->load->view('stock/index', $data);
        $this->load->view('footer');
    }

    public function all_products()
    {
        $sql = 'SELECT * FROM products';
        //$this->db->where('status','Active');
        $query = $this->db->query( $sql);
        $result=  $query->result_array();
        $data = array( 'success'=>true, 'stock'=>$result);

        $this->load->view('header');
        $this->load->view('stock/all_products', $data);
        $this->load->view('footer');
    }
    public function pending_orders(){
        $sql = "SELECT so.*,p.product_title as title from sales_order as so inner join products as p on p.id=so.product_id order by so.approval_status desc";
        $query = $this->db->query( $sql);
        $result=  $query->result_array();
        $data = array( 'success'=>true, 'data'=>$result);

        $this->load->view('header');
        $this->load->view('stock/pending_orders', $data);
        $this->load->view('footer');
    }

    public function add_products()
    {
        $data =array();
        $success=false;
        $error_msg="";
        $msg="";
        if( $_POST && count($_POST)>0)
        {
            $this->form_validation->set_rules("title", "Product Title", "trim|required");
            $this->form_validation->set_rules("stock_price", "Stock Price", "trim|required");
            $this->form_validation->set_rules("sales_price", "Sales Price", "trim|required");


            if ($this->form_validation->run() == FALSE) {
                $error_msg=validation_errors();
                $success=false;
                $msg="Validation Error";
            }
            else{
                $data = array(
                    'product_title'=> $this->input->post('title'),
                    'stock_price' => $this->input->post('stock_price'),
                    'sales_price' => $this->input->post('sales_price'),
                    'product_description' => $this->input->post('description'),
                    'entry_date' => date('Y-m-d'),
                    'status' => 'Active',
                    'added_by' => $this->session->userdata('logged_id'),
                );

                $r_id=$this->input->post('RecordID');
                if(empty($r_id)){
                    if($this->db->insert('products', $data)){
                        $msg = "Products Added Successfully";
                        $success=true;
                    }else{
                        $msg = "Please Try Again";
                        $success=false;
                    }
                }else{
                    $this->db->where('id',$this->input->post('RecordID'));
                    $this->db->update('products', $data);
                    $msg = "Products Updated Successfully";
                    $success=true;
                }
            }
            $data=array('success'=>$success,'msg'=>$msg,'error_msg'=>$error_msg);
            echo json_encode($data);die;
        }else{
            $form_data=new stdClass();
            $edit_id=$this->input->get('id');
            if(isset($edit_id) && !empty($edit_id)){
                $sql = "SELECT * FROM products where id=".$edit_id;
                $query = $this->db->query($sql);
                $form_data=$query->row();
            }
            $data=array('data'=>$form_data);
            $this->load->view('header');
            $this->load->view('stock/add_products', $data);
            $this->load->view('footer');
        }
    }

    public function add_stock()
    {
        $data =array();
        $success=false;
        $error_msg="";
        $msg="";
        if( $_POST && count($_POST)>0)
        {
            $this->form_validation->set_rules("product_id", "Product", "trim|required");
            $this->form_validation->set_rules("quantity", "Quantity", "trim|required");

            if ($this->form_validation->run() == FALSE) {
                $error_msg=validation_errors();
                $success=false;
                $msg="Validation Error";
            }
            else{
                $r_id=$this->input->post('RecordID');
                if(empty($r_id)){
                    $product_id=$this->input->post('product_id');
                    $logged_user=$this->session->userdata('logged_id');
                    $chk_stock=$this->db->query("select * from stock where product_id='$product_id' and user_id='$logged_user'")->result_array();
                    if(count($chk_stock)>0){
                        //echo "<pre>";
                        // print_r($chk_stock[0]['id']);
                        $quantity_add=$this->input->post('quantity');
                        $stock_id=$chk_stock[0]['id'];
                        $quantity_available=$chk_stock[0]['quantity'];
                        $new_quantity=floatval($quantity_add)+floatval($quantity_available);
                        $data = array(
                            'quantity' => $new_quantity,
                            'description' => $this->input->post('description')
                        );
                        $s_detail=array(
                            'stock_id'=>$stock_id,
                            'product_id'=>$product_id,
                            'quantity'=>$quantity_add,
                            'description'=>$this->input->post('description'),
                            'entry_date'=>date('Y-m-d H:i:s'),
                            'added_by'=> $this->session->userdata('logged_id')
                        );
                        $this->db->where('id',$stock_id);
                        if($this->db->update('stock', $data)){
                            $this->db->insert('stock_detail', $s_detail);
                            $msg = "Stock Updated Successfully";
                            $success=true;
                        }
                    }else{
                        $data = array(
                            'product_id'=> $this->input->post('product_id'),
                            'quantity' => $this->input->post('quantity'),
                            'description' => $this->input->post('description'),
                            'entry_date' => date('Y-m-d H:i:s'),
                            'status' => 'Active',
                            'user_id' => $this->session->userdata('logged_id'),
                            'controller_id' => $this->session->userdata('logged_controller')
                        );
                        if($this->db->insert('stock', $data)){
                            $insert_id = $this->db->insert_id();
                            $s_detail=array(
                                'stock_id'=>$insert_id,
                                'product_id'=>$product_id,
                                'quantity'=>$this->input->post('quantity'),
                                'description'=>$this->input->post('description'),
                                'entry_date'=>date('Y-m-d H:i:s'),
                                'added_by'=> $this->session->userdata('logged_id')
                            );
                            $this->db->insert('stock_detail', $s_detail);
                            $msg = "Stock Added Successfully";
                            $success=true;
                        }else{
                            $msg = "Please Try Again";
                            $success=false;
                        }
                    }
                }else{
                    $data = array(
                        //'product_id'=> $this->input->post('product_id'),
                        'quantity' => $this->input->post('quantity'),
                        'description' => $this->input->post('description'),
                        'user_id' => $this->session->userdata('logged_id'),
                        'controller_id' => $this->session->userdata('logged_controller')
                    );
                    $this->db->where('id',$this->input->post('RecordID'));
                    $this->db->update('stock', $data);
                    $msg = "Stock Updated Successfully";
                    $success=true;
                }
            }
            $data=array('success'=>$success,'msg'=>$msg,'error_msg'=>$error_msg);
            echo json_encode($data);die;
        }else{
            $form_data=new stdClass();
            $edit_id=$this->input->get('id');
            if(isset($edit_id) && !empty($edit_id)){
                $sql = "SELECT * FROM stock where id=".$edit_id;
                $query = $this->db->query($sql);
                $form_data=$query->row();
            }
            $product_list=array();
            $product_list=$this->db->query("select * from products where status='Active'")->result_array();
            $data=array('data'=>$form_data,'products'=>$product_list);
            $this->load->view('header');
            $this->load->view('stock/add_stock', $data);
            $this->load->view('footer');
        }
    }

    public function DeleteStock(){
        $data=array();
        $success_msg="";
        $error_msg="";
        if($_POST){
            $this->db->where('Id', $_POST['id']);
            $this->db->delete('stock');
            if ($this->db->affected_rows() > 0) {
                $success_msg =  'Stock Deleted successfully';
            } else {
                $error_msg ='Something went wrong !';
            }
            unset ($_POST);
        }
        $data=array('success'=>true,'success_msg'=>$success_msg,'error_msg'=>$error_msg);
        echo json_encode($data);
    }
    public function DeleteProduct(){
        $data=array();
        $success_msg="";
        $error_msg="";
        if($_POST){
            $this->db->where('id', $_POST['id']);
            $this->db->delete('products');
            if ($this->db->affected_rows() > 0) {
                $success_msg =  'Product Deleted successfully';
            } else {
                $error_msg ='Something went wrong !';
            }
            unset ($_POST);
        }
        $data=array('success'=>true,'success_msg'=>$success_msg,'error_msg'=>$error_msg);
        echo json_encode($data);
    }

    public function ApproveSalesOrder(){
        $data=array();
        $success_msg="";
        $success=false;
        $error_msg="";
        if($_POST){
            $record_id=$this->input->post('id');
            $sql1 = "SELECT so.*,s.quantity as quantity_stock FROM sales_order as so inner join stock as s on s.product_id=so.product_id where  so.id=".$record_id;
            $result1 = $this->db->query($sql1)->result_array();
            if(count($result1)>0){
                $p_id=$result1[0]['product_id'];
                $order_quantity=$result1[0]['quantity'];
                $stock_quantity=$result1[0]['quantity_stock'];
                if($stock_quantity>=$order_quantity){
                    $data=array(
                        'approval_status'=>'Approved',
                        'approval_date'=>date('Y-m-d H:i:s'),
                        'approved_by'=>$this->session->userdata('logged_id')
                    );

                    $this->db->where('id',$this->input->post('id'));
                    $this->db->update('sales_order', $data);

                    $remaining_stock=$stock_quantity-$order_quantity;
                    $u_stock=array(
                        'quantity'=>$remaining_stock
                    );
                    $this->db->where('product_id',$p_id);
                    $this->db->update('stock', $u_stock);

                    $msg = "Order Confirmed Successfully";
                    $success=true;
                }else{
                    $msg = "Sufficient Quantity not available!";
                    $success=false;
                }
            }else{
                $msg = "This product not found in Stock";
                $success=false;
            }

            unset ($_POST);
        }else{
            $msg = "Please Try Again";
            $success=false;
        }
        $data=array('success'=>$success,'msg'=>$msg,'error_msg'=>$error_msg);
        echo json_encode($data);
    }
}
