$(document).ready(function(){

    var musicClient = new DarkishMusicClient();
    musicClient.init();


    $('ul.operation-icons li.switch').click(function (event) {
        $('ul.operation-icons li.switch').removeClass('active');
        $(this).addClass('active');

        $('.gallery-box .switchable').removeClass('active');
        $('.gallery-box .switchable.'+$(this).attr('dk-open')).addClass('active');
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

    $('dk-img').each(function(index, value){

        var src = $(this).attr('src');
        var splittedSrc = src.split("/uploads/");

        a = document.createElement('a');


        a.setAttribute('href', splittedSrc[0]+'/media/cache/1024/uploads/'+splittedSrc[1]);

        a.setAttribute('data-lightbox', 'bodygallery');

        img = document.createElement('img');
        img.setAttribute('src', splittedSrc[0]+'/media/cache/256/uploads/'+splittedSrc[1]);

        span = document.createElement('span');

        a.appendChild(img);
        a.appendChild(span);

        $(this).replaceWith(a);
    })

    $('p').on($.modal.OPEN, 'dk-video-player', function(event, modal) {
        var vid = document.createElement('video');
        vid.setAttribute('preload', 'none');
        vid.setAttribute('controls', '');

        var src = document.createElement('source');
        src.setAttribute('src', $(modal.elm).attr('src'));
        src.setAttribute('type', $(modal.elm).attr('type'));

        vid.appendChild(src);

        $(modal.elm).append(vid);

        $(modal.elm).css('top', '20%');



    });

    $('p').on($.modal.CLOSE, 'dk-video-player', function(event, modal) {
        $(modal.elm).empty();
    });



    $('dk-video').each(function(index, value){
        var dkVideoPlayer = document.createElement('dk-video-player');
        dkVideoPlayer.setAttribute('class', $(this).attr('class') + ' modal');
        dkVideoPlayer.setAttribute('id', $(this).attr('class'));
        dkVideoPlayer.setAttribute('src', $(this).attr('src'));
        dkVideoPlayer.setAttribute('type', $(this).attr('type'));


        $(this).parent().append(dkVideoPlayer);
        var src = $(this).attr('src');
        var thumb = src.replace('video', 'video_thumbnail').replace('.mp4', '.jpg');

        a = document.createElement('a');


        a.setAttribute('href', '#'+$(this).attr('class'));
        a.setAttribute('rel', 'modal:open');
        a.setAttribute('class', 'dk-video-modal');

        span = document.createElement('span');


        //a.setAttribute('data-lightbox', 'bodygallery');

        img = document.createElement('img');
        img.setAttribute('src', thumb);

        a.appendChild(img);
        a.appendChild(span);
        $(this).replaceWith(a);


    })
    
    




    $('dk-audio').each(function(index, value){

        var src = $(this).attr('src');

        a = document.createElement('a');


        a.setAttribute('href', '#'+$(this).attr('class'));
        a.setAttribute('class', 'dk-audio-play');
        a.setAttribute('audio-url', src);



        //a.setAttribute('data-lightbox', 'bodygallery');

        span = document.createElement('span');

        a.appendChild(span);

        $(this).replaceWith(a);


    })
    
    ///

    $('a.dk-audio-play').on('click', function(e){


        musicClient.playMusic($(this).attr('audio-url'));



    })


    setTimeout(function(){ $('.gallery-box .switchable.map').addClass('loaded');}, 1000);


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