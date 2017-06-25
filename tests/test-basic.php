<?php
/**
 * Class SampleTest
 *
 * @package Awesome_Google_Suggestions
 */

/**
 * Sample test case.
 */

class BasicTest extends WP_UnitTestCase
{
    public function test_admin_enqueue_scripts()
    {
        // *
        // * wp_script_is('awesome-google-suggestion') should be false
        // * when template is not post.php or post-new.php
        // */
        $display_google_suggesions = new DisplayGoogleSuggestions();
        $display_google_suggesions->admin_enqueue_scripts( '' );
        $this->assertFalse(wp_script_is('awesome-google-suggestion'));

        // *
        // * wp_script_is('awesome-google-suggestion') should be true
        // * when template is not post.php
        // */
        $display_google_suggesions = new DisplayGoogleSuggestions();
        $display_google_suggesions->admin_enqueue_scripts( 'post.php' );
        $this->assertTrue(wp_script_is('awesome-google-suggestion'));

        // *
        // * wp_script_is('awesome-google-suggestion') should be true
        // * when template is not post-new.php
        // */
        $display_google_suggesions = new DisplayGoogleSuggestions();
        $display_google_suggesions->admin_enqueue_scripts( 'post-new.php' );
        $this->assertTrue(wp_script_is('awesome-google-suggestion'));
    }
}
