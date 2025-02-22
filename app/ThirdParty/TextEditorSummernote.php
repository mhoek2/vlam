<?php

namespace App\ThirdPArty;

use App\ThirdParty\TextEditor;

class TextEditorSummernote extends TextEditor
{
    public function __construct()
    {
        $this->apiKey = "";  // You can add an API key here if necessary
    }

    public function load_style()
    {
        return '
		<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
		<style>
			.note-editor.note-airframe, .note-editor.note-frame {
				text-align: initial;
				background:#fff;
			}
		</style>
		';
    }

    public function load_script()
    {
        return '<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>';
    }

    public function init_script()
    {
        return "
            function set_text_editor( elementID ) {
				$(elementID).summernote({
					height: 300,
					toolbar: [
						['style', ['bold', 'italic', 'underline', 'clear']],
						['font', ['strikethrough', 'superscript', 'subscript']],
						['font', ['fontname', 'fontsize', 'color', 'background']],
						['para', ['ul', 'ol', 'paragraph']],
						/*['insert', ['link', 'picture', 'video']],*/
						['table', ['table']],
						['view', ['fullscreen', 'codeview', 'help']],
					],
					fontNames: ['Arial', 'Verdana', 'Times New Roman'],
					fontSizes: ['10', '12', '14', '18', '24', '36'],
					colors: [
						['#000000', '#FF0000', '#00FF00', '#0000FF', '#FFFF00'],
						['#FF00FF', '#00FFFF', '#000000', '#CCCCCC', '#FFFFFF'],
					], 
					callbacks: {
						onImageUpload: function(files) {
							
						},
						onMediaDelete: function(target) {
							
						}
					}
				});
            }
        ";
    }

    public function assign_editor($dom_id)
    {
        return "set_text_editor( {$dom_id} );";
    }

    public function get($dom_id)
    {
        return "$( {$dom_id} ).summernote('code');";
    }
}
