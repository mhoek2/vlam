<?php
if (! function_exists('download_url')) {
    function download_url( $path ) : string {
    	return base_url( route_to( 'front.download', $path ) );
    }
}