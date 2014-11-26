//var newsIndexCtrl = angular.module('newsIndexCtrl', ['treeControl', 'angularFileUpload']);
var classifiedIndexCtrl = angular.module('classifiedIndexCtrl', ['treeControl', 'angularFileUpload']);

    // inject the Comment service into our controller
//newsIndexCtrl.controller('NewsIndexController', ['$modal','$scope','$http', '$upload', '$interval', 'NewsTree','NewsControl',    
classifiedIndexCtrl.controller('ClassifiedIndexController', ['$modal','$scope','$http', '$upload', '$interval', 'ClassifiedTree','ClassifiedControl',
        function($modal, $scope, $http, $upload, $interval, ClassifiedTree, ClassifiedControl) {
        // object to hold all the data for the new comment form

        $scope.mainTreeHide = false;
        $scope.classifiedGridHide = false;
        $scope.editing = false;
        $scope.test = "asd";
        $scope.dataForTheTree = [{
            id: -1,
            title: 'تایید نشده ها',
            treeIndex: '--',
            upTreeIndex: '#'
        },{
            id: -2,
            title: 'بدون شاخه ها',
            treeIndex: '-1',
            upTreeIndex: '#'
        }];

        $scope.dataForTheClassifiedTree = [];
            $scope.threetree = {};
        $scope.treeOptions = {
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


        ClassifiedTree.get()
            .success(function(data) {
                data.forEach(function(element, index, array){
                    $scope.dataForTheTree.push(element);
                });
                $scope.dataForTheClassifiedTree = data;
                $scope.showSelected($scope.dataForTheTree[0]);
            });

        $scope.newClassifiedAction = function() {
            $scope.previousClassified = $scope.classified;
            $scope.classified = {
                id: "",
                title: "",
                createdDate: "",
                publishDate: "",
                expireDate: "",
                body: "",
                userId: "",
                status: "",
                category: "",
                classifiedtreeId: '',
                firstPhone: "",
                secondPhone: "",
                email: "",
                unitNumber: "",
                firstImage: "",
                secondImage: "",
                thirdImage: "",
                banner: ""

            };
            console.log($scope.previousClassified);
            console.log($scope.classified);
            $scope.editing = true;
            $scope.mainTreeHide = true;
            $scope.classifiedGridHide = true;
        };


        $scope.cancelClassifiedAction = function() {
            console.log($scope.previousClassified);
            $scope.classified = $scope.previousClassified;
            $scope.previousClassified = {
                id: "",
                title: "",
                createdDate: "",
                publishDate: "",
                expireDate: "",
                body: "",
                userId: "",
                status: "",
                category: "",
                classifiedtreeId: '',
                categoryObj: null,
                firstPhone: "",
                secondPhone: "",
                email: "",
                unitNumber: "",
                firstImage: "",
                secondImage: "",
                thirdImage: "",
                banner: ""

            };
            $scope.editing = false;
            $scope.mainTreeHide = false;
            $scope.classifiedGridHide = false;
        };

        $scope.editClassifiedAction = function() {
            $scope.previousClassified = copy($scope.classified);

            $scope.editing = true;
            $scope.mainTreeHide = true;
            $scope.classifiedGridHide = true;
        };





        $scope.FindByIdInTree = function(id , item) {

            var len = $scope.dataForTheTree.length;


            if(!item) {
                for(var i = 0 ; i< len ; i++) {
                    if($scope.dataForTheTree[i].id == id) {
                        return $scope.dataForTheTree[i];
                    }
                    if($scope.dataForTheTree[i].children) {
                        if($scope.FindByIdInTree(id, $scope.dataForTheTree[i].children)){
                            return $scope.FindByIdInTree(id, $scope.dataForTheTree[i].children);
                        }
                    }

                }

            } else {
                var len = item.length;
                for(var i = 0 ; i < len ; i++) {
                    if(item[i].id == id) {
                        return item[i];
                    }
                    if(item[i].children) {
                        if($scope.FindByIdInTree(id, item[i].children)) {
                            return $scope.FindByIdInTree(id, item[i].children);
                        }
                    }
                }
            }
        };



            $scope.getForCategory = "false";

        $scope.clickForCat = function(cid) {

        };


        $scope.selectTreeForCurrentClassified = function(node) {

            $scope.classified.categoryObj = node;
            $scope.classified.category = node.treeIndex;
            $scope.classified.classifiedtreeId = node.id;
            console.log("inja");
            console.log(node);


        }

        $scope.open = function () {

            $scope.modalInstance = $modal.open({
                templateUrl: 'myModalContent.html',
                size: 'lg',
                scope: $scope
            });
            $scope.modalInstance.lastCat = $scope.classified.categoryObj;

            $scope.modalInstance.result.then(function (selectedItem) {
                console.log(selectedItem);
            }, function (lastCat) {
                $scope.classified.categoryObj = lastCat;
            });
        };



        $scope.ok = function () {
            $scope.modalInstance.close($scope.currentClassifiedTree);
        };

        $scope.cancel = function () {
            $scope.modalInstance.dismiss($scope.modalInstance.lastCat);
        };



        $scope.openDeleteModal = function() {
            $scope.modalInstance = $modal.open({
                templateUrl: 'deleteModalContent.html',
                size: 'lg',
                scope: $scope
            });

            $scope.modalInstance.result.then(function (selectedItem) {
                $scope.deleteCurrentClassified();
            }, function (lastCat) {

            });
        };

        $scope.okDeleteModal = function() {
            $scope.modalInstance.close();
        }

        $scope.cancelDeleteModal = function() {
            $scope.modalInstance.dismiss();
        }

        $scope.classified = {
            id: "",
            title: "",
            createdDate: "",
            publishDate: "",
            expireDate: "",
            body: "",
            userId: "",
            status: "",
            category: "",
            classifiedtreeId: '',
            categoryObj: null,
            firstPhone: "",
            secondPhone: "",
            email: "",
            unitNumber: "",
            firstImage: "",
            secondImage: "",
            thirdImage: "",
            banner: ""
        };

        $scope.previousClassified = {
            id: "",
            title: "",
            createdDate: "",
            publishDate: "",
            expireDate: "",
            body: "",
            userId: "",
            status: "",
            category: "",
            classifiedtreeId: '',
            categoryObj: null,
            firstPhone: "",
            secondPhone: "",
            email: "",
            unitNumber: "",
            firstImage: "",
            secondImage: "",
            thirdImage: "",
            banner: ""
        };


        $scope.classifiedForm = {
            templates: [
                {name:'خبر عادی', value: 0},
                {name:'مسابقه', value: 1},
                {name:'ویدئو', value: 2},
                {name:'پادکست', value: 3}

            ]

        };
        $scope.template = $scope.classifiedForm.templates[0];




        $scope.testFunction = function() {
            //console.log($scope.classifiedGridOptions.data[$scope.classifiedGridOptions.data.length-1]);
            //$scope.gridApi.selection.selectRow($scope.classifiedGridOptions.data[$scope.classifiedGridOptions.data.length-1]);

            $indexOfThis = -1;
            $scope.classifiedGridOptions.data.every(function(element, index, array){
                if(element.id == 17) {
                    $indexOfThis = element.id;
                    return false;
                }
                return true;

            });
            console.log($indexOfThis);



        };




        $scope.showSelected = function(sel, page) {
            var page = (!page)?1:page;
            $scope.selected = sel;

            ClassifiedControl.getForCategory(sel.id, page).success(function(data){
                $scope.classifiedGridOptions.data = data;

                $interval( function() {$scope.gridApi.selection.selectRow($scope.classifiedGridOptions.data[0]);}, 0, 1);
            });



            $http.get('ajax/generate_csrf/create_classified').success(function(data){
                $scope._token = data;
            });

            ClassifiedControl.getTotalPages(sel.id).success(function(data){
                $scope.classifiedGridOptions.totalPages = data;
            });
        };

        /*$scope.classifiedGridOptions = { enableRowSelection: true, enableRowHeaderSelection: false };
        $scope.classifiedGridOptions = { multiSelect: false };
        $scope.classifiedGridOptions.modifierKeysToMultiSelect = false;
        $scope.classifiedGridOptions.noUnselect = true;
        */

            $scope.classifiedGridOptions = { enableRowSelection: true, enableRowHeaderSelection: false };



            $scope.classifiedGridOptions.multiSelect = false;
            $scope.classifiedGridOptions.modifierKeysToMultiSelect = false;
            $scope.classifiedGridOptions.noUnselect = true;
            $scope.classifiedGridOptions.page = 1;
            $scope.classifiedGridOptions.nextPage = function() {
                if($scope.classifiedGridOptions.page < $scope.classifiedGridOptions.totalPages) {
                    $scope.classifiedGridOptions.page = $scope.classifiedGridOptions.page + 1;
                    $scope.showSelected($scope.selected, $scope.classifiedGridOptions.page);
                }
            };

            $scope.classifiedGridOptions.previousPage = function() {
                if($scope.classifiedGridOptions.page > 1) {
                    $scope.classifiedGridOptions.page = $scope.classifiedGridOptions.page - 1;
                    $scope.showSelected($scope.selected, $scope.classifiedGridOptions.page);
                }
            };
            $scope.classifiedGridOptions.totalPages = "";

        $scope.classifiedGridOptions.columnDefs = [
            { field: 'id' },
            { field: 'title'},
            { field: 'createdDate'},
            { field: 'expireDate'},
            { field: 'status', cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                if (row.entity.status) {
                        return 'approved glyphicon glyphicon-ok';
                    } else {
                        return 'unapproved glyphicon glyphicon-ok';
                    }
                },

                type: 'boolean'
            }
        ];





        //$scope.classifiedGridOptions.data =[{"id":13,"createdDate":null,"expireDate":null,"file":null,"body":null,"userId":null,"status":false,"category":"01","absolutePath":"E:\\xampp\\htdocs\\darkish\\src\\Darkish\\CategoryBundle\\Entity\/..\/..\/..\/..\/web\/uploads\/documents\/13289bb6825fa1e4c53a3221d50a26e5675b871a.txt","webPath":"uploads\/documents\/13289bb6825fa1e4c53a3221d50a26e5675b871a.txt","title":"sd sdsad sad","path":"13289bb6825fa1e4c53a3221d50a26e5675b871a.txt"},{"id":14,"createdDate":null,"expireDate":null,"file":null,"body":null,"userId":null,"status":false,"category":"01","absolutePath":"E:\\xampp\\htdocs\\darkish\\src\\Darkish\\CategoryBundle\\Entity\/..\/..\/..\/..\/web\/uploads\/documents\/8f442eab6c216a5dd9f9a7a06a2537013e215eb3.txt","webPath":"uploads\/documents\/8f442eab6c216a5dd9f9a7a06a2537013e215eb3.txt","title":"sada sda","path":"8f442eab6c216a5dd9f9a7a06a2537013e215eb3.txt"},{"id":15,"createdDate":null,"expireDate":null,"file":null,"body":null,"userId":null,"status":false,"category":"01","absolutePath":"E:\\xampp\\htdocs\\darkish\\src\\Darkish\\CategoryBundle\\Entity\/..\/..\/..\/..\/web\/uploads\/documents\/df0210fead4a3a741042a3bcec1ded299f3a09db.docx","webPath":"uploads\/documents\/df0210fead4a3a741042a3bcec1ded299f3a09db.docx","title":"asdsd asd","path":"df0210fead4a3a741042a3bcec1ded299f3a09db.docx"},{"id":16,"createdDate":null,"expireDate":null,"file":null,"body":"<p>sd sadsad <strong>asd <\/strong>asd&nbsp;<\/p>","userId":1,"status":false,"category":"01","absolutePath":"E:\\xampp\\htdocs\\darkish\\src\\Darkish\\CategoryBundle\\Entity\/..\/..\/..\/..\/web\/uploads\/documents\/45de77ce30f04721bb9e6e316dc0a282cfa32a62.txt","webPath":"uploads\/documents\/45de77ce30f04721bb9e6e316dc0a282cfa32a62.txt","title":"asda das","path":"45de77ce30f04721bb9e6e316dc0a282cfa32a62.txt"},{"id":17,"createdDate":null,"expireDate":null,"file":null,"body":null,"userId":1,"status":false,"category":"01","absolutePath":"E:\\xampp\\htdocs\\darkish\\src\\Darkish\\CategoryBundle\\Entity\/..\/..\/..\/..\/web\/uploads\/documents\/e525fe51578aa00172a618dcdb79177eb2838754.txt","webPath":"uploads\/documents\/e525fe51578aa00172a618dcdb79177eb2838754.txt","title":"sad asdsadas","path":"e525fe51578aa00172a618dcdb79177eb2838754.txt"},{"id":18,"createdDate":null,"expireDate":null,"file":null,"body":"<p>as das dsad asd asd<\/p>","userId":1,"status":false,"category":"01","absolutePath":"E:\\xampp\\htdocs\\darkish\\src\\Darkish\\CategoryBundle\\Entity\/..\/..\/..\/..\/web\/uploads\/documents\/b4da36a9d8d5a77177db794d602efd8203e7c2dd.txt","webPath":"uploads\/documents\/b4da36a9d8d5a77177db794d602efd8203e7c2dd.txt","title":"sd asd ad","path":"b4da36a9d8d5a77177db794d602efd8203e7c2dd.txt"}];

        $scope.info = {};

        $scope.toggleMultiSelect = function() {
            $scope.gridApi.selection.setMultiSelect(!$scope.gridApi.grid.options.multiSelect);
        };

        $scope.selectAll = function() {
            $scope.gridApi.selection.selectAllRows();
        };

        $scope.clearAll = function() {
            $scope.gridApi.selection.clearSelectedRows();

        };

        $scope.toggleRow1 = function() {
            $scope.gridApi.selection.toggleRowSelection($scope.classifiedGridOptions.data[0]);
        };

        $scope.classifiedGridOptions.onRegisterApi = function(gridApi){
            //set gridApi on scope
            $scope.gridApi = gridApi;

            gridApi.selection.on.rowSelectionChanged($scope,function(row){
                var msg = 'row selected ' + row.isSelected;
                $scope.classified.title = row.entity.title;
                $scope.classified.body = row.entity.body;
                $scope.classified.id = (row.entity.id) ? row.entity.id : null;
                $scope.classified.categoryObj = $scope.FindByIdInTree(row.entity.classifiedtreeId);
                $scope.classified.expireDate = row.entity.expireDate;
                $scope.classified.publishDate = row.entity.publishDate;
                $scope.classified.status = row.entity.status;
                $scope.classified.firstPhone = row.entity.firstPhone;
                $scope.classified.secondPhone = row.entity.secondPhone;
                $scope.classified.email = row.entity.email;
                $scope.classified.unitNumber = row.entity.unitNumber;


            });
        };

        $scope.searchInTree = function(id){

        };
        


        $scope.currentClassified = {};

        $scope.saveCurrentClassified = function() {
            console.log($scope.classifiedform);
            if($scope.classified.id){
                alert("saveClassified");
                ClassifiedControl.saveClassified($scope.classified).success(function(data){
                    console.log(data);
                    $scope.editing = false;
                    $scope.mainTreeHide = false;
                    $scope.classifiedGridHide = false;
                    if($scope.classified.categoryObj == null) {
                        console.log('vujud nadarad');
                        $scope.showSelected($scope.FindByIdInTree(-2));
                    } else {
                        console.log("vujud darad");
                        $scope.showSelected($scope.FindByIdInTree($scope.classified.categoryObj.id));
                    }
                });
            } else {
                alert("createClassified");
                ClassifiedControl.createClassified($scope.classified).success(function(data){
                    $scope.classifiedGridOptions.data.push(data);
                    console.log($scope.classifiedGridOptions.data[$scope.classifiedGridOptions.data.length-1]);
                    $scope.editing = false;
                    $scope.mainTreeHide = false;
                    $scope.classifiedGridHide = false;
                    if($scope.classified.categoryObj == null) {
                        console.log('vujud nadarad');
                        $scope.showSelected($scope.FindByIdInTree(-2));
                    } else {
                        console.log("vujud darad");
                        $scope.showSelected($scope.FindByIdInTree($scope.classified.categoryObj.id));
                    }
                });
            }

        };


            $scope.deleteCurrentClassified = function() {
                if($scope.classified.id){
                    ClassifiedControl.delete($scope.classified).success(function(data){
                        $scope.showSelected($scope.selected);

                    });
                }
            };

        $scope.approveCurrentClassified = function() {
            if($scope.classified.id){
                alert("saveClassified");
                ClassifiedControl.approve($scope.classified).success(function(data){
                    $indexOfThis = -1;
                    $scope.classifiedGridOptions.data.every(function(element, index, array){
                        if(element.id == data.id) {
                            $indexOfThis = element.id;
                            element.status = data.status;
                            $scope.classified.status = data.status;
                            return false;
                        }
                        return true;

                    });

                });
            }
        };





        $scope.showFiles = function() {
            console.log($scope.upload);
            console.log($upload);
        }

        $scope.onFileSelect = function($files) {
            console.log($files[0]);
            $scope.selectedImage = $files[0];
            var reader = new FileReader();
            reader.readAsDataURL($scope.selectedImage);
            reader.onload = function (e) {
                $scope.dataUrl = e.target.result;
            }

            //$files: an array of files selected, each file has name, size, and type.
            /*for (var i = 0; i < $files.length; i++) {
                var file = $files[i];
                $scope.upload = $upload.upload({
                    url: 'server/upload/url', //upload.php script, node.js route, or servlet url
                    //method: 'POST' or 'PUT',
                    //headers: {'header-key': 'header-value'},
                    //withCredentials: true,
                    data: {myObj: $scope.myModelObj},
                    file: file, // or list of files ($files) for html5 only
                    //fileName: 'doc.jpg' or ['1.jpg', '2.jpg', ...] // to modify the name of the file(s)
                    // customize file formData name ('Content-Disposition'), server side file variable name.
                    //fileFormDataName: myFile, //or a list of names for multiple files (html5). Default is 'file'
                    // customize how data is added to formData. See #40#issuecomment-28612000 for sample code
                    //formDataAppender: function(formData, key, val){}
                }).progress(function(evt) {
                    console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
                }).success(function(data, status, headers, config) {
                    // file is uploaded successfully
                    console.log(data);
                });
                //.error(...)
                //.then(success, error, progress);
                // access or attach event listeners to the underlying XMLHttpRequest.
                //.xhr(function(xhr){xhr.upload.addEventListener(...)})
            }
            /* alternative way of uploading, send the file binary with the file's content-type.
             Could be used to upload files to CouchDB, imgur, etc... html5 FileReader is needed.
             It could also be used to monitor the progress of a normal http post/put request with large data*/
            // $scope.upload = $upload.http({...})  see 88#issuecomment-31366487 for sample code.
        };
        

        ///////  Ckeditor config   ////////////

            $scope.imageBrowseUrl = '/browser/browse.php?type=Images&iid=';
            $scope.editorOptions = {
                language: 'en',
                height: '100px',
                contentsLangDirection: 'rtl',
                filebrowserImageBrowseUrl: '/browser/browse.php?type=Images&iid=',
                filebrowserImageUploadUrl: '/browser/browse.php?type=Images&iid=',
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






            function copy(o) {
                var copy = Object.create(Object.getPrototypeOf(o));
                var propNames = Object.getOwnPropertyNames(o);

                propNames.forEach(function(name) {
                    var desc = Object.getOwnPropertyDescriptor(o, name);
                    Object.defineProperty(copy, name, desc);
                });

                return copy;
            }



        }]);