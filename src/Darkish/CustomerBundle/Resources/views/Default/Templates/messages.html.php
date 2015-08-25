<div class="row page messages-page">
	<div class="col col-xs-12 col-sm-5 threads master"
		 ng-hide="isXSmall() && (selectedThread.id || groupMessageForm)">
		<div ng-show="user.type == 'owner'" class="well master-buttons" ng-class="{'fixed': isXSmall()}">

			<button ng-click="showGroupMessageForm()" 
					class="btn btn-danger group-message-button">ارسال پیام گروهی</button>
		</div>
		<div class="well inner master-inner" ng-class="{'scrollable': !isXSmall()}">
			<ul ng-show="threads.length">
				<li ng-repeat="thread in threads | orderBy: '-last_message.id'" class="thread" ng-click="selectThread(thread)"
					ng-class="{'selected': selectedThread.id == thread.id}">
					<div class="private" ng-show="thread.thread_type == 'private'">
						<img ng-src="{{thread.client.photo ? thread.client.photo.icon_absolute_path : '<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_profile.jpg') ?>'}}" name="aboutme" width="48" height="48" class="img-circle">
						<div class="middle">
							<span class="username" ng-bind="thread.client.full_name ? thread.client.full_name : thread.client.username">
							</span>
							<span class="last-message" ng-show="thread.last_message" ng-bind-html="getLastMessageTrusted(thread.last_message.text)">
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
							<div class="dk icon-trash"></div>
						</button>
					</div>

					<div class="group" ng-show="thread.thread_type == 'group'">
						<img ng-src="{{thread.client.photo ? thread.client.photo.icon_absolute_path : '<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/group-message.png') ?>'}}" name="aboutme" width="48" height="48" class="img-circle">
						<div class="middle">
							<span class="group-label">
								پیام گروهی
							</span>
							<span class="last-message" ng-show="thread.last_message" ng-bind-html="getLastMessageTrusted(thread.last_message.text)">
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
							<div class="dk icon-trash"></div>
						</button>
					</div>
				</li>
			</ul>
			<div ng-hide="threads.length" class="">
				پیامی موجود نیست.
			</div>
		</div>
		
	</div>
	<div class="col col-xs-12 col-sm-7 messages details">
		<div class="details-header" id="details-header" 
			ng-show="(selectedThread.id || groupMessageForm)"
			ng-class="{'fixed': isXSmall()}"
			>
			<button class="return-button" ng-click="groupMessageForm = false ; selectedThread = {};">
				<div class="dk icon-arrow-right"></div>
			</button>
			{{(selectedThread.thread_type == 'group') ? 'پیام گروهی' : (selectedThread.client.full_name ? selectedThread.client.full_name : selectedThread.client.username )}}
			<!-- <button class="details-header-button btn btn-sm btn-primary">
				دکمه بالا
			</button> -->
		</div>
		<div ng-class="{'has-details-bottom': isXSmall() && selectedThread.id, 'scrollable': !isXSmall()}" ng-show="selectedThread.id" class="messages-inner details-inner" id="message-container" scroll-glue>
			<button ng-show="selectedThread.thread_type == 'private'" class="btn btn-info btn-xs load-more" ng-show="selectedThread.id" ng-disabled="hasNotMore" ng-click="loadMore()">بیشتر</button>
			<ul class="message-list">
				<li class="message" ng-repeat="message in currentMessages | orderBy: 'id'"
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
				<div class="message-text col col-xs-8 col-sm-8 ">
					<!-- <input class="form-control" ng-model="messageForm"/> -->
					<textarea maxlength="1500" id="message-text-area" class="msd-elastic form-control" ng-model="messageForm">
					</textarea>
					<!-- <span id="message-text-span" style="height: 50px; width:100%; background-color: rgb(226, 226, 226); display: inline-block;" contenteditable="true"
					        ng-model="messageForm"
					    	strip-br="true"
					 		select-non-editable="true">
					 </span> -->
				</div>
				<div class="col col-xs-2 col-sm-2 emotions-list">
					<div class="btn-group dropup  ">
					  <button type="button" class="btn btn-default dropdown-toggle emotion-add-icon" data-toggle="dropdown" aria-expanded="false">
					  	<span class="dk icon-smiley"></span>
					  </button>
					  <ul ng-click="$event.stopPropagation();" class="dropdown-menu" role="menu">
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('smiley'); $event.stopPropagation();" class="raw-btn dk-emot emot-smiley"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('happy'); $event.stopPropagation();" class="raw-btn dk-emot emot-happy"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('wink2'); $event.stopPropagation();" class="raw-btn dk-emot emot-wink2"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('wink'); $event.stopPropagation();" class="raw-btn dk-emot emot-wink"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('laugh'); $event.stopPropagation();" class="raw-btn dk-emot emot-laugh"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('teeth'); $event.stopPropagation();" class="raw-btn dk-emot emot-teeth"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('yummi'); $event.stopPropagation();" class="raw-btn dk-emot emot-yummi"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('surprised'); $event.stopPropagation();" class="raw-btn dk-emot emot-surprised"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('crazy'); $event.stopPropagation();" class="raw-btn dk-emot emot-crazy"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('money'); $event.stopPropagation();" class="raw-btn dk-emot emot-money"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('moa'); $event.stopPropagation();" class="raw-btn dk-emot emot-moa"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('inlove'); $event.stopPropagation();" class="raw-btn dk-emot emot-inlove"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('flirt'); $event.stopPropagation();" class="raw-btn dk-emot emot-flirt"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('teary'); $event.stopPropagation();" class="raw-btn dk-emot emot-teary"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('mad'); $event.stopPropagation();" class="raw-btn dk-emot emot-mad"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('upset'); $event.stopPropagation();" class="raw-btn dk-emot emot-upset"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cry'); $event.stopPropagation();" class="raw-btn dk-emot emot-cry"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('angry'); $event.stopPropagation();" class="raw-btn dk-emot emot-angry"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sick'); $event.stopPropagation();" class="raw-btn dk-emot emot-sick"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sleeping'); $event.stopPropagation();" class="raw-btn dk-emot emot-sleeping"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('info'); $event.stopPropagation();" class="raw-btn dk-emot emot-info"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('Q'); $event.stopPropagation();" class="raw-btn dk-emot emot-Q"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('heart'); $event.stopPropagation();" class="raw-btn dk-emot emot-heart"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('purple_heart'); $event.stopPropagation();" class="raw-btn dk-emot emot-purple_heart"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('clap'); $event.stopPropagation();" class="raw-btn dk-emot emot-clap"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('like'); $event.stopPropagation();" class="raw-btn dk-emot emot-like"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('V'); $event.stopPropagation();" class="raw-btn dk-emot emot-V"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('unlike'); $event.stopPropagation();" class="raw-btn dk-emot emot-unlike"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('flower'); $event.stopPropagation();" class="raw-btn dk-emot emot-flower"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('balloon2'); $event.stopPropagation();" class="raw-btn dk-emot emot-balloon2"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('balloon1'); $event.stopPropagation();" class="raw-btn dk-emot emot-balloon1"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cake'); $event.stopPropagation();" class="raw-btn dk-emot emot-cake"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('gift'); $event.stopPropagation();" class="raw-btn dk-emot emot-gift"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('partyhat'); $event.stopPropagation();" class="raw-btn dk-emot emot-partyhat"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cupcake'); $event.stopPropagation();" class="raw-btn dk-emot emot-cupcake"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('magnify'); $event.stopPropagation();" class="raw-btn dk-emot emot-magnify"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('glasses'); $event.stopPropagation();" class="raw-btn dk-emot emot-glasses"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('letter'); $event.stopPropagation();" class="raw-btn dk-emot emot-letter"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('thinking'); $event.stopPropagation();" class="raw-btn dk-emot emot-thinking"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('music'); $event.stopPropagation();" class="raw-btn dk-emot emot-music"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('pencil'); $event.stopPropagation();" class="raw-btn dk-emot emot-pencil"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('book'); $event.stopPropagation();" class="raw-btn dk-emot emot-book"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ruler'); $event.stopPropagation();" class="raw-btn dk-emot emot-ruler"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('scissor'); $event.stopPropagation();" class="raw-btn dk-emot emot-scissor"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('dollar'); $event.stopPropagation();" class="raw-btn dk-emot emot-dollar"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('run'); $event.stopPropagation();" class="raw-btn dk-emot emot-run"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('time'); $event.stopPropagation();" class="raw-btn dk-emot emot-time"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('bell'); $event.stopPropagation();" class="raw-btn dk-emot emot-bell"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('telephone'); $event.stopPropagation();" class="raw-btn dk-emot emot-telephone"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('snowman'); $event.stopPropagation();" class="raw-btn dk-emot emot-snowman"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('snowflake'); $event.stopPropagation();" class="raw-btn dk-emot emot-snowflake"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('rain'); $event.stopPropagation();" class="raw-btn dk-emot emot-rain"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cloud'); $event.stopPropagation();" class="raw-btn dk-emot emot-cloud"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('moon'); $event.stopPropagation();" class="raw-btn dk-emot emot-moon"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sun'); $event.stopPropagation();" class="raw-btn dk-emot emot-sun"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('angel'); $event.stopPropagation();" class="raw-btn dk-emot emot-angel"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('palmtree'); $event.stopPropagation();" class="raw-btn dk-emot emot-palmtree"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('christmas_tree'); $event.stopPropagation();" class="raw-btn dk-emot emot-christmas_tree"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sunflower'); $event.stopPropagation();" class="raw-btn dk-emot emot-sunflower"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cactus'); $event.stopPropagation();" class="raw-btn dk-emot emot-cactus"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sprout'); $event.stopPropagation();" class="raw-btn dk-emot emot-sprout"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('clover'); $event.stopPropagation();" class="raw-btn dk-emot emot-clover"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('koala'); $event.stopPropagation();" class="raw-btn dk-emot emot-koala"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('bunny'); $event.stopPropagation();" class="raw-btn dk-emot emot-bunny"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('squirrel'); $event.stopPropagation();" class="raw-btn dk-emot emot-squirrel"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('goldfish'); $event.stopPropagation();" class="raw-btn dk-emot emot-goldfish"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('monkey'); $event.stopPropagation();" class="raw-btn dk-emot emot-monkey"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cat'); $event.stopPropagation();" class="raw-btn dk-emot emot-cat"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('kangaroo'); $event.stopPropagation();" class="raw-btn dk-emot emot-kangaroo"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ladybug'); $event.stopPropagation();" class="raw-btn dk-emot emot-ladybug"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('turtle'); $event.stopPropagation();" class="raw-btn dk-emot emot-turtle"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sheep'); $event.stopPropagation();" class="raw-btn dk-emot emot-sheep"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('panda'); $event.stopPropagation();" class="raw-btn dk-emot emot-panda"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('owl'); $event.stopPropagation();" class="raw-btn dk-emot emot-owl"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('chick'); $event.stopPropagation();" class="raw-btn dk-emot emot-chick"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('dog'); $event.stopPropagation();" class="raw-btn dk-emot emot-dog"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('bee'); $event.stopPropagation();" class="raw-btn dk-emot emot-bee"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('penguin'); $event.stopPropagation();" class="raw-btn dk-emot emot-penguin"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('dragonfly'); $event.stopPropagation();" class="raw-btn dk-emot emot-dragonfly"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('pig'); $event.stopPropagation();" class="raw-btn dk-emot emot-pig"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('snake'); $event.stopPropagation();" class="raw-btn dk-emot emot-snake"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('snail'); $event.stopPropagation();" class="raw-btn dk-emot emot-snail"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('fly'); $event.stopPropagation();" class="raw-btn dk-emot emot-fly"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('shark'); $event.stopPropagation();" class="raw-btn dk-emot emot-shark"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('bat'); $event.stopPropagation();" class="raw-btn dk-emot emot-bat"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('martini'); $event.stopPropagation();" class="raw-btn dk-emot emot-martini"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('beer'); $event.stopPropagation();" class="raw-btn dk-emot emot-beer"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('coffee'); $event.stopPropagation();" class="raw-btn dk-emot emot-coffee"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('soda'); $event.stopPropagation();" class="raw-btn dk-emot emot-soda"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('burger'); $event.stopPropagation();" class="raw-btn dk-emot emot-burger"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('pizza'); $event.stopPropagation();" class="raw-btn dk-emot emot-pizza"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('hotdog'); $event.stopPropagation();" class="raw-btn dk-emot emot-hotdog"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('popcorn'); $event.stopPropagation();" class="raw-btn dk-emot emot-popcorn"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('egg'); $event.stopPropagation();" class="raw-btn dk-emot emot-egg"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('noodles'); $event.stopPropagation();" class="raw-btn dk-emot emot-noodles"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('chicken'); $event.stopPropagation();" class="raw-btn dk-emot emot-chicken"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('donut'); $event.stopPropagation();" class="raw-btn dk-emot emot-donut"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('popsicle'); $event.stopPropagation();" class="raw-btn dk-emot emot-popsicle"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ice_cream'); $event.stopPropagation();" class="raw-btn dk-emot emot-ice_cream"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('lollipop'); $event.stopPropagation();" class="raw-btn dk-emot emot-lollipop"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('croissant'); $event.stopPropagation();" class="raw-btn dk-emot emot-croissant"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('chocolate'); $event.stopPropagation();" class="raw-btn dk-emot emot-chocolate"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cherry'); $event.stopPropagation();" class="raw-btn dk-emot emot-cherry"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('grapes'); $event.stopPropagation();" class="raw-btn dk-emot emot-grapes"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('watermelon'); $event.stopPropagation();" class="raw-btn dk-emot emot-watermelon"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('strawberry'); $event.stopPropagation();" class="raw-btn dk-emot emot-strawberry"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('banana'); $event.stopPropagation();" class="raw-btn dk-emot emot-banana"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('pineapple'); $event.stopPropagation();" class="raw-btn dk-emot emot-pineapple"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('corn'); $event.stopPropagation();" class="raw-btn dk-emot emot-corn"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('pea'); $event.stopPropagation();" class="raw-btn dk-emot emot-pea"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('mushroom'); $event.stopPropagation();" class="raw-btn dk-emot emot-mushroom"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('bicycle'); $event.stopPropagation();" class="raw-btn dk-emot emot-bicycle"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('taxi'); $event.stopPropagation();" class="raw-btn dk-emot emot-taxi"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ambulance'); $event.stopPropagation();" class="raw-btn dk-emot emot-ambulance"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('policecar'); $event.stopPropagation();" class="raw-btn dk-emot emot-policecar"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('car'); $event.stopPropagation();" class="raw-btn dk-emot emot-car"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('airplane'); $event.stopPropagation();" class="raw-btn dk-emot emot-airplane"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('rocket'); $event.stopPropagation();" class="raw-btn dk-emot emot-rocket"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ufo'); $event.stopPropagation();" class="raw-btn dk-emot emot-ufo"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('flipflop'); $event.stopPropagation();" class="raw-btn dk-emot emot-flipflop"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('umbrella'); $event.stopPropagation();" class="raw-btn dk-emot emot-umbrella"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('fidora'); $event.stopPropagation();" class="raw-btn dk-emot emot-fidora"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cap'); $event.stopPropagation();" class="raw-btn dk-emot emot-cap"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('crown'); $event.stopPropagation();" class="raw-btn dk-emot emot-crown"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('diamond'); $event.stopPropagation();" class="raw-btn dk-emot emot-diamond"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ring'); $event.stopPropagation();" class="raw-btn dk-emot emot-ring"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('relax'); $event.stopPropagation();" class="raw-btn dk-emot emot-relax"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('battery'); $event.stopPropagation();" class="raw-btn dk-emot emot-battery"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('nobattery'); $event.stopPropagation();" class="raw-btn dk-emot emot-nobattery"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('termometer'); $event.stopPropagation();" class="raw-btn dk-emot emot-termometer"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('meds'); $event.stopPropagation();" class="raw-btn dk-emot emot-meds"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('syringe'); $event.stopPropagation();" class="raw-btn dk-emot emot-syringe"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('golfball'); $event.stopPropagation();" class="raw-btn dk-emot emot-golfball"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('golf'); $event.stopPropagation();" class="raw-btn dk-emot emot-golf"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('soccer'); $event.stopPropagation();" class="raw-btn dk-emot emot-soccer"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('baseball'); $event.stopPropagation();" class="raw-btn dk-emot emot-baseball"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('basketball'); $event.stopPropagation();" class="raw-btn dk-emot emot-basketball"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('tennis'); $event.stopPropagation();" class="raw-btn dk-emot emot-tennis"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('beachball'); $event.stopPropagation();" class="raw-btn dk-emot emot-beachball"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('8ball'); $event.stopPropagation();" class="raw-btn dk-emot emot-8ball"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('boxing'); $event.stopPropagation();" class="raw-btn dk-emot emot-boxing"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('football'); $event.stopPropagation();" class="raw-btn dk-emot emot-football"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('weight'); $event.stopPropagation();" class="raw-btn dk-emot emot-weight"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('muscle'); $event.stopPropagation();" class="raw-btn dk-emot emot-muscle"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('trophy'); $event.stopPropagation();" class="raw-btn dk-emot emot-trophy"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('happycry'); $event.stopPropagation();" class="raw-btn dk-emot emot-happycry"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('silly'); $event.stopPropagation();" class="raw-btn dk-emot emot-silly"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('nerd'); $event.stopPropagation();" class="raw-btn dk-emot emot-nerd"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('shy'); $event.stopPropagation();" class="raw-btn dk-emot emot-shy"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('not_sure'); $event.stopPropagation();" class="raw-btn dk-emot emot-not_sure"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('confused'); $event.stopPropagation();" class="raw-btn dk-emot emot-confused"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('meh'); $event.stopPropagation();" class="raw-btn dk-emot emot-meh"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('what'); $event.stopPropagation();" class="raw-btn dk-emot emot-what"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('yo'); $event.stopPropagation();" class="raw-btn dk-emot emot-yo"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('wtf'); $event.stopPropagation();" class="raw-btn dk-emot emot-wtf"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('tongue'); $event.stopPropagation();" class="raw-btn dk-emot emot-tongue"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sad'); $event.stopPropagation();" class="raw-btn dk-emot emot-sad"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('exhausted'); $event.stopPropagation();" class="raw-btn dk-emot emot-exhausted"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('huh'); $event.stopPropagation();" class="raw-btn dk-emot emot-huh"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('scream'); $event.stopPropagation();" class="raw-btn dk-emot emot-scream"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('weak'); $event.stopPropagation();" class="raw-btn dk-emot emot-weak"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('dead'); $event.stopPropagation();" class="raw-btn dk-emot emot-dead"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('mischievous'); $event.stopPropagation();" class="raw-btn dk-emot emot-mischievous"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ohno'); $event.stopPropagation();" class="raw-btn dk-emot emot-ohno"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('straight'); $event.stopPropagation();" class="raw-btn dk-emot emot-straight"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('dizzy'); $event.stopPropagation();" class="raw-btn dk-emot emot-dizzy"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cool'); $event.stopPropagation();" class="raw-btn dk-emot emot-cool"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('spiderman'); $event.stopPropagation();" class="raw-btn dk-emot emot-spiderman"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('eek'); $event.stopPropagation();" class="raw-btn dk-emot emot-eek"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ugh'); $event.stopPropagation();" class="raw-btn dk-emot emot-ugh"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('devil'); $event.stopPropagation();" class="raw-btn dk-emot emot-devil"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('oh'); $event.stopPropagation();" class="raw-btn dk-emot emot-oh"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('depressed'); $event.stopPropagation();" class="raw-btn dk-emot emot-depressed"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('mwah'); $event.stopPropagation();" class="raw-btn dk-emot emot-mwah"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('singing'); $event.stopPropagation();" class="raw-btn dk-emot emot-singing"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('batman'); $event.stopPropagation();" class="raw-btn dk-emot emot-batman"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ninja'); $event.stopPropagation();" class="raw-btn dk-emot emot-ninja"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('light_bulb'); $event.stopPropagation();" class="raw-btn dk-emot emot-light_bulb"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('fire'); $event.stopPropagation();" class="raw-btn dk-emot emot-fire"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('torch'); $event.stopPropagation();" class="raw-btn dk-emot emot-torch"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sushi1'); $event.stopPropagation();" class="raw-btn dk-emot emot-sushi1"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sushi2'); $event.stopPropagation();" class="raw-btn dk-emot emot-sushi2"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('phone'); $event.stopPropagation();" class="raw-btn dk-emot emot-phone"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('knife'); $event.stopPropagation();" class="raw-btn dk-emot emot-knife"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('key'); $event.stopPropagation();" class="raw-btn dk-emot emot-key"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('angrymark'); $event.stopPropagation();" class="raw-btn dk-emot emot-angrymark"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('bomb'); $event.stopPropagation();" class="raw-btn dk-emot emot-bomb"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('mapleleaf'); $event.stopPropagation();" class="raw-btn dk-emot emot-mapleleaf"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('zzz'); $event.stopPropagation();" class="raw-btn dk-emot emot-zzz"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('guitar'); $event.stopPropagation();" class="raw-btn dk-emot emot-guitar"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('trumpet'); $event.stopPropagation();" class="raw-btn dk-emot emot-trumpet"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('hammer'); $event.stopPropagation();" class="raw-btn dk-emot emot-hammer"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('dice'); $event.stopPropagation();" class="raw-btn dk-emot emot-dice"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('console'); $event.stopPropagation();" class="raw-btn dk-emot emot-console"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('lantern'); $event.stopPropagation();" class="raw-btn dk-emot emot-lantern"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('microphone'); $event.stopPropagation();" class="raw-btn dk-emot emot-microphone"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('tape'); $event.stopPropagation();" class="raw-btn dk-emot emot-tape"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('speaker'); $event.stopPropagation();" class="raw-btn dk-emot emot-speaker"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('video'); $event.stopPropagation();" class="raw-btn dk-emot emot-video"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('TV'); $event.stopPropagation();" class="raw-btn dk-emot emot-TV"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('wrench'); $event.stopPropagation();" class="raw-btn dk-emot emot-wrench"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('lock'); $event.stopPropagation();" class="raw-btn dk-emot emot-lock"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('paperclip'); $event.stopPropagation();" class="raw-btn dk-emot emot-paperclip"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('skull'); $event.stopPropagation();" class="raw-btn dk-emot emot-skull"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ghost'); $event.stopPropagation();" class="raw-btn dk-emot emot-ghost"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('paw'); $event.stopPropagation();" class="raw-btn dk-emot emot-paw"></button></li>
						  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('darkish-logo'); $event.stopPropagation();" class="raw-btn dk-emot emot-darkish-logo"></button></li>
			                    
					  </ul>
					</div>
				</div>
				<div class="submit-button col col-xs-2 col-sm-2 ">
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
				<div ng-hide="canSendGroupMessage()" class="groupMessageDisabled">
					در حال حاضر ارسال پیام گروهی برای شما مقدور نیست. شما در تاریخ و ساعت {{openGroupMessage() | toDate | amDateFormat:'jYYYY/jM/jD, h:mm'}} می توانید برای ارسال پیام گروهی اقدام فرمایید.
					
				</div>
				<textarea ng-disabled="groupMessageApprove || !canSendGroupMessage()" maxlength="3000" class="form-control" id="group-text-area" ng-model="groupText"></textarea>
				<button ng-hide="groupMessageApprove"  class="btn btn-success btn-sm" ng-disabled="!groupText || !canSendGroupMessage()" ng-click="presubmitGroupMessage()">پیش نمایش</button>
				<div ng-hide="groupMessageApprove" class="btn-group dropup emotions-list group-message">
				  <button type="button" class="btn btn-default dropdown-toggle emotion-add-icon" data-toggle="dropdown" aria-expanded="false">
				  	<span class="dk icon-smiley"></span>
				  </button>
				  <ul ng-click="$event.stopPropagation();" class="dropdown-menu" role="menu">
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('smiley'); $event.stopPropagation();" class="raw-btn dk-emot emot-smiley"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('happy'); $event.stopPropagation();" class="raw-btn dk-emot emot-happy"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('wink2'); $event.stopPropagation();" class="raw-btn dk-emot emot-wink2"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('wink'); $event.stopPropagation();" class="raw-btn dk-emot emot-wink"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('laugh'); $event.stopPropagation();" class="raw-btn dk-emot emot-laugh"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('teeth'); $event.stopPropagation();" class="raw-btn dk-emot emot-teeth"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('yummi'); $event.stopPropagation();" class="raw-btn dk-emot emot-yummi"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('surprised'); $event.stopPropagation();" class="raw-btn dk-emot emot-surprised"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('crazy'); $event.stopPropagation();" class="raw-btn dk-emot emot-crazy"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('money'); $event.stopPropagation();" class="raw-btn dk-emot emot-money"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('moa'); $event.stopPropagation();" class="raw-btn dk-emot emot-moa"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('inlove'); $event.stopPropagation();" class="raw-btn dk-emot emot-inlove"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('flirt'); $event.stopPropagation();" class="raw-btn dk-emot emot-flirt"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('teary'); $event.stopPropagation();" class="raw-btn dk-emot emot-teary"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('mad'); $event.stopPropagation();" class="raw-btn dk-emot emot-mad"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('upset'); $event.stopPropagation();" class="raw-btn dk-emot emot-upset"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cry'); $event.stopPropagation();" class="raw-btn dk-emot emot-cry"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('angry'); $event.stopPropagation();" class="raw-btn dk-emot emot-angry"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sick'); $event.stopPropagation();" class="raw-btn dk-emot emot-sick"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sleeping'); $event.stopPropagation();" class="raw-btn dk-emot emot-sleeping"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('info'); $event.stopPropagation();" class="raw-btn dk-emot emot-info"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('Q'); $event.stopPropagation();" class="raw-btn dk-emot emot-Q"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('heart'); $event.stopPropagation();" class="raw-btn dk-emot emot-heart"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('purple_heart'); $event.stopPropagation();" class="raw-btn dk-emot emot-purple_heart"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('clap'); $event.stopPropagation();" class="raw-btn dk-emot emot-clap"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('like'); $event.stopPropagation();" class="raw-btn dk-emot emot-like"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('V'); $event.stopPropagation();" class="raw-btn dk-emot emot-V"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('unlike'); $event.stopPropagation();" class="raw-btn dk-emot emot-unlike"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('flower'); $event.stopPropagation();" class="raw-btn dk-emot emot-flower"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('balloon2'); $event.stopPropagation();" class="raw-btn dk-emot emot-balloon2"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('balloon1'); $event.stopPropagation();" class="raw-btn dk-emot emot-balloon1"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cake'); $event.stopPropagation();" class="raw-btn dk-emot emot-cake"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('gift'); $event.stopPropagation();" class="raw-btn dk-emot emot-gift"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('partyhat'); $event.stopPropagation();" class="raw-btn dk-emot emot-partyhat"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cupcake'); $event.stopPropagation();" class="raw-btn dk-emot emot-cupcake"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('magnify'); $event.stopPropagation();" class="raw-btn dk-emot emot-magnify"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('glasses'); $event.stopPropagation();" class="raw-btn dk-emot emot-glasses"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('letter'); $event.stopPropagation();" class="raw-btn dk-emot emot-letter"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('thinking'); $event.stopPropagation();" class="raw-btn dk-emot emot-thinking"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('music'); $event.stopPropagation();" class="raw-btn dk-emot emot-music"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('pencil'); $event.stopPropagation();" class="raw-btn dk-emot emot-pencil"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('book'); $event.stopPropagation();" class="raw-btn dk-emot emot-book"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ruler'); $event.stopPropagation();" class="raw-btn dk-emot emot-ruler"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('scissor'); $event.stopPropagation();" class="raw-btn dk-emot emot-scissor"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('dollar'); $event.stopPropagation();" class="raw-btn dk-emot emot-dollar"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('run'); $event.stopPropagation();" class="raw-btn dk-emot emot-run"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('time'); $event.stopPropagation();" class="raw-btn dk-emot emot-time"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('bell'); $event.stopPropagation();" class="raw-btn dk-emot emot-bell"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('telephone'); $event.stopPropagation();" class="raw-btn dk-emot emot-telephone"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('snowman'); $event.stopPropagation();" class="raw-btn dk-emot emot-snowman"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('snowflake'); $event.stopPropagation();" class="raw-btn dk-emot emot-snowflake"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('rain'); $event.stopPropagation();" class="raw-btn dk-emot emot-rain"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cloud'); $event.stopPropagation();" class="raw-btn dk-emot emot-cloud"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('moon'); $event.stopPropagation();" class="raw-btn dk-emot emot-moon"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sun'); $event.stopPropagation();" class="raw-btn dk-emot emot-sun"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('angel'); $event.stopPropagation();" class="raw-btn dk-emot emot-angel"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('palmtree'); $event.stopPropagation();" class="raw-btn dk-emot emot-palmtree"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('christmas_tree'); $event.stopPropagation();" class="raw-btn dk-emot emot-christmas_tree"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sunflower'); $event.stopPropagation();" class="raw-btn dk-emot emot-sunflower"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cactus'); $event.stopPropagation();" class="raw-btn dk-emot emot-cactus"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sprout'); $event.stopPropagation();" class="raw-btn dk-emot emot-sprout"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('clover'); $event.stopPropagation();" class="raw-btn dk-emot emot-clover"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('koala'); $event.stopPropagation();" class="raw-btn dk-emot emot-koala"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('bunny'); $event.stopPropagation();" class="raw-btn dk-emot emot-bunny"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('squirrel'); $event.stopPropagation();" class="raw-btn dk-emot emot-squirrel"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('goldfish'); $event.stopPropagation();" class="raw-btn dk-emot emot-goldfish"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('monkey'); $event.stopPropagation();" class="raw-btn dk-emot emot-monkey"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cat'); $event.stopPropagation();" class="raw-btn dk-emot emot-cat"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('kangaroo'); $event.stopPropagation();" class="raw-btn dk-emot emot-kangaroo"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ladybug'); $event.stopPropagation();" class="raw-btn dk-emot emot-ladybug"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('turtle'); $event.stopPropagation();" class="raw-btn dk-emot emot-turtle"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sheep'); $event.stopPropagation();" class="raw-btn dk-emot emot-sheep"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('panda'); $event.stopPropagation();" class="raw-btn dk-emot emot-panda"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('owl'); $event.stopPropagation();" class="raw-btn dk-emot emot-owl"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('chick'); $event.stopPropagation();" class="raw-btn dk-emot emot-chick"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('dog'); $event.stopPropagation();" class="raw-btn dk-emot emot-dog"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('bee'); $event.stopPropagation();" class="raw-btn dk-emot emot-bee"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('penguin'); $event.stopPropagation();" class="raw-btn dk-emot emot-penguin"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('dragonfly'); $event.stopPropagation();" class="raw-btn dk-emot emot-dragonfly"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('pig'); $event.stopPropagation();" class="raw-btn dk-emot emot-pig"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('snake'); $event.stopPropagation();" class="raw-btn dk-emot emot-snake"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('snail'); $event.stopPropagation();" class="raw-btn dk-emot emot-snail"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('fly'); $event.stopPropagation();" class="raw-btn dk-emot emot-fly"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('shark'); $event.stopPropagation();" class="raw-btn dk-emot emot-shark"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('bat'); $event.stopPropagation();" class="raw-btn dk-emot emot-bat"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('martini'); $event.stopPropagation();" class="raw-btn dk-emot emot-martini"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('beer'); $event.stopPropagation();" class="raw-btn dk-emot emot-beer"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('coffee'); $event.stopPropagation();" class="raw-btn dk-emot emot-coffee"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('soda'); $event.stopPropagation();" class="raw-btn dk-emot emot-soda"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('burger'); $event.stopPropagation();" class="raw-btn dk-emot emot-burger"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('pizza'); $event.stopPropagation();" class="raw-btn dk-emot emot-pizza"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('hotdog'); $event.stopPropagation();" class="raw-btn dk-emot emot-hotdog"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('popcorn'); $event.stopPropagation();" class="raw-btn dk-emot emot-popcorn"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('egg'); $event.stopPropagation();" class="raw-btn dk-emot emot-egg"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('noodles'); $event.stopPropagation();" class="raw-btn dk-emot emot-noodles"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('chicken'); $event.stopPropagation();" class="raw-btn dk-emot emot-chicken"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('donut'); $event.stopPropagation();" class="raw-btn dk-emot emot-donut"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('popsicle'); $event.stopPropagation();" class="raw-btn dk-emot emot-popsicle"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ice_cream'); $event.stopPropagation();" class="raw-btn dk-emot emot-ice_cream"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('lollipop'); $event.stopPropagation();" class="raw-btn dk-emot emot-lollipop"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('croissant'); $event.stopPropagation();" class="raw-btn dk-emot emot-croissant"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('chocolate'); $event.stopPropagation();" class="raw-btn dk-emot emot-chocolate"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cherry'); $event.stopPropagation();" class="raw-btn dk-emot emot-cherry"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('grapes'); $event.stopPropagation();" class="raw-btn dk-emot emot-grapes"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('watermelon'); $event.stopPropagation();" class="raw-btn dk-emot emot-watermelon"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('strawberry'); $event.stopPropagation();" class="raw-btn dk-emot emot-strawberry"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('banana'); $event.stopPropagation();" class="raw-btn dk-emot emot-banana"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('pineapple'); $event.stopPropagation();" class="raw-btn dk-emot emot-pineapple"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('corn'); $event.stopPropagation();" class="raw-btn dk-emot emot-corn"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('pea'); $event.stopPropagation();" class="raw-btn dk-emot emot-pea"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('mushroom'); $event.stopPropagation();" class="raw-btn dk-emot emot-mushroom"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('bicycle'); $event.stopPropagation();" class="raw-btn dk-emot emot-bicycle"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('taxi'); $event.stopPropagation();" class="raw-btn dk-emot emot-taxi"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ambulance'); $event.stopPropagation();" class="raw-btn dk-emot emot-ambulance"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('policecar'); $event.stopPropagation();" class="raw-btn dk-emot emot-policecar"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('car'); $event.stopPropagation();" class="raw-btn dk-emot emot-car"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('airplane'); $event.stopPropagation();" class="raw-btn dk-emot emot-airplane"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('rocket'); $event.stopPropagation();" class="raw-btn dk-emot emot-rocket"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ufo'); $event.stopPropagation();" class="raw-btn dk-emot emot-ufo"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('flipflop'); $event.stopPropagation();" class="raw-btn dk-emot emot-flipflop"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('umbrella'); $event.stopPropagation();" class="raw-btn dk-emot emot-umbrella"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('fidora'); $event.stopPropagation();" class="raw-btn dk-emot emot-fidora"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cap'); $event.stopPropagation();" class="raw-btn dk-emot emot-cap"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('crown'); $event.stopPropagation();" class="raw-btn dk-emot emot-crown"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('diamond'); $event.stopPropagation();" class="raw-btn dk-emot emot-diamond"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ring'); $event.stopPropagation();" class="raw-btn dk-emot emot-ring"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('relax'); $event.stopPropagation();" class="raw-btn dk-emot emot-relax"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('battery'); $event.stopPropagation();" class="raw-btn dk-emot emot-battery"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('nobattery'); $event.stopPropagation();" class="raw-btn dk-emot emot-nobattery"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('termometer'); $event.stopPropagation();" class="raw-btn dk-emot emot-termometer"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('meds'); $event.stopPropagation();" class="raw-btn dk-emot emot-meds"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('syringe'); $event.stopPropagation();" class="raw-btn dk-emot emot-syringe"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('golfball'); $event.stopPropagation();" class="raw-btn dk-emot emot-golfball"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('golf'); $event.stopPropagation();" class="raw-btn dk-emot emot-golf"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('soccer'); $event.stopPropagation();" class="raw-btn dk-emot emot-soccer"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('baseball'); $event.stopPropagation();" class="raw-btn dk-emot emot-baseball"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('basketball'); $event.stopPropagation();" class="raw-btn dk-emot emot-basketball"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('tennis'); $event.stopPropagation();" class="raw-btn dk-emot emot-tennis"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('beachball'); $event.stopPropagation();" class="raw-btn dk-emot emot-beachball"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('8ball'); $event.stopPropagation();" class="raw-btn dk-emot emot-8ball"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('boxing'); $event.stopPropagation();" class="raw-btn dk-emot emot-boxing"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('football'); $event.stopPropagation();" class="raw-btn dk-emot emot-football"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('weight'); $event.stopPropagation();" class="raw-btn dk-emot emot-weight"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('muscle'); $event.stopPropagation();" class="raw-btn dk-emot emot-muscle"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('trophy'); $event.stopPropagation();" class="raw-btn dk-emot emot-trophy"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('happycry'); $event.stopPropagation();" class="raw-btn dk-emot emot-happycry"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('silly'); $event.stopPropagation();" class="raw-btn dk-emot emot-silly"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('nerd'); $event.stopPropagation();" class="raw-btn dk-emot emot-nerd"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('shy'); $event.stopPropagation();" class="raw-btn dk-emot emot-shy"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('not_sure'); $event.stopPropagation();" class="raw-btn dk-emot emot-not_sure"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('confused'); $event.stopPropagation();" class="raw-btn dk-emot emot-confused"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('meh'); $event.stopPropagation();" class="raw-btn dk-emot emot-meh"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('what'); $event.stopPropagation();" class="raw-btn dk-emot emot-what"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('yo'); $event.stopPropagation();" class="raw-btn dk-emot emot-yo"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('wtf'); $event.stopPropagation();" class="raw-btn dk-emot emot-wtf"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('tongue'); $event.stopPropagation();" class="raw-btn dk-emot emot-tongue"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sad'); $event.stopPropagation();" class="raw-btn dk-emot emot-sad"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('exhausted'); $event.stopPropagation();" class="raw-btn dk-emot emot-exhausted"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('huh'); $event.stopPropagation();" class="raw-btn dk-emot emot-huh"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('scream'); $event.stopPropagation();" class="raw-btn dk-emot emot-scream"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('weak'); $event.stopPropagation();" class="raw-btn dk-emot emot-weak"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('dead'); $event.stopPropagation();" class="raw-btn dk-emot emot-dead"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('mischievous'); $event.stopPropagation();" class="raw-btn dk-emot emot-mischievous"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ohno'); $event.stopPropagation();" class="raw-btn dk-emot emot-ohno"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('straight'); $event.stopPropagation();" class="raw-btn dk-emot emot-straight"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('dizzy'); $event.stopPropagation();" class="raw-btn dk-emot emot-dizzy"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('cool'); $event.stopPropagation();" class="raw-btn dk-emot emot-cool"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('spiderman'); $event.stopPropagation();" class="raw-btn dk-emot emot-spiderman"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('eek'); $event.stopPropagation();" class="raw-btn dk-emot emot-eek"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ugh'); $event.stopPropagation();" class="raw-btn dk-emot emot-ugh"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('devil'); $event.stopPropagation();" class="raw-btn dk-emot emot-devil"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('oh'); $event.stopPropagation();" class="raw-btn dk-emot emot-oh"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('depressed'); $event.stopPropagation();" class="raw-btn dk-emot emot-depressed"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('mwah'); $event.stopPropagation();" class="raw-btn dk-emot emot-mwah"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('singing'); $event.stopPropagation();" class="raw-btn dk-emot emot-singing"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('batman'); $event.stopPropagation();" class="raw-btn dk-emot emot-batman"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ninja'); $event.stopPropagation();" class="raw-btn dk-emot emot-ninja"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('light_bulb'); $event.stopPropagation();" class="raw-btn dk-emot emot-light_bulb"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('fire'); $event.stopPropagation();" class="raw-btn dk-emot emot-fire"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('torch'); $event.stopPropagation();" class="raw-btn dk-emot emot-torch"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sushi1'); $event.stopPropagation();" class="raw-btn dk-emot emot-sushi1"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('sushi2'); $event.stopPropagation();" class="raw-btn dk-emot emot-sushi2"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('phone'); $event.stopPropagation();" class="raw-btn dk-emot emot-phone"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('knife'); $event.stopPropagation();" class="raw-btn dk-emot emot-knife"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('key'); $event.stopPropagation();" class="raw-btn dk-emot emot-key"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('angrymark'); $event.stopPropagation();" class="raw-btn dk-emot emot-angrymark"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('bomb'); $event.stopPropagation();" class="raw-btn dk-emot emot-bomb"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('mapleleaf'); $event.stopPropagation();" class="raw-btn dk-emot emot-mapleleaf"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('zzz'); $event.stopPropagation();" class="raw-btn dk-emot emot-zzz"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('guitar'); $event.stopPropagation();" class="raw-btn dk-emot emot-guitar"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('trumpet'); $event.stopPropagation();" class="raw-btn dk-emot emot-trumpet"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('hammer'); $event.stopPropagation();" class="raw-btn dk-emot emot-hammer"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('dice'); $event.stopPropagation();" class="raw-btn dk-emot emot-dice"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('console'); $event.stopPropagation();" class="raw-btn dk-emot emot-console"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('lantern'); $event.stopPropagation();" class="raw-btn dk-emot emot-lantern"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('microphone'); $event.stopPropagation();" class="raw-btn dk-emot emot-microphone"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('tape'); $event.stopPropagation();" class="raw-btn dk-emot emot-tape"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('speaker'); $event.stopPropagation();" class="raw-btn dk-emot emot-speaker"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('video'); $event.stopPropagation();" class="raw-btn dk-emot emot-video"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('TV'); $event.stopPropagation();" class="raw-btn dk-emot emot-TV"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('wrench'); $event.stopPropagation();" class="raw-btn dk-emot emot-wrench"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('lock'); $event.stopPropagation();" class="raw-btn dk-emot emot-lock"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('paperclip'); $event.stopPropagation();" class="raw-btn dk-emot emot-paperclip"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('skull'); $event.stopPropagation();" class="raw-btn dk-emot emot-skull"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('ghost'); $event.stopPropagation();" class="raw-btn dk-emot emot-ghost"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('paw'); $event.stopPropagation();" class="raw-btn dk-emot emot-paw"></button></li>
					  <li ng-click="$event.stopPropagation();"><button ng-click="insertEmotion('darkish-logo'); $event.stopPropagation();" class="raw-btn dk-emot emot-darkish-logo"></button></li>
		                    
				  </ul>
				</div>
				<hr/>
				<div ng-show="groupMessageApprove" style="display: table;width: 100%;">
					<div style="background: white; padding: 10px 5px; border-radius: 4px;" class="col col-xs-12" ng-bind-html="getTrustedMessage(groupText)">

					</div>
					<button class="col col-xs-6 col-sm-2 btn btn-danger btn-sm" ng-click="cancelGroupMessage()">انصراف</button>
					<button class="col col-xs-6 col-sm-2 btn btn-success btn-sm" ng-click="submitGroupMessage()">ارسال</button>
				</div>	
			</form>
			
		</div>
		
	</div>
</div>

