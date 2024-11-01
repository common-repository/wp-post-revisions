jQuery(document).ready(function($) {
	$( '.post_excerpt_update' ).hide();
	$( '.update_links' ).hide();

	$( '.post_link_edit' ).click( function() {

		show_update_links( $(this) );

		return false;
	} );

	$( '.post_link_cancel' ).click( function() {

		show_edit_links( $(this) );

		return false;
	} );


	$( '.post_link_update' ).click( function() {
		var update = $( this );
		var post_revision = update.closest( 'li' ).find( '.post_excerpt_update' ).val();
		var id = update.closest( 'li' ).find( '.post_revision_id' ).val();


		$.ajax( {
			type: 'POST',
			url: ajaxurl,
			data: { post_id: id, post_excerpt: post_revision, action: 'edit_post_revision' },
			beforeSend: function(){
				update.after( ' <i>Updating Post Excerpt......</i>' );
			},
			success: function( data ) {

				console.log( data );
				
				if( data == 'delete' ) {

					var r = confirm("Field can not be empty. This entry will get deleted. Are you sure ?");

					if( r == true ) {
						var id = update.closest( 'li' ).find( '.post_revision_id' ).val();

						$.ajax( {
							type: 'POST',
							url: ajaxurl,
							data: { post_id: id, action: 'delete_post_revision' },
							beforeSend: function(){
								update.after( ' <i>Deleting Post Excerpt......</i>' );
							},
							success: function( data ) {
								update.closest( 'li' ).remove();
								alert( 'Data removed successfully!!' );
							}
						} );
					} else {
						update.closest( 'li' ).find( 'i' ).remove(); 
					}

				} else {

					update.closest( 'li' ).find( 'post_excerpt_update' ).val( post_revision );
					update.closest( 'li' ).find( '.post_list_number span' ).html( post_revision );
					show_edit_links( update );

					update.closest( 'li' ).find( 'i' ).remove();

				}
			}
		} );

		return false;
	} );

	$( '.post_link_delete' ).click( function() {
		var r = confirm("This can not be undone. Are you sure want to delete this FAQ ?");

		if( r == true ) {
			var update = $( this );
			var id = update.closest( 'li' ).find( '.post_revision_id' ).val();

			$.ajax( {
				type: 'POST',
				url: ajaxurl,
				data: { post_id: id, action: 'delete_post_revision' },
				beforeSend: function(){
					update.after( ' <i>Deleting Post Excerpt......</i>' );
				},
				success: function( data ) {
					update.closest( 'li' ).remove();
					alert( 'Data removed successfully!!' );
				}
			} );
		}

		return false;
	} );
});

function show_edit_links( element ) {
	element.closest( 'li' ).find( '.post_excerpt_update' ).hide();
	element.closest( 'li' ).find( '.post_list_number' ).show();
	element.closest( 'li' ).find( '.edit_links' ).show();
	element.closest( 'li' ).find( '.update_links' ).hide();
}
function show_update_links( element ) {
	element.closest( 'li' ).find( '.post_excerpt_update' ).show();
	element.closest( 'li' ).find( '.post_list_number' ).hide();
	element.closest( 'li' ).find( '.edit_links' ).hide();
	element.closest( 'li' ).find( '.update_links' ).show();
}