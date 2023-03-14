document.addEventListener("DOMContentLoaded", function() {
    const btns = document.querySelectorAll(".btn-car");
    let currentIndex = 0;
    let intervalId = null;
    const intervalDuration = 4000; // durée entre chaque changement de div en ms

    function startInterval() {
        intervalId = setInterval(() => {
            const nextIndex = (currentIndex + 1) % btns.length;
            changeDisplayedDiv(nextIndex);
        }, intervalDuration);
    }

    function stopInterval() {
        clearInterval(intervalId);
    }

    function changeDisplayedDiv(index) {
        const items = document.querySelectorAll("#wrap");
        items.forEach(function(item) {
            item.style.display = "none";
        });
        const divToShow = document.querySelector(`.car-items-con-${btns[index].value}`);
        divToShow.style.display = "flex";
        currentIndex = index;
        btns.forEach(function(btn) {
            btn.classList.remove("selected");
        });
        btns[index].classList.add("selected");
    }

    btns.forEach(function(btn) {
        btn.addEventListener("click", function() {
            changeDisplayedDiv(Array.from(btns).indexOf(btn));
            btns.forEach(function(btn) {
                btn.classList.remove("selected");
            });
            btn.classList.add("selected");
            stopInterval();
            startInterval();
        });
    });

    startInterval();
});