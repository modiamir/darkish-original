

customerApp.controller('DatabaseCtrl', ['$scope', '$state', 'databaseData', 'FileUploader', '$window', '$http', 'SweetAlert',
										'estateTypes', 'contractTypes', 'estateFeatures',  'automobileTypes', 'automobileBrands', 'automobileFeatures', 'automobileColors',
  function($scope, $state, databaseData, FileUploader, $window, $http, SweetAlert, estateTypes, contractTypes, estateFeatures, automobileTypes, automobileBrands, automobileFeatures, automobileColors){


	

	$scope.state = $state;
	
	$scope.editmode = false;
  
  	$scope.scp = 'DatabaseCtrl';
	$scope.databaseData = databaseData;

	$scope.estateTypes = estateTypes;

	$scope.contractTypes = contractTypes;

	$scope.estateFeatures = estateFeatures;

	$scope.automobileTypes = automobileTypes;

	$scope.automobileBrands = automobileBrands;

	$scope.automobileFeatures = automobileFeatures;

	$scope.automobileColors = automobileColors;

  	$scope.items = []

  	$http.post('customer/ajax/database/search').then(
	    function(response){
	      $scope.items = response.data[0];
	    }, 
	    function(responseErr){

	    }
    );


	$scope.log = function(item) {
		console.log(item);

	}


	$scope.isCollapsed = true;


  	$scope.deleteItem = function(item) {
	    var index = $scope.items.indexOf(item);
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
	      $http({
	        method: 'DELETE',
	        url: './customer/ajax/database/delete/'+item.id,
	        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
	        data: $.param({_method: 'DELETE'})
	      }).then(function(response){
	        $scope.items.splice(index, 1);
	      }, function(responseErr){
	        SweetAlert.swal({
	          title: "حذف انجام نشد.",
	          type: "success"
	        });
	      });

	       
	    });
    
    
  	}



  	$scope.searchCriteria = {}

  	$scope.search = function(lowestId) {

  		var searchData = angular.copy($scope.searchCriteria);
  		
  		searchData._method = "POST";

  		if(searchData.estate_contract_type == 2 && searchData.estate_price) {
  			delete searchData.estate_price;
  		}

  		if(lowestId) {
  			searchData.lowest_id = lowestId;
  		}

  		$http({
	        method: 'POST',
	        url: './customer/ajax/database/search',
	        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
	        data: $.param(searchData)
	      }).then(function(response){
	      	if(lowestId) {
	      		$scope.items = $scope.items.concat(response.data[0]);
	      	} else {
	      		$scope.items = response.data[0];
	      	}
	        $scope.loadingMore = false;
	      }, function(responseErr){
	        SweetAlert.swal({
	          title: "حذف انجام نشد.",
	          type: "success"
	        });
	        $scope.loadingMore = false;
	      });
  	}

  	$scope.clearSearchCriteria = function() {
  		$scope.searchCriteria = {}
  	}

  	$scope.searchMore = function() {
		var lowestId = $scope.items[$scope.items.length - 1].id;

		$scope.loadingMore = true;
  		$scope.search(lowestId);
  	}


  	$scope.loadingMore = false;


  	angular.element($('.master-inner')).bind('scroll',function()
  	{
  		if(	$(this).scrollTop() + $(this).innerHeight()>=$(this)[0].scrollHeight &&
  			!$scope.loadingMore
  			)
    	{	
    		$scope.searchMore();
    	}
  	})


  	$scope.updateOnScrollEvents = function(event, isEnd) {
  		if(isEnd) {
  			alert(isEnd);
  		}
  	}

  	$scope.finishEdit = function() {
	    $scope.editmode = false;
  	}


  	$scope.selectItem = function(item) {
  		$state.go('database.itemdetails', {iid: item.id});
  	}

  	$scope.dbType = function() {
  		return ($scope.user.record.dbase_type_index.id == 2) ? "automobile" : "estate";
  	}


  	

	$scope.ages = [];
	var d = new Date();
	var n = d.getFullYear();
	for (var i = n - 10; i <= n + 1; i++) {
		$scope.ages.push(i)
	};
  
	$scope.searchTemplate = function() {
    	switch($scope.user.record.dbase_type_index.id) {
    		case 1: return "customer/template/estate-search.html"
    		case 2: return "customer/template/automobile-search.html"
    	}
    }

    $scope.createTemplate = function() {
    	switch($scope.user.record.dbase_type_index.id) {
    		case 1: return "customer/template/estate-create.html"
    		case 2: return "customer/template/automobile-create.html"
    	}
    }

    $scope.itemListTemplate = function() {
    	switch($scope.user.record.dbase_type_index.id) {
    		case 1: return "customer/template/estate-item-list.html"
    		case 2: return "customer/template/automobile-item-list.html"
    	}
    }

    $scope.itemDetailsTemplate = function() {
    	switch($scope.user.record.dbase_type_index.id) {
    		case 1: return "customer/template/estate-item-details.html"
    		case 2: return "customer/template/automobile-item-details.html"
    	}
    }

    $scope.itemEditTemplate = function() {
    	switch($scope.user.record.dbase_type_index.id) {
    		case 1: return "customer/template/estate-item-edit.html"
    		case 2: return "customer/template/automobile-item-edit.html"
    	}
    }



}])

customerApp.controller('DatabaseItemListCtrl', ['$scope', '$http', '$filter', 'SweetAlert' , function($scope, $http, $filter, SweetAlert){
	$scope.testtttt = "shahed";
}])

customerApp.controller('DatabaseItemDetailsCtrl', ['$scope', '$http', '$filter', 'SweetAlert', 'item' , function($scope, $http, $filter, SweetAlert, item){
	$scope.item = item;
	var tempFeatures = ($scope.dbType() == "estate") ? angular.copy($scope.item.estate_features) : angular.copy($scope.item.automobile_features);
    if($scope.dbType() == "estate") {
    	$scope.item.estate_features = {}
    	if($scope.item.estate_type) {
    		$scope.item.estate_type = $filter('filter')($scope.estateTypes, {id: $scope.item.estate_type.id})[0];
    	}
    	if($scope.item.contract_type) {
    		$scope.item.contract_type = $filter('filter')($scope.contractTypes, {id: $scope.item.contract_type.id})[0];
    	}
    } else {
    	$scope.item.automobile_features = {}
    	if($scope.item.automobile_brand) {
    		$scope.item.automobile_brand = $filter('filter')($scope.automobileBrands, {id: $scope.item.automobile_brand.id})[0];
    	}
    	if($scope.item.automobile_type) {
    		$scope.item.automobile_type = $filter('filter')($scope.automobileTypes, {id: $scope.item.automobile_type.id})[0];
    	}
    	if($scope.item.automobile_color) {
    		$scope.item.automobile_color = $filter('filter')($scope.automobileColors, {id: $scope.item.automobile_color.id})[0];
    	}
    }
    var tempFeaturesJson = {};
    angular.forEach(tempFeatures, function(value, key){
    	tempFeaturesJson[value] = true;
    });

    if($scope.dbType() == "estate") {
    	$scope.item.estate_features = tempFeaturesJson;
    } else {
    	$scope.item.automobile_features = tempFeaturesJson;
    }

		
}])

customerApp.controller('DatabaseItemEditCtrl', ['$scope', '$http', '$filter', 'SweetAlert', 'item', 'FileUploader', '$state' , function($scope, $http, $filter, SweetAlert, item, FileUploader,$state){
	$scope.originalItem = angular.copy(item);
	$scope.item = item;
	var tempFeatures = ($scope.dbType() == "estate") ? angular.copy($scope.item.estate_features) : angular.copy($scope.item.automobile_features);
    if($scope.dbType() == "estate") {
    	$scope.item.estate_features = {}
    	if($scope.item.estate_type) {
    		$scope.item.estate_type = $filter('filter')($scope.estateTypes, {id: $scope.item.estate_type.id})[0];
    	}
    	if($scope.item.contract_type) {
    		$scope.item.contract_type = $filter('filter')($scope.contractTypes, {id: $scope.item.contract_type.id})[0];
    	}
    } else {
    	$scope.item.automobile_features = {}
    	if($scope.item.automobile_brand) {
    		$scope.item.automobile_brand = $filter('filter')($scope.automobileBrands, {id: $scope.item.automobile_brand.id})[0];
    	}
    	if($scope.item.automobile_type) {
    		$scope.item.automobile_type = $filter('filter')($scope.automobileTypes, {id: $scope.item.automobile_type.id})[0];
    	}
    	if($scope.item.automobile_color) {
    		$scope.item.automobile_color = $filter('filter')($scope.automobileColors, {id: $scope.item.automobile_color.id})[0];
    	}
    }
    var tempFeaturesJson = {};
    angular.forEach(tempFeatures, function(value, key){
    	tempFeaturesJson[value] = true;
    });

    if($scope.dbType() == "estate") {
    	$scope.item.estate_features = tempFeaturesJson;
    } else {
    	$scope.item.automobile_features = tempFeaturesJson;
    }



    /**
     * 
     * uploader
     */

    var uploader = $scope.uploader = new FileUploader({
        url: './customer/ajax/upload'
    });
    uploader.withCredentials = true;
    
    uploader.queueLimit = 5;

    uploader.autoUpload = true;
    uploader.removeAfterUpload = true;
    uploader.formData.push({uploadDir : 'image'});
    uploader.formData.push({continual : true});
    uploader.formData.push({type : 'database'});
    uploader.msg = "";
    
    // FILTERS
    $scope.logUploader = function() {
      console.log(uploader);
    }

    uploader.filters.push({
        name: 'imageFilter',
        fn: function(item /*{File|FileLikeObject}*/, options) {
            var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
            return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
        }
    });

    uploader.filters.push({
          name: 'photoLimits',
          fn: function(item, photo) {
              var photocount = (($scope.item.photos) ? $scope.item.photos.length : 0) + uploader.queue.length;
              console.log(photocount);
              if( photocount >= 5) {
                return false;
              }
              return true;
          }
      });
    
    
    uploader.onSuccessItem = function(fileItem, response, status, headers) {
        console.info('onSuccessItem', fileItem, response, status, headers);
        if(!$scope.item.photos) {
            $scope.item.photos = [];
        }
        $scope.item.photos.push(response);
        uploader.msg = 'فایل با موفقیت بارگزاری شد.';
    };


  	$scope.removePhoto = function(index) {
    	$scope.item.photos.splice(index, 1);
	}

	$scope.saveItem = function() {
      	var tempItem = angular.copy($scope.item);
      	var data = humps.camelizeKeys(tempItem);
      	var postData = {_method: 'POST'};
      
      
      
      
      	if($scope.dbType() == 'estate') {
      		data.estateFeatures = [];
      		
      		angular.forEach(tempItem.estate_features, function(value, key){
	      		if(value) {
	      			data.estateFeatures.push(key);
	      		}
	      	});

	      	if(data.contractType){
	      		data.contractType = data.contractType.id;
	      	}


	      	if(data.estateType){
	      		data.estateType = data.estateType.id;
	      	}

	      	if(data.estateType == 8) {
	      		delete data.numOfRooms;
	      		delete data.floor;
	      		delete data.age;
	      		delete data.estateFeatures;
	      	}
      	} else {
      		data.automobileFeatures = [];
      		angular.forEach(tempItem.automobile_features, function(value, key){
	      		if(value) {
	      			data.automobileFeatures.push(key);
	      		}
      		});

	      	if(data.automobileType){
	      		data.automobileType = data.automobileType.id;
	      	}
	      	if(data.automobileBrand){
	      		data.automobileBrand = data.automobileBrand.id;
	      	}
	      	if(data.automobileColor){
	      		data.automobileColor = data.automobileColor.id;
	      	}

      	}

      	delete data.id;
      	delete data.created;
      	delete data.status;
      	postData[$scope.dbType()] = data;

      
      	$http({
	        method: 'POST',
	        url: './customer/ajax/estate/'+$scope.item.id,
	        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
	        data: $.param(postData)
	    }). then(
        	function(response){
        		var inListItems = $filter('filter')($scope.items,{id: $scope.item.id});
        		var inListItem = null;
        		var inListItemIndex = null;
        		if(inListItems.length) {
        			inListItem = inListItems[0];
        			inListItemIndex = $scope.items.indexOf(inListItem);
        			$scope.items[inListItemIndex] = response.data;
        		}

              $state.go('database.itemdetails', {iid: response.data.id});
        	}, 
        	function(responseErr){
              if(responseErr.status == 500 && responseErr.data.code == 13) {
                SweetAlert.swal({
                  title: "کد محصول تکراری است.",
                  type: "success"
                });
              } else {
              	SweetAlert.swal({
              	  title: "ذخیره انجام نشد.",
              	  text: responseErr.data.text,
              	  type: "success"
              	});
              }
        	}
      	);


	}

		
}])



customerApp.controller('DatabaseDetailsCtrl', ['$scope', '$http', '$filter', 'SweetAlert' , function($scope, $http, $filter, SweetAlert){
   

    
}])


customerApp.controller('DatabaseCreateCtrl', ['$scope', 'FileUploader', '$http', '$state', 'SweetAlert', 
	function($scope, FileUploader, $http, $state, SweetAlert){


    $scope.item = {};

    if($scope.dbType() == 'estate') {
    	$scope.item.contract_type = $scope.contractTypes[0];
    	$scope.item.estate_type = $scope.estateTypes[0];
    } else {
    	$scope.item.automobile_brand = $scope.automobileBrands[0];
    	$scope.item.created_year = $scope.ages[0];
    }
  	

	$scope.uploadAlert =  function() {
		SweetAlert.swal({
		  	title: "برای بارگزاری تصویر باید ملک را ذخیره نمایید.",
		  	type: "success"
		});
	}




  	$scope.saveItem = function() {
        var tempItem = angular.copy($scope.item);
        var data = humps.camelizeKeys(tempItem);
        var postData = {_method: 'POST'};
        
        
        
        
        if($scope.dbType() == 'estate') {
        	data.estateFeatures = [];
        	angular.forEach(tempItem.estate_features, function(value, key){
        		if(value) {
        			data.estateFeatures.push(key);
        		}
        	});

        	if(data.contractType){
        		data.contractType = data.contractType.id;
        	}


        	if(data.estateType){
        		data.estateType = data.estateType.id;
        	}

        	if(data.estateType == 8) {
        		delete data.numOfRooms;
        		delete data.floor;
        		delete data.age;
        		delete data.estateFeatures;
        	}

        } else {
        	data.automobileFeatures = [];
        	angular.forEach(tempItem.automobile_features, function(value, key){
        		if(value) {
        			data.automobileFeatures.push(key);
        		}
        	});

        	if(data.automobileType){
        		data.automobileType = data.automobileType.id;
        	}
        	if(data.automobileBrand){
        		data.automobileBrand = data.automobileBrand.id;
        	}
        	if(data.automobileColor){
        		data.automobileColor = data.automobileColor.id;
        	} 

        }

        postData[$scope.dbType()] = data;

        
        $http({
          method: 'POST',
          url: './customer/ajax/estate',
          headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
          data: $.param(postData)
        }). then(
          	function(response){
              	$scope.items.unshift(response.data);
                $state.go('database.itemedit', {iid: response.data.id});
          	}, 
          	function(responseErr){
                if(responseErr.status == 500 && responseErr.data.code == 13) {
                  SweetAlert.swal({
                    title: "کد محصول تکراری است.",
                    type: "success"
                  });
                } else {
                	SweetAlert.swal({
                	  title: "ذخیره انجام نشد.",
                	  text: responseErr.data.text,
                	  type: "success"
                	});
                }
          	}
        );


  	}



}])


customerApp.controller('DatabaseEditCtrl', ['$scope', 'FileUploader', '$http', '$filter', 'SweetAlert', '$state', '$window', 
	function($scope, FileUploader, $http, $filter, SweetAlert, $state, $window){
  	$scope.database = angular.copy($scope.databaseData);

  	$scope.removeBanner = function() {
    	$scope.database.dbase_banner = null;
  	}

  	$scope.saveDatabaseDetails = function() {
  		$http({
	  		method: 'POST',
	  		url: './customer/ajax/database/save_details',
	  		headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
	  		data: $.param({
	  			_method: 'POST', 
	  			description: $scope.database.dbase_description,
	  			banner: $scope.database.dbase_banner
	  		})
  		}).then(
  			function(response){
	  			$scope.databaseData.dbase_description = response.data.dbase_description;
	  			$scope.databaseData.dbase_banner = response.data.dbase_banner;
	  			SweetAlert.swal({
	  				title: "ذخیره انجام شد.",
	  				text: "",
	  				type: "success"
	  			}, function() {
	  				$state.go("database.details");
	  			}); 
  			}, 
			function(responseErr){

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
      $scope.database.dbase_banner = response;
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