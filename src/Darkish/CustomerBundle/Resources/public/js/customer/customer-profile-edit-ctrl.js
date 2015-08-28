customerApp.controller('ProfileEditCtrl', ['$scope', '$http', '$state','SweetAlert', 'FileUploader', function($scope, $http, $state, SweetAlert, FileUploader){
    $http.get('customer/get_user').then(function(response){
        $scope.editinguser = response.data;
    });

    /**
     * Cropper
     *
     */
    $scope.myImage='';
    $scope.myCroppedImage='';

    $scope.logFile = function() {


        //console.info('myImage', $scope.myImage);
        //console.info('myCroppedImage', $scope.myCroppedImage);

        $http({
            method: 'POST',
            url: './customer/ajax/upload',
            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
            data: $.param({_method: 'POST', base64: $scope.myCroppedImage,type: 'customer',uploadDir:'image' })
        }).then(function(response){
            $scope.editinguser.photo = response.data;
            uploader.msg = 'فایل با موفقیت بارگزاری شد.';
            $scope.myImage = "";
            $scope.uploading = false;
        }, function(responseErr){})

        //console.info('blob', b);
    }


    $scope.onChangeCrop = function() {
        if($scope.myImage == "" ) {
            $scope.uploading = false;
        } else {
            $scope.uploading = true;
        }
    }
    var handleFileSelect=function(evt) {
        var file=evt.currentTarget.files[0];
        var reader = new FileReader();
        reader.onload = function (evt) {
            $scope.$apply(function($scope){
                $scope.myImage=evt.target.result;
            });
        };
        reader.readAsDataURL(file);
    };
    angular.element(document.querySelector('#fileInput')).on('change',handleFileSelect);


    /* Cropper End */

    $scope.isUnchanged = function(user) {
        return angular.equals(user, $scope.user);
    };

    $scope.saveProfile = function(user) {
        var data = humps.camelizeKeys(user);
        if(user.photo) {
            data.photo = user.photo.id;
        }
        delete data.record;
        delete data.isActive;
        delete data.id;
        delete data.created;
        delete data.newPasswordConfirm;
        delete data.roles;
        delete data.type;
        delete data.username;
        delete data.assistantAccess;
        delete data.password_confirm;

        if(data.password) {
            data.newPassword = data.password;
            delete data.password;
            delete data.passwordConfirm;
        }

        $http({
            method: 'POST',
            url: './customer/ajax/update/'+user.id,
            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
            data: $.param({_method: 'POST', customer_edit_profile: data})
        }).then(
            function(response){
                var editeduser = response.data;
                angular.forEach(editeduser, function(value, key){
                    $scope.user[key] = value;
                });
                SweetAlert.swal(
                    {
                        title: "ویرایش انجام شد.",
                        text: "شما به صفحه پروفایل منتقل خواهید شد.",
                        type: "success"
                    },
                    function(){
                        $state.go('profile')
                    }
                );

            },
            function(responseErr){
                SweetAlert.swal(
                    {
                        title: "ویرایش با خطا مواجه شد",
                        text: responseErr.data.message,
                        type: "warning"
                    }
                );
            }
        );
    }

    /**
     *
     * uploader
     */

    var uploader = $scope.uploader = new FileUploader({
        url: './customer/ajax/upload'
    });
    uploader.withCredentials = true;
    uploader.queueLimit =1 ;
    uploader.autoUpload = false;
    uploader.removeAfterUpload = true;
    uploader.formData.push({uploadDir : 'image'});
    uploader.formData.push({continual : true});
    uploader.formData.push({type : 'customer'});
    uploader.msg = "";

    // FILTERS

    uploader.filters.push({
        name: 'imageTypeFilter',
        fn: function(item /*{File|FileLikeObject}*/, options) {
            uploadableType = "image";
            uploadableExtensions = ["jpg", "jpeg", "png", "bmp"];
            fileType = item.type.split("/")[0];
            fileExtension = item.type.split("/")[1];
            if(fileType != uploadableType || uploadableExtensions.indexOf(fileExtension) == -1) {
                return false;
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
        $scope.editinguser.photo = response;
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

}])
