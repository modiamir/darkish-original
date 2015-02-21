//angular.module('treeService', [])
angular.module('classifiedtreeService', [])

    //.factory('NewsTree', function($http) {
    .factory('ClassifiedTree', function($http) {

        return {
            // get all the comments
            get : function() {
                return $http.get('ajax/gettree');
            },

            getLinear: function() {
                return $http.get('ajax/gettree_linear');
            }

        }

    });