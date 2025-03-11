<?php
if (! function_exists('setCSRFHeaderMeta')) {
    function setCSRFHeaderMeta() {
        return "<meta name='csrf-token' content='". csrf_hash() ."' />\n";
	}
}

if (! function_exists('updateCSRFMeta')) {
    function updateCSRFMeta() {
		$debug = array();
		
		if (ENVIRONMENT === 'development') {
			$debug[0] = "alert('missing crsf token');";
			$debug[1] = "console.log('new CSRF hash: ', response.new_csrf_token);";
		}
		
		// TODO:
		// look into : return <<<JS heredoc
        return "
			function updateCSRFMeta( response ){
				if ( typeof(response.new_csrf_token) === 'undefined')
				{
					". (isset($debug[0]) ? $debug[0] : '') ."
					location.reload();
				}

				". (isset($debug[1]) ? $debug[1] : '') ."

				$('input[name=". csrf_token() ."]').val(response.new_csrf_token);
				$('meta[name=\"csrf-token\"]').attr('content', response.new_csrf_token );
			}
			";
    }
}

if (! function_exists('setCSRFPostData')) {
    function setCSRFPostData() {
        return "'". csrf_token() ."': $('meta[name=\"csrf-token\"]').attr('content')\n";
	}
}
