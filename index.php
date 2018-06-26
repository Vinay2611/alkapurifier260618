<!DOCTYPE HTML>
<html>
<head>
    <title>Alka Energy Water Corporation</title>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
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
    <script>
        new WOW().init();
    </script>
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
</head>
<body>
<!--<div class="" style="position: absolute;">
    <div class="slider single-item">
        <div>
            <img src="images/top-slider/slide1.jpg">
        </div>
        <div>
            <img src="images/top-slider/slide2.jpg">
        </div>
        <div>
            <img src="images/top-slider/slide3.jpg">
        </div>
        &lt;!&ndash;<div><img src="images/top-slider/slide4.jpeg"></div>&ndash;&gt;
    </div>
    <style></style>

    <script>
        $(function () {
            $('.single-item').slick({
                dots: true,
                infinite: true,
                speed: 1000,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                fade: true,
                cssEase: 'linear'
            });
        });
    </script>


</div>-->

<script type="text/javascript" src="js/slideshow.js"></script>
<script type="text/javascript">
    $(function(){
        $.sublime_slideshow({
            src:[
                {url:"images/top-slider/slide1.jpg"},
                {url:"images/top-slider/slide5.jpeg"},
                {url:"images/top-slider/slide4.jpeg"},
                {url:"images/top-slider/slide3.jpg"},
                {url:"images/top-slider/slide2.jpg"}

            ],
            duration:   6,
            fade:       3,
            scaling:    false,
            rotating:   false,
            overlay:    "images/top-slider/slide1.jpg"
        });
    });
</script>
<div class="my-slider" style="width: 100%;position: absolute;">
</div>
<div class="bgg">
    <!----- start-header---->
    <div class="container">
        <div id="home" class="header wow bounceInDown" data-wow-delay="0.4s">
            <div class="top-header">
                <div class="logo" style="position: relative;z-index: 400;">
                    <a href="index.php">Alka</a>
                </div>
                <!----start-top-nav---->
                <nav class="top-nav">
                    <ul class="top-nav">
                        <li><a href="#about" class="scroll">about</a></li>
                        <li><a href="#process" class="scroll">process</a></li>
                        <!--<li><a href="#port" class="scroll">portfolio</a></li>-->
                        <li class="page-scroll"><a href="#contact" class="scroll">contact</a></li>
                        <li class="franchies-menu" ><a href="franchies.php" target="_blank" class="">associates</a></li>
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

    <!----- //End-header---->
    <!---- banner-info ---->
    <div class="banner-info">
        <div class="container">
            <h1 class="wow fadeIn" data-wow-delay="0.5s"><span>WE ARE</span><br /><label>ALKA ENERGY </label></h1>
            <div class="top-banner-grids wow bounceInUp" data-wow-delay="0.4s">
                <div class="banner-grid text-center">
                    <span class="top-icon1"> </span>
                    <h3>analytics</h3>
                </div>
                <div class="banner-grid  text-center">
                    <span class="top-icon2"> </span>
                    <h3>strategy</h3>
                </div>
                <div class="banner-grid text-center">
                    <span class="top-icon3"> </span>
                    <h3>branding</h3>
                </div>
                <div class="banner-grid text-center">
                    <span class="top-icon4"> </span>
                    <h3>promotion</h3>
                </div>
                <div class="banner-grid text-center">
                    <span class="top-icon5"> </span>
                    <h3>sales</h3>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
    <div class="clearfix"> </div>
</div>
<br><br>
<div id="about" class="about">
    <div class="head-section">
        <div class="container">
            <h3><span>about</span><label>us</label></h3>
        </div>
    </div>
    <!--- about-grids ---->
    <div class="about-grids">
        <div class="col-md-4 about-grid about-grid1 wow fadeInLeft" data-wow-delay="0.4s">
            <div class="about-grid-info">
                <h4><a href="#">ALKA ENERGY WATER CORPORATION</a></h4>
                <p>We, ALKA ENERGY WATER CORPORATION, Dombivali East, Kalyan, Thane District, MAHARASHTRA,<br>
                    India's prominent Corporate Entrepreneurs and feel proud to introduce and provide ANTI-OXIDANT
                    ALKALINE Water and various kinds of Alkaline Water Purifying Products all over India.<br>
                    <a href="about-alka-energy.php" class="read-more"  target="_blank">Read More</a>
                </p>
            </div>
            <div class="about-grid-pic">
                <img src="images/front/about-alka-energy.png" title="name" />
            </div>
        </div>
        <div class="col-md-4 about-grid about-grid2 wow fadeInUp" data-wow-delay="0.4s">
            <div class="about-grid-pic">
                <img src="images/front/about-water.png"  title="name" />
            </div>
            <div class="about-grid-info">
                <h4><a href="#">ABOUT WATER</a></h4>
                <p>As we all know, water is a basic necessity and one of the most important resources for the existence of all the creatures on earth, whether

                    it is an Animal or a Plant.<br>

                    Human body is comprised of 70 to 80% of Water.<br>

                    Our blood is composed of 83% of Water.
                    <br>
                    Good water can heal you !   Bad water will harm you !!
                    <br>
                    <a href="about-water.php" class="read-more"  target="_blank">Read More</a>
                </p>
            </div>
        </div>
        <div class="col-md-4 about-grid about-grid1 wow fadeInRight" data-wow-delay="0.4s">
            <div class="about-grid-info">
                <h4><a href="#">ABOUT ANTI - OXIDANT ALKALINE WATER</a></h4>
                <p>Scientists found that healthy drinkable water consists of the following :-<br>

                    i)  TDS   (Total Dissolved Solids) : It is a measurement on the content and level of natural salts and minerals in the water.<br>

                    ii)  pH     ( Potential Hydrogen)  <br>
                    <a href="about-anti-oxidant.php" class="read-more"  target="_blank">Read More</a>
                </p>
            </div>
            <div class="about-grid-pic">
                <img src="images/front/about-work.png" title="name" />
            </div>
        </div>
        <div class="clearfix"> </div>
    </div>
    <!--- /about-grids ---->
</div>
</div>
<!---- about ---->

<!--- process --->
<div id="process" class="process">
    <div class="head-section">
        <div class="container">
            <h3><span>Why</span><label>ALKALINE WATER</label></h3>
        </div>
    </div>
    <div class="container why-alka">
       <p>
           In JAPAN it is called kangen water. It begins as ordinary water but naturally becomes very much HYDRATING by IONISATION.</p>

           <p>It contains ions, has a different boiling point, surface tension, viscocity.</p>

           <p>The Ionized, Alkaline water has plenty of Anti - Oxidantants which help anti-ageing. It is the water that detoxifies, throwing away

           acidic wastes and toxins.</p>

           <p>As we grow up we intake too much acidic food, drinks and many other bad habits like smoking, alcohol consumption and others which

           make more acidic and causes all types of  diseases.
       </p>
        <a href="why-alka.php" class="read-more2"  target="_blank">Read More</a>
    </div>
</div>
<!--- process --->
<!--- blog ---->

<!---- work-with-us---->
<div class="work-with-us text-center">
    <div class="container">
        <p> DR. OTTO HEINRICH WARBURG, A German Physilogist and Noble Prize winner way back in the year 1931 recognized the significance of Alkaline. According to him. </p>
        <h4>"NO DISEASE CAN EXIST IN AN ALKALINE ENVIRONMENT"</h4>

    </div>
</div>
<!---- work-with-us---->
<!--- portfolio ---->
<!---- map ---->
<div id="contact" class="map">
    <div class="map-location">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d30140.607867177594!2d73.09085689160936!3d19.213713590602836!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1472733305370"></iframe>
    </div>
    <div class="contact-main">
        <div class="contact-info text-center wow fadeInLeft" data-wow-delay="0.3s">
            <a class="catch-me wow shake" data-wow-delay="0.3s" href="#">contact us</a>
            <h4><span>ALKA ENERGY</span></h4>
            <p><span class="map-icon1"> </span>Dombivali East, Kalyan, Thane District </p>
            <p><span class="map-icon2"></span> alkaenergy16@gmail.com</p>
            <p><span class="map-icon3"> </span>223-323-232-3232</p>
        </div>
    </div>
</div>
<!---- map ---->
<div class="clearfix"> </div>
<!---- footer --->
<div class="footer text-center">
    <div class="container">
        <div class="footer-inner wow zoomIn" data-wow-delay="0.3s">
            <ul class="footer-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="about-alka-energy.php">About Us</a></li>
                <li><a href="why-alka.php">Why Alka</a></li>
                <li><a href="about-anti-oxidant.php">Anti-Oxidant Alkaline Water</a></li>
                <li><a href="about-water.php">About Water</a></li>
            </ul>
            <br>
            <ul>
                <li><span></span><a href="#" style="font-size: 35px;
    color: white;
    font-weight: 700;
    padding-top: 24px;
    margin-top: 21px;">Alka Energy</a></li>
                <li><a class="contact-me" href="#">contact us</a></li>
            </ul>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                /*
                 var defaults = {
                 containerID: 'toTop', // fading element id
                 containerHoverID: 'toTopHover', // fading element hover id
                 scrollSpeed: 1200,
                 easingType: 'linear'
                 };
                 */

                $().UItoTop({ easingType: 'easeOutQuart' });

            });
        </script>
        <a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
    </div>
</div>
<!---- footer --->
</div>
</body>
</html>

