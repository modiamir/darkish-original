//var newsIndexCtrl = angular.module('newsIndexCtrl', ['treeControl', 'angularFileUpload']);
var offerIndexCtrl = angular.module('offerIndexCtrl', ['treeControl', 'angularFileUpload']);

    // inject the Comment service into our controller
//newsIndexCtrl.controller('NewsIndexController', ['$modal','$scope','$http', '$upload', '$interval', 'NewsTree','NewsControl',    
offerIndexCtrl.controller('OfferIndexController', ['$modal','$scope','$http', '$upload', '$interval', 'OfferTree','OfferControl',
        function($modal, $scope, $http, $upload, $interval, OfferTree, OfferControl) {
        // object to hold all the data for the new comment form

        $scope.mainTreeHide = false;
        $scope.offerGridHide = false;
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

        $scope.dataForTheOfferTree = [];
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


        OfferTree.get()
            .success(function(data) {
                data.forEach(function(element, index, array){
                    $scope.dataForTheTree.push(element);
                });
                $scope.dataForTheOfferTree = data;
                $scope.showSelected($scope.dataForTheTree[0]);
            });

        $scope.newOfferAction = function() {
            $scope.previousOffer = $scope.offer;
            $scope.offer = {
                id: "",
                title: "",
                createdDate: "",
                publishDate: "",
                expireDate: "",
                body: "",
                userId: "",
                status: "",
                category: "",
                offertreeId: '',
                firstPhone: "",
                secondPhone: "",
                email: "",
                unitNumber: "",
                firstImage: "",
                secondImage: "",
                thirdImage: "",
                banner: ""

            };
            console.log($scope.previousOffer);
            console.log($scope.offer);
            $scope.editing = true;
            $scope.mainTreeHide = true;
            $scope.offerGridHide = true;
        };


        $scope.cancelOfferAction = function() {
            console.log($scope.previousOffer);
            $scope.offer = $scope.previousOffer;
            $scope.previousOffer = {
                id: "",
                title: "",
                createdDate: "",
                publishDate: "",
                expireDate: "",
                body: "",
                userId: "",
                status: "",
                category: "",
                offertreeId: '',
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
            $scope.offerGridHide = false;
        };

        $scope.editOfferAction = function() {
            $scope.previousOffer = copy($scope.offer);

            $scope.editing = true;
            $scope.mainTreeHide = true;
            $scope.offerGridHide = true;
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


        $scope.selectTreeForCurrentOffer = function(node) {

            $scope.offer.categoryObj = node;
            $scope.offer.category = node.treeIndex;
            $scope.offer.offertreeId = node.id;
            console.log("inja");
            console.log(node);


        }

        $scope.open = function () {

            $scope.modalInstance = $modal.open({
                templateUrl: 'myModalContent.html',
                size: 'lg',
                scope: $scope
            });
            $scope.modalInstance.lastCat = $scope.offer.categoryObj;

            $scope.modalInstance.result.then(function (selectedItem) {
                console.log(selectedItem);
            }, function (lastCat) {
                $scope.offer.categoryObj = lastCat;
            });
        };



        $scope.ok = function () {
            $scope.modalInstance.close($scope.currentOfferTree);
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
                $scope.deleteCurrentOffer();
            }, function (lastCat) {

            });
        };

        $scope.okDeleteModal = function() {
            $scope.modalInstance.close();
        }

        $scope.cancelDeleteModal = function() {
            $scope.modalInstance.dismiss();
        }

        $scope.offer = {
            id: "",
            title: "",
            createdDate: "",
            publishDate: "",
            expireDate: "",
            body: "",
            userId: "",
            status: "",
            category: "",
            offertreeId: '',
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

        $scope.previousOffer = {
            id: "",
            title: "",
            createdDate: "",
            publishDate: "",
            expireDate: "",
            body: "",
            userId: "",
            status: "",
            category: "",
            offertreeId: '',
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


        $scope.offerForm = {
            templates: [
                {name:'خبر عادی', value: 0},
                {name:'مسابقه', value: 1},
                {name:'ویدئو', value: 2},
                {name:'پادکست', value: 3}

            ]

        };
        $scope.template = $scope.offerForm.templates[0];




        $scope.testFunction = function() {
            //console.log($scope.offerGridOptions.data[$scope.offerGridOptions.data.length-1]);
            //$scope.gridApi.selection.selectRow($scope.offerGridOptions.data[$scope.offerGridOptions.data.length-1]);

            $indexOfThis = -1;
            $scope.offerGridOptions.data.every(function(element, index, array){
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

            OfferControl.getForCategory(sel.id, page).success(function(data){
                $scope.offerGridOptions.data = data;

                $interval( function() {$scope.gridApi.selection.selectRow($scope.offerGridOptions.data[0]);}, 0, 1);
            });



            $http.get('ajax/generate_csrf/create_offer').success(function(data){
                $scope._token = data;
            });

            OfferControl.getTotalPages(sel.id).success(function(data){
                $scope.offerGridOptions.totalPages = data;
            });
        };

        /*$scope.offerGridOptions = { enableRowSelection: true, enableRowHeaderSelection: false };
        $scope.offerGridOptions = { multiSelect: false };
        $scope.offerGridOptions.modifierKeysToMultiSelect = false;
        $scope.offerGridOptions.noUnselect = true;
        */

            $scope.offerGridOptions = { enableRowSelection: true, enableRowHeaderSelection: false };



            $scope.offerGridOptions.multiSelect = false;
            $scope.offerGridOptions.modifierKeysToMultiSelect = false;
            $scope.offerGridOptions.noUnselect = true;
            $scope.offerGridOptions.page = 1;
            $scope.offerGridOptions.nextPage = function() {
                if($scope.offerGridOptions.page < $scope.offerGridOptions.totalPages) {
                    $scope.offerGridOptions.page = $scope.offerGridOptions.page + 1;
                    $scope.showSelected($scope.selected, $scope.offerGridOptions.page);
                }
            };

            $scope.offerGridOptions.previousPage = function() {
                if($scope.offerGridOptions.page > 1) {
                    $scope.offerGridOptions.page = $scope.offerGridOptions.page - 1;
                    $scope.showSelected($scope.selected, $scope.offerGridOptions.page);
                }
            };
            $scope.offerGridOptions.totalPages = "";

        $scope.offerGridOptions.columnDefs = [
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





        //$scope.offerGridOptions.data =[{"id":13,"createdDate":null,"expireDate":null,"file":null,"body":null,"userId":null,"status":false,"category":"01","absolutePath":"E:\\xampp\\htdocs\\darkish\\src\\Darkish\\CategoryBundle\\Entity\/..\/..\/..\/..\/web\/uploads\/documents\/13289bb6825fa1e4c53a3221d50a26e5675b871a.txt","webPath":"uploads\/documents\/13289bb6825fa1e4c53a3221d50a26e5675b871a.txt","title":"sd sdsad sad","path":"13289bb6825fa1e4c53a3221d50a26e5675b871a.txt"},{"id":14,"createdDate":null,"expireDate":null,"file":null,"body":null,"userId":null,"status":false,"category":"01","absolutePath":"E:\\xampp\\htdocs\\darkish\\src\\Darkish\\CategoryBundle\\Entity\/..\/..\/..\/..\/web\/uploads\/documents\/8f442eab6c216a5dd9f9a7a06a2537013e215eb3.txt","webPath":"uploads\/documents\/8f442eab6c216a5dd9f9a7a06a2537013e215eb3.txt","title":"sada sda","path":"8f442eab6c216a5dd9f9a7a06a2537013e215eb3.txt"},{"id":15,"createdDate":null,"expireDate":null,"file":null,"body":null,"userId":null,"status":false,"category":"01","absolutePath":"E:\\xampp\\htdocs\\darkish\\src\\Darkish\\CategoryBundle\\Entity\/..\/..\/..\/..\/web\/uploads\/documents\/df0210fead4a3a741042a3bcec1ded299f3a09db.docx","webPath":"uploads\/documents\/df0210fead4a3a741042a3bcec1ded299f3a09db.docx","title":"asdsd asd","path":"df0210fead4a3a741042a3bcec1ded299f3a09db.docx"},{"id":16,"createdDate":null,"expireDate":null,"file":null,"body":"<p>sd sadsad <strong>asd <\/strong>asd&nbsp;<\/p>","userId":1,"status":false,"category":"01","absolutePath":"E:\\xampp\\htdocs\\darkish\\src\\Darkish\\CategoryBundle\\Entity\/..\/..\/..\/..\/web\/uploads\/documents\/45de77ce30f04721bb9e6e316dc0a282cfa32a62.txt","webPath":"uploads\/documents\/45de77ce30f04721bb9e6e316dc0a282cfa32a62.txt","title":"asda das","path":"45de77ce30f04721bb9e6e316dc0a282cfa32a62.txt"},{"id":17,"createdDate":null,"expireDate":null,"file":null,"body":null,"userId":1,"status":false,"category":"01","absolutePath":"E:\\xampp\\htdocs\\darkish\\src\\Darkish\\CategoryBundle\\Entity\/..\/..\/..\/..\/web\/uploads\/documents\/e525fe51578aa00172a618dcdb79177eb2838754.txt","webPath":"uploads\/documents\/e525fe51578aa00172a618dcdb79177eb2838754.txt","title":"sad asdsadas","path":"e525fe51578aa00172a618dcdb79177eb2838754.txt"},{"id":18,"createdDate":null,"expireDate":null,"file":null,"body":"<p>as das dsad asd asd<\/p>","userId":1,"status":false,"category":"01","absolutePath":"E:\\xampp\\htdocs\\darkish\\src\\Darkish\\CategoryBundle\\Entity\/..\/..\/..\/..\/web\/uploads\/documents\/b4da36a9d8d5a77177db794d602efd8203e7c2dd.txt","webPath":"uploads\/documents\/b4da36a9d8d5a77177db794d602efd8203e7c2dd.txt","title":"sd asd ad","path":"b4da36a9d8d5a77177db794d602efd8203e7c2dd.txt"}];

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
            $scope.gridApi.selection.toggleRowSelection($scope.offerGridOptions.data[0]);
        };

        $scope.offerGridOptions.onRegisterApi = function(gridApi){
            //set gridApi on scope
            $scope.gridApi = gridApi;

            gridApi.selection.on.rowSelectionChanged($scope,function(row){
                var msg = 'row selected ' + row.isSelected;
                $scope.offer.title = row.entity.title;
                $scope.offer.body = row.entity.body;
                $scope.offer.id = (row.entity.id) ? row.entity.id : null;
                $scope.offer.categoryObj = $scope.FindByIdInTree(row.entity.offertreeId);
                $scope.offer.expireDate = row.entity.expireDate;
                $scope.offer.publishDate = row.entity.publishDate;
                $scope.offer.status = row.entity.status;
                $scope.offer.firstPhone = row.entity.firstPhone;
                $scope.offer.secondPhone = row.entity.secondPhone;
                $scope.offer.email = row.entity.email;
                $scope.offer.unitNumber = row.entity.unitNumber;


            });
        };

        $scope.searchInTree = function(id){

        };
        


        $scope.currentOffer = {};

        $scope.saveCurrentOffer = function() {
            console.log($scope.offerform);
            if($scope.offer.id){
                alert("saveOffer");
                OfferControl.saveOffer($scope.offer).success(function(data){
                    console.log(data);
                    $scope.editing = false;
                    $scope.mainTreeHide = false;
                    $scope.offerGridHide = false;
                    if($scope.offer.categoryObj == null) {
                        console.log('vujud nadarad');
                        $scope.showSelected($scope.FindByIdInTree(-2));
                    } else {
                        console.log("vujud darad");
                        $scope.showSelected($scope.FindByIdInTree($scope.offer.categoryObj.id));
                    }
                });
            } else {
                alert("createOffer");
                OfferControl.createOffer($scope.offer).success(function(data){
                    $scope.offerGridOptions.data.push(data);
                    console.log($scope.offerGridOptions.data[$scope.offerGridOptions.data.length-1]);
                    $scope.editing = false;
                    $scope.mainTreeHide = false;
                    $scope.offerGridHide = false;
                    if($scope.offer.categoryObj == null) {
                        console.log('vujud nadarad');
                        $scope.showSelected($scope.FindByIdInTree(-2));
                    } else {
                        console.log("vujud darad");
                        $scope.showSelected($scope.FindByIdInTree($scope.offer.categoryObj.id));
                    }
                });
            }

        };


            $scope.deleteCurrentOffer = function() {
                if($scope.offer.id){
                    OfferControl.delete($scope.offer).success(function(data){
                        $scope.showSelected($scope.selected);

                    });
                }
            };

        $scope.approveCurrentOffer = function() {
            if($scope.offer.id){
                alert("saveOffer");
                OfferControl.approve($scope.offer).success(function(data){
                    $indexOfThis = -1;
                    $scope.offerGridOptions.data.every(function(element, index, array){
                        if(element.id == data.id) {
                            $indexOfThis = element.id;
                            element.status = data.status;
                            $scope.offer.status = data.status;
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