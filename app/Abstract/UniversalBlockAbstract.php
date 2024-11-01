<?php
namespace WPPlugins\UniversalBlocks\Abstract;
use WPPlugins\UniversalBlocks\Interface\UniversalBlockInterface;


/**
 * Abstract class for registering Universal Blocks.
 */
abstract class UniversalBlockAbstract implements UniversalBlockInterface {

	/**
	* Register block hooks.
	*
	* @since 1.0.0
	*/
	public function registerHooks() {}

	/**
	* Abstract method for defining block-specific registration logic (optional).
	*
	* This method is useful if you need custom logic for individual blocks.
	*
	* @param string $name Block name.
	* @param string $title Block title.
	* @param array $attributes Block attributes (optional).
	* @return void
	*/
  	public function registerBlock( $name, $title, array $attributes = [] ) {}

  	/**
   	* Register blocks.
   	*
   	* @since 1.0.0
   	*/
  	public function registerBlocks() {
  		$blocks = wppub_universal_activated_blocks_list();

		foreach ( $blocks as $slug => $block ) {
			$name = UNIVERSAL_BLOCKS_PATH . "/src/blocks/{$slug}/build";
			register_block_type( $name );
		}
  	}
}
