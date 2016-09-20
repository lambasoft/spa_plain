<!DOCTYPE html>
<html lang="en">
<?php
$isCreated = false;
$Gym = new Gym($DB);
if(isset($_POST['token'])){
    $_POST['link_user_id'] = $User->get("id");
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
    <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyDjh5wt_fi_kx-zFKbcVF5XSUWcOFJlcj4'></script>
    <script src="../bower_components/jquery-locationpicker-plugin/dist/locationpicker.jquery.js"></script>
    <script src="../bower_components/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <link rel="stylesheet" type="text/css" href="../bower_components/jquery.tagsinput/src/jquery.tagsinput.css" />

    <script>


      $('#locationGUI').before("<input type='text' id='us2-address' class='form-control' style='margin:10px;width:250px'/>");
      <?php
      $ip  = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
      $info = getIPInfo($ip);
      ?>
      $('#tags').tagsInput({
         'height':'50px',
         'width':'200px',
         'defaultText':'add Tag',
         'delimiter': [',',';',' '],
       });
      $('#locationGUI').locationpicker({
      	location: {latitude: <?php echo $info->latitude; ?>, longitude: <?php echo $info->longitude; ?>},
      	radius: 0,
        inputBinding: {
            locationNameInput: $('#us2-address')
        },
        enableAutocomplete: true,
        onchanged: function(currentLocation, radius, isMarkerDropped) {
          $("#locationGYM").val(currentLocation.latitude + "," + currentLocation.longitude);
          console.log("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");
        },
        oninitialized: function(component) {
          $("#locationGYM").val(<?php echo $info->latitude; ?> + "," + <?php echo $info->longitude; ?>);
        }
    	});
    </script>
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
