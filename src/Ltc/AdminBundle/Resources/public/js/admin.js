$(function() {
    $('a.confirm').click(function() {
        return confirm($(this).text() + ' ?');
    });

    if ($fullHeight = $('.full_height').orNot()) {
        $(window).resize(function() {
            $fullHeight.height($(window).height() - $('#header').height());
        }).trigger('resize');
    }

    $('form .with_image, form .with_file').each(function() {
        var $textarea = $(this).find('textarea');
        $(this).prepend($tools = $('<div class="tools">'));
        $(this).hasClass('with_image') && $tools.append($('<a>image</a>').click(function() {
            insertFromKcfinder($textarea, function(url) {
                return '![legende](' + url + ')';
            });
        }));
        $(this).hasClass('with_file') && $tools.append($('<a>fichier</a>').click(function() {
            insertFromKcfinder($textarea, function(url) {
                return '[nom](' + url + ')';
            });
        }));
    });

    $('textarea.textarea_tags').each(function() {
        var $self = $(this);
        $.get($self.data('url'), function(tags) {
            $self.autocomplete({
                source: tags
            });
        }, 'json');
    });
});

function insertFromKcfinder($textarea, callback) {
    window.KCFinder = {
        callBack: function(url) {
            url = url.replace(/\//, ltc_config.base_url);
            $textarea.insertAtCaret(callback(url));
        }
    };
    window.open('/manager/browse.php', 'kcfinder_single');
}

if (typeof console == "undefined" || typeof console.log == "undefined") console = {
    log: function() {}
};

$.fn.orNot = function() {
    return this.length == 0 ? false: this;
};

$.fn.extend({
    insertAtCaret: function(myValue) {
        return this.each(function(i) {
            if (document.selection) {
                this.focus();
                sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            }
            else if (this.selectionStart || this.selectionStart == '0') {
                var startPos = this.selectionStart;
                var endPos = this.selectionEnd;
                var scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos) + myValue + this.value.substring(endPos, this.value.length);
                this.focus();
                this.selectionStart = startPos + myValue.length;
                this.selectionEnd = startPos + myValue.length;
                this.scrollTop = scrollTop;
            } else {
                this.value += myValue;
                this.focus();
            }
        })
    }
});
