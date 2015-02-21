angular.module('treeService', [])

    .factory('NewsTree', function($http) {

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