<!DOCTYPE html>
<html lang="en" ng-app="CustomerApp" ng-controller="CustomerCtrl" >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title ng-bind="pagetitle()">
        
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

    <!-- Angular-tags CSS -->
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-tags/dist/angular-tags-0.2.10.css') ?>" rel="stylesheet" type="text/css" />


    <!-- Custom styles for this template -->
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/customer.css') ?>" rel="stylesheet">
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/darkish-font.css') ?>" rel="stylesheet">
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/sweetalert/lib/sweet-alert.css') ?>" type="text/css" rel="stylesheet" />

</head>
<body>
    <div class="container">

        <!-- navigation for small display -->
        <nav class="navbar navbar-inverse visible-xs small-display-nav" role="navigation" >
            <div class="row first-row">
                <div class="col col-xs-2 logo">
                    <a class="navbar-brand"><div class="icon icon-logo-farsi"></div></a>
                </div>
                <div class="col col-xs-8 record-title">
                    <h4>
                        <?php print $app->getUser()->getRecord()->getTitle(); ?>
                    </h4>
                </div>
                <div class="col col-xs-2 user-menu-button">
                    <?php $imageUrl = ($app->getUser()->getPhoto())? $app->getUser()->getPhoto()->getIconAbsolutePath() : $view['assets']->getUrl('bundles/darkishcustomer/images/default_profile.jpg'); ?>
                    <a ng-src="{{user.photo.icon_absolute_path}}" href="#" class="dropdown-toggle collapsed" data-toggle="collapse" role="button" data-target="#navbar-collapse-user-menu" aria-expanded="false"><img width="56" height="56" class="photo-icon" src="<?php echo $imageUrl; ?>" /> <!-- <span class="caret"></span> --></a>
                    
                </div>
                <div class="col col-xs-12 user-menu">
                    <div class="collapse navbar-collapse" id="navbar-collapse-user-menu">
                        <ul class="nav navbar-nav">
                            <li ng-class="{'active': (state.current.name == 'editprofile')}"><a ui-sref="editprofile">ویرایش پروفایل</a></li>
                            <li role="presentation" class="divider"></li>
                            <li>
                                <a href="<?php
                                echo $view['router']->generate('customer_logout')
                                ?>">
                                    خروج
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                    
                </div>
            </div>
            <div class="row second-row">
                <div class="col col-xs-3 main-menu-link">
                    <button type="button" class="navbar-toggle collapsed pull-right" data-toggle="collapse" data-target="#navbar-collapse-main-menu">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="col col-xs-6 col-xs-offset-3 centered-align">
                    <div class="navbar-text favoritcount"><div class="icon icon-heart"></div> <span class="count"><?php echo "".$app->getUser()->getRecord()->getFormattedFavoriteCount(); ?></span></div>
                    <div class="navbar-text likecount"><div class="icon icon-like"></div> <span class="count"><?php echo "".$app->getUser()->getRecord()->getFormattedLikeCount(); ?></span></div>
                    <div class="navbar-text visitcount"><div class="icon icon-eye"></div> <span class="count"><?php echo "".$app->getUser()->getRecord()->getFormattedVisitCount(); ?></span></div>                    
                    <div class="online-status">
                        <span class="glyphicon glyphicon-off" ng-class="{'online': isOnline(), 'offline': !isOnline()}" aria-hidden="true"></span>
                        <span ng-show="isOnline()" class="online status-text" >Online</span>
                        <span ng-show="!isOnline()" class="offline status-text" >Offline</span>
                    </div>
                </div>
                

                <div class="col col-xs-12">
                    <div class="collapse navbar-collapse" id="navbar-collapse-main-menu">
                        <ul class="nav navbar-nav">
                            <li ng-class="{'active': (state.current.name == 'profile')}"><a ui-sref="profile">پروفایل</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'htmlpage')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_HTML') > -1"><a ui-sref="htmlpage">صفحه آنلاین</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'messages')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_MESSAGE') > -1"><a ui-sref="messages">پیام ها</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'comments')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_COMMENT') > -1"><a ui-sref="comments">نظرات</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'attachments')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_ATTACHMENT') > -1"><a ui-sref="attachments">فایل ها</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'database')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_DATABASE') > -1"><a ui-sref="database">دیتابیس</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'store')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_STORE') > -1"><a ui-sref="store">فروشگاه آنلاین</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'users')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_ASSISTANT') > -1"><a ui-sref="users">کاربران</a></li>
                        </ul>
                    </div>
                </div>



                
            </div>
            
        </nav><!-- /navbar -->


        <!-- Navigation for large display -->
        <nav class="navbar navbar-inverse visible-lg visible-md visible-sm" role="navigation" >
            <div class="collapse navbar-collapse row large-display-nav" id="navbar-collapse-01">
                <div class="col col-sm-1 col-md-1 col-lg-1 logo">
                    <a class="navbar-brand"><div class="icon icon-logo-farsi"></div></a>
                </div>
                <div class="col col-sm-3 col-md-3 col-lg-3 primary-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a class="dropdown-toggle main-menu" data-toggle="dropdown" role="button" aria-expanded="false">{{state.current.data.label}}<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li ng-class="{'active': (state.current.name == 'profile')}"><a ui-sref="profile">پروفایل</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'htmlpage')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_HTML') > -1"><a ui-sref="htmlpage">صفحه آنلاین</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'messages')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_MESSAGE') > -1"><a ui-sref="messages">پیام ها</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'comments')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_COMMENT') > -1"><a ui-sref="comments">نظرات</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'attachments')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_ATTACHMENT') > -1"><a ui-sref="attachments">فایل ها</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'database')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_DATABASE') > -1"><a ui-sref="database">دیتابیس</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'store')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_STORE') > -1"><a ui-sref="store">فروشگاه آنلاین</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'users')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_ASSISTANT') > -1"><a ui-sref="users">کاربران</a></li>
                                
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col col-sm-3 col-md-4 col-lg-4 record-title">
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
                                <li ng-class="{'active': (state.current.name == 'editprofile')}"><a ui-sref="editprofile">ویرایش پروفایل</a></li>
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
        <div class="main-view" ui-view>
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
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcomment/bower_components/moment/moment.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/moment-jalaali/build/moment-jalaali.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcomment/bower_components/moment/locale/fa.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcomment/bower_components/angular-moment/angular-moment.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-ui-utils/ui-utils.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-scroll/angular-scroll.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-ui-bootstrap-bower/ui-bootstrap.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-ui-bootstrap-bower/ui-bootstrap-tpls.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-tags/dist/angular-tags-0.2.10.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-tags/dist/angular-tags-0.2.10-tpls.min.js') ?>"></script>
    
    
    
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/js/customer/customer-index-ctrl.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/js/customer/customer-message-ctrl.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/js/customer/customer-store-ctrl.js') ?>" type="text/javascript"></script>
</body>
</html>