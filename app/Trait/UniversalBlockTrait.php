<?php
namespace WPPlugins\UniversalBlocks\Trait;
use WPPlugins\UniversalBlocks\{
    Helper,
    Assets,
    Ajax,
    Blocks,
    Admin,
    Front,
    Common,
    Api
};

trait UniversalBlockTrait {
    public function defineConstants() {
    }

    public function includes() {
        // Include required core files here
    }

    public function defineTables() {
        // Define custom tables here
    }

    public function initHooks() {
        new Helper();
        new Assets();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new Ajax();
        }

        new Blocks();
        new Admin();
        new Front();
        new Common();
        new Api();
    }

    public function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
    }
}
