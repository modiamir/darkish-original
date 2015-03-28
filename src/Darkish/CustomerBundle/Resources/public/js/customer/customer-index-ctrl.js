var customerApp = angular.module('CustomerApp', ['ui.router', 'oitozero.ngSweetAlert', 'angularFileUpload', 
								'ngPasswordStrength', 'validation.match']);


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


customerApp.controller('CustomerCtrl', ['$scope', '$state', '$http', function($scope, $state, $http){
	// console.log($state);
    $scope.pageTitle = 'پنل مشتریان';
    $http.get('customer/get_user').then(function(response){
		$scope.user = response.data;
    $scope.isOnline = function() {
      return true;
    }
	}); 
	$scope.state = $state;
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
    	console.log(user);
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
    	        console.log(responseErr);
    	        SweetAlert.swal(
    	            {
    	                title: "ویرایش با خطا مواجه شد", 
    	                text: responseErr.data,
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

customerApp.controller('MessagesCtrl', ['$scope', function($scope){
	
}])

customerApp.controller('CommentsCtrl', ['$scope', '$http', function($scope, $http){
	$scope.corstest = function() {
    $http.get("http://178.62.236.24/n-darkish/web/api/rest/time.json").then(
      function(response){
        console.log(response);
      }, 
      function(responseErr){
        console.log(responseErr);
      });
  }
}])

customerApp.controller('AttachmentsCtrl', ['$scope', function($scope){
	
}])

customerApp.controller('DatabaseCtrl', ['$scope', function($scope){
	
}])

customerApp.controller('StoreCtrl', ['$scope', function($scope){
	
}])

customerApp.controller('UsersCtrl', ['$scope', function($scope){
	
}])