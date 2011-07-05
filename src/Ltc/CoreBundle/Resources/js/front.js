$(function() {
    var email = ['pascal', 'Duplessis@', 'aol.com'].join('');
    $('.js_email').text(email).attr('href', 'mailto:'+email);

    $('.infinitescroll').each(function() {
        $(this).infinitescroll({
            navSelector: "div.pager",
            nextSelector: "div.pager a.next",
            itemSelector: ".infinitescroll .paginated_item",
            loadingText: "Chargement des articles suivants...",
            donetext: "Fin de la liste des articles."
        }).find('div.pager').hide();
    });

    $('input.hint_me').hints();
});

if (typeof console == "undefined" || typeof console.log == "undefined") console = {
    log: function() {},
    debug: function() {}
};

$.fn.orNot = function() {
    return this.length == 0 ? false: this;
};
