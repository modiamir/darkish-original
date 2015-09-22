
$(document).ready(function () {


    $('.content').off('click', '.media.comment > .media-body > .comment-reply-button')
        .on('click', '.media.comment > .media-body > .comment-reply-button', function(event){
            var settings = {
                "async": true,
                "crossDomain": false,
                //"url": "/comment/get_form/"+$(this).attr('entity-type')+"/"+$(this).attr('entity-id')+"/"+$(this).attr('comment-id'),
                "url": Routing.generate('website_get_comment_form', {
                    'entityType': $(this).attr('entity-type'),
                    'entityId'  : $(this).attr('entity-id'),
                    'parent'  : $(this).attr('comment-id')
                }),
                "method": "GET",
                "headers": {}
            }
            var el = this;
            $.ajax(settings).done(function (response) {
                $('.media-body > form').remove();
                $( el ).after( response );
            });

        })

    $('.content').off('click', '.media.comment > .media-body  .comment-like')
        .on('click', '.media.comment > .media-body  .comment-like', function(event){
            self = this;
            var cid =$(self).attr('comment-id');
            var count = $(self).data().likeCount;
            var settings = {
                "async": true,
                "crossDomain": false,
                //"url": "/comment/get_form/"+$(this).attr('entity-type')+"/"+$(this).attr('entity-id')+"/"+$(this).attr('comment-id'),
                "url": Routing.generate('website_comment_like', {
                    'comment'  : cid
                }),
                "method": "POST",
                "headers": {}
            }
            var el = this;
            $.ajax(settings).done(function (response) {
                $(self).data('likeCount', count+1);
                $('.comment-like[comment-id="'+cid+'"] span.like-count').text(count+1);
            }).error(function (err) {
                alert('شما قبلا این نظر را لایک کرده اید.')
                $(self).prop('disabled', true);
            });


        })


    $('.content').off('click', '.media.comment > .media-body  ul.comment-report a')
        .on('click', '.media.comment > .media-body  ul.comment-report a', function(event){
            console.log('test');
            self = this;
            var cid =$(self).data().commentId;
            var claimId =$(self).data().claimTypeId;
            var settings = {
                "async": true,
                "crossDomain": false,
                "url": Routing.generate('website_comment_report', {
                    'comment'  : cid,
                    'report'   : claimId
                }),
                "method": "POST",
                "headers": {}
            }
            var el = this;
            $.ajax(settings).done(function (response) {
                alert('گزارش شما ثبت گردید')
                $('button.comment-report[data-comment-id="'+cid+'"]').prop('disabled', true);
            }).error(function (err) {
                alert('برای این نظر قبلا گزارش ثبت شده است')
                $('button.comment-report[data-comment-id="'+cid+'"]').prop('disabled', true);
            });


        })

    $('.content').off('click', '.media.comment > .media-body > .comment-more-button')
        .on('click', '.media.comment > .media-body > .comment-more-button', function(event){
            self = this;
            var cid =$(self).attr('comment-id');
            var lastChild = $('#children-'+cid+' div[id^="child-"]:last-child')[0];
            var lastId = $($(lastChild)[0]).attr('child-id');

            $('.media-body > form').remove();

            var settings = {
                "async": true,
                "crossDomain": false,
                //"url": "/comment/get_form/"+$(this).attr('entity-type')+"/"+$(this).attr('entity-id')+"/"+$(this).attr('comment-id'),
                "url": Routing.generate('website_get_comment_children', {
                    'comment'  : cid,
                    'lastId'  : lastId
                }),
                "method": "GET",
                "headers": {}
            }
            var el = this;
            $.ajax(settings).done(function (response) {
                $('#children-'+cid).append(response.children);
                if(response.count < 5) {
                    $(self).css('display','none');
                }
            });

        })


    $('#comment-file-list').dkUpload({
        browse_button: 'comment-file-browse',
        start_upload_button: 'comment-start-upload'
    });
})
