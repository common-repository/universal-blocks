<?php
/**
 * Plugin Name:       Universal Blocks - Drag & Drop Page Builder Blocks and Patterns for Gutenberg Block Editor
 * Author URI:        https://profiles.wordpress.org/al-imran-akash/
 * Description:       Emphasize that your plugin offers blocks for any kind of content or design need.
 * Version:           1.01-beta
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Al Imran Akash
 * Author URI:        https://wpplugines.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       universal-blocks
 * Domain Path:       /languages
 */

namespace WPPlugins\UniversalBlocks;
require_once  __DIR__ . '/vendor/autoload.php';

final class Plugin {
    use Trait\UniversalBlockTrait;

    /**
    * Plugin version.
    *
    * @var string
    */
    public $version = '1.0.0';

    /**
    * The single instance of the class.
    *
    * @var Plugin
    * @since 1.0.0
    */
    protected static $_instance = null;

    /**
    * Main Plugin Instance.
    *
    * Ensures only one instance of Plugin is loaded or can be loaded.
    *
    * @since 1.0.0
    * @static
    * @return Plugin - Main instance.
    */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
    * Cloning is forbidden.
    *
    * @since 1.0.0
    */
    public function __clone() {}

    /**
    * Unserializing instances of this class is forbidden.
    *
    * @since 1.0.0
    */
    public function __wakeup() {}

    /**
    * Plugin Constructor.
    */
    public function __construct() {
        $this->defineConstants();
        $this->includes();
        $this->defineTables();
        $this->registerHooks();
        // add_action( 'init', [ $this, 'registerBlocks' ] );
    }

    /**
    * Register hooks.
    *
    * @since 1.0.0
    */
    public function registerHooks() {
        $this->initHooks();
    }

    private function defineConstants() {
        $this->define( 'UNIVERSAL_BLOCKS_FILE', __FILE__ );
        $this->define( 'UNIVERSAL_BLOCKS_PATH', __DIR__ );
        $this->define( 'UNIVERSAL_BLOCKS_URL', plugins_url( '', UNIVERSAL_BLOCKS_FILE ) );
        $this->define( 'UNIVERSAL_BLOCKS_ASSETS', UNIVERSAL_BLOCKS_URL . '/assets' );
        $this->define( 'UNIVERSAL_BLOCKS_ABSPATH', dirname( UNIVERSAL_BLOCKS_FILE ) . '/' );
        $this->define( 'UNIVERSAL_BLOCKS_BASENAME', plugin_basename( UNIVERSAL_BLOCKS_FILE ) );
        $this->define( 'UNIVERSAL_BLOCKS_VERSION', '1.0.0' );
        $this->define( 'UNIVERSAL_BLOCKS_DEBUG_MODE', true );
        $this->define( 'UNIVERSAL_BLOCKS_MIN_PHP_VERSION', '7.2' );
        $this->define( 'UNIVERSAL_BLOCKS_MIN_WP_VERSION', '5.2' );
        $this->define( 'UNIVERSAL_BLOCKS_SLUG', 'universal-blocks' );
    }

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes() {
        /**
         * composer loaded
         * 
         * @since 1.0.0
         */
        require_once UNIVERSAL_BLOCKS_PATH . '/vendor/autoload.php';
    }
}

Plugin::instance();
