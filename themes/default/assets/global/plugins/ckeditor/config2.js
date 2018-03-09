/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	 config.language = 'vi';

	 //config.htmlEncodeOutput = true;
	 config.skin = 'office2013'; 
	// config.uiColor = '#AADC6E';
	 config.filebrowserBrowseUrl = 'http://adminweb.anvui.vn/media-ckeditor';
	 config.filebrowserImageUploadUrl = 'http://adminweb.anvui.vn/media-upload'; 
	 config.extraPlugins = 'youtube';
	 config.extraPlugins = 'lineheight';
	 config.extraPlugins = 'eqneditor';
	 config.enterMode = CKEDITOR.ENTER_BR;
	 //config.toolbar = [{ name: 'insert', items: ['Image', 'Youtube']}];
	 //config.extraPlugins = 'justify';
	 // config.extraPlugins = 'image2';
	 // config.extraPlugins = 'dialog';
	 // config.extraPlugins = 'widget';
	 // config.extraPlugins = 'lineutils';
	 // config.extraPlugins = 'clipboard';
	 //config.extraPlugins = 'wenzgmap';
	//config.toolbarGroups = [
	//     { name: 'document',    groups: [ 'mode' ]},
	//     { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
	//     //{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
	//     //{ name: 'forms' },
	//     //{ name: 'links' },
	//     { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },

	//     { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
	    
	//     { name: 'insert' },
	//     '/',
	//     { name: 'styles' },
	//     { name: 'colors' },
	//     { name: 'tools' },
	//     { name: 'links' },
	//     //{ name: 'others' },
	//     //{ name: 'about' }
	// ];
	// Toolbar configuration generated automatically by the editor based on config.toolbarGroups.
// config.toolbar = [
// 	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'NewPage','-', 'Templates' ] },
	
// 	//{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
// 	//{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
	
// 	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote',  '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
	
// 	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
	
// 	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
// 	{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
// 	{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
// 	{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
// 	{ name: 'others', items: [ '-' ] },
// 	{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
// 	{ name: 'insert', items: [ 'Image',  'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak','Youtube' ] },
// ];

// Toolbar groups configuration.
// config.toolbarGroups = [
// 	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
// 	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
// 	{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
// 	{ name: 'forms' },
// 	'/',
// 	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
// 	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
// 	{ name: 'links' },
// 	{ name: 'insert' },
// 	'/',
// 	{ name: 'styles' },
// 	{ name: 'colors' },
// 	{ name: 'tools' },
// 	{ name: 'others' },
	
// ];
};
