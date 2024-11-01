<?php
/**
 * All admin facing functions
 */
namespace WPPlugins\UniversalBlocks;
use WPPlugins\UniversalBlocks\Install;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Admin
 * @author IM <im@gmail.com>
 */
class Admin {

    private $plugin;

	/**
	 * Constructor function
	 */
	public function __construct() {

        $this->plugin = array(
            'basename' => UNIVERSAL_BLOCKS_BASENAME,
        );

        $this->hooks();
	}

    private function hooks() {
        register_activation_hook( UNIVERSAL_BLOCKS_FILE, [ new Install(), 'install' ] );

        add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ], -1 );
        add_action( 'admin_notices', [ $this, 'build_dependencies_notice' ] );
        add_action( 'after_setup_theme', [ $this, 'setup_environment' ] );
        add_action( 'init', [ $this, 'init' ], 0 );
        add_action( 'activated_plugin', [ $this, 'activated_plugin' ] );
        add_action( 'deactivated_plugin', [ $this, 'deactivated_plugin' ] );
        add_action( 'admin_head', [ $this, 'head' ] );
        add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_blocks_script' ] );
        add_filter( 'admin_body_class', [ $this, 'universal_blocks_body_class' ] );
        add_filter( "plugin_action_links_{$this->plugin['basename']}", [ $this, 'action_links' ] );
        add_filter( 'plugin_row_meta', [ $this, 'plugin_row_meta' ], 10, 2 );


    }

    public function head() {
        // Helper::pri($this->plugin);
    }

    /**
     * Add admin menu item
     */
    public function add_admin_menu() {
        add_menu_page(
            'Universal Blocks Settings',
            'Universal Blocks',
            'manage_options',
            'universal-blocks',
            [ $this, 'universal_blocks_settings_page' ],
            UNIVERSAL_BLOCKS_ASSETS . '/icon/logo.svg',
            25
        );
    }

    public function universal_blocks_settings_page() {

        if ( universal_blocks_admin_menu() ) {
            wp_enqueue_script( 'settings-script' );
            wp_enqueue_style( 'settings-style' );
        }
        
        echo '<div class="wrap"><div id="wppub-settings">'. __( 'Universal Blocks Settings', 'universal-blocks' ) .'</div></div>';
    }

    /**
     * When WP has loaded all plugins, trigger the `woocommerce_loaded` hook.
     *
     * This ensures `woocommerce_loaded` is called only after all other plugins
     * are loaded, to avoid issues caused by plugin directory naming changing
     * the load order. See #21524 for details.
     *
     * @since 3.6.0
     */
    public function on_plugins_loaded() {
        do_action( 'wppub_loaded' );
    }

    /**
     * Ran when any plugin is activated.
     *
     * @since 3.6.0
     * @param string $filename The filename of the activated plugin.
     */
    public function activated_plugin( $filename ) {

        if ( ! get_option('universal_blocks', []) ) {
            $blocks = wppub_universal_blocks_list();
            update_option( 'universal_blocks', $blocks );
        }
    }

    /**
     * Ran when any plugin is deactivated.
     *
     * @since 3.6.0
     * @param string $filename The filename of the deactivated plugin.
     */
    public function deactivated_plugin( $filename ) {}

    /**
     * Init WooCommerce when WordPress Initialises.
     */
    public function init() {
        // Before init action.
        do_action( 'before_wppub_plugin_init' );

        // Set up localisation.
        $this->load_plugin_textdomain();

        // Init action.
        do_action( 'wppub_plugin_init' );
    }

    /**
     * Load Localisation files.
     *
     * Note: the first-loaded translation file overrides any following ones if the same translation is present.
     */
    public function load_plugin_textdomain() {
        load_plugin_textdomain( 'universal-blocks', false, plugin_basename( dirname( UNIVERSAL_BLOCKS_FILE ) ) . '/i18n/languages' );
    }

    /**
     * Output a admin notice when build dependencies not met.
     *
     * @return void
     */
    public function build_dependencies_notice() {}

    /**
     * Ensure theme and server variable compatibility and setup image sizes.
     */
    public function setup_environment() {
        $this->add_thumbnail_support();
    }

    /**
     * Ensure post thumbnail support is turned on.
     */
    private function add_thumbnail_support() {
        if ( ! current_theme_supports( 'post-thumbnails' ) ) {
            add_theme_support( 'post-thumbnails' );
        }
        
        add_post_type_support( 'product', 'thumbnail' );
    }

    public function action_links( $links ) {
        if ( !is_array( $links ) ) {
            $links = array();
        }

        $admin_url = admin_url( 'admin.php' );

        $new_links = [
            'settings' => sprintf( '<a href="%1$s">' . __( 'Settings', 'product-view-count' ) . '</a>', add_query_arg( 'page', 'universal-blocks', $admin_url ) )
        ];
        
        return array_merge( $new_links, $links );
    }

    public function plugin_row_meta( $plugin_meta, $plugin_file ) {

        if ( $this->plugin['basename'] === $plugin_file ) {
            $plugin_meta['help'] = '<a href="https://help.wpplugines.com/" target="_blank" class="cx-help">' . __( 'Help', 'product-view-count' ) . '</a>';
        }

        return $plugin_meta;
    }

    public function enqueue_blocks_script() {

        wp_enqueue_style( 'admin-style' );

        wp_enqueue_script(
            'blocks-script',
            UNIVERSAL_BLOCKS_URL . '/admin/settings/src/index.js',
            ['wp-element'],
            null,
            true
        );

        wp_localize_script(
            'blocks-script',
            'UNIVERSAL_BLOCKS',
            [
                'nonce'             => wp_create_nonce('universal-blocks'),
                'blocks'            => wppub_universal_blocks_list(),
                'activated_blocks'  => wppub_universal_activated_blocks_list(),
            ]
        );
    }

    public function universal_blocks_body_class( $classes ) {
        $classes .= ' universal-blocks';
        return $classes;
    }
}