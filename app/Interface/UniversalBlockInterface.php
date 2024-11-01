<?php
namespace WPPlugins\UniversalBlocks\Interface;

interface UniversalBlockInterface {
    public function registerHooks();
    public function registerBlock( $name, $title, array $attributes = [] );
    public function registerBlocks();
}