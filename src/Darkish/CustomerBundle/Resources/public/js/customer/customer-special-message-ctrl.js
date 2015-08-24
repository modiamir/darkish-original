
customerApp.controller('SpecialMessageCtrl', ['$scope', 'recordData', 'FileUploader', '$sce', '$http', 'SweetAlert', 'ngDialog',
function($scope, recordData, FileUploader, $sce, $http, SweetAlert, ngDialog){

	$scope.recordData = recordData;

	$scope.recordFormData= {};


	$scope.mapFormData = function(record) {
		var tempData = angular.copy(record);
		$scope.recordFormData.messageText = tempData.message_text;


	}

	$scope.mapFormData($scope.recordData);
	
	$scope.save = function() {
		$http({
			method: 'POST',
			url: './customer/ajax/save_record_data',
			headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
			data: $.param({_method: 'POST', customer_record: $scope.recordFormData})
		}).then(
			function(response)
			{
				$scope.recordData = response.data;
				$scope.mapFormData($scope.recordData);
			}, 
			function(responseErr) {
				
			}
		);
	}
	




}])