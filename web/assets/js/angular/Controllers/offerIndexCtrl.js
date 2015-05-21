//var offerIndexCtrl = angular.module('OfferIndexCtrl', ['offertreeControl', 'angularFileUpload']);
//var offerIndexCtrl = offerApp.module('OfferIndexCtrl', ['offertreeControl', 'angularFileUpload']);


    // inject the Comment service into our controller
//    offerIndexCtrl.controller('OfferIndexController', ['$modal','$scope','$http', '$upload', '$interval', 'OfferTree','OfferControl',
//        function($modal, $scope, $http, $upload, $interval, OfferTree, OfferControl) {
//            $scope.test = "this is test";
//        }]);

angular.module('OfferApp', ['treeControl', 'ui.grid', 'smart-table', 'btford.modal', 'ngCollection', 'ngSanitize', 'ngCkeditor', 'ui.bootstrap', 'ui.bootstrap.persian.datepicker', 'checklist-model',
                            ,'mediaPlayer', 'infinite-scroll','angularFileUpload', 'uiGmapgoogle-maps', 'duScroll'
    ])
    .config(['uiGmapGoogleMapApiProvider', function (GoogleMapApi) {
        GoogleMapApi.configure({
      //    key: 'your api key',
          v: '3.17',
          libraries: 'weather,geometry,visualization'
        });
    }])      
    .controller('OfferIndexCtrl', ['$scope', '$http', '$location', '$filter', '$sce', 'TreeService', 'OfferService', 'ValuesService', '$interval', 'poollingFactory',
                                     'mapModal','FileUploader', '$modal', 'SecurityService',
    function($scope, $http, $location,  $filter, $sce,   TreeService,   OfferService,   ValuesService, $interval, poollingFactory, mapModal,FileUploader, $modal, SecurityService) {

        
        /**
         * initializing config for list endless scroll
         */
        gb = document.getElementsByClassName('grid-block')[0];
        tbl = gb.getElementsByTagName('table')[0];
              
        
        gridblock = angular.element(gb);
        table = angular.element(tbl);
        
        gridblock.on('scroll', function() {
          if(gridblock.scrollTop() + gridblock.height() >= table.height()) {
              OfferService.searchOffer(OfferService.offerList().length);
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
        uploader.formData.push({type : 'offer'});
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
                    OfferService.addToImagesList(response);
                    break;
                case 'icon':
                    OfferService.currentOffer.icon = response;
                    break;
                case 'video':
                    OfferService.addToVideosList(response);
                    break;
                case 'audio':
                    OfferService.addToAudiosList(response);
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
        bannerUploader.formData.push({type : 'offer'});
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
            
            OfferService.currentOffer.banner = response;
             
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
         *  OfferService Initializing
         */
        $scope.OfferService = OfferService;
        $scope.SecurityService = SecurityService;
        $scope.OfferService.getOfferForCat(-3,0);
        $scope.offerList = function() {
            return OfferService.offerList();
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
                    window.location = "../offer";

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
                        OfferService.saveCurrentOffer(contin);
                        $scope.offerform.$setPristine();

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
            tempBody = (OfferService.currentOffer.body)? OfferService.currentOffer.body : "";
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
    .factory('TreeService', ['$http', 'OfferService', '$collection', function($http, OfferService, $collection){

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
                OfferService.offerSearchCriteria = {cid: node.id}
                OfferService.searchOffer();
            }

        };
    }])
    .factory('OfferService', ['$http', 'Collection', 'ValuesService', '$filter' ,function($http, Collection, ValuesService, $filter){
        offerList = Collection.getInstance();
        var selectedOffer = {};
//        var currentOffer;





        var self = {

            currentOffer: {active:false, verify:false}



        };


        
        self.removeBanner = function() {
            self.currentOffer.banner = {}
        }
        
        self.list = offerList;
        self.nextSelectedOffer = function() {
            var currentIndex = self.currentSelectedOffer();
            if(self.nexable()){
                self.selectOffer(self.list.array[currentIndex+1])
            }
        }

        self.nexable = function() {
            var currentIndex = self.currentSelectedOffer();
            if(currentIndex != null &&
                currentIndex < (self.list.length - 1) ){
                return true;
            }
            return false;
        }

        self.previousSelectedOffer = function() {
            var currentIndex = self.currentSelectedOffer();
            if(self.previousable()){
                self.selectOffer(self.list.array[currentIndex-1])
            }
        }

        self.previousable = function() {
            var currentIndex = self.currentSelectedOffer();
            if(currentIndex != null &&
                currentIndex > 0 ){
                return true;
            }
            return false;
        }

        self.hasVideo = function() {
            if((typeof self.currentOffer.videosList != 'undefined' && self.currentOffer.videosList.length > 0) || 
               (typeof self.currentOffer.bodyVideosList != 'undefined' && self.currentOffer.bodyVideosList.length > 0) ) {
                return true;
            }
            return false;
        }
        
        self.hasAudio = function() {
            if((typeof self.currentOffer.audiosList != 'undefined' && self.currentOffer.audiosList.length > 0) || 
               (typeof self.currentOffer.bodyAudiosList != 'undefined' && self.currentOffer.bodyAudiosList.length > 0)) {
                return true;
            }
            return false;
        }

        self.currentSelectedOffer =function() {
            currentOfferIndex = null;
            angular.forEach(self.list.array, function(value,key) {
                if(value.id == selectedOffer.id) {
                    currentOfferIndex = key;
                    keepGoing = false;
                }
            })
            return currentOfferIndex;
        }

        self.verifyCurrentOffer = function() {
            return $http({
                method: 'PUT',
                url: 'ajax/verify_offer/'+self.currentOffer.id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
            }).then(
                function(response){
                    self.currentOffer.verify = true;
                },
                function(responseErr){
                }
            );
        }

        self.toggleVerifyCurrentOffer = function() {
            if(!self.currentOffer.id) {
                self.currentOffer.verify = !self.currentOffer.verify;
            } else {
                return $http({
                    method: 'PUT',
                    url: 'ajax/toggle_verify_offer/'+self.currentOffer.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                }).then(
                    function(response){
                        self.currentOffer.verify = response.data.verify;
                    },
                    function(responseErr){
                    }
                );
            }

        }

        self.toggleActiveCurrentOffer = function() {
            if(!self.currentOffer.id) {
                self.currentOffer.active = !self.currentOffer.active;
            }else {
                return $http({
                    method: 'PUT',
                    url: 'ajax/toggle_active_offer/'+self.currentOffer.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                }).then(
                    function(response){
                        self.currentOffer.active = response.data.active;
                    },
                    function(responseErr){
                    }
                );
            }

        }


        self.deleteCurrentOffer = function(serv) {
            if(self.currentOffer.id) {
                $http({
                    method: 'PUT',
                    url: 'ajax/delete_offer/'+self.currentOffer.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                }).then(
                    function(response){
                        offerList.remove(selectedOffer);
                        self.currentOffer = {}
                        temporaryOffer = {}
                        serv.close();
                    },
                    function(responseErr){
                        console.log(responseErr)
                    }
                );
            }
        }




        self.currentOffer.treeList = Collection.getInstance();
        self.currentOffer.images = Collection.getInstance()
        self.currentOffer.videos = Collection.getInstance()
        self.currentOffer.audios = Collection.getInstance()

        self.saved = false;

        self.currentCid;

        self.offerSearchCriteria = {};

//        self.list = function() {
//            return items;
//        };

        self.selectedOffer= function() {
            return selectedOffer;
        };

        self.getOfferForCat = function(cid, count) {
            
            $http.get('ajax/get_total_offer_for_cat/'+cid).then(function(response){
                self.totalOffer = response.data;
            },function(errResponse){
            });
            
            $http.get('ajax/get_offer_for_cat/'+cid+'/'+count).then(function(response){
                if(!count) {offerList.removeAll();}
                offerList.addAll(response.data);
                self.currentCid = cid;
                if(!count) {selectedOffer = {id:0};}
            },function(errResponse){
            });
        };

        self.getOfferByCriteria = function(count) {
            if(!self.offerSearchCriteria.searchKeyword) {
                self.offerSearchCriteria.searchKeyword = "";
            }
            if(!self.offerSearchCriteria.searchBy) {
                self.offerSearchCriteria.searchBy = "1";
            }
            if(!self.offerSearchCriteria.sortBy) {
                self.offerSearchCriteria.sortBy = "1";
            }

            var lastSep = (self.offerSearchCriteria.searchKeyword)?'/':'';
            
            $http.get('ajax/total_search_offer/'+
                self.offerSearchCriteria.searchBy+'/'+
                self.offerSearchCriteria.sortBy+'/'+
                self.offerSearchCriteria.searchKeyword
                ).then(function(response){
                self.totalOffer = response.data;
            },function(errResponse){
            });
            
            $http.get('ajax/search_offer/'+
                self.offerSearchCriteria.searchBy+'/'+
                self.offerSearchCriteria.sortBy+'/'+
                count+
                lastSep
                +
                self.offerSearchCriteria.searchKeyword
                ).then(function(response){

                if(!count) {offerList.removeAll();}
                offerList.addAll(response.data);
                self.currentCid = null;
                if(!count){selectedOffer = {id:0};}
            },function(errResponse){
            });
        }

        self.searchOffer = function(count) {
            
            if(!count) {
                count=0;
            }
            if(self.offerSearchCriteria.cid !=null) {
                self.getOfferForCat(self.offerSearchCriteria.cid, count)
            } else {
                self.offerSearchCriteria.cid = null;
                self.getOfferByCriteria(count);
            }

        }

        self.offerList = function() {
            return offerList.all();
        };

        var temporaryOffer = {}

        self.file = null;

        var editing = false;
        self.isEditing = function() {
            return editing;
        }

        self.editingNew= function() {

            temporaryOffer = angular.copy(self.currentOffer);
            self.currentOffer = angular.copy({});
            self.currentOffer.treeList = Collection.getInstance();
            self.currentOffer.imagesList = Collection.getInstance();
            self.currentOffer.bodyImagesList = Collection.getInstance();
            self.currentOffer.videosList = Collection.getInstance();
            self.currentOffer.bodyVideosList = Collection.getInstance();
            self.currentOffer.audiosList = Collection.getInstance();
            self.currentOffer.bodyAudiosList = Collection.getInstance();
            self.currentOffer.bodyDocsList = Collection.getInstance();
            
            

            


            /**
             * initializing verify active --begin
             */

            self.currentOffer.verify = false;
            self.currentOffer.active = false;
            self.currentOffer.continual = true; 
            self.currentOffer.rate = 10; 
            /* initializing verify active --end  */

            

            editing = true;
            ValuesService.getRandUploadKey(true);
            
            self.currentOffer.publish_date = new Date();


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
            temporaryOffer = angular.copy(self.currentOffer);
            editing = true;
        }

        self.cancelEditing = function() {
            self.currentOffer = angular.copy(temporaryOffer);
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
            temporaryOffer = {}
            editing = false;
        }

        self.selectOffer = function(offer) {
            selectedOffer = offer;
            $http.get('ajax/get_offer/'+offer.id).then(
                function(response) {
                    self.currentOffer = response.data;
                    

                    
                    self.currentOffer.treeList = Collection.getInstance();
                    self.currentOffer.treeList.addAll(self.currentOffer.offertrees);

                    self.currentOffer.imagesList = Collection.getInstance();
                    self.currentOffer.imagesList.addAll(self.currentOffer.images);

                    self.currentOffer.videosList = Collection.getInstance();
                    self.currentOffer.videosList.addAll(self.currentOffer.videos);
                    self.currentOffer.videoPlaylist = [];
                    angular.forEach(self.currentOffer.videos, function(value, key){
                        var playlistItem = {};
                        playlistItem.src = value.absolute_path;
                        playlistItem.type = value.filemime;
                        self.currentOffer.videoPlaylist.push(playlistItem);
                    });


                    self.currentOffer.audiosList = Collection.getInstance();
                    self.currentOffer.audiosList.addAll(self.currentOffer.audios);
                    self.currentOffer.audioPlaylist = [];
                    angular.forEach(self.currentOffer.audios, function(value, key){
                        var playlistItem = {};
                        playlistItem.src = value.absolute_path;
                        playlistItem.type = value.filemime;
                        self.currentOffer.audioPlaylist.push(playlistItem);
                    });


                    self.currentOffer.bodyImagesList = Collection.getInstance();
                    self.currentOffer.bodyImagesList.addAll(self.currentOffer.body_images);

                    self.currentOffer.bodyVideosList = Collection.getInstance();
                    self.currentOffer.bodyVideosList.addAll(self.currentOffer.body_videos);

                    self.currentOffer.bodyAudiosList = Collection.getInstance();
                    self.currentOffer.bodyAudiosList.addAll(self.currentOffer.body_audios);
                    
                    self.currentOffer.bodyDocsList = Collection.getInstance();
                    self.currentOffer.bodyDocsList.addAll(self.currentOffer.body_docs);
                },
                function(errResponse) {
                }
            );

        };

        self.addToImagesList = function(obj) {
            self.currentOffer.imagesList.add(obj);
            self.currentOffer.images = self.currentOffer.imagesList.all();
        }

        self.addToBodyImagesList = function(obj) {
            self.currentOffer.bodyImagesList.add(obj);
            self.currentOffer.body_images = self.currentOffer.bodyImagesList.all();
        }

        self.addToVideosList = function(obj) {
            self.currentOffer.videosList.add(obj);
            self.currentOffer.videos = self.currentOffer.videosList.all();
            playlistItem = {};
            playlistItem.src = obj.absolute_path;
            playlistItem.type = obj.filemime;
            self.currentOffer.videoPlaylist.push(playlistItem);
        }

        self.addToBodyVideosList = function(obj) {
            self.currentOffer.bodyVideosList.add(obj);
            self.currentOffer.body_videos = self.currentOffer.bodyVideosList.all();
        }

        self.addToAudiosList = function(obj) {
            self.currentOffer.audiosList.add(obj);
            self.currentOffer.audios = self.currentOffer.audiosList.all();
            playlistItem = {};
            playlistItem.src = obj.absolute_path;
            playlistItem.type = obj.filemime;
            self.currentOffer.audioPlaylist.push(playlistItem);
        }

        self.addToBodyAudiosList = function(obj) {
            self.currentOffer.bodyAudiosList.add(obj);
            self.currentOffer.body_audios = self.currentOffer.bodyAudiosList.all();
        }
        
        self.addToBodyDocsList = function(obj) {
            self.currentOffer.bodyDocsList.add(obj);
            self.currentOffer.body_docs = self.currentOffer.bodyDocsList.all();
        }

        self.removeFromAttachList = function() {
            switch(ValuesService.activeTab) {
                case 'image':
                    angular.forEach(self.selectedImages, function(value, key){
                        self.currentOffer.imagesList.remove(value);
                    });
                    self.currentOffer.images = self.currentOffer.imagesList.all();
                    break;
                case 'icon':
                    
                    self.currentOffer.icon = {};
                    break;
                case 'video':
                    angular.forEach(self.selectedVideos, function(value, key){
                        self.currentOffer.videosList.remove(value);
                    });
                    self.currentOffer.videos = self.currentOffer.videosList.all();
                    break;
                case 'audio':
                    angular.forEach(self.selectedAudios, function(value, key){
                        self.currentOffer.audiosList.remove(value);
                    });
                    self.currentOffer.audios = self.currentOffer.audiosList.all();
                    break;

            }

        }
        
        self.cleanBodyAttachments = function() {
            bodyDom = angular.element(self.currentOffer.body);
            angular.forEach(self.currentOffer.bodyImagesList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentOffer.bodyImagesList.remove(value);
                }
            });
            self.currentOffer.body_images = self.currentOffer.bodyImagesList.all();
            
            angular.forEach(self.currentOffer.bodyVideosList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentOffer.bodyVideosList.remove(value);
                }
            });
            self.currentOffer.body_videos = self.currentOffer.bodyVideosList.all();
            
            angular.forEach(self.currentOffer.bodyAudiosList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentOffer.bodyAudiosList.remove(value);
                }
            });
            self.currentOffer.body_audios = self.currentOffer.bodyAudiosList.all();
            
            angular.forEach(self.currentOffer.bodyDocsList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentOffer.bodyDocsList.remove(value);
                }
            });
            self.currentOffer.body_docs = self.currentOffer.bodyDocsList.all();
            
        }

        self.removeFromBodyAttachList = function() {
            switch(ValuesService.bodyAttachmentActiveTab) {
                case 'image':
                    angular.forEach(self.selectedBodyImages, function(value, key){
                        
                        bodyDom = angular.element(self.currentOffer.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentOffer.bodyImagesList.remove(value);
                        }
                        
                    });
                    self.currentOffer.body_images = self.currentOffer.bodyImagesList.all();
                    break;
                case 'video':
                    angular.forEach(self.selectedBodyVideos, function(value, key){
                        bodyDom = angular.element(self.currentOffer.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentOffer.bodyVideosList.remove(value);
                        }
                        
                    });
                    self.currentOffer.body_videos = self.currentOffer.bodyVideosList.all();
                    break;
                case 'audio':
                    angular.forEach(self.selectedBodyAudios, function(value, key){
                        bodyDom = angular.element(self.currentOffer.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentOffer.bodyAudiosList.remove(value);
                        }
                        
                    });
                    self.currentOffer.body_audios = self.currentOffer.bodyAudiosList.all();
                    break;
                
                case 'doc':
                    angular.forEach(self.selectedBodyDocs, function(value, key){
                        bodyDom = angular.element(self.currentOffer.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentOffer.bodyDocsList.remove(value);
                        }
                        
                    });
                    self.currentOffer.body_docs = self.currentOffer.bodyDocsList.all();
                    break;

            }

        }







        self.addToTreeList = function(obj, sort)  {
            angular.forEach(self.currentOffer.treeList.array, function(value, key){
                if(obj.id == value.tree.id) {
                    self.currentOffer.treeList.remove(value);
                }
            });
            obj.sort = sort;
            var tree = {};
            tree.tree = obj;
            tree.sort = (sort)?sort:60;
            self.currentOffer.treeList.update(tree);
            self.currentOffer.offertrees = self.currentOffer.treeList.all() ;
            return obj.title+" به پیشنهاد ویژه اضافه شد.";
        }

        self.removeFromTreeList = function(selectedTrees)  {
            selectedTrees.forEach(function(tree, index, selectedTrees){
                self.currentOffer.treeList.remove(tree);
            });

            self.currentOffer.offertrees = self.currentOffer.treeList.all() ;
        }

        self.updateCurrentOffer = function() {
            self.currentOffer._csrf_token = ValuesService.csrf;
            return $http({
                method: 'PUT',
                url: 'ajax/'+self.currentOffer.id+'/update',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({data: angular.toJson(self.currentOffer)})
            });
        }

        self.saveCurrentNewOffer = function() {
            self.currentOffer._csrf_token = ValuesService.csrf;
            self.currentOffer.uploadKey = ValuesService.getRandUploadKey();
            return $http({
                method: 'POST',
                url: 'ajax/create',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({data: angular.toJson(self.currentOffer)})
            });
        }

        self.isNew = function() {
            if(self.currentOffer.id) {
                return false;
            } else {
                return true;
            }
        }



        self.saveCurrentOffer = function(contin) {
            contin = (contin)? true : false;
            self.savingMessages = {}
            self.saved = false;
            if(!contin){
                self.cleanBodyAttachments();
            }
            if(self.isNew()) {

                self.saveCurrentNewOffer().then(
                    function(response){
//                        self.currentOffer = {}
//                        self.currentOffer = response.data[0];

                        self.currentOffer.id = response.data[0].id;
                        self.selectOffer(self.currentOffer);
                        self.saved = true;
                        self.savingMessages = ['خبر مورد نظر ذخیره شد.'];
                        if(!contin) {
                            self.searchOffer();
                            self.finishEditing();
                        } else {
                            temporaryOffer = angular.copy(self.currentOffer);
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
                self.updateCurrentOffer().then(
                    function(response){
//                        self.currentOffer = response.data;
                        self.saved = true;
                        self.savingMessages = ['خبر مورد نظر ذخیره شد.'];
                        if(!contin) {
                            self.searchOffer();
                            self.finishEditing();
                        }else {
                            temporaryOffer = angular.copy(self.currentOffer);
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
        
        

        

        self.isSelected = function(offer) {
            if(offer.id == selectedOffer.id) {
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

    controller('treeModalCtrl', ['$scope', 'OfferService','TreeService', '$modalInstance', function ($scope, OfferService, TreeService, $modalInstance) {
        $scope.OfferService = OfferService;
        $scope.TreeService = TreeService;
        $scope.tree = function() {
            return $scope.TreeService.tree();
        }

        $scope.treeOptions = function() {
            return $scope.TreeService.treeOptions();
        }
        $scope.tOptions = angular.copy($scope.TreeService.treeOptions());
        $scope.tOptions.dirSelectable = false;
        
        $scope.close = function () {
            $modalInstance.close();
        };

        $scope.addTerm = function(term) {

        }
    }]).
    controller('bodyTreeModalCtrl', ['$scope', 'OfferService','TreeService', '$modalInstance', function ($scope, OfferService, TreeService, $modalInstance) {
        $scope.OfferService = OfferService;
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
    controller('bodyOfferModalCtrl', ['$scope', 'OfferService','TreeService', '$modalInstance', function ($scope, OfferService, TreeService, $modalInstance) {
        $scope.OfferService = OfferService;
        $scope.TreeService = TreeService;
        $scope.text = "";
        $scope.offerId = "";
        
        $scope.close = function () {
            $modalInstance.close();
        };

        var CkInstance = null;
        angular.forEach(CKEDITOR.instances,function(value, key){CkInstance = value; keepGoing = false;})
        
        $scope.insertOffer = function() {
            
            console.log($scope.currentBodyTreeNode);
            CkInstance.insertHtml('<a href="#" class="body inner-link " offer-id="'+$scope.offerId+'">'+$scope.text+'</a>');
            $scope.close();
        }
    }]).
    controller('insertLinkModalCtrl', ['$scope', 'OfferService','TreeService', '$modalInstance', function ($scope, OfferService, TreeService, $modalInstance) {
        $scope.OfferService = OfferService;
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
    controller('savingModalCtrl', ['$scope', 'OfferService','TreeService', '$modalInstance', function ($scope, OfferService, TreeService, $modalInstance) {
        $scope.OfferService = OfferService;
        $scope.close = function(){$modalInstance.backdrop = true; $modalInstance.close();}

    }]).
    controller('deleteModalCtrl', ['$scope', '$modalInstance', 'OfferService','TreeService', function ($scope, $modalInstance, OfferService, TreeService) {
        $scope.OfferService = OfferService;
        $scope.close = function(){$modalInstance.close();}
        $scope.deleteCurrentOffer = function() {
            console.log(OfferService.deleteCurrentOffer($modalInstance));
        }
    }]).
    controller('continualModalCtrl', ['$scope', '$http', '$modalInstance', 'OfferService','TreeService', function ($scope, $http, $modalInstance, OfferService, TreeService) {
        $scope.OfferService = OfferService;
        $scope.images = angular.copy(OfferService.currentOffer.imagesList.all());
        $scope.audios = angular.copy(OfferService.currentOffer.audiosList.all());
        $scope.videos = angular.copy(OfferService.currentOffer.videosList.all());
        
        $scope.bodyImages = angular.copy(OfferService.currentOffer.bodyImagesList.all());
        $scope.bodyAudios = angular.copy(OfferService.currentOffer.bodyAudiosList.all());
        $scope.bodyDocs = angular.copy(OfferService.currentOffer.bodyDocsList.all());
        $scope.bodyVideos = angular.copy(OfferService.currentOffer.bodyVideosList.all());
        $scope.close = function(){$modalInstance.close();}
        $scope.save = function() {
            OfferService.currentOffer.imagesList.removeAll();
            OfferService.currentOffer.imagesList.addAll($scope.images);
            OfferService.currentOffer.images = OfferService.currentOffer.imagesList.all();

            OfferService.currentOffer.audiosList.removeAll();
            OfferService.currentOffer.audiosList.addAll($scope.audios);
            OfferService.currentOffer.audios = OfferService.currentOffer.audiosList.all();

            OfferService.currentOffer.videosList.removeAll();
            OfferService.currentOffer.videosList.addAll($scope.videos);
            OfferService.currentOffer.videos = OfferService.currentOffer.videosList.all();

            OfferService.currentOffer.bodyImagesList.removeAll();
            OfferService.currentOffer.bodyImagesList.addAll($scope.bodyImages);
            OfferService.currentOffer.body_images = OfferService.currentOffer.bodyImagesList.all();

            OfferService.currentOffer.bodyAudiosList.removeAll();
            OfferService.currentOffer.bodyAudiosList.addAll($scope.bodyAudios);
            OfferService.currentOffer.body_audios = OfferService.currentOffer.bodyAudiosList.all();
            
            OfferService.currentOffer.bodyDocsList.removeAll();
            OfferService.currentOffer.bodyDocsList.addAll($scope.bodyDocs);
            OfferService.currentOffer.body_docs = OfferService.currentOffer.bodyDocsList.all();

            OfferService.currentOffer.bodyVideosList.removeAll();
            OfferService.currentOffer.bodyVideosList.addAll($scope.bodyVideos);
            OfferService.currentOffer.body_videos = OfferService.currentOffer.bodyVideosList.all();
            
            $modalInstance.close();
        }
        
    }]).
        
    controller('imageModalCtrl', ['$scope', '$modalInstance', 'OfferService','TreeService', 'ValuesService', function ($scope, $modalInstance, OfferService, TreeService, ValuesService) {
        $scope.OfferService = OfferService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentImageModal = {}; $modalInstance.close();}
        $scope.currentImage = OfferService.currentOffer.images[ValuesService.currentImageModal.index];
        $scope.totalImage = OfferService.currentOffer.images.length;
        $scope.currentIndex = ValuesService.currentImageModal.index + 1;
        $scope.next = function() {
            ValuesService.currentImageModal.index = ValuesService.currentImageModal.index + 1;
            $scope.currentImage = OfferService.currentOffer.images[ValuesService.currentImageModal.index];
            $scope.currentIndex = ValuesService.currentImageModal.index + 1;
        }
        $scope.prev = function() {
            ValuesService.currentImageModal.index = ValuesService.currentImageModal.index -1;
            $scope.currentImage = OfferService.currentOffer.images[ValuesService.currentImageModal.index];
            $scope.currentIndex = ValuesService.currentImageModal.index + 1;
        }



    }]).
    controller('iconModalCtrl', ['$scope', '$modalInstance', 'OfferService','TreeService', 'ValuesService', function ($scope, $modalInstance, OfferService, TreeService, ValuesService) {
        $scope.OfferService = OfferService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentIconModal = {}; $modalInstance.close();}
        $scope.icon = ValuesService.currentIconModal.image;
        



    }]).
    controller('videoModalCtrl', ['$scope', '$sce', '$modalInstance', 'OfferService','TreeService', 'ValuesService', function ($scope, $sce, $modalInstance, OfferService, TreeService, ValuesService) {
        $scope.OfferService = OfferService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentVideoModal = {}; $modalInstance.close();}
        $scope.currentVideo = OfferService.currentOffer.videos[ValuesService.currentVideoModal.index];
        $scope.totalVideo = OfferService.currentOffer.videos.length;
        $scope.currentIndex = ValuesService.currentVideoModal.index + 1;
        $scope.next = function() {
            ValuesService.currentVideoModal.index = ValuesService.currentVideoModal.index + 1;
            $scope.currentVideo = OfferService.currentOffer.videos[ValuesService.currentVideoModal.index];
            $scope.currentIndex = ValuesService.currentVideoModal.index + 1;
            var videoPlayer = document.getElementById('modal-video-player');
            videoPlayer.src = $scope.currentVideo.absolute_path;
            videoPlayer.load();
            videoPlayer.play();
        }
        $scope.prev = function() {
            ValuesService.currentVideoModal.index = ValuesService.currentVideoModal.index -1;
            $scope.currentVideo = OfferService.currentOffer.videos[ValuesService.currentVideoModal.index];
            $scope.currentIndex = ValuesService.currentVideoModal.index + 1;
            var videoPlayer = document.getElementById('modal-video-player');
            videoPlayer.src = $scope.currentVideo.absolute_path;
            videoPlayer.load();
            videoPlayer.play();
        }

    }]).
    controller('audioModalCtrl', ['$scope', '$sce', '$modalInstance', 'OfferService','TreeService', 'ValuesService', function ($scope, $sce, $modalInstance, OfferService, TreeService, ValuesService) {
        $scope.OfferService = OfferService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentAudioModal = {}; $modalInstance.close();}
        $scope.currentAudio = OfferService.currentOffer.audios[ValuesService.currentAudioModal.index];
        $scope.totalAudio = OfferService.currentOffer.audios.length;
        $scope.currentIndex = ValuesService.currentAudioModal.index + 1;
        $scope.next = function() {
            ValuesService.currentAudioModal.index = ValuesService.currentAudioModal.index + 1;
            $scope.currentAudio = OfferService.currentOffer.audios[ValuesService.currentAudioModal.index];
            $scope.currentIndex = ValuesService.currentAudioModal.index + 1;
            var audioPlayer = document.getElementById('modal-audio-player');
            audioPlayer.src = $scope.currentAudio.absolute_path;
            audioPlayer.load();
            audioPlayer.play();
        }
        $scope.prev = function() {
            ValuesService.currentAudioModal.index = ValuesService.currentAudioModal.index -1;
            $scope.currentAudio = OfferService.currentOffer.audios[ValuesService.currentAudioModal.index];
            $scope.currentIndex = ValuesService.currentAudioModal.index + 1;
            var audioPlayer = document.getElementById('modal-audio-player');
            audioPlayer.src = $scope.currentAudio.absolute_path;
            audioPlayer.load();
            audioPlayer.play();
        }

    }]).
    controller('cancelModalCtrl', ['$scope', '$modalInstance', 'OfferService','TreeService', function ($scope, $modalInstance, OfferService, TreeService) {
        $scope.OfferService = OfferService;
        $scope.close = function(){$modalInstance.close(false);}
        $scope.cancel = function() {
            OfferService.cancelEditing(); 
            $modalInstance.close(true);
        }
    }]).
    controller('loginModalCtrl', ['$scope', '$http', '$modalInstance', 'OfferService','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, OfferService, ValuesService, SecurityService) {
        $scope.OfferService = OfferService;
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
                                window.location = "../offer";
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
    controller('logoutModalCtrl', ['$scope', '$http', '$modalInstance', 'OfferService','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, OfferService, ValuesService, SecurityService) {
        $scope.OfferService = OfferService;
        
        $scope.cancel = function() {
            $modalInstance.dismiss();
        }
        $scope.logout = function() {
            $modalInstance.close();
        }
    }]).
    controller('disconnectModalCtrl', ['$scope', '$http', '$modalInstance', 'OfferService','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, OfferService, ValuesService, SecurityService) {
        $scope.OfferService = OfferService;
        $scope.close = function(){$modalInstance.close(false);}
        
    }]).
    controller('bodyPreviewModalCtrl', ['$scope', '$http', '$sce', '$collection', '$modalInstance', 'OfferService','ValuesService', 'SecurityService', function ($scope, $http, $sce, $collection, $modalInstance, OfferService, ValuesService, SecurityService) {
        $scope.OfferService = OfferService;
        $scope.close = function(){$modalInstance.close(false);}
        $scope.getTrustedBody =  function(untrustedBody) {
            tempBody = (untrustedBody)? untrustedBody : "";
            return $sce.trustAsHtml(tempBody);
        }
        $scope.history = $collection.getInstance();
        $scope.trustedBody = $scope.getTrustedBody(OfferService.currentOffer.body);
        $scope.innerLink = true;
        $scope.externalLink = false;
        
        $scope.loadOffer = function(offerId) {
            $scope.innerLink = true;
            $scope.externalLink = false;
            $http.get('ajax/get_offer_by_id/' + offerId).then(
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
                angular.element(document.querySelectorAll('.body-preview-content a[offer-id]')).unbind('click');
                angular.element(document.querySelectorAll('.body-preview-content a[offer-id]')).on('click', function (event) {
                    offerId = event.toElement.getAttribute('offer-id');
                    $scope.loadOffer(offerId);
                    $scope.history.add({func: $scope.loadOffer, arg: offerId});
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
        
        $scope.history.add({func: $scope.loadOffer, arg: OfferService.currentOffer.id});
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
    controller('bodyModalCtrl', ['$scope', '$http', 'OfferService','TreeService', 'ValuesService','SecurityService', 'FileUploader', '$modalInstance', '$modal', 'recordform', 
        function (                $scope,   $http,   OfferService,  TreeService,   ValuesService, SecurityService, FileUploader, $modalInstance, $modal, recordform) {
        $scope.recordform = recordform;
        $scope.OfferService = OfferService;
        $scope.TreeService = TreeService;
        $scope.ValuesService = ValuesService;
        $scope.SecurityService = SecurityService;
        $scope.bodyEditorOptions = {
            language: 'fa',
            height: '500px',
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
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Halfhr', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'Video', 'Offer' ] },
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
                        OfferService.saveCurrentOffer(contin);
//                        $scope.offerform.$setPristine();

                    }
                }, 
                function(errResponse){
                    $scope.openDisconnectModal();
                }
            );
            
        }
        
        
        /**
         * Body Offer modal initializing
         */
        
        
        $scope.openBodyOfferModal = function (size) {

            var bodyOfferModalInstance = $modal.open({
                templateUrl: 'bodyOfferModal.html',
                controller: 'bodyOfferModalCtrl',
                size: size,
                resolve: {
                    
                }
            });

            bodyOfferModalInstance.result.then(
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
        uploader.formData.push({type : 'offer'});
        
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
                    OfferService.addToBodyImagesList(response);
                    break;
                case 'video':
                    OfferService.addToBodyVideosList(response);
                    break;
                case 'audio':
                    OfferService.addToBodyAudiosList(response);
                    break;
                case 'doc':
                    OfferService.addToBodyDocsList(response);
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
                    var fileClass = OfferService.selectedBodyImage.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;"><img class="'+fileClass+'"  alt="" style="width:200px;" src="'+OfferService.selectedBodyImage.absolute_path+'" /></p>');
                    break;
                case 'video':
                    var fileClass = OfferService.selectedBodyVideo.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'"  style="text-align:center;" ><video class="'+fileClass+'"  controls="" name="media" width="300"><source src="'+OfferService.selectedBodyVideo.absolute_path+'" type="'+OfferService.selectedBodyVideo.filemime+'"></video></p>');
                    break;
                case 'audio':
                    var fileClass = OfferService.selectedBodyAudio.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;" ><audio class="'+fileClass+'"  controls="" name="media" width="300"><source src="'+OfferService.selectedBodyAudio.absolute_path+'" type="'+OfferService.selectedBodyAudio.filemime+'"></audio></p>');
                    break;
                    
                case 'doc':
                    var text = prompt("لطفا متن مربوط به لینک دانلود فایل را وارد نمایید. در غیر این صورت نام فایل به عنوان متن در نظر گرفته می شود.");
                    text = (text)?text:OfferService.selectedBodyDoc.file_name;
                    var fileClass = OfferService.selectedBodyDoc.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;" ><a class="body web-link '+fileClass+'" href="'+OfferService.selectedBodyDoc.absolute_path+'"  > '+text+'  </a></p>');
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
        for(var i = 1; i<=60; i++) {
            self.treeRanks.push({
                id: i,
                name: i
            })
        }


        return self;

    }]).factory('SecurityService', ['$http', 'OfferService', function($http, OfferService){
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
            if(editAccess[OfferService.currentOffer.id] == 'waiting') {
                return false;
            }
            
            if(!angular.isDefined(editAccess[OfferService.currentOffer.id])) {
                editAccess[OfferService.currentOffer.id] = 'waiting';
                
                $http.get('ajax/check_permission/edit/'+OfferService.currentOffer.id).then(
                    function(response){
                        editAccess[OfferService.currentOffer.id] = response.data[0];
                        return editAccess[OfferService.currentOffer.id];
                    },
                    function(errResponse){
                        editAccess[OfferService.currentOffer.id] = null;
                        return false;
                    }
                );
            } else {
                return editAccess[OfferService.currentOffer.id];
            }
            
        }
        
        
        self.actionsAccess.deleteAccess = function() {
            if(deleteAccess[OfferService.currentOffer.id] == 'waiting') {
                return false;
            }
            
            if(!angular.isDefined(deleteAccess[OfferService.currentOffer.id])) {
                deleteAccess[OfferService.currentOffer.id] = 'waiting';
                
                $http.get('ajax/check_permission/remove/'+OfferService.currentOffer.id).then(
                    function(response){
                        deleteAccess[OfferService.currentOffer.id] = response.data[0];
                        return deleteAccess[OfferService.currentOffer.id];
                    },
                    function(errResponse){
                        deleteAccess[OfferService.currentOffer.id] = null;
                        return false;
                    }
                );
            } else {
                return deleteAccess[OfferService.currentOffer.id];
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
            if(OfferService.isNew()) {
                return true;
            } else {
                return self.actionsAccess.editAccess();
            }
            
        }
        
        
        
        self.buttonsAccess.saveAndContinueButtonAccess = function() {
            if(OfferService.isNew()) {
                return true;
            } else {
                return self.actionsAccess.editAccess();
            }
            
        }
        
        return self;
        
        
        
    } ]);
