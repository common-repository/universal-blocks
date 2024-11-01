<?php
/**
 * All Ajax facing functions
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
 * @subpackage Ajax
 * @author IM <im@gmail.com>
 */
class Ajax {

	/**
	 * Constructor function
	 */
	public function __construct() {
        add_action( 'wp_ajax_callback-name', [ $this, 'callback_name' ] );
        add_action( 'wp_ajax_nopriv_callback-name', [ $this, 'callback_name' ] );
	}

    public function callback_name() {
        $response = [];

        if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['_wpnonce'] ) ) , 'universal-blocks' ) ) {
            $response['status']     = 0;
            $response['message']    = __( 'Unauthorized!', 'universal-blocks' );
            wp_send_json( $response );
        }
        
        $response['message']    = __( 'Rquest send Successfully!', 'universal-blocks' );
        $response['status']     = 1;
        wp_send_json( $response );
    }
}