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
        <?php $view['slots']->output('stylesheets') ?>
    <?php endif; ?>









</head>
<body ng-app="<?php $view['slots']->output('ngapp') ?>" ng-controller="<?php $view['slots']->output('controller') ?>"  >
    <div ng-cloak ng-init="loaded=false" ng-show="loaded" ng-class="{'loaded': loaded, 'notloaded': !loaded }" class="notloaded" >
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-6">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">درکیش</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-6">
                <?php if($view['slots']->has('top-menu')): ?>
                    <?php $view['slots']->output('top-menu') ?>
                <?php endif; ?>

                <?php if($view['slots']->has('top-actions')): ?>
                    <?php $view['slots']->output('top-actions') ?>
                <?php endif; ?>
            </div>
        </div>
    </nav>


    <?php if($view['slots']->has('body')): ?>
        <?php $view['slots']->output('body') ?>
    <?php endif; ?>

    <?php if($view['slots']->has('javascripts')): ?>
        
        
        <?php $view['slots']->output('javascripts') ?>

        
    <?php endif; ?>

</div>
<div id="loading" ng-hide="loaded" ng-cloak ng-class="{'loaded': loaded }">
<i class="fa fa-circle-o-notch fa-spin"></i>
</div>
</body>
</html>