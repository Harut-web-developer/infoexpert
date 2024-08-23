<!-- Mariam 40 ev Harut 60-->
<?php
/** @var yii\web\View $this */
$this->registerCssFile('@web/css/courses.css?v=1');
?>
<?php
$language = $_COOKIE['language'];
$class1 = '';
if ($language == 'en') {
    $class1 = 'myCoursesEn';
} elseif ($language == 'am') {
    $class1 = 'myCoursesAm';
} elseif ($language == 'ru') {
    $class1 = 'myCoursesRu';
}
?>
<div class="myCourses <?php echo $class1; ?>">
    <div class="myCoursesSection">
        <div class="myCoursesTitleField">
            <a href="javascript:history.go(-1)" class="managmentBack">
                <img src="/images/backButtonCheckout.png" alt="" class="backButtonCheckout">
            </a>
            <div><?=$GLOBALS['text']['tabletMyCourse']?></div>
        </div>
        <div class="userProfileMenuField">
            <span><?=$GLOBALS['text']['mycoursesTitle']?></span>
            <ul class="userProfileMenu coursesFieldPage">
                <li><a href="/my-card/payments"><?=$GLOBALS['text']['paymentPage']?></a></li>
                <li><a href="/user-profile/achievements"><?=$GLOBALS['text']['tabletachievement']?></a></li>
                <li><a href="/courses/my-courses"><?=$GLOBALS['text']['tabletMyCourse']?></a></li>
                <li><a href="/wishlist/index"><?=$GLOBALS['text']['tabletWishlist']?></a></li>
            </ul>
        </div>
        <div class="mainCoursesFields">
            <div class="myCoursesProfileField">
                <div class="myCoursesFieldSection">
                    <div class="myCoursesFieldSectionLeft">
                        <div class="imgFieldCourses">
                            <?php if(!empty(Yii::$app->user->identity->image)){?>
                                <img src="/<?=Yii::$app->user->identity->image?>" alt="">
                            <?php }else{?>
                                <img src="/images/avatar.png" alt="">
                            <?php } ?>
                        </div>
                        <div class="usersProfileInfo">
                            <span class="nameAndUsername"><?php if(!empty(Yii::$app->user->identity->username)){echo Yii::$app->user->identity->username;}?></span>
                            <?php if (Yii::$app->user->identity->phone) { ?>
                                <div class="usersProfileInfoPhone">
                                    <img src="/images/phonAchievements.png" alt="">
                                    <span><?php if(!empty(Yii::$app->user->identity->phone)){echo Yii::$app->user->identity->phone;}?></span>
                                </div>
                            <?php } ?>
                            <?php if (Yii::$app->user->identity->email) { ?>
                                <div class="usersProfileInfoEmail">
                                    <img src="/images/mailAchievements.png" alt="">
                                    <span><?php if(!empty(Yii::$app->user->identity->email)){echo Yii::$app->user->identity->email;}?></span>
                                </div>
                            <?php } ?>
                            <?php if (Yii::$app->user->identity->linkdin_url) { ?>
                                <div class="usersProfileInfoLinkdin">
                                    <img src="/images/linkdinAchievements.png" alt="">
                                    <?php if(!empty(Yii::$app->user->identity->linkdin_url)){?>
                                        <a href="<?=Yii::$app->user->identity->linkdin_url?>" target="_blank"><?=Yii::$app->user->identity->username?></a>
                                    <?php }?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="myCoursesFieldSectionRight">
                        <a href="/user-profile/achievements-edit"><img src="/images/editIconMyCourses.png" alt=""></a>
                    </div>
                </div>
            </div>
            <?php if (!empty($my_lessons)){?>
                <div class="cardMyCourses">
                    <div class="wrapperMyCourses">
                        <ul class="carouselMyCourses myCoursesFieldAcceptCourses">
                            <?php foreach ($my_lessons as $my_lesson){?>
                                <li class="myCoursesBlocksField">
                                    <div class="myCoursesBlocksFieldMain">
                                        <div class="imgField">
                                            <img class="myCoursesPhoto" src="/<?=$my_lesson['img']?>" alt="" draggable="false">
                                        </div>
                                        <div class="myCoursesBlocksFieldMainInfo">
                                            <div class="infoTitle"><?=$my_lesson['lesson_name']?></div>
                                            <div class="myCoursesRating">
                                                <?php if ($my_lesson['rating'] != null || $my_lesson['rating'] != 0){?>
                                                    <div class="ratingStarMyourse">
                                                        <?php
                                                        $count = $my_lesson['rating'];
                                                        $img = '';
                                                        for ($i = 1; $i <= $count; $i++){
                                                            $img .= '<img src="/images/ratingStar.png" alt="" draggable="false">';
                                                        }
                                                        echo $img;
                                                        ?>
                                                    </div>
                                                    <span><?=$GLOBALS['text']['rating']?></span>
                                                <?php } ?>
                                            </div>
                                            <div class="progress" style="height: 3px;">
                                                <div class="progress-bar" role="progressbar" style="width: <?=$my_lesson['complete_percent']?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="myCourseercentText"><?=$my_lesson['complete_percent']?> % <?=$GLOBALS['text']['complete']?></span>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            <?php }else{?>
                <div class="textForEmpty">
                    <span><?=$GLOBALS['text']['emptyCourses']?></span>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="myCoursesSectionMobile">
        <div class="myCoursesTitleField">
            <img src="/images/backButtonCheckout.png" alt="" class="backButtonCheckout">
            <div><?=$GLOBALS['text']['tabletMyCourse']?></div>
        </div>
        <?php if (!empty($my_lessons)){?>
        <div class="myCoursesMobile">
            <?php foreach ($my_lessons as $my_lesson){?>
                <div class="myCoursesBlocksField">
                    <div class="imgField">
                        <img class="myCoursesPhoto" src="/<?=$my_lesson['img']?>" alt="" draggable="false">
                    </div>
                    <div class="myCoursesBlocksFieldMain">
                        <span><?=$my_lesson['lesson_name']?></span>

                        <div class="myCoursesRating">
                            <?php if ($my_lesson['rating'] != null || $my_lesson['rating'] != 0){?>
                                <div class="ratingStarMyourse">
                                    <?php
                                    $count = $my_lesson['rating'];
                                    $img = '';
                                    for ($i = 1; $i <= $count; $i++){
                                        $img .= '<img src="/images/ratingStar.png" alt="" draggable="false">';
                                    }
                                    echo $img;
                                    ?>
                                </div>
                                <span><?=$GLOBALS['text']['rating']?></span>
                            <?php } ?>
                        </div>
                        <div class="blogInfoPercent">
                            <div class="progress" style="height: 3px;">
                                <div class="progress-bar" role="progressbar" style="width: <?=$my_lesson['complete_percent']?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="myCourseercentText"><?=$my_lesson['complete_percent']?> % <?=$GLOBALS['text']['complete']?></span>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
        <?php }else{?>
        <div class="textForEmpty">
            <span><?=$GLOBALS['text']['emptyCourses']?></span>
        </div>
        <?php } ?>
<!--        <div class="containerSeeMoreMyCourses">-->
<!--            <button id="btnMyCourse">-->
<!--                <img class="seeMoreBlog" src="/images/seeMoreBlog.png" alt="">-->
<!--                <span class="seeMoreText">--><?php //= $GLOBALS['text']['sectionSixBtnMobile'] ?><!--</span>-->
<!--            </button>-->
<!--        </div>-->
    </div>
</div>
<script>
//    Mariam 100
    document.addEventListener("DOMContentLoaded", function () {
        function slider(carousel, wrapper, firstCard) {
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
        const wrapper = document.querySelector(".wrapperMyCourses");
        const carousel = document.querySelector(".carouselMyCourses");
        if (carousel != null){
            const firstCard = carousel.querySelector(".myCoursesBlocksField");
            slider(carousel, wrapper, firstCard);
        }
    });
</script>