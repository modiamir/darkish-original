<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>
        درکیش  |
        <?php $view['slots']->output('pagetitle') ?>
    </title>

    <?php if($view['slots']->has('stylesheets')): ?>
        <link href="<?php echo $view['assets']->getUrl('assets/css/bootstrap-arabic.css') ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo $view['assets']->getUrl('assets/css/styles.css') ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo $view['assets']->getUrl('assets/css/font-awesome.min.css') ?>" type="text/css" rel="stylesheet" />

        <?php $view['slots']->output('stylesheets') ?>
    <?php else: ?>
        <link href="{{ asset('assets/css/bootstrap-arabic.css') }}" type="text/css" rel="stylesheet" />
    <?php endif; ?>









</head>
<body ng-app="<?php $view['slots']->output('ngapp') ?>" ng-controller="<?php $view['slots']->output('controller') ?>"  >
<form ng-cloak ng-class="{'loaded': loaded, 'notloaded': !loaded }" class="notloaded" name="<?php $view['slots']->output('formname') ?>" novalidate>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid top-container">
            <div class="row">
                <div class="col col-xs-2 top-menu-col">
                    <div class="container-fluid top-menu-container">
                        <div class="row">
                            <div class="col col-xs-4">
                                <div class="navbar-header">
                                    <a class="navbar-brand" href="#">درکیش</a>
                                </div>
                            </div>
                            <div class="col  col-xs-8">
                                <?php if ($view['slots']->has('top-menu')): ?>
                                    <?php $view['slots']->output('top-menu') ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-xs-10">
                    <div class="collapse container navbar-collapse" id="bs-example-navbar-collapse-6">
                        <div class="row">
                            <div class="col-xs-12">
                                <?php if ($view['slots']->has('top-actions')): ?>
                                    <?php $view['slots']->output('top-actions') ?>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </nav>


    <?php if($view['slots']->has('body')): ?>
        <?php $view['slots']->output('body') ?>
    <?php endif; ?>

    <?php if($view['slots']->has('javascripts')): ?>
        <script src="<?php echo $view['assets']->getUrl('bundles/fosjsrouting/js/router.js') ?>"></script>
        
        <script src="<?php echo $view['assets']->getUrl('assets/js/jquery.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo $view['assets']->getUrl('assets/js/bootstrap-arabic.js') ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('assets/js/angular/angular.js'); ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('assets/js/angular/angular-touch.js'); ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('assets/js/angular/angular-animate.js'); ?>"></script>
        
        <?php $view['slots']->output('javascripts') ?>
    <?php else: ?>
        <script src="<?php echo $view['assets']->getUrl('bundles/fosjsrouting/js/router.js') ?>"></script>
        
        <script src="<?php echo $view['assets']->getUrl('assets/js/jquery.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo $view['assets']->getUrl('assets/js/bootstrap-arabic.js') ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('assets/js/angular/angular.js'); ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('assets/js/angular/angular-touch.js'); ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('assets/js/angular/angular-animate.js'); ?>"></script>
        
    <?php endif; ?>

</form>
<div id="loading" ng-cloak ng-class="{'loaded': loaded }"">
<i class="fa fa-circle-o-notch fa-spin"></i>
</div>
</body>
</html>