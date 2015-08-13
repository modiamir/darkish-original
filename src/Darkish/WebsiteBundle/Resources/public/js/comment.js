jQuery('.media.comment > .media-body > .comment-reply-button').bind('click', function(event){
    var settings = {
        "async": true,
        "crossDomain": false,
        //"url": "/comment/get_form/"+jQuery(this).attr('entity-type')+"/"+jQuery(this).attr('entity-id')+"/"+jQuery(this).attr('comment-id'),
        "url": Routing.generate('website_get_comment_form', {
            'entityType': jQuery(this).attr('entity-type'),
            'entityId'  : jQuery(this).attr('entity-id'),
            'parent'  : jQuery(this).attr('comment-id')
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

