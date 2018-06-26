<!DOCTYPE HTML>
<html>
<head>
    <title>Alka | Home</title>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/font-awesome.min.css" rel='stylesheet' type='text/css' />
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Custom Theme files -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!-- Custom Theme files -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
    <script type="text/javascript" src="js/jquery.corner.js"></script>
    <script src="js/wow.min.js"></script>

    <!---- animated-css ---->
    <!---- start-smoth-scrolling---->
    <script type="text/javascript" src="js/move-top.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
            });
        });
    </script>
    <!---- start-smoth-scrolling---->
    <!----webfonts--->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
    <!---//webfonts--->
    <!----start-top-nav-script---->
    <script>
        $(function() {
            var pull 		= $('#pull');
            menu 		= $('nav ul');
            menuHeight	= menu.height();
            $(pull).on('click', function(e) {
                e.preventDefault();
                menu.slideToggle();
            });
            $(window).resize(function(){
                var w = $(window).width();
                if(w > 320 && menu.is(':hidden')) {
                    menu.removeAttr('style');
                }
            });
        });
    </script>
    <!----//End-top-nav-script---->

    <style>
        .loading{
            color: green;
            display: none;
        }
    </style>
</head>
<body>

<div class="bgg" style="
    background: #dea753;">
    <!----- start-header---->
    <div class="container">
        <div id="home" class="header2 wow " data-wow-delay="0.4s">
            <div class="top-header">
                <a href="index.php"> <div class="logo"  style="position: relative;z-index: 400;">
                        <a href="index.php">Alka</a>
                    </div></a>
                <!----start-top-nav---->
                <nav class="top-nav">
                    <ul class="top-nav">
                        <li><a href="index.php#about" class="">about</a></li>
                        <li><a href="index.php#process" class="">process</a></li>
                        <!--<li><a href="#port" class="scroll">portfolio</a></li>-->
                        <li class="page-scroll"><a href="index.php#contact" class="">contact</a></li>
                        <li class="franchies-menu"><a href="franchies.php" class="">associates</a></li>
                    </ul>
                    <a href="#" id="pull"><img src="images/nav-icon.png" title="menu" /></a>
                </nav>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $height=$(".bgg").height();
            console.log($height);
            $(".sm-slider").height($height);
        });
    </script>

    <div class="clearfix"> </div>
</div>


<br>
<br>