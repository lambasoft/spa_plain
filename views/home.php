<!DOCTYPE html>
<html lang="en">

<?php
include("layouts/home.head.php");
?>

<body id="home-page">

<?php
include("layouts/common/nav_bar.php");
?>


<!-- Header -->
<?php
//include("layouts/home.header.php");
?>


<div class="container-fluid pages-container">
    <div class="row pages">
        <div class="col-md-2 fadeInLeft animated">
            <div class="banner">
                <h3 style="color:black">Banner</h3>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-3 col-xs-6 fadeInLeft animated">
                    <div class="single-page border-bottom-hover-green">
                        <a href="#">
                            <h3 class="colored-white">SPA</h3>
                        </a>
                    </div>
                </div>

                <div class="col-md-3 col-xs-6 fadeInLeft animated ">
                    <div class="single-page border-bottom-hover-red">
                        <a href="#">
                            <h3 class="colored-white">GYM</h3>
                        </a>
                    </div>
                </div>

                <div class="col-md-3 col-xs-6 fadeInLeft animated">
                    <div class="single-page border-bottom-hover-pink">
                        <a href="#">
                            <h3 class="colored-white">GIFTS</h3>
                        </a>
                    </div>
                </div>

                <div class="col-md-3 col-xs-6 fadeInLeft animated">
                    <div class="single-page border-bottom-hover-maroon">
                        <a href="#">
                            <h3 class="colored-white">JOBS</h3>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-xs-6 fadeInRight animated">
                    <div class="single-page border-bottom-hover-blue">
                        <a href="#">
                            <h3 class="colored-white">SUPPLIES</h3>
                        </a>
                    </div>
                </div>

                <div class="col-md-3 col-xs-6 fadeInRight animated">
                    <div class="single-page border-bottom-hover-purple">
                        <a href="#">
                            <h3 class="colored-white">MANUALS</h3>
                        </a>
                    </div>
                </div>

                <div class="col-md-3 col-xs-6 fadeInRight animated">
                    <div class="single-page border-bottom-hover-yellow">
                        <a href="#">
                            <h3 class="colored-white">RATING</h3>
                        </a>
                    </div>
                </div>

                <div class="col-md-3 col-xs-6 fadeInRight animated">
                    <div class="single-page border-bottom-hover-gray">
                        <a href="#">
                            <h3 class="colored-white">NEWS</h3>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-2 fadeInRight animated">
            <div class=" banner">
                <h3 style="color:black">Banner</h3>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php
include("layouts/home.footer.php");
?>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
<script src="<?php echo BOOTSTRAP_PATH; ?>/dist/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/wow/0.1.12/wow.min.js"></script>
</body>
</html>
