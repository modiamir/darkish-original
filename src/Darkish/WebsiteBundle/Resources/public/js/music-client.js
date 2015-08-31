
function DarkishMusicClient() {

    var self = this;

    self.isPlayerOpen = false;



    self.setIsPlayerOpen = function(value) {
        self.isPlayerOpen = value;
    }

    self.getIsPLayerOpen = function() {
        return self.isPlayerOpen;
    }

    self.init = function () {
        self.isPlayerOpen = Cookies.get('darkish_musicplayer_is_open');
        setInterval(function(){
            self.isPlayerOpen  = Cookies.get('darkish_musicplayer_is_open');
            console.info('isPlayerOpen', self.isPlayerOpen);
        }, 5000);
    }


    self.playMusic = function(fileName) {
        console.log(self.isPlayerOpen);
        if(self.isPlayerOpen) {
            Cookies.expire('darkish_music_current');
            Cookies.set('darkish_music_current', fileName);
            Cookies.set('command', 'play');
        } else {
            Cookies.expire('darkish_music_current');
            Cookies.set('darkish_music_current', fileName);
            Cookies.set('command', 'play');
            var win = window.open('http://localhost/n-darkish/web/app_dev.php/play','darkish_audioplayer','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=350');

        }
    }

}




