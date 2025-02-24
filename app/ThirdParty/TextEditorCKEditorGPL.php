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
				Autosave,
				BlockQuote,
				Bold,
				Essentials,
				Heading,
				ImageBlock,
				ImageInline,
				ImageToolbar,
				Indent,
				IndentBlock,
				Italic,
				Link,
				List,
				ListProperties,
				Paragraph,
				Table,
				TableCaption,
				TableCellProperties,
				TableColumnResize,
				TableProperties,
				TableToolbar,
				TodoList,
				Underline
			} from '" . site_url() . "assets/ckeditor/ckeditor5.js';

			function set_text_editor( elementID ){
				ClassicEditor.create( document.querySelector( elementID ), {
					toolbar: {
							items: [
								'heading',
								'|',
								'bold',
								'italic',
								'underline',
								'|',
								'link',
								'insertTable',
								'blockQuote',
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
							Autosave,
							BlockQuote,
							Bold,
							Essentials,
							Heading,
							ImageBlock,
							ImageInline,
							ImageToolbar,
							Indent,
							IndentBlock,
							Italic,
							Link,
							List,
							ListProperties,
							Paragraph,
							Table,
							TableCaption,
							TableCellProperties,
							TableColumnResize,
							TableProperties,
							TableToolbar,
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
						image: {
							toolbar: ['imageTextAlternative']
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
