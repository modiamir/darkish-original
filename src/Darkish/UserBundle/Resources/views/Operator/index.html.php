<?php $view->extend('::panel_layout_second.html.php') ?>


<?php $view['slots']->start('stylesheets') ?>
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/bootstrap-rtl/dist/css/bootstrap-rtl.min.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/stylesheets/operator/operator.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/font-awesome/css/font-awesome.min.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/sweetalert/lib/sweet-alert.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-ui-switch/angular-ui-switch.min.css') ?>" type="text/css" rel="stylesheet" />
    
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('javascripts') ?>

    <script src="<?php echo $view['assets']->getUrl('bundles/fosjsrouting/js/router.js') ?>"></script>
        
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular/angular.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-ui-router/release/angular-ui-router.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-smart-table/dist/smart-table.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-collection/angular-collection.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-prompt/dist/angular-prompt.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-file-upload/angular-file-upload.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/humps/humps.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-validation-match/dist/angular-input-match.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-sweetalert/SweetAlert.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/sweetalert/lib/sweet-alert.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-ui-switch/angular-ui-switch.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/checklist-model/checklist-model.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-bootstrap-checkbox/angular-bootstrap-checkbox.js') ?>"></script>
    
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/js/operator/operator-index-app.js') ?>"></script>

    
    
<?php $view['slots']->stop() ?>
    
<?php $view['slots']->start('pagetitle') ?>مدیریت اپراتور ها<?php $view['slots']->stop() ?>

<?php $view['slots']->start('ngapp') ?>operatorApp<?php $view['slots']->stop() ?>

<?php $view['slots']->start('controller') ?>operatorIndexCtrl<?php $view['slots']->stop() ?>

<?php $view['slots']->start('top-menu');?>
    <ul class="nav navbar-nav">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown">مدیریت اپراتورها<span class="caret"></span></a>
            <?php print $view['knp_menu']->render('main') ?>
        </li>
    </ul>
<?php $view['slots']->stop() ?>


<?php $view['slots']->start('top-actions');?>
    <div  class="record-top show-grid ">

        <div class="col-md-4">
            





        </div>
        <div class="col-md-5">
            
            
            
        </div>

        <div class="col-md-3 left user-box" ng-class="{'logged-in': (SecurityService.loggedIn && SecurityService.connected), 'logged-out': (!SecurityService.loggedIn || !SecurityService.connected)}" style="float: left"  >
            <ul class="nav navbar-nav navbar-left user-pane">



                <li class="dropdown open">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <i class="fa fa-power-off"></i>
                    <span class="username-value">
                    {{ValuesService.username}}
                    </span> <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-left" role="menu">
                        <li ng-show="SecurityService.loggedIn && SecurityService.connected">
                            <a  data-ng-click="logout()">
                                خروج
                            </a>
                        </li>
                        <li ng-hide="SecurityService.loggedIn  || !SecurityService.connected">
                            <a data-ng-click="openLoginModal()">
                                ورود مجدد
                            </a>
                            <script type="text/ng-template" id="loginModal.html">
                                <div class="modal-header">
                                    <h3 class="modal-title">ورود مجدد</h3>
                                </div>
                                <div class="modal-body">
                                    <label class="username" for="login-username" >نام کاربری</label>
                                    <input id="login-username" type="text" ng-model="username">
                                    <label class="password" for="login-password" >رمز عبور</label>
                                    <input id="login-password" type="text" ng-model="password">
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" ng-click="login()">ورود</button>
                                    <button class="btn btn-warning" ng-click="close()">بستن</button>
                                </div>
                            </script>
                        </li>

                    </ul>
                </li>
            </ul>

        </div>
    </div>
<?php $view['slots']->stop() ?>




<?php $view['slots']->start('body') ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div ui-view></div>
            </div>
        </div>
    </div>
    
    
    
    
    
<?php $view['slots']->stop() ?>
    