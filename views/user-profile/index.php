<?php
/** @var yii\web\View $this */
$this->registerCssFile('@web/css/user-profile.css');
?>
<div class="usersProfile">
    <div class="userProfileSection">
        <div class="userProfileMenuField">
            <span>My Profile</span>
            <ul class="userProfileMenu">
                <li><a href="/user-profile/achievements">My achievements</a></li>
                <li><a href="/courses/my-courses">My courses</a></li>
                <li><a href="/wishlist/index">Wishlist</a></li>
                <li><a href="/my-card/index">My card</a></li>
            </ul>
        </div>
        <div class="userProfileMoreAboutField">
            <div class="fieldMoreAbout">
                <span>Let us know more about you</span>
                <a href="/user-profile/user-create"><img src="/images/userAdd.png" alt=""></a>
            </div>
        </div>
    </div>
</div>
