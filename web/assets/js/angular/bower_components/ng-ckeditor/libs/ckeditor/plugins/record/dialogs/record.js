/**
 * Copyright (c) 2014, CKSource - Frederico Knabben. All rights reserved.
 * Licensed under the terms of the MIT License (see LICENSE.md).
 *
 * The abbr plugin dialog window definition.
 *
 * Created out of the CKEditor Plugin SDK:
 * http://docs.ckeditor.com/#!/guide/plugin_sdk_sample_1
 */

// Our dialog definition.
CKEDITOR.dialog.add( 'recordDialog', function( editor ) {
	return {

		// Basic properties of the dialog window: title, minimum size.
		title: 'Record Properties',
		minWidth: 400,
		minHeight: 200,

		// Dialog window content definition.
		contents: [
			{
				// Definition of the Basic Settings dialog tab (page).
				id: 'tab-basic',
				label: 'Basic Settings',

				// The tab content.
				elements: [
					{
						// Text input field for the record text.
						type: 'text',
						id: 'text',
						label: 'متن',

						// Validation checking whether the field is not empty.
						validate: CKEDITOR.dialog.validate.notEmpty( "Record field cannot be empty." )
					},
					{
						// Text input field for the record title (explanation).
						type: 'text',
						id: 'recordId',
						label: 'شماره رکورد',
						validate: CKEDITOR.dialog.validate.notEmpty( "Explanation field cannot be empty." )
					}
				]
			}
		],

		// This method is invoked once a user clicks the OK button, confirming the dialog.
		onOk: function() {

			// The context of this function is the dialog object itself.
			// http://docs.ckeditor.com/#!/api/CKEDITOR.dialog
			var dialog = this;

			// Create a new <abbr> element.
			var record = editor.document.createElement( 'span' );

			// Set element attribute and text by getting the defined field values.
			record.setAttribute( 'record-id', dialog.getValueOf( 'tab-basic', 'recordId' ) );
			record.setAttribute( 'class', 'body inner-link' );
			record.setText( dialog.getValueOf( 'tab-basic', 'text' ) );

			
			editor.insertElement( record );
		}
	};
});
