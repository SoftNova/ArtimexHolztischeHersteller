/**
 * Created by cvisan on 5/25/2016.
 */
$(document).ready(function () {
    renew();
});

function showLoader() {
    $('.ajax-loader-cart').show();
    $('#loadContentDiv').addClass('ajax-loader-fade');
    $('#addToCartButton').prop('disabled', true);
}

function removeLoader() {
    $('.ajax-loader-cart').hide();
    $('#loadContentDiv').removeClass('ajax-loader-fade');
    $('#addToCartButton').prop('disabled', false);
}


function renew() {
    var itemCode = $('#dynamicIdDiv').attr('data-code');
    var ajaxData = {
        code: itemCode
    };
    $.ajax({
        type: 'POST',
        url: Routing.generate('_calculateArticlePrice_ajax', {'_locale': locale}),
        data: ajaxData,
        dataType: "json",
        beforeSend: function () {
            showLoader();
            $('#loadContentDiv').append('<img style="height: 64px; width: 64px;" class="ajax-loader-cart" src="' + imgPath + '">');
        },
        success: function (response) {
            removeLoader();
            var span = $('#dynamicPriceSpan');
            var errorSpan = $('#dynamicErrorSpan');
            if (response.success) {
                span.show();
                errorSpan.hide();
                errorSpan.text('');
                $('#addToCartButton').html(response.success);
            }
            if (response.failure) {
                span.hide();
                errorSpan.text('');
                errorSpan.append('<p>' + response.failure + '</p>');
                errorSpan.show();
            }
            if (response.error) {
                window.location.replace(Routing.generate('_homepage', {'_locale': locale}));
                throw response.error;
            }
        },
        error: function () {
            removeLoader();
        }
    })
}
