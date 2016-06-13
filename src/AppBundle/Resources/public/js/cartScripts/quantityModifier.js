/**
 * Created by cvisan on 6/13/2016.
 */


$(document).ajaxStop(function () {
    $('#grand-total').effect("slide");
    $('#cart').effect('slide');
});

function modifyMe(caller) {
    var itemCode = $(caller).attr('data-code');
    var itemNewQuantity = $(caller).find('option:selected').val();
    $.ajax({
        type: 'POST',
        url: Routing.generate('_modify_cart_item_quantity', {'_locale': locale}),
        data: {
            itemCode: itemCode,
            itemNewQuantity: itemNewQuantity
        },
        dataType: "json",
        beforeSend: function () {
            var row = $('#' + itemCode);
            row.append('<img style="height: 64px; width: 64px;" class="ajax-loader-cart" src="' + imgPath + '">');
            row.find('div').css({'opacity': 0.1});
        },
        success: function (response) {
            if (response.success) {

                var cart = $('#cart');
                cart.text(cartTrs + ' - ');
                cart.append('<span class="cart-amunt">' + currencyTrs + response.success.price + '</span>');
                cart.append('<span class="product-count">' + response.success.quantity + '</span>');
                cart.append('<i class="fa fa-shopping-cart"></i>');
                $('#cartDynamicContent').html(response.success.content);
            }
            if (response.failure) {
                window.location.replace(Routing.generate('_homepage'));
                throw response.error;
            }
        }
    })
}
