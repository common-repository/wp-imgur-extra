<?php
/*
Plugin Name: wp-imgur-extra
Description: This plugin based on wp-imgur by Darshan Sawardekar with added option to enable https for image.
Version: 0.7.1
Author: Ahmad Fikrizaman
Author URI: https://blog.whop.io
Plugin URI: http://wordpress.org/plugins/wp-imgur-extra
License: GPLv2
 */

require_once __DIR__ . '/vendor/dsawardekar/arrow/lib/Arrow/ArrowPluginLoader.php';

function wp_imgur_extra_main()
{
    $options = array(
        'plugin'       => 'WpImgurExtra\Plugin',
        'arrowVersion' => '1.8.0',
    );

    ArrowPluginLoader::load(__FILE__, $options);
}

wp_imgur_extra_main();
