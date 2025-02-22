<?php

namespace App\ThirdPArty;

use App\ThirdParty\TextEditor;

class TextEditorCKEditor extends TextEditor
{
	public function __construct( )
	{
		$this->apiKey = "eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NzA0MjIzOTksImp0aSI6IjdiNzA0MzZhLWE2MDMtNGI2Yi1hOGQxLTJmYzk3MWEzYmIxYyIsImxpY2Vuc2VkSG9zdHMiOlsiMTI3LjAuMC4xIiwibG9jYWxob3N0IiwiMTkyLjE2OC4qLioiLCIxMC4qLiouKiIsIjE3Mi4qLiouKiIsIioudGVzdCIsIioubG9jYWxob3N0IiwiKi5sb2NhbCJdLCJ1c2FnZUVuZHBvaW50IjoiaHR0cHM6Ly9wcm94eS1ldmVudC5ja2VkaXRvci5jb20iLCJkaXN0cmlidXRpb25DaGFubmVsIjpbImNsb3VkIiwiZHJ1cGFsIl0sImxpY2Vuc2VUeXBlIjoiZGV2ZWxvcG1lbnQiLCJmZWF0dXJlcyI6WyJEUlVQIiwiQk9YIl0sInZjIjoiZDYwZjUzMDUifQ.z2QBK-JsDzcivBdrBMos8JHYhKbS4nUDXdFJkRtnmpyThmyA9JEfG5mFfGjIN8pZCdtrTYrirVWdxKcm5Ptkhw";
	}
	
	public function load_style()
	{
		return '<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css">';
	}
	
	public function load_script()
	{
		return '<script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js"></script>';
	}
	
	public function init_script()
	{
		return "
			let CKEditorArray = [];
			
			const {
				ClassicEditor,
				Essentials,
				Paragraph,
				Bold,
				Italic,
				Font,
				Heading,
				Link,
				BlockQuote,
				CodeBlock,
				List,
				TodoList,
			} = CKEDITOR;
			
			function set_text_editor( elementID ){
				ClassicEditor.create( document.querySelector( elementID ), {
					licenseKey: '{$this->apiKey}',
					plugins: [ Essentials, Paragraph, Bold, Font, Heading, Link, Italic, BlockQuote, CodeBlock, List, TodoList, ],
					toolbar: {
						items: [
							'undo', 'redo',
							'|',
							'heading',
							'|',
							'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
							'|',
							'bold', 'italic', 'strikethrough', 'subscript', 'superscript', 'code',
							'|',
							'link', 'uploadImage', 'blockQuote', 'codeBlock',
							'|',
							'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent'
						],
						shouldNotGroupWhenFull: false
					}
				} )
				.then( editor => {
					CKEditorArray[elementID] = editor;
				} )
				.catch( error => {
					console.error( error );
				} );
			}
		";
	}
	
	public function assign_editor( $dom_id )
	{
		return "set_text_editor( {$dom_id} );";
	}
	
	public function get( $dom_id )
	{
		return "CKEditorArray[ {$dom_id} ].getData();";
	}
}
