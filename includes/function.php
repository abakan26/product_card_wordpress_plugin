<?php
remove_action("woocommerce_before_shop_loop_item", "woocommerce_template_loop_product_link_open", 10);
add_action("woocommerce_before_shop_loop_item", "vn_template_loop_product_link_open");
function vn_template_loop_product_link_open()
{
    global $product;

    $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

    echo '<a href="' . esc_url( $link ) . '" class=" woocommerce-LoopProduct-link woocommerce-loop-product__link">';
}
/*
**Title
*/
remove_action( 'woocommerce_shop_loop_item_title' , 'woocommerce_template_loop_product_title', 10);

add_action( 'woo_shop_loop_item_title' , 'vn_template_loop_product_title', 10);
function vn_template_loop_product_title() {
    global $product;
    $vn_product__mass = vn_product_mass();
    echo '<div class="vni_cart_text_fl_none text-center">' .
        '<h5 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . ' card-title text-center">' . get_the_title() . " ($vn_product__mass г)</h5>"
        .     '<p class="card-title">'. $product->get_description().'</p>'
        .'</div>'
    ;
}

/*
Button add to card
*/
remove_action( 'woocommerce_after_shop_loop_item' , 'woocommerce_template_loop_add_to_cart', 10);

//add_action("woocommerce_after_shop_loop_item", "vn_template_loop_add_to_cart", 10);
function vn_template_loop_add_to_cart( $args = array() ) {
    global $product;

    if ( $product ) {
        $defaults = array(
            'quantity'   => 1,
            'class'      => implode(
                ' ',
                array_filter(
                    array(
                        'button',
                        'product_type_' . $product->get_type(),
                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                        $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                    )
                )
            ),
            'attributes' => array(
                'data-product_id'  => $product->get_id(),
                'data-product_sku' => $product->get_sku(),
                'aria-label'       => $product->add_to_cart_description(),
                'rel'              => 'nofollow',
            ),
        );

        $args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

        if ( isset( $args['attributes']['aria-label'] ) ) {
            $args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
        }

        wc_get_template( 'loop/add-to-cart.php', $args );
    }
}
/*
*/

/*
Price
*/
remove_action( 'woocommerce_after_shop_loop_item_title' , 'woocommerce_template_loop_price', 10);

/*
Mass
*/

function vn_product_mass()
{
    global $product;
    if ( $mass = (float) $product->get_weight() ){
        $mass = (int) ($mass * 1000);
        return $mass;
    }
}

/**
 * Добавляем поле количества на страницу архивов.
 */
function custom_quantity_field_archive() {
    $product = wc_get_product( get_the_ID() );
    if ( ! $product->is_sold_individually() && 'variable' != $product->product_type && $product->is_purchasable() ) {
        woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
    }
}

function wpp_get_product_count_in_cart( $product_id = null ) {

    if ( empty( $product_id ) ) {
        global $product;
        $product_id = $product->id;
    }

    $wc_cart = WC()->cart;

    $product_cart_id = $wc_cart->generate_cart_id( $product_id );
    $in_cart = $wc_cart->find_product_in_cart( $product_cart_id );
    $cart = $wc_cart->get_cart();

    return !empty( $in_cart ) ? $cart[ $in_cart ][ 'quantity' ] : 0;
}

/*
 * Удаление из корзины аякс
 */
function remove_item_from_cart()
{

    $cart = WC()->instance()->cart;
    $id = $_POST['product_id'];

    $cart_id = $cart->generate_cart_id($id);
    $cart_item_id = $cart->find_product_in_cart($cart_id);
    $quantity = 0;

    if ($cart_item_id) {
        $quantity = $cart->get_cart()[ $cart_item_id ][ 'quantity' ];

        $cart->set_quantity($cart_item_id, $quantity-1);
        $new_quantity = $cart->get_cart()[ $cart_item_id ][ 'quantity' ];
        echo ! is_null($new_quantity) ?  $new_quantity :  0;
    }

    wp_die();
}

add_action('wp_ajax_remove_item_from_cart', 'remove_item_from_cart');
add_action('wp_ajax_nopriv_remove_item_from_cart', 'remove_item_from_cart');
/*
 * Количество после добавления аякс
 */
function vn_count_item_from_cart()
{


    $cart = WC()->instance()->cart;
    $id = $_POST['product_id'];

    $cart_id = $cart->generate_cart_id($id);
    $cart_item_id = $cart->find_product_in_cart($cart_id);
    $quantity = 0;

    if ($cart_item_id) {
        $quantity = $cart->get_cart()[ $cart_item_id ][ 'quantity' ];
        echo ! is_null($quantity) ?  $quantity :  0;
    }

    wp_die();
}

add_action('wp_ajax_count_item_from_cart', 'vn_count_item_from_cart');
add_action('wp_ajax_nopriv_count_item_from_cart', 'vn_count_item_from_cart');