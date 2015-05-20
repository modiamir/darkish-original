<div class="well database-details details-inner">
	<ul class="comments-list" ng-show="comments.length > 0">
		<li ng-repeat="comment in comments" class="comment-item">
			<div ng-include="'customer/template/comments-item.html'" ng-controller="CommentsItemCtrl" onload=""></div>
		</li>

	</ul>
	<div ng-show="comments.length <= 0" class="no-result" ng-bind="noResultMessage">

	</div>
	<a ng-show="canLoadMore" ng-click="loadMore()">نمایش نظرات بیشتر</a>
</div>