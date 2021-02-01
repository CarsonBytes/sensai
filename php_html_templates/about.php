<?php
// No direct access
defined('_JEXEC') or die;
?>
<style>
    .images_div {
        display: flex;
        justify-content: space-between;
    }

    .images_div img {
        width: 30%;
        height: auto;
    }

    strong {
        color: #f90;
    }

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

    .amz_logo {
        margin-bottom: 10px;
    }

    p {
        text-align: justify;
    }
</style>

<p>Sensaihonya is a small group of coworkers, endeavoured to
    play a role in providing quality but affordable publications
    for decorative and educational purposes.</p>
<p>We make every effort to ensure that we ONLY supply
    products that are QUALITY yet available at VERY attainable
    prices so that everyone could afford to <strong>buy without a second
        thought</strong>.</p>

<p><strong>Our printed products will be
        produced in leading countries by
        premium printers.</strong></p>

<div class="images_div">
    <img src="<?php echo JUri::base() . 'images/page/about/printed-inJap.jpg' ?>" />
    <img src="<?php echo JUri::base() . 'images/page/about/printed-in-de.jpg' ?>" />
    <img src="<?php echo JUri::base() . 'images/page/about/printed-in-uk.jpg' ?>" />
</div>

<h3>What do we offer?</h3>
<div class="blocks">
    <div class="block">
        <a href="<?php echo JUri::base() . 'categories'; ?>">
            <h4>Sensai Decor Posters</h4>
        </a>
        <img src="<?php echo JUri::base() . 'images/bundle/gallery/A02_bundle_thumb_277.jpg' ?>" />
        <p>Our designers have put together harmoniously coordinated
            images into a bundle set that you could arrange freely to
            cozy up your space.
            The inspiring picture set fits perfectly in a living room or
            bedroom, as a whole or in combinations as you wish.
            Sensai posters are also ideal as gift items to your adored.</p>
        <div class="clearfix"></div>
    </div>
    <div class="block">
        <a href="<?php echo JUri::base() . 'audio-posters'; ?>">
            <h4>Sensai Audio Posters</h4>
        </a>
        <img src="<?php echo JUri::base() . 'images/bundle/gallery/A08_bundle_thumb_277.jpg' ?>" />
        <p>As the name suggest, Audio Posters are posters that you can
            listen to, with a mobile - a device nearly everyone has.
            Our Audio Posters contain collection of image objects well
            organized in groups, bursting with full-colour images.
            The subjects include dog breeds, cat breeds, birds, butterflies,
            ABC chart, dinosaurs, and many other subjects that you will
            easily find something interesting.</p>
        <div class="clearfix"></div>
    </div>
    <div class="block">
        <a href="<?php echo JUri::base() . 'promotions'; ?>">
            <h4>Sensai Audio ePosters</h4>
        </a>
        <img src="<?php echo JUri::base() . 'images/page/about/pdf.jpg' ?>" />
        <p>We also publish audio ePosters available for FREE downloads.</p>
        <div class="clearfix"></div>
        <h5>Print it yourself - Quality A3 format</h5>
        <img style="max-width: 100px;" src="<?php echo JUri::base() . 'images/page/about/printing.jpg' ?>" />
        <p>Embedded with quality jpegs, Sensai Audio ePosters are good enough for
            printing A3 format. With a quality home use A3 or A4
            printer, you could obtain crispy clear images.</p>
        <p>Yes. You can choose to print on your own printer and not to buy from us. You are welcome to do this.</p>
        <div class="clearfix"></div>
    </div>
</div>
<h3>How can customers get our products?</h3>
<p>ePosters are available as <a href="<?php echo JUri::base() . 'promotions'; ?>">FREE downloads</a>.</p>

<p>Merchandise publications are available on Amazon: <br />
<div class="images_div">
    <img class="amz_logo" src="<?php echo JUri::base() . 'images/page/about/amazon-co-jp-logo.jpg' ?>" />
    <img class="amz_logo" src="<?php echo JUri::base() . 'images/page/about/amazon-de.jpg' ?>" />
    <img class="amz_logo" src="<?php echo JUri::base() . 'images/page/about/amazon-co-uk.jpg' ?>" />
</div>
</p>

<p>We don’t handle sales by ourselves.
    Most, if not all, of our products will be available
    as <a href="<?php echo JUri::base() . 'categories'; ?>">bundles</a>. Individual titles will not be on our
    merchandise list.</p>