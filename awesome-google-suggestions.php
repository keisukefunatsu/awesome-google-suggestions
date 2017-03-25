<?php
/**
 * Plugin Name: AWESOME Google Suggestion
 * Plugin URI: https://awe-some.net
 * Description: This plugin allows you to check word count when editing text
 * Version: 0.0.1
 * Author: AWESOME Co.,Ltd.
 * Author URI: https://awe-some.net
 * Text Domain: awesome-google-suggestion
 * Domain Path: /languages
 * License: GPL v2 or later
 * Requires at least: 4.7
 * Tested up to: 4.7
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */




 function testAjax(){
     echo "あいうえお";
     die();
 }
 add_action( "wp_ajax_testAjax" , "testAjax" );
 add_action( "wp_ajax_nopriv_testAjax" , "testAjax" );


 /**
  * Display google suggestions for awesome wordpress project
  */

$display_google_suggesions = new DisplayGoogleSuggestions();
$display_google_suggesions->register();
class DisplayGoogleSuggestions
{
    /**
   * Register actions
   *
   * @param  none
   * @return none
   */
    public function register()
    {
        add_action('plugins_loaded', array( $this, 'plugins_loaded' ));
    }

    public function plugins_loaded()
    {
        add_action('edit_form_after_title', array( $this, 'display_suggest'  ));
        add_action('admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ));
        add_action('wp_ajax_awesome_google_suggestions', array( $this, 'wp_ajax_awesome_google_suggestions' ));
    }
    /**
     * Display form to show suggestions
     *
     * @param  none
     * @return none
     */
    public function display_suggest()
    {
        // echo '<form method="post" action="/wp-admin">';
        echo '<input class="awesome-google-suggestion-input" type="text" placeholder="Enter words here" name="" value="">';
        // echo '</form>';
    }

    /**
     * enqueue ajax-script
     *
     * @param  none
     * @return none
     */
    public function admin_enqueue_scripts()
    {
        wp_enqueue_script('awesome-google-suggestion',
        plugins_url('js/awesome-google-suggestions.js', __FILE__),
        array( 'jquery' ),
        filemtime(dirname(__FILE__) . '/js/awesome-google-suggestions.js')
      );
    }
    public function wp_ajax_awesome_google_suggestions()
    {
        if (! isset($_POST)) {
            //  echo json_encode('hello');
          echo 'hello';
        } else {
            echo 'good bye';
        }
    }



}
