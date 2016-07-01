<!DOCTYPE html>
<html lang="en">
<?php
$Spa = new Spa($DB, $_GET['id']);
require_once(VIEWS_PATH. "/layouts/auth.head.php");
if(empty($Spa->errors)){
    $SpaInfo = $Spa->getID($_GET['id']);
}
$isReviewed = false;
if(isset($_POST['action_review'])){
    $_POST['link_user_id'] = $User->get("id");
    $isReviewed = $Spa->doAction("review",$_POST);
}
?>
<body>
    <?php
    require_once(VIEWS_PATH ."/layouts/common/nav_bar.php");
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <?php
                    if(!empty($Spa->errors)){
                        ?>
                        <div class="panel-heading">Spa - Error</div>
                        <div class="panel-body ">
                            <h2>Spa Not Found !</h2>
                        </div>
                        <?php
                    }else{
                        ?>
                        <div class="panel-heading"> <?php echo $SpaInfo['name']; ?></div>
                        <div class="panel-body ">
                            <div class="gateway">
                                <img src="<?PHP echo WEB_PATH . "/" . $SpaInfo['logo'] ;  ?>">

                            </div>

                            <div class="gateway_tabs">

                              <!-- Nav tabs -->
                              <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#about" aria-controls="about" role="tab" data-toggle="tab">About</a></li>
                                <li role="presentation"><a href="#address" aria-controls="address" role="tab" data-toggle="tab">Address & Info</a></li>
                                <li role="presentation"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">Reviews</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="about">
                                    <h3>About <?php echo $SpaInfo['name']; ?></h3>
                                    <div class="pull-left">
                                        <div style="float:left;width:75px;background:transparent url(<?PHP echo WEB_PATH;  ?>/resources/assets/star-gray-15x15.png) 0 0 repeat-x;">
                                            <div style="width:<?php echo $Spa->getReviewsAvg() * 15; ?>px;height:15px;background:transparent url(<?PHP echo WEB_PATH;  ?>/resources/assets/star-orange-15x15.png) 0 0 repeat-x;">
                                            </div>
                                        </div>

                                        <div class="pull-left reviews">
                                            <a href="#">See Reviews</a>
                                        </div>
                                    </div>
                                    <span class="clearfix"> </span>
                                    <div class="desc pull-left">
                                        <?php echo $SpaInfo['description']; ?>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="address">
                                    <div class="address text-center">
                                        <?php echo $SpaInfo['address']; ?>
                                    </div>
                                    <hr>
                                    <div class="info">
                                        <div class="col-md-8">
                                           <h3>Opening Hours</h3>
                                           <div id="businessHoursContainer"></div>  
                                       </div>

                                       <div class="col-md-4">
                                         <h3>Info</h3>
                                         <ul class="list-group">
                                             <li class="list-group-item"><b>Manager Name:</b> <?php echo $SpaInfo['manager_name']; ?></li>
                                             <li class="list-group-item"><b>Manager Type:</b> <?php echo $SpaInfo['manager_type']; ?></li>
                                             <li class="list-group-item"><b>Spa Size:</b> <?php echo $SpaInfo['size']; ?></li>
                                             <li class="list-group-item"><b>Open Year:</b> <?php echo $SpaInfo['open_year']; ?></li>
                                             <li class="list-group-item"><b>Treatment Rooms:</b> <?php echo $SpaInfo['treatment_rooms']; ?></li>
                                             <li class="list-group-item"><b>Retail Products:</b> <?php echo $SpaInfo['retail_products']; ?></li>
                                         </ul>
                                     </div>

                                 </div>
                             </div>
                             <div role="tabpanel" class="tab-pane" id="reviews">
                                 <div class="col-md-12">

                                     <h3 style="float: left;padding-top: 0!important;">
                                       Reviews For <?php echo $SpaInfo['name']; ?> <span class="total"> (<?php echo $Spa->getReviewsCount(); ?>)</span>
                                   </h3> 

                                   <div style="margin-top:25px;margin-left: 15px;float: left;width:75px;background:transparent url(<?PHP echo WEB_PATH;  ?>/resources/assets/star-gray-15x15.png) 0 0 repeat-x;">
                                    <div style="width:<?php echo $Spa->getReviewsAvg() * 15; ?>px;height:15px;background:transparent url(<?PHP echo WEB_PATH;  ?>/resources/assets/star-orange-15x15.png) 0 0 repeat-x;">
                                    </div>
                                </div>

                                <div class="pull-right" style="margin-top:25px;">
                                    <a href="#" data-toggle="modal" data-target="#myModal">Write a Review</a>
                                </div>
                                <span class="clearfix"></span>
                                <hr>
                                <?php
                                
                                echo '<pre>';
                                print_r($Spa->getReviews());
                                echo '</pre>';
                                ?>
                            </div>


                            
                        </div>
                    </div>

                </div>
            </div>
            <?php
        }
        ?>


    </div>
</div>
</div>
</div>
</div>

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<!-- Plugins -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.2.17/jquery.timepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.2.17/jquery.timepicker.min.css"/>
<script type="text/javascript" src="<?php echo WEB_PATH . "/" .  PLUGINS_PATH . "/jquery.businessHours/jquery.businessHours.min.js";?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo WEB_PATH . "/" .  PLUGINS_PATH . "/jquery.businessHours/jquery.businessHours.css";?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo WEB_PATH . "/" .  PLUGINS_PATH . "/jquery.businessHours/libs/page.css";?>"/>

<script>

    var businessHoursManager = $("#businessHoursContainer").businessHours({
        inputDisabled: true,
        operationTime: <?php echo $SpaInfo['opening_hours']; ?>
    });
    

</script>

<script src="<?PHP echo WEB_PATH . "/" . "plugins/isotope/isotope.pkgd.min.js"; ?>"></script>
<script>
    $('.grid').isotope({
  // set itemSelector so .grid-sizer is not used in layout
  itemSelector: '.object_item',
  layoutMode: 'masonry'
})
</script>

<?php
if($isReviewed && empty($Spa->errors)){
    ?>
    <script src="<?php echo WEB_PATH . "/" .  PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php  echo WEB_PATH . "/" .  PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.css">
    <script>
        swal("Successfully Reviewed Spa!", "Redirecting....", "success");
//setTimeout(function(){ window.location = "home"; }, 3000);
</script>
<?php
}
?>

<!-- Modal Review-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Enter Your Review</h4>
            </div>
            <form action="#" method="POST">
                <div class="modal-body review">
                    <input type="hidden" name="action_review" value="1" />
                    <div class="row">

                        <div class="col-md-12">
                            <ul class="clearfix">
                                <li class="first pull-left">Overall Rating: </li>
                                <li class="pull-left">
                                    <fieldset class="rating">
                                        <input type="radio" id="star5" name="rating" value="5" /><label class="full" for="star5" title="Awesome - 5 stars"></label>
                                        <input type="radio" id="star4half" name="rating" value="4.5" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                        <input type="radio" id="star4" name="rating" value="4" /><label class="full" for="star4" title="Pretty good - 4 stars"></label>
                                        <input type="radio" id="star3half" name="rating" value="3.5" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                        <input type="radio" id="star3" name="rating" value="3" /><label class="full" for="star3" title="Meh - 3 stars"></label>
                                        <input type="radio" id="star2half" name="rating" value="2.5" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                        <input type="radio" id="star2" name="rating" value="2" /><label class="full" for="star2" title="Kinda bad - 2 stars"></label>
                                        <input type="radio" id="star1half" name="rating" value="1.5" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                        <input type="radio" id="star1" name="rating" value="1" /><label class="full" for="star1" title="Sucks big time - 1 star"></label>
                                        <input type="radio" id="starhalf" name="rating" value="0.5" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                    </fieldset>
                                </li>
                            </ul>


                            <ul class="clearfix">
                                <div class="form-group">
                                    <label for="reviewTitle">Review Title</label>
                                    <div class="form-group">
                                        <input id="reviewTitle" type="text" class="form-control" name="title" placeholder="Title" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="reviewDesc">Review Description</label>
                                    <div class="form-group">
                                        <textarea id="reviewDesc" name="description" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </ul>

                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </div>

            </form>
        </div>

    </div>
</div>

</body>
</html>
