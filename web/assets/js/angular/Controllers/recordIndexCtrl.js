//var recordIndexCtrl = angular.module('RecordIndexCtrl', ['recordtreeControl', 'angularFileUpload']);
//var recordIndexCtrl = recordApp.module('RecordIndexCtrl', ['recordtreeControl', 'angularFileUpload']);


    // inject the Comment service into our controller
//    recordIndexCtrl.controller('RecordIndexController', ['$modal','$scope','$http', '$upload', '$interval', 'RecordTree','RecordControl',
//        function($modal, $scope, $http, $upload, $interval, NewsTree, NewsControl) {
//            $scope.test = "this is test";
//        }]);

angular.module('RecordApp', ['treeControl', 'ui.grid', 'smart-table', 'btford.modal']).
    controller('RecordIndexCtrl', ['$scope', '$filter', 'TreeService', 'RecordService', 'treeModal', function($scope, $filter, TreeService, RecordService, treeModal) {


        /**
         *
         *  TreeService initializing
         */
        $scope.TreeService = TreeService;
        $scope.TreeService.updateTree();
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








        //console.log($scope.RecordService.gridOptions());














    }])
    .factory('TreeService', ['$http', 'RecordService', function($http, RecordService){
        var test;
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
    .factory('RecordService', ['$http',function($http){
        var recordList = [];
        var selectedRecord = {};
//        var currentRecord;



        var self = {

            currentRecord: {}



        };

        self.list = function() {
            return items;
        };

        self.selectedRecord= function() {
            return self.selectedRecord;
        };

        self.getRecordsForCat = function(cid) {

            $http.get('ajax/get_record_for_cat/'+cid).then(function(response){
                recordList = response.data;
                //console.log(response);
            },function(errResponse){
                console.log(errResponse);
            });
        };

        self.recordList = function() {
            return recordList;
        };

        self.selectRecord = function(record) {
            selectedRecord = record;
            $http.get('ajax/get_record/'+record.id).then(
                function(response) {
                    self.currentRecord = response.data;
                },
                function(errResponse) {
                    console.log(errResponse);
                }
            );

            console.log(self.currentRecord);
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
    controller('treeModalCtrl', ['$scope', 'treeModal', function ($scope, treeModal) {
        $scope.closeMe = treeModal.deactivate;
    }]);
