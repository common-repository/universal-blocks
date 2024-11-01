<?php
/**
 * All Install facing functions
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
 * @subpackage Install
 * @author IM <im@gmail.com>
 */
class Install {

    public static function install() {
        // self::create_tables();
    }

    /**
     * Set up the database tables which the plugin needs to function.
     * WARNING: If you are modifying this method, make sure that its safe to call regardless of the state of database.
     *
     * This is called from `install` method and is executed in-sync when WC is installed or updated..
     *
     * TODO: Add all crucial tables that we have created from workers in the past.
     */
    private static function create_tables() {
        global $wpdb;

        $wpdb->hide_errors();

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        dbDelta( self::get_schema() );
    }

    /**
     * Get Table schema.
     *
     * @return string
     */
    private static function get_schema() {
        global $wpdb;

        $collate = '';

        if ( $wpdb->has_cap( 'collation' ) ) {
            $collate = $wpdb->get_charset_collate();
        }

        $tables = "
            CREATE TABLE {$wpdb->prefix}IM_sessions (
              session_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
              session_key char(32) NOT NULL,
              session_value longtext NOT NULL,
              session_expiry BIGINT UNSIGNED NOT NULL,
              PRIMARY KEY  (session_id),
              UNIQUE KEY session_key (session_key)
            ) $collate;
            
            CREATE TABLE {$wpdb->prefix}IM_api_keys (
              key_id BIGINT UNSIGNED NOT NULL auto_increment,
              user_id BIGINT UNSIGNED NOT NULL,
              description varchar(200) NULL,
              permissions varchar(10) NOT NULL,
              consumer_key char(64) NOT NULL,
              consumer_secret char(43) NOT NULL,
              nonces longtext NULL,
              truncated_key char(7) NOT NULL,
              last_access datetime NULL default null,
              PRIMARY KEY  (key_id),
              KEY consumer_key (consumer_key),
              KEY consumer_secret (consumer_secret)
            ) $collate;
        ";

        return $tables;
    }

}