customerApp.controller('MessagesCtrl', ['$scope', '$window', 'threads', '$http', '$timeout', '$filter',
  '$interval', 'SweetAlert', '$sce', function($scope, $window, threads, $http, $timeout, $filter, $interval, SweetAlert, $sce){
  $scope.threads = threads.threads;
  $scope.lastMessage = threads.last_message;
  $scope.selectedThread = {};
  // $scope.window = $window;

  
  $scope.resizeForm = function(event) {
    console.log(event);
  }


  $scope.setCaretPosition = function(ctrl, pos)
  {
   
    if(ctrl.setSelectionRange)
    {
      ctrl.focus();
      ctrl.setSelectionRange(pos,pos);
      
    }
    else if (ctrl.createTextRange) {
      var range = ctrl.createTextRange();
      range.collapse(true);
      range.moveEnd('character', pos);
      range.moveStart('character', pos);
      range.select();
    }
  }


  $scope.doGetCaretPosition =  function(ctrl) {
   
    var CaretPos = 0;
    // IE Support
    if (document.selection) {
   
      ctrl.focus ();
      var Sel = document.selection.createRange ();
   
      Sel.moveStart ('character', -ctrl.value.length);
   
      CaretPos = Sel.text.length;
    }
    // Firefox support
    else if (ctrl.selectionStart || ctrl.selectionStart == '0')
      CaretPos = ctrl.selectionStart;
   
    return (CaretPos);
   
  }

  $scope.insertEmotion = function(emotionName) {
    
    var pos =$scope.doGetCaretPosition(document.getElementById('message-text-area'));

    var emotionTag = '('+emotionName+')';
    
    var start = $('#message-text-area').prop("selectionStart");
    var end   = $('#message-text-area').prop("selectionEnd");

    $scope.messageForm = ($scope.messageForm) ? $scope.messageForm : "";

    $scope.messageForm = $scope.messageForm.slice(0, start)+emotionTag+$scope.messageForm.slice(end);
    el = document.getElementById('message-text-area');
    if(el.setSelectionRange)
    {
      $timeout(function(){
        $scope.setCaretPosition(el, end + emotionTag.length);
      }, 5);
      
      
    }
    
  }


  $scope.insertEmotionGroup = function(emotionName) {

    var emotionTag = '('+emotionName+')';
    var start = $('#group-text-area').prop("selectionStart");
    var end   = $('#group-text-area').prop("selectionEnd");

    $scope.groupText = ($scope.groupText) ? $scope.groupText : "";

    $scope.groupText = $scope.groupText.slice(0, start)+emotionTag+$scope.groupText.slice(end);
    el = document.getElementById('group-text-area');
    if(el.setSelectionRange)
    {
      $timeout(function(){
        $scope.setCaretPosition(el, end);
      }, 5);
      
      
    }
  }

  ////////////////////////////////
  

  $scope.getTrustedMessage = function(text) {
    txt = $filter('smilies')(text);
    return $sce.trustAsHtml(txt);
  }

  $scope.getLastMessageTrusted = function(text) {
     // lastMessageText = $scope.getTrustedMessage(text);
     lastMessageTrustedText = $filter('limitTo')(text, 30)
     return $sce.trustAsHtml($filter('smilies')(lastMessageTrustedText));
  }

  $scope.setDetailsInnerMarginBottom = function()   {
    if($scope.isXSmall()) {
      var height = angular.element($('.message-submit'))[0].offsetHeight;
      $('body .main-view .page .details .details-inner').css('margin-bottom', height);  
      $("html, body").animate({ scrollTop: $(document).height() }, 5);
    } else {
      $('body .main-view .page .details .details-inner').css('margin-bottom', 0);  
    }
  }

  
  angular.element($('.message-submit .message-text textarea')).bind('keydown', function(e){
    $scope.setDetailsInnerMarginBottom();
  });

  angular.element($('.message-submit .message-text textarea')).bind('keypress', function(e){
    
  });

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
      $scope.hasNotMore = false;
      $scope.groupMessageForm = false;
      $scope.messageForm = "";
      $http.get('./customer/ajax/get_messages_for_thread/'+thread.id+'/0').then(
        function(response) {
          $timeout(function(){
            $('#message-container').scrollTop($('#message-container')[0].scrollHeight, 0);  
          }, 5);
          $scope.selectedThread = thread;
          $scope.currentMessages = response.data;
          $scope.setLastMessageSeen(thread, thread.last_message.id);
          $scope.fetchDeliveredSeen();
          $scope.setDetailsInnerMarginBottom();
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
        if(response.data.length < 10) {
          $scope.hasNotMore = true;
        }
      },
      function(responseErr) {
      }
    );
  }

  $scope.postMessage = function() {
    if($scope.messageForm) {
      // var text = angular.copy($scope.messageForm);
      var text = $scope.messageForm.replace(/\n/g, '<br/>')
      $scope.messageForm = null;
      $scope.sendMessageRequest(text);
      
    }
  }


  $scope.sendMessageRequest = function(text) {
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
          $scope.setDetailsInnerMarginBottom();
        }, 100)
        
      }, 
      function(responseErr) {
        var contin = confirm('پیام شما ارسال نشد. آیا مجددا ارسال شود؟');
        if(contin) {
          $scope.sendMessageRequest(text);
        }
      }
    );
  }

  var intervalPromise;
  intervalPromise = $interval(function(){
    var latest = 0;
    angular.forEach($scope.threads, function(value, key){
      latest = (latest < value.last_message.id) ? value.last_message.id : latest;
    });
    $http.get('./customer/ajax/refresh_messages/'+ latest, {ignoreLoadingBar: true}).then(
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
                }, 30);
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
    $scope.groupText = "";
    $scope.groupMessageApprove = false;
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
       imageSize: "40x40",
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

  $scope.groupMessageApprove = false;

  $scope.presubmitGroupMessage = function() {
    $scope.groupMessageApprove = true;    
  }

  $scope.cancelGroupMessage = function() {
    $scope.groupMessageApprove = false;
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
        $scope.groupMessageApprove = false;
        $scope.threads.unshift(response.data);
        $scope.selectThread(response.data);
        
        console.log($scope.threads);
        
      }
    );
    // $http({
    //     method: 'POST',
    //     url: './customer/ajax/post_group_message',
    //     headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
    //     data: $.param({_method: 'POST', text: $scope.groupText})
    // }).then(
    //   function(response) {
    //     $scope.groupText = null;
    //     $scope.threads.push(response.data);
    //     $scope.selectThread(response.data);
        
        
        
    //   }
    // );
  }

}])