//angular.module('newsService', [])
angular.module('classifiedService', [])

    //.factory('NewsControl', function($http) {
    .factory('ClassifiedControl', function($http) {

        return {
            // get all the comments
            getForCategory : function(cid,page) {
                return $http.get('ajax/get_classified_for_cat/'+cid+'/'+ page);
            },

            getTotalPages: function(cid) {
                return $http.get('ajax/get_total_pages/' + cid);
            },

            saveClassified: function(classified){
                classified._method = "put";
                return $http({
                    method: 'POST',
                    url: 'ajax/edit/'+classified.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(classified)
                });
            },

            createClassified: function(classified){
                console.log(classified);
                return $http({
                    method: 'POST',
                    url: 'ajax/create',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(classified)
                });
            },

            approve: function(classified) {
                classified._method = "put";
                return $http({
                    method: 'POST',
                    url: 'ajax/classified/approve/'+classified.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(classified)
                });

            },

            delete: function(classified) {
                classified._method = "delete";
                return $http({
                    method: 'POST',
                    url: 'ajax/classified/delete/'+classified.id,
                    headers: {'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(classified)
                });
            }


        }

    });