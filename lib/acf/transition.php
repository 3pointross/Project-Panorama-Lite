<?php
	
function psp_update_sub_field( $selector, $value, $post_id = false ) {
	
	// filter post_id
	// $post_id = acf_get_valid_post_id( $post_id );
	
	
	// vars
	$field = false;
	$name = '';
	
	
	// within a have_rows loop
	if( is_string($selector) ) {
		
		
		// loop over global data
		if( !empty($GLOBALS['acf_field']) ) {
			
			foreach( $GLOBALS['acf_field'] as $row ) {
				
				// add to name
				$name .= "{$row['name']}_{$row['i']}_";
				
				
				// override $post_id
				$post_id = $row['post_id'];
				
			}
			
		}
		
		
		// get sub field
		$field = get_sub_field_object( $selector );
		
		
		// create dummy field
		if( !$field ) {
		
			$field = acf_get_valid_field(array(
				'name'	=> $selector,
				'key'	=> '',
				'type'	=> '',
			));
			
		}
		
		
		// append name
		$name .= $field['name'];
		
		
		// update name
		$field['name'] = $name;
		
		
	} elseif( is_array($selector) ) {
		
		// validate
		if( count($selector) < 3 ) {
			
			return false;
			
		}
		
		
		// vars
		$parent_name = acf_extract_var( $selector, 0 );
		
		
		// load parent
		$field = get_field_object( $parent_name, $post_id, false, false );
		
		
		// add to name
		$name .= "{$field['name']}";
		
		
		// sub fields
		foreach( $selector as $s ) {
				
			if( is_numeric($s) ) {
				
				$row_i = intval($s) - 1;
				
				// add to name
				$name .= "_{$row_i}";
				
			} else {
				
				// update parent
				$field = acf_get_sub_field( $s, $field );
				
				
				// create dummy field
				if( !$field ) {
				
					$field = acf_get_valid_field(array(
						'name'	=> $s,
						'key'	=> '',
						'type'	=> '',
					));
					
				}
				
				
				// add to name
				$name .= "_{$field['name']}";
				
			}
			// if
			
		}
		// foreach
		
		
		// update name
		$field['name'] = $name;
				
				
	}
	
	// save
	return acf_update_value( $value, $post_id, $field );
		
}
	
	
?>