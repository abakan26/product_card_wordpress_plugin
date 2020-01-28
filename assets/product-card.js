jQuery(document).ready(function () {

/*
** Кнопка удаления из корзины
*/
    jQuery(".card-body-new").on("click", ".vn-remove-item", function () {
        var button_rem = jQuery(this);
        var product_id = button_rem.data("product_id");
        var product_wrapper = button_rem.parents(".card-body-new");
        button_rem.addClass('loading');

        jQuery.ajax({
            type: "post",
            url: wc_add_to_cart_params.ajax_url,
            data: {action: 'remove_item_from_cart', 'product_id': product_id},
            success: function (res) {
                
                var vn_count = jQuery(".vn-product-count-"+product_id);                
                button_rem.removeClass('loading');
                if (res != 0) {
                    product_wrapper.addClass("card-selected");
                    button_rem.show();
                    vn_count.show();
                    vn_count.text(res + "x ");
                }
                else {
                    product_wrapper.removeClass("card-selected");
                    button_rem.hide();
                    vn_count.hide();
                    jQuery(".vn-product-count-"+product_id).text("");
                }
            }
        });
    })

/*
** Кнопка кнпока добавления в корзину
*/
    jQuery( document.body ).on( 'added_to_cart', function( e, fragments, cart_hash, button ) {
        var product_id = button.data("product_id");
        var button_rem = jQuery(".vn-remove-item-"+product_id);
        var product_wrapper = button_rem.parents(".card-body-new");

        jQuery.ajax({
            type: "post",
            url: wc_add_to_cart_params.ajax_url,
            data: {action: 'count_item_from_cart', 'product_id': product_id},
            success: function (res) {
                var vn_count = jQuery(".vn-product-count-"+product_id);
                

                if (res != 0) {
                    product_wrapper.addClass("card-selected");
                    vn_count.show();
                    button_rem.show();
                    vn_count.text(res + "x ");
                }
                else {
                    vn_count.hide();
                    jQuery(".vn-product-count-"+product_id).text("");
                }
            }
        });
    });

});