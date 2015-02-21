CKEDITOR.plugins.add( 'halfhr', {
    icons: 'halfhr',
    init: function( editor ) {
        editor.addCommand( 'insertHalfhr', {
            exec: function( editor ) {
                editor.insertHtml( '<hr style="width:50%;" />' );
            }
        });
        editor.ui.addButton( 'Halfhr', {
            label: 'درج خط افقی ۵۰ درصد',
            command: 'insertHalfhr',
            toolbar: 'insert'
        });
    }
});