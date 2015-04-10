
<div ng-show="!user" class="loading">
	loading
</div>
<div class="row">
	<div class="col-xs-12">
		<div ng-show="user" class="span3 well profile-page">
		    <center>

			    <div class="last-update">
			    	آخرین بروزرسانی: <span class=""><?php $lastUpdate = $app->getUser()->getRecord()->getLastUpdate(); echo $lastUpdate->format('Y-m-d H:i:s'); ?></span>
		    	</div>
		    	<div class="record-number">
		    		شماره رکورد: <span class="">R<?php echo $app->getUser()->getRecord()->getRecordNumber() ?></span>
		    	</div>
			    <a href="#aboutModal" data-toggle="modal" data-target="#myModal"><img ng-src="{{user.photo.icon_absolute_path ? user.photo.icon_absolute_path : '<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_profile.jpg') ?>'}}" name="aboutme" width="140" height="140" class="img-circle"></a>
			    <h3 ng-bind="user.full_name"></h4>
			    <h4 ng-bind="user.username"></h4>
			    <div class="access">
				    <span><strong>دسترسی ها: </strong></span>
				    <span ng-repeat="access in user.assistant_access" style="margin-left: 3px; margin-right: 3px;" class="label label-warning" ng-bind="access.name"></span>
			    </div>
			    
			</center>
		</div>			
	</div>

</div>
