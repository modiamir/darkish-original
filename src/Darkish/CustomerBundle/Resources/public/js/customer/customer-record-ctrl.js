
customerApp.controller('RecordEditCtrl', ['$scope', 'recordData', 'FileUploader', '$sce', '$http', 'SweetAlert', 'ngDialog',
function($scope, recordData, FileUploader, $sce, $http, SweetAlert, ngDialog){

	$scope.recordData = recordData;

	$scope.recordFormData= {};


	$scope.mapFormData = function(record) {
		var tempData = angular.copy(record);
		$scope.recordFormData.owner = tempData.owner;
		$scope.recordFormData.ownerMail = tempData.owner_mail;
		$scope.recordFormData.ownerPhone = Number(tempData.owner_phone);
		$scope.recordFormData.manager = tempData.manager;
		$scope.recordFormData.managerMail = tempData.manager_mail;
		$scope.recordFormData.managerPhone = tempData.manager_phone;
		$scope.recordFormData.telNumberOneLabel = tempData.tel_number_one_label;
		$scope.recordFormData.telNumberOne = tempData.tel_number_one;
		$scope.recordFormData.telNumberTwoLabel = tempData.tel_number_two_label;
		$scope.recordFormData.telNumberTwo = tempData.tel_number_two;
		$scope.recordFormData.telNumberThreeLabel = tempData.tel_number_three_label;
		$scope.recordFormData.telNumberThree = tempData.tel_number_three;
		$scope.recordFormData.telNumberFourLabel = tempData.tel_number_four_label;
		$scope.recordFormData.telNumberFour = tempData.tel_number_four;
		$scope.recordFormData.faxNumberOne = tempData.fax_number_one;
		$scope.recordFormData.faxNumberTwo = tempData.fax_number_two;
		$scope.recordFormData.mobileNumberOne = tempData.mobile_number_one;
		$scope.recordFormData.mobileNumberTwo = tempData.mobile_number_two;
		$scope.recordFormData.email = tempData.email;
		$scope.recordFormData.website = tempData.website;
		$scope.recordFormData.smsNumber = tempData.sms_number;
		$scope.recordFormData.postalCode = tempData.postal_code;
		//$scope.recordFormData.messageText = tempData.message_text;
		$scope.recordFormData.sellServicePageCustomer = tempData.sell_service_page_customer;
		$scope.recordFormData.dbaseEnableCustomer = tempData.dbase_enable_customer;
		$scope.recordFormData.commentableCustomer = tempData.commentable_customer;



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