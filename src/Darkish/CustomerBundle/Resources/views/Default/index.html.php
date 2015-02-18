<!DOCTYPE html>
<html lang="en" ng-app="CustomerApp" ng-controller="CustomerCtrl" >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>
        درکیش  |
        {{pageTitle}}
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


</head>
<body>
    <div class="container">
        <nav class="navbar navbar-inverse navbar-lg" role="navigation">
            <div class="navbar-header pull-right">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
                    <span class="sr-only">Toggle navigation</span>
                </button>
                <a class="navbar-brand" href="#">درکیش</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse-01">
                <ul class="nav navbar-nav navbar-left">
                    <li><span class="navbar-text">ویزیت <span class="badge"><?php echo $app->getUser()->getRecord()->getVisitCount(); ?></span></span></li>
                    <li><span class="navbar-text">لایک <span class="badge"><?php echo $app->getUser()->getRecord()->getLikeCount(); ?></span></span></li>
                    <li><span class="navbar-text">مورد علاقه <span class="badge"><?php echo $app->getUser()->getRecord()->getFavoriteCount(); ?></span></span></li>
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
        <div class="row">
            <div class="col col-xs-2 sidebar">
                <nav class="navbar nav-sidebar">
                    <div class="list-group">
                        <a href="#" class="list-group-item">پروفایل</a>
                        <a href="#" class="list-group-item">صفحه آنلاین</a>
                        <a href="#" class="list-group-item">پیام ها</a>
                        <a href="#" class="list-group-item active">نظرات</a>
                        <a href="#" class="list-group-item">فایل ها</a>
                        <a href="#" class="list-group-item">دیتابیس</a>
                        <a href="#" class="list-group-item">فروشگاه آنلاین</a>
                        <a href="#" class="list-group-item">کاربران</a>
                        
                    </div>
                </nav>
                
                
            </div>
            <div class="col col-xs-10">
                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-default">1</button>
                    <button type="button" class="btn btn-default">2</button>

                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Dropdown
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Dropdown link</a></li>
                            <li><a href="#">Dropdown link</a></li>
                        </ul>
                    </div>
                </div>
            </div>
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
    
    
    
    
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/js/customer/customer-index-ctrl.js') ?>" type="text/javascript"></script>
</body>
</html>