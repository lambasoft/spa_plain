<!DOCTYPE html>
<html lang="en">
<?php
$isCreated = false;
$Gym = new Gym($DB);
if(isset($_POST['token'])){
    $isCreated = $Gym->doAction("create",$_POST);
    // if($isCreated == true){
    //     echo "Gym Created";
    // }
}
require_once(VIEWS_PATH. "/layouts/auth.head.php");

$gymBuilder = new FormBuilder($Gym, "create", ["enctype" =>  "multipart/form-data" ,"action_path" => "#", "errors" => $Gym->errors]);
?>
<body>
    <?php
    require_once(VIEWS_PATH ."/layouts/common/nav_bar.php");
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create Gym</div>
                    <div class="panel-body">
                        <?php
                        echo $gymBuilder->render(true);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <?php
    if($isCreated && empty($Gym->errors)){
        ?>
        <script src="<?php echo WEB_PATH . "/" .  PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php  echo WEB_PATH . "/" .  PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.css">
        <script>
            swal("Successfully Created Gym!", "Redirecting....", "success");
            setTimeout(function(){ window.location = "home"; }, 3000);
        </script>
        <?php
    }
    ?>
</body>
</html>
