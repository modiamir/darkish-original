customerApp.controller('CommentsCtrl', ['$scope', '$http', '$state', function($scope, $http, $state){
	$scope.isAllPage = function() {
		return $state.current.name == 'comments.all';
	}

	$scope.isNewsPage = function() {
		return $state.current.name == 'comments.news';
	}
	$scope.comments = [];

	$http({
		method: 'POST',
		url: './customer/ajax/comment/search',
		headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
		data: $.param({_method: 'POST'})
	}).then(
		function(response){
			$scope.comments = response.data.comments;
		}, 
		function(responseErr){

		} 
	);

}])

customerApp.controller('CommentsAllCtrl', ['$scope', '$http', function($scope, $http){
	
}])

customerApp.controller('CommentsNewsCtrl', ['$scope', '$http', function($scope, $http){
	
}])

customerApp.controller('CommentsItemCtrl', ['$scope', '$http', function($scope, $http){
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

	$scope.setClaim = function(comment) {

		$http({
			method: 'POST',
			url: 'customer/ajax/comment/set_claim/'+comment.id,
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