<?php
/** @var yii\web\View $this */
$this->registerCssFile('@web/css/contactus.css');

?>
<div class="contactus d-flex justify-content-center">
    <div class="disinline">
        <img class="backButton" src="/images/backButton.png" alt="">
        <div class="sectionContactusTop d-flex flex-row">
            <div class="sectionContactusTopLeft">
                <div class="contactusDiv">
                    <h1 class="contactusTitle">Need A Direct Line?</h1>
                    <p class="contactusTxt">Cras massa et odio donec faucibus in. Vitae pretium massa dolor ullamcorper lectus elit quam. </p>
                </div>
                <div class="d-flex flex-row div1">
                    <img class="imgcontact" src="/images/contactus_phon.png">
                    <div class="rigthtxtdiv">
                        <span>Phone</span>
                        <p class="contactusNom">+ 374 12 533 361 </p>
                    </div>
                </div>
                <div class="d-flex flex-row">
                    <img class="imgcontact" src="/images/contactus_email.png">
                    <div class="rigthtxtdiv">
                        <span>Email</span>
                        <p class="contactusMail"> info@infoexpert.am</p>
                    </div>
                </div>
            </div>
            <div class="sectionContactusTopRight">
                <div id="map"></div>
            </div>
        </div>
        <form action="" class="sectionContactusBottom">
            <h1 class="contactusBottomTitle">Contact Us</h1>
            <p class="contactusBottomTxt">Your email address will not be published. Required fields are marked *</p>
            <div class="form-row inputdiv">
                <div class="inputname">
                    <input type="text" id="validationDefault00_" placeholder="Name*" required>
                </div>
                <div class="inputemail">
                    <input type="email" id="validationDefault02_" placeholder="Email*" required>
                </div>
            </div>
            <div class="form-row inputcomment">
                <input type="text" id="validationDefault01_" placeholder="Comment">
            </div>
            <div class="d-flex justify-content-center bottoming">
                <button>
                    <img class="sectionContactusBottomImg" src="/images/contactus.png">
                    <span>POST COMMENT</span>
                </button>
            </div>
        </form>
    </div>
</div>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=e243c296-f6a7-46b7-950a-bd42eb4b2684" type="text/javascript"></script>
<script>
    var myMap;
    ymaps.ready(init);

    function init () {
        myMap = new ymaps.Map('map', {
            center: [40.1991, 44.5048], // iNFOEXPERT
            zoom: 10
        }, {
            searchControlProvider: 'yandex#search'
        });
    }
</script>