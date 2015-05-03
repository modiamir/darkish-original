

customerApp.controller('StoreCtrl', ['$scope', '$state', 'storeData', 'FileUploader', '$window', '$http', 
  function($scope, $state, storeData, FileUploader, $window, $http){
	$scope.store = "mrzsss";
	$scope.state = $state;
  $scope.sortable = false;
  
  
	$scope.storeData = storeData;

  $scope.products = {}

  angular.forEach($scope.storeData.market_groups, function(value, key){
    $http.get('customer/ajax/product/all/'+value.id).then(
      function(response){
        $scope.products[value.id] = response.data;
      }, 
      function(responseErr){});
  });

	$scope.log = function(item) {
		console.log(item);

	}


  $scope.saveSort = function() {
    var productsToSort = [];


    angular.forEach($scope.products, function(prods, key){
      angular.forEach(prods, function(value, key){
        var obj = {};
        obj.id = value.id;
        obj.sort = value.sort;
        productsToSort.push(obj);
      });
    });
    $http({
      method: 'POST',
      url: './customer/ajax/product/sort',
      headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
      data: $.param({_method: 'POST', products: productsToSort})
    }).then(function(response){
      $scope.sortable = false;
    }, function(responseErr){});
  }


  

  $scope.collapsedGroups = {}

  $scope.collapseFirstGroup = function() {
    var isAnyOpen = false;
    angular.forEach($scope.collapsedGroups, function(value, key){
      if(value) {
        isAnyOpen = true;
      }
    });

    if(isAnyOpen) {
      return;
    }


    var first = null;
    var found = false;
    angular.forEach($scope.storeData.market_groups, function(value, key){
      if(!found) {
        if(!first) {
          first = key;
          firstEnable = true;
        }
        if($scope.products[value.id].length) {
          $scope.collapsedGroups[value.id] = true;
          found = true;
        }
      }
    });
    if(!found) {
      $scope.collapsedGroups[first] = true;  
    }
    


  }

    



}])

customerApp.controller('StoreDetailsCtrl', ['$scope', '$http', '$filter', function($scope, $http, $filter){
    $scope.tempGroups = angular.copy($scope.storeData.market_groups);
    $scope.tempGroups = $filter('orderBy')($scope.tempGroups, 'sort');
    $scope.finish = function() {
      var groupsToSort = [];


      
      angular.forEach($scope.tempGroups, function(value, key){
        var obj = {};
        obj.id = value.id;
        obj.sort = value.sort;
        groupsToSort.push(obj);
      });

      $http({
        method: 'POST',
        url: './customer/ajax/product/sort_groups',
        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
        data: $.param({_method: 'POST', groups: groupsToSort})
      }).then(function(response){
        $scope.groupEdit = 0;
        $scope.storeData.market_groups = angular.copy($scope.tempGroups);
      }, function(responseErr){});
    }

    $scope.addGroup = function() {
      var grpObj = {}
      grpObj.name = $scope.addingGroup;
      grpObj.sort = $scope.tempGroups[0].sort - 1;

      $http({
        method: 'POST',
        url: './customer/ajax/product/add_group',
        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
        data: $.param({_method: 'POST', group: grpObj})
      }).then(function(response){
        $scope.tempGroups.unshift(response.data);
        $scope.addingGroup = "";
        $scope.storeData.market_groups = angular.copy($scope.tempGroups);
      }, function(responseErr){});

      
    }

    $scope.deleteGroup = function(index) {
      $http({
        method: 'DELETE',
        url: './customer/ajax/product/delete_group/'+$scope.tempGroups[index].id,
        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
        data: $.param({_method: 'DELETE'})
      }).then(function(response){
        $scope.tempGroups.splice(index, 1);
      }, function(responseErr){});
    }

    $scope.dragControlListeners = {
        accept: function (sourceItemHandleScope, destSortableScope) {
            return sourceItemHandleScope.itemScope.sortableScope.$id === destSortableScope.$id;
        },
        itemMoved: function (event) {
          console.info('itemMoved', event);
          console.info('itemMoved', event)
          /**
           * Action to perform after move success.
           */
          moveSuccess = function() {};

          /**
           * Action to perform on move failure.
           * remove the item from destination Column.
           * insert the item again in original Column.
           */
          moveFailure = function() {   
               eventObj.dest.sortableScope.removeItem(eventObj.dest.index);
               eventObj.source.itemScope.sortableScope.insertItem(eventObj.source.index, eventObj.source.itemScope.task);
          };
        },
        orderChanged: function(event) {
          if(event.dest.index > event.source.index) {
            for(var i = event.source.index ; i < event.dest.index; i++) {
              $scope.tempGroups[i].sort--;
            }
            $scope.tempGroups[event.dest.index].sort = $scope.tempGroups[event.dest.index - 1].sort + 1;
          } else {
            for(var i = event.source.index ; i > event.dest.index ; i--) {
              $scope.tempGroups[i].sort++;
            }
            $scope.tempGroups[event.dest.index].sort = $scope.tempGroups[event.dest.index + 1].sort - 1;
          }
          console.info('orderChanged', event)
        },
        containment: '#board',
        containerPositioning: 'relative'
    };
}])

customerApp.controller('StoreProductEditCtrl', ['$scope', '$stateParams', 'product', 'FileUploader', '$http', '$filter', '$state', function($scope, $stateParams, product, FileUploader, $http, $filter, $state){
  $scope.stateParams = $stateParams;
  $scope.product = product;
  $scope.product.group = $filter('filter')($scope.storeData.market_groups, {id: $scope.product.group.id})[0];
  /**
   * 
   * uploader
   */

  var uploader = $scope.uploader = new FileUploader({
      url: './customer/ajax/upload'
  });
  uploader.withCredentials = true;
  $scope.queueLimit = function() {
    return ($scope.product.photos) ? (3 - $scope.product.photos.length) : 3 ;
  }
  uploader.queueLimit = $scope.queueLimit();

  uploader.autoUpload = false;
  uploader.removeAfterUpload = true;
  uploader.formData.push({uploadDir : 'image'});
  uploader.formData.push({continual : true});
  uploader.formData.push({type : 'product'});
  uploader.msg = "";
  
  // FILTERS


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
            if($scope.product.photos && ($scope.product.photos.length + uploader.queue.length) >= 3) {
              return false;
            }
            return true;
        }
    });
  
  
  uploader.onSuccessItem = function(fileItem, response, status, headers) {
      console.info('onSuccessItem', fileItem, response, status, headers);
      if(!$scope.product.photos) {
          $scope.product.photos = [];
      }
      $scope.product.photos.push(response);
      uploader.msg = 'فایل با موفقیت بارگزاری شد.';
  };


  $scope.saveProduct = function() {
    var tempProduct = angular.copy($scope.product);
    var data = humps.camelizeKeys(tempProduct);
    data.photos = [];
    angular.forEach($scope.product.photos, function(photo, key){
      data.photos.push(photo.id);
    });
    data.group = $scope.product.group.id;
    delete data.groupId;
    delete data.customer;
    delete data.status;
    delete data.created
    delete data.id;
    $http({
      method: 'POST',
      url: './customer/ajax/product/'+product.id,
      headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
      data: $.param({_method: 'POST', product: data})
    }). then(
          function(response){
            var prod = $filter('filter')($scope.products[response.data.group_id], {id: response.data.id})[0];
            var index = $scope.products[response.data.group_id].indexOf(prod);
            $scope.products[response.data.group_id][index] = response.data;
            $state.go('store.productdetails', {pid: response.data.id});
          }, 
          function(responseErr){
            console.log(responseErr);
          }
        );


  }

  $scope.removePhoto = function(index) {
    $scope.product.photos.splice(index, 1);
  }
}])

customerApp.controller('StoreProductDetailsCtrl', ['$scope', '$stateParams', 'product', function($scope, $stateParams, product){
  $scope.edit = "edit product";
  $scope.stateParams = $stateParams;
  $scope.product = product;
  

  $scope.openLightboxModal = function (index) {
    // Lightbox.openModal($scope.product.photos, index);
  };
}])

customerApp.controller('StoreEditCtrl', ['$scope', 'FileUploader', '$http', '$filter', 'SweetAlert', '$state', '$window', 
	function($scope, FileUploader, $http, $filter, SweetAlert, $state, $window){
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
  			$scope.storeData.market_description = response.data.market_description;
  			$scope.storeData.market_banner = response.data.market_banner;
  			$scope.storeData.market_template = response.data.market_template;
  			$scope.storeData.market_groups = response.data.market_groups;
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

customerApp.controller('StoreCreateCtrl', ['$scope', 'FileUploader', '$http', '$state', function($scope, FileUploader, $http, $state){
      $scope.product = {availability: 0, special_tag: 0};

      /**
       * 
       * uploader
       */

      var uploader = $scope.uploader = new FileUploader({
          url: './customer/ajax/upload'
      });
      uploader.withCredentials = true;
      $scope.queueLimit = function() {
        return ($scope.product.photos) ? (3 - $scope.product.photos.length) : 3 ;
      }
      uploader.queueLimit = $scope.queueLimit();

      uploader.autoUpload = false;
      uploader.removeAfterUpload = true;
      uploader.formData.push({uploadDir : 'image'});
      uploader.formData.push({continual : true});
      uploader.formData.push({type : 'product'});
      uploader.msg = "";
      
      // FILTERS


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
                if($scope.product.photos && ($scope.product.photos.length + uploader.queue.length) >= 3) {
                  return false;
                }
                return true;
            }
        });
      
      
      uploader.onSuccessItem = function(fileItem, response, status, headers) {
          console.info('onSuccessItem', fileItem, response, status, headers);
          if(!$scope.product.photos) {
              $scope.product.photos = [];
          }
          $scope.product.photos.push(response);
          uploader.msg = 'فایل با موفقیت بارگزاری شد.';
      };


      $scope.saveProduct = function() {
        var tempProduct = angular.copy($scope.product);
        var data = humps.camelizeKeys(tempProduct);
        data.photos = [];
        angular.forEach($scope.product.photos, function(photo, key){
          data.photos.push(photo.id);
        });
        data.group = $scope.product.group.id;
        console.info('$scope.products',$scope.products);
        console.info('$scope.product.group', $scope.product.group);
        data.sort = ($scope.products[$scope.product.group.id][0])? $scope.products[$scope.product.group.id][0].sort - 1 : 0;

        $http({
          method: 'POST',
          url: './customer/ajax/product',
          headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
          data: $.param({_method: 'POST', product: data})
        }). then(
              function(response){
                $scope.products[response.data.group.id].unshift(response.data);
                $state.go('store.productdetails', {pid: response.data.id});
              }, 
              function(responseErr){
                console.log(responseErr);
              }
            );


      }

      $scope.removePhoto = function(index) {
        $scope.product.photos.splice(index, 1);
      }


}])


customerApp.controller('StoreProductCtrl', ['$scope', function($scope){
  $scope.edit = "edit product";
  $scope.myvar = Math.random();
}])

customerApp.controller('StoreGroupProductsCtrl', ['$scope', '$filter', '$state', function($scope, $filter, $state){
  $scope.items = $scope.products[$scope.group.id];
  $scope.showProductss = function() {
    console.log($scope.items);
  }
  // angular.forEach($scope.products, function(value, key){
  //       if(value.group_id == $scope.group.id) {
  //         $scope.items.push(value);
  //       }
  // });

  // $scope.items = $filter('orderBy')($scope.items, 'sort');
  $scope.dragControlListeners = {
      accept: function (sourceItemHandleScope, destSortableScope) {
          return sourceItemHandleScope.itemScope.sortableScope.$id === destSortableScope.$id;
      },
      itemMoved: function (event) {
        console.info('itemMoved', event);
        console.info('itemMoved', event)
        /**
         * Action to perform after move success.
         */
        moveSuccess = function() {};

        /**
         * Action to perform on move failure.
         * remove the item from destination Column.
         * insert the item again in original Column.
         */
        moveFailure = function() {   
             eventObj.dest.sortableScope.removeItem(eventObj.dest.index);
             eventObj.source.itemScope.sortableScope.insertItem(eventObj.source.index, eventObj.source.itemScope.task);
        };
      },
      orderChanged: function(event) {
        console.log($scope.products[$scope.group.id][event.dest.index - 1]);
        if(event.dest.index > event.source.index) {
          for(var i = event.source.index ; i < event.dest.index; i++) {
            $scope.products[$scope.group.id][i].sort--;
          }
          $scope.products[$scope.group.id][event.dest.index].sort = $scope.products[$scope.group.id][event.dest.index - 1].sort + 1;
        } else {
          for(var i = event.source.index ; i > event.dest.index ; i--) {
            $scope.products[$scope.group.id][i].sort++;
          }
          $scope.products[$scope.group.id][event.dest.index].sort = $scope.products[$scope.group.id][event.dest.index + 1].sort - 1;
        }
        console.info('orderChanged', event)
      },
      containment: '#board'//optional param.
  };

  $scope.selectProduct = function(product) {
    if(!$scope.sortable) {
      $state.go('store.productdetails', {pid: product.id});  
    }
    

  }

  
    
}])
