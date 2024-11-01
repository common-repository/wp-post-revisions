<?php

function post_revisions_content( $content ) {
	if ( !is_singular( 'post' ) ) return;

	global $wpdb;
	$table_name = $wpdb->prefix . TABLE_NAME;
	$post_revision_title = get_option( 'post_revisions_presentation_title' );
	$post_revision_count = get_option( 'post_revisions_presentation_count' );

	$post_revision_excerpt = $wpdb->get_results( 'SELECT * FROM ' . $table_name . ' WHERE `post_id` = ' . get_the_ID() . ' ORDER BY id DESC LIMIT ' . $post_revision_count, ARRAY_A );


	if( $post_revision_excerpt ) {
		$post_revision_excerpt_box = '<p><div id="pk-post-revision-box">';
		$post_revision_excerpt_box .= '<h4>'. $post_revision_title .'</h4>';
		foreach ($post_revision_excerpt as $revision_excerpt) {
			$post_revision_excerpt_box .= '<span>'. esc_attr( $revision_excerpt['time'] ) .' : '. esc_attr( stripcslashes( $revision_excerpt['revision_excerpt'] ) ) .'</span><br>';
		}
		$post_revision_excerpt_box .= '</div></p>';


		$content = $content . $post_revision_excerpt_box;
	}

	return $content;
}
add_filter( 'the_content', 'post_revisions_content' );