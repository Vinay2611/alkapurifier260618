<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
        if(!$this->session->userdata('is_logged_in'))
        {
            redirect('login');
        }
    }
    public function index()
    {
        $sql = "SELECT COUNT(*) as total,AssociatesType FROM franchies GROUP by AssociatesType";
        $query = $this->db->query($sql);
        $p_area=$query->result_array();

        $total_c=array();
        $v_array=$this->config->item('AdminVarialbles');
        foreach ($p_area as $p){
            $p_data= $p['AssociatesType'];
            $v_name=$v_array[$p_data];
            $total_c[$v_name]=$p['total'];
        }

        $available_stock=array();
        $sql = "SELECT s.*, sum(quantity - IFNULL(TotalSold, 0)) as available_stock
                    FROM stock s
                    LEFT JOIN (SELECT id,product_id,IFNULL(sum(quantity), 0) AS TotalSold
                    FROM sales      
                    GROUP BY product_id) as sa ON sa.product_id = s.id";

        $query = $this->db->query($sql);
        $available_stock=$query->result_array();
        $available_stock=$available_stock[0]["available_stock"];

        $stock_today=array();
        $date=date('Y-m-d');
        $sql = "SELECT sum(quantity) as stock_today FROM `stock` WHERE entry_date like '%$date%'";
        $query = $this->db->query($sql);
        $stock_today=$query->result_array();
        $stock_today=$stock_today[0]["stock_today"];


        $sold_total=array();
        $date=date('Y-m-d');
        $sql = "SELECT sum(quantity) as sold_total FROM `sales`";
        $query = $this->db->query($sql);
        $sold_total=$query->result_array();
        $sold_total=$sold_total[0]["sold_total"];

        $sold_today=array();
        $date=date('Y-m-d');
        $sql = "SELECT sum(quantity) as sold_today FROM `sales` WHERE sales_date like '%$date%'";
        $query = $this->db->query($sql);
        $sold_today=$query->result_array();
        $sold_today=$sold_today[0]["sold_today"];


        $data=array('success'=>true,
            't_controllers'=>$total_c,
            'available_stock'=>$available_stock,
            'stock_today'=>$stock_today,
            'sold_total'=>$sold_total,
            'sold_today'=>$sold_today
            );
        $this->load->view('header');
        $this->load->view('index',$data);
        $this->load->view('footer');
    }
}
