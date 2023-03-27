document.addEventListener("DOMContentLoaded", function() {
    let btnShow = document.querySelector(".show-act");
    let btnHide = document.querySelector(".hide-act");
    let actions = document.querySelector(".actions").children;

    for (let index = 3; index < actions.length; index++) {
        const element = actions[index];
        element.style.display = "none";
    }
    btnHide.style.display = "none";

    function show() {        
        for (let index = 3; index < actions.length; index++) {
            const element = actions[index];
            element.style.display = "flex";
        }
        btnHide.style.display = "flex";
        btnShow.style.display = "none";
    }

    function hide() {        
        for (let index = 3; index < actions.length; index++) {
            const element = actions[index];
            element.style.display = "none";
        }
        btnHide.style.display = "none";
        btnShow.style.display = "flex";
    }

    btnShow.addEventListener("click", show);
    btnHide.addEventListener("click", hide);
});