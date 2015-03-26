<!DOCTYPE html>
<html lang="en" ng-app="CustomerApp" ng-controller="CustomerCtrl" >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>
        درکیش  |
        {{pageTitle}} |
        {{state.current.data.label}}
    </title>

    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/screen.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/print.css') ?>" media="print" rel="stylesheet" type="text/css" />
    <!--[if IE]>
        <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/ie.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
    <![endif]-->


    <!-- Bootstrap core CSS -->
    <!--<link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />-->
    
    <!-- Bootswatch core CSS -->
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/bootswatch/flatly/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />

    <!-- Bootstrap-rtl CSS -->
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/bootstrap-rtl/dist/css/bootstrap-rtl.min.css') ?>" rel="stylesheet" type="text/css" />

    <!-- Custom styles for this template -->
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/customer.css') ?>" rel="stylesheet">
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/sweetalert/lib/sweet-alert.css') ?>" type="text/css" rel="stylesheet" />

</head>
<body>

    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="true">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Brand</a>
        </div>

        <div class="navbar-collapse collapse in" id="bs-example-navbar-collapse-2" aria-expanded="true">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
            <li><a href="#">Link</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li class="divider"></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
          <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Link</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-01">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">درکیش</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse-01">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{state.current.data.label}}<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a ui-sref="profile">پروفایل</a></li>
                            <li><a ui-sref="editprofile">ویرایش پروفایل</a></li>
                            <li><a ui-sref="htmlpage">صفحه آنلاین</a></li>
                            <li><a ui-sref="messages">پیام ها</a></li>
                            <li><a ui-sref="comments">نظرات</a></li>
                            <li><a ui-sref="attachments">فایل ها</a></li>
                            <li><a ui-sref="database">دیتابیس</a></li>
                            <li><a ui-sref="store">فروشگاه آنلاین</a></li>
                            <li><a ui-sref="users">کاربران</a></li>
                            
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-left">
                    <li><a><span class="navbar-text">ویزیت <span class="badge"><?php echo $app->getUser()->getRecord()->getVisitCount(); ?></span></span></a></li>
                    <li><a><span class="navbar-text">لایک <span class="badge"><?php echo $app->getUser()->getRecord()->getLikeCount(); ?></span></span></a></li>
                    <li><a><span class="navbar-text">مورد علاقه <span class="badge"><?php echo $app->getUser()->getRecord()->getFavoriteCount(); ?></span></span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $app->getUser()->getUsername() ?><span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left" role="menu">
                            <li class="dropdown-messages"><a>شماره رکورد: <span class="badge">R<?php echo $app->getUser()->getRecord()->getRecordNumber() ?></span></a></li>
                            <li><a>آخرین بروزرسانی: <span class="badge"><?php $lastUpdate = $app->getUser()->getRecord()->getLastUpdate(); echo $lastUpdate->format('Y-m-d H:i:s'); ?></span></a></li>
                            <li role="presentation" class="divider"></li>
                            <li>
                                <a href="<?php
                                echo $view['router']->generate('customer_logout')
                                ?>">
                                    خروج
                                </a>
                            </li>
                            
                        </ul>
                    </li>
                </ul>
                
            </div><!-- /.navbar-collapse -->
        </nav><!-- /navbar -->



        <div class="" ui-view>
        </div>

    </div>
    <div ng-cloak ng-init="loaded=false" ng-show="loaded" ng-class="{'loaded': loaded, 'notloaded': !loaded }" class="notloaded" >
        


    

    

    </div>
    <div id="loading" ng-hide="loaded" ng-cloak ng-class="{'loaded': loaded }">
        <i class="fa fa-circle-o-notch fa-spin"></i>
    </div>
    
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular/angular.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/jquery/dist/jquery.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-ui-router/release/angular-ui-router.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/humps/humps.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-sweetalert/SweetAlert.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/sweetalert/lib/sweet-alert.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-file-upload/angular-file-upload.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ng-password-strength/dist/scripts/ng-password-strength.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-validation-match/dist/angular-input-match.js') ?>"></script>


    
    
    
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/js/customer/customer-index-ctrl.js') ?>" type="text/javascript"></script>
</body>
</html>