<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Easy Skul | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <!-- Font Awesome -->

    <link rel="stylesheet" href="css/font-awesome.css">
  <!-- Ionicons -->

    <link rel="stylesheet" href="css/ionicons.min.css">
  <!-- Theme style -->

    <link rel="stylesheet" href="css/AdminLTE.min.css">
  <!-- iCheck -->
    <link rel="stylesheet" href="css/blue.css">
        <script src="sweetalert2-master/dist/sweetalert2.all.min.js"></script>
        <script src="js/cms.js"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
   <a href="cpanel.php"><b>EasySkul</b>Cpanel</a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name">Easy Skul</div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="web_images/avatar.png" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials" method="POST">
      <div class="input-group">
        <input type="password" id="password" name="password" class="form-control" placeholder="password">
          <input type="hidden" id="user" name="user" value="easyskulAdmin">

        <div class="input-group-btn">
          <button type="button" onclick="login()" id="login_btn" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Enter password to start your session
  </div>

  <div class="lockscreen-footer text-center">
    Copyright &copy; 2017-<?php echo date('Y'); ?><b><a href="https://easyskul.com" class="text-black"> EasySkul</a></b><br>
    All rights reserved
  </div>
</div>
<!-- /.center -->

<!-- jQuery 3 -->

<script src="js/jQuery-v2.1.3.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="js/boostrap.min.js"></script>
</body>
</html>