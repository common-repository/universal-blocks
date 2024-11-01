<?php
/**
 * All Api facing functions
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
 * @subpackage Api
 * @author IM <im@gmail.com>
 */
class Api {

	/**
	 * Constructor function
	 */
	public function __construct() {
        add_action( 'rest_api_init', [ $this, 'register_rest_route' ] );
	}

    public function register_rest_route() {

        // Register GET endpoint for fetching blocks
        register_rest_route( 'universal-blocks/v1', '/blocks', [
            'methods'             => 'GET',
            'callback'            => [ $this, 'blocks_list' ],
            'permission_callback' => [ $this, 'blocks_list_permission'],
        ] );

        // Register POST endpoint for updating a single block
        register_rest_route( 'universal-blocks/v1', '/blocks/(?P<key>[\w-]+)', [
            'methods'             => 'POST',
            'callback'            => [ $this, 'update_block_status' ],
            'permission_callback' => [ $this, 'blocks_list_permission' ],
            'args'                => [
                'enabled' => [
                    'required'           => true,
                    'validate_callback'  => function ($param, $request, $key) {
                        return is_bool($param);
                    },
                ],
            ],
        ] );

        // Register POST endpoint for updating all blocks
        register_rest_route( 'universal-blocks/v1', '/activate', array(
            'methods'   => 'POST',
            'callback'  => array( $this, 'update_all_blocks_status' ),
            'permission_callback' => [ $this, 'blocks_list_permission' ],
            'args'     	=> array(
                'type'  => array(
                    'required' => true,
                    'validate_callback' => function ($param) {
                        return is_string($param);
                    },
                ),
            ),
        ) );
    }

    public function blocks_list() {
        $blocks = wppub_universal_blocks_list();

        return rest_ensure_response( $blocks );
    }

    public function blocks_list_permission() {
        return true;
    }

    public function update_block_status( $request ) {
        $key        = $request['key'];
        $enabled    = $request->get_param( 'enabled' );

        $blocks     = get_option( 'universal_blocks', [] );

        if ( isset( $blocks[$key] ) ) {
            $blocks[$key]['status'] = $enabled ? 'active' : 'deactive';
            update_option( 'universal_blocks', $blocks );
            return rest_ensure_response( ['status' => 'success'] );
        }

        return new WP_Error('block_not_found', 'Block not found', ['status' => 404]);
    }

    public function update_all_blocks_status( $request ) {
        $type 	= $request->get_param( 'type' );

        $blocks = wppub_universal_blocks_list();

        foreach ( $blocks as $key => &$block ) {
            $block['status'] = $type == 'enable' ? 'active' : 'deactive';
        }

        update_option( 'universal_blocks', $blocks );

        return rest_ensure_response( ['status' => 'success'] );
    }
}