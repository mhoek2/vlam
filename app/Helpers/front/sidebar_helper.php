<?php

if (! function_exists('load_sidebar')) {
    function load_sidebar( &$data )
    {
		$data['sidebar'] = view('front/sidebar', $data);
    }
}