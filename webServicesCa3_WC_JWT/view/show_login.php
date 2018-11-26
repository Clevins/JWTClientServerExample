<div class="container">	
    <div class="row" style="margin-bottom:100px; margin-top:100px;">
        <h2>Login</h2><br/>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Start form -->
            <form id="login_form" action="../controller/index.php" method="post">
                <input type="hidden" name="action" value="login">
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
        </div>



    </div>
</div>