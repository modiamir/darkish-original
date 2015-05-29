<!DOCTYPE html>
<html lang="fa" ng-app="CustomerApp" ng-controller="CustomerCtrl" >
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

    <!-- angular material CSS -->
    <!-- <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-material/angular-material.min.css') ?>" rel="stylesheet" type="text/css" /> -->

    <!-- ng-scroll CSS -->
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ng-scrollbar/dist/ng-scrollbar.min.css') ?>" rel="stylesheet" type="text/css" />

    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ang-accordion/css/ang-accordion.css') ?>" rel="stylesheet" type="text/css" />

    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ng-sortable/dist/ng-sortable.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ng-sortable/dist/ng-sortable.style.min.css') ?>" rel="stylesheet" type="text/css" />

    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-loading-bar/build/loading-bar.css') ?>" rel="stylesheet" type="text/css" />

    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ngDialog/css/ngDialog.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ngDialog/css/ngDialog-theme-default.min.css') ?>" rel="stylesheet" type="text/css" />

    <link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/ng-ckeditor.css') ?>" type="text/css" rel="stylesheet" />



    <!-- Custom styles for this template -->
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/customer.css') ?>" rel="stylesheet">
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/customer-database.css') ?>" rel="stylesheet">
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/customer-user.css') ?>" rel="stylesheet">
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/customer-comments.css') ?>" rel="stylesheet">
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/customer-html.css') ?>" rel="stylesheet">
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/customer-attachment.css') ?>" rel="stylesheet">
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/rtl.css') ?>" rel="stylesheet">
    <!-- <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/angular-material-rtl.css') ?>" rel="stylesheet"> -->
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/font-darkish.css') ?>" rel="stylesheet">
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/emotions.css') ?>" rel="stylesheet">
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/sweetalert/lib/sweet-alert.css') ?>" type="text/css" rel="stylesheet" />

</head>
<body ng-class="state.current.name | dotToDash">

    <div class="container nav-container">
        <!-- navigation for small display -->
        <nav class="navbar navbar-inverse visible-xs small-display-nav navbar-fixed-top" role="navigation" >
            <div class="row first-row">
                <div class="col col-xs-2 main-menu-link logo">
                    <button type="button" class="navbar-toggle collapsed pull-center" data-toggle="collapse" data-target="#navbar-collapse-main-menu">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    
                </div>


                <div class="col col-xs-2 logo">
                    <a class="navbar-brand"><div class="dk icon-logo-farsi"></div></a>
                </div>
                <div class="col col-xs-4 record-title">
                    <h4>
                        {{state.current.data.label}}
                    </h4>
                </div>
                <div class="col col-xs-2 centered-align">
                    <div class="online-status">
                        <span class="glyphicon glyphicon-off" ng-class="{'online': isOnline(), 'offline': !isOnline()}" aria-hidden="true"></span>
                        <span ng-show="isOnline()" class="online status-text" >Online</span>
                        <span ng-show="!isOnline()" class="offline status-text" >Offline</span>
                    </div>                                      
                    
                </div>
                <div class="col col-xs-2 user-menu-button">
                    <?php $imageUrl = ($app->getUser()->getPhoto())? $app->getUser()->getPhoto()->getIconAbsolutePath() : $view['assets']->getUrl('bundles/darkishcustomer/images/default_profile.jpg'); ?>
                    <a ng-src="{{user.photo.icon_absolute_path}}" href="" class="dropdown-toggle collapsed" data-toggle="collapse" role="button" data-target="#navbar-collapse-user-menu" aria-expanded="false"><img width="56" height="56" class="photo-icon" src="<?php echo $imageUrl; ?>" /> <!-- <span class="caret"></span> --></a>
                    
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
                <div class="col col-xs-12 main-menu">
                    <div class="collapse navbar-collapse" id="navbar-collapse-main-menu">
                        <ul class="nav navbar-nav">
                            <li ng-class="{'active': (state.current.name == 'profile')}"><a ui-sref="profile">پروفایل</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'htmlpage')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_HTML') > -1"><a ui-sref="htmlpage">صفحه آنلاین</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'messages')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_MESSAGE') > -1"><a ui-sref="messages">پیام ها</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'comments')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_COMMENT') > -1"><a ui-sref="comments.all">نظرات</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'attachments')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_ATTACHMENT') > -1"><a ui-sref="attachments">فایل ها</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'database')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_DATABASE') > -1">
                                        <a ng-show="user.record.dbase_type_index.id == 1" ui-sref="database">مدیریت املاک</a>
                                        <a ng-show="user.record.dbase_type_index.id == 2" ui-sref="database">مدیریت خودروها</a>
                                </li>
                                

                                <li ng-class="{'active': (state.current.name == 'store')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_STORE') > -1"><a ui-sref="store">فروشگاه آنلاین</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'user')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_ASSISTANT') > -1"><a ui-sref="user">کاربران</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
        </nav><!-- /navbar -->


        <!-- Navigation for large display -->
        <nav class="navbar navbar-inverse visible-lg visible-md visible-sm" role="navigation" >
            <div class="collapse navbar-collapse row large-display-nav" id="navbar-collapse-01">
                <div class="col col-sm-1 col-md-1 col-lg-1 logo">
                    <a class="navbar-brand"><div class="dk icon-logo-farsi"></div></a>
                </div>
                <div class="col col-sm-2 col-md-3 col-lg-3 primary-menu">
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
                                    ng-show="access.indexOf('ROLE_CUSTOMER_COMMENT') > -1"><a ui-sref="comments.all">نظرات</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'attachments')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_ATTACHMENT') > -1"><a ui-sref="attachments">فایل ها</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'database')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_DATABASE') > -1">
                                        <a ng-show="user.record.dbase_type_index.id == 1" ui-sref="database">مدیریت املاک</a>
                                        <a ng-show="user.record.dbase_type_index.id == 2" ui-sref="database">مدیریت خودروها</a>
                                </li>
                                
                                <li ng-class="{'active': (state.current.name == 'store')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_STORE') > -1"><a ui-sref="store">فروشگاه آنلاین</a></li>
                                
                                <li ng-class="{'active': (state.current.name == 'user')}"
                                    ng-show="access.indexOf('ROLE_CUSTOMER_ASSISTANT') > -1"><a ui-sref="user">کاربران</a></li>
                                
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col col-sm-5 col-md-4 col-lg-4 record-title">
                    <h4>
                        <?php print $app->getUser()->getRecord()->getTitle(); ?>
                    </h4>
                </div>
                <div class="col col-sm-4 col-md-4 col-lg-4 user-menu">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <div class="online-status">
                                <span class="glyphicon glyphicon-off" ng-class="{'online': isOnline(), 'offline': !isOnline()}" aria-hidden="true"></span>
                                <span ng-show="isOnline()" class="online status-text" >Online</span>
                                <span ng-show="!isOnline()" class="offline status-text" >Offline</span>
                            </div>
                        </li>
                        <li><span class="navbar-text visitcount"><div class="dk icon-eye"></div> <span class="count"><?php echo "".$app->getUser()->getRecord()->getFormattedVisitCount(); ?></span></span></li>
                        <li><span class="navbar-text likecount"><div class="dk icon-like"></div> <span class="count"><?php echo "".$app->getUser()->getRecord()->getFormattedLikeCount(); ?></span></span></li>
                        <li><span class="navbar-text favoritcount"><div class="dk icon-heart"></div> <span class="count"><?php echo "".$app->getUser()->getRecord()->getFormattedFavoriteCount(); ?></span></span></li>
                        <li class="dropdown">
                            <?php $imageUrl = ($app->getUser()->getPhoto())? $app->getUser()->getPhoto()->getIconAbsolutePath() : $view['assets']->getUrl('bundles/darkishcustomer/images/default_profile.jpg'); ?>
                            <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img class="photo-icon" src="<?php echo $imageUrl; ?>" /> <!-- <span class="caret"></span> --></a>
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
    </div>
    <div class="container">

        
        <div class="main-view" ui-view>
        </div>

    </div>
    <div ng-cloak ng-init="loaded=false" ng-show="loaded" ng-class="{'loaded': loaded, 'notloaded': !loaded }" class="notloaded" >
        


    

    

    </div>
    <div id="loading" ng-hide="loaded" ng-cloak ng-class="{'loaded': loaded }">
        <i class="fa fa-circle-o-notch fa-spin"></i>
    </div>

    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/jquery/dist/jquery.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/jquery-ui/jquery-ui.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular/angular.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-sanitize/angular-sanitize.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-animate/angular-animate.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-aria/angular-aria.min.js') ?>" type="text/javascript"></script>
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
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-tags/dist/angular-tags-0.2.10.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-tags/dist/angular-tags-0.2.10-tpls.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ng-scrollbar/dist/ng-scrollbar.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-elastic/elastic.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ng-resize/ngresize.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-validation/dist/angular-validation.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-validation/dist/angular-validation-rule.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-virtual-scroll/angular-virtual-scroll.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ang-accordion/js/ang-accordion.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ng-sortable/dist/ng-sortable.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ngDialog/js/ngDialog.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ng-ckeditor/libs/ckeditor/ckeditor.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ng-ckeditor/ng-ckeditor.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-validation-match/dist/angular-input-match.js') ?>"></script>

    <!-- <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-touch/angular-touch.js') ?>"></script> -->
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-loading-bar/build/loading-bar.js') ?>"></script>
    
    <!-- <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-contenteditable/angular-contenteditable.js') ?>"></script> -->


    
    
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/js/customer/customer-index-ctrl.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/js/customer/customer-directives.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/js/customer/customer-message-ctrl.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/js/customer/customer-store-ctrl.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/js/customer/customer-database-ctrl.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/js/customer/customer-user-ctrl.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/js/customer/customer-comments-ctrl.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/js/customer/customer-html-ctrl.js') ?>" type="text/javascript"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/js/customer/customer-attachment-ctrl.js') ?>" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).keydown(function(e) {
            var nodeName = e.target.nodeName.toLowerCase();

            if (e.which === 8) {
                if ((nodeName === 'input' && e.target.type === 'text') || 
                    (nodeName === 'input' && e.target.type === 'number') || 
                    (nodeName === 'input' && e.target.type === 'password') || 
                    nodeName === 'textarea') {
                    // do nothing
                } else {
                    e.preventDefault();
                }
            }
        });
    </script>
</body>
</html>