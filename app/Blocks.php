<?php
/**
 * All Blocks facing functions
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
 * @subpackage Blocks
 * @author IM <im@gmail.com>
 */
class Blocks extends Abstract\UniversalBlockAbstract {

	/**
	 * Constructor function
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'registerBlocks' ] );
		add_filter( 'block_categories_all', [ $this, 'register_block_categories' ] );
	}

    public function registerBlocks() {

    	wp_enqueue_script( 'block-script' );
        wp_enqueue_style( 'block-style' );

	    parent::registerBlocks();
	}

	public function register_block_categories( $categories ) {
		$ub_categories = [
			[
	        	'slug' 	=> 'universal-blocks',
	            'title' => __( 'Universal Blocks', 'universal-blocks' ),
	            'icon' 	=> UNIVERSAL_BLOCKS_ASSETS . '/icon/logo.svg',
	        ],
			[
	        	'slug' 	=> 'universal-blocks-post',
	            'title' => __('Universal Post Blocks', 'universal-blocks'),
	            'icon' 	=> UNIVERSAL_BLOCKS_ASSETS . '/icon/logo.svg',
	        ],
			[
	        	'slug' 	=> 'universal-blocks-wc',
	            'title' => __('Universal Blocks - WooCommerce', 'universal-blocks'),
	            'icon' 	=> UNIVERSAL_BLOCKS_ASSETS . '/icon/logo.svg',
	        ]
		];

	    foreach ( $ub_categories as $category ) {
	        array_unshift( $categories, $category );
	    }

	    return $categories;
	}
}