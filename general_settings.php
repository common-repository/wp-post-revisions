<?php

function post_revisions_presentation_section() {
	?>
	<p>Settings for the WP Post Revisions</p>
	<?php
}

function post_revisions_presentation_title_field() {
	?>
	<input type="text" 
			name="post_revisions_presentation_title" 
			id="post_revisions_presentation_title" 
			value="<?php echo esc_attr( get_option('post_revisions_presentation_title') ); ?>">
	<?php
}

function post_revisions_presentation_count_field() {
	?>
	<input type="text" 
			name="post_revisions_presentation_count" 
			id="post_revisions_presentation_count" 
			value="<?php echo esc_attr( get_option('post_revisions_presentation_count') ); ?>">
	<?php
}

function post_revisions_presentation_update_plugin_menu() {
	add_settings_section( 'post_revisions_presentation', 'WP Post Revisions Settings', 'post_revisions_presentation_section', 'general' );

	add_settings_field( 'post_revisions_presentation_title', 'Title', 'post_revisions_presentation_title_field', 'general', 'post_revisions_presentation' );

	add_settings_field( 'post_revisions_presentation_count', 'Number of revisions to present', 'post_revisions_presentation_count_field', 'general', 'post_revisions_presentation' );
}
add_action( 'admin_menu', 'post_revisions_presentation_update_plugin_menu' );

function post_revisions_presentation_init() {
	register_setting( 'general', 'post_revisions_presentation_title' );
	register_setting( 'general', 'post_revisions_presentation_count' );
}
add_action( 'admin_init', 'post_revisions_presentation_init' );