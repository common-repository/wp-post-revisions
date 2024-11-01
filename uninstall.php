<?php
if ( !defined(ABSPATH) && !defined('WP_UNINSTALL_PLUGIN') )
	exit();

global $wpdb;
$table_name = $wpdb->prefix . 'post_revisions';
$wpdb->query( 'DROP TABLE ' . $table_name );

delete_option('post_revisions_presentation_version_number'); 
delete_option('post_revisions_presentation_title'); 
delete_option('post_revisions_presentation_count'); 