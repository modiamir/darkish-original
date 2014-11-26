//angular.module('newsService', [])
angular.module('offerService', [])

    //.factory('NewsControl', function($http) {
    .factory('OfferControl', function($http) {

        return {
            // get all the comments
            getForCategory : function(cid,page) {
                return $http.get('ajax/get_offer_for_cat/'+cid+'/'+ page);
            },

            getTotalPages: function(cid) {
                return $http.get('ajax/get_total_pages/' + cid);
            },

            saveOffer: function(offer){
                offer._method = "put";
                return $http({
                    method: 'POST',
                    url: 'ajax/edit/'+offer.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(offer)
                });
            },

            createOffer: function(offer){
                console.log(offer);
                return $http({
                    method: 'POST',
                    url: 'ajax/create',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(offer)
                });
            },

            approve: function(offer) {
                offer._method = "put";
                return $http({
                    method: 'POST',
                    url: 'ajax/offer/approve/'+offer.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(offer)
                });

            },

            delete: function(offer) {
                offer._method = "delete";
                return $http({
                    method: 'POST',
                    url: 'ajax/offer/delete/'+offer.id,
                    headers: {'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(offer)
                });
            }


        }

    });