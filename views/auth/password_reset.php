<!DOCTYPE html>
<html lang="en">
<?php
$isReset = false;
if(isset($_POST['token'])){
    $isReset = $User->doResetPassword();
}
require_once(VIEWS_PATH . "/layouts/auth.head.php");
?>
<body>
<?php
require_once(VIEWS_PATH ."/layouts/common/nav_bar.php");
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="#">

                        <input type="hidden" name="token" value="">

                        <div class="form-group">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="<?php echo $User->old("email"); ?>">
                                <?php
                                if (isset($User->errors['email'])){
                                    ?>
                                    <span class="help-block">
                                        <strong><?php echo $User->errors['email'];?></strong>
                                    </span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php
                            if (isset($User->errors['error'])){
                                ?>
                                <div class="col-md-6 col-md-offset-4">
                                <span class="text-danger">
                                        <strong><?php echo $User->errors['error'];?></strong>
                                    </span>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-refresh"></i>Reset Password
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
if($isReset && empty($User->errors)){
    ?>
    <script src="<?php echo WEB_PATH . "/" .  PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php  echo WEB_PATH . "/" .  PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.css">
    <script>
        swal("We have sent you an Email!", "Check your email", "success");
        //setTimeout(function(){ window.location = "home"; }, 3000);
    </script>
    <?php
}
?>
</body>
</html>
