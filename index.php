<?php
/*
Plugin Name: Asset CleanUp Pro: Keep it always active
Plugin URI: https://gabelivan.com/items/wp-asset-cleanup-pro/
Description: This custom plugin automatically activates Asset CleanUp Pro whenever it is inactive as on some websites it deactivates itself. To be used ONLY if necessary!
Author: Gabriel Livan
Version: 1
Author URI: https://gabelivan.com/
*/
$wpacuProPluginSlug = 'wp-asset-clean-up-pro/wpacu.php';

if ( function_exists('is_plugin_active') && function_exists('activate_plugin') && (! is_plugin_active($wpacuProPluginSlug)) ) {
	activate_plugin($wpacuProPluginSlug, '', false, true);
	add_action('admin_notices', static function() {
	    ?>
        <div id="wpacu-pro-forced-activation" class="updated notice is-dismissible">
            <p><strong>Asset CleanUp Pro</strong> has been reactivated as it should always be active because the following plugin is enabled: <strong>Asset CleanUp Pro: Keep it always active</strong>.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
        </div>
        <?php
    });
}

add_action('admin_footer', static function() {
    $wpacuAlwaysActiveMsg = esc_js('The plugin `Asset CleanUp Pro: Keep it always active` is activated which is meant to keep `Asset CleanUp Pro` always active.'."\n\n".'If you want to deactivate/delete `Asset CleanUp Pro`, please remove `Asset CleanUp Pro: Keep it always active` first.');
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		    $('tr[data-plugin="wp-asset-clean-up-pro/wpacu.php"]').on('click', 'span.deactivate a', function() {
		        alert('<?php echo $wpacuAlwaysActiveMsg; ?>');
		        return false;
            });
		});
	</script>
	<?php
});
