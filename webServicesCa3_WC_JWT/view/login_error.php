<?php
include_once'..\view\nav.php';
?>

<!--Login Form-->
<h2>Login Error</h2>
<h4>Incorrect Username Or Paassword</h4>
<div class="container">	
    <div class="row" style="margin-bottom:100px; margin-top:100px;">
        <h2>Login</h2><br/>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Start form -->
            <form id="login_form" action="../model/login.inc.php" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label><span></span>
                    <input type="text" class="form-control" id="login" name="username" >
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label><span></span>
                    <input type="password" class="form-control" id="login_password" name="password"  placeholder="Password">
                </div>
                <div class="form-check"> 
                    <button type="submit" class="btn btn-primary" id="reg_button" name="login-submit">Submit</button>
                </div>

            </form>


            <!-- End form -->
        </div>



    </div>
</div>
<?php
require_once'..\view\nav.php';
