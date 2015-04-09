

customerApp.controller('StoreCtrl', ['$scope', '$state', 'storeData', 'FileUploader', 
  function($scope, $state, storeData, FileUploader){
	$scope.store = "mrzsss";
	$scope.state = $state;

	$scope.storeData = storeData;
	$scope.log = function(item) {
		console.log(item);
	}

    

}])

customerApp.controller('StoreProductEditCtrl', ['$scope', function($scope){
  $scope.edit = "edit product";
}])

customerApp.controller('StoreEditCtrl', ['$scope', 'FileUploader', '$http', '$filter', 'SweetAlert', '$state', 
	function($scope, FileUploader, $http, $filter, SweetAlert, $state){
  $scope.store = angular.copy($scope.storeData);

  $scope.templates = [];
  $http.get("./customer/ajax/get_templates").then(
	function(response){
		$scope.templates = response.data;
		$scope.store.market_template = $filter('filter')($scope.templates, {id: $scope.store.market_template.id})[0];
	},
	function(responseErr){}
  )


  $scope.saveStoreDetails = function() {
  	$http({
  		method: 'POST',
  		url: './customer/ajax/save_store_details',
  		headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
  		data: $.param({
  			_method: 'POST', 
  			description: $scope.store.market_description,
  			groups: $scope.store.market_groups,
  			banner: $scope.store.market_banner,
  			template: $scope.store.market_template
  		})
  	}).then(
  		function(response){
  			$scope.storeData.market_description = $scope.store.market_description;
  			$scope.storeData.market_banner = $scope.store.market_banner;
  			SweetAlert.swal({
  				title: "ذخیره انجام شد.",
  				text: "",
  				type: "success"
  			}, function() {
  				$state.go("store");
  			}); 
  		}, 
  		function(responseErr){}
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
  uploader.autoUpload = true;
  uploader.removeAfterUpload = true;
  uploader.formData.push({uploadDir : 'image'});
  uploader.formData.push({continual : true});
  uploader.formData.push({type : 'store'});
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
      $scope.store.market_banner = response;
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

customerApp.controller('StoreCreateCtrl', ['$scope', function($scope){
  $scope.edit = "create";
}])