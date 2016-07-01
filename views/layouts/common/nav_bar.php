<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="<?PHP echo WEB_PATH;  ?>/home">
                <img class="logo" src="<?PHP echo WEB_PATH;  ?>/resources/assets/logo.png" alt="Spa Advisor">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <?php
            // if($page != "home"){
                ?>
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="<?PHP echo WEB_PATH;  ?>/home">Home</a></li>
                    <li><a href="<?PHP echo WEB_PATH;  ?>/account/create_spa">Create Spa</a></li>
                    <li><a href="<?PHP echo WEB_PATH;  ?>/account/create_gym">Create Gym</a></li>
                    <li><a href="<?PHP echo WEB_PATH;  ?>/spas">View Spas</a></li>
                    <li><a href="<?PHP echo WEB_PATH;  ?>/gyms">View Gyms</a></li>
                </ul>
                <?php
            // }
            ?>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->

                <?php
                if($User->isLogged()){
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <?php echo $User->get("first_name"); ?> <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?PHP echo WEB_PATH;  ?>/account/"><i class="fa fa-btn fa-user"></i>Account</a></li>
                            <li><a href="<?PHP echo WEB_PATH;  ?>/logout"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                    <?php
                }else{
                    ?>
                    <li><a href="<?PHP echo WEB_PATH;  ?>/login">Login</a></li>
                    <li><a href="<?PHP echo WEB_PATH;  ?>/register">Register</a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
