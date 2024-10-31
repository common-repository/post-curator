<?php

add_action( 'admin_menu', 'post_curator_add_admin_menu' );
add_action( 'admin_init', 'post_curator_settings_init' );


function post_curator_add_admin_menu(  ) { 

	add_submenu_page( 'options-general.php', 'Post Curator', 'Post Curator', 'manage_options', 'post-curator', 'post_curator_options_page' );

}


function post_curator_settings_init(  ) { 

	register_setting( 'pluginPage', 'post_curator_settings' );

	add_settings_section(
		'post_curator_pluginPage_section', 
		__( '', 'post_curator' ), 
		'post_curator_settings_section_callback', 
		'pluginPage'
		);

	add_settings_field( 
		'post_curator_select_field_0', 
		__( 'Blog Category', 'post_curator' ), 
		'post_curator_select_field_0_render', 
		'pluginPage', 
		'post_curator_pluginPage_section' 
		);


}


function post_curator_select_field_0_render(  ) { 

	$options = get_option( 'post_curator_settings' );
	?>

	<select id="post-curator-category" name='post_curator_settings[post_curator_select_field_0]'>
		<option value='9' <?php selected( $options['post_curator_select_field_0'], 9 ); ?>>Beauty</option>
		<option value='7' <?php selected( $options['post_curator_select_field_0'], 7 ); ?>>Car</option>
		<option value='11' <?php selected( $options['post_curator_select_field_0'], 11 ); ?>>Design</option>
		<option value='6' <?php selected( $options['post_curator_select_field_0'], 6 ); ?>>Fashion</option>
		<option value='12' <?php selected( $options['post_curator_select_field_0'], 12 ); ?>>Food</option>
		<option value='20' <?php selected( $options['post_curator_select_field_0'], 20 ); ?>>Gaming</option>
		<option value='17' <?php selected( $options['post_curator_select_field_0'], 17 ); ?>>Green</option>
		<option value='16' <?php selected( $options['post_curator_select_field_0'], 16 ); ?>>Health</option>
		<option value='41' <?php selected( $options['post_curator_select_field_0'], 41 ); ?>>History</option>
		<option value='42' <?php selected( $options['post_curator_select_field_0'], 42 ); ?>>Marketing</option>
		<option value='14' <?php selected( $options['post_curator_select_field_0'], 14 ); ?>>Movie</option>
		<option value='5' <?php selected( $options['post_curator_select_field_0'], 5 ); ?>>Music</option>
		<option value='21' <?php selected( $options['post_curator_select_field_0'], 21 ); ?>>Pet</option>
		<option value='15' <?php selected( $options['post_curator_select_field_0'], 15 ); ?>>Photography</option>
		<option value='8' <?php selected( $options['post_curator_select_field_0'], 8 ); ?>>Lifestyle</option>
		<option value='18' <?php selected( $options['post_curator_select_field_0'], 18 ); ?>>Technology</option>
		<option value='10' <?php selected( $options['post_curator_select_field_0'], 10 ); ?>>Travel</option>
		<option value='19' <?php selected( $options['post_curator_select_field_0'], 19 ); ?>>Web</option>
		<option value='22' <?php selected( $options['post_curator_select_field_0'], 22 ); ?>>Other</option>
	</select>

	<?php

}


function post_curator_settings_section_callback(  ) { 

	echo __( '', 'post_curator' );

}


function post_curator_options_page(  ) { 

	?>
	<form action='options.php' method='post'>

		<h3>Step 1 - Choose Category</h3>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		
		?>

		<h3>Step 2 - Click Register Blog</h3>

		<a class="button button-primary" href="#" id="post-curator-register">Register Blog</a>

		<p id="post-curator-response"></p>

		<h3>Step 3 - Save Setting</h3>

		<?php 

		submit_button();

		?>

	</form>

	<script type="text/javascript">
		(function($) {
			$(document).ready(function() {
				$('#post-curator-register').on('click', function(e) {
					e.preventDefault();
					$.ajax({
						type: 'post',
						dataType: 'json',
						url: 'http://postcurator.net/wp-admin/admin-ajax.php',
						data: {
							action : 'post_curator_ajax_listener',
							url: '<?php echo admin_url("admin-ajax.php"); ?>',
							category: $('#post-curator-category').val()
						},
						success: function(r) {
							if (r.response == 'success') {
								$('#post-curator-response').html('Your blog has been added, thanks.');
							}
							
							if (r.response == 'duplicate') {
								$('#post-curator-response').html('Your blog is already registered.');
							}

							if (r.response == 'fail') {
								$('#post-curator-response').html('An error happened.');
							}
						}
					})
				});
			});
		})(jQuery);
	</script>

	<?php

}

?>