var customerApp = angular.module('CustomerApp', ['ui.router', 'oitozero.ngSweetAlert', 'angularFileUpload', 
								'ngPasswordStrength', 'validation.match', 'angularMoment', 'ui.utils', 'duScroll', 'decipher.tags',
                'ui.bootstrap.typeahead', 'ngMaterial', 'monospaced.elastic', 'ngSanitize', 'validation', 'validation.rule'
                , 'angAccordion', 'ui.sortable', 'angular-loading-bar']);

customerApp.run(function(amMoment) {
    amMoment.changeLocale('fa');
});



customerApp.filter('toDate', function() {
  return function(input) {
    return new Date(input);
  }
})

customerApp.filter('smilies', function() {
  return function(input) {
    var smilies = [
      {
        regex: /\(wink\)/g,
        name: 'wink'
      }, 
      {
        regex: /\(dollar\)/g,
        name: 'dollar'
      }, 
      {
        regex: /\(happy\)/g,
        name: 'happy'
      },
      {
        regex: /\(airplane\)/g,
        name: 'airplane'
      },
      {
        regex: /\(angry\)/g,
        name: 'angry'
      },
      {
        regex: /\(baseball\)/g,
        name: 'baseball'
      },
      {
        regex: /\(basketball\)/g,
        name: 'basketball'
      },
      {
        regex: /\(bicycle\)/g,
        name: 'bicycle'
      },
      {
        regex: /\(burger\)/g,
        name: 'burger'
      },
      {
        regex: /\(car\)/g,
        name: 'car'
      },
      {
        regex: /\(clap\)/g,
        name: 'clap'
      },
      {
        regex: /\(cloud\)/g,
        name: 'cloud'
      },
      {
        regex: /\(coffee\)/g,
        name: 'coffee'
      },
      {
        regex: /\(confused\)/g,
        name: 'confused'
      },
      {
        regex: /\(cool\)/g,
        name: 'cool'
      },
      {
        regex: /\(crazy\)/g,
        name: 'crazy'
      },
      {
        regex: /\(cry\)/g,
        name: 'cry'
      },
      {
        regex: /\(cupcake\)/g,
        name: 'cupcake'
      },
      {
        regex: /\(depressed\)/g,
        name: 'depressed'
      },
      {
        regex: /\(exclam\)/g,
        name: 'exclam'
      },
      {
        regex: /\(fire\)/g,
        name: 'fire'
      },
      {
        regex: /\(flower\)/g,
        name: 'flower'
      },
      {
        regex: /\(happy\)/g,
        name: 'happy'
      },
      {
        regex: /\(koala\)/g,
        name: 'koala'
      },
      {
        regex: /\(ladybug\)/g,
        name: 'ladybug'
      },
      {
        regex: /\(laugh\)/g,
        name: 'laugh'
      },
      {
        regex: /\(light_bulb\)/g,
        name: 'light_bulb'
      },
      {
        regex: /\(mad\)/g,
        name: 'mad'
      },
      {
        regex: /\(money\)/g,
        name: 'money'
      },
      {
        regex: /\(music\)/g,
        name: 'music'
      },
      {
        regex: /\(nerd\)/g,
        name: 'nerd'
      },
      {
        regex: /\(not_sure\)/g,
        name: 'not_sure'
      },
      {
        regex: /\(Q\)/g,
        name: 'Q'
      },
      {
        regex: /\(rain\)/g,
        name: 'rain'
      },
      {
        regex: /\(relax\)/g,
        name: 'relax'
      },
      {
        regex: /\(run\)/g,
        name: 'run'
      },
      {
        regex: /\(sad\)/g,
        name: 'sad'
      },
      {
        regex: /\(scream\)/g,
        name: 'scream'
      },
      {
        regex: /\(shy\)/g,
        name: 'shy'
      },
      {
        regex: /\(sick\)/g,
        name: 'sick'
      },
      {
        regex: /\(sleeping\)/g,
        name: 'sleeping'
      },
      {
        regex: /\(smiley\)/g,
        name: 'smiley'
      },
      {
        regex: /\(soccer\)/g,
        name: 'soccer'
      },
      {
        regex: /\(sun\)/g,
        name: 'sun'
      },
      {
        regex: /\(surprised\)/g,
        name: 'surprised'
      },
      {
        regex: /\(teeth\)/g,
        name: 'teeth'
      },
      {
        regex: /\(time\)/g,
        name: 'time'
      },
      {
        regex: /\(tongue\)/g,
        name: 'tongue'
      },
      {
        regex: /\(wink\)/g,
        name: 'wink'
      },
      {
        regex: /\(yummi\)/g,
        name: 'yummi'
      },
      {
        regex: /\(darkish_logo\)/g,
        name: 'darkish_logo'
      } 

    ];
    angular.forEach(smilies, function(value, key){
      input = input.replace(value.regex, 
      '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" class="dk-emot emot-'+value.name+'" alt="'+value.name+'" />');
    });
    
    return input;
  }
})

customerApp.config(function($stateProvider, $urlRouterProvider, $mdThemingProvider) {





  $mdThemingProvider.theme('default')
    .primaryPalette('teal')
    .accentPalette('blue')
    .warnPalette('red');
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
      },
      resolve: {
        storeData: function($http) {
          return $http({method: 'GET', url: 'customer/ajax/get_store_data'})
             .then (function (response) {
                return response.data;
             });  
        }

      }
    })
    .state('store.productdetails', {
      url: "/product/{pid:int}",
      templateUrl: "customer/template/store-product-details.html",
      controller: "StoreProductDetailsCtrl",
      resolve: {
        product: function($http, $stateParams) {
          return $http({method: 'GET', url: 'customer/ajax/product/get/'+$stateParams.pid})
             .then (function (response) {
                return response.data;
             });  
        }

      }
    })
    .state('store.editproduct', {
      url: "/product/{pid:int}/edit",
      templateUrl: "customer/template/store-product-edit.html",
      controller: "StoreProductEditCtrl",
      resolve: {
        product: function($http, $stateParams) {
          return $http({method: 'GET', url: 'customer/ajax/product/get/'+$stateParams.pid})
             .then (function (response) {
                return response.data;
             });  
        }
      }
    })
    .state('store.edit', {
      url: "/edit",
      templateUrl: "customer/template/store-edit.html",
      controller: "StoreEditCtrl"
    })
    .state('store.details', {
      url: "/details",
      templateUrl: "customer/template/store-details.html",
      controller: "StoreDetailsCtrl"
    })
    .state('store.create', {
      url: "/create",
      templateUrl: "customer/template/store-create.html",
      controller: "StoreCreateCtrl"

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


customerApp.controller('CustomerCtrl', ['$scope', '$state', '$http', '$rootScope', '$document', '$window', function($scope, $state, $http, $rootScope, $document, $window){
  $http.get('customer/get_user').then(
    function(response){
		  $scope.user = response.data;
      $scope.access = $scope.getAccess();
      $scope.window = $window;
      $scope.isXSmall = function() {
        if($window.outerWidth < 768) {
          return true;
        }
        return false;
      }
	});


  // $document.on('scroll', function() {
  //       if($window.outerWidth < 768) {
  //         $('.details-header').addClass('fixed');
  //         $('.master-buttons').addClass('fixed');
  //       } else {
  //         $('.details-header').removeClass('fixed');
  //         $('.master-buttons').removeClass('fixed');
  //       }
  //  });



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



customerApp.controller('CommentsCtrl', ['$scope', '$http', function($scope, $http){
	
}])

customerApp.controller('AttachmentsCtrl', ['$scope', function($scope){
	
}])

customerApp.controller('DatabaseCtrl', ['$scope', function($scope){
	
}])




customerApp.controller('UsersCtrl', ['$scope', function($scope){
	
}])