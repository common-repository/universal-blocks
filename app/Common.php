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
class Common {

	/**
	 * Constructor function
	 */
	public function __construct() {
	    add_action( 'wp_head', [ $this, 'head' ] );
	    // add_action( 'enqueue_block_assets', [ $this, 'block_assets' ] );
	}

	public function head() {}

	public function block_assets() {}
}