<div class="well database-details details-inner">
	<a ng-hide="submitCommentForm" ng-click="submitCommentForm = true">+ ارسال نظر</a>
	<div class="submit-comment-form" ng-show="submitCommentForm">
		<textarea maxlength="3000" class="form-control" ng-model="newComment.body"></textarea>
		<div class="btn-group btn-group-sm submit-btn-group">
			<button class="btn btn-danger " ng-click="submitCommentForm = false" >انصراف</button>
			<button ng-disabled="!newComment.body" ng-click="postNewComment()" class="btn btn-success">ارسال</button>
		</div>
		<label ng-disabled="newComment.photos.length >= 3" class="btn btn-info btn-sm upload-label">
			انتخاب فایل
			<input type="file" ng-show="false" nv-file-select="" uploader="uploader" multiple  /><br/>
		</label>
		<div class="progress" style="">
            <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
        </div>
        <hr ng-show="newComment.photos"/>
        <div class="row" ng-show="newComment.photos">
        	<div class="col col-xs-12 col-sm-6 col-md-3" ng-repeat="photo in newComment.photos">
        		<div class="image-thumb">
            		<img ng-src="{{photo.icon_absolute_path}}" />
            		<button class="thumbnail-remove btn btn-danger btn-xs" ng-click="removePhoto($index)"><div class="dk icon-remove"></div></button>
        		</div>
        	</div>
        </div>
	</div>
	<ul class="comments-list" ng-show="comments.length > 0">
		<li ng-repeat="comment in comments" class="comment-item">
			<div ng-include="'customer/template/comments-item.html'" ng-controller="CommentsItemCtrl" onload=""></div>
		</li>
	</ul>
	<div ng-show="comments.length <= 0" class="no-result" ng-bind="noResultMessage">

	</div>
	<a ng-show="canLoadMore" ng-click="loadMore()">نمایش نظرات بیشتر</a>
</div>