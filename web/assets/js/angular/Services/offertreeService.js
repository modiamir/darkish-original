//angular.module('treeService', [])
angular.module('offertreeService', [])

    //.factory('NewsTree', function($http) {
    .factory('OfferTree', function($http) {

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