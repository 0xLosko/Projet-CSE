document.addEventListener("DOMContentLoaded", function() {
    let toggleBtn = document.querySelector('.brg');
    let x = document.querySelector('.nav-link-con');
    let imgCon = document.querySelector('.nav-img-con');
    function toggle() {
        x.style.display = (x.style.display === "flex") ? "none" : "flex";
        if (imgCon.style.display === "none") {
            imgCon.style.display = "flex";
        } else {
            imgCon.style.display = "none";
        }
    }

    toggleBtn.addEventListener("click", toggle);
});

