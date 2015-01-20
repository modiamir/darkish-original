CKEDITOR.plugins.add( 'mycustom', {
    icons: 'mycustom',
    init: function( editor ) {
        CKEDITOR.on('dialogDefinition', function (ev) {
            // Take the dialog name and its definition from the event data.
            var dialogName = ev.data.name;
            var dialogDefinition = ev.data.definition;
            
            // Check if the definition is from the dialog window you are interested in (the "Link" dialog window).
            if (false && dialogName == 'image') {
                // Get a reference to the "Link Info" tab.
                var infoTab = dialogDefinition.getContents('info');
                infoTab.add({
                id : 'imageWidth',
                type : 'checkbox',
                label : 'عرض تصویر'
                });
                
                var onOk = dialogDefinition.onOk;

                dialogDefinition.onOk = function (e) {
//                    var imageSrcUrl = e.sender.originalElement.$.src;
//                    var imgHtml = CKEDITOR.dom.element.createFromHtml("<img src=" + imageSrcUrl + " alt='' align='right'/>");
//                    console.log(dialogDefinition);
//                    var classes = this.getContentElement( 'advanced', 'txtGenClass').getValue();
//                    console.log(this.getContentElement( 'advanced', 'txtGenClass'));
//                    if(this.getContentElement( 'info', 'imageWidth').getValue()) {
//                        classes = 'full-width-mobile '+ classes;
//                    } else {
//                        classes = ' '+ classes;
//                        classes.replace("full-width-mobile", "");
//                    }
//                    
//                    
//                    imgHtml.addClass(classes);
//                    
//                    editor.insertElement(imgHtml);
                    
                };
            }
            if (dialogName == 'table') {
                var advancedTab = dialogDefinition.getContents('advanced');
                var infoTab = dialogDefinition.getContents('info');
                console.log(infoTab);
                var urlField = advancedTab.get( 'advCSSClasses' );
                var widthField = infoTab.get( 'txtWidth' );
                urlField[ 'default' ] = 'body-table';
                widthField [ 'default' ] = '';
            }
            
        });
    }
});


