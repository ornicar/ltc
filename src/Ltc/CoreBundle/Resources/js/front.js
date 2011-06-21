$(function() {
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
