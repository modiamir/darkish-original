
$(document).ready(function () {

    var parentTrees = [];
    $('#classified-uptree-select option').each(function(){
        parentTrees.push($(this).data());
    })

    var subTrees = [];
    $('#classified-subtree-select option').each(function(){
        subTrees.push($(this).data());
    })

    if($('#classified-uptree-select option:selected').val() == 0) {
        $('#classified-subtree-select').empty();
    } else {
        $('#classified-subtree-select option[data-uptree-index!="'+$('#classified-uptree-select option:selected').val()+'"]').remove();
    }



    $('#classified-uptree-select').change(function(){
        var self = this;
        var parentTreeIndex = $('#classified-uptree-select option:selected').val();

        console.log(parentTreeIndex);
        if(parentTreeIndex == 0) {
            console.log($('#classified-subtree-select option:selected').val())
        }

        var newSubTrees = [];
        if(!parentTreeIndex) {
            newSubTrees = [];
        } else {
            newSubTrees = jQuery.grep(subTrees, function( type, index ) {
                return ( type.uptreeIndex == parentTreeIndex );
            });
        }

        $('#classified-subtree-select').empty();
        $('#classified-subtree-select').append($('<option>', {
            value: ""
        }));
        $.each(newSubTrees, function (i, item) {
            $('#classified-subtree-select').append($('<option>', {
                value: item.treeIndex,
                text : item.treeTitle
                //selected: (i == 0)? true : false
            }));
        });
    })


    $('#classified-subtree-select').change(function(){
        var selected = $('#classified-subtree-select option:selected').val();

        if(selected) {
            window.location.href = Routing.generate('website_classified', {'tree': selected});
        }
    })


})
