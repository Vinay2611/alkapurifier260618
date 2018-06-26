<?php
$user_role=$this->session->userdata('logged_role');
?>
<!doctype html>
<html lang="en-US">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Alka Purifier</title>
    <meta name="description" content="" />
    <meta name="Author" content="Dorin Grigoras [www.stepofweb.com]" />
    <!-- mobile settings -->
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
    <!-- WEB FONTS -->

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext" rel="stylesheet" type="text/css" />
    <!-- CORE CSS -->

    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- THEME CSS -->
    <link href="<?php echo base_url(); ?>assets/css/essentials.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/layout.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/color_scheme/green.css" rel="stylesheet" type="text/css" id="color_scheme" />
    <link href="<?php echo base_url(); ?>assets/css/layout-datatables.css" rel="stylesheet" type="text/css" />
    <style>
        .loading{
            display: none;
        }
    </style>
</head>
<body>
<!-- WRAPPER -->
<div id="wrapper" class="clearfix">
    <aside id="aside">
        <nav id="sideNav"><!-- MAIN MENU -->
            <br>
            <ul class="nav nav-list">

                <li>
                    <a href="#">
                        <i class="fa fa-menu-arrow pull-right"></i>
                        <i class="main-icon fa fa-group"></i> <span>Associates</span>
                    </a>
                    <ul>
                        <li><a href="<?php echo base_url(); ?>franchies/addfranchies">Add Associates</a></li>

                    </ul>
                </li>
                <?php
                $sales_controller= $this->config->item('SalesControllers');
                if(!in_array($user_role, $sales_controller)){
                    ?>
                    <li>
                        <a href="#">
                            <i class="fa fa-menu-arrow pull-right"></i>
                            <i class="main-icon fa fa-industry"></i> <span>Production Controller</span>
                        </a>
                        <ul>
                            <?php
                            if($user_role=='Admin'){
                                $contoller= $this->config->item('ProductionControllers');
                            }else{
                                $contoller= $this->config->item($user_role);
                            }
                            $controller_url=$this->config->item('ProductionControllerUrls');
                            if(isset($contoller) && count($contoller)>0){
                                foreach ($contoller as $c){
                                    ?>
                                    <li><a href="<?php echo base_url().$controller_url[$c]; ?>"><?php echo $c;?></a></li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </li>
                <?php
                }?>

                <?php
                $production_controller= $this->config->item('ProductionControllers');
                if(!in_array($user_role, $production_controller)){
                    ?>
                    <li>
                        <a href="#">
                            <i class="fa fa-menu-arrow pull-right"></i>
                            <i class="main-icon fa fa-money"></i> <span>Sales Controller</span>
                        </a>
                        <ul>
                            <?php
                            if($user_role=='Admin'){
                                $contoller= $this->config->item('SalesControllers');
                            }else{
                                $contoller= $this->config->item($user_role);
                            }
                            $controller_url=$this->config->item('SalesControllerUrls');
                            if(isset($contoller) && count($contoller)>0){
                                foreach ($contoller as $c){
                                    ?>
                                    <li><a href="<?php echo base_url().$controller_url[$c]; ?>"><?php echo $c;?></a></li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                }?>

            </ul>
        </nav>
        <?php if(isset($user_role) && $user_role=="Admin") {
            ?>
            <nav id="sideNav"><!-- MAIN MENU -->
                <br>

                <h3>Manage Production</h3>
                <ul class="nav nav-list">

                    <li class="el_primary" id="el_11">
                        <a href="<?php echo base_url(); ?>stock/all_products">
                            <i class="main-icon fa fa-link"></i>
                            <span>All Products</span>
                        </a>
                    </li>
                    <li class="el_primary" id="el_11">
                        <a href="<?php echo base_url(); ?>stock/add_products">
                            <i class="main-icon fa fa-link"></i>
                            <span>Add Products</span>
                        </a>
                    </li>

                    <li class="el_primary" id="el_9">
                        <a href="<?php echo base_url(); ?>stock/index">
                            <i class="main-icon fa fa-link"></i>
                            <span>All Stock</span>
                        </a>
                    </li>
                    <li class="el_primary" id="el_10">
                        <a href="<?php echo base_url(); ?>stock/add_stock">
                            <i class="main-icon fa fa-link"></i>
                            <span>Add Stock</span>
                        </a>
                    </li>

                    <li class="el_primary" id="el_11">
                        <a href="<?php echo base_url(); ?>stock/pending_orders">
                            <i class="main-icon fa fa-link"></i>
                            <span>Pending Orders</span>
                        </a>
                    </li>
                </ul>
                <h3>Manage Sales</h3>

                <ul class="nav nav-list">
                   <!-- <li class="el_primary" id="el_9">
                        <a href="<?php /*echo base_url(); */?>sales/index">
                            <i class="main-icon fa fa-link"></i>
                            <span>All Sales</span>
                        </a>
                    </li>
                    <li class="el_primary" id="el_10">
                        <a href="<?php /*echo base_url(); */?>sales/add_sales">
                            <i class="main-icon fa fa-link"></i>
                            <span>Add Sales</span>
                        </a>
                    </li>
                    <li class="el_primary" id="el_11">
                        <a href="<?php /*echo base_url(); */?>sales/available_stock">
                            <i class="main-icon fa fa-link"></i>
                            <span>Available Stock</span>
                        </a>
                    </li>-->

                    <li class="el_primary" id="el_11">
                        <a href="<?php echo base_url(); ?>sales/all_orders">
                            <i class="main-icon fa fa-link"></i>
                            <span>All Orders</span>
                        </a>
                    </li>

                    <li class="el_primary" id="el_11">
                        <a href="<?php echo base_url(); ?>sales/generate_order">
                            <i class="main-icon fa fa-link"></i>
                            <span>Generate Order</span>
                        </a>
                    </li>
                </ul>
                <h3>MORE</h3>
                <ul class="nav nav-list">
                    <li>
                        <a href="<?php echo base_url(); ?>lists/country">
                            <i class="main-icon fa fa-calendar"></i>
                            <span>Country List</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>lists/state">
                            <i class="main-icon fa fa-link"></i>
                            <span>State List</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>lists/city">
                            <i class="main-icon fa fa-link"></i>
                            <span>City List</span>
                        </a>
                    </li>
                    <!--<li>
                    <a href="<?php /*echo base_url(); */?>lists/area">
                        <i class="main-icon fa fa-link"></i>
                        <span>Area List</span>
                    </a>
                </li>-->
                </ul>
            </nav>
        <?php
        }else if(isset($user_role) && in_array($user_role, $this->config->item('ProductionControllers'))){
            ?>
            <nav id="sideNav"><!-- MAIN MENU -->
                <br>
                <h3>Manage Production</h3>
                <ul class="nav nav-list">
                    <li class="el_primary" id="el_9">
                        <a href="<?php echo base_url(); ?>stock/all_products">
                            <i class="main-icon fa fa-link"></i>
                            <span>All Products</span>
                        </a>
                    </li>
                    <li class="el_primary" id="el_10">
                        <a href="<?php echo base_url(); ?>/stock/add_products">
                            <i class="main-icon fa fa-link"></i>
                            <span>Add Products</span>
                        </a>
                    </li>
                    <li class="el_primary" id="el_9">
                        <a href="<?php echo base_url(); ?>stock/index">
                            <i class="main-icon fa fa-link"></i>
                            <span>All Stock</span>
                        </a>
                    </li>
                    <li class="el_primary" id="el_9">
                        <a href="<?php echo base_url(); ?>stock/add_stock">
                            <i class="main-icon fa fa-link"></i>
                            <span>Add Stock</span>
                        </a>
                    </li>
                    <li class="el_primary" id="el_9">
                        <a href="<?php echo base_url(); ?>stock/pending_orders">
                            <i class="main-icon fa fa-link"></i>
                            <span>Pending Orders</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php
        }else if(isset($user_role) && in_array($user_role, $this->config->item('SalesControllers'))){
            ?>
            <nav id="sideNav"><!-- MAIN MENU -->
                <br>
                <h3>Manage Sales</h3>

                <ul class="nav nav-list">
                    <li class="el_primary" id="el_9">
                        <a href="<?php echo base_url(); ?>sales/all_orders">
                            <i class="main-icon fa fa-link"></i>
                            <span>All Orders</span>
                        </a>
                    </li>
                    <li class="el_primary" id="el_10">
                        <a href="<?php echo base_url(); ?>sales/generate_order">
                            <i class="main-icon fa fa-link"></i>
                            <span>Generate Order</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <?php
        }?>

        <span id="asidebg"><!-- aside fixed background --></span>
    </aside>
    <!-- /ASIDE -->
    <!-- HEADER -->
    <header id="header">
        <!-- Mobile Button -->
        <button id="mobileMenuBtn"></button>
        <!-- Logo -->
        <span class="logo pull-left">
					<h3 style="color:white;margin-top: 6px;"><a href="<?php echo base_url(); ?>">Alka Energy</a></h3>
				</span>
        <form method="get" action="page-search.html" class="search pull-left hidden-xs">

            <input type="text" class="form-control" name="k" placeholder="Search for something..." />

        </form>
        <nav>
            <!-- OPTIONS LIST -->
            <ul class="nav pull-right">
                <!-- USER OPTIONS -->

                <li class="dropdown pull-left">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">

                        <img class="user-avatar" alt="" src="<?php echo base_url(); ?>assets/images/noavatar.jpg" height="34" />

                        <span class="user-name">

									<span class="hidden-xs">

										John Doe <i class="fa fa-angle-down"></i>

									</span>

								</span>

                    </a>

                    <ul class="dropdown-menu hold-on-click">
                        <li><!-- logout -->

                            <a href="<?php echo base_url(); ?>login/logout"><i class="fa fa-power-off"></i> Log Out</a>

                        </li>

                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript">var plugin_path = '<?php echo base_url(); ?>assets/plugins/';</script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/app.js"></script>
    <!-- /HEADER -->
