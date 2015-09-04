
$(document).ready(function () {


    $('#offer-uptree-select').change(function(){
        var treeIndex = $('#offer-uptree-select option:selected').val();
        if(treeIndex == "0") {
            console.log(treeIndex)
            window.location.href = Routing.generate('website_offer');
        } else {
            window.location.href = Routing.generate('website_offer', {'tree': treeIndex});
        }

    })


})
