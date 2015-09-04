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
		'frapontillo.bootstrap-switch',
		'cfp.hotkeys',
		'ngCkeditor'
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
  		      		case 'itinerary':
  		      			$currentState = 'سفرنامه';
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
	'hotkeys',
	'$modal',
	function(
		$scope,
		$interval,
		$state,
		SearchService,
		$stateParams,
		globalValues,
		$http,
		FileUploader,
		ngDialog,
		hotkeys,
		$modal
	)
	{
		

		hotkeys.add({
		    combo: 'shift+alt+m',
		    description: 'This one goes to 11',
		    callback: function() {
		      	messageWindow = window.open("./messagebox", "_blank", "toolbar=no,directories=no, scrollbars=yes, resizable=yes, top=200, left=500, width=550, height=500, location=no, resizable=no");
		      	console.log(messageWindow);
		    }
	  	});

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
	      		case 'itinerary':
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
	      		case 'itinerary':
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

		$scope.bodyEditorOptions = {
            language: 'fa',
            height: '200px',
            uiColor: '#e8ede0',
            extraPlugins: "dragresize,video,templates,dialog,colorbutton,lineheight,halfhr,record,mycustom,tabletools,contextmenu,contextmenu,menu,floatpanel,panel,tableresize,colordialog,dialogadvtab,removeformat",
            line_height:"1;1.1;1.2;1.3;1.4;1.5;1.6;1.7;1.8;1.9;2;",
            contentsLangDirection: 'rtl',
            allowedContent : true,
            stylesSet : 'my_styles',
            colorButton_colors: '008299,2672EC,8C0095,5133AB,AC193D,D24726,008A00,094AB2,FFFFFF,A0A0A0,4B4B4B,F3B200,77B900,2572EB,AD103C,00A3A3,FE7C22,FFFFFF,FFFFFF,FFFFFF,FFFFFF,FFFFFF,FFFFFF,FFFFFF,00A0B1,2E8DEF,A700AE,643EBF,BF1E4B,DC572E,00A600,0A5BC4,DCDCDC,8C8C8C,323232,FFF000,00CA00,3F90FF,FF5757,00F5F5,FE9E3C',
            colorButton_enableMore: true,
            font_names :
            'Arial/Arial, Helvetica, sans-serif;' +
            'Times New Roman/Times New Roman, Times, serif;' +
            'yekan;'+
            'B Mitra;'+
            'B Lotus;'+
            'B Koodak;'+
            'Roya;'+
            'Tahoma;',
            contentsCss : '../../assets/css/ckeditor-body.css',
            smiley_path: CKEDITOR.basePath+'plugins/smiley/images/darkish/',
            smiley_images: ['(smiley).png','(sad).png','(wink).png','(angry).png','(yummi).png','(laugh).png','(surprised).png','(happy).png','(cry).png','(sick).png','(shy).png','(teeth).png','(tongue).png','(money).png','(mad).png','(crazy).png','(confused).png','(depressed).png','(scream).png','(nerd).png','(not_sure).png','(cool).png','(sleeping).png','(Q).png','(!).png','($).png','(burger).png','(coffee).png','(cupcake).png','(airplane).png','(car).png','(cloud).png','(rain).png','(sun).png','(flower).png','(music).png','(fire).png','(koala).png','(ladybug).png','(relax).png','(basketball).png','(soccer).png','(baseball).png','(time).png','(bicycle).png','(clap).png','(run).png','(light_bulb).png'],
            toolbar: [
                
            ],
            toolbarGroups : [
                
            ]
        };


        $scope.openInsertEntityModal = function () {
	        
	        var insertEntityModalInstance = $modal.open({
     		    templateUrl: 'insertEntityModal.html',
     		    controller: 'insertEntityModalCtrl',
     		    size: 'sm',
     		    resolve: {
     		        
     		    },
     		    windowClass: 'reply-modal-window'
     		});

     		insertEntityModalInstance.result.then(
     		function (message) {
     		    
     		}, function () {
     		    
     		});

	        
	    };

	    $scope.openInsertTreeModal = function () {
	        
	        var insertTreeModalInstance = $modal.open({
     		    templateUrl: 'insertTreeModal.html',
     		    controller: 'insertTreeModalCtrl',
     		    size: 'sm',
     		    resolve: {
     		        forumTree: function() {
     		        	return $http.get('comment/ajax/get_forum_tree').then(
							function(response){
								return response.data;
							}, 
							function(errResponse){
								return [];
							}
						);
     		        },
     		        mainTree: function() {
     		        	return $http.get('comment/ajax/get_main_tree').then(
							function(response){
								return response.data;
							}, 
							function(errResponse){
								return [];
							}
						);
     		        },
     		        newsTree: function() {
     		        	return $http.get('comment/ajax/get_news_tree').then(
							function(response){
								return response.data;
							}, 
							function(errResponse){
								return [];
							}
						);
     		        }
     		    },
     		    windowClass: ''
     		});

     		insertTreeModalInstance.result.then(
     		function (message) {
     		    
     		}, function () {
     		    
     		});

	        
	    };


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
	'$modal',
	'$sce',
	function(
		$scope,
		$stateParams,
		$state,
		SearchService,
		$log,
		$http,
		$timeout,
		$modal,
		$sce
	){

		$scope.collapsed = true;
		$scope.expanded = false;
		$scope.canChangeTarget = function() {
			return ($stateParams.type == 'forum')?true:false;
		}
		$scope.trustedBody = function(comment) {
			return $sce.trustAsHtml(comment.body);
		}
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

		$scope.openSendMessageModal = function (comment) {
	        
	        var replyModalInstance = $modal.open({
     		    templateUrl: 'sendMessageModal.html',
     		    controller: 'sendMessageModalCtrl',
     		    size: 'sm',
     		    resolve: {
     		        comment: function(){
     		            return comment;
     		        }
     		    },
     		    windowClass: 'reply-modal-window'
     		});

     		replyModalInstance.result.then(
     		function (message) {
     		    
     		}, function () {
     		    
     		});

	        
	    };

	    $scope.openChangeTreeModal = function (comment) {
	        
	        var changeTreeModalInstance = $modal.open({
     		    templateUrl: 'changeTreeModal.html',
     		    controller: 'changeTreeModalCtrl',
     		    size: 'sm',
     		    resolve: {
     		        forumTree: function() {
     		        	return $http.get('comment/ajax/get_forum_tree').then(
							function(response){
								return response.data;
							}, 
							function(errResponse){
								return [];
							}
						);
     		        },
     		        comment: function() {
     		        	return comment;
     		        }
     		    }
     		});

     		changeTreeModalInstance.result.then(
     		function (message) {
     		    
     		}, function () {
     		    
     		});

	        
	    };

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

commentApp.controller('sendMessageModalCtrl', ['$scope', '$http', '$modalInstance', '$modal', 'comment', function($scope, $http, $modalInstance, $modal, comment){
		
		$scope.reply = function(body) {
			if(body.length > 0) {
				$http({
					method: "PUT",
					url: './comment/ajax/send_message/'+comment.id,
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param({body: body, _method:"PUT"})
				}).then(
					function(response){
						$modalInstance.close(response.data);
					}, 
					function(responseErr){
						alert('پاسخ ارسال نشد.')
					}
				);
			}
		}

		$scope.dismiss = function() {
			$modalInstance.dismiss();
		}
}])


commentApp.controller('insertEntityModalCtrl', ['$scope', '$http', '$modalInstance', '$modal', function($scope, $http, $modalInstance, $modal){
		
		var CkInstance = null;
        angular.forEach(CKEDITOR.instances,function(value, key){CkInstance = value; keepGoing = false;})
        
        $scope.insertRecord = function(record) {
            var text = ($scope.text) ? $scope.text : record.originalObject.title;
            console.log($scope.currentBodyTreeNode);
            CkInstance.insertHtml('<a href="#" class="body inner-link " record-id="'+record.originalObject.record_number+'">'+text+'</a>');
            $scope.dismiss();
        }
        $scope.insertNews = function(news) {
            var text = ($scope.text) ? $scope.text : news.originalObject.title;
            console.log($scope.currentBodyTreeNode);
            CkInstance.insertHtml('<a href="#" class="body inner-link " news-id="N'+news.originalObject.id+'">'+text+'</a>');
            $scope.dismiss();
        }

		$scope.dismiss = function() {
			$modalInstance.dismiss();
		}
}])

commentApp.controller('insertTreeModalCtrl', ['$scope', '$http', '$modalInstance', '$modal', 'forumTree', 'mainTree', 'newsTree', function($scope, $http, $modalInstance, $modal, forumTree, mainTree, newsTree){
		
		var CkInstance = null;
        angular.forEach(CKEDITOR.instances,function(value, key){CkInstance = value; keepGoing = false;})
		$scope.forumTree = forumTree;
		$scope.mainTree = mainTree;
		$scope.newsTree = newsTree;
        $scope.treeOptions = {
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

		$scope.insertForumTree = function() {
            
            CkInstance.insertHtml('<a href="#" class="body inner-link " forum-tree-index="'+$scope.selectedForumTree.treeIndex+'">'+$scope.selectedForumTree.title+'</a>');
            $scope.dismiss();
        }

        $scope.insertMainTree = function() {
            
            CkInstance.insertHtml('<a href="#" class="body inner-link " main-tree-index="'+$scope.selectedMainTree.treeIndex+'">'+$scope.selectedMainTree.title+'</a>');
            $scope.dismiss();
        }

        $scope.insertNewsTree = function() {
            
            CkInstance.insertHtml('<a href="#" class="body inner-link " news-tree-index="'+$scope.selectedNewsTree.treeIndex+'">'+$scope.selectedNewsTree.title+'</a>');
            $scope.dismiss();
        }

		$scope.dismiss = function() {
			$modalInstance.dismiss();
		}
}])
commentApp.controller('changeTreeModalCtrl', ['$scope', '$http', '$modalInstance', '$modal', 'forumTree', 'comment', function($scope, $http, $modalInstance, $modal, forumTree, comment){
		
		$scope.forumTree = forumTree;
		$scope.comment = comment;
		$scope.treeOptions = {
		    nodeChildren: "children",
		    dirSelectable: false,
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

		$scope.changeForumTree = function(index) {
            
            $http({
	            method: "put",
	            url: "comment/ajax/change_tree/"+comment.id+'/'+$scope.newForumTree.id,
	            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
	            data: $.param({_method: 'PUT'})
	        }).then(
	        	function(response){
	        		comment.thread = response.data.thread;
	        		$scope.dismiss();
	        	}, 
	        	function(errResponse){
	        		console.log(errResponse.data);
	        	}
	    	);
            
        }
        $scope.dismiss = function() {
			$modalInstance.dismiss();
		}
        
}])
