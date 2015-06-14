//angular.module('newsService', [])
angular.module('sponsorService', [])

    //.factory('NewsControl', function($http) {
    .factory('SponsorControl', function($http) {

        return {
            // get all the comments
            getForCategory : function(cid,page) {
                return $http.get('ajax/get_sponsor_for_cat/'+cid+'/'+ page);
            },

            getTotalPages: function(cid) {
                return $http.get('ajax/get_total_pages/' + cid);
            },

            saveSponsor: function(sponsor){
                sponsor._method = "put";
                return $http({
                    method: 'POST',
                    url: 'ajax/edit/'+sponsor.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(sponsor)
                });
            },

            createSponsor: function(sponsor){
                console.log(sponsor);
                return $http({
                    method: 'POST',
                    url: 'ajax/create',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(sponsor)
                });
            },

            approve: function(sponsor) {
                sponsor._method = "put";
                return $http({
                    method: 'POST',
                    url: 'ajax/sponsor/approve/'+sponsor.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(sponsor)
                });

            },

            delete: function(sponsor) {
                sponsor._method = "delete";
                return $http({
                    method: 'POST',
                    url: 'ajax/sponsor/delete/'+sponsor.id,
                    headers: {'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(sponsor)
                });
            }


        }

    });