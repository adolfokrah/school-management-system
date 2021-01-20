
<?php
    include 'auto_login.php';
?>
<div class="content">
    <div class="top-bar">
        <div class="content" style="background-color:#004c6c; color: white; font-size:12px; line-height: 1.6em; padding: 5px;">
            <div class="row" style="width:98%;">
                <div class="col-md-4 pull-right"><i class="fa fa-map-marker" aria-hidden="true"></i>
 Location: Accra-Central  <i class="fa fa-phone" aria-hidden="true"></i>  Contact us on: (+233) 245-301631 | (+233) 57 768 1063 <br/><i class="fa fa-facebook-official" aria-hidden="true"></i>
 easyskul  <i class="fa fa-linkedin-square" aria-hidden="true"></i>
 easyskul  <i class="fa fa-twitter-square" aria-hidden="true"></i>
 @easyskul  <i class="fa fa-envelop" aria-hidden="true"></i>
 info@easyskul.com</div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-default  " role="navigation" style="border-radius: 0px">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <img src="web_images/logo.png" width="120px" style="float:left; display: block; margin-top: 5px;"/>
          
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li id="home"><a href="index.php">HOME</a></li>
            <li id="about"><a href="about.php">ABOUT</a></li>
            <li id="faq"><a href="faq.php">FAQ</a></li>
            <li id="faq"><a href="register.php">REGISTER MY SCHOOL</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li><p class="navbar-text" style="padding-left:15px">Already have an account?</p></li>
            <li>
              <a href="login"><span class="fa fa-user"></span> <b> My School</b></a>
<!--
                <ul id="login-dp" class="dropdown-menu" style="padding:0px; padding-top:15px;">
                    <li>
                         <div class="a" style="width:100%; padding:0px;">
                             
                                <div class="col-md-12">
                                    <p>Login</p><hr/>
                                     <form class="form" role="form"  accept-charset="UTF-8" id="login-nav">
                                         <small>Please input your crendentials below.</small><br/><br/>
                                            <div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-user"></i>
												</span> 
												<input class="form-control" placeholder="User ID / EMAIL" name="loginname" type="text" autofocus required id="username">
											</div><br/>
                                            <div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-lock"></i>
												</span> 
												<input class="form-control" placeholder="password" name="loginname" type="password" id="password" autofocus required>
											</div><br/>
                                            <div class="form-group">
                                                 <button type="button" class="btn btn-primary" id="login" style="border-radius:1px;">Sign in</button>
                                                 <a href="add_account.php"><button type="button" class="btn btn-default" style="border-radius:1px;">Add Account</button></a>
                                            </div>
                                            <div class="checkbox">
                                                <center><a href="forgotten_password.php">Forgotten Password?</a></center>
                                                 <label>
                                                 <input type="checkbox" id="ip"> keep me logged-in
                                                 </label>
                                            </div>
                                     </form>
                                </div>
                                <div class="bottom text-center">
                                    New here ? <a href="register.php"><b>Join Us</b></a>
                                </div>
                         </div>
                    </li>
                </ul>
-->
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
</div>

<?php 
    
    //CHECK IF USER HAS ALREADY VISTED THE SITE
    $query = mysqli_query($conn,"select * from `visitors` where  `USER IP ADDRESS` ='$ip'");
    if(mysqli_num_rows($query) < 1){
        $date = date('Y-m-d');
        mysqli_query($conn,"INSERT INTO `visitors` (`ID`, `USER IP ADDRESS`, `DATE`) VALUES (NULL, '$ip', '$date');");
    }
?>
<!-- jQuery CDN -->
       
