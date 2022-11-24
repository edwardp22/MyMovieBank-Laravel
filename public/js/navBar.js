/*
   Filename: navBar.js

   Purpose: Logic that modify class name of navigator to change it mode
*/

function changeNav() {
    var nav = document.getElementById("navigator");

    if (nav.classList.contains("navBarResponsive"))
        nav.classList.remove("navBarResponsive");
    else nav.classList.add("navBarResponsive");
}