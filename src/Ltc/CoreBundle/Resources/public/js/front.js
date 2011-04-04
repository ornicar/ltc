$(function() {

    $('div.home_overview div.category_column:first > div').each(function(index) {
        console.debug(index);
        $twin = $('div.home_overview div.category_column:eq(1) > div').eq(index);
        maxHeight = Math.max($(this).height(), $twin.height());
        $(this).height(maxHeight);
        $twin.height(maxHeight);
    });

    $('.js_email').text(['pascal', 'Duplessis@', 'aol.com'].join(''));

});

if (typeof console == "undefined" || typeof console.log == "undefined") console = {
    log: function() {}
};

$.fn.orNot = function() {
    return this.length == 0 ? false: this;
};

