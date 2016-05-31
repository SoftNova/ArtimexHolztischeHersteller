/**
 * Created by cvisan on 5/25/2016.
 */
$(document).ready(function () {
    renew();
});

function showLoader(){
    $('.ajax-loader').show();
    $('#loadContentDiv').addClass('ajax-loader-fade');
    $('#loadImageDiv').addClass('ajax-loader-fade');
    $('#addToCartButton').prop('disabled',true);
}

function removeLoader(){
    $('.ajax-loader').hide();
    $('#loadContentDiv').removeClass('ajax-loader-fade');
    $('#loadImageDiv').removeClass('ajax-loader-fade');
    $('#addToCartButton').prop('disabled', false);
}


function renew() {
    var length = $('#lengthSelect').find('option:selected').text();
    var width = $('#widthSelect').find('option:selected').text();
    var height = $('#heightSelect').find('option:selected').text();
    $('#dynamicDimensions').text(length + 'x' + width + 'x' + height);

    var profile = $('input[name=profRadio]:checked', '#profDiv').val();
    $('#dynamicProfile').text(profile);

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
    var material = $('input[name=matRadio]:checked', '#matDiv');
    $('#dynamicWood').text(material.attr('data-name'));

    var materialID=material.val();

    var quality = $('input[name=qualityRadio]:checked', '#qualityDiv').val();
    $('#dynamicQuality').text(quality);

    var tempering = $('input[name=temperingRadio]:checked', '#temperingDiv').val();
    $('#dynamicTempering').text(tempering);


    var itemCode = $('#dynamicIdDiv').attr('data-code');
    var path = $('#dynamicPriceDiv').attr('data-path');
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
        url: path,
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
    var path = $('#loadImageDiv').attr('data-path');
    var material = $('input[name=matRadio]:checked', '#matDiv').val();
    var ajaxData={
        itemCode: itemCode,
        material: material
    };
    $.ajax({
        type: 'POST',
        url: path,
        data: ajaxData,
        dataType: "json",
        beforeSend: function(){
            showLoader();
        },
        success: function (response) {
            $('#displayImage').attr('src',response);
            removeLoader();
        }
    })
}
