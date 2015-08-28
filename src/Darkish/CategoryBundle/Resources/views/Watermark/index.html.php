<!DOCTYPE html>
<html ng-app="watermarkApp">
<head>

    <title>Messages</title>

    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcategory/stylesheets/screen.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcategory/stylesheets/print.css') ?>" media="print" rel="stylesheet" type="text/css" />
    <!--[if IE]>
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcategory/stylesheets/ie.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
    <![endif]-->

    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/bootstrap-rtl/dist/css/bootstrap-rtl.min.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcategory/stylesheets/watermark/style.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/font-awesome/css/font-awesome.min.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/sweetalert/lib/sweet-alert.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/emotions.css') ?>" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
</head>
<body ng-controller="watermarkIndexCtrl">


<nav class="navbar">
    <div class="container-fluid">
        <div id="navbar" class="navbar-collapse collapse">

        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-3 sidebar">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<!--                    <button ng-disabled="connecting" ng-click="searchCriteria={};searchCriteria.new = 1;searchCriteria.page=1;search()" type="button" class="btn btn-success btn-block">-->
<!--                        -->
<!--                    </button>-->
                    <button data-ng-class="{'btn-default': !searchCriteria.new, 'btn-success': searchCriteria.new}" type="button" class="btn btn-block" ng-model="searchCriteria.new" btn-checkbox btn-checkbox-true="1" btn-checkbox-false="0">
                        رکوردهای بررسی نشده
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-12">
                        <input ng-disabled="connecting" type="text" class="form-control" id="number" ng-model="searchCriteria.number"
                               placeholder="شماره رکورد">
                    </div>
                    <div class="col-xs-12">
                        <input ng-disabled="connecting" type="text" class="form-control" id="number" ng-model="searchCriteria.title"
                               placeholder="عنوان رکورد">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <button ng-disabled="connecting" ng-click="searchCriteria.page=1;search()" type="button" class="btn btn-primary btn-block">
                            جستجو
                        </button>
                    </div>
                </div>
            </div>


            <div class="input-group">


                <div class="input-group-btn">
                    <button ng-disabled="connecting" data-ng-click="searchCriteria.page = currentPage - 1; search()" type="button" ng-disabled="currentPage <= 1"  class="btn btn-default" >
                        قبلی
                    </button>
                </div>
                <input ng-disabled="true" style="text-align: center" type="text" class="form-control" aria-label="..." ng-value="currentPage+' از '+totalPages">
                <div class="input-group-btn">
                    <button ng-disabled="connecting" data-ng-click="searchCriteria.page = currentPage + 1; search()" ng-disabled="currentPage >= totalPages" type="button" class="btn btn-default">
                        بعدی
                    </button>
                </div>
            </div>

            <div class="list-group">
                <a ng-disabled="connecting" data-ng-class="{'active': record.id == currentRecord.id}" data-ng-repeat="record in records" data-ng-click="getRecord(record)" ng-style="{'cursor': (connecting)?'auto':'pointer'}" class="list-group-item" ng-bind="record.title">First item</a>
            </div>


        </div>
        <div class="col-xs-9  main">


<!--            <div class="page-header" data-ng-show="currentRecord.icon">-->
<!--                <h2>-->
<!--                    آیکن-->
<!--                </h2>-->
<!--            </div>-->
<!--            <div class="row" data-ng-show="currentRecord.icon">-->
<!--                <div class="col-xs-3">-->
<!--                    <div class="thumbnail">-->
<!--                        <img alt="" ng-src="{{currentRecord.icon.mobile_absolute_path}}" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;">-->
<!--                        <div class="caption">-->
<!--                            <h3>Thumbnail label</h3>-->
<!--                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>-->
<!--                            <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            <div class="btn-group">
                <button type="button" ng-disabled="connecting || !isCheckedAllFiles()" class="btn btn-default btn-lg" data-ng-click="updateImages()">
                    ذخیره
                </button>

            </div>

            <div class="page-header" data-ng-show="currentRecord.images">
                <h2>
تصاویر ضمیمه
                </h2>
            </div>
            <div class="row" data-ng-show="currentRecord.images">
                <div data-ng-repeat="image in currentRecord.images" class="col-xs-3">
                    <div class="thumbnail" ng-style="{'background-color': (!image.checked)?'rgb(255, 224, 224)':'transparent'}">
                        <input type="checkbox" ng-disabled="connecting || image.checked" ng-model="image.checked" required>
                        <img alt="" ng-src="{{'./../../media/cache/256/uploads/image/'+image.file_name}}" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;">
                        <div class="caption">
                            <div class="checkbox">
                            	<label>
                            		<input ng-disabled="connecting" ng-change="image.checked=true"  ng-model="image.darkish_watermark" type="checkbox" value="" id="">
                            	    درکیش
                            	</label>
                                <label>
                                    <input ng-disabled="connecting" ng-change="image.checked=true" ng-model="image.island_watermark" type="checkbox" value="" id="">
جزیره
                                </label>
                                <label>
                                    <input ng-disabled="connecting" ng-change="image.checked=true" ng-model="image.aruna_watermark" type="checkbox" value="" id="">
                                    آرونا
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="page-header" data-ng-show="currentRecord.body_images">
                <h2>
تصاویر HTML
                </h2>
            </div>
            <div class="row" data-ng-show="currentRecord.body_images">
                <div data-ng-repeat="image in currentRecord.body_images" class="col-xs-3" >
                    <div class="thumbnail" ng-style="{'background-color': (!image.checked)?'rgb(255, 224, 224)':'transparent'}">
                        <input ng-disabled="connecting || image.checked" type="checkbox" ng-model="image.checked" required>
                        <img alt="" ng-src="{{'./../../media/cache/256/uploads/image/'+image.file_name}}" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;">
                        <div class="caption">
                            <label>
                                <input ng-disabled="connecting" ng-change="image.checked=true" ng-model="image.darkish_watermark" type="checkbox" value="" id="">
                                درکیش
                            </label>
                            <label>
                                <input ng-disabled="connecting" ng-change="image.checked=true" ng-model="image.island_watermark" type="checkbox" value="" id="">
                                جزیره
                            </label>
                            <label>
                                <input ng-disabled="connecting" ng-change="image.checked=true" ng-model="image.aruna_watermark" type="checkbox" value="" id="">
                                آرونا
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="<?php echo $view['assets']->getUrl('bundles/fosjsrouting/js/router.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/jquery/dist/jquery.min.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular/angular.min.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-sanitize/angular-sanitize.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-sweetalert/SweetAlert.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/sweetalert/lib/sweet-alert.min.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('bundles/darkishcomment/bower_components/moment/moment.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/moment-jalaali/build/moment-jalaali.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('bundles/darkishcomment/bower_components/moment/locale/fa.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('bundles/darkishcomment/bower_components/angular-moment/angular-moment.js') ?>"></script>
<script src="<?php echo $view['assets']->getUrl('bundles/darkishcategory/js/watermarkCtrl.js') ?>"></script>
</body>
</html>
