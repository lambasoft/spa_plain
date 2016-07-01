<!DOCTYPE html>
<html lang="en">
<?php
$isChanged = false;
if(isset($_POST['token']) && isset($_POST['action_token'])){
  $isChanged = $User->update($_POST , $_POST['action_token']); 
}

require_once(VIEWS_PATH. "/layouts/auth.head.php");
?>
<body>
    <?php
    require_once(VIEWS_PATH ."/layouts/common/nav_bar.php");
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Profile</div>
                    <div class="panel-body">
                        <?php
                        $spaBuilder = new FormBuilder($User, "update", ["action" => "update" , "enctype" =>  "multipart/form-data" ,"action_path" => "#", "errors" => $User->errors]);
                        echo $spaBuilder->render(true);
                        ?>
                        <hr>

                        <?php
                        $spaBuilder = new FormBuilder($User, "update_password", ["action" => "update_password" , "button"=> "Change Password" , "enctype" =>  "multipart/form-data" ,"action_path" => "#", "errors" => $User->errors]);
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
    <?php
    if($isChanged && empty($User->errors)){
        ?>
        <script src="<?php echo WEB_PATH . "/" .  PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php  echo WEB_PATH . "/" .  PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.css">
        <script>
            swal("Successfully updated profile!", "", "success");
        </script>
        <?php
    }
    ?>
</body>
</html>
