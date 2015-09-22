(function( $ ) {




    $.fn.dkUpload = function(options) {


        var self = this;

        function insertHr() {
            self.find('hr').remove();

            self.find('div[class^="col-xs"]:nth-child(3n+3)').after('<hr style="display: inline-block; width: 100%;" />')
        }


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

        // This is the easiest way to have default options.
        var settings = $.extend({
            // These are the defaults.
            browse_button: "browse",
            max_file_size: "5mb",
            extensions: "jpg, png",
            start_upload_button: "start-upload"
        }, options );

        this.data('index', 0);

        var url = this.data().url;
        var uploader = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
            browse_button: settings.browse_button, // this can be an id of a DOM element or the DOM element itself
            url: url,
            filters : {
                max_file_size : settings.max_file_size,
                mime_types: [
                    {title : "Image files", extensions : settings.extensions}
                ]
            },
        });

        uploader.init();


        uploader.bind('FilesAdded', function(up, files) {
            var html = '';
            plupload.each(files, function(file) {
                var preloader = new mOxie.Image();
                html =
                    '<div class="col-xs-4" id="' + file.id + '">' +
                        '<div class="thumbnail">' +
                            '<img width="100%" style="object-fit:contain; height:150px" src="'+''+'" alt="...">'+
                            '<div class="caption">'+
                                '<div class="progress">'+
                                    '<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">'+
                                    '</div>'+
                                '</div>'+
                                plupload.formatSize(file.size) +
                                '<a href="javascript:;" class="btn pull-left btn-sm btn-danger remove">حذف</a>'+
                            '</div>'+
                        '</div>'+
                    '</div>';

                preloader.onload = function(){
                    preloader.downsize( 300, 300 );

                    $('#'+file.id+' img').prop( "src", preloader.getAsDataURL() );
                }
                preloader.load(file.getSource());


                self.append(html);
                insertHr();

                $('#' + file.id + ' a.remove').first().on('click', function() {
                    uploader.removeFile(file);
                    $('#' + file.id).remove();
                    insertHr();
                });

            });
            //document.getElementById('filelist').innerHTML += html;
        });

        uploader.bind('UploadProgress', function(up, file) {
            $('#'+file.id+' .progress-bar').css('width', file.percent+'%').attr('aria-valuenow', file.percent)
                .text(file.percent+'%');

        });


        uploader.bind('Error', function(up, err) {
            self.find('console').append("\nError #" + err.code + ": " + err.message);
        });


        uploader.bind('FileUploaded', function(up, file, object) {
            var response;
            try {
                response = eval(object.response);
            } catch(err) {
                response = eval('(' + object.response + ')');
            }

            addImageForm(self, file, response);
        });

        $('#'+settings.start_upload_button).on('click', function() {
            uploader.start();
        });

        console.log(uploader);

        return this;

    };

}( jQuery ));