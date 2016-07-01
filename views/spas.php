<!DOCTYPE html>
<html lang="en">
<?php
$Spa = new Spa($DB);
require_once(VIEWS_PATH. "/layouts/auth.head.php");
?>
<body>
    <?php
    require_once(VIEWS_PATH ."/layouts/common/nav_bar.php");
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel items panel-default">
                    <div class="panel-heading">Spas</div>
                    <div class="panel-body row-centered">
                        <div class="col-md-12 col-md-offset-1 grid">
                            <?php
                            $spas = $Spa->getAll();
                            foreach($spas as $spa){
                                ?>
                                <div class="col-md-3 col-centered text-center object_item">
                                    <img src="<?PHP echo WEB_PATH . "/" . $spa['logo'] ;  ?>" />
                                    <hr>
                                    <a href="<?PHP echo WEB_PATH . "/spa/{$spa['id']}";  ?>" class="obj_name">
                                     <?php echo $spa['name']; ?>
                                 </a>
                                 <?php echo strlen($spa['description']) > 100 ? substr($spa['description'],0,100)."..." : $spa['description']; ?>
                                 <hr>

                                 <div class="pull-left">
                                    <div style="width:75px;background:transparent url(<?PHP echo WEB_PATH;  ?>/resources/assets/star-gray-15x15.png) 0 0 repeat-x;">
                                    <div style="width:0px;height:15px;background:transparent url(<?PHP echo WEB_PATH;  ?>/resources/assets/star-orange-15x15.png) 0 0 repeat-x;">
                                        </div>
                                    </div>

                                </div>
                                <a href="<?PHP echo WEB_PATH . "/spa/{$spa['id']}";  ?>" class="pull-right" >Read More</a>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="<?PHP echo WEB_PATH . "/" . "plugins/isotope/isotope.pkgd.min.js"; ?>"></script>
<script>
    $('.grid').isotope({
  // set itemSelector so .grid-sizer is not used in layout
  itemSelector: '.object_item',
  layoutMode: 'masonry'
})
</script>
</body>
</html>
