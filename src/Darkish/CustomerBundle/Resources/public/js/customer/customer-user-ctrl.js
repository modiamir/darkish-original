

customerApp.controller('UserCtrl', 
  ['$scope', '$state', 'FileUploader', '$window', '$http', 'SweetAlert', 'accesses', 
  function($scope, $state, FileUploader, $window, $http, SweetAlert, accesses){


	

	$scope.state = $state;
	
	$scope.editmode = false;
  
  $scope.accesses = accesses;



  	$scope.items = []

  	$http.post('customer/ajax/assistant/all').then(
	    function(response){
	      $scope.users = response.data.customers;
	    }, 
	    function(responseErr){

	    }
    );








  	$scope.selectUser = function(user) {
      $state.go('user.edit', {uid: user.id});
  	}

  	$scope.dbType = function() {
  		return ($scope.user.record.dbase_type_index.id == 2) ? "automobile" : "estate";
  	}


  	

	$scope.ages = [];
	var d = new Date();
	var n = d.getFullYear();
	for (var i = n - 10; i <= n + 1; i++) {
		$scope.ages.push(i)
	};
  



}])


customerApp.controller('UserItemEditCtrl', ['$scope', '$http', '$filter', 'SweetAlert', 'user', 'FileUploader', '$state' , function($scope, $http, $filter, SweetAlert, user, FileUploader,$state){
	
    $scope.curUser = user;


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
    uploader.formData.push({type : 'store'});
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
        $scope.curUser.photo = response;
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


    var tempAccessJson = {};
    angular.forEach($scope.curUser.assistant_access, function(value, key){
      tempAccessJson[value.id] = true;
    });
    $scope.curUser.assistant_access = angular.copy(tempAccessJson);
    

    $scope.saveUser = function() {
        var tempUser = angular.copy($scope.curUser);
        var data = humps.camelizeKeys(tempUser);
        var postData = {_method: 'POST'};
        
        
        
        
        data.assistantAccess = [];
        angular.forEach(tempUser.assistant_access, function(value, key){
          if(value) {
            data.assistantAccess.push(key);
          }
        });

        if(data.photo){
          postData.photo = data.photo.id;
          
        }
        delete data.photo;
        
        delete data.newPasswordConfirm;
        delete data.id;
        delete data.created;
        delete data.record;
        delete data.type;
        delete data.roles;
        delete data.username;
        postData['darkish_customerbundle_customer'] = data;

        
        $http({
          method: 'POST',
          url: './customer/ajax/assistant/'+$scope.curUser.id,
          headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
          data: $.param(postData)
        }). then(
            function(response){
                var inList = $filter('filter')($scope.users,{id: $scope.curUser.id})[0];
                var inListIndex = $scope.users.indexOf(inList);
                $scope.users[inListIndex] = response.data;
            }, 
            function(responseErr){
                if(responseErr.status == 500 && responseErr.data.code == 13) {
                  SweetAlert.swal({
                    title: "نام کاربری تکراری است یا معتبر نیست.",
                    type: "success"
                  });
                } else {
                  SweetAlert.swal({
                    title: "ذخیره انجام نشد.",
                    text: responseErr.data.text,
                    type: "success"
                  });
                }
            }
        );


    }
		
    $scope.removeUser = function() {
      SweetAlert.swal({
            title: "آیا از حذف اطمینان دارید؟",
            text: "این عملیات قابل برگشت نیست!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "بله, حذف کن!",
            cancelButtonText: "انصراف",
            imageSize: "40x40",
            closeOnConfirm: true
      }, function(){
          $http({
            method: 'DELETE',
            url: './customer/ajax/assistant/remove/'+$scope.curUser.id,
            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
            data: $.param({_method: "DELETE"})
          }).then(
            function(response){
              var inList = $filter('filter')($scope.users,{id: $scope.curUser.id})[0];
              var inListIndex = $scope.users.indexOf(inList);
              $scope.users.splice(inListIndex,1);
              $state.go('user');
              SweetAlert.swal({
                title: "حذف انجام شد.",
                type: "success"
              });
            },
            function(responseErr){}
          )  
      });
      
    }

}])




customerApp.controller('UserCreateCtrl', ['$scope', 'FileUploader', '$http', '$state', 'SweetAlert', 
	function($scope, FileUploader, $http, $state, SweetAlert){


    $scope.newUser = {};


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
    uploader.formData.push({type : 'store'});
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
        $scope.newUser.photo = response;
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



  	$scope.saveUser = function() {
        var tempUser = angular.copy($scope.newUser);
        var data = humps.camelizeKeys(tempUser);
        var postData = {_method: 'POST'};
        
        
        
        
        data.assistantAccess = [];
        angular.forEach(tempUser.assistant_access, function(value, key){
          if(value) {
            data.assistantAccess.push(key);
          }
        });

        if(data.photo){
          postData.photo = data.photo.id;
          
        }
        delete data.photo;
        delete data.newPasswordConfirm;
          
        postData['darkish_customerbundle_customer'] = data;

        
        $http({
          method: 'POST',
          url: './customer/ajax/assistant',
          headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
          data: $.param(postData)
        }). then(
          	function(response){
              	$scope.users.unshift(response.data);
                $state.go('user.edit', {uid: response.data.id});
          	}, 
          	function(responseErr){
                if(responseErr.status == 500 && responseErr.data.code == 13) {
                  SweetAlert.swal({
                    title: "نام کاربری تکراری است یا معتبر نیست.",
                    type: "success"
                  });
                } else {
                	SweetAlert.swal({
                	  title: "ذخیره انجام نشد.",
                	  text: responseErr.data.text,
                	  type: "success"
                	});
                }
          	}
        );


  	}



}])

