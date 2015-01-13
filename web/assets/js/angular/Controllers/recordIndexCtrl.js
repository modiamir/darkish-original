//var recordIndexCtrl = angular.module('RecordIndexCtrl', ['recordtreeControl', 'angularFileUpload']);
//var recordIndexCtrl = recordApp.module('RecordIndexCtrl', ['recordtreeControl', 'angularFileUpload']);


    // inject the Comment service into our controller
//    recordIndexCtrl.controller('RecordIndexController', ['$modal','$scope','$http', '$upload', '$interval', 'RecordTree','RecordControl',
//        function($modal, $scope, $http, $upload, $interval, NewsTree, NewsControl) {
//            $scope.test = "this is test";
//        }]);

angular.module('RecordApp', ['treeControl', 'ui.grid', 'smart-table', 'btford.modal', 'ngCollection', 'ngSanitize', 'ngCkeditor', 'ui.bootstrap', 'ui.bootstrap.persian.datepicker', 'checklist-model',
                            ,'mediaPlayer', 'infinite-scroll','angularFileUpload', 'uiGmapgoogle-maps', 'duScroll'
    ])
    .config(['uiGmapGoogleMapApiProvider', function (GoogleMapApi) {
        GoogleMapApi.configure({
      //    key: 'your api key',
          v: '3.17',
          libraries: 'weather,geometry,visualization'
        });
    }])      
    .controller('RecordIndexCtrl', ['$scope', '$http', '$location', '$filter', '$sce', 'TreeService', 'RecordService', 'ValuesService','$interval', 'poollingFactory',
                                     'mapModal','FileUploader', '$modal',
    function($scope, $http, $location,  $filter, $sce,   TreeService,   RecordService,   ValuesService, $interval, poollingFactory, mapModal,FileUploader, $modal) {


        gb = document.getElementsByClassName('grid-block')[0];
        tbl = gb.getElementsByTagName('table')[0];
              
        
        gridblock = angular.element(gb);
        table = angular.element(tbl);
        
        gridblock.on('scroll', function() {
          if(gridblock.scrollTop() + gridblock.height() >= table.height()) {
              RecordService.searchRecords(RecordService.recordList().length);
          }
        });



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
        uploader.formData.push({type : 'record'});
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
                    RecordService.addToImagesList(response);
                    break;
                case 'icon':
                    RecordService.currentRecord.icon = response;
                    break;
                case 'video':
                    RecordService.addToVideosList(response);
                    break;
                case 'audio':
                    RecordService.addToAudiosList(response);
                    break;

            }
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
         * Titles modal initialization
         */
        
        
    
            
        $scope.openTitlesModal = function (size) {

            var treeModalInstance = $modal.open({
                templateUrl: 'titlesModal.html',
                controller: 'titlesModalCtrl',
                size: size,
                resolve: {
                    
                },
                windowClass: 'titles-modal-window'
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
         *
         *  RecordService Initializing
         */
        $scope.RecordService = RecordService;
        $scope.RecordService.getRecordsForCat(-3,0);
        $scope.recordList = function() {
            return RecordService.recordList();
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

        $scope.openInsertDate= function($event) {

           $event.preventDefault();
           $event.stopPropagation();

           $scope.insertDateIsOpen = true;
           $scope.validityDateIsOpen = false;
        };
        $scope.openValidityDate = function($event) {
           $event.preventDefault();
           $event.stopPropagation();

           $scope.validityDateIsOpen = true;
           $scope.insertDateIsOpen = false;
        };

        $scope.dateOptions = {
           formatYear: 'yy',
           startingDay: 6
        };

        $scope.initDate = new Date('2016-15-20');
        $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
        $scope.format = $scope.formats[0];



        $scope.logout = function() {
            $http.get('../operator/logout').then(
                function(response){
                    $scope.loggedOut();
                },
                function(responseErr){
                    console.log(responseErr);
                }
            );
        }

        $scope.isLoggedIn = function() {
            $http.get('../user/ajax/is_logged_in').then(
                function(response){
//                    console.log(response.data[0]);
                    if(response.data[0] === false) {
                        $scope.loggedOut();
                    } else {
                        
                    }
                },
                function(responseErr){
                    
                }
            );
        }

        $scope.loggedOut = function() {
            alert("" +
            "شما خارج شده اید. بر روی تایید کلیک کنید تا به صفحه ورود منتقل شوید." +
            "");
            window.location = "../record";
        }

        poollingFactory.callFnOnInterval(function() {
            $scope.isLoggedIn();
        });



        $interval(function(){
            $scope.loaded = true;
        }, 3000);





        $scope.trustedBody =  function() {
            tempBody = (RecordService.currentRecord.body)? RecordService.currentRecord.body : "";
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
    .factory('TreeService', ['$http', 'RecordService', '$collection', function($http, RecordService, $collection){

        var tree = [];
        
        var treeOptions = {
            nodeChildren: "children",
            dirSelectable: false,
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
                RecordService.recordSearchCriteria = {cid: node.id}
                RecordService.searchRecords();
            }

        };
    }])
    .factory('RecordService', ['$http', 'Collection', 'ValuesService', '$filter' ,function($http, Collection, ValuesService, $filter){
        recordList = Collection.getInstance();
        var selectedRecord = {};
//        var currentRecord;




        var self = {

            currentRecord: {}



        };


        self.toggleCapability = function(cap) {
            if(self.isEditing()) {
                switch(cap) {
                    case 'favorite_enable':
                        self.currentRecord.favorite_enable = (self.currentRecord.favorite_enable == true) ? false : true;
                        break;
                    case 'like_enable':
                        self.currentRecord.like_enable = (self.currentRecord.like_enable == true) ? false : true;
                        break;
                    case 'send_sms_enable':
                        self.currentRecord.send_sms_enable = (self.currentRecord.send_sms_enable == true) ? false : true;
                        break;
                    case 'online_ticket':
                        self.currentRecord.online_ticket = (self.currentRecord.online_ticket == true) ? false : true;
                        break;
                    case 'audio':
                        self.currentRecord.audio = (self.currentRecord.audio == true) ? false : true;
                        break;
                    case 'video':
                        self.currentRecord.video = (self.currentRecord.video == true) ? false : true;
                        break;
                }
            }

        }

        self.list = recordList;
        self.nextSelectedRecord = function() {
            var currentIndex = self.currentSelectedRecord();
            if(self.nexable()){
                self.selectRecord(self.list.array[currentIndex+1])
            }
        }

        self.nexable = function() {
            var currentIndex = self.currentSelectedRecord();
            if(currentIndex != null &&
                currentIndex < (self.list.length - 1) ){
                return true;
            }
            return false;
        }

        self.previousSelectedRecord = function() {
            var currentIndex = self.currentSelectedRecord();
            if(self.previousable()){
                self.selectRecord(self.list.array[currentIndex-1])
            }
        }

        self.previousable = function() {
            var currentIndex = self.currentSelectedRecord();
            if(currentIndex != null &&
                currentIndex > 0 ){
                return true;
            }
            return false;
        }

        self.hasVideo = function() {
            if((typeof self.currentRecord.videosList != 'undefined' && self.currentRecord.videosList.length > 0) || 
               (typeof self.currentRecord.bodyVideosList != 'undefined' && self.currentRecord.bodyVideosList.length > 0) ) {
                return true;
            }
            return false;
        }
        
        self.hasAudio = function() {
            if((typeof self.currentRecord.audiosList != 'undefined' && self.currentRecord.audiosList.length > 0) || 
               (typeof self.currentRecord.bodyAudiosList != 'undefined' && self.currentRecord.bodyAudiosList.length > 0)) {
                return true;
            }
            return false;
        }

        self.currentSelectedRecord =function() {
            currentRecordIndex = null;
            angular.forEach(self.list.array, function(value,key) {
                if(value.id == selectedRecord.id) {
                    currentRecordIndex = key;
                    keepGoing = false;
                }
            })
            return currentRecordIndex;
        }

        self.verifyCurrentRecord = function() {
            return $http({
                method: 'PUT',
                url: 'ajax/verify_record/'+self.currentRecord.id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
            }).then(
                function(response){
                    self.currentRecord.verify = true;
                },
                function(responseErr){
                }
            );
        }

        self.toggleVerifyCurrentRecord = function() {
            if(!self.currentRecord.id) {
                self.currentRecord.verify = !self.currentRecord.verify;
            } else {
                return $http({
                    method: 'PUT',
                    url: 'ajax/toggle_verify_record/'+self.currentRecord.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                }).then(
                    function(response){
                        self.currentRecord.verify = response.data.verify;
                    },
                    function(responseErr){
                    }
                );
            }

        }

        self.toggleActiveCurrentRecord = function() {
            if(!self.currentRecord.id) {
                self.currentRecord.active = !self.currentRecord.active;
            }else {
                return $http({
                    method: 'PUT',
                    url: 'ajax/toggle_active_record/'+self.currentRecord.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                }).then(
                    function(response){
                        self.currentRecord.active = response.data.active;
                    },
                    function(responseErr){
                    }
                );
            }

        }


        self.deleteCurrentRecord = function(serv) {
            if(self.currentRecord.id) {
                $http({
                    method: 'PUT',
                    url: 'ajax/delete_record/'+self.currentRecord.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                }).then(
                    function(response){
                        recordList.remove(selectedRecord);
                        self.currentRecord = {}
                        temporaryRecord = {}
                        serv.close();
                    },
                    function(responseErr){
                        console.log(responseErr)
                    }
                );
            }
        }




        self.currentRecord.treeList = Collection.getInstance();
        self.currentRecord.images = Collection.getInstance()
        self.currentRecord.videos = Collection.getInstance()
        self.currentRecord.audios = Collection.getInstance()

        self.saved = false;

        self.currentCid;

        self.recordSearchCriteria = {};

//        self.list = function() {
//            return items;
//        };

        self.selectedRecord= function() {
            return selectedRecord;
        };

        self.getRecordsForCat = function(cid, count) {
            $http.get('ajax/get_record_for_cat/'+cid+'/'+count).then(function(response){
                if(!count) {recordList.removeAll();}
                recordList.addAll(response.data);
                self.currentCid = cid;
                if(!count) {selectedRecord = {id:0};}
            },function(errResponse){
            });
        };

        self.getRecordsByCriteria = function(count) {
            if(!self.recordSearchCriteria.searchKeyword) {
                self.recordSearchCriteria.searchKeyword = "";
            }
            if(!self.recordSearchCriteria.searchBy) {
                self.recordSearchCriteria.searchBy = "1";
            }
            if(!self.recordSearchCriteria.sortBy) {
                self.recordSearchCriteria.sortBy = "1";
            }

            var lastSep = (self.recordSearchCriteria.searchKeyword)?'/':'';
            $http.get('ajax/search_record/'+
                self.recordSearchCriteria.searchBy+'/'+
                self.recordSearchCriteria.sortBy+'/'+
                count+
                lastSep
                +
                self.recordSearchCriteria.searchKeyword
                ).then(function(response){

                if(!count) {recordList.removeAll();}
                recordList.addAll(response.data);
                self.currentCid = null;
                if(!count){selectedRecord = {id:0};}
            },function(errResponse){
            });
        }

        self.searchRecords = function(count) {
            
            if(!count) {
                count=0;
            }
            if(self.recordSearchCriteria.cid !=null) {
                self.getRecordsForCat(self.recordSearchCriteria.cid, count)
            } else {
                self.recordSearchCriteria.cid = null;
                self.getRecordsByCriteria(count);
            }

        }

        self.recordList = function() {
            return recordList.all();
        };

        var temporaryRecord = {}

        self.file = null;

        var editing = false;
        self.isEditing = function() {
            return editing;
        }

        self.editingNew= function() {

            $http.get('ajax/get_last_recordnumber').then(
                function(response){
                    defaultRecordNumber = response.data;
                    result = prompt("شماره رکورد را وارد کنید.", defaultRecordNumber);
                    if(result) {
                        if($filter('number')(result) && result.length <= 6 && result.length > 0) {
                            for(var i = result.length ; i< 6 ; i++) {
                                result = "0"+result;
                            }
                            $http({
                                method: 'PUT',
                                url: 'ajax/lock_record_number/'+result,
                                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
                            }).then(
                                function(response){
                                    if(response.data == 0){
                                        temporaryRecord = angular.copy(self.currentRecord);
                                        self.currentRecord = angular.copy({});
                                        self.currentRecord.record_number = result;
                                        self.currentRecord.treeList = Collection.getInstance();
                                        self.currentRecord.imagesList = Collection.getInstance();
                                        self.currentRecord.bodyImagesList = Collection.getInstance();
                                        self.currentRecord.videosList = Collection.getInstance();
                                        self.currentRecord.bodyVideosList = Collection.getInstance();
                                        self.currentRecord.audiosList = Collection.getInstance();
                                        self.currentRecord.bodyAudiosList = Collection.getInstance();
                                        self.currentRecord.bodyDocsList = Collection.getInstance();

                                        /**
                                         * initializing working time variables -- begin
                                         *
                                         */

                                        self.currentRecord.m_opening_hours_from_date = new Date();
                                        self.currentRecord.m_opening_hours_from_date.setHours(0);
                                        self.currentRecord.m_opening_hours_from_date.setMinutes(0);

                                        self.currentRecord.m_opening_hours_to_date = new Date();
                                        self.currentRecord.m_opening_hours_to_date.setHours(0);
                                        self.currentRecord.m_opening_hours_to_date.setMinutes(0);

                                        self.currentRecord.a_opening_hours_from_date = new Date();
                                        self.currentRecord.a_opening_hours_from_date.setHours(0);
                                        self.currentRecord.a_opening_hours_from_date.setMinutes(0);

                                        self.currentRecord.a_opening_hours_to_date = new Date();
                                        self.currentRecord.a_opening_hours_to_date.setHours(0);
                                        self.currentRecord.a_opening_hours_to_date.setMinutes(0);



                                        /* initializing working time variables -- end */

                                        /**
                                         * initializing capabilities --begin
                                         */

                                        self.currentRecord.favorite_enable = true;
                                        self.currentRecord.like_enable = true;

                                        /* initializing capabilities --end  */


                                        /**
                                         * initializing verify active --begin
                                         */

                                        self.currentRecord.verify = false;
                                        self.currentRecord.active = false;

                                        /* initializing verify active --end  */

                                        /**
                                         * initializing access class --begin
                                         */

                                        self.currentRecord.access_class = 1;

                                        /* initializing access class --end  */


                                        editing = true;
                                        ValuesService.getRandUploadKey(true);
                                    } else {
                                        alert('شماره وارد شده تکراری میباشد')
                                    }
                                },
                                function(responseErr){
                                    alert("شماره وارد شده تکراری است و یا توسط کاربر دیگری قفل شده است.")
                                }
                            );

                        } else {
                            alert('شماره وارد شده معتبر نمیباشد. لطفا دوباره امتحان کنید.');
                        }

                    }
                },function(responseErr){
                    alert("خطا")
                    console.log(responseErr);
                }
            );



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
            temporaryRecord = angular.copy(self.currentRecord);
            editing = true;
        }

        self.cancelEditing = function() {
            self.currentRecord = angular.copy(temporaryRecord);
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
            temporaryRecord = {}
            editing = false;
        }

        self.selectRecord = function(record) {
            selectedRecord = record;
            $http.get('ajax/get_record/'+record.id).then(
                function(response) {
                    self.currentRecord = response.data;
                    if(self.currentRecord.working_days){
                        self.currentRecord.decoded_working_days= function(){
                            $decoded = {};
                            for( i = 0; i<self.currentRecord.working_days.length; i++ ) {
                                $decoded[self.currentRecord.working_days.charAt(i)] = true;
                            }
                            return $decoded;
                        }();
                    }

                    if(self.currentRecord.m_opening_hours_from) {
                        var res = self.currentRecord.m_opening_hours_from.split(":");
                        self.currentRecord.m_opening_hours_from_date = new Date();
                        self.currentRecord.m_opening_hours_from_date.setHours(res[0]);
                        self.currentRecord.m_opening_hours_from_date.setMinutes(res[1]);
                    } else {
                        self.currentRecord.m_opening_hours_from_date = new Date();
                        self.currentRecord.m_opening_hours_from_date.setHours(0);
                        self.currentRecord.m_opening_hours_from_date.setMinutes(0);
                    }
                    if(self.currentRecord.m_opening_hours_to) {
                        var res = self.currentRecord.m_opening_hours_to.split(":");
                        self.currentRecord.m_opening_hours_to_date = new Date();
                        self.currentRecord.m_opening_hours_to_date.setHours(res[0]);
                        self.currentRecord.m_opening_hours_to_date.setMinutes(res[1]);
                    } else {
                        self.currentRecord.m_opening_hours_to_date = new Date();
                        self.currentRecord.m_opening_hours_to_date.setHours(0);
                        self.currentRecord.m_opening_hours_to_date.setMinutes(0);
                    }


                    if(self.currentRecord.a_opening_hours_from) {
                        var res = self.currentRecord.a_opening_hours_from.split(":");
                        self.currentRecord.a_opening_hours_from_date = new Date();
                        self.currentRecord.a_opening_hours_from_date.setHours(res[0]);
                        self.currentRecord.a_opening_hours_from_date.setMinutes(res[1]);
                    } else {
                        self.currentRecord.a_opening_hours_from_date = new Date();
                        self.currentRecord.a_opening_hours_from_date.setHours(0);
                        self.currentRecord.a_opening_hours_from_date.setMinutes(0);
                    }
                    if(self.currentRecord.a_opening_hours_to) {
                        var res = self.currentRecord.a_opening_hours_to.split(":");
                        self.currentRecord.a_opening_hours_to_date = new Date();
                        self.currentRecord.a_opening_hours_to_date.setHours(res[0]);
                        self.currentRecord.a_opening_hours_to_date.setMinutes(res[1]);
                    } else {
                        self.currentRecord.a_opening_hours_to_date = new Date();
                        self.currentRecord.a_opening_hours_to_date.setHours(0);
                        self.currentRecord.a_opening_hours_to_date.setMinutes(0);
                    }
                    
                    

                    self.currentRecord.treeList = Collection.getInstance();
                    self.currentRecord.treeList.addAll(self.currentRecord.trees);

                    self.currentRecord.imagesList = Collection.getInstance();
                    self.currentRecord.imagesList.addAll(self.currentRecord.images);

                    self.currentRecord.videosList = Collection.getInstance();
                    self.currentRecord.videosList.addAll(self.currentRecord.videos);
                    self.currentRecord.videoPlaylist = [];
                    angular.forEach(self.currentRecord.videos, function(value, key){
                        var playlistItem = {};
                        playlistItem.src = value.absolute_path;
                        playlistItem.type = value.filemime;
                        self.currentRecord.videoPlaylist.push(playlistItem);
                    });


                    self.currentRecord.audiosList = Collection.getInstance();
                    self.currentRecord.audiosList.addAll(self.currentRecord.audios);
                    self.currentRecord.audioPlaylist = [];
                    angular.forEach(self.currentRecord.audios, function(value, key){
                        var playlistItem = {};
                        playlistItem.src = value.absolute_path;
                        playlistItem.type = value.filemime;
                        self.currentRecord.audioPlaylist.push(playlistItem);
                    });


                    self.currentRecord.bodyImagesList = Collection.getInstance();
                    self.currentRecord.bodyImagesList.addAll(self.currentRecord.body_images);

                    self.currentRecord.bodyVideosList = Collection.getInstance();
                    self.currentRecord.bodyVideosList.addAll(self.currentRecord.body_videos);

                    self.currentRecord.bodyAudiosList = Collection.getInstance();
                    self.currentRecord.bodyAudiosList.addAll(self.currentRecord.body_audios);
                    
                    self.currentRecord.bodyDocsList = Collection.getInstance();
                    self.currentRecord.bodyDocsList.addAll(self.currentRecord.body_docs);
                },
                function(errResponse) {
                }
            );

        };

        self.addToImagesList = function(obj) {
            self.currentRecord.imagesList.add(obj);
            self.currentRecord.images = self.currentRecord.imagesList.all();
        }

        self.addToBodyImagesList = function(obj) {
            self.currentRecord.bodyImagesList.add(obj);
            self.currentRecord.body_images = self.currentRecord.bodyImagesList.all();
        }

        self.addToVideosList = function(obj) {
            self.currentRecord.videosList.add(obj);
            self.currentRecord.videos = self.currentRecord.videosList.all();
            playlistItem = {};
            playlistItem.src = obj.absolute_path;
            playlistItem.type = obj.filemime;
            self.currentRecord.videoPlaylist.push(playlistItem);
        }

        self.addToBodyVideosList = function(obj) {
            self.currentRecord.bodyVideosList.add(obj);
            self.currentRecord.body_videos = self.currentRecord.bodyVideosList.all();
        }

        self.addToAudiosList = function(obj) {
            self.currentRecord.audiosList.add(obj);
            self.currentRecord.audios = self.currentRecord.audiosList.all();
            playlistItem = {};
            playlistItem.src = obj.absolute_path;
            playlistItem.type = obj.filemime;
            self.currentRecord.audioPlaylist.push(playlistItem);
        }

        self.addToBodyAudiosList = function(obj) {
            self.currentRecord.bodyAudiosList.add(obj);
            self.currentRecord.body_audios = self.currentRecord.bodyAudiosList.all();
        }
        
        self.addToBodyDocsList = function(obj) {
            self.currentRecord.bodyDocsList.add(obj);
            self.currentRecord.body_docs = self.currentRecord.bodyDocsList.all();
        }

        self.removeFromAttachList = function() {
            switch(ValuesService.activeTab) {
                case 'image':
                    angular.forEach(self.selectedImages, function(value, key){
                        self.currentRecord.imagesList.remove(value);
                    });
                    self.currentRecord.images = self.currentRecord.imagesList.all();
                    break;
                case 'icon':
                    
                    self.currentRecord.icon = {};
                    break;
                case 'video':
                    angular.forEach(self.selectedVideos, function(value, key){
                        self.currentRecord.videosList.remove(value);
                    });
                    self.currentRecord.videos = self.currentRecord.videosList.all();
                    break;
                case 'audio':
                    angular.forEach(self.selectedAudios, function(value, key){
                        self.currentRecord.audiosList.remove(value);
                    });
                    self.currentRecord.audios = self.currentRecord.audiosList.all();
                    break;

            }

        }
        
        self.cleanBodyAttachments = function() {
            bodyDom = angular.element(self.currentRecord.body);
            angular.forEach(self.currentRecord.bodyImagesList.array, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentRecord.bodyImagesList.remove(value);
                }
            });
            self.currentRecord.body_images = self.currentRecord.bodyImagesList.all();
            
            angular.forEach(self.currentRecord.bodyVideosList.array, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentRecord.bodyVideosList.remove(value);
                }
            });
            self.currentRecord.body_videos = self.currentRecord.bodyVideosList.all();
            
            angular.forEach(self.currentRecord.bodyAudiosList.array, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentRecord.bodyAudiosList.remove(value);
                }
            });
            self.currentRecord.body_audios = self.currentRecord.bodyAudiosList.all();
            
            angular.forEach(self.currentRecord.bodyDocsList.array, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentRecord.bodyDocsList.remove(value);
                }
            });
            self.currentRecord.body_docs = self.currentRecord.bodyDocsList.all();
            
        }

        self.removeFromBodyAttachList = function() {
            switch(ValuesService.bodyAttachmentActiveTab) {
                case 'image':
                    angular.forEach(self.selectedBodyImages, function(value, key){
                        
                        bodyDom = angular.element(self.currentRecord.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentRecord.bodyImagesList.remove(value);
                        }
                        
                    });
                    self.currentRecord.body_images = self.currentRecord.bodyImagesList.all();
                    break;
                case 'video':
                    angular.forEach(self.selectedBodyVideos, function(value, key){
                        bodyDom = angular.element(self.currentRecord.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentRecord.bodyVideosList.remove(value);
                        }
                        
                    });
                    self.currentRecord.body_videos = self.currentRecord.bodyVideosList.all();
                    break;
                case 'audio':
                    angular.forEach(self.selectedBodyAudios, function(value, key){
                        bodyDom = angular.element(self.currentRecord.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentRecord.bodyAudiosList.remove(value);
                        }
                        
                    });
                    self.currentRecord.body_audios = self.currentRecord.bodyAudiosList.all();
                    break;
                
                case 'doc':
                    angular.forEach(self.selectedBodyDocs, function(value, key){
                        bodyDom = angular.element(self.currentRecord.body);
                        filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                        if(filesInEditor.length > 0) {
                            alert("امکان حذف فایل "+"\n"+value.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
                        }else {
                            self.currentRecord.bodyDocsList.remove(value);
                        }
                        
                    });
                    self.currentRecord.body_docs = self.currentRecord.bodyDocsList.all();
                    break;

            }

        }







        self.addToTreeList = function(obj)  {
            self.currentRecord.treeList.add(obj);
            self.currentRecord.trees = self.currentRecord.treeList.all() ;
        }

        self.removeFromTreeList = function(selectedTrees)  {
            selectedTrees.forEach(function(tree, index, selectedTrees){
                self.currentRecord.treeList.remove(tree);
            });

            self.currentRecord.trees = self.currentRecord.treeList.all() ;
        }

        self.updateCurrentRecord = function() {
            self.currentRecord._csrf_token = ValuesService.csrf;
            return $http({
                method: 'PUT',
                url: 'ajax/'+self.currentRecord.id+'/update',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({data: angular.toJson(self.currentRecord)})
            });
        }

        self.saveCurrentNewRecord = function() {
            self.currentRecord._csrf_token = ValuesService.csrf;
            self.currentRecord.uploadKey = ValuesService.getRandUploadKey();
            return $http({
                method: 'POST',
                url: 'ajax/create',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({data: angular.toJson(self.currentRecord)})
            });
        }

        self.isNew = function() {
            if(self.currentRecord.id) {
                return false;
            } else {
                return true;
            }
        }



        self.saveCurrentRecord = function(contin) {
            contin = (contin)? true : false;
            self.savingMessages = {}
            self.saved = false;
            if(!contin){
                self.cleanBodyAttachments();
            }
            if(self.isNew()) {

                self.saveCurrentNewRecord().then(
                    function(response){
                        self.currentRecord = {}
                        self.currentRecord = response.data[0];


                        self.saved = true;
                        self.savingMessages = ['رکورد مورد نظر ذخیره شد.'];
                        if(!contin) {
                            self.searchRecords();
                            self.finishEditing();
                        } else {
                            temporaryRecord = angular.copy(self.currentRecord);
                        }
                    },
                    function(errResponse){
                        self.saved = true;
                        self.savingMessages = errResponse.data;
                    }
                );
            } else {
                self.updateCurrentRecord().then(
                    function(response){
                        self.currentReocrd = response;
                        self.saved = true;
                        self.savingMessages = ['رکورد مورد نظر ذخیره شد.'];
                        if(!contin) {
                            self.searchRecords();
                            self.finishEditing();
                        }else {
                            temporaryRecord = angular.copy(self.currentRecord);
                        }
                    },
                    function(errResponse){
                        self.saved = true;
                        self.savingMessages = errResponse.data;
                    }
                );
            }
        }
        
        

        self.changeWorkingDays = function() {

            self.currentRecord.working_days = function() {
                $encoded = "";
                for(i=1 ; i<=8 ; i++) {
                    if(self.currentRecord.decoded_working_days[i]){
                        $encoded = $encoded + i.toString();
                    }
                }
                return $encoded;
            }();
        };

        self.isSelected = function(record) {
            if(record.id == selectedRecord.id) {
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

    controller('treeModalCtrl', ['$scope', 'RecordService','TreeService', '$modalInstance', function ($scope, RecordService, TreeService, $modalInstance) {
        $scope.RecordService = RecordService;
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
    controller('bodyTreeModalCtrl', ['$scope', 'RecordService','TreeService', '$modalInstance', function ($scope, RecordService, TreeService, $modalInstance) {
        $scope.RecordService = RecordService;
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
    controller('bodyRecordModalCtrl', ['$scope', 'RecordService','TreeService', '$modalInstance', function ($scope, RecordService, TreeService, $modalInstance) {
        $scope.RecordService = RecordService;
        $scope.TreeService = TreeService;
        $scope.text = "";
        $scope.recordId = "";
        
        $scope.close = function () {
            $modalInstance.close();
        };

        var CkInstance = null;
        angular.forEach(CKEDITOR.instances,function(value, key){CkInstance = value; keepGoing = false;})
        
        $scope.insertRecord = function() {
            
            console.log($scope.currentBodyTreeNode);
            CkInstance.insertHtml('<a href="#" class="body inner-link " record-id="'+$scope.recordId+'">'+$scope.text+'</a>');
            $scope.close();
        }
    }]).
    controller('insertLinkModalCtrl', ['$scope', 'RecordService','TreeService', '$modalInstance', function ($scope, RecordService, TreeService, $modalInstance) {
        $scope.RecordService = RecordService;
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
    controller('savingModalCtrl', ['$scope', 'RecordService','TreeService', '$modalInstance', function ($scope, RecordService, TreeService, $modalInstance) {
        $scope.RecordService = RecordService;
        $scope.close = function(){$modalInstance.backdrop = true; $modalInstance.close();}

    }]).
    controller('titlesModalCtrl', ['$scope', '$modalInstance', 'RecordService','TreeService', function ($scope, $modalInstance, RecordService, TreeService) {
        $scope.RecordService = RecordService;
        $scope.close = function(){$modalInstance.close();}
        
    }]).
    controller('mapModalCtrl', ['$scope', 'mapModal', 'RecordService','TreeService', 'uiGmapGoogleMapApi', function ($scope, mapModal, RecordService, TreeService, GoogleMapApi) {
        $scope.RecordService = RecordService;
        $scope.closeMe = function(){ 
            mapModal.deactivate();
        }
        
        $scope.apply = function() {
            RecordService.currentRecord.latitude = $scope.map.marker.coords.latitude;
            RecordService.currentRecord.longitude = $scope.map.marker.coords.longitude;
            mapModal.deactivate();
        }
        /**
         * Google map initialization
         */
        GoogleMapApi.then(function (maps)
        {
            $scope.map = {center: {latitude: 26.53570851865494, longitude: 53.97153854370117}, zoom: 12};
            $scope.map.events = {
                click: function (var1, var2, var3, var4) {
                    console.info('latitude', var3[0].latLng.lat());
                    console.info('longitude', var3[0].latLng.lng());
                    $scope.map.marker.coords.latitude = var3[0].latLng.lat();
                    
                    $scope.map.marker.coords.longitude = var3[0].latLng.lng();
                    
                    
                    $scope.$apply();



                }
            };
            $scope.map.marker = {
                id: 0,
                coords: {
                    latitude: RecordService.currentRecord.latitude,
                    longitude: RecordService.currentRecord.longitude
                },
                options: {draggable: true},
            };
        });
        ///////////////
    }]).
    controller('deleteModalCtrl', ['$scope', '$modalInstance', 'RecordService','TreeService', function ($scope, $modalInstance, RecordService, TreeService) {
        $scope.RecordService = RecordService;
        $scope.close = function(){$modalInstance.close();}
        $scope.deleteCurrentRecord = function() {
            console.log(RecordService.deleteCurrentRecord($modalInstance));
        }
    }]).
    controller('continualModalCtrl', ['$scope', '$http', '$modalInstance', 'RecordService','TreeService', function ($scope, $http, $modalInstance, RecordService, TreeService) {
        $scope.RecordService = RecordService;
        $scope.images = angular.copy(RecordService.currentRecord.imagesList.all());
        $scope.audios = angular.copy(RecordService.currentRecord.audiosList.all());
        $scope.videos = angular.copy(RecordService.currentRecord.videosList.all());
        
        $scope.bodyImages = angular.copy(RecordService.currentRecord.bodyImagesList.all());
        $scope.bodyAudios = angular.copy(RecordService.currentRecord.bodyAudiosList.all());
        $scope.bodyDocs = angular.copy(RecordService.currentRecord.bodyDocsList.all());
        $scope.bodyVideos = angular.copy(RecordService.currentRecord.bodyVideosList.all());
        $scope.close = function(){$modalInstance.close();}
        $scope.save = function() {
            RecordService.currentRecord.imagesList.removeAll();
            RecordService.currentRecord.imagesList.addAll($scope.images);
            RecordService.currentRecord.images = RecordService.currentRecord.imagesList.all();

            RecordService.currentRecord.audiosList.removeAll();
            RecordService.currentRecord.audiosList.addAll($scope.audios);
            RecordService.currentRecord.audios = RecordService.currentRecord.audiosList.all();

            RecordService.currentRecord.videosList.removeAll();
            RecordService.currentRecord.videosList.addAll($scope.videos);
            RecordService.currentRecord.videos = RecordService.currentRecord.videosList.all();

            RecordService.currentRecord.bodyImagesList.removeAll();
            RecordService.currentRecord.bodyImagesList.addAll($scope.bodyImages);
            RecordService.currentRecord.body_images = RecordService.currentRecord.bodyImagesList.all();

            RecordService.currentRecord.bodyAudiosList.removeAll();
            RecordService.currentRecord.bodyAudiosList.addAll($scope.bodyAudios);
            RecordService.currentRecord.body_audios = RecordService.currentRecord.bodyAudiosList.all();
            
            RecordService.currentRecord.bodyDocsList.removeAll();
            RecordService.currentRecord.bodyDocsList.addAll($scope.bodyDocs);
            RecordService.currentRecord.body_docs = RecordService.currentRecord.bodyDocsList.all();

            RecordService.currentRecord.bodyVideosList.removeAll();
            RecordService.currentRecord.bodyVideosList.addAll($scope.bodyVideos);
            RecordService.currentRecord.body_videos = RecordService.currentRecord.bodyVideosList.all();
            
            $modalInstance.close();
        }
        
    }]).
        
    controller('imageModalCtrl', ['$scope', '$modalInstance', 'RecordService','TreeService', 'ValuesService', function ($scope, $modalInstance, RecordService, TreeService, ValuesService) {
        $scope.RecordService = RecordService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentImageModal = {}; $modalInstance.close();}
        $scope.currentImage = RecordService.currentRecord.images[ValuesService.currentImageModal.index];
        $scope.totalImage = RecordService.currentRecord.images.length;
        $scope.currentIndex = ValuesService.currentImageModal.index + 1;
        $scope.next = function() {
            ValuesService.currentImageModal.index = ValuesService.currentImageModal.index + 1;
            $scope.currentImage = RecordService.currentRecord.images[ValuesService.currentImageModal.index];
            $scope.currentIndex = ValuesService.currentImageModal.index + 1;
        }
        $scope.prev = function() {
            ValuesService.currentImageModal.index = ValuesService.currentImageModal.index -1;
            $scope.currentImage = RecordService.currentRecord.images[ValuesService.currentImageModal.index];
            $scope.currentIndex = ValuesService.currentImageModal.index + 1;
        }



    }]).
    controller('videoModalCtrl', ['$scope', '$sce', '$modalInstance', 'RecordService','TreeService', 'ValuesService', function ($scope, $sce, $modalInstance, RecordService, TreeService, ValuesService) {
        $scope.RecordService = RecordService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentVideoModal = {}; $modalInstance.close();}
        $scope.currentVideo = RecordService.currentRecord.videos[ValuesService.currentVideoModal.index];
        $scope.totalVideo = RecordService.currentRecord.videos.length;
        $scope.currentIndex = ValuesService.currentVideoModal.index + 1;
        $scope.next = function() {
            ValuesService.currentVideoModal.index = ValuesService.currentVideoModal.index + 1;
            $scope.currentVideo = RecordService.currentRecord.videos[ValuesService.currentVideoModal.index];
            $scope.currentIndex = ValuesService.currentVideoModal.index + 1;
            var videoPlayer = document.getElementById('modal-video-player');
            videoPlayer.src = $scope.currentVideo.absolute_path;
            videoPlayer.load();
            videoPlayer.play();
        }
        $scope.prev = function() {
            ValuesService.currentVideoModal.index = ValuesService.currentVideoModal.index -1;
            $scope.currentVideo = RecordService.currentRecord.videos[ValuesService.currentVideoModal.index];
            $scope.currentIndex = ValuesService.currentVideoModal.index + 1;
            var videoPlayer = document.getElementById('modal-video-player');
            videoPlayer.src = $scope.currentVideo.absolute_path;
            videoPlayer.load();
            videoPlayer.play();
        }

    }]).
    controller('cancelModalCtrl', ['$scope', '$modalInstance', 'RecordService','TreeService', function ($scope, $modalInstance, RecordService, TreeService) {
        $scope.RecordService = RecordService;
        $scope.close = function(){$modalInstance.close(false);}
        $scope.cancel = function() {
            RecordService.cancelEditing(); 
            $modalInstance.close(true);
        }
    }]).
    controller('bodyModalCtrl', ['$scope', '$http', 'RecordService','TreeService', 'ValuesService', 'FileUploader', '$modalInstance', '$modal', 
        function (                $scope,   $http,   RecordService,  TreeService,   ValuesService, FileUploader, $modalInstance, $modal) {
        $scope.RecordService = RecordService;
        $scope.TreeService = TreeService;
        $scope.ValuesService = ValuesService;
        $scope.bodyEditorOptions = {
            language: 'fa',
            height: '500px',
            uiColor: '#e8ede0',
            extraPlugins: "dragresize,video,templates,dialog,colorbutton,lineheight,halfhr,record",
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
                { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Halfhr', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'Video', 'Record' ] },
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
         * Body Record modal initializing
         */
        
        
        $scope.openBodyRecordModal = function (size) {

            var bodyRecordModalInstance = $modal.open({
                templateUrl: 'bodyRecordModal.html',
                controller: 'bodyRecordModalCtrl',
                size: size,
                resolve: {
                    
                }
            });

            bodyRecordModalInstance.result.then(
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
        uploader.formData.push({type : 'record'});
        
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
        };
        uploader.onCancelItem = function(fileItem, response, status, headers) {
            console.info('onCancelItem', fileItem, response, status, headers);
        };
        uploader.onCompleteItem = function(fileItem, response, status, headers) {
            console.info('onCompleteItem', fileItem, response, status, headers);
            switch(response.upload_dir) {
                case 'image':
                    RecordService.addToBodyImagesList(response);
                    break;
                case 'video':
                    RecordService.addToBodyVideosList(response);
                    break;
                case 'audio':
                    RecordService.addToBodyAudiosList(response);
                    break;
                case 'doc':
                    RecordService.addToBodyDocsList(response);
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
                    var fileClass = RecordService.selectedBodyImage.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;"><img class="'+fileClass+'"  alt="" style="width:200px;" src="'+RecordService.selectedBodyImage.absolute_path+'" /></p>');
                    break;
                case 'video':
                    var fileClass = RecordService.selectedBodyVideo.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'"  style="text-align:center;" ><video class="'+fileClass+'"  controls="" name="media" width="300"><source src="'+RecordService.selectedBodyVideo.absolute_path+'" type="'+RecordService.selectedBodyVideo.filemime+'"></video></p>');
                    break;
                case 'audio':
                    var fileClass = RecordService.selectedBodyAudio.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;" ><audio class="'+fileClass+'"  controls="" name="media" width="300"><source src="'+RecordService.selectedBodyAudio.absolute_path+'" type="'+RecordService.selectedBodyAudio.filemime+'"></audio></p>');
                    break;
                    
                case 'doc':
                    var text = prompt("لطفا متن مربوط به لینک دانلود فایل را وارد نمایید. در غیر این صورت نام فایل به عنوان متن در نظر گرفته می شود.");
                    text = (text)?text:RecordService.selectedBodyDoc.file_name;
                    var fileClass = RecordService.selectedBodyDoc.file_name.replace(".", "-");
                    CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;" ><a class="body web-link '+fileClass+'" href="'+RecordService.selectedBodyDoc.absolute_path+'"  > '+text+'  </a></p>');
                    break;

            }


        };

        

        $scope.close = function(){$modalInstance.close();}


    }]).
    factory('ValuesService', ['$http', function ($http){ 
        var centers;

        var safarSazTypes;

        var dbaseTypes;

        var areas;

        var csrf;


        var self = {
            centers: null
        };

        if(!centers) {
            $http.get('ajax/get_centers').then(
                function(response) {
                    self.centers = response.data;

                },
                function(errResponse) {

                }
            );
        }

        if(!csrf) {
            $http.get('ajax/generate_csrf').then(
                function(response) {
                    self.csrf = response.data;


                },
                function(errResponse) {
                }
            );
        }

        if(!safarSazTypes) {
            $http.get('ajax/get_safarsaz_types').then(
                function(response) {
                    self.safarsazTypes = response.data;

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

        if(!dbaseTypes) {

            $http.get('ajax/get_dbase_types').then(
                function(response) {
                    self.dbaseTypes = response.data;

                },
                function(errResponse) {
                }
            );



        }

        if(!areas) {

            $http.get('ajax/get_areas').then(
                function(response) {
                    self.areas = response.data;

                },
                function(errResponse) {
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


        self.safarsazRanks = [];
        for(var i = 1; i<=10; i++) {
            self.safarsazRanks.push({
                id: i,
                name: i
            })
        }



        self.accessClasses = [
            {
                value: 1,
                label: "سطح اول"
            },
            {
                value: 2,
                label: "سطح دوم"
            },
            {
                value: 3,
                label: "سطح سوم"
            },
            {
                value: 4,
                label: "سطح چهارم"
            }
        ];

        return self;

    }]);
