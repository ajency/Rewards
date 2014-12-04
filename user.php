<?php

/*Template Name: User Template
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
get_header();
?>



    <!-- BEGIN HEADER -->
    <div class="header navbar navbar-inverse no-error-body ">
        <!-- BEGIN TOP NAVIGATION BAR -->
        <div class="navbar-inner">

            <div class="container">
                <div class="compressed">
                    <div class="row">
                        <div class="col-md-2 col-xs-2">
                            <a href="#"><img src="<?php echo site_url(); ?>/wp-content/themes/Rewards/img/skyi-logo.png" alt=""
                                             class="logo" width="90"></a>
                        </div>
                        <div class="col-md-10 col-xs-10 hidden-xs hidden-sm">
                            <ul class=" nav navbar-nav navbar-right pull-right">
                                <li><b>View Our Projects <span class="glyphicon glyphicon-arrow-right"></span></b></li>
                                <li><a href="http://www.manaslake.com/">Manas Lake </a></li>
                                <li><a href="http://www.songbirds.in/">Songbirds </a></li>
                                <!-- <li><a href="http://www.skyi.com/2bhk_3bhk_bavdhan.php">Iris (Bavdhan) </a></li>
                                <li><a href="http://www.skyi.com/2bhk_3bhk_baner.php">Iris (Baner) </a></li>
                                <li><a href="http://www.skyi.com/4bhk_baner.php">5</a></li>
                                <li><a href="http://www.skyi.com/villa_pune.php">Aquila </a></li>
                                <li><a href="http://www.skyi.com/villas_pune.php">Seher</a></li> -->
                            </ul>

                        </div>
                        <div class="col-md-10 col-xs-10 hidden-md hidden-lg">
                            <a id="chat-menu-toggle" href="#sidr" class="chat-menu-toggle pull-right p-t-30">
                                <div class="iconset top-menu-toggle-dark"></div>
                        </div>

                        </a>
                    </div>

                </div>
            </div>

        </div>
        <!-- END TOP NAVIGATION BAR -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN CONTAINER -->

    <div id="loading" style="position:absolute; width:100%; text-align:center;
 top:300px;display:none">
        <img src="<?php echo site_url(); ?>/html/assets/img/spinner.gif" border=0></div>
    <div class="container " id="main-content-region">
        
    </div>


    <div id="footer">
        <div class="error-container">
            <img src="<?php echo site_url(); ?>/html/assets/img/skyi-logo-gray.png" class="center-image">
            <ul class="footer-links">
                <li><a href="http://www.skyi.com/">SKYi</a></li>
                <li><a href="http://www.manaslake.com/">Manas Lake</a></li>
                <li><a href="http://www.songbirds.in/">Songbirds</a></li>
                <li><a href="http://www.skyi.com/tnc/">Terms and Conditions</a></li>
                <li><a href="<?php echo site_url(); ?>/wp-login.php">System Login</a></li>
                <!--<li><a href="#">Terms and Conditions</a></li>
                <li><a href="#">Copyrights &amp; Privacy </a></li>
                <li><a href="#">Help &amp; FAQ</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">eBrochure</a></li>
                <li><a href="#">Projects</a></li>-->
            </ul>
            <br>

            <div class="copyright"> All work copyright of respective owner, 2014-15 SKYi</div>
        </div>
    </div>
    <!-- END CONTAINER -->
    <div id="sidr" class="chat-window-wrapper hidden">
        <div id="main-chat-wrapper">
            <div class="chat-window-wrapper fadeIn" id="chat-users">
                <div class="side-widget">
                    <div class="side-widget-title">View All Projects</div>
                    <div class="side-widget-content">
                        <div id="groups-list">
                            <ul class="groups">
                                <li><a href="index.html">Songbirds </a></li>
                                <li><a href="index.html">Iris </a></li>
                                <li><a href="index.html">5</a></li>
                                <li><a href="index.html">Aquila </a></li>
                                <li><a href="index.html">Seher</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-57185034-1', 'auto');
  ga('send', 'pageview');

</script>



<?php get_footer();