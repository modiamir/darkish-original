var customerApp = angular.module('customerApp', ['ui.router', 'smart-table', 'ui.router',
    'ngCollection', 'ui.bootstrap', 'cgPrompt', 'angularFileUpload', 'validation.match', 'oitozero.ngSweetAlert',
    'uiSwitch', 'checklist-model', 'angucomplete-alt']);

customerApp.config(function($stateProvider, $urlRouterProvider){
   $urlRouterProvider.otherwise("/"); 
   
   $stateProvider
    .state('customers', {
      url: "/",
      templateUrl: "template/customers.html",
      controller: "customersCtrl"
    })
    .state('add', {
      url: "/add/{id:int}/{type:string}",
      templateUrl: "template/customers.add.html",
      controller: "customersAddCtrl"
    })
    .state('edit', {
      url: "/edit/{id:int}",
      templateUrl: "template/customers.edit.html",
      controller: "customersEditCtrl"
    });
});

customerApp.controller('customerIndexCtrl', ['$scope', '$interval', '$collection', '$http', 'poollingFactory', 'SecurityService', 'SweetAlert', '$modal', 'ValuesService', function($scope, $interval, $collection, $http, poollingFactory, SecurityService, SweetAlert, $modal, ValuesService){
    
        /**
         * 
         * user authentication config
         */
        $scope.SecurityService = SecurityService;
        $scope.ValuesService = ValuesService;
        SecurityService.loggedIn = true;
        SecurityService.connected = true;
        SecurityService.disconnectModalDisplayed = false;
        $scope.shared = {};
        $scope.shared.currentRecord = {id:-1, title: 'تمامی رکوردها'};
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
            $http.get('../customer/ajax/is_logged_in').then(
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
        $scope.customers = [];
}]);

customerApp.controller('customersCtrl', ['$scope', '$collection', '$http', '$state', 'prompt', 'SweetAlert', function($scope, $collection, $http, $state, prompt, SweetAlert) {
    $scope.toggleIsActive = function(customer) {
        $http({
            method: 'POST',
            url: './ajax/toggle_is_active',
            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
            data: $.param({id: customer.id})
        }).then(
            function(response){
                
            },
            function(errResponse){
                customer.is_active = (customer.is_active)?false:true;
            }
        );
    }
    
    $scope.add = function(type, recordId) {
        $state.go('add', {id: recordId, type: type});
    }
    
    $scope.tableState = {};
    
    $scope.itemsByPage=10;
    $scope.displayedCustomers = $scope.customers;
    $scope.refresh = function(tableState) {
        $scope.isLoading = true;
        $http({
            method: 'POST',
            url: './ajax/search',
            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
            data: $.param({data: tableState, recordId: $scope.shared.currentRecord.id})
        }).then(
            function(response){
                $scope.customers = response.data.result;
                $scope.displayedCustomers = $scope.customers;
                $scope.owner = response.data.owner[0];
                tableState.pagination.numberOfPages = response.data.numOfPages;
                $scope.isLoading = false;
                $scope.tableState = tableState;
            },
            function(response){
                
            }
        );
        
    };
    
    $scope.delete = function(customer, index) {
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
                    url: './ajax/delete_customer',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param({id: customer.id})
                }).then(
                    function(response){
                        $scope.customers.splice(index,1);
                        $scope.displayedCustomers = $scope.customers;

                        SweetAlert.swal({
                            title: "حذف انجام شد!", 
                            type: "success",
                            confirmButtonText: "بستن"
                        });
                        $scope.refresh($scope.tableState);
                    }, 
                    function(responseErr){
                        
                    }
                );
                
            }
        );
        
       
    }
    
    $scope.editCustomer = function(customer) {
        $state.go('edit', {id: customer.id})
    }
    
    $scope.$watch(
        function(scope) { return $scope.foundById },
        function(newValue, oldValue) {
            if(typeof newValue != 'undefined' && newValue.originalObject.id) {
                $scope.shared.currentRecord = newValue.originalObject;
                $scope.refresh($scope.tableState);
            }
        }
    );
    $scope.$watch(
        function(scope) { return $scope.foundByTitle },
        function(newValue, oldValue) {
            if(typeof newValue != 'undefined' && newValue.originalObject.id) {
                $scope.shared.currentRecord = newValue.originalObject;
                $scope.refresh($scope.tableState);
            }
        }
    );
    
    
    
}]);

customerApp.controller('customersAddCtrl', ['$scope', '$stateParams', '$state', 'SweetAlert', '$http', 'ValuesService', 'FileUploader', function($scope, $stateParams, $state, SweetAlert, $http, ValuesService, FileUploader){
        $scope.ValuesService = ValuesService;
        $scope.customer = {};
        $scope.customer.type = $stateParams.type;
        $scope.customer.record = {};
        $scope.customer.record.id = $stateParams.id;

        
        
        $scope.submit = function() {
            var data = humps.camelizeKeys($scope.customer);
            if($scope.customer.photo) {
                data.photo = $scope.customer.photo.id;
            }
            if($stateParams.id) {
                data.record = $stateParams.id;
            }
            
            if(!data.isActive) {
                delete data.isActive;
            }
            delete data.newPasswordConfirm;
            
            $http({
                method: 'POST',
                url: './ajax/create',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({_method: 'POST', darkish_customerbundle_customer: data})
            }).then(
                function(response){
                    $scope.customer = response.data;
                    SweetAlert.swal(
                        {
                            title: "ویرایش انجام شد.", 
                            text: "شما به صفحه لیست اپراتورها منتقل خواهید شد.",
                            type: "success"
                        },
                        function(){
                            $state.go('customers')
                        }
                    );
                        
                },
                function(responseErr){
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
            url: '../managedfile/ajax/upload'
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
            $scope.customer.photo = response;
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

customerApp.controller('customersEditCtrl', ['$scope', '$stateParams', '$state', 'SweetAlert', '$http', 'ValuesService', 'FileUploader', function($scope, $stateParams, $state, SweetAlert, $http, ValuesService, FileUploader){
        $scope.ValuesService = ValuesService;
        
        $http.get('./ajax/get_customer/'+$stateParams.id).then(
            function(response){
                $scope.customer = response.data;
                var assistantAccess = [];
                angular.forEach($scope.customer.assistant_access, function(value, index){
                    assistantAccess[index] = value.id;
                });
                $scope.customer.assistant_access = angular.copy(assistantAccess);
            },
            function(errResponse){
                
            }
        );
        
        $scope.submit = function() {
            var data = humps.camelizeKeys($scope.customer);
            if($scope.customer.photo) {
                data.photo = $scope.customer.photo.id;
            }
            if($scope.customer.record) {
                data.record = $scope.customer.record.id;
            }
            
            if(!data.isActive) {
                delete data.isActive;
            }
            
            delete data.id;
            delete data.created;
            delete data.newPasswordConfirm;
            delete data.roles;
            $http({
                method: 'POST',
                url: './ajax/update/'+$scope.customer.id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({_method: 'POST', darkish_customerbundle_customer: data})
            }).then(
                function(response){
                    $scope.customer = response.data;
                    var roles = [];
                    angular.forEach($scope.customer.roles, function (value, index) {
                        roles[index] = value.id;
                        console.log(value);
                    });
                    $scope.customer.roles = angular.copy(roles);
                    SweetAlert.swal(
                        {
                            title: "ویرایش انجام شد.", 
                            text: "شما به صفحه لیست اپراتورها منتقل خواهید شد.",
                            type: "success"
                        },
                        function(){
                            $state.go('customers')
                        }
                    );
                        
                },
                function(responseErr){
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
            url: '../managedfile/ajax/upload'
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
            $scope.customer.photo = response;
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


customerApp.factory("poollingFactory", function ($timeout) {

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

customerApp.factory('ValuesService', ['$http', function($http){
    self = {};
    var username = null;
    if(!username) {
        $http.get('ajax/get_username').then(
            function(response){
                username = response.data;
                self.username = username;
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

customerApp.factory('SecurityService', ['$http', function($http){
        var self={};
        
            
        
        
        
        
        return self;
        
        
        
    } ]);

customerApp.controller('loginModalCtrl', ['$scope', '$http', '$modalInstance','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, ValuesService, SecurityService) {
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
                                window.location = "../customer/manage";
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