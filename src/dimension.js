/* jshint esversion:6 */

function updateSize() {
    let header = document.getElementsByClassName('header-list')[0].children;
    let footer = document.getElementsByClassName('footer-list')[0].children;
    let components = ["jira", "comment", "date", "time", "date_t", "time_t", "id"];
    for (let i = 0; i < header.length; i++) {
        let size_component = "" + document.getElementsByClassName(components[i])[1].clientWidth + "px";
        header[i].style.width = size_component;
        footer[i].style.width = size_component;
    }

    let bodyUsed = document.getElementsByClassName("tasks-list")[0].getClientRects()[0].bottom;
    document.getElementsByClassName('footer-list')[0].style.top = "" + bodyUsed + "px";
}

window.onload = updateSize;