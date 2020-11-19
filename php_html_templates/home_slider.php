<?php
// No direct access
defined('_JEXEC') or die;
?>
<style>
    #home_promo .carousel_btns_wrapper {
        position: absolute;
        bottom: 20px;
        left: 60px;
    }

    #home_promo .carousel_btns {
        display: flex;
        align-items: center;
    }

    #home_promo .carousel_btns>a {
        margin-right: 15px;
    }

    #home_promo .carousel_btns>a .read_more {
        position: relative;
        bottom: auto;
        z-index: 10;
    }

    #home_promo .carousel_btns .carousel-indicators {
        display: block;
        width: auto;
        bottom: auto;
        height: auto;
        position: relative;
        line-height: 1;
    }

    #home_promo .carousel_btns .carousel-indicators li {
        bottom: 30px;
        height: 20px;
        width: 20px;
        border: 2px solid #fff;
    }
</style>
<div id="home_promo" class="carousel slide carousel-fade" data-ride="carousel">
    <div class="carousel_btns_wrapper">
        <div class="carousel_btns">
            <a href="#">
                <div class="read_more">Read More</div>
            </a>
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#home_promo" data-slide-to="0" class="active"></li>
                <li data-target="#home_promo" data-slide-to="1"></li>
                <li data-target="#home_promo" data-slide-to="2"></li>
                <li data-target="#home_promo" data-slide-to="3"></li>
                <li data-target="#home_promo" data-slide-to="4"></li>
            </ol><!-- Wrapper for slides -->
        </div>
    </div>
    <div class="carousel-inner">
        <?php for ($i = 1; $i < 6; $i++) { ?>
            <div class="item <?php if ($i == 1) { ?>active<?php } ?>">
                <img class="lazyload <?php if ($i == 1) { ?>carousel_1<?php } ?>" data-src="<?php echo JURI::root() ?>images/page/home/gallery/08-gallery_<?php echo $i?>_2000.jpg" alt="" />
                <?php /* <a href="#">
                    <div class="read_more">Read More</div>
                </a>*/ ?>
            </div>
        <?php } ?>
    </div>
    <?php /* Left and right controls  <a href="#home_promo" class="left carousel-control" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> <span class="sr-only">Previous</span> </a> <a href="#home_promo" class="right carousel-control" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span> <span class="sr-only">Next</span> </a> */ ?>
</div>