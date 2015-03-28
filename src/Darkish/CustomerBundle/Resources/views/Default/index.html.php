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
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/darkish-font.css') ?>" rel="stylesheet">
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/sweetalert/lib/sweet-alert.css') ?>" type="text/css" rel="stylesheet" />

</head>
<body>
    <div class="container">

        <!-- navigation for small display -->
        <nav class="navbar navbar-inverse visible-xs" role="navigation" >
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-01">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">کوچک</a>
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


        <!-- Navigation for large display -->
        <nav class="navbar navbar-inverse visible-lg visible-md visible-sm " role="navigation" >
            <div class="collapse navbar-collapse row large-display-nav" id="navbar-collapse-01">
                <div class="col col-sm-1 col-md-1 col-lg-1 logo">
                    <a class="navbar-brand" href="#"><div class="icon icon-logo"></div></a>
                </div>
                <div class="col col-sm-2 col-md-3 col-lg-3 primary-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a class="dropdown-toggle main-menu" data-toggle="dropdown" role="button" aria-expanded="false">{{state.current.data.label}}<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
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
                </div>
                <div class="col col-sm-4 col-md-4 col-lg-4 record-title">
                    <h4>
                        <?php print $app->getUser()->getRecord()->getTitle(); ?>
                    </h4>
                </div>
                <div class="col col-sm-5 col-md-4 col-lg-4 user-menu">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <div class="online-status">
                                <span class="glyphicon glyphicon-off" ng-class="{'online': isOnline(), 'offline': !isOnline()}" aria-hidden="true"></span>
                                <span ng-show="isOnline()" class="online status-text" >Online</span>
                                <span ng-show="!isOnline()" class="offline status-text" >Offline</span>
                            </div>
                        </li>
                        <li><span class="navbar-text visitcount"><div class="icon icon-eye"></div> <span class="count"><?php echo "".$app->getUser()->getRecord()->getFormattedVisitCount(); ?></span></span></li>
                        <li><span class="navbar-text likecount"><div class="icon icon-like"></div> <span class="count"><?php echo "".$app->getUser()->getRecord()->getFormattedLikeCount(); ?></span></span></li>
                        <li><span class="navbar-text favoritcount"><div class="icon icon-heart"></div> <span class="count"><?php echo "".$app->getUser()->getRecord()->getFormattedFavoriteCount(); ?></span></span></li>
                        <li class="dropdown">
                            <?php $imageUrl = ($app->getUser()->getPhoto())? $app->getUser()->getPhoto()->getIconAbsolutePath() : $view['assets']->getUrl('bundles/darkishcustomer/images/default_profile.jpg'); ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img class="photo-icon" src="<?php echo $imageUrl; ?>" /> <!-- <span class="caret"></span> --></a>
                            <ul class="dropdown-menu dropdown-menu-left" role="menu">
                                <li><a ui-sref="profile">پروفایل</a></li>
                                <li><a ui-sref="editprofile">ویرایش پروفایل</a></li>
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
                </div>
                
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