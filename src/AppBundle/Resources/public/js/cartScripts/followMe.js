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

});