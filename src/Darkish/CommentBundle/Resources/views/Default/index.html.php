<?php $view->extend('::panel_layout_second.html.php') ?>

<?php $view['slots']->start('stylesheets') ?>
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/bootstrap-rtl/dist/css/bootstrap-rtl.min.css') ?>" type="text/css" rel="stylesheet" />
    <!-- <link href="<?php echo $view['assets']->getUrl('bundles/darkishcomment/stylesheets/screen.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
  	<link href="<?php echo $view['assets']->getUrl('bundles/darkishcomment/stylesheets/print.css') ?>" media="print" rel="stylesheet" type="text/css" /> -->
	<!--[if IE]>
	    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcomment/stylesheets/ie.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
	<![endif]-->

    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcomment/stylesheets/comment/comment.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/font-awesome/css/font-awesome.min.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/sweetalert/lib/sweet-alert.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-ui-switch/angular-ui-switch.min.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcomment/bower_components/angular-tree-control/css/tree-control.css') ?>" rel="stylesheet" type="text/css" >
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcomment/bower_components/angular-tree-control/css/tree-control-attribute.css') ?>" rel="stylesheet" type="text/css" >
    
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angucomplete-alt/angucomplete-alt.css') ?>" type="text/css" rel="stylesheet" />
    
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('javascripts') ?>

    <script src="<?php echo $view['assets']->getUrl('bundles/fosjsrouting/js/router.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular/angular.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-ui-router/release/angular-ui-router.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-sweetalert/SweetAlert.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/sweetalert/lib/sweet-alert.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcomment/bower_components/moment/moment.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcomment/bower_components/moment/locale/fa.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcomment/bower_components/angular-moment/angular-moment.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angucomplete-alt/dist/angucomplete-alt.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcomment/bower_components/angular-tree-control/angular-tree-control.js') ?>" type="text/javascript" ></script>

    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcomment/js/comment/comment-index-app.js') ?>"></script>

    
    
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('pagetitle') ?>مدیریت اپراتور ها<?php $view['slots']->stop() ?>

<?php $view['slots']->start('ngapp') ?>commentApp<?php $view['slots']->stop() ?>

<?php $view['slots']->start('controller') ?>commentIndexCtrl<?php $view['slots']->stop() ?>

<?php $view['slots']->start('top-menu');?>
    <ul class="nav navbar-nav">
        <li class="dropdown">
            <a class="dropdown-toggle" >مدیریت نظرات<span class="caret"></span></a>
            <?php print $view['knp_menu']->render('main') ?>
        </li>
    </ul>
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('body') ?>
    <div class="container">
        <div class="row">
        	<div class="sidebar-wrapper col-lg-3 col-md-3 col-sm-3 col-xs-3">
        		
    			<div class="row">
    				<div class="col col-lg-5 col-md-5 col-sm-5 col-xs-5">
    					<div class="dropdown">
    					  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" aria-expanded="true">
    					    نظرات مربوط به
    					    <span class="caret"></span>
    					  </button>
    					  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
    					    <li role="presentation"><a role="menuitem" tabindex="-1" ui-sref="default({type: 'forum'})">تالار گفتگو</a></li>
    					    <li role="presentation"><a role="menuitem" tabindex="-1" ui-sref="default({type: 'record'})">رکورد</a></li>
    					    <li role="presentation"><a role="menuitem" tabindex="-1" ui-sref="default({type: 'news'})">اخبار</a></li>
    					    <li role="presentation"><a role="menuitem" tabindex="-1" ui-sref="default({type: 'safarsaz'})">سفر ساز</a></li>
    					  </ul>
    					</div>
    				</div>
    				<div class="col col-lg-7 col-md-7 col-sm-7 col-xs-7">
    					<div ui-view="current-state"></div>
    				</div>
    			</div>
        		<hr/>
                <div class="list-group search-filter-box">
                  <a ng-click="searchByFilter('all')" class="list-group-item" ng-class="{'active': SearchService.searchCriteria.filter == 'all'}">همه نظرات</a>
                  <a ng-click="searchByFilter('claimed')" class="list-group-item" ng-class="{'active': SearchService.searchCriteria.filter == 'claimed'}" >شکایت شده ها</a>
                </div>
        		<div ui-view="sidebar"></div>
                <div class="search-box">
                    <label>
                        متن
                        <input type="radio" name="keywordType"
                               value="text" ng-model="SearchService.searchCriteria.keywordType" />
                    </label>
                    <label>
                        شماره {{currentState()}}
                        <input type="radio" name="keywordType"
                               value="number" ng-model="SearchService.searchCriteria.keywordType" />
                    </label>
                    <button ng-disabled="!SearchService.searchCriteria.keywordType || !SearchService.searchCriteria.keyword" ng-click="searchByKeyword(SearchService.searchCriteria.keywordType, SearchService.searchCriteria.keyword)" class="btn btn-info btn-sm">بیاب</button>
                    <input type="text" class="form-control" ng-model="SearchService.searchCriteria.keyword" placeholder="کلید واژه/شماره" />
                </div>
        	</div>
            <div class="content-wrapper col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <h2 ng-show="globalValues.currentEntity.id && isCommentable(globalValues.currentEntity)">{{globalValues.currentEntity.title}}<button ng-click="globalValues.currentEntity.form = (globalValues.currentEntity.form)? false : true" type="button" class="btn btn-success btn-xs post-comment-button">ارسال نظر</button></h2>
                <div collapse="!globalValues.currentEntity.form">
                    <div class="well well-lg">
                        <label for="comment-body">متن پاسخ</label>
                            <textarea id="comment-body" class="form-control" ng-model="commentBody" rows="3"></textarea>
                          
                            <button type="submit" ng-click="postComment(commentBody);commentBody=''" class="btn btn-default">ارسال</button>
                    </div>
                </div>
                <hr ng-show="globalValues.currentEntity.id"/>
                <div ui-view="content" class="content"></div>
                <div class="row">
                    <div class="col-xs-3">
                        test
                    </div>
                    <div class="col-xs-6">
                        <i class="fa fa-thumbs-up fa-flip-horizontal" style="font-size:30px;"></i>
                    </div>
                    <div class="col-xs-">
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    
<?php $view['slots']->stop() ?>