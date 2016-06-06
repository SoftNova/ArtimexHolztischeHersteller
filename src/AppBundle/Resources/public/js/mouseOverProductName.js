/**
 * Created by cvisan on 6/6/2016.
 */
$(document).ready(function () {
    $('.itemDisplayName').hover(function () {
        var text = $(this).text();
        $(this).tooltipster({
            content: text,
            multiple:true
        });
    });
})
;