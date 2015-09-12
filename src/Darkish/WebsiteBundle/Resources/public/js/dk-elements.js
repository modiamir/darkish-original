$(document).ready(function() {

    var musicClient = new DarkishMusicClient();
    musicClient.init();

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
});