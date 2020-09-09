<?php
/*
Plugin Name: Asset CleanUp Pro: Keep it always active
Plugin URI: https://github.com/gabelivan/wpacu-keep-it-on
Description: This custom plugin automatically activates Asset CleanUp Pro whenever it is inactive as on some websites it deactivates itself. To be used ONLY if necessary!
Author: Gabriel Livan
Version: 1.1
Author URI: https://gabelivan.com/
*/

/**
 * Class AssetCleanUpProAlwaysActive
 */
class AssetCleanUpProAlwaysActive
{
	/**
	 * @var string[]
	 */
	public static $wpacuProInfoData = array(
	    'pro_plugin_slug'      => 'wp-asset-clean-up-pro/wpacu.php',
	    'pro_plugin_title'     => 'Asset CleanUp Pro: Page Speed Booster',
	    'current_plugin_title' => 'Asset CleanUp Pro: Keep it always active'
    );

	/**
	 *
	 */
	public function init()
    {
        if ( function_exists('is_plugin_active') && function_exists('activate_plugin') && (! is_plugin_active(self::$wpacuProInfoData['pro_plugin_slug'])) ) {
		    activate_plugin(self::$wpacuProInfoData['pro_plugin_slug'], '', false, true);
		    set_transient('wpacu_pro_plugin_reactivated', true);
	    }

	    add_action('admin_notices', array($this, 'noticeProPluginReactivated'));
	    add_action('admin_footer',  array($this, 'adminFooterScripts'));
    }

	/**
	 *
	 */
	public function noticeProPluginReactivated()
    {
	    if ( ! get_transient('wpacu_pro_plugin_reactivated') ) {
	        return;
        }
        ?>
        <div id="wpacu-pro-forced-activation" class="updated notice is-dismissible">
            <p><span style="color: #46b450;" class="dashicons dashicons-yes-alt"></span> <strong><?php echo self::$wpacuProInfoData['pro_plugin_title']; ?></strong> has been reactivated as it should always be active because the following plugin is enabled: <strong><?php echo self::$wpacuProInfoData['current_plugin_title']; ?></strong>.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
        </div>
        <?php
        delete_transient('wpacu_pro_plugin_reactivated');
    }

	/**
	 *
	 */
	public function adminFooterScripts()
    {
	    $wpacuAlwaysActiveMsg = esc_js(
		    'The plugin `'.self::$wpacuProInfoData['current_plugin_title'].'` is activated which is meant to keep `'.self::$wpacuProInfoData['pro_plugin_title'].'` always active.'."\n\n".
		    'If you want to deactivate/delete `'.self::$wpacuProInfoData['pro_plugin_title'].'`, please remove `'.self::$wpacuProInfoData['current_plugin_title'].'` first.'
	    );
	    ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('tr[data-plugin="<?php echo self::$wpacuProInfoData['pro_plugin_slug']; ?>"]').on('click', 'span.deactivate a', function() {
                    alert('<?php echo $wpacuAlwaysActiveMsg; ?>');
                    return false;
                });
            });
        </script>
        <?php
    }
}

$wpacuKeepItActiveClass = new AssetCleanUpProAlwaysActive();
$wpacuKeepItActiveClass->init();
