<?php
/** @var yii\web\View $this */
$this->registerCssFile('@web/css/categorie.css');
$this->registerJsFile('https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js', ['type' => "module"]);
$this->registerJsFile('https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js', ['nomodule' => true]);
?>
<div class="categorie">
    <div class="categorieTitleDiv">
        <h1 class="categorieTitle">
            <a href="javascript:history.go(-1)" class="categorieBackButton">
                <img class="ellipseButton" src="/images/Ellipse2.png" alt="">
                <img class="backButton" src="/images/backButton.png" alt="">
            </a>
            <?=$blogs['page_title']?>
            <div class="sizeLikeField">
                <div class="large-font">
                    <ion-icon name="heart" role="img" class="md hydrated">
                        <div class="red-bg"></div>
                    </ion-icon>
                </div>
            </div>
<!--            <div class='large-font'>-->
<!--                <ion-icon name="heart">-->
<!--                    <div class='red-bg'></div>-->
<!--                </ion-icon>-->
<!--            </div>-->
        </h1>

        <span class="date">
            <img src="/images/date.png">
            <span class="dateNumber"> <?=$blogs['create_date']?></span>
        </span>
    </div>
    <div class="sectionCategorie">
        <div class="sectionCategorieLeft">
            <img class="categorieImage" src="/<?=$blogs['img']?>">
            <div class="categorieText"><?=$blogs['page_content']?></div>
        </div>
        <div class="sectionCategorieRight">
            <div class="categorieTitleDivRight">
                <h1><?= $GLOBALS['text']['recentNews'] ?></h1>
            </div>
            <?php if (!empty($last_blogs)){foreach ($last_blogs as $last_blog){ ?>
                <a href="categorie?id=<?=$last_blog['id']?>">
                    <div class="rigthtxt">
                        <img src="/<?=$last_blog['img']?>">
                        <div class="rigthtxtdiv">
                            <span><?=$last_blog['page_name']?></span>
                        </div>
                    </div>
                </a>
            <?php }}?>
        </div>
    </div>
</div>
<!--Like js-->
<script>
document.querySelectorAll('.categorie ion-icon').forEach(icon => {
        icon.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    });
</script>