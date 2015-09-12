function formatState (state) {
    var $state = $(

    '<div class="forumtree-select-option">'+
        '<a class="icon">'+
            '<img src="'+$(state.element).attr('tree-icon-src')+'">'+
        '</a>'+
        '<div class="tree-titles">'+
                '<h3>'+
                    '<a>'+$(state.element).attr('tree-title')+'</a>'+
                '</h3>'+
                '<span class="tree-subtitle">'+$(state.element).attr('tree-subtitle')+'</span>'+
        '</div>'+
    '</div>'

    );
    return $state;
};

function forwardToForumTree(evt) {
    var path = Routing.generate('website_forum_tree', {'treeIndex': $(evt.params.data.element).attr('tree-index')});
    window.location.href = path;
}


$(document).ready(function(){
    $('#forumtree-select').select2({
        templateResult: formatState
    });

    $('#forumtree-select').on("select2:select", forwardToForumTree);
})