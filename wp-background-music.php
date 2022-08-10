<?php
/**
 * The plugin for add Background Music to WordPress.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/adityathok/wp-background-music
 * @since             1.0.0
 * @package           wp-background-music
 *
 * @wordpress-plugin
 * Plugin Name:       WP Background Music
 * Plugin URI:        https://github.com/adityathok/wp-background-music
 * Description:       Plugin for add Background Music to WordPress.
 * Version:           1.0.0
 * Author:            Aditya Thok
 * Author URI:        https://github.com/adityathok
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-background-music
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define constants
 *
 * @since 1.1.1
 */
if ( ! defined( 'WP_BGN_MUSIC_VERSION' ) )		define( 'WP_BGN_MUSIC_VERSION'		, '1.1.1' ); // Plugin version constant
if ( ! defined( 'WP_BGN_MUSIC_PLUGIN' ) )		define( 'WP_BGN_MUSIC_PLUGIN'		, trim( dirname( plugin_basename( __FILE__ ) ), '/' ) ); // Name of the plugin folder eg - 'wp-background-music'
if ( ! defined( 'WP_BGN_MUSIC_PLUGIN_DIR' ) )	define( 'WP_BGN_MUSIC_PLUGIN_DIR'	, plugin_dir_path( __FILE__ ) ); // Plugin directory absolute path with the trailing slash. Useful for using with includes eg - /var/www/html/wp-content/plugins/wp-background-music/
if ( ! defined( 'WP_BGN_MUSIC_PLUGIN_URL' ) )	define( 'WP_BGN_MUSIC_PLUGIN_URL'	, plugin_dir_url( __FILE__ ) ); // URL to the plugin folder with the trailing slash. Useful for referencing src eg - http://localhost/wp/wp-content/plugins/wp-background-music/


if ( ! function_exists( 'wpbgn_music_register_scripts' ) ) {

	/**
	 * Load JavaScript and Style sources.
	 */
	function wpbgn_music_register_scripts() {
		
		// Get the version.

		$the_version = WP_BGN_MUSIC_VERSION;
		wp_enqueue_style( 'wp-bgn-music-style', WP_BGN_MUSIC_PLUGIN_URL . 'assets/css/style.css', array(), $the_version, false );
		wp_enqueue_script( 'wp-bgn-music-script', WP_BGN_MUSIC_PLUGIN_URL . 'assets/js/script.js', array('jquery'), $the_version, true );
	}
    add_action( 'wp_enqueue_scripts', 'wpbgn_music_register_scripts' );
}

/**
 * Regsiter Sub Menu Page
 */
add_action('admin_menu', 'wpbgn_music_register_option_submenu_page');
function wpbgn_music_register_option_submenu_page() {
	add_submenu_page(
		'options-general.php',
		'Background Music Options',
		'Background Music Options',
		'manage_options',
		'background-music-options-page',
		'wpbgn_music_register_option_page_callback' );
}
	
function wpbgn_music_register_option_page_callback() {
	require_once( WP_BGN_MUSIC_PLUGIN_DIR . 'inc/options-page.php' );
}

add_action('wp_footer', 'wpbgn_music_add_audio_to_footer');
function wpbgn_music_add_audio_to_footer(){	
	$dataoption = get_option('wpbgn_music_options',[]);
	$urlaudio   = isset($dataoption['urlaudio']) ? $dataoption['urlaudio'] : '';
	$message   	= isset($dataoption['message']) ? $dataoption['message'] : '';
	$showbubble = isset($dataoption['showbubble']) ? $dataoption['showbubble'] : '';

	$cookie 	= isset($_COOKIE['audiowpbgn']) ? $_COOKIE['audiowpbgn'] : '';
	$isactive	= $cookie==='true' ? 'xactive': '';
	$isclose	= $cookie==='true' ? 'xclose': '';

	if($urlaudio) {
		?>
		<audio autoplay loop id="wpbgn-music-audio">
			<source src="<?php echo $urlaudio;?>" type="audio/mpeg">
			Your browser does not support the audio element.
		</audio>

		<?php if($showbubble==1): ?>
			<div class="wp-bgn-music <?php echo $isactive;?>">
				<div class="wpbgn-music-float">
					<div class="wpbgn-music-bar-sound wpbgn-music-play" data-play="<?php echo $isactive;?>">
						<span></span><span></span><span></span><span></span>
					</div>
					<div class="wpbgn-music-bubble <?php echo $isclose;?>">
						<div class="wpbgn-music-bubble-content">
							<div class="wpbgn-music-bubble-content-message">
								<?php echo $message;?>
								<div class="wpbgn-music-allow-btn">
									<span class="wpbgn-music-play"> <i class="dashicons dashicons-controls-play"></i> Play</span>
								</div>
								<div class="wpbgn-music-message-allow-sound">
									Or allow sound access in the browser for this website.
								</div>
							</div>
							<div class="wpbgn-music-bubble-content-close">
								<span class="dashicons dashicons-no-alt"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php
	}
}