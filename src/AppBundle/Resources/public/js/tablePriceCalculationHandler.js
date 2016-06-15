/**
 * Created by cvisan on 5/25/2016.
 */
$(document).ready(function () {
    renew();

    var materialObj = $('input[name=matRadio]:checked', '#matDiv');
    var materialTempering = materialObj.attr('data-is-tempered');
    if (materialTempering=="1") {
        $('#temperingDiv').effect('clip');
        $('#temperingDivHr').effect('clip');
    }
    else {
        $('#temperingDiv').effect('slide');
        $('#temperingDivHr').effect('slide');
    }
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
    var length = $('#lengthSelect').find('option:selected').text();
    var width = $('#widthSelect').find('option:selected').text();
    var height = $('#heightSelect').find('option:selected').text();
    $('#dynamicDimensions').text(length + 'x' + width + 'x' + height);

    var profileObj = $('input[name=profRadio]:checked', '#profDiv');
    $('#dynamicProfile').text(profileObj.attr('data-name'));
    var profile = profileObj.val();

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
    var materialID = materialObj.val();

    var materialTempering = materialObj.attr('data-is-tempered');
    if (materialTempering=="1"){
        $('input[name=temperingRadio]').each(function(){
            $(this).attr('disabled','disabled');
        });

    }else{
        $('input[name=temperingRadio]').each(function(){
            $(this).removeAttr('disabled');
        });

    }
    var qualityObj = $('input[name=qualityRadio]:checked', '#qualityDiv');
    $('#dynamicQuality').text(qualityObj.attr('data-name'));
    var quality = qualityObj.val();

    var temperingObj = $('input[name=temperingRadio]:checked', '#temperingDiv');
    if (materialTempering==1){
        $('#dynamicTempering').text(temperingTrans);
        var tempering = undefined;
    }
    else{
        $('#dynamicTempering').text(temperingObj.attr('data-name'));
        var tempering = temperingObj.val();
    }
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
        url: Routing.generate('_calculatePrice_ajax', {'_locale': locale}),
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

$('select').on('change', function () {
    renew();
});
$('input[type=radio]').not('.matRadio').change(function () {
    renew();
});
$('input[type=radio][name=matRadio]').change(function () {
    $.when(renew()).done(function ()
        {
            renewWithImage();
        }
    )
});


function renewWithImage() {
    var itemCode = $('#dynamicIdDiv').attr('data-code');

    var materialObj = $('input[name=matRadio]:checked', '#matDiv');
    var material = materialObj.val();


    var materialTempering = materialObj.attr('data-is-tempered');
    if (materialTempering=="1") {
        $('#temperingDiv').effect('clip');
        $('#temperingDivHr').effect('clip');
    }
    else {
        $('#temperingDiv').effect('slide');
        $('#temperingDivHr').effect('slide');
    }
    var ajaxData = {
        itemCode: itemCode,
        material: material
    };
    $.ajax({
        type: 'POST',
        url: Routing.generate('_getPrimaryImageByMaterial', {'_locale': locale}),
        data: ajaxData,
        dataType: "json",
        beforeSend: function () {
            $('#loadImageDiv').addClass('ajax-loader-fade');
        },
        success: function (response) {
            $('#displayImage').attr('src', response);
            $('#loadImageDiv').removeClass('ajax-loader-fade');
            $('#loadImageDiv').effect('slide');
        }
    })
}


