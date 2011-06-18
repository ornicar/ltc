$(function() {

    $('div.home_overview div.category_column:first > div').each(function(index) {
        $twin = $('div.home_overview div.category_column:eq(1) > div').eq(index);
        maxHeight = Math.max($(this).height(), $twin.height());
        $(this).height(maxHeight);
        $twin.height(maxHeight);
    });

    $('.js_email').text(['pascal', 'Duplessis@', 'aol.com'].join(''));

    $('.infinitescroll').each(function() {
        $(this).infinitescroll({
            navSelector: "div.pagination",
            nextSelector: "div.pagination a.next",
            itemSelector: ".infinitescroll .paginated_item",
            loadingText: "Chargement des articles suivants...",
            donetext: "Fin de la liste des articles."
        }).find('div.pagination').hide();
    });
});

if (typeof console == "undefined" || typeof console.log == "undefined") console = {
    log: function() {},
    debug: function() {}
};

$.fn.orNot = function() {
    return this.length == 0 ? false: this;
};
