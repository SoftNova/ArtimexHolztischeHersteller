/**
 * Created by cvisan on 5/25/2016.
 */
$(document).ready(function () {
    renew();
});

function showLoader(){
    $('.ajax-loader').show();
    $('#loadContentDiv').addClass('ajax-loader-fade');

    $('#addToCartButton').prop('disabled',true);
}

function removeLoader(){
    $('.ajax-loader').hide();
    $('#loadContentDiv').removeClass('ajax-loader-fade');
    $('#addToCartButton').prop('disabled', false);
}


function renew() {
    var length = $('#lengthSelect').find('option:selected').text();
    var width = $('#widthSelect').find('option:selected').text();
    var height = $('#heightSelect').find('option:selected').text();
    $('#dynamicDimensions').text(length + 'x' + width + 'x' + height);

    var profileObj = $('input[name=profRadio]:checked', '#profDiv');
    $('#dynamicProfile').text(profileObj.attr('data-name'));
    var profile= profileObj.val();

    var extensions = $('input[name=extRadio]:checked', '#extDiv').val();
    if (extensions == 0) {
        $('#dynamicExtDiv').hide();
    } else {
        $('#dynamicExtDiv').show();
        var extLength = $('#extLengthSelect').find('option:selected').text();
        $('#dynamicExt').text(extensions + " (" + extLength + "cm)");
    }

    var drawers = $('input[name=drawerRadio]:checked', '#drawerDiv').val();
    if (drawers == 0) {
        $('#dynamicDrawerDiv').hide();
    } else {
        $('#dynamicDrawerDiv').show();
        var drawerLength = $('#drawerLengthSelect').find('option:selected').text();
        $('#dynamicDrawer').text(drawers + " (" + drawerLength + "cm)");
    }

    var materialObj = $('input[name=matRadio]:checked', '#matDiv');
    $('#dynamicWood').text(materialObj.attr('data-name'));
    var materialID=materialObj.val();

    var qualityObj = $('input[name=qualityRadio]:checked', '#qualityDiv');
    $('#dynamicQuality').text(qualityObj.attr('data-name'));
    var quality=qualityObj.val();

    var temperingObj = $('input[name=temperingRadio]:checked', '#temperingDiv');
    $('#dynamicTempering').text(temperingObj.attr('data-name'));
    var tempering=temperingObj.val();

    var itemCode = $('#dynamicIdDiv').attr('data-code');
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
        code: itemCode
    };
    $.ajax({
        type: 'POST',
        url: Routing.generate('_calculatePrice_ajax', {'_locale' : locale}),
        data: ajaxData,
        dataType: "json",
        beforeSend: function(){
            showLoader();
        },
        success: function(response){
            removeLoader();
            var span = $('#dynamicPriceSpan');
            var errorSpan = $('#dynamicErrorSpan');
            if (response.success) {
                span.show();
                errorSpan.hide();
                errorSpan.text('');
                $('#addToCartButton').html(response.success);
            }
            if (response.failure){
                span.hide();
                errorSpan.text('');
                errorSpan.append('<p>' + response.failure + '</p>');
                errorSpan.show();
            }
            if (response.error){
                alert('Data corruption detected');
                window.location.replace(Routing.generate('_homepage'));
                throw response.error;
            }
        },
        error: function () {
            removeLoader();
        }
    })
}

$('select').on('change', function () {
    renew();
});
$('input[type=radio]').change(function(){
    renew();
});
$('input[type=radio][name=matRadio]').change(function(){
    renewWithImage();
});

function renewWithImage() {
    var itemCode = $('#dynamicIdDiv').attr('data-code');
    var material = $('input[name=matRadio]:checked', '#matDiv').val();
    var ajaxData={
        itemCode: itemCode,
        material: material
    };
    $.ajax({
        type: 'POST',
        url: Routing.generate('_getPrimaryImageByMaterial', {'_locale' : locale}),
        data: ajaxData,
        dataType: "json",
        beforeSend: function(){
            $('#loadImageDiv').addClass('ajax-loader-fade');
        },
        success: function (response) {
            $('#displayImage').attr('src',response);
            $('#loadImageDiv').removeClass('ajax-loader-fade');
        }
    })
}



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

    var dimensionsString = length + 'x' + width + 'x' + height;
    var profileString = profileObj.attr('data-name');
    var drawersString = drawers + " (" + drawerLength + "cm)";
    var extString = extensions + " (" + extLength + "cm)";
    var materialString = materialObj.attr('data-name');
    var qualityString = qualityObj.attr('data-name');
    var temperingString = temperingObj.attr('data-name');

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
        temperingString: temperingString
    };
    $.ajax({
        type: 'POST',
        url: Routing.generate('_add_table_to_cart', {'_locale' : locale}),
        data: ajaxData,
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            if (response.success) {
                alert("yay");
                var cart = $('#cart');
                cart.text(cartTrs+' - ');
                cart.append('<span class="cart-amunt">' + response.success.price + '</span>');
                cart.append('<span class="product-count">'+response.success.quantity+'</span>')

            }
        },
        error: function () {
        }
    })
});