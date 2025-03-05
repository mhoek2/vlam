<?php

namespace App\ThirdPArty;

use App\ThirdParty\TextEditor;

class TextEditorCKEditorGPL extends TextEditor
{
	public function __construct( )
	{
		$this->apiKey = "GPL";
	}
	
	public function load_style()
	{
		return '<link rel="stylesheet" href="http://vlam.hoeklab.nl/public/assets/ckeditor/ckeditor5.css">';
	}
	
	public function load_script()
	{
		return "
		<script type='module'>
		
			let CKEditorArray = [];

			import {
				ClassicEditor,
				Autoformat,
				AutoImage,
				Autosave,
				BlockQuote,
				Bold,
				Emoji,
				Essentials,
				FindAndReplace,
				GeneralHtmlSupport,
				Heading,
				HtmlComment,
				HtmlEmbed,
				ImageBlock,
				ImageCaption,
				ImageInline,
				ImageInsertViaUrl,
				ImageResize,
				ImageStyle,
				ImageTextAlternative,
				ImageToolbar,
				Indent,
				IndentBlock,
				Italic,
				Link,
				LinkImage,
				List,
				ListProperties,
				MediaEmbed,
				Mention,
				Paragraph,
				PasteFromOffice,
				ShowBlocks,
				SourceEditing,
				Table,
				TableCaption,
				TableCellProperties,
				TableColumnResize,
				TableProperties,
				TableToolbar,
				TextTransformation,
				TodoList,
				Underline
			} from '" . site_url() . "assets/ckeditor/ckeditor5.js';

			function set_text_editor( elementID ){
				ClassicEditor.create( document.querySelector( elementID ), {
					toolbar: {
							items: [
								'sourceEditing',
								'showBlocks',
								'findAndReplace',
								'|',
								'heading',
								'|',
								'bold',
								'italic',
								'underline',
								'|',
								'emoji',
								'link',
								'insertImageViaUrl',
								'mediaEmbed',
								'insertTable',
								'blockQuote',
								'htmlEmbed',
								'|',
								'bulletedList',
								'numberedList',
								'todoList',
								'outdent',
								'indent'
							],
							shouldNotGroupWhenFull: false
						},
						plugins: [
							Autoformat,
							AutoImage,
							Autosave,
							BlockQuote,
							Bold,
							Emoji,
							Essentials,
							FindAndReplace,
							GeneralHtmlSupport,
							Heading,
							HtmlComment,
							HtmlEmbed,
							ImageBlock,
							ImageCaption,
							ImageInline,
							ImageInsertViaUrl,
							ImageResize,
							ImageStyle,
							ImageTextAlternative,
							ImageToolbar,
							Indent,
							IndentBlock,
							Italic,
							Link,
							LinkImage,
							List,
							ListProperties,
							MediaEmbed,
							Mention,
							Paragraph,
							PasteFromOffice,
							ShowBlocks,
							SourceEditing,
							Table,
							TableCaption,
							TableCellProperties,
							TableColumnResize,
							TableProperties,
							TableToolbar,
							TextTransformation,
							TodoList,
							Underline
						],
						heading: {
							options: [
								{
									model: 'paragraph',
									title: 'Paragraph',
									class: 'ck-heading_paragraph'
								},
								{
									model: 'heading1',
									view: 'h1',
									title: 'Heading 1',
									class: 'ck-heading_heading1'
								},
								{
									model: 'heading2',
									view: 'h2',
									title: 'Heading 2',
									class: 'ck-heading_heading2'
								},
								{
									model: 'heading3',
									view: 'h3',
									title: 'Heading 3',
									class: 'ck-heading_heading3'
								},
								{
									model: 'heading4',
									view: 'h4',
									title: 'Heading 4',
									class: 'ck-heading_heading4'
								},
								{
									model: 'heading5',
									view: 'h5',
									title: 'Heading 5',
									class: 'ck-heading_heading5'
								},
								{
									model: 'heading6',
									view: 'h6',
									title: 'Heading 6',
									class: 'ck-heading_heading6'
								}
							]
						},
						htmlSupport: {
							allow: [
								{
									name: /^.*$/,
									styles: true,
									attributes: true,
									classes: true
								}
							]
						},
						htmlEmbed: {
							allowedContent: {
								iframe: true
							}
						},
						image: {
							toolbar: [
								'toggleImageCaption',
								'imageTextAlternative',
								'|',
								'imageStyle:inline',
								'imageStyle:wrapText',
								'imageStyle:breakText',
								'|',
								'resizeImage'
							]
						},
						licenseKey: '{$this->apiKey}',
						link: {
							addTargetToExternalLinks: true,
							defaultProtocol: 'https://',
							decorators: {
								toggleDownloadable: {
									mode: 'manual',
									label: 'Downloadable',
									attributes: {
										download: 'file'
									}
								}
							}
						},
						list: {
							properties: {
								styles: true,
								startIndex: true,
								reversed: true
							}
						},
						mention: {
							feeds: [
								{
									marker: '@',
									feed: [
										/* See: https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html */
									]
								}
							]
						},
						placeholder: 'Type or paste your content here!',
						table: {
							contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
						}
				} )
				.then( editor => {
					CKEditorArray[elementID] = editor;
				} )
				.catch( error => {
					console.error( error );
				} );
			}
			
			window.set_text_editor = set_text_editor;
			window.CKEditorArray = CKEditorArray;
		</script>
		";
	}	
	
	public function init_script()
	{
		return '';
	}
	
	public function assign_editor( $dom_id )
	{
		return "window.set_text_editor( {$dom_id} );";
	}
	
	public function get( $dom_id )
	{
		return "window.CKEditorArray[ {$dom_id} ].getData();";
	}
}
