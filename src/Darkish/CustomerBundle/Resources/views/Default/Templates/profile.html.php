
<div ng-show="!user" class="loading">
	loading
</div>
<div class="row">
	<div class="col-xs-12">
		<div ng-show="user" class="span3 well profile-page">
		    <center>
		    	<h3 class="record-title">{{record.title}}
                        </h3>
			    <div class="icons">
			    	<span class="icon favoritcount"><div class="dk icon-heart"></div> <span class="count"><?php echo "".$app->getUser()->getRecord()->getFormattedFavoriteCount(); ?></span></span>
	                <span class="icon likecount"><div class="dk icon-like"></div> <span class="count"><?php echo "".$app->getUser()->getRecord()->getFormattedLikeCount(); ?></span></span>
	                <span class="icon visitcount"><div class="dk icon-eye"></div> <span class="count"><?php echo "".$app->getUser()->getRecord()->getFormattedVisitCount(); ?></span></span>
			    </div>
			    <a href="#aboutModal" data-toggle="modal" data-target="#myModal"><img ng-src="{{user.photo.icon_absolute_path ? user.photo.icon_absolute_path : '<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_profile.jpg') ?>'}}" name="aboutme" width="140" height="140" class="img-circle"></a>
			    <h3 ng-bind="user.full_name"></h4>
			    <h4 ng-bind="user.username"></h4>
	    	    <div class="last-update">
					آخرین بروزرسانی:
					<span class="">{{record.last_update | amDateFormat:'jYYYY/jMM/jDD hh:mm' }}</span>
					<br/>
					تاریخ اعتبار:
					<span ng-style="{color: (isNearToExpire()) ? 'red': 'green'}" class="">{{record.expire_date | amDateFormat:'jYYYY/jMM/jDD' }}</span>
	        	</div>
	        	<div class="record-number">
	        		شماره پرونده: <span class=""><?php echo $app->getUser()->getRecord()->getRecordNumber() ?></span>
	        	</div>
			    <!-- <div class="access">
				    <span><strong>دسترسی ها: </strong></span>
				    <span ng-repeat="access in user.assistant_access" style="margin-left: 3px; margin-right: 3px;" class="label label-warning" ng-bind="access.name"></span>
			    </div> -->
			    
			</center>
		</div>			
	</div>

</div>
