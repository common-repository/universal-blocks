<?php
use WPPlugins\UniversalBlocks\Helper;

if( ! function_exists( 'wppub_universal_blocks_list' ) ) :
function wppub_universal_blocks_list() {

    $blocks = [
        /**
         * General Blocks
         */
        'accordion'         => [
            'title'         => __( 'Accordion', 'universal-blocks' ),
            'icon'          => UNIVERSAL_BLOCKS_ASSETS . '/icon/accordion.svg',
            'category'      => [ 'general', 'content' ],
            'demo'          => '',
            'status'        => 'active',
            'package'       => __( 'Free', 'universal-blocks' ),
            'required'      => true,
            'keywords'      => [ 'accordion', 'collapsible', 'toggle', 'expandable', 'faq', 'tabs' ],
            'attributes'    => [],
        ],
        'accordion-advanced' => [
            'title'         => __( 'Accordion Advanced', 'universal-blocks' ),
            'icon'          => UNIVERSAL_BLOCKS_ASSETS . '/icon/accordion.svg',
            'category'      => [ 'general', 'content' ],
            'demo'          => '',
            'status'        => 'upcoming',
            'package'       => __( 'Upcoming', 'universal-blocks' ),
            'required'      => true,
            'keywords'      => [ 'accordion-advanced', 'collapsible', 'toggle', 'expandable', 'faq', 'tabs' ],
            'attributes'    => [],
        ],
        'alert'             => [
            'title'         => __( 'Alert', 'universal-blocks' ),
            'icon'          => UNIVERSAL_BLOCKS_ASSETS . '/icon/alert.svg',
            'category'      => [ 'general', 'content' ],
            'demo'          => '',
            'status'        => 'active',
            'package'       => __( 'Free', 'universal-blocks' ),
            'required'      => true,
            'keywords'      => [ 'accordion-advanced', 'collapsible', 'toggle', 'expandable', 'faq', 'tabs' ],
            'keywords'      => [ 'alert', 'collapsible', 'toggle', 'expandable', 'faq', 'tabs' ],
            'attributes'    => [],
        ],
        'alert-advanced'    => [
            'title'         => __( 'Alert Advanced', 'universal-blocks' ),
            'icon'          => UNIVERSAL_BLOCKS_ASSETS . '/icon/alert.svg',
            'category'      => [ 'general', 'content' ],
            'demo'          => '',
            'status'        => 'upcoming',
            'package'       => __( 'Upcoming', 'universal-blocks' ),
            'required'      => true,
            'keywords'      => [ 'alert-advanced', 'collapsible', 'toggle', 'expandable', 'faq', 'tabs' ],
            'attributes'    => [],
        ],
        'button'            => [
            'title'         => __( 'Button', 'universal-blocks' ),
            'icon'          => UNIVERSAL_BLOCKS_ASSETS . '/icon/button.svg',
            'category'      => [ 'general', 'content' ],
            'demo'          => '',
            'status'        => 'active',
            'package'       => __( 'Free', 'universal-blocks' ),
            'required'      => true,
            'keywords'      => [ 'button', 'collapsible', 'toggle', 'expandable', 'faq', 'tabs' ],
            'attributes'    => [],
        ],
        'button-group'      => [
            'title'         => __( 'Button Group', 'universal-blocks' ),
            'icon'          => UNIVERSAL_BLOCKS_ASSETS . '/icon/button-group.svg',
            'category'      => [ 'general', 'content' ],
            'demo'          => '',
            'status'        => 'active',
            'package'       => __( 'Free', 'universal-blocks' ),
            'required'      => true,
            'keywords'      => [ 'button-group', 'collapsible', 'toggle', 'expandable', 'faq', 'tabs' ],
            'attributes'    => [],
        ],
        'faq'               => [
            'title'         => __( 'FAQ', 'universal-blocks' ),
            'icon'          => UNIVERSAL_BLOCKS_ASSETS . '/icon/button-group.svg',
            'category'      => [ 'general', 'content' ],
            'demo'          => '',
            'status'        => 'active',
            'package'       => __( 'Free', 'universal-blocks' ),
            'required'      => true,
            'keywords'      => [ 'button-group', 'collapsible', 'toggle', 'expandable', 'faq', 'tabs' ],
            'attributes'    => [],
        ],
        'faq-advanced'               => [
            'title'         => __( 'FAQ Advanced', 'universal-blocks' ),
            'icon'          => UNIVERSAL_BLOCKS_ASSETS . '/icon/button-group.svg',
            'category'      => [ 'general', 'content' ],
            'demo'          => '',
            'status'        => 'upcoming',
            'package'       => __( 'Upcoming', 'universal-blocks' ),
            'required'      => true,
            'keywords'      => [ 'button-group', 'collapsible', 'toggle', 'expandable', 'faq', 'tabs' ],
            'attributes'    => [],
        ],
        // 'tabs'              => [
        //     'title'         => __( 'Tabs', 'universal-blocks' ),
        //     'icon'          => UNIVERSAL_BLOCKS_ASSETS . '/icon/button-group.svg',
        //     'category'      => [ 'general', 'content' ],
        //     'demo'          => '',
        //     'status'        => 'active',
        //     'package'       => __( 'Free', 'universal-blocks' ),
        //     'required'      => true,
        //     'keywords'      => [ 'button-group', 'collapsible', 'toggle', 'expandable', 'faq', 'tabs' ],
        //     'attributes'    => [],
        // ]
    ];

    return apply_filters( 'wppub_universal_blocks_list', $blocks );
}
endif;

if( ! function_exists( 'wppub_universal_activated_blocks_list' ) ) :
function wppub_universal_activated_blocks_list() {
    $blocks = get_option( 'universal_blocks' );

    if ( ! is_array( $blocks ) ) {
        return array();
    }
    
    $active_blocks = array_filter( $blocks, function( $block ) {
        return isset( $block['status'] ) && $block['status'] === 'active';
    });

    return apply_filters( 'wppub_universal_activated_blocks_list', $active_blocks );
}
endif;

if( ! function_exists( 'universal_blocks_admin_menu' ) ) :
function universal_blocks_admin_menu() {
    global $menu;
    $exists = false;

    foreach ( $menu as $item ) {
        if ( $item[2] === 'universal-blocks' ) {
            $exists = true;
            break;
        }
    }

    return $exists;
}
endif;
