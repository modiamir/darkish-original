angular.module('fsCordova', [])//بررسی لود شدن کامل کوردووا و آمادگی انگولار برای بوت شدن
.service('CordovaService', ['$document', '$q',
function ($document, $q) {
    var d = $q.defer(),
    resolved = false;
    var self = this;
    this.ready = d.promise;
    document.addEventListener('deviceready', function () {
        resolved = true;
        d.resolve(window.cordova);
        
    });
    // Check to make sure we didn't miss the
    // event (just in case)
    setTimeout(function () {
        if (!resolved) {
            if (window.cordova) d.resolve(window.cordova);
        }
    }, 3000);
}]);
alert('amir');
//angular.module('panzoom').factory('PanZoomService', ['$q',
//    function ($q) {
//        // key -> deferred with promise of API
//        var panZoomAPIs = {};

//        var registerAPI = function (key, panZoomAPI) {
//            if (!panZoomAPIs[key]) {
//                panZoomAPIs[key] = $q.defer();
//            }

//            var deferred = panZoomAPIs[key];
//            if (deferred.hasBeenResolved) {
//                throw 'Internal error: attempt to register a panzoom API but key was already used. Did you declare two <panzoom> directives with the same id?';
//            } else {
//                deferred.resolve(panZoomAPI);
//                deferred.hasBeenResolved = true;
//            }
//        };

//        var unregisterAPI = function (key) {
//            delete panZoomAPIs[key];
//        };

//        // this method returns a promise since it's entirely possible that it's called before the <panzoom> directive registered the API
//        var getAPI = function (key) {
//            if (!panZoomAPIs[key]) {
//                panZoomAPIs[key] = $q.defer();
//            }

//            return panZoomAPIs[key].promise;
//        };

//        return {
//            registerAPI: registerAPI,
//            unregisterAPI: unregisterAPI,
//            getAPI: getAPI
//        };
//    }]);


alert("loading app 2");


var darkishApp =
    angular.module('DarkishApp', [

        'fsCordova',
        'ui.bootstrap',
        'ui.router',
        'ct.ui.router.extras',
        'ngCordova',
        'jQueryScrollbar',
        "ngSanitize",
        "ngTouch",
        "angularSoundManager",
        'panzoom', 'panzoomwidget',
        "ui.bootstrap-slider",

		"com.2fdevs.videogular",
		"com.2fdevs.videogular.plugins.controls",
		"com.2fdevs.videogular.plugins.overlayplay",
        "com.2fdevs.videogular.plugins.dash",
        "com.2fdevs.videogular.plugins.buffering",
		"com.2fdevs.videogular.plugins.poster"
    ]);

darkishApp.constant('ACCESS_LEVELS', {
    'pub': 1,
    'user':2  
});






darkishApp.config(function ($stateProvider, $urlRouterProvider, ACCESS_LEVELS, $compileProvider) {
    
    // for any unmatched url, redirect to /overview
    $urlRouterProvider.otherwise("/personal");
    
    $compileProvider.imgSrcSanitizationWhitelist(/^\s*(local|file|https|http|data):/);
    // set up the states
    $stateProvider.state('main', {
        'abstract': true,
        templateUrl: 'app/theme/views/main.html',
        controller: "MainCtrl",
        access_level: ACCESS_LEVELS.pub,
        sticky: true,
        deepStateRedirect: true,
    
    }).state('main.register', {// صفحه ثبت نام
        url: "/register",
        views: {
            'register': {
                templateUrl: 'app/theme/views/register.html',
                controller: "RegisterCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub
    
    }).state('main.personal', {// صفحه شخصی
        url: "/personal",
        views:  {
            'personal': {
                templateUrl: 'app/theme/views/personal.html',
                controller: "PersonalCtrl"
            }
        },
        //sticky: true,
        //deepStateRedirect: true,
        access_level: ACCESS_LEVELS.pub

    }).state('main.personal.profile', {// صفحه پروفایل
        url: "/personal/profile",
        views: {
            'PageProfile': {
                templateUrl: 'app/theme/views/profile.html',
                controller: "PageProfileCtrl"
            }
        },
        //sticky: true,
        //deepStateRedirect: true,
        access_level: ACCESS_LEVELS.pub

    }).state('main.personal.message', {// صفحه پیامها
        url: "/personal/message",
        views: {
            'PageMessage': {
                templateUrl: 'app/theme/views/message.html',
                controller: "PageMessageCtrl"
            }
        },
        //sticky: true,
        //deepStateRedirect: true,
        access_level: ACCESS_LEVELS.pub

    }).state('main.map', {// صفحه نقشه
        url: "/map",
        views: {
            'map': {
                templateUrl: 'app/theme/views/Map.html',
                controller:"MapCtrl"
            }
        },
        //sticky: true,
        //deepStateRedirect: true,
        access_level: ACCESS_LEVELS.pub

    }).state('main.ticket', {//صفحه بلیط
        url: "/ticket",
        views: {
            'ticket': {
                templateUrl: 'app/theme/views/Ticket.html',
                controller: "TicketCtrl"
            }
        },
        //sticky: true,
        //deepStateRedirect: true,
        access_level: ACCESS_LEVELS.pub
    }).state('main.news', {// صفحه ثبت نام
        url: "/news",
        views: {
            'news': {
                templateUrl: 'app/theme/views/news.html',
                controller: "NewsCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub,
        
        
        
    }).state('main.news.NewsTree', {// صفحه ثبت نام
        url: "/news/NewsTree?level,isNew",
        views: {
            'NewsTree': {
                templateUrl: 'app/theme/views/NewsTree.html',
                controller: "NewsTreeCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub

    }).state('main.news.NewsList', {// صفحه ثبت نام
        url: "/news/NewsList?level,isNew",
        views: {
            'NewsList': {
                templateUrl: 'app/theme/views/NewsList.html',
                controller: "NewsListCtrl"
            }
        },
        //sticky: true,
        //deepStateRedirect: true,
        access_level: ACCESS_LEVELS.pub

    }).state('main.news.NewsContent', {// صفحه ثبت نام
        url: "/news/NewsTree?level,isNew",
        views: {
            'NewsContent': {
                templateUrl: 'app/theme/views/NewsContent.html',
                controller: "NewsContentCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub

    }).state('main.news.kishNews', {// صفحه ثبت نام
        url: "/news/kishNews?level,isNew",
        views: {
            'kishNews': {
                templateUrl: 'app/theme/views/KishNews.html',
                controller: "KishNewsCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub

    }).state('main.Offer', {// صفحه ثبت نام
        url: "/Offer",
        views: {
            'offer': {
                templateUrl: 'app/theme/views/Offer.html',
                controller: "OfferCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub

    }).state('main.Offer.OfferTree', {// صفحه پیشنهاد ویژه
        url: "/Offer/OfferTree?level,isNew",
        views: {
            'offerTree': {
                templateUrl: 'app/theme/views/OfferTree.html',
                controller: "OfferTreeCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub

    }).state('main.Offer.OfferList', {// صفحه ثبت نام
        url: "/Offer/OfferList?level,isNew",
        views: {
            'offerList': {
                templateUrl: 'app/theme/views/OfferList.html',
                controller: "OfferListCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub

    }).state('main.Offer.OfferContent', {// صفحه ثبت نام
        url: "/Offer/OfferContent?level,isNew",
        views: {
            'offerContent': {
                templateUrl: 'app/theme/views/OfferContent.html',
                controller: "OfferContentCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub

    }).state('main.Classify', {// صفحه ثبت نام
        url: "/Classify",
        views: {
            'classify': {
                templateUrl: 'app/theme/views/Classify.html',
                controller: "ClassifyCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub

    }).state('main.Classify.ClassifyTree', {// صفحه ثبت نام
        url: "/Classify/ClassifyTree?level,isNew",
        views: {
            'classifyTree': {
                templateUrl: 'app/theme/views/ClassifyTree.html',
                controller: "ClassifyTreeCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub

    }).state('main.Classify.ClassifyList', {// صفحه ثبت نام
        url: "/Classify/ClassifyList?level,isNew",
        views: {
            'classifyList': {
                templateUrl: 'app/theme/views/ClassifyList.html',
                controller: "ClassifyListCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub
    }).state('main.Classify.ClassifyContent', {// صفحه ثبت نام
        url: "/Classify/ClassifyContent?level,isNew",
        views: {
            'classifyContent': {
                templateUrl: 'app/theme/views/ClassifyContent.html',
                controller: "ClassifyContentCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub

    }).state('main.Setting', {// صفحه ثبت نام
        url: "/Setting",
        views: {
            'setting': {
                templateUrl: 'app/theme/views/Setting.html',
                controller: "SettingCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub

    }).state('main.Setting.Devel', {// صفحه ثبت نام
        url: "/Setting/Devel",
        views: {
            'settingDevel': {
                templateUrl: 'app/theme/views/SettingDevel.html',
                controller: "SettingDevelCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub

    }).state('main.search', {// صفحه جستجو
        url: "/search",
        views: {
            'search': {
                templateUrl: 'app/theme/views/Search.html',
                controller: "SearchCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub

    }).state('main.record', {// صفحه ثبت نام
        url: "/record",
        views: {
            'record': {
                templateUrl: 'app/theme/views/Record.html',
                controller: "RecordCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub,



    }).state('main.record.RecordTree', {// صفحه ثبت نام
        url: "/record/RecordTree?level,isNew",
        views: {
            'recordTree': {
                templateUrl: 'app/theme/views/RecordTree.html',
                controller: "RecordTreeCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub

    }).state('main.record.RecordList', {// صفحه ثبت نام
        url: "/record/RecordList?level,isNew",
        views: {
            'recordList': {
                templateUrl: 'app/theme/views/RecordList.html',
                controller: "RecordListCtrl"
            }
        },
        //sticky: true,
        //deepStateRedirect: true,
        access_level: ACCESS_LEVELS.pub

    }).state('main.record.RecordContent', {// صفحه ثبت نام
        url: "/record/RecordTree?level,isNew",
        views: {
            'recordContent': {
                templateUrl: 'app/theme/views/RecordContent.html',
                controller: "RecordContentCtrl"
            }
        },
        access_level: ACCESS_LEVELS.pub

    })
    
    
});




darkishApp.run(['$rootScope', 'StateStackSrv', '$state', '$window', '$timeout', '$location', 'UserSrv', '$cordovaSQLite', 'UpdateSrv',
    function ($rootScope, StateStackSrv, $state, $window, $timeout, $location, UserSrv, $cordovaSQLite, UpdateSrv) {
    $rootScope.$state = $state;
    $rootScope.Darkish_db;
    $rootScope.Current_Theme;
    $rootScope.FirstRun = 0;
    serverTime = "2015-01-01T00:00:00+0000";


    document.addEventListener('deviceready', function () {

        //// Android customization
        //cordova.plugins.backgroundMode.setDefaults({ text: 'Doing heavy tasks.' });
        //// Enable background mode
        //cordova.plugins.backgroundMode.enable();

        //// Called when background mode has been activated
        //cordova.plugins.backgroundMode.onactivate = function () {
        //    setTimeout(function () {
        //        // Modify the currently displayed notification
        //        cordova.plugins.backgroundMode.configure({
        //            text: 'Running in background for more than 5s now.'
        //        });
        //    }, 5000);
        //}

        if ($window.sqlitePlugin != undefined) {
            //alert("استفاده از پلاگین اسکیولایت");
            //window.sqlitePlugin.deleteDatabase({ name: "KishMap.mbtiles", location: 1 }, function () {
            //    alert("database deleted: KishMap.mbtiles");
            //}, function (err) {
            //    alert("Error database delete: "+JSON.stringify(err));
            //});
            //window.sqlitePlugin.deleteDatabase({ name: "darkish.db", location: 1 }, function () {
            //    alert("database deleted: darkish.db");
            //}, function (err) {
            //    alert("Error database delete: " + JSON.stringify(err));
            //});
           
            //Map_db = $window.sqlitePlugin.openDatabase({ name: "KishMap.mbtiles", createFromLocation: 1, androidLockWorkaround: 1 });

            Map_db = $window.sqlitePlugin.openDatabase({ name: "map.db", createFromLocation: 1, androidLockWorkaround: 1 });
            Darkish_db = $window.sqlitePlugin.openDatabase({ name: "darkish.db", createFromLocation: 1, androidLockWorkaround: 1 });
           

            alert("ارتباط با دیتابیس انجام شد");
            
            //alert("انجام تراکنش");
            //$.getScript("app/scripts/Fill-Device-Database.js", function () {
                
            //    var query = "SELECT UpDate_Date FROM Tbl_Update WHERE SectionName='Records'"
            //    $cordovaSQLite.execute(Darkish_db, query, []).then(function (res) {

            //        //get news updates form 
            //        var promise = UpdateSrv.records(1, res.rows.item(0).UpDate_Date);
            //        promise.then(function () {
            //            alert("Update Records Done!");
            //        }, function () {
            //            alert("records update Error");
            //        });
                    
            //    }, function (err) {
                    
            //        alert("Database Error: ");
                    
            //    });

            //}); 
            
            
        } else {
            // For debuging in simulator fallback to native SQL Lite
            //alert("استفاده از دامپ دیتابیس");

            Darkish_db = window.openDatabase('Darkish.db', '1.0', 'Darkish', 3 * 1024 * 1024); //connect to the DB
            $.getScript("app/scripts/fill-database.js", function () {

                

            });
            
        }
    }, false);


    $rootScope.$on('$stateChangeSuccess', function (evt, next, curr, fromState, fromParams) {    
        StateStackSrv.push(fromState);
        //console.log(JSON.stringify(fromState));
    });
    //$rootScope.$on('$stateChangeStart',
    //        function (evt, next, curr, fromState, fromParams) {
    //            //alert("next access level: " + next.access_level);
    //            console.log(next);
    //            if (next.access_level == 2) {
    //                //alert("این صفحه نیاز به ثبت نام دارد");
    //                UserSrv.getuser(function (user) {

    //                    if (user.role != 2) {
    //                        //alert("یوزر ثبت نام نکرده است");
    //                        evt.preventDefault();
    //                        $state.go('main.register');
    //                    } else {
    //                        //alert("یوزر ثبت نام کرده است");
    //                    }

    //                });

    //            } else {
    //                //alert("این صفحه نیاز به ثبت نام ندارد");
    //            }

    //        });
}]);



darkishApp.directive("dkImage", function () {

    return {

        controller: function ($scope, $element, $attrs, FileSrv, AppSrv,WebSrv) {

            var url = $attrs['dkUrl'];
            var fs = $attrs['dkFs'];
            var pn = $attrs['dkPn'];
            var sf = $attrs['dkSf'];
            var type = $attrs['dkDt'];
            var appSection = $attrs['dkAs'];
            var appSubSection = $attrs['dkAss'];
            
            //url.length > 4 && (url.substr(0, 2) == "{{") && (url.substr(url.length - 2) == "}}") ? url = $scope[url.substr(2, url.length - 4)] : url = url;
            
            

            var downloadOptions = {
                type: type,
                appSection: appSection,
                appSubSection: appSubSection
            }
            
            var promise = FileSrv.getImage(url, pn, fs, sf, downloadOptions);
            promise.then(function (res) {

                
                //alert(res.nativeURL);
                $attrs.$set('src', res.nativeURL);
               
               

            }, function (err) {
                
                if (err.code == 1) {
                    

                    var JustImageName = url.substring(url.lastIndexOf("/") + 1, url.lastIndexOf("."));

                    //try to tell server to make the picture.
                    //console.log("JustImageName: " + JustImageName + "\n url: " + url);
                    
                    var promise = WebSrv.refreshImageCache(JustImageName);
                    promise.then(function (res) {

                        var promise = FileSrv.getImage(url, pn, fs, sf, downloadOptions);
                        promise.then(function (res) {


                            //alert(res.nativeURL);
                            $attrs.$set('src', res.nativeURL);



                        }, function (err) {

                            console.log("Error getting image: " + JSON.stringify(err));

                        });
                        
                    }, function (err) {

                        console.log("Error Image Cache Refreshed: " + JSON.stringify(err));

                    });

                } else {

                    console.log("Unknown Error getFile error: " + JSON.stringify(err));
                }
                

            });
            
        }

    }
});





darkishApp.directive("dkAudio", function () {
    return {


        templateUrl: "app/theme/views/templates/dkAudio.html",
        replace: true,
        restrict: 'E',
        scope:{},
        controller: function ($scope, $timeout, $element, $attrs) {

            $scope.progress = 0;

            //alert("from dkaudio: " + $attrs.dkSrc);
           
            $scope.audioPlaying = false;
            $scope.loading=false;
            
            $scope.playAudio = function () {
                
                $scope.createPlayer();
                $scope.loading = true;
                    $scope.audioPlayer.play({
                            onfinish: function () {
                                $scope.audioPlayer.destruct();
                                togglePlaying(false);
                                $scope.loading = false;
                                $scope.progress = 0;
                            },
                            onstop: function () {
                                $scope.audioPlayer.unload($scope.audioPlayer.id);
                                $scope.progress = 0;
                                togglePlaying(false);
                                $scope.loading = false;
                            }
                        });
                    
                }  
                
                $scope.pauseAudio=function(){
                    $scope.audioPlayer.pause();
                }  

                $scope.stopAudio=function(){
                    $scope.audioPlayer.stop();
                    $scope.progress = 0;
                }  
            
                $scope.seekClick = function (event) {

                    var touchPos=(event.pageX - event.target.offsetLeft);
                    var seekWidth = (event.target.offsetWidth);
                    var percent = (touchPos / seekWidth) * 100;

                   var Newposition = (percent * $scope.audioPlayer.duration) / 100;
                   alert(Newposition);
                   $scope.audioPlayer.setPosition(Newposition);
                }
                var togglePlaying = function (booleanValue) {
                    
                    
                    $timeout(function () {
                        $scope.audioPlaying = booleanValue;
                    }, 10);
                    
                }
                
                $scope.createPlayer = function () {

                    $scope.audioPlayer = soundManager.createSound({
                        id: $attrs.dkId,
                        url: $attrs.dkSrc,
                        
                        onload: function (bSuccess) {
                            if (bSuccess) {
                                $scope.loading = false;
                                togglePlaying(true);
                            } else {
                                alert("error loading");
                                $scope.loading = false;
                                togglePlaying(false);
                            }
                        },

                        onpause: function () {
                            togglePlaying(false);
                            $scope.loading = false;
                        },
                        onresume: function () {
                            togglePlaying(true);
                            
                        }
                        
                    });
                    $scope.audioPlayer.options.whileplaying = function () {

                        $scope.progress = ($scope.audioPlayer.position / $scope.audioPlayer.duration) * 100;
                        $scope.$apply();

                    }

                }
                
                
                $(".seekBase").width($(".audio-player-wrapper").width() - 100);
                

        }
    }
});


darkishApp.directive("croppAria", function () {

    return {


        restrict: 'A',
        
        controller: function ($scope,$element) {


           
            $element.bind("load", function () {


                $('#cropArea > img').cropper($scope.CropperOptions);
                

            });
            
        }
    }
});


//darkishApp.directive("dkVideo", function () {
//    return {


//        templateUrl: "app/theme/views/templates/dkVideo.html",

//        controller: function ($sce, $scope, $element, $attrs) {

//            $scope.config = {
//                sources: [
//					{ src: $sce.trustAsResourceUrl($attrs.dkSrc), type: "video/mp4" },
//                ],
//                tracks: [
//					{
//					    src: "http://www.videogular.com/assets/subs/pale-blue-dot.vtt",
//					    kind: "subtitles",
//					    srclang: "en",
//					    label: "English",
//					    default: ""
//					}
//                ],
//                theme: "app/theme/css/videogular-themes-default/videogular.css",
//                plugins: {
//                    //poster: "http://www.videogular.com/assets/images/videogular.png"
//                }
//            };

//        }
//    }
//});







//darkishApp.directive("addbuttons", function ($compile) {
//    return function (scope, element, attrs) {
//        element.bind("click", function () {
//            scope.count++;
//            angular.element(document.getElementById('space-for-buttons')).append($compile('<img ng-src="{{getImage()}}"/>')(scope));

//        });
//    };
//});

//darkishApp.directive("imagesrc", function () {
//    return function (scope, element, attrs) {
//        element.bind("click", function () {
//            console.log(attrs);
//            alert("This is alert #" + attrs.alert);
//        });
//    };
//});




