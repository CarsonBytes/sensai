<?php
// No direct access
defined('_JEXEC') or die;
?>
<style>
    /* @import url('https://fonts.googleapis.com/css2?family=Handlee&display=swap'); */

    /* .images_div {
        display: flex;
        flex-wrap: wrap;
        margin: -15px;
        justify-content: space-between;
    }

    .images_div .img_div {
        text-align: center;
        margin: 15px;
    }

    .images_div .img_div img {
        width: calc(1000px / 6 - 25px);
        height: auto;
    } */

    /* strong {
        color: #f90;
    } */

    /* .blocks {
        display: flex;
        justify-content: space-around;
    }

    .block {
        text-align: center;
        max-width: 20%;
    } */

    .block img {
        /* text-align: center; */
        margin-bottom: 20px;
        margin-right: 10px;
        /* max-width: 100%;
        height: auto; */
        float: left;
    }

    /* .amz_logo {
        height: 50px;
        width: auto;
        margin-bottom: 10px;
    } */

    /* ul {
        padding-left: 20px;
    } */

    /* .dot_list {
        text-align: center;
        margin-bottom: 5px;
    }

    .dot {
        text-align: center;
        height: 35px;
        width: 35px;
        border-radius: 50%;
        display: inline-block;
        line-height: 35px;
        border: 1px solid black;
        font-size: 18px;
        margin-right: 5px
    }

    .dot.red {
        background-color: red;
        color: white;
    } */

    /* p {
        font-family: 'Handlee', cursive;
        text-align: justify;
    } */

    h3 {
        font-family: 'Handlee', cursive;
        font-weight: bold;
        font-size: 25px;
    }

    p{
        font-weight: bold;
        font-size: 17px;
        margin: 10px 0;
    }

    /* strong {
        color: red;
        font-size: 15px;
    } */

    /*  .with_pic {
        padding-bottom: 0;
        margin-bottom: 0;
        display: block;

    } */

    html.static .t3-wrapper .t3-mainbody .t3-content .item-page .articlebody {
        padding-top: 0;
    }
</style>
<h3>Audio Resources</h3>
<img style="width:100%;height: auto;" src="<?php echo JUri::base() . 'images/page/features/01-free-and-audio-b2.svg' ?>" alt="Audio Posters convenient QR" />

<h3>Learn on Any Device</h3>
<img style="width:100%;height: auto;" src="<?php echo JUri::base() . 'images/page/features/02-any-device-txt-b2-01.svg' ?>" alt="Learn on Any Device anywhere anytime" />

<p>Or, </p>
<img style="width:100%;height: auto;" src="<?php echo JUri::base() . 'images/page/features/03-scan-qr-code-txt-b2-01.svg' ?>" alt="Learn in front of the poster" />

<p>Or, </p>
<img style="width:100%;height: auto;" src="<?php echo JUri::base() . 'images/page/features/02-b-web-page-b2.svg' ?>" alt="visit our webpages and learn" />

<h3>Well Organised</h3>
<img style="width:100%;height: auto;" src="<?php echo JUri::base() . 'images/page/features/04-well-organized-b21b-01-01-01.svg' ?>" alt="Well Organised, Easy Navigation" />
<h3>Easy Navigation</h3>
<img style="width:100%;height: auto;" src="<?php echo JUri::base() . 'images/page/features/04-well-organized-b22-01-01-01.svg' ?>" alt="Easy Navigation" />

<h3>Adding New Titles Continually</h3>
<img style="width:100%;height: auto;" src="<?php echo JUri::base() . 'images/page/features/05-continual-b2.svg' ?>" alt="Adding New Titles Continually" />
<h3>Developing More Language Versions</h3>
<img style="width:100%;height: auto;" src="<?php echo JUri::base() . 'images/page/features/05-continual-b22.svg' ?>" alt="Developing More Language Versions" />
<h3>Continual Updating Web Resource</h3>
<img style="width:100%;height: auto;" src="<?php echo JUri::base() . 'images/page/features/05-continual-b23.svg' ?>" alt="Continual Updating Web Resource" />
<h3>Our target</h3>
<img style="width:100%;height: auto;" src="<?php echo JUri::base() . 'images/page/features/05-continual-b24.svg' ?>" alt="our target customer" />

<?php /*
<img style="float: right;margin-left: 40px;" src="<?php echo JUri::base() . 'images/page/features/free.jpg' ?>" />
<h3>Audio Resources</h3>
<p>Our Audio Posters are excellent products that allow kids and
    adults to listen to native speakers pronounce poster
    contents, creating an instant and convenient learning
    environment that can be reached at fingers reach.</p>
<div class="clearfix" style="margin-bottom: 20px;"></div>
<img style="float: right;margin-left: 40px;" src="<?php echo JUri::base() . 'images/page/features/audio.jpg' ?>" />
<p>Simply scan the QR code at the top right corner of each page
    with mobile scanning app or our Sensai Audio Poster App.</p>
<div class="clearfix" style="margin-bottom: 50px;"></div>

<img style="float:right;margin-left: 40px;" src="<?php echo JUri::base() . 'images/page/features/any-device.jpg' ?>" />
<h3>Learn on Any Device</h3>
<p>Sensai audio Posters are available on computers, tablets and
    even your smartphone. All you need is a browser or an app to
    access the responsive contents.</p>
<div class="clearfix"></div>
<img style="float:right;margin-left: 40px;" src="<?php echo JUri::base() . 'images/page/features/any-time.jpg' ?>" />
<div class="clearfix"></div>
<h4 class="with_pic" style="background: #FEFDE9;"><strong>Or</strong>,<br /> Learn in front of the poster,</h4>
<img style="width: 100%;height: auto;" src="<?php echo JUri::base() . 'images/page/features/03-scan-qr-code-txt.jpg' ?>" />

<div class="clearfix"></div>
<h4><strong>Or</strong>,<br /> Visit our webpages and learn</h4>
<img style="width: 100%;height: auto;" src="<?php echo JUri::base() . 'images/page/features/webpage.PNG' ?>" />

<div class="clearfix"></div>
<h3 class="with_pic" style="background: #E5FFFE;">Well Organised, Easy Navigation</h3>
<img style="width: 100%;height: auto;" src="<?php echo JUri::base() . 'images/page/features/04-well-organized.jpg' ?>" />

<?php /*
<h3>Continual Resource Updates</h3>
<h4>Available Titles</h4>
<div class="images_div">
    <div class="img_div">
        <img src="<?php echo JUri::base() . 'images/bundle/A0A_10630_Ed_cat_277.jpg' ?>" />
        <div class="caption">Cat Breeds</div>
    </div>
    <div class="img_div">
        <img src="<?php echo JUri::base() . 'images/bundle/A0B_10620_Ed_dog_277.jpg' ?>" />
        <div class="caption">Dog Breeds</div>
    </div>
    <div class="img_div">
        <img src="<?php echo JUri::base() . 'images/page/features/A08_edu_07_body-01.jpg' ?>" />
        <div class="caption">Human Body</div>
    </div>
    <div class="img_div">
        <img src="<?php echo JUri::base() . 'images/page/features/A08_edu_06_wild_animal-01.jpg' ?>" />
        <div class="caption">Animals</div>
    </div>
    <div class="img_div">
        <img src="<?php echo JUri::base() . 'images/page/features/A08_edu_05_farm.jpg' ?>" />
        <div class="caption">Farm Animals</div>
    </div>
    <div class="img_div">
        <img src="<?php echo JUri::base() . 'images/page/features/A08_edu_04_veggie.jpg' ?>" />
        <div class="caption">Vegetables</div>
    </div>
    <div class="img_div">
        <img src="<?php echo JUri::base() . 'images/page/features/A08_edu_03_dino.jpg' ?>" />
        <div class="caption">Dinosaurs</div>
    </div>
    <div class="img_div">
        <img src="<?php echo JUri::base() . 'images/page/features/A08_edu_01_abc.jpg' ?>" />
        <div class="caption">ABC</div>
    </div>
    <div class="img_div">
        <img src="<?php echo JUri::base() . 'images/page/features/A08_edu_02b_123_b.jpg' ?>" />
        <div class="caption">1 - 10</div>
    </div>
</div>
<h4>Adding New Titles Continually</h4>
<p>From time to time, we will be publishing more audio titles. Please make sure to come
    back to our website to check if there are any titles that you are interested.</p>
<div class="images_div">
    <div class="img_div">
        <img src="<?php echo JUri::base() . 'images/page/features/shutterstock_600658802.jpg' ?>" />
    </div>
    <div class="img_div">
        <img src="<?php echo JUri::base() . 'images/page/features/423_Lyophyllum_Fumosum.jpeg' ?>" />
    </div>
    <div class="img_div">
        <img src="<?php echo JUri::base() . 'images/page/features/shutterstock_79437976.jpg' ?>" />
    </div>
    <div class="img_div">
        <img src="<?php echo JUri::base() . 'images/page/features/shutterstock_7015861.jpg' ?>" />
    </div>
    <div class="img_div">
        <img src="<?php echo JUri::base() . 'images/page/features/204_Narcissus_flycatcher_shutterstock_1427364527.jpg' ?>" />
    </div>
    <div class="img_div">
        <img src="<?php echo JUri::base() . 'images/page/features/shutterstock_483455455.jpg' ?>" />
    </div>
</div>
<h4>Developing More Language Versions</h4>
<div class="dot_list">
    <span class="dot red">en</span>
    <span class="dot">de</span>
    <span class="dot red">jp</span>
    <span class="dot">fr</span>
    <span class="dot red">•••</span>
</div>
<p>More language versions will be added indenitely to our data set so as to build a
    convenient and easy way of multilingual exposure for our users.</p>
<h4>Continual Updating Web Resource</h4>
<p>Of course, we will be watching if there will be better web resources that we should be
    linking.</p>
<h4>Our target</h4>
<p>The resource pages should stay attractive to
<ul>
    <li>Families that carry young children</li>
    <li>Anyone that are eager to learn multilingual vocabularies</li>
    <li>Users that visit us regularly for updates</li>
</ul>
</p>*/