/**
 * Created by cvisan on 6/6/2016.
 */
$(document).ready(function () {

    var p=$('.itemDisplayName');
    p.hover(function (e) {
        var text = $(this).text();
        $(this).tooltipster({
            content: $(text)
        });
    });
})
;