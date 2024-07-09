document.addEventListener("DOMContentLoaded", function () {
    function slider(carousel, wrapper, firstCard) {
        const firstCardWidth = firstCard.offsetWidth;
        let isDragging = false,
            startX,
            startScrollLeft,
            timeoutId;

        const dragStart = (e) => {
            isDragging = true;
            carousel.classList.add("dragging");
            startX = e.touches ? e.touches[0].pageX : e.pageX;
            startScrollLeft = carousel.scrollLeft;
        };

        const dragging = (e) => {
            if (!isDragging) return;
            const newScrollLeft = startScrollLeft - ((e.touches ? e.touches[0].pageX : e.pageX) - startX);
            if (newScrollLeft <= 0 || newScrollLeft >= carousel.scrollWidth - carousel.offsetWidth) {
                isDragging = false;
                return;
            }
            carousel.scrollLeft = newScrollLeft;
        };

        const dragStop = () => {
            isDragging = false;
            carousel.classList.remove("dragging");
        };

        const autoPlay = () => {
            if (window.innerWidth < 800) return;
            const totalCardWidth = carousel.scrollWidth;
            const maxScrollLeft = totalCardWidth - carousel.offsetWidth;
            if (carousel.scrollLeft >= maxScrollLeft) return;
        };

        carousel.addEventListener("touchstart", dragStart);
        carousel.addEventListener("mousedown", dragStart);
        carousel.addEventListener("touchmove", dragging);
        carousel.addEventListener("mousemove", dragging);
        document.addEventListener("touchend", dragStop);
        document.addEventListener("mouseup", dragStop);
        wrapper.addEventListener("mouseenter", () =>
            clearTimeout(timeoutId));
        wrapper.addEventListener("mouseleave", autoPlay);
    }

    if (window.location.pathname == '/courses/my-courses') {
        const carousel3 = document.querySelector(".myCoursesFieldAcceptCourses");
        const wrapper3 = document.querySelector(".wrapperMyCourses");
        const firstCard3 = carousel3.querySelector(".myCoursesBlocksField");
        slider(carousel3, wrapper3, firstCard3);
    } else {
        const wrapper = document.querySelector(".wrapper"); // div
        const carousel = document.querySelector(".carouselCourses"); /* ul*/
        const firstCard = carousel.querySelector(".cardCourses"); // li
        slider(carousel, wrapper, firstCard);

        const carousel2 = document.querySelector(".carousel2");
        const wrapper2 = document.querySelector(".wrapper2");
        const firstCard2 = carousel2.querySelector(".card2");
        slider(carousel2, wrapper2, firstCard2);
    }
});
$(document).ready(function() {
    $('.coursisBtnField button').on("click", function () {
        window.location.href = '/my-card/checkout';
    })
    $('.footerCard button').on("click", function () {
        window.location.href = '/my-card/checkout';
    })
})
let seeMoreBtnCourses = document.querySelector('#coursesBtnMobile');
let courses = [...document.querySelectorAll('.cardCoursesMobile .cardCourses')];
let currentItemCourses = 2;
if (currentItemCourses >= courses.length) {
    seeMoreBtnCourses.style.display = 'none';
}
seeMoreBtnCourses.onclick = () => {
    let itemsToShow = 2;
    for (let i = currentItemCourses; i < currentItemCourses + itemsToShow; i++) {
        if (i < courses.length) {
            courses[i].style.display = 'block';
        }
    }
    currentItemCourses += itemsToShow;
    if (currentItemCourses >= courses.length) {
        seeMoreBtnCourses.style.display = 'none';
    }
}