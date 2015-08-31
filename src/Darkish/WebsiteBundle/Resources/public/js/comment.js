$('.media.comment > .media-body > .comment-reply-button').bind('click', function(event){
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


$('.media.comment > .media-body > .comment-more-button').bind('click', function(event){
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