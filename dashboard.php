<?php
/**
 * Template Name: Dashboard Template
 * The template for displaying the dashboard. This will be a single page app
 */

get_header(); ?>
    <!-- BEGIN HEADER -->
    <div class="header navbar navbar-inverse" id="header-region"></div>
    <!-- END HEADER -->

    <!-- BEGIN CONTAINER -->
    <div class="page-container row-fluid">

        <!-- Left NAv container -->
        <div class="page-sidebar" id="left-nav-region"></div>
        <a href="#" class="scrollup" style="display: inline;">Scroll</a>
        <!-- footer region -->
        <div class="footer-widget" id="footer-region"></div>

        <!-- Main page content -->
        <div class="page-content">
            <div class="clearfix"></div>
            <div class="content">
                <!-- breadcrumb region -->
                <div id="breadcrumb-region"></div>

                <!-- main content region -->
                <div id="main-content-region"></div>

            </div>
        </div>
    </div>
    <!-- END CONTAINER -->

    <!-- Dialog region -->
    <div id="dialog-region"></div>
    <!-- Login region -->
    <div id="login-region"></div>

<?php get_footer();?>


