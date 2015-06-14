//angular.module('treeService', [])
angular.module('sponsortreeService', [])

    //.factory('NewsTree', function($http) {
    .factory('SponsorTree', function($http) {

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