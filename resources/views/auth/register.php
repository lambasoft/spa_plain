<!DOCTYPE html>
<html lang="en">
<?php
require_once(ACTIONS_PATH . "/authenticate.php");
$authenticate = new Authenticate($auth);
$isRegistered = false;
if(isset($_POST['token'])){
    $isRegistered = $authenticate->Register();
}
require_once(RESOURCES_PATH ."/views/layouts/login.head.php");
?>
<body>
<?php
require_once(RESOURCES_PATH ."/views/layouts/common/nav_bar.php");
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="#">
                        <input type="hidden" name="token" value="register"/>
                        <div class="form-group <?php echo (isset($authenticate->errors['first_name'])? ' has-error': '') ?>">
                            <label class="col-md-4 control-label">First Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="first_name" value="<?php echo $authenticate->old("first_name"); ?>">
                                <?php
                                if (isset($authenticate->errors['first_name'])){
                                    ?>
                                    <span class="help-block">
                                        <strong><?php echo $authenticate->errors['first_name'];?></strong>
                                    </span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group <?php echo (isset($authenticate->errors['last_name'])? ' has-error': '') ?>">
                            <label class="col-md-4 control-label">Last Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="last_name" value="<?php echo $authenticate->old("last_name"); ?>">
                                <?php
                                if (isset($authenticate->errors['last_name'])){
                                    ?>
                                    <span class="help-block">
                                        <strong><?php echo $authenticate->errors['last_name'];?></strong>
                                    </span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group <?php echo (isset($authenticate->errors['email'])? ' has-error': '') ?>">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="<?php echo $authenticate->old("email"); ?>">
                                <?php
                                if (isset($authenticate->errors['email'])){
                                    ?>
                                    <span class="help-block">
                                        <strong><?php echo $authenticate->errors['email'];?></strong>
                                    </span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group <?php echo (isset($authenticate->errors['password'])? ' has-error': '') ?>">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                                <?php
                                if (isset($authenticate->errors['password'])){
                                    ?>
                                    <span class="help-block">
                                        <strong><?php echo $authenticate->errors['password'];?></strong>
                                    </span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group <?php echo (isset($authenticate->errors['password_confirmation'])? ' has-error': '') ?>">
                            <label class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">
                                <?php
                                if (isset($authenticate->errors['password_confirmation'])){
                                    ?>
                                    <span class="help-block">
                                        <strong><?php echo $authenticate->errors['password_confirmation'];?></strong>
                                    </span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group <?php echo (isset($authenticate->errors['error'])? ' has-error': '') ?>">

                            <div class="col-md-6 col-md-offset-4">
                                <?php
                                if (isset($authenticate->errors['error'])){
                                    ?>
                                    <span class="help-block">
                                        <strong><?php echo $authenticate->errors['error'];?></strong>
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
if($isRegistered && empty($authenticate->errors)){
    ?>
    <script src="<?php echo PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo PLUGINS_PATH . "/sweetalert";?>/dist/sweetalert.css">
    <script>
        swal("Successfully Registered", "Please verify your email to continue.", "success");
        setTimeout(function(){ window.location = "login"; }, 3000);
    </script>
    <?php
}
?>
</body>
</html>
