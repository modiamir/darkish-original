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
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ngDialog/css/ngDialog.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ngDialog/css/ngDialog-theme-default.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishwebsite/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $view['assets']->getUrl('bundles/darkishcategory/bower_components/angular-hotkeys/build/hotkeys.min.css') ?>" rel="stylesheet" type="text/css" />
    
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
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-file-upload/angular-file-upload.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/ngDialog/js/ngDialog.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishwebsite/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishwebsite/bower_components/angular-bootstrap-switch/dist/angular-bootstrap-switch.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('bundles/darkishcategory/bower_components/angular-hotkeys/build/hotkeys.min.js') ?>"></script>

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
                <h2 ng-show="globalValues.currentEntity.id && isCommentable(globalValues.currentEntity)">{{globalValues.currentEntity.title}}<button ng-click="newComment = {}; globalValues.currentEntity.form = (globalValues.currentEntity.form)? false : true" type="button" class="btn btn-success btn-xs post-comment-button">ارسال نظر</button></h2>
                <div collapse="!globalValues.currentEntity.form">
                    <div class="well well-lg">
                        
                        <div class="submit-comment-form" >
                            <textarea class="form-control" ng-model="newComment.body"></textarea>
                            <div style="float: left; margin-top: 10px; margin-bottom: 10px;" class="btn-group btn-group-sm submit-btn-group">
                                <button class="btn btn-danger " ng-click="newComment = {}; globalValues.currentEntity.form = false" >انصراف</button>
                                <button ng-disabled="!newComment.body" ng-click="postComment(newComment);" class="btn btn-success">ارسال</button>
                            </div>
                            <label style="float: right; margin-top: 10px;" ng-disabled="newComment.photos.length >= 3" class="btn btn-info btn-sm upload-label">
                                انتخاب فایل
                                <input type="file" ng-show="false" nv-file-select="" uploader="uploader" multiple  /><br/>
                            </label>
                            <div class="progress" style="clear: both">
                                <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                            </div>
                            <div class="row" ng-show="newComment.photos">
                                <div class="col col-xs-12 col-sm-6 col-md-3" ng-repeat="photo in newComment.photos">
                                    <div class="image-thumb">
                                        <img ng-src="{{photo.icon_absolute_path}}" />
                                        <button class="thumbnail-remove btn btn-danger btn-xs" ng-click="removePhoto($index)">حذف</button>
                                    </div>
                                </div>
                            </div>
                        </div>        
                    </div>
                    
                </div>
                <hr ng-show="globalValues.currentEntity.id"/>
                <div ui-view="content" class="content"></div>
                
            </div>
        </div>
    </div>
    
    <script type="text/ng-template" id="photo-modal.html">
        <div class="photo-modal">
          <img style="max-width: 100%;" class="photo-in-modal" ng-src="{{photos[index].web_absolute_path}}" />
          <button class="btn btn-default previous-btn" ng-disabled="index <= 0" ng-click="index = index-1">
            بعدی
          </button>
          <button class="btn btn-default next-btn" ng-disabled="index >= (photos.length -1)" ng-click="index = index+1">
            قبلی
          </button>
        </div>
    </script>
    
    <script type="text/ng-template" id="sendMessageModal.html">
        <div class="modal-header">
            <h3 class="modal-title">پاسخ</h3>
        </div>
        <div class="modal-body">
            <textarea ng-model="body" class="form-control" row=4></textarea>
        </div>
        <div class="modal-footer">
            <button ng-disabled="" class="btn btn-warning" ng-click="dismiss()">انصراف</button>
            <button class="btn btn-info pull-left" data-ng-click="reply(body)">ارسال</button>
        </div>
    </script>
    
<?php $view['slots']->stop() ?>