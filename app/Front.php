<?php
/**
 * All Front facing functions
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
 * @subpackage Front
 * @author IM <im@gmail.com>
 */
class Front {

	/**
	 * Constructor function
	 */
	public function __construct() {
        add_action( 'wp_head', [ $this, 'head' ] );
	}

    public function head() {
    	$blocks = wppub_universal_activated_blocks_list();
    	// Helper::pri($blocks);
    }
}