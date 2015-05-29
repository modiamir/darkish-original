customerApp.controller('CommentsCtrl', ['$scope', '$http', '$state', '$filter', 
	function($scope, $http, $state, $filter){
	$scope.isAllPage = function() {
		return $state.current.name == 'comments.all';
	}

	$scope.isNewsPage = function() {
		return $state.current.name == 'comments.news';
	}
	
	$scope.search = function(news, comments) {
		var postData = {_method: 'POST'};
		if(news) {
			postData.news = true;
		}

		var commentsCount = comments.length;
		var lowestId = (commentsCount) ? comments[commentsCount - 1].id : 0;

		return $http({
			method: 'POST',
			url: './customer/ajax/comment/search/'+lowestId,
			headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
			data: $.param(postData)
		});
	}

	$scope.claimTypes = [];
	$http.get('./customer/ajax/comment/get_claim_types').then(
		function(response){
			$scope.claimTypes = response.data;
		}, 
		function(responseErr){}
	);

	$scope.setUnseenByCustomers = function(comments) {
		var unseenComments = $filter('filter')(comments, {unseen_by_customers: true});
		if(unseenComments.length > 0) {
			var unseenCommentsIds = [];
			angular.forEach(unseenComments, function(value, key){
				unseenCommentsIds.push(value.id);
			});
			$http({
				method: 'POST',
				url: './customer/ajax/comment/set_unseen_by_customer',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
				data: $.param({_method: 'POST', comments: unseenCommentsIds})
			}).then(
				function(response){

				}, 
				function(responseErr){

				}
			)
		}

	}


    

}])

customerApp.controller('CommentsAllCtrl', ['$scope', '$http', 'FileUploader', function($scope, $http, FileUploader){
	$scope.comments = [];
	$scope.noResultMessage = "در حال دریافت ..."
	$scope.canLoadMore = false;
	$scope.newComment = {};
	$scope.search(false, $scope.comments).then(
		function(response){
			$scope.comments = $scope.comments.concat(response.data.comments);
			$scope.setUnseenByCustomers(response.data.comments);
			$scope.noResultMessage = "نظری جهت نمایش موجود نیست.";
			if(response.data.comments.length > 0) {
				$scope.canLoadMore = true;
			}
		}, 
		function(responseErr){

		} 
	);

	$scope.loadMore = function() {
		$scope.search(false, $scope.comments).then(
			function(response){
				$scope.comments = $scope.comments.concat(response.data.comments);
				$scope.setUnseenByCustomers(response.data.comments);
				$scope.noResultMessage = "نظری جهت نمایش موجود نیست.";
				if(response.data.comments.length <= 0) {
					$scope.canLoadMore = false;
				}
			}, 
			function(responseErr){

			} 
		);
	}


	$scope.postNewComment = function() {
		$http({
			method: 'POST',
			url: 'customer/ajax/comment/post',
			headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
			data: $.param({
				_method: 'POST', 
				darkish_commentbundle_comment: {body: $scope.newComment.body},
				photos: $scope.newComment.photos
			})
		}).then(
			function(response){
				$scope.comments.unshift(response.data);
				$scope.newComment = {}
				$scope.submitCommentForm = false;
			}, 
			function(responseErr){

			}
		);
	}

    /**
     * 
     * uploader
     */
    var uploader = $scope.uploader = new FileUploader({
        url: './customer/ajax/upload'
    });
    uploader.withCredentials = true;
    
    uploader.queueLimit = 3;

    uploader.autoUpload = true;
    uploader.removeAfterUpload = true;
    uploader.formData.push({uploadDir : 'image'});
    uploader.formData.push({continual : true});
    uploader.formData.push({type : 'comment'});
    uploader.msg = "";
    
    // FILTERS
    $scope.logUploader = function() {
      console.log(uploader);
    }

    uploader.filters.push({
        name: 'imageFilter',
        fn: function(item /*{File|FileLikeObject}*/, options) {
            var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
            return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
        }
    });

    uploader.filters.push({
          name: 'photoLimits',
          fn: function(item, photo) {
              var photocount = (($scope.newComment.photos) ? $scope.newComment.photos.length : 0) + uploader.queue.length;
              console.log(photocount);
              if( photocount >= 3) {
                return false;
              }
              return true;
          }
      });
    
    
    uploader.onSuccessItem = function(fileItem, response, status, headers) {
        console.info('onSuccessItem', fileItem, response, status, headers);
        if(!$scope.newComment.photos) {
            $scope.newComment.photos = [];
        }
        $scope.newComment.photos.push(response);
        uploader.msg = 'فایل با موفقیت بارگزاری شد.';
    };


  	$scope.removePhoto = function(index) {
    	$scope.newComment.photos.splice(index, 1);
	}
	
}])

customerApp.controller('CommentsNewsCtrl', ['$scope', '$http', function($scope, $http){
	$scope.comments = [];
	$scope.noResultMessage = "در حال دریافت ..."
	$scope.canLoadMore = false;
	$scope.search(true, $scope.comments).then(
		function(response){
			$scope.comments = $scope.comments.concat(response.data.comments);
			$scope.setUnseenByCustomers(response.data.comments);
			$scope.noResultMessage = "نظری جهت نمایش موجود نیست.";
			if(response.data.comments.length > 0) {
				$scope.canLoadMore = true;
			}
		}, 
		function(responseErr){

		} 
	);

	$scope.loadMore = function() {
		$scope.search(true, $scope.comments).then(
			function(response){
				$scope.comments = $scope.comments.concat(response.data.comments);
				$scope.setUnseenByCustomers(response.data.comments);
				$scope.noResultMessage = "نظری جهت نمایش موجود نیست.";
				if(response.data.comments.length <= 0) {
					$scope.canLoadMore = false;
				}
			}, 
			function(responseErr){

			} 
		);
	}
}])

customerApp.controller('CommentsItemCtrl', ['$scope', '$http', '$filter', 'ngDialog', function($scope, $http, $filter, ngDialog){
	$scope.replyForm = false;
	$scope.replyFormDirty = false;
	$scope.comment.children = [];
	$scope.getReplies = function(comment) {
		var childrenCount = comment.children.length;
		var lowestId = (childrenCount) ? comment.children[childrenCount - 1].id : 0;
		$http.get('customer/ajax/comment/replies/'+ comment.id + '/' + lowestId).then(
			function(response) {
				comment.children = comment.children.concat(response.data.comments);
				$scope.replyForm = true;
				var unseenReplies = $filter('filter')(response.data.comments, {unseen_by_customers: true});
				if(unseenReplies.length > 0) {
					var unseenRepliesIds = [];
					angular.forEach(unseenReplies, function(value, key){
						unseenRepliesIds.push(value.id);
					});
					$http({
						method: 'POST',
						url: './customer/ajax/comment/set_unseen_replies_by_customer/'+comment.id,
						headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
						data: $.param({_method: 'POST', comments: unseenRepliesIds})
					}).then(
						function(response){
							comment.unseen_replies_by_customers = 0;
						}, 
						function(responseErr){

						}
					)
				}
			},
			function(responseErr) {

			}
		);
	}

	$scope.openCloseReplies = function(comment) {
		if($scope.replyFormDirty) {
			$scope.replyForm = !$scope.replyForm;
		} else {
			$scope.getReplies(comment);
		}
		$scope.replyFormDirty = true;
	}

	$scope.setClaim = function(comment, claimType) {

		$http({
			method: 'POST',
			url: 'customer/ajax/comment/set_claim/'+comment.id+'/'+claimType.id,
			headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
			data: $.param({_method: 'POST'})
		}).then(
			function(response){
				comment.claim_type = response.data.claim_type;
				comment.state = response.data.state;

			}, 
			function(responseErr){

			}
		);
		
	}

	$scope.reply = function(comment, replyBody) {

		$http({
			method: 'POST',
			url: 'customer/ajax/comment/reply/'+comment.id,
			headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
			data: $.param({_method: 'POST', darkish_commentbundle_comment: {body: replyBody}})
		}).then(
			function(response){
				comment.children.unshift(response.data);
				comment.reply_count = comment.reply_count + 1;
			}, 
			function(responseErr){

			}
		);
	}


	$scope.like = function(comment) {
		$http({
			method: 'POST',
			url: 'customer/ajax/comment/like/'+comment.id,
			headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
			data: $.param({_method: 'POST'})
		}).then(
			function(response){
				comment.like_count = response.data.like_count;
				comment.has_liked = response.data.has_liked;

			}, 
			function(responseErr){

			}
		);
	}


}])

customerApp.controller('CommentsChildCtrl', ['$scope', '$http', function($scope, $http){
}])

