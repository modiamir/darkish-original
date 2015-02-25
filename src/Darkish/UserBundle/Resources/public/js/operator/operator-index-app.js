var operatorApp = angular.module('operatorApp', ['ui.router', 'smart-table', 'ui.router',
    'ngCollection', 'ui.bootstrap', 'cgPrompt', 'angularFileUpload', 'validation.match', 'oitozero.ngSweetAlert',
    'uiSwitch', 'checklist-model']);

operatorApp.config(function($stateProvider, $urlRouterProvider){
   $urlRouterProvider.otherwise("/"); 
   
   $stateProvider
    .state('operators', {
      url: "/",
      templateUrl: "template/operators.html",
      controller: "operatorsCtrl"
    })
    .state('add', {
      url: "/add",
      templateUrl: "template/operators.add.html",
      controller: "operatorsAddCtrl"
    })
    .state('edit', {
      url: "/edit/{id:int}",
      templateUrl: "template/operators.edit.html",
      controller: "operatorsEditCtrl"
    });
});

operatorApp.controller('operatorIndexCtrl', ['$scope', '$interval', '$collection', '$http', 'poollingFactory', 'SecurityService', 'SweetAlert', '$modal', 'ValuesService', function($scope, $interval, $collection, $http, poollingFactory, SecurityService, SweetAlert, $modal, ValuesService){
    
        /**
         * 
         * user authentication config
         */
        $scope.SecurityService = SecurityService;
        $scope.ValuesService = ValuesService;
        SecurityService.loggedIn = true;
        SecurityService.connected = true;
        SecurityService.disconnectModalDisplayed = false;

        $scope.logout = function () {
            $http.get('../operator/ajax/logout').then(
                    function (response) {
                        $scope.loggedOut();
                    },
                    function (responseErr) {
                        console.log(responseErr);
                    }
            );
        }
        
        $scope.loggedOut = function() {
            SecurityService.loggedIn = false;
        }

        $scope.isLoggedIn = function () {
            $http.get('../operator/ajax/is_logged_in').then(
                    function (response) {
//                    console.log(response.data[0]);
                        SecurityService.connected = true;
                        SecurityService.disconnectModalDisplayed = false;
                        if (response.data[0] === false) {
                            SecurityService.loggedIn = false;
                        } else {
                            SecurityService.loggedIn = true;
                        }

                    },
                    function (responseErr) {
                        SecurityService.connected = false;
                        if (SecurityService.disconnectModalDisplayed == false) {
                            SecurityService.disconnectModalDisplayed = true;
                            SweetAlert.swal({
                                title: "قطع ارتباط!",
                                text: "ارتباط شما با سرور قطع شده است.",
                                type: "warning",
                                confirmButtonText: "بستن"
                            });
//                            $scope.openDisconnectModal();
                        }

                    }
            );
        }    
        poollingFactory.callFnOnInterval(function() {
            $scope.isLoggedIn();
        });
        
        /**
         * login modal initialization
         */
        
                
    
            
        $scope.openLoginModal = function (size) {
            
            var loginModalInstance = $modal.open({
                templateUrl: 'loginModal.html',
                controller: 'loginModalCtrl',
                size: size,
                resolve: {
                    
                },
                windowClass: 'login-modal-window'
            });

            loginModalInstance.result.then(
            function () {
                
                
                
            }, function () {
                
            });
        };
        
        ///////////////
        
        $interval(function(){
            $scope.loaded = true;
        }, 3000);
        $scope.operators = [];
}]);

operatorApp.controller('operatorsCtrl', ['$scope', '$collection', '$http', '$state', 'prompt', 'SweetAlert', function($scope, $collection, $http, $state, prompt, SweetAlert) {
    $scope.toggleIsActive = function(operator) {
        $http({
            method: 'POST',
            url: './ajax/toggle_is_active',
            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
            data: $.param({id: operator.id})
        }).then(
            function(response){
                
            },
            function(errResponse){
                operator.is_active = (operator.is_active)?false:true;
            }
        );
    }
    $scope.itemsByPage=10;
    $scope.displayedOperators = $scope.operators;
    $scope.refresh = function(tableState) {
        $http({
            method: 'POST',
            url: './ajax/search',
            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
            data: $.param({data: tableState})
        }).then(
            function(response){
                $scope.operators = response.data.result;
                $scope.displayedOperators = $scope.operators;
                tableState.pagination.numberOfPages = response.data.numOfPages;
            },
            function(response){
                
            }
        );
        
    };
    
    $scope.delete = function(operator, index) {
        SweetAlert.swal(
            {
                title: "حذف اپراتور؟",
                text: "آیا از انجام این عمل اطمینان دارید؟",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "بله، انجام حذف!",
                cancelButtonText: "انصراف",
            }, 
            function(){
                $http({
                    method: 'POST',
                    url: './ajax/delete_operator',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param({id: operator.id})
                }).then(
                    function(response){
                        $scope.operators.splice(index,1);
                        $scope.displayedOperators = $scope.operators;

                        SweetAlert.swal({
                            title: "حذف انجام شد!", 
                            type: "success",
                            confirmButtonText: "بستن"
                        });
                    }, 
                    function(responseErr){
                        
                    }
                );
                
            }
        );
        
       
    }
    
    $scope.editOperator = function(operator) {
        $state.go('edit', {id: operator.id})
    }
    
}]);

operatorApp.controller('operatorsAddCtrl', ['$scope', '$stateParams', '$state', 'SweetAlert', '$http', 'ValuesService', 'FileUploader', function($scope, $stateParams, $state, SweetAlert, $http, ValuesService, FileUploader){
        $scope.ValuesService = ValuesService;
        $scope.operator = {};
        

        
        
        $scope.submit = function() {
            var data = humps.camelizeKeys($scope.operator);
            if($scope.operator.photo) {
                data.photo = $scope.operator.photo.id;
            }
            data.accessLevel = JSON.stringify(data.accessLevel);
            if(!data.isActive) {
                delete data.isActive;
            }
            delete data.newPasswordConfirm;
            
            $http({
                method: 'POST',
                url: './ajax/create',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({_method: 'POST', darkish_userbundle_operator: data})
            }).then(
                function(response){
                    
                    SweetAlert.swal(
                        {
                            title: "ویرایش انجام شد.", 
                            text: "شما به صفحه لیست اپراتورها منتقل خواهید شد.",
                            type: "success"
                        },
                        function(){
                            $state.go('operators')
                        }
                    );
                        
                },
                function(responseErr){

                }
            );
        }
        
        
        /**
         * 
         * uploader
         */

        var uploader = $scope.uploader = new FileUploader({
            url: '../managedfile/ajax/upload'
        });
        uploader.withCredentials = true;
        uploader.queueLimit =1 ;
        uploader.autoUpload = true;
        uploader.removeAfterUpload = true;
        uploader.formData.push({uploadDir : 'image'});
        uploader.formData.push({continual : true});
        uploader.formData.push({type : 'operator'});
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
            $scope.operator.photo = response;
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
}]);

operatorApp.controller('operatorsEditCtrl', ['$scope', '$stateParams', '$state', 'SweetAlert', '$http', 'ValuesService', 'FileUploader', function($scope, $stateParams, $state, SweetAlert, $http, ValuesService, FileUploader){
        $scope.ValuesService = ValuesService;
        
        $http.get('./ajax/get_operator/'+$stateParams.id).then(
            function(response){
                $scope.operator = response.data;
                var roles = [];
                angular.forEach($scope.operator.roles, function(value, index){
                    roles[index] = value.id;
                    console.log(value);
                });
                $scope.operator.roles = angular.copy(roles);
                $scope.operator.access_level = JSON.parse($scope.operator.access_level);
                
            },
            function(errResponse){
                
            }
        );
        
        $scope.submit = function() {
            var data = humps.camelizeKeys($scope.operator);
            if($scope.operator.photo) {
                data.photo = $scope.operator.photo.id;
            }
            data.accessLevel = JSON.stringify(data.accessLevel);
            
            if(!data.isActive) {
                delete data.isActive;
            }
            delete data.creator;
            
            delete data.id;
            delete data.created;
            delete data.newPasswordConfirm;
            $http({
                method: 'POST',
                url: './ajax/update/'+$scope.operator.id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({_method: 'POST', darkish_userbundle_operator: data})
            }).then(
                function(response){
                    $scope.operator = response.data;
                    var roles = [];
                    angular.forEach($scope.operator.roles, function (value, index) {
                        roles[index] = value.id;
                        console.log(value);
                    });
                    $scope.operator.roles = angular.copy(roles);
                    SweetAlert.swal(
                        {
                            title: "ویرایش انجام شد.", 
                            text: "شما به صفحه لیست اپراتورها منتقل خواهید شد.",
                            type: "success"
                        },
                        function(){
                            $state.go('operators')
                        }
                    );
                        
                },
                function(responseErr){

                }
            );
        }
        
        
        /**
         * 
         * uploader
         */

        var uploader = $scope.uploader = new FileUploader({
            url: '../managedfile/ajax/upload'
        });
        uploader.withCredentials = true;
        uploader.queueLimit =1 ;
        uploader.autoUpload = true;
        uploader.removeAfterUpload = true;
        uploader.formData.push({uploadDir : 'image'});
        uploader.formData.push({continual : true});
        uploader.formData.push({type : 'operator'});
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
            $scope.operator.photo = response;
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
}]);


operatorApp.factory("poollingFactory", function ($timeout) {

    var timeIntervalInSec = 10;

    function callFnOnInterval(fn, timeInterval) {

        var promise = $timeout(fn, 1000 * timeIntervalInSec);

        return promise.then(function(){
            callFnOnInterval(fn, timeInterval);
        });
    };

    return {
        callFnOnInterval: callFnOnInterval
    };
});

operatorApp.factory('ValuesService', ['$http', function($http){
    self = {}
    
    if(!self.username) {
        $http.get('ajax/get_username').then(
            function(response){
                self.username = response.data;
            },
            function(responseErr){
                console.log(responseErr);
            }
        );
    }
    
    self.accessLevels = [
        {
            label: 'رکوردها',
            value: "record"
        },
        {
            label: 'اخبار و سرگرمی',
            value: "news"
        },
        {
            label: 'پیشنهاد ویژه',
            value: "offer"
        },
        {
            label: 'نیازمندی ها',
            value: "classified"
        },
        {
            label: 'تالار گفتگو',
            value: "forum"
        },
        {
            label: 'مدیریت مشتریها',
            value: "manage_customer"
        }
        
    ];
    
    var roles;
    if(!roles) {

        $http.get('ajax/get_roles').then(
            function(response) {
                self.roles = response.data;

            },
            function(errResponse) {
            }
        );



    }
    
    return self;
}]);

operatorApp.factory('SecurityService', ['$http', function($http){
        var self={};
        
            
        
        
        
        
        return self;
        
        
        
    } ]);

operatorApp.controller('loginModalCtrl', ['$scope', '$http', '$modalInstance','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, ValuesService, SecurityService) {
        $scope.close = function(){$modalInstance.close(false);}
        $scope.cancel = function() {
            $modalInstance.close(true);
        }
        $scope.login = function() {
            var approve = true;
            var redirect = false;
            if(ValuesService.username != $scope.username) {
                
                approve = confirm("نام کاربری وارد شده با نام کاربری شناسایی شده از قبل متفاوت است. در صورت ادامه صفحه مجددا بارگزاری خواهد شد. آیا از ادامه اطمینان دارید؟");
                redirect = true;
            }
            if(approve) {
                $http({
                    method: 'POST',
                    url: '../operator/ajax/login',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    data: $.param({username: $scope.username, password: $scope.password})
                }).then(
                        function (response) {
                            SecurityService.loggedIn = true;
                            if(redirect) {
                                window.location = "../operator/manage";
                            } else {
                                $modalInstance.close(true);
                            }
                            
                        },
                        function (errResponse) {
                            alert(errResponse.data);
                        }
                );
            }
            
            
        }
    }])