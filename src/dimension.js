/* jshint esversion:6 */

var jira;
var commentaire;
var date;
var time;
var update_date;
var update_time;
var action;

function updateSize() {
    jira = document.getElementsByClassName('header-list')[0].children[0];
    commentaire = document.getElementsByClassName('header-list')[0].children[1];
    date = document.getElementsByClassName('header-list')[0].children[2];
    time = document.getElementsByClassName('header-list')[0].children[3];
    update_date = document.getElementsByClassName('header-list')[0].children[4];
    update_time = document.getElementsByClassName('header-list')[0].children[5];
    action = document.getElementsByClassName('header-list')[0].children[6];

    _jira = document.getElementsByClassName('footer-list')[0].children[0];
    _commentaire = document.getElementsByClassName('footer-list')[0].children[1];
    _date = document.getElementsByClassName('footer-list')[0].children[2];
    _time = document.getElementsByClassName('footer-list')[0].children[3];
    _update_date = document.getElementsByClassName('footer-list')[0].children[4];
    _update_time = document.getElementsByClassName('footer-list')[0].children[5];
    _action = document.getElementsByClassName('footer-list')[0].children[6];

    let composantJira = document.getElementsByClassName("jira")[1];
    jira.style.width = "" + composantJira.clientWidth + "px";
    _jira.style.width = "" + composantJira.clientWidth + "px";
    let composantCom = document.getElementsByClassName('comment')[1];
    commentaire.style.width = "" + composantCom.clientWidth + "px";
    _commentaire.style.width = "" + composantCom.clientWidth + "px";
    let composantDate = document.getElementsByClassName('date')[1];
    date.style.width = "" + composantDate.clientWidth + "px";
    _date.style.width = "" + composantDate.clientWidth + "px";
    let composantTime = document.getElementsByClassName('time')[1];
    time.style.width = "" + composantTime.clientWidth + "px";
    _time.style.width = "" + composantTime.clientWidth + "px";
    let composantUD = document.getElementsByClassName('date_t')[1];
    update_date.style.width = "" + composantUD.clientWidth + "px";
    _update_date.style.width = "" + composantUD.clientWidth + "px";
    let composantUT = document.getElementsByClassName('time_t')[1];
    update_time.style.width = "" + composantUT.clientWidth + "px";
    _update_time.style.width = "" + composantUT.clientWidth + "px";
    let composantAction = document.getElementsByClassName('id')[1];
    action.style.width = "" + composantAction.clientWidth + "px";
    _action.style.width = "" + composantAction.clientWidth + "px";

    let bodyUsed = document.getElementsByClassName("tasks-list")[0].getClientRects()[0].bottom;
    console.log("" + bodyUsed + "px");
    document.getElementsByClassName('footer-list')[0].style.top = "" + bodyUsed + "px";
}

window.onload = updateSize;