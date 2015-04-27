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
							<span class="last-message" ng-show="thread.last_message" ng-bind-html="getTrustedMessage(thread.last_message.text) | limitTo:30">
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
							<span class="last-message" ng-show="thread.last_message" ng-bind-html="getTrustedMessage(thread.last_message.text) | limitTo:30">
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
			<button class="return-button" ng-click="groupMessageForm = false ; selectedThread = {};">
				<div class="dk icon-arrow-right"></div>
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
				<div class="message-text col col-xs-8 col-sm-8 col-md-10">
					<!-- <input class="form-control" ng-model="messageForm"/> -->
					<textarea id="message-text-area" class="msd-elastic form-control" ng-model="messageForm">
					</textarea>
					<!-- <span id="message-text-span" style="height: 50px; width:100%; background-color: rgb(226, 226, 226); display: inline-block;" contenteditable="true"
					        ng-model="messageForm"
					    	strip-br="true"
					 		select-non-editable="true">
					 </span> -->
				</div>
				<div class="col col-xs-2 col-sm-2 col-md-1 emotions-list">
					<div class="btn-group dropup  ">
					  <button type="button" class="btn btn-default dropdown-toggle emotion-add-icon" data-toggle="dropdown" aria-expanded="false">
					  </button>
					  <ul class="dropdown-menu" role="menu">
			                    <li><button ng-click="insertEmotion('angry'); $event.stopPropagation();" class="raw-btn dk-emot emot-angry"></button></li>
			                    <li><button ng-click="insertEmotion('confused'); $event.stopPropagation();" class="raw-btn dk-emot emot-confused"></button></li>
			                    <li><button ng-click="insertEmotion('cool'); $event.stopPropagation();" class="raw-btn dk-emot emot-cool"></button></li>
			                    <li><button ng-click="insertEmotion('crazy'); $event.stopPropagation();" class="raw-btn dk-emot emot-crazy"></button></li>
			                    <li><button ng-click="insertEmotion('depressed'); $event.stopPropagation();" class="raw-btn dk-emot emot-depressed"></button></li>
			                    <li><button ng-click="insertEmotion('wink'); $event.stopPropagation();" class="raw-btn dk-emot emot-wink"></button></li>
			                    <li><button ng-click="insertEmotion('teeth'); $event.stopPropagation();" class="raw-btn dk-emot emot-teeth"></button></li>
			                    <li><button ng-click="insertEmotion('shy'); $event.stopPropagation();" class="raw-btn dk-emot emot-shy"></button></li>
			                    <li><button ng-click="insertEmotion('sleeping'); $event.stopPropagation();" class="raw-btn dk-emot emot-sleeping"></button></li>
			                    <li><button ng-click="insertEmotion('money'); $event.stopPropagation();" class="raw-btn dk-emot emot-money"></button></li>
			                    <li><button ng-click="insertEmotion('nerd'); $event.stopPropagation();" class="raw-btn dk-emot emot-nerd"></button></li>
			                    <li><button ng-click="insertEmotion('not_sure'); $event.stopPropagation();" class="raw-btn dk-emot emot-not_sure"></button></li>
			                    <li><button ng-click="insertEmotion('mad'); $event.stopPropagation();" class="raw-btn dk-emot emot-mad"></button></li>
			                    <li><button ng-click="insertEmotion('laugh'); $event.stopPropagation();" class="raw-btn dk-emot emot-laugh"></button></li>
			                    <li><button ng-click="insertEmotion('surprised'); $event.stopPropagation();" class="raw-btn dk-emot emot-surprised"></button></li>
			                    <li><button ng-click="insertEmotion('sad'); $event.stopPropagation();" class="raw-btn dk-emot emot-sad"></button></li>
			                    <li><button ng-click="insertEmotion('tongue'); $event.stopPropagation();" class="raw-btn dk-emot emot-tongue"></button></li>
			                    <li><button ng-click="insertEmotion('happy'); $event.stopPropagation();" class="raw-btn dk-emot emot-happy"></button></li>
			                    <li><button ng-click="insertEmotion('sick'); $event.stopPropagation();" class="raw-btn dk-emot emot-sick"></button></li>
			                    <li><button ng-click="insertEmotion('smiley'); $event.stopPropagation();" class="raw-btn dk-emot emot-smiley"></button></li>
			                    <li><button ng-click="insertEmotion('cry'); $event.stopPropagation();" class="raw-btn dk-emot emot-cry"></button></li>
			                    <li><button ng-click="insertEmotion('yummi'); $event.stopPropagation();" class="raw-btn dk-emot emot-yummi"></button></li>
			                    <li><button ng-click="insertEmotion('scream'); $event.stopPropagation();" class="raw-btn dk-emot emot-scream"></button></li>
			                    <li><button ng-click="insertEmotion('Q'); $event.stopPropagation();" class="raw-btn dk-emot emot-Q"></button></li>
			                    <li><button ng-click="insertEmotion('exclam'); $event.stopPropagation();" class="raw-btn dk-emot emot-exclam"></button></li>
			                    <li><button ng-click="insertEmotion('dollar'); $event.stopPropagation();" class="raw-btn dk-emot emot-dollar"></button></li>
			                    <li><button ng-click="insertEmotion('burger'); $event.stopPropagation();" class="raw-btn dk-emot emot-burger"></button></li>
			                    <li><button ng-click="insertEmotion('coffee'); $event.stopPropagation();" class="raw-btn dk-emot emot-coffee"></button></li>
			                    <li><button ng-click="insertEmotion('cupcake'); $event.stopPropagation();" class="raw-btn dk-emot emot-cupcake"></button></li>
					    		<li><button ng-click="insertEmotion('airplane'); $event.stopPropagation();" class="raw-btn dk-emot emot-airplane"></button></li>
			                    <li><button ng-click="insertEmotion('car'); $event.stopPropagation();" class="raw-btn dk-emot emot-car"></button></li>
			                    <li><button ng-click="insertEmotion('cloud'); $event.stopPropagation();" class="raw-btn dk-emot emot-cloud"></button></li>
			                    <li><button ng-click="insertEmotion('rain'); $event.stopPropagation();" class="raw-btn dk-emot emot-rain"></button></li>
			                    <li><button ng-click="insertEmotion('sun'); $event.stopPropagation();" class="raw-btn dk-emot emot-sun"></button></li>
			                    <li><button ng-click="insertEmotion('flower'); $event.stopPropagation();" class="raw-btn dk-emot emot-flower"></button></li>
			                    <li><button ng-click="insertEmotion('music'); $event.stopPropagation();" class="raw-btn dk-emot emot-music"></button></li>
			                    <li><button ng-click="insertEmotion('fire'); $event.stopPropagation();" class="raw-btn dk-emot emot-fire"></button></li>
			                    <li><button ng-click="insertEmotion('koala'); $event.stopPropagation();" class="raw-btn dk-emot emot-koala"></button></li>
			                    <li><button ng-click="insertEmotion('ladybug'); $event.stopPropagation();" class="raw-btn dk-emot emot-ladybug"></button></li>
			                    <li><button ng-click="insertEmotion('relax'); $event.stopPropagation();" class="raw-btn dk-emot emot-relax"></button></li>
			                    <li><button ng-click="insertEmotion('basketball'); $event.stopPropagation();" class="raw-btn dk-emot emot-basketball"></button></li>
			                    <li><button ng-click="insertEmotion('soccer'); $event.stopPropagation();" class="raw-btn dk-emot emot-soccer"></button></li>
			                    <li><button ng-click="insertEmotion('baseball'); $event.stopPropagation();" class="raw-btn dk-emot emot-baseball"></button></li>
			                    <li><button ng-click="insertEmotion('time'); $event.stopPropagation();" class="raw-btn dk-emot emot-time"></button></li>
			                    <li><button ng-click="insertEmotion('bicycle'); $event.stopPropagation();" class="raw-btn dk-emot emot-bicycle"></button></li>
			                    <li><button ng-click="insertEmotion('clap'); $event.stopPropagation();" class="raw-btn dk-emot emot-clap"></button></li>
			                    <li><button ng-click="insertEmotion('run'); $event.stopPropagation();" class="raw-btn dk-emot emot-run"></button></li>
			                    <li><button ng-click="insertEmotion('light_bulb'); $event.stopPropagation();" class="raw-btn dk-emot emot-light_bulb"></button></li>
			                    
					  </ul>
					</div>
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
				<textarea class="form-control" id="group-text-area" ng-model="groupText"></textarea>
				<button class="btn btn-success btn-sm" ng-disabled="!groupText" ng-click="submitGroupMessage()">ارسال</button>
				<div class="btn-group dropup emotions-list group-message">
				  <button type="button" class="btn btn-default dropdown-toggle emotion-add-icon" data-toggle="dropdown" aria-expanded="false">
				  </button>
				  <ul class="dropdown-menu" role="menu">
		                    <li><button ng-click="insertEmotionGroup('angry'); $event.stopPropagation();" class="raw-btn dk-emot emot-angry"></button></li>
		                    <li><button ng-click="insertEmotionGroup('confused'); $event.stopPropagation();" class="raw-btn dk-emot emot-confused"></button></li>
		                    <li><button ng-click="insertEmotionGroup('cool'); $event.stopPropagation();" class="raw-btn dk-emot emot-cool"></button></li>
		                    <li><button ng-click="insertEmotionGroup('crazy'); $event.stopPropagation();" class="raw-btn dk-emot emot-crazy"></button></li>
		                    <li><button ng-click="insertEmotionGroup('depressed'); $event.stopPropagation();" class="raw-btn dk-emot emot-depressed"></button></li>
		                    <li><button ng-click="insertEmotionGroup('wink'); $event.stopPropagation();" class="raw-btn dk-emot emot-wink"></button></li>
		                    <li><button ng-click="insertEmotionGroup('teeth'); $event.stopPropagation();" class="raw-btn dk-emot emot-teeth"></button></li>
		                    <li><button ng-click="insertEmotionGroup('shy'); $event.stopPropagation();" class="raw-btn dk-emot emot-shy"></button></li>
		                    <li><button ng-click="insertEmotionGroup('sleeping'); $event.stopPropagation();" class="raw-btn dk-emot emot-sleeping"></button></li>
		                    <li><button ng-click="insertEmotionGroup('money'); $event.stopPropagation();" class="raw-btn dk-emot emot-money"></button></li>
		                    <li><button ng-click="insertEmotionGroup('nerd'); $event.stopPropagation();" class="raw-btn dk-emot emot-nerd"></button></li>
		                    <li><button ng-click="insertEmotionGroup('not_sure'); $event.stopPropagation();" class="raw-btn dk-emot emot-not_sure"></button></li>
		                    <li><button ng-click="insertEmotionGroup('mad'); $event.stopPropagation();" class="raw-btn dk-emot emot-mad"></button></li>
		                    <li><button ng-click="insertEmotionGroup('laugh'); $event.stopPropagation();" class="raw-btn dk-emot emot-laugh"></button></li>
		                    <li><button ng-click="insertEmotionGroup('surprised'); $event.stopPropagation();" class="raw-btn dk-emot emot-surprised"></button></li>
		                    <li><button ng-click="insertEmotionGroup('sad'); $event.stopPropagation();" class="raw-btn dk-emot emot-sad"></button></li>
		                    <li><button ng-click="insertEmotionGroup('tongue'); $event.stopPropagation();" class="raw-btn dk-emot emot-tongue"></button></li>
		                    <li><button ng-click="insertEmotionGroup('happy'); $event.stopPropagation();" class="raw-btn dk-emot emot-happy"></button></li>
		                    <li><button ng-click="insertEmotionGroup('sick'); $event.stopPropagation();" class="raw-btn dk-emot emot-sick"></button></li>
		                    <li><button ng-click="insertEmotionGroup('smiley'); $event.stopPropagation();" class="raw-btn dk-emot emot-smiley"></button></li>
		                    <li><button ng-click="insertEmotionGroup('cry'); $event.stopPropagation();" class="raw-btn dk-emot emot-cry"></button></li>
		                    <li><button ng-click="insertEmotionGroup('yummi'); $event.stopPropagation();" class="raw-btn dk-emot emot-yummi"></button></li>
		                    <li><button ng-click="insertEmotionGroup('scream'); $event.stopPropagation();" class="raw-btn dk-emot emot-scream"></button></li>
		                    <li><button ng-click="insertEmotionGroup('Q'); $event.stopPropagation();" class="raw-btn dk-emot emot-Q"></button></li>
		                    <li><button ng-click="insertEmotionGroup('exclam'); $event.stopPropagation();" class="raw-btn dk-emot emot-exclam"></button></li>
		                    <li><button ng-click="insertEmotionGroup('dollar'); $event.stopPropagation();" class="raw-btn dk-emot emot-dollar"></button></li>
		                    <li><button ng-click="insertEmotionGroup('burger'); $event.stopPropagation();" class="raw-btn dk-emot emot-burger"></button></li>
		                    <li><button ng-click="insertEmotionGroup('coffee'); $event.stopPropagation();" class="raw-btn dk-emot emot-coffee"></button></li>
		                    <li><button ng-click="insertEmotionGroup('cupcake'); $event.stopPropagation();" class="raw-btn dk-emot emot-cupcake"></button></li>
				    		<li><button ng-click="insertEmotionGroup('airplane'); $event.stopPropagation();" class="raw-btn dk-emot emot-airplane"></button></li>
		                    <li><button ng-click="insertEmotionGroup('car'); $event.stopPropagation();" class="raw-btn dk-emot emot-car"></button></li>
		                    <li><button ng-click="insertEmotionGroup('cloud'); $event.stopPropagation();" class="raw-btn dk-emot emot-cloud"></button></li>
		                    <li><button ng-click="insertEmotionGroup('rain'); $event.stopPropagation();" class="raw-btn dk-emot emot-rain"></button></li>
		                    <li><button ng-click="insertEmotionGroup('sun'); $event.stopPropagation();" class="raw-btn dk-emot emot-sun"></button></li>
		                    <li><button ng-click="insertEmotionGroup('flower'); $event.stopPropagation();" class="raw-btn dk-emot emot-flower"></button></li>
		                    <li><button ng-click="insertEmotionGroup('music'); $event.stopPropagation();" class="raw-btn dk-emot emot-music"></button></li>
		                    <li><button ng-click="insertEmotionGroup('fire'); $event.stopPropagation();" class="raw-btn dk-emot emot-fire"></button></li>
		                    <li><button ng-click="insertEmotionGroup('koala'); $event.stopPropagation();" class="raw-btn dk-emot emot-koala"></button></li>
		                    <li><button ng-click="insertEmotionGroup('ladybug'); $event.stopPropagation();" class="raw-btn dk-emot emot-ladybug"></button></li>
		                    <li><button ng-click="insertEmotionGroup('relax'); $event.stopPropagation();" class="raw-btn dk-emot emot-relax"></button></li>
		                    <li><button ng-click="insertEmotionGroup('basketball'); $event.stopPropagation();" class="raw-btn dk-emot emot-basketball"></button></li>
		                    <li><button ng-click="insertEmotionGroup('soccer'); $event.stopPropagation();" class="raw-btn dk-emot emot-soccer"></button></li>
		                    <li><button ng-click="insertEmotionGroup('baseball'); $event.stopPropagation();" class="raw-btn dk-emot emot-baseball"></button></li>
		                    <li><button ng-click="insertEmotionGroup('time'); $event.stopPropagation();" class="raw-btn dk-emot emot-time"></button></li>
		                    <li><button ng-click="insertEmotionGroup('bicycle'); $event.stopPropagation();" class="raw-btn dk-emot emot-bicycle"></button></li>
		                    <li><button ng-click="insertEmotionGroup('clap'); $event.stopPropagation();" class="raw-btn dk-emot emot-clap"></button></li>
		                    <li><button ng-click="insertEmotionGroup('run'); $event.stopPropagation();" class="raw-btn dk-emot emot-run"></button></li>
		                    <li><button ng-click="insertEmotionGroup('light_bulb'); $event.stopPropagation();" class="raw-btn dk-emot emot-light_bulb"></button></li>
		                    
				  </ul>
				</div>
			</form>
			
		</div>
		
	</div>
</div>

