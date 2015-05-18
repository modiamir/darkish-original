<div class="row page comments-page">
	<div class="col col-xs-12 comments details">
		<div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">
			<div class="btn-group btn-tabs">
				<button class="btn btn-info" ui-sref="comments.all" ng-class="{'active': isAllPage()}">همه نظرات</button>
				<button class="btn btn-default" ui-sref="comments.news" ng-class="{'active': isNewsPage()}">نظرات جدید</button>
			</div>
		</div>
		<div ui-view></div>
	</div>
</div>
