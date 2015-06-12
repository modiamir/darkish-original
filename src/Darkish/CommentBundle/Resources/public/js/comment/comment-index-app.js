var commentApp = angular.module('commentApp', 
	[
		'ui.router', 
		'ui.bootstrap',
		'oitozero.ngSweetAlert',
		'angularMoment',
		'ui.bootstrap.dropdown',
		'angucomplete-alt',
		'treeControl',
		'angularFileUpload',
		'ngDialog',
		'frapontillo.bootstrap-switch'
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
	'FileUploader',
	'ngDialog',
	function(
		$scope,
		$interval,
		$state,
		SearchService,
		$stateParams,
		globalValues,
		$http,
		FileUploader,
		ngDialog
	)
	{
		
		$interval(function(){
            $scope.loaded = true;
        }, 3000);
        $scope.operators = [];
        $scope.SearchService = SearchService;
        $scope.globalValues = globalValues;

        $scope.newComment = {};

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
				lowestId: 0,
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
				lowestId: 0,
				keywordType: keywordType,
				keyword: keyword,
				sort: {
					date: 'DESC'
				}
			}
			globalValues.currentEntity = null;
        	$scope.SearchService.search();	

        }

        $scope.postComment = function(newComment) {
        	
			var data = {};
			photosIds = [];
			angular.forEach(newComment.photos, function(value, key){
				photosIds.push(value.id);
			});
			$http({
                method: "post",
                url: "comment/ajax/post_comment/"+ $stateParams.type+'/'+globalValues.currentEntity.id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({_method: 'POST', darkish_commentbundle_comment: {body: newComment.body}, photos: photosIds})
            }).then(
            	function(response){
            		SearchService.comments.unshift(response.data.comment);
            		SearchService.count = (SearchService.count)? SearchService.count+1 : 1;
            		$scope.newComment = {};
            		globalValues.currentEntity.form = false;
            	}, 
            	function(errResponse){
            		console.log(errResponse.data);
            	}
        	);
			
		}


		$scope.openPhotoModal = function (photos, index) {
		  ngDialog.open({ 
		    template: 'photo-modal.html',
		    className: 'ngdialog-theme-default custom-width',
		    controller: 'PhotoModalCtrl', 
		    resolve: {
		      photos: function() {
		          return photos;
		      },
		      index: function() {
		        return index;
		      }
		    }
		  });
		};

	    /**
	     * 
	     * uploader
	     */
	    var uploader = $scope.uploader = new FileUploader({
	        url: './managedfile/ajax/upload'
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
	'globalValues',
	function(
		$scope,
		$stateParams,
		$state,
		SearchService,
		$log,
		$http,
		globalValues
	){

		$scope.SearchService = SearchService;
		if($state.current.name == 'default') {
			$scope.SearchService.searchCriteria = {
				type: $stateParams.type,
				filter: 'all',
				lowestId: 0,
				keywordType: null,
				keyword: null,
				sort: {
					date: 'DESC'
				}
			}
			$scope.SearchService.search();	
		}


		$http.get('comment/ajax/get_claim_types').then(function(response){
			$scope.claimTypes = response.data;
		});
		
		

		$scope.loadMore = function() {
			if(!globalValues.currentEntity) {
				$scope.SearchService.searchCriteria.lowestId = SearchService.comments[SearchService.comments.length - 1].id;
				$scope.SearchService.search();
			} else {
				SearchService.getEntityComments($stateParams.type, globalValues.currentEntity, SearchService.comments[SearchService.comments.length - 1].id);
			}
			
		}


	}
])

commentApp.controller('CommentCtrl', [
	'$scope',
	'$stateParams',
	'$state', 
	'SearchService',
	'$log',
	'$http',
	'$timeout',
	function(
		$scope,
		$stateParams,
		$state,
		SearchService,
		$log,
		$http,
		$timeout
	){

		$scope.collapsed = true;
		$scope.expanded = false;

		$scope.collapse = function(){
			$scope.collapsed = !$scope.collapsed;
			if(!$scope.expanded) {
				$scope.expanded = true;
				$http.get('comment/ajax/get_replies/'+$scope.comment.id+'/'+0).then(
					function(response){
						var result = response.data;
						$scope.comment.children = response.data.children;
					}, 
					function(errResponse){

					}
				);
			}
		}
		

		$scope.reply = function(body) {
			var data = {};
			data.body = body;
			$http({
                method: "post",
                url: "comment/ajax/reply/"+$scope.comment.id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({_method: 'POST', parentId: $scope.comment.id, darkish_commentbundle_comment: data})
            }).then(
            	function(response){
            		$scope.comment.children.unshift(response.data);
            	}, 
            	function(errResponse){
            		console.log(errResponse.data);
            	}
        	);
			
		}


		$scope.like = function(comment) {
			$http({
	            method: "post",
	            url: "comment/ajax/like/"+comment.id,
	            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
	            data: $.param({_method: 'POST'})
	        }).then(
	        	function(response){
	        		if(comment.like_count && comment.like_count > 0) {
	        			comment.like_count = comment.like_count +  1;
	        		} else {
	        			comment.like_count = 1;
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
	            url: "comment/ajax/set_claim/"+comment.id+'/'+claimType.id,
	            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
	            data: $.param({_method: 'PUT'})
	        }).then(
	        	function(response){
	        		comment.claim_type = claimType.id;
	        	}, 
	        	function(errResponse){
	        		console.log(errResponse.data);
	        	}
	    	);
		}

		$scope.setState = function(comment, state) {
			$http({
	            method: "put",
	            url: "comment/ajax/set_state/"+comment.id+'/'+state,
	            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
	            data: $.param({_method: 'PUT'})
	        }).then(
	        	function(response){
	        		comment.state = state;
	        	}, 
	        	function(errResponse){
	        		console.log(errResponse.data);
	        	}
	    	);
		}


		$scope.clearClaim = function(comment) {
			$http({
	            method: "put",
	            url: "comment/ajax/clear_claim/"+comment.id,
	            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
	            data: $.param({_method: 'PUT'})
	        }).then(
	        	function(response){
	        		comment.claim_type = 0;
	        	}, 
	        	function(errResponse){
	        		console.log(errResponse.data);
	        	}
	    	);
		}
		
		$scope.remove = function(comment, array, index) {
			$http({
	            method: "put",
	            url: "comment/ajax/delete/"+comment.id,
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
	'globalValues',
	function(
		$state,
		$http,
		globalValues
	){
		var self = {};
		self.searchCriteria = {
			type: 'forum',
			filter: 'all',
			keywordType: 'text',
			lowestId: 0,
			keyword: '',
			sort: {
				date: 'DESC'
			}
		}
		self.comments = [];
		self.count = 0;
		self.search = function(contin) {
			globalValues.currentEntity = null;
			if(contin == true) {
				self.count = 0;	
			} 
			if(!self.searchCriteria.lowestId) {
				self.searchCriteria.lowestId = 0;
				console.log(self.searchCriteria.lowestId);
			}
			$http.get('comment/ajax/search/'+self.searchCriteria.type+'/'+self.searchCriteria.filter+
				'/'+self.searchCriteria.keywordType+'/'+self.searchCriteria.lowestId+'/'+self.searchCriteria.keyword
			 ).then(
				function(response){
					var result = response.data;
					if(self.searchCriteria.lowestId > 0) {
						self.comments = self.comments.concat(result.comments);
					} else {
						self.comments = result.comments;
					}

					self.count = self.count + result.count;
				}, 
				function(errResponse){

				}
			);

			
		}

		self.getEntityComments = function(type, entity, lowestId) {
			if(!lowestId) {
				lowestId = 0;
			}
			$http.get('comment/ajax/get_entity_comments/'+type+'/'+entity.id+'/'+lowestId).then(
				function(response){
					var result = response.data;
					if(lowestId > 0) {
						self.comments = self.comments.concat(result.comments);
					} else  {
						self.comments = result.comments;	
						self.count = self.count + result.count;
					}
					
					
				},
				function(errResponse){

				});
		}

		self.log = function(item) {
			console.log(item);
		}
		return self;
}]);


commentApp.controller('PhotoModalCtrl', ['$scope', '$http', 'photos', 'index', function($scope, $http, photos, index){
  $scope.photos = photos;
  $scope.index = index;


}])