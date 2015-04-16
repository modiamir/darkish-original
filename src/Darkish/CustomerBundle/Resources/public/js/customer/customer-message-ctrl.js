customerApp.controller('MessagesCtrl', ['$scope', '$window', 'threads', '$http', '$timeout', '$filter',
  '$interval', 'SweetAlert', '$document', function($scope, $window, threads, $http, $timeout, $filter, $interval, SweetAlert, $document){
  $scope.threads = threads.threads;
  $scope.lastMessage = threads.last_message;
  $scope.selectedThread = {};
  // $scope.window = $window;

  


  $scope.fetchDeliveredSeen = function() {
    if($scope.selectedThread.id) {
      var thread = $scope.selectedThread;
      $http.get('./customer/ajax/fetch_last_seen_delivered/'+ thread.id).then(
        function(response) {
          thread.last_client_seen = response.data.seen;
          thread.last_client_delivered = response.data.delivered;
        }
      );
    }
  }

  $scope.setLastMessageDelivered = function(thread, message) {
      $http({
          method: 'PUT',
          url: './customer/ajax/set_last_delivered/'+thread.id+'/'+message,
          headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
          data: $.param({_method: 'PUT'})
      }).then(
        function(response) {
          
          thread.last_record_delivered = message;
          
        }
      )
  }

  $scope.setLastMessageSeen = function(thread, message) {
      $http({
          method: 'PUT',
          url: './customer/ajax/set_last_seen/'+thread.id+'/'+message,
          headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
          data: $.param({_method: 'PUT'})
      }).then(
        function(response) {
          thread.last_record_seen = message;
          
          
        }
      )
  }
  
  angular.forEach($scope.threads, function(value, key){
    if(value.last_message.id > value.last_record_delivered) {
      $scope.setLastMessageDelivered(value, value.last_message.id);  
    }
    
  });

  $scope.currentMessages = [];
  $scope.selectThread = function(thread) {
    if(!angular.equals($scope.selectedThread, thread)) {
      $scope.selectedThread = thread;
      $scope.hasNotMore = false;
      $scope.groupMessageForm = false;
      $http.get('./customer/ajax/get_messages_for_thread/'+thread.id+'/0').then(
        function(response) {
          $timeout(function(){
            $('#message-container').scrollTop($('#message-container')[0].scrollHeight);  
          }, 100);
          $scope.currentMessages = response.data;
          $scope.setLastMessageSeen(thread, thread.last_message.id);
          $scope.fetchDeliveredSeen();
        },
        function(responseErr) {
        }
      );
    }
  }

  $scope.loadMore = function() {
    $http.get('./customer/ajax/get_messages_for_thread/'+$scope.selectedThread.id+'/'+$scope.currentMessages.length).then(
      function(response) {
        $scope.currentMessages = $scope.currentMessages.concat(response.data);
        if(response.data.length < 5) {
          $scope.hasNotMore = true;
        }
      },
      function(responseErr) {
      }
    );
  }

  $scope.postMessage = function() {
    if($scope.messageForm) {
      var text = angular.copy($scope.messageForm);
      $scope.messageForm = null;
      $http({
          method: 'PUT',
          url: './customer/ajax/post_message/'+$scope.selectedThread.id,
          headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
          data: $.param({_method: 'PUT', text: text})
      }).then(
        function(response) {
          var msg = {};
          msg.id = response.data.id;
          msg.text = response.data.text;
          msg.from = response.data.from;
          msg.created = response.data.created;
          $scope.currentMessages.push(msg);
          $scope.selectedThread.last_message = response.data;
          $scope.setLastMessageSeen($scope.selectedThread, $scope.selectedThread.last_message.id);
          $scope.setLastMessageDelivered($scope.selectedThread, $scope.selectedThread.last_message.id);
          $timeout(function(){
            $('#message-container').scrollTop($('#message-container')[0].scrollHeight);  
          }, 100)
          
          
          
        }
      );
    }
  }

  var intervalPromise;
  intervalPromise = $interval(function(){
    var latest = 0;
    angular.forEach($scope.threads, function(value, key){
      latest = (latest < value.last_message.id) ? value.last_message.id : latest;
    });
    $http.get('./customer/ajax/refresh_messages/'+ latest).then(
      function(response) {
        var tmpScrollHeight = $('#message-container')[0].scrollHeight;
        angular.forEach(response.data, function(value, key){
          var th = $filter('filter')($scope.threads, {id: value.thread.id})[0];
          if(th) {
            if($scope.selectedThread.id == th.id) {
              th.last_message.id = value.id;
              th.last_message.created = value.created;
              th.last_message.from = value.from;
              th.last_message.text = value.text;
              th.last_record_seen = value.id;
              th.last_record_delivered = value.id;
              var msg = {}
              msg.id = value.id;
              msg.created = value.created;
              msg.text = value.text;
              msg.from = value.from;
              $scope.currentMessages.push(msg);
              console.log($('#message-container').scrollTop());
              console.log(tmpScrollHeight);
              if( (tmpScrollHeight - $('#message-container').scrollTop() ) < 420) {
                $timeout(function(){
                  $('#message-container').scrollTop($('#message-container')[0].scrollHeight);  
                }, 100);
              }
              
            } else {
              th.last_message.id = value.id;
              th.last_message.created = value.created;
              th.last_message.from = value.from;
              th.last_message.text = value.text;
              th.last_record_delivered = value.id;
            }
          } else {
            var newThread = value.thread;
            newThread.last_message = {};
            newThread.last_message.id = value.id;
            newThread.last_message.created = value.created;
            newThread.last_message.from = value.from;
            newThread.last_message.text = value.text;
            newThread.last_record_delivered = value.id;
            $scope.threads.push(newThread);
          }
          
        });
      },
      function(responseErr) {

      }
    );

    $scope.fetchDeliveredSeen();
  }, 10000);

  $scope.$on('$destroy',function(){
      console.log(intervalPromise);
      if(intervalPromise)
          $interval.cancel(intervalPromise);   
  });
  
  $scope.showGroupMessageForm = function() {
    $scope.selectedThread = {};
    $scope.groupMessageForm = true;
  }

  $scope.delete = function(thread) {
    SweetAlert.swal({
       title: "آیا از حذف اطمینان دارید؟",
       text: "این عملیات قابل برگشت نیست!",
       type: "warning",
       showCancelButton: true,
       confirmButtonColor: "#DD6B55",
       confirmButtonText: "بله, حذف کن!",
       cancelButtonText: "انصراف",
       closeOnConfirm: false}, 
    function(){ 
      $http({
        method: 'DELETE',
        url: './customer/ajax/delete/'+thread.id,
        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
        data: $.param({_method: 'DELETE'})
      }).then(
        function(response) {
          var index = $scope.threads.indexOf(thread);
          $scope.threads.splice(index, 1);
          if($scope.selectedThread.id == thread.id) {
            $scope.selectedThread = {};
          }
          SweetAlert.swal("حذف انجام شد.", "", "success");   
        }
      )

       
    });
  }

  $scope.submitGroupMessage = function() {
    $http({
        method: 'POST',
        url: './customer/ajax/post_group_message',
        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
        data: $.param({_method: 'POST', text: $scope.groupText})
    }).then(
      function(response) {
        $scope.groupText = null;
        $scope.threads.push(response.data);
        $scope.selectThread(response.data);
        
        
        
      }
    );
  }

}])