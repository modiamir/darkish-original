var customerApp = angular.module('CustomerApp', ['ui.router', 'oitozero.ngSweetAlert', 'angularFileUpload',
								'ngPasswordStrength', 'validation.match', 'angularMoment', 'ui.utils', 'duScroll', 'decipher.tags',
                'ui.bootstrap', 'monospaced.elastic', 'ngSanitize', 'validation', 'validation.rule'
                , 'angAccordion', 'ui.sortable', 'angular-loading-bar', 'ngDialog', 'ngCkeditor', 'validation.match', 'ngImgCrop', 'ui.bootstrap.persian.datepicker']);

customerApp.run(function(amMoment) {
    amMoment.changeLocale('fa');
    // FastClick.attach(document.body);
});

customerApp
    .directive('dkVideo', ['$compile', function($compile){
      return {
        restrict: 'E',
        transclude: true,
        link: function(scope, element, attrs) {
          //console.log(attrs);
          var img = document.createElement('img');
          $(img).attr('src', './assets/images/video-default.jpg');
          var src = attrs.src;

          $(img).attr('ng-click', "openBodyVideoModal('lg', '"+src+"')");

          var compileScope = scope;
          $(element).replaceWith($compile(img)(compileScope));

          //element.html('test');
        }
      }
    }])
    .directive('dkAudio', ['$compile', function($compile){
      return {
        restrict: 'E',
        transclude: true,
        link: function(scope, element, attrs) {
          //console.log(attrs);
          var img = document.createElement('img');
          $(img).attr('src', './assets/images/audio-default.png');
          var src = attrs.src;

          $(img).attr('ng-click', "openBodyAudioModal('lg', '"+src+"')");

          var compileScope = scope;
          $(element).replaceWith($compile(img)(compileScope));

          //element.html('test');
        }
      }
    }])
    .directive('bindHtmlCompile', ['$compile', '$timeout', function ($compile, $timeout) {
      return {
        restrict: 'A',
        link: function (scope, element, attrs) {
          scope.$watch(function () {
            return scope.$eval(attrs.bindHtmlCompile).toString();

          }, function (value) {

            var trueHtml = scope.$eval(attrs.bindHtmlCompile).toString();


            //var elem = angular.element(element);
            //var elem = angular.element('<div>'+trueHtml+'</div>');
            //var elem = angular.element('<div>'+trueHtml+'</div>');

            //var videos = $('video[class^="record-"]', elem);

            //videos.each(function( index ) {
            //    var el = this;
            //    var img = document.createElement('img');
            //    $(img).attr('src', '../../assets/images/video-default.jpg');
            //    var src = $('source',el).attr('src');
            //    var src1 = src.substring(0,10);
            //    var src2 = src.substring(10);
            //    $(img).attr('ng-click', "openBodyVideoModal('lg', '"+src1+"', '"+src2+"')");
            //    $(el).replaceWith(img);
            //});
            //
            //var audios = $('audio[class^="record-"]', elem);
            //
            //audios.each(function( index ) {
            //    var el = this;
            //    var img = document.createElement('img');
            //    $(img).attr('src', '../../assets/images/audio-default.png');
            //    var src = $('source',el).attr('src');
            //    var src1 = src.substring(0,10);
            //    var src2 = src.substring(10);
            //    $(img).attr('width', '100');
            //    $(img).attr('ng-click', "openBodyAudioModal('lg', '"+src1+"', '"+src2+"')");
            //    $(el).replaceWith(img);
            //});

            var compileScope = scope;

            //element.html($compile(elem.html())(compileScope));
            element.html($compile(trueHtml)(compileScope));

          });
        }
      };
    }])




customerApp.filter('toDate', function() {
  return function(input) {
    return new Date(input);
  }
})

customerApp.filter('dotToDash', function() {
  return function(input) {
    return input.replace(/\./g,'-');
  }
});

customerApp.filter('smilies', function() {
  return function(input) {
    var smilies = [
      {
        regex: /\(smiley\)/g,
        name: 'smiley'
      },
      {
        regex: /\(happy\)/g,
        name: 'happy'
      },
      {
        regex: /\(wink2\)/g,
        name: 'wink2'
      },
      {
        regex: /\(wink\)/g,
        name: 'wink'
      },
      {
        regex: /\(laugh\)/g,
        name: 'laugh'
      },
      {
        regex: /\(teeth\)/g,
        name: 'teeth'
      },
      {
        regex: /\(yummi\)/g,
        name: 'yummi'
      },
      {
        regex: /\(surprised\)/g,
        name: 'surprised'
      },
      {
        regex: /\(crazy\)/g,
        name: 'crazy'
      },
      {
        regex: /\(money\)/g,
        name: 'money'
      },
      {
        regex: /\(moa\)/g,
        name: 'moa'
      },
      {
        regex: /\(inlove\)/g,
        name: 'inlove'
      },
      {
        regex: /\(flirt\)/g,
        name: 'flirt'
      },
      {
        regex: /\(teary\)/g,
        name: 'teary'
      },
      {
        regex: /\(mad\)/g,
        name: 'mad'
      },
      {
        regex: /\(upset\)/g,
        name: 'upset'
      },
      {
        regex: /\(cry\)/g,
        name: 'cry'
      },
      {
        regex: /\(angry\)/g,
        name: 'angry'
      },
      {
        regex: /\(sick\)/g,
        name: 'sick'
      },
      {
        regex: /\(sleeping\)/g,
        name: 'sleeping'
      },
      {
        regex: /\(info\)/g,
        name: 'info'
      },
      {
        regex: /\(Q\)/g,
        name: 'Q'
      },
      {
        regex: /\(heart\)/g,
        name: 'heart'
      },
      {
        regex: /\(purple_heart\)/g,
        name: 'purple_heart'
      },
      {
        regex: /\(clap\)/g,
        name: 'clap'
      },
      {
        regex: /\(like\)/g,
        name: 'like'
      },
      {
        regex: /\(V\)/g,
        name: 'V'
      },
      {
        regex: /\(unlike\)/g,
        name: 'unlike'
      },
      {
        regex: /\(flower\)/g,
        name: 'flower'
      },
      {
        regex: /\(balloon2\)/g,
        name: 'balloon2'
      },
      {
        regex: /\(balloon1\)/g,
        name: 'balloon1'
      },
      {
        regex: /\(cake\)/g,
        name: 'cake'
      },
      {
        regex: /\(gift\)/g,
        name: 'gift'
      },
      {
        regex: /\(partyhat\)/g,
        name: 'partyhat'
      },
      {
        regex: /\(cupcake\)/g,
        name: 'cupcake'
      },
      {
        regex: /\(magnify\)/g,
        name: 'magnify'
      },
      {
        regex: /\(glasses\)/g,
        name: 'glasses'
      },
      {
        regex: /\(letter\)/g,
        name: 'letter'
      },
      {
        regex: /\(thinking\)/g,
        name: 'thinking'
      },
      {
        regex: /\(music\)/g,
        name: 'music'
      },
      {
        regex: /\(pencil\)/g,
        name: 'pencil'
      },
      {
        regex: /\(book\)/g,
        name: 'book'
      },
      {
        regex: /\(ruler\)/g,
        name: 'ruler'
      },
      {
        regex: /\(scissor\)/g,
        name: 'scissor'
      },
      {
        regex: /\(dollar\)/g,
        name: 'dollar'
      },
      {
        regex: /\(run\)/g,
        name: 'run'
      },
      {
        regex: /\(time\)/g,
        name: 'time'
      },
      {
        regex: /\(bell\)/g,
        name: 'bell'
      },
      {
        regex: /\(telephone\)/g,
        name: 'telephone'
      },
      {
        regex: /\(snowman\)/g,
        name: 'snowman'
      },
      {
        regex: /\(snowflake\)/g,
        name: 'snowflake'
      },
      {
        regex: /\(rain\)/g,
        name: 'rain'
      },
      {
        regex: /\(cloud\)/g,
        name: 'cloud'
      },
      {
        regex: /\(moon\)/g,
        name: 'moon'
      },
      {
        regex: /\(sun\)/g,
        name: 'sun'
      },
      {
        regex: /\(angel\)/g,
        name: 'angel'
      },
      {
        regex: /\(palmtree\)/g,
        name: 'palmtree'
      },
      {
        regex: /\(christmas_tree\)/g,
        name: 'christmas_tree'
      },
      {
        regex: /\(sunflower\)/g,
        name: 'sunflower'
      },
      {
        regex: /\(cactus\)/g,
        name: 'cactus'
      },
      {
        regex: /\(sprout\)/g,
        name: 'sprout'
      },
      {
        regex: /\(clover\)/g,
        name: 'clover'
      },
      {
        regex: /\(koala\)/g,
        name: 'koala'
      },
      {
        regex: /\(bunny\)/g,
        name: 'bunny'
      },
      {
        regex: /\(squirrel\)/g,
        name: 'squirrel'
      },
      {
        regex: /\(goldfish\)/g,
        name: 'goldfish'
      },
      {
        regex: /\(monkey\)/g,
        name: 'monkey'
      },
      {
        regex: /\(cat\)/g,
        name: 'cat'
      },
      {
        regex: /\(kangaroo\)/g,
        name: 'kangaroo'
      },
      {
        regex: /\(ladybug\)/g,
        name: 'ladybug'
      },
      {
        regex: /\(turtle\)/g,
        name: 'turtle'
      },
      {
        regex: /\(sheep\)/g,
        name: 'sheep'
      },
      {
        regex: /\(panda\)/g,
        name: 'panda'
      },
      {
        regex: /\(owl\)/g,
        name: 'owl'
      },
      {
        regex: /\(chick\)/g,
        name: 'chick'
      },
      {
        regex: /\(dog\)/g,
        name: 'dog'
      },
      {
        regex: /\(bee\)/g,
        name: 'bee'
      },
      {
        regex: /\(penguin\)/g,
        name: 'penguin'
      },
      {
        regex: /\(dragonfly\)/g,
        name: 'dragonfly'
      },
      {
        regex: /\(pig\)/g,
        name: 'pig'
      },
      {
        regex: /\(snake\)/g,
        name: 'snake'
      },
      {
        regex: /\(snail\)/g,
        name: 'snail'
      },
      {
        regex: /\(fly\)/g,
        name: 'fly'
      },
      {
        regex: /\(shark\)/g,
        name: 'shark'
      },
      {
        regex: /\(bat\)/g,
        name: 'bat'
      },
      {
        regex: /\(martini\)/g,
        name: 'martini'
      },
      {
        regex: /\(beer\)/g,
        name: 'beer'
      },
      {
        regex: /\(coffee\)/g,
        name: 'coffee'
      },
      {
        regex: /\(soda\)/g,
        name: 'soda'
      },
      {
        regex: /\(burger\)/g,
        name: 'burger'
      },
      {
        regex: /\(pizza\)/g,
        name: 'pizza'
      },
      {
        regex: /\(hotdog\)/g,
        name: 'hotdog'
      },
      {
        regex: /\(popcorn\)/g,
        name: 'popcorn'
      },
      {
        regex: /\(egg\)/g,
        name: 'egg'
      },
      {
        regex: /\(noodles\)/g,
        name: 'noodles'
      },
      {
        regex: /\(chicken\)/g,
        name: 'chicken'
      },
      {
        regex: /\(donut\)/g,
        name: 'donut'
      },
      {
        regex: /\(popsicle\)/g,
        name: 'popsicle'
      },
      {
        regex: /\(ice_cream\)/g,
        name: 'ice_cream'
      },
      {
        regex: /\(lollipop\)/g,
        name: 'lollipop'
      },
      {
        regex: /\(croissant\)/g,
        name: 'croissant'
      },
      {
        regex: /\(chocolate\)/g,
        name: 'chocolate'
      },
      {
        regex: /\(cherry\)/g,
        name: 'cherry'
      },
      {
        regex: /\(grapes\)/g,
        name: 'grapes'
      },
      {
        regex: /\(watermelon\)/g,
        name: 'watermelon'
      },
      {
        regex: /\(strawberry\)/g,
        name: 'strawberry'
      },
      {
        regex: /\(banana\)/g,
        name: 'banana'
      },
      {
        regex: /\(pineapple\)/g,
        name: 'pineapple'
      },
      {
        regex: /\(corn\)/g,
        name: 'corn'
      },
      {
        regex: /\(pea\)/g,
        name: 'pea'
      },
      {
        regex: /\(mushroom\)/g,
        name: 'mushroom'
      },
      {
        regex: /\(bicycle\)/g,
        name: 'bicycle'
      },
      {
        regex: /\(taxi\)/g,
        name: 'taxi'
      },
      {
        regex: /\(ambulance\)/g,
        name: 'ambulance'
      },
      {
        regex: /\(policecar\)/g,
        name: 'policecar'
      },
      {
        regex: /\(car\)/g,
        name: 'car'
      },
      {
        regex: /\(airplane\)/g,
        name: 'airplane'
      },
      {
        regex: /\(rocket\)/g,
        name: 'rocket'
      },
      {
        regex: /\(ufo\)/g,
        name: 'ufo'
      },
      {
        regex: /\(flipflop\)/g,
        name: 'flipflop'
      },
      {
        regex: /\(umbrella\)/g,
        name: 'umbrella'
      },
      {
        regex: /\(fidora\)/g,
        name: 'fidora'
      },
      {
        regex: /\(cap\)/g,
        name: 'cap'
      },
      {
        regex: /\(crown\)/g,
        name: 'crown'
      },
      {
        regex: /\(diamond\)/g,
        name: 'diamond'
      },
      {
        regex: /\(ring\)/g,
        name: 'ring'
      },
      {
        regex: /\(relax\)/g,
        name: 'relax'
      },
      {
        regex: /\(battery\)/g,
        name: 'battery'
      },
      {
        regex: /\(nobattery\)/g,
        name: 'nobattery'
      },
      {
        regex: /\(termometer\)/g,
        name: 'termometer'
      },
      {
        regex: /\(meds\)/g,
        name: 'meds'
      },
      {
        regex: /\(syringe\)/g,
        name: 'syringe'
      },
      {
        regex: /\(golfball\)/g,
        name: 'golfball'
      },
      {
        regex: /\(golf\)/g,
        name: 'golf'
      },
      {
        regex: /\(soccer\)/g,
        name: 'soccer'
      },
      {
        regex: /\(baseball\)/g,
        name: 'baseball'
      },
      {
        regex: /\(basketball\)/g,
        name: 'basketball'
      },
      {
        regex: /\(tennis\)/g,
        name: 'tennis'
      },
      {
        regex: /\(beachball\)/g,
        name: 'beachball'
      },
      {
        regex: /\(8ball\)/g,
        name: '8ball'
      },
      {
        regex: /\(boxing\)/g,
        name: 'boxing'
      },
      {
        regex: /\(football\)/g,
        name: 'football'
      },
      {
        regex: /\(weight\)/g,
        name: 'weight'
      },
      {
        regex: /\(muscle\)/g,
        name: 'muscle'
      },
      {
        regex: /\(trophy\)/g,
        name: 'trophy'
      },
      {
        regex: /\(happycry\)/g,
        name: 'happycry'
      },
      {
        regex: /\(silly\)/g,
        name: 'silly'
      },
      {
        regex: /\(nerd\)/g,
        name: 'nerd'
      },
      {
        regex: /\(shy\)/g,
        name: 'shy'
      },
      {
        regex: /\(not_sure\)/g,
        name: 'not_sure'
      },
      {
        regex: /\(confused\)/g,
        name: 'confused'
      },
      {
        regex: /\(meh\)/g,
        name: 'meh'
      },
      {
        regex: /\(what\)/g,
        name: 'what'
      },
      {
        regex: /\(yo\)/g,
        name: 'yo'
      },
      {
        regex: /\(wtf\)/g,
        name: 'wtf'
      },
      {
        regex: /\(tongue\)/g,
        name: 'tongue'
      },
      {
        regex: /\(sad\)/g,
        name: 'sad'
      },
      {
        regex: /\(exhausted\)/g,
        name: 'exhausted'
      },
      {
        regex: /\(huh\)/g,
        name: 'huh'
      },
      {
        regex: /\(scream\)/g,
        name: 'scream'
      },
      {
        regex: /\(weak\)/g,
        name: 'weak'
      },
      {
        regex: /\(dead\)/g,
        name: 'dead'
      },
      {
        regex: /\(mischievous\)/g,
        name: 'mischievous'
      },
      {
        regex: /\(ohno\)/g,
        name: 'ohno'
      },
      {
        regex: /\(straight\)/g,
        name: 'straight'
      },
      {
        regex: /\(dizzy\)/g,
        name: 'dizzy'
      },
      {
        regex: /\(cool\)/g,
        name: 'cool'
      },
      {
        regex: /\(spiderman\)/g,
        name: 'spiderman'
      },
      {
        regex: /\(eek\)/g,
        name: 'eek'
      },
      {
        regex: /\(ugh\)/g,
        name: 'ugh'
      },
      {
        regex: /\(devil\)/g,
        name: 'devil'
      },
      {
        regex: /\(oh\)/g,
        name: 'oh'
      },
      {
        regex: /\(depressed\)/g,
        name: 'depressed'
      },
      {
        regex: /\(mwah\)/g,
        name: 'mwah'
      },
      {
        regex: /\(singing\)/g,
        name: 'singing'
      },
      {
        regex: /\(batman\)/g,
        name: 'batman'
      },
      {
        regex: /\(ninja\)/g,
        name: 'ninja'
      },
      {
        regex: /\(light_bulb\)/g,
        name: 'light_bulb'
      },
      {
        regex: /\(fire\)/g,
        name: 'fire'
      },
      {
        regex: /\(torch\)/g,
        name: 'torch'
      },
      {
        regex: /\(sushi1\)/g,
        name: 'sushi1'
      },
      {
        regex: /\(sushi2\)/g,
        name: 'sushi2'
      },
      {
        regex: /\(phone\)/g,
        name: 'phone'
      },
      {
        regex: /\(knife\)/g,
        name: 'knife'
      },
      {
        regex: /\(key\)/g,
        name: 'key'
      },
      {
        regex: /\(angrymark\)/g,
        name: 'angrymark'
      },
      {
        regex: /\(bomb\)/g,
        name: 'bomb'
      },
      {
        regex: /\(mapleleaf\)/g,
        name: 'mapleleaf'
      },
      {
        regex: /\(zzz\)/g,
        name: 'zzz'
      },
      {
        regex: /\(guitar\)/g,
        name: 'guitar'
      },
      {
        regex: /\(trumpet\)/g,
        name: 'trumpet'
      },
      {
        regex: /\(hammer\)/g,
        name: 'hammer'
      },
      {
        regex: /\(dice\)/g,
        name: 'dice'
      },
      {
        regex: /\(console\)/g,
        name: 'console'
      },
      {
        regex: /\(lantern\)/g,
        name: 'lantern'
      },
      {
        regex: /\(microphone\)/g,
        name: 'microphone'
      },
      {
        regex: /\(tape\)/g,
        name: 'tape'
      },
      {
        regex: /\(speaker\)/g,
        name: 'speaker'
      },
      {
        regex: /\(video\)/g,
        name: 'video'
      },
      {
        regex: /\(TV\)/g,
        name: 'TV'
      },
      {
        regex: /\(wrench\)/g,
        name: 'wrench'
      },
      {
        regex: /\(lock\)/g,
        name: 'lock'
      },
      {
        regex: /\(paperclip\)/g,
        name: 'paperclip'
      },
      {
        regex: /\(skull\)/g,
        name: 'skull'
      },
      {
        regex: /\(ghost\)/g,
        name: 'ghost'
      },
      {
        regex: /\(paw\)/g,
        name: 'paw'
      },
      {
        regex: /\(darkish-logo\)/g,
        name: 'darkish-logo'
      }
    ];
      
    angular.forEach(smilies, function(value, key){
      if(input){
        input = input.replace(value.regex, 
      '<img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" class="dk-emot emot-'+value.name+'" alt="('+value.name+')" />');  
      }
      
    });
    
    return input;
  }
})

customerApp.config(function($stateProvider, $urlRouterProvider) {





  //
  // For any unmatched url, redirect to /state1
  $urlRouterProvider.otherwise("/profile");
  //
  // Now set up the states
  $stateProvider
    .state('profile', {
      url: "/profile",
      templateUrl: "customer/template/profile.html",
      controller: "ProfileCtrl",
      data: {
      	label: 'پروفایل'
      },
      resolve: {
        recordData: function($http){
          return $http({method: 'GET', url: 'customer/ajax/html/get_record_details'})
              .then (function (response) {
            return response.data;
          });
        }
      }
    })
    .state('editprofile', {
      url: "/profile/edit",
      templateUrl: "customer/template/profile-edit.html",
      controller: "ProfileEditCtrl",
      data: {
      	label: 'ویرایش پروفایل'
      }
    })
    .state('htmlpage', {
      url: "/html-page",
      templateUrl: "customer/template/html-page.html",
      controller: "HtmlPageCtrl",
      data: {
      	label: 'صفحه آنلاین'
      },
      resolve: {
        recordData: function($http){
          return $http({method: 'GET', url: 'customer/ajax/html/get_record_details'})
             .then (function (response) {
                return response.data;
             });
        }
      }
    })
    .state('recordedit', {
      url: "/record-edit",
      templateUrl: "customer/template/record-edit.html",
      controller: "RecordEditCtrl",
      data: {
        label: 'ویرایش واحد'
      },
      resolve: {
        recordData: function($http){
          return $http({method: 'GET', url: 'customer/ajax/html/get_record_details'})
              .then (function (response) {
            return response.data;
          });
        }
      }
    })
    .state('specialmessage', {
      url: "/special-message",
      templateUrl: "customer/template/special-message.html",
      controller: "SpecialMessageCtrl",
      data: {
        label: 'پیام ویژه'
      },
      resolve: {
        recordData: function($http){
          return $http({method: 'GET', url: 'customer/ajax/html/get_record_details'})
              .then (function (response) {
            return response.data;
          });
        }
      }
    })
    .state('attachments', {
      url: "/attachments",
      templateUrl: "customer/template/attachments.html",
      controller: "AttachmentsCtrl",
      data: {
        label: 'گالری'
      },
      resolve: {
        recordData: function($http){
          return $http({method: 'GET', url: 'customer/ajax/attachment/get_record_details'})
             .then (function (response) {
                return response.data;
             });
        }
      }
    })
    .state('messages', {
      url: "/messages",
      templateUrl: "customer/template/messages.html",
      controller: "MessagesCtrl",
      data: {
      	label: 'پیام ها'
      },
      resolve: {
        threads: function($http) {
          return $http({method: 'GET', url: 'customer/ajax/get_message_threads'})
             .then (function (response) {
                return response.data;
             });
        },
        recordData: function($http){
          return $http({method: 'GET', url: 'customer/ajax/html/get_record_details'})
             .then (function (response) {
                return response.data;
             });
        }
      }
    })
    .state('comments', {
      abstract: true,
      url: "/comments",
      templateUrl: "customer/template/comments.html",
      controller: "CommentsCtrl",
      data: {
      	label: 'نظرات'
      }
    })
    .state('comments.all', {
      url: "/all",
      templateUrl: "customer/template/comments-all.html",
      controller: "CommentsAllCtrl"
    })
    .state('comments.news', {
      url: "/news",
      templateUrl: "customer/template/comments-news.html",
      controller: "CommentsNewsCtrl"
    })
    .state('database', {
      url: "/database",
      templateUrl: "customer/template/database.html",
      controller: "DatabaseCtrl",
      data: {
      	label: 'پایگاه داده'
      },
      resolve: {
        databaseData: function($http) {
          return $http({method: 'GET', url: 'customer/ajax/get_database_data'})
             .then (function (response) {
                return response.data;
             });  
        },
        estateTypes: function($http) {
          return $http({method: 'GET', url: 'customer/ajax/get_estate_types'})
             .then (function (response) {
                return response.data;
             });  
        },
        contractTypes: function($http) {
          return $http({method: 'GET', url: 'customer/ajax/get_contract_types'})
             .then (function (response) {
                return response.data;
             });  
        },
        estateFeatures: function($http) {
          return $http({method: 'GET', url: 'customer/ajax/get_estate_features'})
             .then (function (response) {
                return response.data;
             });  
        },
        automobileTypes: function($http) {
          return $http({method: 'GET', url: 'customer/ajax/get_automobile_types'})
             .then (function (response) {
                return response.data;
             });  
        },
        automobileBrands: function($http) {
          return $http({method: 'GET', url: 'customer/ajax/get_automobile_brands'})
             .then (function (response) {
                return response.data;
             });  
        },
        automobileFeatures: function($http) {
          return $http({method: 'GET', url: 'customer/ajax/get_automobile_features'})
             .then (function (response) {
                return response.data;
             });  
        },
        automobileColors: function($http) {
          return $http({method: 'GET', url: 'customer/ajax/get_automobile_colors'})
             .then (function (response) {
                return response.data;
             });  
        },


      }
    })
    .state('database.edit', {
      url: "/edit",
      templateUrl: "customer/template/database-edit.html",
      controller: "DatabaseEditCtrl"
    })
    .state('database.details', {
      url: "/details",
      templateUrl: "customer/template/database-details.html",
      controller: "DatabaseDetailsCtrl"
    })
    .state('database.create', {
      url: "/create",
      templateUrl: "customer/template/database-create.html",
      controller: "DatabaseCreateCtrl"

    })
    .state('database.itemdetails', {
      url: "/item/{iid:int}",
      templateUrl: "customer/template/database-item-details.html",
      controller: "DatabaseItemDetailsCtrl",
      resolve: {
        item: function($http, $stateParams) {
          return $http({method: 'GET', url: 'customer/ajax/database/get_item/'+$stateParams.iid})
             .then (function (response) {
                return response.data;
             });  
        }

      }
    })
    .state('database.itemedit', {
      url: "/item/{iid:int}/edit",
      templateUrl: "customer/template/database-item-edit.html",
      controller: "DatabaseItemEditCtrl",
      resolve: {
        item: function($http, $stateParams) {
          return $http({method: 'GET', url: 'customer/ajax/database/get_item/'+$stateParams.iid})
             .then (function (response) {
                return response.data;
             });  
        }

      }
    })////////
    .state('user', {
      url: "/user",
      templateUrl: "customer/template/user.html",
      controller: "UserCtrl",
      data: {
        label: 'مدیریت کاربران'
      },
      resolve: {
        accesses: function($http) {
          return $http({method: 'GET', url: 'customer/ajax/assistant/get_roles'})
             .then (function (response) {
                return response.data;
             });  
        }


      }
    }).state('user.create', {
      url: "/create",
      templateUrl: "customer/template/user-create.html",
      controller: "UserCreateCtrl"

    })
    .state('user.edit', {
      url: "/{uid:int}",
      templateUrl: "customer/template/user-edit.html",
      controller: "UserItemEditCtrl",
      resolve: {
        user: function($http, $stateParams) {
          return $http({method: 'GET', url: 'customer/ajax/assistant/get_user/'+$stateParams.uid})
             .then (function (response) {
                return response.data;
             });  
        }

      }
    })
    /////
    .state('store', {
      url: "/store",
      templateUrl: "customer/template/store.html",
      controller: "StoreCtrl",
      data: {
      	label: 'فروشگاه آنلاین'
      },
      resolve: {
        storeData: function($http) {
          return $http({method: 'GET', url: 'customer/ajax/get_store_data'})
             .then (function (response) {
                storeDate = response.data;
                // if(storeDate.market_online_order == "true") {
                //   storeDate.market_online_order = true;
                // } else {
                //   storeDate.market_online_order = false;
                // }
                return response.data;
             });  
        }

      }
    })
    .state('store.productdetails', {
      url: "/product/{pid:int}",
      templateUrl: "customer/template/store-product-details.html",
      controller: "StoreProductDetailsCtrl",
      resolve: {
        product: function($http, $stateParams) {
          return $http({method: 'GET', url: 'customer/ajax/product/get/'+$stateParams.pid})
             .then (function (response) {
                return response.data;
             });  
        }

      }
    })
    .state('store.editproduct', {
      url: "/product/{pid:int}/edit",
      templateUrl: "customer/template/store-product-edit.html",
      controller: "StoreProductEditCtrl",
      resolve: {
        product: function($http, $stateParams) {
          return $http({method: 'GET', url: 'customer/ajax/product/get/'+$stateParams.pid})
             .then (function (response) {
                return response.data;
             });  
        }
      }
    })
    .state('store.edit', {
      url: "/edit",
      templateUrl: "customer/template/store-edit.html",
      controller: "StoreEditCtrl"
    })
    .state('store.details', {
      url: "/details",
      templateUrl: "customer/template/store-details.html",
      controller: "StoreDetailsCtrl"
    })
    .state('store.create', {
      url: "/create",
      templateUrl: "customer/template/store-create.html",
      controller: "StoreCreateCtrl"

    });
});


customerApp.controller('CustomerCtrl', ['$scope', '$state', '$http', '$rootScope', '$document', '$window', 'ngDialog', function($scope, $state, $http, $rootScope, $document, $window, ngDialog){
  $http.get('customer/get_user').then(
    function(response){
		  $scope.user = response.data;
      $scope.access = $scope.getAccess();
      console.log($scope.user.record);
      $scope.state = $state;
      $scope.window = $window;
      $scope.isXSmall = function() {
        if($window.outerWidth < 768) {
          return true;
        }
        return false;
      }
	});


  // $document.on('scroll', function() {
  //       if($window.outerWidth < 768) {
  //         $('.details-header').addClass('fixed');
  //         $('.master-buttons').addClass('fixed');
  //       } else {
  //         $('.details-header').removeClass('fixed');
  //         $('.master-buttons').removeClass('fixed');
  //       }
  //  });



  $scope.isOnline = function() {
    return true;
  }

  $scope.getAccess = function() {
    var access = [];
    angular.forEach($scope.user.assistant_access, function(value, key){
      access.push(value.role);
    });
    return access;
  }

  $scope.state = $state;

  $rootScope.$on('$stateChangeSuccess', 
  function(event, toState, toParams, fromState, fromParams){
    if(toState.name == "editprofile") {
      if($('#navbar-collapse-user-menu').hasClass('in')) {
        $('#navbar-collapse-user-menu').collapse('hide');  
      }
    } else {
      if($('#navbar-collapse-main-menu').hasClass('in')) {
        $('#navbar-collapse-main-menu').collapse('hide');  
      }  
    }
  });




  $scope.pagetitle = function() {
    return "درکیش  | پنل مشتریان | " + (($state.current.data) ? $state.current.data.label:"");
  }


  $scope.openPhotoModal = function (photos, index) {
    ngDialog.open({ 
      template: 'customer/template/photo-modal.html',
      className: 'ngdialog-theme-default custom-width',
      controller: 'PhotoModalCtrl', 
      resolve: {
        photos: function() {
            return photos;
        },
        index: function() {
          return index;
        }
      }
    });
  };

  $scope.openVideoModal = function (videos, index) {
    ngDialog.open({ 
      template: 'customer/template/video-modal.html',
      className: 'ngdialog-theme-default custom-width',
      controller: 'VideoModalCtrl', 
      resolve: {
        videos: function() {
            return videos;
        },
        index: function() {
          return index;
        }
      }
    });
  };


  $scope.openAudioModal = function (audios, index) {
    ngDialog.open({ 
      template: 'customer/template/audio-modal.html',
      className: 'ngdialog-theme-default custom-width',
      controller: 'AudioModalCtrl', 
      resolve: {
        audios: function() {
            return audios;
        },
        index: function() {
          return index;
        }
      }
    });
  };
  
}]);








customerApp.controller('PhotoModalCtrl', ['$scope', '$http', 'photos', 'index', function($scope, $http, photos, index){
  $scope.photos = photos;
  $scope.index = index;


}])


customerApp.controller('VideoModalCtrl', ['$scope', '$http', 'videos', 'index', function($scope, $http, videos, index){
  $scope.videos = videos;
  $scope.index = index;

  $scope.next = function() {
    $scope.index = $scope.index + 1;
    var videoPlayer = document.getElementById('modal-video-player');
    videoPlayer.src = $scope.videos[$scope.index].absolute_path;
    videoPlayer.load();
    // videoPlayer.play();
  }

  $scope.previous = function() {
    $scope.index = $scope.index - 1;
    var videoPlayer = document.getElementById('modal-video-player');
    videoPlayer.src = $scope.videos[$scope.index].absolute_path;
    videoPlayer.load();
    // videoPlayer.play();
  }

}])



customerApp.controller('AudioModalCtrl', ['$scope', '$http', 'audios', 'index', function($scope, $http, audios, index){
  $scope.audios = audios;
  $scope.index = index;

  $scope.next = function() {
    $scope.index = $scope.index + 1;
    var audioPlayer = document.getElementById('modal-audio-player');
    audioPlayer.src = $scope.audios[$scope.index].absolute_path;
    audioPlayer.load();
    // audioPlayer.play();
  }

  $scope.previous = function() {
    $scope.index = $scope.index - 1;
    var audioPlayer = document.getElementById('modal-audio-player');
    audioPlayer.src = $scope.audios[$scope.index].absolute_path;
    audioPlayer.load();
    // audioPlayer.play();
  }

}])






customerApp.controller('UsersCtrl', ['$scope', function($scope){
	
}])