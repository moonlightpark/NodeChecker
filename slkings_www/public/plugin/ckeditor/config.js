/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	console.log(config);
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.font_names = 'Gulim/Gulim;Dotum/Dotum;Arial/Arial;Verdana/Verdana';
	config.allowedContent = true;
		//CKEDITOR.dtd.$removeEmpty.span = 0;
	//config.fontSize_defaultLabel = '72px';	
	//config.extraPlugins='dragresize';
};
