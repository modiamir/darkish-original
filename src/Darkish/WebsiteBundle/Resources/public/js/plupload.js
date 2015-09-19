var $imageHolder;

$(document).ready(function () {

    $imageHolder = $('#filelist');
    $imageHolder.data('index', 0);

    var url = $('#filelist').data().url;
    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,silverlight,html4',
        browse_button: 'browse', // this can be an id of a DOM element or the DOM element itself
        url: url,
        filters : {
            max_file_size : '5mb',
            mime_types: [
                {title : "Image files", extensions : "jpg,png"}
            ]
        },
    });

    uploader.init();


    uploader.bind('FilesAdded', function(up, files) {
        var html = '';
        plupload.each(files, function(file) {
            var preloader = new mOxie.Image();
            html +=
                '<div class="col-xs-3" id="' + file.id + '">' +
                    '<div class="thumbnail">' +
                        '<img width="100%" src="'+''+'" alt="...">'+
                        '<div class="caption">'+
                            '<div class="progress">'+
                                '<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">'+
                                '</div>'+
                            '</div>'+
                            file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>'+
                        '</div>'+
                    '</div>'+
                '</div>';
            preloader.onload = function(){
                preloader.downsize( 300, 300 );

                $('#'+file.id+' img').prop( "src", preloader.getAsDataURL() );
            }
            preloader.load(file.getSource());
        });
        document.getElementById('filelist').innerHTML += html;
    });

    uploader.bind('UploadProgress', function(up, file) {
        $('#'+file.id+' .progress-bar').css('width', file.percent+'%').attr('aria-valuenow', file.percent)
            .text(file.percent+'%');

        document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
    });

    uploader.bind('Error', function(up, err) {
        document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
    });

    uploader.bind('FileUploaded', function(up, file, object) {
        var response;
        try {
            response = eval(object.response);
        } catch(err) {
            response = eval('(' + object.response + ')');
        }

        addImageForm($imageHolder, file, response);
    });


    document.getElementById('start-upload').onclick = function() {
        uploader.start();
    };
})

function addImageForm($imageHolder, file, response) {
    var prototype = $imageHolder.data('prototype');

    $newImageDiv = $('#'+file.id);

    // get the new index
    var index = $imageHolder.data('index');
    var newIndex = index + 1;
    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $imageHolder.data('index', newIndex);

    $newImageDiv.append(newForm);

    $('#'+file.id+ ' input[id$="fileName"]').attr('value', response.name);
    $('#'+file.id+ ' input[id$="type"]').attr('value', 'itinerary');
    $('#'+file.id+ ' input[id$="uploadDir"]').attr('value', 'image');



}