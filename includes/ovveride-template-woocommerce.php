<?php
// Override Template Part's.
add_filter( 'wc_get_template_part',             'override_woocommerce_template_part', 10, 3 );
// Override Template's.
add_filter( 'woocommerce_locate_template',      'override_woocommerce_template', 10, 3 );
/**
 * Template Part's
 *
 * @param  string $template Default template file path.
 * @param  string $slug     Template file slug.
 * @param  string $name     Template file name.
 * @return string           Return the template part from plugin.
 */
function override_woocommerce_template_part( $template, $slug, $name ) {
// UNCOMMENT FOR @DEBUGGING
// echo '<pre>';
// echo 'template: ' . $template . '<br/>';
// echo 'slug: ' . $slug . '<br/>';
// echo 'name: ' . $name . '<br/>';
// echo '</pre>';
// Template directory.
// E.g. /wp-content/plugins/my-plugin/woocommerce/

    $template_directory = plugin_dir_path(dirname(__FILE__)) . 'woocommerce/';
    if ( $name ) {
        $path = $template_directory . "{$slug}-{$name}.php";

    } else {
        $path = $template_directory . "{$slug}.php";
    }

    return file_exists( $path ) ? $path : $template;
}
/**
 * Template File
 *
 * @param  string $template      Default template file  path.
 * @param  string $template_name Template file name.
 * @param  string $template_path Template file directory file path.
 * @return string                Return the template file from plugin.
 */
function override_woocommerce_template( $template, $template_name, $template_path ) {
// UNCOMMENT FOR @DEBUGGING
// echo '<pre>';
// echo 'template: ' . $template . '<br/>';
// echo 'template_name: ' . $template_name . '<br/>';
// echo 'template_path: ' . $template_path . '<br/>';
// echo '</pre>';
// Template directory.
// E.g. /wp-content/plugins/my-plugin/woocommerce/
    $template_directory = plugin_dir_path(dirname(__FILE__))  . 'woocommerce/';
    $path = $template_directory . $template_name;
    return file_exists( $path ) ? $path : $template;
}