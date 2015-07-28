//var recordIndexCtrl = angular.module('RecordIndexCtrl', ['recordtreeControl', 'angularFileUpload']);
//var recordIndexCtrl = recordApp.module('RecordIndexCtrl', ['recordtreeControl', 'angularFileUpload']);


    // inject the Comment service into our controller
//    recordIndexCtrl.controller('RecordIndexController', ['$modal','$scope','$http', '$upload', '$interval', 'RecordTree','RecordControl',
//        function($modal, $scope, $http, $upload, $interval, NewsTree, NewsControl) {
//            $scope.test = "this is test";
//        }]);

angular.module('RecordApp', ['treeControl', 'ui.grid', 'smart-table', 'btford.modal', 'ngCollection', 'ngSanitize', 'ngCkeditor', 'ui.bootstrap', 'ui.bootstrap.persian.datepicker', 'checklist-model',
                            ,'mediaPlayer', 'infinite-scroll','angularFileUpload', 'uiGmapgoogle-maps', 'duScroll', 'angucomplete-alt'
    ])
    .config(['uiGmapGoogleMapApiProvider', function (GoogleMapApi) {
        GoogleMapApi.configure({
      //    key: 'your api key',
          v: '3.17',
          libraries: 'weather,geometry,visualization'
        });
    }]).filter('range', function() {
      return function(input, min, max) {
        min = parseInt(min); //Make string input int
        max = parseInt(max);
        for (var i=min; i<=max; i++)
          input.push(i);
        return input;
      };
    }).controller('RecordIndexCtrl', ['$scope', '$http', '$location', '$filter', '$sce', 'TreeService', 'RecordService', 'ValuesService', '$interval', 'poollingFactory',
                                     'mapModal','FileUploader', '$modal', 'SecurityService',
    function($scope, $http, $location,  $filter, $sce,   TreeService,   RecordService,   ValuesService, $interval, poollingFactory, mapModal,FileUploader, $modal, SecurityService) {


        /**
         * initializing config for list endless scroll
         */
        gb = document.getElementsByClassName('grid-block')[0];
        tbl = gb.getElementsByTagName('table')[0];


        gridblock = angular.element(gb);
        table = angular.element(tbl);

        gridblock.on('scroll', function() {
          if(gridblock.scrollTop() + gridblock.height() >= table.height()) {
              RecordService.searchRecords(RecordService.recordList().length);
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


        /**
         * Tree modal initializing
         */


        $scope.openTicketTreeModal = function (size) {

            var ticketTreeModalInstance = $modal.open({
                templateUrl: 'ticketTreeModal.html',
                controller: 'ticketTreeModalCtrl',
                size: size,
                resolve: {

                }
            });

            ticketTreeModalInstance.result.then(
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
         * Body modal initialization
         */



        $scope.openRegisterCodeModal = function (size) {
            var registerCodeModalInstance = $modal.open({
                templateUrl: 'registerCodeModal.html',
                controller: 'registerCodeModalCtrl',
                size: size,
                windowClass: ''
            });

            registerCodeModalInstance.result.then(
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
         *  RecordService Initializing
         */
        $scope.RecordService = RecordService;
        $scope.SecurityService = SecurityService;
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
        // $scope.disabled = function(date, mode) {
        //     return ( mode === 'day' &&date.getDay() === 5  );
        // };

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
                    window.location = "../record";
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
                        RecordService.saveCurrentRecord(contin);
                        $scope.recordform.$setPristine();

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

        /////////////////////////////





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

        self.generateRgisterCodeSingle = function() {
            $http({
                method: 'POST',
                url: '../recordregister/single/'+self.currentRecord.id+'/1',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
            }).then(
                function(response){
                    if(response.data.id) {
                        var encodedData = window.btoa(unescape(encodeURIComponent(JSON.stringify([response.data.id]))));
                        window.open('../recordregister/download/'+encodedData+'/code/1');
                    } else {
                        alert('برای  رکورده فعلی کد ثبت نام تولید نشد');
                    }
                },
                function(responseErr){
                }
            );
        }

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
            $http.get('ajax/get_total_record_for_cat/'+cid).then(function(response){
                self.totalRecord = response.data;
            },function(errResponse){
            });

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
            $http.get('ajax/total_search_record/'+
                self.recordSearchCriteria.searchBy+'/'+
                self.recordSearchCriteria.sortBy+'/'+
                self.recordSearchCriteria.searchKeyword
                ).then(function(response){
                self.totalRecord = response.data;
            },function(errResponse){
            });

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


                                        self.currentRecord.commentable = true;
                                        self.currentRecord.comment_default_state = 3;

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
                    if(self.currentRecord.access_class) {
                        self.currentRecord.access_class = self.currentRecord.access_class.id;
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
                    self.currentRecord.treeList.addAll(self.currentRecord.maintrees);

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

                    console.log(self.currentRecord);
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
            angular.forEach(self.currentRecord.bodyImagesList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentRecord.bodyImagesList.remove(value);
                }
            });
            self.currentRecord.body_images = self.currentRecord.bodyImagesList.all();

            angular.forEach(self.currentRecord.bodyVideosList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentRecord.bodyVideosList.remove(value);
                }
            });
            self.currentRecord.body_videos = self.currentRecord.bodyVideosList.all();

            angular.forEach(self.currentRecord.bodyAudiosList.hash, function(value, key){
                filesInEditor = bodyDom.find("."+value.file_name.replace('.','-'));
                if(filesInEditor.length == 0) {
                    self.currentRecord.bodyAudiosList.remove(value);
                }
            });
            self.currentRecord.body_audios = self.currentRecord.bodyAudiosList.all();

            angular.forEach(self.currentRecord.bodyDocsList.hash, function(value, key){
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







        self.addToTreeList = function(obj, sort, group_filter)  {
            angular.forEach(self.currentRecord.treeList.array, function(value, key){
                if(obj.id == value.tree.id) {
                    self.currentRecord.treeList.remove(value);
                }
            });
            obj.sort = sort;
            obj.group_filter = group_filter;
            var tree = {};
            tree.tree = obj;
            tree.sort = (sort)?sort:60;
            tree.group_filter = (group_filter)?group_filter.id:0;
            self.currentRecord.treeList.update(tree);
            self.currentRecord.maintrees = self.currentRecord.treeList.all() ;
            return obj.title+" به رکورد اضافه شد.";
        }

        self.removeFromTreeList = function(selectedTrees)  {
            selectedTrees.forEach(function(tree, index, selectedTrees){
                self.currentRecord.treeList.remove(tree);
            });

            self.currentRecord.maintrees = self.currentRecord.treeList.all() ;
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
//                        self.currentRecord = {}
//                        self.currentRecord = response.data[0];
                        self.currentRecord.id = response.data[0].id;
                        self.selectRecord(self.currentRecord);

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
                        self.savingMessageIsArray = (angular.isArray(self.savingMessages))? true:false;
                        console.log(errResponse);
                    }
                );
            } else {
                self.updateCurrentRecord().then(
                    function(response){
//                        self.currentReocrd = response;
                        self.saved = true;
                        self.savingMessages = ['رکورد مورد نظر ذخیره شد.'];
                        if(!contin) {
                            // self.searchRecords();
                            self.finishEditing();
                        }else {
                            temporaryRecord = angular.copy(self.currentRecord);
                        }
                        var recordInList = $filter('filter')(self.list.array, {id: response.data.id}, true)[0];
                        recordInList.title = response.data.title;
                        recordInList.sub_title = response.data.sub_title;
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

    controller('treeModalCtrl', ['$scope', 'RecordService','TreeService', 'ValuesService', '$modalInstance', '$http', function ($scope, RecordService, TreeService, ValuesService, $modalInstance, $http) {
        $scope.RecordService = RecordService;
        $scope.TreeService = TreeService;
        $scope.ValuesService = ValuesService;
        $scope.tree = function() {
            return $scope.TreeService.tree();
        }

        $scope.treeOptions = function() {

            return $scope.TreeService.treeOptions();
        }
        $scope.tOptions = angular.copy($scope.TreeService.treeOptions());
        $scope.tOptions.dirSelectable = false;

        $scope.groupFilters = []

        $scope.selectTree = function(node) {
            $http.get('ajax/get_group_filter/'+node.tree_index).then(
                function(response){
                    if(response.data.length) {
                        $scope.group_filter = null;
                        $scope.groupFilters = response.data;
                    } else {
                        $scope.group_filter = {id: 0, filter_name: 'بدون فیلتر'};
                        $scope.groupFilters = [$scope.group_filter];
                    }
                    console.log($scope.groupFilters);
                },
                function(responseErr) {
                    $scope.group_filter = {id: 0, filter_name: 'بدون فیلتر'};
                    $scope.groupFilters = [$scope.group_filter];

                }
            )
            
        }

        $scope.showCurrentFulter = function() {
            console.log($scope.group_filter);
        }

        $scope.close = function () {
            $modalInstance.close();
        };

        $scope.addTerm = function(term) {

        }
    }]).

    controller('ticketTreeModalCtrl', ['$scope', '$http', 'RecordService','TreeService', 'ValuesService', '$modalInstance', function ($scope, $http, RecordService, TreeService, ValuesService, $modalInstance) {
        $scope.RecordService = RecordService;
        $scope.TreeService = TreeService;
        $scope.ValuesService = ValuesService;
        var tree=[];

        $http.get('ajax/gettickettree').then(function(response) {
            tree = response.data;
        }, function(errResponse) {
            console.error('Error while fetching notes');
        });

        $scope.tree = function() {
            return tree;
        }

        $scope.treeOptions = function() {

            return $scope.TreeService.treeOptions();
        }
        $scope.tOptions = angular.copy($scope.TreeService.treeOptions());
        $scope.tOptions.dirSelectable = false;

        $scope.close = function () {
            $modalInstance.close();
        };

        $scope.selectTicketTreeList = function(node) {
            RecordService.currentRecord.ticket_server_tree = node;
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
            CkInstance.insertHtml('<a href="#" class="body inner-link " tree-index="'+$scope.currentBodyTreeNode.tree_index+'">'+$scope.currentBodyTreeNode.title+'</a>');
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

        $scope.insertRecord = function(record) {
            var text = ($scope.text) ? $scope.text : record.originalObject.title;
            console.log($scope.currentBodyTreeNode);
            CkInstance.insertHtml('<a href="#" class="body inner-link " record-id="'+record.originalObject.record_number+'">'+text+'</a>');
            $scope.close();
        }
        $scope.insertNews = function(news) {
            var text = ($scope.text) ? $scope.text : news.originalObject.title;
            console.log($scope.currentBodyTreeNode);
            CkInstance.insertHtml('<a href="#" class="body inner-link " news-id="N'+news.originalObject.id+'">'+text+'</a>');
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
    controller('iconModalCtrl', ['$scope', '$modalInstance', 'RecordService','TreeService', 'ValuesService', function ($scope, $modalInstance, RecordService, TreeService, ValuesService) {
        $scope.RecordService = RecordService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentIconModal = {}; $modalInstance.close();}
        $scope.icon = ValuesService.currentIconModal.image;




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
    controller('audioModalCtrl', ['$scope', '$sce', '$modalInstance', 'RecordService','TreeService', 'ValuesService', function ($scope, $sce, $modalInstance, RecordService, TreeService, ValuesService) {
        $scope.RecordService = RecordService;
        $scope.ValuesService = ValuesService;
        $scope.close = function(){ValuesService.currentAudioModal = {}; $modalInstance.close();}
        $scope.currentAudio = RecordService.currentRecord.audios[ValuesService.currentAudioModal.index];
        $scope.totalAudio = RecordService.currentRecord.audios.length;
        $scope.currentIndex = ValuesService.currentAudioModal.index + 1;
        $scope.next = function() {
            ValuesService.currentAudioModal.index = ValuesService.currentAudioModal.index + 1;
            $scope.currentAudio = RecordService.currentRecord.audios[ValuesService.currentAudioModal.index];
            $scope.currentIndex = ValuesService.currentAudioModal.index + 1;
            var audioPlayer = document.getElementById('modal-audio-player');
            audioPlayer.src = $scope.currentAudio.absolute_path;
            audioPlayer.load();
            audioPlayer.play();
        }
        $scope.prev = function() {
            ValuesService.currentAudioModal.index = ValuesService.currentAudioModal.index -1;
            $scope.currentAudio = RecordService.currentRecord.audios[ValuesService.currentAudioModal.index];
            $scope.currentIndex = ValuesService.currentAudioModal.index + 1;
            var audioPlayer = document.getElementById('modal-audio-player');
            audioPlayer.src = $scope.currentAudio.absolute_path;
            audioPlayer.load();
            audioPlayer.play();
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
    controller('loginModalCtrl', ['$scope', '$http', '$modalInstance', 'RecordService','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, RecordService, ValuesService, SecurityService) {
        $scope.RecordService = RecordService;
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
                                window.location = "../record";
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
    controller('logoutModalCtrl', ['$scope', '$http', '$modalInstance', 'RecordService','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, RecordService, ValuesService, SecurityService) {
        $scope.RecordService = RecordService;

        $scope.cancel = function() {
            $modalInstance.dismiss();
        }
        $scope.logout = function() {
            $modalInstance.close();
        }
    }]).
    controller('disconnectModalCtrl', ['$scope', '$http', '$modalInstance', 'RecordService','ValuesService', 'SecurityService', function ($scope, $http, $modalInstance, RecordService, ValuesService, SecurityService) {
        $scope.RecordService = RecordService;
        $scope.close = function(){$modalInstance.close(false);}

    }]).
    controller('bodyPreviewModalCtrl', ['$scope', '$http', '$sce', '$collection', '$modalInstance', 'RecordService','ValuesService', 'SecurityService', function ($scope, $http, $sce, $collection, $modalInstance, RecordService, ValuesService, SecurityService) {
        $scope.RecordService = RecordService;
        $scope.close = function(){$modalInstance.close(false);}
        $scope.getTrustedBody =  function(untrustedBody) {
            tempBody = (untrustedBody)? untrustedBody : "";
            return $sce.trustAsHtml(tempBody);
        }
        $scope.history = $collection.getInstance();
        $scope.trustedBody = $scope.getTrustedBody(RecordService.currentRecord.body);
        $scope.innerLink = true;
        $scope.externalLink = false;

        $scope.loadRecord = function(recordNumber) {
            $scope.innerLink = true;
            $scope.externalLink = false;
            $http.get('ajax/get_record_by_number/' + recordNumber).then(
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


        $scope.loadNews = function(newsNumber) {
            $scope.innerLink = true;
            $scope.externalLink = false;
            $http.get('../news/ajax/get_news_by_id/' + newsNumber).then(
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
                angular.element(document.querySelectorAll('.body-preview-content a[record-id]')).unbind('click');
                angular.element(document.querySelectorAll('.body-preview-content a[record-id]')).on('click', function (event) {
                    recordNumber = event.toElement.getAttribute('record-id');
                    $scope.loadRecord(recordNumber);
                    $scope.history.add({func: $scope.loadRecord, arg: recordNumber});
                    event.preventDefault();
                });


                angular.element(document.querySelectorAll('.body-preview-content a[news-id]')).unbind('click');
                angular.element(document.querySelectorAll('.body-preview-content a[news-id]')).on('click', function (event) {
                    newsNumber = event.toElement.getAttribute('news-id');
                    newsNumber = newsNumber.substr(1, newsNumber.length - 1);
                    $scope.loadNews(newsNumber);
                    $scope.history.add({func: $scope.loadNews, arg: newsNumber});
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

                $('.body-preview-content img').filter(function(){
                    return $(this).css('border-width') == '0px';

                }).css('border-width', '0').css('width', '90%');



            }, 200);
        }
        $scope.observeEvents();

        $scope.history.add({func: $scope.loadRecord, arg: RecordService.currentRecord.record_number});
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
    controller('bodyModalCtrl', ['$scope', '$http', 'RecordService','TreeService', 'ValuesService', 'SecurityService', 'FileUploader', '$modalInstance', '$modal', 'recordform',
        function (                $scope,   $http,   RecordService,  TreeService,   ValuesService,   SecurityService,   FileUploader, $modalInstance, $modal, recordform) {
        $scope.recordform = recordform;
        $scope.RecordService = RecordService;
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
                        RecordService.saveCurrentRecord(contin);
//                        $scope.recordform.$setPristine();

                    }
                },
                function(errResponse){
                    $scope.openDisconnectModal();
                }
            );

        }


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

    controller('registerCodeModalCtrl', ['$scope', '$http', 'RecordService','TreeService', 'ValuesService', 'SecurityService', 'FileUploader', '$modalInstance', '$modal',
        function (                $scope,   $http,   RecordService,  TreeService,   ValuesService,   SecurityService,   FileUploader, $modalInstance, $modal) {
        $scope.recordform = recordform;
        $scope.RecordService = RecordService;
        $scope.TreeService = TreeService;
        $scope.ValuesService = ValuesService;
        $scope.SecurityService = SecurityService;

        $scope.generateRgisterCodeGroup = function() {
            console.log(RecordService.list.all());
            var recordIds = [];

            angular.forEach(RecordService.list.all(), function(value, key){
                console.log(value);
                recordIds.push(value.id);
            });
            console.log(recordIds);
            $http({
                method: 'POST',
                url: '../recordregister/group',
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param({records: recordIds})
            }).then(
                function(response){
                    var codeIds = [];
                    angular.forEach(response.data, function(value, key){
                        codeIds.push(value.id);
                    });
                    if(codeIds.length > 0) {
                        var encodedData = window.btoa(unescape(encodeURIComponent(JSON.stringify(codeIds))));
                        window.open('../recordregister/download/'+encodedData+'/code/1');
                    } else {
                        alert('برای هیچ کدام از رکوردهای لیست کد ثبت نام تولید نشد');
                    }


                },
                function(responseErr){
                }
            );
        }

        $scope.printRgisterCodeGroup = function() {
            var recordNumbers = [];

            angular.forEach(RecordService.list.all(), function(value, key){
                recordNumbers.push(value.record_number);
            });

            if(recordNumbers.length > 0) {
                var encodedData = window.btoa(unescape(encodeURIComponent(JSON.stringify(recordNumbers))));
                window.open('../recordregister/download/'+encodedData+'/record/0');
            } else {
                alert('رکوردی در لیست موجود نیست')
            }
        }

        $scope.generateRgisterCodeRange = function(from, to) {
            $http({
                method: 'POST',
                url: '../recordregister/range/'+from+'/'+to,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
            }).then(
                function(response){
                    if(response.data.length > 0) {
                        window.open('../recordregister/download/range/'+from+'/'+to+'/1');
                    } else {
                        alert('برای هیچ کدام از رکوردهای لیست کد ثبت نام تولید نشد')
                    }


                },
                function(responseErr){
                }
            );
        }

        $scope.printRgisterCodeRange = function(from, to) {

            window.open('../recordregister/download/range/'+from+'/'+to+'/0');

        }

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

        self.treeRanks = [];
        for(var i = 1; i<=60; i++) {
            self.treeRanks.push({
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

        self.commentDefaultStates = [
            {
                value: 0,
                label: "تایید"
            },
            {
                value: 3,
                label: "در انتظار تایید"
            }
        ];

        return self;

    }]).factory('SecurityService', ['$http', 'RecordService', function($http, RecordService){
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
            if(editAccess[RecordService.currentRecord.id] == 'waiting') {
                return false;
            }

            if(!angular.isDefined(editAccess[RecordService.currentRecord.id])) {
                editAccess[RecordService.currentRecord.id] = 'waiting';

                $http.get('ajax/check_permission/edit/'+RecordService.currentRecord.id).then(
                    function(response){
                        editAccess[RecordService.currentRecord.id] = response.data[0];
                        return editAccess[RecordService.currentRecord.id];
                    },
                    function(errResponse){
                        editAccess[RecordService.currentRecord.id] = null;
                        return false;
                    }
                );
            } else {
                return editAccess[RecordService.currentRecord.id];
            }

        }


        self.actionsAccess.deleteAccess = function() {
            if(deleteAccess[RecordService.currentRecord.id] == 'waiting') {
                return false;
            }

            if(!angular.isDefined(deleteAccess[RecordService.currentRecord.id])) {
                deleteAccess[RecordService.currentRecord.id] = 'waiting';

                $http.get('ajax/check_permission/remove/'+RecordService.currentRecord.id).then(
                    function(response){
                        deleteAccess[RecordService.currentRecord.id] = response.data[0];
                        return deleteAccess[RecordService.currentRecord.id];
                    },
                    function(errResponse){
                        deleteAccess[RecordService.currentRecord.id] = null;
                        return false;
                    }
                );
            } else {
                return deleteAccess[RecordService.currentRecord.id];
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
            if(RecordService.isNew()) {
                return true;
            } else {
                return self.actionsAccess.editAccess();
            }

        }



        self.buttonsAccess.saveAndContinueButtonAccess = function() {
            if(RecordService.isNew()) {
                return true;
            } else {
                return self.actionsAccess.editAccess();
            }

        }

        return self;



    } ]);
