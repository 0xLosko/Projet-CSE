document.addEventListener("DOMContentLoaded", function() {
    let toggleBtn = document.querySelector('.brg');
    let x = document.querySelector('.nav-link-con');
    let navCon = document.querySelector('.nav-con');
    let imgCon = document.querySelector('.nav-img-con');
    function toggle() {
        if(x.style.display === "flex"){
            x.style.display = "none";
        } else {
            x.style.display = "flex";
            navCon.style.paddingLeft = '2%';
        }
        if (imgCon.style.display === "none") {
            imgCon.style.display = "flex";
        } else {
            imgCon.style.display = "none";
        }
    }

    toggleBtn.addEventListener("click", toggle);
});

