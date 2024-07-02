<?php

/*
Plugin Name: Advanced Custom Fields: Timezone Select
Plugin URI: PLUGIN_URL
Description: SHORT_DESCRIPTION
Version: 1.0.0
Author: AUTHOR_NAME
Author URI: AUTHOR_URL
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

require __DIR__ . '/vendor/autoload.php';

// check if class already exists
if( !class_exists('ultra_acf_plugin_timezone_select') ) :

class ultra_acf_plugin_timezone_select {
	
	// vars
	var $settings;
	
	
	/*
	*  __construct
	*
	*  This function will setup the class functionality
	*
	*  @type	function
	*  @date	17/02/2016
	*  @since	1.0.0
	*
	*  @param	void
	*  @return	void
	*/
	
	function __construct() {
		
		// settings
		// - these will be passed into the field class.
		$this->settings = array(
			'version'	=> '1.0.0',
			'url'		=> plugin_dir_url( __FILE__ ),
			'path'		=> plugin_dir_path( __FILE__ )
		);
		
		
		// include field
		add_action('acf/include_field_types', array($this, 'include_field')); // v5
	}
	
	
	/*
	*  include_field
	*
	*  This function will include the field type class
	*
	*  @type	function
	*  @date	17/02/2016
	*  @since	1.0.0
	*
	*  @param	$version (int) major ACF version. Defaults to false
	*  @return	void
	*/
	
	function include_field( $version = false ) {

		// support empty $version
		if( !$version ) $version = 5;


		// load textdomain
		load_plugin_textdomain( 'timezone_select', false, plugin_basename( dirname( __FILE__ ) ) . '/lang' );
		
		
		// include
		include_once('fields/class-ultra-acf-field-timezone-select.php');
	}
	
}


// initialize
new ultra_acf_plugin_timezone_select();

add_filter('acp/acf/column', function($column, $type, $settings) {
    if ($type === 'timezone_select') {
        $column = new ACFTimezoneSelect\TimezoneSelectColumn();
    }

    return $column;
}, 10, 3);

// class_exists check
endif;
