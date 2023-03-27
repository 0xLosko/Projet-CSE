document.addEventListener("DOMContentLoaded", function() {
    let actions = document.querySelector(".actions").children;
    console.log(actions);
    for (let index = 3; index < actions.length; index++) {
        const element = actions[index];
        element.style.display = "none";
    }
    // btn view more
});