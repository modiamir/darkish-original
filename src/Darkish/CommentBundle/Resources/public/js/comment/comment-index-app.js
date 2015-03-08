var commentApp = angular.module('commentApp', 
	[
		'ui.router', 
		'ui.bootstrap',
		'oitozero.ngSweetAlert',
		'angularMoment',
		'ui.bootstrap.dropdown',
		'angucomplete-alt'
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
	function(
		$scope,
		$interval,
		$state,
		SearchService,
		$stateParams,
		globalValues
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
	}
]);



commentApp.controller('sidebarCtrl', [
	'$scope',
	'$stateParams',
	'$state', 
	'globalValues',
	'SearchService',
	function(
		$scope,
		$stateParams,
		$state,
		globalValues,
		SearchService
	){
		$scope.stateParams = $stateParams;
		$scope.selectEntityCallback = function(selected) {
			globalValues.currentEntity = selected.originalObject;
			$scope.$broadcast('angucomplete-alt:clearInput');
			SearchService.getEntityComments($stateParams.type, selected.originalObject);

		}
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