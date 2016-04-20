<!DOCTYPE html>
<html lang="en">
<?php
$isRegistered = false;
if(isset($_POST['token'])){
    $isRegistered = $User->doRegister();
}
require_once(VIEWS_PATH ."/layouts/auth.head.php");
?>
<body>
<?php
require_once(VIEWS_PATH ."/layouts/common/nav_bar.php");
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="#">
                        <input type="hidden" name="token" value="register"/>
                        <div class="form-group <?php echo (isset($User->errors['first_name'])? ' has-error': '') ?>">
                            <label class="col-md-4 control-label">First Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="first_name" value="<?php echo $User->old("first_name"); ?>">
                                <?php
                                if (isset($User->errors['first_name'])){
                                    ?>
                                    <span class="help-block">
                                        <strong><?php echo $User->errors['first_name'];?></strong>
                                    </span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group <?php echo (isset($User->errors['last_name'])? ' has-error': '') ?>">
                            <label class="col-md-4 control-label">Last Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="last_name" value="<?php echo $User->old("last_name"); ?>">
                                <?php
                                if (isset($User->errors['last_name'])){
                                    ?>
                                    <span class="help-block">
                                        <strong><?php echo $User->errors['last_name'];?></strong>
                                    </span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

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

                        <div class="form-group <?php echo (isset($User->errors['password_confirmation'])? ' has-error': '') ?>">
                            <label class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">
                                <?php
                                if (isset($User->errors['password_confirmation'])){
                                    ?>
                                    <span class="help-block">
                                        <strong><?php echo $User->errors['password_confirmation'];?></strong>
                                    </span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group <?php echo (isset($User->errors['error'])? ' has-error': '') ?>">

                            <div class="col-md-6 col-md-offset-4">
                                <?php
                                if (isset($User->errors['error'])){
                                    ?>
                                    <span class="help-block">
                                        <strong><?php echo $User->errors['error'];?></strong>
                                    </span>
                                    <?php
                                }
                                ?>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Register
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
if($isRegistered && empty($User->errors)){
    ?>
    <script src="/<?php echo WEB_PATH . "/" .  PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/<?php  echo WEB_PATH . "/" .  PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.css">
    <script>
        swal("Successfully Registered", "Please verify your email to continue.", "success");
        setTimeout(function(){ window.location = "login"; }, 3000);
    </script>
    <?php
}
?>
</body>
</html>
