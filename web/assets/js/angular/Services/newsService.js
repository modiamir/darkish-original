angular.module('newsService', [])

    .factory('NewsControl', function($http) {

        return {
            // get all the comments
            getForCategory : function(cid,page) {
                return $http.get('ajax/get_news_for_cat/'+cid+'/'+ page);
            },

            getTotalPages: function(cid) {
                return $http.get('ajax/get_total_pages/' + cid);
            },

            saveNews: function(news){
                news._method = "put";
                return $http({
                    method: 'PUT',
                    url: 'ajax/edit/'+news.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(news)
                });
            },

            createNews: function(news){
                console.log(news);
                return $http({
                    method: 'POST',
                    url: 'ajax/create',
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(news)
                });
            },

            approve: function(news) {
                news._method = "put";
                return $http({
                    method: 'POST',
                    url: 'ajax/news/approve/'+news.id,
                    headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(news)
                });

            },

            delete: function(news) {
                news._method = "delete";
                return $http({
                    method: 'POST',
                    url: 'ajax/news/delete/'+news.id,
                    headers: {'Content-Type' : 'application/x-www-form-urlencoded' },
                    data: $.param(news)
                });
            },

            getRandomUploadKey: function() {
                return $http.get('ajax/gen_rand_upload_key');
            },

            getFilesImages: function(news) {
                return $http.get('ajax/get_files_images/'+ news.id);
            }


        }

    });