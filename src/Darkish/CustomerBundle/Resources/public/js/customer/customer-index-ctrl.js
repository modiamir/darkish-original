var customerApp = angular.module('CustomerApp', ['ui.router', 'oitozero.ngSweetAlert', 'angularFileUpload', 
								'ngPasswordStrength', 'validation.match', 'angularMoment']);

customerApp.run(function(amMoment) {
    amMoment.changeLocale('fa');
});



customerApp.filter('toDate', function() {
  return function(input) {
    return new Date(input);
  }
})

customerApp.config(function($stateProvider, $urlRouterProvider) {
  //
  // For any unmatched url, redirect to /state1
  $urlRouterProvider.otherwise("/profile");
  //
  // Now set up the states
  $stateProvider
    .state('profile', {
      url: "/profile",
      templateUrl: "customer/template/profile.html",
      controller: "ProfileCtrl",
      data: {
      	label: 'پروفایل'
      }
    })
    .state('editprofile', {
      url: "/profile/edit",
      templateUrl: "customer/template/profile-edit.html",
      controller: "ProfileEditCtrl",
      data: {
      	label: 'ویرایش پروفایل'
      }
    })
    .state('htmlpage', {
      url: "/html-page",
      templateUrl: "customer/template/html-page.html",
      controller: "HtmlPageCtrl",
      data: {
      	label: 'صفحه آنلاین'
      }
    })
    .state('messages', {
      url: "/messages",
      templateUrl: "customer/template/messages.html",
      controller: "MessagesCtrl",
      data: {
      	label: 'پیام ها'
      },
      resolve: {
        threads: function($http) {
          return $http({method: 'GET', url: 'customer/ajax/get_message_threads'})
             .then (function (response) {
                return response.data;
             });

        }
      }
    })
    .state('comments', {
      url: "/comments",
      templateUrl: "customer/template/comments.html",
      controller: "CommentsCtrl",
      data: {
      	label: 'نظرات'
      }
    })
    .state('attachments', {
      url: "/attachments",
      templateUrl: "customer/template/attachments.html",
      controller: "AttachmentsCtrl",
      data: {
      	label: 'فایل ها'
      }
    })
    .state('database', {
      url: "/database",
      templateUrl: "customer/template/database.html",
      controller: "DatabaseCtrl",
      data: {
      	label: 'پایگاه داده'
      }
    })
    .state('store', {
      url: "/store",
      templateUrl: "customer/template/store.html",
      controller: "StoreCtrl",
      data: {
      	label: 'فروشگاه آنلاین'
      }
    })
    .state('users', {
      url: "/users",
      templateUrl: "customer/template/users.html",
      controller: "UsersCtrl",
      data: {
      	label: 'کاربران'
      }
    });
});


customerApp.controller('CustomerCtrl', ['$scope', '$state', '$http', '$rootScope', function($scope, $state, $http, $rootScope){
	// console.log($state);
  $http.get('customer/get_user').then(
    function(response){
		  $scope.user = response.data;
      $scope.access = $scope.getAccess();
      
	});

  $scope.isOnline = function() {
    return true;
  }

  $scope.getAccess = function() {
    var access = [];
    angular.forEach($scope.user.assistant_access, function(value, key){
      access.push(value.role);
    });
    return access;
  }

  $scope.state = $state;

  $rootScope.$on('$stateChangeSuccess', 
  function(event, toState, toParams, fromState, fromParams){
    if(toState.name == "editprofile") {
      if($('#navbar-collapse-user-menu').hasClass('in')) {
        $('#navbar-collapse-user-menu').collapse('hide');  
      }
    } else {
      if($('#navbar-collapse-main-menu').hasClass('in')) {
        $('#navbar-collapse-main-menu').collapse('hide');  
      }  
    }
  });




  $scope.pagetitle = function() {
    return "درکیش  | پنل مشتریان | " + (($state.current.data) ? $state.current.data.label:"");
  }
  
}]);



customerApp.controller('ProfileCtrl', ['$scope', '$http', function($scope, $http){
	


}])

customerApp.controller('ProfileEditCtrl', ['$scope', '$http', '$state','SweetAlert', 'FileUploader', function($scope, $http, $state, SweetAlert, FileUploader){
	$http.get('customer/get_user').then(function(response){
		$scope.editinguser = response.data;
	}); 

	$scope.isUnchanged = function(user) {
      return angular.equals(user, $scope.user);
    };

    $scope.saveProfile = function(user) {
    	var data = humps.camelizeKeys(user);
    	if(user.photo) {
    	    data.photo = user.photo.id;
    	}
    	delete data.record;
	    delete data.isActive;
    	delete data.id;
    	delete data.created;
    	delete data.newPasswordConfirm;
    	delete data.roles;
    	delete data.type;
    	delete data.username;
    	delete data.assistantAccess;
    	delete data.password_confirm;

    	if(data.password) {
    		data.newPassword = data.password;
    		delete data.password;
    		delete data.passwordConfirm;
    	}

    	$http({
    	    method: 'POST',
    	    url: './customer/ajax/update/'+user.id,
    	    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
    	    data: $.param({_method: 'POST', customer_edit_profile: data})
    	}).then(
    	    function(response){
    	        var editeduser = response.data;
    	        angular.forEach(editeduser, function(value, key){
    	        	$scope.user[key] = value;
    	        });
    	        SweetAlert.swal(
    	            {
    	                title: "ویرایش انجام شد.", 
    	                text: "شما به صفحه پروفایل منتقل خواهید شد.",
    	                type: "success"
    	            },
    	            function(){
    	                $state.go('profile')
    	            }
    	        );
    	            
    	    },
    	    function(responseErr){
    	        SweetAlert.swal(
    	            {
    	                title: "ویرایش با خطا مواجه شد", 
    	                text: responseErr.data.error.message,
    	                type: "warning"
    	            }
    	        );
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
    uploader.queueLimit =1 ;
    uploader.autoUpload = true;
    uploader.removeAfterUpload = true;
    uploader.formData.push({uploadDir : 'image'});
    uploader.formData.push({continual : true});
    uploader.formData.push({type : 'customer'});
    uploader.msg = "";
    
    // FILTERS
        
    uploader.filters.push({
        name: 'imageTypeFilter',
        fn: function(item /*{File|FileLikeObject}*/, options) {
            uploadableType = "image";
            uploadableExtensions = ["jpg", "jpeg", "png", "bmp"];
            fileType = item.type.split("/")[0];
            fileExtension = item.type.split("/")[1];
            if(fileType != uploadableType || uploadableExtensions.indexOf(fileExtension) == -1) {
                return false;
            }
            
            return true;
            
             
        }
    });
    
//        uploader.filters.push({
//            name: 'imageSizeFilter',
//            fn: function(item /*{File|FileLikeObject}*/, options) {
//                if(ValuesService.activeTab == 'image') {
//                    if(item.size > 300000) {
//                        return false;
//                    }
//                }
//                return true;
//                
//                 
//            }
//        });
    
    

    // CALLBACKS

    uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
        console.info('onWhenAddingFileFailed', item, filter, options);
        switch(filter.name) {
            case 'imageTypeFilter':
                uploader.msg = "شما فقط میتوانید فایل با پسوند های  png و bmp و jpg آپلود کنید";
                break;
            case 'imageSizeFilter':
                uploader.msg = 'imageSizeFilter';
                break;
            
            
        }
    };
    uploader.onAfterAddingFile = function(fileItem) {
        console.info('onAfterAddingFile', fileItem);
    };
    uploader.onAfterAddingAll = function(addedFileItems) {
        console.info('onAfterAddingAll', addedFileItems);
    };
    uploader.onBeforeUploadItem = function(item) {
        console.info('onBeforeUploadItem', item);
    };
    uploader.onProgressItem = function(fileItem, progress) {
        console.info('onProgressItem', fileItem, progress);
    };
    uploader.onProgressAll = function(progress) {
        console.info('onProgressAll', progress);
    };
    uploader.onSuccessItem = function(fileItem, response, status, headers) {
        console.info('onSuccessItem', fileItem, response, status, headers);
        $scope.editinguser.photo = response;
        uploader.msg = 'فایل با موفقیت بارگزاری شد.';
    };
    uploader.onErrorItem = function(fileItem, response, status, headers) {
        console.info('onErrorItem', fileItem, response, status, headers);
    };
    uploader.onCancelItem = function(fileItem, response, status, headers) {
        console.info('onCancelItem', fileItem, response, status, headers);
    };
    uploader.onCompleteItem = function(fileItem, response, status, headers) {
        console.info('onCompleteItem', fileItem, response, status, headers);
    };
    uploader.onCompleteAll = function() {
        console.info('onCompleteAll');
    };

}])

customerApp.controller('HtmlPageCtrl', ['$scope', function($scope){
	 
}])

customerApp.controller('MessagesCtrl', ['$scope', '$window', 'threads', '$http', '$timeout', '$filter',
  '$interval', function($scope, $window, threads, $http, $timeout, $filter, $interval){
  $scope.threads = threads.threads;
  $scope.lastMessage = threads.last_message;
  $scope.selectedThread = {};

  $scope.setLastMessageDelivered = function(thread, message) {
      $http({
          method: 'PUT',
          url: './customer/ajax/set_last_delivered/'+thread.id+'/'+message,
          headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
          data: $.param({_method: 'PUT'})
      }).then(
        function(response) {
          
          thread.last_record_delivered = message;
          console.log($scope.threads);
          
        }
      )
  }

  $scope.setLastMessageSeen = function(thread, message) {
      $http({
          method: 'PUT',
          url: './customer/ajax/set_last_seen/'+thread.id+'/'+message,
          headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
          data: $.param({_method: 'PUT'})
      }).then(
        function(response) {
          thread.last_record_seen = message;
          
          
        }
      )
  }
  
  angular.forEach($scope.threads, function(value, key){
    if(value.last_message.id > value.last_record_delivered) {
      $scope.setLastMessageDelivered(value, value.last_message.id);  
    }
    
  });

  $scope.currentMessages = [];
  $scope.selectThread = function(thread) {
    if(!angular.equals($scope.selectedThread, thread)) {
      $scope.selectedThread = thread;
      $scope.hasNotMore = false;
      $scope.groupMessageForm = false;
      $http.get('./customer/ajax/get_messages_for_thread/'+thread.id+'/0').then(
        function(response) {
          
          $scope.currentMessages = response.data;
          $scope.setLastMessageSeen(thread, thread.last_message.id);
        },
        function(responseErr) {
        }
      );
    }
  }

  $scope.loadMore = function() {
    $http.get('./customer/ajax/get_messages_for_thread/'+$scope.selectedThread.id+'/'+$scope.currentMessages.length).then(
      function(response) {
        $scope.currentMessages = $scope.currentMessages.concat(response.data);
        if(response.data.length < 5) {
          $scope.hasNotMore = true;
        }
      },
      function(responseErr) {
      }
    );
  }

  $scope.postMessage = function() {
    if($scope.messageForm) {
      $http({
          method: 'PUT',
          url: './customer/ajax/post_message/'+$scope.selectedThread.id,
          headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
          data: $.param({_method: 'PUT', text: $scope.messageForm})
      }).then(
        function(response) {
          $scope.currentMessages.unshift(response.data);
          $scope.messageForm = null;
          $scope.selectedThread.last_message = response.data;
          $scope.setLastMessageSeen($scope.selectedThread, $scope.selectedThread.last_message.id);
          $scope.setLastMessageDelivered($scope.selectedThread, $scope.selectedThread.last_message.id);
          $timeout(function(){
            $('#message-container').scrollTop($('#message-container')[0].scrollHeight);  
          }, 100)
          
          
          
        }
      );
    }
  }

  $interval(function(){
    var latest = 0;
    angular.forEach($scope.threads, function(value, key){
      latest = (latest < value.last_message.id) ? value.last_message.id : latest;
    });
    $http.get('./customer/ajax/refresh_messages/'+ latest).then(
      function(response) {
        angular.forEach(response.data, function(value, key){
          var th = $filter('filter')($scope.threads, {id: value.thread.id})[0];
          if($scope.selectedThread.id == th.id) {
            th.last_message.id = value.id;
            th.last_message.created = value.created;
            th.last_message.from = value.from;
            th.last_message.text = value.text;
            th.last_record_seen = value.id;
            th.last_record_delivered = value.id;
            $scope.currentMessages.push(value);
          } else {
            th.last_message.id = value.id;
            th.last_message.created = value.created;
            th.last_message.from = value.from;
            th.last_message.text = value.text;
            th.last_record_delivered = value.id;
          }
        });
      },
      function(responseErr) {

      }
    );
  }, 10000);
  
  $scope.showGroupMessageForm = function() {
    $scope.selectedThread = {};
    $scope.groupMessageForm = true;
  }

  $scope.submitGroupMessage = function() {
    $http({
        method: 'POST',
        url: './customer/ajax/post_group_message',
        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
        data: $.param({_method: 'POST', text: $scope.groupText})
    }).then(
      function(response) {
        $scope.groupText = null;
        $scope.threads.push(response.data);
        $scope.selectThread(response.data);
        
        
        
      }
    );
  }

}])

customerApp.controller('CommentsCtrl', ['$scope', '$http', function($scope, $http){
	
}])

customerApp.controller('AttachmentsCtrl', ['$scope', function($scope){
	
}])

customerApp.controller('DatabaseCtrl', ['$scope', function($scope){
	
}])

customerApp.controller('StoreCtrl', ['$scope', function($scope){
	
}])

customerApp.controller('UsersCtrl', ['$scope', function($scope){
	
}])