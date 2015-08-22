//var sponsorIndexCtrl = angular.module('SponsorIndexCtrl', ['sponsortreeControl', 'angularFileUpload']);
//var sponsorIndexCtrl = sponsorApp.module('SponsorIndexCtrl', ['sponsortreeControl', 'angularFileUpload']);


    // inject the Comment service into our controller
//    sponsorIndexCtrl.controller('SponsorIndexController', ['$modal','$scope','$http', '$upload', '$interval', 'SponsorTree','SponsorControl',
//        function($modal, $scope, $http, $upload, $interval, SponsorTree, SponsorControl) {
//            $scope.test = "this is test";
//        }]);

angular.module('SponsorApp', ['treeControl', 'ui.grid', 'smart-table', 'btford.modal', 'ngCollection', 'ngSanitize', 'ngCkeditor', 'ui.bootstrap', 'ui.bootstrap.persian.datepicker', 'checklist-model',
                            ,'mediaPlayer', 'infinite-scroll','angularFileUpload', 'uiGmapgoogle-maps', 'duScroll', 'angucomplete-alt', 'com.2fdevs.videogular', "com.2fdevs.videogular.plugins.controls",
    "com.2fdevs.videogular.plugins.overlayplay",
    "com.2fdevs.videogular.plugins.poster", 'com.2fdevs.videogular', "com.2fdevs.videogular.plugins.controls",
    "com.2fdevs.videogular.plugins.overlayplay",
    "com.2fdevs.videogular.plugins.poster"
    ])
    .config(['uiGmapGoogleMapApiProvider', function (GoogleMapApi) {
        GoogleMapApi.configure({
      //    key: 'your api key',
          v: '3.17',
          libraries: 'weather,geometry,visualization'
        });
    }])
    .directive('dkVideo', ['$compile', function($compile){
        return {
            restrict: 'E',
            transclude: true,
            link: function(scope, element, attrs) {
                //console.log(attrs);
                var img = document.createElement('img');
                $(img).attr('src', '../../assets/images/video-default.jpg');
                var src = attrs.src;

                $(img).attr('ng-click', "openBodyVideoModal('lg', '"+src+"')");

                var compileScope = scope;
                $(element).replaceWith($compile(img)(compileScope));

                //element.html('test');
            }
        }
    }])
    .directive('dkAudio', ['$compile', function($compile){
        return {
            restrict: 'E',
            transclude: true,
            link: function(scope, element, attrs) {
                //console.log(attrs);
                var img = document.createElement('img');
                $(img).attr('src', '../../assets/images/audio-default.png');
                var src = attrs.src;

                $(img).attr('ng-click', "openBodyAudioModal('lg', '"+src+"')");

                var compileScope = scope;
                $(element).replaceWith($compile(img)(compileScope));

                //element.html('test');
            }
        }
    }])
    .directive('bindHtmlCompile', ['$compile', '$timeout', function ($compile, $timeout) {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                scope.$watch(function () {
                    return scope.$eval(attrs.bindHtmlCompile).toString();

                }, function (value) {

                    var trueHtml = scope.$eval(attrs.bindHtmlCompile).toString();


                    //var elem = angular.element(element);
                    //var elem = angular.element('<div>'+trueHtml+'</div>');
                    //var elem = angular.element('<div>'+trueHtml+'</div>');

                    //var videos = $('video[class^="record-"]', elem);

                    //videos.each(function( index ) {
                    //    var el = this;
                    //    var img = document.createElement('img');
                    //    $(img).attr('src', '../../assets/images/video-default.jpg');
                    //    var src = $('source',el).attr('src');
                    //    var src1 = src.substring(0,10);
                    //    var src2 = src.substring(10);
                    //    $(img).attr('ng-click', "openBodyVideoModal('lg', '"+src1+"', '"+src2+"')");
                    //    $(el).replaceWith(img);
                    //});
                    //
                    //var audios = $('audio[class^="record-"]', elem);
                    //
                    //audios.each(function( index ) {
                    //    var el = this;
                    //    var img = document.createElement('img');
                    //    $(img).attr('src', '../../assets/images/audio-default.png');
                    //    var src = $('source',el).attr('src');
                    //    var src1 = src.substring(0,10);
                    //    var src2 = src.substring(10);
                    //    $(img).attr('width', '100');
                    //    $(img).attr('ng-click', "openBodyAudioModal('lg', '"+src1+"', '"+src2+"')");
                    //    $(el).replaceWith(img);
                    //});

                    var compileScope = scope;

                    //element.html($compile(elem.html())(compileScope));
                    element.html($compile(trueHtml)(compileScope));

                });
            }
        };
    }])
    .controller('SponsorIndexCtrl', ['$scope', '$http', '$location', '$filter', '$sce', 'TreeService', 'SponsorService', 'ValuesService', '$interval', 'poollingFactory',
                                     'mapModal','FileUploader', '$modal', 'SecurityService',
    function($scope, $http, $location,  $filter, $sce,   TreeService,   SponsorService,   ValuesService, $interval, poollingFactory, mapModal,FileUploader, $modal, SecurityService) {

        
        /**
         * initializing config for list endless scroll
         */
        gb = document.getElementsByClassName('grid-block')[0];
        tbl = gb.getElementsByTagName('table')[0];
              
        
        gridblock = angular.element(gb);
        table = angular.element(tbl);
        
        gridblock.on('scroll', function() {
          if(gridblock.scrollTop() + gridblock.height() >= table.height()) {
              SponsorService.searchSponsor(SponsorService.sponsorList().length);
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
        uploader.formData.push({type : 'sponsor'});
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
                    uploadableExtensions = ["jpg", "jpeg", "png", "gif", "bmp"];
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
                    uploadableExtensions = ["jpg", "jpeg", "png", "gif", "bmp"];
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
                    SponsorService.addToImagesList(response);
                    break;
                case 'icon':
                    SponsorService.currentSponsor.icon = response;
                    break;
                case 'video':
                    SponsorService.addToVideosList(response);
                    break;
                case 'audio':
                    SponsorService.addToAudiosList(response);
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
        bannerUploader.formData.push({type : 'sponsor'});
        bannerUploader.msg = "";
        
        
        
        // FILTERS
            
        bannerUploader.filters.push({
            name: 'imageTypeFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                if(ValuesService.activeTab == 'image') {
                    uploadableType = "image";
                    uploadableExtensions = ["jpg", "jpeg", "png", "gif", "bmp"];
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
            
            SponsorService.currentSponsor.banner = response;
             
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
         * Vertical Banner Uploader start
         */

        var verticalBannerUploader = $scope.verticalBannerUploader = new FileUploader({
            url: '../managedfile/ajax/upload'
        });
        verticalBannerUploader.withCredentials = true;
        verticalBannerUploader.queueLimit =10 ;
        verticalBannerUploader.autoUpload = true;
        verticalBannerUploader.removeAfterUpload = true;
        verticalBannerUploader.formData.push({uploadDir : 'banner'});
        verticalBannerUploader.formData.push({type : 'sponsor'});
        verticalBannerUploader.msg = "";



        // FILTERS

        verticalBannerUploader.filters.push({
            name: 'imageTypeFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                if(ValuesService.activeTab == 'image') {
                    uploadableType = "image";
                    uploadableExtensions = ["jpg", "jpeg", "png", "gif", "bmp"];
                    fileType = item.type.split("/")[0];
                    fileExtension = item.type.split("/")[1];
                    if(fileType != uploadableType || uploadableExtensions.indexOf(fileExtension) == -1) {
                        return false;
                    }
                }
                return true;


            }
        });

//        verticalBannerUploader.filters.push({
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

        verticalBannerUploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
            console.info('onWhenAddingFileFailed', item, filter, options);
            switch(filter.name) {
                case 'imageTypeFilter':
                    verticalBannerUploader.msg = "شما فقط میتوانید فایل با پسوند های  png و bmp و jpg آپلود کنید";
                    break;
                case 'imageSizeFilter':
                    verticalBannerUploader.msg = 'imageSizeFilter';
                    break;
            }
        };
        verticalBannerUploader.onAfterAddingFile = function(fileItem) {
            console.info('onAfterAddingFile', fileItem);
        };
        verticalBannerUploader.onAfterAddingAll = function(addedFileItems) {
            console.info('onAfterAddingAll', addedFileItems);
        };
        verticalBannerUploader.onBeforeUploadItem = function(item) {
            console.info('onBeforeUploadItem', item);
        };
        verticalBannerUploader.onProgressItem = function(fileItem, progress) {
            console.info('onProgressItem', fileItem, progress);
        };
        verticalBannerUploader.onProgressAll = function(progress) {
            console.info('onProgressAll', progress);
        };
        verticalBannerUploader.onSuccessItem = function(fileItem, response, status, headers) {
            console.info('onSuccessItem', fileItem, response, status, headers);

            SponsorService.currentSponsor.vertical_banner = response;

            verticalBannerUploader.msg = 'فایل با موفقیت بارگزاری شد.';
        };
        verticalBannerUploader.onErrorItem = function(fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);
            alert(response);
        };
        verticalBannerUploader.onCancelItem = function(fileItem, response, status, headers) {
            console.info('onCancelItem', fileItem, response, status, headers);
        };
        verticalBannerUploader.onCompleteItem = function(fileItem, response, status, headers) {
            console.info('onCompleteItem', fileItem, response, status, headers);
        };
        verticalBannerUploader.onCompleteAll = function() {
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
         * body video modal initialization
         */




        $scope.openBodyVideoModal = function (size, video) {

            var treeModalInstance = $modal.open({
                templateUrl: 'bodyVideoModal.html',
                controller: 'bodyVideoModalCtrl as controller',
                size: size,
                resolve: {
                    video: function() {
                        return video;
                    }
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
         * body video modal initialization
         */




        $scope.openBodyAudioModal = function (size, audio) {

            var treeModalInstance = $modal.open({
                templateUrl: 'bodyAudioModal.html',
                controller: 'bodyAudioModalCtrl as controller',
                size: size,
                resolve: {
                    audio: function() {
                        return audio;
                    }
                },
                windowClass: 'audo-modal-window'
            });

            treeModalInstance.result.then(
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
         * Select Record modal initializing
         */
        
        
        $scope.openSelectRecordModal = function (size) {

            var bodySelectModalInstance = $modal.open({
                templateUrl: 'selectRecordModal.html',
                controller: 'selectRecordModalCtrl',
                size: size,
                resolve: {
                }
            });

            bodySelectModalInstance.result.then(
            function () {
                
            }, function () {
                
            });
        };

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
         *  SponsorService Initializing
         */
        $scope.SponsorService = SponsorService;
        $scope.SecurityService = SecurityService;
        $scope.SponsorService.getSponsorForCat(-3,0);
        $scope.sponsorList = function() {
            return SponsorService.sponsorList();
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
                    window.location = "../sponsor";

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
                        SponsorService.saveCurrentSponsor(contin);
                        $scope.sponsorform.$setPristine();

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
            tempBody = (SponsorService.currentSponsor.body)? SponsorService.currentSponsor.body : "";
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
    .factory('TreeService', ['$http', 'SponsorService', '$collection', function($http, SponsorService, $collection){

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
                SponsorService.sponsorSearchCriteria = {cid: node.id}
                SponsorService.searchSponsor();
            }

        };
    }])
    .factory('SponsorService', ['$http', 'Collection', 'ValuesService', '$filter' ,function($http, Collection, ValuesService, $filter){
        sponsorList = Collection.getInstance();
        var selectedSponsor = {};
//        var currentSponsor;





        var self = {

            currentSponsor: {active:false, verify:false}



        };


        
        self.removeBanner = function() {
            self.currentSponsor.banner = {}
        }

        self.removeVerticalBanner = function() {
            self.currentSponsor.banner = {}
        }
        
        self.list = sponsorList;
        self.nextSelectedSponsor = function() {
            var currentIndex = self.currentSelectedSponsor();
            if(self.nexable()){
                self.selectSponsor(self.list.array[currentIndex+1])
            }
        }

        self.nexable = function() {
            var currentIndex = self.currentSelectedSponsor();
            if(currentIndex != null &&
                currentIndex < (self.list.length - 1) ){
                return true;
            }
            return false;
        }

        self.previousSelectedSponsor = function() {
            var currentIndex = self.currentSelectedSponsor();
            if(self.previousable()){
                self.selectSponsor(self.list.array[currentIndex-1])
            }
        }

        self.previousable = function() {
            var currentIndex = self.currentSelectedSponsor();
            if(currentIndex != null &&
                currentIndex > 0 ){
                return true;
            }
            return false;
        }

        self.hasVideo = function() {
            if((typeof self.currentSponsor.videosList != 'undefined' && self.currentSponsor.videosList.length > 0) || 
               (typeof self.currentSponsor.bodyVideosList != 'undefined' && self.currentSponsor.bodyVideosList.length > 0) ) {
                return true;
            }
            return false;
        }
        
        self.hasAudio = function() {
            if((typeof self.currentSponsor.audiosList != 'undefined' && self.currentSponsor.audiosList.length > 0) || 
               (typeof self.currentSponsor.bodyAudiosList != 'undefined' && self.currentSponsor.bodyAudiosList.length > 0)) {
                return true;
            }
            return false;
        }

        self.currentSelectedSponsor =function() {
            currentSponsorIndex = null;
            angular.forEach(self.list.array, function(value,key) {
                if(value.id == selectedSponsor.id) {
                    currentSponsorIndex = key;
                    keepGoing = false;
                }
            })
            return currentSponsorIndex;
        }

        self.verifyCurrentSponsor = function() {
            return $http({
                method: 'PUT',
                url: 'ajax/verify_sponsor/'+self.currentSponsor.id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
            }).then(
                function(response){
                    self.currentSponsor.verify = true;
                },
                function(responseErr){
                }
            );
        }

        self.toggleVerifyCurrentSponsor = function() {
            if(!self.currentSponsor.id) {
                self.currentSponsor.verify = !self.currentSponsor.verify;
            } else {
                return $http({
                    method: 'PUT',
                    url: 'ajax/toggle_verify_sponsor/'+self.currentSponsor.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                }).then(
                    function(response){
                        self.currentSponsor.verify = response.data.verify;
                    },
                    function(responseErr){
                    }
                );
            }

        }

        self.setMainCurrentSponsor = function() {
            if(self.currentSponsor.id) {
                return $http({
                    method: 'PUT',
                    url: 'ajax/set_main_sponsor/'+self.currentSponsor.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                }).then(
                    function(response){
                        self.currentSponsor.main_sponsor = true;
                    },
                    function(responseErr){
                    }
                );
            }

        }

        self.toggleActiveCurrentSponsor = function() {
            if(!self.currentSponsor.id) {
                self.currentSponsor.active = !self.currentSponsor.active;
            }else {
                return $http({
                    method: 'PUT',
                    url: 'ajax/toggle_active_sponsor/'+self.currentSponsor.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                }).then(
                    function(response){
                        self.currentSponsor.active = response.data.active;
                    },
                    function(responseErr){
                    }
                );
            }

        }


        self.deleteCurrentSponsor = function(serv) {
            if(self.currentSponsor.id) {
                $http({
                    method: 'PUT',
                    url: 'ajax/delete_sponsor/'+self.currentSponsor.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                }).then(
                    function(response){
                        sponsorList.remove(selectedSponsor);
                        self.currentSponsor = {}
                        temporarySponsor = {}
                        serv.close();
                    },
                    function(responseErr){
                        console.log(responseErr)
                    }
                );
            }
        }




        self.currentSponsor.treeList = Collection.getInstance();
        self.currentSponsor.images = Collection.getInstance()
        self.currentSponsor.videos = Collection.getInstance()
        self.currentSponsor.audios = Collection.getInstance()

        self.saved = false;

        self.currentCid;

        self.sponsorSearchCriteria = {};

//        self.list = function() {
//            return items;
//        };

        self.selectedSponsor= function() {
            return selectedSponsor;
        };

        self.getSponsorForCat = function(cid, count) {
            
            $http.get('ajax/get_total_sponsor_for_cat/'+cid).then(function(response){
                self.totalSponsor = response.data;
            },function(errResponse){
            });
            
            $http.get('ajax/get_sponsor_for_cat/'+cid+'/'+count).then(function(response){
                if(!count) {sponsorList.removeAll();}
                sponsorList.addAll(response.data);
                self.currentCid = cid;
                if(!count) {selectedSponsor = {id:0};}
            },function(errResponse){
            });
        };

        self.getSponsorByCriteria = function(count) {
            if(!self.sponsorSearchCriteria.searchKeyword) {
                self.sponsorSearchCriteria.searchKeyword = "";
            }
            if(!self.sponsorSearchCriteria.searchBy) {
                self.sponsorSearchCriteria.searchBy = "1";
            }
            if(!self.sponsorSearchCriteria.sortBy) {
                self.sponsorSearchCriteria.sortBy = "1";
            }

            var lastSep = (self.sponsorSearchCriteria.searchKeyword)?'/':'';
            
            $http.get('ajax/total_search_sponsor/'+
                self.sponsorSearchCriteria.searchBy+'/'+
                self.sponsorSearchCriteria.sortBy+'/'+
                self.sponsorSearchCriteria.searchKeyword
                ).then(function(response){
                self.totalSponsor = response.data;
            },function(errResponse){
            });
            
            $http.get('ajax/search_sponsor/'+
                self.sponsorSearchCriteria.searchBy+'/'+
                self.sponsorSearchCriteria.sortBy+'/'+
                count+
                lastSep
                +
                self.sponsorSearchCriteria.searchKeyword
                ).then(function(response){

                if(!count) {sponsorList.removeAll();}
                sponsorList.addAll(response.data);
                self.currentCid = null;
                if(!count){selectedSponsor = {id:0};}
            },function(errResponse){
            });
        }

        self.searchSponsor = function(count) {
            
            if(!count) {
                count=0;
            }
            if(self.sponsorSearchCriteria.cid !=null) {
                self.getSponsorForCat(self.sponsorSearchCriteria.cid, count)
            } else {
                self.sponsorSearchCriteria.cid = null;
                self.getSponsorByCriteria(count);
            }

        }

        self.sponsorList = function() {
            return sponsorList.all();
        };

        var temporarySponsor = {}

        self.file = null;

        var editing = false;
        self.isEditing = function() {
            return editing;
        }

        self.editingNew= function() {

            temporarySponsor = angular.copy(self.currentSponsor);
            self.currentSponsor = angular.copy({});
            self.currentSponsor.treeList = Collection.getInstance();
            self.currentSponsor.imagesList = Collection.getInstance();
            self.currentSponsor.bodyImagesList = Collection.getInstance();
            self.currentSponsor.videosList = Collection.getInstance();
            self.currentSponsor.bodyVideosList = Collection.getInstance();
            self.currentSponsor.audiosList = Collection.getInstance();
            self.currentSponsor.bodyAudiosList = Collection.getInstance();
            self.currentSponsor.bodyDocsList = Collection.getInstance();
            
            

            


            /**
             * initializing verify active --begin
             */

            self.currentSponsor.verify = false;
            self.currentSponsor.active = false;
            self.currentSponsor.continual = true; 
            self.currentSponsor.rate = 10; 
            /* initializing verify active --end  */

            

            editing = true;
            ValuesService.getRandUploadKey(true);
            
            self.currentSponsor.publish_date = new Date();


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
            temporarySponsor = angular.copy(self.currentSponsor);
            editing = true;
        }

        self.cancelEditing = function() {
            self.currentSponsor = angular.copy(temporarySponsor);
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
            temporarySponsor = {}
            editing = false;
        }

        self.selectSponsor = function(sponsor) {
            selectedSponsor = sponsor;
            $http.get('ajax/get_sponsor/'+sponsor.id).then(
                function(response) {
                    self.currentSponsor = response.data;
                    

                    
                    self.currentSponsor.treeList = Collection.getInstance();
                    self.currentSponsor.treeList.addAll(self.currentSponsor.sponsortrees);

                    self.currentSponsor.imagesList = Collection.getInstance();
                    self.currentSponsor.imagesList.addAll(self.currentSponsor.images);

                    self.currentSponsor.videosList = Collection.getInstance();
                    self.currentSponsor.videosList.addAll(self.currentSponsor.videos);
                    self.currentSponsor.videoPlaylist = [];
                    angular.forEach(self.currentSponsor.videos, function(value, key){
                        var playlistItem = {};
                        playlistItem.src = value.absolute_path;
                        playlistItem.type = value.filemime;
                        self.currentSponsor.videoPlaylist.push(playlistItem);
                    });


                    self.currentSponsor.audiosList = Collection.getInstance();
                    self.currentSponsor.audiosList.addAll(self.currentSponsor.audios);
                    self.currentSponsor.audioPlaylist = [];
                    angular.forEach(self.currentSponsor.audios, function(value, key){
                        var playlistItem = {};
                        playlistItem.src = value.absolute_path;
                        playlistItem.type = value.filemime;
                        self.currentSponsor.audioPlaylist.push(playlistItem);
                    });


                    self.currentSponsor.bodyImagesList = Collection.getInstance();
                    self.currentSponsor.bodyImagesList.addAll(self.currentSponsor.body_images);

                    self.currentSponsor.bodyVideosList = Collection.getInstance();
                    self.currentSponsor.bodyVideosList.addAll(self.currentSponsor.body_videos);

                    self.currentSponsor.bodyAudiosList = Collection.getInstance();
                    self.currentSponsor.bodyAudiosList.addAll(self.currentSponsor.body_audios);
                    
                    self.currentSponsor.bodyDocsList = Collection.getInstance();
                    self.currentSponsor.bodyDocsList.addAll(self.currentSponsor.body_docs);
                },
                function(errResponse) {
                }
            );

        };

        self.addToImagesList = function(obj) {
            self.currentSponsor.imagesList.add(obj);
            self.currentSponsor.images = self.currentSponsor.imagesList.all();
        }

        self.addToBodyImagesList = function(obj) {
            self.currentSponsor.bodyImagesList.add(obj);
            self.currentSponsor.body_images = self.currentSponsor.bodyImagesList.all();
        }

        self.addToVideosList = function(obj) {
            self.currentSponsor.videosList.add(obj);
            self.currentSponsor.videos = self.currentSponsor.videosList.all();
            playlistItem = {};
            playlistItem.src = obj.absolute_path;
            playlistItem.type = obj.filemime;
            self.currentSponsor.videoPlaylist.push(playlistItem);
        }

        self.addToBodyVideosList = function(obj) {
            self.currentSponsor.bodyVideosList.add(obj);
            self.currentSponsor.body_videos = self.currentSponsor.bodyVideosList.all();
        }

        self.addToAudiosList = function(obj) {
            self.currentSponsor.audiosList.add(obj);
            self.currentSponsor.audios = self.currentSponsor.audiosList.all();
            playlistItem = {};
            playlistItem.src = obj.absolute_path;
            playlistItem.type = obj.filemime;
            self.currentSponsor.audioPlaylist.push(playlistItem);
        }

        self.addToBodyAudiosList = function(obj) {
            self.currentSponsor.bodyAudiosList.add(obj);
            self.currentSponsor.body_audios = self.currentSponsor.bodyAudiosList.all();
        }
        
        self.addToBodyDocsList = function(obj) {
            self.currentSponsor.bodyDocsList.add(obj);
            self.currentSponsor.body_docs = self.currentSponsor.bodyDocsList.all();
        }

        self.removeFromAttachList = function() {
            switch(ValuesService.activeTab) {
                case 'image':
                    angular.forEach(self.selectedImages, function(value, key){
                        self.currentSponsor.imagesList.remove(value);
                    });
                    self.currentSponsor.images = self.currentSponsor.imagesList.all();
                    break;
                case 'icon':
                    
                    self.currentSponsor.icon = {};
                    break;
                case 'video':
                    angular.forEach(self.selectedVideos, function(value, key){
                        self.currentSponsor.videosList.remove(value);
                    });
                    self.currentSponsor.videos = self.currentSponsor.videosList.all();
                    break;
                case 'audio':
                    angular.forEach(self.selectedAudios, function(value, key){
                        self.currentSponsor.audiosList.remove(value);
                    });
                    self.currentSponsor.audios = self.currentSponsor.audiosList.all();
                    break;

            }

        }
        
        self.cleanBodyAttachments = function() {
            bodyDom = angular.element(self.currentSponsor.body);
            angular.forEach(self.currentSponsor.bodyImagesList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentSponsor.bodyImagesList.remove(value);
                }
            });
            self.currentSponsor.body_images = self.currentSponsor.bodyImagesList.all();
            
            angular.forEach(self.currentSponsor.bodyVideosList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentSponsor.bodyVideosList.remove(value);
                }
            });
            self.currentSponsor.body_videos = self.currentSponsor.bodyVideosList.all();
            
            angular.forEach(self.currentSponsor.bodyAudiosList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentSponsor.bodyAudiosList.remove(value);
                }
            });
            self.currentSponsor.body_audios = self.currentSponsor.bodyAudiosList.all();
            
            angular.forEach(self.currentSponsor.bodyDocsList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentSponsor.bodyDocsList.remove(value);
                }
            });
            self.currentSponsor.body_docs = self.currentSponsor.bodyDocsList.all();
            
        }

        self.removeFromBodyAttachList = function() {
            switch(ValuesService.bodyAttachmentActiveTab) {
                case 'image':
                    angular.forEach(self.selectedBodyImages, function(value, key){
                        
                        bodyDom = angular.element(self.currentSponsor.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentSponsor.bodyImagesList.remove(value);
                        }
                        
                    });
                    self.currentSponsor.body_images = self.currentSponsor.bodyImagesList.all();
                    break;
                case 'video':
                    angular.forEach(self.selectedBodyVideos, function(value, key){
                        bodyDom = angular.element(self.currentSponsor.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentSponsor.bodyVideosList.remove(value);
                        }
                        
                    });
                    self.currentSponsor.body_videos = self.currentSponsor.bodyVideosList.all();
                    break;
                case 'audio':
                    angular.forEach(self.selectedBodyAudios, function(value, key){
                        bodyDom = angular.element(self.currentSponsor.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentSponsor.bodyAudiosList.remove(value);
                        }
                        
                    });
                    self.currentSponsor.body_audios = self.currentSponsor.bodyAudiosList.all();
                    break;
                
                case 'doc':
                    angular.forEach(self.selectedBodyDocs, function(value, key){
                        bodyDom = angular.element(self.currentSponsor.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentSponsor.bodyDocsList.remove(value);
                        }
                        
                    });
                    self.currentSponsor.body_docs = self.currentSponsor.bodyDocsList.all();
                    break;

            }

        }







        self.addToTreeList = function(obj, sort)  {
            angular.forEach(self.currentSponsor.treeList.array, function(value, key){
                if(obj.id == value.tree.id) {
                    self.currentSponsor.treeList.remove(value);
                }
            });
            obj.sort = sort;
            var tree = {};
            tree.tree = obj;
            tree.sort = (sort)?sort:60;
            self.currentSponsor.treeList.update(tree);
            self.currentSponsor.sponsortrees = self.currentSponsor.treeList.all() ;
            return obj.title+" به پیشنهاد ویژه اضافه شد.";
        }

        self.removeFromTreeList = function(selectedTrees)  {
            selectedTrees.forEach(function(tree, index, selectedTrees){
                self.currentSponsor.treeList.remove(tree);
            });

            self.currentSponsor.sponsortrees = self.currentSponsor.treeList.all() ;
        }

        self.updateCurrentSponsor = function() {
            self.currentSponsor._csrf_token = ValuesService.csrf;
            return $http({
                method: 'PUT',
                url: 'ajax/'+self.currentSponsor.id+'/update',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({data: angular.toJson(self.currentSponsor)})
            });
        }

        self.saveCurrentNewSponsor = function() {
            self.currentSponsor._csrf_token = ValuesService.csrf;
            self.currentSponsor.uploadKey = ValuesService.getRandUploadKey();
            return $http({
                method: 'POST',
                url: 'ajax/create',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({data: angular.toJson(self.currentSponsor)})
            });
        }

        self.isNew = function() {
            if(self.currentSponsor.id) {
                return false;
            } else {
                return true;
            }
        }



        self.saveCurrentSponsor = function(contin) {
            contin = (contin)? true : false;
            self.savingMessages = {}
            self.saved = false;
            if(!contin){
                self.cleanBodyAttachments();
            }
            if(self.isNew()) {

                self.saveCurrentNewSponsor().then(
                    function(response){
//                        self.currentSponsor = {}
//                        self.currentSponsor = response.data[0];

                        self.currentSponsor.id = response.data[0].id;
                        self.selectSponsor(self.currentSponsor);
                        self.saved = true;
                        self.savingMessages = ['خبر مورد نظر ذخیره شد.'];
                        if(!contin) {
                            self.searchSponsor();
                            self.finishEditing();
                        } else {
                            temporarySponsor = angular.copy(self.currentSponsor);
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
                self.updateCurrentSponsor().then(
                    function(response){
//                        self.currentSponsor = response.data;
                        self.saved = true;
                        self.savingMessages = ['خبر مورد نظر ذخیره شد.'];
                        if(!contin) {
                            self.searchSponsor();
                            self.finishEditing();
                        }else {
                            temporarySponsor = angular.copy(self.currentSponsor);
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
        
        

        

        self.isSelected = function(sponsor) {
            if(sponsor.id == selectedSponsor.id) {
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

    controller('treeModalCtrl', ['$scope', 'SponsorService','TreeService', '$modalInstance', function ($scope, SponsorService, TreeService, $modalInstance) {
        $scope.SponsorService = SponsorService;
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
    controller('bodyTreeModalCtrl', ['$scope', 'SponsorService','TreeService', '$modalInstance', function ($scope, SponsorService, TreeService, $modalInstance) {
        $scope.SponsorService = SponsorService;
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
    controller('bodySponsorModalCtrl', ['$scope', 'SponsorService','TreeService', '$modalInstance', function ($scope, SponsorService, TreeService, $modalInstance) {
        $scope.SponsorService = SponsorService;
        $scope.TreeService = TreeService;
        $scope.text = "";
        $scope.sponsorId = "";
        
        $scope.close = function () {
            $modalInstance.close();
        };

        var CkInstance = null;
        angular.forEach(CKEDITOR.instances,function(value, key){CkInstance = value; keepGoing = false;})
        
        $scope.insertSponsor = function() {
            
            console.log($scope.currentBodyTreeNode);
            CkInstance.insertHtml('<a href="#" class="body inner-link " sponsor-id="'+$scope.sponsorId+'">'+$scope.text+'</a>');
            $scope.close();
        }
    }]).
    controller('insertLinkModalCtrl', ['$scope', 'SponsorService','TreeService', '$modalInstance', function ($scope, SponsorService, TreeService, $modalInstance) {
        $scope.SponsorService = SponsorService;
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
    controller('savingModalCtrl', ['$scope', 'SponsorService','TreeService', '$modalInstance', function ($scope, SponsorService, TreeService, $modalInstance) {
        $scope.SponsorService = SponsorService;
        $scope.close = function(){$modalInstance.backdrop = true; $modalInstance.close();}

    }]).
    controller('deleteModalCtrl', ['$scope', '$modalInstance', 'SponsorService','TreeService', function ($scope, $modalInstance, SponsorService, TreeService) {
        $scope.SponsorService = SponsorService;
        $scope.close = function(){$modalInstance.close();}
        $scope.deleteCurrentSponsor = function() {
            console.log(SponsorService.deleteCurrentSponsor($modalInstance));
        }
    }]).
    controller('continualModalCtrl', ['$scope', '$http', '$modalInstance', 'SponsorService','TreeService', function ($scope, $http, $modalInstance, SponsorService, TreeService) {
        $scope.SponsorService = SponsorService;
        $scope.images = angular.copy(SponsorService.currentSponsor.imagesList.all());
        $scope.audios = angular.copy(SponsorService.currentSponsor.audiosList.all());
        $scope.videos = angular.copy(SponsorService.currentSponsor.videosList.all());
        
        $scope.bodyImages = angular.copy(SponsorService.currentSponsor.bodyImagesList.all());
        $scope.bodyAudios = angular.copy(SponsorService.currentSponsor.bodyAudiosList.all());
        $scope.bodyDocs = angular.copy(SponsorService.currentSponsor.bodyDocsList.all());
        $scope.bodyVideos = angular.copy(SponsorService.currentSponsor.bodyVideosList.all());
        $scope.close = function(){$modalInstance.close();}
        $scope.save = function() {
            SponsorService.currentSponsor.imagesList.removeAll();
            SponsorService.currentSponsor.imagesList.addAll($scope.images);
            SponsorService.currentSponsor.images = SponsorService.currentSponsor.imagesList.all();

            SponsorService.currentSponsor.audiosList.removeAll();
            SponsorService.currentSponsor.audiosList.addAll($scope.audios);
            SponsorService.currentSponsor.audios = SponsorService.currentSponsor.audiosList.all();

            SponsorService.currentSponsor.videosList.removeAll();
            SponsorService.currentSponsor.videosList.addAll($scope.videos);
            SponsorService.currentSponsor.videos = SponsorService.currentSponsor.videosList.all();

            SponsorService.currentSponsor.bodyImagesList.removeAll();
            SponsorService.currentSponsor.bodyImagesList.addAll($scope.bodyImages);
            SponsorService.currentSponsor.body_images = SponsorService.currentSponsor.bodyImagesList.all();

            SponsorService.currentSponsor.bodyAudiosList.removeAll();
            SponsorService.currentSponsor.bodyAudiosList.addAll($scope.bodyAudios);
            SponsorService.currentSponsor.body_audios = SponsorService.currentSponsor.bodyAudiosList.all();
            
            SponsorService.currentSponsor.bodyDocsList.removeAll();
            SponsorService.currentSponsor.bodyDocsList.addAll($scope.bodyDocs);
            SponsorService.currentSponsor.body_docs = SponsorService.currentSponsor.bodyDocsList.all();

            SponsorService.currentSponsor.bodyVideosList.removeAll();
            SponsorService.currentSponsor.bodyVideosList.addAll($scope.bodyVideos);
            SponsorService.currentSponsor.body_videos = SponsorService.currentSponsor.bodyVideosList.all();
            
            $modalInstance.close();
        }
        
    }]).
        
    controller('imageModalCtrl', ['$scope', '$modalInstance', 'SponsorService','TreeService', 'ValuesService', function ($scope, $modalInstance, SponsorService, TreeService, ValuesService) {
        $scope.SponsorService = SponsorService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentImageModal = {}; $modalInstance.close();}
        $scope.currentImage = SponsorService.currentSponsor.images[ValuesService.currentImageModal.index];
        $scope.totalImage = SponsorService.currentSponsor.images.length;
        $scope.currentIndex = ValuesService.currentImageModal.index + 1;
        $scope.next = function() {
            ValuesService.currentImageModal.index = ValuesService.currentImageModal.index + 1;
            $scope.currentImage = SponsorService.currentSponsor.images[ValuesService.currentImageModal.index];
            $scope.currentIndex = ValuesService.currentImageModal.index + 1;
        }
        $scope.prev = function() {
            ValuesService.currentImageModal.index = ValuesService.currentImageModal.index -1;
            $scope.currentImage = SponsorService.currentSponsor.images[ValuesService.currentImageModal.index];
            $scope.currentIndex = ValuesService.currentImageModal.index + 1;
        }



    }]).
    controller('iconModalCtrl', ['$scope', '$modalInstance', 'SponsorService','TreeService', 'ValuesService', function ($scope, $modalInstance, SponsorService, TreeService, ValuesService) {
        $scope.SponsorService = SponsorService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentIconModal = {}; $modalInstance.close();}
        $scope.icon = ValuesService.currentIconModal.image;
        



    }]).
    controller('bodyVideoModalCtrl', ['$scope', '$sce', '$modalInstance', 'SponsorService','TreeService', 'ValuesService', 'video', function ($scope, $sce, $modalInstance, SponsorService, TreeService, ValuesService, video) {
        this.config = {
            preload: "none",
            sources: [
                {src: $sce.trustAsResourceUrl(video), type: "video/mp4"}
            ],
            tracks: [

            ],
            theme: {
                url: "http://www.videogular.com/styles/themes/default/latest/videogular.css"
            }
        };
        this.video = video;

    }]).
    controller('bodyAudioModalCtrl', ['$scope', '$sce', '$modalInstance', 'SponsorService','TreeService', 'ValuesService', 'audio', function ($scope, $sce, $modalInstance, SponsorService, TreeService, ValuesService, audio) {

        this.config = {
            sources: [
                {src: $sce.trustAsResourceUrl(audio), type: "audio/mpeg"},
                {src: $sce.trustAsResourceUrl("http://static.videogular.com/assets/audios/videogular.ogg"), type: "audio/ogg"}
            ],
            theme: {
                url: "http://www.videogular.com/styles/themes/default/latest/videogular.css"
            }
        };
        this.audio = audio;

    }]).
    controller('videoModalCtrl', ['$scope', '$sce', '$modalInstance', 'SponsorService','TreeService', 'ValuesService', function ($scope, $sce, $modalInstance, SponsorService, TreeService, ValuesService) {
        $scope.SponsorService = SponsorService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentVideoModal = {}; $modalInstance.close();}
        $scope.currentVideo = SponsorService.currentSponsor.videos[ValuesService.currentVideoModal.index];
        $scope.totalVideo = SponsorService.currentSponsor.videos.length;
        $scope.currentIndex = ValuesService.currentVideoModal.index + 1;
        $scope.next = function() {
            ValuesService.currentVideoModal.index = ValuesService.currentVideoModal.index + 1;
            $scope.currentVideo = SponsorService.currentSponsor.videos[ValuesService.currentVideoModal.index];
            $scope.currentIndex = ValuesService.currentVideoModal.index + 1;
            var videoPlayer = document.getElementById('modal-video-player');
            videoPlayer.src = $scope.currentVideo.absolute_path;
            videoPlayer.load();
            videoPlayer.play();
        }
        $scope.prev = function() {
            ValuesService.currentVideoModal.index = ValuesService.currentVideoModal.index -1;
            $scope.currentVideo = SponsorService.currentSponsor.videos[ValuesService.currentVideoModal.index];
            $scope.currentIndex = ValuesService.currentVideoModal.index + 1;
            var videoPlayer = document.getElementById('modal-video-player');
            videoPlayer.src = $scope.currentVideo.absolute_path;
            videoPlayer.load();
            videoPlayer.play();
        }

    }]).
    controller('audioModalCtrl', ['$scope', '$sce', '$modalInstance', 'SponsorService','TreeService', 'ValuesService', function ($scope, $sce, $modalInstance, SponsorService, TreeService, ValuesService) {
        $scope.SponsorService = SponsorService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentAudioModal = {}; $modalInstance.close();}
        $scope.currentAudio = SponsorService.currentSponsor.audios[ValuesService.currentAudioModal.index];
        $scope.totalAudio = SponsorService.currentSponsor.audios.length;
        $scope.currentIndex = ValuesService.currentAudioModal.index + 1;
        $scope.next = function() {
            ValuesService.currentAudioModal.index = ValuesService.currentAudioModal.index + 1;
            $scope.currentAudio = SponsorService.currentSponsor.audios[ValuesService.currentAudioModal.index];
            $scope.currentIndex = ValuesService.currentAudioModal.index + 1;
            var audioPlayer = document.getElementById('modal-audio-player');
            audioPlayer.src = $scope.currentAudio.absolute_path;
            audioPlayer.load();
            audioPlayer.play();
        }
        $scope.prev = function() {
            ValuesService.currentAudioModal.index = ValuesService.currentAudioModal.index -1;
            $scope.currentAudio = SponsorService.currentSponsor.audios[ValuesService.currentAudioModal.index];
            $scope.currentIndex = ValuesService.currentAudioModal.index + 1;
            var audioPlayer = document.getElementById('modal-audio-player');
            audioPlayer.src = $scope.currentAudio.absolute_path;
            audioPlayer.load();
            audioPlayer.play();
        }

    }]).
    controller('cancelModalCtrl', ['$scope', '$modalInstance', 'SponsorService','TreeService', function ($scope, $modalInstance, SponsorService, TreeService) {
        $scope.SponsorService = SponsorService;
        $scope.close = function(){$modalInstance.close(false);}
        $scope.cancel = function() {
            SponsorService.cancelEditing(); 
            $modalInstance.close(true);
        }
    }]).
    controller('loginModalCtrl', ['$scope', '$http', '$modalInstance', 'SponsorService','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, SponsorService, ValuesService, SecurityService) {
        $scope.SponsorService = SponsorService;
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
                                window.location = "../sponsor";
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
    controller('logoutModalCtrl', ['$scope', '$http', '$modalInstance', 'SponsorService','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, SponsorService, ValuesService, SecurityService) {
        $scope.SponsorService = SponsorService;
        
        $scope.cancel = function() {
            $modalInstance.dismiss();
        }
        $scope.logout = function() {
            $modalInstance.close();
        }
    }]).
    controller('disconnectModalCtrl', ['$scope', '$http', '$modalInstance', 'SponsorService','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, SponsorService, ValuesService, SecurityService) {
        $scope.SponsorService = SponsorService;
        $scope.close = function(){$modalInstance.close(false);}
        
    }]).
    controller('bodyPreviewModalCtrl', ['$scope', '$http', '$sce', '$collection', '$modalInstance', 'SponsorService','ValuesService', 'SecurityService', '$modal', function ($scope, $http, $sce, $collection, $modalInstance, SponsorService, ValuesService, SecurityService, $modal) {
        $scope.SponsorService = SponsorService;
        $scope.close = function(){$modalInstance.close(false);}
        $scope.getTrustedBody =  function(untrustedBody) {
            tempBody = (untrustedBody)? untrustedBody : "";
            return $sce.trustAsHtml(tempBody);
        }
        $scope.history = $collection.getInstance();
        $scope.trustedBody = $scope.getTrustedBody(SponsorService.currentSponsor.body);
        $scope.innerLink = true;
        $scope.externalLink = false;

        /**
         * body video modal initialization
         */




        $scope.openBodyVideoModal = function (size, video) {

            var treeModalInstance = $modal.open({
                templateUrl: 'bodyVideoModal.html',
                controller: 'bodyVideoModalCtrl as controller',
                size: size,
                resolve: {
                    video: function() {
                        return video;
                    }
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
         * body video modal initialization
         */




        $scope.openBodyAudioModal = function (size, audio) {

            var treeModalInstance = $modal.open({
                templateUrl: 'bodyAudioModal.html',
                controller: 'bodyAudioModalCtrl as controller',
                size: size,
                resolve: {
                    audio: function() {
                        return audio;
                    }
                },
                windowClass: 'audo-modal-window'
            });

            treeModalInstance.result.then(
                function () {

                }, function () {

                });
        };

        ///////////////

        $scope.loadSponsor = function(sponsorId) {
            $scope.innerLink = true;
            $scope.externalLink = false;
            $http.get('ajax/get_sponsor_by_id/' + sponsorId).then(
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
                angular.element(document.querySelectorAll('.body-preview-content a[sponsor-id]')).unbind('click');
                angular.element(document.querySelectorAll('.body-preview-content a[sponsor-id]')).on('click', function (event) {
                    sponsorId = event.toElement.getAttribute('sponsor-id');
                    $scope.loadSponsor(sponsorId);
                    $scope.history.add({func: $scope.loadSponsor, arg: sponsorId});
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
        
        $scope.history.add({func: $scope.loadSponsor, arg: SponsorService.currentSponsor.id});
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
    controller('selectRecordModalCtrl', ['$scope', 'SponsorService','TreeService', '$modalInstance', function ($scope, SponsorService, TreeService, $modalInstance) {
        $scope.SponsorService = SponsorService;
        $scope.TreeService = TreeService;
        $scope.text = "";
        $scope.recordId = "";
        
        $scope.close = function () {
            $modalInstance.close();
        };

        
        $scope.insertRecord = function(record) {
            console.log(record.originalObject);
            SponsorService.currentSponsor.submitter_title = record.originalObject.title;
            SponsorService.currentSponsor.submitter_number = record.originalObject.record_number;
            $scope.close();
        }
    }]).
    controller('bodyModalCtrl', ['$scope', '$http', 'SponsorService','TreeService', 'ValuesService','SecurityService', 'FileUploader', '$modalInstance', '$modal', 'recordform', 
        function (                $scope,   $http,   SponsorService,  TreeService,   ValuesService, SecurityService, FileUploader, $modalInstance, $modal, recordform) {
        $scope.recordform = recordform;
        $scope.SponsorService = SponsorService;
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
            smiley_images: ['(smiley).png','(happy).png','(wink2).png','(wink).png','(laugh).png','(teeth).png','(yummi).png','(surprised).png','(crazy).png','(money).png','(moa).png','(inlove).png','(flirt).png','(teary).png','(mad).png','(upset).png','(cry).png','(angry).png','(sick).png','(sleeping).png','(info).png','(Q).png','(heart).png','(purple_heart).png','(clap).png','(like).png','(V).png','(unlike).png','(flower).png','(balloon2).png','(balloon1).png','(cake).png','(gift).png','(partyhat).png','(cupcake).png','(magnify).png','(glasses).png','(letter).png','(thinking).png','(music).png','(pencil).png','(book).png','(ruler).png','(scissor).png','(dollar).png','(run).png','(time).png','(bell).png','(telephone).png','(snowman).png','(snowflake).png','(rain).png','(cloud).png','(moon).png','(sun).png','(angel).png','(palmtree).png','(christmas_tree).png','(sunflower).png','(cactus).png','(sprout).png','(clover).png','(koala).png','(bunny).png','(squirrel).png','(goldfish).png','(monkey).png','(cat).png','(kangaroo).png','(ladybug).png','(turtle).png','(sheep).png','(panda).png','(owl).png','(chick).png','(dog).png','(bee).png','(penguin).png','(dragonfly).png','(pig).png','(snake).png','(snail).png','(fly).png','(shark).png','(bat).png','(martini).png','(beer).png','(coffee).png','(soda).png','(burger).png','(pizza).png','(hotdog).png','(popcorn).png','(egg).png','(noodles).png','(chicken).png','(donut).png','(popsicle).png','(ice_cream).png','(lollipop).png','(croissant).png','(chocolate).png','(cherry).png','(grapes).png','(watermelon).png','(strawberry).png','(banana).png','(pineapple).png','(corn).png','(pea).png','(mushroom).png','(bicycle).png','(taxi).png','(ambulance).png','(policecar).png','(car).png','(airplane).png','(rocket).png','(ufo).png','(flipflop).png','(umbrella).png','(fidora).png','(cap).png','(crown).png','(diamond).png','(ring).png','(relax).png','(battery).png','(nobattery).png','(termometer).png','(meds).png','(syringe).png','(golfball).png','(golf).png','(soccer).png','(baseball).png','(basketball).png','(tennis).png','(beachball).png','(8ball).png','(boxing).png','(football).png','(weight).png','(muscle).png','(trophy).png','(happycry).png','(silly).png','(nerd).png','(shy).png','(not_sure).png','(confused).png','(meh).png','(what).png','(yo).png','(wtf).png','(tongue).png','(sad).png','(exhausted).png','(huh).png','(scream).png','(weak).png','(dead).png','(mischievous).png','(ohno).png','(straight).png','(dizzy).png','(cool).png','(spiderman).png','(eek).png','(ugh).png','(devil).png','(oh).png','(depressed).png','(mwah).png','(singing).png','(batman).png','(ninja).png','(light_bulb).png','(fire).png','(torch).png','(sushi1).png','(sushi2).png','(phone).png','(knife).png','(key).png','(angrymark).png','(bomb).png','(mapleleaf).png','(zzz).png','(guitar).png','(trumpet).png','(hammer).png','(dice).png','(console).png','(lantern).png','(microphone).png','(tape).png','(speaker).png','(video).png','(TV).png','(wrench).png','(lock).png','(paperclip).png','(skull).png','(ghost).png','(paw).png','(darkish-logo).png'],
            smiley_columns: 20,            
            toolbar: [
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Halfhr', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'Video', 'Sponsor' ] },
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
                        SponsorService.saveCurrentSponsor(contin);
//                        $scope.sponsorform.$setPristine();

                    }
                }, 
                function(errResponse){
                    $scope.openDisconnectModal();
                }
            );
            
        }
        
        
        /**
         * Body Sponsor modal initializing
         */
        
        
        $scope.openBodySponsorModal = function (size) {

            var bodySponsorModalInstance = $modal.open({
                templateUrl: 'bodySponsorModal.html',
                controller: 'bodySponsorModalCtrl',
                size: size,
                resolve: {
                    
                }
            });

            bodySponsorModalInstance.result.then(
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
        uploader.formData.push({type : 'sponsor'});
        
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
                    uploadableExtensions = ["jpg", "jpeg", "png", "gif", "bmp"];
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
                    SponsorService.addToBodyImagesList(response);
                    break;
                case 'video':
                    SponsorService.addToBodyVideosList(response);
                    break;
                case 'audio':
                    SponsorService.addToBodyAudiosList(response);
                    break;
                case 'doc':
                    SponsorService.addToBodyDocsList(response);
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
                    var fileClass = SponsorService.selectedBodyImage.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;"><img class="'+fileClass+'"  alt="" style="width:200px;" src="'+SponsorService.selectedBodyImage.absolute_path+'" /></p>');
                    break;
                case 'video':
                    var fileClass = SponsorService.selectedBodyVideo.file_name.replace(".", "-");
                    //CkInstance.insertHtml('<p class="'+fileClass+'"  style="text-align:center;" ><video class="'+fileClass+'"  controls="" name="media" width="300"><source src="'+SponsorService.selectedBodyVideo.absolute_path+'" type="'+SponsorService.selectedBodyVideo.filemime+'"></video></p>');
                    CkInstance.insertHtml('<p class="'+fileClass+'"  style="text-align:center;" ><dk-video class="'+fileClass+'"  controls="" name="media" width="300" src="'+SponsorService.selectedBodyVideo.absolute_path+'" type="'+SponsorService.selectedBodyVideo.filemime+'"></dk-video></p>');
                    break;
                case 'audio':
                    var fileClass = SponsorService.selectedBodyAudio.file_name.replace(".", "-");
                    //CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;" ><audio class="'+fileClass+'"  controls="" name="media" width="300"><source src="'+SponsorService.selectedBodyAudio.absolute_path+'" type="'+SponsorService.selectedBodyAudio.filemime+'"></audio></p>');
                    CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;" ><dk-audio class="'+fileClass+'"  controls="" name="media" width="300" src="'+SponsorService.selectedBodyAudio.absolute_path+'" type="'+SponsorService.selectedBodyAudio.filemime+'"></dk-audio></p>');
                    break;
                    
                case 'doc':
                    var text = prompt("لطفا متن مربوط به لینک دانلود فایل را وارد نمایید. در غیر این صورت نام فایل به عنوان متن در نظر گرفته می شود.");
                    text = (text)?text:SponsorService.selectedBodyDoc.file_name;
                    var fileClass = SponsorService.selectedBodyDoc.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;" ><a class="body web-link '+fileClass+'" href="'+SponsorService.selectedBodyDoc.absolute_path+'"  > '+text+'  </a></p>');
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

    }]).factory('SecurityService', ['$http', 'SponsorService', function($http, SponsorService){
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
            if(editAccess[SponsorService.currentSponsor.id] == 'waiting') {
                return false;
            }
            
            if(!angular.isDefined(editAccess[SponsorService.currentSponsor.id])) {
                editAccess[SponsorService.currentSponsor.id] = 'waiting';
                
                $http.get('ajax/check_permission/edit/'+SponsorService.currentSponsor.id).then(
                    function(response){
                        editAccess[SponsorService.currentSponsor.id] = response.data[0];
                        return editAccess[SponsorService.currentSponsor.id];
                    },
                    function(errResponse){
                        editAccess[SponsorService.currentSponsor.id] = null;
                        return false;
                    }
                );
            } else {
                return editAccess[SponsorService.currentSponsor.id];
            }
            
        }
        
        
        self.actionsAccess.deleteAccess = function() {
            if(deleteAccess[SponsorService.currentSponsor.id] == 'waiting') {
                return false;
            }
            
            if(!angular.isDefined(deleteAccess[SponsorService.currentSponsor.id])) {
                deleteAccess[SponsorService.currentSponsor.id] = 'waiting';
                
                $http.get('ajax/check_permission/remove/'+SponsorService.currentSponsor.id).then(
                    function(response){
                        deleteAccess[SponsorService.currentSponsor.id] = response.data[0];
                        return deleteAccess[SponsorService.currentSponsor.id];
                    },
                    function(errResponse){
                        deleteAccess[SponsorService.currentSponsor.id] = null;
                        return false;
                    }
                );
            } else {
                return deleteAccess[SponsorService.currentSponsor.id];
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
            if(SponsorService.isNew()) {
                return true;
            } else {
                return self.actionsAccess.editAccess();
            }
            
        }
        
        
        
        self.buttonsAccess.saveAndContinueButtonAccess = function() {
            if(SponsorService.isNew()) {
                return true;
            } else {
                return self.actionsAccess.editAccess();
            }
            
        }
        
        return self;
        
        
        
    } ]);
