<!DOCTYPE html>
<html lang="en">
<?php
$isLogged = false;
if(isset($_POST['token'])){
    $isLogged = $Spa->add();
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
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="#">
                        <input type="hidden" name="token" value="login">
                        <div class="form-group <?php echo (isset($User->errors['email'])? ' has-error': '') ?>">
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

                        <div class="form-group <?php echo (isset($User->errors['password'])? ' has-error': '') ?>">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                                <?php
                                if (isset($User->errors['password'])){
                                    ?>
                                    <span class="help-block">
                                        <strong><?php echo $User->errors['password'];?></strong>
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
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Login
                                </button>
                                <a class="btn btn-link" href="password_reset">Forgot Your Password?</a>
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
if($isLogged && empty($User->errors)){
    ?>
    <script src="<?php echo PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.css">
    <script>
        swal("Successfully Logged In!", "Redirecting....", "success");
        setTimeout(function(){ window.location = "home"; }, 3000);
    </script>
    <?php
}
?>
</body>
</html>
