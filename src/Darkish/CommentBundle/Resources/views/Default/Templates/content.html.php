<div class="comments">
	<div class="media comment" ng-repeat="comment in SearchService.comments">
		<div class="row">
			<div class="right col-lg-2 col-md-2 col-sm-2 col-xs-2">
				<div class="owner-photo">
					<i ng-hide="comment.comment.owner.photo.icon_absolute_path" class="fa fa-user"></i>
					<img ng-show="comment.comment.owner.photo.icon_absolute_path" ng-src="{{comment.comment.owner.photo.icon_absolute_path}}"  />
				</div>
				<div class="owner-username">
					<span ng-bind="comment.comment.owner.username"></span>
				</div>
			</div>
			<div class="center col-lg-8 col-md-8 col-sm-8 col-xs-8" ng-class="{'pending': (comment.comment.state==3)}">
				<div class="row">
					<div class="body col col-lg-12 col-md-12 col-sm-12 col-xs-12">
						{{comment.comment.body}}
						<hr class="divider" />
					</div>

					<div class="datetime col col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<span am-time-ago="comment.comment.created_at"></span>
					</div>
					<div class="operations col col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<button ng-click="collapse(comment)" type="button" class="btn btn-success btn-xs">پاسخ</button>
						<button type="button" ng-click="like(comment)" class="btn btn-info btn-xs">
							{{comment.comment.like_count}}
							<i class="fa fa-thumbs-up fa-flip-horizontal"></i>
							
						</button>
						<div class="btn-group">
							<button ng-disabled="comment.comment.claim_type" type="button" class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
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
					#{{comment.comment.id}}
				</span>
				<span class="entity-title">
					{{currentState()}}: {{comment.comment.thread.target.title}}
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
				<div ng-show="comment.comment.claim_type" class="btn-group">
				    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				    	رفع شکایت <span class="caret"></span>
				    </button>
				    <ul class="dropdown-menu dropdown-menu-left" role="menu">
				    	<li role="presentation" class="dropdown-header">آیا از رفع شکایت اطمینان دارید؟</li>
					    <li role="menuitem"><a ng-click="clearClaim(comment)">بله</a></li>
				    </ul>
				</div>
				<div ng-show="comment.comment.state == 3" class="btn-group">
				    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				    	تایید <span class="caret"></span>
				    </button>
				    <ul class="dropdown-menu dropdown-menu-left" role="menu">
				    	<li role="presentation" class="dropdown-header">آیا از تایید اطمینان دارید؟</li>
					    <li role="menuitem"><a ng-click="setState(comment, 0)">بله</a></li>
				    </ul>
				</div>
				<span ng-show="comment.comment.claim_type" class="claim-type">
					شکایت: {{claimTypes[comment.comment.claim_type-1].label}}
				</span>
			</div>
			<div collapse="collapsed.comment.id != comment.comment.id" class="center-foot reply col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
								<i ng-hide="child.comment.owner.photo.icon_absolute_path" class="fa fa-user"></i>
								<img ng-show="child.comment.owner.photo.icon_absolute_path" ng-src="{{child.comment.owner.photo.icon_absolute_path}}"  />
							</div>
							<div class="owner-username">
								<span ng-bind="child.comment.owner.username"></span>
							</div>
						</div>
						<div class="center col-lg-6 col-md-6 col-sm-6 col-xs-6" ng-class="{'pending': (child.comment.state==3)}">
							<div class="row">
								<div class="body col col-lg-12 col-md-12 col-sm-12 col-xs-12">
									{{child.comment.body}}
									<hr class="divider" />
								</div>

								<div class="datetime col col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<span am-time-ago="child.comment.created_at"></span>
								</div>
								<div class="operations col col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<button type="button" ng-click="like(child)" class="btn btn-info btn-xs">
										{{child.comment.like_count}}
										<i class="fa fa-thumbs-up fa-flip-horizontal"></i>
										
									</button>
									<div class="btn-group">
									    <button ng-disabled="child.comment.claim_type" type="button" class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
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
								#{{child.comment.id}}
							</span>
							<span class="entity-title">
								{{currentState()}}: {{child.comment.thread.target.title}}
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

							<div ng-show="child.comment.claim_type" class="btn-group">
							    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							    	رفع شکایت <span class="caret"></span>
							    </button>
							    <ul class="dropdown-menu dropdown-menu-left" role="menu">
							    	<li role="presentation" class="dropdown-header">آیا از رفع شکایت اطمینان دارید؟</li>
								    <li role="menuitem"><a ng-click="clearClaim(child)">بله</a></li>
							    </ul>
							</div>

							<div ng-show="child.comment.state == 3" class="btn-group">
							    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							    	تایید <span class="caret"></span>
							    </button>
							    <ul class="dropdown-menu dropdown-menu-left" role="menu">
							    	<li role="presentation" class="dropdown-header">آیا از تایید اطمینان دارید؟</li>
								    <li role="menuitem"><a ng-click="setState(child, 0)">بله</a></li>
							    </ul>
							</div>

							<span ng-show="child.comment.claim_type" class="claim-type">
								شکایت: {{claimTypes[child.comment.claim_type-1].label}}
							</span>
						</div>	
						
					</div>
					<hr class="divider" />
				</div>
			</div>
		</div>
		<hr class="comment-divider" />
	</div>
</div>



<script type="text/ng-template" id="comment-form.html" >
	<label for="comment-body">متن پاسخ</label>
	<textarea id="comment-body" class="form-control" ng-model="commentBody" rows="3"></textarea>
  
	<button type="submit" ng-click="reply(commentBody);commentBody=''" class="btn btn-default">ارسال</button>
</script>

