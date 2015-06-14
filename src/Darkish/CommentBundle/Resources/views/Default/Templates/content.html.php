<div class="comments">
	<div class="media comment" ng-repeat="cm in SearchService.comments">
		<div ng-init="comment = cm" ng-include="'comment/template/comment.html'" ng-controller="CommentCtrl" scope="" onload=""></div>
		<hr class="comment-divider" />
	</div>
	<button ng-click="loadMore()">بیشتر</button>
</div>



<script type="text/ng-template" id="comment-form.html" >
	<label for="comment-body">متن پاسخ</label>
	<textarea id="comment-body" class="form-control" ng-model="commentBody" rows="3"></textarea>
  
	<button type="submit" ng-click="reply(commentBody);commentBody=''" class="btn btn-default">ارسال</button>
</script>

