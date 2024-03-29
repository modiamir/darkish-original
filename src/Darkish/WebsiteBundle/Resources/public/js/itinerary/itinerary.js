
$(document).ready(function() {







    $('.itinerary-body').readmore({
        moreLink: '<a href="#">ادامه</a>',
        lessLink: '<a href="#">کمتر</a>',
        embedCSS: true,
        blockCSS: 'margin: 10px; display: inline-block',
        collapsedHeight: 100

    });


    $('button[data-itinerary-id]').click(function(){
        var itineraryId = $(this).data().itineraryId;
        var self = this;
        $.get(Routing.generate('website_itinerary_get_comments', { itinerary: itineraryId }), function(data, status){
            $('.itinerary-comments').empty();
            $('#itinerary-comments-'+itineraryId).html(data);
            $('button[data-itinerary-id]').prop('disabled', false);
            $(self).prop('disabled', true);
            var uri = new URI(window.location.href);
            if(uri.search(true).page) {
                $('form[name="submit_anonymous_comment"]').append('<input type="hidden" name="page" value="'+uri.search(true).page+'" />');
            }

            $('#comment-file-list').dkUpload({
                browse_button: 'comment-file-browse',
                start_upload_button: 'comment-start-upload'
            });
        });

    })

    $('.media.itinerary').on('click', '.itinerary-comments ul.pagination a', function(e){
        e.preventDefault();
        self=this;
        $.get($(this).attr('href'), function(data, status){
            var wrapper = $(self).closest('.itinerary-comments');
            wrapper.empty();
            wrapper.html(data);
        });
    })




});
