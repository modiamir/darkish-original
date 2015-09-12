$(document).ready(function(){




    $('ul.operation-icons li.switch').click(function (event) {
        $('ul.operation-icons li.switch').removeClass('active');
        $(this).addClass('active');



        $('.gallery-box .switchable').removeClass('active');
        $('.gallery-box .switchable.'+$(this).attr('dk-open')).addClass('active');
        if($(this).attr('dk-open') == 'map' && $('.gallery-box .switchable.map #map').attr('dk-displayed') != "1") {
            var center= $('.gallery-box .switchable.map #map').data();
            console.log(center);
            addMarker([center.latitude, center.longitude]);
            $('.gallery-box .switchable.map #map').attr('dk-displayed', "1");

        }
    })

    $('ul.operation-icons li.switch:first-child').addClass('active');
    $('.gallery-box .switchable:first-child').addClass('active');

    $('ul.operation-icons').removeClass('hidden');

    $('a[href^="#"]').on('click',function (e) {
        e.preventDefault();

        var target = this.hash;
        var $target = $(target);

        $('html, body').stop().animate({
            'scrollTop': $target.offset().top
        }, 900, 'swing', function () {
            window.location.hash = target;
        });
    });




    //setTimeout(function(){ $('.gallery-box .switchable.map').addClass('loaded');}, 1000);


    function addLink() {
        //Get the selected text and append the extra info
        var selection = window.getSelection(),
            pagelink = '<br /><br /> Read more at: ' + document.location.href,
            copytext = selection + pagelink,
            newdiv = document.createElement('div');

        //hide the newly created container
        newdiv.style.position = 'absolute';
        newdiv.style.left = '-99999px';

        //insert the container, fill it with the extended text, and define the new selection
        document.body.appendChild(newdiv);
        newdiv.innerHTML = copytext;
        selection.selectAllChildren(newdiv);

        window.setTimeout(function () {
            document.body.removeChild(newdiv);
        }, 100);
    }

    document.addEventListener('copy', addLink);


})