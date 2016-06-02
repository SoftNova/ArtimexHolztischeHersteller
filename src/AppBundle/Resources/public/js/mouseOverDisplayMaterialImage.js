/**
 * Created by cvisan on 6/2/2016.
 */
$(document).ready(function () {
    var material =  $('#materialRadio');
    material.tooltip({content:'<img src="'+ material.find('input').attr('data-imgPath') +'">'})
});