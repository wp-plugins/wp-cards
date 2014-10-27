<?php
/**
 * This file holds all of the plugin options
 */

$wp_cards_plugin_options = array(
	'include_bootstrap_files'  => array(
		'type'    => 'checkbox',
		'id'      => 'wp_cards_include_bootstrap_files',
		'default' => 'disable'
	)
);

foreach ( $wp_cards_plugin_options as $key => $value ) {
	$option_value = null;

	if ( isset( $value['id'] ) ) {
		if ( ! $option_value = get_option( $value['id'] ) ) {
			if ( isset( $value['default'] ) )
				$option_value = $value['default'];
		}

		// Set the value
		$wp_cards_plugin_options[$key]['value'] = $option_value;
	}
}

function wp_cards_plugin_menu() {
	global $wp_cards_plugin_options;

	if ( function_exists( 'current_user_can' ) && ! current_user_can( 'manage_options' ) )
		return;
		//die(__('Cheatin&#8217; uh?'));

	if ( ! empty( $_REQUEST['page'] ) && esc_attr( $_REQUEST['page'] ) == basename( __FILE__ ) ) {
		$postback_url = '/wp-admin/admin.php?page=' . esc_attr( $_REQUEST['page'] )
		              . '&on_' . esc_attr( $_REQUEST['action'] ) . '=true';

		if ( ! empty( $_REQUEST['action'] ) && 'save' == esc_attr( $_REQUEST['action'] ) ) {
			foreach ( $wp_cards_plugin_options as $key => $value ) {
				if ( ! empty( $value['type'] ) && 'checkbox' == $value['type'] ) {
					if ( isset( $_REQUEST[$value['id']] ) )
						update_option( $value['id'], 'enable' );
					else
						update_option( $value['id'], 'disable' );
				} else {
					if ( ! empty( $value['id'] ) && ! empty( $_REQUEST[$value['id']] ) )
						update_option( $value['id'], esc_attr( $_REQUEST[$value['id']] ) );
					elseif ( isset( $value['id'] ) )
						delete_option( $value['id'] );
				}
			}

			header( 'Location: ' . $postback_url );
			die;
		} elseif ( 'reset' == esc_attr( $_REQUEST['action'] ) ) {
			foreach ( $wp_cards_plugin_options as $key => $value ) {
				delete_option( $value['id'] );
			}

			header( 'Location: ' . $postback_url);
			die;
		}
	}

	add_menu_page( 'WP-Cards', 'WP-Cards', 'manage_options', basename(__FILE__), 'wp_cards_options_form' );
}

function wp_cards_options_form() {
	global $wp_cards_plugin_options;
	extract($wp_cards_plugin_options);
	$current_page = esc_attr( $_GET['page'] );
?>
<div class="wrap">
	<div class="icon32" id="icon-themes"><br /></div>
	<h2>WP-Cards Plugin Options</h2>
	<?php if ( esc_attr( $_REQUEST['on_save'] ) ) : ?>
	<div id="message" class="updated fade"><p><strong>Plugin settings saved.</strong></p></div>
	<?php endif; ?>
	<form method="post">
		<input type="hidden" name="action" value="save">
		<input type="hidden" name="page" value="<?php echo $current_page; ?>" id="current_module">
		<table class="form-table">
			<tr valign="top" class="checkbox">
				<th scope="row">
					<label for="wp_cards_include_bootstrap_files">Include Bootstrap files</label></th><td colspan="2">
					<input id="wp_cards_include_bootstrap_files"<?php echo ( 'enable' == $include_bootstrap_files['value'] ? ' checked="checked"' : '' ); ?> type="checkbox" name="wp_cards_include_bootstrap_files" value="<?php echo $include_bootstrap_files['value']; ?>">
					<label for="wp_cards_include_bootstrap_files">WP Cards uses Bootstrap 3, if your theme already includes Bootstap 3, you do not need to check this box.</label>
				</td>
			</tr>
		</table>
		<?php echo $form_options; ?>
		<p class="submit"><input type="submit" name="Submit" value="Save Changes" class="button-primary"></p>
	</form>
</div>
<?php
	unset( $elements );
}

?>