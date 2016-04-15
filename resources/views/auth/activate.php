<!DOCTYPE html>
<html lang="en">
<?php
$isActivated = false;
$User->parseActivate();
if(isset($_POST['token'])){
    $isActivated = $User->doActivate();
}
require_once(RESOURCES_PATH. "/views/layouts/auth.head.php");
?>
<body>
<?php
require_once(RESOURCES_PATH ."/views/layouts/common/nav_bar.php");
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Verify Your Email</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="#">
                        <input type="hidden" name="token" value="login">

                        <div class="form-group <?php echo (isset($User->errors['password'])? ' has-error': '') ?>">
                            <label class="col-md-4 control-label">Code</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="ver_code" value="<?php echo $User->old("ver_code"); ?>">
                                <?php
                                if (isset($User->errors['ver_code'])){
                                    ?>
                                    <span class="help-block">
                                        <strong><?php echo $User->errors['ver_code'];?></strong>
                                    </span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <?php
                                if (isset($User->errors['error'])){
                                    ?>
                                    <span class="text-danger">
                                        <strong><?php echo $User->errors['error'];?></strong>
                                    </span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Activate
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<?php
if($isActivated && empty($User->errors)){
    ?>
    <script src="/<?php echo WEB_PATH . "/" .  PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/<?php  echo WEB_PATH . "/" .  PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.css">
    <script>
        swal("You may now Login!", "Redirecting....", "success");
        setTimeout(function(){ window.location = "/<?PHP echo WEB_PATH;  ?>/login"; }, 3000);
    </script>
    <?php
}
?>
</body>
</html>
