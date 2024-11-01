<?php

function post_revision_meta_box() {
	wp_nonce_field( basename( __FILE__ ), 'post_revision_meta_box_nonce' );
	?>
	<p>
		<label for="post_revision">Post Revision Excerpt</label>
		<textarea name="post_revision" id="post_revision" class="widefat"></textarea>
	</p>
	<?php
}
function post_revision_meta_box_add() {
	add_meta_box( 'post-revision-box-id', 'Put revision excerpt here!', 'post_revision_meta_box', 'post' );
}
add_action( 'add_meta_boxes', 'post_revision_meta_box_add' );


function post_revision_save() {
	// Check Autosave is ON
	if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
	// IF nonce fails return
	if ( !isset( $_POST['post_revision_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['post_revision_meta_box_nonce'], basename( __FILE__ ) ) ) return;
	// If user can not edit post return
	if ( !current_user_can( 'edit_post' ) ) return;
	// Check if update excerpt is provided 
	if ( isset( $_POST['post_revision'] ) && !empty( $_POST['post_revision'] ) ) {
		global $wpdb;

		$post_id 				= $_POST['post_ID'];
		$post_revision_excerpt 	= $_POST['post_revision'];

		$table_name 			= $wpdb->prefix . TABLE_NAME;
		// Prepare query
		$prepared_query = $wpdb->prepare( 'INSERT INTO ' . $table_name . ' (`post_id`, `revision_excerpt`) VALUES (%d, %s)', $post_id, $post_revision_excerpt );
		// die( $prepared_query );
		// Perform query
		$wpdb->query( $prepared_query );
	}
}
add_action( 'edit_post', 'post_revision_save' );