<?php
/**
 * Plugin Name: SocialLinks
 * Description: Add simple social media text links to pages and posts. Currently supported: Twitter, Facebook, Google+ and LinkedIn.
 * Version: 0.0.1
 * Author: Jan Kossick
 * Author URI: https://g4rf.net
 */

// check if the wordpress core is loaded
defined('ABSPATH') or die('No script kiddies please!');

// add css
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style('g4rf-sociallinks', 
            plugins_url('css/g4rf-sociallinks.css', __FILE__));
});

// social links
add_filter('the_content', function($content) {
    // posts, pages and only on the main content
    if(is_front_page() || !is_singular() || !is_main_query() ) return $content;
 
    $link = urlencode(get_permalink());
    $text = urlencode(get_the_title());
    $image = urlencode(get_the_post_thumbnail_url(get_the_ID(), 'full'));
    if(!$image) $image = '';
    $hashtags = urlencode('#wennschönsächsisch #wennscheensäggsch #häschdäg');
    
    $sociallinks = <<<SOCIALLINKS
            
    <div class="g4rf-socialmedia">
        teilen auf:
        <a href="https://twitter.com/home?status=$text%20$link%20$hashtags"
            class="g4rf-twitter" target="_blank">twitter</a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=$link"
            class="g4rf-facebook" target="_blank">facebook</a>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url=$link&title=$text&summary=#$hashtags&source="
            class="g4rf-linkedin" target="_blank">linkedin</a>
        <a href="http://pinterest.com/pin/create/button/?url=$link&media=$image&description=$text%20$hashtags"
            class="g4rf-pinterest" target="_blank">pinterest</a>
    </div>
SOCIALLINKS;

    return $content . $sociallinks;
});