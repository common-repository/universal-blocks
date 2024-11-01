<?php
/**
 * All Assets facing functions
 */
namespace WPPlugins\UniversalBlocks;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Assets
 * @author IM <im@gmail.com>
 */
class Assets {

	/**
	 * Constructor function
	 */
	public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets' ] );
        add_action( 'enqueue_block_assets', [ $this, 'block_assets' ] );
        add_action( 'enqueue_block_editor_assets', [ $this, 'block_assets' ] );
	}

    /**
     * Styles get function
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    public function get_styles() {
        $min = defined( 'UNIVERSAL_BLOCKS_DEBUG_MODE' ) && UNIVERSAL_BLOCKS_DEBUG_MODE ? '' : '.min';

        return [
            'front-style' => [
                'src'     => UNIVERSAL_BLOCKS_ASSETS . "/css/front{$min}.css",
                'version' => filemtime( UNIVERSAL_BLOCKS_PATH . "/assets/css/front{$min}.css" ),
            ],
            'admin-style' => [
                'src'     => UNIVERSAL_BLOCKS_ASSETS . "/css/admin{$min}.css",
                'version' => filemtime( UNIVERSAL_BLOCKS_PATH . "/assets/css/admin{$min}.css" ),
            ],
            'settings-style' => [
                'src'     => UNIVERSAL_BLOCKS_URL . "/admin/settings/build/style-index.css",
                'version' => filemtime( UNIVERSAL_BLOCKS_PATH . "/admin/settings/build/style-index.css" ),
            ]
        ];
    }

    /**
     * Scripts get function
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    public function get_scripts() {
        $min = defined( 'UNIVERSAL_BLOCKS_DEBUG_MODE' ) && UNIVERSAL_BLOCKS_DEBUG_MODE ? '' : '.min';

        return [
            'front-script' => [
                'src'     => UNIVERSAL_BLOCKS_ASSETS . "/js/front{$min}.js",
                'version' => filemtime( UNIVERSAL_BLOCKS_PATH . "/assets/js/front{$min}.js" ),
                'deps'    => [ 'jquery', 'wp-util' ],
            ],
            'admin-script' => [
                'src'     => UNIVERSAL_BLOCKS_ASSETS . "/js/admin{$min}.js",
                'version' => filemtime( UNIVERSAL_BLOCKS_PATH . "/assets/js/admin{$min}.js" ),
                'deps'    => [ 'jquery', 'wp-util' ],
            ],
            'settings-script' => [
                'src'     => UNIVERSAL_BLOCKS_URL . "/admin/settings/build/index.js",
                'version' => filemtime( UNIVERSAL_BLOCKS_PATH . "/admin/settings/build/index.js" ),
                'deps'    => [  'wp-element', 'wp-components', 'wp-i18n', 'wp-api-fetch', 'wp-hooks', 'wp-data' ],
            ]
        ];
    }
    
    /**
     * Assets enqueue function
     * 
     * @since 1.0.0
     * 
     * @return mixed
     */
    public function enqueue_assets() {
        $styles = $this->get_styles();

        foreach ( $styles as $handale => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;
            wp_register_style( $handale, $style['src'], $deps, $style['version'] );
        }

        wp_localize_script( 'admin-script', 'UB', [
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'universal-blocks' ),
        ] );

        $scripts = $this->get_scripts();

        foreach ( $scripts as $handale => $script ) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;
            wp_register_script( $handale, $script['src'], $deps, $script['version'], true );
        }

        wp_localize_script( 'front-script', 'UB', [
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'universal-blocks' ),
        ] );
    }

    /**
     * Styles get function
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    public function block_get_styles() {
        $min = defined( 'UNIVERSAL_BLOCKS_DEBUG_MODE' ) && UNIVERSAL_BLOCKS_DEBUG_MODE ? '' : '.min';

        return [
            'block-style' => [
                'src'     => UNIVERSAL_BLOCKS_ASSETS . "/css/block{$min}.css",
                'version' => filemtime( UNIVERSAL_BLOCKS_PATH . "/assets/css/block{$min}.css" ),
            ],
        ];
    }

    /**
     * Scripts get function
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    public function block_get_scripts() {
        $min = defined( 'UNIVERSAL_BLOCKS_DEBUG_MODE' ) && UNIVERSAL_BLOCKS_DEBUG_MODE ? '' : '.min';

        return [
            'block-script' => [
                'src'     => UNIVERSAL_BLOCKS_ASSETS . "/js/block{$min}.js",
                'version' => filemtime( UNIVERSAL_BLOCKS_PATH . "/assets/js/block{$min}.js" ),
                'deps'    => [ 'wp-blocks', 'wp-editor', 'wp-element', 'wp-components', 'wp-i18n', 'wp-api-fetch', 'wp-hooks', 'wp-data' ],
            ]
        ];
    }
    
    /**
     * Assets enqueue function
     * 
     * @since 1.0.0
     * 
     * @return mixed
     */
    public function block_assets() {
        $styles = $this->block_get_styles();

        foreach ( $styles as $handale => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;
            wp_register_style( $handale, $style['src'], $deps, $style['version'] );
        }

        $scripts = $this->block_get_scripts();

        foreach ( $scripts as $handale => $script ) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;
            wp_register_script( $handale, $script['src'], $deps, $script['version'], true );
        }

        wp_localize_script(
            'block-script',
            'UNIVERSAL_BLOCKS',
            [
                'nonce'             => wp_create_nonce('universal-blocks'),
                'blocks'            => wppub_universal_blocks_list(),
                'activated_blocks'  => wppub_universal_activated_blocks_list(),
                'logo'              => UNIVERSAL_BLOCKS_ASSETS . '/icon/logo.svg',
            ]
        );
    }
}