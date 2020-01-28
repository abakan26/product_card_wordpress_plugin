<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

?>

<li <?php wc_product_class( 'col-xl-4 col-md-6 col-sm-12 d-flex justify-content-center', $product ); ?> >
    <?php
    $vn_pr_id = $product->get_id();    
    $vn_product_count = wpp_get_product_count_in_cart($vn_pr_id) ? wpp_get_product_count_in_cart($vn_pr_id) . 'x' : "";

    $show_button = ! $vn_product_count ? "none" : "block";
    $selected = ! $vn_product_count ? "" : "card-selected";
    echo "
        <div class='card-body-new $selected' >
            <div class='vn_img_wrapper_product'>
            	";
					
    echo "      ";
    			do_action( 'woocommerce_before_shop_loop_item_title' );

    echo "	</div>";
    			do_action( 'woo_shop_loop_item_title' );
    echo "	<div class='row product__bottom'>
			    <div class='col-3 product__bottom_item'>
			        <button style='display: $show_button' class='vn-remove-item vn-remove-item-{$vn_pr_id}' data-product_id={$vn_pr_id}>-</button>
                </div>
			    <div class='col-6 product__bottom_item'>
			    	<span class='vn-product-count vn-product-count-{$vn_pr_id}' >$vn_product_count</span>";
	echo     		$product->price . " тг";
    echo "      </div>
			    <div class='vn-plus col-3 product__bottom_item'>";
                    custom_quantity_field_archive();
                    do_action( 'woocommerce_after_shop_loop_item' );
    echo "	    </div>
            </div>
        </div>    
    ";

    ?>
</li>