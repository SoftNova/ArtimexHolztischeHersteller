
$('#addToCartButton').on('click',function(){

    var itemCode = $('#dynamicIdDiv').attr('data-code');

    var ajaxData = {
        code: itemCode,
    };
    
    $.ajax({
        type: 'POST',
        url: Routing.generate('_add_article_to_cart', {'_locale' : locale}),
        data: ajaxData,
        dataType: "json",
        beforeSend: function(){
            $("html, body").animate({ scrollTop: 0 }, "slow");
        },
        success: function(response){
            if (response.success) {
                var cart = $('#cart');
                cart.text(cartTrs+' - ');
                cart.append('<span class="cart-amunt">' + currencyTrs + response.success.price + '</span>');
                cart.append('<span class="product-count">'+response.success.quantity+'</span>')
                cart.append('<i class="fa fa-shopping-cart"></i>');
                var imgtodrag = $('#displayImage');
                if (imgtodrag) {
                    var imgclone = imgtodrag.clone()
                        .offset({
                            top: imgtodrag.offset().top,
                            left: imgtodrag.offset().left
                        })
                        .css({
                            'opacity': '0.5',
                            'position': 'absolute',
                            'height': '150px',
                            'width': '150px',
                            'z-index': '100'
                        })
                        .appendTo($('body'))
                        .animate({
                            'top': cart.offset().top + 10,
                            'left': cart.offset().left + 10,
                            'width': 75,
                            'height': 75
                        }, 1000, 'easeInOutExpo');

                    setTimeout(function () {
                        cart.effect("shake", {
                            times: 2
                        }, 200);
                    }, 1500);

                    imgclone.animate({
                        'width': 0,
                        'height': 0
                    }, function () {
                        $(this).detach()
                    });
                }
            }
        },
        error: function () {
        }
    })
});