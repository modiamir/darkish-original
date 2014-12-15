//var recordIndexCtrl = angular.module('RecordIndexCtrl', ['recordtreeControl', 'angularFileUpload']);
//var recordIndexCtrl = recordApp.module('RecordIndexCtrl', ['recordtreeControl', 'angularFileUpload']);


    // inject the Comment service into our controller
//    recordIndexCtrl.controller('RecordIndexController', ['$modal','$scope','$http', '$upload', '$interval', 'RecordTree','RecordControl',
//        function($modal, $scope, $http, $upload, $interval, NewsTree, NewsControl) {
//            $scope.test = "this is test";
//        }]);

angular.module('RecordApp', ['treeControl', 'ui.grid', 'smart-table', 'btford.modal', 'ngCollection', 'ngSanitize', 'ngCkeditor']).
    controller('RecordIndexCtrl', ['$scope', '$filter', 'TreeService', 'RecordService', 'treeModal', 'ValuesService', 'savingModal', 'uploadModal', 'bodyModal',
                           function($scope,   $filter,   TreeService,   RecordService,   treeModal,   ValuesService,   savingModal,   uploadModal,   bodyModal ) {


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

        $scope.showSavingModal = function(){console.log(RecordService.saved);savingModal.activate()};

        $scope.showUploadModal = function() {uploadModal.activate();}

        $scope.showBodyModal = bodyModal.activate;















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
                    //console.log(response);
                }, function(errResponse) {
                    console.error('Error while fetching notes');
                });
            },
            selectTree: function(node) {
                RecordService.getRecordsForCat(node.id);

            }

        };
    }])
    .factory('RecordService', ['$http', 'Collection', 'ValuesService', '$filter' ,function($http, Collection, ValuesService, $filter){
        var recordList = [];
        var selectedRecord = {};
//        var currentRecord;




        var self = {

            currentRecord: {}



        };

        self.currentRecord.treeList = Collection.getInstance();
        self.currentRecord.images = Collection.getInstance()
        self.currentRecord.videos = Collection.getInstance()
        self.currentRecord.audios = Collection.getInstance()

        self.saved = false;

        self.currentCid;

        self.list = function() {
            return items;
        };

        self.selectedRecord= function() {
            return self.selectedRecord;
        };

        self.getRecordsForCat = function(cid) {

            $http.get('ajax/get_record_for_cat/'+cid).then(function(response){
                recordList = response.data;
                self.currentCid = cid;
                //console.log(response);
            },function(errResponse){
                console.log(errResponse);
            });
        };

        self.recordList = function() {
            return recordList;
        };

        var temporaryRecord = {}

        self.file = null;

        var editing = false;
        self.isEditing = function() {
            return editing;
        }

        self.editingNew= function() {
            result = prompt("شماره رکورد را وارد کنید.");
            if(result) {
                if($filter('number')(result)) {
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
                    editing = true;
                    ValuesService.getRandUploadKey(true);
                } else {
                    alert('شماره وارد شده معتبر نمیباشد. لطفا دوباره امتحان کنید.');
                }

            }

        }



        self.editing = function() {
            temporaryRecord = angular.copy(self.currentRecord);
            editing = true;
        }

        self.cancelEditing = function() {
            self.currentRecord = angular.copy(temporaryRecord);
            editing = false;
        }

        self.selectImage = function(image) {
            console.log(image);
            self.selectedImage = image;
        }

        self.selectBodyImage = function(image) {
            console.log(image);
            self.selectedBodyImage = image;
        }

        self.selectVideo = function(video) {
            console.log(video);
            self.selectedVideo = video;
        }

        self.selectBodyVideo = function(video) {
            console.log(video);
            self.selectedBodyVideo = video;
        }

        self.selectAudio = function(audio) {
            console.log(audio);
            self.selectedAudio = audio;
        }

        self.selectBodyAudio = function(audio) {
            console.log(audio);
            self.selectedBodyAudio = audio;
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

                    self.currentRecord.treeList = Collection.getInstance();
                    self.currentRecord.treeList.addAll(self.currentRecord.trees);

                    self.currentRecord.imagesList = Collection.getInstance();
                    self.currentRecord.imagesList.addAll(self.currentRecord.images);

                    self.currentRecord.videosList = Collection.getInstance();
                    self.currentRecord.videosList.addAll(self.currentRecord.videos);

                    self.currentRecord.audiosList = Collection.getInstance();
                    self.currentRecord.audiosList.addAll(self.currentRecord.audios);


                    self.currentRecord.bodyImagesList = Collection.getInstance();
                    self.currentRecord.bodyImagesList.addAll(self.currentRecord.body_images);

                    self.currentRecord.bodyVideosList = Collection.getInstance();
                    self.currentRecord.bodyVideosList.addAll(self.currentRecord.body_videos);

                    self.currentRecord.bodyAudiosList = Collection.getInstance();
                    self.currentRecord.bodyAudiosList.addAll(self.currentRecord.body_audios);

                    console.log(self.currentRecord);
                },
                function(errResponse) {
                    console.log(errResponse);
                }
            );

        };

        self.addToImagesList = function(obj) {
            console.log(obj);
            self.currentRecord.imagesList.add(obj);
            self.currentRecord.images = self.currentRecord.imagesList.all();
        }

        self.addToBodyImagesList = function(obj) {
            console.log(obj);
            self.currentRecord.bodyImagesList.add(obj);
            self.currentRecord.body_images = self.currentRecord.bodyImagesList.all();
        }

        self.addToVideosList = function(obj) {
            console.log(obj);
            self.currentRecord.videosList.add(obj);
            self.currentRecord.videos = self.currentRecord.videosList.all();
        }

        self.addToBodyVideosList = function(obj) {
            console.log(obj);
            self.currentRecord.bodyVideosList.add(obj);
            self.currentRecord.body_videos = self.currentRecord.bodyVideosList.all();
        }

        self.addToAudiosList = function(obj) {
            console.log(obj);
            self.currentRecord.audiosList.add(obj);
            self.currentRecord.audios = self.currentRecord.audiosList.all();
        }

        self.addToBodyAudiosList = function(obj) {
            console.log(obj);
            self.currentRecord.bodyAudiosList.add(obj);
            self.currentRecord.body_audios = self.currentRecord.bodyAudiosList.all();
        }

        self.removeFromAttachList = function() {
            switch(ValuesService.activeTab) {
                case 'image':
                    self.currentRecord.imagesList.remove(self.selectedImage);
                    self.currentRecord.images = self.currentRecord.imagesList.all();
                    break;
                case 'video':
                    self.currentRecord.videosList.remove(self.selectedVideo);
                    self.currentRecord.videos = self.currentRecord.videosList.all();
                    break;
                case 'audio':
                    self.currentRecord.audiosList.remove(self.selectedAudio);
                    self.currentRecord.audios = self.currentRecord.audiosList.all();
                    break;

            }

        }

        self.removeFromBodyAttachList = function() {
            switch(ValuesService.bodyAttachmentActiveTab) {
                case 'image':
                    self.currentRecord.bodyImagesList.remove(self.selectedBodyImage);
                    self.currentRecord.body_images = self.currentRecord.bodyImagesList.all();
                    break;
                case 'video':
                    self.currentRecord.bodyVideosList.remove(self.selectedBodyVideo);
                    self.currentRecord.body_videos = self.currentRecord.bodyVideosList.all();
                    break;
                case 'audio':
                    self.currentRecord.bodyAudiosList.remove(self.selectedBodyAudio);
                    self.currentRecord.body_audios = self.currentRecord.bodyAudiosList.all();
                    break;

            }

        }







        self.addToTreeList = function(obj)  {
            console.log(obj);
            self.currentRecord.treeList.add(obj);
            self.currentRecord.trees = self.currentRecord.treeList.all() ;
        }

        self.removeFromTreeList = function(selectedTrees)  {
            console.log(selectedTrees);
            selectedTrees.forEach(function(tree, index, selectedTrees){
                self.currentRecord.treeList.remove(tree);
            });

            self.currentRecord.trees = self.currentRecord.treeList.all() ;
            console.log(self.currentRecord.treeList.all());
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
            if(self.isNew()) {

                self.saveCurrentNewRecord().then(
                    function(response){
                        self.currentReocrd = response;
                        self.saved = true;
                        self.getRecordsForCat(self.currentCid);
                        self.finishEditing();
                    },
                    function(errResponse){console.log(errResponse);}
                );
            } else {
                self.updateCurrentRecord().then(
                    function(response){
                        self.currentReocrd = response;
                        self.saved = true;
                        self.getRecordsForCat(self.currentCid);
                        self.finishEditing();
                    },
                    function(errResponse){console.log(errResponse);}
                );
            }
        }

        self.changeWorkingDays = function() {

            self.currentRecord.working_days = function() {
                $encoded = "";
                console.log(self.currentRecord.decoded_working_days);
                for(i=1 ; i<=8 ; i++) {
                    console.log(self.currentRecord.decoded_working_days[i]);
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
    controller('uploadModalCtrl', ['$scope', 'uploadModal', 'RecordService','TreeService', 'ValuesService', '$http', function ($scope, uploadModal, RecordService, TreeService, ValuesService, $http) {

        $scope.RecordService = RecordService;
        $scope.ValuesService = ValuesService;
        $scope.closeMe = function(){uploadModal.deactivate();}
        $scope.filesChanged = function(elm) {
            $scope.files = elm.files;
            $scope.$apply();
            RecordService.file = $scope.files[0];
        };

        $scope.upload = function() {

            var fd = new FormData();

            fd.append('file', RecordService.file);
            fd.append('uploadDir', ValuesService.activeTab);
            fd.append('type', 'record');
            if(RecordService.isNew()) {
                if(ValuesService.getRandUploadKey()) {
                    fd.append('uploadKey', ValuesService.getRandUploadKey());
                }
                alert('isnew');
            } else {
                fd.append('entityId', RecordService.currentRecord.id);
                alert('is not new');
            }





            $http.post('../managedfile/ajax/upload', fd,
                {
                    transformRequest:angular.identity,
                    headers: {'Content-Type':undefined }
                }).then(
                function(response){
                    console.log(response);

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


                },
                function(errResponse){

                });
        };


    }]).
    controller('bodyModalCtrl', ['$scope', '$http' ,'bodyModal', 'RecordService','TreeService', 'ValuesService', 'bodyUploadModal',
        function (                $scope,   $http,   bodyModal,   RecordService,  TreeService,   ValuesService,   bodyUploadModal) {
        $scope.RecordService = RecordService;
        $scope.TreeService = TreeService;
        $scope.ValuesService = ValuesService;
        $scope.bodyEditorOptions = {
            language: 'en',
            height: '400px',
            uiColor: '#e8ede0',
            contentsLangDirection: 'rtl',
            toolbar_full: [
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
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
        };


        $scope.CkeditorInsert = function() {
            switch(ValuesService.bodyAttachmentActiveTab) {
                case 'image':
//                    CKEDITOR.instances.editor1.insertHtml('<img width="100" src="'+absolutePath+'"/>');
                    console.log(RecordService.selectedBodyImage.absolute_path);
                    break;
                case 'video':
//                    CKEDITOR.instances.editor1.insertHtml('<img width="100" src="'+absolutePath+'"/>');
                    console.log(RecordService.selectedBodyVideo.absolute_path);
                    break;
                case 'audio':
//                    CKEDITOR.instances.editor1.insertHtml('<img width="100" src="'+absolutePath+'"/>');
                    console.log(RecordService.selectedBodyAudio.absolute_path);
                    break;

            }


        };

        $scope.upload = function() {

            var fd = new FormData();

            fd.append('file', RecordService.bodyFile);
            fd.append('uploadDir', ValuesService.bodyAttachmentActiveTab);
            fd.append('type', 'record');
            if(RecordService.isNew()) {
                if(ValuesService.getRandUploadKey()) {
                    fd.append('uploadKey', ValuesService.getRandUploadKey());
                }
                alert('isnew');
            } else {
                fd.append('entityId', RecordService.currentRecord.id);
                alert('is not new');
            }





            $http.post('../managedfile/ajax/upload', fd,
                {
                    transformRequest:angular.identity,
                    headers: {'Content-Type':undefined }
                }).then(
                function(response){
                    console.log(response);

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


                },
                function(errResponse){

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
                    console.log(response.data);

                },
                function(errResponse) {
                    console.log(errResponse);
                }
            );
        }

        if(!csrf) {
            $http.get('ajax/generate_csrf').then(
                function(response) {
                    self.csrf = response.data;
                    console.log(response.data);
                    console.log("asd");

                },
                function(errResponse) {
                    console.log(errResponse);
                }
            );
        }

        if(!safarSazTypes) {
            $http.get('ajax/get_safarsaz_types').then(
                function(response) {
                    self.safarsazTypes = response.data;
                    console.log(response.data);

                },
                function(errResponse) {
                    console.log(errResponse);
                }
            );

        }

        if(!dbaseTypes) {

            $http.get('ajax/get_dbase_types').then(
                function(response) {
                    self.dbaseTypes = response.data;
                    console.log(response.data);

                },
                function(errResponse) {
                    console.log(errResponse);
                }
            );



        }

        if(!areas) {

            $http.get('ajax/get_areas').then(
                function(response) {
                    self.areas = response.data;
                    console.log(response.data);

                },
                function(errResponse) {
                    console.log(errResponse);
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
