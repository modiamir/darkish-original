function setSliders(boundries) {

    var queries = URI(window.location.href).search(true);

    
    var priceKey = "automobile_search[price]";
    
    

    $("#automobile_search_price").slider('destroy');
    


    var priceMin = null;
    var priceMax = null;

    $('#automobile_search_secondaryPrice').hide();

    $('label[for="automobile_search_price"]').text('قیمت');

    $('label[for="automobile_search_secondaryPrice"]').hide();



    priceMin = boundries.automobile_price.min;
    priceMax = boundries.automobile_price.max;

    if(queries[priceKey]) {
        var queryPrice = queries[priceKey].split(',');
        priceMinVal = queryPrice[0];
        priceMaxVal = queryPrice[1];
    } else {
        priceMinVal = priceMin;
        priceMaxVal = priceMax;
    }




    $('#automobile_search_price')
        .attr('data-slider-id', 'automobile_search_price_slider')
        .attr('data-slider-min', priceMin)
        .attr('data-slider-max', priceMax)
        .attr('data-slider-step', 1)
        .attr('data-slider-value', "["+priceMinVal+","+priceMaxVal+"]")
        .slider({
            formatter: function(value) {
                return 'بازه قیمت: ' + value;
            }
        });







}

$(document).ready(function(){

    $('#automobile_search_secondaryPrice').hide();
    $('#automobile_search_price').hide();

    var settings = {
        "async": true,
        "crossDomain": false,
        "dataType": "json",
        //"url": "/comment/get_form/"+$(this).attr('entity-type')+"/"+$(this).attr('entity-id')+"/"+$(this).attr('comment-id'),
        "url": Routing.generate('website_record_database_boundries'),
        "method": "GET",
        "headers": {}
    }
    var el = this;
    $.ajax(settings).done(function (response) {
        $('#automobile_search_secondaryPrice').show();
        $('#automobile_search_price').show();
        setSliders(response);
    });

    var allTypes = [];
    $('#automobile_search_automobileType').empty();
    var settings = {
        "async": true,
        "crossDomain": false,
        "dataType": "json",
        //"url": "/comment/get_form/"+$(this).attr('entity-type')+"/"+$(this).attr('entity-id')+"/"+$(this).attr('comment-id'),
        "url": Routing.generate('website_record_database_automobile_data'),
        "method": "GET",
        "headers": {}
    }
    var el = this;
    $.ajax(settings).done(function (response) {
        $('#automobile_search_automobileBrand').change(function(){
            allTypes = response;
            var self = this;
            var selectedId = $('#automobile_search_automobileBrand option:selected').val();
            var types = [];
            if(!selectedId) {
                types = [];
            } else {
                types = jQuery.grep(allTypes, function( type, index ) {
                    return ( type.parent_id == selectedId );
                });
            }

            $('#automobile_search_automobileType').empty();
            $('#automobile_search_automobileType').append($('<option>', {
                value: ""
            }));
            $.each(types, function (i, item) {
                $('#automobile_search_automobileType').append($('<option>', {
                    value: item.id,
                    text : item.value
                }));
            });
        })
    });


})


