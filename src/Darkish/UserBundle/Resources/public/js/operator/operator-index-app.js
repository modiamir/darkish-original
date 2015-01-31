var operatorApp = angular.module('operatorApp', ['ui.router', 'smart-table', 'ui.router',
    'ngCollection', 'ui.bootstrap', 'cgPrompt', 'angularFileUpload', 'validation.match', 'oitozero.ngSweetAlert',
    'uiSwitch']);

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

operatorApp.controller('operatorIndexCtrl', ['$scope', '$interval', '$collection', '$http',function($scope, $interval, $collection, $http){
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
    $scope.itemsByPage=3;
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
                    url: './ajax/delete_record',
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
                
            },
            function(errResponse){
                
            }
        );

        $scope.test = function() {
            console.log($scope.operatorEdit);
        }
        
        $scope.submit = function() {
            var data = humps.camelizeKeys($scope.operator);
            if($scope.operator.photo) {
                data.photo = $scope.operator.photo.id;
            }
            
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


operatorApp.factory('ValuesService', ['$http', function($http){
    self = {}
    self.accessLevels = [
        {
            label: 'سطح یک',
            value: 1
        },
        {
            label: 'سطح دو',
            value: 2
        },
        {
            label: 'سطح سه',
            value: 3
        },
        {
            label: 'سطح چهار',
            value: 4
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