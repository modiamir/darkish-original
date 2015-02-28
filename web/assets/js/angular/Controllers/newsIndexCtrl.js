//var newsIndexCtrl = angular.module('NewsIndexCtrl', ['newstreeControl', 'angularFileUpload']);
//var newsIndexCtrl = newsApp.module('NewsIndexCtrl', ['newstreeControl', 'angularFileUpload']);


    // inject the Comment service into our controller
//    newsIndexCtrl.controller('NewsIndexController', ['$modal','$scope','$http', '$upload', '$interval', 'NewsTree','NewsControl',
//        function($modal, $scope, $http, $upload, $interval, NewsTree, NewsControl) {
//            $scope.test = "this is test";
//        }]);

angular.module('NewsApp', ['treeControl', 'ui.grid', 'smart-table', 'btford.modal', 'ngCollection', 'ngSanitize', 'ngCkeditor', 'ui.bootstrap', 'ui.bootstrap.persian.datepicker', 'checklist-model',
                            ,'mediaPlayer', 'infinite-scroll','angularFileUpload', 'uiGmapgoogle-maps', 'duScroll'
    ])
    .config(['uiGmapGoogleMapApiProvider', function (GoogleMapApi) {
        GoogleMapApi.configure({
      //    key: 'your api key',
          v: '3.17',
          libraries: 'weather,geometry,visualization'
        });
    }])      
    .controller('NewsIndexCtrl', ['$scope', '$http', '$location', '$filter', '$sce', 'TreeService', 'NewsService', 'ValuesService', '$interval', 'poollingFactory',
                                     'mapModal','FileUploader', '$modal', 'SecurityService',
    function($scope, $http, $location,  $filter, $sce,   TreeService,   NewsService,   ValuesService, $interval, poollingFactory, mapModal,FileUploader, $modal, SecurityService) {

        
        /**
         * initializing config for list endless scroll
         */
        gb = document.getElementsByClassName('grid-block')[0];
        tbl = gb.getElementsByTagName('table')[0];
              
        
        gridblock = angular.element(gb);
        table = angular.element(tbl);
        
        gridblock.on('scroll', function() {
          if(gridblock.scrollTop() + gridblock.height() >= table.height()) {
              NewsService.searchNews(NewsService.newsList().length);
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
        uploader.formData.push({type : 'news'});
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
                    NewsService.addToImagesList(response);
                    break;
                case 'icon':
                    NewsService.currentNews.icon = response;
                    break;
                case 'video':
                    NewsService.addToVideosList(response);
                    break;
                case 'audio':
                    NewsService.addToAudiosList(response);
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

        console.info('uploader', uploader);
        //////////////////////////


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
         *  NewsService Initializing
         */
        $scope.NewsService = NewsService;
        $scope.SecurityService = SecurityService;
        $scope.NewsService.getNewsForCat(-3,0);
        $scope.newsList = function() {
            return NewsService.newsList();
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
                    window.location = "../news";
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
                        NewsService.saveCurrentNews(contin);
                        $scope.newsform.$setPristine();

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
            tempBody = (NewsService.currentNews.body)? NewsService.currentNews.body : "";
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
    .factory('TreeService', ['$http', 'NewsService', '$collection', function($http, NewsService, $collection){

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
                NewsService.newsSearchCriteria = {cid: node.id}
                NewsService.searchNews();
            }

        };
    }])
    .factory('NewsService', ['$http', 'Collection', 'ValuesService', '$filter' ,function($http, Collection, ValuesService, $filter){
        newsList = Collection.getInstance();
        var selectedNews = {};
//        var currentNews;




        var self = {

            currentNews: {active:false, verify:false}



        };


        

        self.list = newsList;
        self.nextSelectedNews = function() {
            var currentIndex = self.currentSelectedNews();
            if(self.nexable()){
                self.selectNews(self.list.array[currentIndex+1])
            }
        }

        self.nexable = function() {
            var currentIndex = self.currentSelectedNews();
            if(currentIndex != null &&
                currentIndex < (self.list.length - 1) ){
                return true;
            }
            return false;
        }

        self.previousSelectedNews = function() {
            var currentIndex = self.currentSelectedNews();
            if(self.previousable()){
                self.selectNews(self.list.array[currentIndex-1])
            }
        }

        self.previousable = function() {
            var currentIndex = self.currentSelectedNews();
            if(currentIndex != null &&
                currentIndex > 0 ){
                return true;
            }
            return false;
        }

        self.hasVideo = function() {
            if((typeof self.currentNews.videosList != 'undefined' && self.currentNews.videosList.length > 0) || 
               (typeof self.currentNews.bodyVideosList != 'undefined' && self.currentNews.bodyVideosList.length > 0) ) {
                return true;
            }
            return false;
        }
        
        self.hasAudio = function() {
            if((typeof self.currentNews.audiosList != 'undefined' && self.currentNews.audiosList.length > 0) || 
               (typeof self.currentNews.bodyAudiosList != 'undefined' && self.currentNews.bodyAudiosList.length > 0)) {
                return true;
            }
            return false;
        }

        self.currentSelectedNews =function() {
            currentNewsIndex = null;
            angular.forEach(self.list.array, function(value,key) {
                if(value.id == selectedNews.id) {
                    currentNewsIndex = key;
                    keepGoing = false;
                }
            })
            return currentNewsIndex;
        }

        self.verifyCurrentNews = function() {
            return $http({
                method: 'PUT',
                url: 'ajax/verify_news/'+self.currentNews.id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
            }).then(
                function(response){
                    self.currentNews.verify = true;
                },
                function(responseErr){
                }
            );
        }

        self.toggleVerifyCurrentNews = function() {
            if(!self.currentNews.id) {
                self.currentNews.verify = !self.currentNews.verify;
            } else {
                return $http({
                    method: 'PUT',
                    url: 'ajax/toggle_verify_news/'+self.currentNews.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                }).then(
                    function(response){
                        self.currentNews.verify = response.data.verify;
                    },
                    function(responseErr){
                    }
                );
            }

        }

        self.toggleActiveCurrentNews = function() {
            if(!self.currentNews.id) {
                self.currentNews.active = !self.currentNews.active;
            }else {
                return $http({
                    method: 'PUT',
                    url: 'ajax/toggle_active_news/'+self.currentNews.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                }).then(
                    function(response){
                        self.currentNews.active = response.data.active;
                    },
                    function(responseErr){
                    }
                );
            }

        }


        self.deleteCurrentNews = function(serv) {
            if(self.currentNews.id) {
                $http({
                    method: 'PUT',
                    url: 'ajax/delete_news/'+self.currentNews.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                }).then(
                    function(response){
                        newsList.remove(selectedNews);
                        self.currentNews = {}
                        temporaryNews = {}
                        serv.close();
                    },
                    function(responseErr){
                        console.log(responseErr)
                    }
                );
            }
        }




        self.currentNews.treeList = Collection.getInstance();
        self.currentNews.images = Collection.getInstance()
        self.currentNews.videos = Collection.getInstance()
        self.currentNews.audios = Collection.getInstance()

        self.saved = false;

        self.currentCid;

        self.newsSearchCriteria = {};

//        self.list = function() {
//            return items;
//        };

        self.selectedNews= function() {
            return selectedNews;
        };

        self.getNewsForCat = function(cid, count) {
            
            $http.get('ajax/get_total_news_for_cat/'+cid).then(function(response){
                self.totalNews = response.data;
            },function(errResponse){
            });
            
            $http.get('ajax/get_news_for_cat/'+cid+'/'+count).then(function(response){
                if(!count) {newsList.removeAll();}
                newsList.addAll(response.data);
                self.currentCid = cid;
                if(!count) {selectedNews = {id:0};}
            },function(errResponse){
            });
        };

        self.getNewsByCriteria = function(count) {
            if(!self.newsSearchCriteria.searchKeyword) {
                self.newsSearchCriteria.searchKeyword = "";
            }
            if(!self.newsSearchCriteria.searchBy) {
                self.newsSearchCriteria.searchBy = "1";
            }
            if(!self.newsSearchCriteria.sortBy) {
                self.newsSearchCriteria.sortBy = "1";
            }

            var lastSep = (self.newsSearchCriteria.searchKeyword)?'/':'';
            
            $http.get('ajax/total_search_news/'+
                self.newsSearchCriteria.searchBy+'/'+
                self.newsSearchCriteria.sortBy+'/'+
                self.newsSearchCriteria.searchKeyword
                ).then(function(response){
                self.totalNews = response.data;
            },function(errResponse){
            });
            
            $http.get('ajax/search_news/'+
                self.newsSearchCriteria.searchBy+'/'+
                self.newsSearchCriteria.sortBy+'/'+
                count+
                lastSep
                +
                self.newsSearchCriteria.searchKeyword
                ).then(function(response){

                if(!count) {newsList.removeAll();}
                newsList.addAll(response.data);
                self.currentCid = null;
                if(!count){selectedNews = {id:0};}
            },function(errResponse){
            });
        }

        self.searchNews = function(count) {
            
            if(!count) {
                count=0;
            }
            if(self.newsSearchCriteria.cid !=null) {
                self.getNewsForCat(self.newsSearchCriteria.cid, count)
            } else {
                self.newsSearchCriteria.cid = null;
                self.getNewsByCriteria(count);
            }

        }

        self.newsList = function() {
            return newsList.all();
        };

        var temporaryNews = {}

        self.file = null;

        var editing = false;
        self.isEditing = function() {
            return editing;
        }

        self.editingNew= function() {

            temporaryNews = angular.copy(self.currentNews);
            self.currentNews = angular.copy({});
            self.currentNews.treeList = Collection.getInstance();
            self.currentNews.imagesList = Collection.getInstance();
            self.currentNews.bodyImagesList = Collection.getInstance();
            self.currentNews.videosList = Collection.getInstance();
            self.currentNews.bodyVideosList = Collection.getInstance();
            self.currentNews.audiosList = Collection.getInstance();
            self.currentNews.bodyAudiosList = Collection.getInstance();
            self.currentNews.bodyDocsList = Collection.getInstance();

            

            


            /**
             * initializing verify active --begin
             */

            self.currentNews.verify = false;
            self.currentNews.active = false;
            self.currentNews.continual = true; 
            self.currentNews.rate = 10; 
            /* initializing verify active --end  */

            

            editing = true;
            ValuesService.getRandUploadKey(true);
            
            self.currentNews.publish_date = new Date();


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
            temporaryNews = angular.copy(self.currentNews);
            editing = true;
        }

        self.cancelEditing = function() {
            self.currentNews = angular.copy(temporaryNews);
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
            temporaryNews = {}
            editing = false;
        }

        self.selectNews = function(news) {
            selectedNews = news;
            $http.get('ajax/get_news/'+news.id).then(
                function(response) {
                    self.currentNews = response.data;
                    

                    
                    self.currentNews.treeList = Collection.getInstance();
                    self.currentNews.treeList.addAll(self.currentNews.newstrees);

                    self.currentNews.imagesList = Collection.getInstance();
                    self.currentNews.imagesList.addAll(self.currentNews.images);

                    self.currentNews.videosList = Collection.getInstance();
                    self.currentNews.videosList.addAll(self.currentNews.videos);
                    self.currentNews.videoPlaylist = [];
                    angular.forEach(self.currentNews.videos, function(value, key){
                        var playlistItem = {};
                        playlistItem.src = value.absolute_path;
                        playlistItem.type = value.filemime;
                        self.currentNews.videoPlaylist.push(playlistItem);
                    });


                    self.currentNews.audiosList = Collection.getInstance();
                    self.currentNews.audiosList.addAll(self.currentNews.audios);
                    self.currentNews.audioPlaylist = [];
                    angular.forEach(self.currentNews.audios, function(value, key){
                        var playlistItem = {};
                        playlistItem.src = value.absolute_path;
                        playlistItem.type = value.filemime;
                        self.currentNews.audioPlaylist.push(playlistItem);
                    });


                    self.currentNews.bodyImagesList = Collection.getInstance();
                    self.currentNews.bodyImagesList.addAll(self.currentNews.body_images);

                    self.currentNews.bodyVideosList = Collection.getInstance();
                    self.currentNews.bodyVideosList.addAll(self.currentNews.body_videos);

                    self.currentNews.bodyAudiosList = Collection.getInstance();
                    self.currentNews.bodyAudiosList.addAll(self.currentNews.body_audios);
                    
                    self.currentNews.bodyDocsList = Collection.getInstance();
                    self.currentNews.bodyDocsList.addAll(self.currentNews.body_docs);
                },
                function(errResponse) {
                }
            );

        };

        self.addToImagesList = function(obj) {
            self.currentNews.imagesList.add(obj);
            self.currentNews.images = self.currentNews.imagesList.all();
        }

        self.addToBodyImagesList = function(obj) {
            self.currentNews.bodyImagesList.add(obj);
            self.currentNews.body_images = self.currentNews.bodyImagesList.all();
        }

        self.addToVideosList = function(obj) {
            self.currentNews.videosList.add(obj);
            self.currentNews.videos = self.currentNews.videosList.all();
            playlistItem = {};
            playlistItem.src = obj.absolute_path;
            playlistItem.type = obj.filemime;
            self.currentNews.videoPlaylist.push(playlistItem);
        }

        self.addToBodyVideosList = function(obj) {
            self.currentNews.bodyVideosList.add(obj);
            self.currentNews.body_videos = self.currentNews.bodyVideosList.all();
        }

        self.addToAudiosList = function(obj) {
            self.currentNews.audiosList.add(obj);
            self.currentNews.audios = self.currentNews.audiosList.all();
            playlistItem = {};
            playlistItem.src = obj.absolute_path;
            playlistItem.type = obj.filemime;
            self.currentNews.audioPlaylist.push(playlistItem);
        }

        self.addToBodyAudiosList = function(obj) {
            self.currentNews.bodyAudiosList.add(obj);
            self.currentNews.body_audios = self.currentNews.bodyAudiosList.all();
        }
        
        self.addToBodyDocsList = function(obj) {
            self.currentNews.bodyDocsList.add(obj);
            self.currentNews.body_docs = self.currentNews.bodyDocsList.all();
        }

        self.removeFromAttachList = function() {
            switch(ValuesService.activeTab) {
                case 'image':
                    angular.forEach(self.selectedImages, function(value, key){
                        self.currentNews.imagesList.remove(value);
                    });
                    self.currentNews.images = self.currentNews.imagesList.all();
                    break;
                case 'icon':
                    
                    self.currentNews.icon = {};
                    break;
                case 'video':
                    angular.forEach(self.selectedVideos, function(value, key){
                        self.currentNews.videosList.remove(value);
                    });
                    self.currentNews.videos = self.currentNews.videosList.all();
                    break;
                case 'audio':
                    angular.forEach(self.selectedAudios, function(value, key){
                        self.currentNews.audiosList.remove(value);
                    });
                    self.currentNews.audios = self.currentNews.audiosList.all();
                    break;

            }

        }
        
        self.cleanBodyAttachments = function() {
            bodyDom = angular.element(self.currentNews.body);
            angular.forEach(self.currentNews.bodyImagesList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentNews.bodyImagesList.remove(value);
                }
            });
            self.currentNews.body_images = self.currentNews.bodyImagesList.all();
            
            angular.forEach(self.currentNews.bodyVideosList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentNews.bodyVideosList.remove(value);
                }
            });
            self.currentNews.body_videos = self.currentNews.bodyVideosList.all();
            
            angular.forEach(self.currentNews.bodyAudiosList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentNews.bodyAudiosList.remove(value);
                }
            });
            self.currentNews.body_audios = self.currentNews.bodyAudiosList.all();
            
            angular.forEach(self.currentNews.bodyDocsList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentNews.bodyDocsList.remove(value);
                }
            });
            self.currentNews.body_docs = self.currentNews.bodyDocsList.all();
            
        }

        self.removeFromBodyAttachList = function() {
            switch(ValuesService.bodyAttachmentActiveTab) {
                case 'image':
                    angular.forEach(self.selectedBodyImages, function(value, key){
                        
                        bodyDom = angular.element(self.currentNews.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentNews.bodyImagesList.remove(value);
                        }
                        
                    });
                    self.currentNews.body_images = self.currentNews.bodyImagesList.all();
                    break;
                case 'video':
                    angular.forEach(self.selectedBodyVideos, function(value, key){
                        bodyDom = angular.element(self.currentNews.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentNews.bodyVideosList.remove(value);
                        }
                        
                    });
                    self.currentNews.body_videos = self.currentNews.bodyVideosList.all();
                    break;
                case 'audio':
                    angular.forEach(self.selectedBodyAudios, function(value, key){
                        bodyDom = angular.element(self.currentNews.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentNews.bodyAudiosList.remove(value);
                        }
                        
                    });
                    self.currentNews.body_audios = self.currentNews.bodyAudiosList.all();
                    break;
                
                case 'doc':
                    angular.forEach(self.selectedBodyDocs, function(value, key){
                        bodyDom = angular.element(self.currentNews.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentNews.bodyDocsList.remove(value);
                        }
                        
                    });
                    self.currentNews.body_docs = self.currentNews.bodyDocsList.all();
                    break;

            }

        }







        self.addToTreeList = function(obj, sort)  {

            angular.forEach(self.currentNews.treeList.array, function(value, key){
                if(obj.id == value.tree.id) {
                    self.currentNews.treeList.remove(value);
                }
            });

            obj.sort = sort;
            var tree = {};
            tree.tree = obj;
            tree.sort = (sort)?sort:60;
            self.currentNews.treeList.update(tree);
            self.currentNews.newstrees = self.currentNews.treeList.all() ;
            return obj.title+" به خبر اضافه شد.";

            
        }

        self.removeFromTreeList = function(selectedTrees)  {
            selectedTrees.forEach(function(tree, index, selectedTrees){
                self.currentNews.treeList.remove(tree);
            });

            self.currentNews.newstrees = self.currentNews.treeList.all() ;
        }

        self.updateCurrentNews = function() {
            self.currentNews._csrf_token = ValuesService.csrf;
            return $http({
                method: 'PUT',
                url: 'ajax/'+self.currentNews.id+'/update',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({data: angular.toJson(self.currentNews)})
            });
        }

        self.saveCurrentNewNews = function() {
            self.currentNews._csrf_token = ValuesService.csrf;
            self.currentNews.uploadKey = ValuesService.getRandUploadKey();
            return $http({
                method: 'POST',
                url: 'ajax/create',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({data: angular.toJson(self.currentNews)})
            });
        }

        self.isNew = function() {
            if(self.currentNews.id) {
                return false;
            } else {
                return true;
            }
        }



        self.saveCurrentNews = function(contin) {
            contin = (contin)? true : false;
            self.savingMessages = {}
            self.saved = false;
            if(!contin){
                self.cleanBodyAttachments();
            }
            if(self.isNew()) {

                self.saveCurrentNewNews().then(
                    function(response){
//                        self.currentNews = {}
//                        self.currentNews = response.data[0];

                        self.currentNews.id = response.data[0].id;
                        self.selectNews(self.currentNews);
                        self.saved = true;
                        self.savingMessages = ['خبر مورد نظر ذخیره شد.'];
                        if(!contin) {
                            self.searchNews();
                            self.finishEditing();
                        } else {
                            temporaryNews = angular.copy(self.currentNews);
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
                self.updateCurrentNews().then(
                    function(response){
//                        self.currentNews = response.data;
                        self.saved = true;
                        self.savingMessages = ['خبر مورد نظر ذخیره شد.'];
                        if(!contin) {
                            self.searchNews();
                            self.finishEditing();
                        }else {
                            temporaryNews = angular.copy(self.currentNews);
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
        
        

        

        self.isSelected = function(news) {
            if(news.id == selectedNews.id) {
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

    controller('treeModalCtrl', ['$scope', 'NewsService','TreeService', '$modalInstance', function ($scope, NewsService, TreeService, $modalInstance) {
        $scope.NewsService = NewsService;
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
    controller('bodyTreeModalCtrl', ['$scope', 'NewsService','TreeService', '$modalInstance', function ($scope, NewsService, TreeService, $modalInstance) {
        $scope.NewsService = NewsService;
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
    controller('bodyNewsModalCtrl', ['$scope', 'NewsService','TreeService', '$modalInstance', function ($scope, NewsService, TreeService, $modalInstance) {
        $scope.NewsService = NewsService;
        $scope.TreeService = TreeService;
        $scope.text = "";
        $scope.newsId = "";
        
        $scope.close = function () {
            $modalInstance.close();
        };

        var CkInstance = null;
        angular.forEach(CKEDITOR.instances,function(value, key){CkInstance = value; keepGoing = false;})
        
        $scope.insertNews = function() {
            
            console.log($scope.currentBodyTreeNode);
            CkInstance.insertHtml('<a href="#" class="body inner-link " news-id="'+$scope.newsId+'">'+$scope.text+'</a>');
            $scope.close();
        }
    }]).
    controller('insertLinkModalCtrl', ['$scope', 'NewsService','TreeService', '$modalInstance', function ($scope, NewsService, TreeService, $modalInstance) {
        $scope.NewsService = NewsService;
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
    controller('savingModalCtrl', ['$scope', 'NewsService','TreeService', '$modalInstance', function ($scope, NewsService, TreeService, $modalInstance) {
        $scope.NewsService = NewsService;
        $scope.close = function(){$modalInstance.backdrop = true; $modalInstance.close();}

    }]).
    controller('deleteModalCtrl', ['$scope', '$modalInstance', 'NewsService','TreeService', function ($scope, $modalInstance, NewsService, TreeService) {
        $scope.NewsService = NewsService;
        $scope.close = function(){$modalInstance.close();}
        $scope.deleteCurrentNews = function() {
            console.log(NewsService.deleteCurrentNews($modalInstance));
        }
    }]).
    controller('continualModalCtrl', ['$scope', '$http', '$modalInstance', 'NewsService','TreeService', function ($scope, $http, $modalInstance, NewsService, TreeService) {
        $scope.NewsService = NewsService;
        $scope.images = angular.copy(NewsService.currentNews.imagesList.all());
        $scope.audios = angular.copy(NewsService.currentNews.audiosList.all());
        $scope.videos = angular.copy(NewsService.currentNews.videosList.all());
        
        $scope.bodyImages = angular.copy(NewsService.currentNews.bodyImagesList.all());
        $scope.bodyAudios = angular.copy(NewsService.currentNews.bodyAudiosList.all());
        $scope.bodyDocs = angular.copy(NewsService.currentNews.bodyDocsList.all());
        $scope.bodyVideos = angular.copy(NewsService.currentNews.bodyVideosList.all());
        $scope.close = function(){$modalInstance.close();}
        $scope.save = function() {
            NewsService.currentNews.imagesList.removeAll();
            NewsService.currentNews.imagesList.addAll($scope.images);
            NewsService.currentNews.images = NewsService.currentNews.imagesList.all();

            NewsService.currentNews.audiosList.removeAll();
            NewsService.currentNews.audiosList.addAll($scope.audios);
            NewsService.currentNews.audios = NewsService.currentNews.audiosList.all();

            NewsService.currentNews.videosList.removeAll();
            NewsService.currentNews.videosList.addAll($scope.videos);
            NewsService.currentNews.videos = NewsService.currentNews.videosList.all();

            NewsService.currentNews.bodyImagesList.removeAll();
            NewsService.currentNews.bodyImagesList.addAll($scope.bodyImages);
            NewsService.currentNews.body_images = NewsService.currentNews.bodyImagesList.all();

            NewsService.currentNews.bodyAudiosList.removeAll();
            NewsService.currentNews.bodyAudiosList.addAll($scope.bodyAudios);
            NewsService.currentNews.body_audios = NewsService.currentNews.bodyAudiosList.all();
            
            NewsService.currentNews.bodyDocsList.removeAll();
            NewsService.currentNews.bodyDocsList.addAll($scope.bodyDocs);
            NewsService.currentNews.body_docs = NewsService.currentNews.bodyDocsList.all();

            NewsService.currentNews.bodyVideosList.removeAll();
            NewsService.currentNews.bodyVideosList.addAll($scope.bodyVideos);
            NewsService.currentNews.body_videos = NewsService.currentNews.bodyVideosList.all();
            
            $modalInstance.close();
        }
        
    }]).
        
    controller('imageModalCtrl', ['$scope', '$modalInstance', 'NewsService','TreeService', 'ValuesService', function ($scope, $modalInstance, NewsService, TreeService, ValuesService) {
        $scope.NewsService = NewsService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentImageModal = {}; $modalInstance.close();}
        $scope.currentImage = NewsService.currentNews.images[ValuesService.currentImageModal.index];
        $scope.totalImage = NewsService.currentNews.images.length;
        $scope.currentIndex = ValuesService.currentImageModal.index + 1;
        $scope.next = function() {
            ValuesService.currentImageModal.index = ValuesService.currentImageModal.index + 1;
            $scope.currentImage = NewsService.currentNews.images[ValuesService.currentImageModal.index];
            $scope.currentIndex = ValuesService.currentImageModal.index + 1;
        }
        $scope.prev = function() {
            ValuesService.currentImageModal.index = ValuesService.currentImageModal.index -1;
            $scope.currentImage = NewsService.currentNews.images[ValuesService.currentImageModal.index];
            $scope.currentIndex = ValuesService.currentImageModal.index + 1;
        }



    }]).
    controller('iconModalCtrl', ['$scope', '$modalInstance', 'NewsService','TreeService', 'ValuesService', function ($scope, $modalInstance, NewsService, TreeService, ValuesService) {
        $scope.NewsService = NewsService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentIconModal = {}; $modalInstance.close();}
        $scope.icon = ValuesService.currentIconModal.image;
        



    }]).
    controller('videoModalCtrl', ['$scope', '$sce', '$modalInstance', 'NewsService','TreeService', 'ValuesService', function ($scope, $sce, $modalInstance, NewsService, TreeService, ValuesService) {
        $scope.NewsService = NewsService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentVideoModal = {}; $modalInstance.close();}
        $scope.currentVideo = NewsService.currentNews.videos[ValuesService.currentVideoModal.index];
        $scope.totalVideo = NewsService.currentNews.videos.length;
        $scope.currentIndex = ValuesService.currentVideoModal.index + 1;
        $scope.next = function() {
            ValuesService.currentVideoModal.index = ValuesService.currentVideoModal.index + 1;
            $scope.currentVideo = NewsService.currentNews.videos[ValuesService.currentVideoModal.index];
            $scope.currentIndex = ValuesService.currentVideoModal.index + 1;
            var videoPlayer = document.getElementById('modal-video-player');
            videoPlayer.src = $scope.currentVideo.absolute_path;
            videoPlayer.load();
            videoPlayer.play();
        }
        $scope.prev = function() {
            ValuesService.currentVideoModal.index = ValuesService.currentVideoModal.index -1;
            $scope.currentVideo = NewsService.currentNews.videos[ValuesService.currentVideoModal.index];
            $scope.currentIndex = ValuesService.currentVideoModal.index + 1;
            var videoPlayer = document.getElementById('modal-video-player');
            videoPlayer.src = $scope.currentVideo.absolute_path;
            videoPlayer.load();
            videoPlayer.play();
        }

    }]).
    controller('audioModalCtrl', ['$scope', '$sce', '$modalInstance', 'NewsService','TreeService', 'ValuesService', function ($scope, $sce, $modalInstance, NewsService, TreeService, ValuesService) {
        $scope.NewsService = NewsService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentAudioModal = {}; $modalInstance.close();}
        $scope.currentAudio = NewsService.currentNews.audios[ValuesService.currentAudioModal.index];
        $scope.totalAudio = NewsService.currentNews.audios.length;
        $scope.currentIndex = ValuesService.currentAudioModal.index + 1;
        $scope.next = function() {
            ValuesService.currentAudioModal.index = ValuesService.currentAudioModal.index + 1;
            $scope.currentAudio = NewsService.currentNews.audios[ValuesService.currentAudioModal.index];
            $scope.currentIndex = ValuesService.currentAudioModal.index + 1;
            var audioPlayer = document.getElementById('modal-audio-player');
            audioPlayer.src = $scope.currentAudio.absolute_path;
            audioPlayer.load();
            audioPlayer.play();
        }
        $scope.prev = function() {
            ValuesService.currentAudioModal.index = ValuesService.currentAudioModal.index -1;
            $scope.currentAudio = NewsService.currentNews.audios[ValuesService.currentAudioModal.index];
            $scope.currentIndex = ValuesService.currentAudioModal.index + 1;
            var audioPlayer = document.getElementById('modal-audio-player');
            audioPlayer.src = $scope.currentAudio.absolute_path;
            audioPlayer.load();
            audioPlayer.play();
        }

    }]).
    controller('cancelModalCtrl', ['$scope', '$modalInstance', 'NewsService','TreeService', function ($scope, $modalInstance, NewsService, TreeService) {
        $scope.NewsService = NewsService;
        $scope.close = function(){$modalInstance.close(false);}
        $scope.cancel = function() {
            NewsService.cancelEditing(); 
            $modalInstance.close(true);
        }
    }]).
    controller('loginModalCtrl', ['$scope', '$http', '$modalInstance', 'NewsService','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, NewsService, ValuesService, SecurityService) {
        $scope.NewsService = NewsService;
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
                                window.location = "../news";
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
    controller('logoutModalCtrl', ['$scope', '$http', '$modalInstance', 'NewsService','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, NewsService, ValuesService, SecurityService) {
        $scope.NewsService = NewsService;
        
        $scope.cancel = function() {
            $modalInstance.dismiss();
        }
        $scope.logout = function() {
            $modalInstance.close();
        }
    }]).
    controller('disconnectModalCtrl', ['$scope', '$http', '$modalInstance', 'NewsService','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, NewsService, ValuesService, SecurityService) {
        $scope.NewsService = NewsService;
        $scope.close = function(){$modalInstance.close(false);}
        
    }]).
    controller('bodyPreviewModalCtrl', ['$scope', '$http', '$sce', '$collection', '$modalInstance', 'NewsService','ValuesService', 'SecurityService', function ($scope, $http, $sce, $collection, $modalInstance, NewsService, ValuesService, SecurityService) {
        $scope.NewsService = NewsService;
        $scope.close = function(){$modalInstance.close(false);}
        $scope.getTrustedBody =  function(untrustedBody) {
            tempBody = (untrustedBody)? untrustedBody : "";
            return $sce.trustAsHtml(tempBody);
        }
        $scope.history = $collection.getInstance();
        $scope.trustedBody = $scope.getTrustedBody(NewsService.currentNews.body);
        $scope.innerLink = true;
        $scope.externalLink = false;
        
        $scope.loadNews = function(newsId) {
            $scope.innerLink = true;
            $scope.externalLink = false;
            $http.get('ajax/get_news_by_id/' + newsId).then(
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
                angular.element(document.querySelectorAll('.body-preview-content a[news-id]')).unbind('click');
                angular.element(document.querySelectorAll('.body-preview-content a[news-id]')).on('click', function (event) {
                    newsId = event.toElement.getAttribute('news-id');
                    $scope.loadNews(newsId);
                    $scope.history.add({func: $scope.loadNews, arg: newsId});
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
        
        $scope.history.add({func: $scope.loadNews, arg: NewsService.currentNews.id});
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
    controller('bodyModalCtrl', ['$scope', '$http', 'NewsService','TreeService', 'ValuesService', 'SecurityService', 'FileUploader', '$modalInstance', '$modal', 'recordform', 
        function (                $scope,   $http,   NewsService,  TreeService,   ValuesService, SecurityService, FileUploader, $modalInstance, $modal, recordform) {
        $scope.recordform = recordform;
        $scope.NewsService = NewsService;
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
                { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Halfhr', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'Video', 'News' ] },
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
                        NewsService.saveCurrentNews(contin);
//                        $scope.newsform.$setPristine();

                    }
                }, 
                function(errResponse){
                    $scope.openDisconnectModal();
                }
            );
            
        }
        
        
        /**
         * Body News modal initializing
         */
        
        
        $scope.openBodyNewsModal = function (size) {

            var bodyNewsModalInstance = $modal.open({
                templateUrl: 'bodyNewsModal.html',
                controller: 'bodyNewsModalCtrl',
                size: size,
                resolve: {
                    
                }
            });

            bodyNewsModalInstance.result.then(
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
        uploader.formData.push({type : 'news'});
        
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
                    NewsService.addToBodyImagesList(response);
                    break;
                case 'video':
                    NewsService.addToBodyVideosList(response);
                    break;
                case 'audio':
                    NewsService.addToBodyAudiosList(response);
                    break;
                case 'doc':
                    NewsService.addToBodyDocsList(response);
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
                    var fileClass = NewsService.selectedBodyImage.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;"><img class="'+fileClass+'"  alt="" style="width:200px;" src="'+NewsService.selectedBodyImage.absolute_path+'" /></p>');
                    break;
                case 'video':
                    var fileClass = NewsService.selectedBodyVideo.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'"  style="text-align:center;" ><video class="'+fileClass+'"  controls="" name="media" width="300"><source src="'+NewsService.selectedBodyVideo.absolute_path+'" type="'+NewsService.selectedBodyVideo.filemime+'"></video></p>');
                    break;
                case 'audio':
                    var fileClass = NewsService.selectedBodyAudio.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;" ><audio class="'+fileClass+'"  controls="" name="media" width="300"><source src="'+NewsService.selectedBodyAudio.absolute_path+'" type="'+NewsService.selectedBodyAudio.filemime+'"></audio></p>');
                    break;
                    
                case 'doc':
                    var text = prompt("لطفا متن مربوط به لینک دانلود فایل را وارد نمایید. در غیر این صورت نام فایل به عنوان متن در نظر گرفته می شود.");
                    text = (text)?text:NewsService.selectedBodyDoc.file_name;
                    var fileClass = NewsService.selectedBodyDoc.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;" ><a class="body web-link '+fileClass+'" href="'+NewsService.selectedBodyDoc.absolute_path+'"  > '+text+'  </a></p>');
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

    }]).factory('SecurityService', ['$http', 'NewsService', function($http, NewsService){
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
            if(editAccess[NewsService.currentNews.id] == 'waiting') {
                return false;
            }
            
            if(!angular.isDefined(editAccess[NewsService.currentNews.id])) {
                editAccess[NewsService.currentNews.id] = 'waiting';
                
                $http.get('ajax/check_permission/edit/'+NewsService.currentNews.id).then(
                    function(response){
                        editAccess[NewsService.currentNews.id] = response.data[0];
                        return editAccess[NewsService.currentNews.id];
                    },
                    function(errResponse){
                        editAccess[NewsService.currentNews.id] = null;
                        return false;
                    }
                );
            } else {
                return editAccess[NewsService.currentNews.id];
            }
            
        }
        
        
        self.actionsAccess.deleteAccess = function() {
            if(deleteAccess[NewsService.currentNews.id] == 'waiting') {
                return false;
            }
            
            if(!angular.isDefined(deleteAccess[NewsService.currentNews.id])) {
                deleteAccess[NewsService.currentNews.id] = 'waiting';
                
                $http.get('ajax/check_permission/remove/'+NewsService.currentNews.id).then(
                    function(response){
                        deleteAccess[NewsService.currentNews.id] = response.data[0];
                        return deleteAccess[NewsService.currentNews.id];
                    },
                    function(errResponse){
                        deleteAccess[NewsService.currentNews.id] = null;
                        return false;
                    }
                );
            } else {
                return deleteAccess[NewsService.currentNews.id];
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
            if(NewsService.isNew()) {
                return true;
            } else {
                return self.actionsAccess.editAccess();
            }
            
        }
        
        
        
        self.buttonsAccess.saveAndContinueButtonAccess = function() {
            if(NewsService.isNew()) {
                return true;
            } else {
                return self.actionsAccess.editAccess();
            }
            
        }
        
        return self;
        
        
        
    } ]);
