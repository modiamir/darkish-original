
<div class="row user-page page">
	<div ng-hide="isXSmall() && state.current.name != 'user'" class="col col-xs-12 col-sm-5 col-md-4 col-lg-4 database-list master">
		<div class="well master-buttons" ng-class="{'fixed': isXSmall()}"> 
			<div class="btn-group btn-group-justified">
			  <a ng-disabled="state.current.name != 'user' || editmode" class="btn btn-default add-item" ui-sref="user.create"><div class="dk icon-add"></div>جدید</a>
			</div>
		</div>
		<div class="master-inner well" ng-class="{'scrollable': !isXSmall()}">
			<div class="user-list">
				<ul>
					<li ng-repeat="user in users" ng-click="selectUser(user)">
						<div  ng-include="'customer/template/user-item-list.html'"></div>
					</li>
				</ul>
			</div>

		</div>
		
	</div>

	<div class="col col-xs-12 col-sm-7  col-md-8 col-lg-8 details child-states">
		
		<div ui-view>
		</div>
	</div>
</div>

