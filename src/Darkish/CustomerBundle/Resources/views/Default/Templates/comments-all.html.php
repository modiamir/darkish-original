<div class="well database-details details-inner">
	<ul class="comments-list">
		<li ng-repeat="comment in comments" class="comment-item">
			<div ng-include="'customer/template/comments-item.html'" ng-controller="CommentsItemCtrl" onload=""></div>
		</li>

	</ul>
</div>