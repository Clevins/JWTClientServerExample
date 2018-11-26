<!--<div class="container">
    <div class="row">
        <h1> Request JWT Key</h1>

        <form action="../controller/home.php" method="POST" id="add_product_form">
            <input type="hidden" name="action" value="request_token">
            <label>User Name: </label>
            <input type="text" name ="userName" placeholder="Enter user name" required />
            <br>
            <label>Password: </label>
            <input type="text" name ="password" placeholder="Enter Password" required />
            <br>
            <label>Member Type </label>
            <input type="text" name ="memType" placeholder="Enter member Type" required />
            <br>
            <label>&nbsp;</label>
            <input type="submit" value="Get Key" />
            <br>        
        </form>   
    </div> 
</div>
-->
<div class="container">	
    <div class="row" style="margin-bottom:100px; margin-top:100px;">
        <h2>Request API key</h2><br/>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Start form -->
            <form id="login_form" action="../controller/index.php" method="post">
                <input type="hidden" name="action" value="request_token">
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label><span></span>
                    <input type="text" class="form-control" id="login" name="userName" >
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label><span></span>
                    <input type="password" class="form-control" id="login_password" name="password"  placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Member Type</label><span></span>
                    <input type="text" class="form-control" id="login_password" name="memType"  placeholder="Password">
                </div>
                <label>&nbsp;</label>
                <input type="submit" value="Get Key" />

            </form>


            <!-- End form -->
        </div>



    </div>
</div>



