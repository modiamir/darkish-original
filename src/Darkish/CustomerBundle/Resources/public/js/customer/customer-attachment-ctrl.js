


customerApp.controller('AttachmentsCtrl', ['$scope', 'recordData', 'FileUploader', '$sce', '$http', 'SweetAlert', 'ngDialog', 
	function($scope, recordData, FileUploader, $sce, $http, SweetAlert, ngDialog){
	$scope.currentTab = 'image';
	$scope.recordData = recordData;
	$scope.bodyMode = 'edit';
	CKEDITOR.env.isCompatible = true;
	
	$scope.currentMedias = function() {
		switch($scope.currentTab) {
			case 'image':
				return recordData.images;
			case 'video':
				return recordData.videos;
		}
	}

	$scope.getMediaTemplate = function() {
		switch($scope.currentTab) {
			case 'image':
				return 'image-list-item.html';
			case 'video':
				return 'video-list-item.html';
		}	
	}


	$scope.removeFromList = function(media, index) {
		switch($scope.currentTab) {
			case 'image':
			    recordData.images.splice(index, 1);
				break;
			case 'video':
				recordData.videos.splice(index, 1);
				break;
			
		}		

	}

	


	$scope.saveAttachment = function() {
		$http({
			method: 'POST',
			url: 'customer/ajax/attachment/save',
			headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
			data: $.param({
				_method: 'POST', 
				images : $scope.recordData.images,
				videos : $scope.recordData.videos
			})
		}).then(function(response){
			$scope.recordData.images = response.data.images;
			$scope.recordData.videos = response.data.videos;
			SweetAlert.swal({
			  title: "ذخیره انجام شد.",
			  type: "success"
			});
		});
	}


    //////////////


    /**
     * 
     * uploader
     */

    var uploader = $scope.uploader = new FileUploader({
        url: './customer/ajax/upload'
    });
    uploader.withCredentials = true;
    uploader.queueLimit =1;
    uploader.autoUpload = true;
    uploader.removeAfterUpload = true;
    uploader.msg = "";
    uploader.formData.push({type : 'record', uploadDir: 'image'});
    $scope.fileTitle = "";
    $scope.$watch('fileTitle', function(newValue, oldValue, scope) {
    	uploader.formData[0].title = $scope.fileTitle;
    });

    // FILTERS
        

    uploader.filters.push({
          name: 'fileLimits',
          fn: function(item, photo) {
          		switch($scope.currentTab) {
          			case 'image':
          				var filecount = (($scope.recordData.images) ? $scope.recordData.images.length : 0) + uploader.queue.length;
          				if( filecount >= $scope.recordData.access_class.attachment_images_limit) {
          				  return false;
          				}
          				break;
      				case 'video':
      					var filecount = (($scope.recordData.videos) ? $scope.recordData.videos.length : 0) + uploader.queue.length;
      					if( filecount >= $scope.recordData.access_class.attachment_videos_limit) {
      					  return false;
      					}
          				break;
          		}
              
              	return true;
      	}
  	});

    uploader.filters.push({
        name: 'imageTypeFilter',
        fn: function(item /*{File|FileLikeObject}*/, options) {
            if($scope.currentTab == 'image') {
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
            if($scope.currentTab == 'video') {
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
            if($scope.currentTab == 'audio') {
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
        console.info('UPLOADEROBJ',uploader);
        
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
                recordData.images.unshift(response)
                break;
            case 'video':
            	recordData.videos.unshift(response)
                break;

        }
        uploader.msg = 'فایل با موفقیت بارگزاری شد.';
    };
    uploader.onCompleteAll = function() {
        console.info('onCompleteAll');
        $scope.fileTitle = "";
    };


    $scope.selectTab = function(tab) {
		$scope.currentTab = tab;
		uploader.formData[0].uploadDir = $scope.currentTab;
	}

	$scope.disableUpload = function() {
		switch($scope.currentTab) {
			case 'image':
				if(recordData.images.length >= recordData.access_class.attachment_images_limit)
					return true;
				break;
			case 'video':
				if(recordData.videos.length >= recordData.access_class.attachment_videos_limit)
					return true;
				break;


		}
		return false;
	}

	$scope.remaining = function() {
		switch($scope.currentTab) {
			case 'image':
				return recordData.access_class.attachment_images_limit - recordData.images.length;
				break;
			case 'video':
				return recordData.access_class.attachment_videos_limit - recordData.videos.length;
				break;

		}
	}

	$scope.uploadable = function() {
		switch($scope.currentTab) {
			case 'image':
				return recordData.access_class.attachment_images_limit;
				break;
			case 'video':
				return recordData.access_class.attachment_videos_limit;
				break;

		}
	}

	



}])

