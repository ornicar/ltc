if ($('pre.cowsay').length) {
    $.ajax("http://lichess.org/fortune.php?cowsay=1", {
        dataType: "jsonp",
        success: function(text) { $('pre.cowsay').text(text); }
    });
}

$('a.confirm').click(function() {
    return confirm($(this).text()+' ?');
});
