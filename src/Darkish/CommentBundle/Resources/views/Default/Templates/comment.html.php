<div class="row">
	<div class="right col-lg-2 col-md-2 col-sm-2 col-xs-2">
		<div class="owner-photo">
			<i ng-hide="comment.owner.photo.icon_absolute_path" class="fa fa-user"></i>
			<img ng-show="comment.owner.photo.icon_absolute_path" ng-src="{{comment.owner.photo.icon_absolute_path}}"  />
		</div>
		<div class="owner-username">
			<span ng-bind="comment.owner.username"></span>
		</div>
	</div>
	<div class="center col-lg-8 col-md-8 col-sm-8 col-xs-8" ng-class="{'pending': (comment.state==3)}">
		<div class="row">
			<div class="body col col-lg-12 col-md-12 col-sm-12 col-xs-12">
				{{comment.body}}
				<hr class="divider" />
			</div>

			<div class="datetime col col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<span am-time-ago="comment.created_at"></span>
			</div>
			<div class="operations col col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<button ng-click="collapse()" type="button" class="btn btn-success btn-xs">پاسخ</button>
				<button type="button" ng-click="like(comment)" class="btn btn-info btn-xs">
					{{comment.like_count}}
					<i class="fa fa-thumbs-up fa-flip-horizontal"></i>
					
				</button>
				<div class="btn-group">
					<button ng-disabled="comment.claim_type" type="button" class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				    	شکایت <span class="caret"></span>
				    </button>
			        <ul class="dropdown-menu" role="menu">
			    	    <li ng-repeat="claimType in claimTypes"><a ng-click="setClaim(comment,claimType)">{{claimType.label}}</a></li>
			        </ul>
			    </div>
			</div>
		</div>
	</div>
	<div class="left col-lg-2 col-md-2 col-sm-2 col-xs-2">
		<span class="comment-number">
			#{{comment.id}}
		</span>
		<span class="entity-title">
			{{currentState()}}: {{comment.thread.target.title}}
		</span>
		<div class="btn-group">
		    <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		    	حذف <span class="caret"></span>
		    </button>
		    <ul class="dropdown-menu dropdown-menu-left" role="menu">
		    	<li role="presentation" class="dropdown-header">آیا از حذف اطمینان دارید؟</li>
			    <li role="menuitem"><a ng-click="remove(comment, SearchService.comments, $index)">بله</a></li>
		    </ul>
		</div>
		<div ng-show="comment.claim_type" class="btn-group">
		    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		    	رفع شکایت <span class="caret"></span>
		    </button>
		    <ul class="dropdown-menu dropdown-menu-left" role="menu">
		    	<li role="presentation" class="dropdown-header">آیا از رفع شکایت اطمینان دارید؟</li>
			    <li role="menuitem"><a ng-click="clearClaim(comment)">بله</a></li>
		    </ul>
		</div>

		<div class="btn-group" role="group" >
			<div  class="btn-group">
			    <button ng-disabled="comment.state == 0 || comment.claim_type" ng-class="{'btn-default': (comment.state == 3), 'btn-success':  (comment.state == 0)}" type="button" class="btn  btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			    	فعال <span class="caret"></span>
			    </button>
			    <ul class="dropdown-menu dropdown-menu-left" role="menu">
			    	<li role="presentation" class="dropdown-header">آیا از تایید اطمینان دارید؟</li>
				    <li role="menuitem"><a ng-click="setState(comment, 0)">بله</a></li>
			    </ul>
			</div>
			<div class="btn-group">
			    <button ng-disabled="comment.state == 3" ng-class="{'btn-danger': (comment.state == 3), 'btn-default':  (comment.state == 0)}"  type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			    	غیر فعال <span class="caret"></span>
			    </button>
			    <ul class="dropdown-menu dropdown-menu-left" role="menu">
			    	<li role="presentation" class="dropdown-header">آیا از عدم تایید اطمینان دارید؟</li>
				    <li role="menuitem"><a ng-click="setState(comment, 3)">بله</a></li>
			    </ul>
			</div>
		</div>
		<div ng-show="comment.owner_type == 'client'" class="send-message">
			<button class="btn btn-default" ng-click="openSendMessageModal(comment)">ارسال پیام</button>
		</div>
		<span ng-show="comment.claim_type" class="claim-type">
			شکایت: {{claimTypes[comment.claim_type-1].label}}
		</span>
		
		
	</div>
	<div class="col col-xs-10 col-xs-offset-2">
		<img ng-click="openPhotoModal(comment.photos, $index)" style="float: right; margin-left: 10px; width: 64px; height:64px;" ng-repeat="photo in comment.photos" ng-src="{{photo.icon_absolute_path}}">
	</div>
	<div collapse="collapsed" class="center-foot reply col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="well well-lg" ng-include="'comment-form.html'" ></div>
	</div>
	<div ng-show="comment.children.length" class="center-bottom children col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="col-xs-10 col-xs-offset-2">
			<hr/>
		</div>
		<div class="media comment" ng-repeat="child in comment.children">
			<div class="row">
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
				</div>
				<div class="right col-lg-2 col-md-2 col-sm-2 col-xs-2">
					<div class="owner-photo">
						<i ng-hide="child.owner.photo.icon_absolute_path" class="fa fa-user"></i>
						<img ng-show="child.owner.photo.icon_absolute_path" ng-src="{{child.owner.photo.icon_absolute_path}}"  />
					</div>
					<div class="owner-username">
						<span ng-bind="child.owner.username"></span>
					</div>
				</div>
				<div class="center col-lg-6 col-md-6 col-sm-6 col-xs-6" ng-class="{'pending': (child.state==3)}">
					<div class="row">
						<div class="body col col-lg-12 col-md-12 col-sm-12 col-xs-12">
							{{child.body}}
							<hr class="divider" />
						</div>

						<div class="datetime col col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<span am-time-ago="child.created_at"></span>
						</div>
						<div class="operations col col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<button type="button" ng-click="like(child)" class="btn btn-info btn-xs">
								{{child.like_count}}
								<i class="fa fa-thumbs-up fa-flip-horizontal"></i>
								
							</button>
							<div class="btn-group">
							    <button ng-disabled="child.claim_type" type="button" class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							    	شکایت <span class="caret"></span>
							    </button>
							    <ul class="dropdown-menu" role="menu">
								    <li ng-repeat="claimType in claimTypes"><a ng-click="setClaim(child,claimType)">{{claimType.label}}</a></li>
							    </ul>
							</div>
						</div>
					</div>
				</div>
				<div class="left col-lg-2 col-md-2 col-sm-2 col-xs-2">
					<span class="comment-number">
						#{{child.id}}
					</span>
					<span class="entity-title">
						{{currentState()}}: {{child.thread.target.title}}
					</span>
					<div class="btn-group">
					    <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					    	حذف <span class="caret"></span>
					    </button>
					    <ul class="dropdown-menu dropdown-menu-left" role="menu">
					    	<li role="presentation" class="dropdown-header">آیا از حذف اطمینان دارید؟</li>
						    <li role="menuitem"><a ng-click="remove(child,comment.children, $index)">بله</a></li>
					    </ul>
					</div>

					<div ng-show="child.claim_type" class="btn-group">
					    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					    	رفع شکایت <span class="caret"></span>
					    </button>
					    <ul class="dropdown-menu dropdown-menu-left" role="menu">
					    	<li role="presentation" class="dropdown-header">آیا از رفع شکایت اطمینان دارید؟</li>
						    <li role="menuitem"><a ng-click="clearClaim(child)">بله</a></li>
					    </ul>
					</div>

					<div ng-show="child.state == 3" class="btn-group">
					    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					    	تایید <span class="caret"></span>
					    </button>
					    <ul class="dropdown-menu dropdown-menu-left" role="menu">
					    	<li role="presentation" class="dropdown-header">آیا از تایید اطمینان دارید؟</li>
						    <li role="menuitem"><a ng-click="setState(child, 0)">بله</a></li>
					    </ul>
					</div>

					<span ng-show="child.claim_type" class="claim-type">
						شکایت: {{claimTypes[child.claim_type-1].label}}
					</span>
				</div>	
				
			</div>
			<hr class="divider" />
		</div>
	</div>
</div>