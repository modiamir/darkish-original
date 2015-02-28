//var classifiedIndexCtrl = angular.module('ClassifiedIndexCtrl', ['classifiedtreeControl', 'angularFileUpload']);
//var classifiedIndexCtrl = classifiedApp.module('ClassifiedIndexCtrl', ['classifiedtreeControl', 'angularFileUpload']);


    // inject the Comment service into our controller
//    classifiedIndexCtrl.controller('ClassifiedIndexController', ['$modal','$scope','$http', '$upload', '$interval', 'ClassifiedTree','ClassifiedControl',
//        function($modal, $scope, $http, $upload, $interval, ClassifiedTree, ClassifiedControl) {
//            $scope.test = "this is test";
//        }]);

angular.module('ClassifiedApp', ['treeControl', 'ui.grid', 'smart-table', 'btford.modal', 'ngCollection', 'ngSanitize', 'ngCkeditor', 'ui.bootstrap', 'ui.bootstrap.persian.datepicker', 'checklist-model',
                            ,'mediaPlayer', 'infinite-scroll','angularFileUpload', 'uiGmapgoogle-maps', 'duScroll'
    ])
    .config(['uiGmapGoogleMapApiProvider', function (GoogleMapApi) {
        GoogleMapApi.configure({
      //    key: 'your api key',
          v: '3.17',
          libraries: 'weather,geometry,visualization'
        });
    }])      
    .controller('ClassifiedIndexCtrl', ['$scope', '$http', '$location', '$filter', '$sce', 'TreeService', 'ClassifiedService', 'ValuesService', '$interval', 'poollingFactory',
                                     'mapModal','FileUploader', '$modal', 'SecurityService',
    function($scope, $http, $location,  $filter, $sce,   TreeService,   ClassifiedService,   ValuesService, $interval, poollingFactory, mapModal,FileUploader, $modal, SecurityService) {

        
        /**
         * initializing config for list endless scroll
         */
        gb = document.getElementsByClassName('grid-block')[0];
        tbl = gb.getElementsByTagName('table')[0];
              
        
        gridblock = angular.element(gb);
        table = angular.element(tbl);
        
        gridblock.on('scroll', function() {
          if(gridblock.scrollTop() + gridblock.height() >= table.height()) {
              ClassifiedService.searchClassified(ClassifiedService.classifiedList().length);
          }
        });
        /////////////////////


        /**
         * 
         * uploader
         */

        var uploader = $scope.uploader = new FileUploader({
            url: '../managedfile/ajax/upload'
        });
        uploader.withCredentials = true;
        uploader.queueLimit =10 ;
        uploader.autoUpload = true;
        uploader.removeAfterUpload = true;
        uploader.formData.push({uploadDir : ValuesService.activeTab});
        uploader.formData.push({type : 'classified'});
        uploader.msg = "";
        
        $scope.selectTab = function(currentTab) {
            ValuesService.activeTab = currentTab;
            uploader.formData.push({uploadDir : ValuesService.activeTab});
        }
        
        // FILTERS
            
        uploader.filters.push({
            name: 'imageTypeFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                if(ValuesService.activeTab == 'image') {
                    uploadableType = "image";
                    uploadableExtensions = ["jpg", "jpeg", "png", "bmp"];
                    fileType = item.type.split("/")[0];
                    fileExtension = item.type.split("/")[1];
                    if(fileType != uploadableType || uploadableExtensions.indexOf(fileExtension) == -1) {
                        return false;
                    }
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
        
        uploader.filters.push({
            name: 'iconTypeFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                if(ValuesService.activeTab == 'icon') {
                    uploadableType = "image";
                    uploadableExtensions = ["jpg", "jpeg", "png"];
                    fileType = item.type.split("/")[0];
                    fileExtension = item.type.split("/")[1];
                    if(fileType != uploadableType || uploadableExtensions.indexOf(fileExtension) == -1) {
                        return false;
                    }
                }
                return true;
                
                 
            }
        });
        
//        uploader.filters.push({
//            name: 'iconSizeFilter',
//            fn: function(item /*{File|FileLikeObject}*/, options) {
//                if(ValuesService.activeTab == 'icon') {
//                    if(item.size > 300000) {
//                        return false;
//                    }
//                }
//                return true;
//                
//                 
//            }
//        });
        
        uploader.filters.push({
            name: 'videoTypeFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                if(ValuesService.activeTab == 'video') {
                    uploadableType = "video";
                    uploadableExtensions = ["mp4"];
                    fileType = item.type.split("/")[0];
                    fileExtension = item.type.split("/")[1];
                    if(fileType != uploadableType || uploadableExtensions.indexOf(fileExtension) == -1) {
                        return false;
                    }
                }
                return true;
                
                 
            }
        });
        
//        uploader.filters.push({
//            name: 'videoSizeFilter',
//            fn: function(item /*{File|FileLikeObject}*/, options) {
//                if(ValuesService.activeTab == 'video') {
//                    if(item.size > 10000000) {
//                        return false;
//                    }
//                }
//                return true;
//                
//                 
//            }
//        });
        
        uploader.filters.push({
            name: 'audioTypeFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                if(ValuesService.activeTab == 'audio') {
                    uploadableType = "audio";
                    uploadableExtensions = ["mp3"];
                    fileType = item.type.split("/")[0];
                    fileExtension = item.type.split("/")[1];
                    if(fileType != uploadableType || uploadableExtensions.indexOf(fileExtension) == -1) {
                        return false;
                    }
                }
                return true;
                
                 
            }
        });
        
//        uploader.filters.push({
//            name: 'audioSizeFilter',
//            fn: function(item /*{File|FileLikeObject}*/, options) {
//                if(ValuesService.activeTab == 'audio') {
//                    if(item.size > 4000000) {
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
                case 'iconTypeFilter':
                    uploader.msg = 'شما فقط میتوانید فایل با پسوندهای   jpeg یا png یا   jpg آپلود کنید.';
                    break;
                case 'iconSizeFilter':
                    uploader.msg = 'iconSizeFilter';
                    break;
                case 'audioTypeFilter':
                    uploader.msg = 'شما فقط میتوانید فایل با پسوندهای   mp3  آپلود کنید.';
                    break;
                case 'audioSizeFilter':
                    uploader.msg = 'audioSizeFilter';
                    break;
                case 'videoTypeFilter':
                    uploader.msg = 'شما فقط میتوانید فایل با پسوندهای   mp4  آپلود کنید.';
                    break;
                case 'videoSizeFilter':
                    uploader.msg = 'videoSizeFilter';
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
            switch(response.upload_dir) {
                case 'image':
                    ClassifiedService.addToImagesList(response);
                    break;
                case 'icon':
                    ClassifiedService.currentClassified.icon = response;
                    break;
                case 'video':
                    ClassifiedService.addToVideosList(response);
                    break;
                case 'audio':
                    ClassifiedService.addToAudiosList(response);
                    break;

            }
            uploader.msg = 'فایل با موفقیت بارگزاری شد.';
        };
        uploader.onErrorItem = function(fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);
            alert(response);
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

        
        //////////////////////////



        /**
         * Banner Uploader start
         */
        
        var bannerUploader = $scope.bannerUploader = new FileUploader({
            url: '../managedfile/ajax/upload'
        });
        bannerUploader.withCredentials = true;
        bannerUploader.queueLimit =10 ;
        bannerUploader.autoUpload = true;
        bannerUploader.removeAfterUpload = true;
        bannerUploader.formData.push({uploadDir : 'banner'});
        bannerUploader.formData.push({type : 'classified'});
        bannerUploader.msg = "";
        
        
        
        // FILTERS
            
        bannerUploader.filters.push({
            name: 'imageTypeFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                if(ValuesService.activeTab == 'image') {
                    uploadableType = "image";
                    uploadableExtensions = ["jpg", "jpeg", "png", "bmp"];
                    fileType = item.type.split("/")[0];
                    fileExtension = item.type.split("/")[1];
                    if(fileType != uploadableType || uploadableExtensions.indexOf(fileExtension) == -1) {
                        return false;
                    }
                }
                return true;
                
                 
            }
        });
        
//        bannerUploader.filters.push({
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

        bannerUploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
            console.info('onWhenAddingFileFailed', item, filter, options);
            switch(filter.name) {
                case 'imageTypeFilter':
                    bannerUploader.msg = "شما فقط میتوانید فایل با پسوند های  png و bmp و jpg آپلود کنید";
                    break;
                case 'imageSizeFilter':
                    bannerUploader.msg = 'imageSizeFilter';
                    break;
            }
        };
        bannerUploader.onAfterAddingFile = function(fileItem) {
            console.info('onAfterAddingFile', fileItem);
        };
        bannerUploader.onAfterAddingAll = function(addedFileItems) {
            console.info('onAfterAddingAll', addedFileItems);
        };
        bannerUploader.onBeforeUploadItem = function(item) {
            console.info('onBeforeUploadItem', item);
        };
        bannerUploader.onProgressItem = function(fileItem, progress) {
            console.info('onProgressItem', fileItem, progress);
        };
        bannerUploader.onProgressAll = function(progress) {
            console.info('onProgressAll', progress);
        };
        bannerUploader.onSuccessItem = function(fileItem, response, status, headers) {
            console.info('onSuccessItem', fileItem, response, status, headers);
            
            ClassifiedService.currentClassified.banner = response;
             
            bannerUploader.msg = 'فایل با موفقیت بارگزاری شد.';
        };
        bannerUploader.onErrorItem = function(fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);
            alert(response);
        };
        bannerUploader.onCancelItem = function(fileItem, response, status, headers) {
            console.info('onCancelItem', fileItem, response, status, headers);
        };
        bannerUploader.onCompleteItem = function(fileItem, response, status, headers) {
            console.info('onCompleteItem', fileItem, response, status, headers);
        };
        bannerUploader.onCompleteAll = function() {
            console.info('onCompleteAll');
        };
        
        ////////////////////

        /**
         * Editor initialization
         */
        CKEDITOR.stylesSet.add( 'my_styles', [
            // سبک های درکیش
            { name: 'تیتر اصلی', element: 'h1', attributes: { 'class': 'body primary-header' } },
            { name: 'تیتر فرعی',  element: 'h2', attributes: { 'class': 'body secondary-header' } },
            { name: 'متن اصلی',  element: 'p', attributes: { 'class': 'body primary-text' } },
            { name: 'متن فرعی',  element: 'p',attributes: { 'class': 'body secondary-text' } },
            { name: 'متن کوچک',  element: 'p',attributes: { 'class': 'body little-text' } },
            { name: 'زیر نویس',  element: 'p',attributes: { 'class': 'body subtitle-text' } },
            { name: 'Titr – Latin',  element: 'h1',attributes: { 'class': 'body latin-primary-header' } },
            { name: 'SubTitr - Latin',  element: 'h2',attributes: { 'class': 'body latin-secondary-header' } },
            { name: 'Text - Latin',  element: 'p',attributes: { 'class': 'body latin-text' } },
            { name: 'Link - Latin',  element: 'p',attributes: { 'class': 'body latin-link' } },
            { name: 'لینک داخلی',  element: 'span',attributes: { 'class': 'body inner-link' } },
            { name: 'لینک اینترنتی',  element: 'span',attributes: { 'class': 'body web-link' } },

        ]);
        //////////////////////
        
        
        


        /**
         *
         *  TreeService initializing
         */
        $scope.TreeService = TreeService;
        $scope.TreeService.updateTree();
        $scope.ValuesService = ValuesService;
        $scope.tree = function() {
            return $scope.TreeService.tree();
        }



        $scope.treeOptions = function() {
            return $scope.TreeService.treeOptions();
        }
        
        /**
         * Tree modal initializing
         */
        
        
        $scope.openTreeModal = function (size) {

            var treeModalInstance = $modal.open({
                templateUrl: 'treeModal.html',
                controller: 'treeModalCtrl',
                size: size,
                resolve: {
                    
                }
            });

            treeModalInstance.result.then(
            function () {
                
            }, function () {
                
            });
        };
        
        //////////////
        
        
        /**
         * Saving modal initialization
         */
        
        
        $scope.openSavingModal = function (size) {

            var treeModalInstance = $modal.open({
                templateUrl: 'savingModal.html',
                controller: 'savingModalCtrl',
                size: size,
                resolve: {
                    
                },
                backdrop: 'static'
            });

            treeModalInstance.result.then(
            function () {
                
            }, function () {
                
            });
        };
        
        //////////////
        
        /**
         * Body modal initialization
         */
        
        
                
        $scope.openBodyModal = function (size) {

            var treeModalInstance = $modal.open({
                templateUrl: 'bodyModal.html',
                controller: 'bodyModalCtrl',
                size: size,
                resolve: {
                    recordform: function(){
                        return $scope.recordform;
                    }
                },
                windowClass: 'body-modal-window'
            });

            treeModalInstance.result.then(
            function () {
                
            }, function () {
                
            });
        };
        
        ///////////////
        
        
        
        
        /**
         * delete modal initialization
         */
        
                
    
            
        $scope.openDeleteModal = function (size) {

            var treeModalInstance = $modal.open({
                templateUrl: 'deleteModal.html',
                controller: 'deleteModalCtrl',
                size: size,
                resolve: {
                    
                },
                windowClass: 'delete-modal-window'
            });

            treeModalInstance.result.then(
            function () {
                
            }, function () {
                
            });
        };
        
        ///////////////
        
        
    
        /**
         * continual modal initialization
         */
        
                
    
            
        $scope.openContinualModal = function (size) {

            var treeModalInstance = $modal.open({
                templateUrl: 'continualModal.html',
                controller: 'continualModalCtrl',
                size: size,
                resolve: {
                    
                },
                windowClass: 'continual-modal-window'
            });

            treeModalInstance.result.then(
            function () {
                
            }, function () {
                
            });
        };
        
        ///////////////


        /**
         * image modal initialization
         */
        
                
    
            
        $scope.openImageModal = function (size, image, index) {
            ValuesService.currentImageModal.image = image; 
            ValuesService.currentImageModal.index = index;

            var treeModalInstance = $modal.open({
                templateUrl: 'imageModal.html',
                controller: 'imageModalCtrl',
                size: size,
                resolve: {
                    
                },
                windowClass: 'image-modal-window'
            });

            treeModalInstance.result.then(
            function () {
                
            }, function () {
                
            });
        };
        
        ///////////////

        /**
         * icon modal initialization
         */
        
                
        
            
        $scope.openIconModal = function (size, icon) {
            ValuesService.currentIconModal = {};
            ValuesService.currentIconModal.image = icon;
            console.log(icon);
            var iconModalInstance = $modal.open({
                templateUrl: 'iconModal.html',
                controller: 'iconModalCtrl',
                size: size,
                resolve: {
                    
                },
                windowClass: 'image-modal-window'
            });

            iconModalInstance.result.then(
            function () {
                
            }, function () {
                
            });
        };
        
        ///////////////
    
        /**
         * video modal initialization
         */
        
                
    
            
        $scope.openVideoModal = function (size, video, index) {
            ValuesService.currentVideoModal.video = video; 
            ValuesService.currentVideoModal.index = index;

            var treeModalInstance = $modal.open({
                templateUrl: 'videoModal.html',
                controller: 'videoModalCtrl',
                size: size,
                resolve: {
                    
                },
                windowClass: 'video-modal-window'
            });

            treeModalInstance.result.then(
            function () {
                
            }, function () {
                
            });
        };
        
        ///////////////
        
        /**
         * audio modal initialization
         */
        
                
    
            
        $scope.openAudioModal = function (size, audio, index) {
            ValuesService.currentAudioModal = {}
            ValuesService.currentAudioModal.Audio = audio; 
            ValuesService.currentAudioModal.index = index;

            var audioModalInstance = $modal.open({
                templateUrl: 'audioModal.html',
                controller: 'audioModalCtrl',
                size: size,
                resolve: {
                    
                },
                windowClass: 'audio-modal-window'
            });

            audioModalInstance.result.then(
            function () {
                
            }, function () {
                
            });
        };
        
        ///////////////
        
        /**
         * cancel modal initialization
         */
        
                
    
            
        $scope.openCancelModal = function (size, form) {
            
            var cancelModalInstance = $modal.open({
                templateUrl: 'cancelModal.html',
                controller: 'cancelModalCtrl',
                size: size,
                resolve: {
                    
                },
                windowClass: 'cancel-modal-window'
            });

            cancelModalInstance.result.then(
            function (setPristine) {
                if(setPristine) {
                    form.$setPristine();
                }
                
                
            }, function () {
                
            });
        };
        
        ///////////////
        
        
        /**
         * body preview modal initialization
         */
        
                
    
            
        $scope.openBodyPreviewModal = function (size) {
            var bodyPreviewModalInstance = $modal.open({
                templateUrl: 'bodyPreviewModal.html',
                controller: 'bodyPreviewModalCtrl',
                size: size,
                resolve: {
                    
                },
                windowClass: 'body-preview-modal-window'
            });

            bodyPreviewModalInstance.result.then(
            function () {
                
                
                
            }, function () {
                
            });
        };
        
        ///////////////
        
        
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


        /**
         * logout modal initialization
         */
        
                
    
            
        $scope.openLogoutModal = function (size) {
            
            var logoutModalInstance = $modal.open({
                templateUrl: 'logoutModal.html',
                controller: 'logoutModalCtrl',
                size: size,
                resolve: {
                    
                },
                windowClass: 'login-modal-window'
            });

            logoutModalInstance.result.then(
            function () {
                
                $scope.logout();
                
                
            }, function () {
                
            });
        };
        
        ///////////////

        /**
         * disconnect modal initialization
         */
        
                
    
            
        $scope.openDisconnectModal = function (size) {
            
            var disconnectModalInstance = $modal.open({
                templateUrl: 'disconnectModal.html',
                controller: 'disconnectModalCtrl',
                size: size,
                resolve: {
                    
                },
                windowClass: 'disconnect-modal-window'
            });

            disconnectModalInstance.result.then(
            function () {
                
                
                
            }, function () {
                
            });
        };
        
        ///////////////


        /**
         *
         *  ClassifiedService Initializing
         */
        $scope.ClassifiedService = ClassifiedService;
        $scope.SecurityService = SecurityService;
        $scope.ClassifiedService.getClassifiedForCat(-3,0);
        $scope.classifiedList = function() {
            return ClassifiedService.classifiedList();
        };

        
        
        

        
        $scope.showMapModal = function(){mapModal.activate()};

        

        


        /**
         *  Date picker configuration
         */
        $scope.today = function() {
            $scope.dt = new Date();
        };
        $scope.today();

        $scope.clear = function () {
            $scope.dt = null;
        };

        // Disable weekend selection
        $scope.disabled = function(date, mode) {
            return ( mode === 'day' &&date.getDay() === 5  );
        };

        $scope.toggleMin = function() {
            $scope.minDate = $scope.minDate ? null : new Date();
        };
        $scope.toggleMin();

        $scope.openExpireDate= function($event) {

           $event.preventDefault();
           $event.stopPropagation();

           $scope.expireDateIsOpen = true;
           $scope.publishDateIsOpen = false;
        };
        $scope.openPublishDate = function($event) {
           $event.preventDefault();
           $event.stopPropagation();

           $scope.publishDateIsOpen = true;
           $scope.expireDateIsOpen = false;
        };

        $scope.publishDateOptions = {
           formatYear: 'yy',
           startingDay: 6
        };
        
        $scope.expireDateOptions = {
           formatYear: 'yy',
           startingDay: 6
        };

        $scope.initDate = new Date('2016-15-20');
        $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
        $scope.format = $scope.formats[0];



        /**
         * 
         * user authentication config
         */

        SecurityService.loggedIn = true;
        SecurityService.connected = true;
        SecurityService.disconnectModalDisplayed = false;

        $scope.logout = function() {
            $http.get('../operator/ajax/logout').then(
                function(response){
                    $scope.loggedOut();
                    window.location = "../classified";
                },
                function(responseErr){
                    console.log(responseErr);
                }
            );
        }

        $scope.isLoggedIn = function() {
            $http.get('../operator/ajax/is_logged_in').then(
                function(response){
//                    console.log(response.data[0]);
                    SecurityService.connected = true;
                    SecurityService.disconnectModalDisplayed = false;
                    if(response.data[0] === false) {
                        SecurityService.loggedIn = false;
                    } else {
                        SecurityService.loggedIn = true;
                    }
                },
                function(responseErr){
                    SecurityService.connected = false;
                    if(SecurityService.disconnectModalDisplayed == false) {
                        SecurityService.disconnectModalDisplayed = true;
                        $scope.openDisconnectModal();
                    }
                }
            );
        }

        $scope.loggedOut = function() {
            SecurityService.loggedIn = false;
        }
        
        $scope.checkConnectionSave = function(contin) {
            $http.get('../user/ajax/is_logged_in').then(
                function(response){
                    SecurityService.connected = true;
                    if(response.data[0] === false) {
                        SecurityService.loggedIn = false;
                    } else {
                        SecurityService.loggedIn = true;    
                    }
                    
                    
                    
                    if(!SecurityService.connected) {
                        $scope.openDisconnectModal();
                    }else
                    if(!SecurityService.loggedIn) {
                        $scope.openLoginModal();
                    } else {
                        contin = (contin)? true : false;
                        $scope.openSavingModal();
                        ClassifiedService.saveCurrentClassified(contin);
                        $scope.classifiedform.$setPristine();

                    }
                }, 
                function(errResponse){
                    $scope.openDisconnectModal();
                }
            );
            
        }

        poollingFactory.callFnOnInterval(function() {
            $scope.isLoggedIn();
        });



        $interval(function(){
            $scope.loaded = true;
        }, 3000);

        /////////////////////////////////



        $scope.trustedBody =  function() {
            tempBody = (ClassifiedService.currentClassified.body)? ClassifiedService.currentClassified.body : "";
            return $sce.trustAsHtml(tempBody);
        }


        /**
         * configuration for time picker -- begin
         */
        $scope.hstep = 1;
        $scope.mstep = 15;
        $scope.ismeridian = false;


        /* configuration for time picker -- begin */


    }])
    .factory("Collection", function($collection){
    var Collection = $collection;

    return Collection;
    })
    .factory("poollingFactory", function ($timeout) {

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
    })
    .factory('TreeService', ['$http', 'ClassifiedService', '$collection', function($http, ClassifiedService, $collection){

        var tree = [];
        
        var treeOptions = {
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
        };

        return {
            tree: function() {
                return tree;
            },
            treeOptions: function() {
                return treeOptions;
            },

            currentTreeNode: tree[0],
            currentSecondTreeNode: tree[0],

            updateTree: function() {
                $http.get('ajax/gettree').then(function(response) {
                    tree = response.data;
                }, function(errResponse) {
                    console.error('Error while fetching notes');
                });
            },
            selectTree: function(node) {
                ClassifiedService.classifiedSearchCriteria = {cid: node.id}
                ClassifiedService.searchClassified();
            }

        };
    }])
    .factory('ClassifiedService', ['$http', 'Collection', 'ValuesService', '$filter' ,function($http, Collection, ValuesService, $filter){
        classifiedList = Collection.getInstance();
        var selectedClassified = {};
//        var currentClassified;





        var self = {

            currentClassified: {active:false, verify:false}



        };


        
        self.removeBanner = function() {
            self.currentClassified.banner = {}
        }
        
        self.list = classifiedList;
        self.nextSelectedClassified = function() {
            var currentIndex = self.currentSelectedClassified();
            if(self.nexable()){
                self.selectClassified(self.list.array[currentIndex+1])
            }
        }

        self.nexable = function() {
            var currentIndex = self.currentSelectedClassified();
            if(currentIndex != null &&
                currentIndex < (self.list.length - 1) ){
                return true;
            }
            return false;
        }

        self.previousSelectedClassified = function() {
            var currentIndex = self.currentSelectedClassified();
            if(self.previousable()){
                self.selectClassified(self.list.array[currentIndex-1])
            }
        }

        self.previousable = function() {
            var currentIndex = self.currentSelectedClassified();
            if(currentIndex != null &&
                currentIndex > 0 ){
                return true;
            }
            return false;
        }

        self.hasVideo = function() {
            if((typeof self.currentClassified.videosList != 'undefined' && self.currentClassified.videosList.length > 0) || 
               (typeof self.currentClassified.bodyVideosList != 'undefined' && self.currentClassified.bodyVideosList.length > 0) ) {
                return true;
            }
            return false;
        }
        
        self.hasAudio = function() {
            if((typeof self.currentClassified.audiosList != 'undefined' && self.currentClassified.audiosList.length > 0) || 
               (typeof self.currentClassified.bodyAudiosList != 'undefined' && self.currentClassified.bodyAudiosList.length > 0)) {
                return true;
            }
            return false;
        }

        self.currentSelectedClassified =function() {
            currentClassifiedIndex = null;
            angular.forEach(self.list.array, function(value,key) {
                if(value.id == selectedClassified.id) {
                    currentClassifiedIndex = key;
                    keepGoing = false;
                }
            })
            return currentClassifiedIndex;
        }

        self.verifyCurrentClassified = function() {
            return $http({
                method: 'PUT',
                url: 'ajax/verify_classified/'+self.currentClassified.id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
            }).then(
                function(response){
                    self.currentClassified.verify = true;
                },
                function(responseErr){
                }
            );
        }

        self.toggleVerifyCurrentClassified = function() {
            if(!self.currentClassified.id) {
                self.currentClassified.verify = !self.currentClassified.verify;
            } else {
                return $http({
                    method: 'PUT',
                    url: 'ajax/toggle_verify_classified/'+self.currentClassified.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                }).then(
                    function(response){
                        self.currentClassified.verify = response.data.verify;
                    },
                    function(responseErr){
                    }
                );
            }

        }

        self.toggleActiveCurrentClassified = function() {
            if(!self.currentClassified.id) {
                self.currentClassified.active = !self.currentClassified.active;
            }else {
                return $http({
                    method: 'PUT',
                    url: 'ajax/toggle_active_classified/'+self.currentClassified.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                }).then(
                    function(response){
                        self.currentClassified.active = response.data.active;
                    },
                    function(responseErr){
                    }
                );
            }

        }


        self.deleteCurrentClassified = function(serv) {
            if(self.currentClassified.id) {
                $http({
                    method: 'PUT',
                    url: 'ajax/delete_classified/'+self.currentClassified.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                }).then(
                    function(response){
                        classifiedList.remove(selectedClassified);
                        self.currentClassified = {}
                        temporaryClassified = {}
                        serv.close();
                    },
                    function(responseErr){
                        console.log(responseErr)
                    }
                );
            }
        }




        self.currentClassified.treeList = Collection.getInstance();
        self.currentClassified.images = Collection.getInstance()
        self.currentClassified.videos = Collection.getInstance()
        self.currentClassified.audios = Collection.getInstance()

        self.saved = false;

        self.currentCid;

        self.classifiedSearchCriteria = {};

//        self.list = function() {
//            return items;
//        };

        self.selectedClassified= function() {
            return selectedClassified;
        };

        self.getClassifiedForCat = function(cid, count) {
            
            $http.get('ajax/get_total_classified_for_cat/'+cid).then(function(response){
                self.totalClassified = response.data;
            },function(errResponse){
            });
            
            $http.get('ajax/get_classified_for_cat/'+cid+'/'+count).then(function(response){
                if(!count) {classifiedList.removeAll();}
                classifiedList.addAll(response.data);
                self.currentCid = cid;
                if(!count) {selectedClassified = {id:0};}
            },function(errResponse){
            });
        };

        self.getClassifiedByCriteria = function(count) {
            if(!self.classifiedSearchCriteria.searchKeyword) {
                self.classifiedSearchCriteria.searchKeyword = "";
            }
            if(!self.classifiedSearchCriteria.searchBy) {
                self.classifiedSearchCriteria.searchBy = "1";
            }
            if(!self.classifiedSearchCriteria.sortBy) {
                self.classifiedSearchCriteria.sortBy = "1";
            }

            var lastSep = (self.classifiedSearchCriteria.searchKeyword)?'/':'';
            
            $http.get('ajax/total_search_classified/'+
                self.classifiedSearchCriteria.searchBy+'/'+
                self.classifiedSearchCriteria.sortBy+'/'+
                self.classifiedSearchCriteria.searchKeyword
                ).then(function(response){
                self.totalClassified = response.data;
            },function(errResponse){
            });
            
            $http.get('ajax/search_classified/'+
                self.classifiedSearchCriteria.searchBy+'/'+
                self.classifiedSearchCriteria.sortBy+'/'+
                count+
                lastSep
                +
                self.classifiedSearchCriteria.searchKeyword
                ).then(function(response){

                if(!count) {classifiedList.removeAll();}
                classifiedList.addAll(response.data);
                self.currentCid = null;
                if(!count){selectedClassified = {id:0};}
            },function(errResponse){
            });
        }

        self.searchClassified = function(count) {
            
            if(!count) {
                count=0;
            }
            if(self.classifiedSearchCriteria.cid !=null) {
                self.getClassifiedForCat(self.classifiedSearchCriteria.cid, count)
            } else {
                self.classifiedSearchCriteria.cid = null;
                self.getClassifiedByCriteria(count);
            }

        }

        self.classifiedList = function() {
            return classifiedList.all();
        };

        var temporaryClassified = {}

        self.file = null;

        var editing = false;
        self.isEditing = function() {
            return editing;
        }

        self.editingNew= function() {

            temporaryClassified = angular.copy(self.currentClassified);
            self.currentClassified = angular.copy({});
            self.currentClassified.treeList = Collection.getInstance();
            self.currentClassified.imagesList = Collection.getInstance();
            self.currentClassified.bodyImagesList = Collection.getInstance();
            self.currentClassified.videosList = Collection.getInstance();
            self.currentClassified.bodyVideosList = Collection.getInstance();
            self.currentClassified.audiosList = Collection.getInstance();
            self.currentClassified.bodyAudiosList = Collection.getInstance();
            self.currentClassified.bodyDocsList = Collection.getInstance();
            
            

            


            /**
             * initializing verify active --begin
             */

            self.currentClassified.verify = false;
            self.currentClassified.active = false;
            self.currentClassified.continual = true; 
            self.currentClassified.rate = 10; 
            /* initializing verify active --end  */

            

            editing = true;
            ValuesService.getRandUploadKey(true);
            
            self.currentClassified.publish_date = new Date();


        }

        self.isReadyToInsert = function() {
            switch(ValuesService.bodyAttachmentActiveTab) {
                case 'image':
                    if(self.selectedBodyImage) {
                        return true;
                    }
                    break;
                case 'video':
                    if(self.selectedBodyVideo) {
                        return true;
                    }
                    break;
                case 'audio':
                    if(self.selectedBodyAudio) {
                        return true;
                    }
                    break;
                case 'doc':
                    if(self.selectedBodyDoc) {
                        return true;
                    }
                    break;
                default:
                    return false;
            }
            return false;
        }


        self.editing = function() {
            temporaryClassified = angular.copy(self.currentClassified);
            editing = true;
        }

        self.cancelEditing = function() {
            self.currentClassified = angular.copy(temporaryClassified);
            editing = false;
        }

        self.selectedImages = []

        self.selectedBodyImages = []

        self.selectedVideos = []

        self.selectedBodyVideos = []

        self.selectedAudios = []

        self.selectedBodyAudios = []
        
        self.selectedBodyDocs = []


        self.selectedImage = {}

        self.selectedBodyImage = {}

        self.selectedVideo = {}

        self.selectedBodyVideo= {}

        self.selectedAudio = {}

        self.selectedBodyVideo = {}




        self.getTime = function(datetime) {
            hours = datetime.getHours();
            times = datetime.getMinutes();
            hours = ((""+hours).length == 1) ? '0'+ hours : ""+hours;
            times = ((""+times).length == 1) ? '0'+ times : ""+times;
            return hours+':'+times;
        }


        self.finishEditing = function() {
            temporaryClassified = {}
            editing = false;
        }

        self.selectClassified = function(classified) {
            selectedClassified = classified;
            $http.get('ajax/get_classified/'+classified.id).then(
                function(response) {
                    self.currentClassified = response.data;
                    

                    
                    self.currentClassified.treeList = Collection.getInstance();
                    self.currentClassified.treeList.addAll(self.currentClassified.classifiedtrees);

                    self.currentClassified.imagesList = Collection.getInstance();
                    self.currentClassified.imagesList.addAll(self.currentClassified.images);

                    self.currentClassified.videosList = Collection.getInstance();
                    self.currentClassified.videosList.addAll(self.currentClassified.videos);
                    self.currentClassified.videoPlaylist = [];
                    angular.forEach(self.currentClassified.videos, function(value, key){
                        var playlistItem = {};
                        playlistItem.src = value.absolute_path;
                        playlistItem.type = value.filemime;
                        self.currentClassified.videoPlaylist.push(playlistItem);
                    });


                    self.currentClassified.audiosList = Collection.getInstance();
                    self.currentClassified.audiosList.addAll(self.currentClassified.audios);
                    self.currentClassified.audioPlaylist = [];
                    angular.forEach(self.currentClassified.audios, function(value, key){
                        var playlistItem = {};
                        playlistItem.src = value.absolute_path;
                        playlistItem.type = value.filemime;
                        self.currentClassified.audioPlaylist.push(playlistItem);
                    });


                    self.currentClassified.bodyImagesList = Collection.getInstance();
                    self.currentClassified.bodyImagesList.addAll(self.currentClassified.body_images);

                    self.currentClassified.bodyVideosList = Collection.getInstance();
                    self.currentClassified.bodyVideosList.addAll(self.currentClassified.body_videos);

                    self.currentClassified.bodyAudiosList = Collection.getInstance();
                    self.currentClassified.bodyAudiosList.addAll(self.currentClassified.body_audios);
                    
                    self.currentClassified.bodyDocsList = Collection.getInstance();
                    self.currentClassified.bodyDocsList.addAll(self.currentClassified.body_docs);
                },
                function(errResponse) {
                }
            );

        };

        self.addToImagesList = function(obj) {
            self.currentClassified.imagesList.add(obj);
            self.currentClassified.images = self.currentClassified.imagesList.all();
        }

        self.addToBodyImagesList = function(obj) {
            self.currentClassified.bodyImagesList.add(obj);
            self.currentClassified.body_images = self.currentClassified.bodyImagesList.all();
        }

        self.addToVideosList = function(obj) {
            self.currentClassified.videosList.add(obj);
            self.currentClassified.videos = self.currentClassified.videosList.all();
            playlistItem = {};
            playlistItem.src = obj.absolute_path;
            playlistItem.type = obj.filemime;
            self.currentClassified.videoPlaylist.push(playlistItem);
        }

        self.addToBodyVideosList = function(obj) {
            self.currentClassified.bodyVideosList.add(obj);
            self.currentClassified.body_videos = self.currentClassified.bodyVideosList.all();
        }

        self.addToAudiosList = function(obj) {
            self.currentClassified.audiosList.add(obj);
            self.currentClassified.audios = self.currentClassified.audiosList.all();
            playlistItem = {};
            playlistItem.src = obj.absolute_path;
            playlistItem.type = obj.filemime;
            self.currentClassified.audioPlaylist.push(playlistItem);
        }

        self.addToBodyAudiosList = function(obj) {
            self.currentClassified.bodyAudiosList.add(obj);
            self.currentClassified.body_audios = self.currentClassified.bodyAudiosList.all();
        }
        
        self.addToBodyDocsList = function(obj) {
            self.currentClassified.bodyDocsList.add(obj);
            self.currentClassified.body_docs = self.currentClassified.bodyDocsList.all();
        }

        self.removeFromAttachList = function() {
            switch(ValuesService.activeTab) {
                case 'image':
                    angular.forEach(self.selectedImages, function(value, key){
                        self.currentClassified.imagesList.remove(value);
                    });
                    self.currentClassified.images = self.currentClassified.imagesList.all();
                    break;
                case 'icon':
                    
                    self.currentClassified.icon = {};
                    break;
                case 'video':
                    angular.forEach(self.selectedVideos, function(value, key){
                        self.currentClassified.videosList.remove(value);
                    });
                    self.currentClassified.videos = self.currentClassified.videosList.all();
                    break;
                case 'audio':
                    angular.forEach(self.selectedAudios, function(value, key){
                        self.currentClassified.audiosList.remove(value);
                    });
                    self.currentClassified.audios = self.currentClassified.audiosList.all();
                    break;

            }

        }
        
        self.cleanBodyAttachments = function() {
            bodyDom = angular.element(self.currentClassified.body);
            angular.forEach(self.currentClassified.bodyImagesList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentClassified.bodyImagesList.remove(value);
                }
            });
            self.currentClassified.body_images = self.currentClassified.bodyImagesList.all();
            
            angular.forEach(self.currentClassified.bodyVideosList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentClassified.bodyVideosList.remove(value);
                }
            });
            self.currentClassified.body_videos = self.currentClassified.bodyVideosList.all();
            
            angular.forEach(self.currentClassified.bodyAudiosList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentClassified.bodyAudiosList.remove(value);
                }
            });
            self.currentClassified.body_audios = self.currentClassified.bodyAudiosList.all();
            
            angular.forEach(self.currentClassified.bodyDocsList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentClassified.bodyDocsList.remove(value);
                }
            });
            self.currentClassified.body_docs = self.currentClassified.bodyDocsList.all();
            
        }

        self.removeFromBodyAttachList = function() {
            switch(ValuesService.bodyAttachmentActiveTab) {
                case 'image':
                    angular.forEach(self.selectedBodyImages, function(value, key){
                        
                        bodyDom = angular.element(self.currentClassified.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentClassified.bodyImagesList.remove(value);
                        }
                        
                    });
                    self.currentClassified.body_images = self.currentClassified.bodyImagesList.all();
                    break;
                case 'video':
                    angular.forEach(self.selectedBodyVideos, function(value, key){
                        bodyDom = angular.element(self.currentClassified.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentClassified.bodyVideosList.remove(value);
                        }
                        
                    });
                    self.currentClassified.body_videos = self.currentClassified.bodyVideosList.all();
                    break;
                case 'audio':
                    angular.forEach(self.selectedBodyAudios, function(value, key){
                        bodyDom = angular.element(self.currentClassified.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentClassified.bodyAudiosList.remove(value);
                        }
                        
                    });
                    self.currentClassified.body_audios = self.currentClassified.bodyAudiosList.all();
                    break;
                
                case 'doc':
                    angular.forEach(self.selectedBodyDocs, function(value, key){
                        bodyDom = angular.element(self.currentClassified.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentClassified.bodyDocsList.remove(value);
                        }
                        
                    });
                    self.currentClassified.body_docs = self.currentClassified.bodyDocsList.all();
                    break;

            }

        }







        self.addToTreeList = function(obj, sort)  {
            angular.forEach(self.currentClassified.treeList.array, function(value, key){
                if(obj.id == value.tree.id) {
                    self.currentClassified.treeList.remove(value);
                }
            });
            obj.sort = sort;
            var tree = {};
            tree.tree = obj;
            tree.sort = (sort)?sort:60;
            self.currentClassified.treeList.update(tree);
            self.currentClassified.classifiedtrees = self.currentClassified.treeList.all() ;
            return obj.title+" به رکورد اضافه شد.";
        }

        self.removeFromTreeList = function(selectedTrees)  {
            selectedTrees.forEach(function(tree, index, selectedTrees){
                self.currentClassified.treeList.remove(tree);
            });

            self.currentClassified.classifiedtrees = self.currentClassified.treeList.all() ;
        }

        self.updateCurrentClassified = function() {
            self.currentClassified._csrf_token = ValuesService.csrf;
            return $http({
                method: 'PUT',
                url: 'ajax/'+self.currentClassified.id+'/update',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({data: angular.toJson(self.currentClassified)})
            });
        }

        self.saveCurrentNewClassified = function() {
            self.currentClassified._csrf_token = ValuesService.csrf;
            self.currentClassified.uploadKey = ValuesService.getRandUploadKey();
            return $http({
                method: 'POST',
                url: 'ajax/create',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({data: angular.toJson(self.currentClassified)})
            });
        }

        self.isNew = function() {
            if(self.currentClassified.id) {
                return false;
            } else {
                return true;
            }
        }



        self.saveCurrentClassified = function(contin) {
            contin = (contin)? true : false;
            self.savingMessages = {}
            self.saved = false;
            if(!contin){
                self.cleanBodyAttachments();
            }
            if(self.isNew()) {

                self.saveCurrentNewClassified().then(
                    function(response){
//                        self.currentClassified = {}
//                        self.currentClassified = response.data[0];

                        self.currentClassified.id = response.data[0].id;
                        self.selectClassified(self.currentClassified);
                        self.saved = true;
                        self.savingMessages = ['خبر مورد نظر ذخیره شد.'];
                        if(!contin) {
                            self.searchClassified();
                            self.finishEditing();
                        } else {
                            temporaryClassified = angular.copy(self.currentClassified);
                        }
                    },
                    function(errResponse){
                        self.saved = true;
                        self.savingMessages = errResponse.data;
                        self.savingMessageIsArray = (angular.isArray(self.savingMessages))? true:false;
                        console.log(errResponse);
                    }
                );
            } else {
                self.updateCurrentClassified().then(
                    function(response){
//                        self.currentClassified = response.data;
                        self.saved = true;
                        self.savingMessages = ['خبر مورد نظر ذخیره شد.'];
                        if(!contin) {
                            self.searchClassified();
                            self.finishEditing();
                        }else {
                            temporaryClassified = angular.copy(self.currentClassified);
                        }
                    },
                    function(errResponse){
                        self.saved = true;
                        self.savingMessages = errResponse.data;
                        self.savingMessageIsArray = (angular.isArray(self.savingMessages))? true:false;
                        console.log(errResponse);
                    }
                );
            }
        }
        
        

        

        self.isSelected = function(classified) {
            if(classified.id == selectedClassified.id) {
                return true;
            }
            else return false;
        };

        return self;
    }]).
    factory('mapModal', function (btfModal) {
        return btfModal({
            controller: 'mapModalCtrl',
            controllerAs: 'mapModal',
            templateUrl: 'map-modal.html'
        });
    }).

    controller('treeModalCtrl', ['$scope', 'ClassifiedService','TreeService', '$modalInstance', function ($scope, ClassifiedService, TreeService, $modalInstance) {
        $scope.ClassifiedService = ClassifiedService;
        $scope.TreeService = TreeService;
        $scope.tree = function() {
            return $scope.TreeService.tree();
        }

        $scope.treeOptions = function() {
            return $scope.TreeService.treeOptions();
        }
        
        $scope.close = function () {
            $modalInstance.close();
        };

        $scope.addTerm = function(term) {

        }
    }]).
    controller('bodyTreeModalCtrl', ['$scope', 'ClassifiedService','TreeService', '$modalInstance', function ($scope, ClassifiedService, TreeService, $modalInstance) {
        $scope.ClassifiedService = ClassifiedService;
        $scope.TreeService = TreeService;
        $scope.tree = function() {
            return $scope.TreeService.tree();
        }
        
        
        $scope.mainTreeOptions = function() {
            return $scope.TreeService.treeOptions();
        }
        $scope.treeOptions = angular.copy($scope.TreeService.treeOptions());
        $scope.treeOptions.dirSelectable = true;
        
        $scope.close = function () {
            $modalInstance.close();
        };

        var CkInstance = null;
        angular.forEach(CKEDITOR.instances,function(value, key){CkInstance = value; keepGoing = false;})
        
        $scope.insertTree = function() {
            
            console.log($scope.currentBodyTreeNode);
            CkInstance.insertHtml('<a href="#" class="body inner-link " tree-index="'+$scope.currentBodyTreeNode.treeIndex+'">'+$scope.currentBodyTreeNode.title+'</a>');
            $scope.close();
        }
    }]).
    controller('bodyClassifiedModalCtrl', ['$scope', 'ClassifiedService','TreeService', '$modalInstance', function ($scope, ClassifiedService, TreeService, $modalInstance) {
        $scope.ClassifiedService = ClassifiedService;
        $scope.TreeService = TreeService;
        $scope.text = "";
        $scope.classifiedId = "";
        
        $scope.close = function () {
            $modalInstance.close();
        };

        var CkInstance = null;
        angular.forEach(CKEDITOR.instances,function(value, key){CkInstance = value; keepGoing = false;})
        
        $scope.insertClassified = function() {
            
            console.log($scope.currentBodyTreeNode);
            CkInstance.insertHtml('<a href="#" class="body inner-link " classified-id="'+$scope.classifiedId+'">'+$scope.text+'</a>');
            $scope.close();
        }
    }]).
    controller('insertLinkModalCtrl', ['$scope', 'ClassifiedService','TreeService', '$modalInstance', function ($scope, ClassifiedService, TreeService, $modalInstance) {
        $scope.ClassifiedService = ClassifiedService;
        $scope.TreeService = TreeService;
        $scope.text = "";
        $scope.link = "";
        
        $scope.close = function () {
            $modalInstance.close();
        };

        var CkInstance = null;
        angular.forEach(CKEDITOR.instances,function(value, key){CkInstance = value; keepGoing = false;})
        
        $scope.insertLink = function() {
            $scope.insertableLink= 'http://'+$scope.link;
            console.log($scope.currentBodyTreeNode);
            CkInstance.insertHtml('<a class="body web-link " href="'+$scope.insertableLink+'">'+$scope.text+'</a>');
            $scope.close();
        }
    }]).
    controller('savingModalCtrl', ['$scope', 'ClassifiedService','TreeService', '$modalInstance', function ($scope, ClassifiedService, TreeService, $modalInstance) {
        $scope.ClassifiedService = ClassifiedService;
        $scope.close = function(){$modalInstance.backdrop = true; $modalInstance.close();}

    }]).
    controller('deleteModalCtrl', ['$scope', '$modalInstance', 'ClassifiedService','TreeService', function ($scope, $modalInstance, ClassifiedService, TreeService) {
        $scope.ClassifiedService = ClassifiedService;
        $scope.close = function(){$modalInstance.close();}
        $scope.deleteCurrentClassified = function() {
            console.log(ClassifiedService.deleteCurrentClassified($modalInstance));
        }
    }]).
    controller('continualModalCtrl', ['$scope', '$http', '$modalInstance', 'ClassifiedService','TreeService', function ($scope, $http, $modalInstance, ClassifiedService, TreeService) {
        $scope.ClassifiedService = ClassifiedService;
        $scope.images = angular.copy(ClassifiedService.currentClassified.imagesList.all());
        $scope.audios = angular.copy(ClassifiedService.currentClassified.audiosList.all());
        $scope.videos = angular.copy(ClassifiedService.currentClassified.videosList.all());
        
        $scope.bodyImages = angular.copy(ClassifiedService.currentClassified.bodyImagesList.all());
        $scope.bodyAudios = angular.copy(ClassifiedService.currentClassified.bodyAudiosList.all());
        $scope.bodyDocs = angular.copy(ClassifiedService.currentClassified.bodyDocsList.all());
        $scope.bodyVideos = angular.copy(ClassifiedService.currentClassified.bodyVideosList.all());
        $scope.close = function(){$modalInstance.close();}
        $scope.save = function() {
            ClassifiedService.currentClassified.imagesList.removeAll();
            ClassifiedService.currentClassified.imagesList.addAll($scope.images);
            ClassifiedService.currentClassified.images = ClassifiedService.currentClassified.imagesList.all();

            ClassifiedService.currentClassified.audiosList.removeAll();
            ClassifiedService.currentClassified.audiosList.addAll($scope.audios);
            ClassifiedService.currentClassified.audios = ClassifiedService.currentClassified.audiosList.all();

            ClassifiedService.currentClassified.videosList.removeAll();
            ClassifiedService.currentClassified.videosList.addAll($scope.videos);
            ClassifiedService.currentClassified.videos = ClassifiedService.currentClassified.videosList.all();

            ClassifiedService.currentClassified.bodyImagesList.removeAll();
            ClassifiedService.currentClassified.bodyImagesList.addAll($scope.bodyImages);
            ClassifiedService.currentClassified.body_images = ClassifiedService.currentClassified.bodyImagesList.all();

            ClassifiedService.currentClassified.bodyAudiosList.removeAll();
            ClassifiedService.currentClassified.bodyAudiosList.addAll($scope.bodyAudios);
            ClassifiedService.currentClassified.body_audios = ClassifiedService.currentClassified.bodyAudiosList.all();
            
            ClassifiedService.currentClassified.bodyDocsList.removeAll();
            ClassifiedService.currentClassified.bodyDocsList.addAll($scope.bodyDocs);
            ClassifiedService.currentClassified.body_docs = ClassifiedService.currentClassified.bodyDocsList.all();

            ClassifiedService.currentClassified.bodyVideosList.removeAll();
            ClassifiedService.currentClassified.bodyVideosList.addAll($scope.bodyVideos);
            ClassifiedService.currentClassified.body_videos = ClassifiedService.currentClassified.bodyVideosList.all();
            
            $modalInstance.close();
        }
        
    }]).
        
    controller('imageModalCtrl', ['$scope', '$modalInstance', 'ClassifiedService','TreeService', 'ValuesService', function ($scope, $modalInstance, ClassifiedService, TreeService, ValuesService) {
        $scope.ClassifiedService = ClassifiedService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentImageModal = {}; $modalInstance.close();}
        $scope.currentImage = ClassifiedService.currentClassified.images[ValuesService.currentImageModal.index];
        $scope.totalImage = ClassifiedService.currentClassified.images.length;
        $scope.currentIndex = ValuesService.currentImageModal.index + 1;
        $scope.next = function() {
            ValuesService.currentImageModal.index = ValuesService.currentImageModal.index + 1;
            $scope.currentImage = ClassifiedService.currentClassified.images[ValuesService.currentImageModal.index];
            $scope.currentIndex = ValuesService.currentImageModal.index + 1;
        }
        $scope.prev = function() {
            ValuesService.currentImageModal.index = ValuesService.currentImageModal.index -1;
            $scope.currentImage = ClassifiedService.currentClassified.images[ValuesService.currentImageModal.index];
            $scope.currentIndex = ValuesService.currentImageModal.index + 1;
        }



    }]).
    controller('iconModalCtrl', ['$scope', '$modalInstance', 'ClassifiedService','TreeService', 'ValuesService', function ($scope, $modalInstance, ClassifiedService, TreeService, ValuesService) {
        $scope.ClassifiedService = ClassifiedService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentIconModal = {}; $modalInstance.close();}
        $scope.icon = ValuesService.currentIconModal.image;
        



    }]).
    controller('videoModalCtrl', ['$scope', '$sce', '$modalInstance', 'ClassifiedService','TreeService', 'ValuesService', function ($scope, $sce, $modalInstance, ClassifiedService, TreeService, ValuesService) {
        $scope.ClassifiedService = ClassifiedService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentVideoModal = {}; $modalInstance.close();}
        $scope.currentVideo = ClassifiedService.currentClassified.videos[ValuesService.currentVideoModal.index];
        $scope.totalVideo = ClassifiedService.currentClassified.videos.length;
        $scope.currentIndex = ValuesService.currentVideoModal.index + 1;
        $scope.next = function() {
            ValuesService.currentVideoModal.index = ValuesService.currentVideoModal.index + 1;
            $scope.currentVideo = ClassifiedService.currentClassified.videos[ValuesService.currentVideoModal.index];
            $scope.currentIndex = ValuesService.currentVideoModal.index + 1;
            var videoPlayer = document.getElementById('modal-video-player');
            videoPlayer.src = $scope.currentVideo.absolute_path;
            videoPlayer.load();
            videoPlayer.play();
        }
        $scope.prev = function() {
            ValuesService.currentVideoModal.index = ValuesService.currentVideoModal.index -1;
            $scope.currentVideo = ClassifiedService.currentClassified.videos[ValuesService.currentVideoModal.index];
            $scope.currentIndex = ValuesService.currentVideoModal.index + 1;
            var videoPlayer = document.getElementById('modal-video-player');
            videoPlayer.src = $scope.currentVideo.absolute_path;
            videoPlayer.load();
            videoPlayer.play();
        }

    }]).
    controller('audioModalCtrl', ['$scope', '$sce', '$modalInstance', 'ClassifiedService','TreeService', 'ValuesService', function ($scope, $sce, $modalInstance, ClassifiedService, TreeService, ValuesService) {
        $scope.ClassifiedService = ClassifiedService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentAudioModal = {}; $modalInstance.close();}
        $scope.currentAudio = ClassifiedService.currentClassified.audios[ValuesService.currentAudioModal.index];
        $scope.totalAudio = ClassifiedService.currentClassified.audios.length;
        $scope.currentIndex = ValuesService.currentAudioModal.index + 1;
        $scope.next = function() {
            ValuesService.currentAudioModal.index = ValuesService.currentAudioModal.index + 1;
            $scope.currentAudio = ClassifiedService.currentClassified.audios[ValuesService.currentAudioModal.index];
            $scope.currentIndex = ValuesService.currentAudioModal.index + 1;
            var audioPlayer = document.getElementById('modal-audio-player');
            audioPlayer.src = $scope.currentAudio.absolute_path;
            audioPlayer.load();
            audioPlayer.play();
        }
        $scope.prev = function() {
            ValuesService.currentAudioModal.index = ValuesService.currentAudioModal.index -1;
            $scope.currentAudio = ClassifiedService.currentClassified.audios[ValuesService.currentAudioModal.index];
            $scope.currentIndex = ValuesService.currentAudioModal.index + 1;
            var audioPlayer = document.getElementById('modal-audio-player');
            audioPlayer.src = $scope.currentAudio.absolute_path;
            audioPlayer.load();
            audioPlayer.play();
        }

    }]).
    controller('cancelModalCtrl', ['$scope', '$modalInstance', 'ClassifiedService','TreeService', function ($scope, $modalInstance, ClassifiedService, TreeService) {
        $scope.ClassifiedService = ClassifiedService;
        $scope.close = function(){$modalInstance.close(false);}
        $scope.cancel = function() {
            ClassifiedService.cancelEditing(); 
            $modalInstance.close(true);
        }
    }]).
    controller('loginModalCtrl', ['$scope', '$http', '$modalInstance', 'ClassifiedService','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, ClassifiedService, ValuesService, SecurityService) {
        $scope.ClassifiedService = ClassifiedService;
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
                                window.location = "../classified";
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
    }]).
        
    controller('logoutModalCtrl', ['$scope', '$http', '$modalInstance', 'ClassifiedService','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, ClassifiedService, ValuesService, SecurityService) {
        $scope.ClassifiedService = ClassifiedService;
        
        $scope.cancel = function() {
            $modalInstance.dismiss();
        }
        $scope.logout = function() {
            $modalInstance.close();
        }
    }]).
    controller('disconnectModalCtrl', ['$scope', '$http', '$modalInstance', 'ClassifiedService','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, ClassifiedService, ValuesService, SecurityService) {
        $scope.ClassifiedService = ClassifiedService;
        $scope.close = function(){$modalInstance.close(false);}
        
    }]).
    controller('bodyPreviewModalCtrl', ['$scope', '$http', '$sce', '$collection', '$modalInstance', 'ClassifiedService','ValuesService', 'SecurityService', function ($scope, $http, $sce, $collection, $modalInstance, ClassifiedService, ValuesService, SecurityService) {
        $scope.ClassifiedService = ClassifiedService;
        $scope.close = function(){$modalInstance.close(false);}
        $scope.getTrustedBody =  function(untrustedBody) {
            tempBody = (untrustedBody)? untrustedBody : "";
            return $sce.trustAsHtml(tempBody);
        }
        $scope.history = $collection.getInstance();
        $scope.trustedBody = $scope.getTrustedBody(ClassifiedService.currentClassified.body);
        $scope.innerLink = true;
        $scope.externalLink = false;
        
        $scope.loadClassified = function(classifiedId) {
            $scope.innerLink = true;
            $scope.externalLink = false;
            $http.get('ajax/get_classified_by_id/' + classifiedId).then(
                    function (response) {
                        $scope.rtTitle = response.data.title;
                        $scope.trustedBody = $scope.getTrustedBody(response.data.body);
                        $scope.observeEvents();
                    },
                    function (errResponse) {
                        $scope.rtTitle = '<span style="color:red">ناموجود</span>'
                    }
            );
        }
        $scope.loadTree = function(treeIndex) {
            $http.get('ajax/get_tree_by_index/' + treeIndex).then(
                    function (response) {
                        $scope.innerLink = true;
                        $scope.externalLink = false;
                        $scope.rtTitle = response.data.title;
                        $scope.observeEvents();
                    },
                    function (errResponse) {
                        $scope.rtTitle = '<span style="color:red">ناموجود</span>'
                    }
            );
        }
        
        $scope.loadExternal = function(url) {
            $scope.innerLink = false;
            $scope.externalLink = true;
            $scope.trustedUrl = $sce.trustAsResourceUrl(url);
            $scope.url = url;
            $scope.trustedBody = "";
        }
        
        $scope.observeEvents = function() {
            setTimeout(function () {
                angular.element(document.querySelectorAll('.body-preview-content a[classified-id]')).unbind('click');
                angular.element(document.querySelectorAll('.body-preview-content a[classified-id]')).on('click', function (event) {
                    classifiedId = event.toElement.getAttribute('classified-id');
                    $scope.loadClassified(classifiedId);
                    $scope.history.add({func: $scope.loadClassified, arg: classifiedId});
                    event.preventDefault();
                });

                angular.element(document.querySelectorAll('.body-preview-content a[tree-index]')).unbind('click');
                angular.element(document.querySelectorAll('.body-preview-content a[tree-index]')).on('click', function (event) {
                    console.log(event);
                    treeIndex = event.toElement.getAttribute('tree-index');
                    $scope.loadTree(treeIndex);
                    $scope.history.add({func: $scope.loadTree, arg: treeIndex});
                    event.preventDefault();
                });
                
                
                angular.element($(".body-preview-content a[href != '#']")).unbind('click');
                angular.element($(".body-preview-content a[href != '#']")).on('click', function (event) {
                    console.log(event);
                    url = event.toElement.getAttribute('href');
                    $scope.loadExternal(url);
                    $scope.history.add({func: $scope.loadExternal, arg: url});
                    event.preventDefault();
                });
                
                $(".body-preview-content a[href]").filter(function(){
                    var href = $(this).attr('href');
                    return (href[0] == '#' && href.length > 1)
                }).unbind('click').on('click', function(){
                    var id = $(this).attr('href');
                    
                    $('.body-preview-box .body-preview-content').animate({
                        scrollTop: $(id).offset().top
                    },100);
                    
                });
//                $('.body-preview-content img').css('width', '90%');
                
                $('.body-preview-content img').filter(function(){
                    return $(this).css('border-width') == '0px';
                    
                }).css('border-width', '0').css('width', '90%');
                
            }, 500);
        }
        $scope.observeEvents();
        
        $scope.history.add({func: $scope.loadClassified, arg: ClassifiedService.currentClassified.id});
        $scope.back = function() {
            var func = $scope.history.array[$scope.history.length-2];
            func.func(func.arg);
            $scope.history.remove($scope.history.array[$scope.history.length-1]);
        }
        
        $scope.hasBack = function() {
            if($scope.history.length > 1) {
                return true;
            } else {
                return false;
            }
        }
        $scope.goToTop = function() {
            section = document.getElementsByClassName('body-preview-content')[0];
            sectionElm = angular.element(section);
            sectionElm.scrollTo(0,0);
            
        }
        
    }]).
    controller('bodyModalCtrl', ['$scope', '$http', 'ClassifiedService','TreeService', 'ValuesService','SecurityService', 'FileUploader', '$modalInstance', '$modal', 'recordform', 
        function (                $scope,   $http,   ClassifiedService,  TreeService,   ValuesService, SecurityService, FileUploader, $modalInstance, $modal, recordform) {
        $scope.recordform = recordform;
        $scope.ClassifiedService = ClassifiedService;
        $scope.TreeService = TreeService;
        $scope.ValuesService = ValuesService;
        $scope.SecurityService = SecurityService;
        $scope.bodyEditorOptions = {
            language: 'fa',
            height: '500px',
            uiColor: '#e8ede0',
            extraPlugins: "dragresize,video,templates,dialog,colorbutton,lineheight,halfhr,record,mycustom,tabletools,contextmenu,contextmenu,menu,floatpanel,panel,tableresize,colordialog,dialogadvtab",
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
            toolbar: [
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Halfhr', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'Video', 'Classified' ] },
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize', 'Templates', 'TextColor', 'BGColor', 'lineheight' ] },
                { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                { name: 'others', items: [ '-' ] },
                { name: 'about', items: [ 'About' ] }
            ],
            toolbarGroups : [
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
                { name: 'forms' },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
                { name: 'links' },
                { name: 'insert' },
                '/',
                { name: 'styles' },
                { name: 'colors' },
                { name: 'tools' },
                { name: 'others' },
                { name: 'about' }
            ]
        };

        /**
         * Tree modal initializing
         */
        
        
        $scope.openBodyTreeModal = function (size) {

            var bodyTreeModalInstance = $modal.open({
                templateUrl: 'bodyTreeModal.html',
                controller: 'bodyTreeModalCtrl',
                size: size,
                resolve: {
                    
                }
            });

            bodyTreeModalInstance.result.then(
            function () {
                
            }, function () {
                
            });
        };
        
        
        
        //////////////
        
        
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
        
        
        
        /**
         * disconnect modal initialization
         */
        
                
    
            
        $scope.openDisconnectModal = function (size) {
            
            var disconnectModalInstance = $modal.open({
                templateUrl: 'disconnectModal.html',
                controller: 'disconnectModalCtrl',
                size: size,
                resolve: {
                    
                },
                windowClass: 'disconnect-modal-window'
            });

            disconnectModalInstance.result.then(
            function () {
                
                
                
            }, function () {
                
            });
        };
        
        ///////////////
        
        $scope.checkConnectionSave = function(contin) {
            $http.get('../user/ajax/is_logged_in').then(
                function(response){
                    SecurityService.connected = true;
                    if(response.data[0] === false) {
                        SecurityService.loggedIn = false;
                    } else {
                        SecurityService.loggedIn = true;    
                    }
                    
                    
                    
                    if(!SecurityService.connected) {
                        $scope.openDisconnectModal();
                    }else
                    if(!SecurityService.loggedIn) {
                        $scope.openLoginModal();
                    } else {
                        contin = (contin)? true : false;
//                        $scope.openSavingModal();
                        ClassifiedService.saveCurrentClassified(contin);
//                        $scope.classifiedform.$setPristine();

                    }
                }, 
                function(errResponse){
                    $scope.openDisconnectModal();
                }
            );
            
        }
        
        
        /**
         * Body Classified modal initializing
         */
        
        
        $scope.openBodyClassifiedModal = function (size) {

            var bodyClassifiedModalInstance = $modal.open({
                templateUrl: 'bodyClassifiedModal.html',
                controller: 'bodyClassifiedModalCtrl',
                size: size,
                resolve: {
                    
                }
            });

            bodyClassifiedModalInstance.result.then(
            function () {
                
            }, function () {
                
            });
        };
        
        
        
        //////////////
        
        /**
         * Insert link modal initializing
         */
        
        
        $scope.openInsertLinkModal = function (size) {

            var bodyInsertLinkInstance = $modal.open({
                templateUrl: 'insertLinkModal.html',
                controller: 'insertLinkModalCtrl',
                size: size,
                resolve: {
                    
                }
            });

            insertLinkModalInstance.result.then(
            function () {
                
            }, function () {
                
            });
        };
        
        
        
        //////////////


        /**
         * 
         * uploader
         */

        var uploader = $scope.uploader = new FileUploader({
            url: '../managedfile/ajax/upload'
        });
        uploader.withCredentials = true;
        uploader.queueLimit =10 ;
        uploader.autoUpload = true;
        uploader.removeAfterUpload = true;
        uploader.msg = "";
        uploader.formData.push({type : 'classified'});
        
        $scope.selectTab = function(currentTab) {
            ValuesService.bodyAttachmentActiveTab = currentTab;
            uploader.formData.push({uploadDir : ValuesService.bodyAttachmentActiveTab});
        }
        
        // FILTERS
            
        uploader.filters.push({
            name: 'imageTypeFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                if(ValuesService.bodyAttachmentActiveTab == 'image') {
                    uploadableType = "image";
                    uploadableExtensions = ["jpg", "jpeg", "png", "bmp"];
                    fileType = item.type.split("/")[0];
                    fileExtension = item.type.split("/")[1];
                    if(fileType != uploadableType || uploadableExtensions.indexOf(fileExtension) == -1) {
                        return false;
                    }
                }
                return true;
                
                 
            }
        });
        
//        uploader.filters.push({
//            name: 'imageSizeFilter',
//            fn: function(item /*{File|FileLikeObject}*/, options) {
//                if(ValuesService.bodyAttachmentActiveTab == 'image') {
//                    if(item.size > 300000) {
//                        return false;
//                    }
//                }
//                return true;
//                
//                 
//            }
//        });
        
        uploader.filters.push({
            name: 'videoTypeFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                if(ValuesService.bodyAttachmentActiveTab == 'video') {
                    uploadableType = "video";
                    uploadableExtensions = ["mp4"];
                    fileType = item.type.split("/")[0];
                    fileExtension = item.type.split("/")[1];
                    if(fileType != uploadableType || uploadableExtensions.indexOf(fileExtension) == -1) {
                        return false;
                    }
                }
                return true;
                
                 
            }
        });
        
//        uploader.filters.push({
//            name: 'videoSizeFilter',
//            fn: function(item /*{File|FileLikeObject}*/, options) {
//                if(ValuesService.bodyAttachmentActiveTab == 'video') {
//                    if(item.size > 10000000) {
//                        return false;
//                    }
//                }
//                return true;
//                
//                 
//            }
//        });
        
        uploader.filters.push({
            name: 'audioTypeFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                if(ValuesService.bodyAttachmentActiveTab == 'audio') {
                    uploadableType = "audio";
                    uploadableExtensions = ["mp3"];
                    fileType = item.type.split("/")[0];
                    fileExtension = item.type.split("/")[1];
                    if(fileType != uploadableType || uploadableExtensions.indexOf(fileExtension) == -1) {
                        return false;
                    }
                }
                return true;
                
                 
            }
        });
        
//        uploader.filters.push({
//            name: 'audioSizeFilter',
//            fn: function(item /*{File|FileLikeObject}*/, options) {
//                if(ValuesService.bodyAttachmentActiveTab == 'audio') {
//                    if(item.size > 4000000) {
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
                case 'audioTypeFilter':
                    uploader.msg = 'شما فقط میتوانید فایل با پسوندهای   mp3  آپلود کنید.';
                    break;
                case 'audioSizeFilter':
                    uploader.msg = 'audioSizeFilter';
                    break;
                case 'videoTypeFilter':
                    uploader.msg = 'شما فقط میتوانید فایل با پسوندهای   mp4  آپلود کنید.';
                    break;
                case 'videoSizeFilter':
                    uploader.msg = 'videoSizeFilter';
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
        };
        uploader.onErrorItem = function(fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);
            alert(response);
        };
        uploader.onCancelItem = function(fileItem, response, status, headers) {
            console.info('onCancelItem', fileItem, response, status, headers);
        };
        uploader.onCompleteItem = function(fileItem, response, status, headers) {
            console.info('onCompleteItem', fileItem, response, status, headers);
            switch(response.upload_dir) {
                case 'image':
                    ClassifiedService.addToBodyImagesList(response);
                    break;
                case 'video':
                    ClassifiedService.addToBodyVideosList(response);
                    break;
                case 'audio':
                    ClassifiedService.addToBodyAudiosList(response);
                    break;
                case 'doc':
                    ClassifiedService.addToBodyDocsList(response);
                    break;

            }
            uploader.msg = 'فایل با موفقیت بارگزاری شد.';
        };
        uploader.onCompleteAll = function() {
            console.info('onCompleteAll');
        };

        console.info('uploader', uploader);

        
        /***************************
         *************************** 
         ***************************
         */

        


        $scope.CkeditorInsert = function() {

            var CkInstance = null;
            angular.forEach(CKEDITOR.instances,function(value, key){CkInstance = value; keepGoing = false;})
            
            switch(ValuesService.bodyAttachmentActiveTab) {
                case 'image':
                    var fileClass = ClassifiedService.selectedBodyImage.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;"><img class="'+fileClass+'"  alt="" style="width:200px;" src="'+ClassifiedService.selectedBodyImage.absolute_path+'" /></p>');
                    break;
                case 'video':
                    var fileClass = ClassifiedService.selectedBodyVideo.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'"  style="text-align:center;" ><video class="'+fileClass+'"  controls="" name="media" width="300"><source src="'+ClassifiedService.selectedBodyVideo.absolute_path+'" type="'+ClassifiedService.selectedBodyVideo.filemime+'"></video></p>');
                    break;
                case 'audio':
                    var fileClass = ClassifiedService.selectedBodyAudio.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;" ><audio class="'+fileClass+'"  controls="" name="media" width="300"><source src="'+ClassifiedService.selectedBodyAudio.absolute_path+'" type="'+ClassifiedService.selectedBodyAudio.filemime+'"></audio></p>');
                    break;
                    
                case 'doc':
                    var text = prompt("لطفا متن مربوط به لینک دانلود فایل را وارد نمایید. در غیر این صورت نام فایل به عنوان متن در نظر گرفته می شود.");
                    text = (text)?text:ClassifiedService.selectedBodyDoc.file_name;
                    var fileClass = ClassifiedService.selectedBodyDoc.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;" ><a class="body web-link '+fileClass+'" href="'+ClassifiedService.selectedBodyDoc.absolute_path+'"  > '+text+'  </a></p>');
                    break;

            }


        };

        

        $scope.close = function(){$modalInstance.close();}


    }]).
    factory('ValuesService', ['$http', function ($http){ 

        


        var csrf;


        
        if(!csrf) {
            $http.get('ajax/generate_csrf').then(
                function(response) {
                    self.csrf = response.data;


                },
                function(errResponse) {
                }
            );
        }

        

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

        
        



        self.activeTab = 'image';
        self.bodyAttachmentActiveTab = 'image';
        self.randUploadKey = null;
        self.getRandUploadKey = function(force){
            if(force == true || !self.randUploadKey) {
                $http.get('../managedfile/ajax/gen_rand_upload_key').then(
                    function(response) {
                        self.randUploadKey = response.data;
                    },
                    function(errResponse) {
                        self.randUploadKey = null;
                    }
                )
            }
            return self.randUploadKey;
        };


        self.currentImageModal = {}
        self.currentVideoModal = {}


        self.treeRanks = [];
        for(var i = 1; i<=30; i++) {
            self.treeRanks.push({
                id: i,
                name: i
            })
        }


        return self;

    }]).factory('SecurityService', ['$http', 'ClassifiedService', function($http, ClassifiedService){
        var self={};
        
            
        var viewAccess = null;
        var editAccess = {};
        var deleteAccess = {};
        var verifyAccess = null;
        var createAccess = null;
        var activateAccess = null;
        var otherAccess = null;
        
        self.actionsAccess = {};
        self.buttonsAccess = {};
        
        
        self.actionsAccess.viewAccess = function() {
            if(viewAccess == 'waiting') {
                return false;
            }
            if(viewAccess == null) {
                viewAccess = 'waiting';
                $http.get('ajax/check_permission/view').then(
                    function(response){
                        viewAccess = response.data[0];
                        return viewAccess;
                    },
                    function(errResponse){
                        viewAccess = null;
                        return false;
                    }
                );
            } else {
                return viewAccess;
            }
            
        }
        
        self.actionsAccess.editAccess = function() {
            if(editAccess[ClassifiedService.currentClassified.id] == 'waiting') {
                return false;
            }
            
            if(!angular.isDefined(editAccess[ClassifiedService.currentClassified.id])) {
                editAccess[ClassifiedService.currentClassified.id] = 'waiting';
                
                $http.get('ajax/check_permission/edit/'+ClassifiedService.currentClassified.id).then(
                    function(response){
                        editAccess[ClassifiedService.currentClassified.id] = response.data[0];
                        return editAccess[ClassifiedService.currentClassified.id];
                    },
                    function(errResponse){
                        editAccess[ClassifiedService.currentClassified.id] = null;
                        return false;
                    }
                );
            } else {
                return editAccess[ClassifiedService.currentClassified.id];
            }
            
        }
        
        
        self.actionsAccess.deleteAccess = function() {
            if(deleteAccess[ClassifiedService.currentClassified.id] == 'waiting') {
                return false;
            }
            
            if(!angular.isDefined(deleteAccess[ClassifiedService.currentClassified.id])) {
                deleteAccess[ClassifiedService.currentClassified.id] = 'waiting';
                
                $http.get('ajax/check_permission/remove/'+ClassifiedService.currentClassified.id).then(
                    function(response){
                        deleteAccess[ClassifiedService.currentClassified.id] = response.data[0];
                        return deleteAccess[ClassifiedService.currentClassified.id];
                    },
                    function(errResponse){
                        deleteAccess[ClassifiedService.currentClassified.id] = null;
                        return false;
                    }
                );
            } else {
                return deleteAccess[ClassifiedService.currentClassified.id];
            }
            
        }
        
        
        self.actionsAccess.verifyAccess = function() {
            if(verifyAccess == 'waiting') {
                return false;
            }
            if(verifyAccess == null) {
                verifyAccess = 'waiting';
                $http.get('ajax/check_permission/verify').then(
                    function(response){
                        verifyAccess = response.data[0];
                        return verifyAccess;
                    },
                    function(errResponse){
                        verifyAccess = null;
                        return false;
                    }
                );
            } else {
                return verifyAccess;
            }
            
        }
        
        self.actionsAccess.createAccess = function() {
            if(createAccess == 'waiting') {
                return false;
            }
            if(createAccess == null) {
                createAccess = 'waiting';
                $http.get('ajax/check_permission/create').then(
                    function(response){
                        createAccess = response.data[0];
                        return createAccess;
                    },
                    function(errResponse){
                        createAccess = null;
                        return false;
                    }
                );
            } else {
                return createAccess;
            }
            
        }
        
        self.actionsAccess.activateAccess = function() {
            if(activateAccess == 'waiting') {
                return false;
            }
            if(activateAccess == null) {
                activateAccess = 'waiting';
                $http.get('ajax/check_permission/activate').then(
                    function(response){
                        activateAccess = response.data[0];
                        return activateAccess;
                    },
                    function(errResponse){
                        activateAccess = null;
                        return false;
                    }
                );
            } else {
                return activateAccess;
            }
            
        }
        
        self.actionsAccess.otherAccess = function() {
            if(otherAccess == 'waiting') {
                return false;
            }
            if(otherAccess == null) {
                otherAccess = 'waiting';
                $http.get('ajax/check_permission/other').then(
                    function(response){
                        otherAccess = response.data[0];
                        return otherAccess;
                    },
                    function(errResponse){
                        otherAccess = null;
                        return false;
                    }
                );
            } else {
                return otherAccess;
            }
            
        }
        
        self.buttonsAccess.newButtonAccess = function() {
            return self.actionsAccess.createAccess();
        }
        
        
        
        self.buttonsAccess.editButtonAccess = function() {
            return self.actionsAccess.editAccess();
        }
        
        self.buttonsAccess.deleteButtonAccess = function() {
            return self.actionsAccess.deleteAccess();
        }
        
        self.buttonsAccess.verifyButtonAccess = function() {
            return self.actionsAccess.verifyAccess();
        }
        
        self.test = function() {
            return false;
        }
        
        self.buttonsAccess.activateButtonAccess = function() {
            return self.actionsAccess.activateAccess();
        }
        
        
        
        self.buttonsAccess.saveButtonAccess = function() {
            if(ClassifiedService.isNew()) {
                return true;
            } else {
                return self.actionsAccess.editAccess();
            }
            
        }
        
        
        
        self.buttonsAccess.saveAndContinueButtonAccess = function() {
            if(ClassifiedService.isNew()) {
                return true;
            } else {
                return self.actionsAccess.editAccess();
            }
            
        }
        
        return self;
        
        
        
    } ]);
