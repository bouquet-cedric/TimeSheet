var actif = 1;

function nextMonth() {
    if (actif + 1 <= 12) {
        for (let i = 0; i < 12; i++) {
            var d = document.getElementsByClassName('month_' + (i + 1));
            for (let elts of d) {
                elts.style.display = 'none';
            }
        }
        actif++;
        var d = document.getElementsByClassName('month_' + actif);
        for (let elts of d) {
            elts.style.display = 'table-row';
        }
    }
}

function initMonth() {
    for (let i = 0; i < 12; i++) {
        var d = document.getElementsByClassName('month_' + (i + 1));
        for (let elts of d) {
            elts.style.display = 'none';
        }
    }
    var d = document.getElementsByClassName('month_' + actif);
    for (let elts of d) {
        elts.style.display = 'table-row';
    }
}

function previousMonth() {
    if (actif - 1 > 0) {
        for (let i = 0; i < 12; i++) {
            var d = document.getElementsByClassName('month_' + (i + 1));
            for (let elts of d) {
                elts.style.display = 'none';
            }
        }
        actif--;
        var d = document.getElementsByClassName('month_' + actif);
        for (let elts of d) {
            elts.style.display = 'table-row';
        }
    }
}