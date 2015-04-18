<div class="row page messages-page">
	<div class="col col-xs-12 col-sm-5 col-md-4 col-lg-3 threads master"
		 ng-hide="isXSmall() && (selectedThread.id || groupMessageForm)">
		<div class="well master-buttons" ng-class="{'fixed': isXSmall()}">
			<button ng-click="showGroupMessageForm()" 
					class="btn btn-danger group-message-button">ارسال پیام گروهی</button>
		</div>
		<div class="well inner master-inner" ng-class="{'scrollable': !isXSmall()}">
			<ul ng-show="threads.length">
				<li ng-repeat="thread in threads | orderBy: '-last_record_delivered'" class="thread" ng-click="selectThread(thread)"
					ng-class="{'selected': selectedThread.id == thread.id}">
					<div class="private" ng-show="thread.thread_type == 'private'">
						<img ng-src="{{thread.client.photo ? thread.client.photo.icon_absolute_path : '<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_profile.jpg') ?>'}}" name="aboutme" width="48" height="48" class="img-circle">
						<div class="middle">
							<span class="username" ng-bind="thread.client.full_name ? thread.client.full_name : thread.client.username">
							</span>
							<span class="last-message" ng-show="thread.last_message" ng-bind-html="thread.last_message.text | limitTo:30">
							</span>
						</div>
						<span class="datetime">
							{{thread.last_message.created | toDate | amDateFormat:'jYYYY/jM/jD, h:mm'}}
						</span>
						<span ng-show="thread.last_message.id > thread.last_record_seen" class="hasnew">
							جدید
						</span>
						<button class="delete-button btn-danger btn-xs" ng-click="delete(thread);$event.stopPropagation();">
							<!-- <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> -->
							حذف
						</button>
					</div>

					<div class="group" ng-show="thread.thread_type == 'group'">
						<img ng-src="{{thread.client.photo ? thread.client.photo.icon_absolute_path : '<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/group-message.png') ?>'}}" name="aboutme" width="48" height="48" class="img-circle">
						<div class="middle">
							<span class="group-label">
								پیام گروهی
							</span>
							<span class="last-message" ng-show="thread.last_message" ng-bind-html="thread.last_message.text | limitTo:30">
							</span>
						</div>
						<span class="datetime">
							{{thread.last_message.created | toDate | amDateFormat:'jYYYY/jM/jD, h:mm'}}
						</span>
						<span ng-show="thread.last_message.id > thread.last_record_seen" class="hasnew">
							جدید
						</span>
					</div>
				</li>
			</ul>
			<div ng-hide="threads.length" class="">
				پیامی موجود نیست.
			</div>
		</div>
		
	</div>
	<div class="col col-xs-12 col-sm-7 col-md-8 col-lg-9 messages details">
		<div class="details-header" id="details-header" 
			ng-show="(selectedThread.id || groupMessageForm)"
			ng-class="{'fixed': isXSmall()}"
			>
			<button class="return-button" ng-click="groupMessageForm = false ; selectedThread = {}">
				<div class="icon icon-arrow-right"></div>
			</button>
			<span class="details-header-title"> {{(selectedThread.thread_type == 'group') ? 'پیام گروهی' : (selectedThread.client.full_name ? selectedThread.client.full_name : selectedThread.client.username )}}</span>
			<button class="details-header-button btn btn-sm btn-primary">
				دکمه بالا
			</button>
		</div>
		<div ng-class="{'has-details-bottom': isXSmall() && selectedThread.id, 'scrollable': !isXSmall()}" ng-show="selectedThread.id" class="messages-inner details-inner" id="message-container" scroll-glue>
			<button ng-show="selectedThread.thread_type == 'private'" class="btn btn-info btn-xs load-more" ng-show="selectedThread.id" ng-disabled="hasNotMore" ng-click="loadMore()">بیشتر</button>
			<ul class="message-list">
				<li class="message" ng-repeat="message in currentMessages | orderBy:'id'"
					ng-class="
					{
						'pull-right': message.from == 'record',
						'record': message.from == 'record',
					 	'pull-left': message.from == 'client',
					 	'client': message.from == 'client'
					}
					 ">
					<img ng-show="message.from == 'client'" ng-src="{{thread.client.photo ? thread.client.photo.icon_absolute_path : '<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_profile.jpg') ?>'}}" name="aboutme" width="48" height="48" class="img-circle">
					<img ng-show="message.from == 'record'" ng-src="{{user.photo.icon_absolute_path ? user.photo.icon_absolute_path : '<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_profile.jpg') ?>'}}" name="aboutme" width="48" height="48" class="img-circle">
					<span class="text" ng-bind-html="getTrustedMessage(message.text)">
					</span>
					<span class="time">
					{{message.created | toDate | amDateFormat:'jYYYY/jM/jD, h:mm'}}
					</span>
					<span class="delivered" 
						  ng-show="message.from == 'record' && selectedThread.last_client_delivered == message.id && selectedThread.last_client_seen != message.id">
						دریافت شده
					</span>
					<span class="seen"
						  ng-show="message.from == 'record' && selectedThread.last_client_seen == message.id">
						دیده شده
					</span>
					

				</li>
			</ul>
		</div>
		<div ng-show="selectedThread.id && selectedThread.thread_type == 'private'" class="message-submit details-bottom" ng-class="{'fixed' : isXSmall()}"
			ng-resize="resizeForm($event)">
			<form>
				<div class="message-text col col-xs-10 col-sm-10 col-md-11">
					<!-- <input class="form-control" ng-model="messageForm"/> -->
					<textarea class="msd-elastic form-control" ng-model="messageForm">
					</textarea>
				</div>
				<div class="submit-button col col-xs-2 col-sm-2 col-md-1">
					<button ng-click="postMessage()" ng-disabled="!messageForm"> 
						<span class="glyphicon glyphicon-send gly-flip-horizontal disable"  
							  aria-hidden="true" ng-class="{'disable': !messageForm}"
						  	></span>
					  	<span class="text hidden-xs" ng-class="{'disable': !messageForm}">ارسال</span>
					</button>
				</div>
			</form>

			
		</div>
		<div ng-show="groupMessageForm" class="group-message-form-wrapper details-inner well">
			<h3>
				ارسال پیام گروهی
			</h3>
			<form>
				<textarea class="form-control" ng-model="groupText"></textarea>
				<button class="btn btn-success btn-sm" ng-disabled="!groupText" ng-click="submitGroupMessage()">ارسال</button>
			</form>
			
		</div>
		
	</div>
</div>

