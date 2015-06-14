<!DOCTYPE html>
<html ng-app="messageboxApp">
    <head>
        
        <title>Messages</title>
        
        <link href="<?php echo $view['assets']->getUrl('bundles/darkishcategory/stylesheets/screen.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
      	<link href="<?php echo $view['assets']->getUrl('bundles/darkishcategory/stylesheets/print.css') ?>" media="print" rel="stylesheet" type="text/css" />
      	<!--[if IE]>
          	<link href="<?php echo $view['assets']->getUrl('bundles/darkishcategory/stylesheets/ie.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
      	<![endif]-->

        <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/bootstrap-rtl/dist/css/bootstrap-rtl.min.css') ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo $view['assets']->getUrl('bundles/darkishcategory/stylesheets/messagebox/style.css') ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/font-awesome/css/font-awesome.min.css') ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/sweetalert/lib/sweet-alert.css') ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/stylesheets/emotions.css') ?>" rel="stylesheet">

        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    </head>
    <body ng-controller="messageBoxIndexCtrl">
        


        
    	<div class="messages-wrapper">
    		<div class="messages">
    			<ul>
    				<li class="load-older">
    					<a ng-click="loadOlder()">بیشتر</a>
    				</li>
    				<li class="message" ng-repeat="message in messages | orderBy: 'id'"
						>
					 	<div ng-click="openReplyModal(message, false)" class="message-details"
					 		ng-class="
					 		{
					 			'pull-right': message.from == 'record',
					 			'record': message.from == 'record',
					 		 	'pull-left': message.from == 'client',
					 		 	'client': message.from == 'client'
					 		}
					 		 ">
				 		 	
			 		 		<img ng-show="message.from == 'client'" ng-src="{{message.thread.client.photo ? message.thread.client.photo.icon_absolute_path : '<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_profile.jpg') ?>'}}" name="aboutme" width="48" height="48" class="img-circle client-photo">
				 		 	
					 		<img ng-show="message.from == 'record'" ng-src="{{message.thread.customer.photo ? message.thread.customer.photo.icon_absolute_path : '<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_profile.jpg') ?>'}}" name="aboutme" width="48" height="48" class="img-circle customer-photo">
					 		
					 		<span class="text" ng-bind-html="getTrustedMessage(message.text)">
					 		</span>
					 		<span class="time">
					 		{{message.created | toDate | amDateFormat:'jYYYY/jM/jD, h:mm'}}
					 		</span>
					 		<span ng-show="message.from == 'client'" class="client-name" ng-bind="message.thread.client.full_name"></span>
					 		
					 	</div>
						<div ng-click="openReplyModal(message, true)" ng-show="message.from == 'record'" class="client-details">
							<img ng-src="{{message.thread.client.photo ? message.thread.client.photo.icon_absolute_path : '<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_profile.jpg') ?>'}}" name="aboutme" width="48" height="48" class="img-circle client-photo">
							<span class="client-name" ng-bind="message.thread.client.full_name"></span>
						</div>
						

					</li>
    			</ul>
    		</div>
    		
    	</div>


        


    	<script type="text/ng-template" id="replyModal.html">
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
        <script src="<?php echo $view['assets']->getUrl('bundles/fosjsrouting/js/router.js') ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/jquery/dist/jquery.min.js') ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular/angular.min.js') ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/angular-sanitize/angular-sanitize.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js') ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/angular-sweetalert/SweetAlert.js') ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('bundles/darkishuser/bower_components/sweetalert/lib/sweet-alert.min.js') ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('bundles/darkishcomment/bower_components/moment/moment.js') ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/bower_components/moment-jalaali/build/moment-jalaali.js') ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('bundles/darkishcomment/bower_components/moment/locale/fa.js') ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('bundles/darkishcomment/bower_components/angular-moment/angular-moment.js') ?>"></script>
        <script src="<?php echo $view['assets']->getUrl('bundles/darkishcategory/js/messageboxCtrl.js') ?>"></script>
    </body>
</html>
