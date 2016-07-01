<!DOCTYPE html>
<html lang="en">
<?php
$isCreated = false;
$Spa = new Spa($DB);
if(isset($_POST['token'])){
    $_POST['link_user_id'] = $User->get("id");
    $isCreated = $Spa->doAction("create",$_POST);
}
require_once(VIEWS_PATH. "/layouts/auth.head.php");

$spaBuilder = new FormBuilder($Spa, "create", ["enctype" =>  "multipart/form-data" ,"action_path" => "#", "errors" => $Spa->errors]);
?>
<body>
    <?php
    require_once(VIEWS_PATH ."/layouts/common/nav_bar.php");
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create Spa</div>
                    <div class="panel-body">
                        <?php
                        echo $spaBuilder->render(true);
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

        var businessHoursManager = $("#businessHoursContainer").businessHours();
        $("form").submit(function() {
        // use: businessHoursManager.serialize() to get serialized business hours in JSON
        $("#openingHours").val(JSON.stringify(businessHoursManager.serialize()));
    });

</script>

<?php
if($isCreated && empty($Spa->errors)){
    ?>
    <script src="<?php echo WEB_PATH . "/" .  PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php  echo WEB_PATH . "/" .  PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.css">
    <script>
        swal("Successfully Created Spa!", "Redirecting....", "success");
//setTimeout(function(){ window.location = "home"; }, 3000);
</script>
<?php
}
?>
</body>
</html>
