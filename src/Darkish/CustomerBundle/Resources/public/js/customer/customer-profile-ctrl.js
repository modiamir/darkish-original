customerApp.controller('ProfileCtrl', ['$scope', '$http', 'recordData', function($scope, $http, recordData){
    $scope.record = recordData;

    $scope.isNearToExpire = function()
    {
        var now = new Date();
        var expireDate = new Date($scope.record.expire_date);
        var validDay = 14;
        return ( (expireDate - now) < (validDay * 86400 * 1000));
    }
}])