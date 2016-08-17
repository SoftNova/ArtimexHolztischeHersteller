/**
 * Created by cvisan on 6/17/2016.
 */
(function($) {
    if ($(window).width() >= 768){
        var element = $('#grand-total'),
            originalY = element.offset().top;
        // Space between element and top of screen (when scrolling)
        var topMargin = 20;

        // Should probably be set in CSS; but here just for emphasis
        element.css('position', 'relative');

        $(window).on('scroll', function(event) {
            var scrollTop = $(window).scrollTop();

            element.stop(false, false).animate({
                top: scrollTop < originalY
                    ? 0
                    : scrollTop - originalY + topMargin
            }, 300);
        });
    }
})(jQuery);

$('.with-font').on('change',function(){
    $('.hidden-tooltip').hide();
    $(this).parent().find('.hidden-tooltip').show();
    var grandTotal= $('#cartGrandTotal');
    var disc =parseInt($(this).attr('data-disc'));
    var total = parseInt(grandTotal.attr('data-grt'));
    total = Math.floor(total - (disc/100 * total));
    var cur = grandTotal.attr('data-cur');
    grandTotal.text(cur+total+',00');
    grandTotal.effect('slide');
});