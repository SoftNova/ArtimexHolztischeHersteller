/**
 * Created by cvisan on 6/10/2016.
 */

function addToCard(){
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