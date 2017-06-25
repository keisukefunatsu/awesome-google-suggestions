<?php
/**
 * Plugin Name: AWESOME Google Suggestion
 * Plugin URI: https://awe-some.net
 * Description: This plugin allows you to check word count when editing text
 * Version: 0.0.1
 * Author: AWESOME Co.,Ltd.
 * Author URI: https://github.com/keisukefunatsu
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




 /**
  * Display google suggestions for awesome wordpress project.
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
			add_action('wp_ajax_awesome_google_suggestions', array( $this, 'wp_ajax_awesome_google_suggestions' ));
			add_action('edit_form_after_title', array( $this, 'display_suggestions'  ));
			add_action('admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ));
    }
		/**
		* Display form to show suggestions
		*
		* @param  none
		* @return none
		*/
		public function display_suggestions()
		{
			echo '<input class="awesome-google-suggestion-input" type="text" placeholder="Enter words here" name="" value="">';
			$ajax_url = admin_url('admin-ajax.php');
			$awesome_nonce = wp_create_nonce('awesome-google-suggestions');
			$awesome_args = array(
				'action' => 'awesome_google_suggestions',
				'nonce' => $awesome_nonce,
				); ?>
				<style media="screen">
					.awesome-google-suggestion-input {
						width: 45%;
						height: 30px;
					}
					.awesome-google-suggestion-results {
						display: none;
						padding: 30px 30px;
						font-size: 0.9rem;
						line-height: 1.3rem;
						position: relative;
						background: #bdccd6;
						border: 2px solid #c6c9cc;
						border-radius: 4px;
					}
					.awesome-google-suggestion-results:after, .awesome-google-suggestion-results:before {
						bottom: 100%;
						left: 50%;
						border: solid transparent;
						content: " ";
						height: 0;
						width: 0;
						position: absolute;
						pointer-events: none;
					}
					.awesome-google-suggestion-results:after {
						border-color: rgba(136, 183, 213, 0);
						border-bottom-color: #d7d9da;
						border-width: 30px;
						margin-left: -30px;
					}
					.awesome-google-suggestion-results:before {
						border-color: rgba(194, 225, 245, 0);
						border-bottom-color: #d7d9da;
						border-width: 36px;
						margin-left: -36px;
					}
				</style>
				<script type="text/javascript">
					var awesome_google_suggestions_uri = '<?php echo esc_url($ajax_url); ?>';
					var awesome_google_suggestions_args = <?php echo json_encode($awesome_args); ?>;
				</script>

			<?php

		}

		/**
		* enqueue ajax-script
		*
		* @param  none
		* @return none
		*/
		public function admin_enqueue_scripts($hook_suffix)
		{
			if ('post-new.php' === $hook_suffix || 'post.php' === $hook_suffix) {
				wp_enqueue_script(
					'awesome-google-suggestion',
					plugins_url('js/awesome-google-suggestions.js', __FILE__),
					array( 'jquery' ),
					filemtime(dirname(__FILE__) . '/js/awesome-google-suggestions.js')
				);
			}
		}
		/**
		* wp-ajax-script
		*
		* @param  none
		* @return json encoded google suggestion
		*/

		public function wp_ajax_awesome_google_suggestions()
			{
				nocache_headers();

				if (! isset($_GET['nonce']) || ! wp_verify_nonce($_GET['nonce'], 'awesome-google-suggestions')) {
					return;
				}

				header('Content-Type: application/javascript; charset=UTF-8');

				if ( isset( $_GET['text'] ) ) {
					$text = sanitize_text_field($_GET['text']);
					$url = 'https://www.google.com/complete/search?hl=ja&output=toolbar&ie=utf_8&oe=utf_8&q=' . $text ;
					$xml = simplexml_load_file($url);
					$json = json_encode($xml);
					echo $json;
				}
				die();
			}
}
