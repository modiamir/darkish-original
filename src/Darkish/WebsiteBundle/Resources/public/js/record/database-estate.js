function setSliders(boundries) {

    var queries = URI(window.location.href).search(true);

    
    var priceKey = "estate_search[price]";
    var secondaryPriceKey = "estate_search[secondaryPrice]";
    

    $("#estate_search_price").slider('destroy');
    $("#estate_search_secondaryPrice").slider('destroy');



    var priceMin = null;
    var priceMax = null;

    var secondaryPriceMin = null;
    var secondaryPriceMax = null;

    if($('#estate_search_contractType option:selected').val() == 2) {

        $('label[for="estate_search_secondaryPrice"]').show();

        $('label[for="estate_search_price"]').text('رهن');


        priceMin = boundries.estate_rent_price.min;
        priceMax = boundries.estate_rent_price.max;

        if(queries[priceKey]) {
            var queryPrice = queries[priceKey].split(',');
            priceMinVal = queryPrice[0];
            priceMaxVal = queryPrice[1];
        } else {
            priceMinVal = priceMin;
            priceMaxVal = priceMax;
        }




        secondaryPriceMin = boundries.estate_rent_secondary_price.min;
        secondaryPriceMax = boundries.estate_rent_secondary_price.max;

        if(queries[secondaryPriceKey]) {
            var querySecondaryPrice = queries[secondaryPriceKey].split(',');
            secondaryPriceMinVal = querySecondaryPrice[0];
            secondaryPriceMaxVal = querySecondaryPrice[1];
        } else {
            secondaryPriceMinVal = secondaryPriceMin;
            secondaryPriceMaxVal = secondaryPriceMax;
        }



        $('#estate_search_price')
            .attr('data-slider-id', 'estate_search_price_slider')
            .attr('data-slider-min', priceMin)
            .attr('data-slider-max', priceMax)
            .attr('data-slider-step', 1)
            .attr('data-slider-value', "["+priceMinVal+","+priceMaxVal+"]")
            .slider({
                formatter: function(value) {
                    return 'بازه قیمت: ' + value;
                }
            });

        $('#estate_search_secondaryPrice')
            .attr('data-slider-id', 'estate_search_secondaryPrice_slider')
            .attr('data-slider-min', secondaryPriceMin)
            .attr('data-slider-max', secondaryPriceMax)
            .attr('data-slider-step', 1)
            .attr('data-slider-value', "["+secondaryPriceMinVal+","+secondaryPriceMaxVal+"]")
            .slider({
                formatter: function(value) {
                    return 'بازه قیمت: ' + value;
                }
            });


    } else {

        $('#estate_search_secondaryPrice').hide();

        $('label[for="estate_search_price"]').text('قیمت');

        $('label[for="estate_search_secondaryPrice"]').hide();



        priceMin = boundries.estate_sell_price.min;
        priceMax = boundries.estate_sell_price.max;

        if(queries[priceKey]) {
            var queryPrice = queries[priceKey].split(',');
            priceMinVal = queryPrice[0];
            priceMaxVal = queryPrice[1];
        } else {
            priceMinVal = priceMin;
            priceMaxVal = priceMax;
        }




        $('#estate_search_price')
            .attr('data-slider-id', 'estate_search_price_slider')
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






}

$(document).ready(function(){

    $('#estate_search_secondaryPrice').hide();
    $('#estate_search_price').hide();

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
        $('#estate_search_secondaryPrice').show();
        $('#estate_search_price').show();
        setSliders(response);

        $('#estate_search_contractType').change(function(){
            setSliders(response);
        });

    });


})


