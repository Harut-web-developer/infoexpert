$(".menuAboutDropDown").hover(function(){
    $('.dropDownAbout').show();
},function(){
    $('.dropDownAbout').hide();
});
$(".menuCoursesDropDown").hover(function(){
    $('.dropDownCources').show();
},function(){
    $('.dropDownCources').hide();
});

$(function() {
    if (window.location.pathname == '/'){
        $('a[href*=\\#]').on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top}, 500, 'linear');
        });
    }
});
$(".questionField").click(function() {
    var panel = $(this).next(".answerQuestion");
    $(".answerQuestion").not(panel).css("display", "none");
    $(".questions").find('img').css({'transform': 'rotate(0deg)'});
    panel.toggle();
    $(this).find('img').css({'transform': 'rotate(180deg)'});
});
(async ()=>   // async IIFE code for slider.
{
    const
        interval       = 1500  // ms
        , paddingRight   = 51
        , slideContainer = document.querySelector('.carousel')
        , slidesWrapper  = document.querySelector('.carousel-slides')
        , slides         = document.querySelectorAll('.carousel-slides > li')
        , delay          = ms => new Promise(r => setTimeout(r, ms))
        , movLeft = (el, mov) => new Promise(r =>
        {
            el.ontransitionend =_=>
            {
                el.ontransitionend = null
                el.style.transition = 'none';
                r()
            }
            el.style.transition = '1s';
            el.style.transform  = `translateX(${-mov}px)`;
        });

    let index = 0;
    if (slidesWrapper != null) {
        while (true) // infinite carrousel loop
        {
            await delay(interval)
            await movLeft(slidesWrapper, slides[index].clientWidth + paddingRight)

            slidesWrapper.appendChild(slides[index])  // mov first slide to the end
            slidesWrapper.style.transform = `translateX(0)` // rest translateX
            index = ++index % slides.length
        }
    }
})()
var swiper = new Swiper(".slide-content", {
    slidesPerView: 3,
    spaceBetween: 25,
    loop: true,
    centerSlide: 'true',
    fade: 'true',
    grabCursor: 'true',
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },

    breakpoints:{
        0: {
            slidesPerView: 1,
        },
        520: {
            slidesPerView: 2,
        },
        950: {
            slidesPerView: 3,
        },
    },
});
$(document).ready(function () {
    $('body').on('click', '.mainFlag', function () {
        $(this).closest('.flagFields').find('.otherFlags').toggle();
    })
    $('body').on('click', '.armFlag', function () {
        $(this).closest('.flagFields').children('img').attr('src', '/images/armflag.png');
        $(this).closest('.flagFields').find('.otherFlags').css('display', 'none');
    })
    $('body').on('click', '.ruFlag', function () {
        $(this).closest('.flagFields').children('img').attr('src', '/images/ruflag.png');
        $(this).closest('.flagFields').find('.otherFlags').css('display', 'none');
    })
    $('body').on('click', '.usaFlag', function () {
        $(this).closest('.flagFields').children('img').attr('src', '/images/usaflag.png');
        $(this).closest('.flagFields').find('.otherFlags').css('display', 'none');
    })
})