
<div class="row database-page page">
	<div ng-hide="isXSmall() && state.current.name != 'database'" class="col col-xs-12 col-sm-5 col-md-4 col-lg-4 database-list master">
		<div class="well master-buttons" ng-class="{'fixed': isXSmall()}"> 
			<div class="btn-group btn-group-justified">
			  <a ng-disabled="state.current.name != 'database'" class="btn btn-info" ui-sref="database.details">پایگاه داده</a>
			  <a ng-show="!editmode" ng-disabled="state.current.name != 'database'" class="btn btn-default edit-mode" ng-click="editmode= !editmode; collapseFirstGroup()"><div class="dk icon-edit"></div> ویرایش</a>
			  <a ng-show="editmode" ng-disabled="state.current.name != 'database'" class="btn btn-default finish-edit" ng-click="finishEdit()"><div class="dk icon-verify-small"></div>اتمام</a>
			  <a ng-disabled="state.current.name != 'database' || editmode" class="btn btn-default add-item" ui-sref="database.create"><div class="dk icon-add"></div>جدید</a>
			</div>
		</div>
		<div class="master-inner well" ng-class="{'scrollable': !isXSmall()}">
			<div class="database-list">
				<div class="collapsible-search">
					<div class="search-collapse-header" ng-click="isCollapsed = !isCollapsed">
						<div ng-show="isCollapsed" class="dk icon-add"></div>
						<div ng-show="!isCollapsed" class="dk icon-remove"></div>
						<span class="search-label">جستجو</span>
						<div class="dk icon-nav-search"></div>
					</div>
					<div class="search-box" collapse="isCollapsed">
						<div ng-include="searchTemplate()" scope="" onload=""></div>
					</div>
				</div>
				<ul>
					<li ng-repeat="item in items" ng-click="selectItem(item)">
						<div  ng-include="itemListTemplate()" ng-controller="DatabaseItemListCtrl" scope="" onload=""></div>
					</li>
				</ul>
				<div class="loading-more" ng-show="loadingMore">
				loading more ...
				</div>
			</div>

		</div>
		
	</div>

	<div class="col col-xs-12 col-sm-7  col-md-8 col-lg-8 details child-states">
		
		<div ui-view>
		</div>
	</div>
</div>

