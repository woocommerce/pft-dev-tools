<?php
/*
Plugin Name: WP CLI Trigger Hook
Description: A plugin with a set of utilities is used to develop the product form template system.
Version: 0.0.2-dev
Author: retrofox
*/

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'trigger', 'Trigger_Hook_Command' );
}

class Trigger_Hook_Command {
    /**
     * Trigger a WordPress hook manually.
     * 
     * ## OPTIONS
     * 
     * <action>
     * : The name of the hook to trigger.
     * 
     * [--action=<action>]
     * : The action to perform. Default is 'update'.
     * ---
     * default: update
     * options:
     *  - install
     *  - update
     *  - delete
     * ---
     *
     * ## EXAMPLES
     * 
     *    wp trigger woocommerce_after_update_option
     *    wp trigger woocommerce_after_update_option --action=install
     * 
     * @when after_wp_load
     */
    public function __invoke( $args, $assoc_args ) {
        $valid_actions = [ 'install', 'update', 'delete' ];
        $hook_name     = $args[ 0 ];
        $action        = $assoc_args[ 'action' ] ?? 'update';

        // check if it's a valid action
        if ( ! in_array( $action, $valid_actions ) ) {
            WP_CLI::error( "Invalid action '$action'. Valid actions are: " . implode( ', ', $valid_actions ) );
        }

        if ( has_action( $hook_name ) ) {
            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            $upgrader_object = new WP_Upgrader();

            // Specific data for WooCommerce plugin
            $plugin  = 'woocommerce/woocommerce.php'; // Path to the main plugin file
            $plugins = array( $plugin );

            $options = array(
                'action'  => $action,
                'type'    => 'plugin',
                'plugins' => $plugins,
            );

            // Trigger the hook manually
            do_action( $hook_name, $upgrader_object, $options );

            WP_CLI::success( "Hook '$hook_name' triggered successfully." );
        } else {
            WP_CLI::error( "The hook '$hook_name' does not exist or has no associated actions." );
        }
    }
}

/*
 * Enable `product-editor-template-system` feature in WooCommerce
 */
add_filter( 'woocommerce_admin_features', function ( $features ) {
    $features[] = 'product-editor-template-system';
    return $features;
} );
