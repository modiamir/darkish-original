var watermarkApp = angular.module('watermarkApp',
    [
        'angularMoment'	, 'ngSanitize', 'ui.bootstrap'
    ]
);

watermarkApp.run(function(amMoment) {
    amMoment.changeLocale('fa');
    // FastClick.attach(document.body);
});




watermarkApp.filter('toDate', function() {
    return function(input) {
        return new Date(input);
    }
})

watermarkApp.controller('watermarkIndexCtrl', ['$scope', '$http', '$filter', '$sce', '$timeout', '$interval', function($scope, $http, $filter, $sce, $timeout, $interval){

    $scope.searchCriteria = {page: 1, number:"", title: ""}
    $scope.records = [];
    $scope.currentRecord = {}
    $scope.totalPages = 0;
    $scope.currentPage = 0;
    $scope.search = function() {
        $scope.connecting = true;
        $http({
            method: "POST",
            url: './get_records',
            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
            data: $.param($scope.searchCriteria)
        }).then(
            function(response){
                $scope.records = response.data.records;
                $scope.totalPages = response.data.totalPages;
                $scope.currentPage = response.data.currentPage;
                $scope.search.page = response.data.currentPage;
                $scope.connecting = false;
            },
            function(responseErr){
                alert('پاسخ ارسال نشد.')
            }
        );
    }

    $scope.search();

    $scope.getRecord = function(rec) {
        if(!$scope.connecting)
        {
            $scope.connecting = true;
            $http.get('./get_record/'+rec.id).then(
                function(response){
                    $scope.currentRecord = response.data;
                    $scope.connecting = false;
                }
            )
        }

    }

    $scope.logCurrentRecord = function() {
        console.log($scope.currentRecord);
    }

    $scope.updateImages = function() {
        var data = {};
        if($scope.currentRecord.images) {
            data.images = $scope.currentRecord.images;
        }
        if($scope.currentRecord.body_images) {
            data.body_images = $scope.currentRecord.body_images;
        }
        $scope.connecting = true;
        $http({
            method: "POST",
            url: './update_images/'+$scope.currentRecord.id,
            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
            data: $.param(data)
        }).then(
            function(response){
                $scope.connecting = false;
                alert("بروزرسانی فایل ها انجام شد.");
            }
        )
    }

    $scope.isCheckedAllFiles = function() {



        if(!$scope.currentRecord.id)
        {
            return false;
        }

        var result = true;
        if($scope.currentRecord.images) {
            angular.forEach($scope.currentRecord.images, function (image) {
                console.info('bodyImage', image);
                if (!image.checked) {
                    result = false;
                }
            });
        }

        if(!result) {
            return false;
        }

        if($scope.currentRecord.body_images) {
            angular.forEach($scope.currentRecord.body_images, function (image) {
                console.info('image', image);
                if (!image.checked) {
                    result = false;
                }
            });
        }

        return result;
    }

}])

