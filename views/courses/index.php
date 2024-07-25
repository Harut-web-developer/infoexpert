<!-- Mariam ev Harut-->
<?php

use app\models\AcWishlist;
use yii\web\View;
use yii\web\YiiAsset;

/** @var yii\web\View $this */

$this->registerCssFile('@web/css/courses.css?as=45');
$this->registerJsFile('@web/js/courses.js', ['position' => \yii\web\View::POS_END,'depends' => [YiiAsset::class],]);
$this->registerJsFile('https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js', ['type' => "module"]);
$this->registerJsFile('https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js', ['nomodule' => true]);

?>
<div class="courses">
    <div class="headerCourses">
        <a href="javascript:history.go(-1)" class="coursesMobBackButton">
            <img class="backButton" src="/images/backButton.png" alt="">
            <img class="ellipseButton" src="/images/Ellipse2.png" alt="">
        </a>
        <div>
            <span class="txt1"><?=$GLOBALS['text']['mainCourseTitleFirst']?></span>
            <span class="txt2"><?=$GLOBALS['text']['mainCourseTitleSecond']?></span>
            <span class="txt1"><?=$GLOBALS['text']['mainCourseTitleThird']?></span>
            <span class="txt2"><?=$GLOBALS['text']['mainCourseTitleFour']?></span>
        </div>
    </div>
    <div class="cardCourses_">
        <div class="wrapper">
            <ul class="carouselCourses">
                <?php if(!empty($courses)){foreach ($courses as $course){?>
                    <li class="cardCourses">
                        <div class="img">
                            <img src="/<?=$course['img']?>" alt="" draggable="false">
                        </div>
                        <div class="cardCoursesBody">
                            <div class="cardBody">
                                <span class="span1"><?=$course['lesson_name']?></span>
                                <div class="starAndTxt">
                                    <div class="starDivCourses">
                                        <?php
                                            $count = $course['rating'];
                                            $img = '';
                                            for ($i = 1; $i <= 5; $i++){
                                                if ($i <= $count){
                                                    $img .= '<img src="/images/cardStar.png" alt="" draggable="false">';
                                                }else{
                                                    $img .= '<img src="/images/cardStarWhite.png" alt="" draggable="false">';
                                                }
                                            }
                                            echo $img;
                                        ?>
                                    </div>
                                    <h1 class="span2"><?=$course['price']?> <span class="amd">AMD</span></h1>
                                </div>
                            </div>
                            <div class="cardCenter">
                                <div class="cardtxt1">
                                    <img src="/images/courses1.png" alt="" draggable="false">
                                    <span><?=$course['lesson_title']?></span>
                                </div>
                                <div class="cardtxt2">
                                    <img src="/images/courses2.png" alt="" draggable="false">
                                    <span><?=$course['lesson_certificate']?></span>
                                </div>
                            </div>
                            <div class="footerCard">
                                <div class="coursisBtnField">
                                    <a href="/my-card/checkout?lesson_id=<?=$course['id']?>" class="buyCourses" data-buy="<?=$course['id']?>">
                                        <img class="footerImg1" src="/images/wishlist1.png" alt="" draggable="false">
                                        <span><?=$GLOBALS['text']['mycoursesBtn']?></span>
                                    </a>
                                </div>
                                <div class="booterImgs">
                                    <div class='large-font'>
                                        <ion-icon name="heart" data-id="<?=$course['id']?>" data-active="<?=AcWishlist::getWishlist($course['id'],1) ? AcWishlist::getWishlist($course['id'],1) : 0?>" data-type="1">
                                            <div class='red-bg'></div>
                                        </ion-icon>
                                    </div>
                                    <img data-id="<?=$course['id']?>" class="footerImg3 addMyCard" src="/images/courses5.png" alt="" draggable="false">
                                </div>
                            </div>
                        </div>
                    </li>
                <?php }}?>
            </ul>
        </div>
    </div>
    <div class="cardCoursesMobile">
        <?php if(!empty($courses)){foreach ($courses as $course){?>
            <div class="cardCourses">
                <img class="img" src="/<?=$course['img']?>" alt="" draggable="false">
                <div class="cardCoursesBody">
                    <div class="cardBottomMainField">
                        <div class="cardBody">
                            <span class="span1"><?=$course['lesson_name']?></span>
                            <div class="starAndTxt">
                                <div class="starDivCourses">
                                    <?php
                                        $count = $course['rating'];
                                        $img = '';
                                        for ($i = 1; $i <= 5; $i++){
                                            if ($i <= $count){
                                                $img .= '<img src="/images/cardStar.png" alt="" draggable="false">';
                                            }else{
                                                $img .= '<img src="/images/cardStarWhite.png" alt="" draggable="false">';
                                            }
                                        }
                                        echo $img;
                                    ?>
                                </div>
                                <div class="span2"><?=$course['price']?> <span class="amd">AMD</span></div>
                            </div>
                        </div>
                        <div class="cardCenter">
                            <div class="cardtxt1">
                                <img src="/images/courses1.png" alt="" draggable="false">
                                <span><?=$course['lesson_title']?></span>
                            </div>
                            <div class="cardtxt2">
                                <img src="/images/courses2.png" alt="" draggable="false">
                                <span><?=$course['lesson_certificate']?></span>
                            </div>
                        </div>
                        <div class="footerCard">
                            <a href="/my-card/checkout?lesson_id=<?=$course['id']?>">
                                <img class="footerImg1" src="/images/wishlist1.png" alt="" draggable="false">
                                <span><?=$GLOBALS['text']['mycoursesBtn']?></span>
                            </a>
                            <div class="booterImgs">
                                <div class='large-font'>
                                    <ion-icon name="heart" data-id="<?=$course['id']?>" data-active="<?=AcWishlist::getWishlist($course['id'],1) ? AcWishlist::getWishlist($course['id'],1) : 0?>" data-type="1">
                                        <div class='red-bg'></div>
                                    </ion-icon>
                                </div>
                                <img data-id="<?=$course['id']?>" class="footerImg3 addMyCard" src="/images/courses5.png" alt="" draggable="false">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }}?>
    </div>
    <div class="mobilebtn">
        <button id="coursesBtnMobile">
            <img src="/images/coursesBtn.png" alt="">
        </button>
    </div>
    <h1 class="title0"><?=$GLOBALS['text']['mainCourseTutors']?></h1>
    <div class="cardCourses2">
        <div class="wrapper2">
            <ul class="carousel2">
                <?php if (!empty($tutors)){foreach ($tutors as $tutor){?>
                    <li class="card2">
                        <div class="img2">
                            <?php if (!empty($tutor['img'])){?>
                                <img src="/<?=$tutor['img']?>" alt="" draggable="false">
                            <?php }else{ ?>
                                <img src="/images/avatar.png" alt="" draggable="false">
                            <?php } ?>
                        </div>
                        <div class="cardBody2">
                            <h1 class="span1slider2"><?=$tutor['username']?></h1>
                            <span class="span2slider2"><?=$tutor['text']?></span>
                        </div>
                    </li>
                <?php }} ?>
            </ul>
        </div>
    </div>
</div>
