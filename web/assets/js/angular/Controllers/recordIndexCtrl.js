//var recordIndexCtrl = angular.module('RecordIndexCtrl', ['recordtreeControl', 'angularFileUpload']);
//var recordIndexCtrl = recordApp.module('RecordIndexCtrl', ['recordtreeControl', 'angularFileUpload']);


    // inject the Comment service into our controller
//    recordIndexCtrl.controller('RecordIndexController', ['$modal','$scope','$http', '$upload', '$interval', 'RecordTree','RecordControl',
//        function($modal, $scope, $http, $upload, $interval, NewsTree, NewsControl) {
//            $scope.test = "this is test";
//        }]);

angular.module('RecordApp', ['treeControl', 'ui.grid', 'smart-table', 'btford.modal', 'ngCollection', 'ngSanitize', 'ngCkeditor', 'ui.bootstrap', 'ui.bootstrap.persian.datepicker', 'checklist-model',
                            ,'mediaPlayer', 'infinite-scroll'
    ]).
    controller('RecordIndexCtrl', ['$scope', '$filter', '$sce', 'TreeService', 'RecordService', 'treeModal', 'ValuesService', 'savingModal', 'uploadModal', 'bodyModal', 'titlesModal', 'imageModal', 'videoModal', 'deleteModal','$interval',
    function($scope,   $filter, $sce,   TreeService,   RecordService,   treeModal,   ValuesService,   savingModal,   uploadModal,   bodyModal,   titlesModal,   imageModal, videoModal, deleteModal, $interval ) {


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
         *
         *  RecordService Initializing
         */
        $scope.RecordService = RecordService;
        $scope.RecordService.getRecordsForCat(1);
        $scope.recordList = function() {
            return RecordService.recordList();
        };

        $scope.showModal = treeModal.activate;

        $scope.showSavingModal = function(){savingModal.activate()};

        $scope.showTitlesModal = function(){titlesModal.activate()};

        $scope.showImageShowModal = function(image, index) { ValuesService.currentImageModal.image = image; ValuesService.currentImageModal.index = index;  imageModal.activate()};

        $scope.showVideoShowModal = function(video, index) { ValuesService.currentVideoModal.video = video; ValuesService.currentVideoModal.index = index;  videoModal.activate()};

        $scope.showDeleteModal = function(){
            deleteModal.activate();
        };

        $scope.showUploadModal = function() {uploadModal.activate();}

        $scope.showBodyModal = bodyModal.activate;



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

        self.toggleActiveCurrentRecord = function() {
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
                        serv.deactivate();
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
                        if($filter('number')(result) && result.length == 6) {
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
            self.temporaryRecord = {}
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

        self.removeFromAttachList = function() {
            switch(ValuesService.activeTab) {
                case 'image':
                    angular.forEach(self.selectedImages, function(value, key){
                        self.currentRecord.imagesList.remove(value);
                    });
                    self.currentRecord.images = self.currentRecord.imagesList.all();
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

        self.removeFromBodyAttachList = function() {
            switch(ValuesService.bodyAttachmentActiveTab) {
                case 'image':
                    angular.forEach(self.selectedBodyImages, function(value, key){
                        self.currentRecord.bodyImagesList.remove(value);
                    });
                    self.currentRecord.body_images = self.currentRecord.bodyImagesList.all();
                    break;
                case 'video':
                    angular.forEach(self.selectedBodyVideos, function(value, key){
                        self.currentRecord.bodyVideosList.remove(value);
                    });
                    self.currentRecord.body_videos = self.currentRecord.bodyVideosList.all();
                    break;
                case 'audio':
                    angular.forEach(self.selectedBodyAudios, function(value, key){
                        self.currentRecord.bodyAudiosList.remove(value);
                    });
                    self.currentRecord.body_audios = self.currentRecord.bodyAudiosList.all();
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



        self.saveCurrentRecord = function() {
            self.savingMessages = {}
            if(self.isNew()) {

                self.saveCurrentNewRecord().then(
                    function(response){
                        self.currentRecord = {}
                        self.currentRecord = response.data[0];


                        self.saved = true;
                        self.searchRecords();
                        self.finishEditing();
                    },
                    function(errResponse){

                    }
                );
            } else {
                self.updateCurrentRecord().then(
                    function(response){
                        self.currentReocrd = response;
                        self.saved = true;
                        self.savingMessages = ['رکورد مورد نظر ذخیره شد.'];
                        self.searchRecords();
                        self.finishEditing();
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
    factory('treeModal', function (btfModal) {
        return btfModal({
            controller: 'treeModalCtrl',
            controllerAs: 'treeModal',
            templateUrl: 'tree-modal.html'
        });
    }).
    factory('savingModal', function (btfModal) {
        return btfModal({
            controller: 'savingModalCtrl',
            controllerAs: 'savingModal',
            templateUrl: 'saving-modal.html'
        });
    }).
    factory('uploadModal', function (btfModal) {
        return btfModal({
            controller: 'uploadModalCtrl',
            controllerAs: 'uploadModal',
            templateUrl: 'upload-modal.html'
        });
    }).
    factory('bodyUploadModal', function (btfModal) {
        return btfModal({
            controller: 'bodyUploadModalCtrl',
            controllerAs: 'bodyUploadModal',
            templateUrl: 'body-upload-modal.html'
        });
    }).
    factory('bodyModal', function (btfModal) {
        return btfModal({
            controller: 'bodyModalCtrl',
            controllerAs: 'bodyModal',
            templateUrl: 'body-modal.html'
        });
    }).
    factory('titlesModal', function (btfModal) {
        return btfModal({
            controller: 'titlesModalCtrl',
            controllerAs: 'titlesModal',
            templateUrl: 'titles-modal.html'
        });
    }).
    factory('deleteModal', function (btfModal) {
        return btfModal({
            controller: 'deleteModalCtrl',
            controllerAs: 'deleteModal',
            templateUrl: 'delete-modal.html'
        });
    }).
    factory('imageModal', function (btfModal) {
        return btfModal({
            controller: 'imageModalCtrl',
            controllerAs: 'imageModal',
            templateUrl: 'image-modal.html'
        });
    }).
    factory('videoModal', function (btfModal) {
        return btfModal({
            controller: 'videoModalCtrl',
            controllerAs: 'videoModal',
            templateUrl: 'video-modal.html'
        });
    }).

    controller('treeModalCtrl', ['$scope', 'treeModal', 'RecordService','TreeService', function ($scope, treeModal, RecordService, TreeService) {
        $scope.RecordService = RecordService;
        $scope.TreeService = TreeService;
        $scope.tree = function() {
            return $scope.TreeService.tree();
        }

        $scope.treeOptions = function() {
            return $scope.TreeService.treeOptions();
        }
        $scope.closeMe = treeModal.deactivate;

        $scope.addTerm = function(term) {

        }
    }]).
    controller('savingModalCtrl', ['$scope', 'savingModal', 'RecordService','TreeService', function ($scope, savingModal, RecordService, TreeService) {
        $scope.RecordService = RecordService;
        $scope.closeMe = function(){RecordService.saved = false; savingModal.deactivate();}

    }]).
    controller('titlesModalCtrl', ['$scope', 'titlesModal', 'RecordService','TreeService', function ($scope, titlesModal, RecordService, TreeService) {
        $scope.RecordService = RecordService;
        $scope.closeMe = function(){titlesModal.deactivate();}
    }]).
    controller('deleteModalCtrl', ['$scope', 'deleteModal', 'RecordService','TreeService', function ($scope, deleteModal, RecordService, TreeService) {
        $scope.RecordService = RecordService;
        $scope.closeMe = function(){deleteModal.deactivate();}
        $scope.deleteCurrentRecord = function() {
            console.log(RecordService.deleteCurrentRecord(deleteModal));
        }
    }]).
    controller('imageModalCtrl', ['$scope', 'imageModal', 'RecordService','TreeService', 'ValuesService', function ($scope, imageModal, RecordService, TreeService, ValuesService) {
        $scope.RecordService = RecordService;
        $scope.ValuesService = ValuesService;
        $scope.closeMe = function(){ValuesService.currentImageModal = {}; imageModal.deactivate();}
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
    controller('videoModalCtrl', ['$scope', '$sce', 'videoModal', 'RecordService','TreeService', 'ValuesService', function ($scope, $sce, videoModal, RecordService, TreeService, ValuesService) {
        $scope.RecordService = RecordService;
        $scope.ValuesService = ValuesService;
        $scope.closeMe = function(){ValuesService.currentVideoModal = {}; videoModal.deactivate();}
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
    controller('uploadModalCtrl', ['$scope', 'uploadModal', 'RecordService','TreeService', 'ValuesService', '$http', function ($scope, uploadModal, RecordService, TreeService, ValuesService, $http) {

        $scope.RecordService = RecordService;
        $scope.ValuesService = ValuesService;
        $scope.uploadable = false;
        $scope.uploading = false;
        $scope.closeMe = function(){uploadModal.deactivate();}
        $scope.filesChanged = function(elm) {
            $scope.files = elm.files;
            $scope.$apply();
            RecordService.file = $scope.files[0];
            fileType = RecordService.file.type.split("/")[0];
            fileExtension = RecordService.file.type.split("/")[1];
            switch(ValuesService.activeTab) {
                case 'image':
                    uploadableType = "image";
                    uploadableExtensions = ["jpg", "png", "jpeg", "gif"];
                    break;
                case 'video':
                    uploadableType = "video";
                    uploadableExtensions = ["mp4", "mpg", "mpeg"];
                    break;
                case 'audio':
                    uploadableType = "audio";
                    uploadableExtensions = ["mp3"];
                    break;
            }
            if(fileType != uploadableType || uploadableExtensions.indexOf(fileExtension) == -1) {
                alert(
                    "شما فقط میتوانید فاید "
                        + uploadableType
                        + " با پسوند های "
                        + uploadableExtensions.join()
                        + "انتخاب کنید."
                );
            } else {
                $scope.uploadable = true;
                $scope.$apply();
            }

        };



        $scope.upload = function() {
            if(!$scope.uploadable) {
                return;
            }
            $scope.uploading = true;
            //$scope.$apply();
            var fd = new FormData();
            fd.append('file', RecordService.file);
            fd.append('uploadDir', ValuesService.activeTab);
            fd.append('type', 'record');
            if(RecordService.isNew()) {
                if(ValuesService.getRandUploadKey()) {
                    fd.append('uploadKey', ValuesService.getRandUploadKey());
                }
            } else {
                fd.append('entityId', RecordService.currentRecord.id);

            }





            $http.post('../managedfile/ajax/upload', fd,
                {
                    transformRequest:angular.identity,
                    headers: {'Content-Type':undefined }
                }).then(
                function(response){

                    switch(response.data.upload_dir) {
                        case 'image':
                            RecordService.addToImagesList(response.data);
                            break;
                        case 'video':
                            RecordService.addToVideosList(response.data);
                            break;
                        case 'audio':
                            RecordService.addToAudiosList(response.data);
                            break;

                    }
                    $scope.uploading = false;
                    //$scope.$apply();


                },
                function(errResponse){
                    $scope.uploading = false;
                    $scope.$apply();

                });
        };


    }]).
    controller('bodyModalCtrl', ['$scope', '$http' ,'bodyModal', 'RecordService','TreeService', 'ValuesService', 'bodyUploadModal',
        function (                $scope,   $http,   bodyModal,   RecordService,  TreeService,   ValuesService,   bodyUploadModal) {
        $scope.RecordService = RecordService;
        $scope.TreeService = TreeService;
        $scope.ValuesService = ValuesService;
        $scope.uploadable = false;
        $scope.uploading = false;
        $scope.bodyEditorOptions = {
            language: 'fa',
            height: '353px',
            uiColor: '#e8ede0',
            extraPlugins: "dragresize,video",
            contentsLangDirection: 'rtl',
            allowedContent : true,
            toolbar: [
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'Video' ] },
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
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

        $scope.filesChanged = function(elm) {
            $scope.files = elm.files;
            $scope.$apply();
            RecordService.bodyFile = $scope.files[0];
            fileType = RecordService.bodyFile.type.split("/")[0];
            fileExtension = RecordService.bodyFile.type.split("/")[1];
            switch(ValuesService.bodyAttachmentActiveTab) {
                case 'image':
                    uploadableType = "image";
                    uploadableExtensions = ["jpg", "png", "jpeg", "gif"];
                    break;
                case 'video':
                    uploadableType = "video";
                    uploadableExtensions = ["mp4", "mpg", "mpeg"];
                    break;
                case 'audio':
                    uploadableType = "audio";
                    uploadableExtensions = ["mp3"];
                    break;
            }
            if(fileType != uploadableType || uploadableExtensions.indexOf(fileExtension) == -1) {
                alert(
                    "شما فقط میتوانید فاید "
                        + uploadableType
                        + " با پسوند های "
                        + uploadableExtensions.join()
                        + "انتخاب کنید."
                );
            } else {
                $scope.uploadable = true;
                $scope.$apply();
            }
        };


        $scope.CkeditorInsert = function() {

            var CkInstance = null;
            angular.forEach(CKEDITOR.instances,function(value, key){CkInstance = value; keepGoing = false;})
            switch(ValuesService.bodyAttachmentActiveTab) {
                case 'image':
                    CkInstance.insertHtml('<img alt="" width="100px" src="'+RecordService.selectedBodyImage.absolute_path+'" />');
                    break;
                case 'video':
                    CkInstance.insertHtml('<p><video controls="" name="media" width="300"><source src="'+RecordService.selectedBodyVideo.absolute_path+'" type="'+RecordService.selectedBodyVideo.filemime+'"></video></p>');
                    break;
                case 'audio':
                    CkInstance.insertHtml('<p><audio controls="" name="media" width="300"><source src="'+RecordService.selectedBodyAudio.absolute_path+'" type="'+RecordService.selectedBodyAudio.filemime+'"></audio></p>');
                    break;

            }


        };

        $scope.upload = function() {
            if(!$scope.uploadable) {
                return;
            }
            $scope.uploading = true;

            var fd = new FormData();

            fd.append('file', RecordService.bodyFile);
            fd.append('uploadDir', ValuesService.bodyAttachmentActiveTab);
            fd.append('type', 'record');
            if(RecordService.isNew()) {
                if(ValuesService.getRandUploadKey()) {
                    fd.append('uploadKey', ValuesService.getRandUploadKey());
                }
            } else {
                fd.append('entityId', RecordService.currentRecord.id);
            }





            $http.post('../managedfile/ajax/upload', fd,
                {
                    transformRequest:angular.identity,
                    headers: {'Content-Type':undefined }
                }).then(
                function(response){

                    switch(response.data.upload_dir) {
                        case 'image':
                            RecordService.addToBodyImagesList(response.data);
                            break;
                        case 'video':
                            RecordService.addToBodyVideosList(response.data);
                            break;
                        case 'audio':
                            RecordService.addToBodyAudiosList(response.data);
                            break;

                    }
                    $scope.uploading = false;


                },
                function(errResponse){
                    $scope.uploading = false;
                    $scope.$apply();
                });
        };

        $scope.closeMe = bodyModal.deactivate;


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


        self.safarsazRanks = [
            {
                id: 1,
                name: 1
            },
            {
                id: 2,
                name: 2
            },
            {
                id: 3,
                name: 3
            },
            {
                id: 4,
                name: 4
            },
            {
                id: 5,
                name: 5
            },
            {
                id: 6,
                name: 6
            },
            {
                id: 7,
                name: 7
            },
            {
                id: 8,
                name: 8
            },
            {
                id: 9,
                name: 9
            },
            {
                id: 10,
                name: 10
            }

        ];

        return self;

    }]);
