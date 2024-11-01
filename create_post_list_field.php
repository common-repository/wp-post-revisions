<?php

function post_revision_list_meta_box() {
	?>
	<p>
		<label for="post_revision">Post Revision List</label>
		<ul>
			<?php
			global $wpdb;
			$tableName 		= $wpdb->prefix . TABLE_NAME;
			$sql 			= "SELECT * FROM {$tableName} WHERE `post_id` = %s ORDER BY `id` DESC";
			$prepared_query = $wpdb->prepare( $sql, get_the_ID() );
			$results 		= $wpdb->get_results( $prepared_query, ARRAY_A );
			foreach( $results as $result ) :
			?>
				<li>
					<input type="hidden" class="post_revision_id" value="<?php echo esc_attr( $result['id'] ); ?>">
					<input type="text" name="post_excerpt_update" class="widefat post_excerpt_update" value="<?php echo esc_attr( stripcslashes( $result['revision_excerpt'] ) ) ?>">
					<span class="post_list_number"><?php echo esc_attr( $result['time'] ) .' : <span>'. esc_attr( stripcslashes( $result['revision_excerpt'] ) ) . '</span>' ?></span>
					<span class="edit_links"><a href="#" class="post_link_edit">Edit</a> | <a href="#" class="post_link_delete">Delete</a></span>
					<span class="update_links"><a href="#" class="post_link_update">Update</a> | <a href="#" class="post_link_cancel">Cancel</a></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</p>
	<?php
}
function post_revision_list_meta_box_add() {
	add_meta_box( 'post-revision-list-box-id', 'Revision List', 'post_revision_list_meta_box', 'post' );
	wp_enqueue_script( 'post-list', plugin_dir_url( __FILE__ ) . '/js/core.js', ['jquery'] );
}
add_action( 'add_meta_boxes', 'post_revision_list_meta_box_add' );

/*------------------Edit Revision---------------------------*/

function edit_post_revision() {
	$post_excerpt 	= isset( $_POST['post_excerpt'] ) ? $_POST['post_excerpt'] : null;
	$post_id 		= isset( $_POST['post_id'] ) ? $_POST['post_id'] : null;
	$message = '';
	if( !$post_excerpt ) {
		$message = 'delete';
		echo $message;
		die();
	}

	global $wpdb;
	$tableName = $wpdb->prefix . TABLE_NAME;

	$sql = 'UPDATE ' . $tableName . ' SET `revision_excerpt` = %s WHERE `id` = %s';
	$prepared_query = $wpdb->prepare( $sql, $post_excerpt, $post_id );
	if ( $wpdb->query( $prepared_query ) ) {
		$message = 'success';
	} else {
		$message = 'fail';
	}

	echo $message;
	die();

}
add_action( 'wp_ajax_edit_post_revision', 'edit_post_revision' );
/*------------------Edit Revision---------------------------*/

/*------------------Delete Revision---------------------------*/

function delete_post_revision() {
	$post_id 		= isset( $_POST['post_id'] ) ? $_POST['post_id'] : null;
	$message = '';
	
	global $wpdb;
	$tableName = $wpdb->prefix . TABLE_NAME;

	$sql = 'DELETE FROM ' . $tableName . ' WHERE `id` = %s';
	$prepared_query = $wpdb->prepare( $sql, $post_id );
	if ( $wpdb->query( $prepared_query ) ) {
		$message = 'success';
	} else {
		$message = 'fail';
	}

	echo $message;
	die();

}
add_action( 'wp_ajax_delete_post_revision', 'delete_post_revision' );

/*------------------Delete Revision---------------------------*/