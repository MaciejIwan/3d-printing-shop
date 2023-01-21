import "../css/index.scss"

window.addEventListener('DOMContentLoaded', function () {
    // console.log("Hello World!")
    // let button = document.querySelector('#home');
    //
    // button.addEventListener('click', function (event) {
    //     console.log("Czy działa?")
    // })

    document.getElementById("home-btn").addEventListener("click", () => toggleDisplay("home", "contact"));
    document.getElementById("contact-btn").addEventListener("click", () => toggleDisplay("contact", "home"));


});

function toggleDisplay(showId, hideId) {
    document.getElementById(showId).style.display = "flex";
    document.getElementById(hideId).style.display = "none";
}
