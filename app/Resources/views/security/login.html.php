
    
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>ورود به پنل مدیریت</title>

    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/stylesheets/screen.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/stylesheets/print.css') ?>" media="print" rel="stylesheet" type="text/css" />
    <!--[if IE]>
        <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/stylesheets/ie.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
    <![endif]-->

    
    <!-- Bootstrap core CSS -->
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />

    <!-- Custom styles for this template -->
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/stylesheets/styles.css') ?>" rel="stylesheet">

    
    
  </head>

  <body>

    <div class="container">

    <?php if ($error): ?>
        <div><?php echo $error->getMessage() ?></div>
    <?php endif ?>

    <form dir="rtl" class="operator-login-form" action="<?php echo $view['router']->generate('login_check') ?>" method="post">
        <h2>
            وارد شوید
        </h2>
        <div class="form-group">
            <label for="username">نام کاربری:</label>
            <input dir="ltr" class="form-control" placeholder="نام کاربری" type="text" id="username" name="_username" value="<?php echo $last_username ?>" />
        </div>
        <div class="form-group">
            <label for="password">رمز عبور:</label>
            <input dir="ltr" class="form-control" placeholder="رمز عبور" type="password" id="password" name="_password" />
        </div>
        <div class="form-group">
            <input type="checkbox" id="remember_me" name="_remember_me" checked />
            <label for="remember_me">مرا به خاطر بسپار</label>
        </div>
        <!--
            If you want to control the URL the user
            is redirected to on success (more details below)
            <input type="hidden" name="_target_path" value="/account" />
        -->

        <button class="btn btn-default" type="submit">ورود</button>
    </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  

</body>
</html>