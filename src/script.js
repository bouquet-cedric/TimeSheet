/* jshint esversion: 6 */

var actif = 1;
var isActive = false;

function applyKey(event) {
    let evt = event || window.event;
    if (isActive) {
        if (evt.keyCode == '37') {
            previousMonth();
        }
        if (evt.keyCode == '39')
            nextMonth();
    }
}


document.onkeydown = applyKey;


function nextMonth() {
    var d = null;
    if (actif + 1 <= 12) {
        for (let i = 0; i < 12; i++) {
            d = document.getElementsByClassName('month_' + (i + 1));
            for (let elts of d) {
                elts.style.display = 'none';
            }
        }
        actif++;
        d = document.getElementsByClassName('month_' + actif);
        for (let elts of d) {
            elts.style.display = 'table-row';
        }
    }
}

function initMonth() {
    var d = null;
    for (let i = 0; i < 12; i++) {
        d = document.getElementsByClassName('month_' + (i + 1));
        for (let elts of d) {
            elts.style.display = 'none';
        }
    }
    d = document.getElementsByClassName('month_' + actif);
    for (let elts of d) {
        elts.style.display = 'table-row';
    }
}

function previousMonth() {
    var d = null;
    if (actif - 1 > 0) {
        for (let i = 0; i < 12; i++) {
            d = document.getElementsByClassName('month_' + (i + 1));
            for (let elts of d) {
                elts.style.display = 'none';
            }
        }
        actif--;
        d = document.getElementsByClassName('month_' + actif);
        for (let elts of d) {
            elts.style.display = 'table-row';
        }
    }
}

function fillComment() {
    $('#jiras-input').on('input', function() {
        var opt = $('option[value="' + $(this).val() + '"]');
        $('#commentary').val(opt.length ? opt.attr('comment') : '');
    });
}