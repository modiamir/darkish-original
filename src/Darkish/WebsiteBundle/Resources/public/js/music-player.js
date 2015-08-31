$(document).ready(function(){

    var currentAudio = null;

    Cookies.set('darkish_musicplayer_is_open', true, { expires: 10 });
    setInterval(function(){
        Cookies.set('darkish_musicplayer_is_open', true, { expires: 10 });
    },10100);

    function playMusic(fileName) {
        console.log('Command "playMusic" run');
        console.log(fileName);

        var aud = document.createElement('audio');
        aud.setAttribute('controls', '');
        aud.setAttribute('width', '100%');
        aud.setAttribute('height', '100%');

        var src = document.createElement('source');
        src.setAttribute('type', 'audio/mpeg');
        src.setAttribute('src', fileName);

        aud.appendChild(src);

        $('body audio').remove();
        $('body').append(aud);
        aud.play();
        currentAudio =fileName;
        Cookies.expire('darkish_music_current');
    }




    setInterval(function(){

        var command = null;
        if(command = Cookies.get('command')) {
            switch(command) {
                case 'play':
                    if(Cookies.get('darkish_music_current') && Cookies.get('darkish_music_current') != currentAudio) {
                        playMusic(Cookies.get('darkish_music_current'));
                    }
                    break;
            }
        }




    }, 500);


})