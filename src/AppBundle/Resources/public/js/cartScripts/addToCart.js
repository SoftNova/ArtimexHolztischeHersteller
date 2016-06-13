
$('#addToCartButton').on('click',function(){
    var length = $('#lengthSelect').find('option:selected').text();

    var width = $('#widthSelect').find('option:selected').text();

    var height = $('#heightSelect').find('option:selected').text();

    var profileObj = $('input[name=profRadio]:checked', '#profDiv');
    var profile= profileObj.val();

    var extensions = $('input[name=extRadio]:checked', '#extDiv').val();
    if (extensions != 0) {
        var extLength = $('#extLengthSelect').find('option:selected').text();
    }

    var drawers = $('input[name=drawerRadio]:checked', '#drawerDiv').val();
    if (drawers != 0) {
        var drawerLength = $('#drawerLengthSelect').find('option:selected').text();
    }

    var materialObj = $('input[name=matRadio]:checked', '#matDiv');
    var materialID=materialObj.val();

    var qualityObj = $('input[name=qualityRadio]:checked', '#qualityDiv');
    var quality=qualityObj.val();

    var temperingObj = $('input[name=temperingRadio]:checked', '#temperingDiv');
    var tempering=temperingObj.val();

    var itemCode = $('#dynamicIdDiv').attr('data-code');

    var dimensionsString = dimensionsLabel + length + 'x' + width + 'x' + height;
    var profileString =profileLabel+ profileObj.attr('data-name');
    var drawersString = (drawers>0) ? drawerLabel + drawers + " (" + drawerLength + "cm)" : null;
    var extString = (extensions>0) ? extLabel + extensions +" (" + extLength + "cm)":null;
    var materialString =materialLabel+ materialObj.attr('data-name');
    var qualityString = qualityLabel+ qualityObj.attr('data-name');
    var temperingString = temperingLabel+ temperingObj.attr('data-name');
    var distanceToSides =$('input[name=distRadio]:checked', '#distDiv').val();

    var ajaxData = {
        length: length,
        width: width,
        height: height,
        profile: profile,
        extensions: extensions,
        extLength: extLength,
        drawers: drawers,
        drawerLength: drawerLength,
        material: materialID,
        quality: quality,
        tempering: tempering,
        code: itemCode,
        dimensionsString: dimensionsString,
        profileString: profileString,
        drawersString: drawersString,
        extString: extString,
        materialString: materialString,
        qualityString: qualityString,
        temperingString: temperingString,
        distanceToSides: distanceToSides
    };
    $.ajax({
        type: 'POST',
        url: Routing.generate('_add_table_to_cart', {'_locale' : locale}),
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