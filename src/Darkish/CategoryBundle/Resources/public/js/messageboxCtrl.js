var messageboxApp = angular.module('messageboxApp', 
	[
		'angularMoment'	, 'ngSanitize', 'ui.bootstrap'
	]
);

messageboxApp.run(function(amMoment) {
    amMoment.changeLocale('fa');
    // FastClick.attach(document.body);
});




messageboxApp.filter('toDate', function() {
  return function(input) {
    return new Date(input);
  }
})

messageboxApp.filter('smilies', function() {
  return function(input) {
    var smilies = [
      {
        regex: /\(wink\)/g,
        name: 'wink'
      }, 
      {
        regex: /\(dollar\)/g,
        name: 'dollar'
      }, 
      {
        regex: /\(happy\)/g,
        name: 'happy'
      },
      {
        regex: /\(airplane\)/g,
        name: 'airplane'
      },
      {
        regex: /\(angry\)/g,
        name: 'angry'
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
        regex: /\(bicycle\)/g,
        name: 'bicycle'
      },
      {
        regex: /\(burger\)/g,
        name: 'burger'
      },
      {
        regex: /\(car\)/g,
        name: 'car'
      },
      {
        regex: /\(clap\)/g,
        name: 'clap'
      },
      {
        regex: /\(cloud\)/g,
        name: 'cloud'
      },
      {
        regex: /\(coffee\)/g,
        name: 'coffee'
      },
      {
        regex: /\(confused\)/g,
        name: 'confused'
      },
      {
        regex: /\(cool\)/g,
        name: 'cool'
      },
      {
        regex: /\(crazy\)/g,
        name: 'crazy'
      },
      {
        regex: /\(cry\)/g,
        name: 'cry'
      },
      {
        regex: /\(cupcake\)/g,
        name: 'cupcake'
      },
      {
        regex: /\(depressed\)/g,
        name: 'depressed'
      },
      {
        regex: /\(exclam\)/g,
        name: 'exclam'
      },
      {
        regex: /\(fire\)/g,
        name: 'fire'
      },
      {
        regex: /\(flower\)/g,
        name: 'flower'
      },
      {
        regex: /\(koala\)/g,
        name: 'koala'
      },
      {
        regex: /\(ladybug\)/g,
        name: 'ladybug'
      },
      {
        regex: /\(laugh\)/g,
        name: 'laugh'
      },
      {
        regex: /\(light_bulb\)/g,
        name: 'light_bulb'
      },
      {
        regex: /\(mad\)/g,
        name: 'mad'
      },
      {
        regex: /\(money\)/g,
        name: 'money'
      },
      {
        regex: /\(music\)/g,
        name: 'music'
      },
      {
        regex: /\(nerd\)/g,
        name: 'nerd'
      },
      {
        regex: /\(not_sure\)/g,
        name: 'not_sure'
      },
      {
        regex: /\(Q\)/g,
        name: 'Q'
      },
      {
        regex: /\(rain\)/g,
        name: 'rain'
      },
      {
        regex: /\(relax\)/g,
        name: 'relax'
      },
      {
        regex: /\(run\)/g,
        name: 'run'
      },
      {
        regex: /\(sad\)/g,
        name: 'sad'
      },
      {
        regex: /\(scream\)/g,
        name: 'scream'
      },
      {
        regex: /\(shy\)/g,
        name: 'shy'
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
        regex: /\(smiley\)/g,
        name: 'smiley'
      },
      {
        regex: /\(soccer\)/g,
        name: 'soccer'
      },
      {
        regex: /\(sun\)/g,
        name: 'sun'
      },
      {
        regex: /\(surprised\)/g,
        name: 'surprised'
      },
      {
        regex: /\(teeth\)/g,
        name: 'teeth'
      },
      {
        regex: /\(time\)/g,
        name: 'time'
      },
      {
        regex: /\(tongue\)/g,
        name: 'tongue'
      },
      {
        regex: /\(yummi\)/g,
        name: 'yummi'
      },
      {
        regex: /\(darkish_logo\)/g,
        name: 'darkish_logo'
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


messageboxApp.controller('messageBoxIndexCtrl', ['$scope', '$http', '$filter', '$sce', '$modal', '$timeout', '$interval', function($scope, $http, $filter, $sce, $modal, $timeout, $interval){
	$http.get('./ajax/get_messages/older/0').then(
		function(response){
			$scope.messages = response.data.messages;
			$timeout(function(){
 		    	$(".messages-wrapper").animate({ scrollTop: $('.messages-wrapper')[0].scrollHeight }, "slow");
 		    },200);
		}
	);


	$interval(function() {
		var messageLength = $scope.messages.length;
		if(messageLength > 0) {
			var biggestId = $scope.messages[$scope.messages.length - 1].id;
			angular.forEach($scope.messages, function(value, key){
				biggestId = (value.id > biggestId) ? value.id : biggestId;
			});
			$http.get('./ajax/get_messages/newer/'+biggestId).then(
				function(response){
					if(response.data.messages.length > 0) {
						$scope.messages = response.data.messages.concat($scope.messages);
						$timeout(function(){
			 		    	$(".messages-wrapper").animate({ scrollTop: $('.messages-wrapper')[0].scrollHeight }, "slow");
			 		    },200);
					}
					
				}
			);			
		}
	}, 20000)

	$scope.loadOlder = function() {
		var messageLength = $scope.messages.length;
		if(messageLength > 0) {
			var lowestId = $scope.messages[0].id;
			console.log(lowestId);
			angular.forEach($scope.messages, function(value, key){
				lowestId = (value.id < lowestId) ? value.id : lowestId;
			});
			$http.get('./ajax/get_messages/older/'+lowestId).then(
				function(response){
					$scope.messages = $scope.messages.concat(response.data.messages);
				}
			);			
		}
		
	}

	$scope.getTrustedMessage = function(text) {
	  txt = $filter('smilies')(text);
	  return $sce.trustAsHtml(txt);
	}

	$scope.openReplyModal = function (message, force) {
        force = (force) ? true : false;
        if(force || message.from == "client") {
     		var replyModalInstance = $modal.open({
     		    templateUrl: 'replyModal.html',
     		    controller: 'replyModalCtrl',
     		    size: 'sm',
     		    resolve: {
     		        message: function(){
     		            return message;
     		        }
     		    },
     		    windowClass: 'reply-modal-window'
     		});

     		replyModalInstance.result.then(
     		function (message) {
     		    $scope.messages.push(message);
     		    $timeout(function(){
     		    	$(".messages-wrapper").animate({ scrollTop: $('.messages-wrapper')[0].scrollHeight }, "slow");
     		    	
     		    },200);
     		    
     		}, function () {
     		    
     		});   	
        }

        
    };
}])


messageboxApp.controller('replyModalCtrl', ['$scope', 'message', '$http', '$modalInstance', '$modal', function($scope, message, $http, $modalInstance, $modal){
		$scope.message = message;
		
		$scope.reply = function(body) {
			if(body.length > 0) {
				$http({
					method: "PUT",
					url: './ajax/reply/'+message.thread.id,
					headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
					data: $.param({body: body, _method:"PUT"})
				}).then(
					function(response){
						$modalInstance.close(response.data);
					}, 
					function(responseErr){
						alert('پاسخ ارسال نشد.')
					}
				);
			}
		}

		$scope.dismiss = function() {
			$modalInstance.dismiss();
		}
}])