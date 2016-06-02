/**
 * Created by cvisan on 6/2/2016.
 */


imagePreview = function(){
    var material = $('.materialRadioMouseOver');
    xOffset = 10;
    yOffset = 30;
    //material.each(function () {
    //  var path = $(this).find('input').attr('data-imgPath');
    //$(this).tooltip({content: '<img src="' + path + '"/>'})
    //})

    material.hover(function (e) {
            var path = $(this).find('input').attr('data-imgPath');
            $('body').append("<p id='preview'><img class='hover-img' src='" + path + "'/>"+ "</p>");
            $("#preview")
                .css("top", (e.pageY - xOffset) + "px")
                .css("left", (e.pageX + yOffset) + "px")
                .css("position", "absolute")
                .fadeIn("fast");
        },
        function () {
            $("#preview").remove();
        });
    material.mousemove(function (e) {
        $("#preview")
            .css("top", (e.pageY - xOffset) + "px")
            .css("left", (e.pageX + yOffset) + "px");
    })

};
$(document).ready(function () {
    imagePreview();
})
;


