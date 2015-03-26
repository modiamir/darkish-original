var commentApp = angular.module('commentApp', 
	[
		'ui.router', 
		'ui.bootstrap',
		'oitozero.ngSweetAlert',
		'angularMoment',
		'ui.bootstrap.dropdown',
		'angucomplete-alt',
		'treeControl'
	]
);

commentApp.run(function(amMoment) {
    amMoment.changeLocale('fa');
});


commentApp.config(function($stateProvider, $urlRouterProvider){
   $urlRouterProvider.otherwise("/type/forum");

   $stateProvider
    .state('default', {
      url: "/type/:type",
      views: {
      	'current-state': {
      		templateProvider: function ($stateParams) {
      			$currentState = "";

  		        switch($stateParams.type) {
      		      	case 'record':
      		      		$currentState = 'رکورد';
      		      		break;
  		      		case 'news':
      		      		$currentState = 'اخبار';
      		      		break;
  		      		case 'safarsaz':
  		      			$currentState = 'سفرساز';
  		      			break;
	      			case 'forum':
      		      		$currentState = 'تالار گفتگو';
      		      		break;
      		    }

      		    return '<h4 style="margin:0; line-height: 34px;">'+$currentState +'</h4>';
      		    
      		}
      	},
      	'sidebar': {
      		templateUrl: 'comment/template/sidebar.html',
      		controller: 'sidebarCtrl'

      	},
      	'content': {
      		controller: 'contentCtrl',
      		templateUrl: 'comment/template/content.html'
      	}
      }
    });
});

commentApp.value('globalValues', {});

commentApp.controller('commentIndexCtrl', [
	'$scope',
	'$interval',
	'$state',
	'SearchService',
	'$stateParams',
	'globalValues',
	'$http',
	function(
		$scope,
		$interval,
		$state,
		SearchService,
		$stateParams,
		globalValues,
		$http
	)
	{
		
		$interval(function(){
            $scope.loaded = true;
        }, 3000);
        $scope.operators = [];
        $scope.SearchService = SearchService;
        $scope.globalValues = globalValues;
        $scope.test = function() {
        	console.log(globalValues);
        }
        $scope.currentState = function() {
	        switch($stateParams.type) {
		      	case 'record':
		      		return 'رکورد';
		      		break;
	      		case 'news':
		      		return 'خبر';
		      		break;
	      		case 'safarsaz':
	      			return 'سفرساز';
	      			break;
				case 'forum':
		      		return 'تالار گفتگو';
		      		break;
		    }
        }

        $scope.isCommentable = function(entity) {
        	switch($stateParams.type) {
		      	case 'record':
		      		if(entity.commentable) {return true; } else {return false;}
		      		break;
	      		case 'news':
		      		if(entity.commentable) {return true; } else {return false;}
		      		break;
	      		case 'safarsaz':
	      			return true;
	      			break;
				case 'forum':
		      		return true;
		      		break;
		    }	
        	return true;
        }

        
        $scope.searchByFilter = function(filter) {
        	$scope.SearchService.searchCriteria = {
				type: $stateParams.type,
				filter: filter,
				keywordType: null,
				keyword: null,
				sort: {
					date: 'DESC'
				}
			}
			globalValues.currentEntity = null;
        	$scope.SearchService.search();
        }

        $scope.searchByKeyword = function(keywordType, keyword) {
        	$scope.SearchService.searchCriteria = {
				type: $stateParams.type,
				filter: 'all',
				keywordType: keywordType,
				keyword: keyword,
				sort: {
					date: 'DESC'
				}
			}
			globalValues.currentEntity = null;
        	$scope.SearchService.search();	

        }

        $scope.postComment = function(body) {
        	
			var data = {};
			data.body = body;
			$http({
                method: "post",
                url: "comment/ajax/post_comment/"+ $stateParams.type+'/'+globalValues.currentEntity.id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({_method: 'POST', darkish_commentbundle_comment: data})
            }).then(
            	function(response){
            		SearchService.comments.unshift(response.data);
            		SearchService.count = (SearchService.count)? SearchService.count+1 : 1;
            	}, 
            	function(errResponse){
            		console.log(errResponse.data);
            	}
        	);
			
		}
	}
]);



commentApp.controller('sidebarCtrl', [
	'$scope',
	'$stateParams',
	'$state', 
	'globalValues',
	'SearchService',
	'$http',
	function(
		$scope,
		$stateParams,
		$state,
		globalValues,
		SearchService,
		$http
	){
		$scope.stateParams = $stateParams;
		$scope.selectEntityCallback = function(selected) {

			globalValues.currentEntity = selected.originalObject;
			$scope.$broadcast('angucomplete-alt:clearInput');
			SearchService.getEntityComments($stateParams.type, selected.originalObject);

		}

		$scope.selectForumTreeEntity = function(selected) {
			globalValues.currentEntity = selected;
			SearchService.getEntityComments($stateParams.type, selected);			
		}

		$scope.forumTreeOptions = {
		    nodeChildren: "children",
		    dirSelectable: true,
		    injectClasses: {
		        ul: "a1",
		        li: "a2",
		        liSelected: "a7",
		        iExpanded: "a3",
		        iCollapsed: "a4",
		        iLeaf: "a5",
		        label: "a6",
		        labelSelected: "a8"
		    }
		}
		$scope.forumTrees =	[];

		$http.get('comment/ajax/get_forum_tree').then(
			function(response){
				$scope.forumTrees = response.data;
			}, 
			function(errResponse){
				console.log(errResponse);
			});
	}
])



commentApp.controller('contentCtrl', [
	'$scope',
	'$stateParams',
	'$state', 
	'SearchService',
	'$log',
	'$http',
	function(
		$scope,
		$stateParams,
		$state,
		SearchService,
		$log,
		$http
	){

		$scope.SearchService = SearchService;
		if($state.current.name == 'default') {
			$scope.SearchService.searchCriteria = {
				type: $stateParams.type,
				filter: 'all',
				keywordType: null,
				keyword: null,
				sort: {
					date: 'DESC'
				}
			}
			$scope.SearchService.search();	
		}


		$scope.claimTypes = [
			{
				id: 1,
				label: 'نوع یک'
			},
			{
				id: 2,
				label: 'نوع دو'
			},
			{
				id: 3,
				label: 'نوع سه'
			}
		];

		$http.get('comment/ajax/get_claim_types').then(function(response){
			$scope.claimTypes = response.data;
		});
		
		$scope.collapsed = 0;
		
		$scope.collapse = function(comment){
			if($scope.collapsed != comment) {
				// $http.get('comment/ajax/csrf').then(
				// 	function(response){
				// 		$scope.csrf = response.data;
				// 		$scope.collapsed = comment.comment.id;	
				// 	}, 
				// 	function(errResponse){
				// 		console.log(errResponse.data);
				// 		$scope.collapsed = 0;
				// 	});
				
				$scope.collapsed = comment;	
				// $scope.commentBody = "";
				
			} else {
				$scope.collapsed = 0;
			}
			
		}

		$scope.reply = function(body) {
			var data = {};
			data.body = body;
			$http({
                method: "post",
                url: "comment/ajax/reply/"+$scope.collapsed.comment.thread.id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({_method: 'POST', parentId: $scope.collapsed.comment.id, darkish_commentbundle_comment: data})
            }).then(
            	function(response){
            		$scope.collapsed.children.unshift(response.data);
            	}, 
            	function(errResponse){
            		console.log(errResponse.data);
            	}
        	);
			
		}


		$scope.like = function(comment) {
			$http({
	            method: "post",
	            url: "comment/ajax/like/"+comment.comment.id,
	            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
	            data: $.param({_method: 'POST'})
	        }).then(
	        	function(response){
	        		if(comment.comment.like_count && comment.comment.like_count > 0) {
	        			comment.comment.like_count = comment.comment.like_count +  1;
	        		} else {
	        			comment.comment.like_count = 1;
	        		}
	        	}, 
	        	function(errResponse){
	        		console.log(errResponse.data);
	        	}
	    	);
		}


		$scope.setClaim = function(comment, claimType) {
			$http({
	            method: "put",
	            url: "comment/ajax/set_claim/"+comment.comment.id+'/'+claimType.id,
	            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
	            data: $.param({_method: 'PUT'})
	        }).then(
	        	function(response){
	        		comment.comment.claim_type = claimType.id;
	        	}, 
	        	function(errResponse){
	        		console.log(errResponse.data);
	        	}
	    	);
		}

		$scope.setState = function(comment, state) {
			$http({
	            method: "put",
	            url: "comment/ajax/set_state/"+comment.comment.id+'/'+state,
	            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
	            data: $.param({_method: 'PUT'})
	        }).then(
	        	function(response){
	        		comment.comment.state = state;
	        	}, 
	        	function(errResponse){
	        		console.log(errResponse.data);
	        	}
	    	);
		}


		$scope.clearClaim = function(comment) {
			$http({
	            method: "put",
	            url: "comment/ajax/clear_claim/"+comment.comment.id,
	            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
	            data: $.param({_method: 'PUT'})
	        }).then(
	        	function(response){
	        		comment.comment.claim_type = 0;
	        	}, 
	        	function(errResponse){
	        		console.log(errResponse.data);
	        	}
	    	);
		}
		
		$scope.remove = function(comment, array, index) {
			$http({
	            method: "put",
	            url: "comment/ajax/delete/"+comment.comment.id,
	            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
	            data: $.param({_method: 'PUT'})
	        }).then(
	        	function(response){
	        		array.splice(index,1);
	        	}, 
	        	function(errResponse){
	        		console.log(errResponse.data);
	        	}
	    	);
		}

	}
])

commentApp.factory('SearchService', [
	'$state',
	'$http',
	function(
		$state,
		$http
	){
		var self = {};
		self.searchCriteria = {
			type: 'forum',
			filter: 'all',
			keywordType: 'text',
			keyword: '',
			sort: {
				date: 'DESC'
			}
		}
		self.comments = [];
		self.count = 0;
		self.search = function(contin) {
			if(contin == true) {
				self.count = 0;	
			} 
			$http.get('comment/ajax/search/'+self.searchCriteria.type+'/'+self.searchCriteria.filter+
				'/'+self.searchCriteria.keywordType+'/'+self.searchCriteria.keyword
			 ).then(
				function(response){
					var result = response.data;
					self.comments = result.comments;
					self.count = self.count + result.count;
				}, 
				function(errResponse){

				}
			);

			
		}

		self.getEntityComments = function(type, entity) {
			$http.get('comment/ajax/get_entity_comments/'+type+'/'+entity.id).then(
				function(response){
					var result = response.data;
					self.comments = result.comments;
					self.count = self.count + result.count;
				},
				function(errResponse){

				});
		}
		return self;
}]);