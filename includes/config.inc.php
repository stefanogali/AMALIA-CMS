<?php
/**
 * Absolute path to application root directory (one level above current dir)
 */
$config['app_dir'] = dirname(dirname(__FILE__));
 
/**
 * Absolute path to directory where uploaded files will be stored
 * Using an absolute path to the upload dir can help circumvent security restrictions on some servers
 */
$config['upload_dir'] = $config['app_dir'] . '/uploads/';
$config['upload_footer_dir'] = $config['app_dir'] . '/footer-uploads/';
$config['slider_images_dir'] = $config['app_dir'] . '/slider-images/';
$config['images_dir'] = $config['app_dir'] . '/images/';
?>