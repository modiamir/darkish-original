
customerApp.controller('HtmlPageCtrl', ['$scope', 'recordData', 'FileUploader', '$sce', '$http', 'SweetAlert', 'ngDialog', 
	function($scope, recordData, FileUploader, $sce, $http, SweetAlert, ngDialog){
	$scope.currentTab = 'image';
	$scope.recordData = recordData;
	$scope.bodyMode = 'edit';
	CKEDITOR.env.isCompatible = true;
	
	$scope.currentMedias = function() {
		switch($scope.currentTab) {
			case 'image':
				return recordData.body_images;
			case 'video':
				return recordData.body_videos;
			case 'audio':
				return recordData.body_audios;
			case 'doc':
				return recordData.body_docs;
		}
	}

	$scope.getMediaTemplate = function() {
		switch($scope.currentTab) {
			case 'image':
				return 'image-list-item.html';
			case 'video':
				return 'video-list-item.html';
			case 'audio':
				return 'audio-list-item.html';
			case 'doc':
				return 'doc-list-item.html';
		}	
	}

	$scope.getTrustBody = function() {
		return $sce.trustAsHtml(recordData.body);
	}

	$scope.removeFromList = function(media, index) {
		switch($scope.currentTab) {
			case 'image':
				bodyDom = angular.element($scope.recordData.body);
				filesInEditor = bodyDom.find("."+media.file_name.replace('.','-'));
				if(filesInEditor.length > 0) {
				    alert("امکان حذف فایل "+"\n"+media.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
				}else {
					SweetAlert.swal({
							title: "آیا از حذف اطمینان دارید؟",
							text: "این عملیات قابل برگشت نیست!",
							type: "warning",
							showCancelButton: true,
							confirmButtonColor: "#DD6B55",
							confirmButtonText: "بله, حذف کن!",
							cancelButtonText: "انصراف",
							imageSize: "40x40",
							closeOnConfirm: true},
						function(){
							$timeout(function(){
								recordData.body_images.splice(index, 1);
							}, 50);


						});

				}
				
				break;
			case 'video':
				bodyDom = angular.element($scope.recordData.body);
				filesInEditor = bodyDom.find("."+media.file_name.replace('.','-'));
				if(filesInEditor.length > 0) {
				    alert("امکان حذف فایل "+"\n"+media.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
				}else {
					SweetAlert.swal({
							title: "آیا از حذف اطمینان دارید؟",
							text: "این عملیات قابل برگشت نیست!",
							type: "warning",
							showCancelButton: true,
							confirmButtonColor: "#DD6B55",
							confirmButtonText: "بله, حذف کن!",
							cancelButtonText: "انصراف",
							imageSize: "40x40",
							closeOnConfirm: true},
						function(){
							$timeout(function(){
								recordData.body_videos.splice(index, 1);
							}, 50);


						});

				}
				break;
			case 'audio':
				bodyDom = angular.element($scope.recordData.body);
				filesInEditor = bodyDom.find("."+media.file_name.replace('.','-'));
				if(filesInEditor.length > 0) {
				    alert("امکان حذف فایل "+"\n"+media.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
				}else {
					SweetAlert.swal({
							title: "آیا از حذف اطمینان دارید؟",
							text: "این عملیات قابل برگشت نیست!",
							type: "warning",
							showCancelButton: true,
							confirmButtonColor: "#DD6B55",
							confirmButtonText: "بله, حذف کن!",
							cancelButtonText: "انصراف",
							imageSize: "40x40",
							closeOnConfirm: true},
						function(){
							$timeout(function(){
								recordData.body_audios.splice(index, 1);
							}, 50);


						});

				}
				break;
			case 'doc':
				bodyDom = angular.element($scope.recordData.body);
				filesInEditor = bodyDom.find("."+media.file_name.replace('.','-'));
				if(filesInEditor.length > 0) {
				    alert("امکان حذف فایل "+"\n"+media.file_name+"\n"+"وجود ندارد. برای حذف ابتدا این فایل را از ویرایشگر حذف نمایید");
				}else {
					SweetAlert.swal({
							title: "آیا از حذف اطمینان دارید؟",
							text: "این عملیات قابل برگشت نیست!",
							type: "warning",
							showCancelButton: true,
							confirmButtonColor: "#DD6B55",
							confirmButtonText: "بله, حذف کن!",
							cancelButtonText: "انصراف",
							imageSize: "40x40",
							closeOnConfirm: true},
						function(){
							$timeout(function(){
								recordData.body_docs.splice(index, 1);
							}, 50);


						});

				}
				break;
		}		

	}

	$scope.insertIntoBody = function(media) {
		var CkInstance = null;
		angular.forEach(CKEDITOR.instances,function(value, key){CkInstance = value; keepGoing = false;})
		
		switch($scope.currentTab) {
		    case 'image':
		        var fileClass = media.file_name.replace(".", "-");
		        CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;"><img class="'+fileClass+'"  alt="" style="width:200px;" src="'+media.absolute_path+'" /></p>');
		        break;
		    case 'video':
		        var fileClass = media.file_name.replace(".", "-");
		        CkInstance.insertHtml('<p class="'+fileClass+'"  style="text-align:center;" ><dk-video class="'+fileClass+'"  controls="" name="media" width="300" src="'+media.absolute_path+'" type="'+media.filemime+'"></dk-video></p>');

		        break;
		    case 'audio':
		        var fileClass = media.file_name.replace(".", "-");
		        CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;" ><dk-audio class="'+fileClass+'"  controls="" name="media" width="300" src="'+media.absolute_path+'" type="'+media.filemime+'"></dk-audio></p>');

		        break;
		        
		    case 'doc':
		        var text = prompt("لطفا متن مربوط به لینک دانلود فایل را وارد نمایید. در غیر این صورت نام فایل به عنوان متن در نظر گرفته می شود.");
		        text = (text)?text:media.file_name;
		        var fileClass = media.file_name.replace(".", "-");
		        CkInstance.insertHtml('<p class="'+fileClass+'" style="text-align:center;" ><a class="body web-link '+fileClass+'" href="'+media.absolute_path+'"  > '+text+'  </a></p>');
		        break;

		}
	}


	$scope.saveHtml = function() {
		$http({
			method: 'POST',
			url: 'customer/ajax/html/save',
			headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
			data: $.param({
				_method: 'POST', 
				body: $scope.recordData.body,
				body_images : $scope.recordData.body_images,
				body_videos : $scope.recordData.body_videos,
				body_audios : $scope.recordData.body_audios,
				body_docs : $scope.recordData.body_docs,
			})
		}).then(function(response){
			$scope.recordData.body = response.data.body;
			$scope.recordData.body_images = response.data.body_images;
			$scope.recordData.body_videos = response.data.body_videos;
			$scope.recordData.body_audios = response.data.body_audios;
			$scope.recordData.body_docs = response.data.body_docs;
			SweetAlert.swal({
			  title: "ذخیره انجام شد.",
			  type: "success"
			});
		});
	}


		

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
        contentsCss : 'assets/css/ckeditor-body.css',
        smiley_path: CKEDITOR.basePath+'plugins/smiley/images/darkish/',
        smiley_images: ['(smiley).png','(sad).png','(wink).png','(angry).png','(yummi).png','(laugh).png','(surprised).png','(happy).png','(cry).png','(sick).png','(shy).png','(teeth).png','(tongue).png','(money).png','(mad).png','(crazy).png','(confused).png','(depressed).png','(scream).png','(nerd).png','(not_sure).png','(cool).png','(sleeping).png','(Q).png','(!).png','($).png','(burger).png','(coffee).png','(cupcake).png','(airplane).png','(car).png','(cloud).png','(rain).png','(sun).png','(flower).png','(music).png','(fire).png','(koala).png','(ladybug).png','(relax).png','(basketball).png','(soccer).png','(baseball).png','(time).png','(bicycle).png','(clap).png','(run).png','(light_bulb).png'],
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
          				var filecount = (($scope.recordData.body_images) ? $scope.recordData.body_images.length : 0) + uploader.queue.length;
          				if( filecount >= $scope.recordData.access_class.body_images_limit) {
          				  return false;
          				}
          				break;
      				case 'video':
      					var filecount = (($scope.recordData.body_videos) ? $scope.recordData.body_videos.length : 0) + uploader.queue.length;
      					if( filecount >= $scope.recordData.access_class.body_videos_limit) {
      					  return false;
      					}
          				break;
      				case 'audio':
      					var filecount = (($scope.recordData.body_audios) ? $scope.recordData.body_audios.length : 0) + uploader.queue.length;
      					if( filecount >= $scope.recordData.access_class.body_audios_limit) {
      					  return false;
      					}
          				break;
      				case 'doc':
      					var filecount = (($scope.recordData.body_docs) ? $scope.recordData.body_docs.length : 0) + uploader.queue.length;
      					if( filecount >= $scope.recordData.access_class.body_docs_limit) {
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
                recordData.body_images.unshift(response)
                break;
            case 'video':
            	recordData.body_videos.unshift(response)
                break;
            case 'audio':
                recordData.body_audios.unshift(response)
                break;
            case 'doc':
                recordData.body_docs.unshift(response)
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
				if(recordData.body_images.length >= recordData.access_class.body_images_limit)
					return true;
				break;
			case 'video':
				if(recordData.body_videos.length >= recordData.access_class.body_videos_limit)
					return true;
				break;
			case 'audio':
				if(recordData.body_audios.length >= recordData.access_class.body_audios_limit)
					return true;
				break;
			case 'doc':
				if(recordData.body_docs.length >= recordData.access_class.body_docs_limit)
					return true;
				break;

		}
		return false;
	}

	$scope.remaining = function() {
		switch($scope.currentTab) {
			case 'image':
				return recordData.access_class.body_images_limit - recordData.body_images.length;
				break;
			case 'video':
				return recordData.access_class.body_videos_limit - recordData.body_videos.length;
				break;
			case 'audio':
				return recordData.access_class.body_audios_limit - recordData.body_audios.length;
				break;
			case 'doc':
				return recordData.access_class.body_docs_limit - recordData.body_docs.length;
				break;

		}
	}

	$scope.uploadable = function() {
		switch($scope.currentTab) {
			case 'image':
				return recordData.access_class.body_images_limit;
				break;
			case 'video':
				return recordData.access_class.body_videos_limit;
				break;
			case 'audio':
				return recordData.access_class.body_audios_limit;
				break;
			case 'doc':
				return recordData.access_class.body_docs_limit;
				break;

		}
	}



	$scope.openBodyVideoModal = function (size, video) {

		$scope.openVideoModal([{absolute_path: video}],0);
	};

	$scope.openBodyAudioModal = function (size, audio) {

		$scope.openVideoModal([{absolute_path: audio}],0);
	};


}])

