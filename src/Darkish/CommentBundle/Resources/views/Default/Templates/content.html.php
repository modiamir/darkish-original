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
			<div class="center col-lg-10 col-md-10 col-sm-10 col-xs-10">
				<div class="row">
					<div class="center-right col-lg-10 col-md-10 col-sm-10 col-xs-10">
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
								<button type="button" class="btn btn-info btn-xs">
									{{comment.comment.like_count}}
									<i class="fa fa-thumbs-up fa-flip-horizontal"></i>
									
								</button>
								<div class="btn-group">
									<button type="button" class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								    	شکایت <span class="caret"></span>
								    </button>
							        <ul class="dropdown-menu" role="menu">
							    	    <li ng-repeat="claimType in claimTypes"><a>{{claimType.label}}</a></li>
							        </ul>
							    </div>
							</div>
						</div>
					</div>
					<div class="center-left col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<div class="btn-group">
						    <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						    	حذف <span class="caret"></span>
						    </button>
						    <ul class="dropdown-menu dropdown-menu-left" role="menu">
						    	<li role="presentation" class="dropdown-header">آیا از حذف اطمینان دارید؟</li>
							    <li role="menuitem"><a ng-click="remove(comment, SearchService.comments, $index)">بله</a></li>
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
						<hr/>
						<div class="media comment" ng-repeat="child in comment.children">
							<div class="row">
								<div class="right col-lg-2 col-md-2 col-sm-2 col-xs-2">
									<div class="owner-photo">
										<i ng-hide="child.comment.owner.photo.icon_absolute_path" class="fa fa-user"></i>
										<img ng-show="child.comment.owner.photo.icon_absolute_path" ng-src="{{child.comment.owner.photo.icon_absolute_path}}"  />
									</div>
									<div class="owner-username">
										<span ng-bind="child.comment.owner.username"></span>
									</div>
								</div>
								<div class="center col-lg-10 col-md-10 col-sm-10 col-xs-10">
									<div class="row">
										<div class="center-right col-lg-10 col-md-10 col-sm-10 col-xs-10">
											<div class="row">
												<div class="body col col-lg-12 col-md-12 col-sm-12 col-xs-12">
													{{child.comment.body}}
													<hr class="divider" />
												</div>

												<div class="datetime col col-lg-6 col-md-6 col-sm-6 col-xs-6">
													<span am-time-ago="child.comment.created_at"></span>
												</div>
												<div class="operations col col-lg-6 col-md-6 col-sm-6 col-xs-6">
													<button type="button" class="btn btn-info btn-xs">
														{{child.comment.like_count}}
														<i class="fa fa-thumbs-up fa-flip-horizontal"></i>
														
													</button>
													<div class="btn-group">
													    <button type="button" class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
													    	شکایت <span class="caret"></span>
													    </button>
													    <ul class="dropdown-menu" role="menu">
														    <li ng-repeat="claimType in claimTypes"><a>{{claimType.label}}</a></li>
													    </ul>
													</div>
												</div>
											</div>
										</div>
										<div class="center-left col-lg-2 col-md-2 col-sm-2 col-xs-2">
											<div class="btn-group">
											    <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											    	حذف <span class="caret"></span>
											    </button>
											    <ul class="dropdown-menu dropdown-menu-left" role="menu">
											    	<li role="presentation" class="dropdown-header">آیا از حذف اطمینان دارید؟</li>
												    <li role="menuitem"><a ng-click="remove(child,comment.children, $index)">بله</a></li>
											    </ul>
											</div>
											<span ng-show="child.comment.claim_type" class="claim-type">
												شکایت: {{claimTypes[child.comment.claim_type-1].label}}
											</span>
										</div>	
									</div>
									
									
								</div>
								
							</div>
							<hr class="divider" />
						</div>
					</div>	
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

