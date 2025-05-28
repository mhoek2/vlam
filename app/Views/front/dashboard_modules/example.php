<?php
function parse_entry_meta( $data ){
	if ( strlen($data) < 1 )
		return;

	$entries = json_decode($data, true);

	if ( !is_array($entries) || empty($entries) )
		return;
	
	foreach( $entries as $entry )
	{
		echo "<b>" . $entry['entry_name'] . "</b><br>";

		// mcq?
		if ( !is_null($entry['property_id']) && is_array($entry['value']) )
		{
			foreach( $entry['value'] as $value )
			{
				echo $value . "<br>";
			}
		}
		else {
			echo $entry['value'] . "<br>";
		}

		echo "<br><br>";
	}
}

parse_entry_meta( $meta['value'] );
?>

<?php  // $meta['value'] ?>