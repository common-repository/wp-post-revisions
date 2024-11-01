<?php
/*
	Plugin Name: WP Post Revisions
	Author: Pranab Kalita
	Description: Allows bloggers to be more transparent to their readers by allowing them to notify readers the updations made in their blogs.
	Version: 1.0
	License: GPL2
*/

if ( !defined( "VERSION_NUMBER" ) )  define( "VERSION_NUMBER", "1.0.0" );
if ( !defined( "TABLE_NAME" ) )  define( "TABLE_NAME", "post_revisions" );
if ( !defined( "POST_REVISION_TITLE" ) )  define( "POST_REVISION_TITLE", "Revisions made :" );
if ( !defined( "POST_REVISION_COUNT" ) )  define( "POST_REVISION_COUNT", "5" );

function activation() {
	global $wpdb;
	$version_number 		= VERSION_NUMBER;
	$table_name 			= $wpdb->prefix . TABLE_NAME;
	$post_revision_title 	= POST_REVISION_TITLE;
	$post_revision_count 	= POST_REVISION_COUNT;

	if( $wpdb->get_var( 'SHOW TABLES LIKE ' . $table_name ) != $table_name ) {
		$sql = '
			CREATE TABLE '. $table_name .' (
				`id` INTEGER(11) UNSIGNED AUTO_INCREMENT,
				`time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				`post_id` INTEGER(11) UNSIGNED,
				`revision_excerpt` TEXT,
				PRIMARY KEY  (`id`)	
			)
		';

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		add_option( 'post_revisions_presentation_version_number', $version_number );
		add_option( 'post_revisions_presentation_title', $post_revision_title );
		add_option( 'post_revisions_presentation_count', $post_revision_count );
	}	
}
register_activation_hook( __FILE__, 'activation' );

require 'general_settings.php';
require 'create_post_meta_field.php';
require 'create_post_list_field.php';
require 'post_revisions_presentation.php';