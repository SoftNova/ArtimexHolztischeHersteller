/**
 * Created by cvisan on 5/25/2016.
 */

function showLoader(){
    $('.ajax-loader').show();
}

function removeLoader(){
    $('.ajax-loader').hide();
}
$(document).ready(function () {
    renew();
});

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
    var material = $('input[name=matRadio]:checked', '#matDiv').val();
    $('#dynamicWood').text(material);

    var quality = $('input[name=qualityRadio]:checked', '#qualityDiv').val();
    $('#dynamicQuality').text(quality);

    var tempering = $('input[name=temperingRadio]:checked', '#temperingDiv').val();
    $('#dynamicTempering').text(tempering);


    var itemID = $('#dynamicIdDiv').attr('data-code');
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
        material: material,
        quality: quality,
        tempering: tempering,
        itemID: itemID
    };
    $.ajax({
        type: 'POST',
        url: path,
        data: ajaxData,
        dataType: "json",
        beforeSend: function(){
            showLoader()
        },
        success: function(response){
            $('#addToCartButton').html(response);
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
    renew();

}