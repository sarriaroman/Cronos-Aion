﻿/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
   // Define changes to default configuration here. For example:
   // config.language = 'fr';
   // config.skin = 'office2003';
   //config.removePlugins =  'elementspath,enterkey,entities,forms,pastefromword,htmldataprocessor,specialchar' ;
   config.removePlugins =  'elementspath,enterkey,entities,forms,pastefromword,htmldataprocessor,specialchar,horizontalrule,wsc' ;
   //config.toolbar = 'Basic';
   config.width = 660;
   config.resize_enabled = false;
   config.skin = 'v2';
   CKEDITOR.config.toolbar = [
   ['Styles','Format','Font','FontSize'],
   '/',
   ['Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','Outdent','Indent'],
   '/',
   ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
   ['Image','Table','-','Link','Flash','Smiley','TextColor','BGColor','Source']
] ;

};
