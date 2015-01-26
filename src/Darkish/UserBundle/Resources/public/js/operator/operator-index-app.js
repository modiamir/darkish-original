var operatorApp = angular.module('operatorApp', ['ui.router', 'smart-table', 'ui.router',
    'ngCollection', 'ui.bootstrap', 'cgPrompt']);

operatorApp.config(function($stateProvider, $urlRouterProvider){
   $urlRouterProvider.otherwise("/"); 
   
   $stateProvider
    .state('operators', {
      url: "/",
      templateUrl: "template/operators.html",
      controller: "operatorsCtrl"
    })
    .state('add', {
      url: "/add",
      templateUrl: "template/operators.add.html",
      controller: "operatorsAddCtrl"
    })
    .state('edit', {
      url: "/edit/{id:int}",
      templateUrl: "template/operators.edit.html",
      controller: "operatorsEditCtrl"
    });
});

operatorApp.controller('operatorIndexCtrl', ['$scope', '$interval', '$collection', '$http',function($scope, $interval, $collection, $http){
    $interval(function(){
        $scope.loaded = true;
    }, 3000);
    $scope.operators = [];
}]);

operatorApp.controller('operatorsCtrl', ['$scope', '$collection', '$http', 'prompt', function($scope, $collection, $http, prompt) {
    
    $scope.itemsByPage=3;
    $scope.displayedOperators = $scope.operators;
    $scope.refresh = function(tableState) {
        $http({
            method: 'POST',
            url: './ajax/search',
            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
            data: $.param({data: tableState})
        }).then(
            function(response){
                $scope.operators = response.data.result;
                $scope.displayedOperators = $scope.operators;
                tableState.pagination.numberOfPages = response.data.numOfPages;
            },
            function(response){
                
            }
        );
        
    };
    
    $scope.delete = function(operator, index) {
        prompt({
            title: 'حذف اپراتور؟',
            message: 'آیا از انجام این عمل اطمینان دارید؟'
          }).then(function(){
//            $http({
//                method: 'PUT',
//                url: './ajax/delete/'+operator.id,
//                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
//                data: $.param({data: tableState})
//            });
            $scope.operators.splice(index,1);
            $scope.displayedOperators = $scope.operators;
            console.log(operator);
          });
    }
}]);

operatorApp.controller('operatorsAddCtrl', ['$scope', function($scope){
        $scope.test = 'operatorsAddCtrl';
}]);

operatorApp.controller('operatorsEditCtrl', ['$scope', '$stateParams' , '$http', function($scope, $stateParams, $http){
        $http.get('./ajax/get_operator/'+$stateParams.id).then(
            function(response){
                $scope.operator = response.data;
            }, 
            function(errResponse){
                
            }
        ); 
}]);