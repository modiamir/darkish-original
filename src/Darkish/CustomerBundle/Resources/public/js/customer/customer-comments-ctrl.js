customerApp.controller('CommentsCtrl', ['$scope', '$http', '$state', function($scope, $http, $state){
	$scope.isAllPage = function() {
		return $state.current.name == 'comments.all';
	}

	$scope.isNewsPage = function() {
		return $state.current.name == 'comments.news';
	}
}])

customerApp.controller('CommentsAllCtrl', ['$scope', '$http', function($scope, $http){
	
}])

customerApp.controller('CommentsNewsCtrl', ['$scope', '$http', function($scope, $http){
	
}])