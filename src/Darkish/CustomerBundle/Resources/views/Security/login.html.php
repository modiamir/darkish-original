<html lang="en"><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>ورود به پنل مدیریت</title>

        <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/screen.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
        <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/print.css') ?>" media="print" rel="stylesheet" type="text/css" />
        <!--[if IE]>
            <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/ie.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
        <![endif]-->


        <!-- Bootstrap core CSS -->
        <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />

        <!-- Bootstrap-rtl CSS -->
        <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/bootstrap-rtl/dist/css/bootstrap-rtl.min.css') ?>" rel="stylesheet" type="text/css" />
        
        <!-- FlatUI CSS -->
        <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/flat-ui/dist/css/flat-ui.min.css') ?>" rel="stylesheet" type="text/css" />
        
        <!-- Custom styles for this template -->
        <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/login.css') ?>" rel="stylesheet">

        <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/font-darkish.css') ?>" rel="stylesheet">



    </head>

    <body>
        




<?php if ($error): ?>
    <div><?php echo $error->getMessage() ?></div>
<?php endif ?>

    
    <div class="login-page container">
        <div class="row">
            <div class="col col-xs-offset-1 col-xs-10 col-md-3 col-md-offset-3 ">
                <h4 class="page-title">
                    ورود مشتریان
                </h4>
            </div>
            <div class="col col-xs-offset-1 col-xs-10 col-md-3 col-md-offset-0">
                <h3 class="logo">
                    <div class="dk icon-logo"></div>
                </h3>
            </div>
        </div>
        
        <form action="<?php echo $view['router']->generate('customer_login_check') ?>" method="post">
        <div class="row">
            <div class="login-form login-form col col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3">

                <div class="form-group">
                    <input type="text" value="<?php echo $last_username ?>" class="form-control login-field" name="_username" placeholder="پست الکترونیکی" id="username">
                    <label class="login-field-icon fui-user" for="login-name"></label>
                </div>

                <div class="form-group">
                    <input type="password" id="password" name="_password" class="form-control login-field" value="" placeholder="رمز عبور" >
                    <label class="login-field-icon fui-lock" for="login-pass"></label>
                </div>

                <input type="submit" class="btn btn-primary btn-lg btn-block" value="ورود" />
                <a class="login-link" href="#">رمز عبور خود را فراموش کردید؟</a>
            </div>
        </div>
        </form>
    </div>
    
    

</html>