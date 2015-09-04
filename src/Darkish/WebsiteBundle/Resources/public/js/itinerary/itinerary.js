var $collectionHolder;

// setup an "add a tag" link
var $addTagLink = $('<a href="#" class="add_tag_link">Add a file</a>');
var $newLinkLi = $('<li></li>').append($addTagLink);

$(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('#darkish_category_bundle_itinerary_form_photos');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($addTagLink);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $addTagLink);
    });









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
            $('#itinerary-comments-'+itineraryId).html(data);
            $(self).remove();
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


function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before(newForm);
}