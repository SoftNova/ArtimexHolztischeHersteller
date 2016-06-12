/**
 * Created by rvcat on 6/12/2016.
 */


function removeMe(caller){
    var itemCode = $(caller).attr('data-code');

    $.ajax({
        type: 'POST',
        url: Routing.generate('_remove_item_from_cart', {'_locale' : locale}),
        data: {itemCode: itemCode},
        dataType: "json",
        success: function(response) {
            var cart = $('#cart');
            cart.text(cartTrs+' - ');
            cart.append('<span class="cart-amunt">' + currencyTrs + response.success.price + '</span>');
            cart.append('<span class="product-count">'+response.success.quantity+'</span>')
            cart.append('<i class="fa fa-shopping-cart"></i>');
        }
    })
}